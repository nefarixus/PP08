<template>
  <div>
    <!-- Кнопка регистрации -->
    <div class="container-signup-button">
      <RouterLink to="/register" class="neon-button">Зарегистрироваться сейчас</RouterLink>
    </div>

    <!-- ===== Главный hero-слайдер (slider 1) ===== -->
    <div class="header" ref="heroHeader">
      <div class="main-header">
        <div class="slider" ref="heroSlider">
          <div
            class="slide"
            style="background-image: url('/images/LandscapeArcGlyphCoverArt.jpg'); filter: brightness(1.12) contrast(1.04) saturate(1.08);"
          >
            <a href="#">
              <div class="banner-card">
                <p class="card-title">ArcGlyph</p>
                <p class="card-desc">ArcGlyph это утилита смешанной реальности для любых задач: призывайте круги, счетчики, таймеры и процедурных существ в своем пространстве.</p>
                <p class="find-out-more">Узнать больше</p>
              </div>
            </a>
          </div>
          <div
            class="slide"
            style="background-image: url('/images/app-image-override.png'); filter: brightness(1.12) contrast(1.04) saturate(1.08);"
          >
            <a href="#">
              <div class="banner-card">
                <p class="card-title">FortiCasa</p>
                <p class="card-desc">Погрузитесь в уникальное стратегическое оборонное приключение с FortiCasa: ВР робот дефенс для Oculus Quest!</p>
                <p class="find-out-more">Узнать больше</p>
              </div>
            </a>
          </div>
          <div
            class="slide"
            style="background-image: url('/images/app-image-override (1).png'); filter: brightness(1.12) contrast(1.04) saturate(1.08);"
          >
            <a href="#">
              <div class="banner-card">
                <p class="card-title">Metacity Patrol</p>
                <p class="card-desc">Исследуйте и защищайте районы Metacity в свободной приключенческой киберпанк-песочнице.</p>
                <p class="find-out-more">Узнать больше</p>
              </div>
            </a>
          </div>
        </div>
      </div>
      <button class="prev" @click="moveHeroSlide(-1)">&#10094;</button>
      <button class="next" @click="moveHeroSlide(1)">&#10095;</button>
      <div class="dots">
        <span
          v-for="(_, i) in 3"
          :key="i"
          class="dot"
          :class="{ active: heroSlideIndex === i }"
          @click="goToHeroSlide(i)"
        ></span>
      </div>
    </div>

    <!-- ===== Каталог продуктов (slider 2, 6 per view) ===== -->
    <div class="under-header">
      <div class="second-header">
        <div class="main-second-header">
          <div class="slider2" ref="catalogSlider">
            <div v-if="loading" class="slide2" style="padding: 32px 0; text-align:center;">Загрузка...</div>
            <div v-else-if="products.length === 0" class="slide2" style="padding: 32px 0; text-align:center;">Нет доступных приложений</div>
            <template v-else>
              <div v-for="product in products" :key="product.id" class="slide2">
                <article class="catalog-card">
                  <RouterLink :to="`/product/${product.id}`" class="catalog-card__link">
                    <div class="catalog-card__media">
                      <img :src="`/images/${product.img}`" :alt="product.name">
                    </div>
                    <div class="catalog-card__divider"></div>
                    <div class="catalog-card__body">
                      <h3 class="catalog-card__title">{{ product.name }}</h3>
                      <div class="catalog-card__price-row">
                        <span :class="getPricePillClass(product.price)">{{ getPriceLabel(product.price) }}</span>
                      </div>
                      <p v-if="product.description" class="catalog-card__excerpt">{{ getExcerpt(product.description) }}</p>
                      <p v-else class="catalog-card__excerpt catalog-card__excerpt--placeholder">Описание появится в карточке товара</p>
                    </div>
                  </RouterLink>
                  <div class="catalog-card__footer">
                    <button
                      v-if="isLoggedIn && isInLibrary(product.id)"
                      type="button"
                      class="add-button"
                      disabled
                    >Уже в библиотеке</button>
                    <RouterLink
                      v-else-if="product.price > 0"
                      :to="`/checkout/${product.id}`"
                      class="checkout-link"
                    >Купить</RouterLink>
                    <button
                      v-else
                      type="button"
                      class="add-button"
                      @click="addToLibrary(product.id)"
                      :disabled="addingToLibrary[product.id]"
                    >{{ addingToLibrary[product.id] ? 'Добавление...' : 'Добавить' }}</button>
                  </div>
                </article>
              </div>
              <!-- Последняя карточка -->
              <div class="slide2">
                <a href="#">
                  <div class="banner-card-more">
                    <p class="card-desc-more">Хочешь больше?</p>
                    <p class="button-more">Начни искать</p>
                  </div>
                </a>
              </div>
            </template>
          </div>
          <button class="prev2" @click="moveCatalogSlide(-1)">&#10094;</button>
          <button class="next2" @click="moveCatalogSlide(1)">&#10095;</button>
        </div>
      </div>
    </div>

    <!-- ===== Карточки меню ===== -->
    <div class="card-menu">
      <a href="#" class="card-menu-card1">
        <div>
          <img src="https://cdn.sidequestvr.com/file/2467806/left-large.png" alt="img-card1">
          <p class="menu-card-text">Лучшее <br><span>ААА ВР Названия!</span></p>
        </div>
      </a>
      <a href="#" class="card-menu-card2">
        <div>
          <p class="menu-card-text2">Скидки и <br><span>Распродажа</span></p>
          <img src="https://cdn.sidequestvr.com/file/2467809/sale-large.png" alt="img-card2">
        </div>
      </a>
      <a href="#" class="card-menu-card3">
        <div>
          <p class="menu-card-text2">Самые <br><span>странные ВР игры!</span></p>
          <img src="https://cdn.sidequestvr.com/file/2467812/weirdest-large.png" alt="img-card3">
        </div>
      </a>
      <a href="#" class="card-menu-card4">
        <div>
          <img src="https://cdn.sidequestvr.com/file/2467815/right-large.png" alt="img-card4">
          <p class="menu-card-text">Лучшее <br><span>Замиксуй реальность</span></p>
        </div>
      </a>
    </div>

    <!-- ===== Топ-слайдер (slider 4, 2 per view) ===== -->
    <div class="tops-div">
      <div class="slider4" ref="topsSlider">
        <a href="#" class="slide4">
          <div class="tops-card-inside1">
            <div class="block">
              <p class="top-card-title">Топ <span>хоррор</span> игр</p>
              <p class="top-card-desc">Наша выборка пяти наистрашнейших игр этой недели...</p>
              <p class="slide-button">Напугай меня</p>
            </div>
            <img src="/images/char.png-600.png" alt="1st top">
          </div>
        </a>
        <a href="#" class="slide4">
          <div class="tops-card-inside2">
            <div class="block">
              <p class="top-card-title">Топ 5 <span>кастомных домов</span></p>
              <p class="top-card-desc">Хотите как можно скорее оказаться в каком-нибудь уникальном месте <br>в VR?</p>
              <p class="slide-button">Посмотреть</p>
            </div>
            <img src="/images/char-big.png-600.png" alt="2nd top">
          </div>
        </a>
        <a href="#" class="slide4">
          <div class="tops-card-inside3">
            <div class="block">
              <p class="top-card-title">Топ 5 СайдКвест <span>Эксклюзивов</span></p>
              <p class="top-card-desc">Найди это только на нашей платформе!</p>
              <p class="slide-button">Посмотреть</p>
            </div>
            <img src="/images/mario-trend.png-600.png" alt="3rd top">
          </div>
        </a>
        <a href="#" class="slide4">
          <div class="tops-card-inside4">
            <div class="block">
              <p class="top-card-title">Топ 5 <span>фитнесс приложений</span></p>
              <p class="top-card-desc">Занимаетесь спортом в виртуальной реальности? Вот несколько <br>интересных занятий...</p>
              <p class="slide-button">Посмотреть</p>
            </div>
            <img src="/images/trend-fitness.png-600.png" alt="4th top">
          </div>
        </a>
      </div>
      <button class="prev4" @click="moveTopsSlide(-1)">&#10094;</button>
      <button class="next4" @click="moveTopsSlide(1)">&#10095;</button>
    </div>

    <!-- ===== Топ мастхевов ===== -->
    <div class="top-must-plays">
      <img src="https://cdn.sidequestvr.com/file/2298807/batman-left-v4.png" alt="" class="joker-img">
      <img src="https://cdn.sidequestvr.com/file/2298808/right.png" alt="" class="zombie-img">
      <p class="top-title"><span>Топ</span> Мастхевов!</p>
      <div class="top-must-plays-grid">
        <a href="#" class="top-grid1">
          <div class="top-grid-text-container1">
            <p class="text1">Бэтмен: Тени Аркхэма</p>
            <p class="text2">Платно</p>
          </div>
        </a>
        <a href="#" class="top-grid2">
          <img src="https://cdn.sidequestvr.com/file/2491141/39031485_1160489718016281_3050468458242801597_n.jpg" alt="">
          <div class="top-grid-text-container">
            <p class="text1">BONELAB</p>
            <p class="text2">Платно</p>
          </div>
        </a>
        <a href="#" class="top-grid3">
          <img src="https://cdn.sidequestvr.com/file/2490798/39031497_875215037171957_3000930639070807095_n.jpg" alt="">
          <div class="top-grid-text-container">
            <p class="text1">Assassin's Creed® Nexus</p>
            <p class="text2">Платно</p>
          </div>
        </a>
      </div>
      <a class="link" href="#">Покажите мне больше!</a>
    </div>

    <!-- ===== Последний контейнер (slider 5, 4 per view, scroll by 3) ===== -->
    <div class="last-container">
      <div class="last-container-banner">
        <img src="https://cdn.sidequestvr.com/file/2489194/star-wars-beyond-victory-ilm-meta-immersive-copy.jpg" alt="">
        <p class="article-text">Добро пожаловать в СайдКвест! Ознакомьтесь с нашими</p>
        <p class="article-title">Статья — Star Wars: Beyond Victory — раскрыты режим игры и дата выхода</p>
        <p class="article-who-time">от Татьяна СайдКвест --- 11 сентября 2025 г.</p>
        <a href="#" class="article-link">Прочитать статью</a>
      </div>
      <div class="fifth-slider">
        <div class="last-container-slider" ref="lastSlider">
          <a href="#" class="slide5">
            <div class="tops-card-inside5"><div class="block"><p class="top-card-title5"><span>Все приложения</span></p></div><img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="slide"></div>
          </a>
          <a href="#" class="slide5">
            <div class="tops-card-inside5"><div class="block"><p class="top-card-title5"><span>Все приложения</span></p></div><img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="slide"></div>
          </a>
          <a href="#" class="slide5">
            <div class="tops-card-inside5"><div class="block"><p class="top-card-title5"><span>Все приложения</span></p></div><img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="slide"></div>
          </a>
          <a href="#" class="slide5">
            <div class="tops-card-inside5"><div class="block"><p class="top-card-title5"><span>Все приложения</span></p></div><img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="slide"></div>
          </a>
          <a href="#" class="slide5">
            <div class="tops-card-inside5"><div class="block"><p class="top-card-title5"><span>Все приложения</span></p></div><img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="slide"></div>
          </a>
          <a href="#" class="slide5">
            <div class="tops-card-inside5"><div class="block"><p class="top-card-title5"><span>Все приложения</span></p></div><img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="slide"></div>
          </a>
          <a href="#" class="slide5">
            <div class="tops-card-inside5"><div class="block"><p class="top-card-title5"><span>Все приложения</span></p></div><img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="slide"></div>
          </a>
          <a href="#" class="slide5">
            <div class="tops-card-inside5"><div class="block"><p class="top-card-title5"><span>Все приложения</span></p></div><img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="slide"></div>
          </a>
          <a href="#" class="slide5">
            <div class="tops-card-inside5"><div class="block"><p class="top-card-title5"><span>Все приложения конец</span></p></div><img src="https://cdn.sidequestvr.com/file/2480138/all.png-220.png" alt="slide"></div>
          </a>
        </div>
        <button
          class="prev5"
          @click="moveLastSlide(-1)"
          :disabled="prev5Disabled"
          :style="{ opacity: prev5Disabled ? '0.45' : '1', cursor: prev5Disabled ? 'not-allowed' : 'pointer' }"
        >&#10094;</button>
        <button
          class="next5"
          @click="moveLastSlide(1)"
          :disabled="next5Disabled"
          :style="{ opacity: next5Disabled ? '0.45' : '1', cursor: next5Disabled ? 'not-allowed' : 'pointer' }"
        >&#10095;</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import { apiPost, apiGet } from '../utils/api';

// ===================== Data =====================
const products = ref<any[]>([]);
const loading = ref(true);
const userLibrary = ref<number[]>([]);
const isLoggedIn = ref(false);
const addingToLibrary = ref<Record<number, boolean>>({});
const router = useRouter();

// ===================== Slider refs =====================
const heroHeader  = ref<HTMLElement | null>(null);
const heroSlider  = ref<HTMLElement | null>(null);
const catalogSlider = ref<HTMLElement | null>(null);
const topsSlider  = ref<HTMLElement | null>(null);
const lastSlider  = ref<HTMLElement | null>(null);

// ===================== Slider 1: Hero (circular, fade) =====================
const HERO_TOTAL = 3;
const heroSlideIndex = ref(0);
const heroImages = [
  '/images/LandscapeArcGlyphCoverArt.jpg',
  '/images/app-image-override.png',
  '/images/app-image-override (1).png',
];

const showHeroSlide = (index: number) => {
  if (index >= HERO_TOTAL) heroSlideIndex.value = 0;
  else if (index < 0)      heroSlideIndex.value = HERO_TOTAL - 1;
  else                     heroSlideIndex.value = index;

  const headerEl = heroHeader.value;
  const sliderEl = heroSlider.value;
  if (!sliderEl) return;

  // Fade effect (mirror PHP: add fade-out → swap bg → remove fade-out)
  if (headerEl) {
    headerEl.classList.add('fade-out');
    setTimeout(() => {
      headerEl.style.backgroundImage = `url('${heroImages[heroSlideIndex.value]}')`;
      setTimeout(() => headerEl.classList.remove('fade-out'), 300);
    }, 300);
  }

  sliderEl.style.transform = `translateX(-${heroSlideIndex.value * 100}%)`;
};

const moveHeroSlide = (dir: number) => showHeroSlide(heroSlideIndex.value + dir);
const goToHeroSlide  = (i: number)  => showHeroSlide(i);

// ===================== Slider 2: Catalog (6 per view, move by full page = 100%) =====================
const SLIDES_PER_VIEW_2 = 6;
let catalogPageIndex = 0;

const moveCatalogSlide = (dir: number) => {
  if (!catalogSlider.value) return;
  const slides = catalogSlider.value.querySelectorAll('.slide2');
  const totalPages = Math.ceil(slides.length / SLIDES_PER_VIEW_2);
  const maxPage = totalPages - 1;
  catalogPageIndex = Math.max(0, Math.min(catalogPageIndex + dir, maxPage));
  // offset = pageIndex * slidesPerView * (100/slidesPerView) = pageIndex * 100 %
  const offset = catalogPageIndex * SLIDES_PER_VIEW_2 * (100 / SLIDES_PER_VIEW_2);
  catalogSlider.value.style.transform = `translateX(-${offset}%)`;
};

// ===================== Slider 4: Tops (2 per view, move by full page = 100%) =====================
const SLIDES_PER_VIEW_4 = 2;
let topsPageIndex = 0;

const moveTopsSlide = (dir: number) => {
  if (!topsSlider.value) return;
  const slides = topsSlider.value.querySelectorAll('.slide4');
  const totalPages = Math.ceil(slides.length / SLIDES_PER_VIEW_4);
  const maxPage = totalPages - 1;
  topsPageIndex = Math.max(0, Math.min(topsPageIndex + dir, maxPage));
  const offset = topsPageIndex * SLIDES_PER_VIEW_4 * (100 / SLIDES_PER_VIEW_4);
  topsSlider.value.style.transform = `translateX(-${offset}%)`;
};

// ===================== Slider 5: Last (4 visible, scroll 3, px-based, disable at edges) =====================
const SLIDES_PER_VIEW_5 = 4;
const SLIDES_TO_SCROLL_5 = 3;
let currentTranslate5 = 0;
const prev5Disabled = ref(true);
const next5Disabled = ref(false);

const getMaxTranslate5 = (): number => {
  if (!lastSlider.value?.parentElement) return 0;
  return Math.max(0, lastSlider.value.scrollWidth - lastSlider.value.parentElement.clientWidth);
};

const getStep5 = (): number => {
  if (!lastSlider.value) return 0;
  const first = lastSlider.value.querySelector('.slide5') as HTMLElement | null;
  if (!first) return 0;
  return Math.round(first.getBoundingClientRect().width * SLIDES_TO_SCROLL_5);
};

const renderSlider5 = () => {
  if (!lastSlider.value) return;
  const maxTranslate = getMaxTranslate5();
  currentTranslate5 = Math.max(0, Math.min(currentTranslate5, maxTranslate));
  lastSlider.value.style.transform = `translateX(-${currentTranslate5}px)`;
  prev5Disabled.value = currentTranslate5 <= 0;
  next5Disabled.value = currentTranslate5 >= maxTranslate;
};

const moveLastSlide = (dir: number) => {
  const step = getStep5();
  currentTranslate5 += dir * step;
  renderSlider5();
};

const initSlider5 = () => {
  // PHP sets maxWidth: 25% on each slide5
  const slides = lastSlider.value?.querySelectorAll('.slide5') as NodeListOf<HTMLElement> | undefined;
  slides?.forEach(slide => { slide.style.maxWidth = `${100 / SLIDES_PER_VIEW_5}%`; });
  currentTranslate5 = 0;
  renderSlider5();
};

// ===================== Products / Library =====================
const fetchProducts = async () => {
  try {
    const response = await apiGet('/api/products');
    if (response.ok) products.value = await response.json();
  } catch (e) {
    console.error('Failed to fetch products:', e);
  } finally {
    loading.value = false;
    // После рендера слайдов — ставим minWidth явно (как PHP JS) и сбрасываем позицию
    await nextTick();
    if (catalogSlider.value) {
      (catalogSlider.value.querySelectorAll('.slide2') as NodeListOf<HTMLElement>)
        .forEach(slide => { slide.style.minWidth = `${100 / SLIDES_PER_VIEW_2}%`; });
      catalogPageIndex = 0;
      catalogSlider.value.style.transform = 'translateX(0%)';
    }
  }
};

const fetchUserLibrary = async () => {
  try {
    const response = await apiGet('/api/user/library');
    if (response.ok) {
      const data = await response.json();
      userLibrary.value = data.map((item: any) => item.id);
      isLoggedIn.value = true;
    } else {
      isLoggedIn.value = false;
    }
  } catch {
    isLoggedIn.value = false;
  }
};

const isInLibrary = (productId: number) => userLibrary.value.includes(productId);

const getPricePillClass = (price: number) =>
  `catalog-card__price-pill${price > 0 ? '' : ' catalog-card__price-pill--free'}`;

const getPriceLabel = (price: number) =>
  price > 0
    ? `${new Intl.NumberFormat('ru-RU', { minimumFractionDigits: 0 }).format(price)} ₽`
    : 'Бесплатно';

const getExcerpt = (description: string) =>
  description.length > 100 ? description.substring(0, 100) + '…' : description;

const addToLibrary = async (productId: number) => {
  if (!isLoggedIn.value) { router.push('/login'); return; }
  addingToLibrary.value[productId] = true;
  try {
    const response = await apiPost('/api/library', { product_id: productId });
    if (response.ok) {
      userLibrary.value.push(productId);
    } else {
      const data = await response.json();
      alert(`Ошибка: ${data.message || 'Не удалось добавить в библиотеку'}`);
    }
  } catch {
    alert('Произошла ошибка при добавлении в библиотеку.');
  } finally {
    addingToLibrary.value[productId] = false;
  }
};

// ===================== Mount =====================
onMounted(() => {
  // Init hero — устанавливаем фон сразу, без fade-анимации при первой загрузке
  nextTick(() => {
    heroSlideIndex.value = 0;
    if (heroHeader.value) heroHeader.value.style.backgroundImage = `url('${heroImages[0]}')`;
    if (heroSlider.value) heroSlider.value.style.transform = 'translateX(0%)';
  });

  // Init tops slider — явно ставим minWidth как в PHP JS
  nextTick(() => {
    topsPageIndex = 0;
    if (topsSlider.value) {
      (topsSlider.value.querySelectorAll('.slide4') as NodeListOf<HTMLElement>)
        .forEach(slide => { slide.style.minWidth = `${100 / SLIDES_PER_VIEW_4}%`; });
      topsSlider.value.style.transform = 'translateX(0%)';
    }
  });

  // Init last slider (static, no async)
  nextTick(() => initSlider5());

  // Resize support for slider 5
  window.addEventListener('resize', () => {
    renderSlider5();
  });

  // Fetch data
  fetchProducts();
  fetchUserLibrary();
});
</script>

<style scoped>
/* All styles are handled by global style.css */
</style>
