<template>
  <div>
    <h1>{{ message }}</h1>
  </div>
</template>

<script>
export default {
  name: 'helloworld',
  data() {
    return {
      message: 'Julie & Edgar 💙'
    };
  }
};
</script>

<style scoped>
h1 {
  color: blue;
}
</style>
