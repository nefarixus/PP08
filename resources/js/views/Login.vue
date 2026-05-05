<template>
  <div class="main-login">
    <div class="login-container">
      <h2>Войдите сейчас, чтобы исследовать мир VR!</h2>

      <form @submit.prevent="login">
        <div v-if="registered" class="login-success">
          Регистрация прошла успешно! Войдите в свой новый аккаунт.
        </div>

        <div v-if="error" class="login-error">{{ error }}</div>

        <div class="form-group">
          <label for="email">Email или логин</label>
          <input v-model="email" type="text" id="email" name="email" required>
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
        <p>Нет аккаунта?</p>
        <RouterLink to="/register">Создайте здесь!</RouterLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter, useRoute, RouterLink } from 'vue-router';
import { apiPost } from '../utils/api';
import { useAuth } from '../stores/auth';

const router = useRouter();
const route = useRoute();
const email = ref('');
const password = ref('');
const error = ref('');
const loading = ref(false);
const registered = ref(false);

const { checkAuth } = useAuth();

onMounted(() => {
  if (route.query.registered === '1') {
    registered.value = true;
  }
});

const login = async () => {
  error.value = '';
  loading.value = true;

  try {
    const response = await apiPost('/api/login', {
      login: email.value,
      password: password.value,
    });

    const data = await response.json();

    if (response.ok) {
      // Обновляем глобальный стор — сайдбар и все компоненты реагируют мгновенно
      await checkAuth();
      const redirectTo = (route.query.redirect as string) || '/';
      router.push(redirectTo);
    } else {
      error.value = data.message || 'Неверный email или пароль.';
    }
  } catch (err) {
    console.error('[Login] Network error:', err);
    error.value = 'Произошла ошибка при входе. Пожалуйста, попробуйте еще раз.';
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
