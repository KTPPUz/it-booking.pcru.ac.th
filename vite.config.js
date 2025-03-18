import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // build: {
    //     outDir: 'public_html/build', // ตั้งค่าปลายทางของไฟล์ build
    //     manifest: true,         // เปิดใช้งานการสร้าง manifest.json
    //     emptyOutDir: true,      // ลบไฟล์เก่าใน build folder
    // },
});
