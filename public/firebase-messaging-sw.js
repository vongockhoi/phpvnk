importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    event.waitUntil(self.clients.openWindow(event.notification.data.FCM_MSG.data.orderUrl));
});

firebase.initializeApp({
    apiKey: "AIzaSyA7HHDo6ZVY5omFS3Q3STT1MLvzkUgecQQ",
    authDomain: "nori-food.firebaseapp.com",
    databaseURL: "https://nori-food.firebaseio.com",
    projectId: "nori-food",
    storageBucket: "nori-food.appspot.com",
    messagingSenderId: "466567384802",
    appId: "1:466567384802:web:ccd98ec6a25f52099018bb",
    measurementId: "G-N65BCB1MHH"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    // const notificationTitle = 'New message';
    // const notificationOptions = {
    //     body: 'You just got a new message'
    // };
    // self.registration.showNotification(notificationTitle,
    //     notificationOptions);
});

