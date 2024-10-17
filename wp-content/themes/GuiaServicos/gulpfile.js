let gulp = require('gulp')
let browser = require('browser-sync')
let npm  = require('gulp-watch')
let sass = require('gulp-sass')
let autoprefixer = require('gulp-autoprefixer')
let uglifycss = require('gulp-uglifycss')
var uglify = require('gulp-uglify')
var rename = require('gulp-rename')
var imagemin = require('gulp-imagemin')


gulp.task('compile-dev', () => {

	var files = [
		'./style.css',
		'./*.php',
		'./template-part/*.php',
		'./page-template/*.php',
		'./inc/.*php',
		'./assets/js/*.js',
		'./assets/css/*.css',
		'./assets/sass/*.scss',
	];

	browser.init(files, { 
		//server: { baseDir: "./" },
		proxy: "http://localhost:8080",
		notify: false
	})

	gulp.watch('./assets/sass', function() {
		return gulp.src('./assets/sass/main.scss')
		.pipe(sass({ compress: true }))
		.pipe(autoprefixer()) //add autoprefixer
		.pipe(gulp.dest('./assets/css'))
		.pipe(browser.stream())
 	 });
  
	gulp.watch('./*.php', function() {
		return gulp.src('./*.php')
		.pipe(browser.stream())
	});

})

//minificar css
gulp.task('compress-css', function () {
	gulp.src('./assets/css/main.css')
	  .pipe(uglifycss({
		"maxLineLen": 80,
		"uglyComments": true
	  }))
	  .pipe(rename({
		suffix: '.min'
	  }))
	  .pipe(gulp.dest('./assets/css/min/'));
});

// minificar js
gulp.task('compress-js', function () {
	return gulp.src('./assets/js/*.js')
	.pipe(uglify())
	.pipe(rename({
		suffix: '.min'
	}))
	.pipe(gulp.dest('./assets/js/min/'))
});

//otimizar images assets
gulp.task('compress-images', function () {
	return gulp.src('./assets/images/**')
	.pipe(imagemin({
		interlaced: true,
		progressive: true,
		optimizationLevel: 5,
		verbose: true
	}))
	.pipe(gulp.dest('./assets/images/'))
});

//otimizar images assets
gulp.task('compress-upload', function () {
	return gulp.src('../../uploads/**')
	.pipe(imagemin({
		interlaced: true,
		progressive: true,
		optimizationLevel: 5,
		verbose: true
	}))
	.pipe(gulp.dest('../../uploads'))
});

gulp.task('compile-prod', () => {
	gulp.watch('./assets/sass', function() {
		return gulp.src('./assets/sass/main.css')
		.pipe(sass({ compress: true }))
		.pipe(gulp.dest('./assets/css'))
		//.pipe(gulp.dest('./hexapus-web/assets/css'))
	});
	
})