const settings = {
    locale: window.navigator.language.substr(0,2),
    fallbackLocale: 'en',
    availableLocale: [
        'ru',
        'en',
    ],
    appUrl: import.meta.env.VITE_URL
        ? import.meta.env.VITE_URL
        : window.location.hostname
    ,
}
export default settings;
