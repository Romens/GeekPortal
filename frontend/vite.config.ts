import {fileURLToPath, URL} from 'node:url';

import {defineConfig} from 'vite';
import vue from '@vitejs/plugin-vue';
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'
import path from 'path'
import {VitePWA} from 'vite-plugin-pwa'

// @ts-ignore
import manifest from './webmanifest.json'

const isProduction: boolean = process.env.NODE_ENV !== 'development';
const isLaravel: boolean = process.env.VITE_DRIVER === 'laravel';

const base = isProduction
	? '/'
	: '/'
;

const outputPath: string = isLaravel ?  '../public/app' : './dist'
// const outputPath: string = './dist'

export default defineConfig({
	base: base,
	plugins: [
		VitePWA({
			registerType: 'autoUpdate',
			filename: 'catalog.js',
			workbox: {
				globPatterns: ['**/**/*.{js,css,html,ico,png,svg}'],
				sourcemap: true,
				cleanupOutdatedCaches: false
			},
			manifest,
			devOptions: {
				enabled: true,
			}
		}),
		VueI18nPlugin({
			include: [path.resolve(__dirname, './locales/**')],
		}),
		vue({
			template: {
				transformAssetUrls: {
					base: '/src'
				}
			}
		}),
	],
	server: {
		watch: {
			usePolling: true
		}
	},
	build: {
		outDir: outputPath,
	},
	resolve: {
		alias: {
			'@': fileURLToPath(new URL('./src', import.meta.url))
		}
	}
})
