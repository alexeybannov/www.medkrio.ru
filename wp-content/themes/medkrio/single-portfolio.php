<?php if (get_post_meta($post->ID, 'header_choice_select', true));{ get_header(get_post_meta($post->ID, 'header_choice_select', true)); } ?>
<div id="container_bg">

<div id="content_full">  
<?php if (have_posts ()) : ?>  
<?php while (have_posts ()) : the_post(); ?>  
<div class="entry-content">  
<div <?php post_class(); ?>>  
<?php if (has_post_thumbnail ()) : ?>  
<div class="portfolio_img">  
<?php the_post_thumbnail('portfolio-single', array('title' => "")); ?>  
</div><!--#portfolio_img-->  
<?php endif; ?>  
<?php the_content(); ?>  
 
<?php endwhile; ?>  
<?php endif; ?>  

<div id="portfolio_details">
<?php if ( get_post_meta($post->ID, 'pf_meta_box_text2', true) ) : ?>
<span class="portfolio_detail_title"><?php echo get_post_meta($post->ID, 'pf_meta_box_text', true) ?></span> <?php echo get_post_meta($post->ID, 'pf_meta_box_text2', true) ?></br> 
<?php endif; ?>
<?php if ( get_post_meta($post->ID, 'pf_meta_box_text4', true) ) : ?>
<span class="portfolio_detail_title"><?php echo get_post_meta($post->ID, 'pf_meta_box_text3', true) ?></span> <?php echo get_post_meta($post->ID, 'pf_meta_box_text4', true) ?><br/>
<?php endif; ?>
<?php if ( get_post_meta($post->ID, 'pf_meta_box_text6', true) ) : ?>
<span class="portfolio_detail_title"><?php echo get_post_meta($post->ID, 'pf_meta_box_text5', true) ?></span> <?php echo get_post_meta($post->ID, 'pf_meta_box_text6', true) ?><br/> 
<?php endif; ?> 
</div>
 

</div>  
<div class="back_to_portfolio"><input type="submit" value="<?php $portfolio_back = get_option_tree('port_back', ''); if ( $portfolio_back ) { echo $portfolio_back; } else { _e('Back', 'care' ); } ?>" onClick="history.go(-1)"></div>	  
<div class="clear"></div>

<?php comments_template( '', true ); ?>  
  
</div><!--.entry-content-->  
</div><!--#content_full--> 
</div><!--#container-->  
<?php get_footer(); ?>  
