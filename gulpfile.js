'use strict';

const gulp = require('gulp');
const uglify = require('gulp-uglify');
const gulpIf = require('gulp-if');
const concat = require('gulp-concat');
const less = require('gulp-less');
const debug = require('gulp-debug');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass');
const del = require('del');
const cleanCSS = require('gulp-clean-css');
const path = require('path');
const browserSync = require('browser-sync').create();

const isDev = !process.env.NODE_ENV || process.env.NODE_ENV == 'dev';

const paths = {
    src: 'resources/theme_v2',
    dest: 'public/theme_v2'
};

gulp.task('theme:js', function () {
    return gulp.src(path.join(__dirname, paths.src, 'js/**/*.js'))
        .pipe(uglify())
        .pipe(gulp.dest(path.join(__dirname, paths.dest, 'js')));
});

gulp.task('theme:less', function () {
    return gulp.src(path.join(__dirname, paths.src, 'css/less/**/style.less'))
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(path.join(__dirname, paths.src, 'css')));
});

gulp.task('theme:assets', function () {
    gulp.src(path.join(__dirname, paths.src, 'images/**/*'))
        .pipe(gulp.dest(path.join(__dirname, paths.dest, 'images')));

    return gulp.src(path.join(__dirname, paths.src, 'icons/**/*'))
        .pipe(gulp.dest(path.join(__dirname, paths.dest, 'icons')));
});

gulp.task('theme:css:libs', function () {
    return gulp.src(path.join(__dirname, paths.src, 'css/lib/**/*.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest(path.join(__dirname, paths.dest, 'css/lib')));
});

gulp.task('theme:minify', function () {
    return gulp.src(path.join(__dirname, paths.src, 'css', '{helper,style}.css'))
        .pipe(cleanCSS())
        .pipe(concat('theme.min.css'))
        .pipe(gulp.dest(path.join(__dirname, paths.dest, 'css')));
});

gulp.task('build:theme', gulp.series(gulp.parallel('theme:less', 'theme:css:libs', 'theme:assets', 'theme:js'), 'theme:minify'));

gulp.task('sass', function () {
    return gulp.src('./resources/assets/sass/**/*.scss', {since: gulp.lastRun('sass')})
        .pipe(gulpIf(isDev, sourcemaps.init()))
        .pipe(debug())
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulpIf(isDev, sourcemaps.write()))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('clean', function () {
    return del('./public/{css}');
});

gulp.task('build', gulp.series('clean', 'sass'));

gulp.task('watch', function () {
    gulp.watch('./resources/assets/sass/**/*.scss', gulp.series('sass'));
});

gulp.task('serve', function () {
    browserSync.init({
        proxy: "localhost:8000"
    });

    browserSync.watch('./resources/assets/**/*.*').on('change', function () {
        return browserSync.reload('*.css');
    });
});

gulp.task('dev', gulp.series('build', gulp.parallel('watch', 'serve')));
