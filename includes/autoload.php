<?php

class Theme_Autoloader {
	public static function autoload( $class_name ) {
		if ( ! class_exists( $class_name ) ) {
			$class_file = THEME_INCLUDES_PATH . '/class-' . str_replace( '_', '-', strtolower( $class_name ) ) . '.php';
			if ( file_exists($class_file ) ) {
				require_once $class_file;
			}
		}
	}
}

spl_autoload_register( 'Theme_Autoloader::autoload' );
