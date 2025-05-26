const carousel = document.querySelector('.carousel-duo');
const btnNext = document.querySelector('.carousel-btn.next');
const btnPrev = document.querySelector('.carousel-btn.prev');
const dots = document.querySelectorAll('.dot');

let currentSlide = 1;
const itemWidth = document.querySelector('.carousel-item').offsetWidth + 20; // item + gap
const totalItems = document.querySelectorAll('.carousel-item').length;
const maxSlide = Math.floor(totalItems / 2); // karena 2 item tampil sekaligus

carousel.style.transform = `translateX(-${currentSlide * itemWidth * 2}px)`;

function updateCarousel() {
  carousel.style.transform = `translateX(-${currentSlide * itemWidth * 2}px)`;
  dots.forEach((dot, index) => {
    dot.classList.toggle('active', index === currentSlide);
  });
}

btnNext.addEventListener('click', () => {
  currentSlide++;
  if (currentSlide >= maxSlide) {
    currentSlide = 0;
  }
    updateCarousel();
  carousel.style.transform = `translateX(-${currentSlide * itemWidth * 2}px)`;
});

btnPrev.addEventListener('click', () => {
  currentSlide--;
  if (currentSlide < 0) {
    currentSlide = maxSlide - 1;
  }
    updateCarousel();
  carousel.style.transform = `translateX(-${currentSlide * itemWidth * 2}px)`;
});
dots.forEach((dot, index) => {
  dot.addEventListener('click', () => {
    currentSlide = index;
    updateCarousel();
  });
});
updateCarousel();