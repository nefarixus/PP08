<template>
  <div v-if="loading" class="pd-wrap text-center">Загрузка...</div>
  <div v-else-if="!isLoggedIn" class="pd-wrap text-center">
    <p>Пожалуйста, <RouterLink to="/login" class="nav-text">войдите</RouterLink>, чтобы просмотреть свою библиотеку.</p>
  </div>
  <div v-else class="pd-wrap">
    <header class="lib-header mb-6">
      <h1 class="pd-title">Моя библиотека</h1>
      <div class="lib-user-info text-right">
        <span class="lib-user-name">{{ userLogin }}</span>
        <span class="lib-user-email">{{ userEmail }}</span>
      </div>
    </header>

    <p v-if="library.length === 0" class="text-center py-8 text-gray-400">Ваша библиотека пуста. Перейдите в <RouterLink to="/" class="nav-text">каталог</RouterLink>, чтобы добавить игры.</p>
    <div v-else class="catalog-grid">
      <div
        v-for="game in library"
        :key="game.id"
        class="catalog-card"
      >
        <RouterLink :to="`/product/${game.id}`" class="catalog-card__link">
          <div class="catalog-card__media">
            <img :src="`/images/${game.img}`" :alt="game.name">
          </div>
          <div class="catalog-card__divider"></div>
          <div class="catalog-card__body">
            <h3 class="catalog-card__title">{{ game.name }}</h3>
            <div class="catalog-card__price-row">
              <span v-if="game.price > 0" class="catalog-card__price-pill">{{ formatPrice(game.price) }} ₽</span>
              <span v-else class="catalog-card__price-pill catalog-card__price-pill--free">Бесплатно</span>
            </div>
            <p v-if="game.description" class="catalog-card__excerpt">
              {{ getExcerpt(game.description) }}
            </p>
            <p v-else class="catalog-card__excerpt catalog-card__excerpt--placeholder">
              Описание появится в карточке товара
            </p>
          </div>
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
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
  }).format(price);
};

const getExcerpt = (description: string) => {
  if (!description) return '';
  const excerpt = description.length > 100 ? description.substring(0, 100) + '…' : description;
  return excerpt;
};

onMounted(() => {
  fetchUserLibrary();
});
</script>

<style scoped>
/* All styles are now handled by the global style.css */
.lib-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 20px;
}
.lib-user-info {
  font-size: 14px;
}
.lib-user-name {
  font-weight: bold;
  display: block;
}
.lib-user-email {
  color: var(--muted);
}
</style>