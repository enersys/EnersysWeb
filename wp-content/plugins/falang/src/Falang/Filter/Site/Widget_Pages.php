<?php
namespace Falang\Filter\Site;


class Widget_Pages  {

	/**
	 * Constructor
	 *
	 * @since 1.3.6
	 *
	 */
	public function __construct( ) {

		//remove page due to language visibility
		add_filter( 'widget_pages_args', array( $this, 'widget_pages_args' ), 10, 2 );

	}

    /**
     * Sort menu items by menu order
     *
     * @since 1.3.1
     *
     * @param object $args The args,
     * @param object $instance The second object to compare
     * @return $args or 1 if $a is considered to be respectively less than or greater than $b.
     */
	public function widget_pages_args($args,$instance){
        $remove_language = $this->get_pages_to_excludes();
        $args['exclude'] = implode( ',', $remove_language );
	    return $args;
    }

    /*
     * Page to exclude are page with a specific language diffrents from the current language
     * @return @array of page id
     *
     * */
    private function get_pages_to_excludes(){
        $current_language =  Falang()->get_current_language();
	    $excludes = array();
        $args = array(
          'post_type' => 'page',
          'meta_key' => '_locale',
          'post_status' => 'publish',
        );
        $pages = get_pages($args);
        foreach ($pages as $page){
            if ($page->meta_value != $current_language->locale) {
                $excludes[] = $page->ID;
            }
        }
	    return $excludes;
    }




}