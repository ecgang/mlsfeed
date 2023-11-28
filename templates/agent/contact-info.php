<?php ?>
<div class="agent-list-wrap pl-0 pt-2">
	<div class="d-block">

		<ul class="agent-list-contact list-unstyled">
			
			<?php
			if( get_option('advmls_agent_phone', 1) ) {
				include($pathTemplate.'agent/office-phone.php'); 
			} 

			if( get_option('advmls_agent_mobile', 1) ) {
				include($pathTemplate.'agent/mobile.php'); 
			}

			if( get_option('advmls_agent_fax', 1) ) {
				include($pathTemplate.'agent/fax.php'); 
			} 

			if( get_option('advmls_agent_email', 1) ) {
				include($pathTemplate.'agent/email.php'); 
			}

			if( get_option('advmls_agent_web', 1) ) {
				include($pathTemplate.'agent/website.php'); 
			}
			?>
		</ul>

	</div>
</div>