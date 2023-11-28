<div class="features-list-wrap">
	<a class="btn-features-list" data-toggle="collapse" href="#features-list">
		<i class="advmls-icon icon-add-square"></i> <?php echo get_option('srh_other_features', 'Other Features'); ?>
	</a><!-- btn-features-list -->
	<div id="features-list" class="collapse">
		<div class="features-list">
			<div class="d-flex mb-2">
				<?php include_once($pathTemplate.'search/fields/parking.php'); ?>
				<?php include_once($pathTemplate.'search/fields/with-pool.php'); ?>
				<?php include_once($pathTemplate.'search/fields/with-yard.php'); ?>
			</div>

		</div><!-- features-list -->
	</div><!-- collapse -->
</div><!-- features-list-wrap -->