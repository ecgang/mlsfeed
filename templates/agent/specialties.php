<?php 
global $advmls_local;
$agent_specialties = get_post_meta( get_the_ID(), 'fave_agent_specialties', true );

if( !empty( $agent_specialties ) ) { ?>
	<li>
		<strong><?php echo $advmls_local['specialties_label']; ?>:</strong> 
		<?php echo esc_attr( $agent_specialties ); ?>
	</li>
<?php } ?>