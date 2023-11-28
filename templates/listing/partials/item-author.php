<?php 
global $post;
$listing_agent = advmls_get_property_agent( $post->ID ); 

if(advmls_option('disable_agent', 1) && !empty($listing_agent)) { ?>
<div class="item-author">
	<i class="advmls-icon icon-single-neutral mr-1"></i>
	<?php echo implode( ', ', $listing_agent ); ?>
</div><!-- item-author -->
<?php } ?>