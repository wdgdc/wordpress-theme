<?php

class Theme_Taxonomy {
	// Required:
	// $taxonomy
	// $args['labels']['name']
	// $args['labels']['singular_name']
	public static function register( $taxonomy, $object_type, $args = array() ) {
		$labels         = ! empty( $args['labels'] ) ? $args['labels'] : array();
		$args['labels'] = self::default_labels( $taxonomy, $labels );
		register_taxonomy( $taxonomy, $object_type, $args );
	}

	public static function default_labels( $taxonomy, $args = array() ) {
		$humanized = Theme_String::humanize( $taxonomy );
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
			$singular = Theme_String::singularize( $plural );
		}

		$defaults = array(
			'name' => $plural,
			'singular_name' => $singular,
			'all_items' => 'All ' . $plural,
			'edit_item' => 'Edit '. $singular,
			'view_item' => 'View '. $singular,
			'update_item' => 'Update '. $singular,
			'add_new_item' => 'Add New '. $singular,
			'new_item_name' => 'New '. $singular,
			'parent_item' => 'Parent '. $singular,
			'parent_item_colon' => 'Parent ' . $singular . ':',
			'search_items' => 'Search '. $plural,
			'popular_items' => 'Popular '. $plural,
			'separate_items_with_commas' => 'Separate '. $plural . ' with commas',
			'add_or_remove_items' => 'Add or remove '. $plural,
			'choose_from_most_used' => 'Choose from the most used '. $plural,
			'not_found' => 'No '. $plural . ' found',
		);

		return array_merge( $defaults, $args );
	}
}
