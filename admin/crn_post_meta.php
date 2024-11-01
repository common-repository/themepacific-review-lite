<?php
function themepacific_wpreview_meta_box_fieldsl() {

	$prefix = 'crn_';

	$fields = array(
		
		array( 'label' => __('Rating Container Position','themepacific_wpreview'),
			'desc' => __("Choose the Position and style for Rating Block in posts.",'themepacific_wpreview'),
			'id' => $prefix."rate_layout",
			'std' => "below_center_rate",
			'type' => 'select',
			'options' => array (
				

				'below_center_rate' => array (
					'label' => 'Below Center',
					'value'	=> 'below_center_rate'
					),
				'top_center_rate' => array ( 
					'label' => 'Top Center (Only Pro Version)', 
					'value'	=> '' 
					),			
				'use_shortcode' => array (
					'label' => 'Use Shortcode  (Only Pro Version)',
					'value'	=> ''
					),
				
				)
			), 

		array( 'label' => __('Rating Style','themepacific_wpreview'),
			'desc' => __("Choose the Rating Style",'themepacific_wpreview'),
			'id' => $prefix."rate_style",
			'std' => "percentage",
			'type' => 'select',
			'options' => array (
  				'star' => array ( 
					'label' => 'Stars', 
					'value'	=> 'star' 
					),

				'percentage' => array (
					'label' => 'Percentage  (Only Pro Version)',
					'value'	=> ''
					),	
				'point' => array (
					'label' => 'Point  (Only Pro Version)',
					'value'	=> ''
					),

				)
			), 

		array(
			'label'	=> __('Post Review Details ','themepacific_wpreview'),
			'desc'	=> __('To show Post Rating','themepacific_wpreview'),
			'id'	=> $prefix.'rating',
			'type'	=> 'rating'
			)
		);
	
	return $fields;
}

 
/* Add meta box*/
add_action('admin_menu', 'themepacific_wpreview_add_boxl');
function themepacific_wpreview_add_boxl() {
	add_meta_box('themepacific_wpreview_post_options', __('Post Review Options','themepacific_wpreview'), 'themepacific_wpreview_show_boxl', 'post', 'normal', 'core');
	if( !isset($options['show_in_page']) ) $options['show_in_page'] = '0';

	if($options['show_in_page']){
		add_meta_box('themepacific_wpreview_post_options', __('Page Review Options','themepacific_wpreview'), 'themepacific_wpreview_show_boxl', 'page', 'normal', 'core');	
	}
}
/* Callback function to show fields in meta box*/
function themepacific_wpreview_show_boxl() {
	themepacific_wpreview_meta_box_callbackl(themepacific_wpreview_meta_box_fieldsl(), 'post');
 }


/* Save data from meta box*/
add_action('save_post', 'themepacific_wpreview_save_datal');
function themepacific_wpreview_save_datal($post_id) {
	themepacific_wpreview_meta_box_savel($post_id, themepacific_wpreview_meta_box_fieldsl(), 'post');
 }
 
 
?>
