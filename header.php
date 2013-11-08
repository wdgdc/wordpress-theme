<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php bloginfo('name'); ?> <?php wp_title('&raquo;'); ?></title>
	
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
	<!--[if IE]>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
	<![endif]-->

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script>
		var STYLESHEET_DIRECTORY = '<?php bloginfo('stylesheet_directory'); ?>',
		    VENDOR_DIRECTORY     = '<?php echo get_bloginfo('stylesheet_directory') . '/library/vendor'; ?>';
	</script>

	<?php wp_head(); ?>
</head>

<?php global $body_class; ?>
<body <?php body_class($body_class); ?>>

	<div id="overflow">

		<header id="header" class="clearfix">
			<div class="wrap">
				<?php // only show an <h1> on the homepage and link it if is paginated ?>
				<?php if (is_front_page() && !is_paged()) : ?>
					<h1 id="logo">
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
					<p id="logo">
						<a href="<?php bloginfo('url'); ?>">
							<?php bloginfo('name'); ?>
						</a>
					</p>
				<?php endif; ?>

				<?php bones_main_nav(); ?>
				<?php bones_utility_nav(); ?>
			</div>
		</header>

		<div id="main-container" class="clearfix">
