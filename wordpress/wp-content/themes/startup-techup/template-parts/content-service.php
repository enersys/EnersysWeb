<?php 
$techup_enable_service_section = get_theme_mod( 'techup_enable_service_section', false );
$techup_service_title = get_theme_mod( 'techup_service_title');
$techup_service_subtitle = get_theme_mod( 'techup_service_subtitle' );
if($techup_enable_service_section==true ) {


        $techup_services_no        = 6;
        $techup_services_pages      = array();
        for( $i = 1; $i <= $techup_services_no; $i++ ) {
             $techup_services_pages[] = get_theme_mod('techup_service_page '.$i); 
             $techup_service_icon[]= get_theme_mod('techup_service_icon '.$i,'fa fa-user');
        }
        $techup_services_args  = array(
        'post_type' => 'page',
        'post__in' => array_map( 'absint', $techup_services_pages ),
        'posts_per_page' => absint($techup_services_no),
        'orderby' => 'post__in'
        ); 
        $techup_services_query = new WP_Query( $techup_services_args );
      

?>
    <!--Start Service-->
    <section class="service-section startup-service">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.2s">
            <div class="common-heading">
			    <?php if($techup_service_title) : ?>	
					<span><?php echo esc_html($techup_service_title); ?></span>
				<?php endif; ?>	
				<?php if($techup_service_subtitle) : ?>	
					<h2 class="mb-30"><?php echo esc_html($techup_service_subtitle); ?></h2>
				<?php endif; ?>	
            </div>
          </div>
        </div>
        <div class="row link-hover justify-content-center">
			<?php
			$count = 0;
			while($techup_services_query->have_posts() && $count <= 8 ) :
			$techup_services_query->the_post();
			?>
			  <div class="col-lg-3 col-md-6 col-sm-6 mt-30 wow fadeInUp" data-wow-delay="0.2s">
				<div class="service-box">
				  <div class="service-icon">
					<i class="fa <?php echo esc_attr($techup_service_icon[$count]); ?>"></i>
				  </div>
				  <h4><?php the_title(); ?></h4>
				  <p><?php echo esc_html(get_the_excerpt()); ?></p>
				  <a href="<?php the_permalink(); ?>"><?php echo esc_html('Know More','startup-techup'); ?> <i class="fa fa-chevron-right fa-icon"></i></a>
				</div>
			  </div>
			<?php
			$count = $count + 1;
			endwhile;
			wp_reset_postdata();
			?>    
        </div>
      </div>
    </section>
    <!-- End Services Section -->
<?php } ?>