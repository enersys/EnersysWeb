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

$falang_model = Falang()->get_model();
$falang_options = $falang_model->options;
?>
<script type="text/javascript">
    // Options page tabs
    jQuery( document ).ready( function( $ ) {
        // Tabs
        var $navs = $( '.nav-tab' ),
            $tabs = $( '.tabs' ),
            toogle = function( hash ) {
                location.hash = hash || '';
                var hash = hash || $('.nav-tab')[0].hash;
                //var hash = hash || $( 'a', $navs ).context[0].hash;
                $navs.removeClass( 'nav-tab-active' );
                var $a = hash ? $( 'a[href="' + hash + '"]' ) : $( 'a:first-child', $navs );
                $a.addClass( 'nav-tab-active' );
                $tabs.hide();
                $( hash ).show();
            };
        toogle( window.location.hash );

        $navs.on( 'click', function( e ) {
            e.preventDefault();
            var hash = e.target.hash;
            toogle( hash );
            history.replaceState( {page: hash}, 'title ' + hash, hash );
        });

        // init tooltips
        jQuery(".tips, .help_tip").tipTip({
            'attribute' : 'data-tip',
            'maxWidth' : '250px',
            'fadeIn' : 50,
            'fadeOut' : 50,
            'delay' : 200
        });


    });
</script>

<h2><?php echo __('Settings page', 'falang'); ?></h2>

    <div class="plugin_config">
        <div id="plugin_config_tabs">

            <h2 class="nav-tab-wrapper">
                <a href="#tab-general-settings" class="nav-tab"><?php _e( 'General Settings', 'falang' ); ?></a>
                <a href="#tab-translate-options" class="nav-tab"><?php _e( 'Translate Options', 'falang' ); ?></a>
                <a href="#tab-licence" class="nav-tab"><?php _e( 'License', 'falang' ); ?></a>
                <a href="#tab-informations" class="nav-tab"><?php _e( 'Information', 'falang' ); ?></a>
            </h2>

            <form id="edit-settings" action="<?php echo $falang_form_action;?>" method="post">
	            <?php wp_nonce_field('falang_action', 'falang_settings_option', true, true); ?>

                <div id="tab-general-settings" class="tabs">
		            <?php include plugin_dir_path( __FILE__ ).'settings_tab_general_settings.php'; ?>
                </div>

                <div id="tab-translate-options" class="tabs">
			        <?php include plugin_dir_path( __FILE__ ).'settings_tab_translate_options.php'; ?>
                </div>
                <div id="tab-licence" class="tabs">
                    <?php include plugin_dir_path( __FILE__ ).'settings_tab_licence.php'; ?>
                </div>
                <div id="tab-informations" class="tabs">
	                <?php include plugin_dir_path( __FILE__ ).'settings_tab_informations.php'; ?>
                </div>

                <input type="hidden" name="action" value="falang_save_settings" />

		        <?php submit_button( __( 'Update Settings', 'falang' )); ?>

            </form>


        </div>
    </div>

