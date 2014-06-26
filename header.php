<!doctype html>

<!--[if IE 8]><html <?php language_attributes(); ?> class="no-js ie-8 lt-ie9 lt-ie10"><![endif]-->
<!--[if IE 9]><html <?php language_attributes(); ?> class="no-js ie9 lt-ie10"><![endif]-->
<!--[if !IE]> --> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php wp_title('-', true, 'left'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="Overflow">

<header class="Header u-cf">
	<div class="u-wrap">
		<?php // only show an <h1> on the homepage and link it if is paginated ?>
		<?php if (is_front_page() && !is_paged()) : ?>
			<h1 class="Header-logo Logo">
				<?php if (is_front_page() && !is_paged()) : ?>
						<?php bloginfo('name'); ?>
				<?php else : ?>
					<a href="<?php bloginfo('url'); ?>">
						<?php bloginfo('name'); ?>
					</a>
				<?php endif; ?>
			</h1>
		<?php // Show a <p> tag everywhere else ?>
		<?php else: ?>
			<p class="Header-logo Logo">
				<a href="<?php bloginfo('url'); ?>">
					<?php bloginfo('name'); ?>
				</a>
			</p>
		<?php endif; ?>

		<?php echo Theme::nav('primary'); ?>
		<?php echo Theme::nav('utility'); ?>
	</div>
</header><!-- end .Header -->

<div class="MainContainer u-cf">
