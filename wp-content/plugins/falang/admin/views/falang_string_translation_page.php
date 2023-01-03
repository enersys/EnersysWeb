<?php

if ( ! defined( 'ABSPATH' ) ) {exit;} // Don't access directly
use Falang\Core\Falang_Core;
use Falang\Model\Falang_Model;
use \Falang\Core\Falang_Mo;
use Falang\Factory\TranslatorFactory;
use Falang\Core\FString;

//falang_id is the term_id
//TODO need to user term or taxo more clearly
$falang_model = new \Falang\Model\Falang_Model();
$falang_mo = new Falang_Mo();
$language = $falang_model->get_language_by_locale($falang_target_language_locale);
$falang_mo->import_from_db($language);

//TODO look if it's possible to load it directly witout loops
//load traduction
$data =  FString::get_strings();
$tdata = array();
foreach ( $data as $key => $row ) {
    if ($key == $falang_row){
        $tdata = $row;
    }
}

$translation = $falang_mo->translate(wp_specialchars_decode($tdata['string']));

if ($falang_model->get_option('enable_service')){
	$translator =  TranslatorFactory::getTranslator($falang_target_language_locale);
	$target_code_iso = strtolower($translator->languageCodeToISO($falang_target_language_locale));
}



?>
<html>
<head>
	<title><?php echo __('Strings translations', 'falang'); ?></title>

    <script type="text/javascript">

        // init namespace
        if ( typeof FALANG != 'object') var FALANG = {};

        FALANG.SetStringOptions = function () {
            var self = {};

            // this will be a public method
            var init = function () {
                self = this; // assign reference to current object to "self"

                // jobs window "close" button
                jQuery('#edit-string-translation .btn_close').click( function(event) {
                    tb_remove();
                }).hide();

            }
            var sendOptions = function(obj) {
                //console.log(obj);

                var params = jQuery('#edit-string-translation').serializeArray();

                var jqxhr = jQuery.post(ajaxurl, params,'json' )
                    .success(function (response) {

                        if (response.success) {
                            // request was successful
                            tb_remove();
                        } else {
                            //TODO display error for user
                            //var logMsg = '<div id="message" class="updated" style="display:block !important;"><p>' +
                            //    'Error during options save' +
                            //    '</p></div>';
                            //jQuery('#ajax-response').append( logMsg );
                            console.log("response", response);

                        }

                    })
                    .error(function (e, xhr, error) {
                        console.log("error", xhr, error);
                        console.log(e.responseText);
                        console.log("ajaxurl", ajaxurl);
                        //console.log("params", params);
                    });
            }

            return {
                // declare which properties and methods are supposed to be public
                init: init,
                sendOptions: sendOptions,
            }
        }();

        jQuery( document ).ready(function() {

            jQuery( "#TB_window" ).resizable({
                minHeight: 300,
                maxHeight: 600,
                minWidth: 600,
                maxWidth: 1200,
                handles: 'se , e, s',
                alsoResize: '#fake_original_value, #translation',
                resize: function( event, ui ) {
                    var newWidth = ui.size.width / 2;
                    jQuery('#TB_window').css('margin-left','-'+newWidth+'px');
                }
            });

            //set height
            jQuery( "#TB_ajaxContent" ).height('100%');

            //jQuery('#translation').resizable({alsoResize: '#fake_original_value'})

            //add action-cancel action
            jQuery( ".action-cancel" ).on( "click", function() {
                tb_remove();
            });

            //update translator object to refer to popup windows
            if (typeof translator != "undefined") {
                translator.to = "<?php echo $target_code_iso?>";
            }
        });

    </script>


</head>
<body>
<form id="edit-string-translation" action="#" method="POST">
	<?php wp_nonce_field('falang_action', 'falang_string_nonce', true, true); ?>

	<input type="hidden" name="action" value="falang_string_update_translation"/>
	<input type="hidden" name="target_language" value="<?php echo $falang_target_language_locale; ?>"/>
    <input type="hidden" name="context" value="<?php echo $tdata['context']; ?>"/>
	<input type="hidden" name="row" value="<?php echo $falang_row?>">

	<h2><?php echo __('Translatable String', 'falang'); ?><span class="label">(<?php echo  _($tdata['name']);?>)</span></h2>
	<div class="info">
		<b><?php echo __( 'Target language: ', 'falang' ).$falang_target_language_locale;?></b>
		<?php //echo __('Published', 'falang'); ?>
		<!-- value not submited when unchecked-->
<!--		<input type="checkbox" name="published"  id="published" value="1" --><?php //echo $core_taxonomy->is_published($falang_target_language_locale) ? ' checked' : ''; ?><!--/>-->
	</div>

	<div id="col-container">
		<div class="col-title">
            <div class="col-source">
                <h3><?php echo esc_html__( 'Source', 'falang' ); ?></h3>
            </div><!-- col-source -->
			<div class="col-action">
				&nbsp;
			</div><!-- col-action -->
            <div class="col-target">
                <h3><?php echo esc_html__( 'Target', 'falang' ); ?></h3>
            </div><!-- col-target -->
		</div>
	</div>
		<div class="row">
            <div class="col-source">
                <div id="original_value_translation" name="original_value_translation" style="display: none">
					<?php echo  $tdata['string']; ?>
                </div>
				<?php if ($tdata['multiline']) { ?>
                    <textarea name="fake_original_value" id="fake_original_value" readonly><?php echo esc_textarea($tdata['string'])?></textarea>
				<?php } else { ?>
                    <input type="text" name="fake_original_value" id="fake_original_value" value="<?php echo $tdata['string']; ?>" readonly class="falang">
				<?php } ?>
            </div>
			<div class="col-action">
				<button class="button-secondary button-copy" onclick="copyToTranslation('translation','copy');return false;" title="<?php  echo __( 'Copy', 'falang' ) ?>"><i class="fas fa-copy"></i></button>
                <!-- add yandex/azure button -->
                <?php if ($falang_model->get_option('enable_service') == '1') { ?>
                    <?php if ($falang_model->get_option('service_name') == 'google') { ?>
                        <button class="button-secondary button-copy" onclick="copyToTranslation('translation','translate');return false;" title="<?php  echo __( 'Translate with Google', 'falang' ) ?>"><i class="fab fa-google"></i></button>
                    <?php } ?>
                    <?php if ($falang_model->get_option('service_name') == 'yandex') { ?>
                        <button class="button-secondary button-copy" onclick="copyToTranslation('translation','translate');return false;" title="<?php  echo __( 'Translate with Yandex', 'falang' ) ?>"><i class="fab fa-yandex-international"></i></button>
                    <?php } ?>
                    <?php if ($falang_model->get_option('service_name') == 'azure') { ?>
                        <button class="button-secondary button-copy" onclick="copyToTranslation('translation','translate');return false;" title="<?php  echo __( 'Translate with Azure', 'falang' ) ?>"><i class="fab fa-windows"></i></button>
                    <?php } ?>
                    <?php if ($falang_model->get_option('service_name') == 'lingvanex') { ?>
                        <button class="button-secondary button-copy" onclick="copyToTranslation('translation','translate');return false;" title="<?php  echo __( 'Translate with Lingvanex', 'falang' ) ?>"><i class="fas fa-globe"></i></button>
                    <?php } ?>
                <?php } ?>
			</div>
            <div class="col-target">
				<?php if ($tdata['multiline']) { ?>
                    <textarea name="translation" id="translation"><?php echo esc_textarea($translation);?></textarea>
				<?php } else { ?>
                    <input type="text" name="translation" id="translation" value="<?php echo $translation; ?>" class="falang">
				<?php } ?>
            </div>
		</div>
    <div style="clear: both;"></div>
	<div class="row action">
		<a href="#" class="button button-primary action-cancel"><?php echo __( 'Cancel', 'falang' );?> </a>
		<a href="#" onclick="FALANG.SetStringOptions.sendOptions(this);return false;" class="button button-primary action-save"><?php echo __('Save', 'falang'); ?></a>
	</div>
</form>
</body>
</html>