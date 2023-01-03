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
?>
<div id="col-container">
        <div class="col-wrap">
	        <?php $post_list_table->views(); ?>
            <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
            <form id="listings-filter" method="get">
                <!-- we also need to ensure that the form posts back to our current page -->
                <input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ) ?>" />

                <?php $post_list_table->search_box( __('Search','falang'), 's' );?>

                <!-- Displays the post list in a table -->
                <?php $post_list_table->display();?>
            </form>
        </div><!-- col-wrap -->
</div><!-- col-container -->
<script type="text/javascript">
    jQuery("input[name='_wp_http_referer'], input[name='_wpnonce']").remove();
</script>