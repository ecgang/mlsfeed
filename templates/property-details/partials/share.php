<?php
$twitter_user = '';

$photos = $this->getDataDetails('photos');
$urlPhoto = $this->getDataDetails('url_photo');
$image = $urlPhoto.$photos[0]->image;

$category_name = str_replace(" ", "_",  $this->getDataDetails('category_name'));
$pro_alias = $this->getDataDetails('pro_alias');

$urlProDetail = mlsUrlFactory::getInstance()->getListingDetailUrl(true);
$urlLink = esc_url($urlProDetail.$category_name.'/'.$pro_alias);
?>

<a class="dropdown-item" target="_blank" href="https://api.whatsapp.com/send?text=<?php echo  $this->getProTitle() .  '&nbsp;' . urlencode($urlLink);?>">
	<i class="advmls-icon icon-messaging-whatsapp mr-1"></i> <?php esc_html_e('WhatsApp', 'advantagemls'); ?>
</a>

<?php
echo '<a class="dropdown-item" href="https://www.facebook.com/sharer.php?u=' . urlencode($urlLink) . '&amp;t='.urlencode($this->getProTitle()).'" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
	<i class="advmls-icon icon-social-media-facebook mr-1"></i> '.esc_html__('Facebook', 'advantagemls').'
</a>
<a class="dropdown-item" href="https://twitter.com/intent/tweet?text=' . urlencode($this->getProTitle()) . '&url=' .  urlencode($urlLink) . '&via=' . urlencode($twitter_user ? $twitter_user : get_bloginfo('name')) .'" onclick="if(!document.getElementById(\'td_social_networks_buttons\')){window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;}">
	<i class="advmls-icon icon-social-media-twitter mr-1"></i> '.esc_html__('Twitter', 'advantagemls').'
</a>
<a class="dropdown-item" href="https://pinterest.com/pin/create/button/?url='. urlencode( $urlLink ) .'&amp;media=' . (!empty($image) ? $image : '') . '" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
	<i class="advmls-icon icon-social-pinterest mr-1"></i> '.esc_html__('Pinterest', 'advantagemls').'
</a>
<a class="dropdown-item" href="https://www.linkedin.com/shareArticle?mini=true&url='. urlencode( $urlLink ) .'&title=' . urlencode( $this->getProTitle() ) . '&source='.urlencode( home_url( '/' ) ).'" onclick="window.open(this.href, \'mywin\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;">
	<i class="advmls-icon icon-professional-network-linkedin mr-1"></i> '.esc_html__('Linkedin', 'advantagemls').'
</a>
<a class="dropdown-item" href="mailto:someone@example.com?Subject='.$this->getProTitle().'&body='. urlencode( $urlLink ) .'">
	<i class="advmls-icon icon-envelope mr-1"></i>'.esc_html__('Email', 'advantagemls').'
</a>';