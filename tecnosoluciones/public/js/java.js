document.addEventListener('DOMContentLoaded', function () {
  const carouselInner = document.querySelector('#productList');
  const items = carouselInner.querySelectorAll('article');
  const prevBtn = document.createElement('button');
  const nextBtn = document.createElement('button');

  // Style and add classes to buttons
  prevBtn.className = 'carousel-control-prev';
  prevBtn.setAttribute('aria-label', 'Anterior');
  prevBtn.innerHTML = '<';

  nextBtn.className = 'carousel-control-next';
  nextBtn.setAttribute('aria-label', 'Siguiente');
  nextBtn.innerHTML = '>';

  // Insert buttons before and after the carouselInner
  carouselInner.parentNode.insertBefore(prevBtn, carouselInner);
  carouselInner.parentNode.insertBefore(nextBtn, carouselInner.nextSibling);

  const itemWidth = items[0].offsetWidth + 16; // width + gap (g-4 = 1.5rem ~ 16px)
  let scrollPosition = 0;

  prevBtn.addEventListener('click', function (e) {
    e.preventDefault();
    scrollPosition -= itemWidth;
    if (scrollPosition < 0) {
      scrollPosition = 0;
    }
    carouselInner.scrollTo({
      left: scrollPosition,
      behavior: 'smooth'
    });
  });

  nextBtn.addEventListener('click', function (e) {
    e.preventDefault();
    scrollPosition += itemWidth;
    const maxScroll = carouselInner.scrollWidth - carouselInner.clientWidth;
    if (scrollPosition > maxScroll) {
      scrollPosition = maxScroll;
    }
    carouselInner.scrollTo({
      left: scrollPosition,
      behavior: 'smooth'
    });
  });

  // Fade-in effect for product cards on scroll
  const fadeInElements = document.querySelectorAll('.fade-in');

  function checkFadeIn() {
    const triggerBottom = window.innerHeight * 0.9;
    fadeInElements.forEach(el => {
      const rect = el.getBoundingClientRect();
      if (rect.top < triggerBottom) {
        el.classList.add('visible');
      }
    });
  }

  window.addEventListener('scroll', checkFadeIn);
  checkFadeIn(); // Initial check
})