// === Слайдер 1: Главный слайдер
let slideIndex1 = 0;
const slides1 = document.querySelectorAll('.slider .slide');
const dots = document.querySelectorAll('.dot');
const header = document.querySelector('.header');

const backgrounds1 = [
  './images/LandscapeArcGlyphCoverArt.jpg',
  './images/app-image-override.png',
  './images/app-image-override (1).png'
];

function showSlide1(index) {
  if (index >= slides1.length) slideIndex1 = 0;
  if (index < 0) slideIndex1 = slides1.length - 1;

  // Плавное затемнение фона
  header.classList.add('fade-out');
  setTimeout(() => {
    header.style.backgroundImage = `url('${backgrounds1[slideIndex1]}')`;
    setTimeout(() => {
      header.classList.remove('fade-out');
    }, 300);
  }, 300);

  // Перемещаем слайдер 1
  document.querySelector('.slider').style.transform = `translateX(-${slideIndex1 * 100}%)`;

  // Активная точка
  dots.forEach((dot, i) => {
    dot.classList.toggle('active', i === slideIndex1);
  });
}

function moveSlide1(n) {
  showSlide1(slideIndex1 += n);
}

function currentSlide(n) {
  slideIndex1 = n;
  showSlide1(n);
}

// Инициализация первого слайдера
showSlide1(0);


// === Слайдер 2: Лента по 6 карточек
let slideIndex2 = 0;
const slider2 = document.querySelector('.slider2');
const slides2 = document.querySelectorAll('.slide2');
const totalSlides2 = slides2.length;
const slidesPerView2 = 6;
const totalPages2 = Math.ceil(totalSlides2 / slidesPerView2);

// Устанавливаем ширину слайдов
slides2.forEach(slide => {
  slide.style.minWidth = `${100 / slidesPerView2}%`;
});

function showSlide2(pageIndex) {
  const maxPage = totalPages2 - 1;
  slideIndex2 = Math.max(0, Math.min(pageIndex, maxPage));
  const offset = slideIndex2 * slidesPerView2 * (100 / slidesPerView2);
  slider2.style.transform = `translateX(-${offset}%)`;
}

function moveSlide2(direction) {
  showSlide2(slideIndex2 + direction);
}

// Кнопки для слайдера 2
document.querySelector('.prev2')?.addEventListener('click', () => moveSlide2(-1));
document.querySelector('.next2')?.addEventListener('click', () => moveSlide2(1));

// Инициализация
showSlide2(0);

// === Слайдер 4: Аналог второго, но для третьей секции
let slideIndex4 = 0;
const slider4 = document.querySelector('.slider4');
const slides4 = document.querySelectorAll('.slide4');
const totalSlides4 = slides4.length;
const slidesPerView4 = 2;
const totalPages4 = Math.ceil(totalSlides4 / slidesPerView4);

// Устанавливаем ширину слайдов
slides4.forEach(slide => {
  slide.style.minWidth = `${100 / slidesPerView4}%`;
});

function showSlide4(pageIndex) {
  const maxPage = totalPages4 - 1;
  slideIndex4 = Math.max(0, Math.min(pageIndex, maxPage));
  const offset = slideIndex4 * slidesPerView4 * (100 / slidesPerView4);
  slider4.style.transform = `translateX(-${offset}%)`;
}

function moveSlide4(direction) {
  showSlide4(slideIndex4 + direction);
}

// Кнопки для слайдера 3
document.querySelector('.prev4')?.addEventListener('click', () => moveSlide4(-1));
document.querySelector('.next4')?.addEventListener('click', () => moveSlide4(1));

// Инициализация
showSlide4(0);

// === Слайдер 5: Прокрутка по 3 карточки из 4 видимых
const slider5 = document.querySelector('.last-container-slider');
const slides5 = document.querySelectorAll('.slide5');
const slidesPerView5 = 4;     // Отображаем 4 карточки
const slidesToScroll = 3;     // На сколько карточек листаем
let currentTranslate5 = 0;    // текущий сдвиг в px

// Устанавливаем ширину каждой карточки
slides5.forEach(slide => {
  slide.style.maxWidth = `${100 / slidesPerView5}%`; // 25% на карточку
});

const prev5Btn = document.querySelector('.prev5');
const next5Btn = document.querySelector('.next5');

function getMaxTranslate5() {
  if (!slider5?.parentElement) return 0;
  return Math.max(0, slider5.scrollWidth - slider5.parentElement.clientWidth);
}

function getStepPx5() {
  if (!slides5.length) return 0;
  const first = slides5[0];
  return Math.max(1, Math.round(first.getBoundingClientRect().width * slidesToScroll));
}

function renderSlider5() {
  if (!slider5) return;
  const maxTranslate = getMaxTranslate5();
  currentTranslate5 = Math.max(0, Math.min(currentTranslate5, maxTranslate));
  slider5.style.transform = `translateX(-${currentTranslate5}px)`;
}

function updateSlider5Buttons() {
  if (!prev5Btn || !next5Btn) return;
  const maxTranslate = getMaxTranslate5();
  prev5Btn.disabled = currentTranslate5 <= 0;
  next5Btn.disabled = currentTranslate5 >= maxTranslate;
  prev5Btn.style.opacity = prev5Btn.disabled ? '0.45' : '1';
  next5Btn.style.opacity = next5Btn.disabled ? '0.45' : '1';
  prev5Btn.style.cursor = prev5Btn.disabled ? 'not-allowed' : 'pointer';
  next5Btn.style.cursor = next5Btn.disabled ? 'not-allowed' : 'pointer';
}

function showSlide5(nextTranslate) {
  currentTranslate5 = nextTranslate;
  renderSlider5();
  updateSlider5Buttons();
}

function moveSlide5(direction) {
  const step = getStepPx5();
  showSlide5(currentTranslate5 + direction * step);
}

// Подключаем кнопки
prev5Btn?.addEventListener('click', () => moveSlide5(-1));
next5Btn?.addEventListener('click', () => moveSlide5(1));

// Инициализация
showSlide5(0);
window.addEventListener('resize', () => {
  renderSlider5();
  updateSlider5Buttons();
});


// 🔴 Глобальная функция для совместимости с HTML первого слайдера
function moveSlide(n) {
  moveSlide1(n);
}

// === Мобильное меню-бургер ===
const burger = document.querySelector('.burger-menu');
const aside = document.querySelector('aside');
const overlay = document.querySelector('.overlay');
const container = document.getElementById('main-container');

burger?.addEventListener('click', () => {
  burger.classList.toggle('active');
  aside.classList.toggle('open');
  overlay.classList.toggle('active');
  document.body.style.overflow = overlay.classList.contains('active') ? 'hidden' : '';
});

overlay?.addEventListener('click', () => {
  burger.classList.remove('active');
  aside.classList.remove('open');
  overlay.classList.remove('active');
  document.body.style.overflow = '';
});

const addToLibraryUrl = (typeof window.SITE_ROOT !== 'undefined' ? window.SITE_ROOT : '') + 'add_to_library_ajax.php';

document.querySelectorAll('.add-button').forEach(button => {
    button.addEventListener('click', async function() {
        const productId = this.dataset.productId;
        const response = await fetch(addToLibraryUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + productId
        });

        if (response.ok) {
            const result = await response.json();
            if (result.success) {
                // Меняем текст и блокируем кнопку
                this.textContent = 'Уже в библиотеке';
                this.disabled = true;

                setTimeout(() => {
                    alert('Приложение добавлено в библиотеку!');
                }, 100);
            } else if (result.error) {
                alert(result.error);
            }
        } else {
            alert('Ошибка при добавлении');
        }
    });
});

// === Уведомления (колокольчик) ===
function formatRuDateTime(isoLike) {
  const d = new Date(isoLike);
  if (Number.isNaN(d.getTime())) return String(isoLike || '');
  return d.toLocaleString('ru-RU', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

async function loadNotifications(listEl) {
  const root = (typeof window.SITE_ROOT !== 'undefined' ? window.SITE_ROOT : '');
  const r = await fetch(root + 'get_notifications.php', { credentials: 'same-origin' });
  const j = await r.json();
  const items = Array.isArray(j.items) ? j.items : [];
  listEl.innerHTML = '';
  if (items.length === 0) {
    const empty = document.createElement('div');
    empty.className = 'notif-item';
    empty.innerHTML = `<div class="notif-item__name">${listEl.dataset.empty || 'Пока пусто'}</div>`;
    listEl.appendChild(empty);
    return;
  }
  for (const it of items) {
    const div = document.createElement('div');
    div.className = 'notif-item';
    div.innerHTML = `
      <div class="notif-item__name">${(it.name || '').replace(/</g, '&lt;')}</div>
      <div class="notif-item__sub">Добавлено в библиотеку</div>
      <div class="notif-item__time">${formatRuDateTime(it.added_at)}</div>
    `;
    listEl.appendChild(div);
  }
}

document.querySelectorAll('.notif-btn').forEach(btn => {
  const wrap = btn.closest('.notif-wrap') || btn.closest('.auth-buttons');
  const menu = wrap?.querySelector('.notif-menu');
  const list = wrap?.querySelector('.notif-menu__list');
  if (!menu || !list) return;

  btn.addEventListener('click', async () => {
    const willOpen = menu.hasAttribute('hidden');
    // close other menus
    document.querySelectorAll('.notif-menu').forEach(m => m.setAttribute('hidden', ''));
    if (willOpen) {
      menu.removeAttribute('hidden');
      try { await loadNotifications(list); } catch (e) { /* ignore */ }
    }
  });
});

document.addEventListener('click', (e) => {
  const t = e.target;
  if (t && (t.closest?.('.notif-menu') || t.closest?.('.notif-btn'))) return;
  document.querySelectorAll('.notif-menu').forEach(m => m.setAttribute('hidden', ''));
});