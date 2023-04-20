<template>
    <div class="task-detail-container">
      <div v-if="task">
        <div class="task-card">
          <h2>{{ task.name }}</h2>
          <p>{{ task.description }}</p>
          <p>Due Date: {{ task.dueDate }}</p>
          <p>Status: {{ task.status }}</p>
          <div class="buttons">
            <button @click="editTask">Update</button>
            <button @click="deleteTask">Delete</button>
          </div>
        </div>
      </div>
      <div v-else>
        <p>Loading task details...</p>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        task: null
      };
    },
    created() {
      // Fetch task details from the backend API based on task ID
      this.fetchTaskDetails();
    },
    methods: {
      fetchTaskDetails() {
        // Implement the logic to fetch task details from the backend API
        // You can use Vue resource, Axios, or any other HTTP library to make the API call
        // Set the fetched task details to the 'task' data property
      },
      editTask() {
        // Implement the logic to navigate to the task edit page with the task ID
        // You can use Vue Router or any other routing library to handle the navigation
      },
      deleteTask() {
        // Implement the logic to delete the task via backend API
        // You can use Vue resource, Axios, or any other HTTP library to make the API call
        // After successful deletion, navigate back to the task list page or any other desired page
      }
    }
  }
  </script>
  
  <style scoped>
  .task-detail-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
  }
  
  .task-card {
    background-color: #f3f3f3;
    padding: 1rem;
    border-radius: 8px;
  }
  
  h2 {
    margin-top: 0;
  }
  
  h3 {
    margin-top: 0;
  }
  
  p {
    margin-top: 0.5rem;
  }
  
  .buttons {
    margin-top: 1rem;
  }
  
  button {
    margin-right: 1rem;
  }
  </style>
  