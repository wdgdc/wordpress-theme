<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php wp_title( '-', true, 'left' ); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="body-overflow">

<header class="header">
	<div class="wrap">
		<p class="header-logo logo">
			<a href="<?php bloginfo( 'url' ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>
		</p>

		<?php echo Theme::nav( 'primary' ); ?>
		<?php echo Theme::nav( 'utility' ); ?>
	</div>
</header><!-- end .header -->

<div class="main-container">
