<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @subpackage techup
 * @since techup 1.0
 */

?>

<?php
	if( ! is_front_page() ) {
?>             
			</div> 
		</div> 
	 </div> 
<?php
	}
/*
 * techup_footer hooks
 * 
 * @hooked - techup_footer_start - 5
 * @hooked - techup_footer_site_info - 10
 * @hooked - techup_footer_nav_menu - 15
 * @hooked - techup_footer_end - 20
 *
 */
do_action( 'techup_footer' );
 if( is_front_page() ){
		echo '</div>';
	} ?>

</div> 

<?php wp_footer(); ?>

</body>
</html>