<?php 
global $advmls_local;
$languages = get_post_meta( get_the_ID(), 'fave_agent_language', true );

if( !empty( $languages ) ) { ?>
	<p>
		<i class="advmls-icon icon-messages-bubble mr-1"></i>
		<strong><?php echo $advmls_local['languages']; ?>:</strong> 
		<?php echo esc_attr( $languages ); ?>
	</p>
<?php } ?>