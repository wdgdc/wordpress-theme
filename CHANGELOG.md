# Changelog

## 0.4.0
* __wdg.class.php__ Reorganized WDG class
	* Added `WDG/theme_support` filter in `setup_theme`
	* Added `WDG/content_width` filter in `setup_theme` - default of 800
	* Added autoloading of widgets in `widgets` folder
	* Utility functions
		* Added `get_template_part` function for scoped partials
		* Added `html_attributes` function for properly escaping an array of HTML attributes
		* Added `get_excerpt` function to get the excerpt outside of the loop
		* Added `show_404` function to immediately display the 404 template and send proper headers
* __functions.php__ Added image sizes example
* __wdg.constants.php__ Added new constant `THEME_WIDGETS_PATH`
* Added `templates` folder for WordPress admin-selectable page templates
* CSS - Selected SASS as bundled CSS pre processor
	* Dropped support for Stylus and LESS
	* Added `components`, `mixins`, and `variables` folders for modular styles
	* Added grunt module `grunt-sass-globbing` to concatenate modular styles for simple @include-ing
* __Gruntfile.js__ Default Grunt task is now build, and watch
* __site.js__ `init` and `load` functions run within their own scope
* __header.php__ Dropped support for deprecated Chrome-frame
* Dropped `camelcase` JSLint requirement

## 0.3.0
* Added `Thumbs.db` & `*.log` to `.gitignore`
* Removed Bones & YeoPress mention on theme description
* Removed Suit CSS class names, we won't enforce a CSS naming convention yet
* Move search.php to use the archive.php
* Bugfix: `wdg.constants.php` `THEME_IMG_PATH` is an alias of `THEME_IMAGES_PATH`
* __functions.php__ Added jQuery to the registered scripts
* __comments.php__ Change deprecated `siteurl` keys to `url`
* __bower.json__ Do not enforce that many vendor scripts/styles from the get go
* CSS pre processors are now optional, do not create a stylus directory by default
* Removed `home.js`, let users create these if needed
* Added `partials` & `widgets` directories

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
