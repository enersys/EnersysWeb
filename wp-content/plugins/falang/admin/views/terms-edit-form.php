<?php
/**
 *
 * Displays Term translation in Categories/Tags
 *
 * @link       www.faboba.com
 * @since      1.2.4
 *
 * @package    Falang
 * @subpackage Falang/admin/views
 */

$languages = $this->model->get_languages_list();
$falang_taxonomy = new \Falang\Core\Taxonomy();

$taxonomy_fields = $falang_taxonomy->get_taxonomy_fields($taxonomy);
$taxonomy_meta_fields = $falang_taxonomy->get_taxonomy_metakeys($taxonomy);


?>
<tr>
	<th><h2><?php echo __('Translations', 'falang'); ?></h2></th>
<td><?php wp_nonce_field('falang', 'falang_term_nonce', false, true); ?></td>
</tr>

<?php foreach ($languages as $language) { ?>
	<?php
	if ($this->is_default($language)) continue;

    $published = $falang_taxonomy->translate_term_field($tag, $taxonomy, 'published', $language, '');

	?>
	<tr>
		<th>
			<label><?php echo $language->name.' '.$language->get_flag(); ?></label>
            <label class="falang-switch">
                <input type="checkbox" name="falang_term[<?php echo $taxonomy; ?>][<?php echo $language->locale; ?>][published]"  value="1" <?php echo $published ? ' checked' : ''; ?>/>
                <span class="slider"></span>
            </label>
        </th>
		<td>
			<div style="display:flex;display: -webkit-flex;flex-wrap:wrap;-webkit-flex-wrap:wrap">
                <?php
                foreach ($taxonomy_fields as $field) { ?>
                    <?php $field_value = $falang_taxonomy->translate_term_field($tag, $taxonomy, $field, $language, ''); ?>
                    <?php if ($field == 'description'){ ?>
                        <div style="margin-bottom:1em; width:100%">
                            <textarea name="falang_term[<?php echo $taxonomy; ?>][<?php echo $language->locale; ?>][<?php echo $field; ?>]" style="box-sizing:border-box;width:95%;"><?php echo esc_textarea($field_value); ?></textarea>
                            <p class="description"><?php echo __('Term '.$field, 'falang'); ?></p>
                        </div>
                    <?php } else { ?>
                        <div style="margin-bottom:1em">
                            <input name="falang_term[<?php echo $taxonomy; ?>][<?php echo $language->locale; ?>][<?php echo $field; ?>]" type="text" value="<?php echo $field_value; ?>" placeholder="<?php echo $tag->{$field}; ?>" size="40" style="box-sizing:border-box">
                            <p class="description"><?php echo __('Term '.$field, 'falang'); ?></p>
                        </div>
                    <?php } ?>
                <?php } ?>
                <?php
                foreach ($taxonomy_meta_fields as $meta_fields) { ?>
                    <?php $field_value = $falang_taxonomy->translate_term_field($tag, $taxonomy, $meta_fields, $language, ''); ?>
                        <div style="margin-bottom:1em">
                            <input name="falang_term[<?php echo $taxonomy; ?>][<?php echo $language->locale; ?>][<?php echo $meta_fields; ?>]" type="text" value="<?php echo $field_value; ?>" placeholder="<?php echo $tag->{$meta_fields}; ?>" size="40" style="box-sizing:border-box">
                            <p class="description"><?php echo __('Term '.$meta_fields, 'falang'); ?></p>
                        </div>
                <?php } ?>
			</div>
		</td>
	</tr>
<?php }