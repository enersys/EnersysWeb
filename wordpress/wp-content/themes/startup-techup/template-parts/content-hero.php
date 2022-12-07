<?php
$techup_enable_banner_section = get_theme_mod( 'techup_enable_banner_section', true );
$techup_banner_image = get_theme_mod( 'techup_banner_image', esc_url(  get_template_directory_uri() . '/assets/images/banner.jpg' ) );
$techup_banner_title = get_theme_mod( 'techup_banner_title','');
$techup_banner_content = get_theme_mod( 'techup_banner_content','');
$techup_banner_button_label1 = get_theme_mod( 'techup_banner_button_label1','');
$techup_banner_button_link1 = get_theme_mod( 'techup_banner_button_link1','');
      
if($techup_enable_banner_section==true ) {
?>  
 	<section class="hero-section startup-hero">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="header-heading">
                <h1 class="wow fadeInUp" data-wow-delay=".2s"><?php echo esc_html($techup_banner_title); ?></h1>
                <p class="wow fadeInUp" data-wow-delay=".4s"><?php echo esc_html($techup_banner_content); ?></p>
				<?php if($techup_banner_button_label1) :?>	
					<a href="<?php echo esc_url($techup_banner_button_link1); ?>" class="btn-main wow fadeInUp" data-wow-delay=".6s"><?php echo esc_html($techup_banner_button_label1); ?><i class="fa fa-chevron-right fa-icon"></i><span class="circle"></span></a>
				<?php endif; ?>
			  </div>
            </div>
            <div class="col-lg-6 align-self-center">
              <div class="single-image wow slideInRight" data-wow-delay=".3s">
                <img src="<?php echo esc_url($techup_banner_image);?>" alt="web development" class="img-fluid" />
              </div>
            </div>
          </div>
        </div>
    </section>
 
<?php
}
?>