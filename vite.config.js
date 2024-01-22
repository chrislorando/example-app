import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
// import * as path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    // resolve: {
    //     alias: {
    //         "~bootstrap-icons": path.resolve(
    //             __dirname,
    //             "node_modules/bootstrap-icons"
    //         ),
    //     },
    // },
});
