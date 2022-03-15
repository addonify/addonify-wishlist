
const gulp = require('gulp');
const zip = require('gulp-zip');
const cssnano = require('cssnano');
const shell = require('gulp-shell');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const postcss = require('gulp-postcss');
const replace = require('gulp-replace');
const notify = require('gulp-notify');
const plumber = require('gulp-plumber');
const rtlcss = require('gulp-rtlcss');
const rename = require('gulp-rename');
const wpPot = require('gulp-wp-pot');
const autoprefixer = require('autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass')(require('sass'));

// npm init

// npm install gulp@4.0.2 gulp-shell gulp-sourcemaps gulp-sass sass gulp-concat gulp-uglify gulp-postcss autoprefixer cssnano gulp-replace gulp-notify gulp-plumber gulp-rtlcss gulp-rename gulp-wp-pot gulp-zip -g

// npm install gulp@4.0.2 gulp-shell gulp-sourcemaps gulp-sass sass gulp-concat gulp-uglify gulp-postcss autoprefixer cssnano gulp-replace gulp-notify gulp-plumber gulp-rtlcss gulp-rename gulp-wp-pot gulp-zip --save-dev

/*
===========================================================
=
= Change these constants according to your need
=
====================================================
*/

// 1# Script files path

const scriptpath = {

    script_src: [

        './public/assets/src/js/libraries/*.js',
        './public/assets/src/js/vendor/*.js',
        './public/assets/src/js/custom/*.js',
        '!./public/assets/src/js/conditional/*.js',
    ],

    script_dist: "./public/assets/build/js/",
}
const output_js_file_name = "addonify-wishlist-public.js";

var conditional__script__path = {
    conditional__script__src: [

        './public/assets/src/js/conditional/*.js',
    ],
    conditional__script__build__path: "./public/assets/build/js/conditional/",
}

// 2# SASS/SCSS file path

const sasspath = {

    sass_src: "./public/assets/src/scss/**/*.scss",
    sass_dist: "./public/assets/build/css/",
}
const compiled_sass_css_file_name = "addonify-wishlist-public.css";

var conditional__sass__path = {
    conditional__sass__src: [

        "./public/assets/src/scss/conditional/**"
    ],
    compiled__conditional__sass__build__path: "./public/assets/build/css/conditional/",
}

// 3# LTR & RTL CSS path

const rtlcsspath = {

    rtlcss_src: "./public/assets/build/css/" + compiled_sass_css_file_name,
    rtlcss_dist: "./public/assets/build/css/", // where would you like to save your generated RTL CSS
}

// 4# path of php files to generate WordPress POT file

var project__name = 'Addonify Wishlist';
var project__text__domain = 'addonify-wishlist';

var php__file__path = [

    './*.php',
    './**.php',
    './**/*.php',
    '!./github/**',
    '!./node_modules/*.php',
    '!./.git/*.php',
]

// 5# zip file path

var output__compressed__file = 'addonify-wishlist.zip';

const source__files__folders__to__compress = {

    source__files__folders: [

        './*',
        './*/**',

        '!./.gitignore',
        '!./.github/**',
        '!./.vscode',
        '!./public/assets/src/**',
        '!./gulpfile.js',
        '!./package.json',
        '!./package-lock.json',
        '!./node_modules/**',
        '!./composer.json',
        '!./composer.lock',
        '!./sftp-config.json'
    ],

    path__to__save__production__zip: "./",
}

/*
===========================================================
=
= Define task (Almost no chnages required)
=
====================================================
*/

// Task to compile scripts.

gulp.task('scriptsTask', function () {
    return gulp.src(scriptpath.script_src)
        .pipe(concat(output_js_file_name))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest(scriptpath.script_dist));
});

gulp.task('conditionalScriptsTask', function () {
    return gulp.src(conditional__script__path.conditional__script__src)
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(gulp.dest(conditional__script__path.conditional__script__build__path));
});

// Task to compile SASS/SCSS files.

gulp.task('sassTask', function () {
    var onError = function (err) {
        notify.onError({
            title: "Gulp",
            subtitle: "Failure!",
            message: "Error: <%= error.message %>",
            sound: "Beep"
        })(err);
        this.emit('end');
    };
    return gulp.src(sasspath.sass_src)
        .pipe(sourcemaps.init()) // initialize sourcemaps first
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(postcss([autoprefixer('last 2 version'), cssnano()])) // PostCSS plugins
        .pipe(concat(compiled_sass_css_file_name))
        .pipe(sourcemaps.write('.')) // write sourcemaps file in current directory
        .pipe(gulp.dest(sasspath.sass_dist)); // put final CSS in dist folder
});

gulp.task('conditionalSassTask', function () {
    var onError = function (err) {
        notify.onError({
            title: "Gulp",
            subtitle: "Failure!",
            message: "Error: <%= error.message %>",
            sound: "Beep"
        })(err);
        this.emit('end');
    };
    return gulp.src(conditional__sass__path.conditional__sass__src)
        .pipe(sourcemaps.init())
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(postcss([autoprefixer('last 2 version'), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(conditional__sass__path.compiled__conditional__sass__build__path));
});

// Task to convert LTR css to RTL

gulp.task('dortlTask', function () {
    return gulp.src(rtlcsspath.rtlcss_src)
        .pipe(rtlcss()) // Convert to RTL.
        .pipe(rename({ suffix: '-rtl' })) // Append "-rtl" to the filename.
        .pipe(gulp.dest(rtlcsspath.rtlcss_dist)); // Output RTL stylesheets.
});

// Task to generate WordPress POT file

gulp.task('makeWPPot', function () {
    return gulp.src(php__file__path)
        .pipe(wpPot({
            domain: project__text__domain,
            package: project__name
        }))
        .pipe(gulp.dest('./languages/' + project__text__domain + '.pot'));
});

// Task to generate Production Zip File 

gulp.task('zipProductionFiles', function () {
    return gulp.src(source__files__folders__to__compress.source__files__folders)
        .pipe(zip(output__compressed__file))
        .pipe(gulp.dest(source__files__folders__to__compress.path__to__save__production__zip))
});

//=========================================
// = C O M M A N D S                      = 
//=========================================
//
// 1. Command: gulp assets
// 2. Command: gulp makepot
// 3. Command: gulp zip
//
//=========================================


gulp.task('default', shell.task(

    'echo ===== ⛔️ Ooops! gulp default command is disabled in this project. These are the available commands: gulp assets, gulp zip & gulp makepot. =====',
));

gulp.task('makepot', gulp.series('makeWPPot', (done) => {

    done();
}));

gulp.task('zip', gulp.series('zipProductionFiles', (done) => {

    done();
}));

gulp.task('assets', gulp.series('scriptsTask', 'conditionalScriptsTask', 'sassTask', 'conditionalSassTask', 'dortlTask', (done) => {

    gulp.watch(scriptpath.script_src, gulp.series('scriptsTask'));
    gulp.watch(sasspath.sass_src, gulp.series('sassTask'));
    gulp.watch(rtlcsspath.rtlcss_src, gulp.series('dortlTask'));
    gulp.watch(conditional__sass__path.conditional__sass__src, gulp.series('conditionalSassTask'));
    gulp.watch(conditional__script__path.conditional__script__src, gulp.series('conditionalScriptsTask'));
    done();
}));
