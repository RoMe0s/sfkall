var gulp = require('gulp');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var imagemin = require('gulp-imagemin');
var clean = require('gulp-clean');
var browserify  = require('browserify');
var babelify    = require('babelify');
var source      = require('vinyl-source-stream');
var buffer      = require('vinyl-buffer');

function admin(bundles, file_type) {

    var path = function (bundle) {
        return 'src/MyAdmin/' + bundle + '/Resources/public/';
    };

    var config = {
        es: 'es/index.js',
        js: 'js/**/*.js',
        sass: 'sass/*.sass',
        css: 'css/**/*.css',
        fonts: 'fonts/**/*',
        images: 'images/**/*'
    };
    
    if(bundles.constructor === Array) {
        
        var result = [];
        
        for(var bundle of bundles) {
            
            result.push(path(bundle) + config[file_type]);
            
        }
        
        return result;
        
    }

    return path(bundles) + config[file_type];

}

function getDestination(side, file_type) {

    var destinations = {
        admin: 'admin/',
        front: 'front/'
    };

    return 'web/bundles/' + destinations[side] + file_type;

}

gulp.task('admin_es', function () {
    return browserify({entries: admin('AdminBundle', 'es'), debug: true})
        .transform("babelify", { presets: ["es2015"] })
        .bundle()
        .pipe(source('index.js'))
        .pipe(buffer())
        .pipe(uglify())
        .pipe(gulp.dest(getDestination('admin', 'js')));
});

gulp.task('admin_js', function () {
    return gulp.src(admin('AdminBundle', 'js'))
        .pipe(uglify())
        .pipe(gulp.dest(getDestination('admin', 'js')));
});

gulp.task('admin_sass', function () {
    return gulp.src(admin('AdminBundle', 'sass'))
        .pipe(sass())
        .pipe(cleanCSS())
        .pipe(source('custom.css'))
        .pipe(gulp.dest(getDestination('admin', 'css')));
});

gulp.task('admin_css', function () {
    return gulp.src(admin('AdminBundle', 'css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest(getDestination('admin', 'css')));
});

gulp.task('admin_fonts', function() {
    return gulp.src(admin('AdminBundle', 'fonts'))
        .pipe(gulp.dest(getDestination('admin', 'fonts')));
});

gulp.task('admin_images', function(){
   return gulp.src(admin('AdminBundle', 'images'))
       .pipe(imagemin({
           optimizationLevel: 5
       }))
       .pipe(gulp.dest(getDestination('admin', 'images')));
});

gulp.task('admin_clean', function () {
   return gulp.src(getDestination('admin', '*'))
       .pipe(clean({force: true}));
});

gulp.task('admin', ['admin_clean', 'admin_es', 'admin_js', 'admin_sass', 'admin_css', 'admin_fonts', 'admin_images']);

gulp.task('clean', ['admin_clean']);

gulp.task('build', ['admin']);

gulp.task('watch_admin_es', function () {

    return gulp.watch(admin('AdminBundle', 'es'), ['admin_es']);

});

gulp.task('watch_admin_js', function () {

    return gulp.watch(admin('AdminBundle', 'js'), ['admin_js']);

});

gulp.task('watch_admin_sass', function () {

    return gulp.watch(admin('AdminBundle', 'sass'), ['admin_sass']);

});

gulp.task('watch_admin_css', function () {

    return gulp.watch(admin('AdminBundle', 'css'), ['admin_css']);

});

gulp.task('watch', ['watch_admin_es', 'watch_admin_sass', 'watch_admin_js', 'watch_admin_css']);

gulp.task('default', ['clean', 'build', 'watch']);
