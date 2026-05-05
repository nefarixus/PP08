<template>
  <div class="main-login">
    <div class="login-container">
      <h2>Создайте аккаунт СайдКвест!</h2>

      <div v-if="success" class="login-success">
        <p>Вы успешно зарегистрировались!</p>
        <p>Ваш email: <strong>{{ registeredEmail }}</strong></p>
        <p><RouterLink to="/login?registered=1" class="nav-text">Войдите в аккаунт</RouterLink></p>
      </div>

      <form v-else @submit.prevent="register">
        <div v-if="error" class="login-error">{{ error }}</div>

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
          <div class="social-icons">
            <a href="#" class="social-btn">
              <img src="/images/ic_baseline-discord.png" alt="Discord">
            </a>
            <a href="#" class="social-btn">
              <img src="/images/mdi_github.png" alt="GitHub">
            </a>
            <a href="#" class="social-btn">
              <img src="/images/flowbite_google-solid.png" alt="Google">
            </a>
          </div>
        </div>
      </form>

      <div class="login-footer">
        <p>Уже есть аккаунт?</p>
        <RouterLink to="/login">Войдите здесь!</RouterLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { RouterLink } from 'vue-router';
import { apiPost } from '../utils/api';

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
    const response = await apiPost('/api/register', {
      email: email.value,
      password: password.value,
    });

    const data = await response.json();

    if (response.ok) {
      success.value = true;
      registeredEmail.value = email.value;
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
.login-success {
  background: rgba(34, 197, 94, 0.1);
  border: 1px solid rgba(34, 197, 94, 0.3);
  border-radius: 6px;
  color: #86efac;
  padding: 10px 14px;
  margin-bottom: 16px;
  font-size: 14px;
  text-align: center;
}
.login-error {
  background: rgba(239, 68, 68, 0.1);
  border: 1px solid rgba(239, 68, 68, 0.3);
  border-radius: 6px;
  color: #fca5a5;
  padding: 10px 14px;
  margin-bottom: 16px;
  font-size: 14px;
  text-align: center;
}
</style>
