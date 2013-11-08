(function($) {

var $window   = $(window);
var $document = $(document);
var $body     = $(document.body);

var Site = window.Site = {
	// initialize the script
	init: function() {

	}
};


// Run initialization script on DOM ready
$document.on('ready', Site.init);

})(jQuery);