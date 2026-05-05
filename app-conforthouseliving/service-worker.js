// Service Worker mínimo para Conforthouse Living PWA
// Su único objetivo es cumplir el requisito de Chrome para mostrar
// el banner nativo de "Add to Home Screen". No hace cache de MadeEasy.

const CACHE_VERSION = 'conforthouse-v1';

self.addEventListener('install', function (event) {
    self.skipWaiting();
});

self.addEventListener('activate', function (event) {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', function (event) {
    // Passthrough: dejamos que el navegador maneje todas las peticiones normalmente.
    // No interceptamos ni cacheamos nada del iframe a MadeEasy.
    return;
});
