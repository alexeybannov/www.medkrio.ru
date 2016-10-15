<?php get_header(); ?>
<div id="container_bg">
<div id="content" class="left" >
<?php get_template_part( 'loop', 'archive' ); ?>
</div><!-- #content -->
<div id="sidebar_right">
<?php get_sidebar(); ?>
</div><!--#sidebar_right-->

<div class="clear"></div>
</div><!-- #container -->
<?php get_footer(); ?>