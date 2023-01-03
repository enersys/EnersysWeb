<?php
/**
*  Displays the Association fields for page
 * @since 1.3.24
*/

if ( ! defined( 'ABSPATH' ) ) {exit;} // Don't access directly

$falang_model = Falang()->get_model();
$admin_links = new \Falang\Core\Admin_Links();

?>
<div id="meta-select-association" style="<?php echo empty($locale)?'display:none':'';?>">
    <p><strong><?php esc_html_e( 'Association', 'falang' ); ?></strong></p>
    <?php
	foreach ( $falang_model->get_languages_list(array('hide_default' => false)) as $language ) {
	        //not display link for the selected language
            if ($language->locale == $locale){
                continue;
            }
		    echo '<span>'.$language->get_flag().'</span> ';
            echo $admin_links->display_post_association_list( $post_id, $language );
            echo '<br/>';
	}
    ?>

</div>
