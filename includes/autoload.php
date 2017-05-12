<?php

class Theme_Autoloader {
	public static function autoload( $class_name ) {
		if ( ! class_exists( $class_name ) ) {
			$file_name = 'class-' . str_replace( '_', '-', strtolower( $class_name ) ) . '.php';

			$folder_paths = array(
				THEME_SHORTCODES_PATH . '/',
				THEME_WIDGETS_PATH . '/',
				THEME_INCLUDES_PATH . '/'
			);

			foreach($folder_paths as $path) {
				if ( file_exists( $path . $file_name ) ) {
					require_once( $path . $file_name );
					break;
				}
			}
		}
	}
}

spl_autoload_register( 'Theme_Autoloader::autoload' );
