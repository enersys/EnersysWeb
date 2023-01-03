<?php


namespace Falang\Filter\Site;


class Enfold {

	/**
	 * Constructor
	 *
	 * @since 1.3.1
	 *
	 */
	public function __construct( ) {

		// Split the language switcher menu item in several language menu items
		add_filter( 'avf_post_slider_entry_excerpt', array( $this, 'post_slider_entry_excerpt' ), 10, 4 ); //exceprt translate

		// add translation for content (excerpt) in magazine need override and change of line 1236 to
		//$excerpt = ! empty( $entry->post_excerpt ) ?  get_the_excerpt($entry->ID) : avia_backend_truncate( apply_filters('avf_magazine_entry_content',$entry->post_content,$entry), apply_filters( 'avf_magazine_excerpt_length', 60 ), apply_filters( 'avf_magazine_excerpt_delimiter', ' ' ), '…', true, '' );
		add_filter( 'avf_magazine_entry_content', array( $this, 'avf_magazine_translate_entry_content' ), 10, 2 ); //exceprt translate

	}


	public function post_slider_entry_excerpt($excerpt, $prepare_excerpt, $permalink, $entry){
		$excerpt_length 	= 60;
		$post_content = $entry->post_content;

		$falang_post = new \Falang\Core\Post($entry->ID);

		if (!Falang()->is_default() && $falang_post->is_post_type_translatable($entry->post_type)){
			//manual excerpt
			if (!empty( $entry->post_excerpt)){
				$excerpt = $falang_post->translate_post_field($entry, 'post_excerpt', Falang()->get_current_language() ,$entry->post_excerpt);
			} else {
				//automatic
				$post_content=  $falang_post->translate_post_field($entry, 'post_content', Falang()->get_current_language(), $excerpt);
				//use the format from the file
				//wp-content/themes/enfold/config-templatebuilder/avia-shortcodes/postslider/postslider.php
				$excerpt = avia_backend_truncate( $post_content, apply_filters( 'avf_postgrid_excerpt_length', $excerpt_length ) , apply_filters( 'avf_postgrid_excerpt_delimiter' , ' ' ), '…', true, '' );
			}
		}
		return $excerpt;
	}

	public function avf_magazine_translate_entry_content($content,$entry){
		$falang_post = new \Falang\Core\Post($entry->ID);

		if ($entry && !Falang()->is_default() && $falang_post->is_post_type_translatable($entry->post_type)){

			$content = $falang_post->translate_post_field($entry, 'post_content', Falang()->get_current_language(), $content);

		}

		return $content;

	}



}