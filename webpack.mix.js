const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
let module_name = 'module-base';
let output_module_name = module_name;
if (!mix.inProduction()) {
    output_module_name = `${module_name}-dev`;
}
console.log(output_module_name);
// 读取模块化
const path_vendor = path.resolve('vendor/goodcatch');
const fs = require('fs');
const module_files = fs.readdirSync(path_vendor);
const mix_webpack_resolve_alias = {
    '@this': path.resolve('resources/js/'),
    '@': path.join(path_vendor, 'admin/resources/js/')
};

require('laravel-mix-polyfill');

mix.js('resources/js/app.js', `public/dist/${output_module_name}/js`)
    .sass('resources/js/plugins/css/style.scss', `public/dist/${output_module_name}/css`)
    .setPublicPath(`public/dist/${output_module_name}`)
    .setResourceRoot(`/dist/${output_module_name}/`)
    //    .browserSync('127.0.0.1:8000')
    .polyfill({
        enabled: true,
        useBuiltIns: "usage",
        targets: {"firefox": "50", "ie": 11},
    })
    .webpackConfig({
        externals: {
            'vue': 'Vue',
            'vue-router': 'VueRouter',
            'ant-design-vue': 'antd',
            'moment': 'moment',
        },
        output: {
            publicPath: `/dist/${module_name}/`,
            filename: '[name].js',
            chunkFilename : '[name].js?id=[chunkhash:20]'
        },
        resolve: {
            alias: (!!module_files && module_files.length > 0) ? module_files.reduce((alias, folder) => {
                const module_path = path_vendor + '/' + folder;
                try {
                    const module_json = fs.readFileSync(module_path + '/module.json', 'utf8');

                    // parse JSON string to JSON object
                    const module = JSON.parse(module_json);
                    alias ['@' + module.name.toLowerCase()] = module_path + '/resources/js/'

                    console.log(`> module alias resolved @${module.name.toLowerCase()} => ${module_path}/resources/js/`)
                } catch (err) {
                    console.log(`> ignored due to ${module_path} is not laravel module`);
                }

                return alias;
            }, mix_webpack_resolve_alias) : mix_webpack_resolve_alias
        }
    })
    .version();
