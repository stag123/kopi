const path = require("path");

module.exports = {
    devtool: 'eval-source-map',
    entry : {
        map: ["./js/pages/map.js"],
        site: ["./js/pages/site.js"],
        village: ["./js/pages/village.js"],
    },
    output: {
        path: path.resolve(__dirname, "bundle"),
        filename: "[name].page.js"
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['env']
                    }
                }
            },
            {
                test: /\.less$/,
                exclude: /node_modules/,
                use: [{
                    loader: "style-loader" // creates style nodes from JS strings
                }, {
                    loader: "css-loader" // translates CSS into CommonJS
                }, {
                    loader: "less-loader" // compiles Less to CSS
                }]
            },
            {
                test: /\.(png|jp(e*)g|svg)$/,
                use: [{
                    loader: 'url-loader?name=images/[name].[ext]',
                    options: {
                        limit: 8000, // Convert images < 8kb to base64 strings
                        name: 'images/[hash]-[name].[ext]'
                    }
                }]
            },
            {
                test: /\.hbs$/,
                exclude: /node_modules/,
                loader: "handlebars-loader",
                options: {
                    helperDirs: [
                        path.resolve(__dirname, "js/helpers")
                    ]
                }
            }
        ]
    }
};