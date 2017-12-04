module.exports = {
    entry : {
        map: ["./js/pages/map.js"]
    },
    output: {
        path: __dirname + "/bundle",
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
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test   : /\.less$/,
                exclude: /node_modules/,
                loader : 'style!css!less'
            },
            {
                test   : /\.(jpg|png|gif)$/,
                include: /images/,
                loader : 'url'
            },
            {
                test: /\.hbs$/,
                exclude: /node_modules/,
                loader: "handlebars-loader"
            }
        ]
    }
};