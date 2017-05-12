<?php

class Theme extends WDG {
	public static function init() {
		parent::init();

		// setup admin
		if ( is_admin() ) {
			self::setup_admin_styles();
			self::setup_editor();
			self::setup_fields();
		}

		// setup theme
		self::setup_image_sizes();
		self::setup_styles();
		self::setup_scripts();
		self::setup_menus();
		self::setup_sidebars();
		self::setup_post_types();
		self::setup_taxonomies();
		self::setup_shortcodes();
		self::setup_widgets();
		self::setup_api();
		self::setup_cli();
		self::setup_yoast_seo();

		// custom filters and actions
		self::setup_actions();
		self::setup_filters();
	}

	public static function setup_editor() {
		Theme_Editor::init();
	}

	public static function setup_image_sizes() {
	}

	public static function setup_admin_styles() {
		// handle admin styles
		add_action( 'admin_enqueue_scripts', function() {
			wp_enqueue_style( 'admin', THEME_DIST_URI . '/admin.css', false, self::filemtime( THEME_DIST_PATH . '/admin.css' ) );
		} );
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
		self::register_script_inline( 'site', 'window.site = new Site.default();' );

		// enqueue scripts
		self::enqueue_script( 'site' );
	}

	public static function setup_menus() {
		// register menus
		self::register_nav_menu( 'primary' );
		self::register_nav_menu( 'utility' );
		self::register_nav_menu( 'footer' );
	}

	public static function setup_sidebars() {
		// register sidebars
		self::register_sidebar( 'sidebar' );
	}

	public static function setup_post_types() {
		// register post types
		// Theme_Post_Type::register( 'custom-post-type' );
	}

	public static function setup_taxonomies() {
		// register taxonomies
		// Theme_Taxonomy::register( 'custom-taxonomy', 'custom-post-type' );
	}

	public static function setup_shortcodes() {
		// intiialize your short codes w/ shortcake support classes here
		// any file inside the shortcodes folder that matches class-theme-shortcode-name.php will be autoloaded
		// example new Theme_Shortcode_Example(); will autoload theme-path/includes/shortcodes/class-theme-shortcode-example.php

		// new Theme_Shortcode_Example();
	}

	public static function setup_widgets() {
		// include and intiialize your widget classes here
	}

	public static function setup_fields() {
		// include and initialize your custom fields classes here
	}

	public static function setup_api() {
		// include and initialize your WP API classes here
	}

	public static function setup_cli() {
		if ( ! defined( 'WP_CLI' ) ) {
			return;
		}

		// include and initialize your CLI classes here
	}

	// move Yoast SEO plugin's metabox to the end of the edit post screen
	public static function setup_yoast_seo() {
		add_filter( 'wpseo_metabox_prio', function() {
			return 'low';
		} );
	}

	public static function setup_actions() {
		// add all actions
		add_action( 'init', array( 'Theme_Visual_Grid', 'init' ) );
		add_action( 'after_setup_theme', array( 'Theme_Authors', 'after_setup_theme' ) );
	}

	public static function setup_filters() {
		// add all filters
	}
}
