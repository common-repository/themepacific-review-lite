<?php

class themepacific_wpreview_Adminl {

	private $version;

	public function __construct( $version ) {
		$this->version = $version;
		// Get registered option
		$this->options = get_option( 'themepacific_wpreview_settings' );
	}




	public	function admin_menu() 
	{
		$icon_url = plugins_url( '/images/favicon.png', __FILE__ );
		
		$page_hook = add_menu_page( __( 'ThemePacific WP Review Settings', 'themepacific_wpreview'), 'TP WP Reviews', 'update_core', 'crn-wpreview', array(&$this, 'settings_page'), $icon_url );
		
		add_submenu_page( 'crn-wpreview', __( 'Settings', 'themepacific_wpreview' ), __( 'ThemePacific WP Review Settings', 'themepacific_wpreview' ), 'update_core', 'crn-wpreview', array(&$this, 'settings_page') );


	}

	public function admin_init()
	{
		register_setting( 'crn-wpreview', 'themepacific_wpreview_settings', array(&$this, 'settings_validate') );
		
		add_settings_section( 'crn-wpreview', '', array(&$this, 'section_crn_intro'), 'crn-wpreview' );

		add_settings_field( 'crn_show_on', __( 'Show Ratings Box on', 'themepacific_wpreview' ), array(&$this, 'setting_crn_show_on'), 'crn-wpreview', 'crn-wpreview' );

		add_settings_field( 'crn_urate_permission', __( 'User Ratings Allow for', 'themepacific_wpreview' ), array(&$this, 'setting_crn_urate_permission'), 'crn-wpreview', 'crn-wpreview' );

		 // Add Rating Color Field
		add_settings_field( 'themepacific_wpreview_criteria_clr', __('Review Criteria Color (Only Pro Version) ', 'themepacific_wpreview' ), array( &$this, 'setting_themepacific_wpreview_criteria_clr' ),'crn-wpreview' , 'crn-wpreview' );  

		add_settings_field( 'themepacific_wpreview_rating_clr',  __( 'Review Rating Color (Only Pro Version) ', 'themepacific_wpreview' ), array( &$this, 'setting_themepacific_wpreview_rating_clr' ),'crn-wpreview' , 'crn-wpreview' );  
		add_settings_field( 'themepacific_wpreview_urating_clr',  __( 'User Rating Color (Only Pro Version) ', 'themepacific_wpreview' ), array( &$this, 'setting_themepacific_wpreview_urating_clr' ),'crn-wpreview' , 'crn-wpreview' );  

		add_settings_field( 'crn_rate_desc1', __( 'Rating Summary < 20', 'themepacific_wpreview' ), array(&$this, 'setting_crn_rate_desc1'), 'crn-wpreview', 'crn-wpreview' );


		add_settings_field( 'crn_rate_desc2', __( 'Rating Summary < 40', 'themepacific_wpreview' ), array(&$this, 'setting_crn_rate_desc2'), 'crn-wpreview', 'crn-wpreview' );


		add_settings_field( 'crn_rate_desc3', __( 'Rating Summary < 60', 'themepacific_wpreview' ), array(&$this, 'setting_crn_rate_desc3'), 'crn-wpreview', 'crn-wpreview' );


		add_settings_field( 'crn_rate_desc4', __( 'Rating Summary < 70', 'themepacific_wpreview' ), array(&$this, 'setting_crn_rate_desc4'), 'crn-wpreview', 'crn-wpreview' );


		add_settings_field( 'crn_rate_desc5', __( 'Rating Summary < 80', 'themepacific_wpreview' ), array(&$this, 'setting_crn_rate_desc5'), 'crn-wpreview', 'crn-wpreview' );


		add_settings_field( 'crn_rate_desc6', __( 'Rating Summary < 95', 'themepacific_wpreview' ), array(&$this, 'setting_crn_rate_desc6'), 'crn-wpreview', 'crn-wpreview' );


		add_settings_field( 'crn_rate_desc7', __( 'Rating Summary < 100', 'themepacific_wpreview' ), array(&$this, 'setting_crn_rate_desc7'), 'crn-wpreview', 'crn-wpreview' );

 		add_settings_field( 'crn_instructions', __( 'Shortcode and Template Tag', 'themepacific_wpreview' ), array(&$this, 'setting_crn_instructions'), 'crn-wpreview', 'crn-wpreview' );
	}	

	public function setting_crn_rate_desc1(){

		if( !isset($this->options['crn_rate_desc1']) ) $this->options['crn_rate_desc1'] = 'Terrible!';
 		
		echo '<input type="text" name="themepacific_wpreview_settings[crn_rate_desc1]" class="regular-text" value="'.$this->options['crn_rate_desc1'] .'" />';
 	}
 	
	public function setting_crn_rate_desc2(){

		if( !isset($this->options['crn_rate_desc2']) ) $this->options['crn_rate_desc2'] = 'Poor!';
 		
		echo '<input type="text" name="themepacific_wpreview_settings[crn_rate_desc2]" class="regular-text" value="'.$this->options['crn_rate_desc2'] .'" />';
 	} 
 	
	public function setting_crn_rate_desc3(){

		if( !isset($this->options['crn_rate_desc3']) ) $this->options['crn_rate_desc3'] = 'Ok!';
 		
		echo '<input type="text" name="themepacific_wpreview_settings[crn_rate_desc3]" class="regular-text" value="'.$this->options['crn_rate_desc3'] .'" />';
 	}

	public function setting_crn_rate_desc4(){

		if( !isset($this->options['crn_rate_desc4']) ) $this->options['crn_rate_desc4'] = 'Good!';
 		
		echo '<input type="text" name="themepacific_wpreview_settings[crn_rate_desc1]" class="regular-text" value="'.$this->options['crn_rate_desc4'] .'" />';
 	}

	public function setting_crn_rate_desc5(){

		if( !isset($this->options['crn_rate_desc5']) ) $this->options['crn_rate_desc5'] = 'Very Good!';
 		
		echo '<input type="text" name="themepacific_wpreview_settings[crn_rate_desc5]" class="regular-text" value="'.$this->options['crn_rate_desc5'] .'" />';
 	}

	public function setting_crn_rate_desc6(){

		if( !isset($this->options['crn_rate_desc6']) ) $this->options['crn_rate_desc6'] = 'Excellent!';
 		
		echo '<input type="text" name="themepacific_wpreview_settings[crn_rate_desc6]" class="regular-text" value="'.$this->options['crn_rate_desc6'] .'" />';
 	}
	public function setting_crn_rate_desc7(){

		if( !isset($this->options['crn_rate_desc7']) ) $this->options['crn_rate_desc7'] = 'Spectacular!';
 		
		echo '<input type="text" name="themepacific_wpreview_settings[crn_rate_desc7]" class="regular-text" value="'.$this->options['crn_rate_desc7'] .'" />';
 	}

	public function section_crn_intro(){
		?>
		<p><?php _e('ThemePacific WordPress Review (TP WP Review) Plugin. In this settings page, you can control the TP WP Review Plugin options', 'themepacific_wpreview'); ?></p>
		<p><?php _e('Check out our other free <a href="http://themepacific.com/wp-plugins/?ref=themepacific_wpreview">plugins</a> and <a href="http://themepacific.com/?ref=themepacific_wpreview">themes</a>.', 'themepacific_wpreview'); ?></p>
		<?php
		
	}

	function setting_crn_show_on(){
		
		if( !isset($this->options['show_in_post']) ) $this->options['show_in_post'] = '1';
		if( !isset($this->options['show_in_page']) ) $this->options['show_in_page'] = '0';
		if( !isset($this->options['show_in_loops']) ) $this->options['show_in_loops'] = '0';
		
		echo '<input type="hidden" name="themepacific_wpreview_settings[show_in_post]" value="0" />
		<label><input type="checkbox" name="themepacific_wpreview_settings[show_in_post]" value="1"'. (($this->options['show_in_post']) ? ' checked="checked"' : '') .' />
			'. __('Posts', 'themepacific_wpreview') .'</label><br />
			<input type="hidden" name="themepacific_wpreview_settings[show_in_page]" value="0" />
			<label><input type="checkbox" name="themepacific_wpreview_settings[show_in_page]" value="1"'. (($this->options['show_in_page']) ? ' checked="checked"' : '') .' />
				'. __('Pages', 'themepacific_wpreview') .'</label><br />
				<input type="hidden" name="themepacific_wpreview_settings[show_in_loops]" value="0" />
				<label><input type="checkbox" name="themepacific_wpreview_settings[show_in_loops]" value="1"'. (($this->options['show_in_loops']) ? ' checked="checked"' : '') .' />
					'. __('Home, Archive, Search Pages', 'themepacific_wpreview') .'</label><br />';
		}

	function setting_crn_urate_permission()	{
		$val = ( isset( $this->options['urateAllow'] ) ) ? $this->options['urateAllow'] : 'disable';

			echo '<label><input type="radio" name="themepacific_wpreview_settings[urateAllow]" value="disable"'. (($val=='disable') ? ' checked="checked"' : '') .' />'. __('Disabled', 'themepacific_wpreview') .'</label><br />';

			echo '<label><input type="radio" name="themepacific_wpreview_settings[urateAllow]" value="registered"'. (($val=='registered') ? ' checked="checked"' : '') .' />'. __('Registered Users (Only Pro Version) ', 'themepacific_wpreview') .'</label><br />';

			echo '<label><input type="radio" name="themepacific_wpreview_settings[urateAllow]" value="guest"'. (($val=='guest') ? ' checked="checked"' : '') .' />'. __('Guest Users (Only Pro Version) ', 'themepacific_wpreview') .'</label><br />';

			echo '<label><input type="radio" name="themepacific_wpreview_settings[urateAllow]" value="any"'. (($val=='any') ? ' checked="checked"' : '') .' />'. __('Any Users (Only Pro Version) ', 'themepacific_wpreview') .'</label><br />';
	}			

				function setting_themepacific_wpreview_criteria_clr() { 

					$val = ( isset( $this->options['crn_criteria_clr'] ) ) ? $this->options['crn_criteria_clr'] : '';
					echo '<input type="text" name="themepacific_wpreview_settings[crn_criteria_clr]" value="' .$val . '" class="cpa-color-picker" >';
				}

				function setting_themepacific_wpreview_rating_clr() { 
					$val = ( isset( $this->options['crn_rating_clr'] ) ) ? $this->options['crn_rating_clr'] : '';
					echo '<input type="text" name="themepacific_wpreview_settings[crn_rating_clr]" value="' .$val . '" class="cpa-color-picker" >';
				}

				function setting_themepacific_wpreview_urating_clr() { 
					$val = ( isset( $this->options['crn_urating_clr'] ) ) ? $this->options['crn_urating_clr'] : '';
					echo '<input type="text" name="themepacific_wpreview_settings[crn_urating_clr]" value="' .$val . '" class="cpa-color-picker" >';

				}


				function setting_crn_instructions()	{

					echo '<p>'. __(' ThemePacific WP Review Box can be easily displayed using this Shortcode.', 'themepacific_wpreview') .'</p>
					<p><code>[crn_wp_review]</code></p>
					<p>'. __('Also, ThemePacific WP Review Box can be easily displayed manually in your theme using the following PHP Function:', 'themepacific_wpreview') .'</p>
					<p><code>&lt;?php if( function_exists(\'themepacific_wpreviewBox_lite\') ) themepacific_wpreviewBox_lite(); ?&gt;</code></p>';
				}
				
				function settings_validate($input){

					return $input;
				}

				public function settings_page()	{
					?>
					<div class="wrap">
						<div id="icon-themes" class="icon32"></div>
						<h2><?php _e('ThemePacific Postview Settings', 'themepacific_wpreview'); ?></h2>
						<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){ ?>
						<div id="setting-error-settings_updated" class="updated settings-error"> 
							<p><strong><?php _e( 'Settings saved.', 'themepacific_wpreview' ); ?></strong></p>
						</div>
						<?php } ?>
						<form action="options.php" method="post">
							<?php settings_fields( 'crn-wpreview' ); ?>
							<?php do_settings_sections( 'crn-wpreview' ); ?>
							<p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'themepacific_wpreview' ); ?>" /></p>
						</form>
					</div>
					<?php
				}

	/**
	 * Enqueues the style sheet  
	 *  
	 */
	public function enqueue_styles() {


	}	/**
	 * Enqueues the Scripts
	 */
	public function enqueue_scripts() {

		// Add the color picker css file       
		wp_enqueue_style( 'wp-color-picker' ); 

        // Include our custom jQuery file with WordPress Color Picker dependency
		wp_enqueue_script( 'custom-script-handle', plugins_url( '/js/themepacific_wpreview.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
	}


} 