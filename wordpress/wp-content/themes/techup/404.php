<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @subpackage techup
 * @since techup
 */
get_header();
?>
<section class="error-one bg-dull">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="not-found">
					<h2><?php echo esc_html__('404','techup'); ?></h2>
				</div>
			</div>
		  
			<div class="col-12 mt-4">
				<div class="error-bottom">
					<div class="go-to">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-one">
							<i class="fa fa-home"></i><?php echo esc_html__( 'Visit HomePage','techup'); ?></a>
					</div>
					<span class="or py-4"><?php echo esc_html__('OR','techup'); ?></span>
					<div class="search-box">
					   <?php get_search_form(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();