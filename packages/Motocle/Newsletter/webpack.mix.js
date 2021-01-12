const { mix } = require("laravel-mix");
require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    var publicPath = "publishable/assets";
} else {
    var publicPath = "../../../public/vendor/motocle/newsletter/assets";
}

mix.setPublicPath(publicPath).mergeManifest();

mix.disableNotifications();

mix.js([__dirname + "/src/Resources/assets/js/app.js"], "js/newsletter.js")
    .copyDirectory( __dirname + '/src/Resources/assets/js/tinymce', publicPath + '/js/tinymce')
    .options({
        processCssUrls: false
    });

if (mix.inProduction()) {
    mix.version();
}
