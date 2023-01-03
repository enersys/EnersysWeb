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
            <?php
            // Displays the language list in a table
            $language_list_table->display();
            ?>
        </div><!-- col-wrap -->

        <form id="language-addnew" method="get" action="admin.php?page=falang_language" style="display: inline;">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ) ?>" />
            <input type="hidden" name="action" value="add_new_language" />

            <input type="submit" value="<?php echo __('Add New Language','falang') ?>" name="submit" class="button">
        </form>

</div><!-- col-container -->

<script>
    var sortable_language_table = jQuery(".wp-list-table tbody");

    function update_language_ordering_callback(response) {
        //reset curson
        jQuery('html, body').css("cursor", "auto");
        if (response.success) {
            //update list with new order
            jQuery(".wp-list-table td.column-order").each(function (index) {
                jQuery(this).text(index+1);
            });
        }

        jQuery('.spo-updating-row').removeClass('spo-updating-row').find('.check-column').removeClass('spinner is-active');
        sortable_language_table.removeClass('spo-updating').sortable('enable');

    };

    //add ordering on language page
    jQuery( document ).ready(function($) {
        sortable_language_table.sortable({
            items: '> tr',
            cursor: 'move',
            axis: 'y',
            containment: 'table.widefat',
            cancel: 'input, textarea, button, select, option, .inline-edit-row',
            distance: 2,
            opacity: .8,
            tolerance: 'pointer',
            create: function () {
                jQuery(document).keydown(function (e) {
                    var key = e.key || e.keyCode;
                    if ('Escape' === key || 'Esc' === key || 27 === key) {
                        sortable_language_table.sortable('option', 'preventUpdate', true);
                        sortable_language_table.sortable('cancel');
                    }
                });
            },
            start: function (e, ui) {
                if (typeof (inlineEditPost) !== 'undefined') {
                    inlineEditPost.revert();
                }
                ui.placeholder.height(ui.item.height());
                ui.placeholder.empty();
            },
            helper: function (e, ui) {
                var children = ui.children();
                for (var i = 0; i < children.length; i++) {
                    var selector = jQuery(children[i]);
                    selector.width(selector.width());
                }
                ;
                return ui;
            },
            stop: function (e, ui) {
                if (sortable_language_table.sortable('option', 'preventUpdate')) {
                    sortable_language_table.sortable('option', 'preventUpdate', false);
                }

                // remove fixed widths
                ui.item.children().css('width', '');
            },
            update: function (e, ui) {
                if (sortable_language_table.sortable('option', 'preventUpdate')) {
                    sortable_language_table.sortable('option', 'preventUpdate', false);
                    return;
                }

                sortable_language_table.sortable('disable').addClass('spo-updating');
                ui.item.addClass('spo-updating-row');
                ui.item.find('.check-column').addClass('spinner is-active');

                var elt = jQuery('[name="order[]"]', $(this))
                var order_list = [];
                elt.each(function () {
                    order_list.push($(this).attr('value'));
                });

                $('html, body').css("cursor", "wait");

                // go do the sorting stuff via ajax
                jQuery.post(ajaxurl, {
                    action: 'falang_language_ordering',
                    order: order_list,
                }, update_language_ordering_callback);

                // fix cell colors
                var table_rows = document.querySelectorAll('tr.iedit'),
                    table_row_count = table_rows.length;
                while (table_row_count--) {
                    if (0 === table_row_count % 2) {
                        jQuery(table_rows[table_row_count]).addClass('alternate');
                    } else {
                        jQuery(table_rows[table_row_count]).removeClass('alternate');
                    }
                }
            }
        });
    });
</script>