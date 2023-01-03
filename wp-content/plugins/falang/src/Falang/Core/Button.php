<?php
/**
 * The file that defines the Button Admin Notices
 *
 * @link       www.faboba.com
 * @since      1.3.23
 *
 * @package    Falang
 */
namespace Falang\Core;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


class Button {

    private $options;
    /**
     * @inheritDoc
     */
    public function get_name() {
        return 'admin-button';
    }

    public function print_button() {
        $options = $this->get_options();

        if ( empty( $options['text'] ) ) {
            return;
        }

        $html_tag = ! empty( $options['url'] ) ? 'a' : 'button';
        $before = '';
        $icon = '';
        $attributes = [];

        if ( ! empty( $options['icon'] ) ) {
            $icon = '<i class="' . esc_attr( $options['icon'] ) . '"></i>';
        }

        $classes = $options['classes'];

        if ( ! empty( $options['type'] ) ) {
            $classes[] = 'falang-button--' . $options['type'];
        }

        if ( ! empty( $options['variant'] ) ) {
            $classes[] = 'falang-button--' . $options['variant'];
        }

        if ( ! empty( $options['before'] ) ) {
            $before = '<span>' . wp_kses_post( $options['before'] ) . '</span>';
        }

        if ( ! empty( $options['url'] ) ) {
            $attributes['href'] = $options['url'];
            if ( $options['new_tab'] ) {
                $attributes['target'] = '_blank';
            }
        }

        $attributes['class'] = $classes;

        $html = $before . '<' . $html_tag . ' ' . self::render_html_attributes( $attributes ) . '>';
        $html .= $icon;
        $html .= '<span>' . sanitize_text_field( $options['text'] ) . '</span>';
        $html .= '</' . $html_tag . '>';

        echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * @param string $option Optional default is null
     * @return array|mixed
     */
    private function get_options( $option = null ) {
        return $this->get_items( $this->options, $option );
    }

    /**
     * @param null $option
     * @return array
     */
    private function get_default_options( $option = null ) {
        $default_options = [
            'classes' => [ 'btn button falang-button' ],
            'icon' => '',
            'new_tab' => false,
            'text' => '',
            'type' => '',//empty, cta ,info
            'url' => '',
            'variant' => '',
            'before' => '',
        ];

        if ( null !== $option && -1 !== in_array( $option, $default_options ) ) {
            return $default_options[ $option ];
        }

        return $default_options;
    }

    public function __construct( array $options ) {
        $this->options = $this->merge_properties( $this->get_default_options(), $options );
    }

    /**
     * Render html attributes
     *
     * @access public
     * @static
     * @param array $attributes
     *
     * @return string
     */
    public static function render_html_attributes( array $attributes ) {
        $rendered_attributes = [];

        foreach ( $attributes as $attribute_key => $attribute_values ) {
            if ( is_array( $attribute_values ) ) {
                $attribute_values = implode( ' ', $attribute_values );
            }

            $rendered_attributes[] = sprintf( '%1$s="%2$s"', $attribute_key, esc_attr( $attribute_values ) );
        }

        return implode( ' ', $rendered_attributes );
    }

    final public function merge_properties( array $default_props, array $custom_props, array $allowed_props_keys = [] ) {
        $props = array_replace_recursive( $default_props, $custom_props );

        if ( $allowed_props_keys ) {
            $props = array_intersect_key( $props, array_flip( $allowed_props_keys ) );
        }

        return $props;
    }

    /**
     * Get items.
     *
     * Utility method that receives an array with a needle and returns all the
     * items that match the needle. If needle is not defined the entire haystack
     * will be returned.
     *
     * @since 2.3.0
     * @access protected
     * @static
     *
     * @param array  $haystack An array of items.
     * @param string $needle   Optional. Needle. Default is null.
     *
     * @return mixed The whole haystack or the needle from the haystack when requested.
     */
    final protected static function get_items( array $haystack, $needle = null ) {
        if ( $needle ) {
            return isset( $haystack[ $needle ] ) ? $haystack[ $needle ] : null;
        }

        return $haystack;
    }
}
