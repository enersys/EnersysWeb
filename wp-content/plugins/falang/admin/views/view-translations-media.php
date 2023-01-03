<?php
/**
 * Displays the translations fields for media
 * @since 1.3.24 div in this file
 */

if ( ! defined( 'ABSPATH' ) ) {exit;} // Don't access directly

$falang_model = Falang()->get_model();
$admin_links = new \Falang\Core\Admin_Links();

?>
<div id="meta-post-translations" style="<?php echo empty($locale)?'':'display:none';?>">

<p><strong><?php esc_html_e( 'Translations', 'falang' ); ?></strong></p>
</div>