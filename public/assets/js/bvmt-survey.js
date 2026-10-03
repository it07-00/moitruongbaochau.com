(() => {
    const shell = document.querySelector('.bvmt-shell');
    const form = document.getElementById('bvmt-form');
    if (!shell || !form) return;
    const status = document.getElementById('bvmt-client-status');
    const value = name => form.querySelector(`[name="data[${name}]"]:checked`)?.value ?? form.querySelector(`[name="data[${name}]"]`)?.value;
    const updateConditions = () => {
        const conditions = {
            seasonal: value('operation_frequency') === 'seasonal',
            report: value('has_environment_report_2025') === '1',
            year2025: shell.dataset.hasReport !== '1',
            wastewater: value('has_wastewater_treatment') === '1',
            air: value('has_air_treatment') === '1',
        };
        form.querySelectorAll('[data-condition]').forEach(element => {
            element.hidden = !conditions[element.dataset.condition];
        });
    };
    const renumber = table => {
        const rows = table.querySelectorAll('[data-rows] > [data-row]');
        rows.forEach((row, index) => {
            row.querySelector('[data-row-number]').textContent = index + 1;
            row.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace(/\[(?:\d+|__INDEX__)\]/, `[${index}]`);
            });
        });
        const empty = table.querySelector('[data-empty]');
        if (empty) empty.hidden = rows.length > 0;
    };
    let rowSerial = 0;
    form.addEventListener('click', async event => {
        const goto = event.target.closest('[data-goto]');
        if (goto) document.getElementById('bvmt-target-step').value = goto.dataset.goto;
        const add = event.target.closest('[data-add-row]');
        if (add) {
            const table = add.closest('[data-table]');
            if (table.querySelectorAll('[data-row]').length >= 200) { status.textContent = 'Mỗi bảng tối đa 200 dòng.'; return; }
            const fragment = table.querySelector('template').content.cloneNode(true);
            const ids = new Map();
            fragment.querySelectorAll('[id]').forEach(element => {
                const newId = `${element.id}-${Date.now()}-${rowSerial++}`;
                ids.set(element.id, newId);
                element.id = newId;
            });
            fragment.querySelectorAll('[for]').forEach(label => { label.htmlFor = ids.get(label.htmlFor) ?? label.htmlFor; });
            fragment.querySelectorAll('[aria-labelledby]').forEach(element => { element.setAttribute('aria-labelledby', ids.get(element.getAttribute('aria-labelledby')) ?? element.getAttribute('aria-labelledby')); });
            table.querySelector('[data-rows]').append(fragment);
            renumber(table);
            updateConditions();
            table.querySelector('[data-rows]').lastElementChild.querySelector('input,select,textarea')?.focus();
        }
        const remove = event.target.closest('[data-remove-row]');
        if (remove) { const table = remove.closest('[data-table]'); remove.closest('[data-row]').remove(); renumber(table); }
        const deleteFile = event.target.closest('[data-delete-file]');
        if (deleteFile && window.confirm('Xóa tệp này khỏi hồ sơ?')) {
            deleteFile.disabled = true;
            try {
                const response = await fetch(deleteFile.dataset.deleteFile, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value, Accept: 'application/json' } });
                if (!response.ok) throw new Error(response.status === 409 ? 'Phiếu đã khóa chỉnh sửa.' : 'Không xóa được tệp. Vui lòng thử lại.');
                const input = form.querySelector(`[data-upload-category="${deleteFile.dataset.category}"]`);
                if (input) input.dataset.storedCount = Math.max(0, Number(input.dataset.storedCount) - 1);
                deleteFile.closest('[data-file]').remove();
                status.textContent = 'Đã xóa tệp. Dữ liệu đang nhập được giữ nguyên.';
            } catch (error) { status.textContent = error.message; deleteFile.disabled = false; }
        }
    });
    form.addEventListener('change', event => {
        updateConditions();
        if (event.target.matches('input[type="file"]')) {
            const files = [...event.target.files];
            if (files.length + Number(event.target.dataset.storedCount) > 10 || files.some(file => file.size > 20 * 1024 * 1024)) {
                status.textContent = 'Mỗi nhóm tối đa 10 tệp, mỗi tệp tối đa 20 MB. Vui lòng chọn lại.';
                event.target.value = '';
                return;
            }
            const document = event.target.closest('[data-document]');
            if (document && files.length) document.querySelector('select').value = 'available';
            status.textContent = files.length ? `Đã chọn ${files.length} tệp. Bấm lưu hoặc chuyển bước để tải lên.` : '';
        }
    });
    let submitting = false;
    let dirty = false;
    form.addEventListener('input', () => { dirty = true; });
    form.addEventListener('change', () => { dirty = true; });
    form.addEventListener('submit', event => {
        const fileCount = [...form.querySelectorAll('input[type="file"]')].reduce((count, input) => count + input.files.length, 0);
        if (fileCount > 20) { event.preventDefault(); status.textContent = 'Mỗi lần lưu chọn tối đa 20 tệp. Hãy lưu theo từng nhóm rồi tải thêm.'; return; }
        if (submitting) { event.preventDefault(); return; }
        submitting = true;
        status.textContent = fileCount ? 'Đang lưu dữ liệu và tải hồ sơ…' : 'Đang lưu dữ liệu…';
        form.setAttribute('aria-busy', 'true');
    });
    window.addEventListener('beforeunload', event => { if (dirty && !submitting) { event.preventDefault(); event.returnValue = ''; } });
    document.querySelector('[data-copy-link]')?.addEventListener('click', async event => {
        const input = event.target.closest('.bvmt-resume').querySelector('input');
        try { await navigator.clipboard.writeText(input.value); event.target.textContent = 'Đã sao chép'; }
        catch { input.select(); event.target.textContent = 'Chọn link để sao chép'; }
    });
    updateConditions();
    document.querySelector('.bvmt-errors')?.focus();
})();
