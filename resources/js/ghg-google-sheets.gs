const GHG_SPREADSHEET_ID = '1dQgYELFqBrDCY2Z-9V9hV6xOpirtQ6A4r8O3ugJ6pzI';
const GHG_SHEET_NAME = 'Trang tính1';
const GHG_HEADERS = ['Mã yêu cầu', 'Thời gian gửi', 'Họ tên', 'Số điện thoại', 'Email', 'Doanh nghiệp', 'Loại yêu cầu', 'Nội dung tư vấn', 'Nguồn gửi', 'Trạng thái'];

function ghgResult(result) {
  return ContentService.createTextOutput(JSON.stringify(result)).setMimeType(ContentService.MimeType.JSON);
}

function doPost(e) {
  let lock;
  try {
    const data = JSON.parse(e.postData.contents);
    const token = PropertiesService.getScriptProperties().getProperty('GHG_WEBHOOK_TOKEN');
    if (!token || token.length < 32 || data.token !== token) {
      return ghgResult({ok: false, error: 'unauthorized'});
    }
    if (data.spreadsheet_id !== GHG_SPREADSHEET_ID || data.sheet_name !== GHG_SHEET_NAME
      || !/^[a-f0-9-]{36}$/i.test(data.request_id || '') || !Array.isArray(data.values)
      || data.values.length !== GHG_HEADERS.length || data.values[0] !== data.request_id
      || data.values.some(value => typeof value !== 'string' || value.length > 12000)) {
      return ghgResult({ok: false, error: 'invalid_payload'});
    }
    lock = LockService.getScriptLock();
    lock.waitLock(10000);
    const sheet = SpreadsheetApp.openById(GHG_SPREADSHEET_ID).getSheetByName(GHG_SHEET_NAME);
    if (!sheet || JSON.stringify(sheet.getRange(1, 1, 1, GHG_HEADERS.length).getDisplayValues()[0]) !== JSON.stringify(GHG_HEADERS)) {
      return ghgResult({ok: false, error: 'invalid_headers'});
    }
    const lastRow = sheet.getLastRow();
    if (lastRow > 1 && sheet.getRange(2, 1, lastRow - 1, 1).createTextFinder(data.request_id).matchEntireCell(true).findNext()) {
      return ghgResult({ok: true, request_id: data.request_id, duplicate: true});
    }
    const row = lastRow + 1;
    if (row > sheet.getMaxRows()) {
      sheet.insertRowsAfter(sheet.getMaxRows(), 100);
    }
    const range = sheet.getRange(row, 1, 1, GHG_HEADERS.length);
    range.setNumberFormat('@');
    range.setRichTextValues([data.values.map(value => SpreadsheetApp.newRichTextValue().setText(value).build())]);
    range.setWrap(true);
    SpreadsheetApp.flush();
    return ghgResult({ok: true, request_id: data.request_id});
  } catch (error) {
    return ghgResult({ok: false, error: 'sync_failed'});
  } finally {
    if (lock && lock.hasLock()) {
      lock.releaseLock();
    }
  }
}
