const pdfJsUrl = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@6.5.438/';
const trigger = document.querySelector('[data-profile-reader-open]');
const dialog = document.querySelector('#capability-reader');

if (typeof dialog?.showModal === 'function') {
    const stage = dialog.querySelector('[data-profile-reader-stage]');
    const pageView = dialog.querySelector('[data-profile-reader-page]');
    const status = dialog.querySelector('[data-profile-reader-status]');
    const counter = dialog.querySelector('[data-profile-reader-counter]');
    const previous = dialog.querySelector('[data-profile-reader-previous]');
    const next = dialog.querySelector('[data-profile-reader-next]');
    let reader;

    function isActive(session) {
        return reader === session && dialog.open;
    }

    function showError() {
        status.textContent = 'Không thể hiển thị sách lật. Bạn có thể chọn Mở PDF để tiếp tục đọc.';
        pageView.replaceChildren();
        counter.textContent = '';
        previous.disabled = true;
        next.disabled = true;
    }

    async function renderPage(session, number) {
        session.rendering = true;

        try {
            const page = await session.pdf.getPage(number);
            if (!isActive(session)) return;

            const size = page.getViewport({ scale: 1 });
            const scale = Math.min(stage.clientWidth / size.width, stage.clientHeight / size.height);
            const viewport = page.getViewport({ scale: scale * Math.min(window.devicePixelRatio || 1, 2) });
            const canvas = document.createElement('canvas');
            canvas.width = Math.ceil(viewport.width);
            canvas.height = Math.ceil(viewport.height);
            canvas.style.width = `${size.width * scale}px`;

            await page.render({ canvas, viewport }).promise;
            if (!isActive(session)) return;

            const direction = Math.sign(number - session.page);
            pageView.replaceChildren(canvas);
            if (session.page && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                canvas.style.transformOrigin = direction > 0 ? 'left center' : 'right center';
                canvas.animate([
                    { transform: `perspective(1000px) rotateY(${direction * 55}deg)`, opacity: 0.45 },
                    { transform: 'perspective(1000px) rotateY(0)', opacity: 1 },
                ], { duration: 300, easing: 'ease-out' });
            }

            session.page = number;
            status.textContent = '';
            counter.textContent = `Trang ${number} / ${session.pdf.numPages}`;
            previous.disabled = number === 1;
            next.disabled = number === session.pdf.numPages;
        } catch {
            if (isActive(session)) showError();
        } finally {
            session.rendering = false;
        }
    }

    function turnPage(step) {
        if (!reader?.pdf || reader.rendering || (step < 0 ? previous.disabled : next.disabled)) return;
        void renderPage(reader, reader.page + step);
    }

    trigger.setAttribute('aria-haspopup', 'dialog');
    trigger.addEventListener('click', async (event) => {
        if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

        event.preventDefault();
        const session = { page: 0, rendering: false };
        reader = session;
        status.textContent = 'Đang tải hồ sơ năng lực…';
        dialog.showModal();

        try {
            const { getDocument, GlobalWorkerOptions } = await import(`${pdfJsUrl}legacy/build/pdf.min.mjs`);
            if (!isActive(session)) return;

            GlobalWorkerOptions.workerSrc = `${pdfJsUrl}legacy/build/pdf.worker.min.mjs`;
            session.loadingTask = getDocument({
                url: trigger.href,
                cMapUrl: `${pdfJsUrl}cmaps/`,
                standardFontDataUrl: `${pdfJsUrl}standard_fonts/`,
                wasmUrl: `${pdfJsUrl}wasm/`,
                disableStream: true,
                disableAutoFetch: true,
            });
            session.pdf = await session.loadingTask.promise;
            if (isActive(session)) await renderPage(session, 1);
        } catch {
            if (isActive(session)) showError();
        }
    });

    previous.addEventListener('click', () => turnPage(-1));
    next.addEventListener('click', () => turnPage(1));
    dialog.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
            event.preventDefault();
            turnPage(event.key === 'ArrowLeft' ? -1 : 1);
        }
    });

    dialog.addEventListener('close', () => {
        const loadingTask = reader?.loadingTask;
        reader = undefined;
        pageView.replaceChildren();
        counter.textContent = '';
        previous.disabled = true;
        next.disabled = true;
        if (loadingTask) void loadingTask.destroy().catch(() => {});
    });
}
