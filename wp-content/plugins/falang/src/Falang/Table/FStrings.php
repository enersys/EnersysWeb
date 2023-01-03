<?php
/**
 * The file that defines the Strings
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

class FStrings extends \WP_List_Table {
	protected $language_list;
	protected $model;
	protected $strings;
	protected $groups;
	protected $selected_group;

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct(Falang_Model $model) {
		parent::__construct(
			array(
				'plural' => 'Strings translations', // Do not translate ( used for css class )
				'ajax'   => false,
			)
		);
		$this->model = $model;
		$this->language_list = $this->model->get_languages_list(array( 'hide_default' => true));
		$this->strings = FString::get_strings();
		$this->groups = array_unique( wp_list_pluck( $this->strings, 'context' ) );

		$this->selected_group = -1;

		if ( ! empty( $_REQUEST['group'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$group = sanitize_text_field( wp_unslash( $_REQUEST['group'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
			if ( in_array( $group, $this->groups ) ) {
				$this->selected_group = $group;
			}
		}



	}

	/**
	 * Gets the list of columns
	 *
	 * @since 1.0
	 *
	 * @return array the list of column titles
	 */
	public function get_columns() {
		$columns = array(
			'string'       => __( 'String', 'falang' ),
			'name'         => __( 'Name', 'falang' ),
			'context'      => __( 'Group', 'falang' ),
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
			'string'  => array( 'string', false ),
			'name'    => array( 'name', false ),
			'context' => array( 'context', false ),
		);
	}

	/**
	 * Gets the name of the default primary column.
	 *
	 * @since 1.0
	 *
	 * @return string Name of the default primary column, in this case, 'string'.
	 */
	protected function get_default_primary_column_name() {
		return 'string';
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
			case 'string' :
			case 'name' :
			case 'context':
				return esc_html($item[ $column_name ]);
				break;
			default:
				return $this->display_translation_string_action( $item, $column_name );
		}

	}

	/**
	 * Displays the string to translate
	 *
	 * @since 1.0
     * @since 1.3.28 manage string with encoded caractere
	 *
	 * @param array $item
	 * @return string
	 */
	public function column_string( $item ) {
        return format_to_edit( wp_specialchars_decode($item['string']) ); // Don't interpret special chars for the string column
	}

	/**
	 * Prepares the list of items for displaying
	 *
	 * @since 0.6
     * @since 1.3.28 add wp_specialchars_decode for translate search
	 */
	public function prepare_items() {
		$data = $this->strings;

		// Filter by selected group
		if ( -1 !== $this->selected_group ) {
			$data = wp_list_filter( $data, array( 'context' => $this->selected_group ) );
		}

		// Filter for search string
		$s = empty( $_REQUEST['s'] ) ? '' : wp_unslash( $_REQUEST['s'] );
		if ( ! empty( $s ) ) {

			// Search in translations
			//TODO not yet implemented.
			//$in_translations = $this->search_in_translations( $mo, $s );

			foreach ( $data as $key => $row ) {
				if ( ( - 1 !== $this->selected_group && $row['context'] !== $this->selected_group ) || ( ! empty( $s ) && stripos( $row['name'], $s ) === false && stripos( $row['string'], $s ) === false ) ) {
					unset( $data[ $key ] );
				}
			}
		}

        // Load translations after the search filter for optimisation
        foreach ( $this->language_list as $language ) {

            $mo = new Falang_Mo();
            $mo->import_from_db( $language);
            foreach ( $data as $key => $row ) {
                //need wp_specialchars_decode the orginal key can be encoded , why ?
                $data[ $key ]['translations'][ $language->locale ] = $mo->translate( wp_specialchars_decode($row['string']));
                $data[ $key ]['row'] = $key; // Store the row number for convenience
            }
        }

		$per_page = $this->get_items_per_page( 'falang_strings_per_page' );
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

	/**
	 * Displays the dropdown list to filter strings per group
	 *
	 * @since 1.0
	 *
	 * @param string $which only 'top' is supported
	 */
	public function extra_tablenav( $which ) {
		if ( 'top' !== $which ) {
			return;
		}

		echo '<div class="alignleft actions">';
		printf(
			'<label class="screen-reader-text" for="select-group" >%s</label>',
			/* translators: accessibility text */
			esc_html__( 'Filter by group', 'falang' )
		);
		echo '<select id="select-group" name="group">' . "\n";
		printf(
			'<option value="-1"%s>%s</option>' . "\n",
			-1 === $this->group_selected ? ' selected="selected"' : '',
			esc_html__( 'View all groups', 'falang' )
		);

		foreach ( $this->groups as $group ) {
			printf(
				'<option value="%s"%s>%s</option>' . "\n",
				esc_attr( sanitize_text_field( $group ) ),
				$this->selected_group === $group ? ' selected="selected"' : '',
				esc_html( $group )
			);
		}
		echo '</select>' . "\n";

		submit_button( __( 'Filter' ), 'button', 'filter_action', false, array( 'id' => 'post-query-submit' ) );
		echo '</div>';
	}

	private function display_translation_string_action($item,$locale) {
		$language_list_locale = $this->model->get_available_locales(array('exclude' => 'all'));

		//get translation title
		if (strcmp($item['translations'][$locale],$item['string']) !== 0){
			$out = format_to_edit($item['translations'][$locale]);
		} else {
			$out = '<i style="color: grey">'.format_to_edit($item['translations'][$locale]).'</i>';
		}


		$url_params ='admin-ajax.php';
		$url_params = add_query_arg('row',$item["row"],$url_params);
		$url_params = add_query_arg('language',$locale,$url_params);
		if ( isset($_REQUEST['s']) )	$return_url = add_query_arg( 's', 	sanitize_text_field($_REQUEST['s']), $url_params );
		if ( isset($_REQUEST['group']) )	$return_url = add_query_arg( 'group', 	sanitize_text_field($_REQUEST['group']), $url_params );


		$actions = array(
			'edit'   => sprintf(
				'<a class="thickbox" href="%s">%s</a>',
				//esc_attr__( 'Edit', 'falang' ),
				esc_url( wp_nonce_url(add_query_arg(array('action' => 'falang_string_translation','width' => 578), $url_params ) )),//format 16/9 use for aspectRatio (578+30)608x332
				esc_html__( 'Edit', 'falang' )
			),
			'delete' => sprintf(
				'<a class="ajax-delete-action"  title="%1$s" href="%2$s">%3$s</a>',
				/*$1%s*/ esc_attr__( 'Delete this translation', 'falang' ),
				/*$2%s*/ wp_nonce_url(add_query_arg('action','falang_string_delete_translation',$url_params)),
				//esc_js( __( 'You are about to permanently delete this translation. Are you sure?', 'falang' ) ),
				/*$3%s*/ esc_html__( 'Delete', 'falang' )
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
		$actions = apply_filters( 'falang_translate_string_actions', $actions, $item );

		return sprintf("%s %s",$out,$this->row_actions( $actions,false ));


	}
}