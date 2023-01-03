<?php

namespace Falang\Filter;

/**
 * Setup filters common to admin and site
 *
 * @since 1.2.3
 */

class Filters {

	var $falang = null;

	/**
	 * Constructor: setups filters
	 *
	 * @since 1.0
	 *
	 * @param object $falang
	 */
	public function __construct( &$falang ) {
		$this->falang = $falang;
	}

	/**
	 * Adds languages and translations columns in posts, pages, media, categories and tags tables
	 *
	 * @since 1.2.1
	 *
	 * @param array  $columns List of table columns
	 * @param string $before  The column before which we want to add our languages
	 * @return array modified list of columns
	 */
	protected function add_column( $columns, $before ) {
		if ( $n = array_search( $before, array_keys( $columns ) ) ) {
			$end = array_slice( $columns, $n );
			$columns = array_slice( $columns, 0, $n );
		}

		foreach ( Falang()->get_model()->get_languages_list(array('hide_default' => true)) as $language ) {
			$columns[ 'language_' . $language->locale ] = $language->get_flag();
		}

		return isset( $end ) ? array_merge( $columns, $end ) : $columns;
	}

}