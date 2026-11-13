(() => {
  const isLocalHost = ["localhost", "127.0.0.1", "[::1]", ""].includes(window.location.hostname);
  const interactions = ["pointerdown", "touchstart", "keydown", "wheel"];
  let scriptRequested = false;

  if (!isLocalHost) {
    if (!window.fbq) {
      const queue = window.fbq = function () {
        queue.callMethod
          ? queue.callMethod.apply(queue, arguments)
          : queue.queue.push(arguments);
      };
      if (!window._fbq) window._fbq = queue;
      queue.push = queue;
      queue.loaded = true;
      queue.version = "2.0";
      queue.queue = [];
    }

    function loadPixel(event) {
      if (event && !event.isTrusted) return;
      if (scriptRequested) return;
      scriptRequested = true;
      interactions.forEach(name => document.removeEventListener(name, loadPixel, true));

      if (window.fbq.callMethod || document.querySelector('script[src*="connect.facebook.net/en_US/fbevents.js"]')) return;
      const script = document.createElement("script");
      script.async = true;
      script.src = "https://connect.facebook.net/en_US/fbevents.js";
      document.head.appendChild(script);
    }

    window.fbq("init", "771958201986148");
    window.fbq("track", "PageView");

    window.fbPixelTrack = (eventName, parameters = {}) => {
      window.fbq("track", eventName, parameters);
      loadPixel();
    };

    interactions.forEach(name => document.addEventListener(name, loadPixel, { capture: true, passive: true }));
  } else {
    window.fbPixelTrack = () => {};
  }

  window.bcTrackConversion = (eventName, parameters = {}) => {
    try {
      if (typeof window.fbPixelTrack === "function") {
        window.fbPixelTrack(eventName, parameters);
      }
      if (typeof window.gtag === "function") {
        const gaEvent = eventName === "Lead" ? "generate_lead" : (eventName === "Contact" ? "contact" : eventName);
        window.gtag("event", gaEvent, parameters);
      }
      if (Array.isArray(window.dataLayer)) {
        window.dataLayer.push({
          event: `bc_${String(eventName).toLowerCase()}`,
          ...parameters,
        });
      }
    } catch (_) {}
  };

  window.bcTrackCta = (payload = {}) => {
    try {
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "";
      const endpoint = document.querySelector('meta[name="cta-track-url"]')?.getAttribute("content") || "/cta-track";
      const body = JSON.stringify({
        type: payload.type || "other",
        label: payload.label || null,
        target_url: payload.target_url || null,
        page_url: payload.page_url || window.location.pathname + window.location.search,
        position: payload.position || "content",
        metadata: payload.metadata || null,
      });

      fetch(endpoint, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-CSRF-TOKEN": csrfToken,
          "X-Requested-With": "XMLHttpRequest",
        },
        body,
        keepalive: true,
        credentials: "same-origin",
      }).catch(() => {});
    } catch (_) {}
  };

  function detectCtaPosition(el) {
    if (el.dataset.ctaPosition) return el.dataset.ctaPosition;
    if (el.closest('.floating-contact, [aria-label="Kênh liên hệ nhanh"]')) return "floating";
    if (el.closest("header, #header, #masthead, #offCanvasMenu, #mobile-menu")) return "header";
    if (el.closest("#section-cta, .section-cta")) return "cta_section";
    if (el.closest("footer, #colophon")) return "footer";
    if (el.closest(".modal")) return "modal";
    if (el.closest("aside")) return "sidebar";
    return "content";
  }

  function detectCtaElement(target) {
    if (!target || typeof target.closest !== "function") return null;

    const explicit = target.closest("[data-cta-track]");
    if (explicit) {
      return { el: explicit, type: explicit.getAttribute("data-cta-track") || "consultation" };
    }

    const trigger = target.closest("[data-consultation-trigger]");
    if (trigger) {
      return { el: trigger, type: "consultation" };
    }

    const profileBtn = target.closest("[data-profile-reader-open]");
    if (profileBtn) {
      return { el: profileBtn, type: "pdf" };
    }

    const link = target.closest("a[href]");
    if (!link) return null;

    const href = (link.getAttribute("href") || "").trim();
    const lowerHref = href.toLowerCase();

    if (lowerHref.startsWith("tel:")) {
      return { el: link, type: "hotline" };
    }
    if (lowerHref.includes("zalo.me")) {
      return { el: link, type: "zalo" };
    }
    if (lowerHref.startsWith("mailto:")) {
      return { el: link, type: "email" };
    }
    if (link.classList.contains("contact-map") || lowerHref.includes("google.com/maps") || lowerHref.includes("maps.app.goo.gl")) {
      return { el: link, type: "map" };
    }
    if (lowerHref.includes("/tai-lieu.pdf") || lowerHref.endsWith(".pdf")) {
      return { el: link, type: "pdf" };
    }
    if (
      href === "#form-register-login-features" ||
      href === "#form-ung-tuyen" ||
      link.classList.contains("declaration-form-button") ||
      link.classList.contains("header-consultation") ||
      link.closest("#section-cta, .section-cta") ||
      (lowerHref.includes("/lien-he") && (link.classList.contains("c-button") || link.classList.contains("btn")))
    ) {
      return { el: link, type: "consultation" };
    }

    return null;
  }

  if (!window.__bcCtaListenerAttached) {
    window.__bcCtaListenerAttached = true;
    document.addEventListener("click", (event) => {
      const match = detectCtaElement(event.target);
      if (!match) return;

      const { el, type } = match;
      const label = (
        el.dataset.ctaLabel ||
        el.getAttribute("aria-label") ||
        el.getAttribute("title") ||
        el.textContent ||
        type
      ).replace(/\s+/g, " ").trim().slice(0, 255);
      const targetUrl = el.getAttribute("href") || el.dataset.consultationTrigger || null;
      const position = detectCtaPosition(el);

      window.bcTrackCta({
        type,
        label,
        target_url: targetUrl,
        page_url: window.location.pathname + window.location.search,
        position,
      });

      const pixelEventMap = {
        hotline: "Contact",
        zalo: "Contact",
        email: "Contact",
        map: "FindLocation",
        pdf: "ViewContent",
        consultation: "Lead",
        form_submit: "Lead",
      };

      window.bcTrackConversion(pixelEventMap[type] || "Contact", {
        content_category: type,
        content_name: label,
        content_location: position,
      });
    }, { capture: true, passive: true });
  }
})();
