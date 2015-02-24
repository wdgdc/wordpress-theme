<!doctype html>

<!--[if IE 8]><html <?php language_attributes(); ?> class="no-js ie-8 lt-ie9 lt-ie10"><![endif]-->
<!--[if IE 9]><html <?php language_attributes(); ?> class="no-js ie9 lt-ie10"><![endif]-->
<!--[if !IE]> --> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title('-', true, 'left'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="overflow">

<header class="header">
	<div class="wrap">
		<?php // only show an <h1> on the homepage and link it if is paginated ?>
		<?php if (is_front_page() && !is_paged()) : ?>
			<h1 class="header-logo logo">
				<?php if (is_front_page() && !is_paged()) : ?>
					<span>
						<?php bloginfo('name'); ?>
					</span>
				<?php else : ?>
					<a href="<?php bloginfo('url'); ?>">
						<?php bloginfo('name'); ?>
					</a>
				<?php endif; ?>
			</h1>
		<?php // Show a <p> tag everywhere else ?>
		<?php else: ?>
			<p class="header-logo logo">
				<a href="<?php bloginfo('url'); ?>">
					<?php bloginfo('name'); ?>
				</a>
			</p>
		<?php endif; ?>

		<?php echo Theme::nav('primary'); ?>
		<?php echo Theme::nav('utility'); ?>
	</div>
</header><!-- end .Header -->

<div class="main-container">
