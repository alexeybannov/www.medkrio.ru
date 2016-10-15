<?php
/*
 * Plugin Name: Elegant Builder
 * Plugin URI: http://www.elegantthemes.com
 * Description: A visual drag and drop page builder from Elegant Themes.
 * Version: 1.0
 * Author: Elegant Themes
 * Author URI: http://www.elegantthemes.com
 * License: GPLv2 or later
 */
define( 'ET_LB_PLUGIN_DIR', trailingslashit( dirname(__FILE__) ) );
define( 'ET_LB_PLUGIN_URI', plugins_url('', __FILE__) );
 
add_action( 'init', 'et_lb_plugin_main' );
function et_lb_plugin_main(){
	global $epanelMainTabs;
	
	if ( ! is_array( $epanelMainTabs ) ){
		if ( ! function_exists( 'et_new_thumb_resize' ) ){
			function et_new_thumb_resize( $thumbnail, $width, $height, $alt='', $forstyle = false ){
				global $shortname;
					
				$new_method = true;
				$new_method_thumb = '';
				$external_source = false;
					
				$allow_new_thumb_method = !$external_source && $new_method;
				
				if ( $allow_new_thumb_method && $thumbnail <> '' ){
					$et_crop = true;
					$new_method_thumb = et_resize_image( $thumbnail, $width, $height, $et_crop );
					if ( is_wp_error( $new_method_thumb ) ) $new_method_thumb = '';
				}
				
				$thumb = esc_attr( $new_method_thumb );
				
				$output = '<img src="' . esc_url( $thumb ) . '" alt="' . esc_attr( $alt ) . '" width =' . esc_attr( $width ) . ' height=' . esc_attr( $height ) . ' />';
				
				return ( !$forstyle ) ? $output : $thumb;
			}
		}

		if ( ! function_exists( 'et_resize_image' ) ){
			function et_resize_image( $thumb, $new_width, $new_height, $crop ){
				if ( is_ssl() ) $thumb = preg_replace( '#^http://#', 'https://', $thumb );
				$info = pathinfo($thumb);
				$ext = $info['extension'];
				$name = wp_basename($thumb, ".$ext");
				$is_jpeg = false;
				$site_uri = apply_filters( 'et_resize_image_site_uri', site_url() );
				$site_dir = apply_filters( 'et_resize_image_site_dir', ABSPATH );
				
				#get main site url on multisite installation 
				if ( is_multisite() ){
					switch_to_blog(1);
					$site_uri = site_url();
					restore_current_blog();
				}
				
				if ( 'jpeg' == $ext ) {
					$ext = 'jpg';
					$name = preg_replace( '#.jpeg$#', '', $name );
					$is_jpeg = true;
				}
				
				$suffix = "{$new_width}x{$new_height}";
				
				$destination_dir = '' != get_option( 'et_images_temp_folder' ) ? preg_replace( '#\/\/#', '/', get_option( 'et_images_temp_folder' ) ) : null;
				
				$matches = apply_filters( 'et_resize_image_site_dir', array(), $site_dir );
				if ( !empty($matches) ){
					preg_match( '#'.$matches[1].'$#', $site_uri, $site_uri_matches );
					if ( !empty($site_uri_matches) ){
						$site_uri = str_replace( $matches[1], '', $site_uri );
						$site_uri = preg_replace( '#/$#', '', $site_uri );
						$site_dir = str_replace( $matches[1], '', $site_dir );
						$site_dir = preg_replace( '#\\\/$#', '', $site_dir );
					}
				}
				
				#get local name for use in file_exists() and get_imagesize() functions
				$localfile = str_replace( apply_filters( 'et_resize_image_localfile', $site_uri, $site_dir, et_multisite_thumbnail($thumb) ), $site_dir, et_multisite_thumbnail($thumb) );
				
				$add_to_suffix = '';
				if ( file_exists( $localfile ) ) $add_to_suffix = filesize( $localfile ) . '_';
				
				#prepend image filesize to be able to use images with the same filename
				$suffix = $add_to_suffix . $suffix;
				$destfilename_attributes = '-' . $suffix . '.' . $ext;
				
				$checkfilename = ( '' != $destination_dir && null !== $destination_dir ) ? path_join( $destination_dir, $name ) : path_join( dirname( $localfile ), $name );
				$checkfilename .= $destfilename_attributes;
				
				if ( $is_jpeg ) $checkfilename = preg_replace( '#.jpeg$#', '.jpg', $checkfilename );
				
				$uploads_dir = wp_upload_dir();
				$uploads_dir['basedir'] = preg_replace( '#\/\/#', '/', $uploads_dir['basedir'] );
				
				if ( null !== $destination_dir && '' != $destination_dir && apply_filters('et_enable_uploads_detection', true) ){
					$site_dir = trailingslashit( preg_replace( '#\/\/#', '/', $uploads_dir['basedir'] ) );
					$site_uri = trailingslashit( $uploads_dir['baseurl'] );
				}
				
				#check if we have an image with specified width and height
				
				if ( file_exists( $checkfilename ) ) return str_replace( $site_dir, trailingslashit( $site_uri ), $checkfilename );

				$size = @getimagesize( $localfile );
				if ( !$size ) return new WP_Error('invalid_image_path', __('Image doesn\'t exist'), $thumb);
				list($orig_width, $orig_height, $orig_type) = $size;
				
				#check if we're resizing the image to smaller dimensions
				if ( $orig_width > $new_width || $orig_height > $new_height ){
					if ( $orig_width < $new_width || $orig_height < $new_height ){
						#don't resize image if new dimensions > than its original ones
						if ( $orig_width < $new_width ) $new_width = $orig_width;
						if ( $orig_height < $new_height ) $new_height = $orig_height;
						
						#regenerate suffix and appended attributes in case we changed new width or new height dimensions
						$suffix = "{$add_to_suffix}{$new_width}x{$new_height}";
						$destfilename_attributes = '-' . $suffix . '.' . $ext;
						
						$checkfilename = ( '' != $destination_dir && null !== $destination_dir ) ? path_join( $destination_dir, $name ) : path_join( dirname( $localfile ), $name );
						$checkfilename .= $destfilename_attributes;
						
						#check if we have an image with new calculated width and height parameters
						if ( file_exists($checkfilename) ) return str_replace( $site_dir, trailingslashit( $site_uri ), $checkfilename );
					}
					
					#we didn't find the image in cache, resizing is done here
					$result = image_resize( $localfile, $new_width, $new_height, $crop, $suffix, $destination_dir );
						
					if ( !is_wp_error( $result ) ) {
						#transform local image path into URI
						
						if ( $is_jpeg ) $thumb = preg_replace( '#.jpeg$#', '.jpg', $thumb);
						
						$site_dir = str_replace( '\\', '/', $site_dir );
						$result = str_replace( '\\', '/', $result );
						$result = str_replace( $site_dir, trailingslashit( $site_uri ), $result );
					}
					
					#returns resized image path or WP_Error ( if something went wrong during resizing )
					return $result;
				}
				
				#returns unmodified image, for example in case if the user is trying to resize 800x600px to 1920x1080px image
				return $thumb;
			}
		}

		if ( ! function_exists( 'et_create_images_temp_folder' ) ){
			add_action( 'init', 'et_create_images_temp_folder' );
			function et_create_images_temp_folder(){
				#clean et_temp folder once per week
				if ( false !== $last_time = get_option( 'et_schedule_clean_images_last_time'  ) ){
					$timeout = 86400 * 7;
					if ( ( $timeout < ( time() - $last_time ) ) && '' != get_option( 'et_images_temp_folder' ) ) et_clean_temp_images( get_option( 'et_images_temp_folder' ) );
				}
				
				if ( false !== get_option( 'et_images_temp_folder' ) ) return;
				
				$uploads_dir = wp_upload_dir();
				$destination_dir = ( false === $uploads_dir['error'] ) ? path_join( $uploads_dir['basedir'], 'et_temp' ) : null;
					
				if ( ! wp_mkdir_p( $destination_dir ) ) update_option( 'et_images_temp_folder', '' );
				else { 
					update_option( 'et_images_temp_folder', preg_replace( '#\/\/#', '/', $destination_dir ) );
					update_option( 'et_schedule_clean_images_last_time', time() );
				}
			}
		}

		if ( ! function_exists( 'et_clean_temp_images' ) ){
			function et_clean_temp_images( $directory ){
				$dir_to_clean = @ opendir( $directory );
				
				if ( $dir_to_clean ) {
					while (($file = readdir( $dir_to_clean ) ) !== false ) {
						if ( substr($file, 0, 1) == '.' )
							continue;
						if ( is_dir( $directory.'/'.$file ) )
							et_clean_temp_images( path_join( $directory, $file ) );
						else
							@ unlink( path_join( $directory, $file ) );
					}
					closedir( $dir_to_clean );
				}
				
				#set last time cleaning was performed
				update_option( 'et_schedule_clean_images_last_time', time() );
			}
		}

		if ( ! function_exists( 'et_multisite_thumbnail' ) ){
			function et_multisite_thumbnail( $thumbnail = '' ) {
				// do nothing if it's not a Multisite installation or current site is the main one
				if ( is_main_site() ) return $thumbnail;
				
				# get the real image url
				preg_match( '#([_0-9a-zA-Z-]+/)?files/(.+)#', $thumbnail, $matches );
				if ( isset( $matches[2] ) ){
					$file = rtrim( BLOGUPLOADDIR, '/' ) . '/' . str_replace( '..', '', $matches[2] );
					if ( is_file( $file ) ) $thumbnail = str_replace( ABSPATH, get_site_url( 1 ), $file );
					else $thumbnail = '';
				}

				return $thumbnail;
			}
		}

		if ( ! function_exists( 'et_update_uploads_dir' ) ){
			add_filter( 'update_option_upload_path', 'et_update_uploads_dir' );
			function et_update_uploads_dir( $upload_path ){
				$uploads_dir = wp_upload_dir();
				$destination_dir = ( false === $uploads_dir['error'] ) ? path_join( $uploads_dir['basedir'], 'et_temp' ) : null;
				
				update_option( 'et_images_temp_folder', preg_replace( '#\/\/#', '/', $destination_dir ) );

				return $upload_path;
			}
		}	
	}
		
	add_action( 'admin_enqueue_scripts', 'et_lb_scripts_styles', 10, 1 );
	function et_lb_scripts_styles( $hook ) {
		if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) ){
			et_lb_new_settings_page_js();
			et_lb_new_settings_page_css();
		}
	}

	function et_lb_add_custom_box(){
		add_meta_box( 'et_lb_layout', __( 'Layout Builder', 'Convertible' ), 'et_lb_layout_custom_box', 'post', 'normal', 'high' );
		add_meta_box( 'et_lb_layout', __( 'Layout Builder', 'Convertible' ), 'et_lb_layout_custom_box', 'page', 'normal', 'high' );
	}

	function et_lb_layout_custom_box(){
		et_lb_new_build_settings_page();
	} 

	add_action( 'wp_enqueue_scripts', 'et_lb_add_modules_frontend_js_css' );
	function et_lb_add_modules_frontend_js_css(){
		wp_enqueue_style( 'et_lb_modules', ET_LB_PLUGIN_URI . '/style.css' );
	}
}

add_shortcode('et_lb_logo', 'et_new_lb_logo');
function et_new_lb_logo($atts, $content = null) {
	extract(shortcode_atts(array(
				'align' => 'center'
			), $atts));
			
	$logo = ( $logo_url = trim( $content ) ) && '' != $logo_url ? $logo_url : get_template_directory_uri() . '/images/logo.png';
	$inline_styles = '';
	
	if ( 'center' != $align ) $inline_styles .= " text-align: {$align};";
	$attributes = et_lb_get_attributes( $atts, 'et_lb_logo', $inline_styles );
	
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<a href='" . esc_url( home_url() ) ."'>
						<img src='" .  esc_url( $logo ) . "' alt='" . esc_attr( get_bloginfo('name') ) . "' />
					</a>
				</div>";
	
	return $output;
}

add_shortcode('et_lb_paper', 'et_new_lb_paper');
function et_new_lb_paper($atts, $content = null) {
	$attributes = et_lb_get_attributes( $atts, "et_lb_note-block" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>	
					<div class='et_lb_note'>
						<div class='et_lb_note-inner'>
							<div class='et_lb_note-content clearfix'>"
								. do_shortcode( et_lb_fix_shortcodes($content) ) .
							"</div> <!-- end .et_lb_note-content-->
						</div> <!-- end .et_lb_note-inner-->
					</div> <!-- end .et_lb_note-->
					<div class='et_lb_note-bottom-left'>
						<div class='et_lb_note-bottom-right'>
							<div class='et_lb_note-bottom-center'></div>
						</div>	
					</div>
				</div> <!-- end .et_lb_note-block-->";
	
	return $output;
}

add_shortcode('et_lb_video', 'et_new_lb_video');
function et_new_lb_video($atts, $content = null) {
	global $wp_embed;
	extract(shortcode_atts(array(
				'video_url' => ''
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_note-video" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>	
					<div class='et_lb_note-video-bg'>
						<div class='et_lb_note-video-container clearfix'>"
							. ( '' != $video_url ? '<div class="et_note_video_container">' . $wp_embed->shortcode( '', $video_url ) . '</div>' : '' )
							. do_shortcode( et_lb_fix_shortcodes($content) ) .
						"</div> <!-- end .et_lb_note-video-container-->
					</div> <!-- end .et_lb_note-video-bg-->
					<div class='et_lb_video-bottom-left'>
						<div class='et_lb_video-bottom-right'>
							<div class='et_lb_video-bottom-center'></div>
						</div>	
					</div>
				</div> <!-- end .et_lb_note-video-->";
				
	et_new_load_convertible_scripts( array( 'video' ) );

	return $output;
}

add_shortcode('et_lb_testimonial', 'et_new_lb_testimonial');
function et_new_lb_testimonial($atts, $content = null) {
	extract(shortcode_atts(array(
				'image_url' => '',
				'author_name' => '',
				'author_position' => '',
				'author_site' => ''
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_new-testimonial" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>	
					<div class='et_lb_module_content clearfix'>
						<div class='et_lb_testimonial-bottom'></div>"
						. ( '' != $image_url ?
							"<div class='et_lb_testimonial-image'>
								<img alt='' src='" . esc_url( et_new_thumb_resize( et_multisite_thumbnail($image_url), 51, 51, '', true ) ) . "' />
								<span class='et_lb_overlay'></span>
							</div> <!-- end .et_lb_testimonial-image -->"
						: '' )
						. ( '' != $author_name ?
							"<h3>" . esc_html( $author_name ) . "</h3>"
						: '' )
						. "<p class='et_lb_testimonial-meta'>" . esc_html( $author_position )
							. ( '' != $author_site ? "<br />" . "<a href='" . esc_url( $author_site ) . "'>" . esc_html( $author_site ) . "</a>" : '' )
						. "</p>" . "<div class='clear'></div>"
						. do_shortcode( et_lb_fix_shortcodes($content) ) .
					"</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_new-testimonial-->";

	return $output;
}

add_shortcode('et_lb_slogan', 'et_new_lb_slogan');
function et_new_lb_slogan($atts, $content = null) {
	$attributes = et_lb_get_attributes( $atts, "et_lb_slogan" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content clearfix'>"
						. do_shortcode( et_lb_fix_shortcodes($content) )
						. "<span class='right-quote'></span>" .
					"</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_slogan -->";

	return $output;
}

add_shortcode('et_lb_slider', 'et_new_lb_slider');
function et_new_lb_slider($atts, $content = null){
	global $et_lb_sliders_on_page, $et_lb_slider_imagesize;
	
	extract(shortcode_atts(array(
				'imagesize' => '',
				'animation' => 'fade',
				'animation_duration' => '600',
				'auto_animation' => 'off',
				'auto_speed' => '7000',
				'pause_on_hover' => 'off'
			), $atts));
	
	$et_lb_slider_imagesize = ( '' == $imagesize ) ? '' : $imagesize;
	$et_lb_sliders_on_page = isset( $et_lb_sliders_on_page ) ? ++$et_lb_sliders_on_page : 1;
	
	$class = '';
	if ( ! in_array( $animation, array('','fade') ) ) $class .= " et_lb_slider_effect_{$animation}";
	if ( ! in_array( $animation_duration, array('','600') ) ) $class .= " et_lb_slider_animation_duration_{$animation_duration}";
	if ( ! in_array( $auto_animation, array('','off') ) ) $class .= " et_lb_slider_animation_auto_{$auto_animation}";
	if ( ! in_array( $auto_speed, array('','7000') ) ) $class .= " et_lb_slider_animation_autospeed_{$auto_speed}";
	if ( ! in_array( $pause_on_hover, array('','off') ) ) $class .= " et_lb_slider_pause_hover_{$pause_on_hover}";
	
	$attributes = et_lb_get_attributes( $atts, "et_lb_slider flex-container{$class}" );
	
	$output = 	"<div id='" . esc_attr('et_lb_slider_' . $et_lb_sliders_on_page) . "' {$attributes['class']}{$attributes['inline_styles']}>
					<div class='flexslider'>
						<ul class='slides'>"
							. do_shortcode( et_lb_fix_shortcodes($content) ) .
						"</ul> <!-- end .slides -->
					</div> <!-- .flexslider -->
				</div> <!-- end .et_lb_slider -->";
				
	et_new_load_convertible_scripts( array( 'slider' ) );
	
	return $output;
}

add_shortcode('et_attachment', 'et_new_attachment');
function et_new_attachment($atts, $content = null){
	global $et_lb_slider_imagesize;
	
	extract(shortcode_atts(array(
				'attachment_id' => '',
				'link' => ''
			), $atts));

	$attachment_image = $image_size = '';
	$image = wp_get_attachment_image_src( $attachment_id, 'full' );
	
	if ( '' != $et_lb_slider_imagesize ){
		$image_size = explode( 'x', $et_lb_slider_imagesize );
		$image_size = array_map('intval', $image_size);
	}
	
	$attachment_image = ( '' != $image && '' == $et_lb_slider_imagesize ) ? $image[0] : et_new_thumb_resize( et_multisite_thumbnail( $image[0] ), $image_size[0], $image_size[1], '', true );
	if ( '' != $attachment_image ) $attachment_image = "<img alt='' src='" . esc_url( $attachment_image ) . "' />" . "<span class='et_attachment_overlay'></span>";
	
	$output = 	"<li>"
					. ( '' != $link ? "<a href='" . esc_url( $link ) . "'>" . $attachment_image . "</a>" : $attachment_image )
					. ( '' != $content ? "<div class='flex-caption'>" . do_shortcode( et_lb_fix_shortcodes($content) ) . "</div>" : '' ) .
				"</li>";
	
	return $output;
}

add_shortcode('et_lb_button', 'et_new_lb_button');
function et_new_lb_button($atts, $content = null) {
	extract(shortcode_atts(array(
				'color' => 'blue',
				'size' => 'small',
				'url' => '',
				'window' => 'off',
				'align' => 'left'
			), $atts));

	$inline_styles = '';
	$class = " et_lb_button_{$color} et_lb_button_{$size}";
	
	if ( 'left' != $align ) $inline_styles .= " text-align: {$align};";
	$attributes = et_lb_get_attributes( $atts, "et_lb_button{$class}", $inline_styles );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<a " . ( 'on' == $window ? "target='_blank' " : "" ) . "href='" . esc_url( $url ) . "'>	
						<span>" . do_shortcode( et_lb_fix_shortcodes($content) ) . "</span>
					</a>
				</div> <!-- end .et_lb_button -->";

	return $output;
}

add_shortcode('et_lb_bar', 'et_new_lb_bar');
function et_new_lb_bar($atts, $content = null) {
	$attributes = et_lb_get_attributes( $atts, "et_lb_bar" );
		
	$output = "<div {$attributes['class']}{$attributes['inline_styles']}></div>";

	return $output;
}

add_shortcode('et_lb_list', 'et_new_lb_list');
function et_new_lb_list($atts, $content = null) {
	extract(shortcode_atts(array(
				'type' => 'checkmark'
			), $atts));
			
	$attributes = et_lb_get_attributes( $atts, "et_lb_list et_lb_list_{$type}" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_list -->";

	return $output;
}

add_shortcode('et_lb_toggle', 'et_new_lb_toggle');
function et_new_lb_toggle($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
				'state' => 'close'
			), $atts));
			
	$attributes = et_lb_get_attributes( $atts, "et_lb_toggle et_lb_toggle_{$state}" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content'>
						<div class='et_lb_module_content_inner'>
							<h3 class='et_lb_toggle_title'>{$heading}<span class='et_toggle'></span></h3>
							<div class='et_lb_toggle_content clearfix" . ( 'close' == $state ? ' et_lb_hidden' : '' ) . "'>"
								. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"			</div>
						</div> <!-- end .et_lb_module_content_inner -->
					</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_toggle -->";

	et_new_load_convertible_scripts( array( 'custom' ) );
				
	return $output;
}

add_shortcode('et_lb_tabs', 'et_new_lb_tabs');
function et_new_lb_tabs($atts, $content = null) {
	global $et_lb_tab_titles;
	
	$et_lb_tab_titles = array();
	$attributes = et_lb_get_attributes( $atts, "et_lb_tabs" );

	$tabs_content = "<div class='et_lb_module_content'>
						<div class='et_lb_module_content_inner'>"
							. do_shortcode( et_lb_fix_shortcodes($content) ) .
					"	</div> <!-- end .et_lb_module_content_inner -->
					</div> <!-- end .et_lb_module_content -->";

	$tabs = "<ul class='et_lb_tabs_nav clearfix'>";
	
	$i = 0;
	foreach ( $et_lb_tab_titles as $tab_title ){
		++$i;
		$tabs .= "<li" . ( 1 == $i ? ' class="et_lb_tab_active"' : '' ) . "><a href='#'>{$tab_title}</a></li>";
	}
	$tabs .= "</ul>";
	
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					{$tabs}
					{$tabs_content}
				</div> <!-- end .et_lb_tabs -->";
	
	et_new_load_convertible_scripts( array('custom') );
	
	return $output;
}

add_shortcode('et_lb_tab', 'et_new_lb_tab');
function et_new_lb_tab($atts, $content = null) {
	global $et_lb_tab_titles;
	
	extract(shortcode_atts(array(
				'title' => ''
			), $atts));
	
	$et_lb_tab_titles[] = '' != $title ? $title : 'Tab';
	
	$output = 	"<div class='clearfix et_lb_tab" . ( 1 != count( $et_lb_tab_titles ) ? " et_lb_tab_hidden" : '' ) . "'>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_tab -->";

	return $output;
}

add_shortcode('et_lb_simple_slider', 'et_new_lb_simple_slider');
function et_new_lb_simple_slider($atts, $content = null) {
	global $et_lb_simple_slides;
	
	$et_lb_simple_slides = 0;
	$attributes = et_lb_get_attributes( $atts, "et_lb_simple_slider" );

	$output =  "<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_simple_slider_nav'>
						<a href='#' class='et_lb_simple_slider_prev'>Previous</a>
						<a href='#' class='et_lb_simple_slider_next'>Next</a>
					</div>
					<div class='et_lb_simple_slider_content'>	
						<div class='et_lb_module_content'>
							<div class='et_lb_module_content_inner clearfix'>"
								. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"			</div> <!-- end .et_lb_module_content_inner -->
						</div> <!-- end .et_lb_module_content -->
					</div> <!-- end .et_lb_simple_slider_content -->
				</div> <!-- end .et_lb_simple_slider -->";

	et_new_load_convertible_scripts( array( 'custom' ) );
				
	return $output;
}

add_shortcode('et_lb_simple_slide', 'et_new_lb_simple_slide');
function et_new_lb_simple_slide($atts, $content = null) {
	global $et_lb_simple_slides;
	++$et_lb_simple_slides;
	
	$output = 	"<div class='clearfix et_lb_simple_slide" . ( 1 != $et_lb_simple_slides ? " et_lb_slide_hidden" : ' et_lb_simple_slide_active' ) . "'>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_simple_slide -->";

	return $output;
}

add_shortcode('et_lb_pricing_table', 'et_new_lb_pricing_table');
function et_new_lb_pricing_table($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
				'price' => '',
				'old_price' => '',
				'button_text' => '',
				'button_url' => '#',
				'button_color' => 'blue'
			), $atts));

	$attributes = et_lb_get_attributes( $atts, "et_lb_pricing_table" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content'>
						<div class='et_lb_module_content_inner clearfix'>
							<h3 class='et_lb_pricing_title'>{$heading}</h3>
							<div class='et_lb_pricing_content'>"
								. do_shortcode( et_lb_fix_shortcodes($content) ) .
								( '' != $old_price ? "<span class='et_lb_old_price'>{$old_price}</span>" : '' ) .
								( '' != $price ? "<span class='et_lb_price'>{$price}</span>" : '' )  .
					"		</div> <!-- end .et_lb_pricing_content -->
						</div> <!-- end .et_lb_module_content_inner -->"
						. ( '' != $button_text ? do_shortcode( "[et_lb_button size='medium' align='center' url='" . esc_url( $button_url ) . "' color='{$button_color}']{$button_text}[/et_lb_button]" ) : '' ) .
					"</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_button -->";

	return $output;
}

add_shortcode('et_lb_box', 'et_new_lb_box');
function et_new_lb_box($atts, $content = null) {
	extract(shortcode_atts(array(
				'heading' => '',
				'color' => 'blue'
			), $atts));
			
	$attributes = et_lb_get_attributes( $atts, "et_lb_box et_lb_box_{$color}" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content clearfix'>"
						. ( '' != $heading ? "<h3 class='et_lb_box_title'>{$heading}</h3>" : '' )
						. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"	</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_box -->";

	return $output;
}

function et_new_lb_column( $atts, $content = null, $name = '' ){
	$attributes = et_lb_get_attributes( $atts, "et_lb_column {$name}" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_column_{$name} -->";

	return $output;
}

// dialog box columns
function et_new_lb_alt_column( $atts, $content = null, $name = '' ){
	$name = str_replace( 'alt_', '', $name );
	$attributes = et_lb_get_attributes( $atts, "et_lb_column {$name}" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_column_{$name} -->";

	return $output;
}

add_shortcode('et_lb_text_block', 'et_new_lb_text_block');
function et_new_lb_text_block($atts, $content = null) {
	$attributes = et_lb_get_attributes( $atts, "et_lb_text_block" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( et_lb_fix_shortcodes($content) ) .
				"</div> <!-- end .et_lb_text_block -->";

	return $output;
}

add_shortcode('et_lb_widget_area', 'et_new_lb_widget_area');
function et_new_lb_widget_area($atts, $content = null) {
	extract(shortcode_atts(array(
				'area' => 'Layout Builder Widget Area 1'
			), $atts));
			
	$attributes = et_lb_get_attributes( $atts, "et_lb_widget_area" );
	
	ob_start();
	dynamic_sidebar($area);
	$widgets = ob_get_contents();
	ob_end_clean();
	
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. $widgets .
				"</div> <!-- end .et_lb_widget_area -->";

	return $output;
}

add_shortcode('et_lb_image','et_new_lb_image');
function et_new_lb_image($atts, $content = null) {
	extract(shortcode_atts(array(
				'image_url' => '',
				'imagesize' => '',
				'image_title' => ''
			), $atts));
			
	$attributes = et_lb_get_attributes( $atts, "et_lb_image" );
	
	if ( '' != $imagesize ){
		$image_size = explode( 'x', $imagesize );
		$image_size = array_map('intval', $image_size);
	}
	
	$image = ( '' != $image_url && '' == $imagesize ) ? $image_url : et_new_thumb_resize( et_multisite_thumbnail( $image_url ), $image_size[0], $image_size[1], '', true );
	if ( '' != $image ) $image = "<img alt='' src='" . esc_url( $image ) . "' title='' />";
	
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>
					<div class='et_lb_module_content'>
						<div class='et_lb_module_content_inner clearfix'>"
							. ( '' != $image ? '<div class="et_lb_image_box">' . "<a href='" . esc_url($image_url) . "' class='fancybox' title='" . esc_attr( $image_title ) . "'>{$image}<span class='et_lb_zoom_icon'></span></a>" . '</div>' : '' )
							. ( '' != trim($content) ? '<div class="et_lb_image_content">' . do_shortcode( et_lb_fix_shortcodes($content) ) . '</div> <!-- end .et_lb_image_content -->' : '' ) .
				"		</div> <!-- end .et_lb_module_content_inner -->
					</div> <!-- end .et_lb_module_content -->
				</div> <!-- end .et_lb_widget_area -->";

	et_new_load_convertible_scripts( array( 'image' ) );
				
	return $output;
}
	

add_action( 'after_setup_theme', 'et_lb_setup_theme' );
	if ( ! function_exists( 'et_lb_setup_theme' ) ){
		function et_lb_setup_theme(){
			remove_action( 'admin_init', 'et_theme_check_clean_installation' );
			
			add_action( 'et_lb_hidden_editor', 'et_advanced_buttons' );
			
			add_action( 'add_meta_boxes', 'et_lb_add_custom_box' );
		}
	}

	function et_new_load_convertible_scripts( $scripts_to_load ){
		if ( in_array( 'slider', $scripts_to_load ) ){
			wp_enqueue_script('flexslider', ET_LB_PLUGIN_URI . '/js/jquery.flexslider-min.js', array('jquery'), '1.0', false);
			wp_enqueue_style('flexslider', ET_LB_PLUGIN_URI . '/css/flexslider.css');
		}
		if ( in_array( 'video', $scripts_to_load ) )
			wp_enqueue_script('fitvids', ET_LB_PLUGIN_URI . '/js/jquery.fitvids.js', array('jquery'), '1.0', true);
		
		if ( in_array( 'image', $scripts_to_load ) ) {
			wp_enqueue_script('easing', ET_LB_PLUGIN_URI . '/js/jquery.easing.1.3.js', array('jquery'), '1.0', true);
			wp_enqueue_script('fancybox', ET_LB_PLUGIN_URI . '/js/jquery.fancybox-1.3.4.pack.js', array('jquery'), '1.0', true);
			wp_enqueue_style('fancybox', ET_LB_PLUGIN_URI . '/css/jquery.fancybox-1.3.4.css');
		} else { 
			wp_enqueue_script('et_lb_custom', ET_LB_PLUGIN_URI . '/js/custom.js', array('jquery'), '1.0', true);
		}
	}

	function et_lb_new_settings_page_css(){
		wp_enqueue_style( 'et_lb_admin_css', ET_LB_PLUGIN_URI . '/css/et_lb_admin.css' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_style( 'thickbox' );
	}

	function et_lb_new_settings_page_js(){	
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_script( 'jquery-ui-resizable' );
		
		wp_enqueue_script( 'et_lb_admin_js', ET_LB_PLUGIN_URI . '/js/et_lb_admin.js', array('jquery','jquery-ui-core','jquery-ui-sortable','jquery-ui-draggable','jquery-ui-droppable','jquery-ui-resizable'), '1.0' );
		wp_localize_script( 'et_lb_admin_js', 'et_lb_options', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'et_load_nonce' => wp_create_nonce( 'et_load_nonce' ), 'confirm_message' => __('Permanently delete this module?', 'Convertible'), 'confirm_message_yes' => __('Yes', 'Convertible'), 'confirm_message_no' => __('No', 'Convertible'), 'saving_text' => __('Saving...', 'Convertible'), 'saved_text' => __('Layout Saved.', 'Convertible') ) );
	}

	add_action('init','et_lb_new_modules_init');
	function et_lb_new_modules_init(){
		global $et_lb_modules, $et_lb_columns, $et_lb_sample_layouts;
		
		$et_lb_widget_areas = apply_filters( 'et_lb_widget_areas', array( __('Layout Builder Widget Area 1', 'Convertible'), __('Layout Builder Widget Area 2', 'Convertible'), __('Layout Builder Widget Area 3', 'Convertible'), __('Layout Builder Widget Area 4', 'Convertible'), __('Layout Builder Widget Area 5', 'Convertible') ) );
		
		$et_lb_modules['logo'] = array(
			'name' => __('Logo', 'Convertible'),
			'options' => array(
				'logo_url' => array(
					'title' => __('Logo Image URL', 'Convertible'),
					'type' => 'upload',
					'is_content' => true
				),
				'align' => array(
					'title' => __('Select the logo placement', 'Convertible'),
					'type' => 'select',
					'options' => array( __('left', 'Convertible'), __('center', 'Convertible'), __('right', 'Convertible') ),
					'std' => __('center', 'Convertible')
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)
		);
		
		$et_lb_modules['paper'] = array(
			'name' => __('Paper', 'Convertible'),
			'options' => array(
				'text' => array(
					'title' => __('Add a paper text', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)		
		);
		
		$et_lb_modules['video'] = array(
			'name' => __('Video', 'Convertible'),
			'options' => array(
				'video_url' => array(
					'title' => __('Video URL', 'Convertible'),
					'type' => 'text'
				),
				'text' => array(
					'title' => __('Add module text', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)		
		);
		
		$et_lb_modules['testimonial'] = array(
			'name' => __('Testimonial', 'Convertible'),
			'options' => array(
				'image_url' => array(
					'title' => __('Image URL', 'Convertible'),
					'type' => 'upload'
				),
				'author_name' => array(
					'title' => __('Author Name', 'Convertible'),
					'type' => 'text'
				),
				'author_position' => array(
					'title' => __('Company\'s Position', 'Convertible'),
					'type' => 'text'
				),
				'author_site' => array(
					'title' => __('Author Site URL', 'Convertible'),
					'type' => 'text'
				),
				'testimonial_content' => array(
					'title' => __('Testimonial text', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)		
		);
		
		$et_lb_modules['slogan'] = array(
			'name' => __('Slogan', 'Convertible'),
			'options' => array(
				'slogan_content' => array(
					'title' => __('Slogan text', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)		
		);
		
		$et_lb_modules['slider'] = array(
			'name' => __('Image Slider', 'Convertible'),
			'options' => array(
				'imagesize' => array(
					'title' => __('Image Size (e.g. 300x200)', 'Convertible'),
					'type' => 'text'
				),
				'animation' => array(
					'title' => __('Animation Effect', 'Convertible'),
					'type' => 'select',
					'options' => array( __('fade', 'Convertible'), __('slide', 'Convertible') ),
					'std' => __('fade', 'Convertible')
				),
				'animation_duration' => array(
					'title' => __('Animation Duration (in ms)', 'Convertible'),
					'type' => 'text',
					'std' => '600'
				),
				'auto_animation' => array(
					'title' => __('Auto Animation', 'Convertible'),
					'type' => 'select',
					'options' => array( __('off', 'Convertible'), __('on', 'Convertible') ),
					'std' => __('off', 'Convertible')
				),
				'auto_speed' => array(
					'title' => __('Auto Animation Speed (in ms)', 'Convertible'),
					'type' => 'text',
					'std' => '7000'
				),
				'pause_on_hover' => array(
					'title' => __('Pause Slider On Hover', 'Convertible'),
					'type' => 'select',
					'options' => array( __('off', 'Convertible'), __('on', 'Convertible') ),
					'std' => __('off', 'Convertible')
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				),
				'images' => array(
					'type' => 'slider_images'
				)
			)
		);
		
		$et_lb_modules['button'] = array(
			'name' => __('Button', 'Convertible'),
			'options' => array(
				'color' => array(
					'title' => __('Color', 'Convertible'),
					'type' => 'select',
					'options' => array( __('blue', 'Convertible'), __('green', 'Convertible'), __('red', 'Convertible'), __('purple', 'Convertible'), __('yellow', 'Convertible'), __('black', 'Convertible') ),
					'std' => __('blue', 'Convertible')
				),
				'size' => array(
					'title' => __('Size', 'Convertible'),
					'type' => 'select',
					'options' => array( __('small', 'Convertible'), __('medium', 'Convertible'), __('large', 'Convertible') ),
					'std' => __('small', 'Convertible')
				),
				'url' => array(
					'title' => __('URL', 'Convertible'),
					'type' => 'text'
				),
				'window' => array(
					'title' => __('Open link in the new window?', 'Convertible'),
					'type' => 'select',
					'options' => array( __('off', 'Convertible'), __('on', 'Convertible') ),
					'std' => __('off', 'Convertible')
				),
				'text' => array(
					'title' => __('Text', 'Convertible'),
					'type' => 'text',
					'is_content' => true
				),
				'align' => array(
					'title' => __('Button alignment', 'Convertible'),
					'type' => 'select',
					'options' => array( __('left', 'Convertible'), __('center', 'Convertible'), __('right', 'Convertible') ),
					'std' => __('left', 'Convertible')
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)
		);
		
		$et_lb_modules['bar'] = array(
			'name' => __('Horizontal Bar', 'Convertible'),
			'options' => array(
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			),
			'full_width' => true
		);
		
		$et_lb_modules['list'] = array(
			'name' => __('List', 'Convertible'),
			'options' => array(
				'type' => array(
					'title' => __('Type', 'Convertible'),
					'type' => 'select',
					'options' => array( __('arrow', 'Convertible'), __('checkmark', 'Convertible'), 'x' ),
					'std' => __('checkmark', 'Convertible')
				),
				'et_list_content' => array(
					'title' => __('Content', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)
		);
		
		$et_lb_modules['toggle'] = array(
			'name' => __('Toggle', 'Convertible'),
			'options' => array(
				'heading' => array(
					'title' => __('Title', 'Convertible'),
					'type' => 'text'
				),
				'et_toggle_content' => array(
					'title' => __('Content', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'state' => array(
					'title' => __('Default State', 'Convertible'),
					'type' => 'select',
					'options' => array( __('close', 'Convertible'), __('open', 'Convertible') ),
					'std' => __('close', 'Convertible')
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)
		);
		
		$et_lb_modules['tabs'] = array(
			'name' => __('Tabs', 'Convertible'),
			'options' => array(
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				),
				'tabs' => array(
					'type' => 'tabs_interface'
				)
			)
		);
		
		$et_lb_modules['simple_slider'] = array(
			'name' => __('Simple Slider', 'Convertible'),
			'options' => array(
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				),
				'tabs' => array(
					'type' => 'slider_interface'
				)
			)
		);
		
		$et_lb_modules['pricing_table'] = array(
			'name' => __('Pricing Table', 'Convertible'),
			'options' => array(
				'heading' => array(
					'title' => __('Title', 'Convertible'),
					'type' => 'text'
				),
				'et_pricing_table' => array(
					'title' => __('Content', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'price' => array(
					'title' => __('Price', 'Convertible'),
					'type' => 'text'
				),
				'old_price' => array(
					'title' => __('Old Price', 'Convertible'),
					'type' => 'text'
				),
				'button_text' => array(
					'title' => __('Button Text', 'Convertible'),
					'type' => 'text'
				),
				'button_url' => array(
					'title' => __('Button URL', 'Convertible'),
					'type' => 'text'
				),
				'button_color' => array(
					'title' => __('Button Color', 'Convertible'),
					'type' => 'select',
					'options' => array( __('blue', 'Convertible'), __('green', 'Convertible'), __('red', 'Convertible'), __('purple', 'Convertible'), __('yellow', 'Convertible'), __('black', 'Convertible') ),
					'std' => __('blue', 'Convertible')
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)
		);
		
		$et_lb_modules['box'] = array(
			'name' => __('Box', 'Convertible'),
			'options' => array(
				'heading' => array(
					'title' => __('Title', 'Convertible'),
					'type' => 'text'
				),
				'color' => array(
					'title' => __('Button Color', 'Convertible'),
					'type' => 'select',
					'options' => array( __('blue', 'Convertible'), __('green', 'Convertible'), __('red', 'Convertible') ),
					'std' => __('blue', 'Convertible')
				),
				'et_box_content' => array(
					'title' => __('Content', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)
		);
		
		$et_lb_modules['text_block'] = array(
			'name' => __('Text Block', 'Convertible'),
			'options' => array(
				'et_text_block_content' => array(
					'title' => __('Content', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)
		);
		
		$et_lb_modules['widget_area'] = array(
			'name' => __('Widget Area', 'Convertible'),
			'options' => array(
				'area' => array(
					'title' => __('Widget Area', 'Convertible'),
					'type' => 'select',
					'options' => $et_lb_widget_areas,
					'std' => __('Layout Builder Widget Area 1', 'Convertible')
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)
		);
		
		$et_lb_modules['image'] = array(
			'name' => __('Image', 'Convertible'),
			'options' => array(
				'image_url' => array(
					'title' => __('Image URL', 'Convertible'),
					'type' => 'upload'
				),
				'imagesize' => array(
					'title' => __('Image Size (e.g. 300x200)', 'Convertible'),
					'type' => 'text'
				),
				'image_title' => array(
					'title' => __('Image Title', 'Convertible'),
					'type' => 'text'
				),
				'caption' => array(
					'title' => __('Caption', 'Convertible'),
					'type' => 'wp_editor',
					'is_content' => true
				),
				'css_class' => array(
					'title' => __('Additional css class', 'Convertible'),
					'type' => 'text'
				)
			)
		);
		
		$et_lb_modules = apply_filters( 'et_lb_modules', $et_lb_modules );
		
		$et_lb_columns['1_2'] = array( 'name' => __('1/2 Column', 'Convertible') );
		$et_lb_columns['1_3'] = array( 'name' => __('1/3 Column', 'Convertible') );
		$et_lb_columns['1_4'] = array( 'name' => __('1/4 Column', 'Convertible') );
		$et_lb_columns['2_3'] = array( 'name' => __('2/3 Column', 'Convertible') );
		$et_lb_columns['3_4'] = array( 'name' => __('3/4 Column', 'Convertible') );
		$et_lb_columns['resizable'] = array( 'name' => __('Resizable Column', 'Convertible') );
		
		$et_lb_columns = apply_filters( 'et_lb_columns', $et_lb_columns );
		
		require_once(ET_LB_PLUGIN_DIR . '/includes/et_lb_sample_layouts.php');
		$et_lb_sample_layouts = apply_filters( 'et_lb_sample_layouts', $et_lb_sample_layouts );
		
		foreach( $et_lb_columns as $et_lb_column_key => $et_lb_column ){
			add_shortcode("et_lb_{$et_lb_column_key}", 'et_new_lb_column');
			add_shortcode("et_lb_alt_{$et_lb_column_key}", 'et_new_lb_alt_column');
		}
		
		$i = 0;
		foreach ( $et_lb_widget_areas as $et_lb_widget_area ){
			++$i;
			
			register_sidebar( array(
				'name' => $et_lb_widget_area,
				'before_widget' => '<div id="%1$s" class="et_lb_widget %2$s">',
				'after_widget' => "</div>",
				'before_title' => '<h3 class="et_lb_widget-title">',
				'after_title' => '</h3>',
			) );
		}
	}

	function et_lb_new_build_settings_page(){
		global $et_lb_modules, $et_lb_columns, $et_lb_sample_layouts, $post;
		$et_helper_class = '';
		$et_convertible_settings = get_post_meta( $post->ID, '_et_builder_settings', true );
	?>
		<?php do_action( 'et_before_page_builder' ); ?>
		
		<div id="et_page_builder">
			<div id="et_builder_controls" class="clearfix">
				<a href="#" class="et_add_element et_add_module"><span><?php esc_html_e('Add a Module', 'Convertible'); ?></span></a>
				<a href="#" class="et_add_element et_add_column"><span><?php esc_html_e('Add a Column', 'Convertible'); ?></span></a>
				<a href="#" class="et_add_element et_add_sample_layout"><span><?php esc_html_e('Sample Layout', 'Convertible'); ?></span></a>
				<span id="heading_title"><?php esc_html_e('Page Builder', 'Convertible'); ?></span>
			</div> <!-- #et_builder_controls -->
			
			<div id="et_modules">
				<?php
					foreach ( $et_lb_modules as $module_key => $module_settings ){
						$class = "et_module et_m_{$module_key}";
						if ( isset( $module_settings['full_width'] ) && $module_settings['full_width'] ) $class .= ' et_full_width';
						
						echo "<div data-placeholder='" . esc_attr( $module_settings['name'] ) . "' data-name='" . esc_attr( $module_key ) . "' class='" . esc_attr( $class ) . "'>" . '<span class="et_module_name">' . esc_html( $module_settings['name'] ) . '</span>' .
						'<span class="et_move"></span><span class="et_delete"></span><span class="et_settings_arrow"></span><div class="et_module_settings"></div></div>';
					}
					
					foreach ( $et_lb_columns as $column_key => $column_settings ){
						echo "<div data-placeholder='" . esc_attr( $column_settings['name'] ) . "' data-name='" . esc_attr( $column_key ) . "' class='" . esc_attr( "et_module et_m_column et_m_column_{$column_key}" ) . "'>" . 
						'<span class="et_module_name et_column_name">' . esc_html( $column_settings['name'] ) . '</span>' .
						'<span class="et_move"></span> <span class="et_delete_column"></span></div>';
					}
					
					foreach ( $et_lb_sample_layouts as $layout_key => $layout_settings ){
						echo "<div data-placeholder='" . esc_attr( $layout_settings['name'] ) . "' data-name='" . esc_attr( $layout_key ) . "' class='" . esc_attr( "et_module et_sample_layout" ) . "'>" . 
						'<span class="et_module_name">' . esc_html( $layout_settings['name'] ) . '</span>' .
						'<span class="et_move"></span></div>';
					}
				?>
				<div id="et_module_separator"></div>
				<div id="active_module_settings"></div>
			</div> <!-- #et_modules -->
			
			<div id="et_layout_container">
				<div id="et_layout" class="clearfix">
					<?php 
						if ( is_array( $et_convertible_settings ) && $et_convertible_settings['layout_html'] ) {
							echo stripslashes( $et_convertible_settings['layout_html'] );
							$et_helper_class = ' class="hidden"';
						}
					?>
				</div> <!-- #et_layout -->
				<div id="et_lb_helper"<?php echo $et_helper_class; ?>><?php esc_html_e('Drag a Module Onto Your Canvas', 'Convertible'); ?></div>
			</div> <!-- #et_layout_container -->
			
			<div style="display: none;">
				<?php
					wp_editor( ' ', 'et_lb_hidden_editor' );
					do_action( 'et_lb_hidden_editor' );
				?>
			</div>
		</div> <!-- #et_page_builder -->
		
		<div id="et_lb_ajax_save">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/epanel/images/saver.gif' ); ?>" alt="loading" id="loading" />
			<span><?php esc_html_e( 'Saving...', 'Convertible' ); ?></span>
		</div>
		
		<?php
			echo '<div id="et_lb_save">';
			submit_button( __('Save Changes', 'Convertible'), 'primary', 'et_lb_main_save' );
			echo '</div> <!-- end #et_lb_save -->';
	}

	add_action( 'wp_ajax_et_save_layout', 'et_new_save_layout' );
	function et_new_save_layout(){
		if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);
		
		$et_convertible_settings = array();
		
		$et_convertible_settings['layout_html'] = trim( $_POST['et_layout_html'] );
		$et_convertible_settings['layout_shortcode'] = $_POST['et_layout_shortcode'];
		$et_post_id = (int) $_POST['et_post_id'];
		
		if ( get_post_meta( $et_post_id, '_et_builder_settings', true ) ) update_post_meta( $et_post_id, '_et_builder_settings', $et_convertible_settings );
		else add_post_meta( $et_post_id, '_et_builder_settings', $et_convertible_settings, true );
		
		die();
	}

	add_action( 'wp_ajax_et_append_layout', 'et_new_append_layout' );
	function et_new_append_layout(){
		global $et_lb_sample_layouts;
		
		if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);
		
		$layout_name = $_POST['et_layout_name'];
		if ( isset( $et_lb_sample_layouts[$layout_name] ) ) echo stripslashes( $et_lb_sample_layouts[$layout_name]['content'] );
		
		die();
	}

	add_action( 'wp_ajax_et_show_module_options', 'et_new_show_module_options' );
	function et_new_show_module_options(){
		if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);
		
		$module_class = $_POST['et_module_class'];
		$et_module_exact_name = $_POST['et_module_exact_name'];
		$module_window = (int) $_POST['et_modal_window'];
		
		preg_match( '/et_m_([^\s])+/', $module_class, $matches );
		$module_name = str_replace( 'et_m_', '', $matches[0] );
		
		$paste_to_editor_id = isset( $_POST['et_paste_to_editor_id'] ) ? $_POST['et_paste_to_editor_id'] : '';
		
		et_generate_module_options( $module_name, $module_window, $paste_to_editor_id, $et_module_exact_name );
		
		die();
	}

	add_action( 'wp_ajax_et_show_column_options', 'et_new_show_column_options' );
	function et_new_show_column_options(){
		if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);
		
		$module_class = $_POST['et_module_class'];
		
		preg_match( '/et_m_column_([^\s])+/', $module_class, $matches );
		$module_name = str_replace( 'et_m_column_', '', $matches[0] );
		
		$paste_to_editor_id = isset( $_POST['et_paste_to_editor_id'] ) ? $_POST['et_paste_to_editor_id'] : '';
		
		et_generate_column_options( $module_name, $paste_to_editor_id );
		
		die();
	}

	add_action( 'wp_ajax_et_add_slider_item', 'et_new_add_slider_item' );
	function et_new_add_slider_item(){
		if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);
		
		$attachment_class = $_POST['et_attachment_class'];
		$et_change_image = (bool) $_POST['et_change_image'];

		preg_match( '/wp-image-([\d])+/', $attachment_class, $matches );
		$attachment_id = str_replace( 'wp-image-', '', $matches[0] );
		$attachment_image = wp_get_attachment_image( $attachment_id );
		
		if ( $et_change_image ) {
			echo json_encode( array( 'attachment_image' => $attachment_image, 'attachment_id' => $attachment_id ) );
		} else {
			echo '<div class="et_attachment clearfix" data-attachment="' . esc_attr( $attachment_id ) .'">' 
					. $attachment_image
					. '<div class="et_attachment_options">'
						. '<p class="clearfix">' . '<label>' . esc_html__('Description', 'Convertible') . ': </label>' . '<textarea name="attachment_description[]" class="attachment_description"></textarea> </p>'
						. '<p class="clearfix">' . '<label>' . esc_html__('Link', 'Convertible') . ': </label>'. '<input name="attachment_link[]" class="attachment_link" /> </p>'
					. '</div> <!-- .et_attachment_options -->'
					. '<a href="#" class="et_delete_attachment">' . esc_html__('Delete this slide', 'Convertible') . '</a>'
					. '<a href="#" class="et_change_attachment_image">' . esc_html__('Change image', 'Convertible') . '</a>'
				. '</div>';
		}
		
		die();
	}

	add_action( 'wp_ajax_et_convert_div_to_editor', 'et_new_convert_div_to_editor' );
	function et_new_convert_div_to_editor(){
		if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);
		
		$index = (int) $_POST['et_index'];
		$option_slug = 'et_tab_text_' . $index;
		
		wp_editor( '', $option_slug, array( 'editor_class' => 'et_lb_wp_editor' ) );
		
		die();
	}

	add_action( 'wp_ajax_et_add_tabs_item', 'et_new_add_tab_item' );
	function et_new_add_tab_item(){
		if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);
		
		$et_tabs_length = (int) $_POST['et_tabs_length'];
		$option_slug = 'et_tab_text_' . $et_tabs_length;
		
		echo '<div class="et_lb_tab">' 
				. '<p class="clearfix">' . '<label>' . esc_html__('Tab Title', 'Convertible') . ': </label>' . '<input name="et_lb_tab_title[]" class="et_lb_tab_title" /> </p>';
				wp_editor( '', $option_slug, array( 'editor_class' => 'et_lb_wp_editor' ) );
		echo 	'<a href="#" class="et_lb_delete_tab">' . esc_html__('Delete this tab', 'Convertible') . '</a>'
		. '</div>';
		
		die();
	}

	add_action( 'wp_ajax_et_add_slides_item', 'et_new_add_slide_item' );
	function et_new_add_slide_item(){
		if ( ! wp_verify_nonce( $_POST['et_load_nonce'], 'et_load_nonce' ) ) die(-1);
		
		$et_tabs_length = (int) $_POST['et_tabs_length'];
		$option_slug = 'et_slide_text_' . $et_tabs_length;
		
		echo '<div class="et_lb_tab">';
				wp_editor( '', $option_slug, array( 'editor_class' => 'et_lb_wp_editor' ) );
		echo 	'<a href="#" class="et_lb_delete_tab">' . esc_html__('Delete this tab', 'Convertible') . '</a>'
		. '</div>';
		
		die();
	}

	if ( ! function_exists('et_generate_column_options') ){
		function et_generate_column_options( $column_name, $paste_to_editor_id ){
			global $et_lb_columns;
			
			$module_name = $et_lb_columns[$column_name]['name'];
			echo '<form id="et_dialog_settings">'
					. '<span id="et_settings_title">' . esc_html( ucfirst( $module_name ) . ' ' . __('Settings', 'Convertible') ) . '</span>'
					. '<a href="#" id="et_close_dialog_settings"></a>'
					. '<p class="clearfix"><input type="checkbox" id="et_dialog_first_class" name="et_dialog_first_class" value="" class="et_lb_option" /> ' . esc_html__('This is the first column in the row', 'Convertible') . '</p>';
			
			if ( 'resizable' == $column_name ) echo '<p class="clearfix"><label>' . esc_html__('Column width (%)', 'Convertible') . ':</label> <input name="et_dialog_width" type="text" id="et_dialog_width" value="100" class="regular-text et_lb_option" /></p>';
			
			submit_button();
			
			echo '<input type="hidden" id="et_saved_module_name" value="' . esc_attr( "alt_{$column_name}" ) . '" />';
			
			if ( '' != $paste_to_editor_id ) echo '<input type="hidden" id="et_paste_to_editor_id" value="' . esc_attr( $paste_to_editor_id ) . '" />';
			
			echo '</form>';
		}
	}

	if ( ! function_exists('et_generate_module_options') ){
		function et_generate_module_options( $module_name, $module_window, $paste_to_editor_id, $et_module_exact_name ){
			global $et_lb_modules;
			
			$i = 1;
			$form_id = ( 0 == $module_window ) ? 'et_module_settings' : 'et_dialog_settings';
			
			echo '<form id="' . esc_attr( $form_id ) . '">';
			echo '<span id="et_settings_title">' . esc_html( $et_module_exact_name . ' ' . __('Settings', 'Convertible') ) . '</span>';
			
			if ( 0 == $module_window ) echo '<a href="#" id="et_close_module_settings"></a>';
			else echo '<a href="#" id="et_close_dialog_settings"></a>';
			
			foreach ( $et_lb_modules[$module_name]['options'] as $option_slug => $option_settings ){
				$content_class = isset( $option_settings['is_content'] ) && $option_settings['is_content'] ? ' et_lb_module_content' : '';
				
				echo '<p class="clearfix">';
				if ( isset( $option_settings['title'] ) ) echo "<label><span class='et_module_option_number'>{$i}</span>. {$option_settings['title']}</label>";
				
				if ( 1 == $module_window ) $option_slug = 'et_dialog_' . $option_slug;
				
				switch ( $option_settings['type'] ) {
					case 'wp_editor':
						wp_editor( '', $option_slug, array( 'editor_class' => 'et_lb_wp_editor et_lb_option' . $content_class ) );
						break;
					case 'select':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo
						'<select name="' . esc_attr( $option_slug ) . '" id="' . esc_attr( $option_slug ) . '" class="et_lb_option' . $content_class . '">'
							. ( ( '' == $std ) ? '<option value="nothing_selected">  ' . esc_html__('Select', 'Convertible') . '  </option>' : '' );
							foreach ( $option_settings['options'] as $setting_value ){
								echo '<option value="' . esc_attr( $setting_value ) . '"' . selected( $setting_value, $std, false ) . '>' . esc_html( $setting_value ) . '</option>';
							}
						echo '</select>';
						break;
					case 'text':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo '<input name="' . esc_attr( $option_slug ) . '" type="text" id="' . esc_attr( $option_slug ) . '" value="'.( '' != $std ? esc_attr( $std ) : '' ).'" class="regular-text et_lb_option' . $content_class . '" />';
						break;
					case 'upload':
						echo '<input name="' . esc_attr( $option_slug ) . '" type="text" id="' . esc_attr( $option_slug ) . '" value="" class="regular-text et_lb_option et_lb_upload_field' . $content_class . '" />' . '<a href="#" class="et_lb_upload_button">' . esc_html__('Upload', 'Convertible') . '</a>';
						break;
					case 'slider_images':
						echo '<div id="et_slider_images">' . '<div id="et_slides" class="et_lb_option"></div>' . '<a href="#" id="et_add_slider_images">' . esc_html__('Add Slider Image', 'Convertible') . '</a>' . '</div>';
						break;
					case 'tabs_interface':
						echo '<div id="et_tabs_interface">' . '<div id="et_lb_tabs" class="et_lb_option" data-elements="0"></div>' . '<a href="#" id="et_lb_add_tab">' . esc_html__('Add Tab', 'Convertible') . '</a>' . '</div>';
						break;
					case 'slider_interface':
						echo '<div id="et_slides_interface">' . '<div id="et_lb_tabs" class="et_lb_option" data-elements="0"></div>' . '<a href="#" id="et_lb_add_tab">' . esc_html__('Add Slide', 'Convertible') . '</a>' . '</div>';
						break;
				}
				
				echo '</p>';
				
				++$i;
			}
			
			submit_button();
			
			echo '<input type="hidden" id="et_saved_module_name" value="' . esc_attr( $module_name ) . '" />';
			
			if ( '' != $paste_to_editor_id ) echo '<input type="hidden" id="et_paste_to_editor_id" value="' . esc_attr( $paste_to_editor_id ) . '" />';
			
			echo '</form>';
		}
	}

	if ( ! function_exists('et_lb_get_attributes') ){
		function et_lb_get_attributes( $atts, $additional_classes = '', $additional_styles = '' ){
			extract( shortcode_atts(array(
						'css_class' => '',
						'first_class' => '0',
						'width' => ''
					), $atts));
			$attributes = array( 'class' => '', 'inline_styles' => '' );
			
			if ( '' != $css_class ) $css_class = ' ' . $css_class;
			if ( '' != $additional_classes ) $additional_classes = ' ' . $additional_classes;
			$first_class = ( '1' == $first_class ) ? ' et_lb_first' : '';
			$attributes['class'] = ' class="' . esc_attr( "et_lb_module{$additional_classes}{$first_class}{$css_class}" ) . '"';
			
			if ( '' != $width ) $attributes['inline_styles'] .= " width: {$width}%;";
			$attributes['inline_styles'] .= $additional_styles;
			if ( '' != $attributes['inline_styles'] ) $attributes['inline_styles'] = ' style="' . esc_attr( $attributes['inline_styles'] ) . '"';
			
			return $attributes;
		}
	}

	if ( ! function_exists('et_lb_fix_shortcodes') ){
		function et_lb_fix_shortcodes($content){   
			$replace_tags_from_to = array (
				'<p>[' => '[', 
				']</p>' => ']', 
				']<br />' => ']'
			);

			return strtr( $content, $replace_tags_from_to );
		}
	}
	
add_action( 'et_before_page_builder', 'et_disable_builder_option' );
function et_disable_builder_option(){
	global $post;
	
	$et_builder_disable = get_post_meta( $post->ID, '_et_disable_builder', true );
	
	wp_nonce_field( basename( __FILE__ ), 'et_builder_settings_nonce' );

	echo '<p class="et_builder_option" style="padding: 10px 0 0 6px; margin-bottom: -10px;">'
			. '<label for="et_builder_disable" class="selectit">'
				. '<input name="et_builder_disable" type="checkbox" id="et_builder_disable" ' . checked( $et_builder_disable, 1, false ) . ' /> Disable page builder </label>'
		. '</p>';
}

add_action( 'save_post', 'et_builder_save_details', 10, 2 );
function et_builder_save_details( $post_id, $post ){
	global $pagenow;

	if ( 'post.php' != $pagenow ) return $post_id;
		
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
	if ( ! isset( $_POST['et_builder_settings_nonce'] ) || ! wp_verify_nonce( $_POST['et_builder_settings_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	if ( isset( $_POST['et_builder_disable'] ) )
		update_post_meta( $post_id, '_et_disable_builder', 1 );
	else
		update_post_meta( $post_id, '_et_disable_builder', 0 );
}
 
add_filter( 'the_content', 'et_show_builder_layout' );
function et_show_builder_layout( $content ){
	global $post;
	$builder_layout = get_post_meta( $post->ID, '_et_builder_settings', true );
	$builder_disable = get_post_meta( $post->ID, '_et_disable_builder', true );
	
	if ( ! is_singular() || ! $builder_layout || ! is_main_query() || 1 == $builder_disable ) return $content;
	
	if ( $builder_layout && '' != $builder_layout['layout_shortcode'] ) $content = '<div class="et_builder clearfix">' . do_shortcode( stripslashes( $builder_layout['layout_shortcode'] ) ) . '</div> <!-- .et_builder -->';

	return $content;
} ?>