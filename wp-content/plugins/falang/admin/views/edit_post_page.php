<?php
/**
 * Displays the translations page for posts
 */

if ( ! defined( 'ABSPATH' ) ) {exit;} // Don't access directly
use Falang\Core\Falang_Core;
use Falang\Model\Falang_Model;
use Falang\Translator\TranslatorYandex;
use Falang\Factory\TranslatorFactory;


$original_post = get_post($falang_original_post_id);
$falang_model = new Falang_Model();
$target_language = $falang_model->get_language_by_locale($falang_target_language_locale);

$editor_settings_dest = array(
	'wpautop' => true,
);
$editor_settings_source = array(
	'wpautop' => true,
	'readonly' => true
);

//acf support
// Get field groups for this screen.
if (function_exists('get_field_objects')) {
    $acf_fields = get_field_objects($original_post->ID);
}
//fin acf

//supported builder use for Divi,Yootheme,Elementor,WPBakery to disable content translation
$supported_builder = apply_filters('falang_is_supported_builder',false,$original_post);

if ($falang_model->get_option('enable_service')){
	TranslatorFactory::getTranslator($falang_target_language_locale);
}

?>

    <h2><?php echo sprintf('%1$s : %2$s', esc_html__( 'Translations Post', 'falang' ), $original_post->post_title); ?></h2>
    <form id="edit-translation" method="post" action="<?php echo $falang_form_action; ?>" class="validate">
        <div class="action-btn">
            <div class="cancel-edit">
                <a class="button button-primary" href="<?php echo $falang_cancel_action; ?>"><?php echo __( 'Cancel', 'falang' );?> </a>
            </div>
	        <?php submit_button( __( 'Save & Close', 'falang') ,'primary','save' ); ?>
	        <?php submit_button( __( 'Save', 'falang' ),'primary','update' ); ?>
        </div>

        <div class="info">
	        <?php echo __('Published', 'falang'); ?>
            <!-- value not submited when unchecked-->
            <label class="falang-switch">
                <input type="checkbox" name="published"  id="published" value="1" <?php echo $falang_post->is_published($falang_target_language_locale) ? ' checked' : ''; ?>/>
                <span class="slider"></span>
            </label>
            <br/>
            <br/>
            <button id="toogle-source-panel" class="button button-primary" data-show-reference="<?php echo __( 'Show Reference', 'falang' );?>" data-hide-reference="<?php echo __( 'Hide Reference', 'falang' );?>"><?php echo __( 'Hide Reference', 'falang' );?></button>
	    </div>
        <div id="col-container">
            <div class="col-title">
                <div class="col-source">
                    <h3><?php echo esc_html__( 'Source', 'falang' ).'&nbsp;<small>('. esc_html__( 'readonly', 'falang' ) .')</small>'; ?></h3>
                </div><!-- col-source -->
                <div class="col-action">
                    &nbsp;
                </div><!-- col-action -->
                <div class="col-target">
                    <h3><?php echo esc_html__( 'Target', 'falang' ).' '.$target_language->get_flag(); ?></h3>
                </div><!-- col-target -->
            </div>
                <?php foreach ($falang_post->fields as $key) { ?>
                    <?php $search_metakey = Falang_Core::get_prefix($falang_target_language_locale).$key?>
                    <?php $previous_value = isset($falang_post->metakey[$search_metakey])?$falang_post->metakey[$search_metakey]:''; ?>
                    <div class="row">

                        <h2><?php echo $falang_post->get_keyname_from_field($key); ?></h2>

                        <div class="col-source">
                            <!-- put original value in a div for the copy -->
                            <div id="original_value_<?php echo $key;?>" name="original_value_<?php echo $key;?>" style="display:none" >
                                <?php echo $original_post->{$key}; ?>
                            </div>
                            <!-- with wp_editor like post_content hide the orignal value (translate/copy problem encoding) -->
                            <?php if ($key == 'post_content') { ?>
                                <?php
                                    if (false == $supported_builder){
                                        echo wp_editor($original_post->{$key},'fake_original_value_'.$key,$editor_settings_source);
                                    } else {
                                        // not displaying source for extra Falang builder
                                        echo '&nbsp;';
                                    }
                                ?>
                            <?php } elseif ($key == 'post_excerpt')  { ?>
                                <textarea name="fake_original_value_<?php echo $key;?>" id="fake_original_value_<?php echo $key;?>" readonly class="falang"><?php echo $original_post->{$key}; ?></textarea>
                            <?php }  else { ?>
                                <input type="text" name="fake_original_value_<?php echo $key;?>" id="fake_original_value_<?php echo $key;?>" readonly value="<?php echo esc_attr($original_post->{$key}); ?>" class="falang">
                            <?php }  ?>
                        </div><!-- col-source -->

                        <div class="col-action">
                            <!-- no button for builder content-->
                            <?php if ($key != 'post_content' || false == $supported_builder){ ?>
                            <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','copy');return false;" title="<?php  echo __( 'Copy', 'falang' ) ?>"><i class="fas fa-copy"></i></button>
                            <!-- add yandex/azure button -->
		                    <?php if ($falang_model->get_option('enable_service') == '1') { ?>
                                <?php if ($falang_model->get_option('service_name') == 'google') { ?>
                                    <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','translate');return false;" title="<?php  echo __( 'Translate with Google', 'falang' ) ?>"><i class="fab fa-google"></i></button>
                                <?php } ?>
                                <?php if ($falang_model->get_option('service_name') == 'yandex') { ?>
                                    <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','translate');return false;" title="<?php  echo __( 'Translate with Yandex', 'falang' ) ?>"><i class="fab fa-yandex-international"></i></button>
                                <?php } ?>
                                <?php if ($falang_model->get_option('service_name') == 'azure') { ?>
                                    <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','translate');return false;" title="<?php  echo __( 'Translate with Azure', 'falang' ) ?>"><i class="fab fa-windows"></i></button>
                                <?php } ?>
                                <?php if ($falang_model->get_option('service_name') == 'lingvanex') { ?>
                                    <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','translate');return false;" title="<?php  echo __( 'Translate with Lingvanex', 'falang' ) ?>"><i class="fas fa-globe"></i></button>
                                <?php } ?>
		                    <?php } ?>
                            <?php } else {
                                echo '&nbsp;';
                            }?>
                        </div><!-- col-action -->

                        <div class="col-target">
		                    <?php if ($key == 'post_content') { ?>
			                    <?php
                                    if (false == $supported_builder) {
                                        echo wp_editor(isset($previous_value[0]) ? $previous_value[0] : '', $key, $editor_settings_dest);
                                    } else {
                                        // not displaying source for extra Falang builder
                                        echo sprintf(esc_html__( 'To translate the content, you need to use the additional %1$s Falang plugin', 'falang' ), $supported_builder);
                                    }
			                    ?>
		                    <?php } elseif ($key == 'post_excerpt')  { ?>
                                <textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" class="falang"><?php echo isset($previous_value[0])?esc_textarea($previous_value[0]):''; ?></textarea>
		                    <?php } else {?>
                                <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo isset($previous_value[0])?esc_attr($previous_value[0]):''; ?>" class="falang">
		                    <?php } ?>
                        </div><!-- col-target -->
                    </div><!-- row -->
                <?php }//foreach ?>

          <!-- Manage MetaKeys -->
	        <?php foreach ($falang_translated_metakeys as $key) { ?>
            <!-- ACF FIELDS are displayed with specific edit post page -->
            <?php $is_acf_field = false; ?>
            <?php if(isset($acf_fields)) {$is_acf_field = isset($acf_fields[$key]) ? true:false;}?>
            <?php if ($is_acf_field){continue;} ?>

		        <?php $search_metakey = Falang_Core::get_prefix($falang_target_language_locale).$key?>
		        <?php $previous_value = isset($falang_post->metakey[$search_metakey])?$falang_post->metakey[$search_metakey]:''; ?>
                <!-- manage meta custom editor thanks to @frogerme -->
                <?php if ( has_action( 'falang_translation_meta_field_' . $key ) ) {
                    do_action( 'falang_translation_meta_field_' . $key, $key, $original_post, $falang_post, $falang_model, $previous_value );
                    continue;
                } ?>;
                <div class="row">
                    <h2><?php echo $key ?></h2>
                    <div class="col-source">
                        <div id="original_value_<?php echo $key;?>" name="original_value_<?php echo $key;?>" style="display: inline-block">
			                <?php echo $original_post->{$key}; ?>
                        </div>
                    </div><!-- col-source -->
                    <div class="col-action">
                        <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','copy');return false;" title="<?php  echo __( 'Copy', 'falang' ) ?>"><i class="far fa-copy"></i></button>
                        <!-- add yandex/azure button -->
                        <?php if ($falang_model->get_option('enable_service') == '1') { ?>
                            <?php if ($falang_model->get_option('service_name') == 'google') { ?>
                                <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','translate');return false;" title="<?php  echo __( 'Translate with Google', 'falang' ) ?>"><i class="fab fa-google"></i></button>
                            <?php } ?>
                            <?php if ($falang_model->get_option('service_name') == 'yandex') { ?>
                                <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','translate');return false;" title="<?php  echo __( 'Translate with Yandex', 'falang' ) ?>"><i class="fab fa-yandex-international"></i></button>
                            <?php } ?>
                            <?php if ($falang_model->get_option('service_name') == 'azure') { ?>
                                <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','translate');return false;" title="<?php  echo __( 'Translate with Azure', 'falang' ) ?>"><i class="fab fa-windows"></i></button>
                            <?php } ?>
                            <?php if ($falang_model->get_option('service_name') == 'lingvanex') { ?>
                                <button class="button-secondary button-copy" onclick="copyToTranslation('<?php echo $key;?>','translate');return false;" title="<?php  echo __( 'Translate with Lingvanex', 'falang' ) ?>"><i class="fas fa-globe"></i></button>
                            <?php } ?>
                        <?php } ?>
                    </div><!-- col-action -->
                    <div class="col-target">
                        <textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" rows="1" class="falang"><?php echo isset($previous_value[0])?esc_textarea($previous_value[0]):''; ?></textarea>
                    </div><!-- col-target -->
                </div><!-- row -->
	        <?php }//foreach metakeay ?>

          <!-- Manage ACF  -->
          <?php
          if(isset($acf_fields)){
            include ('edit_post_page_acf.php');
          }
          ?>

                <div class="row">
                    <input type="hidden" name="action" value="falang_save_post" />
                    <input type="hidden" name="target_language" value="<?php echo $falang_target_language_locale?>">
                    <input type="hidden" name="post_id" value="<?php echo $falang_original_post_id?>">
                    <div class="action-btn">
                        <div class="cancel-edit">
                            <a class="button button-primary" href="<?php echo $falang_cancel_action; ?>"><?php echo __( 'Cancel', 'falang' );?> </a>
                        </div>
	                    <?php submit_button( __( 'Save & Close', 'falang') ,'primary','save' ); ?>
	                    <?php submit_button( __( 'Save', 'falang' ),'primary','update' ); ?>
                    </div>
                </div>
        </div><!-- col-container -->
    </form>

    <?php display_free_message(); ?>




