<?php

namespace Falang\Filter\Admin;


class WooCommerce {

	/**
	 * Constructor
	 *
	 * @since 1.3.24
	 *
	 */
	public function __construct( ) {

        add_filter('woocommerce_get_cart_page_permalink',array($this,'translate_woocommerce_get_page_page_permalink'));
        add_filter('woocommerce_get_checkout_page_permalink',array($this,'translate_woocommerce_get_page_page_permalink'));

    }

    /**
     * Translate the permalink when update cart quantity
     * necessary becasue the get_home_url don't have the language code
     * filter not translate_home_url not apply
     *
     * @since 1.3.24 manage get_{wc_page}_hook front ajax call
     */
    public function translate_woocommerce_get_page_page_permalink($permalink){
        if (!Falang()->is_default()) {
            if (get_option('permalink_structure')) {
                $home = get_home_url() . '/' . Falang()->get_current_language()->slug;
                $permalink = str_replace(home_url(), $home, $permalink);
            } else {
                $permalink = add_query_arg(array('lang' => Falang()->get_current_language()->slug), $permalink);
            }
        }
        return $permalink;
    }

}