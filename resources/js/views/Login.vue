<template>
  <div class="main-login">
    <div class="login-container">
      <h2>Вход в аккаунт</h2>
      
      <form @submit.prevent="login">
        <div v-if="registered" class="text-center mb-4 p-3 bg-green-900/30 border border-green-500/30 rounded text-green-300">
          <p>Регистрация прошла успешно! Войдите в свой новый аккаунт.</p>
        </div>

        <div v-if="error" class="text-center mb-4 p-3 bg-red-900/30 border border-red-500/30 rounded text-red-300">{{ error }}</div>

        <div class="form-group">
          <label for="email">Email</label>
          <input v-model="email" type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="password">Пароль</label>
          <input v-model="password" type="password" id="password" name="password" required>
        </div>

        <a href="#" class="forgot-password">Забыли пароль?</a>

        <div class="btn-group">
          <button type="submit" class="btn-login" :disabled="loading">
            {{ loading ? 'Вход...' : 'Войти' }}
          </button>
        </div>
      </form>

      <div class="social-icons">
        <a href="#" class="social-btn">
          <img src="/images/social-discord.png" alt="Discord">
        </a>
        <a href="#" class="social-btn">
          <img src="/images/social-twitter.png" alt="Twitter">
        </a>
        <a href="#" class="social-btn">
          <img src="/images/social-youtube.png" alt="YouTube">
        </a>
      </div>
    </div>
    
    <div class="login-footer">
      <span>Нет аккаунта?</span>
      <RouterLink to="/register" class="add-button">Зарегестрироваться</RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter, useRoute, RouterLink } from 'vue-router';

const router = useRouter();
const route = useRoute();
const email = ref('');
const password = ref('');
const error = ref('');
const loading = ref(false);
const registered = ref(false);

onMounted(() => {
  // Check if redirected from registration
  if (route.query.registered === '1') {
    registered.value = true;
  }
});

const login = async () => {
  error.value = '';
  loading.value = true;

  try {
    const response = await fetch('/api/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify({ email: email.value, password: password.value })
    });

    const data = await response.json();

    if (response.ok) {
      // Authentication successful, redirect to home or intended page
      const redirectTo = (route.query.redirect as string) || '/';
      router.push(redirectTo);
    } else {
      error.value = data.message || 'Неверный email или пароль.';
    }
  } catch (err) {
    console.error('Login error:', err);
    error.value = 'Произошла ошибка при входе.';
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
/* All styles are now handled by the global style.css */
</style>