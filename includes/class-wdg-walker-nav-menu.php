<?php

// Extends default WordPress menu walker and add custom CSS classes
class WDG_Walker_Nav_menu extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$classes = array(
			'nav-menu',
			'nav-menu--depth' . ($depth + 1),
			'sub-menu'
		);

		$classes = apply_filters('WDG/nav_submenu_css_class', $classes, $depth, $args);

		$indent  = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"" . implode(' ', $classes) . "\">\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$item->classes = empty($item->classes) ? array() : (array) $item->classes;

		$classes = array(
			'nav-menu-item',
			'nav-menu-item--depth' . $depth
		);

		if (in_array('menu-item-has-children', $item->classes)) {
			$classes[] = 'nav-menu-item--has-submenu';
		}

		if (in_array('current-menu-item', $item->classes)) {
			$classes[] = 'nav-menu-item--active';
		}

		if (in_array('current-menu-ancestor', $item->classes)) {
			$classes[] = 'nav-menu-item--active-ancestor';
		}

		$item->classes = array_merge($classes, $item->classes);

		parent::start_el($output, $item, $depth, $args, $id);
	}
}
