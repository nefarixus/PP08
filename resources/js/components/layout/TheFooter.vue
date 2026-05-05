<template>
  <footer class="site-footer">
    <div class="site-footer__left">
      <img src="/images/logo.svg" alt="СайдКвест" class="site-footer__logo">
      <div class="site-footer__links">
        <span>&copy; {{ currentYear }} СайдКвест. Все права защищены.</span>
      </div>
    </div>
    <div class="site-footer__right">
      <div class="site-footer__social">
        <a href="#" target="_blank" rel="noopener">
          <img src="/images/social-discord.png" alt="Discord">
        </a>
        <a href="#" target="_blank" rel="noopener">
          <img src="/images/social-twitter.png" alt="Twitter">
        </a>
        <a href="#" target="_blank" rel="noopener">
          <img src="/images/social-youtube.png" alt="YouTube">
        </a>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const currentYear = ref(new Date().getFullYear());
</script>

<style scoped>
/* All styles are now handled by the global style.css */
</style>