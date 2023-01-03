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

//use for popup translation
add_thickbox();
?>
<div id="col-container">
	<div class="col-wrap">
		<?php $options_list_table->views(); ?>
		<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
		<form id="options-translation" method="get" >
            <input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ) ?>" />
			<?php $options_list_table->search_box( __('Search','falang'), 's' );?>
			<?php  //wp_nonce_field( 'options-translation', '_wpnonce_options-translation' ); ?>
			<!-- Displays the post list in a table -->
			<?php $options_list_table->display();?>
		</form>
	</div><!-- col-wrap -->
    <script type="text/javascript">
        jQuery("input[name='_wp_http_referer'], input[name='_wpnonce']").remove();
    </script>