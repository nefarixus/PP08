<template>
  <div class="catalog-wrap">
    <header class="catalog-header">
      <h1 class="catalog-title">Каталог VR-игр</h1>
      <RouterLink v-if="isLoggedIn" to="/library" class="catalog-profile-link">Моя библиотека</RouterLink>
    </header>

    <div v-if="loading" class="catalog-loading">Загрузка...</div>
    <p v-else-if="products.length === 0" class="catalog-empty">Каталог пуст.</p>
    <div v-else class="catalog-grid">
      <div
        v-for="game in products"
        :key="game.id"
        class="catalog-card"
      >
        <RouterLink :to="`/product/${game.id}`" class="catalog-link">
          <img :src="`/images/${game.img}`" :alt="game.name" class="catalog-img">
          <h2 class="catalog-game-title">{{ game.name }}</h2>
          <span v-if="game.price > 0" class="catalog-price">{{ formatPrice(game.price) }} ₽</span>
          <span v-else class="catalog-price catalog-price--free">Бесплатно</span>
        </RouterLink>
        <span v-if="isLoggedIn && isInLibrary(game.id)" class="catalog-in-library">В библиотеке</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { RouterLink } from 'vue-router';

const products = ref<any[]>([]);
const loading = ref(true);
const userLibrary = ref<number[]>([]);
const isLoggedIn = ref(false);

const fetchProducts = async () => {
  try {
    const response = await fetch('/api/products');
    if (response.ok) {
      products.value = await response.json();
    }
  } catch (error) {
    console.error('Failed to fetch products:', error);
  } finally {
    loading.value = false;
  }
};

const fetchUserLibrary = async () => {
  try {
    const response = await fetch('/api/user/library', {
      credentials: 'include'
    });
    if (response.ok) {
      const libraryData = await response.json();
      userLibrary.value = libraryData.map((item: any) => item.id);
      isLoggedIn.value = true;
    }
  } catch (error) {
    console.error('Failed to fetch user library:', error);
    isLoggedIn.value = false;
  }
};

const isInLibrary = (productId: number) => {
  return userLibrary.value.includes(productId);
};

const formatPrice = (price: number) => {
  return new Intl.NumberFormat('ru-RU', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price);
};

onMounted(() => {
  fetchProducts();
  // Attempt to fetch library, will fail if not logged in, which is fine
  fetchUserLibrary();
});
</script>

<style scoped>
/* Styles will be adapted from the original style.css */
.catalog-wrap { /* ... */ }
</style>