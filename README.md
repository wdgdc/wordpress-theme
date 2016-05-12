# WDG Starter WordPress Theme

This is a *very* opinionated base theme for WordPress, build from several iterations of our projects' themes on production.

## Features

* Straightforward directory structure
* PHP classes and functions for your WordPress theme
* CSS goodies like:
    * [SASS (SCSS syntax)](http://sass-lang.com/): CSS pre-processor
    * [Autoprefixer](https://github.com/postcss/autoprefixer): Automatically prefixed vendor properties
    * [Bourbon](http://bourbon.io/) & [Neat](http://neat.bourbon.io/): SASS & Grid library
* JavaScript goodies like:
    * [JSCS](http://jscs.info/): JavaScript code style linter with ES6 support
    * ES2015 syntax with [Bublé](https://gitlab.com/Rich-Harris/buble)
    * ES2015 modules with [Rollup](http://rollupjs.org/)
* Vendor packages
  * Copied automatically from `node_modules` to `assets/vendor`
  * Custom Modernizr generated from your SCSS & JS files
* [LiveReload](http://livereload.com/) support
* [Gulp](http://gulpjs.com/) tasks to build/compile and watch for asset changes

---

## Getting Started

1. Install [Node.js](https://nodejs.org/) & [WordPress](https://wordpress.org/) on your development server
2. [Download the theme](https://github.com/WDGDC/wordpress-theme/archive/master.zip) from our GitHub [repo](https://github.com/wdgdc/wordpress-theme) into your themes directory `/wp-content/themes/`
3. Install the theme's dependencies
```
$ npm install
```
4. Run the `build` task
```
$ npm run build
```
Or watch for changes
```
$ npm run watch
```
5. Enable the WordPress theme and start coding!

---

## Directory structure

**All static assets**, like stylesheets, JavaScript files, images, icons and fonts should go in the `/assets` directory. All 3rd party frameworks and plugins should go in the `/assets/vendor` directory.

Feel free to use Npm for installing and updating them with the `--save` flag so our `gulp build:vendor` task can copy the files to the `assets/vendor` directory.

**SASS** is strictly required in development, use Gulp to compile the CSS files. Use components, mixins and variables folders to keep organized and build modular & reusable files.

**All PHP scripts** that aren't templates should go in `/includes`. Eg. `/includes/class-theme.php`. Refer to the WordPress Coding Standards for [naming convention](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/#naming-conventions).

**Translation files** should live in the `/languages` directory.

`node_modules` is where all **Node.js packaged modules** will be stored to be used in the Build process with Gulp. This directory is excluded from the Git repo by default. Keep it this way.

`partials` is where all the template parts used by WordPress live.

`templates` is where all user-selectable page templates live. Eg. an "About us" page `/* Template Name: About Us */` `templates/about-us.php`. Please do not clutter the root directory with WordPress templates.

`tests` include **unit testing** for our main PHP and JavaScript functionality. We encourage you to write all sort of tests for your theme here, feel free to use your favorite testing framework.

`widgets` is where all WordPress widgets' code is available. Each PHP file in this directory will be included on `add_action('widgets_init')`.

```
wdg-wordpress-theme
├─┬ assets
│ ├── dist
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

---

## Vendor assets

3rd party vendor files live in `/assets/vendor`, they can be either stylesheets, JavaScript, images or any kind of helper, snippet, library or framework that isn't theme related.

Use WordPress `register_style` and `register_script` to add them to your theme.

### ES2015 modules

To use the JavaScript vendor assets within ES6 modules you can whitelist them as globals in the `gulpfile.js`.

Inside the `rollup` task, add your 3rd party dependencies as follows:

```javascript
globals: {
	bows: 'bows',
	jquery: 'jQuery',
	modernizr: 'Modernizr'
},
```

Then include them in your theme's JavaScript files, note that we use the previously provided key `jquery` and not the actual global variable `jQuery`. Then we alias such variable as `$` to be used inside our module.

```javascript
import $ from 'jquery';

$('html').addClass('js');
```

Learn more about [ES2015 modules](http://exploringjs.com/es6/ch_modules.html).

### Default vendor assets

As you can see in the code above, we provide the following vendor assets by default:

* [bows](https://github.com/latentflip/bows)
* [jquery](https://github.com/jquery/jquery)
* [modernizr](https://github.com/Modernizr/Modernizr)

Modernizr is custom built from the references within the JavaScript & CSS asset files.

### Searching for a package
[NPM packages repository](https://www.npmjs.com/)

---

## Build process with Npm & [_Gulp_](http://gulpjs.com/)

### Installing

Use the command line to get to the root of the repo and run the following command to install node modules, including Gulp.

```
$ npm install
```

#### Build

```
$ npm run build
```

This is a set of tasks to be run in sequence to compile the Vendor files, CSS and then JavaScript files.

##### build:vendor

```
$ npm run gulp -- build:vendor
```

1. Generate a custom built Modernizr file based on usage from the project's CSS & JS.
2. Copy all `dependencies` from `package.json` to the `assets/vendor` directory.

##### build:css

```
$ npm run gulp -- build:css
```

1. Grab all Sass files without an underscore in front of the file.
2. Compile SASS files.
3. Autoprefixer.
4. Create compiled and minified versions of all CSS files.

##### build:js

```
$ npm run gulp -- build:js
```

1. Rollup to merge all ES6 modules imported from `assets/js/site.js`.
2. Transpile all ES6 code into ES5 with Bublé.
3. Create compiled and minified versions of all CSS files.

#### Watch

```
$ npm run gulp -- watch
```

The `watch` task will look for changes in the /assets/js and /assets/sass files and build them accordingly.

Please note that the watch task will not generate vendor files by default or on any file change. This has changed from previous versions of the theme. Please run `build:vendor` yourself.

There is [LiveReload](http://livereload.com/) support, so your browser tab should be updated automatically after compilation as long as you have the [browser extension enabled](http://feedback.livereload.com/knowledgebase/articles/86242-how-do-i-install-and-use-the-browser-extensions-).

---

## A note on using CSS pre-processors

We encourage all developers to use CSS pre-processors and we specially like SASS, but use whatever you feel more comfortable with. Just make sure you follow our simple rules.

1. Create a directory on `/assets` where all your files will live. Eg. `/assets/sass`.
2. Pipe the `build:css` task to compile all files without an underscore in front of the file name.
3. Hook up on the watch task for Gulp.
4. Avoid using mixins for vendor prefixes, we are already running Autoprefixer.

---

## WordPress Plugins

We encourage you to use the following plugins for development:

**Development**

* [Advanced Custom Fields](http://wordpress.org/plugins/advanced-custom-fields/) (Pro) for fields
* [Gravity Forms](http://www.gravityforms.com/) for form management
* [Timber](https://wordpress.org/plugins/timber-library/) for templating
* [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/) for cache management
* [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) for search engine optimization

**Administration**

* [Bulk Creator](https://wordpress.org/plugins/bulk-creator/) for initial content creation
* [Jarvis](https://wordpress.org/plugins/jarvis/) for fast lookups of the admin menus

**Debugging**

* [Debug Bar](http://wordpress.org/extend/plugins/debug-bar/) for a debugging environment
* [Debugger](http://wordpress.org/plugins/debugger/) to be used along side Debug Bar for custom debugging messages
* [Log Viewer](http://wordpress.org/extend/plugins/log-viewer/) for log management

## WordPress CLI

We encourage you to use [WordPress CLI](http://wp-cli.org/) as much as possible in your workflow, it's an incredible tool which provides an enormous amount of power. Also look at all the [community packages](https://github.com/wp-cli/wp-cli/wiki/Community-Packages).

---

## Contribution

Although we are very opinionated, we are open to suggestions. Please send as a message to our email hello@wdgdc.com, through our [contact page](http://www.webdevelopmentgroup.com/contact/), send us a [GitHub issue](https://github.com/WDGDC/wordpress-theme/issues) or even better, a [pull request](https://github.com/WDGDC/wordpress-theme/pulls)!


## Credits

* _Brought to you by [The Web Development Group](http://www.webdevelopmentgroup.com/) team._
[@dougaxe1](https://github.com/dougaxe1), [@kshaner](https://github.com/kshaner), [@MikeNGarrett](https://github.com/MikeNGarrett), [@neojp](https://github.com/neojp)
* Original directory structure was inspired by [Bones](http://themble.com/bones/).
* Grunt configuration originally inspired by [YeoPress](https://github.com/wesleytodd/YeoPress).
* If we forgot someone, please send us a [pull request](https://github.com/WDGDC/wordpress-theme/pulls) or a message through the [issues](https://github.com/WDGDC/wordpress-theme/issues).

[![](https://www.webdevelopmentgroup.com/wp-content/themes/wdg/assets/img/wdg-logo.png)](https://www.webdevelopmentgroup.com/)
