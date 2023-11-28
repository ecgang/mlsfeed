<?php 
global $property;
$id = !empty($property->ref) ? $property->ref : '' ;

if(get_option('disable_favorite', 1) || get_option('disable_compare', 1) || get_option('disable_preview', 1) ) { ?>
<ul class="item-tools">

    <?php if(get_option('disable_preview', 1)) { ?>
    <li class="item-tool item-preview">
        <span class="hz-show-lightbox-js" data-listid="<?php echo $id?>" data-toggle="tooltip" data-placement="top" title="<?php echo get_option('cl_preview', 'Preview'); ?>">
                <i class="advmls-icon icon-expand-3"></i>   
        </span><!-- item-tool-favorite -->
    </li><!-- item-tool -->
    <?php } ?>

</ul><!-- item-tools -->
<?php } ?>