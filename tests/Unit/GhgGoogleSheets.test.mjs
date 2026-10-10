import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import vm from 'node:vm';
const code = readFileSync(new URL('../../resources/js/ghg-google-sheets.gs', import.meta.url),'utf8');
const rows = [['Mã yêu cầu','Thời gian gửi','Họ tên','Số điện thoại','Email','Doanh nghiệp','Loại yêu cầu','Nội dung tư vấn','Nguồn gửi','Trạng thái']];
let locked = false;
const sheet = {
 getLastRow:()=>rows.length,getMaxRows:()=>1000,
 getRange(row,col,height,width){return {
  getDisplayValues:()=>rows.slice(row-1,row-1+height).map(r=>r.slice(col-1,col-1+width)),
  createTextFinder(id){return {matchEntireCell(){return this},findNext:()=>rows.slice(1).some(r=>r[0]===id)?{}:null}},
  setNumberFormat(){return this},setWrap(){return this},setRichTextValues(v){rows[row-1]=v[0].map(x=>x.text)}
 }}
};
const ctx = vm.createContext({
 ContentService:{MimeType:{JSON:'json'},createTextOutput(text){return {text,setMimeType(){return this}}}},
 PropertiesService:{getScriptProperties:()=>({getProperty:()=> 'a'.repeat(48)})},
 LockService:{getScriptLock:()=>({waitLock(){locked=true},hasLock:()=>locked,releaseLock(){locked=false}})},
 SpreadsheetApp:{openById:()=>({getSheetByName:()=>sheet}),flush(){},newRichTextValue(){return {setText(text){this.text=text;return this},build(){return {text:this.text}}}}}
});
vm.runInContext(code,ctx);
const id='dc03f558-9830-46f7-852d-43755b4cdf93';
const data={token:'a'.repeat(48),spreadsheet_id:'1dQgYELFqBrDCY2Z-9V9hV6xOpirtQ6A4r8O3ugJ6pzI',sheet_name:'Trang tính1',request_id:id,values:[id,'10/10/2026 17:00:00','Test','0915549148','','Công ty','Tư vấn','=1+1','https://example.com','Mới']};
const send=d=>JSON.parse(ctx.doPost({postData:{contents:JSON.stringify(d)}}).text);
assert.equal(send({...data,token:'wrong'}).ok,false); assert.equal(rows.length,1);
assert.equal(send({...data,sheet_name:'wrong'}).ok,false); assert.equal(rows.length,1);
assert.equal(send(data).ok,true); assert.equal(rows.length,2); assert.equal(rows[1][3],'0915549148');assert.equal(rows[1][7],'=1+1');assert.equal(locked,false);
assert.equal(send(data).duplicate,true);assert.equal(rows.length,2);assert.equal(locked,false);
assert.equal(send({...data,values:[]}).ok,false);
console.log('Apps Script checks passed: token, destination, payload, duplicate ID, literal text, phone and lock release.');

