<?php
global $ele_settings;

$data_column_class = isset($ele_settings['data_columns']) && !empty($ele_settings['data_columns']) ? $ele_settings['data_columns'] : get_option('prop_features_cols', 'list-3-cols');

?>
<ul class="<?php echo esc_attr($data_column_class); ?> list-unstyled">
	<?php
    
    $features_icons = get_option('features_icons');
	global $features;
    if (!empty($features)):
        foreach ($features as $term):
            #var_dump($term);
                echo '<li><i class="advmls-icon icon-check-circle-1 mr-2"></i>' . esc_attr($term->field_option) . '</li>';
            
        endforeach;
    endif;
    ?>
</ul>