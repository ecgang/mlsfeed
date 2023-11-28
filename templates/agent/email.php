<?php 
$agent_email = $agent->email;

if( !empty( $agent_email ) ) { ?>
    <li class="email">
    	<strong>Email: </strong> 
    	<a href="mailto:<?php echo esc_attr( $agent_email ); ?>"><?php echo esc_attr( $agent_email ); ?></a>
    </li>
<?php } ?>