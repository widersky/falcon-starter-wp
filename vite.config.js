import { defineConfig, loadEnv } from 'vite';
import liveReload from 'vite-plugin-live-reload';
const { resolve } = require('path');
const fs = require('fs');

export default ({ mode }) => {
  process.env = {...process.env, ...loadEnv(mode, process.cwd())};

  const themeName = process.env.VITE_THEME_NAME;
  const pathToTheme = __dirname + '/wp-content/themes/' + themeName;

  return defineConfig({
    plugins: [
      liveReload(pathToTheme + '/**/*.php')
    ],

    root: '',
    base: process.env.NODE_ENV === 'development'
      ? pathToTheme + '/'
      : pathToTheme + '/dist/',

    build: {
      outDir: resolve(pathToTheme, './dist'),
      emptyOutDir: true,
      manifest: true,
      target: 'es2018',
      rollupOptions: {
        input: {
          main: resolve( __dirname + '/main.js')
        },
      },
      minify: true,
      write: true
    },

    server: {
      cors: true,
      strictPort: true,
      port: 3000,
      https: false,
      hmr: {
        host: 'localhost',
      },

    },
  });
}
