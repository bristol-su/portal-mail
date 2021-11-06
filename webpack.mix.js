const mix = require('laravel-mix');

mix.setPublicPath('./public');

mix.js('resources/js/app.js', 'public/modules/portal-mail/js/app.js').vue()

mix.webpackConfig({
    externals: {
        '@bristol-su/frontend-toolkit': 'Toolkit',
        'vue': 'Vue',
    }
});
