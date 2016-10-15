<?php
/**
* The template for displaying Comments.
*
*/
?> 
<?php if ( ! comments_open() ) : ?> 
<?php // Do nothing!! ?> 
<?php else : ?>

<div id="comments">
<?php if ( post_password_required() ) : ?>
<p class="nopassword">
<?php $pass = get_option_tree('comments_pass', ''); 
if($pass){ echo $pass; } 
else { _e( 'This post is password protected. Enter the password to view any comments.', 'care' );} ?>
</p>
</div><!-- #comments -->
<?php
/* Stop the rest of comments.php from being processed,
		* but don't kill the script entirely -- we still have
		* to fully load the template.
		*/
return;
endif;
?>

<?php
// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
<h3 id="comments-title"><?php
$responce = get_option_tree('comments_responce', ''); 
$responces = get_option_tree('comments_responces', ''); 
if ($responce || $responces){
printf( _n( ''.$responce. '  %2$s', '%1$s '.$responces. '  %2$s', get_comments_number(), 'care' ),
number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
}
else {
printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'care' ),
number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
}
?></h3>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
<div class="navigation">
<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'care' ) ); ?></div>
<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'care' ) ); ?></div>
</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

<ol class="commentlist">
<?php wp_list_comments( array( 'callback' => 'dotted_comment' ) );?>
</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
<div class="navigation">
<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'care' ) ); ?></div>
<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'care' ) ); ?></div>
</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>
<?php endif; // end have_comments() ?>

<?php // Wordpress Coments Form
if ('open' == $post->comment_status) : ?>

<div id="respond">
<h1 class="comment-title">

<?php 
$comments_add = get_option_tree('comments_add', '');
if($comments_add){
comment_form_title($comments_add, 'Reply to %s'); 
}
else{
comment_form_title(__('Add a Comment', 'care' ), __('Reply to %s', 'care' ) ); 
}

?>
</h1>

<div class="comment-cancel"><?php cancel_comment_reply_link(); ?></div><!-- end comment-cancel -->


<?php if ( get_option('comment_registration') && !$user_ID) : ?>
<p><?php _e('You must be logged in to post a comment.', 'care'); ?></p>
<?php else : ?>


<form method="post" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" id="commentform" class="ka-form">
<?php if ($user_ID) : ?>

<p class="logged"><?php $comments_in = get_option_tree('comments_log', '');   if ( $comments_in ) { echo ''.$comments_in.' &nbsp' ; } else { _e('Logged in as ', 'care' ); }?><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php $comments_out = get_option_tree('comments_out', '');   if ( $comments_out ) { echo $comments_out; } else { _e('Log out', 'care' ); }?> &raquo;</a></p>
<?php else : ?>
<p class="comment-input-wrap pad"><label class="comment-label" for="author"><?php $comments_name = get_option_tree('comments_name', '');   if ( $comments_name ) { echo ''.$comments_name.'' ; } else { _e('Name', 'care' ); }?> <span class="mc_required">*</span></label>
<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" class="comment-input" /></p
>
<p class="comment-input-wrap pad"><label class="comment-label" for="email"><?php $comments_email = get_option_tree('comments_email', '');   if ( $comments_email ) { echo ''.$comments_email.'' ; } else { _e('Email', 'care' ); }?>  <span class="mc_required">*</span></label>
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" class="comment-input comment-email" /></p>

<p class="comment-input-wrap"><label  class="comment-label" for="url"><?php $comments_website = get_option_tree('comments_website', '');   if ( $comments_website ) { echo ''.$comments_website.'' ; } else { _e( 'Website', 'care' ); }?></label>
<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" class="comment-input comment-website" /></p>
<?php endif; ?>

<p class="comment-textarea-wrap"><label  class="comment-label" for="comment"><?php $comments_your = get_option_tree('comments_your', '');   if ( $comments_your ) { echo $comments_your; } else { _e('Your Comments', 'care' ); }?></label><textarea name="comment" class="comment-textarea" tabindex="4" rows="9" cols="5" id="comment"></textarea></p>
<p class="form-submit"><input type="submit" value="<?php $comments_button = get_option_tree('comments_button', '');   if ( $comments_button ) { echo $comments_button; } else { _e('Add comment', 'care' ); }?>" id="submit" /><?php comment_id_fields(); ?></p>
<p><?php do_action('comment_form', $post->ID); ?></p>
</form>	
<?php endif; ?>
</div><!--end comment-response-->
<?php endif; ?>

</div><!-- #comments -->
<?php endif; // end ! comments_open() ?>