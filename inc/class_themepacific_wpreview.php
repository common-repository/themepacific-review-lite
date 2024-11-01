<?php
 

/**
 * @since    1.0.0
 */
//class themepacific_wpReviewl {
class themepacific_wpReviewl {

 
	protected $loader;
 
 	protected $version;
 
	public function __construct() {

 		$this->version = '1.0.0';
 		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

 
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/themepacific_wpreview_admin.php'; 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/meta_box.php'; 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/crn_post_meta.php'; 
		require_once plugin_dir_path(dirname( __FILE__ )) .'public/themepacific_wpreview_functions.php';
 		require_once plugin_dir_path( __FILE__ ) . 'themepacific_wpreview_loader.php';

		$this->loader = new themepacific_wpreview_Loaderl();

	}

 
	private function define_admin_hooks() {

		$admin = new themepacific_wpreview_Adminl( $this->get_version() );
  		$this->loader->add_action('admin_init', $admin,'admin_init');
		$this->loader->add_action('admin_menu', $admin, 'admin_menu', 99);
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );
	}
 
 
	private function define_public_hooks() {

 		$public = new themepacific_wpreview_publicl($this->get_version());	 
 		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles' );
		$this->loader->add_filter('the_content', $public, 'the_content');
        $this->loader->add_filter('the_excerpt', $public, 'the_content');

	$this->loader->add_action( 'wp_ajax_nopriv_themepacific_wpreview', $public, 'themepacific_wpreview' );
	$this->loader->add_action( 'wp_ajax_themepacific_wpreview', $public, 'themepacific_wpreview' );
 	
 	}

 
	public function run() {
		$this->loader->run();
	}
	public function get_version() {
		return $this->version;
	}
 

}