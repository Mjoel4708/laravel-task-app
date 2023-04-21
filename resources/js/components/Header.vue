<template>
    <header class="header">
      <nav>
        <ul>
          <li><router-link to="/">Home</router-link></li>
          <li v-if="isAuthenticated"><router-link to="/tasks">Tasks</router-link></li>
          <li v-if="isAuthenticated"><router-link to="/profile">Profile</router-link></li>
          <li v-if="isAuthenticated" class="auth"><a href="#" @click="logout">Logout</a></li>
          <li v-else class="auth"><router-link to="/login">Login</router-link></li>

          
        </ul>
      </nav>
    </header>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    
    data() {
      return {
        isAuthenticated: false,
        token: null,
        isLoaded: false
      };
    },
    mounted() {
      
    },
    methods: {
      logout() {
        localStorage.removeItem('token');
        this.isAuthenticated = false;
        this.$router.go();
        this.$router.push('/login');
      }
    },
    mounted() {
      // check of token is present
      // if yes, set isAuthenticated to true
      if(typeof localStorage.getItem('token') !== 'undefined' && localStorage.getItem('token') !== null) {
        this.isAuthenticated = true;
        this.token = localStorage.getItem('token');
      }
    },
    watch: {
      isAuthenticated() {
        if(this.isAuthenticated) {
          this.$router.push('/tasks');
        }
      }
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
  