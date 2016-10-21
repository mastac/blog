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
        // 'public/css/app.css',
        'resources/assets/css/select2.min.css',
        '../../../public/css/blog.css'
    ],'public/css/blog.css');

    mix.scripts([
        // 'public/js/app.js',
        'select2.min.js',
        'blog.js',
    ], 'public/js/blog.js');

    mix.version(['public/css/blog.css','public/js/blog.js']);
});
