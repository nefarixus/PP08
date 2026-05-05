<template>
  <div class="under-header">
    <div class="second-header">
      <div class="main-second-header">
        <div class="slider2" ref="sliderContainer">
          <div v-if="loading" class="slide2 text-center py-8">Загрузка...</div>
          <div v-else-if="products.length === 0" class="slide2 text-center py-8">Нет доступных приложений</div>
          <template v-else>
            <div 
              v-for="product in products" 
              :key="product.id"
              class="slide2"
            >
              <article class="catalog-card">
                <RouterLink :to="`/product/${product.id}`" class="catalog-card__link">
                  <div class="catalog-card__media">
                    <img :src="`/images/${product.img}`" :alt="product.name">
                  </div>
                  <div class="catalog-card__divider"></div>
                  <div class="catalog-card__body">
                    <h3 class="catalog-card__title">{{ product.name }}</h3>
                    <div class="catalog-card__price-row">
                      <span :class="getPricePillClass(product.price)">
                        {{ getPriceLabel(product.price) }}
                      </span>
                    </div>
                    <p v-if="product.description" class="catalog-card__excerpt">
                      {{ getExcerpt(product.description) }}
                    </p>
                    <p v-else class="catalog-card__excerpt catalog-card__excerpt--placeholder">
                      Описание появится в карточке товара
                    </p>
                  </div>
                </RouterLink>
                <div class="catalog-card__footer">
                  <button 
                    v-if="isLoggedIn && isInLibrary(product.id)" 
                    type="button" 
                    class="add-button" 
                    disabled
                  >
                    Уже в библиотеке
                  </button>
                  <RouterLink 
                    v-else-if="product.price > 0" 
                    :to="`/checkout/${product.id}`" 
                    class="checkout-link"
                  >
                    Купить
                  </RouterLink>
                  <button 
                    v-else 
                    type="button" 
                    class="add-button"
                    @click="addToLibrary(product.id)"
                    :disabled="addingToLibrary[product.id]"
                  >
                    {{ addingToLibrary[product.id] ? 'Добавление...' : 'Добавить' }}
                  </button>
                </div>
              </article>
            </div>
            <!-- Последняя карточка — "Хочешь больше?" -->
            <div class="slide2">
              <a href="#" class="banner-card-more">
                <p class="card-desc-more">Хочешь больше?</p>
                <p class="button-more">Начни искать</p>
              </a>
            </div>
          </template>
        </div>
        <button class="prev2" @click="moveSlide(-1)">&#10094;</button>
        <button class="next2" @click="moveSlide(1)">&#10095;</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { RouterLink, useRouter } from 'vue-router';

const products = ref<any[]>([]);
const loading = ref(true);
const userLibrary = ref<number[]>([]);
const isLoggedIn = ref(false);
const currentSlideIndex = ref(0);
const sliderContainer = ref<HTMLElement | null>(null);
const addingToLibrary = ref<Record<number, boolean>>({});

const router = useRouter();

const fetchProducts = async () => {
  try {
    const response = await fetch('/api/products');
    if (response.ok) {
      products.value = await response.json();
    } else {
      console.error('Failed to fetch products:', await response.text());
    }
  } catch (error) {
    console.error('Failed to fetch products:', error);
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

const isInLibrary = (productId: number) => {
  return userLibrary.value.includes(productId);
};

const getPricePillClass = (price: number) => {
  return `catalog-card__price-pill${price > 0 ? '' : ' catalog-card__price-pill--free'}`;
};

const getPriceLabel = (price: number) => {
  return price > 0 
    ? `${new Intl.NumberFormat('ru-RU', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(price)} ₽`
    : 'Бесплатно';
};

const getExcerpt = (description: string) => {
  if (!description) return '';
  const excerpt = description.length > 100 ? description.substring(0, 100) + '…' : description;
  return excerpt;
};

const addToLibrary = async (productId: number) => {
  if (!isLoggedIn.value) {
    router.push('/login');
    return;
  }

  addingToLibrary.value[productId] = true;
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
    } else {
      const errorData = await response.json();
      alert(`Ошибка: ${errorData.message || 'Не удалось добавить в библиотеку'}`);
    }
  } catch (error) {
    console.error('Failed to add to library:', error);
    alert('Произошла ошибка при добавлении в библиотеку.');
  } finally {
    addingToLibrary.value[productId] = false;
  }
};

const moveSlide = (direction: number) => {
  if (!sliderContainer.value) return;
  
  const slides = sliderContainer.value.querySelectorAll('.slide2');
  const totalSlides = slides.length;
  const slideWidth = slides[0]?.clientWidth || 0;
  
  currentSlideIndex.value = Math.max(0, Math.min(totalSlides - 1, currentSlideIndex.value + direction));
  
  const transformValue = -currentSlideIndex.value * slideWidth;
  if (sliderContainer.value instanceof HTMLElement) {
    sliderContainer.value.style.transform = `translateX(${transformValue}px)`;
  }
};

onMounted(() => {
  fetchProducts();
  fetchUserLibrary();
});
</script>

<style scoped>
/* All styles are handled by global style.css */
</style>