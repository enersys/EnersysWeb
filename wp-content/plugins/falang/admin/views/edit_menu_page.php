<?php
/**
 * Displays the translations page for posts
 */

use Falang\Core\Falang_Core;
use Falang\Factory\TranslatorFactory;
use Falang\Model\Falang_Model;

if ( ! defined( 'ABSPATH' ) ) {exit;} // Don't access directly

//todo put this in the call of the page
$falang_model = new Falang_Model();
$translate_language_prefix = Falang_Core::get_prefix($falang_target_language_locale);
$target_language = $falang_model->get_language_by_locale($falang_target_language_locale);


add_thickbox();

if ($falang_model->get_option('enable_service')){
	TranslatorFactory::getTranslator($falang_target_language_locale);
}


$type = get_post_meta($falang_original_post_id, '_menu_item_type', true);
$hide = get_post_meta($falang_original_post_id, $translate_language_prefix.'falang_hide', true);

$_menu_item_type = get_post_meta($falang_original_post_id, '_menu_item_type', true);
$post = get_post($falang_original_post_id);

$orginal_post_title = $post->post_title;


$falang_model = new \Falang\Model\Falang_Model();
$target_language = $this->model->get_language_by_locale($falang_target_language_locale);//local in the url

if ($_menu_item_type === 'post_type') {


	$_menu_item_object_id = get_post_meta($falang_original_post_id, '_menu_item_object_id', true);
	$object_post = get_post($_menu_item_object_id);
	$post_object = $falang_post->translate_post_field($object_post, 'post_title',$target_language);
    $edit_link = esc_url( admin_url( 'admin.php?page=falang-translation&amp;action=edit&amp;post_id=' . $_menu_item_object_id . '&amp;language=' . $falang_target_language_locale ) );
    //use for copy/translate
	$orginal_post_title = $object_post->post_title;

} else if ($_menu_item_type === 'taxonomy') {

    $falang_taxo = new \Falang\Core\Taxonomy();

	$_menu_item_object_id = get_post_meta($falang_original_post_id, '_menu_item_object_id', true);
	$_menu_item_object = get_post_meta($falang_original_post_id, '_menu_item_object', true);
	$object_term = get_term_by('id', $_menu_item_object_id, $_menu_item_object);
	$term_object = $falang_taxo->get_term_field_translation($object_term,null,'name',$target_language);
	$edit_link = esc_url( admin_url( 'admin-ajax.php?action=falang_term_translation&width=800&height=400&Context='.$object_term->taxonomy.'&taxonomy='.$object_term->taxonomy.'&id=' . $_menu_item_object_id . '&amp;language=' . $falang_target_language_locale ) );
	//use for copy/translate
	$orginal_post_title = $object_term->name;


} else if ($_menu_item_type === 'custom') {
    $url = $falang_post->translate_post_field($post, '_menu_item_url',$target_language);
}

$classes = get_post_meta($falang_original_post_id, '_menu_item_classes', true);
$classes_string = (is_array($classes)) ? implode(' ', $classes) : $classes;

?>



<h2><?php echo sprintf('%1$s : %2$s', esc_html__( 'Translations Menu', 'falang' ), $orginal_post_title); ?></h2>
<form id="edit-translation" method="post" action="<?php echo $falang_form_action; ?>" class="validate">

<?php wp_nonce_field( 'falang', 'falang_extra_cpt_nonce', false, true ); ?>

    <div class="action-btn">
        <div class="cancel-edit">
            <a class="button button-primary" href="<?php echo $falang_cancel_action; ?>"><?php echo __( 'Cancel', 'falang' );?> </a>
        </div>
        <?php submit_button( __( 'Save', 'falang' ) ); ?>
    </div>
    <div class="info">
        <?php echo __('Published', 'falang'); ?>
        <label class="falang-switch">
            <input type="checkbox" name="published"  id="published" value="1" <?php echo $falang_post->is_published($falang_target_language_locale) ? ' checked' : ''; ?>/>
            <span class="slider"></span>
        </label>
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
            <h3><?php echo esc_html__( 'Target', 'falang' ).' '.$target_language->get_flag(); ?></h3>
        </div><!-- col-target -->
    </div>

		<?php foreach ($falang_post->fields as $key) { ?>
			<?php $search_metakey = $translate_language_prefix.$key?>
			<?php $previous_value = isset($falang_post->metakey[$search_metakey])?$falang_post->metakey[$search_metakey]:array(''); ?>

			<div class="row">
				<!-- post_title -->
				<?php if('post_title' == $key) {?>
                    <h2><?php echo $falang_post->get_keyname_from_field($key);  ?></h2>
                    <div class="col-source">
                        <div id="original_value_<?php echo $key;?>" name="original_value_<?php echo $key;?>">
							<?php echo $orginal_post_title; ?>
                        </div>
                    </div><!-- col-source -->
					<div class="col-action">
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
					</div><!-- col-action -->
                    <div class="col-target">
                        <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $previous_value[0]; ?>" class="falang">
                    </div><!-- col-target -->
				<?php }//post_title?>
			</div><!-- row -->
		<?php }//foreach ?>

        <h2><?php echo __( 'Parameters', 'falang' ); ?></h2>
        <table class="menu-param">
            <tbody>
			<?php if (isset($post_object)) { ?>
                <tr><td><label><?php echo __('Page Title', 'falang'); ?></label></td><td><input type="text" value="<?php echo $post_object; ?>" readonly/> (<a target="_blank" href="<?php echo $edit_link ?>"><?php echo __('edit', 'falang'); ?></a>)</td></tr>
			<?php } else if (isset($term_object)) { ?>
                <tr><td><label><?php echo __('Term Name', 'falang'); ?></label></td><td><input type="text" value="<?php echo $term_object; ?>" readonly/>(<a target="_blank" class="thickbox" href="<?php echo $edit_link ?>"><?php echo __('edit', 'falang'); ?></a>)</td></tr>
			<?php } else if (isset($url)) { ?>
                <tr><td><label><?php echo __('URL', 'falang'); ?></label></td><td><input type="text" name="falang_extra_cpt[_menu_item_url]" value="<?php echo $url; ?>"/></td></tr>
			<?php } ?>
            <tr><td><label><?php echo __('Title Attribute', 'falang'); ?></label></td><td><input type="text" name="post_excerpt" value="<?php echo $falang_post->get_post_field_translation($post,'post_excerpt',$target_language); ?>"/></td></tr>
            <tr><td><label><?php echo __('Description', 'falang'); ?></label></td><td><input type="text" name="post_content" value="<?php echo $falang_post->get_post_field_translation($post,'post_content',$target_language); ?>"/></td></tr>
			<?php if (in_array('_menu_item_classes', $falang_post->get_post_type_metakeys($post->post_type))) { ?>
                <tr><td><label><?php echo __('Classes', 'falang'); ?></label></td><td><input type="text" name="_menu_item_classes" value="<?php echo $classes_string; ?>"/></td></tr>
			<?php } ?>
<!-- Hide menu item not yet working -->
<!--            <tr><td><label>--><?php //echo __('Hide', 'falang'); ?><!--</label></td><td><input type="hidden" id="falang_nav_menu_hide" name="falang_extra_cpt[falang_hide]" value="--><?php //echo $hide; ?><!--"/><label><input type="checkbox" value="1" --><?php //if ($hide) echo ' checked'; ?><!-- onchange="document.getElementById('falang_nav_menu_hide').value=this.checked ? '1' : '';"/>--><?php //echo __('Hide this menu item in this language', 'falang'); ?><!--</label></td></tr>-->
            </tbody>
        </table>

        <div class="action-btn">
            <div class="cancel-edit">
                <a class="button button-primary" href="<?php echo $falang_cancel_action; ?>"><?php echo __( 'Cancel', 'falang' );?> </a>
            </div>
            <?php submit_button( __( 'Save', 'falang' ) ); ?>
        </div>

			<input type="hidden" name="action" value="falang_save_menu" />
			<input type="hidden" name="target_language" value="<?php echo $falang_target_language_locale ?>">
			<input type="hidden" name="post_id" value="<?php echo $falang_original_post_id ?>">


</div><!-- col-container -->
</form>

<?php display_free_message(); ?>



