<?php

class Theme_Attachment {
	public static function get_uri( $id, $image_size = 'full' ) {
		$uri = wp_cache_get( $id . '/' . $image_size, __CLASS__ . '/' . __FUNCTION__ );

		if ( $uri ) {
			return $uri;
		}

		$uri = wp_get_attachment_image_src( $id, $image_size )[0];

		wp_cache_set( $id . '/' . $image_size, $uri, __CLASS__ . '/' . __FUNCTION__ );

		return $uri;
	}

	public static function get_path( $id ) {
		$path = wp_cache_get( $id, __CLASS__ . '/' . __FUNCTION__ );

		if ( $path ) {
			return $path;
		}

		$path = wp_upload_dir()['basedir'] . '/' . wp_get_attachment_metadata( $id )['file'];

		wp_cache_set( $id, $path, __CLASS__ . '/' . __FUNCTION__ );

		return $path;
	}

	public static function get_average_color( $id ) {
		$color = wp_cache_get( $id, __CLASS__ . '/' . __FUNCTION__ );

		if ( $color ) {
			return $color;
		}

		$path = self::get_path( $id );

		if ( ! file_exists( $path ) ) {
			return '';
		}

		$colors = new ColorsOfImage( $path, 25, 3 );
		$color = $colors->getProminentColors()[0];

		wp_cache_set( $id, $color, __CLASS__ . '/' . __FUNCTION__ );

		return $color;
	}
}
