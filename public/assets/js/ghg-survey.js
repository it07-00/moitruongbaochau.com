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

    rows.addEventListener('change', async (event) => {
      const treatment = event.target.closest('select[name$="[treatment_type]"]');
      if (!treatment || !treatment.value) return;
      const value = treatment.value;
      const message = 'Bạn có muốn áp dụng hệ thống xử lý này cho toàn bộ 11 tháng còn lại không?';
      const confirmed = typeof Swal !== 'undefined'
        ? (await Swal.fire({
          title: 'Đồng bộ dữ liệu?', text: message, icon: 'question', showCancelButton: true,
          confirmButtonText: 'Áp dụng cho cả năm', cancelButtonText: 'Không, để tôi tự nhập',
          confirmButtonColor: '#800000',
        })).isConfirmed
        : window.confirm(message);
      if (!confirmed) return;
      rows.querySelectorAll('select[name$="[treatment_type]"]').forEach((select) => {
        select.value = value;
      });
      dirty = true;
    });

    const groupField = section.dataset.ghgFuelGroup;
    const fuelPicker = section.querySelector('[data-ghg-fuel-picker]');
    const newFuelButton = section.querySelector('[data-ghg-new-fuel]');
    const showFuelPicker = () => {
      fuelPicker.querySelectorAll('select').forEach((select) => { select.value = ''; });
      newFuelButton.before(fuelPicker);
      fuelPicker.hidden = false;
      newFuelButton.hidden = true;
      fuelPicker.querySelector('select').focus();
    };
    newFuelButton?.addEventListener('click', showFuelPicker);
    const fieldInput = (row, field) => row.querySelector(`[name$="[${field}]"]`);
    const createRow = (values) => {
      const fragment = template.content.cloneNode(true);
      const row = fragment.querySelector('[data-ghg-row]');
      row.querySelectorAll('[name], [id], label[for]').forEach((element) => {
        ['name', 'id', 'for'].forEach((attribute) => {
          if (element.hasAttribute(attribute)) {
            element.setAttribute(attribute, element.getAttribute(attribute).replaceAll('__INDEX__', String(nextIndex)));
          }
        });
      });
      nextIndex++;
      Object.entries(values).forEach(([field, value]) => { fieldInput(row, field).value = value; });
      return row;
    };
    const createFuelGroup = (groupRows) => {
      const firstRow = groupRows[0];
      const group = document.createElement('fieldset');
      group.className = 'ghg-fuel-group';
      group.dataset.ghgGroupKey = JSON.stringify([fieldInput(firstRow, 'fuel_type').value, fieldInput(firstRow, groupField).value]);
      const legend = document.createElement('legend');
      legend.textContent = ['fuel_type', groupField, 'unit'].map((field) => {
        const select = fieldInput(firstRow, field);
        return select.selectedOptions[0].textContent;
      }).join(' · ');
      group.append(legend);
      const hint = document.createElement('p');
      hint.className = 'ghg-fuel-hint';
      hint.textContent = 'Lượng sử dụng theo từng tháng, đơn vị như trên. Tháng không phát sinh nhập 0.';
      group.append(hint);
      const months = document.createElement('div');
      months.className = 'ghg-fuel-months';
      group.append(months);
      for (let month = 1; month <= 12; month++) {
        let row = groupRows.find((item) => Number(fieldInput(item, 'month').value) === month);
        if (!row) {
          row = createRow({
            month, quantity: 0, notes: '',
            fuel_type: fieldInput(firstRow, 'fuel_type').value,
            [groupField]: fieldInput(firstRow, groupField).value,
            unit: fieldInput(firstRow, 'unit').value,
          });
          dirty = true;
        }
        row.querySelector('legend').textContent = `Tháng ${month}`;
        const monthLabel = document.createElement('span');
        monthLabel.className = 'ghg-fuel-month-label';
        monthLabel.setAttribute('aria-hidden', 'true');
        monthLabel.textContent = `Tháng ${month}`;
        row.querySelector('.ghg-fields-grid').before(monthLabel);
        ['month', 'fuel_type', groupField, 'unit', 'notes'].forEach((field) => {
          fieldInput(row, field).closest('.ghg-field').hidden = true;
        });
        row.querySelector('[data-ghg-remove]').hidden = true;
        months.append(row);
      }
      const notesField = document.createElement('div');
      notesField.className = 'ghg-field ghg-fuel-notes';
      const notesLabel = document.createElement('label');
      const notesInput = document.createElement('textarea');
      notesInput.id = `${fieldInput(firstRow, 'notes').id}-shared`;
      notesInput.rows = 2;
      notesInput.maxLength = 255;
      notesInput.placeholder = 'Thiết bị, phân xưởng hoặc hóa đơn liên quan (nếu có)';
      notesLabel.htmlFor = notesInput.id;
      notesLabel.textContent = 'Ghi chú chung cho 12 tháng';
      const monthlyNotes = Array.from(months.querySelectorAll('[data-ghg-row]')).map((row) => ({
        month: fieldInput(row, 'month').value,
        note: fieldInput(row, 'notes').value,
      }));
      const distinctNotes = new Set(monthlyNotes.map((item) => item.note));
      notesInput.value = distinctNotes.size === 1
        ? monthlyNotes[0].note
        : monthlyNotes.filter((item) => item.note).map((item) => `Tháng ${item.month}: ${item.note}`).join('\n');
      notesInput.addEventListener('input', () => {
        months.querySelectorAll('[data-ghg-row]').forEach((row) => {
          fieldInput(row, 'notes').value = notesInput.value;
        });
      });
      notesField.append(notesLabel, notesInput);
      group.append(notesField);
      const remove = document.createElement('button');
      remove.type = 'button';
      remove.className = 'ghg-remove-row';
      remove.dataset.ghgRemoveGroup = '';
      remove.textContent = 'Xóa nhóm nhiên liệu (12 tháng)';
      group.append(remove);
      rows.append(group);
      return group;
    };
    if (groupField) {
      const groups = new Map();
      Array.from(rows.querySelectorAll('[data-ghg-row]')).forEach((row) => {
        if (!['fuel_type', groupField, 'unit'].every((field) => fieldInput(row, field).value)) return;
        const key = JSON.stringify([fieldInput(row, 'fuel_type').value, fieldInput(row, groupField).value]);
        if (!groups.has(key)) groups.set(key, []);
        groups.get(key).push(row);
      });
      groups.forEach((groupRows) => {
        const months = groupRows.map((row) => Number(fieldInput(row, 'month').value));
        if (months.every((month) => month >= 1 && month <= 12) && new Set(months).size === months.length
          && rows.querySelectorAll('[data-ghg-row]').length + 12 - groupRows.length <= 200) {
          createFuelGroup(groupRows);
        }
      });
      fuelPicker.hidden = rows.querySelector('[data-ghg-group-key]') !== null;
      newFuelButton.hidden = !fuelPicker.hidden;
    }

    section.querySelector('[data-ghg-add]')?.addEventListener('click', () => {
      if (groupField) {
        const choices = Array.from(section.querySelectorAll('[data-ghg-group-field]'));
        const missing = choices.find((select) => !select.value);
        if (missing) {
          if (typeof Swal !== 'undefined') {
            Swal.fire({ icon: 'info', text: 'Vui lòng chọn đầy đủ thông tin để tạo 12 tháng.', confirmButtonColor: '#800000' });
          }
          missing.focus();
          return;
        }
        const values = Object.fromEntries(choices.map((select) => [select.dataset.ghgGroupField, select.value]));
        const key = JSON.stringify([values.fuel_type, values[groupField]]);
        const existing = Array.from(rows.querySelectorAll('[data-ghg-group-key]')).find((group) => group.dataset.ghgGroupKey === key);
        if (existing) {
          existing.querySelector('[name$="[quantity]"]').focus();
          if (typeof Swal !== 'undefined') Swal.fire({ icon: 'info', text: 'Nhóm nhiên liệu này đã có đủ 12 tháng. Vui lòng nhập số liệu trong nhóm đã tạo.', confirmButtonColor: '#800000' });
          return;
        }
        if (rows.querySelectorAll('[data-ghg-row]').length + 12 > 200) return;
        const group = createFuelGroup([createRow({ ...values, month: 1, quantity: 0, notes: '' })]);
        fuelPicker.hidden = true;
        newFuelButton.hidden = false;
        group.querySelector('[name$="[quantity]"]').focus();
        dirty = true;
        return;
      }
      if (rows.children.length >= 200) return;
      rows.insertAdjacentHTML('beforeend', template.innerHTML.replaceAll('__INDEX__', String(nextIndex++)));
      rows.lastElementChild.querySelector('input, select')?.focus();
      dirty = true;
    });
    rows.addEventListener('click', (event) => {
      const removeGroup = event.target.closest('[data-ghg-remove-group]');
      if (removeGroup) {
        removeGroup.closest('[data-ghg-group-key]').remove();
        if (!rows.querySelector('[data-ghg-group-key]')) {
          showFuelPicker();
        } else {
          newFuelButton.focus();
        }
        dirty = true;
        return;
      }
      const remove = event.target.closest('[data-ghg-remove]');
      if (remove) {
        remove.closest('[data-ghg-row]').remove();
        section.querySelector('[data-ghg-add]')?.focus();
        dirty = true;
      }
    });
  });
});
