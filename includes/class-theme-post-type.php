<?php

class Theme_Post_Type {
	// Required:
	// $post_type
	// $args['labels']['name']
	// $args['labels']['singular_name']
	public static function register( $post_type, $args = array() ) {
		$labels = ! empty( $args['labels'] ) ? $args['labels'] : array();
		$defaults = array(
			'public' => true,
		);

		$new_args = array_merge( $defaults, $args );
		$new_args['labels'] = self::default_labels( $post_type, $labels );

		register_post_type( $post_type, $new_args );
	}

	public static function default_labels( $post_type, $args = array() ) {
		$humanized = Theme_String::humanize( $post_type );
		$plural    = '';
		$singular  = '';

		if ( ! empty( $args['name'] ) ) {
			$plural = trim( $args['name'] );
		} else {
			$plural = ucfirst( Theme_String::pluralize( $humanized ) );
		}

		if ( ! empty( $args['singular_name'] ) ) {
			$singular = $args['singular_name'];
		} else {
			$singular = ucfirst( Theme_String::singularize( $plural ) );
		}

		$defaults = array(
			'name' => $plural,
			'singular_name' => $singular,
			'add_new' => 'Add New',
			'add_new_item' => 'Add New '. $singular,
			'edit_item' => 'Edit '. $singular,
			'new_item' => 'New '. $singular,
			'view_item' => 'View '. $singular,
			'search_items' => 'Search '. $plural,
			'not_found' => 'No '. $plural . ' found',
			'not_found_in_trash' => 'No '. $plural . ' found in Trash',
			'parent_item_colon' => 'Parent ' . $singular . ':',
			'all_items' => 'All ' . $plural,
			'archives' => $singular . ' Archives',
			'insert_into_item' => 'Insert into ' . $singular,
			'uploaded_to_this_item' => 'Uploaded to this ' . $singular,
		);

		return array_merge( $defaults, $args );
	}
}
