<?php


namespace Falang\Filter\Site;


use RankMath\Paper\Paper;
use RankMath\Post;

class RankMath{

    /**
     * Constructor
     *
     * @since 1.3.8
     * @since 1.3.24 add sitemap entry
     * @since 1.3.24 add xml_post_usl
     *
     */
    public function __construct( ) {

        add_filter( 'rank_math/frontend/title', array( $this, 'rank_math_title' ), 10);

        add_filter( 'rank_math/sitemap/entry', array( $this, 'rank_math_entry' ) ,10, 3 );

        add_filter( 'rank_math/sitemap/xml_post_url',array ($this, 'rank_math_xml_post_url'), 10, 2 );

    }

    public function rank_math_title($title){
        if (Falang()->is_default() ) return $title;
        global $post;

        //home static posts page
        if (is_home()  && !Post::is_simple_page() ){
            return $title;
        }

        //manage title for all products pages
        //on all product pages the global post is the first product
        if (Post::is_shop_page()){
            $id = Post::get_shop_page_id();
            $shop_page = get_post($id);
            $post = $shop_page;
        }

        if (isset($post) && !empty($post->ID) ){
            $title = Falang()->translate_post_title($title,$post->ID);
            //set the title to the translate post
            $post->post_title = $title;
            if (isset($post->post_type)){
                $title =  Paper::get_from_options( "pt_{$post->post_type}_title", $post, '%title% %sep% %sitename%' );
            }

        }

        return $title;
    }

    /**
     * Filter entry from sitemap for CPT with specific language
     *
     * @since 1.3.24
     *
     */
    public function rank_math_entry($url, $type, $object ){
        //don't filter by default here

        if ( 'post' == $type && 'page' == $object->post_type ){
           $locale = get_post_meta($object->ID, '_locale', true);
           if (!empty($locale) && 'all' != $locale ){
               $current_language = Falang()->get_current_language();
               if($current_language->locale != $locale){
                   return null;
               }
           }
        }
        return $url;
    }


    /**
     * fix permalink for post/page
     *
     * @since 1.3.24
     *
     */
    public function rank_math_xml_post_url($url, $post){
        if (Falang()->is_default() ) return $url;
        $falang_post = new \Falang\Core\Post($post->ID);

        if ($falang_post->is_post_type_translatable($post->post_type)){
            return get_permalink($post->ID);
        }

        return $url;
    }
}