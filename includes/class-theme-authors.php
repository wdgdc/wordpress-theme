<?php

class Theme_Authors {

	const TAXONOMY = 'authors';

	public static function after_setup_theme() {
		Theme_Taxonomy::register( self::TAXONOMY, 'post', [
			'hierarchical' => true,
			'rewrite' => [
				'with_front' => false,
			],
		] );

		add_filter( 'rewrite_rules_array', [ __CLASS__, 'rewrite_rules_array' ] );

		if ( ! is_admin() ) {
			add_filter( 'the_author', [__CLASS__, 'the_author' ] );
			add_filter( 'get_the_author_user_url', [ __CLASS__, 'get_the_author_user_url' ], 10, 3 );
			add_action( 'admin_head', [ __CLASS__, 'admin_head' ] );
		}
	}

	public static function the_author( $author ) {
		return self::get_the_author();
	}

	public static function get_the_author( $post_id = null, $link = false ) {
		$authors = self::get_authors( $post_id );

		if ( ! empty( $authors ) ) {
			if ( $link ) {
				return implode(', ', array_map(array(__CLASS__, 'link_the_author'), $authors));
			}

			return implode(', ', wp_list_pluck( $authors, 'name' ));
		}

		return '';
	}

	public static function get_authors( $post_id ) {
		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		return (array) get_the_terms( $post_id, self::TAXONOMY );
	}

	public static function link_the_author( $author ) {
		return ( $author instanceof WP_Term ) ? sprintf('<a href="%s">%s</a>', get_term_link( $author->term_id , self::TAXONOMY ), $author->name ) : '';
	}

	public static function admin_head() {
		$screen = get_current_screen();
		if ( $screen->id === 'edit-authors' ) {
			add_filter( 'gettext', array( __CLASS__, 'gettext' ), 10, 3 );
		}
	}

	public static function gettext( $translation, $text, $domain ) {
		switch($text) {
			case 'The description is not prominent by default; however, some themes may show it.':
				$translation = 'Enter a short description of the author here. (Optional)';
			break;
			// case 'The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.':
			// 	$translation = '';
			// break;
			case 'The name is how it appears on your site.':
				$translation = 'Enter the name of the author.';
			break;

		}
		return $translation;
	}

	public static function rewrite_rules_array( $rules ) {
		$unnecessary_rules = [];

		// @see wp-includes/rewrite.php:generate_rewrite_rules()
		foreach ( $rules as $key => $value ) {
			if ( strpos( $value, '?author_name' ) !== false ) {
				$unnecessary_rules[] = $key;
			}
		}

		$rules = array_diff_key($rules, array_flip($unnecessary_rules));

		return $rules;
	}
}
