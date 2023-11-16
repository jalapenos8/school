import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
      rollupOptions: {
        output: {
          chunkFileNames: 'resources/js/[name]-[hash].js',
          entryFileNames: 'resources/js/[name]-[hash].js',
          
          assetFileNames: ({name}) => {         
            if (/\.js$/.test(name ?? '')) {
                return 'resources/js/[name]-[hash][extname]';   
            }

            if (/\.css$/.test(name ?? '')) {
                return 'resources/css/[name]-[hash][extname]';   
            }
   
            // default value
            // ref: https://rollupjs.org/guide/en/#outputassetfilenames
            return 'resources/[name]-[hash][extname]';
          },
        },
      }
    },
});
