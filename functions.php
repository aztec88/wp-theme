<?php

/*  Register Scripts and Style */

function theme_register_scripts() {
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/sass/includes/bootstrap.min.css', array(), '4.1.0', 'all');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/sass/includes/font-awesome.min.css', array(), '4.7.0', 'all');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/sass/includes/swiper.min.css', array(), '4.2.6', 'all');
    wp_enqueue_style( 'theme-css', get_stylesheet_uri() );
    wp_enqueue_script( 'bootstrap-js', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/bootstrap.min.js' ), array(), '4.1.0', true );
    wp_enqueue_script( 'bootstrap-js', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/swiper.min.js' ), array(), '4.2.6', true );
    wp_enqueue_script( 'theme-js', esc_url( trailingslashit( get_template_directory_uri() ) . 'js/theme.min.js' ), array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'theme_register_scripts', 1 );


/* Add menu support */
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
    register_nav_menu('primary', 'Primary Header Navigation');
    register_nav_menu('secondary', 'Secondary Header Navigation');
}

/*
	==========================================
	 Theme support function
	==========================================
*/
add_theme_support('custom-background');
add_theme_support('custom-header');
add_theme_support('post-thumbnails');
// add_theme_support('post-formats',array('aside','image','video'));
add_theme_support('html5', array('search-form'));



/* Add custom thumbnail sizes */
if ( function_exists( 'add_image_size' ) ) {
    //add_image_size( 'custom-image-size', 500, 500, true );
}

/* Add widget support */
// if ( function_exists('register_sidebar') )
//     register_sidebar(array(
//         'name'          => 'SidebarOne',
//         'id'            => 'SidebarOne',
// 	    'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
//         'after_widget'  => '</div>',
//         'before_title'  => '<h4 class="widgettitle">',
//         'after_title'   => '</h4>',
//     ));
    
// if ( function_exists('register_sidebar') )
//     register_sidebar(array(
//         'name'          => 'SidebarTwo',
//         'id'            => 'SidebarTwo',
// 	    'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
//         'after_widget'  => '</div>',
//         'before_title'  => '<h4 class="widgettitle">',
//         'after_title'   => '</h4>',
//     ));

/* Woocommerce theme support */
add_action ('after_setup_theme', 'woocommerce_support');

function woocommerce_support(){
    add_theme_support('woocommerce');
}

/*
	==========================================
	 Post type
	==========================================
*/
// function create_posttype() {
// 	register_post_type( 'promo',
// 	array(
// 	  'labels' => array(
// 		'name' => __( 'Promos' ),
// 		'singular_name' => __( 'Promo' )
// 	  ),
// 	  'public' => true,
// 	  'has_archive' => true,
// 	  'menu_icon' => 'dashicons-images-alt2',
// 	  'rewrite' => array('slug' => 'promo'),
// 	  'supports' => array('title', 'editor', 'thumbnail')
// 	)
//   );
//   register_post_type( 'service',
// 	array(
// 	  'labels' => array(
// 		'name' => __( 'Services' ),
// 		'singular_name' => __( 'Service' )
// 	  ),
// 	  'public' => true,
// 	  'has_archive' => true,
// 	  'menu_icon' => 'dashicons-list-view',
// 	  'rewrite' => array('slug' => 'services'),
// 	  'supports' => array('title', 'editor', 'thumbnail','excerpt','custom-fields')
// 	)
//   );
  
// }
// add_action( 'init', 'create_posttype' );



/*
	==========================================
	 Include Walker file for custom menu
	==========================================
*/
// require get_template_directory() . '/inc/walker.php';

# ---------------------------------------------------
# REMOVE SCREEN READER TEXT FROM POST PAGINATION
# ---------------------------------------------------
function sanitize_pagination($content) {
    // Remove h2 tag
    $content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);
    return $content;
}
 
add_action('navigation_markup_template', 'sanitize_pagination');

# ---------------------------------------------------
# UPLOAD LIMIT
# ---------------------------------------------------

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

//Fix page not found for custom post types
flush_rewrite_rules( false );

/*  EXCERPT 
    Usage:
    
    <?php echo excerpt(100); ?>
*/

function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
    } else {
    $excerpt = implode(" ",$excerpt);
    } 
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

