document.addEventListener('DOMContentLoaded', () => {
  const settings = document.querySelector('[data-consultation-settings]');
  const forms = document.querySelectorAll('[data-consultation-form]');
  const siteKey = settings?.dataset.siteKey;

  function revealForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return;
    const panel = form.closest('[role="tabpanel"]');
    const tab = panel && document.querySelector(`[aria-controls="${panel.id}"]`);
    if (tab?.hasAttribute('data-bs-toggle')) {
      bootstrap.Tab.getOrCreateInstance(tab).show();
      bootstrap.Modal.getOrCreateInstance(form.closest('.modal')).show();
    } else {
      tab?.click();
      form.scrollIntoView({ block: 'center', behavior: 'smooth' });
    }
  }

  const previousForm = settings?.dataset.previousForm;
  if (previousForm) revealForm(previousForm);

  document.querySelectorAll('[data-consultation-trigger]').forEach(trigger => {
    trigger.addEventListener('click', event => {
      event.preventDefault();
      revealForm(trigger.dataset.consultationTrigger === 'callback' ? 'modal-callback' : 'modal-consultation');
    });
  });

  async function captchaToken() {
    if (!siteKey) return '';
    return new Promise((resolve, reject) => {
      const timeout = setTimeout(() => reject(new Error('Không tải được reCAPTCHA. Vui lòng kiểm tra kết nối và thử lại.')), 10000);
      if (!window.grecaptcha?.ready) {
        clearTimeout(timeout);
        reject(new Error('reCAPTCHA chưa sẵn sàng. Vui lòng thử lại sau ít giây.'));
        return;
      }
      grecaptcha.ready(() => {
        grecaptcha.execute(siteKey, { action: 'ghg_consultation' }).then(token => {
          clearTimeout(timeout);
          resolve(token);
        }).catch(() => {
          clearTimeout(timeout);
          reject(new Error('Không thể xác minh reCAPTCHA. Vui lòng thử lại.'));
        });
      });
    });
  }

  forms.forEach(form => form.addEventListener('submit', async event => {
    event.preventDefault();
    const button = form.querySelector('[type="submit"]');
    if (button.disabled || !form.reportValidity()) return;
    const status = form.querySelector('[data-form-status]');
    const originalLabel = button.innerHTML;
    form.querySelectorAll('[data-error-for]').forEach(error => { error.textContent = ''; });
    form.querySelectorAll('[aria-invalid]').forEach(field => field.removeAttribute('aria-invalid'));
    status.className = 'mb-3';
    status.textContent = 'Đang gửi yêu cầu…';
    button.disabled = true;
    button.textContent = 'Đang gửi…';
    try {
      form.elements['g-recaptcha-response'].value = await captchaToken();
      const response = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
      });
      const data = response.headers.get('content-type')?.includes('application/json') ? await response.json() : {};
      if (!response.ok) {
        if (response.status === 422) {
          let firstInvalid;
          Object.entries(data.errors || {}).forEach(([name, messages]) => {
            const error = form.querySelector(`[data-error-for="${name}"]`);
            if (error) error.textContent = messages[0];
            const field = form.elements[name];
            if (field && field.type !== 'hidden') {
              field.setAttribute('aria-invalid', 'true');
              firstInvalid ||= field;
            }
          });
          firstInvalid?.focus();
          throw new Error(Object.values(data.errors || {})[0]?.[0] || 'Vui lòng kiểm tra thông tin đã nhập.');
        }
        if (response.status === 429) throw new Error('Bạn đã gửi quá nhiều yêu cầu. Vui lòng chờ một phút rồi thử lại.');
        if (response.status === 419) throw new Error('Phiên làm việc đã hết hạn. Vui lòng tải lại trang rồi gửi lại.');
        throw new Error('Chưa gửi được yêu cầu. Vui lòng thử lại hoặc gọi 0915 549 148.');
      }
      status.className = 'mb-3 text-success';
      status.textContent = data.message;
      form.reset();
    } catch (error) {
      status.className = 'mb-3 text-danger';
      status.textContent = error.message || 'Kết nối bị gián đoạn. Vui lòng thử lại.';
    } finally {
      form.elements['g-recaptcha-response'].value = '';
      button.disabled = false;
      button.innerHTML = originalLabel;
    }
  }));
});
