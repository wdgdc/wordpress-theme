<?php

class Theme_Editor {

	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_filter( 'tiny_mce_before_init', array( __CLASS__, 'tiny_mce_before_init' ), 0 );
	}

	public static function admin_init() {
		// WordPress editor: enqueue editor.css
		add_editor_style( THEME_DIST_URI . '/editor.css' );
		add_filter( 'mce_buttons_2', array( __CLASS__, 'mce_buttons_2' ) );
	}

	// WordPress editor: custom styles dropdown
	// https://codex.wordpress.org/TinyMCE_Custom_Styles
	public static function mce_buttons_2( $buttons ) {
		$format_select = array_shift( $buttons );
		array_unshift( $buttons, 'styleselect' );
		array_unshift( $buttons, $format_select );
		return $buttons;
	}

	private static $style_formats = array();

	// reposition custom styles dropdown on toolbar && add custom styles to dropdown
	// See https://codex.wordpress.org/TinyMCE_Custom_Styles
	public static function tiny_mce_before_init( $init ) {
		$init['style_formats_merge'] = false;
		$init['style_formats'] = '[]';

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

		array_unshift( self::$style_formats, $format_headings );

		$init['style_formats'] = json_encode( self::$style_formats );

		return $init;
	}

}
