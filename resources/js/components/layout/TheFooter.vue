<template>
  <footer class="main-footer">
    <p>&copy; {{ currentYear }} СайдКвест. Все права защищены.</p>
  </footer>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

const currentYear = ref(new Date().getFullYear());
</script>

<style scoped>
/* Styles will be adapted from the original style.css */
.main-footer {
  /* ... existing styles from footer.php ... */
}
</style>