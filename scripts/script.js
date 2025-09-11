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


// === Слайдер 3: Аналог второго, но для третьей секции
let slideIndex3 = 0;
const slider3 = document.querySelector('.slider3');
const slides3 = document.querySelectorAll('.slide3');
const totalSlides3 = slides3.length;
const slidesPerView3 = 6;
const totalPages3 = Math.ceil(totalSlides3 / slidesPerView3);

// Устанавливаем ширину слайдов
slides3.forEach(slide => {
  slide.style.minWidth = `${100 / slidesPerView3}%`;
});

function showSlide3(pageIndex) {
  const maxPage = totalPages3 - 1;
  slideIndex3 = Math.max(0, Math.min(pageIndex, maxPage));
  const offset = slideIndex3 * slidesPerView3 * (100 / slidesPerView3);
  slider3.style.transform = `translateX(-${offset}%)`;
}

function moveSlide3(direction) {
  showSlide3(slideIndex3 + direction);
}

// Кнопки для слайдера 3
document.querySelector('.prev3')?.addEventListener('click', () => moveSlide3(-1));
document.querySelector('.next3')?.addEventListener('click', () => moveSlide3(1));

// Инициализация
showSlide3(0);


// 🔴 Глобальная функция для совместимости с HTML первого слайдера
function moveSlide(n) {
  moveSlide1(n);
}