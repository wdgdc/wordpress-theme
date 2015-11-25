(function ($, $window, $document, $body, Site, Modernizr, _) {

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

})(window.jQuery, window.jQuery(window), window.jQuery(document), window.jQuery(document.body), window.Site || {}, window.Modernizr, window._);
//# sourceMappingURL=site.js.map
