<?php 
$agent_website = $agent->skype;

if( !empty( $agent_website ) ) { ?>
	<li>
		<strong>Website: </strong> 
		<a target="_blank" href="<?php echo esc_url($agent_website); ?>"><?php echo esc_attr( $agent_website ); ?></a>
	</li>
<?php } ?>