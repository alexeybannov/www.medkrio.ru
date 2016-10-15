<?php
/*
 * Plugin Name: Elegant Shortcodes
 * Plugin URI: http://www.elegantthemes.com
 * Description: The ultimate shortcodes collection for any theme.
 * Version: 1.0
 * Author: Elegant Themes
 * Author URI: http://www.elegantthemes.com
 * License: GPLv2 or later
 */
  
define( 'ET_SHORTCODES_PLUGIN_DIR', trailingslashit( dirname(__FILE__) ) );
define( 'ET_SHORTCODES_PLUGIN_URI', plugins_url('', __FILE__) );

add_action( 'init', 'et_shortcodes_main_load', 12 );
function et_shortcodes_main_load(){
	global $epanelMainTabs;
	if ( is_array( $epanelMainTabs ) ) return;
	
	require_once( ET_SHORTCODES_PLUGIN_DIR . '/shortcodes.php' );
}