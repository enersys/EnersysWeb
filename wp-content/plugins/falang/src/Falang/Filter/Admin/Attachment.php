<?php
/**
 * Add Attachment translation for media
 *
 * @since 1.3.4
 */


namespace Falang\Filter\Admin;

use Falang\Core\Post;
use Falang\Filter\Filters;
use Falang\Core\Falang_Core;

class Attachment extends Filters {

    /**
     * @from 1.3.8
     */
    var $falang_data;

    public function __construct( &$falang )
    {
        parent::__construct($falang);

        $falang_post = new Post();

        if ($falang_post->is_post_type_translatable('attachment')){
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_media_scripts'));

            add_filter('ajax_query_attachments_args', array($this, 'ajax_query_attachments'));
            add_filter('wp_prepare_attachment_for_js', array($this, 'prepare_attachment_for_js'), 10, 3);
            add_filter('wp_insert_attachment_data', array($this, 'insert_attachment'), 10, 2);
            add_action('edit_attachment', array($this, 'edit_attachment'));

            // set attachment alt field translatable by default
            add_filter('falang_default-attachment', array($this, 'set_attachment_altfield_translatable'));

            // alt field always appear in option meta-data
            add_filter('falang_post_type_metakeys', array($this, 'attachment_post_type_metakeys'), 10, 2);

            // Adds the published field and translations tables in the 'Edit Media' panel
            add_filter( 'attachment_fields_to_edit', array( $this, 'attachment_fields_to_edit' ), 10, 2 );


        }
    }

    /**
     * Enqueue Javascript (only on post pages)
     *
     * @from 1.3.8
     */
    public function admin_enqueue_media_scripts($hook) {

        if (($hook == 'post.php' || $hook == 'post-new.php' || $hook == 'upload.php')) {

            wp_enqueue_media();

            wp_enqueue_script('falang-monkey-patch-wp-media', FALANG_ADMIN_URL. '/js/attachments.js');
            wp_enqueue_style('falang-style-wp-media', FALANG_ADMIN_URL . '/css/attachments.css');
        }

    }

    /**
     * Do not tanslate attachments queried by wp.media
     *
     * @filter 'ajax_query_attachments_args'
     *
     * @from 1.3.8
     */
    public function ajax_query_attachments($query) {

        $query[$this->falang->language_query_var] = false;

        return $query;
    }

    /**
     * set attachment alt meta key translatable by default
     *
     * @filter "falang_default-$post_type"
     * @from 1.3.8
     */
    public function set_attachment_altfield_translatable($defaults) {

        $defaults['meta_keys'][] = '_wp_attachment_image_alt';

        return $defaults;
    }

    /**
     * Always display alt field in attachment translation options
     *
     * @filter 'falang_post_type_metakeys'
     *
     * @from 1.3.8
     */
    public function attachment_post_type_metakeys($meta_keys, $post_type) {

        if ($post_type === 'attachment') {

            $meta_keys['_wp_attachment_image_alt'] = array('ALT field');

        }

        return $meta_keys;
    }

    /**
     * Send translation for javascript
     *
     * @filter 'wp_prepare_attachment_for_js'
     *
     * @from 1.3.8
     */
    public function prepare_attachment_for_js($response, $attachment, $meta) {

        $languages = $this->falang->get_model()->get_languages_list();
        $falang_post = new Post();

        foreach ($languages as $language) {

            $is_default = $this->falang->is_default($language);
            //TODO change get_post_meta_translation
            //$falang_post->get_post_meta_translation return the defalt valeu in this case it's must be return '' there are no callbacks
            if ($is_default){
                $alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true );
            } else {
                $alt = $falang_post->get_untranslated_post_meta($attachment->ID,Falang_Core::get_prefix( $language->locale ) .'_wp_attachment_image_alt', true);
            }

            //use slug in attachments.js for the array
            $response['falang'][$language->slug] = array(
                'published ' => $falang_post->get_untranslated_post_meta( $attachment->ID, Falang_Core::get_prefix( $language->locale ) . 'published', true ),
                'title' => $falang_post->translate_post_field($attachment, 'post_title', $language, $is_default ? $attachment->post_title : ''),
                'alt' => $alt,
                'caption' => $falang_post->translate_post_field($attachment, 'post_excerpt', $language, $is_default ? $attachment->post_excerpt : ''),
                'description' => $falang_post->translate_post_field($attachment, 'post_content', $language, $is_default ? $attachment->post_content : ''),
                'name' => $falang_post->translate_post_field($attachment, 'post_name', $language, $is_default ? $attachment->post_name : ''),
            );

        }

        return $response;

    }

    /**
     * When data are inserted from ajax, new data is filled on original attachment data.
     * Only field that actually changed should be updated.
     *
     * @filter 'wp_insert_attachment_data'
     *
     * @from 1.3.8
     */
    public function insert_attachment($data, $postarr) {

        if (defined( 'DOING_AJAX' ) && DOING_AJAX) {

            $this->fields = array();

            if (isset($_REQUEST['changes']['title'])) {

                $this->fields[] = 'post_title';

            }

            if (isset($_REQUEST['changes']['name'])) {

                $this->fields[] = 'post_name';

            }

            if (isset($_REQUEST['changes']['caption'])) {

                $this->fields[] = 'post_excerpt';

            }

            if (isset($_REQUEST['changes']['description'])) {

                $this->fields[] = 'post_content';

            }

        }

        return $this->insert_post($data, $postarr);
    }

    /**
     * Save translation data after attachment saves.
     * Hook for 'edit_attachment'
     *
     * @from 1.3.8
     */
    public function edit_attachment($post_id) {

        $this->save_translation_post_data($post_id, get_post($post_id));

    }


    /**
     * Save translation data after post saves.
     * Hook for 'save_post'
     *
     * @from 1.3.8
     */
    private function save_translation_post_data($post_id, $post) {

        $falang_post = new Post();

        if ($falang_post->is_post_type_translatable($post->post_type) && current_user_can('edit_post', $post_id)) {

            $language = $this->falang->get_current_language();

            if (!$this->falang->is_default($language) && isset($this->falang_data[$post_id][$language->locale])) {

                $this->update_post_translation($post_id, $this->falang_data[$post_id][$language->locale], $language);

            }

        }

    }

    /**
     * Restore main language post data before post saves.
     * Filter for 'wp_insert_post_data'
     *
     * @from 1.3.8
     */
    public function insert_post($data, $postarr) {

        if (!isset($data['post_type']) || !is_string($data['post_type'])) { // -> not sure if needed

            return $data;

        }

        if (isset($postarr['falang_gutenberg_metabox'])) {

            // @from 2.5 -> skip when gutenberg updates compat metaboxes
            return $data;

        }

        if ($data['post_type'] === 'revision') {

            $post = get_post($data['post_parent']);

        } else {

            $post = get_post($postarr['ID']);

        }

        $falang_post = new Post();

        if (!$this->falang->is_default() && $falang_post->is_post_type_translatable($post->post_type) && empty($this->falang_data[$post->ID])) {

            // @from 2.6 -> skip if falang_data already exists (when parsing revision data except autosave)
            $language = $this->falang->get_current_language();

            // set default post name
            if ($data['post_title'] == '') {

                if (empty($_POST['post_name']) || $_POST['post_name'] == '') {

                    if ($post->post_name) {

                        $data['post_name'] = $post->post_name;

                    } else if ($post->post_title) {

                        $data['post_name'] = sanitize_title($post->post_title);

                    }

                }

            } else if ($data['post_name'] == '') {

                $data['post_name'] = sanitize_title($data['post_title']);

            }

            foreach ($this->fields as $field) {

                // store translated data
                $this->falang_data[$post->ID][$language->locale][$field] = $data[$field];

                // and restore original data
                $data[$field] = wp_slash($post->$field);

            }

        }

        return $data;

    }


    /**
     * Update post translation
     *
     * @param int $post_id Post ID
     * @param array $data {
     *		List of field to save.
     *		@string $post_name Post name
     *		@string $post_title Post title
     *		@string $post_content Post content
     *		@string $post_excerpt Post excerpt
     *		@string $custom_meta_key Post meta
     * }
     * @param object WP_Post $language Language. Optional
     *
     * @from 1.3.8
     */
    public function update_post_translation($post_id, $data, $language) {

        if (!$this->falang->is_default($language)) {

            foreach ($data as $field => $value) {

                if (in_array($field, $this->fields)) {

                    /**
                     * Filter before a translation field is updated.
                     * @param int $post_id. Original post id.
                     * @param string $field. Field name.
                     * @param string $value. Value.
                     *
                     * @from 2.0
                     */
                    update_post_meta($post_id, Falang_Core::get_prefix($language->locale).$field, apply_filters('falang_admin_update_post', $value, $post_id, $field, $language, $this));

                }

            }

        }

    }

    /**
     * Adds the language field and translations tables in the 'Edit Media' panel
     * Needs WP 3.5+
     *
     * @since 1.3.8
     *
     * @param array  $fields list of form fields
     * @param object $post
     * @return array modified list of form fields
     */
    public function attachment_fields_to_edit( $fields, $post ) {
        if ( 'post.php' == $GLOBALS['pagenow'] ) {
            return $fields; // Don't add anything on edit media panel for WP 3.5+ since we have the metabox
        }

        $post_id = $post->ID;

        $fields['published']=  array(
            'label' => __( 'Published', 'falang' ),
            'input' => 'html',
            'html' => esc_html__('Publish/Unpublish need to be done in the Falang Translation Post page','falang')
        );

        return $fields;
    }

    /**
     * Called when a media is saved
     * Saves language and translations
     *
     * @since 1.3.8
     *
     * @param array $post
     * @param array $attachment
     * @return array unmodified $post
     */
    public function save_media( $post, $attachment ) {

        return $post;
    }

}