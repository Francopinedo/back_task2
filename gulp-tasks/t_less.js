// -------------------- LESS TO CSS --------------------
'use strict';

var gulp = require('gulp'),
    plugins = require("gulp-load-plugins")({
        pattern: ['gulp-*', 'gulp.*'],
        replaceString: /\bgulp[\-.]/
    }),
    // chalk error
    chalk = require('chalk'),
    chalk_error = chalk.bold.red;

// main styles
gulp.task('less_main', function() {
    return gulp.src('public/assets/less/main.less')
        .pipe(plugins.less())
        .on('error', function(err) {
            console.log(chalk_error(err.message));
            this.emit('end');
        })
        .pipe(plugins.autoprefixer({
            browsers: ['> 5%','last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/assets/css'))
        .pipe(plugins.cleanCss({
            advanced: false,
            keepSpecialComments: 0
        }))
        .pipe(plugins.rename('main.min.css'))
        .pipe(gulp.dest('public/assets/css'));
});

// error page
gulp.task('less_error_page', function() {
    return gulp.src('public/assets/less/pages/error_page.less')
        .pipe(plugins.less())
        .on('error', function(err) {
            console.log(chalk_error(err.message));
            this.emit('end');
        })
        .pipe(plugins.autoprefixer({
            browsers: ['> 5%','last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/assets/css'))
        .pipe(plugins.cleanCss({
            advanced: false,
            keepSpecialComments: 0
        }))
        .pipe(plugins.rename('error_page.min.css'))
        .pipe(gulp.dest('public/assets/css'));
});

// login page
gulp.task('less_login_page', function() {
    return gulp.src('public/assets/less/pages/login_page.less')
        .pipe(plugins.less())
        .on('error', function(err) {
            console.log(chalk_error(err.message));
            this.emit('end');
        })
        .pipe(plugins.autoprefixer({
            browsers: ['> 5%','last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/assets/css'))
        .pipe(plugins.cleanCss({
            advanced: false,
            keepSpecialComments: 0
        }))
        .pipe(plugins.rename('login_page.min.css'))
        .pipe(gulp.dest('public/assets/css'));
});

// themes
gulp.task('less_themes', function() {
    return gulp.src('public/assets/less/themes/_theme_*.less')
        .pipe(plugins.less())
        .on('error', function(err) {
            console.log(chalk_error(err.message));
            this.emit('end');
        })
        .pipe(plugins.autoprefixer({
            browsers: ['> 5%','last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/assets/css/themes/'))
        .pipe(plugins.cleanCss({
            advanced: false,
            keepSpecialComments: 0
        }))
        .pipe(plugins.rename(function (path) {
            path.extname = ".min.css"
        }))
        .pipe(gulp.dest('public/assets/css/themes/'))
        .pipe(plugins.concat('themes_combined.min.css'))
        .pipe(gulp.dest('public/assets/css/themes/'));
});

// generate user theme
gulp.task('less_my_theme', function() {
    return gulp.src('public/assets/less/themes/my_theme.less')
        .pipe(plugins.less())
        .on('error', function(err) {
            console.log(chalk_error(err.message));
            this.emit('end');
        })
        .pipe(plugins.autoprefixer({
            browsers: ['> 5%','last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('public/assets/css/themes/'))
        .pipe(plugins.cleanCss({
            advanced: false,
            keepSpecialComments: 0
        }))
        .pipe(plugins.rename('my_theme.min.css'))
        .pipe(gulp.dest('public/assets/css/themes/'));
});

// style switcher
gulp.task('less_style_switcher', function() {
    return gulp.src('public/assets/less/partials/_style_switcher.less')
        .pipe(plugins.less())
        .on('error', function(err) {
            console.log(chalk_error(err.message));
            this.emit('end');
        })
        .pipe(plugins.autoprefixer({
            browsers: ['> 5%','last 2 versions'],
            cascade: false
        }))
        .pipe(plugins.rename('style_switcher.css'))
        .pipe(gulp.dest('public/assets/css/'))
        .pipe(plugins.cleanCss({
            advanced: false,
            keepSpecialComments: 0
        }))
        .pipe(plugins.rename('style_switcher.min.css'))
        .pipe(gulp.dest('public/assets/css/'));
});