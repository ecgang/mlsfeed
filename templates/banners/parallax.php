<?php 
global $post;
$image_id = get_post_meta($post->ID, 'fave_page_header_image', true);
$img_url = wp_get_attachment_image_src( $image_id, 'full' );
$is_dock_search = '';
if(advmls_option('adv_search_which_header_show')['header_image'] != 0) {
	$is_dock_search = advmls_dock_search_class();
}
?>
<section class="top-banner-wrap <?php echo esc_attr($is_dock_search); ?> <?php advmls_banner_fullscreen(); ?> <?php advmls_banner_search_type(); ?>">
	
	<?php advmls_banner_search_autocomplete_html(); ?>
	
	<div class="banner-inner parallax d-flex" data-parallax-bg-image="<?php echo esc_url($img_url[0]); ?>">
		<div class="align-self-center flex-fill">
			<div class="banner-caption">
				
				<?php get_template_part('template-parts/banners/partials/caption'); ?>

				<?php get_template_part('template-parts/search/search-for-banners'); ?>

			</div><!-- banner-caption -->
		</div><!-- align-self-center -->
	</div><!-- banner-inner parallax -->

	<?php 
	if(advmls_option('adv_search_which_header_show')['header_image'] != 0) {
		get_template_part('template-parts/search/dock-search-main');
	}
	?>

</section><!-- top-banner-wrap -->