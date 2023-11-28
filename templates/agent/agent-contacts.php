<?php
$agent_address = get_post_meta( get_the_ID(), 'fave_agent_address', true );
?>
<div class="agent-contacts-wrap">
	<h3 class="widget-title"><?php esc_html_e('Contact', 'advmls'); ?></h3>
	<div class="agent-map">
		<?php get_template_part('template-parts/realtors/agent/image'); ?>
		<?php get_template_part('template-parts/realtors/agent/address'); ?>
	</div>
	<ul class="list-unstyled">
		<?php 
		if( advmls_option('agent_phone', 1) ) {
			get_template_part('template-parts/realtors/agent/office-phone'); 
		} 

		if( advmls_option('agent_mobile', 1) ) {
			get_template_part('template-parts/realtors/agent/mobile'); 
		}

		if( advmls_option('agent_fax', 1) ) {
			get_template_part('template-parts/realtors/agent/fax'); 
		} 

		if( advmls_option('agent_email', 1) ) {
			get_template_part('template-parts/realtors/agent/email'); 
		}

		if( advmls_option('agent_website', 1) ) {
		 	get_template_part('template-parts/realtors/agent/website'); 
		}
		?>
	</ul>

	<?php 
	if( advmls_option('agent_social', 1) ) { 
		get_template_part('template-parts/realtors/agent/social', 'v2'); 
	} ?>
</div><!-- agent-bio-wrap -->