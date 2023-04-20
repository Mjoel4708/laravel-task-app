<template>
    <header class="header">
      <nav>
        <ul>
          <li><router-link to="/">Home</router-link></li>
          <li><router-link to="/tasks">Tasks</router-link></li>
          <li v-if="isAuthenticated"><router-link to="/profile">Profile</router-link></li>
          <li v-if="isAuthenticated" @click="logout">Logout</li>
          <li class="auth" v-if="!isAuthenticated"><router-link to="/login">Login</router-link></li>
        </ul>
      </nav>
    </header>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isAuthenticated: false
      };
    },
    methods: {
      logout() {
        // Implement your logout logic here
        // Clear user authentication status and perform necessary cleanup
        // Redirect to the appropriate page upon successful logout
      }
    },
    mounted() {
      // You can fetch the user authentication status from your backend API here
      // Update the isAuthenticated data property accordingly
      // You can use a Vuex store or other state management pattern for better separation of concerns
    }
  }
  </script>
  
  <style scoped>
  .header {
    background-color: #011627;
    padding: 1rem;
  }
  
  nav ul {
    display: flex;
    list-style-type: none;
    padding: 0;
  }
  
  nav li {
    margin-right: 1rem;
  }
  
  nav a {
    color: #fff;
    text-decoration: none;
  }
  
  nav a:hover {
    text-decoration: underline;
  }
  nav .auth {
    margin-left: auto;
  }

  @media (max-width: 768px) {
    nav ul {
      flex-direction: column;
    }
    nav li {
      margin-right: 0;
      margin-bottom: 1rem;
    }
  }

  @media (max-width: 480px) {
    nav li {
      margin-bottom: 0.5rem;
    }
  }

 @media (max-width: 320px) {
    nav li {
      margin-bottom: 0.25rem;
    }
  } 
  </style>
  