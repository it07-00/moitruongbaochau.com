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
    if (section.querySelector('.ghg-energy-months')) {
      rows.querySelectorAll('[data-ghg-row]').forEach((row) => {
        const quantity = row.querySelector('input[type="number"]');
        const amount = document.createElement('div');
        amount.className = 'ghg-fuel-amount';
        quantity.before(amount);
        amount.append(quantity);
        const unitSelect = fieldInput(row, 'unit');
        if (unitSelect) {
          const unitField = unitSelect.closest('.ghg-field');
          unitField.hidden = true;
          unitSelect.classList.add('ghg-energy-unit');
          unitSelect.setAttribute('aria-label', `Đơn vị nhiệt hơi tháng ${fieldInput(row, 'month').value}`);
          amount.append(unitSelect);
          const unitError = unitField.querySelector('.ghg-error');
          if (unitError) quantity.closest('.ghg-field').append(unitError);
        } else {
          const unit = document.createElement('span');
          unit.className = 'ghg-fuel-unit';
          unit.id = `${quantity.id}-unit`;
          unit.textContent = 'kWh';
          quantity.setAttribute('aria-describedby', [quantity.getAttribute('aria-describedby'), unit.id].filter(Boolean).join(' '));
          amount.append(unit);
        }
      });
    }
    const decorateWaterNumbers = (container) => container.querySelectorAll('input[type="number"]').forEach((input) => {
      const label = input.closest('.ghg-field').querySelector('label');
      const unitText = label.textContent.match(/\((m³|mg\/L)\)/)?.[1];
      if (!unitText) return;
      label.childNodes.forEach((node) => {
        if (node.nodeType === Node.TEXT_NODE) node.textContent = node.textContent.replace(/\s*\((m³|mg\/L)\)/, '');
      });
      const amount = document.createElement('div');
      amount.className = 'ghg-fuel-amount';
      input.before(amount);
      const unit = document.createElement('span');
      unit.className = 'ghg-fuel-unit';
      unit.id = `${input.id}-unit`;
      unit.textContent = unitText;
      input.setAttribute('aria-describedby', [input.getAttribute('aria-describedby'), unit.id].filter(Boolean).join(' '));
      amount.append(input, unit);
    });
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
    const waterPicker = section.querySelector('[data-ghg-water-picker]');
    if (waterPicker) {
      const treatmentPicker = waterPicker.querySelector('[data-ghg-water-treatment]');
      const newWaterButton = section.querySelector('[data-ghg-new-water]');
      const showWaterPicker = () => {
        treatmentPicker.value = '';
        newWaterButton.before(waterPicker);
        waterPicker.hidden = false;
        newWaterButton.hidden = true;
        treatmentPicker.focus();
      };
      const createWaterGroup = (groupRows) => {
        const firstRow = groupRows[0];
        const treatment = fieldInput(firstRow, 'treatment_type').value;
        const group = document.createElement('fieldset');
        group.className = 'ghg-fuel-group ghg-water-group';
        group.dataset.ghgWaterSystem = treatment;
        const legend = document.createElement('legend');
        legend.textContent = fieldInput(firstRow, 'treatment_type').selectedOptions[0].textContent;
        group.append(legend);
        const months = document.createElement('div');
        months.className = 'ghg-wastewater-months';
        if (treatment) months.classList.add('ghg-water-shared-treatment');
        group.append(months);
        const zeroValues = Object.fromEntries(Array.from(firstRow.querySelectorAll('[name]')).map((input) => [
          input.name.match(/\[([^\]]+)\]$/)[1], input.type === 'number' ? 0 : input.value,
        ]));
        for (let month = 1; month <= 12; month++) {
          let row = groupRows.find((item) => Number(fieldInput(item, 'month').value) === month);
          if (!row) {
            row = createRow({ ...zeroValues, month, treatment_type: treatment });
            dirty = true;
          }
          row.querySelector('legend').textContent = `Tháng ${month}`;
          fieldInput(row, 'treatment_type').closest('.ghg-field').hidden = Boolean(treatment);
          months.append(row);
        }
        decorateWaterNumbers(months);
        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'ghg-remove-row';
        remove.dataset.ghgRemoveWater = '';
        remove.textContent = 'Xóa hệ thống xử lý (12 tháng)';
        group.append(remove);
        rows.append(group);
        return group;
      };
      const systems = new Map();
      Array.from(rows.querySelectorAll('[data-ghg-row]')).forEach((row) => {
        const treatment = fieldInput(row, 'treatment_type').value;
        if (!treatment && !row.querySelector('[aria-invalid="true"], .ghg-error')
          && Array.from(row.querySelectorAll('input[type="number"]')).every((input) => input.value !== '' && Number(input.value) === 0)) {
          row.remove();
          return;
        }
        if (!systems.has(treatment)) systems.set(treatment, []);
        systems.get(treatment).push(row);
      });
      systems.forEach((groupRows) => {
        const months = groupRows.map((row) => Number(fieldInput(row, 'month').value));
        if (months.every((month) => month >= 1 && month <= 12) && new Set(months).size === months.length
          && rows.querySelectorAll('[data-ghg-row]').length + 12 - groupRows.length <= 200) {
          createWaterGroup(groupRows);
        }
      });
      waterPicker.hidden = rows.querySelector('[data-ghg-water-system]') !== null;
      newWaterButton.hidden = !waterPicker.hidden;
      newWaterButton.addEventListener('click', showWaterPicker);
      treatmentPicker.addEventListener('change', () => {
        if (!treatmentPicker.value) return;
        const existing = Array.from(rows.querySelectorAll('[data-ghg-water-system]')).find((group) => group.dataset.ghgWaterSystem === treatmentPicker.value);
        if (existing) {
          waterPicker.hidden = true;
          newWaterButton.hidden = false;
          existing.querySelector('input[type="number"]')?.focus();
          if (typeof Swal !== 'undefined') Swal.fire({ icon: 'info', text: 'Hệ thống xử lý này đã có bảng 12 tháng. Vui lòng nhập số liệu trong bảng đã tạo.', confirmButtonColor: '#800000' });
          return;
        }
        const unassigned = rows.querySelector('[data-ghg-water-system=""]');
        let group;
        if (unassigned) {
          unassigned.dataset.ghgWaterSystem = treatmentPicker.value;
          unassigned.querySelector('legend').textContent = treatmentPicker.selectedOptions[0].textContent;
          unassigned.querySelectorAll('select[name$="[treatment_type]"]').forEach((select) => {
            select.value = treatmentPicker.value;
            select.closest('.ghg-field').hidden = true;
          });
          unassigned.querySelector('.ghg-wastewater-months').classList.add('ghg-water-shared-treatment');
          group = unassigned;
        } else {
          if (rows.querySelectorAll('[data-ghg-row]').length + 12 > 200) return;
          const firstRow = createRow({ month: 1, treatment_type: treatmentPicker.value });
          firstRow.querySelectorAll('input[type="number"]').forEach((input) => { input.value = 0; });
          group = createWaterGroup([firstRow]);
        }
        waterPicker.hidden = true;
        newWaterButton.hidden = false;
        group.querySelector('input[type="number"]')?.focus();
        dirty = true;
      });
      rows.addEventListener('click', (event) => {
        const remove = event.target.closest('[data-ghg-remove-water]');
        if (!remove) return;
        remove.closest('[data-ghg-water-system]').remove();
        if (!rows.querySelector('[data-ghg-water-system]')) showWaterPicker();
        else newWaterButton.focus();
        dirty = true;
      });
    }
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
        const quantity = fieldInput(row, 'quantity');
        const amount = document.createElement('div');
        amount.className = 'ghg-fuel-amount';
        quantity.before(amount);
        const unit = document.createElement('span');
        unit.className = 'ghg-fuel-unit';
        unit.id = `${quantity.id}-unit`;
        unit.textContent = fieldInput(row, 'unit').selectedOptions[0].textContent;
        quantity.setAttribute('aria-describedby', [quantity.getAttribute('aria-describedby'), unit.id].filter(Boolean).join(' '));
        amount.append(quantity, unit);
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

    fuelPicker?.addEventListener('change', (event) => {
      if (event.target.matches('[data-ghg-group-field]')) {
        const choices = Array.from(section.querySelectorAll('[data-ghg-group-field]'));
        const missing = choices.find((select) => !select.value);
        if (missing) return;
        const values = Object.fromEntries(choices.map((select) => [select.dataset.ghgGroupField, select.value]));
        const key = JSON.stringify([values.fuel_type, values[groupField]]);
        const existing = Array.from(rows.querySelectorAll('[data-ghg-group-key]')).find((group) => group.dataset.ghgGroupKey === key);
        if (existing) {
          fuelPicker.hidden = true;
          newFuelButton.hidden = false;
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
      }
    });
    section.querySelector('[data-ghg-add]')?.addEventListener('click', () => {
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
