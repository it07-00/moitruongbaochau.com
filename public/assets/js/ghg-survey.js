document.addEventListener('DOMContentLoaded', () => {
  const stepList = document.querySelector('.ghg-step-nav ol');
  const activeStep = stepList?.querySelector('[aria-current="step"]');
  if (activeStep && stepList.scrollWidth > stepList.clientWidth) {
    stepList.scrollLeft = activeStep.getBoundingClientRect().left - stepList.getBoundingClientRect().left + stepList.scrollLeft - (stepList.clientWidth - activeStep.offsetWidth) / 2;
  }

  const form = document.querySelector('[data-ghg-form]');
  if (!form) return;

  let dirty = false;
  form.addEventListener('input', () => { dirty = true; });
  form.addEventListener('change', () => { dirty = true; });
  window.addEventListener('beforeunload', (event) => {
    if (dirty) {
      event.preventDefault();
      event.returnValue = '';
    }
  });
  form.addEventListener('submit', () => { dirty = false; });

  form.querySelectorAll('[data-ghg-section]').forEach((section) => {
    const rows = section.querySelector('[data-ghg-rows]');
    const template = section.querySelector('[data-ghg-template]');
    let nextIndex = Array.from(rows.querySelectorAll('[name]')).reduce((max, input) => {
      const match = input.name.match(/\[(\d+)\]/);
      return Math.max(max, match ? Number(match[1]) + 1 : 0);
    }, 0);

    section.querySelector('[data-ghg-add]')?.addEventListener('click', () => {
      if (rows.children.length >= 200) return;
      rows.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', String(nextIndex++)));
      rows.lastElementChild.querySelector('input, select')?.focus();
      dirty = true;
    });
    rows.addEventListener('click', (event) => {
      const remove = event.target.closest('[data-ghg-remove]');
      if (remove) {
        remove.closest('[data-ghg-row]').remove();
        section.querySelector('[data-ghg-add]')?.focus();
        dirty = true;
      }
    });
  });
});
