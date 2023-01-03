<?php
/**
 * The file that defines the Menus
 *
 * @link       www.faboba.com
 * @since      1.0.0
 *
 * @package    Falang
 */

namespace Falang\Table;

use Falang\Core\Falang_Core;
use Falang\Model\Falang_Model;

class Menu extends \WP_List_Table {

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
				'plural' => 'Posts', // Do not translate ( used for css class )
				'ajax'   => false,
			)
		);
		$this->model = new \Falang\Model\Falang_Model();
		$this->language_list = $this->model->get_languages_list(array( 'hide_default' => true));

	}

	/**
	 * Displays the item information in the column 'name'
	 *
	 * @since 1.0
	 *
	 * @param object $item
	 * @return string
	 */
	public function column_name( $item ) {
		$title = $this->display_nav_menu_item_title($item->name,$item->ID);
		return esc_html($title);
	}

	public function column_type($item){
		$_menu_item_type = get_post_meta($item->ID,'_menu_item_object',true);
		return sprintf(esc_html($_menu_item_type));
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
			default:
				//language column fr_FR, en_US, ...
				if (in_array($column_name,$language_list_locale)){
					return $this->display_translation_menu_action($item,$column_name);
				} else {
					return print_r( $item, true ); //Show the whole array for troubleshooting purposes
				}
		}
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
		return esc_html($item->ID);
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
			'name'         => __( 'Title', 'falang' ),
			'type'  => _x( 'Type', 'falang' ),
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
	 * @since 2.1
	 *
	 * @return string Name of the default primary column, in this case, 'name'.
	 */
	protected function get_default_primary_column_name() {
		return 'name';
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
		$s = empty( $_REQUEST['s'] ) ? '' : wp_unslash( $_REQUEST['s'] );
		foreach ( $data as $key => $row ) {
			if ( !empty($s)){
				$title = $this->display_nav_menu_item_title($row->name,$row->ID);
				if (  stripos( $title, $s ) === false  ) {
					unset( $data[ $key ] );
				}
			}
		}

		$per_page = $this->get_items_per_page('falang_post_per_page');
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

	private function display_translation_menu_action($item,$locale){
		//only display action if post locale is set to all (or missing)
		//TODO make a method on Translation Post
		$post_locale = get_post_meta($item->ID,'_locale' , true);
        $page = falang_clean($_REQUEST['page']);
        if ( isset( $_REQUEST['paged'] ))           $page .= '&paged='.falang_clean($_REQUEST['paged']);
        if ( isset( $_REQUEST['s'] ))               $page .= '&s=' . urlencode( falang_clean($_REQUEST['s']) );


		$language_list_locale = $this->model->get_available_locales(array('exclude' => 'all'));

		if (in_array($post_locale ,$language_list_locale)){
			return false;
		}

		//get status
		$post_status = get_post_meta($item->ID,Falang_Core::get_prefix($locale).'published' , true);
		$status = '<span class="dashicons dashicons-marker" style="font-size: 13px;line-height: 1.5em;color:grey"></span>';
		if (!empty($post_status)){
			if ($post_status){
				$status = '<span class="dashicons dashicons-yes-alt" style="font-size: 13px;line-height: 1.5em;color:green"></span>';
			} else {
				$status = '<span class="dashicons dashicons-dismiss" style="font-size: 13px;line-height: 1.5em;color:red"></span>';
			}
		}

		//get translation title
		$header_title = '<i style="color: grey">'.$this->display_nav_menu_item_title($item->post_title,$item->ID).'</i>';
		$title_locale = get_post_meta($item->ID,Falang_Core::get_prefix($locale).'post_title' , true);
		if (!empty($title_locale)){
			$header_title = $title_locale;
		}


		$actions = array(
			'edit'   => sprintf(
				'<a title="%s" href="%s">%s</a>',
				esc_attr__( 'Edit', 'falang' ),
				esc_url( admin_url( 'admin.php?page='.$page.'&amp;action=edit&amp;post_id=' . $item->ID . '&amp;language=' . $locale ) ),
				esc_html__( 'Edit', 'falang' )
			),
			'delete' => sprintf(
				'<a class="ajax-delete-action" title="%s" href="%s">%s</a>',
				esc_attr__( 'Delete Menu data for this translation', 'falang' ),
				wp_nonce_url( 'admin-ajax.php?action=falang_menu_delete_translation&amp;post_id=' . $item->ID . '&amp;language=' . $locale, 'delete-menu-translation' ),
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
		$actions = apply_filters( 'falang_translate_menu_actions', $actions, $item );

		$row_header = $status.' '.$header_title;

		return sprintf("%s %s",$row_header,$this->row_actions( $actions,false ));
	}

	/**
	 * Translate nav menu items title
	 *
	 * @filter 'the_title'
	 * @from 1.0
	 */
	public function display_nav_menu_item_title($title, $post_id) {
		$post = get_post( $post_id );

		if ( isset( $post->post_type ) && $post->post_type === 'nav_menu_item' ) {
			//$title = apply_filters( 'falang_translate_post_field', $post->post_title, $post, 'post_title');
			$_menu_item_type = get_post_meta( $post_id, '_menu_item_type', true );
			if ( $_menu_item_type === 'post_type' ) {
				if ( ! $title ) {

					$_menu_item_object_id = get_post_meta( $post_id, '_menu_item_object_id', true );

					$object_post = get_post( $_menu_item_object_id );

					$title = apply_filters( 'falang_translate_post_field', $object_post->post_title, $object_post, 'post_title' );
				}

				} else if ( $_menu_item_type === 'taxonomy' ) {

					if ( ! $title ) {

						$_menu_item_object_id = get_post_meta( $post_id, '_menu_item_object_id', true );
						$_menu_item_object    = get_post_meta( $post_id, '_menu_item_object', true );

						$object_term = get_term_by( 'id', $_menu_item_object_id, $_menu_item_object );

						$title = $object_term->name;

					}


				} else if ( $_menu_item_type === 'custom' ) {

					$title = $post->post_title;

//					if ($title === 'language' && isset($this->menu_languages[$post->ID])) {
//
//						$title = $this->menu_languages[$post->ID]->post_title;
//
//					}

				}



		}
		return $title;
	}

}