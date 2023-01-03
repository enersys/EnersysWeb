<?php
  $falang_post = new \Falang\Core\Post();
  $falang_model = new \Falang\Model\Falang_Model();

?>
<html>
<head>
    <title><?php _e('Post Options page', 'falang'); ?></title>
</head>
<body>
<script type="text/javascript">
    // init namespace
    if ( typeof FALANG != 'object') var FALANG = {};

    FALANG.SetPostOptions = function () {
        var self = {};

        // this will be a public method
        var init = function () {
            self = this; // assign reference to current object to "self"

            // jobs window "close" button
            jQuery('#post_options_window .btn_close').click( function(event) {
                tb_remove();
            }).hide();

        }
        var sendOptions = function(obj) {
            //console.log(obj);

            var params = jQuery('#falang-post-options').serializeArray();
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

</script>
<form id="falang-post-options" action="#" method="POST">
	<?php wp_nonce_field('falang_action', 'falang_post_option', true, true); ?>
	<input type="hidden" name="post_type" value="<?php echo $falang_post_type; ?>">
    <input type="hidden" name="action" value="update_settings_post_options"/>
	<h2><?php echo sprintf(__('%s Translate Options', 'falang'), isset($falang_post_type_obj->label) ? $falang_post_type_obj->label : $falang_post_type); ?></h2>
	<table class="form-table">
		<table class="form-table">
			<tbody>
			<?php if ($falang_post_type !== 'post' && $falang_post_type !== 'page' && $falang_post_type !== 'attachment' && $falang_post_type_obj->publicly_queryable) { ?>
				<?php
				add_filter('home_url', array($this,'translate_home_url'), 10, 4);
				?>
				<tr>
					<th><?php _e('Post Type Permalink Base', 'falang'); ?></th>
					<td>
						<ul id="falang-post-options-permalink">
							<?php foreach ($falang_model->get_languages_list() as $language) { ?>
								<?php
								$this->set_language($language);
								$cpt_translation = $falang_post->get_cpt_translation($falang_post_type, $language);
								$cpt_default = $falang_post->translate_cpt($falang_post_type, $language);
								?>
								<li>
                                    <code><?php echo $language->name; ?>: <?php echo home_url('/'); ?></code>
									<input type="text" class="text-input" name="cpt[<?php echo $language->locale; ?>]" value="<?php echo $cpt_translation; ?>" placeholder="<?php echo $cpt_default; ?>" autocomplete="off" style="padding: 0 3px;"><code>/...</code>
								</li>
							<?php } ?>
                            <?php //$this->restore_language(); ?>
						</ul>
						<p class="description"><?php echo sprintf(__('Permalink base slug is overwritten: %s. It is overwritten by Falang.'), '<code>'.$falang_post_type_obj->rewrite['slug'].'</code>'); ?></p>
					</td>
				</tr>
				<?php if ($falang_post_type_obj->has_archive && $falang_post_type_obj->has_archive !== true) { ?>
					<tr>
						<th><?php _e('Post Type Archive Link', 'falang'); ?></th>
						<td>

							<ul id="falangn-post-options-permalink">
								<?php foreach ($falang_model->get_languages_list() as $language) { ?>
									<?php
									$this->set_language($language);
									$cpt_archive_translation = $falang_post->get_cpt_archive_translation($falang_post_type, $language);
									$cpt_archive_default = $falang_post->translate_cpt_archive($falang_post_type, $language);
									?>
									<li>
                                        <code><?php echo $language->name; ?>: <?php echo home_url('/'); ?></code><input type="text" class="text-input" name="cpt_archive[<?php echo $language->locale; ?>]" value="<?php echo $cpt_archive_translation; ?>" placeholder="<?php echo $cpt_archive_default; ?>" autocomplete="off" style="padding: 0 3px;">
									</li>
								<?php } ?>
								<?php //$this->restore_language(); ?>
                            </ul>
							<p class="description"><?php echo sprintf(__('Archive slug is originally: %s. It is overwritten by Falang.'), '<code>'.$falang_post_type_obj->has_archive.'</code>'); ?></p>
						</td>
					</tr>
				<?php } ?>
			<?php } ?>
			<tr>
				<th><?php _e('Translatable Post fields', 'falang'); ?></th>
				<td>
					<ul>
						<?php foreach ($falang_post->fields as $value) { ?>
							<li><label><input type="checkbox" name="fields[]" value="<?php echo $value; ?>" <?php if (in_array($value, $falang_post->get_post_type_fields($falang_post_type))) echo 'checked'; ?>/><?php echo $value; ?></label></li>
						<?php } ?>
					</ul>
				</td>
			</tr>
			<tr>
				<?php if ($falang_meta_keys) { ?>
					<th><?php _e('Translatable Post meta', 'falang'); ?></th>
					<td>
						<ul>
							<?php foreach ($falang_meta_keys as $key => $values) { ?>
								<li><label title="value sample: '<?php echo isset($values[0]) ? $values[0] : ''; ?>'"><input type="checkbox" name="meta_keys[]" value="<?php echo $key; ?>" <?php if (in_array($key, $falang_post->get_post_type_metakeys($falang_post_type))) echo 'checked'; ?>/><?php echo isset($falang_registered_meta_keys[$key]['description']) && $falang_registered_meta_keys[$key]['description'] ? $falang_registered_meta_keys[$key]['description'] : $key; ?></label></li>
							<?php } ?>
						</ul>
					</td>
				<?php } ?>
			</tr>
			<tr>
				<th>Revisions</th>
				<td>
					<label><input type="checkbox" name="enable_revisions" value="1" <?php if ($falang_post->get_post_type_option($falang_post_type, 'enable_revisions')) echo 'checked' ?>/><?php _e('Save language data in revisions', 'falang'); ?></label>
				</td>
			</tr>
			</tbody>
		</table>
        <a href="#" onclick="FALANG.SetPostOptions.sendOptions(this);return false;" class="button"><?php _e('Save options', 'falang'); ?></a>

</form>
</body>
</html>