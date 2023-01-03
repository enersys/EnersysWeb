<?php

if ( ! defined( 'ABSPATH' ) ) {exit;} // Don't access directly
use Falang\Core\Falang_Core;
use Falang\Model\Falang_Model;
use Falang\Factory\TranslatorFactory;

//falang_id is the term_id
//TODO need to user term or taxo more clearly
$core_taxonomy = new \Falang\Core\Taxonomy($falang_id);
$original_term = get_term($falang_id);
$target_language = $this->model->get_language_by_locale($falang_target_language_locale);

if ($this->model->get_option('enable_service')){
	$translator =  TranslatorFactory::getTranslator($falang_target_language_locale);
    $target_code_iso = strtolower($translator->languageCodeToISO($falang_target_language_locale));
}

?>
<html>
<head>
	<title><?php echo __('Term translation page', 'falang'); ?></title>

    <script type="text/javascript">

        // init namespace
        if ( typeof FALANG != 'object') var FALANG = {};

        FALANG.SetTermOptions = function () {
            var self = {};

            // this will be a public method
            var init = function () {
                self = this; // assign reference to current object to "self"

                // jobs window "close" button
                jQuery('#edit-term-translation .btn_close').click( function(event) {
                    tb_remove();
                }).hide();

            }
            var sendOptions = function(obj) {
                //console.log(obj);

                var params = jQuery('#edit-term-translation').serializeArray();

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

        //add action-cancel action
        jQuery( document ).ready(function() {
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
<form id="edit-term-translation" action="#" method="POST">
	<?php wp_nonce_field('falang_action', 'falang_term_nonce', true, true); ?>

	<input type="hidden" name="action" value="falang_term_update_translation"/>
    <input type="hidden" name="target_language" value="<?php echo $falang_target_language_locale; ?>"/>
    <input type="hidden" name="term_id" value="<?php echo $falang_id?>">
    <input type="hidden" name="context" value="<?php echo $falang_context; ?>">
    <input type="hidden" name="taxonomy" value="<?php echo $falang_taxonomy?>">

    <!-- Put message is the Term is not set as translatable -->
    <?php if (!$core_taxonomy->is_taxonomy_translatable($falang_taxonomy)){?>
        <div class="alert alert-warning"><?php echo __('Term is not enabled for translation in the Falang settings, translation will not be visible in front-end', 'falang'); ?></div>
    <?php }?>
    <div class="info">
		<?php echo __('Published', 'falang'); ?>
        <!-- value not submited when unchecked-->
        <label class="falang-switch">
            <input type="checkbox" name="published"  id="published" value="1" <?php echo $core_taxonomy->is_published($falang_target_language_locale) ? ' checked' : ''; ?>/>
            <span class="slider"></span>
        </label>
    </div>

    <div id="col-container">
        <div class="col-label">
            &nbsp;
        </div>
        <div class="col-title">
            <div class="col-source">
                <h3><?php echo esc_html__( 'Source', 'falang' ); ?></h3>
            </div><!-- col-source -->
            <div class="col-action">
                &nbsp;
            </div><!-- col-action -->
            <div class="col-target">
                <h3><?php echo esc_html__( 'Target', 'falang' ).' '.$target_language->get_flag(); ?></h3>
            </div><!-- col-target -->
        </div>
    </div>
            <!-- fields translation -->
            <?php foreach ($falang_taxonomy_fields as $field ) { ?>
                <div class="row">
                    <?php $search_metakey = Falang_Core::get_prefix($falang_target_language_locale).$field?>
                    <?php $previous_value = isset($core_taxonomy->metakey[$search_metakey])?$core_taxonomy->metakey[$search_metakey][0]:''; ?>

                    <div class="col-label">
                        <label><?php echo  __($field, 'falang');?></label>
                    </div>
                    <div class="col-source">
                        <div id="original_value_<?php echo $field;?>" name="original_value_<?php echo $field;?>" style="display: none">
			                <?php echo $original_term->$field; ?>
                        </div>
		                <?php if ($field == 'description') { ?>
                            <textarea name="fake_original_value_<?php echo $field; ?>" id="fake_original_value_<?php echo $field; ?>"  cols="22" rows="4" readonly><?php echo $original_term->$field;?></textarea>
		                <?php } else { ?>
                            <input type="text" name="fake_original_value_<?php echo $field; ?>" id="fake_original_value_<?php echo $field; ?>" value="<?php echo $original_term->$field; ?>" readonly class="falang">
		                <?php } ?>
                    </div>
                    <div class="col-action">
                        <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $field; ?>','copy');return false;" title="<?php  echo __( 'Copy', 'falang' ) ?>"><i class="fas fa-copy"></i></button>
                        <!-- add yandex/azure button -->
                        <?php if ($this->model->get_option('enable_service') == '1') { ?>
                            <?php if ($this->model->get_option('service_name') == 'google') { ?>
                                <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $field;?>','translate');return false;" title="<?php  echo __( 'Translate with Google', 'falang' ) ?>"><i class="fab fa-google"></i></button>
                            <?php } ?>
                            <?php if ($this->model->get_option('service_name') == 'yandex') { ?>
                                <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $field;?>','translate');return false;" title="<?php  echo __( 'Translate with Yandex', 'falang' ) ?>"><i class="fab fa-yandex-international"></i></button>
                            <?php } ?>
                            <?php if ($this->model->get_option('service_name') == 'azure') { ?>
                                <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $field;?>','translate');return false;" title="<?php  echo __( 'Translate with Azure', 'falang' ) ?>"><i class="fab fa-windows"></i></button>
                            <?php } ?>
                            <?php if ($this->model->get_option('service_name') == 'lingvanex') { ?>
                                <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $field;?>','translate');return false;" title="<?php  echo __( 'Translate with Lingvanex', 'falang' ) ?>"><i class="fas fa-globe"></i></button>
                            <?php } ?>
                        <?php } ?>

                    </div>
                    <div class="col-target">
		                <?php if ($field == 'description') { ?>
                            <textarea name="<?php echo $field; ?>" id="<?php echo $field; ?>"  cols="22" rows="4"><?php echo esc_textarea($previous_value);?></textarea>
		                <?php } else { ?>
                            <input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo $previous_value; ?>" class="falang">
		                <?php } ?>
                    </div>
                </div>
            <?php } ?>
    <!-- meta fields translation -->
    <?php foreach ($falang_taxonomy_meta_fields as $metafield ) { ?>
    <div class="row">
        <?php $search_metakey = Falang_Core::get_prefix($falang_target_language_locale).$metafield?>
        <?php $previous_value = isset($core_taxonomy->metakey[$search_metakey])?$core_taxonomy->metakey[$search_metakey][0]:''; ?>

        <div class="col-label">
            <label><?php echo  __($metafield, 'falang');?></label>
        </div>
        <div class="col-source">
            <div id="original_value_<?php echo $metafield;?>" name="original_value_<?php echo $metafield;?>" style="display: none">
                <?php echo get_term_meta($falang_id,$metafield,true) ?>
            </div>
                <input type="text" name="fake_original_value_<?php echo $metafield; ?>" id="fake_original_value_<?php echo $metafield; ?>" value="<?php echo get_term_meta($falang_id,$metafield,true); ?>" readonly class="falang">
        </div>
        <div class="col-action">
            <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $metafield; ?>','copy');return false;" title="<?php  echo __( 'Copy', 'falang' ) ?>"><i class="fas fa-copy"></i></button>
            <!-- add yandex/azure button -->
            <?php if ($this->model->get_option('enable_service') == '1') { ?>
                <?php if ($this->model->get_option('service_name') == 'google') { ?>
                    <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $metafield;?>','translate');return false;" title="<?php  echo __( 'Translate with Google', 'falang' ) ?>"><i class="fab fa-google"></i></button>
                <?php } ?>
                <?php if ($this->model->get_option('service_name') == 'yandex') { ?>
                    <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $metafield;?>','translate');return false;" title="<?php  echo __( 'Translate with Yandex', 'falang' ) ?>"><i class="fab fa-yandex-international"></i></button>
                <?php } ?>
                <?php if ($this->model->get_option('service_name') == 'azure') { ?>
                    <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $metafield;?>','translate');return false;" title="<?php  echo __( 'Translate with Azure', 'falang' ) ?>"><i class="fab fa-windows"></i></button>
                <?php } ?>
                <?php if ($this->model->get_option('service_name') == 'lingvanex') { ?>
                    <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $metafield;?>','translate');return false;" title="<?php  echo __( 'Translate with Lingvanex', 'falang' ) ?>"><i class="fas fa-globe"></i></button>
                <?php } ?>
            <?php } ?>

        </div>
        <div class="col-target">
                <input type="text" name="<?php echo $metafield; ?>" id="<?php echo $metafield; ?>" value="<?php echo $previous_value; ?>" class="falang">
        </div>
    </div>
    <?php } ?>


    <div class="row action">
        <a href="#" class="button button-primary action-cancel"><?php echo __( 'Cancel', 'falang' );?> </a>
        <a href="#" onclick="FALANG.SetTermOptions.sendOptions(this);return false;" class="button button-primary action-save"><?php echo __('Save', 'falang'); ?></a>
    </div>
</form>
</body>
</html>