<?php 

class themepacific_wpreview_publicl {

	private $version;

	public function __construct($version) {

		$this->version = $version;
		$this->options = get_option( 'themepacific_wpreview_settings' );
  
	}
 
	public function enqueue_styles() {

		wp_enqueue_style(
			'crnWpReview',
			plugin_dir_url( __FILE__ ) . 'css/crnWpReview.css'
			);
 

	}
 
 

/**
 *   Show the Rating Box in Posts
 */
public function crn_show_ratingbox( $postid) {



	$rating = get_post_meta($postid, 'crn_rating', true);
	$content = '';
	if(!empty($rating)){
		$fina_scor2 = '';
  		$fina_scor = ($rating[0]['total']/sizeof($rating))*10;
		$fina_scor2 = $fina_scor;
		$ratings_title = esc_html(!empty($rating[0]['title'])?$rating[0]['title']: __('Review Details','themepacific_wpreview')) ;
		$ratings_summary = $rating[0]['summary'];
		$rating0 = $rating1 = $ratingli = '';
 			$fina_scor2 =  $fina_scor2 + $fina_scor2;
 
		$rating0 .= '<span style="display:none" class="entry-title" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing"><span itemprop="name">'.get_the_title().'</span></span><meta itemprop="datePublished" content="'.get_the_time( 'Y-m-d' ).'" /><span style="display:none" itemprop="reviewBody">'.get_the_excerpt().'</span>';	

		$rating0 .='<div id="rating_container" class="below_center_rate crn_wp_re_star"><div class="rating_single"> 
		<h3>'.$ratings_title.'</h3><div class="rating_single_wrap"><ul>'; 

		foreach($rating as $rateValue){  



			$rateValue_text = $rateValue['text'];
			$rateValue_rating = $rateValue['rating'];
 				$bestRating = 5;
				$nfrvr =  floatval(number_format((float)$rateValue_rating,1, '.', '')).' ★';
				$crn_overall =  floatval(number_format((int)$fina_scor/10,1, '.', '')).' ★';
				$crn_overallBg = '<div id="crn_wp_re_active-border" class="crn_wp_re_active-border"><div id="circle" class="crnresCircle"><span class="crn_prec '.(((round($fina_scor))/100)*360).'" id="crn_preca">'.$crn_overall.'</span></div></div>';
				

 
			$ratingli .= '<li class="criteria_container"><div class="criteria_label"> <span>'.esc_html($rateValue_text).'</span> <strong>'.$nfrvr.'</strong> </div><div class="score_bg"> <div style="width:'.($rateValue_rating*10).'%;" class="rated_score_bg"><span></span></div> </div> </li>';
		}  

		update_post_meta($postid, 'crn_rating_only', $fina_scor);


		$rating1 .= '<div class="rate_divider"></div><li class="criteria_container"><div class="criteria_label"> <span class="overall rating">Overall rating</span> <strong>'.$crn_overall.'</strong> </div><div class="score_bg"> <div style="width:'.$fina_scor.'%;" class="rated_score_bg"><span></span></div></div></li><div class="rate_divider"></div></ul>';

		$rating1 .= '<div class="ratings_summary"><span class="ratings_summary_text">'.esc_textarea($ratings_summary).'</span><div class="ratings_result">';

		$rating1 .= $crn_overallBg;

		$rating1 .= '<span class="rat_desc">';

		if( !isset($this->options['crn_rate_desc1']) ) $this->options['crn_rate_desc1'] = 'Terrible!';
		if( !isset($this->options['crn_rate_desc2']) ) $this->options['crn_rate_desc2'] = 'Poor!';
		if( !isset($this->options['crn_rate_desc3']) ) $this->options['crn_rate_desc3'] = 'Ok!';
		if( !isset($this->options['crn_rate_desc4']) ) $this->options['crn_rate_desc4'] = 'Good!';
		if( !isset($this->options['crn_rate_desc5']) ) $this->options['crn_rate_desc5'] = 'Very Good!';
		if( !isset($this->options['crn_rate_desc6']) ) $this->options['crn_rate_desc6'] = 'Excellent!';
		if( !isset($this->options['crn_rate_desc7']) ) $this->options['crn_rate_desc7'] = 'Spectacular!';

		if($fina_scor2<=20 ){$rating1 .=  esc_html($this->options['crn_rate_desc1']);}
		elseif($fina_scor2<=40 ){$rating1 .= esc_html($this->options['crn_rate_desc2']);}
		elseif($fina_scor2<=60 ){$rating1 .= esc_html($this->options['crn_rate_desc3']);}
		elseif($fina_scor2<=70 ){$rating1 .= esc_html($this->options['crn_rate_desc4']);}
		elseif($fina_scor2<=80 ){$rating1 .= esc_html($this->options['crn_rate_desc5']);}
		elseif($fina_scor2<=95 ){$rating1 .= esc_html($this->options['crn_rate_desc6']);}
		elseif($fina_scor2<=100 ){$rating1 .= esc_html($this->options['crn_rate_desc7']);}

		$rating1 .= '</span></div></div>';
		$rating1 .= '<div itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating"><meta itemprop="worstRating" content="1"><meta itemprop="bestRating" content="'.$bestRating.'"><meta itemprop="ratingValue" content="'.number_format((float)$fina_scor/10,1, '.', '').'"></div><span style="display:none" itemprop="reviewRating">'.number_format((float)$fina_scor/10,1, '.', '').'</span>';

		$rating1 .= '<div class="rate_divider"></div>';

 

		$rating1 .= '</div>';
		$rating1 .= '</div>';
		$rating1 .= '</div>';

		$content = $rating0.$ratingli.$rating1;
	} 
	
	return $content;
}

 

function the_content( $content )
{		
	    // Don't show on custom page templates
	if(is_page_template()) return $content;

	global $wp_current_filter;
	if ( in_array( 'get_the_excerpt', (array) $wp_current_filter ) ) {
		return $content;
	}

	if( !isset($this->options['show_in_post']) ) $this->options['show_in_post'] = '1';
	if( !isset($this->options['show_in_page']) ) $this->options['show_in_page'] = '0';
	if( !isset($this->options['show_in_loops']) ) $this->options['show_in_loops'] = '0';

	$postid = get_the_ID();
	if(is_singular('post') && $this->options['show_in_post']) {
		
		$content = 	$this->crn_show_review_box( $postid,$content );

	}elseif(is_singular('page') && $this->options['show_in_page']) {
		
		$content = 	$this->crn_show_review_box( $postid,$content );

	}elseif((is_front_page() || is_home() || is_category() || is_tag() || is_author() || is_date() || is_search()) && $this->options['show_in_loops'] ){
		$content = 	$this->crn_show_review_box( $postid,$content );
	}

	return $content;
}


public function crn_show_review_box($postid ,$content){
  	 
		$ratingContent = $this->crn_show_ratingbox($postid);
		$content = $content.$ratingContent;
	 
	return $content;
}


/**
 * Show the Top Reviews
 * 
 */
public function themepacific_wpreview_show_top_reviews($no_of_posts) {
	global $post;
	$args = array(
		'meta_key' => 'crn_rating_only',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'posts_per_page' => 5
		);
	$result = '';
	$crn_viewed_posts = new WP_Query( $args );
	if ( $crn_viewed_posts->have_posts() ) {
		while ( $crn_viewed_posts->have_posts() ) : $crn_viewed_posts->the_post();
		echo "<li><a href='" . get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a></li> ";
		endwhile;
		echo "<ul>".$result."</ul>";
	}
	wp_reset_postdata();
}



}

function themepacific_wpreviewBox_lite(){
	global $post;
	$themepacific_wpreview = new themepacific_wpreview_publicl('');
	return $themepacific_wpreview->crn_show_ratingbox(get_the_ID());
}


function themepacific_wpreview_lite() {
	global $post;
	$postid = get_the_ID();
	$rating['themepacific_wpreview_style'] = get_post_meta($postid, 'crn_rate_style', true); 
	$rating['themepacific_wpreview_rating'] = get_post_meta($postid, 'crn_rating_only', true); 
	return $rating;
}


function themepacific_wpreviewCustomSmall_lite($size) {

	$rating  = themepacific_wpreview();

	
	$crnwpStyle  = '';
	$finalscore  =  $rating['themepacific_wpreview_rating'];
	$rating_style = $rating['themepacific_wpreview_style'];
	if(empty($finalscore)) {return;};

	if($rating_style == 'percentage'){

		$ratingTxt = round($finalscore).'%';
		$ratingTxtcl ='';

	}elseif($rating_style == 'point'){
		$ratingTxtcl = 'crnrPoint';

		$ratingTxt = number_format((int)$finalscore/10,1, '.', '');
 
	}else{

		$ratingTxtcl = 'crnrStar';
		$ratingTxt = floatval(number_format((int)$finalscore/10,1, '.', '')).'★';
		$crnwpStyle ='';
	}
	$crnSvgCircle = '';
	
		if($size == 's'){
			$crnSvgCircle ='<svg class="crnwpr_rating_svg_custom" width="30" height="30" viewBox="0 0 30 30"><circle cx="15" cy="15" r="13.5" fill="none" stroke="#e6e6e6" stroke-width="3"></circle><circle class="crnwpr_rating_bar_custom" cx="15" cy="15" r="13.5" fill="none" stroke="#f77a52" stroke-width="3" stroke-dasharray="84.823" stroke-dashoffset="82" ></circle></svg>';

			$ratingTxtclSize = 'customCrnwprSmall';

		}else{

			$crnSvgCircle ='<svg class="crnwpr_rating_svg_custom" width="40" height="40" viewBox="0 0 30 30"><circle cx="15" cy="15" r="13.5" fill="none" stroke="#e6e6e6" stroke-width="2"></circle><circle class="crnwpr_rating_bar_custom" cx="15" cy="15" r="13.5" fill="none" stroke="#f77a52" stroke-width="3" stroke-dasharray="84.823" stroke-dashoffset="82" ></circle></svg>';
			$ratingTxtclSize = 'customCrnwprMedium';
 
		}
	if($ratingTxtcl == 'crnrStar') {
		$crnSvgCircle ='';
	}  	

	return '<div  class="crnwpr_rating_cont_custom '.esc_attr($ratingTxtcl).' '.esc_attr($ratingTxtclSize).'" data-pct="'.round($finalscore).' " data-pcta="'.$ratingTxt.'">'.$crnSvgCircle.'</div>';
}




/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'themepacific_wpreview_best_reviews_widgetl' );
 /**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
 function themepacific_wpreview_best_reviews_widgetl() {
 	register_widget( 'themepacific_wpreview_best_reviews_widgetl' );
 }
/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class themepacific_wpreview_best_reviews_widgetl extends WP_Widget {
	
	public  function __construct() {
		$widget_ops = array('classname' => 'themepacific_wpreview_best_reviews_widget','description' => __( 'A Widget to dispaly Best Reviews Posts With Thumbs', 'crn_wp_review' ));
		parent::__construct('crn-wpreview-bestreviews-widget-pro', __( 'TP WP Review - Best Reviews Widget', 'crn_wp_review' ), $widget_ops);	
	}



/**
* Display the widget
*/	
function widget( $args, $instance ) {
	extract($args);
	if ( ! empty( $instance['title'] ) ) {
		$title = $instance['title'];
	}else{

		$title = __('Recent Reviews','themepacific_wpreview');
	}

	if ( ! empty( $instance['get_catego'] ) ) {
		$get_catego = $instance['get_catego'];
	}else{

		$get_catego = 'all';
	}
	if ( ! empty( $instance['getnumpost'] ) ) {
		$getnumpost = $instance['getnumpost'];
	}else{

		$getnumpost = 5;
	}
	

	
	/* Before widget (defined by themes). */

	/* Display the widget title if one was input (before and after defined by themes). */

	echo $args['before_widget'];

	if ( ! empty( $instance['title'] ) ) {
		$title = $instance['title'];
	}
	if ( ! empty( $title ) ) {
			//echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		echo $args['before_title']; ?>
		<a href="<?php echo get_category_link($get_catego); ?>"> <?php echo esc_html( $title );?></a>
		<?php echo $args['after_title'];


	} ?>

	<div class="popular-rec post_format-post-format-review">

		<!-- Begin category posts -->
		<ul class="sb-tabs-wrap">
			<?php 

			global $post;
			$tpcrn_recent_cat_query = new WP_Query(array(
				'showposts' => $getnumpost,
				'cat' => $get_catego,
				'meta_key' => 'crn_rating_only',
				'orderby' => 'meta_value_num',
				'order' => 'DESC',
				)); 

			$count = 0;
			
			

			while ( $tpcrn_recent_cat_query -> have_posts() ) : $tpcrn_recent_cat_query -> the_post(); 

			?>

			<li class="sb-tabs-wrap-li">

				<div class="sb-post-thumbnail">


					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

						<?php
						echo themepacific_wpreviewCustomSmall('s');
						the_post_thumbnail('crn_themepacific_wpreview_blk_small_thumb');
						?>
					</a>

				</div>

				<div class="sb-post-list-title">

					<h4>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h4>

					<div class="entry-meta">

						<span class="crn-post-item-date"> <?php echo get_the_date( ); ?></span>

					</div>
				</div>

			</li>
			<?php $count++; endwhile; //wp_reset_query(); ?>
		</ul>
		<!-- End category posts -->

	</div>
	<!-- End  container -->
	<?php	
	/* After widget (defined by themes). */
	echo $args['after_widget'];	

}

/**
	 * Update the widget settings.
	 */	function update( $new_instance, $old_instance ) {
$instance = $old_instance;
$instance['title'] = $new_instance['title'];
$instance['get_catego'] = $new_instance['get_catego'];
$instance['getnumpost'] = strip_tags( $new_instance['getnumpost']);
return $instance;
}

	// Widget form

function form( $instance ) {

	$defaults = array( 'title' => __('Category Name', 'themepacific_wpreview'), 'getnumpost' => '5','get_catego' => 'all');
	$instance = wp_parse_args( (array) $instance, $defaults ); 



	?>
	


	
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Enter category Name:', 'themepacific_wpreview'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
	</p>


	<p>
		<label for="<?php echo $this->get_field_id('getnumpost'); ?>"><?php _e('Number of Posts to Show:','themepacific_wpreview'); ?></label>
		<input id="<?php echo $this->get_field_id('getnumpost'); ?>" type="text" name="<?php echo $this->get_field_name('getnumpost'); ?>" value="<?php echo $instance['getnumpost'];?>"  maxlength="2" size="3" /> 
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('get_catego'); ?>">Filter by Category:</label> 
		<select id="<?php echo $this->get_field_id('get_catego'); ?>" name="<?php echo $this->get_field_name('get_catego'); ?>" class="widefat categories" style="width:100%;">
			<option value='all' <?php if ('all' == $instance['get_catego']) echo 'selected="selected"'; ?>>Select categories</option>
			<?php $get_catego = get_categories('hide_empty=0&depth=1&type=post');  
			foreach($get_catego as $category) { ?>
			<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['get_catego']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
			<?php } ?>
		</select>
	</p>
	<?php

}	

}


/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'themepacific_wpreview_recent_reviews_widgetl' );
 /**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
 function themepacific_wpreview_recent_reviews_widgetl() {
 	register_widget( 'themepacific_wpreview_recent_reviews_widgetl' );
 }
/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class themepacific_wpreview_recent_reviews_widgetl extends WP_Widget {
	
	public  function __construct() {
		$widget_ops = array('classname' => 'themepacific_wpreview_recent_reviews_widget','description' => __( 'A Widget to dispaly Recent Reviews Posts With Thumbs', 'themepacific_wpreview' ));
		parent::__construct('crn-wpreview-reviews-widget-pro', __( 'TP WP Review - Recent Reviews Widget', 'crn_wp_review' ), $widget_ops);	
	}



/**
* Display the widget
*/	
function widget( $args, $instance ) {
	extract($args);
	if ( ! empty( $instance['title'] ) ) {
		$title = $instance['title'];
	}else{

		$title = __('Recent Reviews','themepacific_wpreview');
	}

	if ( ! empty( $instance['get_catego'] ) ) {
		$get_catego = $instance['get_catego'];
	}else{

		$get_catego = 'all';
	}
	if ( ! empty( $instance['getnumpost'] ) ) {
		$getnumpost = $instance['getnumpost'];
	}else{

		$getnumpost = 5;
	}
	

	
	/* Before widget (defined by themes). */

	/* Display the widget title if one was input (before and after defined by themes). */

	echo $args['before_widget'];

	if ( ! empty( $instance['title'] ) ) {
		$title = $instance['title'];
	}
	if ( ! empty( $title ) ) {
			//echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		echo $args['before_title']; ?>
		<a href="<?php echo get_category_link($get_catego); ?>"> <?php echo esc_html( $title );?></a>
		<?php echo $args['after_title'];


	} ?>


	<div class="popular-rec post_format-post-format-review">
		<!-- Begin category posts -->
		<ul class="sb-tabs-wrap">
			<?php 

			global $post;
			$tpcrn_recent_cat_query = new WP_Query(array(
				'showposts' => $getnumpost,
				'cat' => $get_catego,
				'meta_key' => 'crn_rating_only',
				)); 

			$count = 0;
			
			

			while ( $tpcrn_recent_cat_query -> have_posts() ) : $tpcrn_recent_cat_query -> the_post(); 

			?>

			<li class="sb-tabs-wrap-li">

				<div class="sb-post-thumbnail">


					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

						<?php
						echo themepacific_wpreviewCustomSmall('s');
						the_post_thumbnail('crn_themepacific_wpreview_blk_small_thumb');
						?>
					</a>

				</div>

				<div class="sb-post-list-title">

					<h4>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h4>

					<div class="entry-meta">

						<span class="crn-post-item-date"> <?php echo get_the_date( ); ?></span>

					</div>
				</div>

			</li>
			<?php $count++; endwhile; //wp_reset_query(); ?>
		</ul>

	</div>
	<!-- End  container -->
	<?php	
	/* After widget (defined by themes). */
	echo $args['after_widget'];	

}

/**
	 * Update the widget settings.
	 */	function update( $new_instance, $old_instance ) {
$instance = $old_instance;
$instance['title'] = $new_instance['title'];
$instance['get_catego'] = $new_instance['get_catego'];
$instance['getnumpost'] = strip_tags( $new_instance['getnumpost']);
return $instance;
}

	// Widget form

function form( $instance ) {

	$defaults = array( 'title' => __('Category Name', 'themepacific_wpreview'), 'getnumpost' => '5','get_catego' => 'all');
	$instance = wp_parse_args( (array) $instance, $defaults ); 



	?>
	


	
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Enter category Name:', 'themepacific_wpreview'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
	</p>


	<p>
		<label for="<?php echo $this->get_field_id('getnumpost'); ?>"><?php _e('Number of Posts to Show:','themepacific_wpreview'); ?></label>
		<input id="<?php echo $this->get_field_id('getnumpost'); ?>" type="text" name="<?php echo $this->get_field_name('getnumpost'); ?>" value="<?php echo $instance['getnumpost'];?>"  maxlength="2" size="3" /> 
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('get_catego'); ?>">Filter by Category:</label> 
		<select id="<?php echo $this->get_field_id('get_catego'); ?>" name="<?php echo $this->get_field_name('get_catego'); ?>" class="widefat categories" style="width:100%;">
			<option value='all' <?php if ('all' == $instance['get_catego']) echo 'selected="selected"'; ?>>Select categories</option>
			<?php $get_catego = get_categories('hide_empty=0&depth=1&type=post');  
			foreach($get_catego as $category) { ?>
			<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['get_catego']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
			<?php } ?>
		</select>
	</p>
	<?php

}	

}