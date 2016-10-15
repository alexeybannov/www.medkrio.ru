<div id="primary" class="widget-area">
<ul class="xoxo">

<?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>
<li id="search" class="widget-container widget_search">
			<h3 class="widget-title"><?php _e( 'Search', 'care' ); ?></h3>
				<?php get_search_form(); ?>
			</li>

<?php endif; // end primary widget area ?>
</ul>
</div><!-- #primary .widget-area -->