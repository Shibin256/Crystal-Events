// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyAXBtDovKUhwEMIJ5kLX9Va-KqNjvT1qYE",
  authDomain: "event-management-web-portal.firebaseapp.com",
  databaseURL: "https://event-management-web-portal-default-rtdb.firebaseio.com",
  projectId: "event-management-web-portal",
  storageBucket: "event-management-web-portal.appspot.com",
  messagingSenderId: "989843806431",
  appId: "1:989843806431:web:a09a67be999a0ee50ab16a",
  measurementId: "G-J29GYC8T3G"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);



const signupForm = document.getElementById('signup-form');

    signupForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const repeatPassword = document.getElementById('repeat-password').value;
      const acceptTerms = document.getElementById('accept-terms').checked;

      if (!acceptTerms) {
        alert('Please accept the terms and services.');
        return;
      }

      if (password !== repeatPassword) {
        alert('Passwords do not match.');
        return;
      }

      // Create user with email and password
      firebase.auth().createUserWithEmailAndPassword(email, password)
        .then((userCredential) => {
          // User signed up successfully
          const user = userCredential.user;
          console.log('User signed up:', user);
          alert('Sign up successful!');
          // Redirect to another page or perform other actions as needed
        })
        .catch((error) => {
          // Handle sign-up errors
          console.error('Error signing up:', error.message);
          alert('Error signing up. Please try again.');
        });
    });