<?php

/* Welcome to Bones :)
Thanks to the fantastic work by Bones users, we've now
the ability to translate Bones into different languages.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/



// Adding Translation Option
load_theme_textdomain( 'bonestheme', get_template_directory() .'/library/translation' );



/*********************
GRAVITY FORMS
*********************/
add_action('init', 'gravityforms_language');
function gravityforms_language() {
	$gravityforms_mo = dirname( __FILE__ ) . '/gravityforms-en_US.mo';
	if (file_exists($gravityforms_mo)) {
		load_textdomain('gravityforms', $gravityforms_mo);
	}
}
