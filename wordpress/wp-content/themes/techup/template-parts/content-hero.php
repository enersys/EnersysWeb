<?php
/**
 * Template part for displaying section of banner content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @subpackage techup
 * @since 1.0 
 */
$techup_enable_banner_section = get_theme_mod( 'techup_enable_banner_section', true );
$techup_banner_image = get_theme_mod( 'techup_banner_image', esc_url(  get_template_directory_uri() . '/assets/images/banner.jpg' ) );
$techup_banner_title = get_theme_mod( 'techup_banner_title','');
$techup_banner_content = get_theme_mod( 'techup_banner_content','');
$techup_banner_button_label1 = get_theme_mod( 'techup_banner_button_label1','');
$techup_banner_button_link1 = get_theme_mod( 'techup_banner_button_link1','');
      
if($techup_enable_banner_section==true ) {
?>  
<!-- ======= Hero Section ======= -->
<section class="home5-hero-sec" style="background-image:url(<?php if($techup_banner_image) { echo $techup_banner_image; } else { echo get_header_image(); } ?>)">
    <div class="section-title-wraper">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <h2 class="section-title-2"><?php echo esc_html($techup_banner_title); ?></h2>
            <p><?php echo esc_html($techup_banner_content); ?></p>
			<?php if($techup_banner_button_label1) :?>
				<a href="<?php echo esc_url($techup_banner_button_link1); ?>" class="btn-2"><?php echo esc_html($techup_banner_button_label1); ?></a>
			<?php endif; ?>	
          </div>
        </div>
      </div>
    </div>
</section>
 
<?php
}
?>