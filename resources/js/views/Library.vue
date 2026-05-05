<template>
  <div v-if="loading" class="profile-container" style="padding: 60px 0; text-align:center; color:#9ca3af;">
    Загрузка...
  </div>

  <div v-else-if="!isLoggedIn" class="profile-container" style="padding: 60px 0; text-align:center;">
    <p>Пожалуйста, <RouterLink to="/login" class="nav-text">войдите</RouterLink>, чтобы просмотреть профиль.</p>
  </div>

  <main v-else class="profile-container">
    <!-- Шапка профиля -->
    <div class="profile-header">
      <div class="profile-avatar">{{ userInitial }}</div>
      <div class="profile-info">
        <h1>{{ userLogin }}</h1>
        <div class="profile-tagline">Личная библиотека VR-приложений</div>
        <div class="profile-stats">
          <div class="profile-stat-card">
            <span class="profile-stat-label">В библиотеке</span>
            <span class="profile-stat-value">{{ library.length }}</span>
          </div>
          <div class="profile-stat-card">
            <span class="profile-stat-label">Каталог закрыт на</span>
            <span class="profile-stat-value">{{ coveragePercent }}%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Заголовок секции библиотеки -->
    <div class="profile-section-header">
      <h2>Моя библиотека</h2>
      <div class="profile-section-meta">
        {{ library.length }} из {{ totalProducts }} доступных приложений
      </div>
    </div>

    <!-- Пустое состояние -->
    <template v-if="library.length === 0">
      <p class="empty">Вы ещё не добавили ни одного приложения.</p>
      <p class="empty-sub">Откройте <RouterLink to="/" class="nav-text">главную страницу</RouterLink> и нажмите «Добавить» или «Купить» на понравившихся проектах.</p>
    </template>

    <!-- Сетка игр -->
    <div v-else class="game-grid">
      <RouterLink
        v-for="game in library"
        :key="game.id"
        :to="`/product/${game.id}`"
        class="game-card"
      >
        <img :src="`/images/${game.img}`" :alt="game.name" class="game-img">
        <div class="game-name">{{ game.name }}</div>
      </RouterLink>
    </div>
  </main>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue';
import { RouterLink } from 'vue-router';
import { apiGet } from '../utils/api';
import { useAuth } from '../stores/auth';

const library = ref<any[]>([]);
const totalProducts = ref(0);
const loading = ref(true);

const { isLoggedIn, userLogin, userEmail } = useAuth();

const userInitial = computed(() => {
  const name = userLogin.value || userEmail.value;
  return name ? name.slice(0, 2).toUpperCase() : '??';
});

const coveragePercent = computed(() => {
  if (!totalProducts.value) return 0;
  return Math.round((library.value.length / totalProducts.value) * 100);
});

const fetchTotalProducts = async () => {
  try {
    const res = await apiGet('/api/products/count');
    if (res.ok) {
      const data = await res.json();
      totalProducts.value = data.total ?? 0;
    }
  } catch {}
};

const fetchLibrary = async () => {
  if (!isLoggedIn.value) {
    loading.value = false;
    return;
  }
  try {
    const res = await apiGet('/api/user/library');
    if (res.ok) {
      library.value = await res.json();
    }
  } catch (error) {
    console.error('Failed to fetch library:', error);
  } finally {
    loading.value = false;
  }
};

watch(isLoggedIn, (loggedIn) => {
  if (loggedIn) {
    fetchLibrary();
  } else {
    library.value = [];
  }
});

onMounted(async () => {
  await Promise.all([fetchLibrary(), fetchTotalProducts()]);
});
</script>

<style scoped>
.profile-container {
  max-width: 1120px;
  margin: 56px auto 72px;
  padding: 32px 32px 40px;
  border-radius: 32px;
  background: #0f0f0f;
  border: 1px solid rgba(255, 255, 255, 0.10);
  box-shadow:
    0 40px 80px rgba(0, 0, 0, 0.75),
    0 0 0 1px rgba(0, 0, 0, 0.55);
  color: #f9fafb;
}

.profile-header {
  display: flex;
  align-items: center;
  gap: 24px;
  margin-bottom: 28px;
}

.profile-avatar {
  width: 80px;
  height: 80px;
  border-radius: 24px;
  background: #2a2a2a;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
  font-weight: 800;
  font-family: var(--font-display, system-ui, sans-serif);
  letter-spacing: 0.08em;
  text-transform: uppercase;
  box-shadow:
    0 12px 32px rgba(0, 0, 0, 0.55),
    0 0 0 1px rgba(255, 255, 255, 0.08);
  flex-shrink: 0;
}

.profile-info h1 {
  margin: 0;
  font-size: 26px;
  font-family: var(--font-display, system-ui, sans-serif);
  letter-spacing: 0.03em;
}

.profile-tagline {
  margin-top: 6px;
  font-size: 13px;
  color: #9ca3af;
}

.profile-stats {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 14px;
}

.profile-stat-card {
  min-width: 150px;
  padding: 10px 16px;
  border-radius: 999px;
  background: rgba(0, 0, 0, 0.22);
  border: 1px solid rgba(255, 255, 255, 0.12);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  font-size: 13px;
  color: #e5e7eb;
}

.profile-stat-label {
  opacity: 0.75;
}

.profile-stat-value {
  font-weight: 700;
  font-variant-numeric: tabular-nums;
  color: #e5e7eb;
}

.profile-section-header {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  gap: 12px;
  margin-top: 32px;
  margin-bottom: 12px;
}

.profile-section-header h2 {
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  font-family: var(--font-display, system-ui, sans-serif);
}

.profile-section-meta {
  font-size: 13px;
  color: #9ca3af;
}

.empty {
  text-align: center;
  color: #9ca3af;
  font-size: 16px;
  margin: 40px 0 8px;
}

.empty-sub {
  text-align: center;
  color: #6b7280;
  font-size: 13px;
}

.game-grid {
  margin-top: 8px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 18px;
}

.game-card {
  background: #141414;
  border-radius: 16px;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.10);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.65);
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  text-decoration: none;
  display: block;
}

.game-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 28px 60px rgba(0, 0, 0, 0.75);
  border-color: rgba(255, 255, 255, 0.16);
}

.game-img {
  width: 100%;
  height: 126px;
  object-fit: cover;
  display: block;
}

.game-name {
  padding: 10px 12px 12px;
  text-align: center;
  font-size: 14px;
  font-weight: 500;
  color: #e5e7eb;
}
</style>
