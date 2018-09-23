let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
let glob = require("glob-all");
let PurgecssPlugin = require("purgecss-webpack-plugin");

class TailwindExtractor {
    static extract(content) {
        return content.match(/[A-Za-z0-9-_:\/]+/g) || [];
    }
}

mix.js('src/resources/assets/js/app.js', 'public/js')
    .sass('src/resources/assets/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('tailwind.js') ],
    })
    .sourceMaps();

if(mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new PurgecssPlugin({

                // Specify the locations of any files you want to scan for class names.
                paths: glob.sync([
                    path.join(__dirname, "src/resources/views/**/*.blade.php"),
                    path.join(__dirname, "src/resources/assets/js/**")
                ]),
                extractors: [
                    {
                        extractor: TailwindExtractor,

                        // Specify the file extensions to include when scanning for
                        // class names.
                        extensions: ["js", "php", "vue"]
                    }
                ]
            })
        ]
    });
}
