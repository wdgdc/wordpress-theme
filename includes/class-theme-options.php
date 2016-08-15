<?php

class Theme_Options {
	private static $slug = 'theme-options';
	private static $post_id = 'theme_options';
	private static $location = array();
	private static $sidebars;

	public static function init() {
		self::register_sidebars();
		add_action( 'acf/init', array( __CLASS__, 'register_field_groups' ) );
		add_action( 'acf/update_value/key=theme_sidebars', array( __CLASS__, 'save_sidebars' ), 10, 3 );

		self::$location[] = array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => self::$slug
			)
		);
	}

	public static function register_field_groups() {
		acf_add_options_page( array(
			'page_title' => 'Theme Options',
			'menu_slug' => self::$slug,
			'capability' => 'manage_options',
			'parent_slug' => 'themes.php',
			'post_id' => self::$post_id,
		) );

		acf_add_local_field_group( array(
			'key' => 'theme_options_sidebars',
			'title' => 'Sidebars',
			'fields' => array(
				array(
					'key' => 'theme_sidebars',
					'name' => 'theme_sidebars',
					'label' => 'Additional Sidebars',
					'type' => 'repeater',
					'button_label' => 'Add Sidebar',
					'instructions' => sprintf( 'Add the name of additional sidebars you would like to add to the <a href="%s">widgets page</a>.', admin_url( 'widgets.php' ) ),
					'sub_fields' => array(
						array(
							'key' => 'theme_sidebar_name',
							'name' => 'theme_sidebar_name',
							'label' => 'Name',
							'type' => 'text'
						)
					)
				),
			),
			'location' => self::$location
		));
	}

	public static function save_sidebars( $value, $post_id, $field ) {
		if ( $post_id === self::$post_id ) {
			update_option( '_theme_options_sidebars', $_POST['acf']['theme_sidebars'] );
		}
		return $value;
	}

	public static function register_sidebars() {
		self::get_sidebars();

		if ( is_array( self::$sidebars ) && ! empty( self::$sidebars ) ) {
			foreach( self::$sidebars as $sidebar ) {
				if ( ! empty( $sidebar['theme_sidebar_name'] ) ) {
					Theme::register_sidebar( array(
						'id' => sprintf( 'theme-sidebar-%s', sanitize_title( $sidebar['theme_sidebar_name'] ) ),
						'name' => $sidebar['theme_sidebar_name']
					) );
				}
			}
		}
	}

	public static function get_sidebars() {
		if ( empty( self::$sidebars ) ) {
			self::$sidebars = get_option( '_theme_options_sidebars' );
		}
		return self::$sidebars;
	}
}
