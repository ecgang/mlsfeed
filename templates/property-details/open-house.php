<?php $open_house = $this->getDataDetails('open_house') ? $this->getDataDetails('open_house') : array(); ?>
<?php if( count($open_house) > 0 ){ ?>
	<div class="property-open-house-wrap property-section-wrap" id="property-open-house-wrap">
		<div class="block-wrap">
			<div class="block-title-wrap">
				<h2><?php echo 'Open House'; ?></h2>	
			</div>
			<div class="block-content-wrap">
				<?php
					foreach ($open_house as $key => $open) {
					echo '<p class="text-left pb-1 mb-1 border-bottom"><i class="far fa-clock"></i></i> <strong> From: </strong>'.advmls_the_date($open->start_from, 'jS \of M Y h:i A').' - '. '<strong>To: </strong>'.advmls_the_date($open->end_to, 'jS \of M Y h:i A').'</p>';
					}
				?>
			</div>
		</div>
	</div>
<?php } ?>