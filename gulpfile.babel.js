const pkg          = require('./package.json');
const gulp         = require('gulp');
const gulpPlugins  = require('gulp-load-plugins')();
const { sequence } = gulpPlugins;
let browserSync;

try {
	browserSync = require('browser-sync').create();
} catch(e) {
	// ignore error
}

// project
const project  = { root: __dirname };
project.assets = `${project.root}/assets`;
project.dist   = `${project.assets}/dist`;
project.fonts  = `${project.assets}/fonts`;
project.img    = `${project.assets}/img`;
project.inc    = `${project.root}/includes`;
project.js     = `${project.assets}/js`;
project.lang   = `${project.root}/languages`;
project.node   = `${project.root}/node_modules`;
project.sass   = `${project.assets}/sass`;
project.vendor = `${project.assets}/vendor`;

const banner = `/*!
 * DO NOT OVERRIDE THIS FILE.
 * Generated with \`npm run build\`
 *
 * ${pkg.name} - ${pkg.description}
 * @version ${pkg.version}
 * @author ${pkg.author.name}
 * @link ${pkg.author.url}
 */

`;

// build
gulp.task('build', sequence('build:vendor', ['build:img', 'build:css', 'build:js']));

// img
gulp.task('build:img', () => {
	const { imagemin, size } = gulpPlugins;
	return gulp.src(`${project.img}/**/*.{png,jpg,jpeg,gif,svg}`)
		.pipe(imagemin())
		.pipe(size({
			showFiles: true,
			title: 'imagemin'
		}))
		.pipe(gulp.dest(`${project.img}`));
});

// css
gulp.task('build:css', () => {
	const { autoprefixer, csso, filter, header, plumber, rename, sass, sassGlob, size, sourcemaps, util } = gulpPlugins;
	const filterCSS = filter(['**/*.css'], { restore: true });
	const sync = () => browserSync ? browserSync.stream({ match: '**/*.css' }) : util.noop();

	return gulp.src([`${project.sass}/**/*.scss`, `!_*.scss`])
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sassGlob())
		.pipe(sass({
			outputStyle: 'expanded'
		}).on('error', sass.logError))
		.pipe(autoprefixer({
			browsers: ['last 2 versions', 'ie 11']
		}))
		.pipe(header(banner))
		.pipe(size({
			showFiles: true,
			title: 'sass'
		}))
		.pipe(sourcemaps.write('.')).on('error', util.log)
		.pipe(gulp.dest(project.dist))
		.pipe(sync())

		// minified version
		.pipe(filterCSS)
		.pipe(rename({ suffix: '.min' }))
		.pipe(csso()).on('error', util.log)
		.pipe(size({
			showFiles: true,
			title: 'sass'
		}))
		.pipe(sourcemaps.write('.')).on('error', util.log)
		.pipe(filterCSS.restore)

		// create both files
		.pipe(gulp.dest(project.dist))
		.pipe(sync());
});

// js
gulp.task('build:js', () => {
	// edit these
	let globals = {
		bows: 'bows',
		jquery: 'jQuery',
		modernizr: 'Modernizr'
	};

	// Note: do not edit these lines
	const del = require('del');
	const rollup = require('rollup');
	const vinylPaths = require('vinyl-paths');
	const es2015 = require('rollup-plugin-buble');
	const uglify = require('rollup-plugin-uglify');
	const prettyBytes = require('pretty-bytes');
	const { util } = gulpPlugins;
	const { colors: chalk } = util;

	const log = (() => {
		const cache = Object.create(null);

		return (fileName, msg) => {
			if (!(fileName in cache)) {
				cache[fileName] = Object.create(null);
			}

			if (msg in cache[fileName]) {
				return;
			}

			const title = chalk.cyan('rollup') + ' ';
			util.log(title + chalk.blue(fileName) + ' ' + msg);

			cache[fileName][msg] = true;
		};
	})();

	const getPaths = (path) => {
		const fileName = path.replace(project.js + '/', '').slice(0, -3);
		const dest = `${project.dist}/${fileName}.js`;
		const minDest = `${project.dist}/${fileName}.min.js`;
		let moduleName = fileName[0].toUpperCase() + fileName.slice(1);

		moduleName.replace(/(\-|\_|\.|\s)+(.)?/g, function(match, separator, chr) {
			return chr ? chr.toUpperCase() : '';
		}).replace(/(^|\/)([A-Z])/g, function(match, separator, chr) {
			return match.toLowerCase();
		});

		return { path, fileName, dest, minDest, moduleName };
	};

	const writeFiles = (bundle, path, fileName, moduleName, dest) => {
		const opts = {
			globals,
			sourceMap: true,
			moduleName,
			banner,
			exports: 'named',
			format: 'umd',
			dest,
		};

		const result = bundle.generate(opts);
		let size = Buffer.byteLength(result.code, 'utf8');
		size = prettyBytes(size);
		size = chalk.magenta(size);

		log(fileName, chalk.magenta(size));

		return bundle.write(opts);
	};

	// delete dist files
	del.sync([`${project.dist}/**/*.js`]);

	// read js files
	return gulp.src([`${project.js}/**/*.js`, `!_*.js`], { read: false })
		.pipe(vinylPaths((path) => {
			const fileName = path.replace(project.js + '/', '');

			// skip if file has a _ as the first character
			if (fileName[0] === '_') {
				return Promise.resolve();
			}

			return new Promise((resolve, reject) => {
				const { fileName, dest, minDest, moduleName } = getPaths(path);
				// compile original file
				return rollup.rollup({
					entry: path,
					external: Object.keys(globals),
					onwarn: (msg) => log(`${fileName}.js`, msg),
					plugins: [
						es2015()
					]
				})
				// write original file
				.then((bundle) => writeFiles(bundle, path, `${fileName}.js`, moduleName, dest))

				// compile minified file
				.then(() => rollup.rollup({
					entry: path,
					external: Object.keys(globals),
					onwarn: (msg) => log(`${fileName}.min.js`, msg),
					plugins: [
						es2015(),
						uglify()
					]
				}))
				// write minified file
				.then((bundle) => writeFiles(bundle, path, `${fileName}.min.js`, moduleName, minDest))

				.then(() => {
					const sync = () => browserSync ? browserSync.reload() : util.noop();
					sync();
				})

				// handle promise
				.then(resolve)
				.catch(reject);
			}).catch((err) => console.log(err));
		}));
});

// vendor
gulp.task('build:vendor', ['build:vendor:copyFromNpm', 'build:vendor:modernizr']);

gulp.task('build:vendor:copyFromNpm', () => {
	const { size } = gulpPlugins;
	const npmFiles = Object.keys(pkg.dependencies).map((name) => `${project.node}/${name}/**/*`);

	return gulp.src(npmFiles, { base: project.node })
		.pipe(size({ title: 'vendor' }))
		.pipe(gulp.dest(project.vendor));
});

gulp.task('build:vendor:modernizr', () => {
	const { header, modernizr, rename, sourcemaps, uglify } = gulpPlugins;

	return gulp.src([`${project.sass}/**/*.scss`, `${project.js}/**/*.js`])
		.pipe(modernizr({
			options: [
				'setClasses',
				'addTest',
				'html5printshiv',
				'testProp',
				'fnBind'
			]
		}))
		.pipe(gulp.dest(`${project.vendor}/modernizr`))

		// minified version
		.pipe(sourcemaps.init())
		.pipe(rename({ suffix: '.min' }))
		.pipe(uglify({
			preserveComments: 'license'
		}))
		.pipe(header(banner))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(`${project.vendor}/modernizr`));
});

// watch
gulp.task('watch', () => {
	gulp.watch(`${project.js}/**/*.js`, ['build:js']);
	gulp.watch(`${project.sass}/**/*.scss`, ['build:css']);
	gulp.watch(`${project.img}/**/*.{png,jpg,jpeg,gif,svg}`, ['build:img']);
});

// browsersync
if (browserSync) {
	gulp.task('build:js-sync', ['build:js']);

	gulp.task('watch:sync', () => {
		const { execSync } = require('child_process');

		// get the URL WP_SITEURL from wp-config.php
		const proxy = execSync(`php -r "require '../../../wp-config.php'; echo \\WP_SITEURL;"`, { encoding: 'utf8' });

		// BrowserSync
		browserSync.init({ proxy });

		// watch the files
		gulp.watch(`${project.sass}/**/*.scss`, ['build:css']);
		gulp.watch(`${project.js}/**/*.js`, ['build:js-sync']);
		gulp.watch(`${project.root}/**/*.php`).on('change', browserSync.reload);
		gulp.watch(`${project.img}/**/*.{png,jpg,jpeg,gif,svg}`).on('change', browserSync.reload);
	});
}
