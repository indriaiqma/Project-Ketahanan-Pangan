import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

// Kumpulkan semua file .css di resources/css/pages (termasuk subfolder)
// supaya tidak perlu didaftarkan satu per satu.
function cssHalaman(dir = 'resources/css/pages') {
    if (!fs.existsSync(dir)) return [];

    return fs.readdirSync(dir, { withFileTypes: true }).flatMap((entry) => {
        const full = path.posix.join(dir, entry.name);
        if (entry.isDirectory()) return cssHalaman(full);
        return entry.name.endsWith('.css') ? [full] : [];
    });
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Global
                'resources/css/app.css',
                'resources/js/app.js',

                // CSS per layout
                'resources/css/viewer.css',
                'resources/css/admin.css',

                // CSS per halaman (otomatis)
                ...cssHalaman(),
            ],
            refresh: true,
        }),
    ],
});