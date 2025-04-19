const webpack = require('webpack');
const path = require('path');
const StyleLintPlugin = require('stylelint-webpack-plugin');

const env = {
	mode: "development",
	date: Number(new Date())
};

let fs = require('fs');
fs.writeFile("env.json", JSON.stringify(env), function (err) {
	if (err) {
		console.log(err);
	}
});

module.exports = {
	target: "web",
	entry: {
		gutenberg: './admin/gutenberg/source/blocks.js',
	},
	mode: 'development',
	devtool: 'eval',
	module: {
		rules: [
			{
				test: /\.scss$/,
				use: [
					'style-loader',
					{
						loader: 'css-loader',
						options: {
							sourceMap: true
						}
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true,
						}
					}
				],
			},
			{
				test: /\.css$/,
				use: ['style-loader', 'css-loader?sourceMap'],
			},
			{
				test: /\.(gif|png|jpe?g|svg)$/i,
				type: 'asset/resource',
			},
			{
				test: /\.(woff|woff2|eot|ttf|otf)$/,
				type: 'asset/resource',
			},
		]
	},
	output: {
		filename: 'gutenberg.js',
		path: path.join(__dirname, '/bundle'),
		assetModuleFilename: 'images/[name][ext][query]'
	},
	externals: {
		jquery: 'jQuery'
	},
	plugins: [
		new webpack.ProvidePlugin({
			$: "jquery",
			jQuery: "jquery",
			"window.jQuery": "jquery",
		}),
		new StyleLintPlugin({
			failOnError: false,
			syntax: 'scss',
		}),
	],
};
