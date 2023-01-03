<?php
/**
 * The file that defines the Admin Notices
 *
 * @link       www.faboba.com
 * @since      1.
 *
 * @package    Falang
 */
namespace Falang\Core;


class Admin_Notices {

	/**
	 * Stores notices.
	 * each notice need to have a notice_[notice_name] callback function
	 * @var array
	 */
	private static $notices = array('rate_us_feedback','update_pro');
	const ADMIN_NOTICES_NAME        = 'falang';
	const ADMIN_NOTICES_KEY         = 'falang_dismissed_notices';
	const ADMIN_NOTICES_KEY_DATE    = 'falang_dismissed_notices_date';//last notices dismissed date
	const ADMIN_NOTICES_INSTALLED_TIME  = 'falang_installed_time';//store the time the notice was installed
	const ADMIN_NOTICES_TIME        = 7*24*60*60;//7*24*60*60 ;// 7*24*60*60;1 week between each notices debug: 2*60//;

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

	}

	/**
	 * Get custom notices
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public static function get_notices() {
		return self::$notices;
	}

	/**
	 * Stores a dismissed notice in database
	 * use for Falang and all extra plugins
	 *
	 * @since 1.1.23 add $plugin parameter
	 *
	 * @param string $notice
	 * @param string $plugin
	 */
	public static function dismiss( $notice,$plugin = 'falang' ) {

		$dismissed = get_option( $plugin.'_dismissed_notices', array() );
		$result = false;
		$dismissed_time = time();

		if ( ! in_array( $notice, $dismissed ) ) {
			$dismissed[] = $notice;
			update_option( $plugin.'_dismissed_notices', array_unique( $dismissed ) );
			$result = true;
		}
		//alwasys update the date in case of display several time the same notice after the time is elpased.
		update_option( $plugin.'_dismissed_notices_date',$dismissed_time);//set the last dismissed date

		return $result;

	}

	/**
	 * Get install time.
	 *
	 * Retrieve the time when Falang for Yootheme lite was installed.
	 *
	 * @since 1.3.23
	 * @access public
	 * @static
	 *
	 * @return int Unix timestamp when Falang for YOOtheme was installed.
	 */
	public function get_install_time() {
		$installed_time = get_option( self::ADMIN_NOTICES_INSTALLED_TIME );

		if ( ! $installed_time ) {
			$installed_time = time();

			update_option( self::ADMIN_NOTICES_INSTALLED_TIME, $installed_time );
		}

		return $installed_time;
	}

	/**
	 * Has a notice been dismissed?
	 *
	 * @since 1.0
	 * @since 1.3.23 use only global option and use const
	 *
	 * @param string $notice Notice name
	 * @return bool
	 */
	public static function is_dismissed( $notice ) {
		$dismissed = get_option( self::ADMIN_NOTICES_KEY, array() );

		return in_array( $notice, $dismissed );

	}

	/**
	 * Displays notices
	 *
	 * @since 1.3.23 use elementor like system and ajax dismiss
	 *
	 */
	public function admin_notices() {
		if ( current_user_can( 'manage_options' ) ) {

			//Core notices

            //problem on default falang language and site language
            if (Falang()->get_model()->get_default_locale() != Falang()->get_model()->get_default_language()->locale){
                $this->notice_default_language();
                return;
            }

            //end Core notices

			//fist activation
			if ($this->can_display_notice( 'first_activation' ) && ! $this->is_dismissed( 'first_activation' )  ) {
				$this->notice_first_activation();
				return;
			}

			//upgrade notice is displayed only when necessary return true)
            //on false try to display other notice
			if ($this->can_display_notice( 'upgrade_plugin' )  && $this->is_time('upgrade_plugin') ) {
				if ($this->notice_upgrade_plugin()){
                    return;
                }
			}

			// Custom notices are displayed with a time space
			foreach ( $this->get_notices() as $notice ) {
				if (apply_filters('falang_notices',$notice))
					//dismissed notice need to be displayed after the time is passed
					if ($this->can_display_notice($notice) && $this->is_time($notice)  && !$this->is_dismissed($notice)) {
						$method_callback = "notice_{$notice}";
						if ($this->$method_callback()) {
							return;
						}
					}
			}

			//all notices are displayed we can now reset it after the last execution time
            //and the time is done
            if ($this->can_display_notice($notice) && $this->is_time($notice) && $this->all_notices_displayed()){
                $this->reset_dismissed_notice();
            }
		}
	}

	/**
	 * Should we display notices on this screen?
	 *
	 * @since 1.3.23
	 *
	 * @param  string $notice The notice name.
	 * @return bool
	 */
	protected function is_time($notice ){
		$last_notice_date = get_option( self::ADMIN_NOTICES_KEY_DATE,0 );
		$time = time();
		if ($time > $last_notice_date+ self::ADMIN_NOTICES_TIME){
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Should we display notices on this screen?
	 *
	 * @since 1.0
	 *
	 * @param  string $notice The notice name.
	 * @return bool
	 */
	protected function can_display_notice( $notice ) {
		$screen          = get_current_screen();
		$screen_id       = $screen ? $screen->id : '';
		$show_on_screens = array(
			'dashboard',
			'plugins',
		);

		/**
		 * Filter admin notices which can be displayed
		 * Notices should only show on Falang screens, the main dashboard, and on the plugins screen.
		 *
		 * @since 1.0
		 *
		 * @param bool   $display Whether the notice should be displayed or not.
		 * @param string $notice  The notice name.
		 */
		return apply_filters(
			'falang_can_display_notice',
			in_array(
				$screen->id,
				array(
					'dashboard',
					'plugins',
					'toplevel_page_falang-translation',
					'falang_page_falang-terms',
					'falang_page_falang-menus',
					'falang_page_falang-strings',
					'falang_page_falang-options',
					'falang_page_falang-language',
					'falang_page_falang-settings',
					'falang_page_falang-help'
				)
			),
			$notice
		);
	}

    /**
     * reset dissmissed notices when all notices are alreasy show
     *
     * @since 1.3.24
     *
     */
	public function reset_dismissed_notice(){
        $dismissed[] = 'first_activation';
        update_option( self::ADMIN_NOTICES_KEY,$dismissed);//set the last dismissed date

        $dismissed_time = time();
        update_option( self::ADMIN_NOTICES_KEY_DATE,$dismissed_time);//set the last dismissed date

    }

    /**
     * reset dissmissed notices when all notices are alreasy show
     *
     * @since 1.3.24
     *
     */
    public function all_notices_displayed(){
        $dismissed = get_option( self::ADMIN_NOTICES_KEY, array() );

        $containsAllValues = !array_diff(self::get_notices(), $dismissed);
	    return $containsAllValues;
    }

	/**
	 * Render html attributes
	 *
	 * @since 1.1
	 *
	 * @access public
	 * @static
	 * @param array $attributes
	 *
	 * @return string
	 */
	public static function render_html_attributes( array $attributes ) {
		$rendered_attributes = [];

		foreach ( $attributes as $attribute_key => $attribute_values ) {
			if ( is_array( $attribute_values ) ) {
				$attribute_values = implode( ' ', $attribute_values );
			}

			$rendered_attributes[] = sprintf( '%1$s="%2$s"', $attribute_key, esc_attr( $attribute_values ) );
		}

		return implode( ' ', $rendered_attributes );
	}

	public function print_admin_notice( array $options ) {
		$default_options = [
			'id' => null,
			'title' => '',
			'description' => '',
			'classes' => [ 'notice', 'falang-notice' ], // We include WP's default notice class so it will be properly handled by WP's js handler
			'type' => '',
			'dismissible' => true,
			'icon' => 'icon-falang',
			'button' => [],
			'button_secondary' => [],
		];

		$options = array_replace_recursive( $default_options, $options );

		$notice_classes = $options['classes'];
		$dismiss_button = '';
		$icon = '';

		if ( $options['type'] ) {
			$notice_classes[] = 'falang-notice--' . $options['type'];
		}

		if ( $options['dismissible'] ) {
			$label = esc_html__( 'Dismiss', 'falang' );
			$notice_classes[] = 'falang-notice--dismissible';
			$dismiss_button = '<i class="falang-notice__dismiss" role="button" aria-label="' . $label . '" tabindex="0">'.$label.'</i>';
		}

		if ( $options['icon'] ) {
			$notice_classes[] = 'falang-notice--extended';
			$icon = '<div class="falang-notice__icon-wrapper"><i class="' . esc_attr( $options['icon'] ) . '" aria-hidden="true"></i></div>';
		}

		$wrapper_attributes = [
			'data-plugin_id' => self::ADMIN_NOTICES_NAME,
			'class' => $notice_classes,
		];

		if ( $options['id'] ) {
			$wrapper_attributes['data-notice_id'] = $options['id'];
		}
		?>
		<div <?php echo self::render_html_attributes( $wrapper_attributes ); ?>>
			<?php echo $dismiss_button; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div class="falang-notice__aside">
				<?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div class="falang-notice__content">
				<?php if ( $options['title'] ) { ?>
					<h3><?php echo wp_kses_post( $options['title'] ); ?></h3>
				<?php } ?>

				<?php if ( $options['description'] ) { ?>
					<p><?php echo wp_kses_post( $options['description'] ); ?></p>
				<?php } ?>

				<?php if ( ! empty( $options['button']['text'] ) || ! empty( $options['button_secondary']['text'] ) ) { ?>
					<div class="falang-notice__actions">
						<?php
						foreach ( [ $options['button'], $options['button_secondary'] ] as $index => $button_settings ) {
							if ( empty( $button_settings['variant'] ) && $index ) {
								$button_settings['variant'] = 'outline';
							}

							if ( empty( $button_settings['text'] ) ) {
								continue;
							}

							$button = new Button( $button_settings );
							$button->print_button();
						} ?>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php
	}

	private function notice_first_activation() {
		$notice_id = 'first_activation';

		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		$options = [
			'title' => esc_html__( 'Thanks for installing Falang!', 'falang' ),
			'description' => __( 'Enjoying the experience with Falang ? Please take a moment to spread your love by rating us on <a target="_blank" href="https://wordpress.org/plugins/falang/#reviews">WordPress.org!</a>', 'falang' ),
			'id' => $notice_id,
			'button' => [
				'text' => esc_html__( 'Documentation', 'falang'),
				'url' => 'https://www.faboba.com/en/wordpress/falang-for-wordpress/documentation.html',
				'new_tab' => true,
				'type' => 'info',
			],
			'button_secondary' => [
				'text' => esc_html__( 'Do you have question ?', 'falang' ),
				'url' => 'https://www.faboba.com/falangw/contact/',
				'new_tab' => true,
				'icon' => 'dashicons dashicons-edit',
				'type' => 'cta',
			],
		];

		$this->print_admin_notice( $options );

		return true;
	}

	/*
     * Notices to upgrade 1
     * @since 1.1
     *
     * */
	private function notice_upgrade_plugin() {

		if ( ! current_user_can( 'update_plugins' ) ) {
			return false;
		}

		// Check if have any upgrades.
		$update_plugins = get_site_transient( 'update_plugins' );

		$has_remote_update_package = ! ( empty( $update_plugins ) || empty( $update_plugins->response[ FALANG_BASENAME ] ) || empty( $update_plugins->response[ FALANG_BASENAME ]->package ) );

		if ( ! $has_remote_update_package  ) {
			return false;
		}


        $product = $update_plugins->response[ FALANG_BASENAME ];

        $details_url = self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $product->slug . '&section=changelog&TB_iframe=true&width=600&height=800' );
        $upgrade_url = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' . FALANG_BASENAME ), 'upgrade-plugin_' . FALANG_BASENAME );
        $new_version = $product->new_version;

        $notice_id = 'upgrade_notice_' . $new_version;

		$message = sprintf(
		/* translators: 1: Details URL, 2: Accessibility text, 3: Version number, 4: Update URL, 5: Accessibility text */
			__( 'There is a new version of Falang available. <a href="%1$s" class="thickbox open-plugin-details-modal" aria-label="%2$s">View version %3$s details</a> or <a href="%4$s" class="update-link" aria-label="%5$s">update now</a>.', 'falang' ),
			esc_url( $details_url ),
			esc_attr( sprintf(
			/* translators: %s:  Falang version */
				__( 'View Falang version %s details', 'falang' ),
				$new_version
			) ),
			$new_version,
			esc_url( $upgrade_url ),
			esc_attr( esc_html__( 'Update Falang Now', 'falang' ) )
		);

		$options = [
			'title' => esc_html__( 'Update Notification', 'falang' ),
			'description' => $message,
			'button' => [
				'icon_classes' => 'dashicons dashicons-update',
				'text' => esc_html__( 'Update Now', 'falang' ),
				'url' => $upgrade_url,
			],
			'id' => $notice_id,
		];

		$this->print_admin_notice( $options );

		return true;
	}

	private function notice_rate_us_feedback() {
		$notice_id = 'rate_us_feedback';

		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		$options = [
			'title' => esc_html__( 'Thanks for using Falang !', 'falang' ),
			'description' => esc_html__( 'Enjoying the experience with Falang ?  Please take a moment to spread your love by rating us on WordPress.org!', 'falang' ),
			'id' => $notice_id,
			'button' => [
				'text' => esc_html__( 'Happy To Help', 'falang'),
				'url' => 'https://wordpress.org/plugins/falang/',
				'new_tab' => true,
				'type' => '',
			],
			'button_secondary' => [
				'text' => esc_html__( 'Do you have question ?', 'falang' ),
				'url' => 'https://www.faboba.com/falangw/contact/',
				'new_tab' => true,
				'icon' => 'dashicons dashicons-edit',
				'type' => 'cta',
			],
		];

		$this->print_admin_notice( $options );

		return true;
	}

    private function notice_update_pro() {
        $notice_id = 'update_pro';

        if ( ! current_user_can( 'manage_options' ) ) {
            return false;
        }

        $options = [
            'title' => esc_html__( 'Upgrade to Pro!', 'falang' ),
            'description' => __( 'If you are happy with Falang, support its development and get a Pro license.<br/>In return you get priority support and additional features.', 'falang' ),
            'id' => $notice_id,
            'button' => [
                'text' => esc_html__( 'Buy a license', 'falang'),
                'url' => 'https://www.faboba.com/en/wordpress/falang-for-wordpress/telechargement-achat.html',
                'new_tab' => true,
                'type' => 'cta',
            ],
        ];

        $this->print_admin_notice( $options );

        return true;
    }

    /*
     * $since 1.3.30
     * display notice if the falang default language is not the same with the site language
     * */
    private function notice_default_language(){

        if ( ! current_user_can( 'manage_options' ) ) {
            return false;
        }

        $notice_id = 'language_default_error';

        $options = [
            'title' => esc_html__( 'Falang configuration problem', 'falang' ),
            'description' => __( 'Your Site language (in Settings > General ) is not the same as the one set in Falang as default language. Falang will not work correctly if the two are set differently.<br/>Please change it either in the WordPress settings or modify the Falang default language so they are the same', 'falang' ),
            'id' => $notice_id,
            'type' => 'error',
            'dismissible' => false,
        ];

        $this->print_admin_notice( $options );

        return true;

    }
}