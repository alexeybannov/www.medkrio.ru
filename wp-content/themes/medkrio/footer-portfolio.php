<div id="bottom_elements_background">
<div id="bottom_elements" class="size-wrap">
<?php get_sidebar('copyright'); ?>
<div id="footer_navigation">
<?php wp_nav_menu( array('theme_location' => 'footer', 'container' => false, 'before' => '/', 'fallback_cb' => false)); ?>  
</div><!--#footer_navigation-->
<div class="clear"></div>
</div><!--#bottom_elements-->
</div><!--#bottom_elements_background-->

<?php if (get_option_tree('disable_sliding_sidebar_opt', '')) {} else { ?>
<div class="sliding_sidebar closed" >  
	<div class="sliding_sidebar_content">
	<a class="handle" href="http://link-for-non-js-users"></a>
	<?php get_sidebar('sliding'); ?>
	</div>
</div>

<script>
	var $j = jQuery.noConflict();
	$j(function(){
	$j('.sliding_sidebar').tabSlideOut({
	pathToTabImage: '<?php echo get_template_directory_uri(); ?>/images/footer_handle.png' });
	});
</script>
<?php }?>	
	 

<?php wp_footer(); ?>
<?php $detect = new Mobile_Detect(); 
	if (!$detect->isMobile() || !get_option_tree('disable_cufon_fonts', '')) { ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/fonts/<?php get_option_tree('choose_cufon_font', '', true); ?>.js"></script>
	<script type="text/javascript">
	Cufon.replace('h1,h2,h3,h4,h5,h6,.recent_post-title, .su-service-title, .lb_heading, .su-heading-shell, .su_au_name, .su-pricing-title, .su-pricing-value', {hover: true });
	</script>
	<script type="text/javascript"> Cufon.now(); </script>
<?php }?>
</body>
</html>