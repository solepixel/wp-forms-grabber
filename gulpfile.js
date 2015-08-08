// Load plugins
var gulp = require('gulp');
var plugins = require('gulp-load-plugins')({ camelize: true, lazy: false });

// Scripts
gulp.task('scripts', function() {
  return gulp.src(['js/admin-bar.js'])
  .pipe(plugins.jshint('.jshintrc'))
  .pipe(plugins.jshint.reporter('default'))
  .pipe(plugins.rename({ suffix: '.min' }))
  .pipe(plugins.uglify())
  .pipe(plugins.livereload())
  .pipe(gulp.dest('js/'));
  //.pipe(plugins.notify({ message: 'Scripts task complete' }));
});

// Watch
gulp.task('watch', function() {

  // Watch .js files
  gulp.watch(['js/admin-bar.js'], ['scripts']);

});

// Default task
gulp.task('default', ['scripts', 'watch']);
