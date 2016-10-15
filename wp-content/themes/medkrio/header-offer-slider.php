<!DOCTYPE html>
<!--[if IE 6]><html id="ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html id="ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html id="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
	
	<meta charset="utf-8" />
	<?php $detect = new Mobile_Detect();
	if (get_option_tree('responsive_layout') == 'Responsive layout only for smartphones' && !$detect->isTablet()) { 
		echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
	} elseif (get_option_tree('responsive_layout') == 'Responsive layout for smartphones and tablets') {
		echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
	} ?>

	<title><?php bloginfo('name'); ?>  <?php wp_title(); ?></title>

	<link rel="shortcut icon" href="<?php get_option_tree('favicon', '', true); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />

	<?php if (get_option_tree('responsive_layout') == 'Responsive layout only for smartphones') {
		echo '<link rel="stylesheet" href="', MNKY_CSS .'/mobile.css" type="text/css" media="screen" />';
	} elseif (get_option_tree('responsive_layout') == 'Responsive layout for smartphones and tablets') {
		echo '<link rel="stylesheet" href="', MNKY_CSS .'/mobile-all.css" type="text/css" media="screen" />';
	} ?>
	
	<!--[if IE 7 ]>
	<link href="<?php echo MNKY_CSS ?>/ie7.css" media="screen" rel="stylesheet" type="text/css">
	<![endif]-->
	<!--[if IE 8 ]>
	<link href="<?php echo MNKY_CSS ?>/ie8.css" media="screen" rel="stylesheet" type="text/css">
	<![endif]-->
	<!--[if lte IE 6]>
	<div id="ie-message">Your browser is obsolete and does not support this webpage. Please use newer version of your browser or visit <a href="http://www.ie6countdown.com/" target="_new">Internet Explorer 6 countdown page</a>  for more information. </div>
	<![endif]-->

	<?php 
	require_once(MNKY_FUNCTIONS . '/offer_slider/offer_param.php');
	wp_enqueue_style('Offer_style', get_template_directory_uri() . '/functions/offer_slider/css/offer.css', false, '', 'all');
	wp_head(); ?>

	<?php get_option_tree('analytics_code', '', true); ?>  
</head>

<body <?php body_class(); ?>>

<!-- *******************************Logo & Menu****************************** -->
<div id="horiz_m_bg">
<?php get_sidebar('top') ?>
<div id="horiz_m" class="size-wrap">

<div id="logo">
<a href="<?php echo home_url(); ?>"><img src="<?php get_option_tree('logo_uploud', '', true); ?>" alt="<?php bloginfo('name'); ?>" /></a>
</div><!--#logo-->

<div id="main_menu" class="slidemenu">
<?php wp_nav_menu( array('theme_location' => 'primary', 'container' => false, 'items_wrap' => '<ul id="primary-main-menu" class=%2$s>%3$s</ul>', 'fallback_cb' => false)); ?>  
</div><!--#main_menu-->

</div><!--#horiz_m-->
</div><!--#horiz_m_bg-->

<!-- *******************************Subhead********************************** -->
<div id="subhead">
<?php if (get_option_tree('disable_subhead_inner_shadows', '')) {} else { 
echo '<div class="subhead_shadow"></div>';} ?>
<?php echo '<div class="page_title size-wrap mobile_slider_replace"><h1 class="entry-title-page">', wp_title (''). '</h1>', breadcrumbs_plus(). '</div>' ?>
<div id="offer_slider_frame">
<?php require_once(MNKY_FUNCTIONS . '/offer_slider/offer_slider.php') ?>
</div>
<?php if (get_option_tree('disable_subhead_inner_shadows', '')) {} else { 
echo '<div class="subhead_shadow_bottom"></div>'; } ?>
</div><!--#subhead-->

<!-- *******************************Wrapper********************************** -->
<div id="wrapper" class="size-wrap">