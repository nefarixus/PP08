<template>
  <header class="main-aside">
    <div class="aside-content">
      <RouterLink to="/" class="logo-link">
        <img src="/images/logo.svg" alt="СайдКвест" class="logo-img">
      </RouterLink>

      <nav class="main-nav">
        <ul class="nav-list">
          <li><RouterLink to="/">Каталог</RouterLink></li>
          <li v-if="isLoggedIn"><RouterLink to="/library">Моя библиотека</RouterLink></li>
          <li v-if="isAdmin"><RouterLink to="/admin">Админка</RouterLink></li>
        </ul>
      </nav>

      <div v-if="isLoggedIn" class="user-info">
        <span class="user-name">{{ userLogin }}</span>
        <button @click="logout" class="logout-link">Выйти</button>
      </div>
      <nav v-else class="main-nav auth-links">
        <ul class="nav-list">
          <li><RouterLink to="/login">Войти</RouterLink></li>
          <li><RouterLink to="/register">Регистрация</RouterLink></li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { RouterLink, useRouter } from 'vue-router';

const router = useRouter();
const isLoggedIn = ref(false);
const userLogin = ref('');
const userRole = ref('');

const isAdmin = computed(() => userRole.value === 'admin');

const checkAuth = async () => {
  try {
    // This will be implemented after API routes are created
    // For now, it's a placeholder
    const response = await fetch('/api/user', {
      credentials: 'include'
    });
    if (response.ok) {
      const userData = await response.json();
      isLoggedIn.value = true;
      userLogin.value = userData.login;
      userRole.value = userData.role;
    } else {
      isLoggedIn.value = false;
    }
  } catch (error) {
    console.error('Auth check failed:', error);
    isLoggedIn.value = false;
  }
};

const logout = async () => {
  try {
    // This will be implemented after API routes are created
    await fetch('/api/logout', {
      method: 'POST',
      credentials: 'include'
    });
    isLoggedIn.value = false;
    userLogin.value = '';
    userRole.value = '';
    router.push('/login');
  } catch (error) {
    console.error('Logout failed:', error);
  }
};

onMounted(() => {
  checkAuth();
});
</script>

<style scoped>
/* Styles will be adapted from the original style.css */
.main-aside {
  /* ... existing styles from aside.php ... */
}
</style>