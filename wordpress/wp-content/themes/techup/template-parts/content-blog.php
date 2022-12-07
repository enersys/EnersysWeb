<?php
/**
 * Template part for displaying section of blog content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @subpackage techup
 * @since 1.0
 */

$techup_enable_blog_section = get_theme_mod( 'techup_enable_blog_section', true );
$techup_blog_cat 		= get_theme_mod( 'techup_blog_cat', 'uncategorized' );
if($techup_enable_blog_section == true) {
$techup_blog_title 	= get_theme_mod( 'techup_blog_title', __( '', 'techup' ) );
$techup_blog_subtitle 	= get_theme_mod( 'techup_blog_subtitle' );
$techup_rm_button_label 	= get_theme_mod( 'techup_rm_button_label', __( '', 'techup' ) );
$techup_blog_count 	 = apply_filters( 'techup_blog_count', 3 );

?>
<!-- blog start-->
<section class="blog-5">
	<div class="container">
	  <div class="section-title-5">
	  <?php if($techup_blog_title) : ?>
		<h2><?php echo esc_html( $techup_blog_title ); ?></h2>
		<div class="separator">
		  <ul>
			<li></li>
		  </ul>
		</div>
		<?php endif; ?>
		<?php if($techup_blog_subtitle) :?>
			<p><?php echo esc_html( $techup_blog_subtitle ); ?></p>
		<?php endif; ?>
	</div>
		<div class="row">
			<?php 
			if( !empty( $techup_blog_cat ) ) 
				{
				$blog_args = array(
					'post_type' 	 => 'post',
					'category_name'	 => esc_attr( $techup_blog_cat ),
					'posts_per_page' => absint( $techup_blog_count ),
				);

				$blog_query = new WP_Query( $blog_args );
				if( $blog_query->have_posts() ) {
					while( $blog_query->have_posts() ) {
						$blog_query->the_post();
			?>
			  <div class="col-lg-4">
				<article class="blog-item blog-1">
					<div class="post-img">
						<?php the_post_thumbnail(); ?>
					</div>
					<div class="post-content pt-4 text-left">
						<h5>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h5>
						 <?php the_excerpt(); ?> 
						<?php if($techup_rm_button_label) :?>
							<div class="btn-wraper">
							  <a href="<?php the_permalink(); ?>" class="read-more-btn"><?php echo esc_html($techup_rm_button_label); ?></a>
							</div>
					<?php endif; ?>	
					</div>
				</article>
			  </div>
		  <?php
				}
			}
			wp_reset_postdata();
		}
		 ?>
		</div>
	</div>
</section>
<!-- blog end-->
<?php } ?>