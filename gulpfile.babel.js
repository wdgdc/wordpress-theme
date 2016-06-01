const pkg         = require('./package.json');
const gulp        = require('gulp');
const gulpPlugins = require('gulp-load-plugins')();

// project
const project  = { root: __dirname };
project.assets = project.root + '/assets';
project.dist   = project.assets + '/dist';
project.fonts  = project.assets + '/fonts';
project.img    = project.assets + '/img';
project.inc    = project.root + '/includes';
project.js     = project.assets + '/js';
project.lang   = project.root + '/languages';
project.node   = project.root + '/node_modules';
project.sass   = project.assets + '/sass';
project.vendor = project.assets + '/vendor';

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
gulp.task('build', ['build:vendor', 'build:css-js']);
gulp.task('build:css-js', ['build:css', 'build:js']);

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
	const { autoprefixer, csso, filter, header, livereload, plumber, rename, sass, sassGlob, size, sourcemaps, util } = gulpPlugins;
	const filterCSS = filter(['**/*.css'], { restore: true });

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

		.pipe(livereload());
});

// js
gulp.task('build:js', () => {
	const { filter, header, livereload, plumber, rename, rollup, size, sourcemaps, uglify } = gulpPlugins;
	const es2015   = require('rollup-plugin-buble');
	const filterJS = filter(['**/*.js'], { restore: true });

	return gulp.src(`${project.js}/site.js`)
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(rollup({
			format: 'umd',
			globals: {
				bows: 'bows',
				jquery: 'jQuery',
				modernizr: 'Modernizr'
			},
			moduleName: 'Site',
			sourceMap: true,
			plugins: [
				es2015()
			]
		}))
		.pipe(size({
			showFiles: true,
			title: 'rollup'
		}))
		.pipe(header(banner))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(project.dist))

		// minified version
		.pipe(filterJS)
		.pipe(rename({ suffix: '.min' }))
		.pipe(uglify())
		.pipe(header(banner))
		.pipe(size({
			showFiles: true,
			title: 'rollup'
		}))
		.pipe(sourcemaps.write('.'))
		.pipe(filterJS.restore)

		// create both files
		.pipe(gulp.dest(project.dist))

		.pipe(livereload());
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
	const { livereload } = gulpPlugins;
	livereload.listen();
	gulp.watch(`${project.js}/**/*.js`, ['build:js']);
	gulp.watch(`${project.sass}/**/*.scss`, ['build:css']);
	gulp.watch(`${project.img}/**/*.{png,jpg,jpeg,gif,svg}`, ['build:img']);
});
