const gulp = require('gulp');
const gp   = require('gulp-load-plugins')();

gulp.task('rollup', function() {
  const es2015 = require('rollup-plugin-buble');
  const uglify = require('rollup-plugin-uglify');

  gulp.src(__dirname + '/assets/js/site.js')
    .pipe(gp.sourcemaps.init())
    .pipe(gp.rollup({
      format: 'umd',
      globals: {
        debug: 'debug',
        jquery: 'jQuery',
        modernizr: 'Modernizr'
      },
      moduleName: 'Site',
      sourceMap: true,
      plugins: [
        es2015(),
        uglify()
      ]
    }))
    .pipe(gp.size({
      showFiles: true,
      title: 'JavaScript'
    }))
    .pipe(gp.sourcemaps.write('.'))
    .pipe(gulp.dest(__dirname + '/assets/dist'));
});