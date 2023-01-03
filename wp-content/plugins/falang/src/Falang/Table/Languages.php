<?php
/**
 * The file that defines the languages
 *
 * @link       www.faboba.com
 * @since      1.0.0
 *
 * @package    Falang
 */

namespace Falang\Table;

class Languages extends \WP_List_Table {

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct(
			array(
				'plural' => 'Languages', // Do not translate ( used for css class )
				'ajax'   => false,
			)
		);
	}

/**
 * Displays the item information in a column ( default case )
 *
 * @since 1.0
 *
 * @param object $item
 * @param string $column_name
 * @return string
 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'locale':
			case 'slug':
				return esc_html( $item->$column_name );

			case 'count':
				return (int) $item->$column_name;

			default:
				return $item->$column_name; // flag
		}
	}

	/**
	 * Displays the edit and delete action links in the column 'action'
	 *
	 * @since 1.0
	 *
	 * @param object $item
	 * @return string
	 */
	public function column_action( $item ) {
		$actions = array(
			'edit'   => sprintf(
				'<a title="%s" href="%s">%s</a>',
				esc_attr__( 'Edit this language', 'falang' ),
				esc_url( admin_url( 'admin.php?page=falang-language&amp;action=edit&amp;id=' . $item->term_id ) ),
				esc_html__( 'Edit', 'falang' )
			),
		);

		/**
		 * Filter the list of row actions in the languages list table
		 *
		 * @since 1.8
		 *
		 * @param array  $actions list of html markup actions
		 * @param object $item
		 */
		$actions = apply_filters( 'falang_languages_row_actions', $actions, $item );

		return $this->row_actions( $actions,true );

	}

    /**
     * Displays the sortable handle
     *
     * @since 1.3.9
     *
     * @param object $item
     * @return string
     */
    public function column_ordering( $item ) {
        return '<span class="falang-sortable-handle ui-sortable-handle"></span><input class="text-area-order type="text" name="order[]" style="display:none" value="'.$item->locale.'">';
    }
    /**
     * Displays the sortable handle
     *
     * @since 1.3.9
     * @update 1.3.10 return empty for undefine order
     *
     * @param object $item
     * @return string
     */
    public function column_order( $item ) {
        if (isset($item->order)){
            return esc_html( $item->order );
        } else {
            return '';
        }
	}

	/**
	 * Displays the item information in the column 'name'
	 *
	 * @since 1.0
	 *
	 * @param object $item
	 * @return string
	 */
	public function column_name( $item ) {
		return esc_html( $item->name );
	}

	/**
	 * Displays the item information in the column 'flag'
	 *
	 * @since 1.0
	 *
	 * @param object $item
	 * @return string
	 */
	public function column_flag( $item ) {
		//TODO it's not slug bug flag_code
		$flag_url ='';
		$file = FALANG_DIR.'/flags/' . $item->flag_code . '.png';
		if ( ! empty( $item->flag_code ) && file_exists( $file) ) {
			$flag_url = plugins_url( 'flags/'.$item->flag_code . '.png', FALANG_FILE );
		}

		return sprintf(
			'<img src="%1$s" alt="%2$s"/>',
			$flag_url,
			/* translators: accessibility text */
			esc_html( sprintf( __( 'Flags %s', 'falang' ), $item->name ) )
		);

	}

	/**
	 * Displays the item information in the default language
	 * Displays the 'make default' action link
	 *
	 * @since 1.8
	 *
	 * @param object $item
	 * @return string
	 */
	public function column_default_language( $item ) {
		$options = get_option( 'falang' );
		if ( $options['default_language'] != $item->locale ) {
			$s = sprintf(
				'<div class="row-actions"><span class="default-language">
				<a class="icon-default-language" title="%1$s" href="%2$s"><span class="screen-reader-text">%3$s</span></a>
				</span></div>',
				esc_attr__( 'Select as default language', 'falang' ),
				wp_nonce_url( '?page=falang-language&amp;action=default&amp;language=' . $item->term_id, 'default' ),
				/* translators: accessibility text, %s is a native language name */
				esc_html( sprintf( __( 'Choose %s as default language', 'falang' ), $item->name ) )
			);

			/**
			 * Filter the default language row action in the languages list table
			 * @param string $s    html markup of the action
			 * @param object $item
			 */
			$s = apply_filters( 'falang_default_lang_row_action', $s, $item );
		} else {
			$s = sprintf(
				'<span class="icon-default-language"><span class="screen-reader-text">%1$s</span></span>',
				/* translators: accessibility text */
				esc_html__( 'Default language', 'falang' )
			);
			$actions = array();
		}

		return $s;
	}

	/**
	 * Gets the list of columns
	 *
	 * @since 0.1
	 *
	 * @return array the list of column titles
	 */
	public function get_columns() {
		return array(
            'ordering'   => '',
            'order'        => _x( 'Order', 'falang' ),
			'flag'         => __( 'Flag', 'falang' ),
			'name'         => __( 'Name', 'falang' ),
			'locale'       => _x( 'Locale', 'falang' ),
			'slug'         => _x( 'Code', 'falang' ),
			'default_language' => __( 'Default', 'falang'),
			'count'        => _x( 'Posts', 'falang' ),
			'action'       => __( 'Action', 'falang' )
		);
	}

	/**
	 * Gets the name of the default primary column.
	 *
	 * @since 2.1
	 *
	 * @return string Name of the default primary column, in this case, 'name'.
	 */
	protected function get_default_primary_column_name() {
		return 'name';
	}

	/**
	 * Prepares the list of items for displaying
	 *
	 * @since 0.1
	 *
	 * @param array $data
	 */
	public function prepare_items( $data = array()) {
		$per_page = $this->get_items_per_page('falang_lang_per_page');
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

		//usort( $data, array( $this, 'usort_reorder' ) );

		$total_items = count( $data );
		$this->items = array_slice( $data, ( $this->get_pagenum() - 1 ) * $per_page, $per_page );

//		$this->set_pagination_args(
//			array(
//				'total_items' => $total_items,
//				'per_page'    => $per_page,
//				'total_pages' => ceil( $total_items / $per_page ),
//			)
//		);
	}


}