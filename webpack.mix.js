let mix = require('laravel-mix');

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                exclude: /node_modules\/(?!(dom7|swiper)\/).*/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: Config.babel()
                    }
                ]
            }
        ]
    },
    resolve: {
        alias: {
            '@': path.resolve('resources/assets'),
            '~': path.resolve('resources'),
            'swiper/dist/js/swiper.esm.bundle.js': 'swiper/dist/js/swiper.js',
        }
    }
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

/**
 * Frontend
 */
mix
    .js('src/js/frontend.js', 'assets/js/frontend.min.js')
    .sass('src/scss/frontend.scss', 'assets/css/frontend.min.css')
    .options({
        processCssUrls: false
    })
;

/**
 * Components
 */
mix

    .sass('src/scss/components/hero.scss', 'assets/css/components/hero.min.css')
    .sass('src/scss/components/logos.scss', 'assets/css/components/logos.min.css')
    .sass('src/scss/components/form.scss', 'assets/css/components/form.min.css')
    .sass('src/scss/components/slider.scss', 'assets/css/components/slider.min.css')
    .sass('src/scss/lib/swiper.scss', 'assets/css/lib/swiper.min.css')

    .js('src/js/components/order-form.js', 'assets/js/components/order-form.min.js')
    .js('src/js/components/slider.js', 'assets/js/components/slider.min.js')
;


/**
 * Admin
 */
// mix
//     .sass('src/scss/admin.scss', 'assets/css/admin.min.css')
//     .js('src/js/admin.js', 'assets/js/admin.min.js');

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
