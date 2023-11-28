<?php 

$agent_fax = $agent->fax;


$agent_fax_call = str_replace(array('(',')',' ','-'),'', $agent_fax);
if( !empty( $agent_fax ) ) { ?>
	<li>
		<strong>Fax: </strong> 
		<a href="fax:<?php echo esc_attr($agent_fax_call); ?>">
			<span><?php echo esc_attr( $agent_fax ); ?></span>
		</a>
	</li>
<?php } ?>