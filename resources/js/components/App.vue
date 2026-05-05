<template>
  <div id="app">
    <aside>
      <div class="aside-scroll">
        <RouterLink to="/" class="logo">
          <img src="/images/logo.svg" alt="logo">
          <p class="logo-text">СайдКвест</p>
        </RouterLink>
        <div class="search">
          <form @submit.prevent="search">
            <div class="search-box">
              <input type="text" placeholder="Поиск по СайдКвесту..." v-model="searchQuery" id="searchInput">
            </div>
          </form>
        </div>
        <nav class="primary-nav">
          <div class="nav-block">
            <img src="/images/home.svg" alt="navigation icon" class="icon">
            <RouterLink to="/" class="nav-text">Главная</RouterLink>
          </div>
          <div class="nav-block">
            <img src="/images/download.svg" alt="navigation icon" class="icon">
            <a href="#" class="nav-text">Установить СайдКвест</a>
          </div>
          <div class="nav-block">
            <img src="/images/rocket.svg" alt="navigation icon" class="icon">
            <a href="#" class="nav-text">Приложения и Игры</a>
          </div>
          <div class="nav-block">
            <img src="/images/community.svg" alt="navigation icon" class="icon">
            <a href="#" class="nav-text">Виртуальные Комнаты</a>
          </div>
          <div class="nav-block">
            <img src="/images/thunder.svg" alt="navigation icon" class="icon">
            <a href="#" class="nav-text">Вступить в альянс</a>
          </div>
          <div class="nav-block">
            <img src="/images/star.svg" alt="navigation icon" class="icon">
            <a href="#" class="nav-text">Выйти в Топ</a>
          </div>
          <div class="nav-block">
            <img src="/images/question.svg" alt="navigation icon" class="icon">
            <a href="#" class="nav-text">Поддержка</a>
          </div>
        </nav>
        <nav class="secondary-nav">
          <a href="#" class="nav-text">Портал для разработчиков</a>
          <a href="#" class="nav-text">Обратная связь</a>
          <a href="#" class="nav-text">О нас</a>
        </nav>
      </div>
      <div class="banner-add">
        <p>здесь могла бы быть ваша реклама</p>
      </div>
      <div class="auth">
        <div v-if="isLoggedIn" class="auth-buttons">
          <p class="login">{{ userLogin }}</p>
          <RouterLink to="/library" class="account">Мой аккаунт</RouterLink>
          <RouterLink v-if="isAdmin" to="/admin" class="account account-admin">Админка</RouterLink>
          <a href="#" @click.prevent="logout" class="account account-logout" style="color: #ff4444; border: 0;">Выход</a>
        </div>
        <div v-else class="auth-buttons">
          <RouterLink to="/login" class="login">Войти или <br> Зарегестрироваться</RouterLink>
        </div>
      </div>
    </aside>
    <div class="page-wrapper">
      <div class="container" id="main-container">
        <router-view />
        <footer class="site-footer">
          <div class="site-footer__left">
            <img src="/images/khronos.png" alt="khronos" class="site-footer__logo">
            <nav class="site-footer__links" aria-label="footer">
              <a href="#" class="site-footer__link">Настройки cookie</a>
              <a href="#" class="site-footer__link">Условия</a>
              <a href="#" class="site-footer__link">Конфиденциальность</a>
              <a href="#" class="site-footer__link">Команда</a>
              <a href="#" class="site-footer__link">Продвижение</a>
              <a href="#" class="site-footer__link">Предложить приложение</a>
            </nav>
          </div>
          <div class="site-footer__right" aria-label="social">
            <a href="#" class="site-footer__social"><img src="/images/logo-facebook.png" alt=""></a>
            <a href="#" class="site-footer__social"><img src="/images/logo-instagram.png" alt=""></a>
            <a href="#" class="site-footer__social"><img src="/images/logo-reddit.png" alt=""></a>
            <a href="#" class="site-footer__social"><img src="/images/ri_twitter-x-line.png" alt=""></a>
            <a href="#" class="site-footer__social"><img src="/images/mdi_youtube.png" alt=""></a>
            <a href="#" class="site-footer__social"><img src="/images/logo-tiktok.png" alt=""></a>
            <a href="#" class="site-footer__social"><img src="/images/logo-linkedin.png" alt=""></a>
          </div>
        </footer>
      </div>
    </div>
    <div class="mobile-warning">
      <p>Сайт разработан для просмотра на компьютере.</p>
      <p>Пожалуйста, откройте его с десктопного устройства для лучшего опыта.</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import { apiPost } from '../utils/api';

const router = useRouter();
const searchQuery = ref('');
const isLoggedIn = ref(false);
const userLogin = ref('');
const userRole = ref('');
const isAdmin = ref(false);

const checkAuth = async () => {
  try {
    const response = await fetch('/api/user', { credentials: 'include' });
    if (response.ok) {
      const userData = await response.json();
      isLoggedIn.value = true;
      userLogin.value = userData.login;
      userRole.value = userData.role;
      isAdmin.value = userData.role === 'admin';
    } else {
      isLoggedIn.value = false;
    }
  } catch (error) {
    isLoggedIn.value = false;
  }
};

const logout = async () => {
  try {
    await apiPost('/api/logout');
    isLoggedIn.value = false;
    userLogin.value = '';
    userRole.value = '';
    isAdmin.value = false;
    router.push('/login');
  } catch (error) {
    console.error('Logout failed:', error);
  }
};

const search = () => {
  if (searchQuery.value.trim()) {
    console.log('Search query:', searchQuery.value);
  }
};

onMounted(() => {
  checkAuth();
});
</script>

<style scoped>
/* All styles are handled by global style.css */
</style>
