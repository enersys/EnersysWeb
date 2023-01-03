<?php
/**
 * Adds the language column in posts and terms list tables
 *
 * @since 1.2.1
 */


namespace Falang\Filter\Admin;

use Falang\Core\Taxonomy;
use Falang\Filter\Filters;
use Falang\Core\Falang_Core;

class Filters_Columns extends Filters {

	/**
	 * Constructor.
	 */
	public function __construct(&$falang) {

		parent::__construct($falang);

		// Adds the language column in the 'Categories' and 'Post Tags' tables.
		$falang_taxonomy = new \Falang\Core\Taxonomy();
		$taxonomy_objs      = get_taxonomies( array( 'show_ui' => true ), 'objects' );
		foreach ( $taxonomy_objs as $taxonomy_obj ) {
			if ($falang_taxonomy->is_taxonomy_translatable( $taxonomy_obj->name )){
				add_filter( 'manage_edit-' . $taxonomy_obj->name . '_columns', array( $this, 'add_term_column' ) );
				add_filter( 'manage_' . $taxonomy_obj->name . '_custom_column', array( $this, 'term_column' ), 10, 3 );
			}
		}
	}

	/**
	 * Adds the language column ( before the posts column ) in the 'Categories' or 'Post Tags' table
	 *
	 * @since 1.2.4
	 *
	 * @param array $columns list of terms table columns
	 * @return array modified list of columns
	 */
	public function add_term_column( $columns ) {
		return $this->add_column( $columns, 'posts' );
	}

	/**
	 * Fills the language column in the 'Categories' or 'Post Tags' table
	 *
	 * @since 1.2.4
	 *
	 * @param string $out
	 * @param string $column  Column name
	 * @param int    $term_id
	 */
	public function term_column( $out, $column, $term_id ) {
		$inline = wp_doing_ajax() && isset( $_REQUEST['action'], $_POST['inline_lang_choice'] ) && 'inline-save-tax' === $_REQUEST['action']; // phpcs:ignore WordPress.Security.NonceVerification
		if ( false === strpos( $column, 'language_' ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return $out;
		}

		//from polylang
		if ( isset( $_REQUEST['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$post_type = sanitize_key( $_REQUEST['post_type'] ); // phpcs:ignore WordPress.Security.NonceVerification
		}

		if ( isset( $GLOBALS['post_type'] ) ) {
			$post_type = $GLOBALS['post_type'];
		}

		if ( isset( $_REQUEST['taxonomy'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$taxonomy = sanitize_key( $_REQUEST['taxonomy'] ); // phpcs:ignore WordPress.Security.NonceVerification
		}

		if ( isset( $GLOBALS['taxonomy'] ) ) {
			$taxonomy = $GLOBALS['taxonomy'];
		}

		if ( ! post_type_exists( $post_type ) || ! taxonomy_exists( $taxonomy ) ) {
			return $out;
		}


		//get locale from column name ex : language_de_DE => de_DE
		$locale = str_replace('language_','',$column);
		$term_status = get_term_meta($term_id ,Falang_Core::get_prefix($locale).'published',true);
		$status = '<span class="dashicons dashicons-marker" style="font-size: 13px;line-height: 1.5em;color:grey"></span>';
		if (!empty($term_status)){
			if ($term_status){
				$status = '<span class="dashicons dashicons-yes-alt" style="font-size: 13px;line-height: 1.5em;color:green"></span>';
			} else {
				$status = '<span class="dashicons dashicons-dismiss" style="font-size: 13px;line-height: 1.5em;color:red"></span>';
			}
		}

		$term_original = get_term($term_id);
		$header_title = '<i style="color: grey">'.$term_original->name.'</i>';
		$title_locale = get_term_meta($term_id,Falang_Core::get_prefix($locale).'name' , true);
		if (!empty($title_locale)){
			$header_title = $title_locale;
		}

		$out = $status.' '.$header_title;

		return $out;

	}
}