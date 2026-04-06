{{-- _scripts.blade.php — All index-page JavaScript --}}
<script>
/* ── HELPERS ── */
function openModal(id){document.getElementById(id)?.classList.add('active');document.body.style.overflow='hidden'}
function closeModal(id){document.getElementById(id)?.classList.remove('active');document.body.style.overflow=''}
function loading(){return '<div class="idx-modal-loading"><p style="color:var(--ink-4)">Loading…</p></div>'}
function reExec(el){el.querySelectorAll('script').forEach(old=>{const s=document.createElement('script');[...old.attributes].forEach(a=>s.setAttribute(a.name,a.value));s.textContent=old.textContent;old.parentNode.replaceChild(s,old)})}
function initFP(root=document){if(!window.flatpickr||!root?.querySelectorAll)return;root.querySelectorAll('.date-picker,.date-picker-multi,.date-picker-range').forEach(e=>{if(e._flatpickr)e._flatpickr.destroy()});root.querySelectorAll('.date-picker').forEach(e=>flatpickr(e,{dateFormat:'F j, Y',allowInput:true}));root.querySelectorAll('.date-picker-multi').forEach(e=>flatpickr(e,{mode:'multiple',dateFormat:'F j, Y',allowInput:true}));root.querySelectorAll('.date-picker-range').forEach(e=>flatpickr(e,{mode:'range',dateFormat:'F j, Y',allowInput:true}))}

/* ── TAB SWITCHING ── */
function idxTab(name){
  document.querySelectorAll('.idx-tab').forEach(t=>{t.classList.toggle('active',t.id==='idx-t-'+name);t.setAttribute('aria-selected',t.id==='idx-t-'+name)});
  document.querySelectorAll('.idx-panel').forEach(p=>p.classList.toggle('active',p.id==='idx-p-'+name));
  const _params=new URLSearchParams(location.search);_params.set('tab',name);history.replaceState(null,'','{{ route("ld.index") }}?'+_params.toString());
}

/* ── PRINT MODAL ── */
function openPrintModal(url){document.getElementById('printModalFrame').src=url;openModal('printModal')}
function closePrintModal(){closeModal('printModal');document.getElementById('printModalFrame').src=''}
document.getElementById('printModal')?.addEventListener('click',e=>{if(e.target.id==='printModal')closePrintModal()});

/* ── PARTICIPATION VIEW ── */
function openViewModal(id){
  openModal('viewModal');
  document.getElementById('viewModalBody').innerHTML=loading();
  fetch(`/ld-requests/${id}/show-modal`,{headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.text()).then(html=>{document.getElementById('viewModalBody').innerHTML=html})
}

/* ── PARTICIPATION CREATE ── */
function openCreateModal(){openModal('createModal')}

/* ── PARTICIPATION EDIT ── */
function openEditModal(id){
  openModal('editModal');
  const b=document.getElementById('editModalBody');
  b.innerHTML=loading();
  fetch(`/ld-requests/${id}/edit-modal`,{headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.text()).then(html=>{b.innerHTML=html;reExec(b);initFP(b)})
    .catch(()=>{b.innerHTML='<div style="padding:1rem">Failed to load.</div>'})
}

/* ── GENERIC FORM MODAL ── */
const _fRoutes={
  'attendance':         '/ld-requests/form/attendance',
  'publication':        '/ld-requests/form/publication',
  'reimbursement':      '/ld-requests/form/reimbursement',
  'travel':             '/ld-requests/form/travel',
  'attendance-edit':    id=>`/ld-requests/attendance/${id}/edit-modal`,
  'publication-edit':   id=>`/ld-requests/publication/${id}/edit-modal`,
  'reimbursement-edit': id=>`/ld-requests/reimbursement/${id}/edit-modal`,
  'travel-edit':        id=>`/ld-requests/travel/${id}/edit-modal`,
};
function openFormModal(type,title,id=null){
  document.getElementById('gFormTitle').textContent=title;
  document.getElementById('gFormBody').innerHTML=loading();
  openModal('gFormModal');
  const route=typeof _fRoutes[type]==='function'?_fRoutes[type](id):_fRoutes[type];
  fetch(route,{headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.text()).then(html=>{const c=document.getElementById('gFormBody');c.innerHTML=html;reExec(c);initFP(c)})
    .catch(()=>{document.getElementById('gFormBody').innerHTML='<div style="padding:3rem;text-align:center;color:var(--ink-4)"><div style="font-size:2rem;margin-bottom:10px">🚧</div><strong>Form coming soon</strong></div>'})
}

/* ── GENERIC VIEW MODAL ── */
const _vRoutes={
  attendance:    id=>`/ld-requests/attendance/${id}/show-modal`,
  publication:   id=>`/ld-requests/publication/${id}/show-modal`,
  reimbursement: id=>`/ld-requests/reimbursement/${id}/show-modal`,
  travel:        id=>`/ld-requests/travel/${id}/show-modal`,
};
function openGenericView(type,id,title){
  document.getElementById('gViewTitle').textContent=title;
  document.getElementById('gViewBody').innerHTML=loading();
  openModal('gViewModal');
  fetch(_vRoutes[type](id),{headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.text()).then(html=>{document.getElementById('gViewBody').innerHTML=html})
    .catch(()=>{document.getElementById('gViewBody').innerHTML='<p style="padding:2rem;text-align:center;color:var(--ink-4)">Could not load details.</p>'})
}

/* ── RECORDS POPUP ── */
const recCfg={
  participation:{apiUrl:'/ld-requests/records/participation',addFn:()=>{closeRecords();openCreateModal()},
    dk:'intervention_date',lk:'level',fk:'financial_requested',
    cols:[{l:'#',k:'_index'},{l:'Tracking #',k:'tracking_number'},{l:'Participant',k:'participant_name'},{l:'Position',k:'position'},{l:'Campus',k:'campus'},{l:'College/Office',k:'college_office'},{l:'Status',k:'employment_status'},{l:'Title',k:'title'},{l:'Types',k:'types',arr:true},{l:'Level',k:'level',badge:'gold'},{l:'Nature',k:'natures',arr:true},{l:'Date',k:'intervention_date'},{l:'Venue',k:'venue'},{l:'Organizer',k:'organizer'},{l:'Financial?',k:'financial_requested',bool:true},{l:'Amount',k:'amount_requested',cur:true},{l:'Coverage',k:'coverage',arr:true}]},
  attendance:{apiUrl:'/ld-requests/records/attendance',addFn:()=>{closeRecords();openFormModal('attendance','📅 New Attendance Request')},
    dk:'activity_date',lk:'level',fk:'financial_requested',
    cols:[{l:'#',k:'_index'},{l:'Tracking #',k:'tracking_number'},{l:'Attendee',k:'attendee_name'},{l:'Position',k:'position'},{l:'Campus',k:'campus'},{l:'College/Office',k:'college_office'},{l:'Status',k:'employment_status'},{l:'Activity',k:'activity_types',arr:true},{l:'Purpose',k:'purpose'},{l:'Level',k:'level',badge:'gold'},{l:'Date',k:'activity_date'},{l:'Venue',k:'venue'},{l:'Financial?',k:'financial_requested',bool:true},{l:'Amount',k:'amount_requested',cur:true}]},
  publication:{apiUrl:'/ld-requests/records/publication',addFn:()=>{closeRecords();openFormModal('publication','📰 New Publication Request')},
    dk:'created_at',lk:null,fk:null,
    cols:[{l:'#',k:'_index'},{l:'Tracking #',k:'tracking_number'},{l:'Faculty',k:'faculty_name'},{l:'Position',k:'position'},{l:'Campus',k:'campus'},{l:'Paper Title',k:'paper_title'},{l:'Co-authors',k:'co_authors'},{l:'Journal',k:'journal_title'},{l:'ISSN/ISBN',k:'issn_isbn'},{l:'Publisher',k:'publisher'},{l:'Scope',k:'pub_scope',badge:'gold'},{l:'Nature',k:'nature'},{l:'Amount',k:'amount_requested',cur:true}]},
  reimbursement:{apiUrl:'/ld-requests/records/reimbursement',addFn:()=>{closeRecords();openFormModal('reimbursement','💰 New Reimbursement Request')},
    dk:'activity_date',lk:null,fk:null,
    cols:[{l:'#',k:'_index'},{l:'Tracking #',k:'tracking_number'},{l:'Department',k:'department'},{l:'Activity',k:'activity_types',arr:true},{l:'Venue',k:'venue'},{l:'Date',k:'activity_date'},{l:'Expenses',k:'expense_items',exp:true},{l:'Total',k:'_total',tot:true}]},
  travel:{apiUrl:'/ld-requests/records/travel',addFn:()=>{closeRecords();openFormModal('travel','✈️ New Authority to Travel')},
    dk:'travel_dates',lk:null,fk:null,
    cols:[{l:'#',k:'_index'},{l:'Tracking #',k:'tracking_number'},{l:'Employees',k:'employee_names'},{l:'Positions',k:'positions'},{l:'Dates',k:'travel_dates'},{l:'Time',k:'travel_time'},{l:'Places',k:'places_visited'},{l:'Purpose',k:'purpose'},{l:'Chargeable To',k:'chargeable_against'}]},
};
let _allRec=[],_filtRec=[],_curType='';

function openRecordsModal(type,title){
  _curType=type;_allRec=[];_filtRec=[];
  ['recSearch','recMonth','recYear','recLevel','recFin'].forEach(id=>{const e=document.getElementById(id);if(e)e.value=''});
  document.getElementById('recTitle').textContent=title;
  document.getElementById('recContent').innerHTML='<div style="padding:48px;text-align:center;color:var(--ink-4)">⏳ Loading…</div>';
  const cfg=recCfg[type];
  document.getElementById('recLevel').style.display=cfg.lk?'':'none';
  document.getElementById('recFin').style.display=cfg.fk?'':'none';
  openModal('recordsModal');
  fetch(cfg.apiUrl,{headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}})
    .then(r=>r.json())
    .then(data=>{_allRec=data.records||data||[];_filtRec=[..._allRec];_fillYears();renderRec(_allRec);const n=_allRec.length;document.getElementById('recCount').textContent=`${n} record${n!==1?'s':''}`;document.getElementById('recFooter').textContent=`All ${n} record${n!==1?'s':''}`})
    .catch(()=>{document.getElementById('recContent').innerHTML='<div style="padding:48px;text-align:center;color:var(--ink-4)">⚠️ Could not load records.</div>'})
}
function closeRecords(){closeModal('recordsModal');_allRec=[];_filtRec=[];_curType=''}
function recAddNew(){recCfg[_curType]?.addFn?.()}
document.getElementById('recordsModal')?.addEventListener('click',e=>{if(e.target.id==='recordsModal')closeRecords()});

function _fillYears(){
  const cfg=recCfg[_curType];if(!cfg)return;
  const years=new Set();_allRec.forEach(r=>{const raw=String(r[cfg.dk]||r.created_at||'');const m=raw.match(/\d{4}/);if(m)years.add(m[0])});
  const sel=document.getElementById('recYear');sel.innerHTML='<option value="">All Years</option>';
  [...years].sort((a,b)=>b-a).forEach(y=>{sel.innerHTML+=`<option value="${y}">${y}</option>`});
}
function applyRecFilters(){
  const cfg=recCfg[_curType];if(!cfg)return;
  const q=(document.getElementById('recSearch')?.value||'').toLowerCase();
  const mon=document.getElementById('recMonth')?.value||'';
  const yr=document.getElementById('recYear')?.value||'';
  const lvl=document.getElementById('recLevel')?.value||'';
  const fin=document.getElementById('recFin')?.value;
  const f=_allRec.filter(r=>{
    if(q){const hit=Object.values(r).some(v=>Array.isArray(v)?v.some(x=>String(x).toLowerCase().includes(q)):String(v??'').toLowerCase().includes(q));if(!hit)return false}
    if(mon){const raw=String(r[cfg.dk]||r.created_at||'');const d=new Date(raw);if(isNaN(d)||(d.getMonth()+1)!==parseInt(mon))return false}
    if(yr){const raw=String(r[cfg.dk]||r.created_at||'');const m=raw.match(/\d{4}/);if(!m||m[0]!==yr)return false}
    if(lvl&&cfg.lk){if(String(r[cfg.lk]||'').toLowerCase()!==lvl.toLowerCase())return false}
    if(fin!==''&&fin!==undefined&&cfg.fk){if(Boolean(r[cfg.fk])!==(fin==='1'))return false}
    return true;
  });
  _filtRec=f;renderRec(f);
  const n=f.length,t=_allRec.length;
  document.getElementById('recCount').textContent=n===t?`${n} record${n!==1?'s':''}`:(`${n} of ${t}`);
  document.getElementById('recFooter').textContent=n===t?`All ${n} records`:`Showing ${n} of ${t}`;
}
function clearRecFilters(){['recSearch','recMonth','recYear','recLevel','recFin'].forEach(id=>{const e=document.getElementById(id);if(e)e.value=''});applyRecFilters()}

function esc(s){return String(s??'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;')}
function renderRec(rows){
  const cfg=recCfg[_curType];if(!cfg)return;
  const el=document.getElementById('recContent');
  if(!rows?.length){el.innerHTML='<div style="padding:48px;text-align:center;color:var(--ink-4)">📭 No records found.</div>';return}
  let h='<table class="idx-rec-table"><thead><tr>';
  cfg.cols.forEach(c=>{h+=`<th>${esc(c.l)}</th>`});h+='</tr></thead><tbody>';
  rows.forEach((row,idx)=>{
    h+='<tr>';
    cfg.cols.forEach(c=>{
      h+=`<td>`;
      if(c.k==='_index'){
        h+=`<span style="color:var(--ink-5)">${idx+1}</span>`;
      } else if(c.tot){
        const t=(row.expense_items||[]).reduce((s,x)=>s+parseFloat(x.amount||0),0);
        h+=t>0?`<strong>₱${t.toLocaleString('en-PH',{minimumFractionDigits:2})}</strong>`:'<span style="color:var(--ink-5)">—</span>';
      } else if(c.exp){
        const items=row[c.k]||[];
        if(items.length){
          const tip=esc(items.map(i=>`${i.description||''} × ${i.quantity||''} = ₱${i.amount||''}`).join('\n'));
          h+=`<span class="rec-tip" data-tip="${tip}">${items.length} item${items.length!==1?'s':''}</span>`;
        } else { h+='<span style="color:var(--ink-5)">—</span>'; }
      } else if(c.arr){
        const a=Array.isArray(row[c.k])?row[c.k]:[];
        if(a.length){
          const tip=esc(a.join(', '));
          h+=`<span class="rec-tip" data-tip="${tip}">${a.map(t=>`<span class="badge badge-crimson" style="font-size:.6rem">${esc(t)}</span>`).join(' ')}</span>`;
        } else { h+='<span style="color:var(--ink-5)">—</span>'; }
      } else if(c.badge){
        const v=row[c.k];
        h+=v?`<span class="badge badge-${c.badge}" style="font-size:.62rem">${esc(v)}</span>`:'<span style="color:var(--ink-5)">—</span>';
      } else if(c.bool){
        h+=row[c.k]?'<span class="badge badge-green" style="font-size:.6rem">Yes</span>':'<span style="color:var(--ink-5);font-size:.76rem">No</span>';
      } else if(c.cur){
        const n=parseFloat(row[c.k]||0);
        h+=n>0?`<span style="font-weight:600">₱${n.toLocaleString('en-PH',{minimumFractionDigits:2})}</span>`:'<span style="color:var(--ink-5)">—</span>';
      } else {
        const v=String(row[c.k]??'');
        if(v!==''){
          const tip=esc(v);
          h+=`<span class="rec-tip" data-tip="${tip}">${esc(v)}</span>`;
        } else { h+='<span style="color:var(--ink-5)">—</span>'; }
      }
      h+='</td>';
    });
    h+='</tr>';
  });
  h+='</tbody></table>';el.innerHTML=h;
}


/* ── RECORDS TOOLTIP ── */
(function(){
  const tt=document.createElement('div');
  tt.id='recTooltip';
  document.body.appendChild(tt);

  function show(el,e){
    const tip=el.dataset.tip;
    if(!tip)return;
    tt.textContent=tip;
    tt.style.opacity='1';
    position(e);
  }
  function position(e){
    const pad=10, w=tt.offsetWidth, h=tt.offsetHeight;
    let x=e.clientX+14, y=e.clientY-h-10;
    if(x+w>window.innerWidth-pad) x=e.clientX-w-14;
    if(y<pad) y=e.clientY+20;
    tt.style.left=x+'px';
    tt.style.top=y+'px';
  }
  function hide(){tt.style.opacity='0';}

  document.getElementById('recContent').addEventListener('mouseover',e=>{
    const el=e.target.closest('.rec-tip');
    if(el) show(el,e);
  });
  document.getElementById('recContent').addEventListener('mousemove',e=>{
    if(tt.style.opacity==='1') position(e);
  });
  document.getElementById('recContent').addEventListener('mouseout',e=>{
    if(!e.target.closest('.rec-tip')) return;
    if(!e.relatedTarget?.closest('.rec-tip')) hide();
  });
  document.getElementById('recordsModal').addEventListener('mouseleave',hide);
})();

/* ── CSV Download ── */
function toggleDlMenu(){document.getElementById('dlMenu')?.classList.toggle('open')}
document.addEventListener('click',e=>{if(!document.getElementById('dlWrap')?.contains(e.target))document.getElementById('dlMenu')?.classList.remove('open')});
function csvEsc(v){const s=String(v??'').replace(/"/g,'""');return/[,"\n\r]/.test(s)?`"${s}"`:s}
function downloadCSV(mode){
  document.getElementById('dlMenu')?.classList.remove('open');
  const cfg=recCfg[_curType];if(!cfg)return;
  const rows=mode==='all'?_allRec:(_filtRec.length?_filtRec:_allRec);
  const cols=cfg.cols.filter(c=>c.k!=='_index'&&!c.tot);
  const lines=[cols.map(c=>csvEsc(c.l)).join(',')];
  rows.forEach(row=>{lines.push(cols.map(c=>{
    if(c.exp){const items=row[c.k]||[];return csvEsc(items.map(i=>`${i.description||''} x${i.quantity||''} = ${i.amount||''}`).join(' | '))}
    if(c.arr)return csvEsc((Array.isArray(row[c.k])?row[c.k]:[]).join(', '));
    if(c.bool)return row[c.k]?'Yes':'No';
    if(c.cur){const n=parseFloat(row[c.k]||0);return n>0?n.toFixed(2):''}
    return csvEsc(String(row[c.k]??''));
  }).join(','))});
  const blob=new Blob([lines.join('\n')],{type:'text/csv;charset=utf-8;'});
  const a=Object.assign(document.createElement('a'),{href:URL.createObjectURL(blob),download:`${_curType}-${mode}-${new Date().toISOString().slice(0,10)}.csv`});
  a.click();URL.revokeObjectURL(a.href);
}

/* ── MOV MODAL ── */
let _movUrl=null,_movName=null;
function openMovModal(upUrl,fileUrl,fileName,recordId){
  document.getElementById('movForm').action=upUrl;
  document.getElementById('movRecordId').value=recordId;
  const ex=document.getElementById('movExisting'),nm=document.getElementById('movName'),pb=document.getElementById('movPreviewBtn');
  if(fileUrl){ex.style.display='block';nm.textContent=fileName||'';_movUrl=fileUrl;_movName=fileName||'';pb.onclick=()=>openMovPreview(_movUrl,_movName)}else{ex.style.display='none';_movUrl=null;_movName=null;pb.onclick=null}
  openModal('movModal');
}
function openMovPreview(url,fileName){
  const frame=document.getElementById('movPreviewFrame'),
        imgCon=document.getElementById('movImgCon'),
        img=document.getElementById('movPreviewImg'),
        unsupp=document.getElementById('movUnsupported'),
        docxCon=document.getElementById('movDocxCon'),
        docxContent=document.getElementById('movDocxContent'),
        docxLoading=document.getElementById('movDocxLoading'),
        dlBtn=document.getElementById('movDlBtn'),
        titleEl=document.getElementById('movPreviewTitle');

  [frame,imgCon,unsupp,docxCon].forEach(e=>{e.style.display='none'});
  frame.src='';img.src='';docxContent.innerHTML='';

  const name=fileName||url.split('/').pop()||'file';
  const ext=name.split('.').pop().toLowerCase();
  titleEl.textContent='📎 '+name;
  dlBtn.href=url;

  if(['jpg','jpeg','png','gif','webp','bmp'].includes(ext)){
    imgCon.style.display='flex';img.src=url;
  } else if(ext==='pdf'){
    frame.style.display='block';frame.src=url;
  } else if(ext==='docx'){
    docxCon.style.display='flex';
    docxLoading.style.display='block';
    docxContent.innerHTML='';
    fetch(url)
      .then(r=>r.arrayBuffer())
      .then(buffer=>{
        if(typeof mammoth==='undefined'){
          docxLoading.style.display='none';
          docxContent.innerHTML='<p style="color:#c00;">mammoth.js not loaded. Please download the file instead.</p>';
          return;
        }
        return mammoth.convertToHtml({arrayBuffer:buffer});
      })
      .then(result=>{
        if(!result) return;
        docxLoading.style.display='none';
        docxContent.innerHTML=result.value||'<p style="color:#888;">No content found.</p>';
      })
      .catch(()=>{
        docxLoading.style.display='none';
        docxContent.innerHTML='<p style="color:#c00;">Failed to load document. Please download the file instead.</p>';
      });
  } else if(['doc','xls','xlsx','ppt','pptx'].includes(ext)){
    frame.style.display='block';
    frame.src=`https://docs.google.com/gview?url=${encodeURIComponent(location.origin+url)}&embedded=true`;
  } else {
    unsupp.style.display='flex';
    document.getElementById('movUnsuppName').textContent=name;
    document.getElementById('movUnsuppDl').href=url;
  }
  openModal('movPreviewModal');
}
function closeMovPreview(){
  closeModal('movPreviewModal');
  const f=document.getElementById('movPreviewFrame');if(f){f.src='';f.style.display='none';}
  const i=document.getElementById('movImgCon');if(i)i.style.display='none';
  const u=document.getElementById('movUnsupported');if(u)u.style.display='none';
  const d=document.getElementById('movDocxCon');if(d)d.style.display='none';
}
document.getElementById('movPreviewModal')?.addEventListener('click',e=>{if(e.target.id==='movPreviewModal')closeMovPreview()});

/* ── SIGNATORY HELPERS (used by dynamically loaded form HTML) ── */
function resetSignatory(btn){btn.closest('.sig-box')?.querySelectorAll('[data-default]').forEach(i=>{i.value=i.dataset.default})}
function attToggleOthers(chk,txtId){const t=document.getElementById(txtId);if(!t)return;t.disabled=!chk.checked;if(!chk.checked)t.value=''}
function toggleOthersInput(chk,txtId){attToggleOthers(chk,txtId)}

/* ── KEYBOARD ── */
document.addEventListener('keydown',e=>{
  if(e.key!=='Escape')return;
  ['viewModal','editModal','gFormModal','gViewModal','createModal','movModal'].forEach(id=>closeModal(id));
  closePrintModal();closeMovPreview();closeRecords();
});

/* ── INIT ── */
document.addEventListener('DOMContentLoaded',()=>{
  const tab=new URLSearchParams(location.search).get('tab')||'participation';
  idxTab(tab);
  initFP(document);
  // Re-open MOV on validation failure
  const failedMov=@json(old('mov_record_id'));
  if(failedMov){document.querySelector(`[data-mov="${failedMov}"]`)?.click()}
  // Re-open participation create on error
  const hasErr={{ $errors->any() ? 'true' : 'false' }};
  if(hasErr){const old=@json(old());const isParticipationErr=old?.participant_name||old?.title;if(isParticipationErr){idxTab('participation');openCreateModal()}}
  // Toast auto-dismiss
  const toast=document.getElementById('idx-toast');
  if(toast){setTimeout(()=>{toast.style.transition='all .3s';toast.style.opacity='0';toast.style.transform='translateY(-8px)';setTimeout(()=>toast.remove(),350)},2800)}
});
</script>