<?php if (get_post_meta($post->ID, 'header_choice_select', true));{ get_header(get_post_meta($post->ID, 'header_choice_select', true)); } ?>
<div id="container_bg">
<?php if (get_option_tree('post_layout_sidebar', '')) { echo '<div id="content_full" >'; } else {echo '<div id="content" class="content_left">
';} ?> 

<?php get_template_part( 'loop', 'single' ); ?>

</div><!-- #content -->
<?php if (get_option_tree('post_layout_sidebar', '')) {} else {echo '<div id="sidebar_right">', get_sidebar() . '</div>';}?>

<div class="clear"></div>
</div><!-- #container -->
<?php get_footer(); ?>
