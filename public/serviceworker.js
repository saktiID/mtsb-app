var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    "/offline",
    "/meta.jpeg",
    "/audio/error.mp3",
    "/audio/success.mp3",
    "/images/icons/kemerdekaan/icon-72x72.png",
    "/images/icons/kemerdekaan/icon-96x96.png",
    "/images/icons/kemerdekaan/icon-128x128.png",
    "/images/icons/kemerdekaan/icon-144x144.png",
    "/images/icons/kemerdekaan/icon-152x152.png",
    "/images/icons/kemerdekaan/icon-192x192.png",
    "/images/icons/kemerdekaan/icon-384x384.png",
    "/images/icons/kemerdekaan/icon-512x512.png",
    "/bootstrap/css/bootstrap.min.css",
    "/assets/css/plugins.css",
    "/assets/css/authentication/form-2.css",
    "/assets/css/forms/switches.css",
    "/assets/js/libs/jquery-3.1.1.min.js",
    "/bootstrap/js/popper.min.js",
    "/bootstrap/js/bootstrap.min.js",
    "/assets/js/authentication/form-2.js",
    "/feather/feather.min.js",
    "/assets/css/loader.css",
    "/assets/js/loader.js",
    "/assets/css/main.css",
    "/assets/css/elements/alert.css",
    "/assets/css/scrollspyNav.css",
    "/plugins/bootstrap-select/bootstrap-select.min.css",
    "/plugins/bootstrap-icons/bootstrap-icons.min.css",
    "/plugins/bootstrap-toaster/bootstrap-toaster.min.css",
    "/plugins/perfect-scrollbar/perfect-scrollbar.min.js",
    "/plugins/bootstrap-toaster/bootsrap-toaster.min.js",
    "/assets/js/app.js",
    "/assets/js/custom.js",
    "/assets/js/scrollspyNav.js",
    "/assets/js/internet-status.js",
    "/assets/img/not-found.png",
];

// Cache on install
self.addEventListener("install", (event) => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            return cache.addAll(filesToCache);
        })
    );
});

// Clear cache on activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => cacheName.startsWith("pwa-"))
                    .filter((cacheName) => cacheName !== staticCacheName)
                    .map((cacheName) => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", (event) => {
    event.respondWith(
        caches
            .match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match("offline");
            })
    );
});

// Push Notification -- ini adalah push notif dari server menggunakan key public atau private
self.addEventListener("push", (event) => {
    //  {"title": "Assessment Records", "body": "Berhasil horee", "url": "/"}
    const notification = event.data.json();
    console.log(notification);

    event.waitUntil(
        self.registration.showNotification(notification.title, {
            body: notification.body,
            icon: "/logo.png",
            vibrate: [500, 200, 500],
            badge: "/logo.png",
            data: {
                notifURL: notification.url,
            },
        })
    );
});

// Event click Notification
self.addEventListener("notificationclick", (event) => {
    event.notification.close();
    event.waitUntil(clients.openWindow("/"));
    // event.waitUntil(clients.openWindow(event.notification.data.notifURL));
});
