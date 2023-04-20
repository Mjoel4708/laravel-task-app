<template>
    <div class="task-create-container">
      <h2>Create New Task</h2>
      <form @submit.prevent="createTask">
        <label for="name">Task Name:</label>
        <input type="text" id="name" v-model="taskName" required>
        <label for="description">Task Description:</label>
        <textarea id="description" v-model="taskDescription" required></textarea>
        <label for="dueDate">Due Date:</label>
        <input type="date" id="dueDate" v-model="taskDueDate" required>
        <button type="submit">Create Task</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        taskName: '',
        taskDescription: '',
        taskDueDate: ''
      };
    },
    methods: {
      createTask() {
        // Implement the logic to create a new task using API call
        // You can use Vue resource, Axios, or any other HTTP library to make the API call
        // After successful creation, you can show a success message or redirect to task list page
      }
    }
  }
  </script>
  
  <style scoped>
  .task-create-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
  }
  
  h2 {
    margin-top: 0;
  }
  
  form {
    display: grid;
    gap: 1rem;
  }
  
  label {
    font-weight: bold;
  }
  
  input,
  textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
  }
  
  button {
    margin-top: 1rem;
  }
  </style>
  