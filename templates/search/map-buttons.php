<?php
$advmls_map_system = advmls_get_map_system();
$full_id = 'advmls-gmap-full-osm';
if( $advmls_map_system == 'google') {
	$full_id = 'advmls-gmap-full';
} 
?>
<div class="map-arrows-actions">
	<button id="listing-mapzoomin" class="map-btn"><i class="advmls-icon icon-add"></i></button>
	<button id="listing-mapzoomout" class="map-btn"><i class="advmls-icon icon-subtract"></i></button>
</div><!-- map-arrows-actions -->
<div class="map-next-prev-actions">
	<?php if($advmls_map_system == 'google') { ?>
	<ul class="dropdown-menu" aria-labelledby="advmls-gmap-view">
		<li class="dropdown-item"><a href="#" class="advmlsMapType" data-maptype="roadmap"><span><?php esc_html_e( 'Roadmap', 'advmls' ); ?></span></a></li>
        <li class="dropdown-item"><a href="#" class="advmlsMapType" data-maptype="satellite"><span><?php esc_html_e( 'Satelite', 'advmls' ); ?></span></a></li>
        <li class="dropdown-item"><a href="#" class="advmlsMapType" data-maptype="hybrid"><span><?php esc_html_e( 'Hybrid', 'advmls' ); ?></span></a></li>
        <li class="dropdown-item"><a href="#" class="advmlsMapType" data-maptype="terrain"><span><?php esc_html_e( 'Terrain', 'advmls' ); ?></span></a></li>
	</ul>
	<button id="advmls-gmap-view" class="map-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="advmls-icon icon-earth-1 mr-1"></i> <span><?php esc_html_e( 'View', 'advmls' ); ?></span></button>
	<?php } ?>

	<button id="advmls-gmap-prev" class="map-btn"><i class="advmls-icon icon-arrow-left-1 mr-1"></i> <span><?php esc_html_e('Prev', 'advmls'); ?></span></button>
	<button id="advmls-gmap-next" class="map-btn"><span><?php esc_html_e('Next', 'advmls'); ?></span> <i class="advmls-icon icon-arrow-right-1 ml-1"></i></button>
</div><!-- map-next-prev-actions -->
<div class="map-zoom-actions">
	<div id="<?php echo esc_attr($full_id); ?>" class="map-btn">
		<i class="advmls-icon icon-expand-3 mr-1"></i> <span><?php esc_html_e('Fullscreen', 'advmls'); ?></span>
	</div>
</div><!-- map-zoom-actions -->