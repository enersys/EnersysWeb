<?php
add_thickbox();
$falang_model = $this->model;
?>
<table class="form-table">
	<tbody>
	<tr>
		<th><?php echo __('Translate Post Types', 'falang'); ?></th>
		<td>
			<?php
			$falang_post = new \Falang\Core\Post();
			$falang_taxonomy = new \Falang\Core\Taxonomy();
			$cpts = get_post_types(array(
			), 'objects' );
			?>
			<?php if (isset($cpts)) { ?>
				<ul>
					<?php foreach ($cpts as $post_type) { ?>
						<?php if ($post_type->name === 'revision' || $post_type->name === 'language') continue; ?>
						<li><input type="checkbox" id="<?php echo $this->model->option_name.'-cpt-'.$post_type->name; ?>" name="post_type[]" value="<?php echo $post_type->name; ?>" <?php if ($falang_post->is_post_type_translatable($post_type->name)) echo 'checked'; ?>/>
							<label for="<?php echo $this->model->option_name.'-cpt-'.$post_type->name; ?>"><?php echo (isset($post_type->labels->name) ? $post_type->labels->name : $post_type->name); ?></label>
							<?php if ($falang_post->is_post_type_translatable($post_type->name)) { ?>
								|
								<?php if ($post_type->name === 'nav_menu_item' /*|| in_array($post_type->name, $this->model->extra_post_types)*/) { ?>
									<a class="thickbox" href="<?php echo admin_url('admin-ajax.php?') . 'action=falang_settings_post_options&width=800&height=620&post_type='.$post_type->name.'&page=' . $post_type->name . '_language_option'; ?>"><?php echo __('Options', 'falang'); ?></a>
								<?php } else { ?>
									<a class="thickbox" href="<?php echo admin_url('admin-ajax.php?').'action=falang_settings_post_options&width=800&height=620&'.($post_type->name === 'post' ? '' : 'post_type='.$post_type->name.'&') . 'page=' . $post_type->name . '_language_option'; ?>"><?php echo __('Options', 'falang'); ?></a>
								<?php } ?>
							<?php } ?>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<th><?php echo __('Translate Taxonomies', 'falang'); ?></th>
		<td>
			<?php
			$taxonomies = get_taxonomies(array(
				'show_ui' => true
			), 'objects');
			?>
			<?php if (isset($taxonomies)) { ?>
				<ul>
					<?php foreach ($taxonomies as $taxonomy) { ?>
						<li>
                            <!-- need to use taxo name and not taxonomy-->
							<input type="checkbox" name="taxo[]" value="<?php echo $taxonomy->name; ?>" id="<?php echo $this->model->option_name.'-taxi-'.$taxonomy->name; ?>" <?php if ($falang_taxonomy->is_taxonomy_translatable($taxonomy->name)) echo 'checked'; ?>/>
							<label for="<?php echo $this->model->option_name.'-taxi-'.$taxonomy->name; ?>"><?php echo (isset($taxonomy->labels->name) ? $taxonomy->labels->name : $taxonomy->name); ?></label>
							<?php if ($falang_taxonomy->is_taxonomy_translatable($taxonomy->name)) { ?>
								|
								<a class="thickbox"  href="<?php echo admin_url('admin-ajax.php?action=falang_settings_taxonomy_options&width=800&height=620&page=' . $taxonomy->name . '_language_option&taxonomy='.$taxonomy->name); ?>">Options</a>
							<?php } ?>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</td>
	</tr>

	</tbody>
</table>