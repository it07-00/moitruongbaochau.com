(() => {
  if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const elements = [...document.querySelectorAll('[data-x-aos]')]
    .filter(element => !element.closest('#su-cap-thiet'));

  const reveal = element => {
    element.classList.add('ghg-reveal-visible');
    observer.unobserve(element);
  };

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) reveal(entry.target);
    });
  }, { rootMargin: '0px 0px 100px 0px', threshold: 0 });

  elements.forEach(element => {
    element.classList.add('ghg-reveal-ready');
    observer.observe(element);
  });

  // Keyboard navigation must reveal content even before it crosses the scroll threshold.
  document.addEventListener('focusin', event => {
    let element = event.target.closest('.ghg-reveal-ready');
    while (element) {
      reveal(element);
      element = element.parentElement?.closest('.ghg-reveal-ready');
    }
  });
})();
