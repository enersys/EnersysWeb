<?php
/**
 * The file that defines the Options
 *
 * @link       www.faboba.com
 * @since      1.0
 *
 * @package    Falang
 */

namespace Falang\Table;


use Falang\Core\Falang_Mo;
use Falang\Model\Falang_Model;
use Falang\Core\FString;

class FOptions extends \WP_List_Table {
	protected $language_list;
	protected $model;
	protected $translations;

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct(Falang_Model $model) {
		parent::__construct(
			array(
				'plural' => 'Posts', // Do not translate ( used for css class )
				'ajax'   => false,
			)
		);
		$this->model = $model;
		$this->language_list = $this->model->get_languages_list(array( 'hide_default' => true));
		$this->translations = $this->model->get_option('translations', array());

	}

	/**
	 * Gets the list of columns
	 *
	 * @since 0.6
	 *
	 * @return array the list of column titles
	 */
	public function get_columns() {
		$columns = array(
			'name'         => __( 'Name', 'falang' ),
		);

		//add language column
		//language list is only non default language
		foreach ($this->language_list as $language){
			$columns[$language->locale] =  $language->get_flag();

		}

		return $columns;

	}

	/**
	 * Gets the list of sortable columns
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'name'    => array( 'name', false ),
		);
	}

	/**
	 * Gets the name of the default primary column.
	 *
	 * @since 1.0
	 *
	 * @return string Name of the default primary column, in this case, 'name'.
	 */
	protected function get_default_primary_column_name() {
		return 'name';
	}


	/**
	 * Sort items
	 *
	 * @since 1.0
	 *
	 * @param object $a The first object to compare
	 * @param object $b The second object to compare
	 * @return int -1 or 1 if $a is considered to be respectively less than or greater than $b.
	 */
	protected function usort_reorder( $a, $b ) {
		if ( ! empty( $_GET['orderby'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$orderby = sanitize_key( $_GET['orderby'] ); // phpcs:ignore WordPress.Security.NonceVerification
			if ( isset( $a[ $orderby ], $b[ $orderby ] ) ) {
				$result = strcmp( $a[ $orderby ], $b[ $orderby ] ); // Determine sort order
				return ( empty( $_GET['order'] ) || 'asc' === $_GET['order'] ) ? $result : -$result; // phpcs:ignore WordPress.Security.NonceVerification
			}
		}

		return 0;

	}

	/**
	 * Displays the item information in a column ( default case )
	 *
	 * @since 1.0
	 *
	 * @param array  $item
	 * @param string $column_name
	 * @return string
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'name' :
				return esc_html($item->$column_name);
				break;
			default:
				return $this->display_translation_option_action( $item, $column_name );
		}

	}

	/**
	 * Prepares the list of items for displaying
	 *
	 * @since 1.0
	 */
	public function prepare_items( $data = array()) {
        //TOOD normaly it's done before admin/class-falang-admin.php line 483
		// Filter for search string
		$s = empty( $_REQUEST['s'] ) ? '' : wp_unslash( $_REQUEST['s'] );
		foreach ( $data as $key => $row ) {
//			if ( ( -1 !== $this->selected_group && $row['context'] !== $this->selected_group ) || ( ! empty( $s ) && stripos( $row['name'], $s ) === false && stripos( $row['string'], $s ) === false ) ) {
			if (  ! empty( $s ) && stripos( $row->name, $s ) === false  ) {
				unset( $data[ $key ] );
			}
		}

		$per_page              = $this->get_items_per_page( 'falang_options_per_page' );
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

		if ( ! empty( $_GET['orderby'] ) ) { // No sort by default
			usort( $data, array( $this, 'usort_reorder' ) );
		}

		$total_items = count( $data );
		$this->items = array_slice( $data, ( $this->get_pagenum() - 1 ) * $per_page, $per_page );

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
				'total_pages' => ceil( $total_items / $per_page ),
			)
		);

	}

	/**
	 * Get the current action selected from the bulk actions dropdown.
	 * overrides parent function to avoid submit button to trigger bulk actions
	 *
	 * @since 1.0
	 *
	 * @return string|false The action name or False if no action was selected
	 */
	public function current_action() {
		return empty( $_POST['submit'] ) ? parent::current_action() : false;
	}

	private function display_translation_option_action($item,$locale) {
		$language_list_locale = $this->model->get_available_locales(array('exclude' => 'all'));

		if (is_serialized($item->value) && !is_serialized_string($item->value)) {

			$out = '<span class="serialized-data">'.esc_html__( 'Multiple values', 'falang' ).'</span>';

		} else {
			$out = esc_html($item->value);
			//get translation value if exit
			if (isset($this->translations['option'][$locale][$item->name]) && $this->translations['option'][$locale][$item->name]) {

				$out = esc_html($this->translations['option'][$locale][$item->name]);

			}

		}

		$actions = array(
			'edit'   => sprintf(
				'<a class="thickbox" title="%s" href="%s">%s</a>',
				__( 'Options translation', 'falang' ),
				esc_url( admin_url('admin-ajax.php?action=falang_option_translation&width=800&height=295&amp;name=' . $item->name . '&amp;language=' . $locale ) ),
				__( 'Edit', 'falang' )
			),
			'delete' => sprintf(
				'<a class="ajax-delete-action"  title="%s" href="%s">%s</a>',
				esc_attr__( 'Delete Post data for this translation', 'falang' ),
				wp_nonce_url( 'admin-ajax.php?action=falang_option_delete_translation&amp;name=' . $item->name . '&amp;language=' . $locale, 'delete-term-translation' ),
				__( 'Delete', 'falang' )
			),
		);

		/**
		 * Filter the list of row actions in the languages list table
		 *
		 * @since 1.0
		 *
		 * @param array  $actions list of html markup actions
		 * @param object $item
		 */
		$actions = apply_filters( 'falang_translate_options_actions', $actions, $item );

		return sprintf("%s %s",$out,$this->row_actions( $actions,false ));


	}
}