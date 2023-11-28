<?php
global $agent;
if(!empty($agent->company_name)) {
?>
<p class="agent-list-position"> 
	Company Agent at:  <?php echo $agent->company_name; ?>
</p>
<?php } ?>