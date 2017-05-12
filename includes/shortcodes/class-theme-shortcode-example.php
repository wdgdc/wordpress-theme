<?php

class Theme_Shortcode_Example extends Theme_Shortcode {

	protected $shortcode = 'example';
	protected $shortcode_ui = array(
		'label' => 'Example Shortcode',
		'listItemImage' => 'dashicons-editor-plugins',
		'attrs' => array(
			array(
				'attr'	 => 'foo',
				'label'	=> 'Foo',
				'type'	 => 'text',
			),
		)
	);

	public function __construct() {
		parent::__construct();
	}

	public function shortcode( $atts, $content, $tag ) {
		return Theme::get_template_part( 'partials/shortcodes/example', $atts );
	}
}
