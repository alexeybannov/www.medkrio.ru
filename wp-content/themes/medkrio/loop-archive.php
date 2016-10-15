<?php if ( ! have_posts() ) : ?>
<div id="post-0" class="post not-found">
	<div class="entry-content">
		<p><?php $search_no_result = get_option_tree('search_not_found'); 
			if ($search_no_result){ echo $search_no_result; } 
			else { _e( 'Apologies, but no results were found for your request. Perhaps searching will help find a related post.', 'care' ); } ?>
		</p>
		<?php get_search_form(); ?>
	</div><!-- .entry-content -->
</div><!-- #post-0 -->
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><h4><?php the_title(); ?></h4></a>
<div class="recent_post_widget_link_time"><?php the_time('F jS') ?>, <?php the_time('Y') ?> (<?php comments_number(__('No Comments', 'care'), __('1 Comment', 'care'), __('% Comments', 'care')); ?>)</div>
<?php the_excerpt(); ?> 
<?php endwhile; ?>

<?php // Set pager
if (function_exists('SEO_pager')) {
	SEO_pager();
} else {
	posts_nav_link();
} ?>