<?php 
global $advmls_type_search;

if (empty($advmls_type_search)) {
    $advmls_type_search = 'v1';
}

$sticky_hidden = $sticky_data = '';
$hidden_data = '0';
$adv_search_enable = '';
$adv_search = '';
if( wp_is_mobile() ) {
    $search_sticky = get_option('mobile-search-sticky');
} else {
    $search_sticky = get_option('main-search-sticky');
}

if ((!empty($adv_search_enable) && $adv_search_enable != 'global')) {
    if ($adv_search == 'hide_show') {
        $sticky_data = '1';
        $sticky_hidden = 'search-hidden';
        $hidden_data = '1';
    } else {
        $sticky_data = $search_sticky;
        $sticky_hidden = '';
        $hidden_data = '0';
    }
} else {
    $sticky_data = $search_sticky;
}

$sticky_data = $hidden_data = '0';
$sticky_hidden = '';

$search_style = get_option('search_style', 'style_1');

include_once($pathTemplate.'search/search-'.$advmls_type_search.'.php');
