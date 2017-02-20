<?php

class Theme_String {
	// Credit: http://www.mendoweb.be/blog/php-convert-string-to-camelcase-string/
	public static function camelize( $str, array $noStrip = [] ) {
		if ( ! is_string( $str ) ) {
			return '';
		}

		// non-alpha and non-numeric characters become spaces
		$str = preg_replace( '/[^a-z0-9' . implode( '', $noStrip ) . ']+/i', ' ', $str );
		$str = trim( $str );
		// uppercase the first character of each word
		$str = ucwords( $str );
		$str = str_replace( ' ', '', $str );
		$str = lcfirst( $str );

		return $str;
	}

	public static function classify( $str ) {
		$str = self::camelize( $str );
		$str = ucfirst( $str );

		return $str;
	}

	public static function humanize( $str ) {
		$str = trim( strtolower( $str ) );
		$str = preg_replace( '/[\-\_\.+]/', ' ', $str );
		$str = preg_replace( '/[^a-z0-9\s+]/', '', $str );
		$str = preg_replace( '/\s+/', ' ', $str );
		$str = explode( ' ', $str );
		$str = array_map( 'ucwords', $str );
		return implode( ' ', $str );
	}

	public static function php_classify( $str ) {
		$str = self::humanize( $str );
		$str = preg_replace( '/[\-\ +]/', '_', $str );
		return $str;
	}

	public static function pluralize( $str ) {
		return \Doctrine\Common\Inflector\Inflector::pluralize( $str );
	}

	public static function singularize( $str ) {
		return \Doctrine\Common\Inflector\Inflector::singularize( $str );
	}

	public static function dasherize( $str ) {
		$str = sanitize_title( $str );
		$str = preg_replace( '/[\_\.+]/', '-', $str );
		return $str;
	}
}
