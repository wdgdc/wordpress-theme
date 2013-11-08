(function($) {

var $window   = $(window);
var $document = $(document);
var $body     = $(document.body);

var Home = {
	// initialize the script
	init: function() {
		
	}
};

var Site = window.Site = $.extend({}, window.Site, {
	home: Home
});

// Run initialization script on DOM ready
$document.on('ready', Site.home.init);

})(jQuery);