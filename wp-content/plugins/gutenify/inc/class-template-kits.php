<?php
/**
 * Template Kits functions.
 *
 * @package Gutenify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Gutenify_Rest
 */
class Gutenify_Template_Kits {
	public $current_stylesheet = '';

	function __construct() {
		$this->current_stylesheet = wp_get_theme()->get_stylesheet();
	}

	public function add_kit( $kit ) {
		$response = false;
		if ( ! empty( $kit['name'] ) ) {
			$posts = get_posts(
				array(
					'post_type'  => 'gutenify_kit',
					'meta_query' => array(
						array(
							'key'   => 'kit_name',
							'value' => $kit['name'],
						),
					),
				)
			);
			if ( empty( $posts ) ) {
				$my_post              = array(
					'post_title'  => wp_strip_all_tags( $kit['title'] ),
					'post_status' => 'publish',
					'post_type'   => 'gutenify_kit',
				);
				$post_id              = wp_insert_post( $my_post );
				$local_template_parts = array();
				if ( ! is_wp_error( $post_id ) ) {
					update_post_meta( $post_id, 'kit_name', $kit['name'] );
				}
			} else {
				$post_id = $posts[0]->ID;
			}

			if ( $post_id > 0 ) {
				$selected_navigations = ! empty( $kit['navigations'] ) ? $kit['navigations'] : array();
				$selected_parts       = ! empty( $kit['template_parts'] ) ? $kit['template_parts'] : array();
				$selected_templates   = ! empty( $kit['templates'] ) ? $kit['templates'] : array();
				$selected_demo_pages  = ! empty( $kit['demo_pages'] ) ? $kit['demo_pages'] : array();
				$selected_home_page  = ! empty( $kit['staticHomePage'] ) ? $kit['staticHomePage'] : false;

				$response['navigations']    = $this->add_navigations( $selected_navigations, $post_id );
				$response['template_parts'] = $this->add_template_parts( $selected_parts, $post_id );
				$response['templates']      = $this->add_templates( $selected_templates, $post_id );
				$response['demo_pages']     = $this->add_demo_pages( $selected_demo_pages, $post_id );
				if ( $selected_home_page ) {
					$response['static_homepage']     = $this->add_static_homepage( $selected_home_page, $post_id, $response['demo_pages'] );
				}
			}

			return $response;
		}

		return $response;
	}

	public function add_demo_pages( $items, $kit_id ) {
		// Demo pages.
		$demo_page_data = array();
		if ( ! empty( $items ) ) {

			$metadata   = get_post_meta( $kit_id );
			$_templates = array();
			if ( ! empty( $metadata['kit_templates'][0] ) ) {
				$_templates = json_decode( $metadata['kit_templates'][0] );
			}
			$templates = array();
			if ( ! empty( $_templates ) ) {
				foreach ( $_templates as $template ) {
					$templates[ $template->slug ] = (array) $template;
				}
			}
			foreach ( $items as $demo_page ) {

				$template = ! empty( $templates[ $demo_page['page_template'] ]['wp_slug'] ) ? $templates[ $demo_page['page_template'] ]['wp_slug'] : $demo_page['page_template'];

				$post_data = array(
					'post_title'   => $demo_page['title'] ? wp_strip_all_tags( $demo_page['title'] ) : '',
					'post_name'    => $demo_page['slug'],
					'post_status'  => 'publish',
					'post_type'    => ! empty( $demo_page['post_type'] ) ? $demo_page['post_type'] : 'page',
					'post_content' => $demo_page['content'],
				);

				$id = wp_insert_post( wp_slash( (array) $post_data ), true );
				if ( ! is_wp_error( $id ) ) {
					$post                 = get_post( $id );
					$demo_page['wp_id']   = $id;
					$demo_page['wp_slug'] = $post->post_name;
					$demo_page['content'] = htmlentities( $demo_page['content'] );

					$demo_page_data[] = $demo_page;

					if ( ! empty( $template ) ) {
						update_post_meta( $id, '_wp_page_template', $template );
					}

					if ( ! empty( $demo_page['custom_css'] ) ) {
						update_post_meta( $id, 'gutenify_custom_css', gutenify_minimize_css_simple( $demo_page['custom_css'] ) );
					}
				}
			}
		}
		update_post_meta( $kit_id, 'kit_templates', wp_json_encode( $demo_page_data ) );
		return $demo_page_data;
	}

	public function add_template( $template, $parts = array() ) {
		if ( ! empty( $template ) ) {
			$template_data = get_block_templates(
				array(
					'slug__in' => array( $template['slug'] ),
				)
			);

			$theme = wp_get_theme();
			$slug = $theme->template;
			$content = html_entity_decode( $template['content'] );
			$content = str_replace( '[current-theme-slug]', $slug, $content );

			if ( ! empty( $template['has_header'] ) ) {
				$header_slug = ! empty( $template['header_slug'] ) && ! empty( $parts[ $template['header_slug'] ] ) ? $parts[ $template['header_slug'] ]['wp_slug'] : 'header';
				if ( ! empty( $header_slug ) ) {
					$content = '<!-- wp:template-part {"slug":"' . $header_slug . '","theme":"' . $this->current_stylesheet . '","tagName":"header"} /-->' . $content;
				}
			}

			if ( ! empty( $template['has_footer'] ) ) {
				$footer_slug = ! empty( $template['footer_slug'] ) && ! empty( $parts[ $template['footer_slug'] ] ) ? $parts[ $template['footer_slug'] ]['wp_slug'] : 'footer';

				if ( ! empty( $footer_slug ) ) {
					$content = $content . '<!-- wp:template-part {"slug":"' . $footer_slug . '","theme":"' . $this->current_stylesheet . '","tagName":"footer"} /-->';
				}
			}

			$post_data = array(
				'post_title'   => $template['title'] ? wp_strip_all_tags( $template['title'] ) : '',
				'post_name'    => $template['slug'],
				'post_status'  => 'publish',
				'post_type'    => 'wp_template',
				'post_content' => $content,
				'tax_input'    => array(
					'wp_theme' => $this->current_stylesheet,
				),
			);

			if ( ! empty( $template_data ) ) {
				$post_data['post_title'] = $template_data[0]->title;
				if ( null !== $template_data[0]->wp_id ) {
					$post_data['ID'] = $template_data[0]->wp_id;
				}
			}

			if ( ! empty( $template['wp_id'] ) && ! empty( get_post( $template['wp_id'] ) ) ) {
				$post_data['ID'] = $template['wp_id'];
			}

			$id = wp_insert_post( wp_slash( (array) $post_data ), true );
			if ( ! is_wp_error( $id ) ) {
				$post                = get_post( $id );
				$template['wp_id']   = $id;
				$template['wp_slug'] = $post->post_name;
				$template['content'] = htmlentities( $template['content'] );
			}
		}
		return $template;
	}

	public function add_templates( $items, $kit_id ) {
		$metadata = get_post_meta( $kit_id );
		$_parts   = array();
		if ( ! empty( $metadata['kit_parts'][0] ) ) {
			$_parts = json_decode( $metadata['kit_parts'][0] );
		}
			$parts = array();
		if ( ! empty( $_parts ) ) {
			foreach ( $_parts as $part ) {
				$parts[ $part->slug ] = (array) $part;
			}
		}

		if ( ! empty( $metadata['kit_templates'][0] ) ) {
			$db_items = json_decode( $metadata['kit_templates'][0] );
			if ( ! empty( $db_items ) ) {
				foreach ( $db_items as $db_item ) {
					$db_item = (array) $db_item;
					if ( ! empty( $items ) ) {
						foreach ( $items as $key => $_item ) {
							if ( $_item['slug'] === $db_item['slug'] ) {
								$items[ $key ]['wp_id']   = $db_item['wp_id'];
								$items[ $key ]['wp_slug'] = $db_item['wp_slug'];
							}
						}
					}
				}
			}
		}

		if ( ! empty( $items ) ) {
			$items_data = array();
			foreach ( $items as $item ) {
				$item                                  = (array) $item;
				$item                                  = $this->add_template( (array) $item, (array) $parts );
				$items_data[]                          = $item;
				$local_template_parts[ $item['slug'] ] = $item;
			}
			update_post_meta( $kit_id, 'kit_templates', wp_json_encode( $items_data ) );
		}
		return $items_data;
	}

	public function add_template_part( $part, $navigations ) {
		if ( ! empty( $part ) ) {
			$content = html_entity_decode( $part['content'] );

			if ( ! empty( $navigations ) ) {
				foreach ( $navigations as $nav_slug => $navigation ) {
					$content = str_replace( '[nav-ref:' . $nav_slug . ']', '"ref":' . $navigation['wp_id'], $content );
				}
			}

			$part_data = array(
				'post_title'   => wp_strip_all_tags( $part['title'] ),
				'post_name'    => $part['slug'],
				'post_status'  => 'publish',
				'post_type'    => 'wp_template_part',
				'post_content' => $content,
				'tax_input'    => array(
					'wp_template_part_area' => _filter_block_template_part_area( $part['area'] ),
					'wp_theme'              => $this->current_stylesheet,
				),
			);

			if ( ! empty( $part['wp_id'] ) && ! empty( get_post( $part['wp_id'] ) ) ) {
				$part_data['ID'] = $part['wp_id'];
			}

			$id = wp_insert_post( wp_slash( (array) $part_data ), true );
			if ( ! is_wp_error( $id ) ) {
				$post            = get_post( $id );
				$part['wp_id']   = $id;
				$part['wp_slug'] = $post->post_name;
				$part['content'] = htmlentities( $part['content'] );
			}
			return $part;
		}
	}

	public function add_template_parts( $selected_parts, $kit_id ) {
		$metadata = get_post_meta( $kit_id );

		$_navigations = array();
		if ( ! empty( $metadata['kit_navigations'][0] ) ) {
			$_navigations = json_decode( $metadata['kit_navigations'][0] );
		}
		$navigations = array();
		if ( ! empty( $_navigations ) ) {
			foreach ( $_navigations as $navigation ) {
				$navigations[ $navigation->slug ] = (array) $navigation;
			}
		}

		$parts = $selected_parts;
		if ( ! empty( $metadata['kit_parts'][0] ) ) {
			$db_parts = json_decode( $metadata['kit_parts'][0] );
			if ( ! empty( $db_parts ) ) {
				foreach ( $db_parts as $db_part ) {
					$db_part = (array) $db_part;
					if ( ! empty( $parts ) ) {
						foreach ( $parts as $key => $_part ) {
							if ( $_part['slug'] === $db_part['slug'] ) {
								$parts[ $key ]['wp_id']   = $db_part['wp_id'];
								$parts[ $key ]['wp_slug'] = $db_part['wp_slug'];
							}
						}
					}
				}
			}
		}

		$parts_data = array();
		if ( ! empty( $parts ) ) {
			foreach ( $parts as $part ) {
				$part                                  = $this->add_template_part( (array) $part, $navigations );
				$parts_data[]                          = $part;
				$local_template_parts[ $part['slug'] ] = $part;
			}
		}
		update_post_meta( $kit_id, 'kit_parts', wp_json_encode( $parts_data ) );
		return $parts_data;
	}


	public function add_navigation( $item, $parts = array() ) {
		if ( ! empty( $item ) ) {
			$item_data = get_block_templates(
				array(
					'slug__in' => array( $item['slug'] ),
				)
			);

			$content = html_entity_decode( $item['content'] );

			$post_data = array(
				'post_title'   => $item['title'] ? wp_strip_all_tags( $item['title'] ) : '',
				'post_name'    => $item['slug'],
				'post_status'  => 'publish',
				'post_type'    => 'wp_navigation',
				'post_content' => $content,
				'tax_input'    => array(
					'wp_theme' => $this->current_stylesheet,
				),
			);

			if ( ! empty( $item_data ) ) {
				$post_data['post_title'] = $item_data[0]->title;
				if ( null !== $item_data[0]->wp_id ) {
					$post_data['ID'] = $item_data[0]->wp_id;
				}
			}

			if ( ! empty( $item['wp_id'] ) && ! empty( get_post( $item['wp_id'] ) ) ) {
				$post_data['ID'] = $item['wp_id'];
			}

			$id = wp_insert_post( wp_slash( (array) $post_data ), true );
			if ( ! is_wp_error( $id ) ) {
				$post            = get_post( $id );
				$item['wp_id']   = $id;
				$item['wp_slug'] = $post->post_name;
				$item['content'] = htmlentities( $item['content'] );
			}
		}
		return $item;
	}

	public function add_navigations( $selected_navigations, $kit_id ) {
		$metadata = get_post_meta( $kit_id );
		$items    = $selected_navigations;
		if ( ! empty( $metadata['kit_navigations'][0] ) ) {
			$db_items = json_decode( $metadata['kit_navigations'][0] );
			if ( ! empty( $db_items ) ) {
				foreach ( $db_items as $item ) {
					$item = (array) $item;
					if ( ! empty( $items ) ) {
						foreach ( $items as $key => $_item ) {
							if ( $_item['slug'] === $item['slug'] ) {
								$items[ $key ]['wp_id']   = $item['wp_id'];
								$items[ $key ]['wp_slug'] = $item['wp_slug'];
							}
						}
					}
				}
			}
		}

		$parts_data = array();
		if ( ! empty( $items ) ) {
			foreach ( $items as $item ) {
				$item         = $this->add_navigation( (array) $item );
				$items_data[] = $item;
			}
		}
		update_post_meta( $kit_id, 'kit_navigations', wp_json_encode( $items_data ) );
		return $items_data;
	}

	public function add_static_homepage( $slug, $kit_id, $demo_pages = array() ) {
		if ( ! empty( $demo_pages ) ) {
			foreach( $demo_pages as $page ) {
				if ( $page['slug'] === $slug && '' !== $page['wp_id'] ) {
					update_option( 'page_on_front', $page['wp_id'] );
					update_option( 'show_on_front', 'page' );
					return $page;
				}
			}
		}
	}
}
