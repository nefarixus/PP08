<template>
  <div class="auth-wrap">
    <div class="auth-card">
      <h1 class="auth-title">Вход в аккаунт</h1>

      <div v-if="registered" class="auth-success">
        <p>Регистрация прошла успешно! Войдите в свой новый аккаунт.</p>
      </div>

      <div v-if="error" class="auth-error">{{ error }}</div>

      <form @submit.prevent="login">
        <label for="email">Email</label>
        <input v-model="email" type="email" id="email" name="email" required>

        <label for="password">Пароль</label>
        <input v-model="password" type="password" id="password" name="password" required>

        <button type="submit" class="pd-btn pd-btn-primary" :disabled="loading">
          {{ loading ? 'Вход...' : 'Войти' }}
        </button>
      </form>
      <p class="auth-switch">
        Нет аккаунта? <RouterLink to="/register">Зарегистрироваться</RouterLink>
      </p>
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
/* Styles will be adapted from the original style.css */
.auth-wrap { /* ... */ }
</style>