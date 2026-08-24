/**
 * Môi Trường Bảo Châu - Main Script
 * Version: 2.0.0 (Clean & Optimized Vanilla JS)
 * Single Source of Truth for all interactive components
 */

document.addEventListener('DOMContentLoaded', () => {
  initStickyHeader();
  initMobileMenu();
  initSearchToggle();
  initDesktopDropdown();
  initInfiniteMarquee();
  initNumberCounters();
  initBackToTop();
  initTabs();
  initProjectFilter();
  initNewsFilter();
  initContactForm();
  initSmoothScroll();
  initHeroSlider();
});

/* ==========================================================================
   1. STICKY HEADER
   ========================================================================== */
function initStickyHeader() {
  const stickyHeader = document.querySelector('[data-fx-sticky]');
  if (!stickyHeader) return;

  const onScroll = () => {
    if (window.scrollY > 20) {
      stickyHeader.classList.add('is-sticky', 'shadow-md');
    } else {
      stickyHeader.classList.remove('is-sticky', 'shadow-md');
    }
  };

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}

/* ==========================================================================
   2. MOBILE MENU & OFF-CANVAS DRAWER
   ========================================================================== */
function initMobileMenu() {
  const drawer = document.getElementById('offCanvasMenu');
  const btnOpen = document.getElementById('btn-open-mobile-menu') || document.querySelector('[data-open="offCanvasMenu"]');
  const btnClose = drawer ? drawer.querySelector('[data-close]') : null;
  let overlay = document.getElementById('mobileMenuOverlay');

  if (!drawer) return;

  // Tạo overlay nếu chưa có trong DOM
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.id = 'mobileMenuOverlay';
    overlay.className = 'fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-[99998] transition-opacity duration-300 opacity-0 pointer-events-none cursor-pointer';
    document.body.appendChild(overlay);
  }

  // Khởi tạo style chuẩn cho drawer
  drawer.style.setProperty('position', 'fixed', 'important');
  drawer.style.setProperty('top', '0', 'important');
  drawer.style.setProperty('right', '0', 'important');
  drawer.style.setProperty('bottom', '0', 'important');
  drawer.style.setProperty('left', 'auto', 'important');
  drawer.style.setProperty('width', '320px', 'important');
  drawer.style.setProperty('max-width', '85vw', 'important');
  drawer.style.setProperty('z-index', '100000', 'important');
  drawer.style.setProperty('background', '#fff', 'important');
  drawer.style.setProperty('box-shadow', '-5px 0 30px rgba(0,0,0,.25)', 'important');
  drawer.style.setProperty('transition', 'transform 0.3s ease, visibility 0.3s ease', 'important');

  const closeMenu = () => {
    drawer.classList.remove('is-open');
    drawer.style.setProperty('transform', 'translateX(100%)', 'important');
    drawer.style.setProperty('visibility', 'hidden', 'important');

    if (overlay) {
      overlay.style.setProperty('opacity', '0', 'important');
      overlay.style.setProperty('pointer-events', 'none', 'important');
      setTimeout(() => {
        overlay.style.setProperty('display', 'none', 'important');
      }, 300);
    }
    document.body.style.overflow = '';
  };

  const openMenu = () => {
    drawer.classList.add('is-open');
    drawer.style.setProperty('display', 'block', 'important');
    drawer.style.setProperty('visibility', 'visible', 'important');
    drawer.style.setProperty('transform', 'translateX(0)', 'important');

    if (overlay) {
      overlay.style.setProperty('display', 'block', 'important');
      overlay.style.setProperty('pointer-events', 'auto', 'important');
      // trigger reflow
      void overlay.offsetHeight;
      overlay.style.setProperty('opacity', '1', 'important');
    }
    document.body.style.overflow = 'hidden';
  };

  // Ẩn drawer ban đầu
  closeMenu();

  if (btnOpen) {
    btnOpen.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      openMenu();
    });
  }

  if (btnClose) {
    btnClose.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      closeMenu();
    });
  }

  if (overlay) {
    overlay.addEventListener('click', closeMenu);
  }

  // Đóng khi click vào các liên kết lá
  drawer.querySelectorAll('.mobile-nav-link, a:not(.mobile-submenu-toggle):not([href^="#"])').forEach((link) => {
    link.addEventListener('click', () => {
      closeMenu();
    });
  });

  // Mobile Accordion Submenu Toggles
  const menuContainer = document.getElementById('menu-29035c419b') || drawer;
  menuContainer.querySelectorAll('.mobile-submenu-toggle').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();

      const parentLi = btn.closest('li');
      if (!parentLi) return;

      const submenu = parentLi.querySelector(':scope > ul.submenu');
      const chevron = btn.querySelector('.submenu-chevron');
      if (!submenu) return;

      const isHidden = submenu.classList.contains('hidden') || submenu.style.display === 'none';

      // Đóng các submenu anh em cùng cấp
      const siblings = parentLi.parentElement.querySelectorAll(':scope > li.has-submenu');
      siblings.forEach((sib) => {
        if (sib !== parentLi) {
          const sibSub = sib.querySelector(':scope > ul.submenu');
          const sibChev = sib.querySelector('.submenu-chevron');
          if (sibSub) {
            sibSub.classList.add('hidden');
            sibSub.style.display = 'none';
          }
          if (sibChev) {
            sibChev.classList.remove('rotate-180');
          }
        }
      });

      if (isHidden) {
        submenu.classList.remove('hidden');
        submenu.style.display = 'flex';
        if (chevron) chevron.classList.add('rotate-180');
      } else {
        submenu.classList.add('hidden');
        submenu.style.display = 'none';
        if (chevron) chevron.classList.remove('rotate-180');
      }
    });
  });
}

/* ==========================================================================
   3. SEARCH DROPDOWN TOGGLE
   ========================================================================== */
function initSearchToggle() {
  const searchTrigger = document.querySelector('[data-fx-dropdown-toggle="#dropdown-search-aced3469f6"]');
  const searchPane = document.getElementById('dropdown-search-aced3469f6');
  if (!searchTrigger || !searchPane) return;

  const svgSearch = searchTrigger.querySelector('.svg-search');
  const svgClose = searchTrigger.querySelector('.svg-close');

  const toggleSearch = (e) => {
    if (e) {
      e.preventDefault();
      e.stopPropagation();
    }
    const isOpen = searchPane.classList.contains('is-open');
    if (isOpen) {
      searchPane.classList.remove('is-open');
      if (svgSearch) svgSearch.classList.remove('hidden');
      if (svgClose) svgClose.classList.add('hidden');
    } else {
      searchPane.classList.add('is-open');
      if (svgSearch) svgSearch.classList.add('hidden');
      if (svgClose) svgClose.classList.remove('hidden');
      const input = searchPane.querySelector('input[type="search"]');
      if (input) {
        setTimeout(() => input.focus(), 100);
      }
    }
  };

  searchTrigger.addEventListener('click', toggleSearch);

  document.addEventListener('click', (e) => {
    if (searchPane.classList.contains('is-open') && !searchPane.contains(e.target) && !searchTrigger.contains(e.target)) {
      searchPane.classList.remove('is-open');
      if (svgSearch) svgSearch.classList.remove('hidden');
      if (svgClose) svgClose.classList.add('hidden');
    }
  });
}

/* ==========================================================================
   4. DESKTOP DROPDOWN MENU (HOVER INTENT)
   ========================================================================== */
function initDesktopDropdown() {
  document.querySelectorAll('[data-fx-dropdown-menu] > li').forEach((li) => {
    const sub = li.querySelector(':scope > .submenu');
    if (!sub) return;
    let closeTimer = null;

    const showMenu = () => {
      if (closeTimer) {
        clearTimeout(closeTimer);
        closeTimer = null;
      }
      document.querySelectorAll('[data-fx-dropdown-menu] > li').forEach((other) => {
        if (other !== li) other.classList.remove('is-active', 'is-open');
      });
      li.classList.add('is-active', 'is-open');
    };

    const hideMenu = () => {
      if (closeTimer) clearTimeout(closeTimer);
      closeTimer = setTimeout(() => {
        li.classList.remove('is-active', 'is-open');
      }, 250);
    };

    li.addEventListener('mouseenter', showMenu);
    li.addEventListener('mouseleave', hideMenu);
    sub.addEventListener('mouseenter', showMenu);
    sub.addEventListener('mouseleave', hideMenu);
  });
}

/* ==========================================================================
   5. INFINITE MARQUEE SLIDERS (LOGO ĐỐI TÁC / KHÁCH HÀNG)
   ========================================================================== */
function initInfiniteMarquee() {
  document.querySelectorAll('[data-fx-slider]').forEach((sliderContainer) => {
    const wrapper = sliderContainer.querySelector('.swiper-wrapper');
    if (!wrapper || wrapper.getAttribute('data-fx-init') === 'true') return;
    wrapper.setAttribute('data-fx-init', 'true');

    let options = {};
    try {
      if (wrapper.getAttribute('data-swiper-options')) {
        options = JSON.parse(wrapper.getAttribute('data-swiper-options'));
      }
    } catch (e) {}

    const isRTL = !!options.rtl;
    const pixelsPerSecond = 45;

    sliderContainer.style.overflow = 'hidden';
    sliderContainer.style.position = 'relative';
    sliderContainer.style.width = '100%';
    sliderContainer.style.userSelect = 'none';

    wrapper.style.display = 'flex';
    wrapper.style.flexWrap = 'nowrap';
    wrapper.style.width = 'max-content';
    wrapper.style.willChange = 'transform';
    wrapper.style.cursor = 'grab';

    const originalSlides = Array.prototype.slice.call(wrapper.children);
    if (originalSlides.length === 0) return;

    originalSlides.forEach((slide) => {
      slide.style.flexShrink = '0';
      const clone = slide.cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      wrapper.appendChild(clone);
    });

    let halfWidth = wrapper.scrollWidth / 2;
    let currentX = isRTL ? -halfWidth : 0;
    let isPaused = false;
    let isDragging = false;
    let startX = 0;
    let dragStartX = 0;
    let lastTime = performance.now();

    const updateHalfWidth = () => {
      const newHalf = wrapper.scrollWidth / 2;
      if (newHalf > 0) halfWidth = newHalf;
    };

    window.addEventListener('resize', updateHalfWidth);
    wrapper.querySelectorAll('img').forEach((img) => {
      if (!img.complete) {
        img.addEventListener('load', updateHalfWidth, { once: true });
      }
    });
    setTimeout(updateHalfWidth, 500);
    setTimeout(updateHalfWidth, 1500);

    const step = (now) => {
      const dt = (now - lastTime) / 1000;
      lastTime = now;

      if (!isPaused && !isDragging && halfWidth > 0) {
        const distance = pixelsPerSecond * dt;
        if (isRTL) {
          currentX += distance;
          if (currentX >= 0) currentX -= halfWidth;
        } else {
          currentX -= distance;
          if (Math.abs(currentX) >= halfWidth) currentX += halfWidth;
        }
        wrapper.style.transform = `translate3d(${currentX}px, 0, 0)`;
      }
      requestAnimationFrame(step);
    };
    requestAnimationFrame(step);

    sliderContainer.addEventListener('mouseenter', () => { isPaused = true; });
    sliderContainer.addEventListener('mouseleave', () => { if (!isDragging) isPaused = false; });

    sliderContainer.addEventListener('mousedown', (e) => {
      isDragging = true;
      isPaused = true;
      startX = e.pageX;
      dragStartX = currentX;
      wrapper.style.cursor = 'grabbing';
    });

    window.addEventListener('mousemove', (e) => {
      if (!isDragging) return;
      const walk = e.pageX - startX;
      currentX = dragStartX + walk;
      if (currentX > 0) currentX -= halfWidth;
      if (Math.abs(currentX) >= halfWidth * 2) currentX += halfWidth;
      wrapper.style.transform = `translate3d(${currentX}px, 0, 0)`;
    });

    window.addEventListener('mouseup', () => {
      if (!isDragging) return;
      isDragging = false;
      wrapper.style.cursor = 'grab';
      setTimeout(() => { isPaused = false; }, 300);
    });

    sliderContainer.addEventListener('touchstart', (e) => {
      isDragging = true;
      isPaused = true;
      startX = e.touches[0].pageX;
      dragStartX = currentX;
    }, { passive: true });

    window.addEventListener('touchmove', (e) => {
      if (!isDragging) return;
      const walk = e.touches[0].pageX - startX;
      currentX = dragStartX + walk;
      if (currentX > 0) currentX -= halfWidth;
      if (Math.abs(currentX) >= halfWidth * 2) currentX += halfWidth;
      wrapper.style.transform = `translate3d(${currentX}px, 0, 0)`;
    }, { passive: true });

    window.addEventListener('touchend', () => {
      if (!isDragging) return;
      isDragging = false;
      setTimeout(() => { isPaused = false; }, 300);
    });
  });
}

/* ==========================================================================
   6. NUMBER COUNTERS ANIMATION (INTERSECTION OBSERVER)
   ========================================================================== */
function initNumberCounters() {
  const counterContainers = document.querySelectorAll('[data-fx-counter]');
  if (!counterContainers.length) return;

  const animateCount = (el, target, duration = 1500) => {
    let startTimestamp = null;
    const startValue = 0;
    const step = (timestamp) => {
      if (!startTimestamp) startTimestamp = timestamp;
      const progress = Math.min((timestamp - startTimestamp) / duration, 1);
      // Ease out quad
      const easedProgress = 1 - (1 - progress) * (1 - progress);
      const current = Math.floor(easedProgress * (target - startValue) + startValue);
      el.textContent = current.toLocaleString('vi-VN');
      if (progress < 1) {
        requestAnimationFrame(step);
      } else {
        el.textContent = target.toLocaleString('vi-VN');
      }
    };
    requestAnimationFrame(step);
  };

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const container = entry.target;
        const duration = parseInt(container.getAttribute('data-duration') || '1500', 10);
        const counters = container.querySelectorAll('[data-counter], .counter');

        counters.forEach((counterEl) => {
          const rawTarget = counterEl.getAttribute('data-counter') || counterEl.textContent.trim().replace(/\D/g, '');
          const target = parseInt(rawTarget, 10);
          if (!isNaN(target) && target > 0) {
            animateCount(counterEl, target, duration);
          }
        });

        obs.unobserve(container);
      }
    });
  }, { threshold: 0.2 });

  counterContainers.forEach((container) => observer.observe(container));
}

/* ==========================================================================
   7. BACK TO TOP BUTTON
   ========================================================================== */
function initBackToTop() {
  const btn = document.querySelector('[data-fx-scroll-top]') || document.querySelector('.c-back-to-top');
  if (!btn) return;

  const threshold = parseInt(btn.getAttribute('data-scroll-start') || '300', 10);

  const toggleBtn = () => {
    if (window.scrollY > threshold) {
      btn.setAttribute('data-show', 'true');
      btn.classList.remove('opacity-0', 'pointer-events-none');
      btn.classList.add('opacity-100', 'pointer-events-auto');
    } else {
      btn.setAttribute('data-show', 'false');
      btn.classList.remove('opacity-100', 'pointer-events-auto');
      btn.classList.add('opacity-0', 'pointer-events-none');
    }
  };

  window.addEventListener('scroll', toggleBtn, { passive: true });
  toggleBtn();

  btn.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

/* ==========================================================================
   8. TABS COMPONENT
   ========================================================================== */
function initTabs() {
  document.querySelectorAll('[data-fx-tabs]').forEach((tabsNav) => {
    const contentId = tabsNav.getAttribute('id');
    const tabsContent = contentId
      ? document.querySelector(`[data-fx-tabs-content="${contentId}"]`)
      : document.querySelector('.tabs-content');

    const links = tabsNav.querySelectorAll('a[href^="#"]');
    links.forEach((link) => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        const targetId = link.getAttribute('href');
        if (!targetId || targetId === '#' || targetId.length <= 1) return;

        const targetPanel = (tabsContent ? tabsContent.querySelector(targetId) : null) || document.querySelector(targetId);
        if (targetPanel) {
          links.forEach((l) => {
            l.classList.remove('active', 'is-active');
            l.setAttribute('aria-selected', 'false');
            const p = l.closest('.tabs-title');
            if (p) p.classList.remove('is-active', 'active');
          });

          link.classList.add('active', 'is-active');
          link.setAttribute('aria-selected', 'true');
          const parentTitle = link.closest('.tabs-title');
          if (parentTitle) parentTitle.classList.add('is-active', 'active');

          if (tabsContent) {
            tabsContent.querySelectorAll('.tabs-panel').forEach((panel) => {
              panel.classList.remove('is-active', 'active');
            });
          }
          targetPanel.classList.add('is-active', 'active');
        }
      });
    });
  });
}

/* ==========================================================================
   9. PROJECT CATEGORY FILTER
   ========================================================================== */
function initProjectFilter() {
  const projectFilters = document.querySelectorAll('.home-projects-filters .filter-ul a');
  const projectItems = document.querySelectorAll('.home-projects-filters .filter-grid .item');

  if (projectFilters.length > 0 && projectItems.length > 0) {
    projectFilters.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        projectFilters.forEach((b) => b.classList.remove('active'));
        btn.classList.add('active');

        const filterVal = btn.getAttribute('data-filter');
        projectItems.forEach((item) => {
          const cat = item.getAttribute('data-category');
          if (filterVal === '-1' || filterVal === cat) {
            item.style.display = 'flex';
            item.style.opacity = '1';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }
}

/* ==========================================================================
   9b. NEWS CATEGORY FILTER
   ========================================================================== */
function initNewsFilter() {
  const newsFilterLists = document.querySelectorAll('.filter-ul-news');
  if (newsFilterLists.length === 0) return;

  newsFilterLists.forEach((list) => {
    const filterBtns = list.querySelectorAll('a');
    filterBtns.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        filterBtns.forEach((b) => {
          b.classList.remove('active', 'bg-primary', 'text-white', 'shadow-xs', 'font-bold');
          b.classList.add('bg-black/8', 'text-black/80', 'font-semibold');
        });
        btn.classList.add('active', 'bg-primary', 'text-white', 'shadow-xs', 'font-bold');
        btn.classList.remove('bg-black/8', 'text-black/80');
      });
    });
  });
}

/* ==========================================================================
   10. CONTACT FORM SUBMIT HANDLER
   ========================================================================== */
function initContactForm() {
  const form = document.getElementById('contact-consult-form');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const btn = document.getElementById('btn-submit-contact');
    const alertBox = document.getElementById('form-success-alert');

    if (btn) {
      btn.disabled = true;
      btn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Đang gửi thông tin...
      `;
    }

    setTimeout(() => {
      if (btn) {
        btn.disabled = false;
        btn.innerHTML = `
          <span style="white-space: nowrap;">Gửi thông tin</span>
          <svg width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; min-height: 18px;" class="shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
          </svg>
        `;
      }
      if (alertBox) {
        alertBox.classList.remove('hidden');
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }
      form.reset();
    }, 800);
  });
}

/* ==========================================================================
   11. SMOOTH SCROLL FOR ANCHOR LINKS
   ========================================================================== */
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (e) => {
      const targetId = anchor.getAttribute('href');
      if (!targetId || targetId === '#' || targetId.length <= 1) return;
      if (anchor.closest('[data-fx-tabs]')) return; // ignore tabs

      const targetEl = document.querySelector(targetId);
      if (targetEl) {
        e.preventDefault();
        const headerOffset = 80;
        const elementPosition = targetEl.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        });
      }
    });
  });
}

/* ==========================================================================
   12. HERO BANNER SLIDER (Swiper.js)
   ========================================================================== */
function initHeroSlider() {
  if (!document.getElementById('hero-swiper')) return;
  new Swiper('#hero-swiper', {
    loop: true,
    speed: 800,
    autoplay: { delay: 4000, disableOnInteraction: false },
    effect: 'fade',
    fadeEffect: { crossFade: true },
    navigation: true,
    pagination: {
      el: '.swiper-hero-banner .swiper-pagination',
      clickable: true,
    },
  });
}

