<?php

require_once 'includes/wdg.class.php';

Class Theme extends WDG {
	public static function init() {
		// add all filters and actions
		parent::init();

		// add menus
		Theme::register_nav_menu('primary');
		Theme::register_nav_menu('utility');
		Theme::register_nav_menu('footer');

		// add sidebars
		Theme::register_sidebar('sidebar');

		// add styles
		Theme::register_style('site', THEME_CSS_URI . '/site.css');

		// enqueue styles
		Theme::enqueue_style('site');

		// deregister WordPress jQuery
		add_action('wp_enqueue_scripts', function() {
			wp_deregister_script('jquery');
		});

		// add scripts
		Theme::register_script('modernizr', THEME_VENDOR_URI . '/modernizr/modernizr-custom.js', null, null, false);
		Theme::register_script('jquery', THEME_VENDOR_URI . '/jquery/dist/jquery.js');
		Theme::register_script('site', THEME_JS_URI . '/site.js', array('modernizr', 'jquery'));

		// enqueue scripts
		Theme::enqueue_script('site');
	}
}

Theme::init();