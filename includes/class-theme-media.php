<?php

class Theme_Media {

	// redirect behavior - 404 or image
	const BEHAVIOR = 'file';

	public static function after_setup_theme() {
		add_action( 'template_redirect', array( __CLASS__, 'template_redirect' ) );
	}

	public static function template_redirect() {
		global $wp_query;

		$queried_object = get_queried_object();
		if ( is_attachment() ) {

			switch( self::BEHAVIOR ) {
				case '404':
					status_header(404);
					$wp_query->set_404();
				break;
				case 'file':
					wp_safe_redirect( wp_get_attachment_url( $queried_object->ID ) );
				break;
			}

		}
	}
}