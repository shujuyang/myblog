var mypath = require('path')
var htmlPlugin = require('html-webpack-plugin')
module.exports = {
    entry: './resources/assets/js/app.js',
    output: {
        path: mypath.join(__dirname,'/public/home/dist'),
        filename: 'hebing.js'
    },
    module: {
        // 不知是可以打包 H-ui，还可以打包less
        // 也可以处理sass，或者 *.vue ，图片，或者字体
        rules: [
            {
                test: /\.css$/, // 匹配css文件
                loader: ['style-loader', 'css-loader']
            },
            {
                test: /\.(ttf|woof|woof2|svg|eot)$/,  // 匹配各种后缀的字体文件
                loader:['file-loader?name=./fonts/[name].[ext]']
            },
            {
                test: /\.(jpg|jpeg|png|bmp|gif|svg)$/,  // 匹配各种格式的图片
                loader: ['url-loader']
            },
            {
                test: /\.vue$/,
                loader: ['vue-loader']
            },
            {
                test: /\.js$/,
                loader: 'babel-loader', // 需要下载 babel-loader这个包和babel-preset-es2015这个包
                exclude: /node_modules/ // 忽略node_modules文件夹，不要去将node_modules中的js转换为es5
            }
        ]
    }
}