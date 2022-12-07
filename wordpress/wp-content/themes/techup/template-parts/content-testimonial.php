<?php 
$techup_enable_testimonial_section = get_theme_mod( 'techup_enable_testimonial_section', false );
$techup_testimonial_title= get_theme_mod( 'techup_testimonial_title','What People Say');
$techup_testimonial_subtitle= get_theme_mod( 'techup_testimonial_subtitle');

if($techup_enable_testimonial_section == true ) {
	$techup_testimonials_no        = 6;
	$techup_testimonials_pages      = array();
	for( $i = 1; $i <= $techup_testimonials_no; $i++ ) {
		 $techup_testimonials_pages[] = get_theme_mod('techup_testimonial_page'.$i);
	}
	$techup_testimonials_args  = array(
	'post_type' => 'page',
	'post__in' => array_map( 'absint', $techup_testimonials_pages ),
	'posts_per_page' => absint($techup_testimonials_no),
	'orderby' => 'post__in'
	); 
	$techup_testimonials_query = new WP_Query( $techup_testimonials_args );
?>
  <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials-5">
      <div class="container">
        <div class="section-title-5">
		<?php if($techup_testimonial_title) : ?>
          <h2><?php echo esc_html($techup_testimonial_title); ?></h2>
          <div class="separator">
            <ul>
              <li></li>
            </ul>
          </div>
		   <?php endif; ?>
		   <?php if($techup_testimonial_subtitle) :?>
				<p><?php echo esc_html($techup_testimonial_subtitle); ?></p>
			<?php endif; ?>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div class="owl-carousel testimonials-carousel">
              <?php
				$count = 0;
				while($techup_testimonials_query->have_posts() && $count <= 5 ) :
				$techup_testimonials_query->the_post();
			 ?>
			  
			  <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <i class="fa fa-quote-left"></i>
                  <img src="<?php echo  esc_url(get_the_post_thumbnail_url()) ;?>" class="testimonial-img" alt="<?php echo esc_html(get_post_thumbnail_id()); ?>">
                  <?php the_excerpt(); ?>
                  <h3><?php the_title(); ?></h3>
                </div>
              </div>
               <?php
					$count = $count + 1;
					endwhile;
					wp_reset_postdata();
				?> 
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Testimonials Section -->
<?php } ?>