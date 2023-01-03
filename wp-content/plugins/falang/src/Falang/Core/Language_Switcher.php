<?php
/**
 * Created by PhpStorm.
 * User: Stéphane
 * Date: 25/06/2019
 * Time: 10:59
 */

namespace Falang\Core;


use Falang\Model\Falang_Model;

class Language_Switcher {

	var $params = '';

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct( $params = '' ) {
		$this->params = $params;
	}

	/**
	 * Returns options available for the language switcher - menu (or widget actually no)
	 * either strings to display the options or default values
	 *
	 * @since 1.3.1
	 *
	 * @param string $type optional either 'menu' or 'widget', defaults to 'widget'
	 * @param string $key  optional either 'string' or 'default', defaults to 'string'
	 * @return array list of switcher options strings or default values
	 */
	public static function get_switcher_options( $type = 'widget', $key = 'string' ) {
		$options = array(
			'dropdown'               => array( 'string' => __( 'Displays as a dropdown', 'falang' ), 'default' => 0 ),
			'display_name'             => array( 'string' => __( 'Displays language names', 'falang' ), 'default' => 1 ),
			'display_flags'             => array( 'string' => __( 'Displays flags', 'falang' ), 'default' => 0 ),
			'hide_current'           => array( 'string' => __( 'Hides the current language', 'falang' ), 'default' => 0 ),
		);

		return wp_list_pluck( $options, $key );
	}


	public function display_switcher() {
		$args = wp_parse_args( $this->params, array(
			'echo' => false,
		) );
        $width = Falang()->get_model()->get_option('flag_width','16');
        $height = Falang()->get_model()->get_option('flag_height','11');

        $hide_current = isset($this->params['hide_current'])?$this->params['hide_current']:false;

		$links = $this->get_links($hide_current);
		$total = count( $links );
		$output = '';

		//TODO use $total to display fist and last @see bogo
		foreach ($links as $link) {
			$class = array();
			$label = $link['native_name'] ? $link['native_name'] : $link['title'];
			$title = $link['title'];


			if ( get_locale() == $link['locale'] ) {
				$class[] = 'current';
			}

			if (isset($link['class'])){
			    $class[] = $link['class'];
            }

            //use custom flag if define
            if (($link['custom_flag']) && !empty($link['custom_flag'])) {
                $flag_url = $link['custom_flag'];
            } else {
                $file = FALANG_DIR . '/flags/' . $link['flag'] . '.png';
                if (!empty($link['flag']) && file_exists($file)) {
                    $flag_url = plugins_url('flags/' . $link['flag'] . '.png', FALANG_FILE);
                }
            }

			//if hide name reset it.
			if (!empty($this->params) &&  $this->params['display_name'] != '1') {
				$label = '';
			}

			$positioning_h = (!empty($this->params['positioning']))? $this->params['positioning'] == 'h':false;//true if horisontal

			$position_class = $positioning_h ? 'lang-h':'lang-v';

			//display flag
			if (!empty($this->params) &&  $this->params['display_flags'] == '1') {
				$li = sprintf(
					'<li><a class="%1$s" href="%2$s"><img src="%3$s" alt="%4$s" width="%5$spx" height="%6$spx"/>%7$s</a></li>',
					implode(" ", $class),
					$link['href'],
					$flag_url,
					$title,
					$width,
                    $height,
					$label)
				;
			} else {
				$li = sprintf( '<li><a class="%1$s" href="%2$s">%3$s</a></li>', implode(" ", $class), $link['href'] , $label);
			}

			$output .= $li . "\n";
		}

		$output = '<ul class="falang-language-switcher '. $position_class.'">' . $output . '</ul>' . "\n";

		//$output = apply_filters( 'falang_language_switcher', $output, $args );

		if ( $args['echo'] ) {
			echo $output;
		} else {
			return $output;
		}
	}

    /**
     * Get widget link
     *
     * @since 1.0
     * @since 1.3.20 fix notice on admin display widget
     * @since 1.3.24 add association link
     *
     * @param array $items menu items
     * @return array modified items
     */

	public function get_links($hide_current = false) {
		global $post;
		$links = array();
		//widget backend edtion don't hae real post
		if (isset($post->ID)){
            $falang_post = new Post($post->ID);
            $falang_post_locale = $falang_post->get_post_locale();
        } else {
            $falang_post_locale = 'all';//fix false local
        }

		//TODO Add filtering by publised langauge
		$languages = Falang()->get_model()->get_languages_list();
		$current_language = Falang()->get_current_language();

		foreach ( $languages as $language ) {

			if ($hide_current && ($current_language->locale == $language->locale)){
				continue;
			}

			$link = array(
				'locale'      => $language->locale,
				'slug'        => $language->slug,
				'title'       => $language->name,
				'native_name' => $language->name,
				'flag'        => $language->flag_code,
                'custom_flag'        => isset($language->custom_flag)?$language->custom_flag:'',
				'href'        => '',
			);

			if ($falang_post_locale == 'all'){
                $link['href'] = Falang()->get_translated_url( $language );
            } else {
			    if ($current_language->locale == $language->locale){
                    $link['href'] = Falang()->get_translated_url( $language );
                } else {
                    //look for an association for this langauge
			        //redirect to home page for page with specific locale
                    $association = Falang()->get_model()->get_option( 'association', false );
                    $assoc = get_post_meta($post->ID,'_falang_assoc_'.$language->locale,true);
                    if ($association && $assoc){
                        $associated_post = get_post($assoc);
                        Falang()->set_language($language);
                        $link['href'] = get_permalink(get_post($associated_post));
                        Falang()->set_language($current_language);
                    } else {
                    $link['href'] = $this->get_home_url($language);
                    }
                    $link['class']= 'hide-translation-on-page';//set this class on post set to specific language
                }
            }

			if (is_front_page()){
				$link['href'] = $this->get_home_url($language);
			}

			$links[] = $link;

		}

		return $links;
	}

	/**
	 * Returns the home url in the right language
	 * From polylang , use for homepage differents on languages
	 *
	 * @since 1.3.1
	 *
	 */
	public function get_home_url($language) {
		$site_url = get_site_url();
		$url = trailingslashit( $site_url );
		$default_locale = FALANG()->get_model()->get_default_locale();
		if ( get_option( 'permalink_structure' ) ) {
			if ( Falang()->get_model()->get_option( 'show_slug' ) || $default_locale != $language->locale ) {
				$url = $url . $language->slug . '/';
			}
		} else {
			if ( Falang()->get_model()->get_option( 'show_slug' ) || $default_locale != $language->locale ) {
				$url = add_query_arg( array( 'lang' => $language->slug ), $url );
			}
		}
		return $url;
	}


}