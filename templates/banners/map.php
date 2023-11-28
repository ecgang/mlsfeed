<!-- top-banner-wrap-fullscreen -->
<section class="top-banner-wrap map-banner <?php advmls_banner_fullscreen(); ?>">
	
	<div class="map-wrap">
		<?php get_template_part('template-parts/map-buttons'); ?>
		
		<div id="advmls-properties-map"></div>	
		
	</div>

	<?php
	if(advmls_option('adv_search_which_header_show')['header_map'] != 0) {
		get_template_part('template-parts/search/dock-search-main');
	}
	?>
</section><!-- top-banner-wrap -->