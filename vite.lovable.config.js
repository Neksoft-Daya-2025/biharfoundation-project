import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import path from 'path';
import { fileURLToPath } from 'url';
import { defineConfig } from 'vite';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

export default defineConfig({
    root: path.resolve(__dirname, 'resources/js/lovable'),
    base: '/themes/lovable/',
    publicDir: false,
    plugins: [react(), tailwindcss()],
    css: {
        postcss: {},
    },
    build: {
        outDir: path.resolve(__dirname, 'public/themes/lovable'),
        emptyOutDir: true,
        assetsDir: 'assets',
        rollupOptions: {
            input: path.resolve(__dirname, 'resources/js/lovable/index.html'),
        },
    },
    server: {
        port: 5174,
        strictPort: false,
    },
});
