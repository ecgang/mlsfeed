<?php if(advmls_option('disable_detail_btn', 1)) { ?>
<a class="btn btn-primary btn-item" href="<?php echo esc_url('/listing-details/'.$args->category_name.'/'.$args->pro_alias); ?>">
	<?php echo advmls_option('glc_detail_btn', 'Details'); ?>
</a><!-- btn-item -->
<?php } ?>