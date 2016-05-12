<?php

class Theme_Breadcrumb {
	private static function format_item( $post ) {
		return array(
			'title'     => get_the_title( $post->ID ),
			'permalink' => get_the_permalink( $post->ID ),
		);
	}

	public static function get_items() {
		$items = array();

		// pages
		if ( is_page() ) {
			$page = get_queried_object();
			array_unshift( $items, self::format_item( $page ) );
			while ( $page->post_parent > 0 ) {
				$page = get_post( $page->post_parent );
				array_unshift( $items, self::format_item( $page ) );
			}
		}

		// posts
		if ( is_home() || is_single() || is_archive() ) {
			$page_id = get_option( 'page_for_posts' );
			if ( ! empty( $page_id ) ) {
				$page = get_post( $page_id );
				array_unshift( $items, self::format_item( $page ) );
			}
		}

		if ( is_single() ) {
			$items[] = self::format_item( get_queried_object() );
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

		return $items;
	}
}
