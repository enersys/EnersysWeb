<?php
/**
 * The template for displaying all single posts
 *
 *
 * @subpackage techup
 * @since techup
 */
get_header();
?>
<div class="sp-100 bg-w">
	<div class="container">
		<div class="row">
			<?php if( is_active_sidebar( 'blog-sidebar' ) ){ ?>
				<div class="col-lg-8">
			<?php }else{ ?>
				<div class="col-lg-12">
			<?php } ?>
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'single' );
					endwhile;?>
					<div class="pagination-blog mt-4 mb-60">
					<?php  techup_single_post_navigation();  ?>
					</div>
					  <?php
				else :
				get_template_part( 'template-parts/content', 'none' );
     			endif;
				if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif; ?>
		</div>
		<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php
get_footer();
?>