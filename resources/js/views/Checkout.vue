<template>
  <div class="checkout-page">
    <h1 class="checkout-page-title">Оформление заказа</h1>
    
    <div v-if="loading" class="text-center py-8">Загрузка...</div>
    <div v-else-if="product" class="checkout-card">
      <div class="checkout-card__media">
        <img :src="`/images/${product.img}`" :alt="product.name">
      </div>
      <div class="checkout-card__divider"></div>
      <div class="checkout-card__body">
        <h2 class="checkout-card__title">{{ product.name }}</h2>
        <p v-if="product.description" class="checkout-card__desc">{{ product.description }}</p>
        <p v-else class="checkout-card__desc">Описание скоро появится.</p>
        
        <div class="checkout-card__row">
          <span>Цена:</span>
          <span class="checkout-price-badge">
            {{ formatPrice(product.price) }} ₽
          </span>
        </div>
        
        <p class="checkout-hint">
          Это тестовый платеж. Настоящие деньги не будут списаны.
        </p>
        
        <div v-if="error" class="checkout-err">{{ error }}</div>
        
        <button 
          class="checkout-btn"
          @click="completePayment"
          :disabled="processing"
        >
          {{ processing ? 'Обработка...' : 'Купить' }}
        </button>
        
        <p class="checkout-back">
          <RouterLink to="/" class="nav-text">← Вернуться в каталог</RouterLink>
        </p>
      </div>
    </div>
    <div v-else class="text-center py-8">
      <p>Продукт не найден.</p>
      <RouterLink to="/" class="add-button mt-3">← Вернуться в каталог</RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter, RouterLink } from 'vue-router';

const route = useRoute();
const router = useRouter();
const productId = Number(route.params.id);
const product = ref<any>(null);
const loading = ref(true);
const processing = ref(false);
const error = ref('');

const fetchProduct = async () => {
  try {
    const response = await fetch(`/api/products/${productId}`);
    if (response.ok) {
      product.value = await response.json();
    }
  } catch (error) {
    console.error('Failed to fetch product:', error);
  } finally {
    loading.value = false;
  }
};

const formatPrice = (price: number) => {
  return new Intl.NumberFormat('ru-RU', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(price);
};

const completePayment = async () => {
  if (!product.value || product.value.price <= 0) return;
  
  processing.value = true;
  error.value = '';
  
  try {
    // In a real app, this would be an actual payment API call
    // For now, we'll simulate a successful payment
    await new Promise(resolve => setTimeout(resolve, 1000));
    
    // Redirect to success page or library
    alert('Покупка успешно завершена! Игра добавлена в вашу библиотеку.');
    router.push('/library');
  } catch (err) {
    console.error('Payment failed:', err);
    error.value = 'Произошла ошибка при обработке платежа.';
  } finally {
    processing.value = false;
  }
};

onMounted(() => {
  fetchProduct();
});
</script>

<style scoped>
/* All styles are now handled by the global style.css */
</style>