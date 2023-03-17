import commonjs from '@rollup/plugin-commonjs';
import { nodeResolve } from '@rollup/plugin-node-resolve';
import { babel } from '@rollup/plugin-babel';
import { terser } from 'rollup-plugin-terser';
import postcss from 'rollup-plugin-postcss';
import glob from 'glob';


/**
*
* Specify the project textdomain/slug/prefix. 
*
*/

const textdomain = 'addonify-wishlist';


/**
*
* Specify the entry points for the common js files.
* They will be bundled together in one file.
* 
*/

const commonJavaScriptFiles = glob.sync('public/assets/src/js/custom/**/*.js');

/**
*
* Specify the entry points for the conditional js files.
* They will be kept in separate files.
* 
*/

const conditionalJavaScriptFiles = glob.sync('public/assets/src/conditional**/*.js');

/**
*
* Specify the entry points for SASS files.
* These files will be bundled together in one file.
*/

const commonSassFiles = glob.sync('public/assets/src/sass/index.scss');


/**
*
* Specify the output for following types:
* 
* Common js files: /public/assets/build/js/addonify-wishlist.min.js
* Conditional js files: /public/assets/build/conditional/*
* Common css files: /public/assets/build/css/addonify-wishlist.min.css
*/

const commonJavaScriptFilesOutput = `public/assets/build/js/${textdomain}.min.js`;
const conditionalJavaScriptFilesOutput = 'public/assets/build/conditional/';
const commonCssFilesOutput = `public/assets/build/css/${textdomain}.min.css`;

export default {
    input: {
        common: 'src/js/common/index.js',
        ...conditionalFiles.reduce((entries, file) => {
            entries[file.replace(/^src\/js\//, '').replace(/\.js$/, '')] = file;
            return entries;
        }, {}),
    },
    output: [
        {
            dir: 'dist/common',
            format: 'esm',
        },
        ...conditionalFiles.map((file) => {
            return {
                file: `dist/${file.replace(/^src\/js\//, '').replace(/\.js$/, '')}.min.js`,
                format: 'iife',
                name: file.replace(/^src\/js\/conditional/, 'conditional').replace(/\.js$/, ''),
                plugins: [terser()],
            };
        }),
    ],
    plugins: [
        nodeResolve(),
        commonjs(),
        babel({
            babelHelpers: 'bundled',
            presets: ['@babel/preset-env'],
        }),
        postcss({
            extract: 'dist/css/app.css',
            minimize: true,
            sourceMap: true,
            plugins: [require('autoprefixer'), require('cssnano')],
            modules: false,
            use: ['sass'],
            inject: {
                insertAt: 'top',
            },
            sass: {
                includePaths: ['node_modules'],
                input: 'src/sass/app.scss',
            },
            extensions: ['.scss'],
            exclude: ['node_modules/**'],
            ignoreGlobal: false,
            watch: 'src/sass/**/*',
        }),
    ],
};
