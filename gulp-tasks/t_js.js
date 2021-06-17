// -------------------- MINIFY/CONCATENATE JS FILES --------------------
'use strict';

var gulp = require('gulp'),
    plugins = require("gulp-load-plugins")({
        pattern: ['gulp-*', 'gulp.*'],
        replaceString: /\bgulp[\-.]/
    }),
    // chalk error
    chalk = require('chalk'),
    chalk_error = chalk.bold.red;


// commmon
gulp.task('js_common', function () {
    return gulp.src([
            "public/bower_components/jquery/dist/jquery.js",
            "public/bower_components/modernizr/modernizr.js",
            // moment
            "public/bower_components/moment/moment.js",
            // fastclick (touch devices)
            "public/bower_components/fastclick/lib/fastclick.js",
            // custom scrollbar
            "public/bower_components/jquery.scrollbar/jquery.scrollbar.js",
            // create easing functions from cubic-bezier co-ordinates
            "public/bower_components/jquery-bez/jquery.bez.min.js",
            // Get the actual width/height of invisible DOM elements with jQuery
            "public/bower_components/jquery.actual/jquery.actual.js",
            // waypoints
            "public/bower_components/waypoints/lib/jquery.waypoints.js",
            // velocityjs (animation)
            "public/bower_components/velocity/velocity.js",
            "public/bower_components/velocity/velocity.ui.js",
            // advanced cross-browser ellipsis
            "public/bower_components/jquery.dotdotdot/src/jquery.dotdotdot.min.js",
            // iCheck
            "public/bower_components/iCheck/icheck.js",
            // selectize
            "public/bower_components/selectize/dist/js/standalone/selectize.js",
            // switchery
            "public/bower_components/switchery/dist/switchery.js",
            // prism syntax highlighter
            "public/bower_components/prism/prism.js",
            "public/bower_components/prism/components/prism-php.js",
            "public/bower_components/prism/plugins/line-numbers/prism-line-numbers.js",
            // textarea-autosize
            "public/bower_components/autosize/dist/autosize.js",
            // hammerjs
            "public/bower_components/hammerjs/hammer.js",
            // jquery.debouncedresize
            "public/bower_components/jquery.debouncedresize/js/jquery.debouncedresize.js",
            // screenfull
            "public/bower_components/screenfull/dist/screenfull.js",
            // waves
            "public/bower_components/Waves/dist/waves.js"
        ])
        .pipe(plugins.concat('common.js'))
        .on('error', function(err) {
            console.log(chalk_error(err.message));
            this.emit('end');
        })
        .pipe(gulp.dest('public/assets/js/'))
        .pipe(plugins.uglify({
            mangle: true
        }))
        .pipe(plugins.rename('common.min.js'))
        .pipe(plugins.size({
            showFiles: true
        }))
        .pipe(gulp.dest('public/assets/js/'));
});

// custom uikit
gulp.task('js_uikit', function () {
    return gulp.src([
            // uikit core
            "public/bower_components/uikit/js/uikit.js",
            // uikit components
            "public/bower_components/uikit/js/components/accordion.js",
            "public/bower_components/uikit/js/components/autocomplete.js",
            "public/assets/js/custom/uikit_datepicker.js",
            "public/bower_components/uikit/js/components/form-password.js",
            "public/bower_components/uikit/js/components/form-select.js",
            "public/bower_components/uikit/js/components/grid.js",
            "public/bower_components/uikit/js/components/lightbox.js",
            "public/bower_components/uikit/js/components/nestable.js",
            "public/bower_components/uikit/js/components/notify.js",
            "public/bower_components/uikit/js/components/slideshow.js",
            "public/bower_components/uikit/js/components/slider.js",
            "public/bower_components/uikit/js/components/sortable.js",
            //"public/assets/js/custom/uikit_sortable.js",
            "public/bower_components/uikit/js/components/sticky.js",
            "public/bower_components/uikit/js/components/tooltip.js",
            "public/assets/js/custom/uikit_timepicker.js",
            "public/bower_components/uikit/js/components/upload.js",
            "public/assets/js/custom/uikit_beforeready.js"
        ])
        .pipe(plugins.concat('uikit_custom.js'))
        .pipe(gulp.dest('public/assets/js/'))
        .pipe(plugins.uglify({
            mangle: true
        }))
        .pipe(plugins.rename('uikit_custom.min.js'))
        .pipe(plugins.size({
            showFiles: true
        }))
        .pipe(gulp.dest('public/assets/js/'));
});

// uikit htmleditor
gulp.task('js_uikit_htmleditor', function () {
    return gulp.src([
            // htmleditor
            "public/bower_components/codemirror/lib/codemirror.js",
            "public/bower_components/codemirror/mode/markdown/markdown.js",
            "public/bower_components/codemirror/addon/mode/overlay.js",
            "public/bower_components/codemirror/mode/javascript/javascript.js",
            "public/bower_components/codemirror/mode/php/php.js",
            "public/bower_components/codemirror/mode/gfm/gfm.js",
            "public/bower_components/codemirror/mode/xml/xml.js",
            "public/bower_components/marked/lib/marked.js",
            "public/bower_components/uikit/js/components/htmleditor.js"
        ])
        .pipe(plugins.concat('uikit_htmleditor_custom.js'))
        .pipe(gulp.dest('public/assets/js/'))
        .pipe(plugins.uglify({
            mangle: true
        }).on('error', function (e) {
            console.log('\x07', e.message);
            return this.end();
        }))
        .pipe(plugins.rename('uikit_htmleditor_custom.min.js'))
        .pipe(plugins.size({
            showFiles: true
        }))
        .pipe(gulp.dest('public/assets/js/'));
});

// custom kendoui
gulp.task('js_kendoui', function () {
    // js
    return gulp.src([
            "public/bower_components/kendo-ui/src/js/kendo.core.js",
            "public/bower_components/kendo-ui/src/js/kendo.color.js",
            "public/bower_components/kendo-ui/src/js/kendo.data.js",
            "public/bower_components/kendo-ui/src/js/kendo.calendar.js",
            "public/bower_components/kendo-ui/src/js/kendo.popup.js",
            "public/bower_components/kendo-ui/src/js/kendo.datepicker.js",
            "public/bower_components/kendo-ui/src/js/kendo.timepicker.js",
            "public/bower_components/kendo-ui/src/js/kendo.datetimepicker.js",
            "public/bower_components/kendo-ui/src/js/kendo.list.js",
            "public/bower_components/kendo-ui/src/js/kendo.fx.js",
            "public/bower_components/kendo-ui/src/js/kendo.userevents.js",
            "public/bower_components/kendo-ui/src/js/kendo.menu.js",
            "public/bower_components/kendo-ui/src/js/kendo.draganddrop.js",
            "public/bower_components/kendo-ui/src/js/kendo.slider.js",
            "public/bower_components/kendo-ui/src/js/kendo.mobile.scroller.js",
            "public/bower_components/kendo-ui/src/js/kendo.autocomplete.js",
            "public/bower_components/kendo-ui/src/js/kendo.combobox.js",
            "public/bower_components/kendo-ui/src/js/kendo.dropdownlist.js",
            "public/bower_components/kendo-ui/src/js/kendo.colorpicker.js",
            "public/bower_components/kendo-ui/src/js/kendo.combobox.js",
            "public/bower_components/kendo-ui/src/js/kendo.maskedtextbox.js",
            "public/bower_components/kendo-ui/src/js/kendo.multiselect.js",
            "public/bower_components/kendo-ui/src/js/kendo.numerictextbox.js",
            "public/bower_components/kendo-ui/src/js/kendo.toolbar.js",
            "public/bower_components/kendo-ui/src/js/kendo.panelbar.js",
            "public/bower_components/kendo-ui/src/js/kendo.window.js"
        ])
        .pipe(plugins.concat('kendoui_custom.js'))
        .pipe(gulp.dest('public/assets/js/'))
        .pipe(plugins.uglify({
            mangle: true
        }))
        .pipe(plugins.rename('kendoui_custom.min.js'))
        .pipe(plugins.size({
            showFiles: true
        }))
        .pipe(gulp.dest('public/assets/js/'));

});

// minify common/page js
gulp.task('js_minify', function () {
    return gulp.src([
            'public/assets/js/altair_admin_common.js',
            'public/assets/js/pages/*.js',
            'public/assets/js/custom/*.js',
            '!public/assets/js/**/*.min.js'
        ])
        .pipe(plugins.uglify({
            mangle: true
        }))
        .pipe(plugins.rename({
            extname: ".min.js"
        }))
        .pipe(gulp.dest(function (file) {
            return file.base;
        }));
});