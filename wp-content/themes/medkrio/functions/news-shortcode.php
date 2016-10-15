<?php
// STYLE 1 *********************************************************************************************************
add_shortcode('display_news_s1', 'be_display_posts_shortcode');
function be_display_posts_shortcode($atts) {

	// Pull in shortcode attributes and set defaults
	extract( shortcode_atts( array(
		'post_type' => 'post',
		'post_parent' => false,
		'id' => false,
		'tag' => '',
		'category' => '',
		'offset' => 0,
		'posts_per_page' => '4',
		'order' => 'DESC',
		'orderby' => 'date',
		'include_date' => false,
		'include_excerpt' => true,
		'excerpt_l' => 16,
		'taxonomy' => false,
		'tax_term' => false,
		'width' => 225,
		'height' => 145,
		'crop' => 1,
		'tax_operator' => 'IN'
	), $atts ) );
	
	// Set up initial query for post
	$args = array(
		'post_type' => explode( ',', $post_type ),
		'tag' => $tag,
		'p' => $id,
		'category_name' => $category,
		'posts_per_page' => $posts_per_page,
		'order' => $order,
		'orderby' => $orderby,
		'offset' => $offset
	);
	

	
	// If Post IDs
	if( $id ) {
		$posts_in = explode( ',', $id );
		$args['post__in'] = $posts_in;
	}
	
	
	// If taxonomy attributes, create a taxonomy query
	if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
	
		// Term string to array
		$tax_term = explode( ', ', $tax_term );
		
		// Validate operator
		if( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) )
			$tax_operator = 'IN';
					
		$tax_args = array(
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $tax_term,
					'operator' => $tax_operator
				)
			)
		);
		$args = array_merge( $args, $tax_args );
	}
	
	// If post parent attribute, set up parent
	if( $post_parent ) {
		if( 'current' == $post_parent ) {
			global $post;
			$post_parent = $post->ID;
		}
		$args['post_parent'] = $post_parent;
	}
	
	
	
	$listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $atts ) );
	$count = 0;
	if ( !$listing->have_posts() )
		return apply_filters ('display_posts_shortcode_no_results', false );
		
	$inner = '';
	while ( $listing->have_posts() ): $listing->the_post(); global $post;
	$count++;
	
	if( $count == 1 ){ 
		$style = ' news-main-post';	
		$word_count = $excerpt_l+6;
	} else {
		$style = ' news-list-posts';
		$word_count = $excerpt_l;
	}
	
	

		$title = '<div class="news-listing-title"><a class="title" href="'. get_permalink() .'">'. get_the_title() .'</a>'. do_shortcode (get_post_meta($post->ID, 'special_note', true)) .'</div>';
		
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		
		if ($count == 1 && has_post_thumbnail() )  $image = '<div class="news-listing-image"><a class="image" href="'. get_permalink() .'"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image_src[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;zc=' . $crop . '&amp;" width="' . $width . '" height="' . $height . '" alt="" /></a></div>';
		else $image = '';
		
		if ($include_date == 'true') $date = '<div class="news-listing-meta"><span class="news-listing-date">'. get_the_date() . '</span><span class="news-listing-comment"><a href="'. get_comments_link() .'">('. get_comments_number() .')</a></span></div>';
		else $date = '';
		
		if ($include_excerpt) $excerpt = '<span class="excerpt">' .excerpt($word_count) . '</span>';
		else $excerpt = '';
		
		if ($count == 1) $full_article = ' <span class="article_link"><a href="'. get_permalink() .'">'. __( 'Full article', 'news' ) .'</a></span>';
		else $full_article = '';
		
		$output = '<div class="news-listing' . $style . '"><div class="news-listing-item">' . $image . $title . $date . $excerpt . $full_article . '<span class="news-listing-seperator"></span></div></div>';
		
		$inner .= apply_filters( 'display_posts_shortcode_output', $output, $atts, $image, $title, $date, $excerpt, $full_article );
	
	endwhile; wp_reset_query();
	
	$open = apply_filters( 'display_posts_shortcode_wrapper_open', '<div class="news-listing-wrapper">' );
	$close = apply_filters( 'display_posts_shortcode_wrapper_close', '<div class="clear"></div></div>' );
	$return = $open . $inner . $close;

	return $return;
}

// STYLE 2 *********************************************************************************************************
add_shortcode('display_news_s2', 'be_display_posts_shortcode2');
function be_display_posts_shortcode2($atts) {

	// Pull in shortcode attributes and set defaults
	extract( shortcode_atts( array(
		'post_type' => 'post',
		'post_parent' => false,
		'id' => false,
		'tag' => '',
		'category' => '',
		'offset' => 0,
		'posts_per_page' => '4',
		'order' => 'DESC',
		'orderby' => 'date',
		'include_date' => false,
		'include_excerpt' => true,
		'excerpt_l' => 30,
		'taxonomy' => false,
		'tax_term' => false,
		'width' => 225,
		'height' => 145,
		'crop' => 1,
		'img_for_all' => false,
		'tax_operator' => 'IN'
	), $atts ) );
	
	// Set up initial query for post
	$args = array(
		'post_type' => explode( ',', $post_type ),
		'tag' => $tag,
		'category_name' => $category,
		'p' => $id,
		'posts_per_page' => $posts_per_page,
		'order' => $order,
		'orderby' => $orderby,
		'offset' => $offset
	);
	

	
	// If Post IDs
	if( $id ) {
		$posts_in = explode( ',', $id );
		$args['post__in'] = $posts_in;
	}
	
	
	// If taxonomy attributes, create a taxonomy query
	if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
	
		// Term string to array
		$tax_term = explode( ', ', $tax_term );
		
		// Validate operator
		if( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) )
			$tax_operator = 'IN';
					
		$tax_args = array(
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $tax_term,
					'operator' => $tax_operator
				)
			)
		);
		$args = array_merge( $args, $tax_args );
	}
	
	// If post parent attribute, set up parent
	if( $post_parent ) {
		if( 'current' == $post_parent ) {
			global $post;
			$post_parent = $post->ID;
		}
		$args['post_parent'] = $post_parent;
	}
	
	
	
	$listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $atts ) );
	$count = 0;
	if ( !$listing->have_posts() )
		return apply_filters ('display_posts_shortcode_no_results', false );
		
	$inner = '';
	while ( $listing->have_posts() ): $listing->the_post(); global $post;
	$count++;
	
	if ($img_for_all == 'true') {
		$fatured_img = has_post_thumbnail();
		if( $count == 1 ){ 
			$style = ' news-list-posts-all news-list-first-post';
		} else {
			$style = ' news-list-posts-all';
		}
	} else {
		$fatured_img = $count == 1 && has_post_thumbnail();
		if( $count == 1 ){ 
			$style = ' news-main-post';	
		} else {
			$style = ' news-list-posts';
		}
	}
	
	
		$title = '<div class="news-listing-title"><a class="title" href="'. get_permalink() .'">'. get_the_title() .'</a>'. do_shortcode (get_post_meta($post->ID, 'special_note', true)) .'</div>';
		
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		
		if ($fatured_img)  $image = '<div class="news-listing-image"><a class="image" href="'. get_permalink() .'"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image_src[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;zc=' . $crop . '&amp;" width="' . $width . '" height="' . $height . '" alt="" /></a></div>';
		else $image = '';
		
		if ($include_date == 'true') $date = '<div class="news-listing-meta"><span class="news-listing-date">'. get_the_date() . '</span><span class="news-listing-comment"><a href="'. get_comments_link() .'">('. get_comments_number() .')</a></span></div>';
		else $date = '';
		
		if ($include_excerpt) $excerpt = '<span class="excerpt">' .excerpt($excerpt_l) . '</span>';
		else $excerpt = '';
		
		if ($count == 1) $full_article = ' <span class="article_link"><a href="'. get_permalink() .'">'. __( 'Full article', 'news' ) .'</a></span><div class="clear"></div>';
		else $full_article = '<div class="clear"></div>';
		
		$output = '<div class="news-listing' . $style . '"><div class="news-listing-item">' . $image . $title . $date . $excerpt . $full_article . '</div></div>';
		
		$inner .= apply_filters( 'display_posts_shortcode_output', $output, $atts, $image, $title, $date, $excerpt, $full_article );
	
	endwhile; wp_reset_query();
	
	$open = apply_filters( 'display_posts_shortcode_wrapper_open', '<div class="news-listing-wrapper-s2">' );
	$close = apply_filters( 'display_posts_shortcode_wrapper_close', '<div class="clear"></div></div>' );
	$return = $open . $inner . $close;

	return $return;
}

// LIST STYLE *********************************************************************************************************
add_shortcode('display_news_s3', 'be_display_posts_shortcode3');
function be_display_posts_shortcode3($atts) {

	// Pull in shortcode attributes and set defaults
	extract( shortcode_atts( array(
		'post_type' => 'post',
		'post_parent' => false,
		'id' => false,
		'tag' => '',
		'category' => '',
		'offset' => 0,
		'posts_per_page' => '4',
		'order' => 'DESC',
		'orderby' => 'date',
		'include_date' => false,
		'include_excerpt' => false,
		'excerpt_l' => 8,
		'taxonomy' => false,
		'tax_term' => false,
		'tax_operator' => 'IN'
	), $atts ) );
	
	// Set up initial query for post
	$args = array(
		'post_type' => explode( ',', $post_type ),
		'tag' => $tag,
		'category_name' => $category,
		'p' => $id,
		'posts_per_page' => $posts_per_page,
		'order' => $order,
		'orderby' => $orderby,
		'offset' => $offset
	);
	

	
	// If Post IDs
	if( $id ) {
		$posts_in = explode( ',', $id );
		$args['post__in'] = $posts_in;
	}
	
	
	// If taxonomy attributes, create a taxonomy query
	if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
	
		// Term string to array
		$tax_term = explode( ', ', $tax_term );
		
		// Validate operator
		if( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) )
			$tax_operator = 'IN';
					
		$tax_args = array(
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $tax_term,
					'operator' => $tax_operator
				)
			)
		);
		$args = array_merge( $args, $tax_args );
	}
	
	// If post parent attribute, set up parent
	if( $post_parent ) {
		if( 'current' == $post_parent ) {
			global $post;
			$post_parent = $post->ID;
		}
		$args['post_parent'] = $post_parent;
	}
	
	
	
	$listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $atts ) );
	$count = 0;
	if ( !$listing->have_posts() )
		return apply_filters ('display_posts_shortcode_no_results', false );
		
	$inner = '';
	while ( $listing->have_posts() ): $listing->the_post(); global $post;
	$count++;
	
	if( $count == 1 ){ 
		$style = ' news-main-post';	
	} else {
		$style = ' news-list-posts';
	}
	
		$title = '<div class="news-listing-title"><a class="title" href="'. get_permalink() .'">'. get_the_title() .'</a></div>';
		
		
		if ($include_date == 'true') $date = ' <div class="news-listing-meta"><span class="news-listing-date">'. get_the_date() . '</span><span class="news-listing-comment"><a href="'. get_comments_link() .'">('. get_comments_number() .')</a></span></div>';
		else $date = '';
		
		if ($include_excerpt == 'true') $excerpt = '<span class="excerpt">' .excerpt($excerpt_l) . '</span>';
		else $excerpt = '';
		
		
		$output = '<div class="news-listing' . $style . '"><div class="news-listing-item">'. $title . $excerpt . $date . '</div></div>';
		
		$inner .= apply_filters( 'display_posts_shortcode_output', $output, $atts, $title, $excerpt, $date );
	
	endwhile; wp_reset_query();
	
	$open = apply_filters( 'display_posts_shortcode_wrapper_open', '<div class="news-listing-wrapper-s3">' );
	$close = apply_filters( 'display_posts_shortcode_wrapper_close', '<div class="clear"></div></div>' );
	$return = $open . $inner . $close;

	return $return;
}

// STYLE 4 *********************************************************************************************************
add_shortcode('display_news_s4', 'be_display_posts_shortcode4');
function be_display_posts_shortcode4($atts) {

	// Pull in shortcode attributes and set defaults
	extract( shortcode_atts( array(
		'post_type' => 'post',
		'post_parent' => false,
		'id' => false,
		'tag' => '',
		'category' => '',
		'offset' => 0,
		'posts_per_page' => '4',
		'order' => 'DESC',
		'orderby' => 'date',
		'include_date' => true,
		'include_excerpt' => true,
		'excerpt_l' => 17,
		'taxonomy' => false,
		'tax_term' => false,
		'width' => 208,
		'height' => 100,
		'crop' => 1,
		'tax_operator' => 'IN'
	), $atts ) );
	
	// Set up initial query for post
	$args = array(
		'post_type' => explode( ',', $post_type ),
		'tag' => $tag,
		'category_name' => $category,
		'p' => $id,
		'posts_per_page' => $posts_per_page,
		'order' => $order,
		'orderby' => $orderby,
		'offset' => $offset
	);
	

	
	// If Post IDs
	if( $id ) {
		$posts_in = explode( ',', $id );
		$args['post__in'] = $posts_in;
	}
	
	
	// If taxonomy attributes, create a taxonomy query
	if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
	
		// Term string to array
		$tax_term = explode( ', ', $tax_term );
		
		// Validate operator
		if( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) )
			$tax_operator = 'IN';
					
		$tax_args = array(
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $tax_term,
					'operator' => $tax_operator
				)
			)
		);
		$args = array_merge( $args, $tax_args );
	}
	
	// If post parent attribute, set up parent
	if( $post_parent ) {
		if( 'current' == $post_parent ) {
			global $post;
			$post_parent = $post->ID;
		}
		$args['post_parent'] = $post_parent;
	}
	
	
	
	$listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $atts ) );
	$count = 0;
	if ( !$listing->have_posts() )
		return apply_filters ('display_posts_shortcode_no_results', false );
		
	$inner = '';
	while ( $listing->have_posts() ): $listing->the_post(); global $post;
	$count++;
	
	if( $count == 1 ){ 
		$style = ' news-main-post';
		$bullet = '';
		$generate_title = '<div class="news-listing-title">'. $bullet .'<a class="title" href="'. get_permalink() .'">'. get_the_title() .'</a>'. do_shortcode (get_post_meta($post->ID, 'special_note', true)) .'</div>';
	} else {
		$style = ' news-list-posts';
		$bullet = '&#8226;';
		$generate_title = '<div class="news-listing-title">'. $bullet .'<a class="title" href="'. get_permalink() .'">'. get_the_title() .'</a></div>';
	}
		
		if ($count == 1) $posted_in = '<div class="news-listing-category">'. get_the_category_list( ', ' ) . ' &raquo;</div>';
		else $posted_in = '';
	
		$title = '<div class="news-listing-title">'. $bullet .'<a class="title" href="'. get_permalink() .'">'. get_the_title() .'</a></div>';
		
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		
		if ($count == 1 && has_post_thumbnail() )  $image = '<div class="news-listing-image"><a class="image" href="'. get_permalink() .'"><img src="' .   get_template_directory_uri()  .'/functions/shortcodes-ultimate/lib/timthumb.php?src=' . $image_src[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;zc=' . $crop . '&amp;" width="' . $width . '" height="' . $height . '" alt="" /></a></div>';
		else $image = '';
		
		if ($count == 1 && $include_date == 'true') $date = ' <div class="news-listing-meta"><span class="news-listing-date">'. get_the_date() . '</span><span class="news-listing-comment"><a href="'. get_comments_link() .'">('. get_comments_number() .')</a></span></div>';
		else $date = '';
		
		if ($count == 1 && $include_excerpt == 'true') $excerpt = '<span class="excerpt">' .excerpt($excerpt_l) . '</span>';
		else $excerpt = '';
		
		$output = '<div class="news-listing' . $style . '">'. $posted_in . $image . $title . $excerpt . $date . '</div>';
		
		$inner .= apply_filters( 'display_posts_shortcode_output', $output, $atts, $posted_in, $image, $title, $excerpt, $date );
	
	endwhile; wp_reset_query();
	
	$open = apply_filters( 'display_posts_shortcode_wrapper_open', '<div class="news-listing-wrapper-s4">' );
	$close = apply_filters( 'display_posts_shortcode_wrapper_close', '</div>' );
	$return = $open . $inner . $close;

	return $return;
}