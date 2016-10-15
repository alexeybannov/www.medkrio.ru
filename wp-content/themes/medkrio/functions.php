<?php

/*	
*	---------------------------------------------------------------------
*	MNKY Functions
*	--------------------------------------------------------------------- 
*/

// Define directories
define('MNKY_FUNCTIONS', get_template_directory() . '/functions');
define('MNKY_PATH', get_template_directory_uri() );
define('MNKY_CSS', get_template_directory_uri() . '/css');

require_once(MNKY_FUNCTIONS . '/theme_options/index.php');
require_once(MNKY_FUNCTIONS . '/sidebars.php');
require_once(MNKY_FUNCTIONS . '/breadcrumb-trail.php');
require_once(MNKY_FUNCTIONS . '/content_elements.php');
require_once(MNKY_FUNCTIONS . '/portfolio.php');
require_once(MNKY_FUNCTIONS . '/news-shortcode.php');
require_once(MNKY_FUNCTIONS . '/cutom_meta_boxes.php');
require_once(MNKY_FUNCTIONS . '/sidebar/per-page-sidebars.php');
require_once(MNKY_FUNCTIONS . '/pager.php');
require_once(MNKY_FUNCTIONS . '/widgets/social-widget/social-widget.php');
require_once(MNKY_FUNCTIONS . '/widgets/sidebar-login/sidebar-login.php');
require_once(MNKY_FUNCTIONS . '/widgets/recent-posts-widget.php');
require_once(MNKY_FUNCTIONS . '/recent-posts-slider/recent-posts-slider.php');
require_once(MNKY_FUNCTIONS . '/easy-fancybox/easy-fancybox.php');
require_once(MNKY_FUNCTIONS . '/contact-form/grunion-contact-form.php');
require_once(MNKY_FUNCTIONS . '/shortcodes-ultimate/shortcodes-ultimate.php');
require_once(MNKY_FUNCTIONS . '/mobile_detect.php');

/*	
*	---------------------------------------------------------------------
*	Add scripts
*	--------------------------------------------------------------------- 
*/

add_action('wp_enqueue_scripts', 'scripts');
function scripts() {
    // jQuery
	wp_enqueue_script( 'jquery' );
	
	// Menu
	wp_enqueue_script('menu_drop', get_template_directory_uri() . '/js/slidemenu.js', array('jquery'), '', false);
	
	// Portfolio
	if (is_page_template('portfolio-one.php') || is_page_template('portfolio-two.php') || is_page_template('portfolio-three.php') || is_page_template('portfolio-four.php') ) {
	wp_enqueue_style('Portfolio_style', get_template_directory_uri() . '/functions/portfolio/stylesheets/screen.css', false, '', 'all');
	wp_enqueue_script('Portfolio', get_template_directory_uri() . '/functions/portfolio/scripts/framework.js', array('jquery'), '', false);
	}
	
	if (is_page_template('portfolio-one.php') || is_page_template('portfolio-two.php') || is_page_template('portfolio-three.php') || is_page_template('portfolio-four.php') || is_page_template('paged-portfolio-one.php') || is_page_template('paged-portfolio-two.php') || is_page_template('paged-portfolio-three.php') || is_page_template('paged-portfolio-four.php') ) {
	
	// Mosaic
	wp_enqueue_style('Mosaic_style', get_template_directory_uri() . '/functions/mosaic/css/mosaic.css', false, '', 'all');
	wp_enqueue_script('Mosaic', get_template_directory_uri() . '/functions/mosaic/js/mosaic.1.0.1.min.js', array('jquery'), '', false);
	wp_enqueue_script('portfolio-effect', get_template_directory_uri() . '/js/portfolio_effects.js', array('jquery'), '', false);
	}
	
	// Sliding sidebar
	if (get_option_tree('disable_sliding_sidebar_opt', '')) {} else {
	wp_enqueue_script('TabSlide', get_template_directory_uri() . '/js/jquery.tabSlideOut.v1.3.js', array('jquery'), '', false);
	}
	
	// Cufon
	if (get_option_tree('disable_cufon_fonts', '')) {} else {
	wp_enqueue_script('cufon', get_template_directory_uri() . '/js/cufon-yui.js', array('jquery'), '', true);
	}	
	
	// To top
	wp_enqueue_script('top', get_template_directory_uri() . '/js/top.js', array('jquery'), '', true);
	
	//Social media widget
	wp_enqueue_style('social_media', get_template_directory_uri() . '/functions/widgets/social-widget/social_widget.css', false, '', 'all');
	
	// Dynamic style
	wp_enqueue_style('dynamic-style', get_template_directory_uri() . '/dynamic-style.php', false, '', 'all');
	
	// Comment Script
	if(is_singular() && comments_open()){
		wp_enqueue_script( 'comment-reply' ); 
	}
	
	//Mobile menu
	wp_enqueue_script('mobileMenu', get_template_directory_uri() . '/js/jquery.mobilemenu.js', array('jquery'), '', false);


}


/*	
*	---------------------------------------------------------------------
*	Theme setup
*	--------------------------------------------------------------------- 
*/

/* Remove actions */
remove_action( 'wp_head', 'feed_links_extra'); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links'); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link'); // index link
remove_action( 'wp_head', 'parent_post_rel_link'); // prev link
remove_action( 'wp_head', 'start_post_rel_link'); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link'); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version

/* Set content width */
if ( ! isset( $content_width ) ) $content_width = 980;

/* Register menu */
register_nav_menus( array(
	'primary' => __( 'Main Navigation', 'care' ),
	'footer' => __( 'Footer Navigation', 'care' ),
) );

/* Shortcodes in menu */
add_filter('wp_nav_menu', 'do_shortcode');

/* Thumbnails */
add_theme_support( 'post-thumbnails' );

/* Feeds */
add_theme_support( 'automatic-feed-links' );

/* Custom WordPress login */
function custom_login_head() {
	$login_logo = get_option_tree('login_logo', '');
	if($login_logo){
	echo "
		<style> 
		body.login #login h1 a {
		background: url('" . get_option_tree('login_logo') . "') no-repeat scroll center bottom transparent;
		height: 80px;
		width: 326px;
		margin-bottom:20px;
		}
		</style>";
	}
}
add_action('login_head', 'custom_login_head');


function custom_login_url() {
  return site_url();
}
add_filter( 'login_headerurl', 'custom_login_url', 10, 4 );


function custom_login_title() {
     return get_bloginfo('name');
}
add_filter('login_headertitle', 'custom_login_title');

/* Exclude category from blog */
function excludeCat($query) {
  if ( $query->is_home ) {
	$excludeCat = get_option_tree('exclude_categories_from_blog', '');
	if($excludeCat){
	$query->set('cat', $excludeCat);
	}
  }
  return $query;
}
add_filter('pre_get_posts', 'excludeCat');

/* Custom post count in search page */
function post_count($query) {
  if ($query->is_search) {
	$query->set('posts_per_page', '10');
  }
  return $query;
}
add_filter('pre_get_posts', 'post_count');

/* Custom excerpts */
function excerpt($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'&nbsp;...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
}

/* Custom editor buttons */
function enable_more_buttons($buttons) {
	$buttons[] = 'hr';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'fontselect';
	$buttons[] = 'fontsizeselect';
	return $buttons;
}
add_filter("mce_buttons_3", "enable_more_buttons");


/* Validation for category tag */
add_filter( 'the_category', 'add_nofollow_cat' ); 
function add_nofollow_cat( $text ) { 
$text = str_replace('rel="category tag"', "", $text); return $text; 
}

/* Languages */
function theme_language(){
    load_theme_textdomain('care', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'theme_language');

/* Add editor style */
add_editor_style('style.css');

?>