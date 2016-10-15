<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="entry-content">
<div class="entry-utility single-entry-utility">
<?php dotted_posted_on(); ?>

<!-- Category -->
<?php if (get_option_tree('hide_category_from_meta', '')) {} else{ ?>
<span class="cat-links">
<img src="<?php  get_stylesheet_directory_uri(); ?>/images/folder-ico.png" />
<?php printf( __( '%2$s', 'care' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
</span>
 <?php } ?> 
<!-- Category END -->

<!-- Comments -->
<?php if (get_option_tree('hide_comments_from_meta', '')) {} else{ ?>
<img src="<?php  get_stylesheet_directory_uri(); ?>/images/comment-ico.png" />
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
<img class="tag_link_img" src="<?php  get_stylesheet_directory_uri(); ?>/images/tag-ico.png" />
<?php the_tags(''); ?>
<?php }} ?> 
<!-- Tags END -->

<?php edit_post_link( __( ' Edit', 'care' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
</div><!-- .entry-utility -->


<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php the_content(); ?>
<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'care' ), 'after' => '</div>' ) ); ?>

<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
<h3 class="authorbox_title">About the author</h3>
<div id="authorarea">
<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'dotted_author_bio_avatar_size', 80 ) ); ?>
<div class="authorinfo">
<span class="authorinfo_title"><?php printf( get_the_author() ); ?></span>
<p><?php the_author_meta( 'description' ); ?></p>
</div>
<div class="clear"></div>
</div>
<?php endif; ?>

</div><!-- #post-## -->

<?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>
</div>