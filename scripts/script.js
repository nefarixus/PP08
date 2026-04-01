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
let slideIndex5 = 0;

const slider5 = document.querySelector('.last-container-slider');
const slides5 = document.querySelectorAll('.slide5');

const totalSlides5 = slides5.length;
const slidesPerView5 = 4;     // Отображаем 4 карточки
const slidesToScroll = 1;     // Прокручиваем по 3 за раз
const totalPages5 = Math.ceil((totalSlides5 - slidesPerView5 + slidesToScroll) / slidesToScroll);

// Устанавливаем ширину каждой карточки
slides5.forEach(slide => {
  slide.style.maxWidth = `${100 / slidesPerView5}%`; // 25% на карточку
});

function showSlide5(pageIndex) {
  const maxPage = totalPages5 - 1;
  slideIndex5 = Math.max(0, Math.min(pageIndex, maxPage));

  // Сдвигаем на количество прокручиваемых карточек × ширину одной
  const offset = slideIndex5 * slidesToScroll * (100 / slidesPerView5);
  slider5.style.transform = `translateX(-${offset}%)`;
}

function moveSlide5(direction) {
  showSlide5(slideIndex5 + direction);
}

// Подключаем кнопки
document.querySelector('.prev5')?.addEventListener('click', () => moveSlide5(-1));
document.querySelector('.next5')?.addEventListener('click', () => moveSlide5(1));

// Инициализация
showSlide5(0);


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