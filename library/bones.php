<?php

/*********************
LAUNCH BONES
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
*********************/

// we're firing all out initial functions at the start
add_action('after_setup_theme', 'bones_ahoy', 16);

function bones_ahoy() {
	// launching operation cleanup
	add_action( 'init', 'bones_head_cleanup' );
	
	// remove WP version from RSS
	add_filter( 'the_generator', 'bones_rss_version' );
	
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
	
	// clean up comment styles in the head
	add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
	
	// clean up gallery output in wp
	add_filter( 'gallery_style', 'bones_gallery_style' );

	// enqueue base scripts and styles
	add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles' );

	// launching this stuff after theme setup
	bones_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'bones_register_sidebars' );
	
	// adding the bones search form (created in functions.php)
	add_filter( 'get_search_form', 'bones_wpsearch' );

	// cleaning up random code around images
	add_filter( 'the_content', 'bones_filter_ptags_on_images' );
	
	// cleaning up excerpt
	add_filter( 'excerpt_more', 'bones_excerpt_more' );
}



/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function bones_head_cleanup() {
	// category feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	// post and comment feeds
	remove_action( 'wp_head', 'feed_links', 2 );
	
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
}

// remove WP version from RSS
function bones_rss_version() {
	return '';
}

// remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function bones_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function bones_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}



/*********************
SCRIPTS & ENQUEUEING
*********************/

// get last updated timestamp from static files
function get_file_mtime($filepath) {
	$path    = realpath($filepath);
	$version = filemtime($filepath);
	return $version;
}

function bones_scripts_and_styles() {
	if (is_admin()) {
		return;
	}
	
	// call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	global $wp_styles;

	$library_directory = get_stylesheet_directory_uri() . '/library';
	$vendor_directory  = $library_directory . '/vendor';

	// Feature and browser detection libraries
	wp_register_script('console-polyfill', $vendor_directory . '/console-polyfill/index.js', null, '0.1.0', false);
	wp_register_script('modernizr', $vendor_directory . '/modernizr/modernizr.js', null, '2.6.2', false);
	wp_register_script('is-mobile', $vendor_directory . '/isMobile/isMobile.js', null, '0.3.1', false);

	// Live Reload
	wp_register_script('livereload', ':35729/livereload.js?snipver=1', null, null, true);

	// jQuery: full featured framework. DOM traversal & manipulation, event handling, animation and AJAX
	wp_deregister_script('jquery');
	wp_register_script('jquery', $vendor_directory . '/jquery/jquery.js', array('modernizr'), '1.10.2', false);

	// Register theme stylesheets
	wp_register_style('webfonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,300,400,600,700,800');
	wp_register_style('normalize', $vendor_directory . '/normalize-css/normalize.css', null, '2.1.3', 'all');
	
	$mtime = get_file_mtime(get_stylesheet_directory() . '/library/css/site.css');
	wp_register_style('theme-stylesheet', $library_directory . '/css/site.css', array('webfonts', 'normalize'), $mtime, 'all');
	
	$mtime = get_file_mtime(get_stylesheet_directory() . '/library/css/home.css');
	wp_register_style('home', $library_directory . '/css/home.css', array('theme-stylesheet'), $mtime, 'all');

	// Comment reply script for threaded comments
	if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
		wp_enqueue_script('comment-reply');
	}

	// Register scripts.js file in the footer
	$mtime        = get_file_mtime(get_stylesheet_directory() . '/library/js/scripts.js');
	$dependencies = array(
		'console-polyfill',
		'modernizr',
		'is-mobile',
		'jquery'
	);
	
	wp_register_script('theme-scripts', $library_directory . '/js/scripts.js', $dependencies, $mtime, true);

	// Register home.js file in the footer
	$mtime = get_file_mtime(get_stylesheet_directory() . '/library/js/home.js');
	wp_register_script('home', $library_directory . '/js/home.js', array('theme-scripts'), $mtime, true);



	// enqueue console polyfill, avoids JS errors on old browsers
	wp_enqueue_script('console-polyfill');

	// enqueue scripts that add classes to the <html> before stylesheets to avoid multiple renders
	wp_enqueue_script('modernizr');
	wp_enqueue_script('is-mobile');

	// enqueue styles before any other scripts
	wp_enqueue_style('theme-stylesheet');

	// enqueue the rest of the scripts of the site
	wp_enqueue_script('jquery');
	wp_enqueue_script('theme-scripts');

	// enqueue livereload last
	wp_enqueue_script('livereload');
}



/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function bones_theme_support() {
	// wp thumbnails (sizes handled in functions.php)
	// add_theme_support('post-thumbnails');

	// default thumb size
	// set_post_thumbnail_size(125, 125, true);

	// RSS thingy
	add_theme_support('automatic-feed-links');

	// adding post format support
	// add_theme_support('post-formats', array(
	// 	'gallery', // gallery of images
	// 	'video',   // video
	// 	'audio',   // audio
	// ));

	// wp menus
	add_theme_support('menus');

	// registering wp3+ menus
	register_nav_menus(array(
		'main-nav'    => __( 'The main menu', 'bonestheme' ),    // main nav in header
		'utility-nav' => __( 'The utility menu', 'bonestheme' ), // main nav in header
		'footer-nav'  => __( 'The footer menu', 'bonestheme' ), // main nav in header
	));
}



/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function bones_main_nav() {
	echo '<nav id="nav" class="nav"><span class="arrow"></span>';
	wp_nav_menu(array(
		'container'       => false,                  // remove nav container
		'menu_class'      => 'menu clearfix',        // adding custom nav class
		'link_before'     => '<span class="spacer"></span><span class="label">',
		'link_after'      => '</span>',
		'theme_location'  => 'main-nav',             // where it's located in the theme
		'fallback_cb'     => null                    // fallback function
	));
	echo '</nav>';
}

// the utility menu
function bones_utility_nav() {
	wp_nav_menu(array(
		'container'       => 'div',           // nav container
		'container_class' => 'nav',           // class of container (should you choose to use it)
		'container_id'    => 'utility-nav',   // id of container (should you choose to use it)
		'menu_class'      => 'menu clearfix', // adding custom nav class
		'theme_location'  => 'utility-nav',   // where it's located in the theme
		'depth'           => 1,               // limit the depth of the nav
		'fallback_cb'     => null             // fallback function
	));
}

// the utility menu
function bones_footer_nav() {
	wp_nav_menu(array(
		'container'       => 'div',           // nav container
		'container_class' => 'nav',           // class of container (should you choose to use it)
		'container_id'    => 'footer-nav',   // id of container (should you choose to use it)
		'menu_class'      => 'menu clearfix', // adding custom nav class
		'theme_location'  => 'footer-nav',   // where it's located in the theme
		'depth'           => 1,               // limit the depth of the nav
		'fallback_cb'     => null             // fallback function
	));
}



/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using bones_related_posts(); )
function bones_related_posts() {
	global $post;

	echo '<ul id="bones-related-posts">';
	$tags = wp_get_post_tags( $post->ID );
	
	if ($tags) {
		foreach ( $tags as $tag ) { 
			$tag_arr .= $tag->slug . ',';
		}
		
		$args = array(
			'tag'          => $tag_arr,
			'numberposts'  => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);

		$related_posts = get_posts( $args );
		
		if ($related_posts) {
			foreach ( $related_posts as $post ) {
				setup_postdata( $post );
				?>
					<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
				<?php
			}
		} else {
			echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'bonestheme' ) . '</li>';
		}
	}
	wp_reset_query();
	echo '</ul>';
}



/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function bones_page_navi() {
	global $wp_query;
	
	$bignum = 999999999;

	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}
	
	echo '<nav class="pagination">';
	
		echo paginate_links( array(
			'base'      => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format'    => '',
			'current'   => max( 1, get_query_var('paged') ),
			'total'     => $wp_query->max_num_pages,
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
			'type'      => 'list',
			'end_size'  => 3,
			'mid_size'  => 3
		) );
	
	echo '</nav>';
}



/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function bones_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __( 'Read', 'bonestheme' ) . get_the_title($post->ID).'">'. __( 'Read more &raquo;', 'bonestheme' ) .'</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function bones_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) ) {
		return false;
	}
	$link = sprintf(
		'<a class="entry-author-link" href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}



/*********************
URL PERMALINKS
*********************/

// Flush rewrite rules for custom post types
add_action('after_switch_theme', 'bones_flush_rewrite_rules');

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

add_rewrite_rule('humans.txt', 'wp-content/themes/redcross-disaster/humans.txt');