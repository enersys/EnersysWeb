<?php
/**
 * The file that defines the Admin Links
 *
 * @link       www.faboba.com
 * @since      1.0
 *
 * @package    Falang
 */

namespace Falang\Core;


class Admin_Links extends Links {

	/**
	 * Get the link to create a new post translation
	 *
	 * @since 1.0
	 *
	 * @param int    $post_id  the source post id
	 * @param object $language the language of the new translation
	 * @return string
	 */
	public function get_post_translation_link( $post_id, $language ) {

		$post_type = get_post_type( $post_id );
		$post_type_object = get_post_type_object( get_post_type( $post_id ) );
		if ( ! current_user_can( $post_type_object->cap->create_posts ) ) {
			return '';
		}

		// Special case for the privacy policy page which is associated to a specific capability
		if ( 'page' === $post_type_object->name && ! current_user_can( 'manage_privacy_options' ) ) {
			$privacy_page = get_option( 'wp_page_for_privacy_policy' );
//			if ( $privacy_page && in_array( $post_id, $this->model->post->get_translations( $privacy_page ) ) ) {
//				return '';
//			}
		}

		if ( 'attachment' == $post_type ) {
			$args = array(
				'page' => 'falang-translation',
				'post_id' => $post_id,
				'language'  => $language->locale,
				'action' => 'edit'
			);

			// Add nonce for media as we will directly publish a new attachment from a click on this link
			$link = wp_nonce_url( add_query_arg( $args, admin_url( 'admin.php' ) ), 'edit' );
		} else {
			$args = array(
				'page' => 'falang-translation',
				'post_id' => $post_id,
				'language'  => $language->locale,
				'action' => 'edit'
			);

			$link = wp_nonce_url( add_query_arg( $args, admin_url( 'admin.php' ) ), 'edit' );
		}

		/**
		 * Filter the new post translation link
		 *
		 * @since 1.0
		 *
		 * @param string $link     the new post translation link
		 * @param object $language the language of the new translation
		 * @param int    $post_id  the source post id
		 */
		return apply_filters( 'falang_get_post_translation_link', $link, $language, $post_id );
	}


	/**
	 * Returns html markup for a new post translation link
	 *
	 * @since 1.0
	 *
	 * @param int    $post_id
	 * @param object $language
	 * @param target @target of link _blank , self, popup
	 * @return string
	 */
	public function display_post_translation_link( $post_id, $language, $target = '_blank' ) {
		$link = $this->get_post_translation_link( $post_id, $language );
		return $link ? sprintf(
			'<a href="%1$s" class="falang_language_link" target="%2$s"><span class="">%3$s</span></a>',
			esc_url( $link ),
			$target,
			/* translators: accessibility text, %s is a native language name */
			esc_html( sprintf( __( 'Translate: %s', 'falang' ), $language->name ) )
		) : '';
	}

    /**
     * Returns association page link (not yet post/cpt)
     *
     * @since 1.3.24
     *
     * @param int    $post_id
     * @param object $language
     * @return string
     */
    public function display_post_association_list( $post_id, $language )
    {
        $name = '_falang_assoc_'.$language->locale;

        //get the post
		$selected_post = get_post_meta($post_id,$name,true);

        $dropdown_args = array(
            //'post_type'        => 'page',//not necessary actually only page association
            'selected'         => $selected_post,
            'meta_key'         => '_locale',
            'meta_value'       => $language->locale,
            'name'             => $name,
            'hierarchical'     => false,//to have the post/poge and not only the same level
            'show_option_none' => __( '(no association)' ),
            'sort_column'      => 'post_title',
            'class'			   => 'falang-association',
            'echo'             => 0,
        );

        $output         = wp_dropdown_pages( $dropdown_args );

        if ( empty( $output )) {
        	$output = "<select id=\"".$name."\" name=\"".$name."\" class=\"falang-association\">";
        	$output .= "<option value=\"\">".__( '(no association)' )."</option>";
        	$output .= "</select>";
		}

		if ( ! empty( $output ) ) {
			return $output;
		}

    }


}