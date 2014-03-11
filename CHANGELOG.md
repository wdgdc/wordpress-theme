# Changelog

## 0.2.0
* __functions.php__
	* Sidebar name changed from `Sidebar 1` to `Sidebar`
	* New constants: LIBRARY_DIRECTORY, VENDOR_DIRECTORY
	* Moved JavaScript constant definitions inside wp_head() instead of being in the `header.php`
	* New `.Media` class based on `Media object` by [Nicole Sullivan](http://www.stubbornella.org/content/2010/06/25/the-media-object-saves-hundreds-of-lines-of-code/)
	* New `child_excerpt($text = '', $excerpt_length)` PHP function
	* Default oEmbed `$content_width` as `750`
* __header.php__
	* Removed `bloginfo('name')` from `<title>` tag, please use a SEO WordPress plugin
	* Moved JavaScript constants to `functions.php`
* `home.php` has been renamed as `front-page.php`
* New `home.php` template is just an alias for `archive.php`
* New `_percent($number, $container = 1000)` percentage Stylus mixin
* Fix `admin.css` enqueue for WordPress admin panel CSS customization
* __admin.css__
	* Add contrast to the WordPress Admin bar on the new default flat theme for the WordPress admin panel.
* Removed `livereload` scripts, please use the browser extension instead
* New [colors](http://clrs.cc/) variables for Stylus
* Updated Bower dependencies
* Updated NPM dependencies

## 0.1.0
* Initial release
