<?php
/**
* Displays the translations fields for posts
 * @since 1.3.24 div in this file
*/

if ( ! defined( 'ABSPATH' ) ) {exit;} // Don't access directly

$falang_model = Falang()->get_model();
$admin_links = new \Falang\Core\Admin_Links();

?>
<div id="meta-post-translations" style="<?php echo empty($locale)?'':'display:none';?>">
    <p><strong><?php esc_html_e( 'Translations', 'falang' ); ?></strong></p>

    <?php
	foreach ( $falang_model->get_languages_list(array('hide_default' => true)) as $language ) {
	    //if ( isset( $locale ) && ( $locale != $language->locale ) ) {
		    $link = $admin_links->display_post_translation_link( $post_id, $language );
		    echo '<span>'.$language->get_flag().'</span> '. $link;
	    //}
	    echo '<br/>';
    }
    ?>

</div>