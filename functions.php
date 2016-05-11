<?php

require_once 'includes/wdg.class.php';

class Theme extends WDG {

	public static function init() {
		// add all filters and actions
		parent::init();

		self::setup_actions();
		self::setup_filters();

		// add menus
		self::register_nav_menu( 'primary' );
		self::register_nav_menu( 'utility' );
		self::register_nav_menu( 'footer' );

		// add sidebars
		self::register_sidebar( 'sidebar' );

		// add styles
		self::register_style( 'site', THEME_DIST_URI . '/site.css' );

		// enqueue styles
		self::enqueue_style( 'site' );

		// deregister WordPress jQuery
		add_action( 'wp_enqueue_scripts', function() {
			wp_deregister_script( 'jquery' );
		} );

		// add scripts
		self::register_script( 'modernizr', THEME_VENDOR_URI . '/modernizr/modernizr.min.js', null, null, false );
		self::register_script( 'jquery', THEME_VENDOR_URI . '/jquery/dist/jquery.min.js' );
		self::register_script( 'bows', THEME_VENDOR_URI . '/bows/dist/bows.min.js' );
		self::register_script( 'site', THEME_DIST_URI . '/site.js', array( 'modernizr', 'jquery', 'bows' ) );

		// enqueue scripts
		self::enqueue_script('site');
	}

	public static function setup_actions() {
		// add all actions
	}

	public static function setup_filters() {
		// add all filters
	}
}

Theme::init();
