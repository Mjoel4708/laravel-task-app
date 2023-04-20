<template>
    <div class="home-container">
      <h2>Welcome to Task App</h2>
      <p>Task App is a simple task management application built with Laravel and Vue.js.</p>
      <p>Please login to access the features of the app.</p>
    </div>
  </template>
  
  <script>
  export default {
    // You can add any additional logic or data properties for the home page here
    name: 'Home'
  }
  </script>
  
  <style scoped>
  .home-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
    text-align: center;
  }
  
  h2 {
    margin-top: 0;
  }
  
  p {
    margin-bottom: 1rem;
  }
  </style>
  