<?php get_header(); ?>
<div id="container_bg">
<div id="content_full" >

<div id="post-0" class="post error404_content not-found hentry">
<img src="<?php bloginfo('stylesheet_directory') ?>/images/404.png" class="image404" alt="" />

<p><?php $message_404 = get_option_tree('message_404', '', true); 
if ($message_404){ $message_404; }
else{ _e('The page you were looking for doesn\'t exist.', 'care'); }?></p>
<?php get_search_form(); ?>
</div><!-- #content -->
</div><!-- #content -->

<div class="clear"></div>
<div id="content_box_shadow"></div>

</div><!-- #container -->

<script type="text/javascript">
// focus on search field after it has loaded
document.getElementById('s') && document.getElementById('s').focus();
</script>
<?php get_footer(); ?>