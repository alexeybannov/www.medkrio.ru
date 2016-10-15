<?php	/* If no posts.	 */ ?>

<?php if ( ! have_posts() ) : ?>
<div id="post-0" class="post not-found">
	<h1 class="post-entry-title"><?php _e( 'Not Found', 'care' ); ?></h1>
	<div class="entry-content">
		<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'care' ); ?></p>
		<?php get_search_form(); ?>
	</div><!-- .entry-content -->
</div><!-- #post-0 -->
<?php endif; ?>

<?php	/* Start the Loop.	 */ ?>

<?php while ( have_posts() ) : the_post();?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'care' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

<div class="entry-utility single-entry-utility">
<?php dotted_posted_on(); ?>

<!-- Category -->
<?php if (get_option_tree('hide_category_from_meta', '')) {} else{ ?>
<span class="cat-links">
<img src="<?php bloginfo('stylesheet_directory'); ?>/images/folder-ico.png" />
<?php printf( __( '%2$s', 'care' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
</span>
 <?php } ?> 
<!-- Category END -->

<!-- Comments -->
<?php if (get_option_tree('hide_comments_from_meta', '')) {} else{ ?>
<img src="<?php bloginfo('stylesheet_directory'); ?>/images/comment-ico.png" />
<?php
$comment = get_option_tree('blog_comment', ''); 
$comments = get_option_tree('blog_comments', ''); 
$leave_comments = get_option_tree('blog_leave', ''); 

if ($comment || $comments || $leave_comments ) { 
echo '<span class="comments-link">'; comments_popup_link( __( ''.$leave_comments.' &nbsp', 'care' ), __( '1 '.$comment.' ', 'care' ), __( '% '.$comments.' ', 'care' ) );  echo'</span>'; 
}
else{
echo '<span class="comments-link">'; comments_popup_link( __( 'Leave a comment ', 'care' ), __( '1 Comment ', 'care' ), __( '% Comments ' , 'care' ) );  echo'</span>';
} ?>
 <?php } ?> 
<!-- Comments END -->

<!-- Tags -->
<?php if (get_option_tree('hide_tags_from_meta', '')) {} else{ if( has_tag() ) { ?>
<img class="tag_link_img" src="<?php bloginfo('stylesheet_directory'); ?>/images/tag-ico.png" />
<?php the_tags(''); ?>
<?php }} ?> 
<!-- Tags END -->

</div><!-- .entry-utility -->

<div class="entry-content">
<?php
$read_more = get_option_tree('blog_read', ''); 
if ($read_more){ the_content( __( $read_more , 'care' ) ); }
else{ the_content( __( 'Read more', 'care' ) ); }?>

<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'care' ), 'after' => '</div>' ) ); ?>

<div class="clear"></div>
</div><!-- .entry-content -->
</div><!-- #post-## -->
<br/>	
<?php comments_template( '', true ); ?>
<?php endwhile; // End the loop. Whew. ?>

<?php // Set pager
if (function_exists('SEO_pager')) {
	SEO_pager();
} else {
	posts_nav_link();
} ?>