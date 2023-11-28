<?php

#$layout = advmls_option('property_blocks_tabs');
#$layout = $layout['enabled'];

$video_url = json_decode($this->getDataDetails('pro_video'));

$tab_end = '</div>';
$li_start = '<li class="nav-item">';
$li_end = '</li>';
?>

<?php 
    if($top_area != 'v6') {
        include_once($pathTemplate.'property-details/overview.php'); 
    }
?>
<!--start detail content tabber-->
    <div class="listing-tabs horizontal-listing-tabs">
        <ul class="nav nav-tabs nav-justified">
            <?php
            $i = 0;
            if ($layout): foreach ($layout as $key => $value) {

                if( $i == 0 ) { $a_active = 'active'; } else { $a_active = ''; }

                switch($key) {

                    case 'description':
                        echo $li_start;
                        echo '<a class="nav-link '.$a_active.'" href="#property-description" data-toggle="tab">'.'Description'.'</a>';
                        echo $li_end;
                        $i++;
                        break;

                    case 'address':
                        echo $li_start;
                        echo '<a class="nav-link '.$a_active.'" href="#property-address" data-toggle="tab">'. 'Address' .'</a>';
                        echo $li_end;
                        $i++;
                        break;

                    case 'details':
                        echo $li_start;
                        echo '<a class="nav-link '.$a_active.'" href="#property-details" data-toggle="tab">'. 'Details' .'</a>';
                        echo $li_end;
                        $i++;
                        break;

                    case 'features':
                        echo $li_start;
                        echo '<a class="nav-link '.$a_active.'" href="#property-features" data-toggle="tab">'. 'Features' .'</a>';
                        echo $li_end;
                        $i++;
                        break;

                    case 'video':

                        if( !empty($video_url[0] ) ) {
                            echo $li_start;
                            echo '<a class="nav-link '.$a_active.'" href="#property-video" data-toggle="tab">'. 'Video' .'</a>';
                            echo $li_end;
                            $i++;
                        }
                        break;
                }
            }

            endif;
            ?>

        </ul>
    </div>

    <!--start tab-content-->
    <div class="tab-content horizontal-tab-content" id="property-tab-content">
        <?php
        $j = 0;
        if ($layout): foreach ($layout as $key=>$value) {

            if( $j == 0 ) { $tab_active = 'show active'; } else { $tab_active = ''; }

            switch($key) {

                case 'description':
                    echo '<div class="tab-pane fade '.$tab_active.'" id="property-description" role="tabpanel">';
                        include_once($pathTemplate.'property-details/description.php'); 
                    echo '</div>';
                    $j++;
                    break;

                case 'address':
                    echo '<div class="tab-pane fade '.$tab_active.'" id="property-address" role="tabpanel">';
                        include_once($pathTemplate.'property-details/address.php');
                    echo '</div>';
                    $j++;
                    break;

                case 'details':
                    echo '<div class="tab-pane fade '.$tab_active.'" id="property-details" role="tabpanel">';
                        include_once($pathTemplate.'property-details/detail.php');
                    echo '</div>';
                    $j++;
                    break;

                case 'features':
                    echo '<div class="tab-pane fade '.$tab_active.'" id="property-features" role="tabpanel">';
                        include_once($pathTemplate.'property-details/features.php');
                    echo '</div>';
                    $j++;
                    break;

                case 'video':

                    if( !empty($video_url[0] ) ) {
                        echo '<div class="tab-pane fade '.$tab_active.'" id="property-video" role="tabpanel">';
                            include_once($pathTemplate.'property-details/video.php');
                        echo '</div>';
                        $j++;
                    }
                    break;
            }
        }

        endif;
        ?>

    </div>
    <!--end tab-content-->
    <?php

    if( $tabs_agent_bottom == 1 ) {
        include_once($pathTemplate.'property-details/agent-form-bottom.php');
    }

    ?>