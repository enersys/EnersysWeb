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
        <form id="listings-filter" method="post">
            <?php $menu_list_table->search_box( __('Search','falang'), 's' );?>
            <!-- Displays the menu list in a table -->
            <?php $menu_list_table->display();?>
        </form>
    </div><!-- col-wrap -->
</div><!-- col-container -->