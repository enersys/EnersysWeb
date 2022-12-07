<?php
/**
 * Templates
 *
 * @package Gutenify
 */

/**
 * Gutenify_Templates
 */
class Gutenify_Templates {
	/**
	 * Gutenify_Templates constructor.
	 */
	public function __construct() {
		// Register custom post type.
		add_action( 'init', array( $this, 'add_custom_post_type' ) );
		// add_filter('views_edit-gutenify_kit', array( $this, 'add_kit_import_area' ), 1);
		// add_action('admin_notices', array( $this, 'add_kit_import_area' ), 10);
	}

	/**
	 * Register custom post type.
	 */
	public function add_custom_post_type() {
		$post_type_prefix = 'gutenify';
		register_post_type(
			$post_type_prefix . '_template',
			array(
				'labels'              => array(
					'name'               => _x( 'Templates', 'Post Type General Name' ),
					'singular_name'      => _x( 'Template', 'Post Type Singular Name' ),
					'menu_name'          => __( 'Templates' ),
					'parent_item_colon'  => __( 'Parent Template' ),
					'all_items'          => __( 'Templates' ),
					'view_item'          => __( 'View Template' ),
					'add_new_item'       => __( 'Add New Template' ),
					'add_new'            => __( 'Add New' ),
					'edit_item'          => __( 'Edit Template' ),
					'update_item'        => __( 'Update Template' ),
					'search_items'       => __( 'Search Template' ),
					'not_found'          => __( 'Not Found' ),
					'not_found_in_trash' => __( 'Not found in Trash' ),
				),
				'public'              => false, // true?
				'publicly_queryable'  => false, // true?
				'has_archive'         => false,
				'show_ui'             => true,
				'exclude_from_search' => true,
				'show_in_nav_menus'   => false,
				'rewrite'             => false,
                // phpcs:ignore
                'menu_icon'           => 'dashicons-welcome-view-site',
				'menu_position'       => 91,
				'hierarchical'        => false,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => true,
				'show_in_rest'        => true,
				'taxonomies'          => array(
					$post_type_prefix . '_template_category',
				),
				'capability_type'     => 'post',
				'supports'            => array(
					'title',
					'editor',
					'thumbnail',
					'custom-fields',
				),
			)
		);

		register_taxonomy(
			$post_type_prefix . '_template_category',
			$post_type_prefix . '_template',
			array(
				'label'              => esc_html__( 'Categories' ),
				'labels'             => array(
					'menu_name' => esc_html__( 'Categories' ),
				),
				'rewrite'            => false,
				'hierarchical'       => true,
				'publicly_queryable' => false,
				'show_in_nav_menus'  => false,
				'show_in_rest'       => true,
				'show_admin_column'  => true,
			)
		);


		$gutenify_kit_post_type_args = apply_filters( 'gutenify_kit_post_type_args', array(
			'labels'              => array(
				'name'               => _x( 'Templates Kit', 'Post Type General Name' ),
				'singular_name'      => _x( 'Template  Kit', 'Post Type Singular Name' ),
				'menu_name'          => __( 'Gutenify' ),
				'parent_item_colon'  => __( 'Parent Template Kit' ),
				'all_items'          => __( 'Template Kits' ),
				'view_item'          => __( 'View Template  Kit' ),
				'add_new_item'       => __( 'Add New Template  Kit' ),
				'add_new'            => __( 'Add New' ),
				'edit_item'          => __( 'Edit Template  Kit' ),
				'update_item'        => __( 'Update Template  Kit' ),
				'search_items'       => __( 'Search Template  Kit' ),
				'not_found'          => __( 'Not Found' ),
				'not_found_in_trash' => __( 'Not found in Trash' ),
			),
			'public'              => false, // true?
			'publicly_queryable'  => false, // true?
			'has_archive'         => false,
			'show_ui'             => true,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => false,
			'rewrite'             => false,
			// 'menu_position'       => 57,
			'hierarchical'        => false,
			'show_in_menu'        => false,
			'show_in_admin_bar'   => false,
			'show_in_rest'        => true,
			'capability_type'     => 'post',
			// 'capabilities' => array(
			// 'create_posts' => false,
			// ),
			'supports'            => array(
				'title',
				'editor',
				'thumbnail',
			   // 'custom-fields',
			),
		) );
		register_post_type( $post_type_prefix . '_kit', $gutenify_kit_post_type_args );
	}

	public function add_kit_import_area() {
		// if ($post->post_type != 'event') return false;
		echo '<div id="gutenify-kit-upload-wrap"></div>';
	}
}

new Gutenify_Templates();
