<?php

/* Template name: Styleguide */

the_post();
get_header();

?>

<h1><?php the_title(); ?></h1>
<?php the_content(); ?>

<hr>

<?php echo Theme::get_template_part( 'partials/kitchen-sink' ); ?>

<?php

get_footer();
