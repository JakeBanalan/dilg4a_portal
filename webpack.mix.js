const mix = require('laravel-mix');
const webpack = require('webpack');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

// Inject Vue feature flags and add alias resolution
mix.webpackConfig({
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm-bundler.js'
        }
    },
    plugins: [
        new webpack.DefinePlugin({
            '__VUE_PROD_HYDRATION_MISMATCH_DETAILS__': JSON.stringify(false),
            '__VUE_OPTIONS_API__': JSON.stringify(true),
            '__VUE_PROD_DEVTOOLS__': JSON.stringify(false)
        })
    ]
});

mix.disableNotifications();
