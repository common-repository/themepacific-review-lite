<?php
/***** @themepacific *****/

add_action('admin_enqueue_scripts', 'themepacific_wpreview_admin_enqueue_scriptsl');
function themepacific_wpreview_admin_enqueue_scriptsl() {
	global $typenow;
	if ($typenow == 'post' || $typenow == 'page') {
		/*js*/
		wp_enqueue_script('back', plugin_dir_url( dirname( __FILE__ ) ) . 'admin/js/back.js', array('jquery'));
  	// css
		wp_enqueue_style('admincss', plugin_dir_url( dirname( __FILE__ ) ) . 'admin/css/back.css');
	}
}



function themepacific_wpreview_meta_box_callbackl($fields, $page) {
	global $post;
	$output = '';
	echo '<div class="metabox-wrapper crn-wp-review-metabox">';
	echo '<input type="hidden" name="'.$page.'_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	foreach ($fields as $field) {

		if ($field['label'])	$label 		= $field['label'];
		if ($field['desc']) 	$desc 		= '<div class="description">'.$field['desc'].'</div>';
		if ($field['id']) 		$id 		= $field['id'];
		if ($field['type']) 	$type 		= $field['type'];
		if ( isset($field['value']) ) {
			if ($field['value']) 	$value 		= $field['value'];}
			if ( isset($field['options']) ) {
				if ($field['options']) 	$options	= $field['options'];}

				$meta 	= get_post_meta($post->ID, $id, true);
				echo '<div class="child-mb-wrapper">
				<label for="'.$id.'">'.$label.'</label>';
				switch($field['type']) {
					case 'select':
					echo '<select name="'.$id.'" id="'.$id.'">';
					foreach ($options as $option) {
						echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
					}
					echo '</select>'.$desc;
					break;
					case 'rating':
					echo '<a class="repeatable-add button" href="#">'.__('Add New Review Criteria (Pro Version)','crnwpreview').'</a>';
					echo '<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';

					$i = 0;$summary ='';
					$newarray =$meta;
					if (!empty($newarray)) {


						foreach($newarray as $row) {		 
							if($i==0){
								echo '<input name="'.$field['id'].'[0][total]" id="tpcrn_rating_tot" type="hidden" class="themepacific_wpreview_upload_text" value="'.$row['total'].' " />';

								echo '<li><span>Review Title:</span><input name="'.$field['id'].'[0][title]" id="tpcrn_rating_tot" type="text" class="themepacific_wpreview_upload_text" value="'.$row['title'].' " /></li>';
								$summary = isset($row['summary'])? $row['summary'] : '';
							}

							echo	'<li>


							<span>Review Criteria:</span>
							<input name="'.$field['id'].'['.$i.'][text]" id="'.$field['id'].'['.$i.'][text]" type="text" class="themepacific_wpreview_rate_text" value="'.$row['text'].' " />

							<span>Criteria Rating:</span>
							<input type="number" min="1" max="10" name="'.$field['id'].'['.$i.'][rating]" class="tpcrn_rating_val" id="'.$id.$i.$i.'" value="'.$row['rating'].'" size="5" step="0.1"/>
							<a href="#" class="themepacific_wpreview_clear_rating">Reset Field</a> 						 
							<br clear="all" />
						</li>';
						$i++;

					}

				} else {		
					for ($i=0; $i<5; $i++){
						if($i==0){
							echo '<input name="'.$field['id'].'[0][total]" id="tpcrn_rating_tot" type="hidden" class="themepacific_wpreview_upload_text" value="" />';								

							echo '<li><span>Review Title:</span><input name="'.$field['id'].'[0][title]" id="tpcrn_rating_tot" type="text" class="themepacific_wpreview_upload_text" value=" " /></li>';
						}

						echo	'<li>


						<span>Review Criteria:</span>
						<input name="'.$field['id'].'['.$i.'][text]" id="'.$field['id'].'['.$i.'] [text]" type="text" class="themepacific_wpreview_rate_text" value="" />

						<span>Criteria Rating:</span>
						<input type="number" min="1" max="10" name="'.$field['id'].'['.$i.'][rating]" id="'.$id.$i.$i.'"   class="tpcrn_rating_val" value="" size="5" step="0.1"/>
						<a href="#" class="themepacific_wpreview_clear_rating">Reset field</a>

						<br clear="all" />
					</li>';

				}
			}
			echo '</ul>';

			echo '<span class="crnWPreviewLabel">Review Summary:</span>';
			echo '<textarea class="crnWPreviewInput" name="'.$field['id'].'[0][summary]" id="'.$id.'" cols="60" rows="4">'.$summary.' </textarea>';
				//echo '<span class="description">'.$field['desc'].'</span>';
			break;






		}  
		echo ' </div>';
	}  
	echo '</div>'; 
}

function themepacific_wpreview_emptyratel($aValue){
	if(!empty($aValue)){
		foreach($aValue as $k=>$row)
		{
			$te = trim($row['text']);
			if(empty($te)){

				unset($aValue[$k]);
			}
		}

		
		return $aValue;
	}
} 

if(!function_exists('themepacific_wpreview_sanitize_text_or_array')){
	function themepacific_wpreview_sanitize_text_or_array($array_or_string) {
		if( is_string($array_or_string) ){
			$array_or_string = sanitize_text_field($array_or_string);
		}elseif( is_array($array_or_string) ){
			foreach ( $array_or_string as $key => &$value ) {
				if ( is_array( $value ) ) {
					$value = themepacific_wpreview_sanitize_text_or_array($value);
				}
				else {
					$value = sanitize_text_field( $value );
				}
			}
		}

		return $array_or_string;
	}
}


/* Save the Data*/
function themepacific_wpreview_meta_box_savel($post_id, $fields, $page) {
	if ( isset($_POST[$page.'_meta_box_nonce']) ) {
		if (!wp_verify_nonce(sanitize_text_field($_POST[$page.'_meta_box_nonce']), basename(__FILE__)))
			return $post_id;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;

	if ( isset($_POST['post_type']) ) {
		if ($page != sanitize_text_field($_POST['post_type'])) {

			if (!current_user_can('edit_page', $post_id))
				return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
	}

	foreach ($fields as $field) {
		if ( isset($_POST[$field['id']]) ) {


			if($field['type'] == 'rating') {
				$old = get_post_meta($post_id, $field['id'], true);


				if(function_exists('themepacific_wpreview_emptyratel')){


					$post_fi_id =  themepacific_wpreview_sanitize_text_or_array($_POST[$field['id']]);

					$newarray_store =  themepacific_wpreview_emptyratel($post_fi_id);

				} 

				if(!empty($newarray_store)){
					update_post_meta($post_id, $field['id'], $newarray_store);
				}

				else{
					delete_post_meta($post_id, $field['id'], $old);

				}

				foreach($newarray_store as $rateValue){
					if(isset($rateValue['total'])){  
						$fina_scor = ($rateValue['total']/sizeof($newarray_store))*10;}
						update_option('tpcrn_rating_tot'.$post_id, $fina_scor);
					}

				}


				else {
					$old = get_post_meta($post_id, $field['id'], true);
					$new =  themepacific_wpreview_sanitize_text_or_array($_POST[$field['id']]);
					if ($new && $new != $old) {
						update_post_meta($post_id, $field['id'], $new);
					} elseif ('' == $new && $old) {
						delete_post_meta($post_id, $field['id'], $old);
					}
				}
			}
		}  
	}
	?>