<template>
    <footer class="footer">
      <div class="footer__content">
        <p class="footer__text">Thank you for visiting. </p>
      </div>
    </footer>
  </template>
  
  <script>
  export default {
    // Add any additional logic or functionality for the footer component here
  };
  </script>
  
  <style scoped>
  .footer {
    background-color: #011627;
    padding: 16px;
    text-align: center;
    display: flex;
    flex-direction: column;
  }
  
  .footer__content {
    display: flex;
    justify-content: center;
  }
  
  .footer__text {
    color: #fff;
  }
  </style>
  