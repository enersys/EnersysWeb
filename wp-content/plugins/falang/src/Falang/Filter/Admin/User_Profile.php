<?php
/**
 * Add User Profile Description translation
 *
 * @since 1.3.4
 */


namespace Falang\Filter\Admin;

use Falang\Filter\Filters;

class User_Profile extends Filters {

	public function __construct( &$falang ) {

		parent::__construct($falang);
		// add description for each language
		add_action('show_user_profile', array($this, 'add_profile_translation'), 10, 1);
		add_action('edit_user_profile', array($this, 'add_profile_translation'), 10, 1);

		// save description for each language
		add_action('personal_options_update', array($this, 'save_user_profile'));
		add_action('edit_user_profile_update', array($this, 'save_user_profile'));

	}

	/**
	 * Updates language user preference set in user profile
	 *
	 * @since 1.3.4
	 *
	 * @param int $user_id
	 */
	public function save_user_profile($user_id) {
		foreach ( Falang()->get_model()->get_languages_list(array('hide_default' => true)) as $language ) {
		    $key = '_'.$language->locale.'_description';
			if (isset($_POST[$key])){
				$description = empty( $_POST[$key] ) ? '' : trim( $_POST[ $key] ); // phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput

				/** This filter is documented in wp-includes/user.php */
				$description = apply_filters( 'pre_user_description', $description ); // Applies WP default filter wp_filter_kses
				update_user_meta($user_id, $key, $description);
			} else {
				delete_user_meta($user_id, $key);
            }
        }
	}

	/**
	 * Add description for each language
	 *
	 * @since 1.3.4
	 *
	 * @param int $user_id
	 */
	public function add_profile_translation($user) {
		?>

		<h2><?php echo __('Translations', 'falang'); ?></h2>
		<table class="form-table" role="presentation">
            <?php

            foreach ( Falang()->get_model()->get_languages_list(array('hide_default' => true)) as $language ) { ?>
            <tr>
                <th>
                    <label for="description"><?php _e( 'Biographical Info' );echo ' '.$language->get_flag(); ?></label>
                </th>
                <!-- label is name displayed-->
                <td>
                    <div style="display:flex;display: -webkit-flex;flex-wrap:wrap;-webkit-flex-wrap:wrap">
                        <div style="margin-bottom:1em;  width:100%">
                            <?php
                            $key = '_'.$language->locale.'_description';
                            $description = apply_filters( 'user_description', get_user_meta( $user->ID, $key, true ) ); // Applies WP default filter wp_kses_data
                            ?>
                            <textarea name="<?php echo $key;?>" id="<?php echo $key;?>" class="biography" rows="5" cols="30"><?php echo $description;?></textarea>
                        </div>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
        <?php
	}
}