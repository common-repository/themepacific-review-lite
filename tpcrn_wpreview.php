<?php
/*
Plugin Name:  Themepacific WordPress Review Lite
Plugin URI:   https://themepacific.com/wp-plugins/
Description:  Premium WordPress Review and User Ratings Plugin for WordPress in simple Way.
Version:      1.1
Author:       Theme Pacific, RAJA CRN
Author URI:   https://themepacific.com/
Text Domain:  themepacific_wpreview
Domain Path: /languages

*/
 
 
// If this file is called directly, then abort Mission :)
if ( ! defined( 'WPINC' ) ) {
    die;
}
/**
 * Include the core class responsible for loading all necessary components of the plugin.
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/class_themepacific_wpreview.php';


 

/**
 * Instantiates the class and then
 * calls its run method officially starting up the plugin.
 */
function run_themepacific_wpReviewl() {

	$spmm = new themepacific_wpReviewl();
	$spmm->run();

}

// Call the above function to begin execution of the plugin.
run_themepacific_wpReviewl();
