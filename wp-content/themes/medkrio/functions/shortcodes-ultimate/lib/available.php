<?php

	/**
	 * List of available shortcodes
	 */
	function su_shortcodes( $shortcode = false ) {
		$shortcodes = array(
			# basic shortcodes - start
			'basic-shortcodes-open' => array(
				'name' => __( 'Basic shortcodes', 'shortcodes-ultimate' ),
				'type' => 'opengroup'
			),
				
				# column
				'column' => array(
					'name' => 'Columns',
					'type' => 'wrap',
					'atts' => array(
						'size' => array(
							'values' => array(
								'1-2',
								'1-3',
								'1-4',
								'1-5',
								'1-6',
								'2-3',
								'2-5',
								'3-4',
								'3-5',
								'4-5',
								'5-6'
							),
							'default' => '1-2',
							'desc' => __( 'Column width', 'care' )
						),
						'style' => array(
							'values' => array(
								'0',
								'1'
							),
							'default' => '0',
							'desc' => __( 'Style: style 1 has smaller margins', 'care' )
						),
						'last' => array(
							'values' => array(
								'0',
								'1'
							),
							'default' => '0',
							'desc' => __( 'Last column', 'care' )
						)
					),
					'usage' => '[column size="1-2"] Content [/column]<br/>[column size="1-2" last="1"] Content [/column]',
					'content' => __( 'Column content', 'care' ),
					'desc' => __( 'Flexible columns', 'care' )
				),
				
				# heading
				'heading' => array(
					'name' => 'Heading',
					'type' => 'wrap',
						'atts' => array(
							'font_size' => array(
								'values' => array( ),
								'default' => '20px',
								'desc' => __( 'Font size', 'care' ),
							),
							'color' => array(
								'values' => array( ),
								'default' => '#284B80',
								'desc' => __( 'Text color', 'care' ),
								'type' => 'color'
							)
					),
					'usage' => '[heading] Content [/heading]',
					'content' => __( 'Heading', 'care' ),
					'desc' => __( 'Styled heading with custom color', 'care' )
				),
				
				# spacer
				'spacer' => array(
					'name' => 'Spacer',
					'type' => 'single',
					'atts' => array(
						'size' => array(
							'values' => array( ),
							'default' => '20',
							'desc' => __( 'Spacer height in pixels', 'care' )
						)
					),
					'usage' => '[spacer size="20"]',
					'desc' => __( 'Empty space with adjustable height', 'care' )
				),
				
				# fancy_link
				'fancy_link' => array(
					'name' => 'Fancy link',
					'type' => 'wrap',
					'atts' => array(
							'color' => array(
							'values' => array( ),
							'default' => '#AAAAAA',
							'desc' => __( 'Button background color', 'care' ),
							'type' => 'color'
						),
					
						'link' => array(
							'values' => array( ),
							'default' => '#',
							'desc' => __( 'URL', 'care' )
						)
						
					),
					'usage' => '[fancy_link color="black" link="http://example.com/"] Read more [/fancy_link]',
					'content' => __( 'Link text', 'care' ),
					'desc' => __( 'Styled link', 'care' )
				),
				
				# divider with text
				'textdivider' => array(
					'name' => 'Divider I',
					'type' => 'single',
					'atts' => array(
						'text' => array(
							'values' => array( ),
							'default' => __( 'Divider title', 'care' ),
							'desc' => __( 'Title', 'care' )
						),
						'color' => array(
								'values' => array( ),
								'default' => '#AAA9A9',
								'desc' => __( 'Text color', 'care' ),
								'type' => 'color'
						),					
						'line' => array(
								'values' => array( ),
								'default' => '#E0E0E0',
								'desc' => __( 'Divider line color', 'care' ),
								'type' => 'color'
						)				
					),
					'usage' => '[textdivider]',
					'desc' => __( 'Divider with custom title and color', 'care' )
				),
				
				# divider
				'divider' => array(
					'name' => 'Divider II',
					'type' => 'single',
					'atts' => array(
						'top' => array(
							'values' => array(
								'0',
								'1'
							),
							'default' => '0',
							'desc' => __( 'Show TOP link', 'care' )
						),
						
						'style' => array(
							'values' => array(
								'shadow',
								'solid'
							),
							'default' => 'solid',
							'desc' => __( 'Divider style', 'care' )
						)
					),
					'usage' => '[divider top="1"]',
					'desc' => __( 'Divider with optional TOP link and two styles', 'care' )
				),
			
			# basic shortcodes - end
			'basic-shortcodes-close' => array(
				'type' => 'closegroup'
			),
			
			# post shortcodes - start
			'post-shortcodes-open' => array(
				'name' => __( 'Post shortcodes', 'shortcodes-ultimate' ),
				'type' => 'opengroup'
			),
			
				# posts I
				'display_news_s1' => array(
					'name' => 'Post Shortcode I',
					'type' => 'single',
					'atts' => array(
						'width' => array(
							'values' => false,
							'default' => '225',
							'desc' => __( 'Image width', 'care' )
						),		
						'height' => array(
							'values' => false,
							'default' => '145',
							'desc' => __( 'Image height', 'care' )
						),	
						'excerpt_l' => array(
							'values' => false,
							'default' => '16',
							'desc' => __( 'Words in excerpt', 'care' )
						),
						'include_date' => array(
							'values' => array(
								'true',
								'false'
							),
							'default' => 'false',
							'desc' => __( 'Show date & comments', 'care' )
						),
						'posts_per_page' => array(
							'values' => false,
							'default' => '4',
							'desc' => __( 'Number of posts', 'care' )
						),
						'offset' => array(
							'values' => false,
							'default' => '0',
							'desc' => __( 'Offset', 'care' )
						),
						'orderby' => array(
							'values' => array(
								'ID',
								'author',
								'title',
								'date',
								'modified',
								'parent',
								'rand',
								'comment_count'	
							),
							'default' => 'date',
							'desc' => __( 'Order by', 'care' )
						),
						'order' => array(
							'values' => array(
								'ASC',
								'DESC'
							),
							'default' => 'DESC',
							'desc' => __( 'Order', 'care' )
						),					
						'post_type' => array(
							'values' => false,
							'default' => 'post',
							'desc' => __( 'Post type', 'care' )
						),
						'category' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Category SLUG', 'care' )
						),
						'tag' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Tag SLUG', 'care' )
						),
						'id' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Post ID', 'care' )
						)
					),
					'usage' => '[display_news_s1]',
					'desc' => __( 'Left aligned first post', 'care' )
				),
				# posts II
				'display_news_s2' => array(
					'name' => 'Post Shortcode II',
					'type' => 'single',
					'atts' => array(
						'width' => array(
							'values' => false,
							'default' => '225',
							'desc' => __( 'Image width', 'care' )
						),		
						'height' => array(
							'values' => false,
							'default' => '145',
							'desc' => __( 'Image height', 'care' )
						),	
						'img_for_all' => array(
							'values' => array(
								'true',
								'false'
							),
							'default' => 'false',
							'desc' => __( 'Images for all posts?', 'care' )
						),
						'excerpt_l' => array(
							'values' => false,
							'default' => '30',
							'desc' => __( 'Words in excerpt', 'care' )
						),
						'include_date' => array(
							'values' => array(
								'true',
								'false'
							),
							'default' => 'false',
							'desc' => __( 'Show date & comments', 'care' )
						),
						'posts_per_page' => array(
							'values' => false,
							'default' => '4',
							'desc' => __( 'Number of posts', 'care' )
						),
						'offset' => array(
							'values' => false,
							'default' => '0',
							'desc' => __( 'Offset', 'care' )
						),
						'orderby' => array(
							'values' => array(
								'ID',
								'author',
								'title',
								'date',
								'modified',
								'parent',
								'rand',
								'comment_count'	
							),
							'default' => 'date',
							'desc' => __( 'Order by', 'care' )
						),
						'order' => array(
							'values' => array(
								'ASC',
								'DESC'
							),
							'default' => 'DESC',
							'desc' => __( 'Order', 'care' )
						),					
						'post_type' => array(
							'values' => false,
							'default' => 'post',
							'desc' => __( 'Post type', 'care' )
						),
						'category' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Category SLUG', 'care' )
						),
						'tag' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Tag SLUG', 'care' )
						),
						'id' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Post ID', 'care' )
						)
					),
					'usage' => '[display_news_s2]',
					'desc' => __( 'All posts in one column', 'care' )
				),
				# posts III
				'display_news_s4' => array(
					'name' => 'Post Shortcode III',
					'type' => 'single',
					'atts' => array(
						'width' => array(
							'values' => false,
							'default' => '208',
							'desc' => __( 'Image width', 'care' )
						),		
						'height' => array(
							'values' => false,
							'default' => '100',
							'desc' => __( 'Image height', 'care' )
						),	
						'include_excerpt' => array(
							'values' => array(
								'true',
								'false'
							),
							'default' => 'true',
							'desc' => __( 'Include excerpt?', 'care' )
						),
						'excerpt_l' => array(
							'values' => false,
							'default' => '17',
							'desc' => __( 'Words in excerpt', 'care' )
						),
						'include_date' => array(
							'values' => array(
								'true',
								'false'
							),
							'default' => 'false',
							'desc' => __( 'Show date & comments', 'care' )
						),
						'posts_per_page' => array(
							'values' => false,
							'default' => '4',
							'desc' => __( 'Number of posts', 'care' )
						),
						'category' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Category SLUG', 'care' )
						),
						'tag' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Tag SLUG', 'care' )
						),
						'id' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Post ID', 'care' )
						),
						'offset' => array(
							'values' => false,
							'default' => '0',
							'desc' => __( 'Offset', 'care' )
						),
						'orderby' => array(
							'values' => array(
								'ID',
								'author',
								'title',
								'date',
								'modified',
								'parent',
								'rand',
								'comment_count'	
							),
							'default' => 'date',
							'desc' => __( 'Order by', 'care' )
						),
						'order' => array(
							'values' => array(
								'ASC',
								'DESC'
							),
							'default' => 'DESC',
							'desc' => __( 'Order', 'care' )
						),					
						'post_type' => array(
							'values' => false,
							'default' => 'post',
							'desc' => __( 'Post type', 'care' )
						)
					),
					'usage' => '[display_news_s4]',
					'desc' => __( 'First post followed by bullets', 'care' )
				),
				# posts list style
				'display_news_s3' => array(
					'name' => 'Post Shortcode IV',
					'type' => 'single',
					'atts' => array(
						'include_excerpt' => array(
							'values' => array(
								'true',
								'false'
							),
							'default' => 'true',
							'desc' => __( 'Include excerpt?', 'care' )
						),
						'excerpt_l' => array(
							'values' => false,
							'default' => '8',
							'desc' => __( 'Words in excerpt', 'care' )
						),
						'include_date' => array(
							'values' => array(
								'true',
								'false'
							),
							'default' => 'true',
							'desc' => __( 'Show date & comments', 'care' )
						),
						'posts_per_page' => array(
							'values' => false,
							'default' => '4',
							'desc' => __( 'Number of posts', 'care' )
						),
						'offset' => array(
							'values' => false,
							'default' => '0',
							'desc' => __( 'Offset', 'care' )
						),
						'orderby' => array(
							'values' => array(
								'ID',
								'author',
								'title',
								'date',
								'modified',
								'parent',
								'rand',
								'comment_count'	
							),
							'default' => 'date',
							'desc' => __( 'Order by', 'care' )
						),
						'order' => array(
							'values' => array(
								'ASC',
								'DESC'
							),
							'default' => 'DESC',
							'desc' => __( 'Order', 'care' )
						),					
						'post_type' => array(
							'values' => false,
							'default' => 'post',
							'desc' => __( 'Post type', 'care' )
						),
						'category' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Category SLUG', 'care' )
						),
						'tag' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Tag SLUG', 'care' )
						),
						'id' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Post ID', 'care' )
						)
					),
					'usage' => '[display_news_s3]',
					'desc' => __( 'Short excerpt with title', 'care' )
				),
			
			# post shortcodes - end
			'post-shortcodes-close' => array(
				'type' => 'closegroup'
			),		
			
			
			# slider shortcodes - start
			'slider-shortcodes-open' => array(
				'name' => __( 'Slider shortcodes', 'shortcodes-ultimate' ),
				'type' => 'opengroup'
			),
				
				# Post Slider
				'post_slider' => array(
					'name' => 'Post slider',
					'type' => 'single',
					'atts' => array(
						'width' => array(
							'values' => false,
							'default' => '327',
							'desc' => __( 'Active slide width', 'care' )
						),
						'tabs' => array(
							'values' => array(
								'3',
								'4',
								'5',
								'6'
							),
							'default' => '4',
							'desc' => __( 'Number of tabs', 'care' )
						),
						'selected_color' => array(
								'values' => array( ),
								'default' => '#D92818',
								'desc' => __( 'Selected tab color', 'care' ),
								'type' => 'color'
						),
						'delay' => array(
							'values' => false,
							'default' => '5000',
							'desc' => __( 'Animation speed (1000 = 1 second)', 'care' )
						),
						'cat' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Category SLUG', 'care' )
						),
						'tag' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Tag SLUG', 'care' )
						),
						'orderby' => array(
							'values' => array(
								'ID',
								'author',
								'title',
								'date',
								'modified',
								'parent',
								'rand',
								'comment_count'	
							),
							'default' => 'date',
							'desc' => __( 'Order by', 'care' )
						),
						'post_type' => array(
							'values' => false,
							'default' => 'post',
							'desc' => __( 'Post type', 'care' )
						),
						'include' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Include (post IDs comma separated)', 'care' )
						),
						'exclude' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Exclude (post IDs comma separated)', 'care' )
						)
					),
					'usage' => '[post_slider]',
					'desc' => __( 'Post slider with tabs', 'care' )
				),
				
				# Featured post carousel
				'fp_carousel' => array(
					'name' => 'Post carousel',
					'type' => 'single',
					'atts' => array(
						'width' => array(
							'values' => false,
							'default' => '1005',
							'desc' => __( 'Carousel width', 'care' )
						),
						'height' => array(
							'values' => false,
							'default' => '130',
							'desc' => __( 'Carousel height', 'care' )
						),
						'items' => array(
							'values' => array(
								'3',
								'4',
								'5',
								'6'
							),
							'default' => '5',
							'desc' => __( 'Number of items in slide', 'care' )
						),
						'speed' => array(
							'values' => false,
							'default' => '600',
							'desc' => __( 'Animation speed (1000 = 1 second)', 'care' )
						),
						'margin' => array(
							'values' => array(
								'0',
								'5',
								'10',
								'15'
							),
							'default' => '10',
							'desc' => __( 'Space between items in pixels', 'care' )
						),
						'num' => array(
							'values' => false,
							'default' => '-1',
							'desc' => __( 'Post count (-1 = all posts)', 'care' )
						),
						'cat' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Category SLUG', 'care' )
						),
						'tag' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Tag SLUG', 'care' )
						),
						'orderby' => array(
							'values' => array(
								'ID',
								'author',
								'title',
								'date',
								'modified',
								'parent',
								'rand',
								'comment_count'	
							),
							'default' => 'date',
							'desc' => __( 'Order by', 'care' )
						),
						'post_type' => array(
							'values' => false,
							'default' => 'post',
							'desc' => __( 'Post type', 'care' )
						),
						'include' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Include (post IDs comma separated)', 'care' )
						),
						'exclude' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Exclude (post IDs comma separated)', 'care' )
						)
					),
					'usage' => '[fp_carousel]',
					'desc' => __( 'Featured post jcarousel slider', 'care' )
				),
				
				# jcarousel
				'jcarousel' => array(
					'name' => 'Image carousel',
					'type' => 'single',
					'atts' => array(
						'width' => array(
							'values' => false,
							'default' => '600',
							'desc' => __( 'Carousel width', 'care' )
						),
						'height' => array(
							'values' => false,
							'default' => '130',
							'desc' => __( 'Carousel height', 'care' )
						),
						'bg' => array(
							'values' => false,
							'default' => '#EEEEEE',
							'desc' => __( 'Carousel background', 'care' ),
							'type' => 'color'
						),
						'items' => array(
							'values' => array(
								'3',
								'4',
								'5'
							),
							'default' => '3',
							'desc' => __( 'Number of items to show', 'care' )
						),
						'margin' => array(
							'values' => array(
								'5',
								'10',
								'15'
							),
							'default' => '10',
							'desc' => __( 'Space between items in pixels', 'care' )
						),
						'link' => array(
							'values' => array(
								'none',
								'file',
								'attachment',
								'caption'
							),
							'default' => 'none',
							'desc' => __( 'Items links', 'care' )
						),
						'speed' => array(
							'values' => false,
							'default' => '400',
							'desc' => __( 'Animation speed (1000 = 1 second)', 'care' )
						),
						'p' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Post/page ID', 'care' )
						)
					),
					'usage' => '[jcarousel]<br/>[jcarousel width="600" height="130" link="file" items="5" bg="#EEEEEE" speed="400"]',
					'desc' => __( 'jCarousel (slider) by attached to post images', 'care' )
				),	
				
				# nivo_slider
				'nivo_slider' => array(
					'name' => 'Nivo slider',
					'type' => 'single',
					'atts' => array(
						'width' => array(
							'values' => false,
							'default' => '600',
							'desc' => __( 'Slider width', 'care' )
						),
						'height' => array(
							'values' => false,
							'default' => '300',
							'desc' => __( 'Slider height', 'care' )
						),
						'link' => array(
							'values' => array(
								'none',
								'file',
								'attachment',
								'caption'
							),
							'default' => 'none',
							'desc' => __( 'Slides links', 'care' )
						),
						'speed' => array(
							'values' => false,
							'default' => '600',
							'desc' => __( 'Animation speed (1000 = 1 second)', 'care' )
						),
						'delay' => array(
							'values' => false,
							'default' => '3000',
							'desc' => __( 'Animation delay (1000 = 1 second)', 'care' )
						),
						'p' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Post/page ID', 'care' )
						),
						'effect' => array(
							'values' => array(
								'random',
								'boxRandom',
								'fold',
								'fade'
							),
							'default' => 'random',
							'desc' => __( 'Animation effect', 'care' )
						)
					),
					'usage' => '[nivo_slider]<br/>[nivo_slider width="600" height="300" link="file" effect="boxRandom"]',
					'desc' => __( 'Nivo slider by attached to post images', 'care' )
				),
			
			# slider shortcodes - end
			'slider-shortcodes-close' => array(
				'type' => 'closegroup'
			),
			
			
			# content shortcodes - start
			'content-shortcodes-open' => array(
				'name' => __( 'Content styling shortcodes', 'shortcodes-ultimate' ),
				'type' => 'opengroup'
			),
			
				# quote
				'quote' => array(
					'name' => 'Quote',
					'type' => 'wrap',
					'atts' => array(
						'style' => array(
							'values' => array(
								'1',
								'2',
								'3'
							),
							'default' => '1',
							'desc' => __( 'Quote style', 'care' )
						)
					),
					'usage' => '[quote style="1"] Content [/quote]',
					'content' => __( 'Quote', 'care' ),
					'desc' => __( 'Blockquote alternative', 'care' )
				),
				# pullquote
				'pullquote' => array(
					'name' => 'Pullquote',
					'type' => 'wrap',
					'atts' => array(
						'align' => array(
							'values' => array(
								'left',
								'right'
							),
							'default' => 'left',
							'desc' => __( 'Pullquote alignment', 'care' )
						)
					),
					'usage' => '[pullquote align="left"] Content [/pullquote]',
					'content' => __( 'Pullquote', 'care' ),
					'desc' => __( 'Styled pullquote', 'care' )
				),
				
				# list
				'list' => array(
					'name' => 'List',
					'type' => 'wrap',
					'atts' => array(
						'style' => array(
							'values' => array(
								'star',
								'arrow',
								'check',
								'cross',
								'thumbs',
								'gear',
								'time',
								'note',
								'plus',
								'guard',
								'event',
								'idea',
								'link',
								'settings',
								'home',
								'phone',
								'email',
								'user',
								'twitter',
								'skype',
								'white-bullet',
								'orange-bullet',
								'black-bullet',
								'red-bullet',
								'yellow-bullet',
								'green-bullet',
								'blue-bullet',
							),
							'default' => 'star',
							'desc' => __( 'List style', 'care' )
						)
					),
					'usage' => '[list style="check"] <ul> <li> List item </li> </ul> [/list]',
					'content' => '<ul><li>' . __( 'List item ', 'care' ) . '</li></ul>',
					'desc' => __( 'Styled unordered list', 'care' )
				),
				
				# label
				'label' => array(
					'name' => 'Label',
					'type' => 'single',
						'atts' => array(
							'title' => array(
								'values' => array( ),
								'default' => __( 'Caption', 'care' ),
								'desc' => __( 'Label caption', 'care' )
							),
							'bg' => array(
								'values' => array( ),
								'default' => '#ff9000',
								'desc' => __( 'Background color', 'care' ),
								'type' => 'color'
							),
							'color' => array(
								'values' => array( ),
								'default' => '#ffffff',
								'desc' => __( 'Text color', 'care' ),
								'type' => 'color'
							)
					),
					'usage' => '[label]',
					'content' => __( 'Label', 'care' ),
					'desc' => __( 'Small caption with background color', 'care' )
				),

				
				# highlight
				'highlight' => array(
					'name' => 'Highlight',
					'type' => 'wrap',
					'atts' => array(
						'bg' => array(
							'values' => array( ),
							'default' => '#DDFF99',
							'desc' => __( 'Background color', 'care' ),
							'type' => 'color'
						),
						'color' => array(
							'values' => array( ),
							'default' => '#000000',
							'desc' => __( 'Text color', 'care' ),
							'type' => 'color'
						)
					),
					'usage' => '[highlight bg="#fc0" color="#000"] Content [/highlight]',
					'content' => __( 'Highlighted text', 'care' ),
					'desc' => __( 'Highlighted text', 'care' )
				),
				
				# dropcap
				'dropcap' => array(
					'name' => 'Dropcap',
					'type' => 'wrap',
					'atts' => array(
						'color' => array(
							'values' => array(
								'black',
								'gray',
								'blue',
								'red',
								'green',
								'yellow',
								'orange',
								'pink-orange',
								'purple'
							),
							'default' => 'black',
							'desc' => __( 'Dropcap color', 'care' )
						)
					),
					'usage' => '[dropcap style=""] [/dropcap]',
					'content' => __( 'Content', 'care' ),
					'desc' => __( 'Styled dropcaps', 'care' )
				),
				
				# frame
				'frame' => array(
					'name' => 'Frame',
					'type' => 'wrap',
					'atts' => array(
						'align' => array(
							'values' => array(
								'left',
								'center',
								'none',
								'right'
							),
							'desc' => __( 'Frame align', 'care' )
						)
					),
					'usage' => '[frame align="center"] <img src="image.jpg" alt="" /> [/frame]',
					'content' => __( 'Image tag', 'care' ),
					'desc' => __( 'Styled image frame', 'care' )
				),	

				# box
				'box' => array(
					'name' => 'Box',
					'type' => 'wrap',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Box title', 'care' ),
							'desc' => __( 'Box title', 'care' )
						),
						'color' => array(
							'values' => array( ),
							'default' => '#333333',
							'desc' => __( 'Box color', 'care' ),
							'type' => 'color'
						)
					),
					'usage' => '[box title="Box title" color="#f00"] Content [/box]',
					'content' => __( 'Box content', 'care' ),
					'desc' => __( 'Colored box with title', 'care' )
				),
				# note
				'note' => array(
					'name' => 'Note',
					'type' => 'wrap',
					'atts' => array(
						'color' => array(
							'values' => array( ),
							'default' => '#FFCC00',
							'desc' => __( 'Note color', 'care' ),
							'type' => 'color'
						)
					),
					'usage' => '[note color="#FFCC00"] Content [/note]',
					'content' => __( 'Note text', 'care' ),
					'desc' => __( 'Colored note box', 'care' )
				),
				# callout
				'callout' => array(
					'name' => 'Call Out',
					'type' => 'wrap',
					'atts' => array(
						'bg' => array(
							'values' => array( ),
							'default' => '#00c5dc',
							'desc' => __( 'Background color', 'care' ),
							'type' => 'color'
						),
						'color' => array(
							'values' => array( ),
							'default' => '#FFFFFF',
							'desc' => __( 'Text color', 'care' ),
							'type' => 'color'
						),
						'padding' => array(
							'values' => array( ),
							'default' => __( '25', 'care' ),
							'desc' => __( 'Padding in px', 'care' )
						)
					),
					'usage' => '[callout color="#FFCC00"] Content [/callout]',
					'content' => __( 'Call out text', 'care' ),
					'desc' => __( 'Call out box', 'care' )
				),			
				# content shortcodes - end
				'content-shortcodes-close' => array(
					'type' => 'closegroup'
				),
				
				# content elements shortcodes - start
				'elements-shortcodes-open' => array(
					'name' => __( 'Content element shortcodes', 'shortcodes-ultimate' ),
					'type' => 'opengroup'
				),
						
				# spoiler
				'spoiler' => array(
					'name' => 'Spoiler',
					'type' => 'wrap',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Spoiler title', 'care' ),
							'desc' => __( 'Spoiler title', 'care' )
						)
					),
					'usage' => '[spoiler title="Spoiler title"] Hidden text [/spoiler]',
					'content' => __( 'Hidden content', 'care' ),
					'desc' => __( 'FAQ / Toggle view content', 'care' )
				),
			
				# staff
				'staff' => array(
					'name' => 'Staff',
					'type' => 'wrap',
					'atts' => array(
						'name' => array(
							'values' => array( ),
							'default' => 'Full Name',
							'desc' => __( 'Full Name', 'care' )
						),				
						'position' => array(
							'values' => array( ),
							'default' => 'Staff',
							'desc' => __( 'Job position', 'care' )
						),
						'img' => array(
							'values' => array( ),
							'default' => '',
							'desc' => __( 'Image url', 'care' )
						)
					),
					
					'usage' => '[staff name="Full Name" position="job position"] Content [/staff]',
					'content' => __( 'Description abaut staff member', 'care' ),
					'desc' => __( 'Information about staff/team members', 'care' )
				),
				
				
				# button
				'button' => array(
					'name' => 'Button',
					'type' => 'wrap',
					'atts' => array(
						'link' => array(
							'values' => array( ),
							'default' => '#',
							'desc' => __( 'Button link', 'care' )
						),
						'color' => array(
							'values' => array( ),
							'default' => '#AAAAAA',
							'desc' => __( 'Button background color', 'care' ),
							'type' => 'color'
						),
						'size' => array(
							'values' => array(
								'1',
								'2',
								'3',
								'4',
								'5',
								'6',
								'7',
								'8',
								'9',
								'10',
								'11',
								'12'
							),
							'default' => '3',
							'desc' => __( 'Button size', 'care' )
						),
						'style' => array(
							'values' => array(
								'1',
								'2',
								'3',
								'4'
							),
							'default' => '1',
							'desc' => __( 'Button background style', 'care' )
						),
						'dark' => array(
							'values' => array(
								'0',
								'1'
							),
							'default' => '0',
							'desc' => __( 'Dark text color', 'care' )
						),
						'square' => array(
							'values' => array(
								'0',
								'1'
							),
							'default' => '0',
							'desc' => __( 'Disable rounded corners', 'care' )
						),
						'icon' => array(
							'values' => array( ),
							'default' => '',
							'desc' => __( 'Button icon', 'care' )
						),
						'class' => array(
							'values' => array( ),
							'default' => '',
							'desc' => __( 'Button class', 'care' )
						),
						'target' => array(
							'values' => array(
								'self',
								'blank'
							),
							'default' => 'self',
							'desc' => __( 'Button link target', 'care' )
						)
					),
					'usage' => '[button link="#" color="#b00" size="3" style="3" dark="1" square="1" icon="image.png"] Button text [/button]',
					'content' => __( 'Button text', 'care' ),
					'desc' => __( 'Styled button', 'care' )
				),
				
				
				# service
				'service' => array(
					'name' => 'Service',
					'type' => 'wrap',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Service title', 'care' ),
							'desc' => __( 'Service title', 'care' )
						),
						'icon' => array(
							'values' => array( ),
							'default' => '',
							'desc' => __( 'Service icon', 'care' )
						),
						'size' => array(
							'values' => array(
								'24',
								'32',
								'48'
							),
							'default' => '32',
							'desc' => __( 'Icon size', 'care' )
						)
					),
					'usage' => '[service title="Service title" icon="service.png" size="32"] Service description [/service]',
					'content' => __( 'Service description', 'care' ),
					'desc' => __( 'Service box with title', 'care' )
				),
				
				# tabs
				'tabs' => array(
					'name' => 'Tabs',
					'type' => 'wrap',
					'atts' => array(
						'style' => array(
							'values' => array(
								'1',
								'2',
								'3'
							),
							'default' => '1',
							'desc' => __( 'Tabs style', 'care' )
						)
					),
					'usage' => '[tabs style="1"] [tab title="Tab name"] Tab content [/tab] [/tabs]',
					'desc' => __( 'Tabs container', 'care' )
				),
				# tab
				'tab' => array(
					'name' => 'Tab',
					'type' => 'wrap',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Title', 'care' ),
							'desc' => __( 'Tab title', 'care' )
						)
					),
					'usage' => '[tabs style="1"] [tab title="Tab name"] Tab content [/tab] [/tabs]',
					'content' => __( 'Tab content', 'care' ),
					'desc' => __( 'Single tab', 'care' )
				),
				
				# pricing box
				'pricing' => array(
					'name' => 'Pricing box',
					'type' => 'wrap',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'This is title', 'care' ),
							'desc' => __( 'Box title', 'care' )
						),
						'currency' => array(
							'values' => array( ),
							'default' => __( '$', 'care' ),
							'desc' => __( 'Offer currency', 'care' )
						),
						'price' => array(
							'values' => array( ),
							'default' => __( '10', 'care' ),
							'desc' => __( 'Offer price', 'care' )
						),
						'period' => array(
							'values' => array( ),
							'default' => __( '/mo', 'care' ),
							'desc' => __( 'Offer period', 'care' )
						),
						'slug' => array(
							'values' => array( ),
							'default' => __( '', 'care' ),
							'desc' => __( 'Slug under price', 'care' )
						),
						'link' => array(
							'values' => array( ),
							'default' => __( '', 'care' ),
							'desc' => __( 'Link to offer page', 'care' )
						),
						'bg' => array(
							'values' => array(
								'yes',
								'no'
							),
							'default' => 'yes',
							'desc' => __( 'Use background', 'care' )
						),
						'color' => array(
							'values' => array( ),
							'default' => '#2b2b2b',
							'desc' => __( 'Background color', 'care' ),
							'type' => 'color'
						),	
						'text' => array(
							'values' => array( ),
							'default' => '#ffffff',
							'desc' => __( 'Text color', 'care' ),
							'type' => 'color'
						)
					),
					'usage' => '[pricing] Content [/pricing]',
					'content' => __( 'Box content', 'care' ),
					'desc' => __( 'Styled pricing boxes', 'care' )
				),
				
				# menu
				'menu' => array(
					'name' => 'Menu',
					'type' => 'single',
					'atts' => array(
						'name' => array(
							'values' => array( ),
							'default' => '',
							'desc' => __( 'Custom menu name', 'care' )
						),
						'style' => array(
							'values' => array(
								'1',
								'2'
							),
							'default' => '1',
							'desc' => __( 'Menu style', 'care' )
						)
					),
					'usage' => '[menu name="Main menu"]',
					'desc' => __( 'Custom menu by name', 'care' )
				),
				# subpages
				'subpages' => array(
					'name' => 'Sub pages',
					'type' => 'single',
					'atts' => array(
						'depth' => array(
							'values' => array(
								'1',
								'2',
								'3'
							),
							'default' => '1',
							'desc' => __( 'Depth level', 'care' )
						),
						'p' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Parent page ID', 'care' )
						)
					),
					'usage' => '[subpages]<br/>[subpages depth="2" p="122"]',
					'desc' => __( 'Page childrens', 'care' )
				),
				# siblings
				'siblings' => array(
					'name' => 'Siblings',
					'type' => 'single',
					'atts' => array(
						'depth' => array(
							'values' => array(
								'1',
								'2',
								'3',
								'4'
							),
							'default' => '1',
							'desc' => __( 'Depth level', 'care' )
						)
					),
					'usage' => '[siblings]<br/>[siblings depth="2"]',
					'desc' => __( 'Page siblings', 'care' )
				),
				
				# bloginfo
				'bloginfo' => array(
					'name' => 'Bloginfo',
					'type' => 'single',
					'atts' => array(
						'option' => array(
							'values' => array(
								'name',
								'description',
								'url',
								'admin_email',
								'charset',
								'version',
								'html_type',
								'text_direction',
								'language',
								'template_url',
								'pingback_url',
								'rss2_url'
							),
							'default' => 'left',
							'desc' => __( 'Option name', 'care' )
						)
					),
					'usage' => '[bloginfo option="name"]',
					'desc' => __( 'Get blog info', 'care' )
				),
				# permalink
				'permalink' => array(
					'name' => 'Permalink',
					'type' => 'mixed',
					'atts' => array(
						'p' => array(
							'values' => array( ),
							'default' => '1',
							'desc' => __( 'Post/page ID', 'care' )
						),
						'target' => array(
							'values' => array(
								'self',
								'blank'
							),
							'default' => 'self',
							'desc' => __( 'Link target', 'care' )
						),
					),
					'usage' => '[permalink p=52]<br/>[permalink p="52" target="blank"] Content [/permalink]',
					'content' => __( 'Permalink text', 'care' ),
					'desc' => __( 'Permalink to specified post/page', 'care' )
				),
				
				# members
				'members' => array(
					'name' => 'Members',
					'type' => 'wrap',
					'atts' => array(
						'style' => array(
							'values' => array(
								'0',
								'1',
								'2'
							),
							'default' => '1',
							'desc' => __( 'Box style', 'care' )
						)
					),
					'usage' => '[members style="2"] Content for logged users [/members]',
					'content' => __( 'Contnt for logged members', 'care' ),
					'desc' => __( 'Content for logged in members only', 'care' )
				),
				
				# private
				'private' => array(
					'name' => 'Private',
					'type' => 'wrap',
					'atts' => array( ),
					'usage' => '[private] Private content [/private]',
					'content' => __( 'Private note text', 'care' ),
					'desc' => __( 'Private note for post authors', 'care' )
				),
				
				# feed
				'feed' => array(
					'name' => 'RSS',
					'type' => 'single',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'desc' => __( 'Feed URL', 'care' )
						),
						'limit' => array(
							'values' => array(
								'1',
								'3',
								'5',
								'7',
								'10'
							),
							'default' => '3',
							'desc' => __( 'Number of item to show', 'care' )
						)
					),
					'usage' => '[feed url="http://rss1.smashingmagazine.com/feed/" limit="5"]',
					'desc' => __( 'Feed grabber', 'care' )
				),		
				
				# media
				'media' => array(
					'name' => 'Media',
					'type' => 'single',
					'atts' => array(
						'url' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Media URL', 'care' )
						),
						'width' => array(
							'values' => false,
							'default' => '600',
							'desc' => __( 'Width', 'care' )
						),
						'height' => array(
							'values' => false,
							'default' => '400',
							'desc' => __( 'Height', 'care' )
						)
					),
					'usage' => '[media url="http://www.youtube.com/watch?v=2c2EEacfC1M"]<br/>[media url="http://vimeo.com/15069551"]<br/>[media url="video.mp4"]<br/>[media url="video.flv"]<br/>[media url="audio.mp3"]<br/>[media url="image.jpg"]',
					'desc' => __( 'YouTube video, Vimeo video, .mp4/.flv video, .mp3 file or images', 'care' )
				),
				# document
				'document' => array(
					'name' => 'Document',
					'type' => 'single',
					'atts' => array(
						'file' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Document URL', 'care' )
						),
						'width' => array(
							'values' => false,
							'default' => '600',
							'desc' => __( 'Width', 'care' )
						),
						'height' => array(
							'values' => false,
							'default' => '400',
							'desc' => __( 'Height', 'care' )
						)
					),
					'usage' => '[document file="file.doc" width="600" height="400"]',
					'desc' => __( '.doc, .xls, .pdf viewer by Google', 'care' )
				),
				
				
				# gmap
				'gmap' => array(
					'name' => 'Gmap',
					'type' => 'single',
					'atts' => array(
						'width' => array(
							'values' => false,
							'default' => '600',
							'desc' => __( 'Width', 'care' )
						),
						'height' => array(
							'values' => false,
							'default' => '400',
							'desc' => __( 'Height', 'care' )
						),
						'address' => array(
							'values' => false,
							'default' => '',
							'desc' => __( 'Marker address', 'care' )
						),
					),
					'usage' => '[gmap width="600" height="400" address="Russia, Moscow"]',
					'desc' => __( 'Maps by Google', 'care' )
				),
				
				
				# content cover
				'cover' => array(
					'name' => 'Content cover',
					'type' => 'wrap',
					'atts' => array(
						'color' => array(
								'values' => array( ),
								'default' => '#f1f1f1',
								'desc' => __( 'Background color', 'care' ),
								'type' => 'color'
							),
						'img' => array(
							'values' => array( ),
							'default' => '',
							'desc' => __( 'Icon or Image', 'care' )
						),
						'bg_pos' => array(
							'values' => array(
								'left top',
								'left center',
								'left bottom',
								'right top',
								'right center',
								'right bottom',
								'center top',
								'center center',
								'center bottom'
							),
							'default' => 'center center',
							'desc' => __( 'Icon or Image position', 'care' )
						)
					),
					'usage' => '[cover color="#f1f1f1; img="#"]Content...[/cover]',
					'content' => __( 'Contnet', 'care' ),
					'desc' => __( 'Custom background and icon over content (on hover reveal)', 'care' )
				),
				
				# ads
				'ad' => array(
					'name' => 'Ad',
					'type' => 'single',
					'atts' => array(
						'id' => array(
							'values' => array( ),
							'default' => __( '', 'care' ),
							'desc' => __( 'ID', 'care' )
						)
					),
					'usage' => '[ad id="100"]',
					'desc' => __( 'Insert ads by ID', 'care' )
				),
			
			
			# content shortcodes - end
			'elements-shortcodes-close' => array(
				'type' => 'closegroup'
			),
			
			# advanced shortcodes - start
			'advanced-shortcodes-open' => array(
				'name' => __( 'Advanced shortcodes', 'shortcodes-ultimate' ),
				'type' => 'opengroup'
			),
			
					# tweets
				'tweets' => array(
					'name' => 'Twitter',
					'type' => 'single',
					'atts' => array(
						'username' => array(
							'values' => array( ),
							'default' => 'twitter',
							'desc' => __( 'Twitter username', 'care' )
						),
						'list' => array(
							'values' => array( ),
							'default' => '',
							'desc' => __( 'Tweets from the list', 'care' )
						),
						'query' => array(
							'values' => array( ),
							'default' => '',
							'desc' => __( 'Tweets from the query', 'care' )
						),
						'limit' => array(
							'values' => array(
								'1',
								'2',
								'3',
								'4',
								'5',
								'6',
								'7',
								'8',
								'9',
								'10'
							),
							'default' => '3',
							'desc' => __( 'Number of tweets to show', 'care' )
						)
					),
					'usage' => '[tweets username="gn_themes" limit="3" style="1" format="teaser"]',
					'desc' => __( 'Get newest tweets', 'care' )
				),
				
				# chart
				'chart' => array(
					'name' => 'Chart',
					'type' => 'single',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => 'Chart title',
							'desc' => __( 'Chart title', 'care' )
						),				
						'data' => array(
							'values' => array( ),
							'default' => '70,25,20.01,4.99',
							'desc' => __( 'Data', 'care' )
						),
						'labels' => array(
							'values' => array( ),
							'default' => 'Reffering+sites|Google|Yahoo|Other',
							'desc' => __( 'Lables', 'care' )
						),
						'colors' => array(
							'values' => array( ),
							'default' => '058DC7,50B432,ED561B,EDEF00',
							'desc' => __( 'Colors', 'care' )
						),
						'size' => array(
							'values' => array( ),
							'default' => '630x250',
							'desc' => __( 'Size', 'care' )
						),
						'advanced' => array(
							'values' => array( ),
							'default' => '&chdl=Reffering+sites|Google|Yahoo|Other',
							'desc' => __( 'Advanced (optional)', 'care' )
						),
						'type' => array(
							'values' => array(
								'xyline',
								'sparkline',
								'scatter',
								'venn',
								'line',
								'pie',
								'pie2d'
							),
							'default' => 'pie2d',
							'desc' => __( 'Chart type', 'care' )
						)
					),
					
					'usage' => '[chart]',
					'desc' => __( 'Google chart', 'care' )
				),
				
				# style div
				'div' => array(
					'name' => 'Div',
					'type' => 'wrap',
					'atts' => array(
						'style' => array(
							'values' => array( ),
							'default' => __( '', 'care' ),
							'desc' => __( 'CSS style', 'care' )
						),
						'class' => array(
							'values' => array( ),
							'default' => __( '', 'care' ),
							'desc' => __( 'Custom div class', 'care' )
						)
					),
					'usage' => '[div style=""] [/div]',
					'content' => __( 'Div content', 'care' ),
					'desc' => __( 'DIV with your custom class or style', 'care' )
				),
				# clear
				'clear' => array(
					'name' => 'Clear',
					'type' => 'single',
					'usage' => '[clear]',
					'desc' => __( 'Clear floats after elements', 'care' )
				),
			
			# advanced shortcodes - end
			'advanced-shortcodes-close' => array(
				'type' => 'closegroup'
			),
			
			
		);

		if ( $shortcode )
			return $shortcodes[$shortcode];
		else
			return $shortcodes;
	}

?>