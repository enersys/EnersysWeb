<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       www.faboba.com
 * @since      1.0.0
 *
 * @package    Falang
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

/**
 * Manages Falang uninstallation
 * The goal is to remove ALL Falang related data in db if set to true
 *
 * @since 1.0
 */
class Falang_Uninstall
{

    /**
     * Constructor: manages uninstall for multisite
     *
     * @since 0.5
     */
    public function __construct()
    {
        $this->uninstall();
    }

    /**
     * Removes ALL plugin data
     * only when the relevant option is active
     *
     * @since 0.5
     */
    public function uninstall()
    {
        global $wpdb;

        $delete_trans = $this->get_option('delete_trans_on_uninstall', false);

        if (!$delete_trans) {
            return;
        }

        // Need to register the taxonomies
        $falang_taxonomies = array('language', 'term_language');
        foreach ($falang_taxonomies as $taxonomy) {
            register_taxonomy($taxonomy, null, array('label' => false,
                'public' => false,
                'query_var' => false,
                'rewrite' => false
            ));
        }

        $languages = get_terms('language', array('hide_empty' => false));

        // Delete the strings translations 1.2+
        register_post_type('falang_mo', array('rewrite' => false, 'query_var' => false));
        $ids = get_posts(
            array(
                'post_type' => 'falang_mo',
                'post_status' => 'any',
                'numberposts' => -1,
                'nopaging' => true,
                'fields' => 'ids',
            )
        );
        foreach ($ids as $id) {
            wp_delete_post($id, true);
        }

        foreach ($languages as $language) {
            //local is in description
            $description = maybe_unserialize($language->description);
            foreach ($description as $prop => $value) {
                $language->$prop = $value;
            }

            //check $prefix length can be only 2 caracteres
            if (strlen($language->locale) < 2) {
                continue;
            }

            //see create_prefix from Falang_Core
            $prefix = '_' . $language->locale . '_';

            //delete post meta
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key like ( '" . $prefix . "%')"); // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared

            //delete post locale
            $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_locale' AND meta_value = '" . $prefix . "%'"); // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared

            //delete termmeta
            // Do nothing if the termmeta table does not exists
            if (count($wpdb->get_results("SHOW TABLES LIKE '$wpdb->termmeta'"))) {
                $wpdb->query("DELETE FROM {$wpdb->termmeta} WHERE meta_key like ( '" . $prefix . "%')"); // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared

            }
        }

        // Delete all what is related to languages and translations
        foreach (get_terms($falang_taxonomies, array('hide_empty' => false)) as $term) {
            $term_ids[] = (int)$term->term_id;
            $tt_ids[] = (int)$term->term_taxonomy_id;
        }

        if (!empty($term_ids)) {
            $term_ids = array_unique($term_ids);
            $wpdb->query("DELETE FROM {$wpdb->terms} WHERE term_id IN ( " . implode(',', $term_ids) . ' )'); // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared
            $wpdb->query("DELETE FROM {$wpdb->term_taxonomy} WHERE term_id IN ( " . implode(',', $term_ids) . ' )'); // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared
        }

        if (!empty($tt_ids)) {
            $tt_ids = array_unique($tt_ids);
            $wpdb->query("DELETE FROM {$wpdb->term_relationships} WHERE term_taxonomy_id IN ( " . implode(',', $tt_ids) . ' )'); // PHPCS:ignore WordPress.DB.PreparedSQL.NotPrepared
        }

        // Delete options
        delete_option('falang');
        delete_option('widget_falang'); // Automatically created by WP
        delete_option('falang_wpml_strings'); // Strings registered with icl_register_string
        delete_option('falang_dismissed_notices');//delete dismissed notices options


    }

    /**
     * Get option
     *
     * @param string $option_name . Option name
     * @param mixed $default . Default value if option does not exist
     * @return mixed
     *
     * @from 1.4.7
     */
    public function get_option($option_name, $default = false)
    {
        $options = get_option('falang');
        if (isset($options[$option_name])) {

            return $options[$option_name];

        }

        return $default;
    }

    /**
     * Get prefix for translation meta keys
     *
     * @from 1.0
     *
     * @param string $language_locale
     * @return string
     */
    public function get_prefix($locale)
    {

        return '_' . $locale . '_';

    }
}

new Falang_Uninstall();
