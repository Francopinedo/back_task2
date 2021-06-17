//  -------------------- BUILD --------------------------
'use strict';

var gulp = require('gulp'),
    plugins = require("gulp-load-plugins")({
        pattern: ['gulp-*', 'gulp.*'],
        replaceString: /\bgulp[\-.]/
    }),
    runSequence = require('run-sequence'),
    del = require('del'),
    stream = require('merge-stream');


var build_dir = './_dist/';

// clean release folder
gulp.task('build_clean', function() {
    return del.sync(
        [ build_dir+'**' ],
        { force: true },
        function (err, paths) {}
    );
});

// copy files from /src
gulp.task('build_copy_files',function() {

    // copy root files
    var root_files = gulp.src([
            '.htaccess',
            'favicon.ico',
            'package.json',
            '*.php'
        ])
        .pipe(gulp.dest(build_dir));

    // copy public/bower_components
    var bower_files = gulp.src([
            'public/bower_components/**',
            '!public/bower_components/{autosize,autosize/**}',
            '!public/bower_components/{dense,dense/**}',
            '!public/bower_components/{fastclick,fastclick/**}',
            '!public/bower_components/{hammerjs,hammerjs/**}',
            '!public/bower_components/{jquery,jquery/**}',
            '!public/bower_components/{jquery.actual,jquery.actual/**}',
            '!public/bower_components/{jquery.dotdotdot,jquery.dotdotdot/**}',
            '!public/bower_components/{jquery.scrollbar,jquery.scrollbar/**}',
            '!public/bower_components/{jquery-bez,jquery-bez/**}',
            '!public/bower_components/{jquery-icheck,jquery-icheck/**}',
            '!public/bower_components/{kendo-ui,kendo-ui/**}',
            '!public/bower_components/{marked,marked/**}',
            '!public/bower_components/{modernizr,modernizr/**}',
            '!public/bower_components/{prism,prism/**}',
            '!public/bower_components/{selectize,selectize/**}',
            '!public/bower_components/{switchery,switchery/**}',
            '!public/bower_components/{velocity,velocity/**}',
            '!public/bower_components/{waypoints,waypoints/**}'
        ])
        .pipe(gulp.dest(build_dir+'public/bower_components/'));

    // copy kendo-ui styles/images
    var bower_kendoui_css = gulp.src([
        'public/bower_components/kendo-ui/styles/kendo.common-material.min.css',
        'public/bower_components/kendo-ui/styles/kendo.material.min.css',
        'public/bower_components/kendo-ui/styles/kendo.materialblack.min.css'
    ],{base: './'})
        .pipe(gulp.dest(build_dir));
    var bower_kendoui_img = gulp.src([
        'public/bower_components/kendo-ui/styles/Material/**/*',
        'public/bower_components/kendo-ui/styles/MaterialBlack/**/*',
        'public/bower_components/kendo-ui/styles/textures/**/*'
    ],{base: './'})
        .pipe(gulp.dest(build_dir));

    // copy assets
    var assets_files = gulp.src([
            'public/assets/css/**/*.min.css',
            'public/assets/icons/**/*',
            'public/assets/img/**/*',
            'public/assets/js/**/*.min.js',
            'public/assets/skins/**/*'
        ],{base: './'})
        .pipe(gulp.dest(build_dir));

    // copy data
    var data_files = gulp.src([
            'data/**/*'
        ])
        .pipe(gulp.dest(build_dir+'data/'));

    // copy codemirror files
    var codemirror_files = gulp.src('data/codemirror/*')
        .pipe(gulp.dest(build_dir+'data/codemirror/'));

    // copy php files
    var php_files = gulp.src([
            'php/**/*'
        ])
        .pipe(gulp.dest(build_dir+'php/'));

    // copy helpers
    var helpers_files = gulp.src('helpers/**/*')
        .pipe(gulp.dest(build_dir+'helpers/'));

    // copy file manager
    var file_manager_files = gulp.src([
        'file_manager/**/*'
    ])
        .pipe(gulp.dest(build_dir+'file_manager/'));

    return stream(
        root_files,
        bower_files,
        bower_kendoui_css,
        bower_kendoui_img,
        assets_files,
        data_files,
        codemirror_files,
        php_files,
        helpers_files,
        file_manager_files
    );

});

gulp.task('build',function(callback){
    return runSequence(
        ['default','build_clean'],
        'build_copy_files',
        callback
    );
});