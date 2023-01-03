<table class="form-table">
	<tbody>
    <tr>
        <th><?php _e('Version', 'falang'); ?></th>
        <td>
            <label>
                <p><?php echo $falang_version;?></p>
            </label>
        </td>
    </tr>
	<tr>
		<th><?php _e('Show slug for main language', 'falang'); ?></th>
		<td>
			<label>
				<input type="checkbox" name="show_slug" value="1"<?php echo $falang_model->get_option('show_slug') ? ' checked' : '' ?>/>
				<?php _e('Show slug for main language', 'falang') ?>
			</label>
		</td>
	</tr>
	<tr>
		<th><?php _e('Auto-detect language', 'falang'); ?></th>
		<td>
			<label>
				<input type="checkbox" name="autodetect" value="1"<?php echo $falang_model->get_option('autodetect') ? ' checked' : ''; ?>/>
				<?php _e('Auto-detect language when language is not specified in url', 'falang'); ?>
			</label>
            <p class="description">
                <?php _e('(need show slug for main language)','falang') ?>
            </p>
		</td>
	</tr>
    <tr>
        <th><?php _e('Flags size', 'falang'); ?></th>
        <td>
            <label>
                <input type="text" name="flag_width" size="2" value="<?php echo $falang_model->get_option('flag_width','16'); ?>" /><span>&nbsp;x&nbsp;</span>
                <input type="text" name="flag_height" size="2" value="<?php echo $falang_model->get_option('flag_height','11'); ?>" />
                <?php _e('Customize flags size (default 16x11)', 'falang'); ?>
            </label>
        </td>
    </tr>
    <tr>
        <th><?php _e('Translation Service', 'falang'); ?></th>
        <td>
            <label>
                <input type="checkbox" name="enable_service"  id="enable_service" value="1" <?php echo $falang_model->get_option('enable_service') ? ' checked' : ''; ?>/>
				<?php _e('Enable Translation Service', 'falang'); ?>
            </label>
        </td>
    </tr>
    <tr>
        <th><?php _e('Service name', 'falang'); ?></th>
        <td>
            <select id="service_name" name="service_name" title="Service" class=" required-entry select">
                <option value="google" <?php if ( $falang_model->get_option('service_name') == 'google' ): ?>selected="selected"<?php endif; ?>><?php echo __('Google','falang'); ?></option>
                <option value="azure" <?php if ( $falang_model->get_option('service_name') == 'azure' ): ?>selected="selected"<?php endif; ?>><?php echo __('Bing / Azure','falang'); ?></option>
                <option value="yandex" <?php if ( $falang_model->get_option('service_name') == 'yandex' ): ?>selected="selected"<?php endif; ?>><?php _e('Yandex','falang'); ?></option>
                <option value="lingvanex" <?php if ( $falang_model->get_option('service_name') == 'lingvanex' ): ?>selected="selected"<?php endif; ?>><?php echo __('Lingvanex','falang'); ?></option>
            </select>
	        <?php  \Falang\Core\Falang_Core::falang_tooltip(__('Select Translation Service', 'falang')); ?>
        </td>
    </tr>
    <tr>
        <th><?php _e('Google translate API Key', 'falang'); ?></th>
        <td>
            <label>
                <input type="text" size="40" name="google_key" value="<?php echo $falang_model->get_option('google_key',''); ?>" />
                <?php  \Falang\Core\Falang_Core::falang_tooltip('Sign-up at Google Cloud access key to the Translator API service at <a href=\'https://cloud.google.com/translate\' target="_blank">https://cloud.google.com/translate</a>'); ?>
            </label>
        </td>
    </tr>
    <tr>
        <th><?php _e('Microsoft Azure API Key', 'falang'); ?></th>
        <td>
            <label>
                <input type="text" size="40" name="azure_key" value="<?php echo $falang_model->get_option('azure_key',''); ?>" />
                <?php  \Falang\Core\Falang_Core::falang_tooltip('Sign-up at Microsoft Bing Azure for a free access key to the Translator API service at <a href=\'https://www.microsoft.com/en-us/translator/getstarted.aspx\' target="_blank">https://www.microsoft.com/en-us/translator/getstarted.aspx</a>'); ?>
            </label>
        </td>
    </tr>
    <tr>
        <th><?php _e('Yandex API Key', 'falang'); ?></th>
        <td>
            <label>
                <input type="text" size="40" name="yandex_key" value="<?php echo $falang_model->get_option('yandex_key',''); ?>" />
                <?php  \Falang\Core\Falang_Core::falang_tooltip('Sign-up at Yandex for a free access key to the Translator API service at <a href=\'https://tech.yandex.com/translate/\' target="_blank">https://tech.yandex.com/translate/</a>'); ?>
            </label>
        </td>
    </tr>
    <tr>
        <th><?php _e('Lingvanex API Key', 'falang'); ?></th>
        <td>
            <label>
                <input type="text" size="40" name="lingvanex_key" value="<?php echo $falang_model->get_option('lingvanex_key',''); ?>" />
                <?php  \Falang\Core\Falang_Core::falang_tooltip('Sign-up at Lingvanex for a free access key to the Translator API service at <a href=\'https://lingvanex.com/\' target="_blank">https://lingvanex.com/</a>'); ?>
            </label>
        </td>
    </tr>
    <tr>
        <th><?php _e('Association', 'falang'); ?></th>
        <td>
            <label>
                <input type="checkbox" name="association" value="1" <?php echo $falang_model->get_option('association') ? ' checked' : ''; ?>/>
                <?php _e('Enable associations (for pages only - advanced users!)', 'falang'); ?>
            </label>
        </td>
    </tr>
    <tr>
        <th><?php echo __('Use AJAX in Front-End', 'falang'); ?></th>
        <td>
            <label>
                <input type="checkbox" name="frontend_ajax" value="1"<?php echo $falang_model->get_option('frontend_ajax') ? ' checked' : ''; ?>/>
                <?php echo __('Add language parameter to AJAX queries (using jQuery)', 'falang'); ?>
            </label>
        </td>
    </tr>
    <tr>
        <th><?php echo __('Keep paragraph tags in the Classic block and the Classic Editor', 'falang'); ?></th>
        <td>
            <label>
                <input type="checkbox" name="no_autop" value="1"<?php echo $falang_model->get_option('no_autop') ? ' checked' : ''; ?>/>
                <?php echo __('Stop removing &lt;p&gt; and &lt;br&gt; tags in the Classic Editor and show them in the Text tab.', 'falang'); ?>
            </label>
        </td>
    </tr>    <tr>
        <th><?php _e('Debug admin', 'falang'); ?></th>
        <td>
            <label>
                <input type="checkbox" name="debug_admin" value="1" <?php echo $falang_model->get_option('debug_admin') ? ' checked' : ''; ?>/>
			    <?php _e('View debug info in admin section', 'falang'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th><?php _e('Delete Translations on uninstall', 'falang'); ?></th>
        <td>
            <label>
                <input type="checkbox" name="delete_trans_on_uninstall" value="1"<?php echo $falang_model->get_option('delete_trans_on_uninstall') ? ' checked' : ''; ?>/>
		        <?php _e('Delete all translations when Falang is uninstalled', 'falang'); ?>
            </label>
        </td>
    </tr>
    </tbody>
</table>
