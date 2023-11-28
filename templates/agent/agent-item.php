<?php 
global $agent;
$urlAgentDetail = mlsUrlFactory::getInstance()->getAgentDetailUrl(true);
$urlAgentDetail = $urlAgentDetail.$agent->alias;
?>
<div class="agent-item">
	<div class="agent-thumb">
		<a href="<?php echo $urlAgentDetail; ?>">
			<img width="150" height="150" src="<?php echo $agent->url_photo.$agent->photo; ?>" class="img-fluid rounded-circle wp-post-image" alt="" loading="lazy" sizes="(max-width: 150px) 100vw, 150px">
		</a>
	</div>

	<div class="agent-info">
		<div class="agent-name">
			<a href="<?php echo $urlAgentDetail; ?>">
				<strong><?php echo $agent->name; ?></strong>
			</a>
		</div>

		<div class="agent-company">
			<strong><?php echo $agent->company_name; ?></strong>
		</div>
	</div>
	<div class="agent-body">
		<?php echo substr( strip_tags($agent->bio), 0, 100) ; ?>

	</div>
	<div class="agent-link">
		<a href="<?php echo $urlAgentDetail; ?>"><?php echo 'view profile'; ?></a>
	</div>
</div>