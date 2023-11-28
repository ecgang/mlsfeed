<?php
$status_name = $this->getDataDetails('type_name');

if( !empty($status_name)  ) {

        echo '<span class="label-status label status-color-33 '.tag_escape($status_name).'">
                '.esc_attr($status_name).'
            </span>';
}

?>