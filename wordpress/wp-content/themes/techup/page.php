<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @subpackage techup
 * @since techup
 */
get_header();
if( ! is_front_page() ) 
{ ?>
<div class="sp-100 bg-w">
	<div class="container">
		<div class="row">

			<?php 
			if ( class_exists( 'WooCommerce' ) ) {
				if( (is_account_page() || is_cart() || is_checkout() || is_shop()) && is_active_sidebar( 'woocommerce-widgets' )) {
					echo '<div class="col-lg-8">'; 
				}
				else if(is_account_page() || is_cart() || is_checkout() || is_shop()){ 
					echo '<div class="col-lg-12">';
				}
				else if( is_active_sidebar( 'blog-sidebar' )) {
					echo '<div class="col-lg-8">';
				}
				else{
					echo '<div class="col-lg-12">';
				}
			}
			else if( is_active_sidebar( 'blog-sidebar' )){ 
				echo '<div class="col-lg-8">';
				}
				else{
					echo '<div class="col-lg-12">';
			}
			?>

				<?php
				if ( have_posts() ) :
					if ( is_home() && is_front_page() ) :
						?>
						<header>
							<h1 class="page-title screen-reader-text"><?php the_title(); ?></h1>
						</header>
						<?php
					endif;
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'page' );

					endwhile;?>
				<?php
				else :
            	get_template_part( 'template-parts/content', 'none' );
				endif;
				if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif; ?>
		</div>
		



		<?php if( is_active_sidebar( 'blog-sidebar' ) || is_active_sidebar( 'woocommerce-widgets' )){ 
		 
			if ( class_exists( 'WooCommerce' ) ) {
				if( is_account_page() || is_cart() || is_checkout() || is_shop()) { ?>
					<div class="col-lg-4">
					    <aside class="sidebar mt-5 mt-lg-0">
						  <?php dynamic_sidebar('woocommerce-widgets');  ?>
					    </aside>
					</div>		
				<?php
				}
				else{ 
					get_sidebar();
				}
			}
			else{ 
				get_sidebar(); 
			}
		}
		?>


		</div>
	</div>
</div>
<?php } ?>
<?php
get_footer();
?>