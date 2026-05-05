<template>
  <main class="checkout-page">
    <h1 class="checkout-page-title">Оформление</h1>

    <div v-if="loading" style="text-align:center; padding: 32px 0; color:#aaa;">Загрузка...</div>

    <div v-else-if="!isLoggedIn" style="text-align:center; padding: 32px 0; color:#aaa;">
      <p>Для оформления заказа необходимо <RouterLink to="/login" class="nav-text">войти</RouterLink>.</p>
    </div>

    <template v-else-if="product">
      <p v-if="error" class="checkout-err">{{ error }}</p>
      <p v-if="paid" class="checkout-err" style="color:#86efac;">{{ paidMessage }}</p>

      <div class="checkout-card">
        <div class="checkout-card__media">
          <img :src="`/images/${product.img}`" :alt="product.name">
        </div>
        <div class="checkout-card__divider"></div>
        <div class="checkout-card__body">
          <h2 class="checkout-card__title">{{ product.name }}</h2>
          <p v-if="product.description" class="checkout-card__desc">{{ product.description }}</p>
          <p v-else class="checkout-card__desc">Описание скоро появится.</p>

          <div class="checkout-card__row">
            <span>Итого:</span>
            <span class="checkout-price-badge">{{ formatPrice(product.price) }} ₽</span>
          </div>

          <p class="checkout-hint">Это тестовый платёж. Настоящие деньги не будут списаны.</p>

          <button
            v-if="!paid"
            type="button"
            class="checkout-btn"
            @click="completePayment"
            :disabled="processing"
          >{{ processing ? 'Обработка...' : 'Купить' }}</button>
        </div>
      </div>

      <p class="checkout-back">
        <RouterLink :to="`/product/${product.id}`">← Назад к карточке</RouterLink>
      </p>
    </template>

    <div v-else style="text-align:center; padding: 32px 0; color:#aaa;">
      <p>Продукт не найден.</p>
      <RouterLink to="/" class="pd-btn pd-btn-secondary" style="margin-top:16px;">← К каталогу</RouterLink>
    </div>
  </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter, RouterLink } from 'vue-router';
import { apiPost, apiGet } from '../utils/api';

const route = useRoute();
const router = useRouter();
const productId = Number(route.params.id);
const product = ref<any>(null);
const loading = ref(true);
const isLoggedIn = ref(false);
const processing = ref(false);
const paid = ref(false);
const paidMessage = ref('');
const error = ref('');

const fetchProduct = async () => {
  try {
    const response = await apiGet(`/api/products/${productId}`);
    if (response.ok) {
      product.value = await response.json();
    }
  } catch (err) {
    console.error('Failed to fetch product:', err);
  }
};

const checkAuth = async () => {
  try {
    const response = await apiGet('/api/user');
    isLoggedIn.value = response.ok;
  } catch {
    isLoggedIn.value = false;
  }
};

const formatPrice = (price: number) =>
  new Intl.NumberFormat('ru-RU', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(price);

const completePayment = async () => {
  if (!product.value || product.value.price <= 0) return;

  processing.value = true;
  error.value = '';

  try {
    const response = await apiPost('/api/checkout', { product_id: productId });
    const data = await response.json();

    if (response.ok) {
      paid.value = true;
      paidMessage.value = data.message || 'Покупка успешно завершена! Игра добавлена в библиотеку.';
      setTimeout(() => router.push('/library'), 2000);
    } else {
      error.value = data.message || 'Ошибка при обработке платежа.';
    }
  } catch (err) {
    error.value = 'Произошла ошибка при обработке платежа.';
  } finally {
    processing.value = false;
  }
};

onMounted(async () => {
  await Promise.all([fetchProduct(), checkAuth()]);
  loading.value = false;
});
</script>

<style scoped>
/* All styles are handled by global style.css */
</style>
