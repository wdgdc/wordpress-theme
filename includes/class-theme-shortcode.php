<?php

class Theme_Shortcode {

	/**
	 * the name of the shortcode
	 */
	protected $shortcode = '';

	/**
	 * the shortcode ui syntax - see https://github.com/wp-shortcake/shortcake/wiki/Registering-Shortcode-UI
	 */
	protected $shortcode_ui = array();

	/**
	 * add the shortcode and hook into shortcode ui
	 */
	public function __construct() {
		if ( empty( $this->shortcode ) ) {
			throw new Exception( sprintf( '$this->shortcode must be set in %s', get_called_class() ) );
		}

		add_action( 'init', array( $this, 'add_shortcode' ) );
		add_action( 'register_shortcode_ui', array( $this, 'register_shortcode_ui' ) );
	}

	/**
	 * @action register_shortcode_ui
	 */
	public function add_shortcode() {
		add_shortcode( $this->shortcode, array( $this, 'render' ) );
	}

	/**
	 * the shortcode callback function that looks for the
	 */

	public function render( $atts, $content, $tag ) {
		if ( is_admin() && method_exists( $this, 'shortcode_admin' ) ) {
			$markup = $this->shortcode_admin( $atts, $content, $tag );
			if ( $markup !== false ) {
				return $markup;
			}
		}

		return $this->shortcode( $atts, $content, $tag );
	}

	/**
	 * This method produces the shortcode markup and must be overridden in the child class
	 * @return string
	 */
	protected function shortcode( $atts, $content, $tag ) {
		return '';
	}

	/**
	 * @return false
	 */
	protected function admin_shortcode( $atts, $content, $tag ) {
		return false;
	}

	public function register_shortcode_ui() {
		if ( ! empty( $this->shortcode_ui ) && function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
			shortcode_ui_register_for_shortcode( $this->shortcode, $this->shortcode_ui );
		}
	}
}
