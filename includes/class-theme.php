<?php

require_once 'theme-constants.php';
require_once 'class-wdg.php';
require_once 'class-theme-attachment.php';
require_once 'class-theme-breadcrumb.php';
require_once 'class-theme-post-type.php';
require_once 'class-theme-string.php';
require_once 'class-theme-svg.php';
require_once 'class-theme-taxonomy.php';
require_once 'class-theme-visual-grid.php';

class Theme extends WDG {
	public static function init() {
		parent::init();

		// setup theme
		self::setup_editor();
		self::setup_styles();
		self::setup_scripts();
		self::setup_menus();
		self::setup_sidebars();
		self::setup_post_types();
		self::setup_taxonomies();
		self::setup_shortcodes();
		self::setup_acf();
		self::setup_cli();

		// custom filters and actions
		self::setup_actions();
		self::setup_filters();
	}

	public static function setup_editor() {
		add_action('admin_init', function() {
			// WordPress editor: enqueue editor.css
			add_editor_style( THEME_DIST_URI . '/editor.css' );

			// WordPress editor: custom styles dropdown
			// https://codex.wordpress.org/TinyMCE_Custom_Styles
			add_filter( 'mce_buttons_2', function ( $buttons ) {
				$format_select = array_shift( $buttons );
				array_unshift( $buttons, 'styleselect' );
				array_unshift( $buttons, $format_select );
				return $buttons;
			});
		});

		// reposition custom styles dropdown on toolbar
		add_filter( 'tiny_mce_before_init', function( $init ) {
			$init['style_formats_merge'] = false;
			$init['style_formats'] = '[]';
			return $init;
		}, 0 );

		// add custom styles to dropdown
		// See https://codex.wordpress.org/TinyMCE_Custom_Styles
		add_filter('tiny_mce_before_init', function( $init ) {
			$style_formats = array();

			$format_headings = array(
				'title' => 'Heading styles',
				'items' => array(),
			);

			foreach ( range( 1, 6 ) as $i ) {
				$format_headings['items'][] = array(
					'title'    => 'Heading ' . $i,
					'selector' => 'h1,h2,h3,h4,h5,h6',
					'classes'  => 'h' . $i,
				);
			}

			$style_formats[] = $format_headings;

			$init['style_formats'] = json_encode( $style_formats );

			return $init;
		});
	}

	public static function setup_styles() {
		// register styles
		self::register_style( 'site', THEME_DIST_URI . '/site.css' );

		// enqueue styles
		self::enqueue_style( 'site' );
	}

	public static function setup_scripts() {
		// deregister WordPress' jQuery
		self::deregister_wordpress_jquery();

		// register scripts
		self::register_script( 'modernizr', THEME_VENDOR_URI . '/modernizr/modernizr.min.js', null, null, false );
		self::register_script( 'jquery', THEME_VENDOR_URI . '/jquery/dist/jquery.min.js' );
		self::register_script( 'bows', THEME_VENDOR_URI . '/bows/dist/bows.min.js' );
		self::register_script( 'site', THEME_DIST_URI . '/site.js', array( 'modernizr', 'jquery', 'bows' ) );
		self::register_script_inline( 'site', 'window.site = new Site();' );

		// enqueue scripts
		self::enqueue_script( 'site' );
	}

	public static function setup_menus() {
		//register menus
		self::register_nav_menu( 'primary' );
		self::register_nav_menu( 'utility' );
		self::register_nav_menu( 'footer' );
	}

	public static function setup_sidebars() {
		//register sidebars
		self::register_sidebar( 'sidebar' );
	}

	public static function setup_post_types() {
		// register post types
		Theme_Post_Type::register( 'custom-post-type' );
	}

	public static function setup_taxonomies() {
		// register taxonomies
		Theme_Taxonomy::register( 'custom-taxonomy', 'custom-post-type' );
	}

	public static function setup_shortcodes() {
		// include and intiialize your short codes w/ shortcake support classes here
		// require_once THEME_INCLUDES_PATH . '/shortcodes/class-theme-example-shortcode.php';
		// new Theme_Example_Shortcode();
	}

	public static function setup_acf() {
		// include and initialize your acf classes here
	}

	public static function setup_cli() {
		if ( ! defined( 'WP_CLI' ) ) {
			return;
		}

		// include and initialize your CLI classes here
	}

	public static function setup_actions() {
		// add all actions
		add_action( 'init', array( 'Theme_Visual_Grid', 'init' ) );
	}

	public static function setup_filters() {
		// add all filters
	}
}
