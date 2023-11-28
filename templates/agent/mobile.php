<?php 

$agent_mobile = $agent->mobile;

$agent_mobile_call = str_replace(array('(',')',' ','-'),'', $agent_mobile);
if( !empty( $agent_mobile ) ) { ?>
	<li>
		<strong>Mobile: </strong> 
		<a href="tel:<?php echo esc_attr($agent_mobile_call); ?>">
			<span class="agent-phone"> <?php echo esc_attr( $agent_mobile ); ?></span>
		</a>
	</li>
<?php } ?>