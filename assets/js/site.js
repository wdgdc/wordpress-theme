/* global jQuery, Modernizr */

(function($, $window, $document, $body, Site) {

$.extend(Site, {
	// DOM ready code
	init: function() {
	},

	// window on load code
	load: function() {
	}
});

// Make our namespace globally accessible
window.Site = Site;

// Run initialization script on DOM ready
$document.on('ready', function ( ) {
	Site.init();
});

// Defer scripts to window on load event
$window.on('load', function ( ) {
	Site.load();
});

})(jQuery, jQuery(window), jQuery(document), jQuery(document.body), window.Site || {});