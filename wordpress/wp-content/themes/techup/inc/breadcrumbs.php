<?php
function techup_breadcrumbs() {

       $techup_showonhome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $techup_showcurrent = 1;
    if (is_home() || is_front_page()) {

            echo '<ul id="breadcrumbs" class="banner-link text-center"><li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'techup') . '</a></li></ul>';
    } else {

        echo '<ul id="breadcrumbs" class="banner-link text-center"><li><a href="' . esc_url(home_url('/')). '">' . esc_html__('Home', 'techup') . '</a> ';
        if (is_category()) {
            $techup_thisCat = get_category(get_query_var('cat'), false);
            if ($techup_thisCat->parent != 0)
                echo esc_html(get_category_parents($techup_thisCat->parent, TRUE, ' '));
            echo  esc_html__('Archive by category', 'techup') . ' " ' . single_cat_title('', false) . ' "';
        }   elseif (is_search()) {
            echo  esc_html__('Search Results For ', 'techup') . ' " ' . get_search_query() . ' "';
        } elseif (is_day()) {
            echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ';
            echo '<a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . esc_html(get_the_time('F') ). '</a> ';
            echo  esc_html(get_the_time('d'));
        } elseif (is_month()) {
            echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ';
            echo  esc_html(get_the_time('F')) ;
        } elseif (is_year()) {
            echo esc_html(get_the_time('Y')) ;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $techup_post_type = get_post_type_object(get_post_type());
                $techup_slug = $techup_post_type->rewrite;
                echo '<a href="' . esc_url(home_url('/'. $techup_slug['slug'] . '/')) .'">' . esc_html($techup_post_type->labels->singular_name) . '</a>';
                if ($techup_showcurrent == 1)
                    echo  esc_html(get_the_title()) ;
            } else {
                $techup_cat = get_the_category();
                $techup_cat = $techup_cat[0];
                $techup_cats = get_category_parents($techup_cat, TRUE, ' ');
                if ($techup_showcurrent == 0)
                    $techup_cats =
                            preg_replace("#^(.+)\s\s$#", "$1", $techup_cats);
                echo $techup_cats;
                if ($techup_showcurrent == 1)
                    echo  esc_html(get_the_title());
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $techup_post_type = get_post_type_object(get_post_type());
            echo esc_html($techup_post_type->labels->singular_name );
        } elseif (is_page()) {
            if ($techup_showcurrent == 1)
                echo esc_html(get_the_title());
        } elseif (is_page() && $post->post_parent) {
            $techup_parent_id = $post->post_parent;
            $techup_breadcrumbs = array();
            while ($techup_parent_id) {
                $techup_page = get_page($techup_parent_id);
                $techup_breadcrumbs[] = '<a href="' . esc_url(get_permalink($techup_page->ID)) . '">' . esc_html(get_the_title($techup_page->ID)) . '</a>';
                $techup_parent_id = $techup_page->post_parent;
            }
            $techup_breadcrumbs = array_reverse($techup_breadcrumbs);
            for ($techup_i = 0; $techup_i < count($techup_breadcrumbs); $techup_i++) {
                echo $techup_breadcrumbs[$techup_i];
                if ($techup_i != count($techup_breadcrumbs) - 1)
                    echo ' ';
            }
            if ($techup_showcurrent == 1)
                echo esc_html(get_the_title());
        } elseif (is_tag()) {
            echo  esc_html__('Posts tagged', 'techup') . ' " ' . esc_html(single_tag_title('', false)) . ' "';
        } elseif (is_author()) {
            global $author;
            $techup_userdata = get_userdata($author);
            echo  esc_html__('Articles Published by', 'techup') . ' " ' . esc_html($techup_userdata->display_name ). ' "';
        } elseif (is_404()) {
            echo esc_html__('Error 404', 'techup') ;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
            printf( /* translators: %s is search query variable*/ esc_html__(' ( Page %s )', 'techup'),esc_html(get_query_var('paged')) );
        }

        
        echo '</li></ul>';
    }
}