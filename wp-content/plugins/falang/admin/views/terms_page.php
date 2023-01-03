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
            <form id="listings-filter" method="post">

			<?php $term_list_table->search_box( __('Search','falang'), 's' );?>
            <!-- Displays the term list in a table -->
			<?php $term_list_table->display();?>

            </form>
		</div><!-- col-wrap -->
</div><!-- col-container -->