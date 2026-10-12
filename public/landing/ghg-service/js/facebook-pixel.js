(() => {
  if (["localhost", "127.0.0.1", "[::1]", ""].includes(window.location.hostname)) {
    window.fbPixelTrack = () => {};
    return;
  }

  const interactions = ["pointerdown", "touchstart", "keydown", "wheel"];
  let scriptRequested = false;

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

    // Another integration may already have loaded the shared Pixel library.
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
})();
