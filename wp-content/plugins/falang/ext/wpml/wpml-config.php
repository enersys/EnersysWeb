<?php
/**
 * WPML Compatibility class
 * Defines some WPML constants
 * Registers strings in a persistent way as done by WPML
 * from polylang
 *
 * @since 1.3.2
 */

use Falang\Core\Falang_Translate_Option;

class FALANG_WPML_Config {
	protected static $instance; // For singleton

    /**
     * The content of all read xml files.
     *
     * @var SimpleXMLElement[]
     */
	protected $xmls;

	protected  $options;

	/**
	 * Constructor
	 *
	 * @since 1.3.1
	 */
	public function __construct() {
		if ( extension_loaded( 'simplexml' ) ) {
			$this->init();
		}
	}

	/**
	 * Access to the single instance of the class
	 *
	 * @since 1.3.2
	 *
	 * @return object
	 */
	public static function instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Finds the wpml-config.xml files to parse and setup filters
	 *
	 * @since 1.3.1
	 */
	public function init() {
		$this->xmls = array();

		// Plugins
		// Don't forget sitewide active plugins thanks to Reactorshop http://wordpress.org/support/topic/polylang-and-yoast-seo-plugin/page/2?replies=38#post-4801829
		$plugins = ( is_multisite() && $sitewide_plugins = get_site_option( 'active_sitewide_plugins' ) ) && is_array( $sitewide_plugins ) ? array_keys( $sitewide_plugins ) : array();
		$plugins = array_merge( $plugins, get_option( 'active_plugins', array() ) );

		foreach ( $plugins as $plugin ) {
			if ( file_exists( $file = WP_PLUGIN_DIR . '/' . dirname( $plugin ) . '/wpml-config.xml' ) && false !== $xml = simplexml_load_file( $file ) ) {
				$this->xmls[ dirname( $plugin ) ] = $xml;
			}
		}

		// Theme
		if ( file_exists( $file = ( $template = get_template_directory() ) . '/wpml-config.xml' ) && false !== $xml = simplexml_load_file( $file ) ) {
			$this->xmls[ get_template() ] = $xml;
		}

		// Child theme
		if ( ( $stylesheet = get_stylesheet_directory() ) !== $template && file_exists( $file = $stylesheet . '/wpml-config.xml' ) && false !== $xml = simplexml_load_file( $file ) ) {
			$this->xmls[ get_stylesheet() ] = $xml;
		}

		// Custom
//		if ( file_exists( $file = PLL_LOCAL_DIR . '/wpml-config.xml' ) && false !== $xml = simplexml_load_file( $file ) ) {
//			$this->xmls['Polylang'] = $xml;
//		}

		if ( ! empty( $this->xmls ) ) {
//			add_filter( 'pll_copy_post_metas', array( $this, 'copy_post_metas' ), 20, 2 );
//			add_filter( 'pll_copy_term_metas', array( $this, 'copy_term_metas' ), 20, 2 );
//			add_filter( 'pll_get_post_types', array( $this, 'translate_types' ), 10, 2 );
//			add_filter( 'pll_get_taxonomies', array( $this, 'translate_taxonomies' ), 10, 2 );

			foreach ( $this->xmls as $context => $xml ) {
                $keys = $xml->xpath( 'admin-texts/key' );
                if ( is_array( $keys ) ) {
                    foreach ( $keys as $key ) {
                        $attributes = $key->attributes();
                        $name = (string) $attributes['name'];

                        if ( false !== strpos( $name, '*' ) ) {
                            $pattern = '#^' . str_replace( '*', '(?:.+)', $name ) . '$#';
                            $names = preg_grep( $pattern, array_keys( wp_load_alloptions() ) );

                            if ( is_array( $names ) ) {
                                foreach ( $names as $_name ) {
                                    $this->register_or_translate_option( $context, $_name, $key );
                                }
                            }
                        } else {
                            $this->register_or_translate_option( $context, $name, $key );
                        }
                    }
                }
			}
		}
	}

    /**
     * Registers or translates the strings for an option
     *
     * @since 1.3.13
     *
     * @param string $context The group in which the strings will be registered.
     * @param string $name    Option name.
     * @param object $key     XML node.
     * @return void
     */
    protected function register_or_translate_option( $context, $name, $key ) {
        $option_keys = $this->xml_to_array( $key );
        new Falang_Translate_Option( $name, reset( $option_keys ), array( 'context' => $context ) );
    }

    /**
     * Recursively transforms xml nodes to an array, ready for PLL_Translate_Option.
     *
     * @since 1.3.13
     *
     * @param object $key XML node.
     * @param array  $arr Array of option keys to translate.
     * @return array
     */
    protected function xml_to_array( $key, &$arr = array() ) {
        $attributes = $key->attributes();
        $name = (string) $attributes['name'];
        $children = $key->children();

        if ( count( $children ) ) {
            foreach ( $children as $child ) {
                $arr[ $name ] = $this->xml_to_array( $child, $arr[ $name ] );
            }
        } else {
            $arr[ $name ] = true; // Multiline as in WPML.
        }
        return $arr;
    }

}