
declare global {
	interface Window {
		Echo:any;
		appSettings:any;
		Pusher:any;
	}
}

import {createApp} from 'vue';
import {createPinia} from 'pinia';
import { createI18n } from 'vue-i18n'

import App from './App.vue';
import router from './router/frontend_router_vue';
import settings from './app';

import './assets/main.scss';

// Locale
let messages:{ru:any; en:any;} = {ru:{}, en:{}};

import en from '../locales/en_frontend.json';
import ru from '../locales/ru_frontend.json';

import 'moment/locale/ru';

settings.availableLocale.forEach(locale => {
    if (locale === 'ru') messages[locale] = ru
    if (locale === 'en') messages[locale] = en
})


const i18n = createI18n({
    legacy: false, // you must set `false`, to use Composition API
    locale: settings.locale,
    globalInjection: true,
    fallbackLocale: settings.fallbackLocale, // set fallback locale
    messages
});

// Websockets
import Echo from 'laravel-echo';
import Pusher from 'pusher-js'

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'app-key',
    auth:{
        headers:{
            'Authorization': 'Bearer ' + window.localStorage.getItem("token"),
        }
    },
    wsHost: import.meta.env.VITE_APP_URL_CORE,
    host: import.meta.env.VITE_APP_URL_CORE,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    wssPort: import.meta.env.VITE_PUSHER_PORT,
    authEndpoint: import.meta.env.VITE_URL + "broadcasting/auth",
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: false,
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

const app = createApp(App);

// Moment settings
import moment from "moment";
moment.locale(settings.locale);
app.config.globalProperties.$moment = moment
app.provide("moment", moment);

window.appSettings = settings;

// Uses
app.use(createPinia());
app.use(router);
app.use(i18n);
app.mount('#app');
