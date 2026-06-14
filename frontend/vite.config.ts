import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import { fileURLToPath, URL } from 'node:url';

const alias = (p: string) => fileURLToPath(new URL(p, import.meta.url));

export default defineConfig({
  plugins: [vue(), tailwindcss()],
  server: {
    port: 5173
  },

  resolve: {
    alias: {
      '@': alias('./src')
    }
  }
});
