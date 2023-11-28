<?php 
global $property;
$open_house =  isset($property->open_house) ? $property->open_house : array(); 
?>

<?php if (count($open_house) > 0) { ?>
<div class="content-open border-top border-bottom p-2">
	<p class="text-left p-0 m-0">
		<strong>Open House</strong>
	</p>
		<?php 

			foreach ($open_house as $key => $open) {
				echo '<p class="text-left pb-1 mb-1"><i class="far fa-clock"></i> <strong> From: </strong>'.advmls_the_date($open->start_from, 'jS \of M Y h:i A').' - '. '<strong>To: </strong>'.advmls_the_date($open->end_to, 'jS \of M Y h:i A').'</p>';
			}
		?>
</div>
<?php } ?>