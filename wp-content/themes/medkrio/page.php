<?php if (get_post_meta($post->ID, 'header_choice_select', true));{ get_header(get_post_meta($post->ID, 'header_choice_select', true)); } ?>
<div id="container_bg">
<div id="content_full" >
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php endwhile; // end of the loop. ?>
<?php get_template_part( 'loop', 'page' ); ?>
<?php SEO_pager() ?> 
</div><!-- #content -->
</div><!-- #container -->
<?php get_footer(); ?>