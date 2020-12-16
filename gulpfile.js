var gulp = require('gulp');
var wpPot = require('gulp-wp-pot');

gulp.task('default', function () {
    return gulp.src('./**/*.php')
        .pipe(wpPot( {
            domain: 'addonify-wishlist',
            package: 'Addonify_Wishlist'
        } ))
        .pipe(gulp.dest('languages/addonify-wishlist.pot'));
});
