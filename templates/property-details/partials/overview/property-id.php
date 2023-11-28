<?php
$prop_id = advmls_get_listing_data('property_id');

if(!empty($prop_id)) {
	echo '<ul class="list-unstyled flex-fill">
			<li class="property-overview-item">
				<strong>'.advmls_propperty_id_prefix($prop_id).'</strong> 
			</li>
			<li class="hz-meta-label h-prop-id">'.advmls_option('spl_prop_id', 'Property ID').'</li>
		</ul>';
}