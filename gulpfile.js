const elixir = require('laravel-elixir');

//require('laravel-elixir-vue-2');
// require('laravel-elixir-remove');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

/**
 * Copy template of frontend and backend to public for display
 */
elixir(mix => {
// frontend theme
    mix.copy(
        'resources/timer-html-master',
        'public/theme/frontend'
    );
// backend theme
    mix.copy(
        'resources/adminlte',
        'public/theme/backend'
    );
});

/**
 * Frontend
 */

elixir(mix => {


    mix.sass('blog.scss');

    mix.styles([
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/ionicons.min.css',
        'resources/assets/css/animate.css',
        'resources/assets/css/slider.css',
        'resources/assets/css/owl.carousel.css',
        'resources/assets/css/owl.theme.css',
        'resources/assets/css/jquery.fancybox.css',
        'resources/assets/css/responsive.css',
        'resources/assets/css/select2.min.css',

        'resources/assets/css/main.css',

    ],'public/css/blog.css');

    // fonts
    // bootstrap fonts
    mix.copy(
        'resources/adminlte/bootstrap/fonts',
        'public/fonts'
    );
    mix.copy(
        'resources/timer-html-master/fonts',
        'public/build/fonts'
    );
    mix.copy(
        'resources/timer-html-master/fonts',
        'public/fonts'
    );

    mix.scripts([
        'vendor/modernizr-2.6.2.min.js',
        'jquery.min.js',
        'owl.carousel.min.js',
        'bootstrap.min.js',
        'wow.min.js',
        'slider.js',
        'jquery.fancybox.js',
        'main.js',

        'select2.min.js',
        'blog.js',

    ], 'public/js/blog.js');

    mix.version(['public/css/blog.css','public/js/blog.js']);
});

/**
 * Admin login css, js
 */
elixir(mix => {

    mix.less([
        '../../../resources/adminlte/build/less/AdminLTE.less'
    ], 'public/css/admin/adminlte.css');

    mix.styles([
        '../../../resources/adminlte/bootstrap/css/bootstrap.css',
        '../../../public/css/admin/adminlte.css',
        '../../../resources/adminlte/plugins/iCheck/square/blue.css',
    ], 'public/css/admin/login.css');

    // bootstrap fonts
    mix.copy(
        'resources/adminlte/bootstrap/fonts',
        'public/css/fonts'
    );

    // bootstrap fonts, build
    mix.copy(
        'resources/adminlte/bootstrap/fonts',
        'public/build/css/fonts'
    );

   // iCheck-square-blue
    mix.copy('resources/adminlte/plugins/iCheck/square/blue.png', 'public/css/admin/blue.png');
    mix.copy('resources/adminlte/plugins/iCheck/square/blue@2x.png', 'public/css/admin/blue@2x.png');
    mix.copy('resources/adminlte/plugins/iCheck/square/blue.png', 'public/build/css/admin/blue.png');
    mix.copy('resources/adminlte/plugins/iCheck/square/blue@2x.png', 'public/build/css/admin/blue@2x.png');

    mix.scripts([
        '../../../resources/adminlte/plugins/jQuery/jquery-2.2.3.min.js',
        '../../../resources/adminlte/bootstrap/js/bootstrap.min.js',
        '../../../resources/adminlte/plugins/iCheck/icheck.min.js',
    ] , 'public/js/admin/login.js');

    mix.version(['public/css/admin/login.css', 'public/js/admin/login.js']);
});

/**
 * Admin main
 */
elixir(mix => {

    mix.less([
        '../../../bower_components/bootstrap/less/bootstrap.less',

        // Theme
        '../../../resources/adminlte/build/bootstrap-less/mixins.less',
        '../../../resources/adminlte/build/bootstrap-less/variables.less',
        '../../../resources/adminlte/build/less/AdminLTE.less',
        '../../../resources/adminlte/build/less/skins/skin-blue.less'

    ], 'public/css/admin/adminlte-admin.css');

    mix.sass([
        '../../../bower_components/datatables-buttons/css/buttons.dataTables.scss',
        '../../../bower_components/datatables-buttons/css/buttons.bootstrap.scss'
    ] , 'public/css/admin/buttons.dataTables.css');

    mix.styles([

        // '../../../resources/assets/css/select2.min.css',
        '../../../bower_components/select2/dist/css/select2.min.css',

        // '../../../resources/adminlte/bootstrap/css/bootstrap.css',
        '../../../public/css/admin/adminlte-admin.css', // compile above - theme
        // '../../../public/css/admin/adminlte-skin-blue.css',

        // '../../../resources/adminlte/plugins/iCheck/flat/blue.css',

        '../../../resources/assets/admin/css/dataTables.bootstrap.css',
        '../../../public/css/admin/buttons.dataTables.css',

        '../../../resources/assets/admin/css/override.css'

    ], 'public/css/admin/main.css');

    mix.copy(
        'resources/assets/admin/images/loading_bar.gif',
        'public/images'
    );

    mix.scripts([
        '../../../bower_components/jquery/dist/jquery.min.js',
        // '../../../resources/adminlte/plugins/jQuery/jquery-2.2.3.min.js',

        // '../../../resources/adminlte/bootstrap/js/bootstrap.min.js',
        '../../../bower_components/bootstrap/dist/js/bootstrap.min.js',

        // '../../../resources/adminlte/plugins/iCheck/icheck.min.js',

        // '../../../resources/assets/js/select2.min.js'
        '../../../bower_components/select2/dist/js/select2.min.js',

        // Datatables
        '../../../bower_components/datatables/media/js/jquery.dataTables.js',
        '../../../bower_components/datatables/media/js/dataTables.bootstrap.js',
        // Datatables button
        '../../../bower_components/datatables-buttons/js/dataTables.buttons.js',
        '../../../bower_components/datatables-buttons/js/buttons.bootstrap.js',
        '../../../public/vendor/datatables/buttons.server-side.js',

        // Theme
        '../../../resources/adminlte/dist/js/app.js'
    ] , 'public/js/admin/main.js');

    mix.version(['public/css/admin/main.css', 'public/js/admin/main.js']);

});

