<?php 

$agent_office_num = $agent->phone;

$agent_office_call = str_replace(array('(',')',' ','-'),'', $agent_office_num);

if( !empty($agent_office_num) ) { ?>
    <li>
    	<strong>Phone: </strong> 
    	<a href="tel:<?php echo esc_attr($agent_office_call); ?>">
	    	<span class="agent-phone"><?php echo esc_attr( $agent_office_num ); ?></span>
	    </a>
    </li>
<?php } ?>