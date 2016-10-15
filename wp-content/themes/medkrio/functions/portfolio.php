<?php
/*	
*	---------------------------------------------------------------------
*	Add custom post type for portfolio
*	--------------------------------------------------------------------- 
*/

// Define portfolio thumbnail sizes
add_image_size('portfolio', 418, 230, true);
add_image_size('portfolio-two', 459, 250, true);
add_image_size('portfolio-three', 293, 250, true);
add_image_size('portfolio-four', 210, 210, true);
add_image_size('portfolio-single', 946, 0, false);


 
// Register portfolio post type
add_action( 'init', 'register_cpt_portfolio' );

function register_cpt_portfolio() {

    $labels = array( 
        'name' => _x( 'Portfolio Items', 'portfolio' ),
        'singular_name' => _x( 'Portfolio Items', 'portfolio' ),
        'add_new' => _x( 'Add New', 'portfolio' ),
        'add_new_item' => _x( 'Add New Item', 'portfolio' ),
        'edit_item' => _x( 'Edit Item', 'portfolio' ),
        'new_item' => _x( 'New Portfolio Item', 'portfolio' ),
        'view_item' => _x( 'View Item', 'portfolio' ),
        'search_items' => _x( 'Search in Portfolio', 'portfolio' ),
        'not_found' => _x( 'No portfolio found', 'portfolio' ),
        'not_found_in_trash' => _x( 'No Items found in Trash', 'portfolio' ),
        'parent_item_colon' => _x( 'Parent Portfolio:', 'portfolio' ),
        'menu_name' => _x( 'Portfolio', 'portfolio' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
		'menu_icon' => MNKY_PATH . '/images/portfolio_pt.png',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'portfolio', $args );
}

// Register custom taxonomie
add_action( 'init', 'create_portfolio_taxonomies', 0 );

function create_portfolio_taxonomies() 
{
// Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Category', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'all_items' => __( 'All Categories' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ), 
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Categories' ),
  ); 	

  register_taxonomy('portfolio-category',array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'category' ),
  ));  
}

// Custom portfolio column
add_filter('manage_edit-portfolio_columns', 'add_new_portfolio_columns');

function add_new_portfolio_columns($gallery_columns) {
	$new_columns['cb'] = '<input type="checkbox" />';
 
	$new_columns['thumbnail'] = __('Thumbnail');
	$new_columns['title'] = _x('Title', 'column name');
	$new_columns['author'] = __('Author');
 
	$new_columns['portfolio_categories'] = __('Categories');
 
	$new_columns['date'] = _x('Date', 'column name');
	 
	return $new_columns;
}

add_action('manage_portfolio_posts_custom_column', 'manage_portfolio_columns', 10, 2);
 
function manage_portfolio_columns($column_name) {
	global $post;
	switch ($column_name) {
	
	case 'thumbnail':
		echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
	break;
	
	case 'portfolio_categories':
		$terms = wp_get_post_terms($post->ID, 'portfolio-category');  
		foreach ($terms as $term) {  
			echo $term->name .'&nbsp;&nbsp; ';  
		}  
	break;
	
	} // end switch
}	

?>