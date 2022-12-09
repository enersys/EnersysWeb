<?php
/**
 * Ajax
 *
 * @package Gutenify
 */

/**
 * Gutenify_Ajax
 */
class Gutenify_Ajax {
    /**
     * Gutenify_Ajax constructor.
     */
    public function __construct() {
        // Get templates.
        add_action( 'wp_ajax_gutenify_get_templates', array( $this, 'get_templates' ) );
    }

    /**
     * Get templates.
     */
    public function get_templates() {
        echo "test";
    }
}

new Gutenify_Ajax();
