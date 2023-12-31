<?php global $ele_thumbnail_size; ?>
<div class="item-listing-wrap hz-item-gallery-js item-listing-wrap-v4 card" <?php advmls_property_gallery('advmls-item-image-4'); ?>>
	<div class="item-wrap item-wrap-v4 h-100">
		<div class="d-flex align-items-center h-100">
			<div class="item-header">
				<?php get_template_part('template-parts/listing/partials/item-featured-label'); ?>
				<?php get_template_part('template-parts/listing/partials/item-labels'); ?>
				<?php get_template_part('template-parts/listing/partials/item-price'); ?>
				<?php get_template_part('template-parts/listing/partials/item-tools'); ?>
				<?php get_template_part('template-parts/listing/partials/item-image-v4'); ?>
				<div class="preview_loader"></div>
			</div><!-- item-header -->	
			<div class="item-body flex-grow-1">
				<?php get_template_part('template-parts/listing/partials/item-labels'); ?>
				<?php get_template_part('template-parts/listing/partials/item-title'); ?>
				<?php get_template_part('template-parts/listing/partials/item-price'); ?>
				<?php get_template_part('template-parts/listing/partials/item-address'); ?>
				<?php get_template_part('template-parts/listing/partials/item-features-v1'); ?>
				<?php get_template_part('template-parts/listing/partials/item-btn'); ?>
				<?php get_template_part('template-parts/listing/partials/item-author'); ?>
				<?php get_template_part('template-parts/listing/partials/item-date'); ?>
			</div><!-- item-body -->

			<?php if(advmls_option('disable_date', 1) || advmls_option('disable_agent', 1)) { ?>
			<div class="item-footer clearfix">
				<?php get_template_part('template-parts/listing/partials/item-author'); ?>
				<?php get_template_part('template-parts/listing/partials/item-date'); ?>
			</div>
			<?php } ?>
		</div><!-- d-flex -->
	</div><!-- item-wrap -->
</div><!-- item-listing-wrap -->