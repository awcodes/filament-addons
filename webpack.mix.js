const mix = require("laravel-mix");

mix.disableNotifications();

mix.setPublicPath("./resources/dist")
    .postCss("./resources/css/filament-addons.css", "filament-addons.css", [
        require("tailwindcss")("./tailwind.config.js"),
    ])
    .options({
        processCssUrls: false,
    });
