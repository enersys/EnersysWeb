<?php

namespace Falang\Filter\Admin;

use Falang\Core\Language;
use Falang\Filter\Filters;
use Falang\Model\Falang_Model;

class Classic_Editor extends Filters {

	public function __construct( &$falang ) {

		parent::__construct( $falang );

		// Adds the Languages box in the 'Edit Post' and 'Edit Page' panels
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 2 );
	}

	/**
	 * Adds the Language box in the 'Edit Post' and 'Edit Page' panels ( as well as in custom post types panels )
	 *
	 * @since 1.0
	 *
	 * @param string $post_type Current post type
	 * @param object $post      Current post
	 */
	public function add_meta_boxes( $post_type, $post ) {

		if ( $this->falang->get_model()->is_translated_post_type( $post_type ) ) {
			add_meta_box( 'ml_box', __( 'Languages', 'falang' ), array(
				$this,
				'post_language'
			), $post_type, 'side', 'high' );
		}
	}


	/**
	 * Displays the Languages metabox in the 'Edit Post' and 'Edit Page' panels
	 *
	 * @since 0.1
	 */
	public function post_language( $post ) {
		global $post_ID;
		$post_id   = $post_ID;
		$post_type = get_post_type( $post_id );
		$model     = new Falang_Model();

		$initial = ( 'auto-draft' == $post->post_status );

		//$post_locale =
		//original_post_id =

//		$available_locales = $model->get_available_locales( array(
//			'exclude' => array_merge(
//				array( $post_locale ),
//				array_keys( (array) $translations ) ),
//			'exclude_enus_if_inactive' => true,
//			'current_user_can_access' => true,
//		) );

		wp_nonce_field( 'falang_language', '_falang_nonce' );


		$available_locales_list = null;

		$all_language             = new \stdClass();
		$all_language->name       = 'All';
		$all_language->locale     = 'all';//TODO the walker use slug due to the langauge list (check)
		$available_locales_list[] = $all_language;


		foreach ( $model->get_languages_list() as $lg ) {
			$language                 = new \stdClass();
			$language->name           = $lg->name;
			$language->locale         = $lg->locale;
			$available_locales_list[] = $language;
		}


		$dropdown_locale = new \Falang\Core\Walker_Dropdown();
		//get post language in other case default
		$locale        = get_post_meta( $post_id, '_locale', true );
		$post_language = null;
		if ( isset( $locale ) ) {
			$post_language = $model->get_language_by_locale( $locale );
		}

		// NOTE: the class "tags-input" allows to include the field in the autosave $_POST ( see autosave.js )
		printf(
			'<p><strong>%1$s</strong></p>
			<label class="screen-reader-text" for="%2$s">%1$s</label>
			<div id="select-%3$s-locale">%4$s</div>',
			esc_html__( 'Select Language visibility', 'falang' ),
			$id = ( 'attachment' === $post_type ) ? sprintf( 'attachments[%d][language]', $post_ID ) : 'post_locale_choice',
			'attachment' === $post_type ? 'media' : 'post',
			$dropdown_locale->walk(
				$available_locales_list,
				- 1,
				array(
					'name'     => $id,
					'class'    => 'post_locale_choice tags-input',
					'selected' => isset( $post_language ) ? $post_language->locale : 'all',
					'flag'     => true
				)
			)
		);
//

		/**
		 * Fires before displaying the list of translations in the Languages metabox for posts
		 *
		 * @since 1.0
         * @since 1.3.24 add association for page
		 */
		do_action( 'falang_before_post_translations', $post_type );


			//display language link translation
			include FALANG_ADMIN . '/views/view-translations-' . ( 'attachment' == $post_type ? 'media' : 'post' ) . '.php';

            //display association page only
            if ('page' == $post_type && $this->falang->get_model()->get_option( 'association', false ) ){
                include FALANG_ADMIN . '/views/view-association-post.php';
            }

		/**
		 * Display debug link
		 *
		 * @since 1.2.3
		 */
		$debug_admin = $this->falang->get_model()->get_option( 'debug_admin', false );

		if ( $debug_admin ) {
			$args = array(
				'action'  => 'falang_debug_display',
				'post_id' => $post_ID,
				'width'   => 800,
				'height'  => 400
			);

			$debug_link = wp_nonce_url( add_query_arg( $args, admin_url( 'admin-ajax.php' ) ), 'show' );

			echo '<a href=' . $debug_link . ' class="falang_debug thickbox">' . esc_html( __( 'Debug', 'falang' ) ) . '</a>';
		}
	}

//	/**
//	 * Ajax response for changing the locale in the post metabox
//	 *
//	 * @since 0.2
//	 */
//	//TODO not seem to work and use
//	//wp-content/plugins/falang/includes/class-falang.php falang_save_post
//	public function post_locale_choice() {
//		check_ajax_referer( 'falang_language', '_falang_nonce' );
//
//		$falang_model = new Falang_Model();
//
//		//copy from wp-content/plugins/falang/includes/class-falang.php
//		$post_type = $_POST['post_type'];
//		$post_id = $post_ID = (int) $_POST['post_id'];
//		$post = get_post($post_id);
//
//		if (!$falang_model->is_translated_post_type($post->post_type)) {
//			return ;
//		}
//
//		$current_locales = get_post_meta( $post_id, '_locale' );
//		$locale = null;
//
//		$locale = $_REQUEST['locale'];
//
//		//add local exist and not same ass previous
//		if (!empty($locale) && ($current_locales != $locale)) {
//			add_post_meta( $post_id, '_locale', $locale, true );
//		}
//
//		//change language
//
//	}



}