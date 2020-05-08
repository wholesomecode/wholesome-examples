const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin');
const IgnoreEmitWebpackPlugin = require( 'ignore-emit-webpack-plugin' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const OptimizeCssAssetsWebpackPlugin = require('optimize-css-assets-webpack-plugin');
const path = require('path');
const postcssPresetEnv = require( 'postcss-preset-env' );
const StylelintWebpackPlugin = require( 'stylelint-webpack-plugin' );
const TerserWebpackPlugin = require( 'terser-webpack-plugin' );

module.exports = {
    ...defaultConfig,
    entry: {
		...defaultConfig.entry,
		style: path.resolve( process.cwd(), 'src', 'style.scss' ),
		editor: path.resolve( process.cwd(), 'src', 'editor.scss' ),
    },
    module: {
        ...defaultConfig.module,
        rules: [
            ...defaultConfig.module.rules,
            {
                test: /\.js$/,
                include: /src/,
                exclude: /node_modules/,
                loader: 'eslint-loader',
                options: {
                    fix: true,
                },
            },
            {
                test: /\.s[ac]ss$/i,
                use: [
                    { loader: MiniCssExtractPlugin.loader },
                    { loader: 'css-loader' },
                    {
						loader: 'postcss-loader',
						options: {
							plugins: () => [ postcssPresetEnv( { stage: 3 } ) ],
						},
					},
                    { loader: 'sass-loader' },
                ],
            },
        ],
    },
    optimization: {
        ...defaultConfig.optimization,
        minimize: true,
        minimizer: [
            new OptimizeCssAssetsWebpackPlugin(),
            new TerserWebpackPlugin(),
        ],
	},
    plugins: [
        ...defaultConfig.plugins,
        new FriendlyErrorsWebpackPlugin(),
        new IgnoreEmitWebpackPlugin( [ 'editor.js', 'editor.asset.php', 'style.js', 'style.asset.php', ] ),
        new StylelintWebpackPlugin({
            files: 'src/*.s?(a|c)ss',
            failOnError: true,
            fix: true,
            syntax: 'scss',
		}),
        new MiniCssExtractPlugin( {
            filename: '../build/[name].css',
        } ),
    ],
};
