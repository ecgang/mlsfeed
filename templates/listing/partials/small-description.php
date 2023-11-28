<?php 
global $property;
$small_desc =  !empty($property->pro_small_desc) ?  $property->pro_small_desc : '';

?>
<p class="small-desc text-capitalize mb-2"><?php echo substr( strip_tags($small_desc) , 0, 80).'...'; ?></p>