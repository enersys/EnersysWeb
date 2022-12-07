<?php
$techup_enable_callout_section = get_theme_mod( 'techup_enable_callout_section', false );
$techup_co2_image = get_theme_mod( 'techup_co2_image' );

if($techup_enable_callout_section == true ) {
   
$techup_callout_title = get_theme_mod( 'techup_callout_title');
$techup_callout_content = get_theme_mod( 'techup_callout_content');
$techup_callout_button_label1 = get_theme_mod( 'techup_callout_button_label1');
$techup_callout_button_link1 = get_theme_mod( 'techup_callout_button_link1');
if($techup_co2_image=="")
{
	$techup_co2_image = esc_url(  get_template_directory_uri() . '/assets/images/banner.jpg' ); 
}
?>
<section class="cta-6" style="background-image:url(<?php echo $techup_co2_image; ?>)">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2><?php echo esc_html($techup_callout_title); ?></h2>
				<p class="c-white mb-0"><?php echo esc_html($techup_callout_content); ?></p>
				<?php if(!empty($techup_callout_button_label1 && $techup_callout_button_link1)): ?>
					<a href="<?php echo esc_url($techup_callout_button_link1); ?>" class="btn-2 mt-3"><?php echo esc_html($techup_callout_button_label1); ?></a>
				<?php endif; ?>	
			</div>
		</div>
	</div>
</section>

<?php } ?>