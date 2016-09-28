<?php

class Theme_Breadcrumb {
	private static function format_item( $post ) {
		return array(
			'title'     => get_the_title( $post->ID ),
			'permalink' => get_the_permalink( $post->ID ),
		);
	}

	public static function get_items() {
		$cache_key = '';
		$items = array();

		// pages
		if ( is_page() && ! is_front_page() ) {
			$post = get_queried_object();
			$cache_key = 'post_' . $post->ID;
			$cache = self::get_cache( $cache_key );

			if ( $cache ) {
				return $cache;
			}

			array_unshift( $items, self::format_item( $post ) );
			while ( $post->post_parent > 0 ) {
				$post = get_post( $post->post_parent );
				array_unshift( $items, self::format_item( $post ) );
			}
		}

		// posts
		if ( is_home() ) {
			$cache_key = 'posts';
			$cache = self::get_cache( $cache_key );

			if ( $cache ) {
				return $cache;
			}
		}

		if ( is_home() || ( is_single() && 'post' === get_queried_object()->post_type ) || is_archive() ) {
			$page_id = get_option( 'page_for_posts' );
			if ( ! empty( $page_id ) ) {
				$page = get_post( $page_id );
				array_unshift( $items, self::format_item( $page ) );
			}
		}

		if ( is_single() ) {
			$post = get_queried_object();
			$cache_key = 'post_' . $post->ID;
			$cache = self::get_cache( $cache_key );

			if ( $cache ) {
				return $cache;
			}

			$items[] = self::format_item( $post );
		}

		// archives
		if ( is_archive() ) {
			$items[] = array( 'title' => __( 'Archive', THEME_TEXT_DOMAIN ) );
		}

		// search
		if ( is_search() ) {
			$items[] = array( 'title' => __( 'Search', THEME_TEXT_DOMAIN ) );
		}

		// front page
		$front_id = get_option( 'page_on_front' );

		if ( ! empty( $front_id ) ) {
			array_unshift( $items, self::format_item( get_post( $front_id ) ) );
		} else {
			array_unshift( $items, array(
				'title'     => get_bloginfo( 'name' ),
				'permalink' => get_bloginfo( 'url' ),
			) );
		}

		if ( ! empty( $cache_key ) ) {
			self::set_cache( $cache_key, $items );
		}

		return $items;
	}

	private static function set_cache( $key, $items ) {
		wp_cache_set( 'breadcrumb__' . $key, $items, 'breadcrumb', DAY_IN_SECONDS );
	}

	private static function get_cache( $key ) {
		return wp_cache_get( 'breadcrumb__' . $key, 'breadcrumb' );
	}
}
