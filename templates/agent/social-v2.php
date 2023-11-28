<?php
global $agent;
$agent_facebook = $agent->facebook;
$agent_twitter = $agent->aim;
#$agent_linkedin = $agent->;
#$agent_googleplus = $agent->;
$agent_youtube = $agent->msn;
$agent_pinterest = $agent->gtalk;
$agent_instagram = $agent->yahoo;
#$agent_vimeo = $agent->;
#$agent_skype = $agent->;
$agent_mobile = $agent->mobile;
$agent_whatsapp = $agent->phone;

$agent_mobile_call = str_replace(array('(',')',' ','-'),'', $agent_mobile);
$agent_whatsapp_call = str_replace(array('(',')',' ','-'),'', $agent_whatsapp);

if( !empty( $agent_skype ) || !empty( $agent_facebook ) || !empty( $agent_instagram ) || !empty( $agent_twitter ) || !empty( $agent_linkedin ) || !empty( $agent_googleplus ) || !empty( $agent_youtube ) || !empty( $agent_pinterest ) || !empty( $agent_vimeo ) || !empty( $agent_whatsapp ) ) {
?>
<p><?php printf( esc_html__( 'Find %s on', 'advmls' ) , get_the_title() ); ?>:</p>

<div class="agent-social-media">
	<?php if( !empty( $agent_skype ) ) { ?>
	<span>
		<a class="btn-skype" target="_blank" href="skype:<?php echo esc_attr( $agent_skype ); ?>?chat">
			<i class="advmls-icon icon-video-meeting-skype mr-2"></i>
		</a>
	</span>
	<?php } ?>

	<?php if( !empty( $agent_facebook ) ) { ?>
	<span>
		<a class="btn-facebook" target="_blank" href="<?php echo esc_url( $agent_facebook ); ?>">
			<i class="advmls-icon icon-social-media-facebook mr-2"></i>
		</a>
	</span>
	<?php } ?>

	 <?php if( !empty( $agent_instagram ) ) { ?>
	<span>
		<a class="btn-instagram" target="_blank" href="<?php echo esc_url( $agent_instagram ); ?>">
			<i class="advmls-icon icon-social-instagram mr-2"></i>
		</a>
	</span>
	<?php } ?>

	<?php if( !empty( $agent_twitter ) ) { ?>
	<span>
		<a class="btn-twitter" target="_blank" href="<?php echo esc_url( $agent_twitter ); ?>">
			<i class="advmls-icon icon-social-media-twitter mr-2"></i>
		</a>
	</span>
	<?php } ?>

	<?php if( !empty( $agent_linkedin ) ) { ?>
	<span>
		<a class="btn-linkedin" target="_blank" href="<?php echo esc_url( $agent_linkedin ); ?>">
			<i class="advmls-icon icon-professional-network-linkedin mr-2"></i>
		</a>
	</span>
	<?php } ?>

	<?php if( !empty( $agent_googleplus ) ) { ?>
	<span>
		<a class="btn-googleplus" target="_blank" href="<?php echo esc_url( $agent_googleplus ); ?>">
			<i class="advmls-icon icon-social-media-google-plus-1 mr-2"></i>
		</a>
	</span>
	<?php } ?>

	<?php if( !empty( $agent_youtube ) ) { ?>
	<span>
		<a class="btn-youtube" target="_blank" href="<?php echo esc_url( $agent_youtube ); ?>">
			<i class="advmls-icon icon-social-video-youtube-clip mr-2"></i>
		</a>
	</span>
	<?php } ?>

	<?php if( !empty( $agent_pinterest ) ) { ?>
	<span>
		<a class="btn-pinterest" target="_blank" href="<?php echo esc_url( $agent_pinterest ); ?>">
			<i class="advmls-icon icon-social-pinterest mr-2"></i>
		</a>
	</span>
	<?php } ?>

	<?php if( !empty( $agent_vimeo ) ) { ?>
	<span>
		<a class="btn-vimeo" target="_blank" href="<?php echo esc_url( $agent_vimeo ); ?>">
			<i class="advmls-icon icon-social-video-vimeo mr-2"></i>
		</a>
	</span>
	<?php } ?>

	<?php if( !empty( $agent_whatsapp ) ) { ?>
	<span class="agent-whatsapp">
		<a class="btn-whatsapp" target="_blank" href="https://wa.me/<?php echo esc_attr($agent_whatsapp_call); ?>">
			<i class="advmls-icon icon-messaging-whatsapp mr-2"></i>
		</a>
	</span>
	<?php } ?>
</div>
<?php } ?>