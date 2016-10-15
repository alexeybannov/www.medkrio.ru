<?php
function dotted_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'dotted_remove_recent_comments_style' );

if ( ! function_exists( 'dotted_posted_on' ) ) :

function dotted_posted_on()
{
if (get_option_tree('hide_date_from_meta', '')) {}
else{ $post_date = '<img src="'.get_bloginfo('template_url') . '/images/date-ico.png" /> %2$s';}
if (get_option_tree('hide_author_from_meta', '')) {}
else{ $post_author = '<img src="'.get_bloginfo('template_url') . '/images/author-ico.png" /> %3$s';}
	
	printf( __( $post_date . $post_author , 'care' ),	

	'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),

		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'care' ), get_the_author() ),
			get_the_author()
		)
	);


}
endif;

if ( ! function_exists( 'dotted_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 */
function dotted_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'care' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'care' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'care' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

if ( ! function_exists( 'dotted_comment' ) ) :
		
	/* cancel reply */ 
		function custom_comment_reply2($content_reply) 
		{
		$comment_click_here = get_option_tree('comments_click_here', '');
		if($comment_click_here){
		$content_reply = str_replace('Click here to cancel reply.', $comment_click_here, $content_reply);
		}
		else{
		$content_reply = str_replace('Click here to cancel reply.', 'Click here to cancel reply.', $content_reply);
		}
		return $content_reply;
		}
		add_filter('cancel_comment_reply_link', 'custom_comment_reply2');


		
function dotted_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div class="comment-author vcard">
			<?php echo get_avatar( $comment, $size='60',$default=get_template_directory_uri().'/images/default-avatar.jpg' ); ?> 
		</div><!-- .comment-author .vcard -->
		<div id="comment-<?php comment_ID(); ?>"  class="comment-container">
			<div class="comment_arrow"></div>
			<div class="comment-text">
					<cite class="fn"><?php comment_author_link() ?></cite>
					<span class="comment-meta commentmetadata">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s', 'care' ), get_comment_date() ); ?><?php edit_comment_link( __( '(Edit)', 'care' ), ' ' );
					?>
				</span><!-- .comment-meta .commentmetadata -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
						<?php
						$comment_mod = get_option_tree('comments_moderation', '');
						if($comment_mod){ ?>
							<em class="comment-awaiting-moderation"><?php _e( ''.$comment_mod.'', 'care' ); ?></em>
							<br />
							<?php } else { ?>
							<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'care' ); ?></em>
							<br />
							<?php } ?>
				<?php endif; ?>

				<div class="comment-body"><?php comment_text(); ?></div>
				<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'reply_text' => '&nbsp;',  'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
				<div class="clear"></div>
			</div><!-- .comment-text  -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'care' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'care' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

?>