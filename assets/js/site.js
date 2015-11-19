/* global jQuery, _, Modernizr */

(function ($, $window, $document, $body, Site) {

	$.extend(Site, {
		// DOM ready code
		init: function () {

		},

		// window on load code
		load: function () {

		}
	});

	// Make our namespace globally accessible
	window.Site = Site;

	// Run initialization script on DOM ready
	$document.on('ready', Site.init);

	// Defer scripts to window on load event
	$window.on('load', Site.load);

})(jQuery, jQuery(window), jQuery(document), jQuery(document.body), window.Site || {});
//# sourceMappingURL=site.js.map
