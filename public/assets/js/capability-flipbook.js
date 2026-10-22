const reader = document.querySelector('[data-capability-reader]');

async function startReader(root) {
    const status = root.querySelector('[data-reader-status]');
    const book = root.querySelector('[data-reader-book]');
    const previous = root.querySelector('[data-reader-previous]');
    const next = root.querySelector('[data-reader-next]');
    const count = root.querySelector('[data-reader-count]');
    const fallback = root.querySelector('[data-reader-fallback]');
    const toolbar = root.querySelector('[data-reader-toolbar]');
    let document;
    let loadingTask;
    let currentPage = 1;
    let busy = false;
    let visibleCanvas;
    let pointerStart;

    function updateControls() {
        previous.disabled = busy || currentPage <= 1;
        next.disabled = busy || currentPage >= document.numPages;
        count.textContent = `Trang ${currentPage} / ${document.numPages}`;
        book.setAttribute('aria-label', `Hồ sơ năng lực, trang ${currentPage} trên ${document.numPages}`);
        book.setAttribute('aria-busy', String(busy));
    }

    async function renderPage(number) {
        const page = await document.getPage(number);
        const original = page.getViewport({ scale: 1 });
        const width = Math.min(590, Math.max(280, root.clientWidth - 24));
        const height = width * 297 / 210;
        const pixelRatio = Math.min(window.devicePixelRatio || 1, 2);
        const scale = Math.min(width / original.width, height / original.height) * pixelRatio;
        const viewport = page.getViewport({ scale });
        const canvas = window.document.createElement('canvas');
        canvas.width = Math.ceil(viewport.width);
        canvas.height = Math.ceil(viewport.height);
        canvas.setAttribute('aria-hidden', 'true');
        await page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;
        page.cleanup();
        return canvas;
    }

    async function turnPage(number) {
        if (busy || number < 1 || number > document.numPages || number === currentPage) return;
        busy = true;
        updateControls();
        status.textContent = `Đang mở trang ${number}…`;
        let incoming;
        try {
            incoming = await renderPage(number);
            const forwards = number > currentPage;
            const outgoing = visibleCanvas;
            book.append(incoming);
            if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches && incoming.animate) {
                const origin = forwards ? 'left center' : 'right center';
                incoming.style.transformOrigin = origin;
                outgoing.style.transformOrigin = origin;
                const animations = [
                    outgoing.animate([
                        { transform: 'rotateY(0deg)', opacity: 1 },
                        { transform: `rotateY(${forwards ? -85 : 85}deg)`, opacity: 0 },
                    ], { duration: 420, easing: 'ease-in-out', fill: 'forwards' }),
                    incoming.animate([
                        { transform: `rotateY(${forwards ? 85 : -85}deg)`, opacity: 0 },
                        { transform: 'rotateY(0deg)', opacity: 1 },
                    ], { duration: 420, easing: 'ease-in-out', fill: 'forwards' }),
                ];
                await Promise.all(animations.map(animation => animation.finished));
                animations.forEach(animation => animation.cancel());
            }
            outgoing.remove();
            outgoing.width = outgoing.height = 0;
            visibleCanvas = incoming;
            currentPage = number;
            status.textContent = `Đang xem trang ${currentPage} / ${document.numPages}`;
        } catch {
            incoming?.remove();
            status.textContent = 'Chưa mở được trang này. Vui lòng thử lại hoặc tải PDF.';
        } finally {
            busy = false;
            updateControls();
        }
    }

    try {
        if (!root.dataset.pdfModule) throw new Error('PDF renderer unavailable');
        const pdfjs = await import(root.dataset.pdfModule);
        pdfjs.GlobalWorkerOptions.workerSrc = root.dataset.pdfWorker;
        loadingTask = pdfjs.getDocument({ url: root.dataset.pdfUrl, isEvalSupported: false });
        loadingTask.onProgress = ({ loaded, total }) => {
            status.textContent = total ? `Đang tải hồ sơ năng lực… ${Math.min(100, Math.round(loaded / total * 100))}%` : 'Đang tải hồ sơ năng lực…';
        };
        document = await loadingTask.promise;
        visibleCanvas = await renderPage(1);
        book.append(visibleCanvas);
        book.hidden = false;
        toolbar.hidden = false;
        root.querySelector('[data-reader-hint]').hidden = false;
        status.textContent = `Đang xem trang 1 / ${document.numPages}`;
        updateControls();
    } catch {
        await loadingTask?.destroy();
        status.textContent = 'Chưa mở được chế độ lật sách. Bạn có thể xem bản PDF bên dưới hoặc tải về.';
        fallback.src = root.dataset.pdfUrl;
        fallback.hidden = false;
        return;
    }

    previous.addEventListener('click', () => turnPage(currentPage - 1));
    next.addEventListener('click', () => turnPage(currentPage + 1));
    book.addEventListener('keydown', event => {
        const destination = { ArrowLeft: currentPage - 1, ArrowRight: currentPage + 1, Home: 1, End: document.numPages }[event.key];
        if (destination === undefined) return;
        event.preventDefault();
        turnPage(destination);
    });
    book.addEventListener('pointerdown', event => {
        if (event.isPrimary && event.button === 0) pointerStart = { x: event.clientX, y: event.clientY };
    });
    book.addEventListener('pointerup', event => {
        if (!pointerStart) return;
        const dx = event.clientX - pointerStart.x;
        const dy = event.clientY - pointerStart.y;
        pointerStart = undefined;
        if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy) * 1.4) turnPage(currentPage + (dx < 0 ? 1 : -1));
    });
    book.addEventListener('pointercancel', () => { pointerStart = undefined; });
    window.addEventListener('pagehide', () => { document.destroy(); }, { once: true });
}

if (reader) startReader(reader);
