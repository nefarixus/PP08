<template>
  <div class="auth-wrap">
    <div class="auth-card">
      <h1 class="auth-title">Регистрация</h1>

      <div v-if="success" class="auth-success">
        <p>Вы успешно зарегистрировались!</p>
        <p>Ваш email: <strong>{{ registeredEmail }}</strong></p>
        <p><RouterLink to="/login?registered=1">Войдите в аккаунт</RouterLink></p>
      </div>
      <div v-else>
        <div v-if="error" class="auth-error">{{ error }}</div>

        <form @submit.prevent="register">
          <label for="email">Email</label>
          <input v-model="email" type="email" id="email" name="email" required>

          <label for="password">Пароль</label>
          <input v-model="password" type="password" id="password" name="password" required minlength="6">

          <button type="submit" class="pd-btn pd-btn-primary" :disabled="loading">
            {{ loading ? 'Регистрация...' : 'Зарегистрироваться' }}
          </button>
        </form>
        <p class="auth-switch">
          Уже есть аккаунт? <RouterLink to="/login">Войти</RouterLink>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter, RouterLink } from 'vue-router';

const router = useRouter();
const email = ref('');
const password = ref('');
const error = ref('');
const loading = ref(false);
const success = ref(false);
const registeredEmail = ref('');

const register = async () => {
  error.value = '';
  loading.value = true;

  try {
    const response = await fetch('/api/register', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify({ email: email.value, password: password.value })
    });

    const data = await response.json();

    if (response.ok) {
      success.value = true;
      registeredEmail.value = email.value;
      // Reset form
      email.value = '';
      password.value = '';
    } else {
      error.value = data.message || 'Ошибка при регистрации.';
    }
  } catch (err) {
    console.error('Registration error:', err);
    error.value = 'Произошла ошибка при регистрации.';
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
/* Styles will be adapted from the original style.css */
.auth-wrap { /* ... */ }
</style>