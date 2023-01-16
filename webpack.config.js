const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', ['./assets/js/app.js'])
    .autoProvidejQuery()
    .addStyleEntry('css/app', './assets/css/app.css')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    ;

module.exports = Encore.getWebpackConfig();
