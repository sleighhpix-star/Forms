{{-- resources/views/ld/partials/_styles.blade.php
     Index-page specific styles. Design tokens come from layouts/app.blade.php. --}}
<style>
/* ── Page wrapper ── */
/* ── One-page layout: no body scroll on index ── */
body.idx-page { overflow:hidden; height:100vh; }
.idx {
  max-width:1360px; margin:0 auto;
  padding:1.25rem 1.75rem 0;
  height:calc(100vh - 60px);
  display:flex; flex-direction:column;
  overflow:hidden;
}

/* ── Page heading strip ── */
.idx-heading {
  display:flex; align-items:flex-end; justify-content:space-between;
  flex-wrap:wrap; gap:1rem;
  margin-bottom:1rem;
  flex-shrink:0;
}
.idx-heading h1 {
  font-family:var(--f-display); font-size:1.65rem;
  color:var(--ink); font-weight:400; line-height:1;
}
.idx-heading h1 span { color:var(--c); }

/* ── Tabs ── */
.idx-tabs {
  display:flex; gap:2px; overflow-x:auto; flex-wrap:nowrap;
  padding:5px; background:var(--surface);
  border:1px solid var(--border); border-bottom:none;
  border-radius:var(--r-lg) var(--r-lg) 0 0;
  flex-shrink:0;
}
.idx-tab {
  flex-shrink:0; display:flex; align-items:center; gap:6px;
  padding:8px 18px; border:none; border-radius:var(--r-md);
  background:transparent; color:var(--ink-4);
  font-family:var(--f-body); font-size:.78rem; font-weight:600;
  cursor:pointer; white-space:nowrap; letter-spacing:.01em;
  transition:background .14s, color .14s;
}
.idx-tab:hover  { background:var(--bg); color:var(--c); }
.idx-tab.active { background:var(--c); color:white; box-shadow:0 1px 6px rgba(124,21,51,.25); }
.idx-tab-n {
  background:rgba(0,0,0,.09); color:inherit;
  border-radius:20px; padding:1px 7px; font-size:.62rem; font-weight:700;
}
.idx-tab.active .idx-tab-n { background:rgba(255,255,255,.2); }

/* ── Panel wrapper ── */
.idx-panel { display:none; flex:1; min-height:0; flex-direction:column; }
.idx-panel.active { display:flex; }
.idx-panel-body {
  background:var(--surface);
  border:1px solid var(--border); border-top:none;
  border-radius:0 0 var(--r-lg) var(--r-lg);
  flex:1; min-height:0;
  display:flex; flex-direction:column;
  overflow:hidden;
}

/* ── Stats row ── */
.idx-stats {
  display:grid; grid-template-columns:repeat(auto-fit, minmax(148px,1fr));
  border-bottom:1px solid var(--border-sm);
  flex-shrink:0;
}
.idx-stat {
  padding:18px 22px; position:relative;
  border-right:1px solid var(--border-sm);
}
.idx-stat:last-child { border-right:none; }
.idx-stat-label {
  font-size:.59rem; font-weight:600; letter-spacing:.1em;
  text-transform:uppercase; color:var(--ink-5); margin-bottom:6px;
}
.idx-stat-num {
  font-family:var(--f-display); font-size:1.75rem;
  color:var(--c); line-height:1; font-weight:400;
}
.idx-stat-sub { font-size:.65rem; color:var(--ink-4); margin-top:4px; }
.idx-mini-bars { margin-top:8px; display:flex; flex-direction:column; gap:5px; }
.idx-mini-row  { display:flex; align-items:center; gap:6px; font-size:.63rem; }
.idx-mini-lbl  { color:var(--ink-3); min-width:70px; }
.idx-mini-track{ flex:1; height:3px; background:var(--border-sm); border-radius:3px; overflow:hidden; }
.idx-mini-fill { height:100%; background:var(--c); border-radius:3px; opacity:.6; }
.idx-mini-val  { color:var(--c); font-weight:600; min-width:14px; text-align:right; }

/* ── Toolbar ── */
.idx-toolbar {
  display:flex; align-items:center; justify-content:space-between;
  flex-wrap:wrap; gap:8px;
  padding:12px 20px;
  background:var(--bg); border-bottom:1px solid var(--border-sm);
  flex-shrink:0;
}
.idx-toolbar-l { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.idx-toolbar-r { display:flex; align-items:center; gap:8px; }
.idx-toolbar input[type=text] {
  padding:7px 12px; width:220px;
  border:1.5px solid var(--border); border-radius:var(--r-md);
  font-family:var(--f-body); font-size:.8rem; background:white;
  color:var(--ink); outline:none; transition:border-color .15s, box-shadow .15s;
}
.idx-toolbar input[type=text]:focus {
  border-color:var(--c); box-shadow:0 0 0 3px var(--c-ring);
}
.idx-toolbar input[type=text]::placeholder { color:var(--ink-5); }

/* ── Table ── */
.idx-table-wrap { overflow:auto; flex:1; min-height:0; }
.idx-table-wrap::-webkit-scrollbar { width:5px; height:5px; }
.idx-table-wrap::-webkit-scrollbar-thumb { background:var(--border); border-radius:3px; }
.idx-table thead th { position:sticky; top:0; z-index:2; background:#F8F4EE; }
.idx-table { width:100%; border-collapse:collapse; }
.idx-table thead tr { background:#F8F4EE; }
.idx-table thead th {
  padding:9px 14px; text-align:left; white-space:nowrap;
  font-size:.6rem; font-weight:600; letter-spacing:.08em;
  text-transform:uppercase; color:var(--ink-4);
  border-bottom:2px solid var(--border);
}
.idx-table thead th:first-child { padding-left:20px; }
.idx-table thead th:last-child  { padding-right:20px; }
.idx-table tbody tr { border-bottom:1px solid var(--border-sm); transition:background .1s; }
.idx-table tbody tr:last-child { border-bottom:none; }
.idx-table tbody tr:hover { background:#FDFAF4; }
.idx-table tbody td { padding:10px 14px; font-size:.84rem; vertical-align:middle; color:var(--ink-2); }
.idx-table tbody td:first-child { padding-left:20px; }
.idx-table tbody td:last-child  { padding-right:20px; }
.idx-muted  { color:var(--ink-4) !important; font-size:.78rem !important; }
.idx-nowrap { white-space:nowrap; width:1%; }
.idx-trunc  { max-width:200px; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

/* Action buttons */
.idx-act { display:flex; gap:3px; align-items:center; white-space:nowrap; }
.idx-act .btn { padding:5px 9px; font-size:.72rem; border-radius:var(--r-sm); }
.idx-act .btn:hover { transform:translateY(-1px); }

/* ── Quick-add ── */
.idx-qa { display:none; border-top:2px dashed var(--border); }
.idx-qa.open { display:block; }
.idx-qa-body {
  display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr));
  gap:10px; padding:16px 20px; background:#FDFAF5;
}
.idx-qa-field label {
  display:block; font-size:.63rem; font-weight:600; letter-spacing:.07em;
  text-transform:uppercase; color:var(--ink-3); margin-bottom:4px;
}
.idx-qa-field input,
.idx-qa-field select,
.idx-qa-field textarea {
  width:100%; padding:6px 10px;
  border:1.5px solid var(--border); border-radius:var(--r-sm);
  font-family:var(--f-body); font-size:.8rem; color:var(--ink);
  background:white; outline:none; transition:border-color .15s, box-shadow .15s;
}
.idx-qa-field input:focus,
.idx-qa-field select:focus,
.idx-qa-field textarea:focus { border-color:var(--c); box-shadow:0 0 0 3px var(--c-ring); }
.idx-qa-field textarea { resize:vertical; min-height:40px; }
.idx-qa-footer {
  display:flex; gap:8px; padding:10px 20px 16px;
  background:var(--bg); border-top:1px solid var(--border-sm);
}

/* ── Empty state ── */
.idx-empty { text-align:center; padding:60px 24px; color:var(--ink-4); }
.idx-empty-icon { font-size:2.5rem; opacity:.18; display:block; margin-bottom:10px; }
.idx-empty p { font-size:.9rem; margin-bottom:14px; }

/* ── Pagination ── */
.idx-pagination { padding:12px 20px; background:var(--bg); border-top:1px solid var(--border-sm); flex-shrink:0; }

/* ═══════════════════════════════════════
   MODALS
═══════════════════════════════════════ */
.idx-overlay {
  display:none; position:fixed; inset:0;
  background:rgba(18,12,10,.5); backdrop-filter:blur(4px);
  z-index:9999; align-items:center; justify-content:center;
  overflow:hidden; padding:16px;
}
.idx-overlay.active { display:flex; }
.idx-modal {
  background:var(--surface); border-radius:var(--r-2xl);
  width:100%; max-width:900px; margin:auto;
  max-height:90vh; display:flex; flex-direction:column;
  box-shadow:0 4px 24px rgba(0,0,0,.1), 0 20px 60px rgba(0,0,0,.08);
  border:1px solid var(--border);
  animation:idxModalIn .2s cubic-bezier(.34,1.1,.64,1);
  overflow:hidden;
}
.idx-modal-sm  { max-width:520px; }
.idx-modal-lg  { max-width:96vw; }
@keyframes idxModalIn {
  from { opacity:0; transform:translateY(-16px) scale(.97); }
  to   { opacity:1; transform:none; }
}
.idx-modal-head {
  background:var(--c-dk);
  padding:14px 22px; border-radius:var(--r-2xl) var(--r-2xl) 0 0;
  display:flex; align-items:center; justify-content:space-between;
  position:relative;
}
.idx-modal-head::after {
  content:''; position:absolute; bottom:0; left:0; right:0; height:2px;
  background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);
  opacity:.6;
}
.idx-modal-title { color:white; font-size:.88rem; font-weight:600; }
.idx-modal-close {
  background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.18);
  color:white; border-radius:var(--r-sm); padding:4px 10px;
  cursor:pointer; font-size:.76rem; font-weight:600; transition:background .14s;
}
.idx-modal-close:hover { background:rgba(255,255,255,.22); }
.idx-modal-body { min-height:160px; overflow-y:auto; flex:1; }
.idx-modal-loading { display:flex; align-items:center; justify-content:center; min-height:160px; }

/* Iframe modal */
.idx-iframe-wrap {
  background:var(--surface); border-radius:var(--r-2xl);
  width:92vw; max-width:860px; height:90vh;
  display:flex; flex-direction:column; overflow:hidden;
  box-shadow:0 4px 24px rgba(0,0,0,.1),0 20px 60px rgba(0,0,0,.08);
  border:1px solid var(--border);
  animation:idxModalIn .2s cubic-bezier(.34,1.1,.64,1);
}
.idx-iframe-wrap iframe { flex:1; border:none; width:100%; background:#f5f5f5; }

/* Records popup */
.idx-records-wrap {
  background:var(--surface); border-radius:var(--r-2xl);
  width:100%; max-width:96vw; margin:auto; overflow:hidden;
  box-shadow:0 4px 24px rgba(0,0,0,.1),0 20px 60px rgba(0,0,0,.08);
  border:1px solid var(--border);
  animation:idxModalIn .2s cubic-bezier(.34,1.1,.64,1);
}
.idx-rec-filters {
  padding:11px 18px; background:var(--bg); border-bottom:1px solid var(--border-sm);
  display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;
}
.idx-rec-filters input, .idx-rec-filters select {
  padding:6px 11px; border:1.5px solid var(--border); border-radius:var(--r-md);
  font-family:var(--f-body); font-size:.79rem; background:white; color:var(--ink-2);
  outline:none; transition:border-color .15s;
}
.idx-rec-filters input { width:200px; }
.idx-rec-filters input:focus, .idx-rec-filters select:focus { border-color:var(--c); box-shadow:0 0 0 3px var(--c-ring); }
.idx-rec-body { max-height:calc(90vh - 200px); overflow-y:auto; overflow-x:hidden; }
.idx-rec-scroll { overflow-x:auto; overflow-y:visible; }
.idx-rec-scroll::-webkit-scrollbar { height:5px; }
.idx-rec-scroll::-webkit-scrollbar-thumb { background:var(--border); border-radius:3px; }
.idx-rec-footer {
  padding:10px 18px; background:var(--bg); border-top:1px solid var(--border-sm);
  display:flex; align-items:center; justify-content:space-between;
  font-size:.77rem; color:var(--ink-4);
}
.idx-rec-table { width:100%; border-collapse:collapse; font-size:.78rem; }
.idx-rec-table thead th {
  padding:8px 12px; background:var(--c-dk); color:rgba(255,255,255,.82);
  font-size:.61rem; font-weight:600; letter-spacing:.08em; text-transform:uppercase;
  text-align:left; white-space:nowrap; position:sticky; top:0; z-index:1;
  border-right:1px solid rgba(255,255,255,.06);
}
.idx-rec-table tbody tr { border-bottom:1px solid var(--border-sm); }
.idx-rec-table tbody tr:nth-child(even) { background:var(--bg); }
.idx-rec-table tbody tr:hover { background:#fdfaf4; }
.idx-rec-table tbody td { padding:7px 12px; vertical-align:top; border-right:1px solid var(--border-sm); max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

.idx-rec-table tbody td[title] { cursor:help; }

/* ── RECORDS TOOLTIP ── */
.rec-tip {
  cursor:help;
  display:inline-block; max-width:200px;
  overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
  vertical-align:middle;
}
#recTooltip {
  position:fixed;
  background:#1C1410; color:#fff;
  font-size:.72rem; font-family:var(--f-body); font-weight:400; line-height:1.5;
  padding:6px 10px; border-radius:var(--r-sm);
  white-space:pre-wrap; word-break:break-word;
  max-width:280px; min-width:60px;
  box-shadow:0 4px 16px rgba(0,0,0,.25);
  pointer-events:none;
  opacity:0; transition:opacity .12s ease;
  z-index:999999;
  text-align:left;
}

/* Download dropdown */
.idx-dl-wrap { position:relative; display:inline-block; }
.idx-dl-menu {
  display:none; position:absolute; right:0; top:calc(100% + 4px);
  background:white; border:1px solid var(--border); border-radius:var(--r-md);
  box-shadow:0 8px 24px rgba(0,0,0,.1); min-width:200px; z-index:9999; overflow:hidden;
}
.idx-dl-menu.open { display:block; }
.idx-dl-hd { padding:6px 12px; font-size:.63rem; font-weight:600; letter-spacing:.08em; text-transform:uppercase; color:var(--ink-5); background:var(--bg); border-bottom:1px solid var(--border-sm); }
.idx-dl-btn { display:block; width:100%; padding:9px 14px; background:none; border:none; text-align:left; font-size:.8rem; color:var(--ink); cursor:pointer; border-top:1px solid var(--border-sm); transition:background .1s; }
.idx-dl-btn:first-of-type { border-top:none; }
.idx-dl-btn:hover { background:var(--bg); }

/* MOV preview */
.idx-mov-wrap {
  background:var(--surface); border-radius:var(--r-2xl);
  width:95vw; max-width:1100px; height:92vh;
  display:flex; flex-direction:column; overflow:hidden;
  box-shadow:0 4px 24px rgba(0,0,0,.1),0 20px 60px rgba(0,0,0,.08);
  border:1px solid var(--border);
  animation:idxModalIn .2s cubic-bezier(.34,1.1,.64,1);
}
.idx-mov-wrap iframe, .idx-mov-wrap img { flex:1; border:none; width:100%; background:#f5f5f5; object-fit:contain; }
</style>