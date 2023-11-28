<?php
global $property;
$term_id = '';
$status_id= 33;
$status_name = !empty($property->type_name) ? $property->type_name : '' ;

$label_id = '';
$label_id= 33;
$label_name = !empty($property->category_name) ? $property->category_name : '' ;

$enable_status = get_option('disable_status', 1);
$enable_label = get_option('disable_label', 1);

if( $enable_status || $enable_label ) {
?>
<div class="labels-wrap labels-right"> 

	<?php 
	if( !empty($status_name) && $enable_status ) {
        echo '<span class="label-status label status-color-'.intval($status_id).' mr-2 '.tag_escape($status_name).'">
				'.esc_attr($status_name).'
			</span>';
	}

	if( !empty($label_name) && $enable_label ) {
        echo '<span class="hz-label label label-color-'.intval($label_id).'">
				'.esc_attr($label_name).'
			</span>';
	}
	?>       

</div>
<?php } ?>