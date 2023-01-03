<?php

/**
 *
 * Displays the strings translations tab in Falang.
 *
 * @link       www.faboba.com
 * @since      1.0.0
 *
 * @package    Falang
 * @subpackage Falang/admin/views
 */
//use for popup translation
add_thickbox();

?>
<div id="col-container">
	<div class="col-wrap">
		<?php $strings_list_table->views(); ?>
		<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
		<form id="listings-filter" method="post">
            <input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']) ?>" />
			<?php $strings_list_table->search_box( __('Search','falang'), 's' );?>

			<!-- Displays the post list in a table -->
			<?php $strings_list_table->display();?>

        </form>
        <!-- Displays the clean old string -->
        <form id="listings-string-clean" method="post" action="admin.php?page=falang-strings">
            <input type="hidden" name="action" value="falang_clean_string">
            <label><input name="clean" type="checkbox" value="1" /> <?php echo esc_html__( 'Clean strings translation database', 'falang' ) ;?></label>
            <p><?php esc_html_e( 'Use this to remove unused strings from database, for example after a plugin has been uninstalled.', 'falang' ); ?></p>
            <?php submit_button(esc_html__( 'Clean strings', 'falang' ),'primary','clean-strings'); ?>
        </form>
	</div><!-- col-wrap -->