<template>
  <div v-if="loading" class="profile-container text-center" style="padding: 60px 0;">Загрузка...</div>

  <div v-else-if="!isLoggedIn" class="profile-container text-center" style="padding: 60px 0;">
    <p>Пожалуйста, <RouterLink to="/login" class="nav-text">войдите</RouterLink>, чтобы просмотреть профиль.</p>
  </div>

  <div v-else class="profile-container">
    <div class="profile-header">
      <div class="profile-avatar">{{ userInitial }}</div>
      <div class="profile-info">
        <h1 class="profile-name">{{ userLogin }}</h1>
        <p class="profile-email">{{ userEmail }}</p>
      </div>
    </div>

    <div class="profile-stats">
      <div class="profile-stat">
        <span class="profile-stat__value">{{ library.length }}</span>
        <span class="profile-stat__label">Игр в библиотеке</span>
      </div>
    </div>

    <h2 class="profile-section-title">Моя библиотека</h2>

    <p v-if="library.length === 0" class="profile-empty">
      Ваша библиотека пуста. Перейдите в <RouterLink to="/" class="nav-text">каталог</RouterLink>, чтобы добавить игры.
    </p>

    <div v-else class="game-grid">
      <RouterLink
        v-for="game in library"
        :key="game.id"
        :to="`/product/${game.id}`"
        class="game-card"
      >
        <div class="game-img">
          <img :src="`/images/${game.img}`" :alt="game.name">
        </div>
        <p class="game-name">{{ game.name }}</p>
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { RouterLink } from 'vue-router';

const library = ref<any[]>([]);
const loading = ref(true);
const isLoggedIn = ref(false);
const userLogin = ref('');
const userEmail = ref('');

const userInitial = computed(() => {
  const name = userLogin.value || userEmail.value;
  return name ? name.charAt(0).toUpperCase() : '?';
});

const fetchUserLibrary = async () => {
  try {
    const userResponse = await fetch('/api/user', { credentials: 'include' });
    if (!userResponse.ok) {
      isLoggedIn.value = false;
      return;
    }
    const userData = await userResponse.json();
    isLoggedIn.value = true;
    userLogin.value = userData.login || '';
    userEmail.value = userData.email || '';

    const libraryResponse = await fetch('/api/user/library', { credentials: 'include' });
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

onMounted(() => {
  fetchUserLibrary();
});
</script>

<style scoped>
.profile-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 32px 24px 64px;
  color: #fff;
}

.profile-header {
  display: flex;
  align-items: center;
  gap: 24px;
  margin-bottom: 32px;
}

.profile-avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: rgba(124, 58, 237, 0.35);
  border: 2px solid rgba(124, 58, 237, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-display);
  font-size: 2rem;
  font-weight: 700;
  color: #e9d5ff;
  flex-shrink: 0;
}

.profile-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.profile-name {
  font-family: var(--font-display);
  font-size: 1.6rem;
  font-weight: 700;
  margin: 0;
  color: #fafafa;
}

.profile-email {
  font-size: 14px;
  color: rgba(255, 255, 255, 0.55);
  margin: 0;
}

.profile-stats {
  display: flex;
  gap: 20px;
  margin-bottom: 36px;
  padding: 20px 24px;
  background: #1b1b1b;
  border-radius: 14px;
  border: 1px solid rgba(255, 255, 255, 0.07);
}

.profile-stat {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.profile-stat__value {
  font-family: var(--font-display);
  font-size: 1.6rem;
  font-weight: 700;
  color: #c4b5fd;
  line-height: 1;
}

.profile-stat__label {
  font-size: 12px;
  color: rgba(255, 255, 255, 0.5);
}

.profile-section-title {
  font-family: var(--font-display);
  font-size: 1.15rem;
  font-weight: 700;
  color: #fafafa;
  margin: 0 0 20px;
  padding: 0;
}

.profile-empty {
  color: rgba(255, 255, 255, 0.45);
  font-size: 14px;
  text-align: center;
  padding: 40px 0;
}

.game-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 18px;
}

.game-card {
  display: flex;
  flex-direction: column;
  gap: 10px;
  text-decoration: none;
  border-radius: 12px;
  overflow: hidden;
  background: #1b1b1b;
  border: 1px solid rgba(255, 255, 255, 0.07);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.game-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 32px rgba(0, 0, 0, 0.4);
}

.game-img {
  width: 100%;
  aspect-ratio: 16 / 10;
  overflow: hidden;
}

.game-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.game-name {
  font-family: var(--font-display);
  font-size: 13px;
  font-weight: 600;
  color: #fafafa;
  padding: 0 12px 12px;
  margin: 0;
  line-height: 1.3;
}
</style>
