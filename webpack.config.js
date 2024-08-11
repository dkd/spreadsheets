import TerserPlugin from "terser-webpack-plugin";
import path from "path";
import * as url from 'url';

const __dirname = url.fileURLToPath(new URL('.', import.meta.url));

export default (env, argv) => ({
    optimization: {
        minimizer: [
            new TerserPlugin({
                parallel: true,
                terserOptions: {
                    output: {
                        comments: false,
                    },
                },
                extractComments: false,
            }),
        ],
    },
    entry: {
        "SpreadsheetDataInput": path.join(__dirname, "/Resources/Private/Assets/JavaScript/main.js"),
    },
    module: {
        rules: [
            {
                test: /\.(js)$/,
                exclude: /node_modules/,
                use: [
                    "babel-loader",
                ],
            }
        ]
    },
    output: {
        filename: "[name].js",
        libraryTarget: "amd",
        path: path.join(__dirname, "/Resources/Public/JavaScript"),
        publicPath: argv.mode !== "production" ? "/" : "../dist/"
    },
    externals: {
        "DocumentService": "TYPO3/CMS/Core/DocumentService",
    }
});
