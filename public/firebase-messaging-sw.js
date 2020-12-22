/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/

importScripts('https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
    apiKey: "AIzaSyAdFTQbVACDmHy5QqaVYZby4iktlKywcFM",
    authDomain: "fir-notification-216ed.firebaseapp.com",
    databaseURL: "https://fir-notification-216ed-default-rtdb.firebaseio.com",
    projectId: "fir-notification-216ed",
    storageBucket: "fir-notification-216ed.appspot.com",
    messagingSenderId: "268566207438",
    appId: "1:268566207438:web:e7b57b412477b95cbaa99f",
    measurementId: "G-VJBSG41916"


    });
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );

    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/logo.png",
    };
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});
