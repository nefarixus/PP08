<template>
  <div v-if="loading" class="pd-wrap text-center">Загрузка...</div>
  <div v-else-if="product" class="pd-wrap">
    <article class="pd-card">
      <div class="pd-hero">
        <img :src="`/images/${product.img}`" :alt="product.name">
      </div>
      <div class="pd-divider"></div>
      <div class="pd-panel">
        <h1 class="pd-title">{{ product.name }}</h1>
        <div class="pd-meta">
          <span :class="priceBadgeClass">{{ priceDisplay }}</span>
        </div>
        <p v-if="product.description" class="pd-desc">{{ product.description }}</p>
        <p v-else class="pd-desc pd-desc--empty">Описание скоро появится.</p>

        <div class="pd-actions">
          <RouterLink to="/" class="add-button">← К каталогу</RouterLink>
          <div v-if="!isLoggedIn">
            <RouterLink to="/login" class="add-button">Войти, чтобы добавить или купить</RouterLink>
          </div>
          <div v-else-if="isInLibrary">
            <button type="button" class="add-button" disabled>Уже в библиотеке</button>
          </div>
          <div v-else-if="product.price > 0">
            <RouterLink :to="`/checkout/${product.id}`" class="checkout-link">Купить</RouterLink>
          </div>
          <div v-else>
            <button 
              type="button" 
              class="add-button"
              @click="addToLibrary"
              :disabled="addingToLibrary"
            >
              {{ addingToLibrary ? 'Добавление...' : 'Добавить в библиотеку' }}
            </button>
          </div>
        </div>
      </div>
    </article>
  </div>
  <div v-else class="pd-wrap text-center">
    <p>Продукт не найден.</p>
    <RouterLink to="/" class="add-button mt-3">← К каталогу</RouterLink>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter, RouterLink } from 'vue-router';

const route = useRoute();
const router = useRouter();
const productId = Number(route.params.id);
const product = ref<any>(null);
const loading = ref(true);
const isLoggedIn = ref(false);
const userLibrary = ref<number[]>([]);
const addingToLibrary = ref(false);

const fetchProduct = async () => {
  try {
    const response = await fetch(`/api/products/${productId}`);
    if (response.ok) {
      product.value = await response.json();
    } else {
      console.error('Failed to fetch product:', await response.text());
    }
  } catch (error) {
    console.error('Failed to fetch product:', error);
  } finally {
    loading.value = false;
  }
};

const fetchUserLibrary = async () => {
  try {
    const response = await fetch('/api/user/library', {
      credentials: 'include'
    });
    if (response.ok) {
      const libraryData = await response.json();
      userLibrary.value = libraryData.map((item: any) => item.id);
      isLoggedIn.value = true;
    } else if (response.status === 401) {
      // Not authenticated, that's fine
      isLoggedIn.value = false;
    }
  } catch (error) {
    console.error('Failed to fetch user library:', error);
    isLoggedIn.value = false;
  }
};

const isInLibrary = computed(() => {
  return userLibrary.value.includes(productId);
});

const priceDisplay = computed(() => {
  if (!product.value) return '';
  return product.value.price > 0 
    ? `${new Intl.NumberFormat('ru-RU', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(product.value.price)} ₽`
    : 'Бесплатно';
});

const priceBadgeClass = computed(() => {
  return `pd-price-badge${product.value && product.value.price > 0 ? '' : ' pd-price-badge--free'}`;
});

const addToLibrary = async () => {
  if (!product.value || product.value.price > 0) return;

  addingToLibrary.value = true;
  try {
    const response = await fetch('/api/library', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
      body: JSON.stringify({ product_id: productId })
    });

    if (response.ok) {
      // Add to local library state
      userLibrary.value.push(productId);
      // Optionally show a notification
    } else {
      const errorData = await response.json();
      alert(`Ошибка: ${errorData.message || 'Не удалось добавить в библиотеку'}`);
    }
  } catch (error) {
    console.error('Failed to add to library:', error);
    alert('Произошла ошибка при добавлении в библиотеку.');
  } finally {
    addingToLibrary.value = false;
  }
};

onMounted(() => {
  fetchProduct();
  fetchUserLibrary();
});
</script>

<style scoped>
/* All styles are now handled by the global style.css */
</style>