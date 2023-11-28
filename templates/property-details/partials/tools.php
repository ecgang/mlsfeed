
<ul class="item-tools">
    <li class="item-tool advmls-share">
        <span class="item-tool-share dropdown-toggle" data-toggle="dropdown">
            <i class="fas fa-share-alt"></i>
        </span><!-- item-tool-favorite -->
        <div class="dropdown-menu dropdown-menu-right item-tool-dropdown-menu">
            <?php include_once($pathTemplate.'property-details/partials/share.php'); ?>
        </div>
    </li><!-- item-tool -->

    <li class="item-tool advmls-print" data-propid="<?php echo $this->getDataDetails('id'); ?>">
        <span class="item-tool-compare">
            <i class="fas fa-print"></i>
        </span><!-- item-tool-compare -->
    </li><!-- item-tool -->
</ul><!-- item-tools -->