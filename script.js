const carousel = document.querySelector('.carousel-duo');
const btnNext = document.querySelector('.carousel-btn.next');
const btnPrev = document.querySelector('.carousel-btn.prev');
const dots = document.querySelectorAll('.dot');

let currentSlide = 1;
const itemWidth = document.querySelector('.carousel-item').offsetWidth + 20; // item + gap
const totalItems = document.querySelectorAll('.carousel-item').length;
const maxSlide = Math.floor(totalItems / 2); // karena 2 item tampil sekaligus

// Set initial position of the carousel dot
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

const categories = document.querySelector('.categories');

// Duplicate category items to create circular effect
categories.innerHTML += categories.innerHTML; // gandakan isi kategori

let isDown = false;
let startX;
let scrollLeft;

categories.addEventListener('mousedown', (e) => {
  isDown = true;
  categories.classList.add('active');
  startX = e.pageX - categories.offsetLeft;
  scrollLeft = categories.scrollLeft;
});

categories.addEventListener('mouseleave', () => {
  isDown = false;
  categories.classList.remove('active');
});

categories.addEventListener('mouseup', () => {
  isDown = false;
  categories.classList.remove('active');
});

categories.addEventListener('mousemove', (e) => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - categories.offsetLeft;
  const walk = (x - startX) * 1.5;
  categories.scrollLeft = scrollLeft - walk;

  const halfScroll = categories.scrollWidth / 2;
  if (categories.scrollLeft >= halfScroll) {
    categories.scrollLeft = 0;
  } else if (categories.scrollLeft <= 0) {
    categories.scrollLeft = halfScroll;
  }
});

//signin dan signup
  // Fungsi untuk pindah dari page1 ke page2
  function goToPage2(event) {
    event.preventDefault(); // Mencegah form reload halaman

    const nomorInput = document.getElementById("nomor");
    const nomorValue = nomorInput.value.trim();

    if (nomorValue === "") {
      alert("Mohon isi nomor handphone terlebih dahulu.");
      nomorInput.focus();
      return;
    }

    // Menyembunyikan page1 dan menampilkan page2
    document.getElementById("page1").style.display = "none";
    document.getElementById("page2").style.display = "flex";
  }

  // Fungsi opsional jika ingin kembali ke page1

  function goToPage1(event) {
    event.preventDefault();
    document.getElementById("page1").style.display = "flex";
    document.getElementById("page2").style.display = "none";
  }

  // Saat halaman pertama kali dimuat, pastikan hanya page1 yang terlihat
  window.addEventListener("DOMContentLoaded", () => {
    document.getElementById("page1").style.display = "flex";
    document.getElementById("page2").style.display = "none";
  });
