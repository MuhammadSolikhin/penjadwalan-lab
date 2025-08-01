import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/form-pengajuan.css',
                'resources/js/app.js',
                'resources/js/pengguna/booking/form-pengajuan-booking.js',
                'resources/js/pengguna/booking/calendar.js',
                'resources/js/admin/pengguna-page/pengguna.js',
                'resources/js/laboran/laboratorium-page/laboratorium.js'
            ],
            refresh: true,
        }),
    ],
});
