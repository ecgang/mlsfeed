<?php
global $property;
$listing_view = get_option('search_result_posts_layout', 'list-view-v1');
$search_result_layout = get_option('search_result_layout', 'no-sidebar');
$search_num_posts = get_option('search_num_posts');
$enable_save_search = get_option('enable_disable_save_search');

$have_switcher = true;

$wrap_class = $item_layout = $view_class = $cols_in_row = '';
if($listing_view == 'list-view-v1') {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'list-view';

} elseif($listing_view == 'grid-view-v1') {
    $wrap_class = 'listing-v1';
    $item_layout = 'v1';
    $view_class = 'grid-view';
}

$cols_in_row = 'grid-view-3-cols';

if( $search_result_layout == 'no-sidebar' ) {
    $content_classes = 'col-lg-12 col-md-12';
} else if( $search_result_layout == 'left-sidebar' ) {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap wrap-order-first';
} else if( $search_result_layout == 'right-sidebar' ) {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
} else {
    $content_classes = 'col-lg-8 col-md-12 bt-content-wrap';
}

$number_of_prop = $search_num_posts;
if(!$number_of_prop){
    $number_of_prop = 9;
}

$page = (get_query_var('paged')) ? get_query_var('paged') : 1;

$total_records = count($this->proListResult);

$record_found_text = esc_html__('Result Found', 'advmls');
if( $total_records > 1 ) {
    $record_found_text = esc_html__('Results Found', 'advmls');
}

?>
<style type="text/css">
section.listing-wrap {
    background: #f3f1f1;
}
</style>
<section class="listing-wrap <?php echo esc_attr($wrap_class); ?>" >
    <div class="container">

        <div class="page-title-wrap">

            <?php #include_once($pathTemplate.'template-parts/page/breadcrumb'); ?> 
            <div class="d-flex align-items-center">
                <div class="page-title flex-grow-1">
                    <h1><?php $this->getTitle(); ?></h1>
                </div><!-- page-title -->
                <?php 
                if($have_switcher) {
                    include_once($pathTemplate.'listing/listing-switch-view.php'); 
                }?> 
            </div><!-- d-flex -->  

        </div><!-- page-title-wrap -->

        <div class="row">
            <div class="<?php echo esc_attr($content_classes); ?>">

                <div class="listing-tools-wrap">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            
                            <strong><?php echo esc_attr($total_records).' - '.($page * $this->proPagination->limit).' of '.$this->proPagination->total  ; ?> <?php echo esc_attr($record_found_text); ?></strong>
                        </div>
                    </div><!-- d-flex -->
                    
                </div><!-- listing-tools-wrap -->

                <div class="listing-view <?php echo esc_attr($view_class).' '.esc_attr($cols_in_row); ?> card-deck" id="search-results">
                    <?php
                    if ( count($this->proListResult) > 0 ) : ?>
                        <script>
                            jQuery(document).ready(function(){
                                scrollTopListings('#search-results');
                            })
                        </script>
                    <?php
                        foreach ($this->proListResult as $key => $property) {
                            $currentKey = $key;
                            include($pathTemplate.'listing/item-'.$item_layout.'.php');
                        }
                        ?>
                        <?php
                    else:
                        echo '<div class="search-no-results-found">';
                            esc_html_e('No results found', 'advmls');
                        echo '</div>';
                        
                    endif;
                    ?> 
                </div><!-- listing-view -->

                <?php advmls_pagination( ceil( $this->proPagination->total / $this->proPagination->limit) ); ?>

            </div><!-- bt-content-wrap -->

        </div><!-- row -->

    </div><!-- container -->
</section><!-- listing-wrap -->