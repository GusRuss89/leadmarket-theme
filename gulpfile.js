var gulp = require('gulp'),
	dest = require('gulp-dest'),
	rename = require('gulp-rename'),
	sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	minifycss = require('gulp-minify-css'),
	jshint = require('gulp-jshint'),
	uglify = require('gulp-uglify'),
	imagemin = require('gulp-imagemin'),
	rename = require('gulp-rename'),
	concat = require('gulp-concat'),
	notify = require('gulp-notify'),
	cache = require('gulp-cache'),
	livereload = require('gulp-livereload'),
	del = require('del'),
	filter = require('gulp-filter'),
	filterCSS = filter('**/*.css'),
	http = require('http'),
	st = require('st');

// Sass
gulp.task('sass', function() {
	return gulp.src('library/scss/*.scss')
		.pipe(sass({
			outputStyle: 'expanded'
		}))
		.pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
		.pipe(gulp.dest('library/css'));
		//.pipe(notify({ message: 'Sass task complete' }));
});

// Minify CSS
gulp.task('mincss', function() {
	return gulp.src('library/css/style.css')
		.pipe(minifycss())
		.pipe(rename('style.min.css'))
		.pipe(gulp.dest('library/css'));
		//.pipe(notify({ message: 'Minify CSS task complete' }));
});

// Minify/concat JS
gulp.task('minjs', function() {
	return gulp.src([
			'library/js/libs/jquery.fitvids.js',
			'library/js/scripts.js'])
		.pipe(concat('all-theme-scripts.js'))
		.pipe(gulp.dest('library/js'))
		.pipe(uglify({
			mangle: false,
			preserveComments: 'license'
		}))
		.pipe(rename('all-theme-scripts.min.js'))
		.pipe(gulp.dest('library/js'))
		.pipe(notify({ message: 'Minify JS task complete' }));
});

// Images
gulp.task('images', function() {
	return gulp.src('library/images/*')
		.pipe(cache(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true })))
		.pipe(gulp.dest('library/images'))
		.pipe(notify({ message: 'Images task complete' }));
});

// Clean up
gulp.task('clean', function(cb) {
    del(['library/css'], cb);
});

// Default task
gulp.task('default', ['sass', 'mincss', 'minjs', 'watch']);

// Default task
gulp.task('justcss', ['sass', 'mincss']);


// Server
/*
gulp.task('server', function(done) {
	http.createServer(
		st({ path: __dirname + '/dist', index: 'index.html', cache: false })
	).listen(8888, done);
}); */

// Watch files
gulp.task('watch', function() {

	// Watch .scss files
	gulp.watch('library/scss/**/*.scss', ['sass']);

	// Watch .css files
	gulp.watch('library/css/*.css', ['mincss']);

	// Watch .js files
	gulp.watch(['library/js/scripts.js','library/js/ajax.js'], ['minjs']);

	// Watch image files
	//gulp.watch('src/images/**/*', ['images']);

	// Create LiveReload server
	//livereload.listen();

	// Watch output files, reload on change
	//gulp.watch(['library/css/**','library/js/**','**/*.php']).on('change', livereload.changed);

});