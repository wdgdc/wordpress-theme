<?php

/*
Template Name: Front Page
*/

get_header();
echo Theme::get_template_part( 'partials/kitchen-sink' );
get_sidebar();
get_footer();
