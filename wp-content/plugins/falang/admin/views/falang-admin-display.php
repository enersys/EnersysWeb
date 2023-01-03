<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.faboba.com
 * @since      1.0.0
 *
 * @package    Falang
 * @subpackage Falang/admin/partials
 */

require ABSPATH . 'wp-admin/options-head.php'; // Displays the errors messages as when we were a child of options-general.php
?>
<div class="wrap">
    <h1><?php echo esc_html( $GLOBALS['title'] ); ?></h1>
	<?php
	switch ( $this->active_tab ) {
		case 'language':     // Languages tab
		case 'translation':  // translations tab
        case 'menus':       //menu translation
        case 'terms':
		case 'settings': // Settings tab
        case 'strings': //strings pab
		case 'options': //options pab
		case 'help': //options pab
			include   '' . $this->active_tab . '_page.php';
			break;
		default:
			break;
	}
	?>

</div>

