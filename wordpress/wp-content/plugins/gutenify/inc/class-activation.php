<?php

class Gutenify_Activation {
	public function __contruction() {
		// register_activation_hook( __FILE__, array( __CLASS__, 'cyb_activation' ) );
		add_action( 'activated_plugin', array( __CLASS__, 'cyb_activation' ) );
	}

	public static function cyb_activation( $plugin ) {
		if( $plugin == plugin_basename( GUTENIFY_FILE ) ) {
			exit( wp_redirect( admin_url( 'options-general.php?page=myplugin_settings' ) ) );
		}
	}
}

new Gutenify_Activation();
