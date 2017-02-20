<?php

class Theme_Shortcode {
	protected $shortcode = '';
	protected $shortcode_ui = array();

	public function __construct() {
		if ( empty( $this->shortcode ) ) {
			throw new Exception( sprintf( '$this->shortcode must be set in %s', get_called_class() ) );
		}

		add_action( 'init', array( $this, 'add_shortcode' ) );
		add_action( 'register_shortcode_ui', array( $this, 'register_shortcode_ui' ) );
	}

	public function add_shortcode() {
		add_shortcode( $this->shortcode, array( $this, 'shortcode' ) );
	}

	public function shortcode( $atts ) {
	}

	public function register_shortcode_ui() {
		if ( ! empty( $this->shortcode_ui && function_exists( 'shortcode_ui_register_for_shortcode' ) ) ) {
			shortcode_ui_register_for_shortcode( $this->shortcode, $this->shortcode_ui );
		}
	}
}
