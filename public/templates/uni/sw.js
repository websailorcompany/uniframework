self.addEventListener('install', function(e) {
  let timeStamp = Date.now();
  e.waitUntil(
     caches.open('pwaction').then(function(cache) {
       return cache.addAll([
         `/`,
         `/index.php?timestamp=${timeStamp}`,
         `/pwaction/pwaction.js?timestamp=${timeStamp}`,
         `/pwaction/pwaux.js?timestamp=${timeStamp}`,
         `/pwaction/pws.js?timestamp=${timeStamp}`,
         `/templates/uni/css/bootstrap.min.css?timestamp=${timeStamp}`,
         `/templates/uni/css/font-awesome.min.css?timestamp=${timeStamp}`,
         `/templates/uni/js/jquery.min.js?timestamp=${timeStamp}`,
         `/templates/uni/js/bootstrap.min.js?timestamp=${timeStamp}`,
         `/templates/uni/js/scripts.js?timestamp=${timeStamp}`
       ]);
     })
   );
});
self.addEventListener('activate',  event => {
  event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request, {ignoreSearch:true}).then(response => {
      return response || fetch(event.request);
    })
  );
});
