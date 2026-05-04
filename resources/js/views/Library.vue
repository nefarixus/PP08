<template>
  <div v-if="loading" class="lib-wrap">Загрузка...</div>
  <div v-else-if="!isLoggedIn" class="lib-wrap">
    <p>Пожалуйста, <RouterLink to="/login">войдите</RouterLink>, чтобы просмотреть свою библиотеку.</p>
  </div>
  <div v-else class="lib-wrap">
    <header class="lib-header">
      <h1 class="lib-title">Моя библиотека</h1>
      <div class="lib-user-info">
        <span class="lib-user-name">{{ userLogin }}</span>
        <span class="lib-user-email">{{ userEmail }}</span>
      </div>
    </header>

    <p v-if="library.length === 0" class="lib-empty">Ваша библиотека пуста. Перейдите в <RouterLink to="/">каталог</RouterLink>, чтобы добавить игры.</p>
    <div v-else class="lib-grid">
      <div
        v-for="game in library"
        :key="game.id"
        class="lib-card"
      >
        <RouterLink :to="`/product/${game.id}`" class="lib-link">
          <img :src="`/images/${game.img}`" :alt="game.name" class="lib-img">
          <h2 class="lib-game-title">{{ game.name }}</h2>
          <span v-if="game.price > 0" class="lib-price">{{ formatPrice(game.price) }} ₽</span>
          <span v-else class="lib-price lib-price--free">Бесплатно</span>
        </RouterLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { RouterLink } from 'vue-router';

const library = ref<any[]>([]);
const loading = ref(true);
const isLoggedIn = ref(false);
const userLogin = ref('');
const userEmail = ref('');

const fetchUserLibrary = async () => {
  try {
    const userResponse = await fetch('/api/user', {
      credentials: 'include'
    });
    if (!userResponse.ok) {
      isLoggedIn.value = false;
      return;
    }
    const userData = await userResponse.json();
    isLoggedIn.value = true;
    userLogin.value = userData.login;
    userEmail.value = userData.email;

    const libraryResponse = await fetch('/api/user/library', {
      credentials: 'include'
    });
    if (libraryResponse.ok) {
      library.value = await libraryResponse.json();
    }
  } catch (error) {
    console.error('Failed to fetch user library:', error);
    isLoggedIn.value = false;
  } finally {
    loading.value = false;
  }
};

const formatPrice = (price: number) => {
  return new Intl.NumberFormat('ru-RU', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price);
};

onMounted(() => {
  fetchUserLibrary();
});
</script>

<style scoped>
/* Styles will be adapted from the original style.css */
.lib-wrap { /* ... */ }
</style>