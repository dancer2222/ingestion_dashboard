'use strict';

const gulp = require('gulp');
const uglify = require('gulp-uglify-es').default;;
const babel = require('gulp-babel');
const gulpIf = require('gulp-if');
const debug = require('gulp-debug');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass');
const browserSync = require('browser-sync').create();

const isDev = !process.env.NODE_ENV || process.env.NODE_ENV == 'dev';

const paths = {
    src: 'resources/theme_v2',
    dest: 'public/theme_v2'
};


gulp.task('build:js', function () {
    return gulp.src('./resources/assets/js/app.js')
        .pipe(uglify())
        .pipe(gulp.dest('./public/theme_v2/js'));
});

gulp.task('sass', function () {
    return gulp.src('./resources/assets/sass/**/*.scss', {since: gulp.lastRun('sass')})
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(debug())
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('watch:css', function () {
    gulp.watch('./resources/assets/sass/**/*.scss', gulp.series('sass'));
});

gulp.task('watch:js', function () {
    gulp.watch('./resources/assets/js/**/*.js', gulp.series('build:js'));
});

gulp.task('serve', function () {
    browserSync.init({
        proxy: "localhost:8000"
    });

    browserSync.watch('./resources/assets/**/*.*').on('change', function () {
        return browserSync.reload('*.css');
    });
});

// gulp.task('dev', gulp.series('build', gulp.parallel('watch:js', 'watch:css', 'serve')));
