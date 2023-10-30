import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';

export default ({ mode }) => {
  if (mode === 'development') {
    mode = '';
  }
  process.env = {...process.env, ...loadEnv(mode, process.cwd(), '')};

  return defineConfig({
    resolve: {
      alias: {
        '@': 'resources/js',
        '~': 'resources/',
        'ziggy-js': 'vendor/tightenco/ziggy/dist/vue.es.js',
      }
    },
    server: {
      host: process.env.VITE_HMR_URL,
      port: process.env.VITE_HMR_PORT,
      watch: {
        ignored: ['**/vendor/**', '**/storage/**'],
      },
    },
    plugins: [
      vue({
        template: {
          transformAssetUrls: {
            base: null,
            includeAbsolute: false,
          },
        },
      }),
      laravel({
        input: ['resources/css/app.css', 'resources/js/app.js'],
        refresh: true,
      }),
    ],
    // assetsInclude: ['./public/assets/images/**.png'],
    build: {
      rollupOptions: {
        output: {
          manualChunks: () => 'app',
          entryFileNames: `assets/[name].js`,
          // chunkFileNames: `assets/[name].js`,
          assetFileNames: `assets/[name].[ext]`
        }
      }
    }
  });
};
    
