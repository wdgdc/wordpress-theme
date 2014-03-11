<?php

// LIBRARY & VENDOR DIRECTORY CONSTANTS

define('LIBRARY_DIRECTORY', get_stylesheet_directory_uri() . '/library');
define('VENDOR_DIRECTORY', LIBRARY_DIRECTORY . '/vendor');

add_action('wp_head', function() {
?>
	<script>
		var ROOT_DIRECTORY       = '<?php bloginfo('url'); ?>',
		    STYLESHEET_DIRECTORY = '<?php bloginfo('stylesheet_directory'); ?>',
		    LIBRARY_DIRECTORY    = '<?php bloginfo('stylesheet_directory'); ?>/library',
		    VENDOR_DIRECTORY     = '<?php bloginfo('stylesheet_directory'); ?>/library/vendor',
		    AJAX_URL             = '<?php echo admin_url('admin-ajax.php'); ?>',
		    ajaxurl              = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
<?php
}, 1);

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once( 'library/bones.php' );

/*
2. library/custom-post-type.php
*/
//require_once( 'library/custom-post-type.php' );

/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
require_once( 'library/admin.php' );

/*
4. library/translation/translation.php
	- adding support for other languages
*/
require_once( 'library/translation/translation.php' );



/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );



/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id'            => 'sidebar',
		'name'          => __( 'Sidebar', 'bonestheme' ),
		'description'   => __( 'The sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>',
	));
}



/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
		<li <?php comment_class(); ?>>
			<article id="comment-<?php comment_ID(); ?>" class="clearfix">
				<header class="comment-author vcard Media clearfix">
					<?php
					/*
						this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
						echo get_avatar($comment,$size='32',$default='<path_to_url>' );
					*/
					?>
					<!-- custom gravatar call -->
					<?php
						// create variable
						$bgauthemail = get_comment_author_email();
					?>
					<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=32" class="load-gravatar avatar avatar-48 photo Media-left" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
					<!-- end custom gravatar call -->
					<div class="Media-body">
						<?php printf(__( '<cite class="fn">%s</cite>', 'bonestheme' ), get_comment_author_link()) ?>
						<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>
						<?php edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ?>
					</div>
				</header>
				<?php if ($comment->comment_approved == '0') : ?>
					<div class="alert alert-info">
						<p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
					</div>
				<?php endif; ?>
				<section class="comment_content clearfix">
					<?php comment_text() ?>
				</section>
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</article>
		<!-- </li> is added by WordPress automatically -->
	<?php
}



/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'bonestheme' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'bonestheme' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
} // don't remove this bracket!


// Excerpt customization
function child_excerpt($text = '', $excerpt_length = 55) {
	if ( is_int($text) ) {
		$excerpt_length = $text;
		$text           = '';
	}

	$raw_excerpt = $text;

	if ( $text == '' )
		$text = get_the_content('');

	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);

	$text = wp_trim_words( $text, $excerpt_length, '' );

	if ( in_array( substr($text, -1), array(',', '.') ) ) {
		$text = substr($text, 0, -1);
	}

	$text .= apply_filters('excerpt_more', '...');
	$text = apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
	$text = apply_filters('the_excerpt', $text);

	return $text;
}


/************* POST CLASS NAMES *****************/

// Add .entry class name to all post_types
add_filter('post_class', function($classes) {
	$classes[] = 'entry';
	return $classes;
}, null, 1);

// Add class names on Previous and Next Posts links
add_filter('previous_posts_link_attributes', function() {
	return 'class="previous-posts-link posts-link"';
});

add_filter('next_posts_link_attributes', function() {
	return 'class="next-posts-link posts-link"';
});



if (!isset( $content_width)) {
	$content_width = 750;
}