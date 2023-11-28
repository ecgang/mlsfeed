<?php
// Creating the widget 
class mlsCompanyInfoWidget extends WP_Widget {
  
function __construct() {
	parent::__construct(
	// Base ID of your widget
	'mlsCompanyInfoWidget', 
	// Widget name will appear in UI
	__('MLS: Company Info (logo, description, contact, etc.)', 'wpb_widget_domain'), 
	// Widget description
	array( 'description' => __( 'MLS: Company Info (logo, description, contact, etc.)', 'wpb_widget_domain' ), ) 
	);
}
  
// Creating widget front-end
  
public function widget( $args, $instance ) {
	$title = isset($instance['title']) ? $instance['title'] : '';
	$company_field = isset($instance[ 'company_field' ]) ? $instance[ 'company_field' ] : '';
	  
	// before and after widget arguments are defined by themes
	$pathTemplate = mlsConstants::ADVANTAGEMLSTPLPATH;
	$company = advmls_getCompanyDetails();
    
	$fields = array();
	if (!empty($company) and !isset($company->error)) {
		

        $company_address = !empty($company->address) ? $company->address.', '.$company->city_name.', '. $company->state_name.', '.$company->postcode : '';
		?>

			<?php
			if ( ! empty( $title ) ){?>
				<h3>
					<?php echo  $title ?>
				</h3>
			<?php } ?>

			<?php
				switch ($company_field) {
                    case 'description': 
                        $fields[] = '<p class="company_desc">'.$company->company_description .'</p>';
                     break;
                    case 'photo':
                        $fields[] = '<img src="'.$company->url_photo.$company->photo.'" alt="'. $company->company_name.'" title="'.$company->company_name.'">';
                        break;
                    case 'address':
                       $fields[] = '<p class="company_address">'. $company_address. '</p>';
                     break;
                    case 'website':
                        $fields[] = '<a href="'.esc_url($company->website).'"> '. $company->website.'</a>';
                        break;
                    case 'email':
                        $fields[] = ' <a href="mailto:'. esc_url($company->email) .'"><i class="fas fa-envelope mr-2"></i>'. $company->email.'</a>';
                        break;
                    case 'business_hours':
                       $fields[] = '<span class="company_hours">'. !empty($company->business_name) ? $company->business_name : "business_name is empty".' </span>';
                     break;
                    case 'social':
                       $fields[] = '<ul class="list-inline">
                        
                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'.(!empty($company->facebook) ? $company->facebook : "https://facebook.com").'">
                                    <i class="advmls-icon icon-social-media-facebook"></i>
                                </a>
                            </li><!-- .facebook -->

                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'.(!empty($company->twitter) ? $company->twitter : "https://twitter.com").'">
                                    <i class="advmls-icon icon-social-media-twitter"></i>
                                </a>
                            </li><!-- .twitter -->

                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'. (!empty($company->instagram) ? $company->instagram : "https://instagram").'">
                                    <i class="advmls-icon icon-social-instagram"></i>
                                </a>
                            </li><!-- .instagram -->

                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'.(!empty($company->pinterest) ? $company->pinterest : "https://pinterest").'">
                                    <i class="advmls-icon icon-social-pinterest"></i>
                                </a>
                            </li><!-- .pinterest -->

                            <li class="list-inline-item">
                                <a target="_blank" class="btn-square" href="'. (!empty($company->youtube) ? $company->youtube : "https://youtube.com") .'">
                                    <i class="advmls-icon icon-social-video-youtube-clip"></i>
                                </a>
                            </li><!-- .youtube -->

                        </ul>';
                     break;
                    case 'footer':
                        $fields[] = (!empty($company_address) ? '<p><i class="fas fa-map-marker-alt mr-2"></i>'.$company_address.'</p>' : '' )
                         .(!empty($company->email) ? '<p><i class="fas fa-envelope mr-2"></i>'.$company->email.'</p>' : '')
                         .(!empty($company->phone) ? '<p><i class="fas fa-phone mr-2"></i>'. $company->phone.'</p>' : '' )
                         .(!empty($company->phone1) ? '<p><i class="fas fa-phone mr-2"></i>'. $company->phone1.'</p>' : '' )
                         .(!empty($company->phone2) ? '<p><i class="fas fa-phone mr-2"></i>'. $company->phone2.'</p>' : '' )
                         .(!empty($company->business_name) ? '<p><i class="far fa-clock mr-2"></i>'. $company->business_name.'</p>' : '' );

                    break;
                    case 'phone':
                        $fields[] = (!empty($company->phone) ? '<p><i class="fas fa-phone mr-2"></i>'.$company->phone.'</p>' : '');
                        break;
                    case 'phone1':
                        $fields[] = (!empty($company->phone1) ? '<p><i class="fas fa-phone mr-2"></i>'.$company->phone1.'</p>' : '');
                        break;
                    case 'phone2':
                        $fields[] = (!empty($company->phone2) ? '<p><i class="fas fa-phone mr-2"></i>'.$company->phone2.'</p>' : '');
                        break;
                    default: 
                        if (empty($company_field)) { ?>
                          <p class="fiel-empty"><?php echo "Select a field";?></p>
                            
                        <?php }else{?>
						  <p class="fiel-empty"><?php echo $company_field . " is empty or not exist";?></p>

                        <?php } ?>
                    <?php break;
                }
                
			?>
		<?php 
	}else{ ?>
		<div class="alert alert-warning">
			<p class="text-capitalize">
				<?php echo isset($company->error_msg) ? $company->error_msg : ''; ?>
			</p>
		</div>
	<?php
	}
	
        #ob_start();
   # $detail = ob_get_contents();
    #ob_end_clean();

    echo $args['before_widget']; 
    echo  implode(' ', $fields);
    echo $args['after_widget']; 

}
          
// Widget Backend 
public function form( $instance ) {

	$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
	$company_field = isset( $instance[ 'company_field' ] ) ? $instance[ 'company_field' ] : '';

	// Widget admin form
	?>
	<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<p class="company_field">
		<label for="company_field">
			Company Field
			<select name="<?php echo $this->get_field_name("company_field"); ?>" id="<?php echo $this->get_field_id( 'company_field' ); ?>" class="widefat">
				<option value="">Any</option>
				<option value="description" <?php echo ($company_field == 'description' ? 'selected' : ''); ?> >Description</option>
				<option value="photo" <?php echo ($company_field == 'photo' ? 'selected' : '' ); ?> >Photo</option>
				<option value="address" <?php echo ($company_field == 'address' ? 'selected' : '' ); ?> >Address</option>
				<option value="website" <?php echo ($company_field == 'website' ? 'selected' : '' ); ?> >Website</option>
				<option value="email" <?php echo ($company_field == 'email' ? 'selected' : '' ); ?> >Email</option>
				<option value="business_hours" <?php echo ($company_field == 'business_hours' ? 'selected' : '' ); ?> >Business Hours</option>
                <option value="social" <?php echo ($company_field == 'social' ? 'selected' : '' ); ?> >Social</option>
				<option value="footer" <?php echo ($company_field == 'footer' ? 'selected' : '' ); ?> >Footer</option>
			</select>
		</label>
	</p>
<?php 
}
      
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['company_field'] = ( ! empty( $new_instance['company_field'] ) ) ? strip_tags( $new_instance['company_field'] ) : '';
	return $instance;
}
 
}

