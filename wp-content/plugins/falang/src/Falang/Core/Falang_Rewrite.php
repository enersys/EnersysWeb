<?php
/**
 * Created by PhpStorm.
 * User: Stéphane
 * Date: 12/09/2019
 * Time: 16:03
 */

namespace Falang\Core;

use Falang\Core\Falang_Core;
use WP_Query;


class Falang_Rewrite extends  Falang_Core {

	/**
	 * @from 1.0
	 */
	var $rewritable_post_types = array();

	/**
	 * @from 1.0
	 */
	var $rewritable_taxonomies = array();

	/**
	 * @from 1.0
	 */
	public function load() {

		parent::load();

		add_filter('register_post_type_args', array($this, 'register_post_type_args'), 10, 2);
		add_action('registered_post_type', array($this, 'registered_post_type'), 10, 2);

		add_filter('register_taxonomy_args', array($this, 'register_taxonomy_args'), 10, 2);
		add_action('registered_taxonomy', array($this, 'registered_taxonomy'), 10, 3);

		// rewrite pages
		add_filter('page_rewrite_rules', array($this, 'page_rewrite_rules'));

		// Append language slugs to every rules
		add_filter('rewrite_rules_array', array($this, 'append_language_slugs'), 12);

	}

	/**
	 * Shortcut cpt rule generation
	 *
	 * @filter 'register_post_type_args'
	 * @from 1.0
	 * @since 1.3.3 fix has_archive notice undefined.  change the get_option and add is_admin see -> WP_Post_Type::set_props()
     * @since 1.3.12 also activate when rewrite is not set
	 */
	public function register_post_type_args($args, $post_type) {
		$falang_post= new Post();

		if ($falang_post->is_post_type_translatable($post_type) && (!isset($args['rewrite']) || $args['rewrite'] !== false) && get_option('permalink_structure') != '' ) {

			// -> WP_Post_Type::set_props()
            if (!isset($args['rewrite']) || !is_array( $args['rewrite'] ) ) {
				$args['rewrite'] = array();
			}
			if ( empty( $args['rewrite']['slug'] ) ) {
				$args['rewrite']['slug'] = $post_type;
			}
			if ( ! isset( $args['rewrite']['with_front'] ) ) {
				$args['rewrite']['with_front'] = true;
			}
			if ( ! isset( $args['rewrite']['pages'] ) ) {
				$args['rewrite']['pages'] = true;
			}
			if ( ! isset( $args['rewrite']['feeds'] ) || ! $args['has_archive'] ) {
				//1.3.3 fix the has_archive not defined // set default to false
				if (!isset($args['has_archive'])){$args['has_archive'] = false;}
				$args['rewrite']['feeds'] = (bool) $args['has_archive'];
			}
			if ( ! isset( $args['rewrite']['ep_mask'] ) ) {
				if ( isset( $args['permalink_epmask'] ) ) {
					$args['rewrite']['ep_mask'] = $args['permalink_epmask'];
				} else {
					$args['rewrite']['ep_mask'] = EP_PERMALINK;
				}
			}

			$this->rewritable_post_types[$post_type] = $args['rewrite'];

			$args['rewrite'] = false; // fake it to skip normal rules generation

		}

		return $args;

	}

	/**
	 * Translate custom post type rewrite rules.
	 * See WP_Post_Type::add_rewrite_rules()
	 *
	 * @hook 'registered_post_type'
	 * @from 1.0
     * @since 1.3.27 remove permastruct
	 */
	public function registered_post_type($post_type, $post_type_obj) {
		global $wp_rewrite;
		$falang_post = new Post();

		if (isset($this->rewritable_post_types[$post_type])) {

			$post_type_obj->rewrite = $this->rewritable_post_types[$post_type];
			$post_type_obj->rewrite['walk_dirs'] = false;

			$translation_slugs = array();

			foreach ($this->model->get_languages_list() as $language) {

				$translation_slugs[] = $falang_post->translate_cpt($post_type, $language, $post_type);

			}

			$translation_slugs = array_unique($translation_slugs);

			$translation_slug = '(' . implode('|', $translation_slugs) . ')';

            add_rewrite_tag( "%$post_type-slug%", $translation_slug, "falang_slug=" );


			if ( $post_type_obj->hierarchical ) {
				add_rewrite_tag( "%$post_type%", '(.+?)', $post_type_obj->query_var ? "{$post_type_obj->query_var}=" : "post_type=$post_type&pagename=" );
			} else {
				add_rewrite_tag( "%$post_type%", '([^/]+)', $post_type_obj->query_var ? "{$post_type_obj->query_var}=" : "post_type=$post_type&name=" );
			}

			if ( $post_type_obj->has_archive ) {

				foreach ($this->model->get_languages_list() as $language) {

					$archive_slugs[] = $falang_post->translate_cpt_archive($post_type, $language);

				}

				$archive_slugs = array_unique($archive_slugs);

				$archive_slug = '(' . implode('|', $archive_slugs) . ')';

				if ( $post_type_obj->rewrite['with_front'] ) {
					$archive_slug = substr( $wp_rewrite->front, 1 ) . $archive_slug;
				} else {
					$archive_slug = $wp_rewrite->root . $archive_slug;
				}

				add_rewrite_rule( "{$archive_slug}/?$", 'index.php?post_type='.$post_type.'&falang_slug=$matches[1]', 'top' );
				if ( $post_type_obj->rewrite['feeds'] && $wp_rewrite->feeds ) {
					$feeds = '(' . trim( implode( '|', $wp_rewrite->feeds ) ) . ')';
					add_rewrite_rule( "{$archive_slug}/feed/$feeds/?$", 'index.php?post_type='.$post_type.'&falang_slug=$matches[1]&feed=$matches[2]', 'top' );
					add_rewrite_rule( "{$archive_slug}/$feeds/?$", 'index.php?post_type='.$post_type.'&falang_slug=$matches[1]&feed=$matches[2]', 'top' );
				}
				if ( $post_type_obj->rewrite['pages'] ) {
					add_rewrite_rule( "{$archive_slug}/{$wp_rewrite->pagination_base}/([0-9]{1,})/?$", 'index.php?post_type='.$post_type.'&falang_slug=$matches[1]&paged=$matches[2]', 'top' );
				}
			}

			$permastruct_args = $post_type_obj->rewrite;
			$permastruct_args['feed'] = $permastruct_args['feeds'];

			//specific case when wc product is set to shop base with category
            // Fix the rewrite rules when the product permalink have %product_cat% flag.
            //TODO find a better place to add it
			if ($post_type == 'product' && preg_match( '`/(.+)(/%product_cat%)`', $translation_slug, $matches)){
			    //fix the permalink in admin product page -- seem not necessary only not add the default with the
                //add_permastruct($post_type,  "$translation_slugs[0]/%$post_type%", $permastruct_args);
                //add rules to manage shop category product page
                add_rewrite_rule( "{$archive_slug}/(.+?)/([^/]+)(?:/([0-9]+))?/?$", 'index.php?product_cat=$matches[2]&'.$post_type.'=$matches[3] ', 'top' );
            } else {

               add_permastruct($post_type, "%$post_type-slug%/%$post_type%", $permastruct_args);

               //1.3.27 remove permastruct for bwp footer (wpbingo)
                if ('bwp_footer' == $post_type){
                    remove_permastruct($post_type);
                }
            }

			// -> Get ride of attachment rules
			add_filter($post_type.'_rewrite_rules', array($this, 'drop_cpt_attachment_rules'));

		}

	}

	/**
	 * Get ride of attachment rules: buggy and useless!
	 *
	 * @filter "{$permastructname}_rewrite_rules"
	 * @from 1.0
	 */
	public function drop_cpt_attachment_rules($rules) {

		$new_rules = array();

		foreach ($rules as $match => $rewrite) {

			if (!preg_match('/(?:\?|&)attachment=/', $rewrite)) {

				$new_rules[$match] = $rewrite;

			}

		}

		return $new_rules;
	}

	/**
	 * Shortcut taxonomy rule generation
	 *
	 * @filter 'register_taxonomy_args'
	 * @from 1.0
	 */
	public function register_taxonomy_args($args, $taxonomy) {

		$falang_taxonomy = new Taxonomy();

		if ($falang_taxonomy->is_taxonomy_translatable($taxonomy) && (!isset($args['rewrite']) || $args['rewrite'] !== false) && get_option('permalink_structure') != '') {

			if (!isset($args['rewrite'])) {

				$args['rewrite'] = $taxonomy;

			}

			$args['rewrite'] = wp_parse_args( $args['rewrite'], array(
				'with_front'   => true,
				'hierarchical' => false,
				'ep_mask'      => EP_NONE,
			) );

			if ( empty( $args['rewrite']['slug'] ) ) {
				$args['rewrite']['slug'] = sanitize_title_with_dashes($taxonomy);
			}

			$this->rewritable_taxonomies[$taxonomy] = $args['rewrite'];

			$args['rewrite'] = false; // fake it to skip normal rules generation

		}

		return $args;
	}

	/**
	 * Translate taxonomy rewrite rules.
	 * Bypass: WP_Taxonomy::add_rewrite_rules()
	 *
	 * @hook 'registered_taxonomy'
	 * @from 1.0
	 */
	public function registered_taxonomy($taxonomy, $object_type, $taxonomy_obj) {
		global $wp, $wp_taxonomies;
		$falang_taxo = new Taxonomy();

		if (isset($this->rewritable_taxonomies[$taxonomy])) {

			$taxonomy_obj['rewrite'] = $this->rewritable_taxonomies[$taxonomy]; // why is $taxonomy_obj an array!?
			$taxonomy_obj['rewrite']['walk_dirs'] = false;

			if ($taxonomy_obj['hierarchical'] && $taxonomy_obj['rewrite']['hierarchical']) {
				$tag = '(.+?)'; // -> not supported yet!!
			} else {
				$tag = '([^/]+)';
			}

			$translation_slugs = array();

			foreach ($this->model->get_languages_list() as $language) {

				$translation_slugs[] = $falang_taxo->translate_taxonomy($taxonomy, $language, $taxonomy);

			}

			$translation_slugs = array_unique($translation_slugs);

			$translation_slug = '(' . implode('|', $translation_slugs) . ')';

			add_rewrite_tag( "%$taxonomy-slug%", $translation_slug, 'falang_slug=' );
			add_rewrite_tag( "%$taxonomy%", $tag, $taxonomy_obj['query_var'] ? $taxonomy_obj['query_var'].'=' : "taxonomy=$taxonomy&term=" );

			add_permastruct( $taxonomy, "%$taxonomy-slug%/%$taxonomy%", $taxonomy_obj['rewrite'] );

			// set back the original rewrite properties
			$wp_taxonomies[$taxonomy]->rewrite = $taxonomy_obj['rewrite'];

		}

	}

	/**
	 * Overwrite page rules to bypass WP "verbose page rules", because get_page_by_path() is impossible to hook into.
	 *
	 * @filter 'page_rewrite_rules'
	 * @from 1.0
     * @from 1.3.14 fix page pagination
	 */
	public function page_rewrite_rules($rules) {
		global $wp_rewrite, $wpdb;
		$falang_post = new Post();

		if ($falang_post->is_post_type_translatable('page')) {

			$page_query = new WP_Query(array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_parent' => 0,
				'posts_per_page' => -1,
				'post__not_in' => array_filter(array_map('intval', array(
//					get_option('page_for_posts'), //1.3.5 need to be rewrite or 404
					get_option('page_on_front')
				))),
				$this->language_query_var => false
			));

			$duplicate_rules = array();

			foreach ($page_query->posts as $page) {

				$slugs = array();
				//need to load the right post to know if published
				$falang_post = new Post($page->ID);

				foreach ($this->model->get_languages_list() as $language) {

					if ($falang_post->is_published($language->locale)){
						$translated_slug = $falang_post->translate_post_field($page, 'post_name', $language);
					} else {
						$translated_slug = $page->post_name;
					}

					if (!in_array($translated_slug, $slugs)) {

						$slugs[] = $translated_slug;

					}

				}

				if ($slugs) {

					$regex_base = '((?:'.implode('|', $slugs).').*?)';

					if (!empty($wp_rewrite->endpoints)) {

						foreach ($wp_rewrite->endpoints as $ep) {

							if ($ep[0] & EP_PAGES) {

								$epregex = $regex_base . '/' . $ep[1] . '(/(.*))?/?$';
								$duplicate_rules[$epregex] =  $wp_rewrite->index . '?falang_page=$matches[1]&'.$ep[2].'=$matches[3]';

							}

						}

					}

					if (apply_filters('falang_page_use_feeds', false)) {

						$feedregex = '(' . implode('|', (array) $wp_rewrite->feeds) . ')/?$';
						$feedregex1 = $regex_base . '/' . $wp_rewrite->feed_base . '/' . $feedregex;
						$feedregex2 = $regex_base . '/' . $feedregex;

						$duplicate_rules[$feedregex1] = $wp_rewrite->index . '?falang_page=$matches[1]&feed=$matches[2]';
						$duplicate_rules[$feedregex2] = $wp_rewrite->index . '?falang_page=$matches[1]&feed=$matches[2]';

					}

					if (apply_filters('falang_page_use_comment_pagination', false)) {

						$commentregex = $regex_base . '/' . $wp_rewrite->comments_pagination_base . '-([0-9]{1,})/?$';
						$duplicate_rules[$commentregex] =  $wp_rewrite->index . '?falang_page=$matches[1]&cpage=$matches[2]';

					}

					if (apply_filters('falang_page_use_trackback', false)) {

						$trackbackregex = $regex_base . '/trackback/?$';
						$duplicate_rules[$trackbackregex] =  $wp_rewrite->index . '?falang_page=$matches[1]&tb=1';

					}

					if (apply_filters('falang_page_use_embed', false)) {

						$embedregex = $regex_base . '/embed/?$';
						$duplicate_rules[$embedregex] =  $wp_rewrite->index . '?falang_page=$matches[1]&embed=true'; // sic!

					}

					if (apply_filters('falang_page_use_pagination', false)) {

						$pageregex = $regex_base . '/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?$';
                        $duplicate_rules[$pageregex] =  $wp_rewrite->index . '?falang_page=$matches[1]&paged=$matches[2]';

						//$regex = $regex_base . '(?:/([0-9]+))?/?$';
                        //$duplicate_rules[$regex] =  $wp_rewrite->index . '?falang_page=$matches[1]&page=$matches[2]';
                        $regex = $regex_base . '/?$';
                        $duplicate_rules[$regex] = $wp_rewrite->index . '?falang_page=$matches[1]';

					} else {

						$regex = $regex_base . '/?$';
						$duplicate_rules[$regex] =  $wp_rewrite->index . '?falang_page=$matches[1]';

					}

				}

			}

			$rules = array_merge($duplicate_rules, $rules);

		}

		return $rules;
	}

	/**
	 * Append language slugs to every rules
	 *
	 * @filter 'rewrite_rules_array'
	 * @from 1.0
	 */
	public function append_language_slugs($rules) {

		$language_slugs = array();

		foreach ($this->model->get_languages_list() as $language) {

			$language_slugs[] = $language->slug;

		}

		$new_rules = array();

		$new_rules['(?:' . implode('|', $language_slugs) . ')/?$'] = 'index.php'; // -> rule for home

		$languages_slug = '(?:' . implode('/|', $language_slugs) . '/)?';

		$black_list = array(
// 			'^wp-json/?$',
// 			'^wp-json/(.*)?',
			'^index.php/wp-json/?$',
			'^index.php/wp-json/(.*)?'
		);

		foreach ($rules as $key => $rule) {

			if (in_array($key, $black_list)) { // -> REST API?

				$new_rules[$key] = $rule;

			} else if (substr($key, 0, 1) === '^') { // -> get ride of the leading ^

				$new_rules[$languages_slug . substr($key, 1)] = $rule;

			} else {

				$new_rules[$languages_slug . $key] = $rule;

			}

		}

		return $new_rules;
	}


}