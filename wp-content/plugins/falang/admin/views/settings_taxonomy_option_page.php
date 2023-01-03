<?php
$falang_model = new \Falang\Model\Falang_Model();
$taxonomy = new \Falang\Core\Taxonomy();

?>
<html>
<head>
	<title><?php echo __('Taxonomy options page', 'falang'); ?></title>
</head>
<script type="text/javascript">
    // init namespace
    if ( typeof FALANG != 'object') var FALANG = {};

    FALANG.SetTaxonomyOptions = function () {
        var self = {};

        // this will be a public method
        var init = function () {
            self = this; // assign reference to current object to "self"

            // jobs window "close" button
            jQuery('#taxonomy_options_window .btn_close').click( function(event) {
                tb_remove();
            }).hide();

        }
        var sendOptions = function(obj) {
            //console.log(obj);

            var params = jQuery('#falang-taxonomy-options').serializeArray();
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

    (function() {
        var ul = document.getElementById("falang-taxonomy-options-permalink");
        var registerClick = function(editMode, readMode) {
            var onClick = function(event) {
                editMode.classList.toggle("hidden");
                readMode.classList.toggle("hidden");
                event.preventDefault();
            };
            readMode.querySelector("button").addEventListener("click", onClick);
            editMode.querySelector("button").addEventListener("click", function(event) {
                var input = editMode.querySelector("input");
                readMode.querySelector(".slug").innerHTML = input.value ? input.value : input.dataset.def;
                onClick(event);
            });
        }
        for (var i = 0; i < ul.children.length; i++) {
            registerClick(ul.children[i].querySelector(".edit-mode"), ul.children[i].querySelector(".read-mode"));
        }
    })();

</script>
<body>
<form id="falang-taxonomy-options" action="#" method="POST">
	<?php wp_nonce_field('falang_action', 'falang_taxonomy_option', true, true); ?>
	<input type="hidden" name="taxonomy" value="<?php echo $falang_taxonomy; ?>">
	<input type="hidden" name="action" value="update_settings_taxonomy_options"/>

	<h2><?php echo sprintf(__('%s Language Options', 'falang'), isset($falang_taxonomy_obj->label) ? $falang_taxonomy_obj->label : $falang_taxonomy); ?></h2>

	<table class="form-table">
		<tbody>
		<tr>
			<th><?php echo __('Terms link', 'falang'); ?></th>
			<td>
				<?php
				add_filter('home_url', array($this,'translate_home_url'), 10, 4);
				?>
				<ul id="falang-taxonomy-options-permalink">
					<?php foreach ($falang_model->get_languages_list() as $language) { ?>
						<?php
                        $this->set_language($language);
						$tt = $taxonomy->get_taxonomy_translation($falang_taxonomy, $language);
						$translated_slug = $tt ? $tt : $falang_taxonomy;
						?>
						<li>
							<code><?php echo $language->name; ?></code>
							<span class="read-mode">
									<a class="full-url" target="_blank" href="<?php echo home_url('/'.$translated_slug); ?>"><?php echo home_url('/'); ?><span class="slug"><?php echo $translated_slug; ?></span>/</a>
									<button class="button button-small edit-btn" style="vertical-align: bottom;"><?php echo __('Edit', 'falang'); ?></button>
								</span>
							<span class="edit-mode hidden"><?php echo home_url('/'); ?>
								<input type="text" class="text-input" name="tax[<?php echo $language->locale; ?>]" value="<?php echo $tt; ?>" data-def="<?php echo $falang_taxonomy; ?>" placeholder="<?php echo $falang_taxonomy; ?>" autocomplete="off" style="padding: 0 3px;">
									<button class="button button-small ok-btn" style="vertical-align: bottom;">ok</button>
								</span>
						</li>
					<?php } ?>
				</ul>
			</td>
		</tr>
		<tr>
			<th><?php echo __('Translatable Taxonomy fields', 'falang'); ?></th>
			<td>
				<ul>
					<li><label><input type="checkbox" name="fields[]" value="name" <?php if (in_array('name', $taxonomy->get_taxonomy_fields($falang_taxonomy))) echo 'checked'; ?>/><?php echo __('Name', 'falang'); ?></label></li>
					<li><label><input type="checkbox" name="fields[]" value="slug" <?php if (in_array('slug', $taxonomy->get_taxonomy_fields($falang_taxonomy))) echo 'checked'; ?>/><?php echo __('Slug', 'falang'); ?></label></li>
					<li><label><input type="checkbox" name="fields[]" value="description" <?php if (in_array('description', $taxonomy->get_taxonomy_fields($falang_taxonomy))) echo 'checked'; ?>/><?php echo __('Description', 'falang'); ?></label></li>
				</ul>
			</td>
		</tr>
		<tr>
			<?php if ($falang_meta_keys) { ?>
				<th><?php echo __('Translatable Term meta', 'falang'); ?></th>
				<td>
					<ul>
						<?php foreach ($falang_meta_keys as $key => $values) { ?>
							<li><label title="value sample: '<?php echo isset($values[0]) ? $values[0] : ''; ?>'"><input type="checkbox" name="meta_keys[]" value="<?php echo $key; ?>" <?php if (in_array($key, $taxonomy->get_taxonomy_metakeys($falang_taxonomy))) echo 'checked'; ?>/><?php echo isset($registered_meta_keys[$key]['description']) && $registered_meta_keys[$key]['description'] ? $registered_meta_keys[$key]['description'] : $key; ?></label></li>
						<?php } ?>
					</ul>
				</td>
			<?php } ?>
		</tr>
		</tbody>
	</table>
	<a href="#" onclick="FALANG.SetTaxonomyOptions.sendOptions(this);return false;" class="button"><?php echo __('Save options', 'falang'); ?></a>
</form>
</body>
</html>