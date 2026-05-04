<template>
  <div id="app">
    <TheHeader />
    <main>
      <router-view />
    </main>
    <TheFooter />
  </div>
</template>

<script setup lang="ts">
import TheHeader from './layout/TheHeader.vue';
import TheFooter from './layout/TheFooter.vue';
</script>

<style scoped>
/* Global styles can be added here or in a separate CSS file */
#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
main {
  flex: 1;
}
</style>