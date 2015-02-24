# WDG Starter WordPress Theme

This is a very opinionated base theme for WordPress, build from several iterations of our themes on production.

It comes with [Bower](http://bower.io/) and [Grunt](http://gruntjs.com/) support by default, it was heavily inspired in [YeoPress](https://github.com/wesleytodd/YeoPress)' [default theme](https://github.com/wesleytodd/YeoPress/tree/template) configuration file.

## Directory structure

**All static assets**, like stylesheets, JavaScript files and images should go in the `/assets` directory. All 3rd party frameworks and plugins should go in the `/assets/vendor` directory -  we recommend using Bower for installing and updating them.

**SASS** is encouraged in development, use Grunt to build CSS files. Use components, mixins and variables folders to build modular CSS.

**All PHP scripts** that aren't templates should go in `/includes`. Eg. `/includes/wdg.class.php`

**Translation files** should live in the `/languages` directory.

`node_modules` is where all **Node.js packaged modules** will be stored to be used in the Build process with Grunt. This directory is excluded from the Git repo by default. We'd recommend to keep it this way. The contents of this directory are ignored on Git by default.

`partials` is where all the template parts live.

`templates` is where all user-selectable page templates live. E.g. "/* Template Name: XXX */"

`tests` include **unit testing** for our main PHP scripts (and possibly Front-End tests?). We encourage you to write all sort of tests for your theme here, feel free to use your favorite testing framework.

`widgets` is where all WordPress widgets code is available. Each PHP file in this directory will be included on **widget_init**.


```
wdg-wordpress-theme
├─┬ assets
│ ├── css
│ ├── fonts
│ ├── img
│ ├── js
│ ├── sass
│ └── vendor
├── includes
├── languages
├── node_modules
├── partials
├── templates
├── tests
└── widgets
```

## Vendor assets with [_Bower_](http://bower.io/)

3rd party vendor files live in `/assets/vendor`, they can be either stylesheets, JavaScript, images or any kind of helper, snippet, library or framework that isn't theme related. Eg. Modernizr, jQuery, Normalize.css, Font Awesome.

We encourage the use of [Bower](http://bower.io/) a package and dependencies manager for front-end assets.

In case the script you are looking for isn't available through Bower, feel free to download it and copy it in the vendor directory - preferably in its own directory.

### Default assets
We install the following components by default:

* [console-polyfill](https://github.com/paulmillr/console-polyfill)
* [jquery](https://github.com/jquery/jquery)
* [modernizr](https://github.com/Modernizr/Modernizr)

### Searching for a package
[Bower packages repository](http://bower.io/search/)

### Installing a package

Use the command line to get to root of the repo and run the following command to download and copy the assets to `/assets/vendor` and save its name and version on the `/bower.json` file.

```
$ bower install --save modernizr
```

### Uninstalling a package

The following command will remove the files from `/assets/vendor`

```
$ bower uninstall modernizr
```

## Build process with [_Grunt_](http://gruntjs.com/)

### Installing

Use the command line to get to the root of the repo and run the following command to install node modules, including Grunt.

```
$ npm install
```

#### Default task: build, watch

This is the default task, it does a full build then constantly looks for file changes in the directory theme. Once found, it will apply the specific `build` task based on it's file type.
There is a [LiveReload](http://livereload.com/) support, so your browser tab should be updated automatically after compilation as long as you have the [browser extension enabled](http://feedback.livereload.com/knowledgebase/articles/86242-how-do-i-install-and-use-the-browser-extensions-).

```
$ grunt watch
```

Most of the time you will want to run the default task by simply using the command `grunt` in your root directory.

```
$ grunt
```

#### Build
This set of tasks will be executed based on the file type in the following order:

1. Compiles any CSS Pre-processors and exports it to `/assets/css`
2. Scans all CSS files and adds Browser vendor prefixes with [Autoprefixer](https://github.com/ai/autoprefixer) [grunt-autoprefixer](https://github.com/nDmitry/grunt-autoprefixer)
3. Lints all JavaScript files with [JSHint](http://www.jshint.com/about/) [grunt-contrib-jshint](https://github.com/gruntjs/grunt-contrib-jshint)
4. Scans all compiled CSS and JavaScript files for references of [Modernizr](https://github.com/Modernizr/Modernizr)'s CSS class names or JavaScript methods to create a custom minified version of Modernizr with [grunt-modernizr](https://github.com/Modernizr/grunt-modernizr). Eg. `.backgroundsize {}`, `Modernizr.backgroundSize` or `Modernizr.prefixed('backgroundSize')`

```
$ grunt build
```

#### Tests

Unit testing for PHP and JavaScript in the theme

```
$ grunt tests
```

## Using CSS pre-processors

We encourage all developers to use CSS pre-processors and we specially like SASS, but use whatever you feel more comfortable with. Just make sure you follow our 3 simple rules.

1. Create a directory on `/assets` where all your files will live. Eg. `/assets/sass`.
2. Create a task to use it on Grunt and hook up in the `build` task.
3. Hook up on the watch task for Grunt.
4. Avoid using mixins for vendor prefixes, we are already running autoprefixer on Grunt.

## WordPress Plugins

We encourage you to use the following plugins for development:

**Development**

* [Advanced Custom Fields](http://wordpress.org/plugins/advanced-custom-fields/) for fields
* [Custom Post Type UI](http://wordpress.org/plugins/custom-post-type-ui/) for post types
* [Gravity Forms](http://www.gravityforms.com/) for form management
* [Simple Image Sizes](http://wordpress.org/plugins/simple-image-sizes/) for image sizes
* [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/) for cache management
* [WordPress SEO](https://wordpress.org/plugins/wordpress-seo/) for search engine optimization

**Administration**

* [Bulk Creator](https://wordpress.org/plugins/bulk-creator/) for initial content creation
* [Jarvis](https://wordpress.org/plugins/jarvis/) for fast lookups of the admin menus

**Debugging**

* [Debug Bar](http://wordpress.org/extend/plugins/debug-bar/) for a debugging environment
* [Debugger](http://wordpress.org/plugins/debugger/) to be used along side Debug Bar for custom debugging messages
* [Log Viewer](http://wordpress.org/extend/plugins/log-viewer/) for log management

## WordPress CLI

We encourage you to use [WordPress CLI](http://wp-cli.org/) as much as possible in your workflow, it's an incredible tool which provides an enormous amount of power. Also look at all the [community packages](https://github.com/wp-cli/wp-cli/wiki/Community-Packages).

## Contribution

Although we are very opinionated, we are open to suggestions. Please send as a message to our email hello@wdgdc.com, through our [contact page](http://www.webdevelopmentgroup.com/contact/), send us a [GitHub issue](https://github.com/WDGDC/wordpress-theme/issues) or even better, a [pull request](https://github.com/WDGDC/wordpress-theme/pulls)!

## Credits

_Brought to you by [The Web Development Group](http://www.webdevelopmentgroup.com/) team._

* Original directory structure was inspired by [Bones](http://themble.com/bones/).
* Code snippets from [Underscores](http://underscores.me/).
* Grunt configuration originally inspired by [YeoPress](https://github.com/wesleytodd/YeoPress).
* If we forgot someone, please send us a [pull request](https://github.com/WDGDC/wordpress-theme/pulls) or a message through the [issues](https://github.com/WDGDC/wordpress-theme/issues).

[![](http://www.webdevelopmentgroup.com/wp-content/themes/thewebdevelopmentgroup/images/wdg-logo.png)](http://www.webdevelopmentgroup.com/)