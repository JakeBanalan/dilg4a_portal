<template>
    <div>
      <h1>Hello, Vue!</h1>
    </div>
  </template>
  
  <script>
  export default {
    name: 'IndexComponent',
    data() {
      return {
        message: 'Hello, Vue!'
      };
    }
  };
  </script>
  
  <style scoped>
  h1 {
    color: blue;
  }
  </style>
  