<?php
/*
Template Name: Left sidebar
*/
?>
<?php if (get_post_meta($post->ID, 'header_choice_select', true));{ get_header(get_post_meta($post->ID, 'header_choice_select', true)); } ?>
<div id="container_bg">
<div id="content" class="content_right">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php endwhile; // end of the loop. ?>
<?php get_template_part( 'loop', 'page' ); ?>
</div><!--#content -->

<div id="sidebar_left">
<?php get_sidebar(); ?>
</div><!--#sidebar_right-->

<div class="clear"></div>

</div><!-- #container -->
<?php get_footer(); ?>