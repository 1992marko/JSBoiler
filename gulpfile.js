/* File: gulpfile.js */

// Gulp packages
var gulp  = require('gulp'),
	uglify  = require('gulp-uglify'),
	imagemin = require('gulp-imagemin'),
	browserSync = require('browser-sync').create(),
	babelify = require("babelify"),
	browserify = require('browserify'),
	source = require('vinyl-source-stream'),
	buffer = require('vinyl-buffer'),
	minifyCss = require('gulp-minify-css'),
	autoprefixer  = require('gulp-autoprefixer'),
	hbsfy  = require('hbsfy'),
	stripDebug = require('gulp-strip-debug'),
	sourcemaps = require('gulp-sourcemaps'),
	watchify = require('watchify'),
	gutil = require('gulp-util'),
	sass = require('gulp-sass'),
	concat = require('gulp-concat');
	
//Javascript and handlebars templates
var bundler, libsBundler;

function standardHandler(err) {
	console.log("Build Error:" + err.message);
	//notify("Build Error:" + err.message);
}

function browserifyHandler(err) {
	standardHandler(err);
	this.emit('end');
}

gulp.task('browserifyLibs', function () {
	
	libsBundler = watchify(browserify({
		entries: './src/libs.js',
		debug: true,
		cache: {},
		packageCache: {},
		poll: true
	}).transform(babelify,{presets: ["es2015"]}).transform(hbsfy));

	libsBundler.on('update', rebundle);
	libsBundler.on('log', gutil.log.bind(gutil, 'Browserify Libs done'));
	
	function rebundle(){
		gutil.log("Browserify Libs start");
		return libsBundler
			.bundle()
			.on('error', browserifyHandler)
			.pipe(source('libs.min.js'))
			.pipe(buffer())
			.pipe(sourcemaps.init({ loadMaps: true, debug: true }))
			.pipe(stripDebug())
			.pipe(uglify({mangle:false}))
			.pipe(sourcemaps.write('./', {
				includeContent: false,
				sourceRoot: '../'
		}))
			.pipe(gulp.dest('./'));
	}

	return rebundle();
});

gulp.task('browserify', function () {
	
	bundler = watchify(browserify({
		entries: './src/main.js',
		debug: true,
		cache: {},
		packageCache: {},
	}).transform(babelify,{presets: ["es2015"]}).transform(hbsfy));

	bundler.on('update', rebundle);
	bundler.on('log', gutil.log.bind(gutil, 'Browserify done'));
	
	function rebundle(){
		return bundler
		.bundle()
		.on('error', browserifyHandler)
		.pipe(source('./app.js'))
		.pipe(buffer())
		.pipe(sourcemaps.init({ loadMaps: true, debug: true }))
		.pipe(sourcemaps.write('./', {
			includeContent: false,
			sourceRoot: '../'
      }))
		.pipe(gulp.dest('./'));
	}

	return rebundle();
	
});

gulp.task('browserifyProduction', function () {
	var b2bundler = browserify({
		entries: './src/main.js',
		debug: true,
		cache: {},
		packageCache: {},
	}).transform(babelify,{presets: ["es2015"]}).transform(hbsfy);

	return b2bundler
		.bundle()
		.on('error', browserifyHandler)
		.pipe(source('./app.js'))
		.pipe(buffer())
		.pipe(sourcemaps.init({ loadMaps: true, debug: true }))
		.pipe(stripDebug())
		.pipe(uglify())
		.pipe(sourcemaps.write('./', {
			includeContent: false,
			sourceRoot: '../'
      }))
		.pipe(gulp.dest('./'));
});

//CSS
gulp.task('css', function() {
	//gulp.src(['./src/css/normalize.css', './src/css/libs/*.css', './src/css/framework.css', './src/css/main.css'])
	gulp.src([
		'./src/css/main.css'])
	.pipe(sass().on('error', sass.logError))
	.pipe(sourcemaps.init({ loadMaps: true, debug: true }))
    .pipe(minifyCss())
	.pipe(autoprefixer({
		browsers: ['last 15 versions']
	}))
	.pipe(concat("main.all.css"))
	.pipe(sourcemaps.write('./', {
			includeContent: false,
			sourceRoot: '../'
      }))
	.pipe(gulp.dest("./css"));
	//.pipe(browserSync.reload({stream:true}));
});

//Images
gulp.task('assets', function() {
	return gulp.src('./assets/*')
	.pipe(imagemin([
      //imagemin.gifsicle({interlaced: true}),
      //imagemin.jpegtran({progressive: true}),
      //imagemin.optipng(),
      //imagemin.svgo([{removeViewBox: false}, {minifyStyles: false}])
    ], {verbose: true})).on('error', browserifyHandler)
	.pipe(gulp.dest("./assets"));
});

gulp.task('watch', function () {
	//gulp.watch(['./src/**/*.js', './src/**/*.hbs', '!src/libs.js'], ["browserify"]);
	//gulp.watch(['src/libs.js'], ["browserifyLibs"]);
	gulp.watch('./src/css/*.css', ["css"]);
});

// create a default task
gulp.task('default', ['css', 'browserifyLibs', 'browserify', 'watch']);
gulp.task("production", ["css", "browserifyProduction", "assets"]);