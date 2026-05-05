<template>
  <div class="main-login">
    <div class="login-container">
      <h2>Регистрация</h2>
      
      <div v-if="success" class="text-center mb-4 p-3 bg-green-900/30 border border-green-500/30 rounded text-green-300">
        <p>Вы успешно зарегистрировались!</p>
        <p>Ваш email: <strong>{{ registeredEmail }}</strong></p>
        <p><RouterLink to="/login?registered=1" class="nav-text">Войдите в аккаунт</RouterLink></p>
      </div>
      <div v-else>
        <div v-if="error" class="text-center mb-4 p-3 bg-red-900/30 border border-red-500/30 rounded text-red-300">{{ error }}</div>

        <form @submit.prevent="register">
          <div class="form-group">
            <label for="email">Email</label>
            <input v-model="email" type="email" id="email" name="email" required>
          </div>

          <div class="form-group">
            <label for="password">Пароль</label>
            <input v-model="password" type="password" id="password" name="password" required minlength="6">
          </div>

          <div class="btn-group">
            <button type="submit" class="btn-login" :disabled="loading">
              {{ loading ? 'Регистрация...' : 'Зарегистрироваться' }}
            </button>
          </div>
        </form>
      </div>

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
      <span>Уже есть аккаунт?</span>
      <RouterLink to="/login" class="add-button">Войти</RouterLink>
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
/* All styles are now handled by the global style.css */
</style>