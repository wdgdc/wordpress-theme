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
		Theme::register_style('home', THEME_CSS_URI . '/home.css', array('site'));
		Theme::register_style('print', THEME_CSS_URI . '/home.print.css', array('site'), 1, 'print');
		Theme::register_style('print2', THEME_CSS_URI . '/site.css', array('print'), null, 'print');

		// enqueue styles
		Theme::enqueue_style('site');
		Theme::enqueue_style('print');
		Theme::enqueue_style('print2');
		Theme::enqueue_style('mobile', 9999);

		// add scripts
		Theme::register_script('modernizr', THEME_VENDOR_URI . '/modernizr/modernizr-custom.js', null, null, false);
		Theme::register_script('site', THEME_JS_URI . '/site.js', array('modernizr'));
		Theme::register_script('home', THEME_JS_URI . '/home.js', array('site'));

		// enqueue scripts
		Theme::enqueue_script('site');
	}
}

Theme::init();