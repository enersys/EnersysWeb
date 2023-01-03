<?php


namespace Falang\Filter\Site;


class Flatsome {

    /**
     * Constructor
     *
     * @since 1.3.26
     *
     */
    public function __construct( ) {

        add_filter('falang_translate_custom_post_link',array($this,'falang_translate_custom_post_link'),10,3);

    }


    /**
     * translate the portfolio link
     * @since 1.3.26
     *
     */
    public function falang_translate_custom_post_link($post_link,$post_id,$language)
    {
        $falang_post = new \Falang\Core\Post();
        $post = get_post($post_id);
        global $wp_rewrite;

        if ($post && $falang_post->is_post_type_translatable($post->post_type) && get_option('permalink_structure')) {
            $post_type_obj = get_post_type_object($post->post_type);

            $translated_cpt = is_array($post_type_obj->rewrite) && isset($post_type_obj->rewrite['with_front']) ? $wp_rewrite->front : $wp_rewrite->root;

            $translated_cpt .= $falang_post->translate_cpt($post->post_type, $language, $post->post_type);

            $translated_slug = $falang_post->translate_post_field($post, 'post_name', $language);

            if ($post_type_obj->hierarchical) {

                $parent_id = $post->post_parent;

                while ($parent_id != 0) {

                    $parent = get_post($parent_id);
                    $parent_slug = $falang_post->translate_post_field($parent, 'post_name', $language);
                    $translated_slug = $parent_slug . '/' . $translated_slug;
                    $parent_id = $parent->post_parent;

                }

            }

            $post_link = $translated_cpt . '/' . user_trailingslashit($translated_slug);

            if ($post->post_type == 'featured_item') {

                $post_link = $translated_cpt . '/' . '%featured_item_category%' . '/' . user_trailingslashit($translated_slug);

                //copy from wp-content/themes/flatsome/inc/post-types/post-type-ux-portfolio.php
                //see register_taxonomy_category

                $terms = get_the_terms($post->ID, 'featured_item_category');

                if (!$terms)
                    return str_replace('/%featured_item_category%', '', $post_link);

                $post_terms = array();
                foreach ($terms as $term)
                    $post_terms[] = $term->slug;

                $post_link = str_replace('%featured_item_category%', implode(',', $post_terms), $post_link);
            }

        }
        return  $post_link;
    }

}