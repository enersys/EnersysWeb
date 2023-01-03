<?php
/**
 * The file that defines the Terms
 *
 * @link       www.faboba.com
 * @since      1.0.0
 *
 * @package    Falang
 */

namespace Falang\Table;

use Falang\Core\Falang_Core;
use Falang\Model\Falang_Model;

class Term extends \WP_List_Table {

	private $language_list;
	private $model;

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct(
			array(
				'plural' => 'Terms', // Do not translate ( used for css class )
				'ajax'   => false,
			)
		);
		$this->model = new \Falang\Model\Falang_Model();
		$this->language_list = $this->model->get_languages_list(array( 'hide_default' => true));

	}

	/**
	 * Displays the item information in a column ( default case )
	 *
	 * @since 1.0
	 *
	 * @param object $item
	 * @param string $column_name
	 * @return string
	 */
	public function column_default( $item, $column_name ) {
		$language_list_locale = $this->model->get_available_locales();
		switch ( $column_name ) {
			case 'original' :
			case 'context' :
				return esc_html( $item->$column_name );
			default:
				//language column fr_FR, en_US, ...
				if (in_array($column_name,$language_list_locale)){
					return $this->display_translation_term_action($item,$column_name);
				} else {
					return print_r( $item, true ); //Show the whole array for troubleshooting purposes
				}
		}
	}

	/**
	 * Displays the item information in the column 'term_name'
	 *
	 * @since 1.0
	 *
	 * @param object $item
	 * @return string
	 */
	public function column_term_name( $item ) {
		return esc_html($item->name);
	}

	/**
	 * Displays the id information in the column 'id'
	 *
	 * @since 1.0.6
	 *
	 * @param object $item
	 * @return string
	 */
	public function column_id( $item ) {
		return esc_html($item->id);
	}

	/**
	 * Gets the list of columns
	 *
	 * @since 0.1
	 *
	 * @return array the list of column titles
	 */
	public function get_columns() {

		//use term_name column name because it's make problem with name due to thickbox
		//and copy
		$columns = array(
			'original'         => __( 'Original', 'falang' ),
			'context'         => __( 'Context', 'falang' ),
		);

		//add language column
		//language list is only non default language
		foreach ($this->language_list as $language){
			$columns[$language->locale] =  $language->get_flag();

		}

		//add ID column to the end
		$columns['id'] =  __( 'ID', 'falang' );

		return $columns;
	}


	/**
	 * Gets the name of the default primary column.
	 *
	 * @since 1.0
	 *
	 * @return string Name of the default primary column, in this case, 'name'.
	 */
	protected function get_default_primary_column_name() {
		return 'original';
	}


	/**
	 * Prepares the list of items for displaying
	 *
	 * @since 0.1
	 *
	 * @param array $data
	 */
	public function prepare_items( $data = array()) {

		// Filter for search post
		$s = empty( $_POST['s'] ) ? '' : wp_unslash( $_POST['s'] );
		foreach ( $data as $key => $row ) {
//			if ( ( -1 !== $this->selected_group && $row['context'] !== $this->selected_group ) || ( ! empty( $s ) && stripos( $row['name'], $s ) === false && stripos( $row['string'], $s ) === false ) ) {
			if ( ( ! empty( $s ) && stripos( $row->original, $s ) === false && stripos( $row->original, $s ) === false ) ) {
				unset( $data[ $key ] );
			}
		}

		$per_page = $this->get_items_per_page('falang_term_per_page');
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

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

	// status filter links
	// http://wordpress.stackexchange.com/questions/56883/how-do-i-create-links-at-the-top-of-wp-list-table
	function get_views() {
		$views      = array();
		//TODO check remove query args
		$base_url   = esc_url_raw( remove_query_arg( array( 'term_type' ) ) );

		// handle search query
		if ( isset($_REQUEST['s']) && $_REQUEST['s'] ) {
			$base_url = add_query_arg( 's', $_REQUEST['s'], $base_url );
		}

		// handle term_type filter
		if ( isset($_REQUEST['tt-filter']) && $_REQUEST['tt-filter'] ) {
			$base_url = add_query_arg( 'taxo_type', $_REQUEST['tt-filter'], $base_url );
		}

		return $views;

	}

	/**
	 * Add extra markup in the toolbars before or after the list
	 * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
	 */
	//TODO not yet working
	function _____extra_tablenav( $which ) {
		if ( 'top' != $which ) return;
		$taxonomy_types = $this->model->get_transtable_taxonomy_types(true);
		?>
		<div class="alignleft actions bulkactions">
			<select name="tt-filter" class="taxonomy-type-filter">
				<option value="">Filter by Taxonomy/Term</option>
				<?php  foreach ($taxonomy_types as $tt) {
					$selected = '';
					if( $_REQUEST['tt-filter'] == $tt ){$selected = ' selected = "selected"';}
					?>
					<option value="<?php echo $tt; ?>" <?php echo $selected; ?>><?php echo $tt; ?></option>
					<?php
				}
				?>
			</select>
			<input type="submit" name="" id="tt_filter_btn" class="button" value="<?php echo __('Filter', 'falangw') ?>">
		</div>
		<?php
	}



	private function display_translation_term_action($item,$locale){
		//only display action if post locale is set to all (or missing)
		//TODO make a method on Translation Post
		$post_locale = get_term($item->id,'_locale' , true);
		$language_list_locale = $this->model->get_available_locales(array('exclude' => 'all'));

		if (in_array($post_locale ,$language_list_locale)){
			return false;
		}

		//get status
		$term_status = get_term_meta($item->id ,Falang_Core::get_prefix($locale).'published',true);
		$status = '<span class="dashicons dashicons-marker" style="font-size: 13px;line-height: 1.5em;color:grey"></span>';
		if (!empty($term_status)){
			if ($term_status){
				$status = '<span class="dashicons dashicons-yes-alt" style="font-size: 13px;line-height: 1.5em;color:green"></span>';
			} else {
				$status = '<span class="dashicons dashicons-dismiss" style="font-size: 13px;line-height: 1.5em;color:red"></span>';
			}
		}

		//get translation title
		$header_title = '<i style="color: grey">'.$item->original.'</i>';
		$title_locale = get_term_meta($item->id,Falang_Core::get_prefix($locale).'name' , true);
		if (!empty($title_locale)){
			$header_title = $title_locale;
		}

		$actions = array(
			'edit'   => sprintf(
				'<a class="thickbox" title="%s" href="%s">%s</a>',
				esc_html__( 'Translatable Term', 'falang' ),
				esc_url( admin_url('admin-ajax.php?action=falang_term_translation&width=800&height=auto&amp;context=' . $item->context . '&amp;taxonomy='.$item->taxonomy.'&amp;id=' . $item->id . '&amp;language=' . $locale ) ),
				esc_html__( 'Edit', 'falang' )
			),
			'delete' => sprintf(
				'<a class="ajax-delete-action"  title="%s" href="%s">%s</a>',
				esc_attr__( 'Delete Post data for this translation', 'falang' ),
				wp_nonce_url( 'admin-ajax.php?action=falang_term_delete_translation&amp;context=' . $item->context . '&amp;taxonomy='.$item->taxonomy. '&amp;term_id=' . $item->id . '&amp;language=' . $locale, 'delete-term-translation' ),
				//esc_js( __( 'You are about to permanently delete this translation. Are you sure?', 'falang' ) ),
				esc_html__( 'Delete', 'falang' )
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
		$actions = apply_filters( 'falang_translate_term_actions', $actions, $item );

		$row_header = $status.' '.$header_title;

		return sprintf("%s %s",$row_header,$this->row_actions( $actions,false ));


		//return $this->row_actions( $actions,true );
	}



}