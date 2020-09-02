module.exports = {
    configureWebpack: {
        devtool: 'source-map',
    },
    publicPath: '/',
    outputDir: 'web',
    assetsDir: 'assets',
    runtimeCompiler: true,
    devServer: {
        public: 'testinn-dev.local'
    }
};