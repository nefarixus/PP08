<template>
  <main class="pd-wrap">
    <div v-if="loading" style="text-align:center; padding: 48px 0; color:#aaa;">Загрузка...</div>

    <article v-else-if="product" class="pd-card">
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
          <RouterLink to="/" class="pd-btn pd-btn-secondary">← К каталогу</RouterLink>

          <RouterLink v-if="!isLoggedIn" to="/login" class="pd-btn pd-btn-primary">
            Войти, чтобы добавить или купить
          </RouterLink>

          <button v-else-if="isInLibrary" type="button" class="pd-btn pd-btn-secondary" disabled>
            Уже в библиотеке
          </button>

          <RouterLink v-else-if="product.price > 0" :to="`/checkout/${product.id}`" class="pd-btn pd-btn-primary">
            Купить
          </RouterLink>

          <button
            v-else
            type="button"
            class="pd-btn pd-btn-primary add-button"
            :data-product-id="product.id"
            @click="addToLibrary"
            :disabled="addingToLibrary"
          >
            {{ addingToLibrary ? 'Добавление...' : 'Добавить в библиотеку' }}
          </button>
        </div>
      </div>
    </article>

    <div v-else style="text-align:center; padding:48px 0; color:#aaa;">
      <p>Продукт не найден.</p>
      <RouterLink to="/" class="pd-btn pd-btn-secondary" style="margin-top:16px;">← К каталогу</RouterLink>
    </div>
  </main>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute, RouterLink } from 'vue-router';
import { apiPost, apiGet } from '../utils/api';

const route = useRoute();
const productId = Number(route.params.id);
const product = ref<any>(null);
const loading = ref(true);
const isLoggedIn = ref(false);
const userLibrary = ref<number[]>([]);
const addingToLibrary = ref(false);

const fetchProduct = async () => {
  try {
    const response = await apiGet(`/api/products/${productId}`);
    if (response.ok) {
      product.value = await response.json();
    }
  } catch (error) {
    console.error('Failed to fetch product:', error);
  } finally {
    loading.value = false;
  }
};

const fetchUserLibrary = async () => {
  try {
    const response = await apiGet('/api/user/library');
    if (response.ok) {
      const libraryData = await response.json();
      userLibrary.value = libraryData.map((item: any) => item.id);
      isLoggedIn.value = true;
    } else if (response.status === 401) {
      isLoggedIn.value = false;
    }
  } catch {
    isLoggedIn.value = false;
  }
};

const isInLibrary = computed(() => userLibrary.value.includes(productId));

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
    const response = await apiPost('/api/library', { product_id: productId });
    if (response.ok) {
      userLibrary.value.push(productId);
    } else {
      const errorData = await response.json();
      alert(`Ошибка: ${errorData.message || 'Не удалось добавить в библиотеку'}`);
    }
  } catch {
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
/* All styles are handled by global style.css */
</style>
