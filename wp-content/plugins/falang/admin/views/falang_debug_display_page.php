<?php
if ( ! defined( 'ABSPATH' ) ) {exit;} // Don't access directly

//data are prefixed with $falang
$post_id = $falang_post_id;
$post = get_post($post_id);
$post_meta          = get_post_meta( $post_id );

//build patter to filter only falang meta
$pattern = array();
foreach ($this->model->get_languages_list() as $language){
    $pattern[] = '_'.$language->locale.'_';
}

$pattern = '/^('.implode('|',$pattern).')/';
//pattern like  '/^(_en_US_|_fr_FR_|_de_DE_)/'

//filter meta to have only language meta
foreach ($post_meta as $key => $value){
	//remove meta if key don't start by language locale
	if (!preg_match($pattern,$key)){
		unset($post_meta[$key]);
	}
}

?>
<h1>Debug : <?php echo $post_id;?></h1>
<p>Post Type: <?php echo $post->post_type ;?></p>
<table>
    <tbody>
    <tr>
        <th class="key-column"><?php echo __( 'Key', 'falang' ) ?></th>
        <th class="value-column"><?php echo __( 'Value', 'falang' ) ?></th>
    </tr>
<?php  foreach ($post_meta as $meta_key => $meta_value) { ?>
    <tr>
        <td>
            <?php echo esc_html( $meta_key ); ?>
        </td>
        <td>
            <?php
               if (is_serialized($meta_value) && !is_serialized_string($meta_value)){
                   echo esc_html(__( 'Serialized data', 'falang' ));
               } else {
                   echo esc_html($meta_value[0]);
               }
            ?>

        </td>
    </tr>

<?php } ?>
    </tbody>
</table>
