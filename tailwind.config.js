const defaultTheme = require("tailwindcss/defaultTheme");

const min_max_widths = {};

const widths = {};

const safe = [];

for (let denominator = 1; denominator <= 12; denominator++) {
    for (let numerator = 1; numerator <= denominator; numerator++) {
        let idx = numerator + "/" + denominator;
        min_max_widths[idx] = `${
            (numerator / denominator) * 100
        }%`;
        safe.push('min-w-' + idx);
        safe.push('max-w-' + idx);
    }
}

for (let val = 1; val <= 50; val++) {
    let val4 = val * 4;
    widths[val4] = `${val}rem`;
    min_max_widths[val4] = `${val}rem`;
    safe.push('w-' + val4);
}

module.exports = {
    purge: {
        content: [
            "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
            "./vendor/laravel/jetstream/**/*.blade.php",
            "./storage/framework/views/*.php",
            "./resources/views/**/*.blade.php",
            "./resources/js/**/*.vue",
        ],
        safelist: safe,
    },
    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            width: widths,
        },
        minWidth: min_max_widths,
        maxWidth: min_max_widths,
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
