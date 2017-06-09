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
var concat      = require('gulp-concat');

function admin(bundles, file_type) {

    var path = function (bundle) {
        return 'src/MyAdmin/' + bundle + '/Resources/assets/';
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

function getDestination(file_type) {

    return './src/MyAdmin/AdminBundle/Resources/public/' + file_type;

}

var getAdminNodeModules = {
      'files': {
          'source': [
              './node_modules/select2/dist/css/select2.min.css',
              './node_modules/bootstrap/dist/css/bootstrap.min.css',
              './node_modules/font-awesome/css/font-awesome.min.css',
              './node_modules/animate.css/animate.min.css',
              './node_modules/datatables/media/css/jquery.dataTables.min.css',
              './node_modules/tinymce/**'
          ],
          'destination': getDestination('node_modules')
      }
};


gulp.task('admin_node_modules', function () {
   return gulp.src(getAdminNodeModules.files.source)
       // .pipe(sass())
       // .pipe(cleanCSS())
       .pipe(gulp.dest(getAdminNodeModules.files.destination));
});

gulp.task('admin_es', function () {
    return browserify({entries: admin('AdminBundle', 'es'), debug: true})
        .transform("babelify", { presets: ["es2015"] })
        .bundle()
        .pipe(source('index.js'))
        .pipe(buffer())
        .pipe(uglify())
        .pipe(gulp.dest(getDestination('js')));
});

gulp.task('admin_js', function () {
    return gulp.src(admin('AdminBundle', 'js'))
        .pipe(uglify())
        .pipe(gulp.dest(getDestination('js')));
});

gulp.task('admin_sass', function () {
    return gulp.src(admin('AdminBundle', 'sass'))
        .pipe(sass())
        .pipe(concat('custom.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest(getDestination('css')));
});

gulp.task('admin_css', function () {
    return gulp.src(admin('AdminBundle', 'css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest(getDestination('css')));
});

gulp.task('admin_fonts', function() {
    return gulp.src(admin('AdminBundle', 'fonts'))
        .pipe(gulp.dest(getDestination('fonts')));
});

gulp.task('admin_images', function(){
   return gulp.src(admin('AdminBundle', 'images'))
       .pipe(imagemin({
           optimizationLevel: 5
       }))
       .pipe(gulp.dest(getDestination('images')));
});

gulp.task('admin_clean', function () {
   return gulp.src(getDestination('*'))
       .pipe(clean({force: true}));
});

gulp.task('admin', ['admin_clean', 'admin_es', 'admin_js', 'admin_sass', 'admin_css', 'admin_fonts', 'admin_images', 'admin_node_modules']);

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
