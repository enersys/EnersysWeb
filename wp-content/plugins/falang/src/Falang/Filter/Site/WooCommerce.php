<?php

namespace Falang\Filter\Site;


class WooCommerce {

	/**
	 * Constructor
	 *
	 * @since 1.3.1
     * @since 1.3.28 add woocommerce_product_title filter
	 *
	 */
	public function __construct( ) {
		//woocommerce attribute label support
		add_filter( 'woocommerce_attribute_label', array( $this,'translate_wc_attribute_label'), 10, 3 );
		//woocommerce the_excerpt short_description translation => wc don't use get_the_excerpt
		add_filter('woocommerce_short_description', array($this, 'translate_wc_post_excerpt'), 9);
		//translate product variation description
		add_filter( 'woocommerce_available_variation', array($this,'translate_variation_descriptions'),10,3) ;
        //transate cart title
        add_filter( 'woocommerce_cart_item_name', array($this,'translate_cart_item_name'),10,3) ;

        //transate cart/checkout page permalink
        add_filter('woocommerce_get_cart_page_permalink',array($this,'translate_woocommerce_get_page_page_permalink'));
        add_filter('woocommerce_get_checkout_page_permalink',array($this,'translate_woocommerce_get_page_page_permalink'));

        //translate cart title in thank-you page
        add_filter('woocommerce_order_item_name', array($this,'translate_woocommerce_order_item_name'),10,3);

        //translate product title and permalink during ajax call (aws-search)
        if ( isset( $_REQUEST['wc-ajax'] ) ) {
            add_filter('woocommerce_product_title', array($this, 'translate_woocommerce_product_title'), 10, 2);
        }
        //translate product title for $product->get_title()
        add_filter('woocommerce_product_title', array($this, 'translate_wc_product_title'), 10, 2);

    }

	/** Display the translated attribute label
	 *
	 * @since 1.2.1
	 */
	public function translate_wc_attribute_label( $label, $name, $product ) {
		//TODO put this in the constructor
		$falang_wc_options = get_option('falang_wc_attributes');

		//old version send name without pa_ key stored without pa_ in falang_wc_attributes
		if (strpos($name, 'pa_') === 0){
			$name = str_replace('pa_','',$name);
		}

		$key = $name.'_label_'.Falang()->get_current_language()->locale;
		if (isset( $falang_wc_options[$key])){
			$translated_label = $falang_wc_options[$key];
		}

		//return orginal or translated
		if (!empty($translated_label)){
			return $translated_label;
		} else {
			return $label;
		}

	}

    /**
     * Display the wc short_description excerpt
     *
     * @since 1.2.2
     * @since 1.3.26 remove the is_product test (flatstone quickview don't work ajax call)
     * @since 1.3.27 add term test , category description use the same filter
     */
    public function translate_wc_post_excerpt( $post_excerpt) {
        global $post;
        $term = get_queried_object();
        if (isset($term) && isset($term->taxonomy) && ('product_cat' == $term->taxonomy)) {return $post_excerpt; }
        //if (is_product()){//wc function
        $falang_post = new \Falang\Core\Post($post->ID);
        //need to check empty in other can be displayed several times
        if (!empty($post_excerpt) && !Falang()->is_default() && $falang_post->is_post_type_translatable($post->post_type)){
            $post_excerpt = $falang_post->translate_post_field($post, 'post_excerpt', Falang()->get_current_language(), $post_excerpt);
        }
        //}
        return $post_excerpt;
    }

    /**
     * Display the wc variation description
     *
     * @since 1.3.2
     * @since 1.3.15 clean method
     */
    public function translate_variation_descriptions( $data, $product, $variation ) {
        if (!Falang()->is_default()) {
            $data['variation_description'] = !empty($variation->get_description())?$variation->get_description():$data['variation_description'];
        }
        return $data;
    }

    /**
     * Translate the product title in the cart
     *
     * @since 1.3.15
     */
    public function translate_cart_item_name( $product_get_name, $cart_item, $cart_item_key ) {
        if (!Falang()->is_default()) {
            $falang_post = new \Falang\Core\Post($cart_item['product_id']);
            $post = get_post($cart_item['product_id']);
            $translate = $falang_post->translate_post_field($post, 'post_title', Falang()->get_current_language(), $post->post_title);
            return str_replace($post->post_title, $translate, $product_get_name);
        }
        return $product_get_name;
    }

    /**
     * Translate the permalink when update cart quantity
     * necessary becasue the get_home_url don't have the language code
     * filter not translate_home_url not apply
     *
     * @since 1.3.15
     * @since 1.3.24 change method name (use for cart and checkout page)
     *               copy this function to Filter/Admin ajax use admin not front hook
     *               remove test on cart-update
     * @since 1.3.25 sometimes get_home_url as the slug
     */
    public function translate_woocommerce_get_page_page_permalink($permalink){
        if (!Falang()->is_default()) {
            if (get_option('permalink_structure')) {
                $home = get_home_url();
                $lang = '/' . Falang()->get_current_language()->slug .'/';
                if (strpos($home,$lang) === false){
                    $home = get_home_url() . '/' . Falang()->get_current_language()->slug;
                    $permalink = str_replace(home_url(), $home, $permalink);
                }
            } else {
                $permalink = add_query_arg(array('lang' => Falang()->get_current_language()->slug), $permalink);
            }
        }
        return $permalink;
    }

    /**
     * Translate the product title in the order details-item use in thank-you page
     *
     * @since 1.3.15
     */
    public function translate_woocommerce_order_item_name( $item_name, $item, $is_visible){
        if (!Falang()->is_default()) {
            $falang_post = new \Falang\Core\Post($item['product_id']);
            $post = get_post($item['product_id']);
            $translate = $falang_post->translate_post_field($post, 'post_title', Falang()->get_current_language(), $post->post_title);
            return str_replace($post->post_title, $translate, $item_name);
        }
        return $item_name;
    }

    /**
     * Translate the product title for aws_title_search_result
     * only use on Ajax call
     *
     * @since 1.3.19
     */
    public function translate_woocommerce_product_title( $title, $product){
        $lang = isset( $_REQUEST['lang'] ) ? sanitize_text_field( $_REQUEST['lang'] ) : '';
        $default = Falang()->is_default();
        if ($lang){
            if (!Falang()->is_default()) {
                $language = Falang()->get_model()->get_language_by_slug($lang);
                if ($language){
                    $falang_post = new \Falang\Core\Post($product->get_id());
                    $post = get_post($product->get_id());
                    $title = $falang_post->translate_post_field($post, 'post_title', $language);
                }
            }
        }
        return $title;
    }

    /**
     * filter: woocommerce_product_title
     * Translate the product title when $product->get_title() is used.
     * fix for mymedi theme but used in other theme
     *
     * @since 1.3.28
     * @since 1.3.30 fix notice and use the same way with translate_woocommerce_product_title
     */
    public function translate_wc_product_title($title, $product){
        if (!Falang()->is_default()) {
            $falang_post = new \Falang\Core\Post($product->get_id());
            $post = get_post($product->get_id());
            $translated_product_title = $falang_post->translate_post_field($post, 'post_title', Falang()->get_current_language(), $title);
            return $translated_product_title;

        }
        return $title;
    }
}