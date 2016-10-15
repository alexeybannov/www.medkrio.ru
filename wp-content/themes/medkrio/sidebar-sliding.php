<?php
/**
* The sliding widget areas.
*
*/
?>
<?php
/* The sliding widget area is triggered if any of the areas
	* have widgets. So let's check that first.
	*
	* If none of the sidebars have widgets, then let's bail early.
	*/
if (   ! is_active_sidebar( 'first-sliding-widget-area'  )
		&& ! is_active_sidebar( 'second-sliding-widget-area' )
		&& ! is_active_sidebar( 'third-sliding-widget-area'  )
		&& ! is_active_sidebar( 'fourth-sliding-widget-area' )
		&& ! is_active_sidebar( 'fifth-sliding-widget-area' )
		)
return;
// If we get this far, we have widgets. Let do this.
?>
<div id="sliding-widget-area" >
<?php if ( is_active_sidebar( 'first-sliding-widget-area' ) ) : ?>
<div id="sliding_first" class="widget-area">
<ul class="xoxo">
<?php dynamic_sidebar( 'first-sliding-widget-area' ); ?>
</ul>
</div><!-- #first .widget-area -->
<?php endif; ?>
<?php if ( is_active_sidebar( 'second-sliding-widget-area' ) ) : ?>
<div id="sliding_second" class="widget-area">
<ul class="xoxo">
<?php dynamic_sidebar( 'second-sliding-widget-area' ); ?>
</ul>
</div><!-- #second .widget-area -->
<?php endif; ?>
<?php if ( is_active_sidebar( 'third-sliding-widget-area' ) ) : ?>
<div id="sliding_third" class="widget-area">
<ul class="xoxo">
<?php dynamic_sidebar( 'third-sliding-widget-area' ); ?>
</ul>
</div><!-- #third .widget-area -->
<?php endif; ?>
<?php if ( is_active_sidebar( 'fourth-sliding-widget-area' ) ) : ?>
<div id="sliding_fourth" class="widget-area">
<ul class="xoxo">
<?php dynamic_sidebar( 'fourth-sliding-widget-area' ); ?>
</ul>
</div><!-- #fourth .widget-area -->
<?php endif; ?>
<?php if ( is_active_sidebar( 'fifth-sliding-widget-area' ) ) : ?>
<div id="sliding_fifth" class="widget-area">
<ul class="xoxo">
<?php dynamic_sidebar( 'fifth-sliding-widget-area' ); ?>
</ul>
</div><!-- #fifth .widget-area -->
<?php endif; ?>
</div><!-- #sliding-widget-area -->
