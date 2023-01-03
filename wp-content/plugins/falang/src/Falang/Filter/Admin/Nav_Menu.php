<?php

namespace Falang\Filter\Admin;

use Falang\Core\Language_Switcher;

class Nav_Menu {

	/**
	 * Constructor
	 *
	 * @since 1.3.1
	 *
	 */
	public function __construct( ) {

		//TODO to parent ?
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'wp_setup_nav_menu_item' ) );


		// Integration in the WP menu interface
		add_action( 'admin_init', array( $this, 'admin_init' ) ); // after Polylang upgrade

	}

	/**
	 * adds the language switcher metabox and create new nav menu locations
	 *
	 * @since 1.3.1
	 */
	public function admin_init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_update_nav_menu_item', array( $this, 'wp_update_nav_menu_item' ), 10, 2 );

		// COMENT from polylang
		// FIXME is it possible to choose the order ( after theme locations in WP3.5 and older ) ?
		// FIXME not displayed if Falang is activated before the first time the user goes to nav menus http://core.trac.wordpress.org/ticket/16828
		add_meta_box( 'falang_lang_switch_box', __( 'Language switcher', 'falang' ), array( $this, 'language_switcher' ), 'nav-menus', 'side', 'high' );

	}

	/**
	 * Language switcher metabox from polylang
	 * The checkbox and all hidden fields are important
	 * Thanks to John Morris for his very interesting post http://www.johnmorrisonline.com/how-to-add-a-fully-functional-custom-meta-box-to-wordpress-navigation-menus/
	 *
	 * @since 1.3.1
	 */
	public function language_switcher() {
		global $_nav_menu_placeholder, $nav_menu_selected_id;
		$_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;
		?>
		<div id="posttype-lang-switch" class="posttypediv">
			<div id="tabs-panel-lang-switch" class="tabs-panel tabs-panel-active">
				<ul id="lang-switch-checklist" class="categorychecklist form-no-clear">
					<li>
						<label class="menu-item-title">
							<input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo (int) $_nav_menu_placeholder; ?>][menu-item-object-id]" value="-1"> <?php esc_html_e( 'Languages', 'falang' ); ?>
						</label>
						<input type="hidden" class="menu-item-type" name="menu-item[<?php echo (int) $_nav_menu_placeholder; ?>][menu-item-type]" value="custom">
						<input type="hidden" class="menu-item-title" name="menu-item[<?php echo (int) $_nav_menu_placeholder; ?>][menu-item-title]" value="<?php esc_html_e( 'Languages', 'falang' ); ?>">
						<input type="hidden" class="menu-item-url" name="menu-item[<?php echo (int) $_nav_menu_placeholder; ?>][menu-item-url]" value="#falang_switcher">
					</li>
				</ul>
			</div>
			<p class="button-controls">
				<span class="add-to-menu">
					<input type="submit" <?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu', 'falang' ); ?>" name="add-post-type-menu-item" id="submit-posttype-lang-switch">
					<span class="spinner"></span>
				</span>
			</p>
		</div>
		<?php
	}

	/**
	 * Prepares javascript to modify the language switcher menu item
	 *
	 * @since 1.3.1
	 */
	public function admin_enqueue_scripts() {
		$screen = get_current_screen();
		if ( 'nav-menus' != $screen->base ) {
			return;
		}
		wp_enqueue_script( 'falang_nav_menu', FALANG_ADMIN_URL  . '/js/nav-menu.js', array( 'jquery' ), Falang()->get_version(), true );


		$data = array(
			'strings' => Language_Switcher::get_switcher_options( 'menu', 'string' ), // The strings for the options
			'title'   => __( 'Languages', 'falang' ), // The title
			'val'     => array(),
		);

		// Get all language switcher menu items
		$items = get_posts(
			array(
				'numberposts' => -1,
				'nopaging'    => true,
				'post_type'   => 'nav_menu_item',
				'fields'      => 'ids',
				'meta_key'    => '_falang_menu_item',
			)
		);

		// The options values for the language switcher
		foreach ( $items as $item ) {
			$data['val'][ $item ] = get_post_meta( $item, '_falang_menu_item', true );
		}

		// Send all these data to javascript
		wp_localize_script( 'falang_nav_menu', 'falang_data', $data );
	}


	/**
	 * Save our menu item options
	 *
	 * @since 1.3.1
	 *
	 * @param int $menu_id not used
	 * @param int $menu_item_db_id
	 */
	public function wp_update_nav_menu_item( $menu_id = 0, $menu_item_db_id = 0 ) {
		if ( empty( $_POST['menu-item-url'][ $menu_item_db_id ] ) || '#falang_switcher' !== $_POST['menu-item-url'][ $menu_item_db_id ] ) { // phpcs:ignore WordPress.Security.NonceVerification
			return;
		}

		// Security check as 'wp_update_nav_menu_item' can be called from outside WP admin
		if ( current_user_can( 'edit_theme_options' ) ) {
			check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

			$options = array( 'hide_current' => 0, 'display_flags' => 0, 'display_name' => 1, 'dropdown' => 0 ); // Default values
			// Our jQuery form has not been displayed
			if ( empty( $_POST['menu-item-falang-detect'][ $menu_item_db_id ] ) ) {
				if ( ! get_post_meta( $menu_item_db_id, '_falang_menu_item', true ) ) { // Our options were never saved
					update_post_meta( $menu_item_db_id, '_falang_menu_item', $options );
				}
			}
			else {
				foreach ( array_keys( $options ) as $opt ) {
					$options[ $opt ] = empty( $_POST[ 'menu-item-' . $opt ][ $menu_item_db_id ] ) ? 0 : 1;
				}
				update_post_meta( $menu_item_db_id, '_falang_menu_item', $options ); // Allow us to easily identify our nav menu item
			}
		}
	}

	/**
	 * Assigns the title and label to the language switcher menu items
	 *
	 * @since 1.3.1
	 *
	 * @param object $item Menu item.
	 * @return object
	 */
	public function wp_setup_nav_menu_item( $item ) {
		if ( '#falang_switcher' === $item->url ) {
			$item->post_title = __( 'Languages', 'falang' );
			$item->type_label = __( 'Falang Language Switcher', 'falang' );
		}
		return $item;
	}


}