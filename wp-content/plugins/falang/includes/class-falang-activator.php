<?php

/**
 * Fired during plugin activation
 *
 * @link       www.faboba.com
 * @since      1.0
 *
 * @package    Falang
 * @subpackage Falang/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0
 * @package    Falang
 * @subpackage Falang/includes
 * @author     Stéphane Bouey <stephane.bouey@faboba.com>
 */
class Falang_Activator {
	const POLYLANG = 'polylang/polylang.php';

	/**
	 * @since    1.0
	 */
	public static function activate() {
		global $wp_version;
		$falang_model = new \Falang\Model\Falang_Model();

		$options = get_option($falang_model->option_name);

		load_plugin_textdomain( 'falang', false, basename( FALANG_DIR ) . '/languages' ); // plugin i18n


		//no multisiste
		if ( is_multisite()) {
			die(
			sprintf(
				'<p style = "font-family: sans-serif; font-size: 12px; color: #333; margin: -5px">%s</p>',
				esc_html__('Falang cannot be installed on a multisite system', 'falang' )
			)
			);
		}

		//no polylang
		if (  is_plugin_active(self::POLYLANG)) {
			die(
			sprintf(
				'<p style = "font-family: sans-serif; font-size: 12px; color: #333; margin: -5px">%s</p>',
				esc_html__('Falang cannot be installed with Polylang on the same site', 'falang' )
			)
			);
		}


		if ( version_compare( $wp_version, FALANG_MIN_WP_VERSION, '<' ) ) {
			die(
			sprintf(
				'<p style = "font-family: sans-serif; font-size: 12px; color: #333; margin: -5px">%s</p>',
				sprintf(
				/* translators: %1$s and %2$s are WordPress version numbers */
					esc_html__( 'You are using WordPress %1$s. Falang requires at least WordPress %2$s.', 'falang' ),
					esc_html( $wp_version ),
					FALANG_MIN_WP_VERSION
				)
			)
			);
		}

		if (self::is_polylang_installed()) {
			die(
			sprintf(
				'<p style="font-family:sans-serif;font-size: 13px;color: #333; margin: -5px">%s</p>',
				__('Falang cannot be installed now, because Polylang has not been completely removed. Falang and Polylang use the languages in taxonomies and cannot exist together on the same installation. See the Polylang documentation to remove it completely <a href="https://polylang.pro/doc/how-to-uninstall-polylang/" target="blank">here</a>. After that, you can install Falang again.', 'falang' )
			)
			);
		}

		//create default options for the fist activation
		if (empty($options)) {
			update_option($falang_model->option_name, self::get_default_options());
		}

        // Avoid 1 query on every pages if no wpml strings is registered
        if ( ! get_option( 'falang_wpml_strings' ) ) {
            update_option( 'falang_wpml_strings', array() );
        }

        // create the empty falang dismissed notice option
        if ( ! get_option( 'falang_dismissed_notices' ) ) {
            update_option( 'falang_dismissed_notices', array() );
        }

		//create default language (after option to update default language)
        if (empty($falang_model->get_languages_list())) {
            self::add_default_language();
        }

	}

	/**
	 * Get default Falang options
	 *
	 * @since 1.0
	 *
	 * return array
	 */
	public static function get_default_options() {
		return array(
			'post_type' => array(
				'post' => array('translatable' => true),
				'page' => array('translatable' => true),
				'nav_menu_item' => array('translatable' => true)
			),
			'taxonomy' => array(
				'category' => array('translatable' => true),
				'post_tag' => array('translatable' => true)
			),
			'show_slug' => false,
			'autodetect' => false,
			'need_flush' => 1,
			'enable_service' => false,
			'service_name' => '',
            'google_key' => '',
            'azure_key' => '',
			'yandex_key' => '',
            'lingvanex_key' => '',
			'debug_admin' => false,
			'delete_trans_on_uninstall' => false,
            'flag_width' => 16,
            'flag_height' => 11,
            'association' => false,
            'downloadid' => '',
            'frontend_ajax' => false,
            'no_autop' => false
        );
	}

	/*
	 * Add en_US language taxonomy on installation.
	 * since 1.3.6 don't install language en_US when others languages exist
	 * */
	public static function add_default_language(){
        $falang_model = new \Falang\Model\Falang_Model();

        $args = array(
            'code' => 'en',
            'slug' => 'en',//slug is added from the languages file
            'locale' => 'en_US',
            'name' => 'English',
            'dir' => 'ltr',
            'flag' => 'us',
            'facebook' => 'en_US',
        );
                //$falang_model->add_language($languages['en_US']);//don't work here
                // First add the language taxonomy
        $description = serialize(array('locale' => $args['locale'], 'rtl' => (int)$args['rtl'], 'flag_code' => empty($args['flag']) ? '' : $args['flag']));
        $r = wp_insert_term($args['name'], 'language', array('slug' => $args['slug'], 'description' => $description));
        if (is_wp_error($r)) {
            die(
            sprintf(
                '<p style = "font-family: sans-serif; font-size: 12px; color: #333; margin: -5px">%s</p>',
                esc_html__('Impossible to init default en_US language', 'falang')
            )
            );
        }
        wp_update_term((int)$r['term_id'], 'language', array('position' => (int)$args['position'])); // can't set the term group directly in wp_insert_term

        // The term_language taxonomy
        // Don't want shared terms so use a different slug
        wp_insert_term($args['name'], 'term_language', array('slug' => 'falang_' . $args['slug']));

        // Init a mo_id for this language
        $post = array(
            'post_title' => 'falang_mo_' . $r['term_id'],
            'post_status' => 'private', // To avoid a conflict with WP Super Cache. See https://wordpress.org/support/topic/polylang_mo-and-404s-take-2
            'post_type' => 'falang_mo',
        );
        $mo_id = wp_insert_post($post);
        update_post_meta($mo_id, '_falang_strings_translations', '');

        //set default to en_US
		$falang_model->update_default_lang('en_US');

	}

	public static function is_polylang_installed (){
		$polylang = get_option('polylang');
		if ($polylang){
			return true;
		} else {
			return false;
		}
	}

}
