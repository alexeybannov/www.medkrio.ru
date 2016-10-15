<?php

	/**
	 * Shortcode: heading
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_heading_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'color' => '#284B80',
				'font_size' => '20px'
				), $atts ) );

		return '<div class="su-heading"><div class="su-heading-shell" style="font-size:' . $font_size . '; color:' . $color . ';">' . do_shortcode( $content ) . '</div></div>';
	}
	
	/**
	 * Shortcode: label
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_label_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'title' => 'Caption',
				'color' => '#ffffff',
				'bg' => 'ff9000'
				), $atts ) );

		return '<div class="su-label" style="color:' . $color . '; background-color:' . $bg . ';">'. $title .'</div>';
	}

	/**
	 * Shortcode: frame
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_frame_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'align' => 'none'
				), $atts ) );

		return '<div class="su-frame su-frame-align-' . $align . '"><div class="su-frame-shell">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: tabs
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_tabs_shortcode( $atts, $content ) {
		extract( shortcode_atts( array(
				'style' => 1
				), $atts ) );

		$GLOBALS['tab_count'] = 0;

		do_shortcode( $content );

		if ( is_array( $GLOBALS['tabs'] ) ) {
			foreach ( $GLOBALS['tabs'] as $tab ) {
				$tabs[] = '<span>' . $tab['title'] . '</span>';
				$panes[] = '<div class="su-tabs-pane">' . $tab['content'] . '</div>';
			}
			$return = '<div class="su-tabs su-tabs-style-' . $style . '"><div class="su-tabs-nav">' . implode( '', $tabs ) . '</div><div class="su-tabs-panes">' . implode( "\n", $panes ) . '</div><div class="clear"></div></div>';
		}
		return $return;
	}

	/**
	 * Shortcode: tab
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_tab_shortcode( $atts, $content ) {
		extract( shortcode_atts( array( 'title' => 'Tab %d' ), $atts ) );
		$x = $GLOBALS['tab_count'];
		$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' => do_shortcode( $content ) );
		$GLOBALS['tab_count']++;
	}

	/**
	 * Shortcode: spoiler
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_spoiler_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'title' => __( 'Spoiler title', 'shortcodes-ultimate' ),
				'style' => 0
				), $atts ) );

		return '<div class="su-spoiler su-spoiler-style-' . $style . '"><div class="su-spoiler-title">' . $title . '</div><div class="su-spoiler-content">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: divider
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_divider_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'top' => false,
				'style' => 'solid'
				), $atts ) );

		return ( $top ) ? '<div class="su-divider-' . $style . '"><a href="#top">' . __( 'Top', 'shortcodes-ultimate' ) . '</a></div>' : '<div class="su-divider-' . $style . '"></div>';
	}
	
	/**
	 * Shortcode: divider with title
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_textdivider_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'text' => 'Divider title',
				'color' => '#AAA9A9',
				'line' => '#E0E0E0'
				
				), $atts ) );

		return '<div class="su-divider-text" style="border-color:' . $line . ';"><span class="su-divider-text-title" style="color:' . $color . ';">' . $text . '</span></div>';
	}

	/**
	 * Shortcode: spacer
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_spacer_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'size' => 0
				), $atts ) );

		return '<div class="su-spacer" style="height:' . $size . 'px"></div>';
	}

	/**
	 * Shortcode: highlight
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_highlight_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'bg' => '#fff287',
				'color' => '#000'
				), $atts ) );

		return '<span class="su-highlight" style="background:' . $bg . ';color:' . $color . '">&nbsp;' . $content . '&nbsp;</span>';
	}

	/**
	 * Shortcode: column
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_column_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'size' => '1-2',
				'last' => false,
				'style' => 0
				), $atts ) );

		return ( $last ) ? '<div class="su-column su-column-' . $size . ' su-column-last su-column-style-' . $style . '">' . do_shortcode( $content ) . '</div><div class="clear"></div>' : '<div class="su-column su-column-' . $size . ' su-column-style-' . $style . '">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * Shortcode: list
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_list_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'style' => 'star'
				), $atts ) );

		return '<div class="su-list su-list-style-' . $style . '">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * Shortcode: quote
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_quote_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'style' => 1
				), $atts ) );

		return '<div class="su-quote su-quote-style-' . $style . '"><div class="su-quote-shell">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: pullquote
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_pullquote_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'style' => 1,
				'align' => 'left'
				), $atts ) );

		return '<div class="su-pullquote su-pullquote-style-' . $style . ' su-pullquote-align-' . $align . '">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * Shortcode: button
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_button_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'link' => '#',
				'color' => '#aaa',
				'dark' => false,
				'square' => false,
				'style' => 1,
				'size' => 3,
				'icon' => false,
				'class' => 'su-button-class',
				'target' => false
				), $atts ) );

		$styles = array(
			'border_radius' => ( $square ) ? 0 : round( $size + 2 ),
			'dark_color' => su_hex_shift( $color, 'darker', 20 ),
			'light_color' => su_hex_shift( $color, 'lighter', 50 ),
			'size' => round( ( $size + 9 ) * 1.1 ),
			'text_color' => ( $dark ) ? su_hex_shift( $color, 'darker', 40 ) : su_hex_shift( $color, 'lighter', 90 ),
			'text_shadow' => ( $dark ) ? su_hex_shift( $color, 'lighter', 50 ) : su_hex_shift( $color, 'darker', 10 ),
			'text_shadow_position' => ( $dark ) ? '1px 1px' : '-1px -1px',
			'padding_v' => round( ( $size * 2 ) + 2 ),
			'padding_v_b' => round( ( $size * 2 ) + 3 ),
			'padding_h' => round( ( ( $size * 3 ) + 10 ) )
		);

		$link_styles = array(
			'background-color' => $color,
			'border' => '1px solid ' . $styles['dark_color'],
			'border-radius' => $styles['border_radius'] . 'px',
			'-moz-border-radius' => $styles['border_radius'] . 'px',
			'-webkit-border-radius' => $styles['border_radius'] . 'px'
		);

		$span_styles = array(
			'color' => $styles['text_color'],
			'padding' => $styles['padding_v'] . 'px ' . $styles['padding_h'] . 'px ' . $styles['padding_v_b'] . 'px' ,
			'font-size' => $styles['size'] . 'px',
			'height' => $styles['size'] . 'px',
			'line-height' => $styles['size'] . 'px',
			'border-top' => '1px solid ' . $styles['light_color'],
			'border-radius' => $styles['border_radius'] . 'px',
			'text-shadow' => $styles['text_shadow_position'] . ' 0 ' . $styles['text_shadow'],
			'-moz-border-radius' => $styles['border_radius'] . 'px',
			'-moz-text-shadow' => $styles['text_shadow_position'] . ' 0 ' . $styles['text_shadow'],
			'-webkit-border-radius' => $styles['border_radius'] . 'px',
			'-webkit-text-shadow' => $styles['text_shadow_position'] . ' 0 ' . $styles['text_shadow']
		);

		$img_styles = array(
			'margin' => '0 ' . round( $size * 0.7 ) . 'px -' . round( ( $size * 0.3 ) + 4 ) . 'px -' . round( $size * 0.8 ) . 'px',
			'height' => ( $styles['size'] + 4 ) . 'px'
		);
$link_style ='';
		foreach ( $link_styles as $link_rule => $link_value ) {
			$link_style .= $link_rule . ':' . $link_value . ';';
		}
$span_style ='';
		foreach ( $span_styles as $span_rule => $span_value ) {
			$span_style .= $span_rule . ':' . $span_value . ';';
		}
$img_style ='';
		foreach ( $img_styles as $img_rule => $img_value ) {
			$img_style .= $img_rule . ':' . $img_value . ';';
		}

		$icon_image = ( $icon ) ? '<img src="' . $icon . '" alt="' . htmlspecialchars( $content ) . '" style="' . $img_style . '" /> ' : '';

		$target = ( $target ) ? ' target="_' . $target . '"' : '';

		return '<a href="' . $link . '" class="su-button su-button-style-' . $style . ' ' . $class . '" style="' . $link_style . '"' . $target . '><span style="' . $span_style . '">' . $icon_image . $content . '</span></a>';
	}

	/**
	 * Shortcode: fancy-link
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_fancy_link_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'link' => '#',
				'color' => 'black'
				), $atts ) );

		return '<a class="su-fancy-link su-fancy-link" style=" color:' . $color . '" href="' . $link . '">' . $content . '<span>&rarr;</span></a>';
	}

	/**
	 * Shortcode: service
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_service_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'title' => __( 'Service name', 'shortcodes-ultimate' ),
				'icon' =>   get_template_directory_uri()  .'/functions/shortcodes-ultimate/images/service.png',
				'size' => 32
				), $atts ) );

		return '<div class="su-service"><div class="su-service-title" style="padding:' . round( ( $size - 16 ) / 2 ) . 'px 0 ' . round( ( $size - 16 ) / 2 ) . 'px ' . ( $size + 8 ) . 'px"><img src="' . $icon . '" width="' . $size . '" height="' . $size . '" alt="' . $title . '" /> ' . $title . '</div><div class="su-service-content" style="padding:0 0 0 ' . ( $size + 10 ) . 'px">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: box
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_box_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'color' => '#333',
				'title' => __( 'This is box title', 'shortcodes-ultimate' )
				), $atts ) );

		$styles = array(
			'dark_color' => su_hex_shift( $color, 'darker', 20 ),
			'text_color' => su_hex_shift( $color, 'darker', 60 ),
			'light_color' => su_hex_shift( $color, 'lighter', 60 ),
			'text_shadow' => su_hex_shift( $color, 'darker', 20 ),
			'extra_light_color' => su_hex_shift( $color, 'lighter', 80 ),
		);

		return '<div class="su-box"><div class="su-box-title" style="background-color:' . $color . '; text-shadow:1px 1px 0 ' . $styles['text_shadow'] . '">' . $title . '</div><div class="su-box-content"  style="color:' . $styles['text_color'] . '; background-color:' . $styles['extra_light_color'] . ';">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: note
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_note_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'color' => '#fc0'
				), $atts ) );

		$styles = array(
			'dark_color' => su_hex_shift( $color, 'darker', 20 ),
			'light_color' => su_hex_shift( $color, 'lighter', 20 ),
			'extra_light_color' => su_hex_shift( $color, 'lighter', 50 ),
			'text_color' => su_hex_shift( $color, 'darker', 60 )
		);

		return '<div class="su-note" style="background-color:' . $styles['light_color'] . ';border:1px solid ' . $styles['dark_color'] . '"><div class="su-note-shell" style="border:1px solid ' . $styles['extra_light_color'] . '; color:' . $styles['text_color'] . '">' . do_shortcode( $content ) . '</div></div>';
	}
	
		/**
	 * Shortcode: call out
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_callout_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'bg' => '#003d72',
				'color' => '#fff',
				'padding' => 25,
				), $atts ) );

		$styles = array(
			'dark_color' => su_hex_shift( $color, 'darker', 20 ),
			'light_color' => su_hex_shift( $color, 'lighter', 20 ),
			'extra_light_color' => su_hex_shift( $color, 'lighter', 50 ),
			'text_color' => su_hex_shift( $color, 'darker', 60 )
		);

		return '<div class="su-callout" style="background-color:' . $bg . '; color:' . $color . '; padding:'. $padding .'px;">' . do_shortcode( $content ) . '</div>';
	}


	/**
	 * Shortcode: private
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_private_shortcode( $atts = null, $content = null ) {

		if ( current_user_can( 'publish_posts' ) )
			return '<div class="su-private"><div class="su-private-shell">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: media
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_media_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'url' => '',
				'width' => 600,
				'height' => 400
				), $atts ) );

		$return = '<div class="su-media">';
		$return .= ( $url ) ? su_get_media( $url, $width, $height ) : __( 'Please specify media url', 'shortcodes-ultimate' );
		$return .= '</div>';

		return $return;
	}


	/**
	 * Shortcode: photoshop
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_photoshop_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'image' => false,
				'width' => 200,
				'height' => 100,
				'crop' => 1,
				'quality' => 100,
				'filter' => 1,
				'sharpen' => 0
				), $atts ) );

		return '<img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;zc=' . $crop . '&amp;q=' . $quality . '&amp;f=' . $filter . '&amp;s=' . $sharpen . '" width="' . $width . '" height="' . $height . '" alt="" />';
	}

	/**
	 * Shortcode: nivo_slider
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_nivo_slider_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'width' => 600,
				'height' => 300,
				'link' => false,
				'effect' => 'random',
				'speed' => 600,
				'delay' => 3000,
				'p' => false
				), $atts ) );

		global $post;
		$post_id = ( $p ) ? $p : $post->ID;

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'order' => 'ASC',
			'post_status' => null,
			'post_parent' => $post_id
		);

		// Get attachments
		$attachments = get_posts( $args );

		// If has attachments
		if ( count( $attachments ) > 1 ) {
			$slider_id = uniqid( 'su-nivo-slider_' );
			$return = '<script type="text/javascript">
				var $j = jQuery.noConflict();
					$j(function(){
						jQuery(window).load(function() {
							jQuery("#' . $slider_id . '").nivoSlider({
								effect: "' . $effect . '",
								animSpeed: ' . $speed . ',
								pauseTime: ' . $delay . '
							});
						});
					});</script>';
			$return .= '<div id="' . $slider_id . '" class="su-nivo-slider" style="width:' . $width . 'px;height:' . $height . 'px">';
			foreach ( $attachments as $attachment ) {

				$title = apply_filters( 'the_title', $attachment->post_title );
				$image = wp_get_attachment_image_src( $attachment->ID, 'full', false );

				// Link to file
				if ( $link == 'file' ) {
					$return .= '<a href="' . $image[0] . '" title="' . $title . '"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" /></a>';
				}

				// Link to attachment page
				elseif ( $link == 'attachment' ) {
					$return .= '<a href="' . get_permalink( $attachment->ID ) . '" title="' . $title . '"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" /></a>';
				}

				// Custom link
				elseif ( $link == 'caption' ) {
					if ( $attachment->post_excerpt ) {
						$return .= '<a href="' . $attachment->post_excerpt . '" title="' . $title . '"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" /></a>';
					} else {
						$return .= '<img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" />';
					}
				}

				// No link
				else {
					$return .= '<img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" />';
				}
			}
			$return .= '</div>';
		}

		// No attachments
		else {
			$return = '<p class="su-error"><strong>Nivo slider:</strong> ' . __( 'no attached images, or only one attached image', 'shortcodes-ultimate' ) . '&hellip;</p>';
		}
		return $return;
	}

	/**
	 * Shortcode: permalink
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_permalink_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'p' => 1,
				'target' => ''
				), $atts ) );

		$text = ( $content ) ? $content : get_the_title( $p );
		$tgt = ( $target ) ? ' target="_' . $target . '"' : '';

		return '<a href="' . get_permalink( $p ) . '" title="' . $text . '"' . $tgt . '>' . $text . '</a>';
	}

	/**
	 * Shortcode: bloginfo
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_bloginfo_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'option' => 'name'
				), $atts ) );

		return get_bloginfo( $option );
	}

	/**
	 * Shortcode: subpages
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_subpages_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'depth' => 1,
				'p' => false
				), $atts ) );

		global $post;

		$child_of = ( $p ) ? $p : get_the_ID();

		$return = wp_list_pages( array(
			'title_li' => '',
			'echo' => 0,
			'child_of' => $child_of,
			'depth' => $depth
			) );

		return ( $return ) ? '<ul class="su-subpages">' . $return . '</ul>' : false;
	}

	/**
	 * Shortcode: siblings pages
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_siblings_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'depth' => 1
				), $atts ) );

		global $post;

		$return = wp_list_pages( array(
			'title_li' => '',
			'echo' => 0,
			'child_of' => $post->post_parent,
			'depth' => $depth,
			'exclude' => $post->ID
			) );

		return ( $return ) ? '<ul class="su-siblings">' . $return . '</ul>' : false;
	}

	/**
	 * Shortcode: menu
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_menu_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'name' => 1,
				'style' => 1
				), $atts ) );

		$return = wp_nav_menu( array(
			'echo' => false,
			'menu' => $name,
			'container' => false,
			'menu_id' => 'sitemap_menu-' . $style,
			'fallback_cb' => 'su_menu_shortcode_fb_cb'
			) );

		return ( $name ) ? $return : false;
	}

	/**
	 * Fallback callback function for menu shortcode
	 *
	 * @return string Text message
	 */
	function su_menu_shortcode_fb_cb() {
		return __( 'This menu doesn\'t exists, or has no elements', 'shortcodes-ultimate' );
	}

	/**
	 * Shortcode: document
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_document_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'width' => 600,
				'height' => 400,
				'file' => ''
				), $atts ) );

		return '<iframe src="http://docs.google.com/viewer?embedded=true&url=' . $file . '" width="' . $width . '" height="' . $height . '" class="su-document"></iframe>';
	}

	/**
	 * Shortcode: gmap
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_gmap_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'width' => 600,
				'height' => 400,
				'address' => 'New York'
				), $atts ) );

		return '<iframe width="' . $width . '" height="' . $height . '" src="http://maps.google.com/maps?q=' . urlencode( $address ) . '&amp;output=embed&amp;iwloc=near" class="su-gmap"></iframe>';
	}

	/**
	 * Shortcode: members
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_members_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'style' => 1
				), $atts ) );

		if ( is_user_logged_in() && !is_null( $content ) && !is_feed() ) {
			return do_shortcode( $content );
		} else {
			return '<div class="su-members su-members-style-' . $style . '"><span class="su-members-shell">' . __( 'This content is for members only.', 'shortcodes-ultimate' ) . ' <a href="' . wp_login_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Please login', 'shortcodes-ultimate' ) . '</a>.' . '</span></div>';
		}
	}

	/**
	 * Shortcode: feed
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_feed_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'url' => get_bloginfo_rss( 'rss2_url' ),
				'limit' => 3
				), $atts ) );

		include_once( ABSPATH . WPINC . '/rss.php' );

		return '<div class="su-feed">' . wp_rss( $url, $limit ) . '</div>';
	}

	/**
	 * Shortcode: jcarousel
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_jcarousel_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'width' => 600,
				'height' => 130,
				'link' => false,
				'items' => 3,
				'margin' => 10,
				'speed' => 400,
				'bg' => '#eee',
				'p' => false
				), $atts ) );

		global $post;
		$post_id = ( $p ) ? $p : $post->ID;

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'order' => 'ASC',
			'post_status' => null,
			'post_parent' => $post_id
		);

		// Get attachments
		$attachments = get_posts( $args );

		// If has attachments
		if ( count( $attachments ) > 1 ) {

			$carousel_id = uniqid( 'su-jcarousel_' );

			$width = $width - 80;
			$height = $height - 30;

			$item_width = round( ( $width - ( ( $items - 1 ) * $margin ) ) / $items );

			$return = '
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#' . $carousel_id . '").jcarousel({
							auto: 2,
							scroll: 1,
							wrap: "last",
							animation: ' . $speed . ',
							initCallback: mycarousel_initCallback
						 });
					});
				</script>
			';			
			if (get_option_tree('responsive_layout') == 'Responsive layout only for smartphones' || get_option_tree('responsive_layout') == 'Responsive layout for smartphones and tablets' ) {
			$return .='<style>
			@media only screen and (min-width: 480px) and (max-width: 767px) {
				.mobile-' . $carousel_id . '{
					margin: 0px auto !important;
				}
				.mobile-' . $carousel_id . '{
				height: ' . $height*0.44 . 'px !important;
				width: ' . $width*0.44 . 'px !important;
				}				
				.mobile-' . $carousel_id . ' img, .mobile-' . $carousel_id . ' .jcarousel-container li { 
				width: ' . $item_width*0.44 . 'px !important;
				height: auto !important;
				}				
				#custom_header .mobile-' . $carousel_id . ' {
				padding: 10px 0;
				}
			}
			@media only screen and (max-width: 479px) {
				.mobile-' . $carousel_id . '{
				margin: 0px auto !important;
				}
				.mobile-' . $carousel_id . '{
				height: ' . $height*0.28 . 'px !important;
				width: ' . $width*0.28 . 'px !important;
				}				
				.mobile-' . $carousel_id . ' .jcarousel-list img, .mobile-' . $carousel_id . ' .jcarousel-container li { 
				width: ' . $item_width*0.28 . 'px !important;
				height: auto !important;
				}
				#custom_header .su-jcarousel {
				padding: 10px 0;
				}
			}';
			}
			if (get_option_tree('responsive_layout') == 'Responsive layout for smartphones and tablets') {
				$return .='@media only screen and (min-width: 768px) and (max-width: 959px) {
				.mobile-' . $carousel_id . '{
				margin: 0px auto !important;
				}
				.mobile-' . $carousel_id . ', .mobile-' . $carousel_id . ' .jcarousel-container{
				height: ' . $height*0.72 . 'px !important;
				width: ' . $width*0.72 . 'px !important;
				}				
				.mobile-' . $carousel_id . ' img, .mobile-' . $carousel_id . ' .jcarousel-container li { 
				width: ' . $item_width*0.72 . 'px !important;
				height: auto !important;
				}				
				#custom_header .mobile-' . $carousel_id . ' {
				padding: 20px 0;
				}
			}</style>';
			} else { $return .='</style>';}

			$return .= '<div class="su-jcarousel mobile-' . $carousel_id . '" style="width:' . $width . 'px;height:' . $height . 'px;background-color:' . $bg . '"><div class="su-jcarousel-shell"><ul id="' . $carousel_id . '">';

			foreach ( $attachments as $attachment ) {

				$title = apply_filters( 'the_title', $attachment->post_title );
				$image = wp_get_attachment_image_src( $attachment->ID, 'full', false );

				$return .= '<li style="width:' . $item_width . 'px;height:' . $height . 'px;margin-right:' . $margin . 'px">';

				// Link to file
				if ( $link == 'file' ) {
					$return .= '<a href="' . $image[0] . '" title="' . $title . '"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $item_width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $item_width . '" height="' . $height . '" alt="' . $title . '" /></a>';
				}

				// Link to attachment page
				elseif ( $link == 'attachment' ) {
					$return .= '<a href="' . get_permalink( $attachment->ID ) . '" title="' . $title . '"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $item_width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $item_width . '" height="' . $height . '" alt="' . $title . '" /></a>';
				}

				// Custom link
				elseif ( $link == 'caption' ) {
					if ( $attachment->post_excerpt ) {
						$return .= '<a href="' . $attachment->post_excerpt . '" title="' . $title . '"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $item_width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $item_width . '" height="' . $height . '" alt="' . $title . '" /></a>';
					} else {
						$return .= '<img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $item_width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $item_width . '" height="' . $height . '" alt="' . $title . '" />';
					}
				}

				// No link
				else {
					$return .= '<a><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $item_width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $item_width . '" height="' . $height . '" alt="' . $title . '" /></a>';
				}

				$return .= '</li>';
			}
			$return .= '</ul></div></div>';
		}

		// No attachments
		else {
			$return = '<p class="su-error su-error-carousel"><strong>jCarousel:</strong> ' . __( 'no attached images, or only one attached image', 'shortcodes-ultimate' ) . '&hellip;</p>';
		}

		return $return;
	}
	
	/**
	 * Shortcode: Featured post carousel
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_fp_carousel_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'width' => 1005,
				'height' => 130,
				'items' => 5,
				'margin' => 10,
				'speed' => 600,
				'post_type' => 'post',
				'cat' => null,
				'tag' => null,
				'include' => null,
				'exclude' => null,
				'num' => -1,
				'orderby' => 'date',
				'order' => 'DESC'
				), $atts ) );

	
		global $post;
		$args = array(
			'post_type' => $post_type,
			'category_name' => $cat,
			'tag' => $tag,
			'numberposts' => $num,
			'orderby' => $orderby,
			'include' => $include,
			'exclude' => $exclude,
			'order' => $order
		);
        $myposts = get_posts($args);

			$carousel_id = uniqid( 'su-fpcarousel_' );

			$width = $width - 80;
			$height = $height - 30;

			$item_width = round( ( $width - ( ( $items - 1 ) * $margin ) ) / $items );

			$return = '
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#' . $carousel_id . '").css("display","block");
						jQuery("#' . $carousel_id . '").jcarousel({
							auto: 2,
							scroll: 1,
							wrap: "last",
							animation: ' . $speed . ',
							initCallback: mycarousel_initCallback
						 });
					});
				</script>
			';			

			$return .= '<div class="fp_carousel" style="width:' . $width . 'px;height:' . $height . 'px;background-color:' . $bg . '"><div class="fp_carousel-shell"><ul id="' . $carousel_id . '" style="display:none;">';

			foreach($myposts as $post) :
                setup_postdata($post);
				global $more;
                $more = 0;
				
				if (strlen($post->post_title) > 46) {
				$title = substr(get_the_title($before = '', $after = '', FALSE), 0, 46) . '...'; } else {
				$title = get_the_title();}
				
				$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

				$return .= '<li style="width:' . $item_width . 'px;height:' . $height . 'px;margin-right:' . $margin . 'px">';

				$return .= '<a href="' . get_permalink() . '" title="'. get_the_title() .'"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $item_width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $item_width . '" height="' . $height . '" alt="'. get_the_title() .'" /><span class="fp_title">'. $title .'</span></a>';
			
				$return .= '</li>';
			endforeach;
			wp_reset_query();

			$return .= '</ul></div></div>';

		return $return;
	}
	
	/**
	 * Shortcode: Post slider
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_post_slider_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'width' => 327,
				'post_type' => 'post',
				'cat' => null,
				'tag' =>  null,
				'include' => null,
				'exclude' => null,
				'tabs' => 4,
				'selected_color' => '#D92818',
				'delay' => 5000,
				'orderby' => 'date',
				'order' => 'DESC'
				), $atts ) );

	
		global $post;
		$args = array(
			'post_type' => $post_type,
			'category_name' => $cat,
			'tag' => $tag,
			'numberposts' => $tabs,
			'orderby' => $orderby,
			'include' => $include,
			'exclude' => $exclude,
			'order' => $order
		);
		$count = 0;
		$count_p = 0;
        $myposts = get_posts($args);
			
			$slider_id = uniqid( '_' );
			
			if ($tabs == 3) $height = 190;
			elseif ($tabs == 4) $height = 253;
			elseif ($tabs == 5) $height = 316;
			elseif ($tabs == 6) $height = 379;
			else $height = 253;
			
			$return = '
				<style>
					#post_slider'. $slider_id .', #post_slider'. $slider_id .' .ui-tabs-panel{width:'. $width .'px; height:'. $height .'px;}
					#post_slider'. $slider_id .' ul.ui-tabs-nav{left:'. $width .'px;} 
					.post_slider ul.ui-tabs-nav li.ui-tabs-selected a, .post_slider li.ui-tabs-nav-item a:hover{background-color:'. $selected_color .';}

				</style>';

			$return .= '
				<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#post_slider'. $slider_id .'").tabs({fx:{opacity: "toggle"}}).tabs("rotate", '. $delay .', true);  
				});
				</script>';		

			$return .= '<div id="post_slider'. $slider_id .'" class="post_slider" >
			
			<ul class="ui-tabs-nav">';

			foreach($myposts as $post) :
                setup_postdata($post);
				global $more;
                $more = 0;
				$count++;
				
				if( $count == 1 ){ 
				$l_class = ' ui-tabs-selected';	
				} else {
				$l_class = '';
				}

				if (strlen($post->post_title) > 60) {
				$title = substr(get_the_title($before = '', $after = '', FALSE), 0, 60) . '...'; } else {
				$title = get_the_title();}
				
				$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

				$return .= '<li class="ui-tabs-nav-item '. $l_class .'" id="nav-fragment-' . $count . '">';

				$return .= '<a href="#fragment-' . $count . '" title="'. get_the_title() .'"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w=80&amp;h=50&amp;q=100&amp;zc=1" width="80" height="50" alt="'. get_the_title() .'" /><span class="ps_title">'. $title .'</span><span></span>' . do_shortcode (get_post_meta($post->ID, 'special_note', true)) . '</a>';
			
				$return .= '</li>';
			endforeach;
			
			$return .= '</ul>';
			
			foreach($myposts as $post) :
                setup_postdata($post);
				global $more;
                $more = 0;
				$count_p++;
				
				if( $count_p == 1 ){ 
				$p_class = '';	
				} else {
				$p_class = ' ui-tabs-hide';
				}
				
				if (strlen($post->post_title) > 75) {
				$title = substr(get_the_title($before = '', $after = '', FALSE), 0, 75) . '...'; } else {
				$title = get_the_title();}
				
				$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

				$return .= '<div id="fragment-' . $count_p . '" class="ui-tabs-panel'. $p_class .'">';

				$return .= '<a href="' . get_permalink() . '" title="'. get_the_title() .'"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image[0] . '&amp;w='. $width .'&amp;h='. $height .'&amp;q=100&amp;zc=1" width="'. $width .'" height="'. $height .'" alt="'. get_the_title() .'" /></a><div class="info" ><h2><a href="' . get_permalink() . '" title="'. get_the_title() .'">'. $title .'</a></h2><p>'. excerpt(18) .'</p></div>';
			
				$return .= '</div>';
			endforeach;
			wp_reset_query();

			$return .= '</div>';

		return $return;
	}
	
	/**
	 * Shortcode: Ad
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_ad_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'id' => null
				), $atts ) );

	
		global $post;
		$args = array(
			'post_type' => 'ad_post_type',
			'p' => $id,
			'numberposts' => 1
			);
		
        $ad_posts = get_posts($args);
			
			$ad_id = uniqid( 'ad_' );

			foreach($ad_posts as $post) :
                setup_postdata($post);
				global $more;
                $more = 0;
				
				$ad_width = get_post_meta($post->ID, 'ad_width', true);
				$ad_height = get_post_meta($post->ID, 'ad_height', true);
				$ad_link = get_post_meta($post->ID, 'ad_link', true);
				$ad_target = get_post_meta($post->ID, 'ad_target', true);
				$ad_image_url = get_post_meta($post->ID, 'ad_image_url', true);
				$ad_html = do_shortcode (get_post_meta($post->ID, 'ad_html', true));
				
				if ($ad_width){ 
					$ad_div_width = $ad_width .'px'; 
					$ad_img_width = ' width='. $ad_width; 
				} else { 
					$ad_width = '100%'; 
					$ad_img_width = '';
				}
				
				if ($ad_height){ 
					$ad_div_height = $ad_height .'px'; 
					$ad_img_height = ' height='. $ad_height; 
				} else { 
					$ad_height = '100%'; 
					$ad_img_height = '';
				}
				
				$return .= '<div id="'. $ad_id .'" class="custom-ad" style="width:'. $ad_div_width .'; height:'. $ad_div_height .';">';
				
				if ($ad_link) $return .= '<a href="' . $ad_link .'" target="'. $ad_target .'">';
				
				if ($ad_image_url) $return .= '<img src="'. $ad_image_url .'"'. $ad_img_width . $ad_img_height .' alt="ad" />';
				
				if ($ad_html) $return .= $ad_html;
				
				if ($ad_link) $return .= '</a>';
			
				$return .= '</div>';
			endforeach;
			wp_reset_query();

		return $return;
	}

	
	/**
	 * Shortcode: staff
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_staff_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'name' => 'Full Name',
				'position' => 'Job position',
				'img' => get_template_directory_uri()  .'/functions/shortcodes-ultimate/images/su_avatar.png'
				), $atts ) );

		return '<div class="su-frame su-frame-align-left"><div class="su-frame-shell"><img src="'.$img.'" alt="" width="125" /></div></div><div class="su_au_name">'.$name. '</div><div class="su_au_pos">' . $position . '</div><div class="su_au_dec">'. do_shortcode( $content ) .'</div>';
	}

	/**
	 * Shortcode: tweets
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_tweets_shortcode( $atts, $content=null ) {
		shortcode_atts(array(
		'id'=> null,
		'username'=> null, 
		'list'=> null, 
		'query' => null, 
		'limit' => null
		), $atts);
		$options = (($atts['username'])?'username:"'.$atts['username'].'",':'username:"smashingmag",');
		$options .= (($atts['limit'])?'limit:'.$atts['limit'].',':'');
		$options .= (($atts['query'])?'query:"'.$atts['query'].'",':'');
		$options .= (($atts['list'])?'list:"'.$atts['list'].'",':'');
	
	return '<div class="tweets"> 
				<div class="content_tweets'.$atts['id'].'"> </div> 
			</div>
			<script type="text/javascript">
				jQuery(".content_tweets'.$atts['id'].'").miniTwitter({
					'.$options.'
					retweet:true
				});
			</script>';
}
	
	/**
	 * Shortcode: dropcap
	 */
	function su_dropcap_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'color' => 'black',
	), $atts));
		return '<div class="su-dropcap-'. $color .'">'. do_shortcode( $content ) .'</div>';
	}

	
	/**
	 * Div clear - shortcode
	 */
	function su_clear_shortcode() {
		 return '<div class="clear"></div>';
	}
	
	
	/**
	 * Div custom style - shortcode
	 */
	function su_div_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'style' => '',
		'class' => 'su_custom_style_div'
	), $atts));
		return '<div class="'.$class.'" style="'.$style.'">'. do_shortcode( $content ) .'</div>';
	}
	
	/**
	 * Break - shortcode
	 */
	function break_shortcode() {
		 return '<br />';
	}
	add_shortcode('br', 'break_shortcode');
	
	/**
	 * Shortcode: Pricing box
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_pricing_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'bg' => 'yes',
				'color' => '#2b2b2b',
				'text' => '#fff',
				'currency' => '$',
				'price' => 10,
				'period' => '/mo',
				'slug' => '',
				'link' => false,
				'title' => __( 'This is title', 'shortcodes-ultimate' )
				), $atts ) );

		$styles = array(
			'dark_color' => su_hex_shift( $color, 'darker', 20 ),
			'extra_dark_color' => su_hex_shift( $color, 'darker', 40 ),
			'light_color' => su_hex_shift( $color, 'lighter', 10 ),
			'extra_light_color' => su_hex_shift( $color, 'lighter', 50 ),
			'no_bg_light_color' => su_hex_shift( $text, 'lighter', 60 ),
			'no_bg_light_txt' => su_hex_shift( $text, 'lighter', 40 ),
		);
		
		// Check link
		if ( $link == false ) {
		$return .= '';
		}
		else {
		$return .= '<a href="' . $link . '">';
		}

		// With background 
		if ( $bg == 'yes' ) {
		$return .= '<div class="su-pricing-box-bg" style="background-color:' . $color . ';"><span class="su-pricing-title"  style="color:' . $text . ';"> ' . $title . '</span><div class="su-pricing-line" style="background-color:' . $styles['extra_dark_color'] . ';" ></div><div class="su-pricing-line-2" style="background-color:' . $styles['light_color'] . ';" ></div><div style="color:' . $text . ';"><span class="su-pricing-value su-pricing-currency" style="font-size: 30px;" >' . $currency . '</span><span class="su-pricing-value" style="font-size: 95px;">'. $price . '</span><span class="su-pricing-value" style="font-size: 14px;">' . $period . '</span><br/><span class="su-pricing-slug" style="color: ' . $styles['extra_light_color'] . '; font-size: 11px; ">' . $slug . '</span></div><div class="su-pricing-line" style="background-color:' . $styles['extra_dark_color'] . ';" ></div><div class="su-pricing-line-2" style="background-color:' . $styles['light_color'] . ';" ></div><div class="su-pricing-content" style="color:' . $text . ';">' . do_shortcode( $content ) . '</div></div>';
		}

		// No background
		elseif ( $bg == 'no' ) {
		$return .= '<div class="su-pricing-box" style="background-color:transparent;"><span class="su-pricing-title"  style="color:' . $text . ';"> ' . $title . '</span><div style="color:' . $text . ';"><span class="su-pricing-value su-pricing-currency"  style="font-size: 30px;" >' . $currency . '</span><span class="su-pricing-value" style="font-size: 95px;">' . $price . '</span><span class="su-pricing-value" style="font-size: 14px;">'. $period . '</span><br/><span class="su-pricing-slug" style="color: ' . $styles['no_bg_light_txt'] . '; font-size: 11px; ">' . $slug . '</span></div><div class="su-pricing-line-2" style="background-color:' . $styles['no_bg_light_color'] . ';" ></div><div class="su-pricing-content" style="color:' . $text . ';">' . do_shortcode( $content ) . '</div></div>';
		}
		
		// Check link
		if ( $link == false ) {
		$return .= '';
		}
		else {
		$return .= '</a>';
		}
		
		return $return;
	}
	
	
	/**
	 * Shortcode: Google chart
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_chart_shortcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
	    'data' => '',
	    'size' => '400x180',
	    'colors' => '',
	    'title' => '',
	    'labels' => '',
	    'type' => 'pie',
	    'advanced' => ''
	), $atts));
	switch ($type) {
		case 'line' :
			$charttype = 'lc'; break;
		case 'xyline' :
			$charttype = 'lxy'; break;
		case 'sparkline' :
			$charttype = 'ls'; break;
		case 'meter' :
			$charttype = 'gom'; break;
		case 'scatter' :
			$charttype = 's'; break;
		case 'venn' :
			$charttype = 'v'; break;
		case 'pie' :
			$charttype = 'p3'; break;
		case 'pie2d' :
			$charttype = 'p'; break;
		default :
			$charttype = $type;
		break;
	}
	if ($title) $string .= '&chtt='.$title.'';
	if ($labels) $string .= '&chl='.$labels.'';
	if ($colors) $string .= '&chco='.$colors.'';
	$string .= '&chs='.$size.'';
	$string .= '&chd=t:'.$data.'';
	return '<img title="'.$title.'" src="http://chart.apis.google.com/chart?cht='.$charttype.''.$string.$advanced.'" alt="'.$title.'" />';
}

	/**
	 * Shortcode: Content cover

	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_cover_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'img' => get_template_directory_uri()  .'/functions/shortcodes-ultimate/images/fader-icon.png',
				'color' => '#f1f1f1',
				'bg_pos' => 'center center'
				), $atts ) );

		return '<div class="fader"><span class="faderbg" style="background-image:url('. $img .'); background-color:'. $color .'; background-repeat:no-repeat; background-position:'. $bg_pos .';"></span><span class="fadecontent" >'. do_shortcode( $content ) .'</span></div>';
	}


?>