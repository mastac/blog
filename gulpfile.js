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

elixir(mix => {

    mix.sass('app.scss')
    mix.webpack('app.js');

    mix.sass('blog.scss');

    mix.styles([
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/ionicons.min.css',
        'resources/assets/css/animate.css',
        'resources/assets/css/slider.css',
        'resources/assets/css/owl.carousel.css',
        'resources/assets/css/owl.theme.css',
        'resources/assets/css/jquery.fancybox.css',
        'resources/assets/css/main.css',
        'resources/assets/css/responsive.css',

        'resources/assets/css/select2.min.css',

    ],'public/css/blog.css');

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
