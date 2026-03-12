{{-- resources/views/ld/index.blade.php --}}
@extends('ld.layouts.app')

@section('title', 'Request Records — BatStateU')

@push('styles')
<style>
/* ═══════════════════════════════════════════════════════════
   INDEX PAGE — REDESIGNED STYLES
   All class names identical to original. Visual upgrade only.
═══════════════════════════════════════════════════════════ */

/* ── Modal overlay ── */
.modal-overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(15, 10, 9, .55);
  backdrop-filter: blur(6px);
  z-index: 9999;
  align-items: flex-start; justify-content: center;
  overflow-y: auto; padding: 2rem 1rem;
}
.modal-overlay.active { display: flex; }
.modal-box {
  background: var(--surface);
  border-radius: 18px;
  width: 100%; max-width: 900px;
  box-shadow: 0 24px 80px rgba(92,14,36,.18), 0 4px 16px rgba(0,0,0,.08);
  margin: auto;
  border: 1px solid rgba(124,21,51,.1);
  animation: modalIn .22s cubic-bezier(.34,1.2,.64,1);
}
@keyframes modalIn {
  from { opacity: 0; transform: translateY(-20px) scale(.97); }
  to   { opacity: 1; transform: translateY(0) scale(1); }
}
.modal-header {
  background: linear-gradient(135deg, var(--crimson-deep) 0%, var(--crimson) 100%);
  padding: .85rem 1.5rem;
  display: flex; align-items: center; justify-content: space-between;
  border-radius: 18px 18px 0 0;
  position: relative;
}
.modal-header::after {
  content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1.5px;
  background: linear-gradient(90deg, transparent 0%, var(--gold-light) 40%, var(--gold) 50%, var(--gold-light) 60%, transparent 100%);
  opacity: .6;
}
.modal-header span { color: #fff; font-size: .9rem; font-weight: 700; letter-spacing: .01em; }
.modal-close {
  background: rgba(255,255,255,.13); border: 1px solid rgba(255,255,255,.18);
  color: #fff; border-radius: 8px; padding: .28rem .75rem;
  cursor: pointer; font-size: .8rem; font-weight: 700;
  transition: background .15s;
}
.modal-close:hover { background: rgba(255,255,255,.26); }
.modal-body { min-height: 200px; display: flex; align-items: center; justify-content: center; }

/* ── Print modal ── */
.print-modal-overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(15,10,9,.6); backdrop-filter: blur(6px);
  z-index: 10000; align-items: center; justify-content: center;
}
.print-modal-overlay.active { display: flex; }
.print-modal {
  background: var(--surface); border-radius: 18px;
  width: 92vw; max-width: 820px; height: 90vh;
  display: flex; flex-direction: column; overflow: hidden;
  box-shadow: 0 24px 80px rgba(92,14,36,.18);
  border: 1px solid rgba(124,21,51,.1);
  animation: modalIn .22s cubic-bezier(.34,1.2,.64,1);
}
.print-modal-header {
  background: linear-gradient(135deg, var(--crimson-deep), var(--crimson));
  padding: .85rem 1.5rem;
  display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;
  position: relative;
}
.print-modal-header::after {
  content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1.5px;
  background: linear-gradient(90deg, transparent, var(--gold-light), var(--gold), var(--gold-light), transparent);
  opacity: .6;
}
.print-modal-header span { color: #fff; font-size: .9rem; font-weight: 700; }
.print-modal-close {
  background: rgba(255,255,255,.13); border: 1px solid rgba(255,255,255,.18);
  color: #fff; border-radius: 8px; padding: .28rem .75rem;
  cursor: pointer; font-size: .8rem; font-weight: 700; transition: background .15s;
}
.print-modal-close:hover { background: rgba(255,255,255,.26); }
.print-modal iframe { flex: 1; border: none; width: 100%; background: #f5f5f5; }

/* ════════════════════════════════════════
   TABS
════════════════════════════════════════ */
.form-tabs {
  display: flex; overflow-x: auto; flex-wrap: nowrap; gap: .25rem;
  padding: .6rem .75rem;
  background: var(--surface);
  border-radius: 16px 16px 0 0;
  border: 1px solid rgba(124,21,51,.08);
  border-bottom: none;
  box-shadow: 0 -1px 0 rgba(124,21,51,.04);
}
.form-tab {
  padding: .48rem 1.1rem;
  border: none; cursor: pointer;
  font-size: .78rem; font-weight: 600; white-space: nowrap;
  border-radius: 10px;
  display: flex; align-items: center; gap: .4rem;
  transition: all .18s ease;
  background: transparent; color: var(--ink-faint);
  letter-spacing: .015em; font-family: var(--font-body);
}
.form-tab:hover {
  background: var(--ivory-warm);
  color: var(--crimson);
}
.form-tab.active {
  background: linear-gradient(135deg, var(--crimson-mid), var(--crimson-deep));
  color: white;
  box-shadow: 0 2px 10px rgba(124,21,51,.28), inset 0 1px 0 rgba(255,255,255,.08);
}
.tab-badge {
  background: rgba(0,0,0,.1); color: inherit;
  border-radius: 20px; padding: .05rem .48rem;
  font-size: .64rem; font-weight: 800;
}
.form-tab.active .tab-badge { background: rgba(255,255,255,.18); color: #fff; }

.tab-panel { display: none; }
.tab-panel.active { display: block; }
.tab-content {
  background: var(--surface);
  border: 1px solid rgba(124,21,51,.08);
  border-top: none;
  border-radius: 0 0 16px 16px;
  box-shadow: 0 4px 24px rgba(124,21,51,.07), 0 1px 4px rgba(0,0,0,.04);
  overflow: hidden;
}

/* ════════════════════════════════════════
   STATS STRIP
════════════════════════════════════════ */
.stats-strip {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
  gap: .5rem;
  padding: .65rem .9rem;
  background: linear-gradient(to bottom, var(--ivory-warm), var(--ivory));
  border-bottom: 1px solid var(--ivory-deep);
}
.stat-card {
  background: var(--surface);
  border: 1px solid rgba(124,21,51,.07);
  border-radius: 12px;
  padding: .6rem .8rem;
  position: relative; overflow: hidden;
  text-align: center;
  display: flex; flex-direction: column; justify-content: center;
  transition: box-shadow .18s, transform .18s;
  box-shadow: 0 1px 4px rgba(26,18,16,.05);
}
.stat-card:hover {
  box-shadow: 0 4px 14px rgba(124,21,51,.1);
  transform: translateY(-1px);
}
.stat-card.stat-hero { background: var(--surface); }
.stat-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(90deg, var(--gold), var(--gold-light));
  opacity: 0;
  transition: opacity .2s;
}
.stat-card:hover::before { opacity: 1; }
.stat-card-icon {
  position: absolute; right: 6px; top: 4px;
  font-size: 1.75rem; opacity: .05; line-height: 1; pointer-events: none;
}
.stat-label {
  font-size: .55rem; font-weight: 700; letter-spacing: .1em;
  text-transform: uppercase; color: var(--ink-ghost);
  margin-bottom: .18rem;
}
.stat-value {
  font-family: var(--font-display);
  font-size: 1.35rem; font-weight: 700;
  color: var(--crimson); line-height: 1;
}
.stat-sub { font-size: .58rem; color: var(--ink-faint); margin-top: .12rem; }
.stat-bar-wrap { margin-top: .3rem; }
.stat-bar-track { height: 3px; background: var(--ivory-deep); border-radius: 4px; overflow: hidden; }
.stat-bar-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, var(--gold), var(--gold-light)); }
.stat-bar-label { font-size: .56rem; color: var(--ink-faint); margin-top: .15rem; }
.stat-mini-list { display: flex; flex-direction: column; gap: .22rem; margin-top: .05rem; align-items: center; }
.stat-mini-row { display: flex; align-items: center; gap: .3rem; font-size: .63rem; justify-content: center; width: 100%; }
.stat-mini-label { color: var(--ink-soft); }
.stat-mini-bar { width: 38px; height: 3px; background: var(--ivory-deep); border-radius: 3px; overflow: hidden; flex-shrink: 0; }
.stat-mini-bar-fill { height: 100%; background: linear-gradient(90deg, var(--crimson), var(--crimson-soft)); border-radius: 3px; }
.stat-mini-val { color: var(--crimson); font-weight: 700; min-width: 14px; text-align: right; }

/* ════════════════════════════════════════
   ACTION BAR
════════════════════════════════════════ */
.tab-action-bar {
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: .5rem;
  padding: .65rem 1.1rem;
  background: var(--surface);
  border-bottom: 1px solid var(--ivory-deep);
}
.tab-action-bar-left { display: flex; align-items: center; gap: .45rem; flex-wrap: wrap; }
.tab-action-bar-right { display: flex; align-items: center; gap: .45rem; }

/* ════════════════════════════════════════
   FILTER BAR
════════════════════════════════════════ */
.tab-filters {
  padding: .6rem 1.1rem;
  border-bottom: 1px solid var(--ivory-deep);
  display: flex; flex-wrap: wrap; gap: .45rem; align-items: center;
  background: var(--ivory-warm);
}
.tab-filters input[type=text] {
  padding: .42rem .9rem;
  border: 1.5px solid var(--ivory-deep);
  border-radius: 9px;
  font-size: .82rem; width: 230px; outline: none;
  font-family: var(--font-body);
  background: white;
  transition: border-color .18s, box-shadow .18s;
  color: var(--ink);
}
.tab-filters input[type=text]:focus {
  border-color: var(--crimson);
  box-shadow: 0 0 0 3px var(--crimson-glow);
}
.tab-filters input[type=text]::placeholder { color: var(--ink-ghost); }

/* ════════════════════════════════════════
   DATA TABLE
════════════════════════════════════════ */
.table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.table-scroll::-webkit-scrollbar { height: 6px; }
.table-scroll::-webkit-scrollbar-track { background: var(--ivory); }
.table-scroll::-webkit-scrollbar-thumb { background: var(--ink-ghost); border-radius: 6px; }

/* Override global data-table for this page */
.tab-content .data-table { width: 100%; border-collapse: collapse; background: white; }

.tab-content .data-table thead tr {
  background: linear-gradient(to right, #f9f4ef, #f4ede2);
}
.tab-content .data-table thead th {
  padding: .65rem 1rem;
  text-align: left;
  font-size: .62rem; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase;
  color: var(--ink-ghost);
  border-bottom: 2px solid var(--ivory-deep);
  white-space: nowrap;
}
.tab-content .data-table thead th:first-child { padding-left: 1.25rem; }
.tab-content .data-table thead th:last-child  { padding-right: 1.25rem; }

.tab-content .data-table tbody tr {
  border-bottom: 1px solid #f5f0e8;
  transition: background .12s;
}
.tab-content .data-table tbody tr:last-child { border-bottom: none; }
.tab-content .data-table tbody tr:hover { background: #fdf8f2; }

.tab-content .data-table tbody td {
  padding: .7rem 1rem;
  font-size: .84rem;
  vertical-align: middle;
  color: var(--ink-mid);
}
.tab-content .data-table tbody td:first-child { padding-left: 1.25rem; }
.tab-content .data-table tbody td:last-child  { padding-right: 1.25rem; }
.tab-content .data-table tbody td.muted { color: var(--ink-faint); font-size: .8rem; }
.tab-content .data-table tbody td strong { color: var(--ink); font-weight: 600; }

/* ── Action column ── */
.act-col { white-space: nowrap; width: 1%; }
.act-wrap { display: flex; gap: .25rem; flex-wrap: nowrap; align-items: center; }

/* Icon-style action buttons */
.act-wrap .btn { 
  padding: .3rem .65rem;
  font-size: .74rem;
  border-radius: 8px;
  font-weight: 600;
  letter-spacing: .01em;
  transition: all .15s;
}
.act-wrap .btn:hover { transform: translateY(-1px); }

/* ── Compact badge ── */
.badge-xs { padding: .1rem .45rem; font-size: .62rem; letter-spacing: .03em; }
.type-col, .level-col { width: 1%; white-space: nowrap; }

/* ════════════════════════════════════════
   EMPTY STATE
════════════════════════════════════════ */
.empty-state {
  text-align: center; padding: 4rem 2rem;
  background: white; color: var(--ink-faint);
}
.empty-state .empty-icon {
  font-size: 2.5rem; opacity: .2; margin-bottom: 1rem; display: block;
}
.empty-state p { font-size: .9rem; margin-bottom: .5rem; }

/* ════════════════════════════════════════
   QUICK-ADD INLINE ROWS
════════════════════════════════════════ */
.db-bar {
  display: flex; align-items: center; justify-content: space-between;
  padding: .5rem 1.1rem;
  background: var(--ivory-warm);
  border-top: 1px solid var(--ivory-deep);
}
.db-bar-label {
  font-size: .68rem; font-weight: 700; color: var(--ink-ghost);
  text-transform: uppercase; letter-spacing: .4pt;
}
.btn-db {
  display: flex; align-items: center; gap: .3rem;
  background: white;
  border: 1.5px solid var(--ivory-deep);
  color: var(--ink-soft);
  border-radius: 8px; padding: .28rem .7rem;
  cursor: pointer; font-size: .76rem; font-weight: 600;
  transition: all .15s; font-family: var(--font-body);
}
.btn-db:hover { border-color: var(--crimson); color: var(--crimson); background: rgba(124,21,51,.03); }

.qa-grid { display: none; border-top: 2px dashed var(--ivory-deep); background: #fdfaf5; }
.qa-grid.open { display: block; }
.qa-grid-inner { display: grid; gap: .5rem; padding: .9rem 1.1rem; align-items: end; }
.qa-field label {
  display: block; font-size: .68rem; font-weight: 700; color: var(--ink-soft);
  margin-bottom: .2rem; text-transform: uppercase; letter-spacing: .3pt;
  font-family: var(--font-body);
}
.qa-field input, .qa-field select, .qa-field textarea {
  width: 100%; padding: .38rem .65rem;
  border: 1.5px solid var(--ivory-deep);
  border-radius: 8px; font-size: .8rem; outline: none;
  font-family: var(--font-body); background: white;
  transition: border-color .15s, box-shadow .15s;
  color: var(--ink);
}
.qa-field input:focus, .qa-field select:focus, .qa-field textarea:focus {
  border-color: var(--crimson);
  box-shadow: 0 0 0 3px var(--crimson-glow);
}
.qa-field textarea { resize: vertical; min-height: 2.4rem; }
.qa-actions {
  display: flex; gap: .5rem;
  padding: .55rem 1.1rem .8rem;
  border-top: 1px solid var(--ivory-deep);
  background: var(--ivory-warm);
  border-radius: 0 0 16px 16px;
}
.btn-qa-save {
  background: linear-gradient(135deg, var(--crimson-mid), var(--crimson));
  color: #fff; border: none;
  border-radius: 8px; padding: .36rem .9rem;
  font-size: .8rem; font-weight: 700; cursor: pointer;
  font-family: var(--font-body);
  transition: opacity .15s;
}
.btn-qa-save:hover { opacity: .88; }
.btn-qa-cancel {
  background: none; color: var(--ink-soft);
  border: 1.5px solid var(--ivory-deep);
  border-radius: 8px; padding: .36rem .9rem;
  font-size: .8rem; font-weight: 600; cursor: pointer;
  font-family: var(--font-body); transition: all .15s;
}
.btn-qa-cancel:hover { background: var(--ivory-deep); }

/* ════════════════════════════════════════
   RECORDS POPUP MODAL
════════════════════════════════════════ */
.records-modal-overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(15,10,9,.55); backdrop-filter: blur(6px);
  z-index: 10500; align-items: flex-start; justify-content: center;
  overflow-y: auto; padding: 2rem 1rem;
}
.records-modal-overlay.active { display: flex; }
.records-modal-box {
  background: var(--surface); border-radius: 18px;
  width: 100%; max-width: 94vw;
  box-shadow: 0 24px 80px rgba(92,14,36,.18), 0 4px 16px rgba(0,0,0,.08);
  margin: auto; overflow: hidden;
  border: 1px solid rgba(124,21,51,.1);
  animation: modalIn .22s cubic-bezier(.34,1.2,.64,1);
}
.records-modal-header {
  background: linear-gradient(135deg, var(--crimson-deep), var(--crimson));
  padding: .85rem 1.5rem;
  display: flex; align-items: center; justify-content: space-between;
  position: relative;
}
.records-modal-header::after {
  content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 1.5px;
  background: linear-gradient(90deg, transparent, var(--gold-light), var(--gold), var(--gold-light), transparent);
  opacity: .6;
}
.records-modal-header span { color: #fff; font-size: .95rem; font-weight: 700; }
.records-modal-search {
  padding: .75rem 1.25rem;
  background: var(--ivory-warm);
  border-bottom: 1px solid var(--ivory-deep);
  display: flex; gap: .45rem; align-items: center; flex-wrap: wrap;
}
.records-modal-search input {
  padding: .4rem .9rem;
  border: 1.5px solid var(--ivory-deep);
  border-radius: 9px; font-size: .81rem; outline: none;
  width: 240px; font-family: var(--font-body); background: white;
  transition: border-color .18s, box-shadow .18s;
}
.records-modal-search input:focus {
  border-color: var(--crimson);
  box-shadow: 0 0 0 3px var(--crimson-glow);
}
.records-modal-body {
  max-height: calc(90vh - 180px); overflow-y: auto; overflow-x: hidden;
  display: flex; flex-direction: column;
}
.records-scroll-wrap {
  overflow-x: auto; overflow-y: visible; flex: 1;
}
.records-scroll-wrap::-webkit-scrollbar { height: 6px; }
.records-scroll-wrap::-webkit-scrollbar-track { background: var(--ivory); }
.records-scroll-wrap::-webkit-scrollbar-thumb { background: var(--ink-ghost); border-radius: 6px; }
.records-scroll-wrap::-webkit-scrollbar-thumb:hover { background: var(--ink-faint); }
.records-modal-footer {
  padding: .6rem 1.25rem;
  background: var(--ivory-warm);
  border-top: 1px solid var(--ivory-deep);
  display: flex; align-items: center; justify-content: space-between;
  font-size: .78rem; color: var(--ink-faint);
}
.rm-empty { padding: 3rem; text-align: center; color: var(--ink-ghost); }
.rm-empty-icon { font-size: 2.5rem; margin-bottom: .5rem; }

/* ════════════════════════════════════════
   TOAST
════════════════════════════════════════ */
.toast-success {
  position: fixed; top: 24px; right: 24px;
  background: linear-gradient(135deg, #059669, #047857);
  color: white; padding: 13px 20px; border-radius: 12px;
  font-size: .875rem; font-weight: 500;
  display: flex; align-items: center; gap: 10px;
  box-shadow: 0 8px 30px rgba(5,150,105,.28), 0 2px 8px rgba(0,0,0,.1);
  z-index: 99999; opacity: 0;
  transform: translateY(-12px) scale(.97);
  animation: toastIn .28s cubic-bezier(.34,1.4,.64,1) forwards;
  font-family: var(--font-body);
}
.toast-icon { font-weight: 800; font-size: 1rem; }
@keyframes toastIn { to { opacity: 1; transform: translateY(0) scale(1); } }

/* ════════════════════════════════════════
   FIELD VALIDATION
════════════════════════════════════════ */
.field-error { margin-top: 4px; font-size: .72rem; color: #dc2626; font-weight: 600; }
.is-invalid { border-color: #dc2626 !important; box-shadow: 0 0 0 3px rgba(220,38,38,.1); }

/* ════════════════════════════════════════
   PAGINATION WRAPPER
════════════════════════════════════════ */
.tab-content > div[style*="padding:1rem"] {
  background: var(--ivory-warm);
  border-top: 1px solid var(--ivory-deep);
}
</style>
@endpush

@section('content')
<div class="page page-wide">

  {{-- ✅ Toast --}}
  @if(session('success'))
    <div id="toast-success" class="toast-success" role="status" aria-live="polite">
      <span class="toast-icon">✔</span>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  {{-- Page header --}}
  @php
    $totalAll = ($counts['participation']??0)+($counts['attendance']??0)+($counts['publication']??0)+($counts['reimbursement']??0)+($counts['travel']??0);
  @endphp
  {{-- ═══ TABS ═══ --}}
  <div class="form-tabs">
    <button class="form-tab active" id="tab-participation" onclick="switchTab('participation')">
      📋 Participation <span class="tab-badge">{{ $counts['participation'] ?? 0 }}</span>
    </button>
    <button class="form-tab" id="tab-attendance" onclick="switchTab('attendance')">
      📅 Attendance <span class="tab-badge">{{ $counts['attendance'] ?? 0 }}</span>
    </button>
    <button class="form-tab" id="tab-publication" onclick="switchTab('publication')">
      📰 Publication Incentive <span class="tab-badge">{{ $counts['publication'] ?? 0 }}</span>
    </button>
    <button class="form-tab" id="tab-reimbursement" onclick="switchTab('reimbursement')">
      💰 Reimbursement <span class="tab-badge">{{ $counts['reimbursement'] ?? 0 }}</span>
    </button>
    <button class="form-tab" id="tab-travel" onclick="switchTab('travel')">
      ✈️ Authority to Travel <span class="tab-badge">{{ $counts['travel'] ?? 0 }}</span>
    </button>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 1 — Participation --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel active" id="panel-participation">
    <div class="tab-content">

      @php
        $p_total   = $counts['participation'] ?? 0;
        $p_month   = \App\Models\LdRequest::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
        $p_fin     = \App\Models\LdRequest::where('financial_requested',true)->count();
        $p_levels  = \App\Models\LdRequest::selectRaw('level, count(*) as cnt')->groupBy('level')->pluck('cnt','level')->toArray();
      @endphp
      <div class="stats-strip">
        <div class="stat-card stat-hero">
          <div class="stat-card-icon">📋</div>
          <div class="stat-label">Total</div>
          <div class="stat-value">{{ $p_total }}</div>
          <div class="stat-sub">participation requests</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">📅</div>
          <div class="stat-label">This Month</div>
          <div class="stat-value">{{ $p_month }}</div>
          <div class="stat-sub">new submissions</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">💰</div>
          <div class="stat-label">With Financial</div>
          <div class="stat-value">{{ $p_fin }}</div>
          <div class="stat-sub">requested funding</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">By Level</div>
          <div class="stat-mini-list">
            @foreach(['Local','Regional','National','International'] as $lv)
              @php $lc = $p_levels[$lv] ?? 0; $lp = $p_total > 0 ? ($lc/$p_total)*100 : 0; @endphp
              <div class="stat-mini-row">
                <span class="stat-mini-label">{{ $lv }}</span>
                <div class="stat-mini-bar"><div class="stat-mini-bar-fill" style="width:{{ $lp }}%;"></div></div>
                <span class="stat-mini-val">{{ $lc }}</span>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" type="button" onclick="openCreateModal()">
            ✏️ New Request
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" type="button" onclick="openRecordsModal('participation','📋 Participation Records')">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="participation">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search name, title...">
          <select class="filter-select" name="type" onchange="this.form.submit()">
            <option value="">All Types</option>
            @foreach($types ?? [] as $t)
              <option value="{{ $t }}" {{ request('type')===$t?'selected':'' }}>{{ $t }}</option>
            @endforeach
          </select>
          <select class="filter-select" name="level" onchange="this.form.submit()">
            <option value="">All Levels</option>
            @foreach($levels ?? [] as $l)
              <option value="{{ $l }}" {{ request('level')===$l?'selected':'' }}>{{ $l }}</option>
            @endforeach
          </select>
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['search','type','level']))
            <a href="{{ route('ld.index') }}?tab=participation" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($records) && $records->count())
        <div class="table-scroll"><table class="data-table" style="table-layout:fixed;width:100%;">
          <colgroup>
            <col style="width:36px">   {{-- # --}}
            <col style="width:70px">   {{-- Tracking # --}}
            <col style="width:70px">   {{-- Participant --}}
            <col style="width:100px">  {{-- Campus --}}
            <col style="width:70px">   {{-- Title (tooltip) --}}
            <col style="width:90px">   {{-- Type --}}
            <col style="width:70px">   {{-- Level --}}
            <col style="width:90px">   {{-- Date --}}
            <col style="width:70px">   {{-- Financial --}}
            <col style="width:130px">  {{-- Actions --}}
          </colgroup>
          <thead><tr>
            <th>#</th><th>Tracking #</th><th>Participant</th><th>Campus</th>
            <th>Title</th><th>Type</th><th>Level</th>
            <th>Date</th><th>Financial</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($records as $i => $r)
            <tr>
              <td class="muted">{{ $records->firstItem() + $i }}</td>
              <td class="muted" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.75rem;" title="{{ $r->tracking_number ?? '' }}">{{ $r->tracking_number ?? '—' }}</td>
              <td style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->participant_name }} — {{ $r->position }}">{{ $r->participant_name }}</td>
              <td class="muted" style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->campus }}">{{ $r->campus }}</td>
              <td style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->title }} ({{ $r->college_office }})">{{ $r->title }}</td>
              <td class="type-col">@foreach(($r->types??[]) as $t)<span class="badge badge-maroon badge-xs">{{ $t }}</span>@endforeach</td>
              <td class="level-col"><span class="badge badge-gold badge-xs">{{ $r->level }}</span></td>
              <td class="muted" style="white-space:nowrap;">{{ $r->intervention_date }}</td>
              <td>
                @if($r->financial_requested)
                  <span class="badge badge-green">Yes</span>
                @else
                  <span class="text-muted text-sm">No</span>
                @endif
              </td>
              <td class="act-col">
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" type="button" onclick="openViewModal({{ $r->id }})" title="View">👁</button>
                  <button class="btn btn-ghost btn-sm" type="button" onclick="openEditModal({{ $r->id }})" title="Edit">✏️</button>
                  <button class="btn btn-gold btn-sm" type="button" onclick="openPrintModal('{{ route('ld.print', $r->id) }}')" title="Print">🖨</button>
                  <button class="btn btn-primary btn-sm" type="button" data-mov-btn="{{ $r->id }}"
                          onclick="openMovModal('{{ route('ld.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})" title="Upload MOV">📎{{ $r->mov_path ? '✓' : '' }}</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        @if($records->hasPages())
          <div style="padding:1rem 1.35rem;border-top:1px solid var(--ivory-deep)">
            {{ $records->appends(['tab'=>'participation'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">📋</div><p>No participation requests yet.</p><div style="margin-top:1rem;"><button class="btn btn-primary btn-sm" onclick="openCreateModal()">✏️ Create First Request</button></div></div>
      @endif

      <div class="qa-grid" id="qa-participation">
        <form method="POST" action="{{ route('ld.store') }}" id="qaf-participation">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(160px,1fr));">
            <div class="qa-field"><label>Participant Name*</label><input type="text" name="participant_name" required></div>
            <div class="qa-field"><label>Position</label><input type="text" name="position"></div>
            <div class="qa-field"><label>Campus</label><input type="text" name="campus"></div>
            <div class="qa-field"><label>College / Office</label><input type="text" name="college_office"></div>
            <div class="qa-field"><label>Title of Intervention*</label><input type="text" name="title" required></div>
            <div class="qa-field"><label>Type</label>
              <select name="types[]" multiple style="height:2.6rem;">
                <option>Seminar</option><option>Training</option><option>Convention</option>
                <option>Conference</option><option>Workshop</option><option>Symposium</option><option>Immersion</option>
              </select>
            </div>
            <div class="qa-field"><label>Level</label>
              <select name="level">
                <option value="">—</option><option>Local</option><option>Regional</option><option>National</option><option>International</option>
              </select>
            </div>
            <div class="qa-field"><label>Date</label><input type="text" name="intervention_date" class="date-picker-range"></div>
            <div class="qa-field"><label>Financial Requested</label>
              <select name="financial_requested">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-participation')">Cancel</button>
          </div>
        </form>
      </div>

    </div>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 2 — Attendance --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel" id="panel-attendance">
    <div class="tab-content">

      @php
        $a_total   = $counts['attendance'] ?? 0;
        $a_month   = \App\Models\Ldattendance::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
        $a_fin     = \App\Models\Ldattendance::where('financial_requested',true)->count();
        $a_levels  = \App\Models\Ldattendance::selectRaw('level, count(*) as cnt')->groupBy('level')->pluck('cnt','level')->toArray();
      @endphp
      <div class="stats-strip">
        <div class="stat-card stat-hero">
          <div class="stat-card-icon">📅</div>
          <div class="stat-label">Total</div>
          <div class="stat-value">{{ $a_total }}</div>
          <div class="stat-sub">attendance requests</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">🗓️</div>
          <div class="stat-label">This Month</div>
          <div class="stat-value">{{ $a_month }}</div>
          <div class="stat-sub">new submissions</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">💰</div>
          <div class="stat-label">With Financial</div>
          <div class="stat-value">{{ $a_fin }}</div>
          <div class="stat-sub">requested funding</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">By Level</div>
          <div class="stat-mini-list">
            @foreach(['Local','Regional','National','International'] as $lv)
              @php $lc = $a_levels[$lv] ?? 0; $lp = $a_total > 0 ? ($lc/$a_total)*100 : 0; @endphp
              <div class="stat-mini-row">
                <span class="stat-mini-label">{{ $lv }}</span>
                <div class="stat-mini-bar"><div class="stat-mini-bar-fill" style="width:{{ $lp }}%;"></div></div>
                <span class="stat-mini-val">{{ $lc }}</span>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" type="button" onclick="openFormModal('attendance','📅 New Attendance Request')">
            ✏️ New Request
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" type="button" onclick="openRecordsModal('attendance','📅 Attendance Records')">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="attendance">
          <input type="text" name="att_search" value="{{ request('att_search') }}" placeholder="🔍 Search name, activity...">
          <select class="filter-select" name="att_level" onchange="this.form.submit()">
            <option value="">All Levels</option>
            @foreach(['Local','Regional','National','International'] as $l)
              <option value="{{ $l }}" {{ request('att_level')===$l?'selected':'' }}>{{ $l }}</option>
            @endforeach
          </select>
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['att_search','att_level']))
            <a href="{{ route('ld.index') }}?tab=attendance" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($attendanceRecords) && $attendanceRecords->count())
        <div class="table-scroll"><table class="data-table" style="table-layout:fixed;width:100%;">
          <colgroup>
            <col style="width:36px">   {{-- # --}}
            <col style="width:70px">   {{-- Tracking # --}}
            <col style="width:70px">   {{-- Attendee --}}
            <col style="width:110px">  {{-- Campus --}}
            <col style="width:90px">   {{-- Type --}}
            <col>                      {{-- Purpose (flex) --}}
            <col style="width:70px">   {{-- Level --}}
            <col style="width:90px">   {{-- Date --}}
            <col style="width:70px">   {{-- Financial --}}
            <col style="width:130px">  {{-- Actions --}}
          </colgroup>
          <thead><tr>
            <th>#</th><th>Tracking #</th><th>Attendee</th><th>Campus / Office</th>
            <th>Type of Activity</th><th>Purpose</th>
            <th>Level</th><th>Date</th><th>Financial</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($attendanceRecords as $i => $r)
            <tr>
              <td class="muted">{{ $attendanceRecords->firstItem() + $i }}</td>
              <td class="muted" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.75rem;" title="{{ $r->tracking_number ?? '' }}">{{ $r->tracking_number ?? '—' }}</td>
              <td style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->attendee_name }} — {{ $r->position }}">{{ $r->attendee_name }}</td>
              <td class="muted" style="max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->campus }} — {{ $r->college_office }}">{{ $r->campus }}</td>
              <td class="type-col">@foreach(($r->activity_types??[]) as $t)<span class="badge badge-maroon badge-xs">{{ $t }}</span>@endforeach</td>
              <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->purpose }}">{{ $r->purpose }}</td>
              <td class="level-col"><span class="badge badge-gold badge-xs">{{ $r->level }}</span></td>
              <td class="muted" style="white-space:nowrap;">{{ $r->activity_date }}</td>
              <td>
                @if($r->financial_requested)
                  <span class="badge badge-green">Yes</span>
                @else
                  <span class="text-muted text-sm">No</span>
                @endif
              </td>
              <td class="act-col">
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" type="button" onclick="openGenericView('attendance',{{ $r->id }},'📅 Attendance Details')" title="View">👁</button>
                  <button class="btn btn-ghost btn-sm" type="button" onclick="openFormModal('attendance-edit','✏️ Edit Attendance',{{ $r->id }})" title="Edit">✏️</button>
                  <button class="btn btn-gold btn-sm" type="button" onclick="openPrintModal('{{ route('ld.attendance.print',$r->id) }}')" title="Print">🖨</button>
                  <button class="btn btn-primary btn-sm" type="button"
                          onclick="openMovModal('{{ route('ld.attendance.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.attendance.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})" title="Upload MOV">📎{{ $r->mov_path ? '✓' : '' }}</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        @if($attendanceRecords->hasPages())
          <div style="padding:1rem 1.35rem;border-top:1px solid var(--ivory-deep)">
            {{ $attendanceRecords->appends(['tab'=>'attendance'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">📅</div><p>No attendance requests yet.</p><div style="margin-top:1rem;"><button class="btn btn-primary btn-sm" onclick="openFormModal('attendance','📅 New Attendance Request')">✏️ Create First Request</button></div></div>
      @endif

      <div class="qa-grid" id="qa-attendance">
        <form method="POST" action="{{ route('ld.attendance.store') }}" id="qaf-attendance">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(160px,1fr));">
            <div class="qa-field"><label>Attendee Name*</label><input type="text" name="attendee_name" required></div>
            <div class="qa-field"><label>Position</label><input type="text" name="position"></div>
            <div class="qa-field"><label>Campus</label><input type="text" name="campus"></div>
            <div class="qa-field"><label>College / Office</label><input type="text" name="college_office"></div>
            <div class="qa-field"><label>Employment Status</label>
              <select name="employment_status"><option value="">—</option><option>Permanent</option><option>Temporary</option><option>Contractual</option><option>COS</option></select>
            </div>
            <div class="qa-field"><label>Activity Type</label>
              <select name="activity_types[]" multiple style="height:2.6rem;">
                <option>Meeting</option><option>Planning Session</option><option>Benchmarking</option>
                <option>Project/Product Launch</option><option>Ceremonial/Representational</option>
              </select>
            </div>
            <div class="qa-field"><label>Purpose*</label><input type="text" name="purpose" required></div>
            <div class="qa-field"><label>Level</label>
              <select name="level"><option value="">—</option><option>Local</option><option>Regional</option><option>National</option><option>International</option></select>
            </div>
            <div class="qa-field"><label>Date</label><input type="text" name="activity_date" class="date-picker-range"></div>
            <div class="qa-field"><label>Venue</label><input type="text" name="venue"></div>
            <div class="qa-field"><label>Organizer</label><input type="text" name="organizer"></div>
            <div class="qa-field"><label>Financial Requested</label>
              <select name="financial_requested"><option value="0">No</option><option value="1">Yes</option></select>
            </div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-attendance')">Cancel</button>
          </div>
        </form>
      </div>

    </div>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 3 — Publication Incentive --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel" id="panel-publication">
    <div class="tab-content">

      @php
        $pb_total   = $counts['publication'] ?? 0;
        $pb_month   = \App\Models\Ldpublication::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
        $pb_avgAmt  = \App\Models\Ldpublication::avg('amount_requested') ?? 0;
        $pb_scopes  = \App\Models\Ldpublication::selectRaw('pub_scope, count(*) as cnt')->groupBy('pub_scope')->pluck('cnt','pub_scope')->toArray();
      @endphp
      <div class="stats-strip">
        <div class="stat-card stat-hero">
          <div class="stat-card-icon">📰</div>
          <div class="stat-label">Total</div>
          <div class="stat-value">{{ $pb_total }}</div>
          <div class="stat-sub">publication incentive requests</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">🗓️</div>
          <div class="stat-label">This Month</div>
          <div class="stat-value">{{ $pb_month }}</div>
          <div class="stat-sub">new submissions</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">₱</div>
          <div class="stat-label">Avg. Amount</div>
          <div class="stat-value" style="font-size:1.35rem;">₱{{ number_format($pb_avgAmt,0) }}</div>
          <div class="stat-sub">avg. incentive requested</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">By Scope</div>
          <div class="stat-mini-list">
            @foreach(['Regional','National','International'] as $sc)
              @php $sc_cnt = $pb_scopes[$sc] ?? 0; $sc_pct = $pb_total > 0 ? ($sc_cnt/$pb_total)*100 : 0; @endphp
              <div class="stat-mini-row">
                <span class="stat-mini-label">{{ $sc }}</span>
                <div class="stat-mini-bar"><div class="stat-mini-bar-fill" style="width:{{ $sc_pct }}%;"></div></div>
                <span class="stat-mini-val">{{ $sc_cnt }}</span>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" type="button" onclick="openFormModal('publication','📰 New Publication Incentive Request')">
            ✏️ New Request
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" type="button" onclick="openRecordsModal('publication','📰 Publication Incentive Records')">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="publication">
          <input type="text" name="pub_search" value="{{ request('pub_search') }}" placeholder="🔍 Search name, paper title...">
          <select class="filter-select" name="pub_scope" onchange="this.form.submit()">
            <option value="">All Scopes</option>
            @foreach(['Regional','National','International'] as $s)
              <option value="{{ $s }}" {{ request('pub_scope')===$s?'selected':'' }}>{{ $s }}</option>
            @endforeach
          </select>
          <select class="filter-select" name="pub_nature" onchange="this.form.submit()">
            <option value="">All Natures</option>
            @foreach(['CHED accredited (multidisciplinary)','CHED accredited (specific discipline)','ISI indexed','SCOPUS indexed'] as $n)
              <option value="{{ $n }}" {{ request('pub_nature')===$n?'selected':'' }}>{{ $n }}</option>
            @endforeach
          </select>
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['pub_search','pub_scope','pub_nature']))
            <a href="{{ route('ld.index') }}?tab=publication" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($publicationRecords) && $publicationRecords->count())
        <div class="table-scroll"><table class="data-table" style="table-layout:fixed;width:100%;">
          <colgroup>
            <col style="width:36px">   {{-- # --}}
            <col style="width:70px">   {{-- Tracking # --}}
            <col style="width:70px">   {{-- Faculty --}}
            <col style="width:90px">   {{-- Campus --}}
            <col>                      {{-- Title of Paper (flex) --}}
            <col style="width:130px">  {{-- Journal --}}
            <col style="width:80px">   {{-- Scope --}}
            <col style="width:90px">   {{-- Nature --}}
            <col style="width:90px">   {{-- Amount --}}
            <col style="width:130px">  {{-- Actions --}}
          </colgroup>
          <thead><tr>
            <th>#</th><th>Tracking #</th><th>Faculty / Employee</th><th>Campus</th>
            <th>Title of Paper</th><th>Journal</th>
            <th>Scope</th><th>Nature</th><th>Amount</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($publicationRecords as $i => $r)
            <tr>
              <td class="muted">{{ $publicationRecords->firstItem() + $i }}</td>
              <td class="muted" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.75rem;" title="{{ $r->tracking_number ?? '' }}">{{ $r->tracking_number ?? '—' }}</td>
              <td style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->faculty_name }} — {{ $r->position }}">{{ $r->faculty_name }}</td>
              <td class="muted" style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->campus }}">{{ $r->campus }}</td>
              <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->paper_title }}{{ $r->co_authors ? ' — '.$r->co_authors : '' }}">{{ $r->paper_title }}</td>
              <td class="muted" style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->journal_title }}{{ $r->issn_isbn ? ' ('.$r->issn_isbn.')' : '' }}">{{ $r->journal_title }}</td>
              <td class="level-col"><span class="badge badge-gold badge-xs">{{ $r->pub_scope }}</span></td>
              <td class="muted" style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->nature }}">{{ $r->nature }}</td>
              <td class="muted" style="white-space:nowrap;">@if($r->amount_requested)Php {{ number_format($r->amount_requested,2) }}@endif</td>
              <td class="act-col">
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" type="button" onclick="openGenericView('publication',{{ $r->id }},'📰 Publication Details')" title="View">👁</button>
                  <button class="btn btn-ghost btn-sm" type="button" onclick="openFormModal('publication-edit','✏️ Edit Publication',{{ $r->id }})" title="Edit">✏️</button>
                  <button class="btn btn-gold btn-sm" type="button" onclick="openPrintModal('{{ route('ld.publication.print',$r->id) }}')" title="Print">🖨</button>
                  <button class="btn btn-primary btn-sm" type="button"
                          onclick="openMovModal('{{ route('ld.publication.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.publication.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})" title="Upload MOV">📎{{ $r->mov_path ? '✓' : '' }}</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        @if($publicationRecords->hasPages())
          <div style="padding:1rem 1.35rem;border-top:1px solid var(--ivory-deep)">
            {{ $publicationRecords->appends(['tab'=>'publication'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">📰</div><p>No publication incentive requests yet.</p><div style="margin-top:1rem;"><button class="btn btn-primary btn-sm" onclick="openFormModal('publication','📰 New Publication Incentive Request')">✏️ Create First Request</button></div></div>
      @endif

      <div class="qa-grid" id="qa-publication">
        <form method="POST" action="{{ route('ld.publication.store') }}" id="qaf-publication">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(170px,1fr));">
            <div class="qa-field"><label>Faculty / Employee*</label><input type="text" name="faculty_name" required></div>
            <div class="qa-field"><label>Position</label><input type="text" name="position"></div>
            <div class="qa-field"><label>College / Office</label><input type="text" name="college_office"></div>
            <div class="qa-field"><label>Campus</label><input type="text" name="campus"></div>
            <div class="qa-field"><label>Employment Status</label>
              <select name="employment_status"><option value="">—</option><option>Permanent</option><option>Temporary</option><option>Contractual</option><option>COS</option></select>
            </div>
            <div class="qa-field"><label>Title of Paper*</label><input type="text" name="paper_title" required></div>
            <div class="qa-field"><label>Co-author/s</label><input type="text" name="co_authors"></div>
            <div class="qa-field"><label>Journal Title</label><input type="text" name="journal_title"></div>
            <div class="qa-field"><label>ISSN / ISBN</label><input type="text" name="issn_isbn"></div>
            <div class="qa-field"><label>Publisher</label><input type="text" name="publisher"></div>
            <div class="qa-field"><label>Scope</label>
              <select name="pub_scope"><option value="">—</option><option>Regional</option><option>National</option><option>International</option></select>
            </div>
            <div class="qa-field"><label>Format</label>
              <select name="pub_format"><option value="">—</option><option>Print</option><option>Online</option></select>
            </div>
            <div class="qa-field"><label>Nature</label>
              <select name="nature">
                <option value="">—</option>
                <option>CHED accredited (multidisciplinary)</option>
                <option>CHED accredited (specific discipline)</option>
                <option>ISI indexed</option><option>SCOPUS indexed</option>
              </select>
            </div>
            <div class="qa-field"><label>Amount Requested (Php)</label><input type="number" name="amount_requested" step="0.01" min="0"></div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-publication')">Cancel</button>
          </div>
        </form>
      </div>

    </div>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 4 — Reimbursement --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel" id="panel-reimbursement">
    <div class="tab-content">

      @php
        $r_total   = $counts['reimbursement'] ?? 0;
        $r_month   = \App\Models\Ldreimbursement::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
        $r_allItems = \App\Models\Ldreimbursement::all();
        $r_totalAmt = $r_allItems->sum(fn($x) => collect($x->expense_items??[])->sum(fn($i) => (float)($i['amount']??0)));
        $r_avgAmt   = $r_total > 0 ? $r_totalAmt / $r_total : 0;
      @endphp
      <div class="stats-strip">
        <div class="stat-card stat-hero">
          <div class="stat-card-icon">💰</div>
          <div class="stat-label">Total</div>
          <div class="stat-value">{{ $r_total }}</div>
          <div class="stat-sub">reimbursement requests</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">🗓️</div>
          <div class="stat-label">This Month</div>
          <div class="stat-value">{{ $r_month }}</div>
          <div class="stat-sub">new submissions</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">📊</div>
          <div class="stat-label">Total Amount</div>
          <div class="stat-value" style="font-size:1.25rem;">₱{{ number_format($r_totalAmt,0) }}</div>
          <div class="stat-sub">across all requests</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">📐</div>
          <div class="stat-label">Avg. per Request</div>
          <div class="stat-value" style="font-size:1.25rem;">₱{{ number_format($r_avgAmt,0) }}</div>
          <div class="stat-sub">average reimbursement</div>
        </div>
      </div>

      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" type="button" onclick="openFormModal('reimbursement','💰 New Reimbursement Request')">
            ✏️ New Request
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" type="button" onclick="openRecordsModal('reimbursement','💰 Reimbursement Records')">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="reimbursement">
          <input type="text" name="rei_search" value="{{ request('rei_search') }}" placeholder="🔍 Search department, payee...">
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['rei_search']))
            <a href="{{ route('ld.index') }}?tab=reimbursement" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($reimbursementRecords) && $reimbursementRecords->count())
        <div class="table-scroll"><table class="data-table" style="table-layout:fixed;width:100%;">
          <colgroup>
            <col style="width:36px">   {{-- # --}}
            <col style="width:70px">   {{-- Tracking # --}}
            <col style="width:150px">  {{-- Department --}}
            <col>                      {{-- Particulars (flex) --}}
            <col style="width:90px">   {{-- Activity Type --}}
            <col style="width:120px">  {{-- Venue --}}
            <col style="width:90px">   {{-- Date --}}
            <col style="width:100px">  {{-- Total Amount --}}
            <col style="width:130px">  {{-- Actions --}}
          </colgroup>
          <thead><tr>
            <th>#</th><th>Tracking #</th><th>Department / Office</th>
            <th>Particulars</th><th>Activity Type</th>
            <th>Venue</th><th>Date</th><th>Total Amount</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($reimbursementRecords as $i => $r)
            @php $total = collect($r->expense_items ?? [])->sum(fn($x) => (float)($x['amount'] ?? 0)); @endphp
            <tr>
              <td class="muted">{{ $reimbursementRecords->firstItem() + $i }}</td>
              <td class="muted" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.75rem;" title="{{ $r->tracking_number ?? '' }}">{{ $r->tracking_number ?? '—' }}</td>
              <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->department }}"><strong>{{ $r->department }}</strong></td>
              <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ collect($r->expense_items??[])->pluck('description')->filter()->implode(', ') }}">
                {{ collect($r->expense_items??[])->pluck('description')->filter()->take(2)->implode(', ') }}
              </td>
              <td class="type-col">@foreach(($r->activity_types??[]) as $t)<span class="badge badge-maroon badge-xs">{{ $t }}</span>@endforeach</td>
              <td class="muted" style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->venue }}">{{ $r->venue }}</td>
              <td class="muted" style="white-space:nowrap;">{{ $r->activity_date }}</td>
              <td style="white-space:nowrap;"><strong>@if($total > 0)Php {{ number_format($total,2) }}@endif</strong></td>
              <td class="act-col">
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" type="button" onclick="openGenericView('reimbursement',{{ $r->id }},'💰 Reimbursement Details')" title="View">👁</button>
                  <button class="btn btn-ghost btn-sm" type="button" onclick="openFormModal('reimbursement-edit','✏️ Edit Reimbursement',{{ $r->id }})" title="Edit">✏️</button>
                  <button class="btn btn-gold btn-sm" type="button" onclick="openPrintModal('{{ route('ld.reimbursement.print',$r->id) }}')" title="Print">🖨</button>
                  <button class="btn btn-primary btn-sm" type="button"
                          onclick="openMovModal('{{ route('ld.reimbursement.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.reimbursement.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})" title="Upload MOV">📎{{ $r->mov_path ? '✓' : '' }}</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        @if($reimbursementRecords->hasPages())
          <div style="padding:1rem 1.35rem;border-top:1px solid var(--ivory-deep)">
            {{ $reimbursementRecords->appends(['tab'=>'reimbursement'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">💰</div><p>No reimbursement requests yet.</p><div style="margin-top:1rem;"><button class="btn btn-primary btn-sm" onclick="openFormModal('reimbursement','💰 New Reimbursement Request')">✏️ Create First Request</button></div></div>
      @endif

      <div class="qa-grid" id="qa-reimbursement">
        <form method="POST" action="{{ route('ld.reimbursement.store') }}" id="qaf-reimbursement">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(160px,1fr));">
            <div class="qa-field"><label>Department / Office*</label><input type="text" name="department" required></div>
            <div class="qa-field"><label>Payee Name</label><input type="text" name="payee_name"></div>
            <div class="qa-field"><label>Item / Description*</label><input type="text" name="item_description" required></div>
            <div class="qa-field"><label>Quantity</label><input type="number" name="quantity" min="1" step="1"></div>
            <div class="qa-field"><label>Unit Cost (Php)</label><input type="number" name="unit_cost" step="0.01" min="0"></div>
            <div class="qa-field"><label>Amount (Php)</label><input type="number" name="amount" step="0.01" min="0"></div>
            <div class="qa-field"><label>Activity Type</label>
              <select name="activity_types[]" multiple style="height:2.6rem;">
                <option>Seminar/Training</option><option>Meeting</option><option>Seminar/Conference</option>
                <option>Accreditation</option><option>Program</option>
              </select>
            </div>
            <div class="qa-field"><label>Venue</label><input type="text" name="venue"></div>
            <div class="qa-field"><label>Date</label><input type="text" name="activity_date" class="date-picker-range"></div>
            <div class="qa-field"><label>Reason for Reimbursement</label><textarea name="reason"></textarea></div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-reimbursement')">Cancel</button>
          </div>
        </form>
      </div>

    </div>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 5 — Travel --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel" id="panel-travel">
    <div class="tab-content">

      @php
        $t_total   = $counts['travel'] ?? 0;
        $t_month   = \App\Models\Ldtravel::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
        $t_chargeable = \App\Models\Ldtravel::selectRaw('chargeable_against, count(*) as cnt')->whereNotNull('chargeable_against')->groupBy('chargeable_against')->orderByDesc('cnt')->limit(3)->pluck('cnt','chargeable_against')->toArray();
      @endphp
      <div class="stats-strip">
        <div class="stat-card stat-hero">
          <div class="stat-card-icon">✈️</div>
          <div class="stat-label">Total</div>
          <div class="stat-value">{{ $t_total }}</div>
          <div class="stat-sub">travel authority requests</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-icon">🗓️</div>
          <div class="stat-label">This Month</div>
          <div class="stat-value">{{ $t_month }}</div>
          <div class="stat-sub">new submissions</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Top Chargeable</div>
          <div class="stat-mini-list">
            @forelse($t_chargeable as $label => $cnt)
              @php $tp = $t_total > 0 ? ($cnt/$t_total)*100 : 0; @endphp
              <div class="stat-mini-row">
                <span class="stat-mini-label" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:90px;" title="{{ $label }}">{{ $label }}</span>
                <div class="stat-mini-bar"><div class="stat-mini-bar-fill" style="width:{{ $tp }}%;"></div></div>
                <span class="stat-mini-val">{{ $cnt }}</span>
              </div>
            @empty
              <div style="font-size:.72rem;color:var(--ink-ghost);">No data yet</div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" type="button" onclick="openFormModal('travel','✈️ New Authority to Travel')">
            ✏️ New Request
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" type="button" onclick="openRecordsModal('travel','✈️ Travel Authority Records')">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="travel">
          <input type="text" name="trv_search" value="{{ request('trv_search') }}" placeholder="🔍 Search employee, place...">
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['trv_search']))
            <a href="{{ route('ld.index') }}?tab=travel" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($travelRecords) && $travelRecords->count())
        <div class="table-scroll"><table class="data-table" style="table-layout:fixed;width:100%;">
          <colgroup>
            <col style="width:36px">   {{-- # --}}
            <col style="width:70px">   {{-- Tracking # --}}
            <col style="width:140px">  {{-- Employee/s --}}
            <col style="width:140px">  {{-- Places --}}
            <col>                      {{-- Purpose (flex) --}}
            <col style="width:100px">  {{-- Date of Travel --}}
            <col style="width:90px">   {{-- Time --}}
            <col style="width:110px">  {{-- Chargeable To --}}
            <col style="width:130px">  {{-- Actions --}}
          </colgroup>
          <thead><tr>
            <th>#</th><th>Tracking #</th><th>Employee/s</th>
            <th>Place/s to be Visited</th><th>Purpose</th>
            <th>Date of Travel</th><th>Time</th><th>Chargeable To</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($travelRecords as $i => $r)
            <tr>
              <td class="muted">{{ $travelRecords->firstItem() + $i }}</td>
              <td class="muted" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.75rem;" title="{{ $r->tracking_number ?? '' }}">{{ $r->tracking_number ?? '—' }}</td>
              <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->employee_names }}">{{ $r->employee_names }}</td>
              <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->places_visited }}">{{ $r->places_visited }}</td>
              <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->purpose }}">{{ $r->purpose }}</td>
              <td class="muted" style="white-space:nowrap;">{{ $r->travel_dates }}</td>
              <td class="muted" style="white-space:nowrap;">{{ $r->travel_time }}</td>
              <td class="muted" style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $r->chargeable_against }}">{{ $r->chargeable_against }}</td>
              <td class="act-col">
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" type="button" onclick="openGenericView('travel',{{ $r->id }},'✈️ Travel Authority Details')" title="View">👁</button>
                  <button class="btn btn-ghost btn-sm" type="button" onclick="openFormModal('travel-edit','✏️ Edit Travel Authority',{{ $r->id }})" title="Edit">✏️</button>
                  <button class="btn btn-gold btn-sm" type="button" onclick="openPrintModal('{{ route('ld.travel.print',$r->id) }}')" title="Print">🖨</button>
                  <button class="btn btn-primary btn-sm" type="button"
                          onclick="openMovModal('{{ route('ld.travel.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.travel.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})" title="Upload MOV">📎{{ $r->mov_path ? '✓' : '' }}</button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        @if($travelRecords->hasPages())
          <div style="padding:1rem 1.35rem;border-top:1px solid var(--ivory-deep)">
            {{ $travelRecords->appends(['tab'=>'travel'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">✈️</div><p>No travel authority requests yet.</p><div style="margin-top:1rem;"><button class="btn btn-primary btn-sm" onclick="openFormModal('travel','✈️ New Authority to Travel')">✏️ Create First Request</button></div></div>
      @endif

      <div class="qa-grid" id="qa-travel">
        <form method="POST" action="{{ route('ld.travel.store') }}" id="qaf-travel">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(180px,1fr));">
            <div class="qa-field"><label>Employee Name/s*</label><textarea name="employee_names" required placeholder="One per line for multiple"></textarea></div>
            <div class="qa-field"><label>Position/s</label><textarea name="positions" placeholder="One per line"></textarea></div>
            <div class="qa-field"><label>Date/s of Travel*</label><input type="text" name="travel_dates" class="date-picker-range" required placeholder="e.g. March 13, 2026"></div>
            <div class="qa-field"><label>Time</label><input type="text" name="travel_time" placeholder="e.g. 8:00 AM – 5:00 PM"></div>
            <div class="qa-field"><label>Place/s to be Visited*</label><input type="text" name="places_visited" required></div>
            <div class="qa-field"><label>Purpose*</label><textarea name="purpose" required></textarea></div>
            <div class="qa-field"><label>Chargeable Against</label><input type="text" name="chargeable_against" placeholder="e.g. N/A or fund source"></div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-travel')">Cancel</button>
          </div>
        </form>
      </div>

    </div>
  </div>

  {{-- ════════════════ MODALS ════════════════ --}}

  {{-- Print Modal --}}
  <div class="print-modal-overlay" id="printModal">
    <div class="print-modal">
      <div class="print-modal-header">
        <span>Print Preview</span>
        <button class="print-modal-close" type="button" onclick="closePrintModal()">✕ Close</button>
      </div>
      <iframe id="printModalFrame" src=""></iframe>
    </div>
  </div>

  {{-- Participation: View --}}
  <div class="modal-overlay" id="viewModal" aria-hidden="true">
    <div class="modal-box" role="dialog" aria-modal="true">
      <div class="modal-header">
        <span>📋 Request Details</span>
        <button class="modal-close" type="button" onclick="closeModal('viewModal')">✕ Close</button>
      </div>
      <div id="view-modal-body" class="modal-body"><p style="color:var(--ink-faint)">Loading...</p></div>
    </div>
  </div>

  {{-- Participation: Create --}}
  <div class="modal-overlay" id="createModal" aria-hidden="true">
    <div class="modal-box" role="dialog" aria-modal="true">
      <div class="modal-header">
        <span>✏️ New Participation Request</span>
        <button class="modal-close" type="button" onclick="closeModal('createModal')">✕ Close</button>
      </div>
      <div id="create-modal-body">
        @include('ld.create-form')
      </div>
    </div>
  </div>

  {{-- Participation: Edit --}}
  <div class="modal-overlay" id="editModal" aria-hidden="true">
    <div class="modal-box" role="dialog" aria-modal="true">
      <div class="modal-header">
        <span>✏️ Edit Request</span>
        <button class="modal-close" type="button" onclick="closeModal('editModal')">✕ Close</button>
      </div>
      <div id="edit-modal-body" class="modal-body"><p style="color:var(--ink-faint)">Loading...</p></div>
    </div>
  </div>

  {{-- Generic Form Modal (create & edit for attendance/publication/reimbursement/travel) --}}
  <div class="modal-overlay" id="genericFormModal" aria-hidden="true">
    <div class="modal-box" role="dialog" aria-modal="true">
      <div class="modal-header">
        <span id="genericFormTitle">New Request</span>
        <button class="modal-close" type="button" onclick="closeModal('genericFormModal')">✕ Close</button>
      </div>
      <div id="genericFormBody" class="modal-body"><p style="color:var(--ink-faint)">Loading...</p></div>
    </div>
  </div>

  {{-- Generic View Modal --}}
  <div class="modal-overlay" id="genericViewModal" aria-hidden="true">
    <div class="modal-box" role="dialog" aria-modal="true">
      <div class="modal-header">
        <span id="genericViewTitle">Details</span>
        <button class="modal-close" type="button" onclick="closeModal('genericViewModal')">✕ Close</button>
      </div>
      <div id="genericViewBody" class="modal-body"><p style="color:var(--ink-faint)">Loading...</p></div>
    </div>
  </div>

  {{-- ════ Records Popup Modal ════ --}}
  <div class="records-modal-overlay" id="recordsModal" aria-hidden="true">
    <div class="records-modal-box" role="dialog" aria-modal="true">
      <div class="records-modal-header">
        <span id="recordsModalTitle">Records</span>
        <div style="display:flex;align-items:center;gap:.5rem;">
          <button id="recordsAddBtn" class="btn btn-gold btn-sm" type="button" onclick="recordsAddNew()" style="font-size:.78rem;padding:.3rem .8rem;">
            ＋ Add Information
          </button>
          <button class="modal-close" type="button" onclick="closeRecordsModal()">✕ Close</button>
        </div>
      </div>

      <div class="records-modal-search">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;width:100%;">
          <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
            <input type="text" id="recordsSearchInput" placeholder="🔍 Search all fields..." oninput="applyRecordsFilters()" style="width:220px;">
            <select id="recordsFilterMonth" onchange="applyRecordsFilters()" style="padding:.4rem .65rem;border:1.5px solid var(--ivory-deep);border-radius:8px;font-size:.8rem;outline:none;">
              <option value="">All Months</option>
              <option value="1">January</option><option value="2">February</option><option value="3">March</option>
              <option value="4">April</option><option value="5">May</option><option value="6">June</option>
              <option value="7">July</option><option value="8">August</option><option value="9">September</option>
              <option value="10">October</option><option value="11">November</option><option value="12">December</option>
            </select>
            <select id="recordsFilterYear" onchange="applyRecordsFilters()" style="padding:.4rem .65rem;border:1.5px solid var(--ivory-deep);border-radius:8px;font-size:.8rem;outline:none;">
              <option value="">All Years</option>
            </select>
            <select id="recordsFilterLevel" onchange="applyRecordsFilters()" style="padding:.4rem .65rem;border:1.5px solid var(--ivory-deep);border-radius:8px;font-size:.8rem;outline:none;">
              <option value="">All Levels</option>
              <option>Local</option><option>Regional</option><option>National</option><option>International</option>
            </select>
            <select id="recordsFilterFinancial" onchange="applyRecordsFilters()" style="padding:.4rem .65rem;border:1.5px solid var(--ivory-deep);border-radius:8px;font-size:.8rem;outline:none;">
              <option value="">Financial — All</option>
              <option value="1">Financial — Yes</option>
              <option value="0">Financial — No</option>
            </select>
            <button type="button" onclick="clearRecordsFilters()" style="padding:.4rem .75rem;border:1.5px solid var(--ivory-deep);border-radius:8px;font-size:.78rem;background:#fff;cursor:pointer;color:var(--ink-faint);">✕ Clear</button>
          </div>

          <div style="display:flex;align-items:center;gap:.4rem;">
            <span id="recordsCountLabel" style="font-size:.78rem;color:var(--ink-faint);"></span>
            <div style="position:relative;display:inline-block;" id="downloadDropWrap">
              <button type="button" onclick="toggleDownloadDrop()" style="display:flex;align-items:center;gap:.35rem;padding:.4rem .85rem;background:var(--crimson);color:#fff;border:none;border-radius:8px;font-size:.78rem;font-weight:600;cursor:pointer;">
                ⬇ Download <span style="font-size:.65rem;opacity:.8;">▼</span>
              </button>
              <div id="downloadDrop" style="display:none;position:absolute;right:0;top:calc(100% + 4px);background:#fff;border:1px solid var(--ivory-deep);border-radius:var(--radius-md);box-shadow:0 8px 24px rgba(0,0,0,.15);min-width:190px;z-index:9999;overflow:hidden;">
                <div style="padding:.4rem .75rem;background:var(--ivory-warm);border-bottom:1px solid var(--ivory-deep);font-size:.68rem;font-weight:700;color:var(--ink-ghost);text-transform:uppercase;letter-spacing:.4pt;">Export as CSV</div>
                <button type="button" onclick="downloadCSV('filtered')" style="display:block;width:100%;padding:.55rem .85rem;background:none;border:none;text-align:left;font-size:.8rem;cursor:pointer;color:var(--ink);">📄 Filtered / Current View</button>
                <button type="button" onclick="downloadCSV('all')" style="display:block;width:100%;padding:.55rem .85rem;background:none;border:none;text-align:left;font-size:.8rem;cursor:pointer;color:var(--ink);border-top:1px solid var(--ivory-deep);">📦 All Records (unfiltered)</button>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="records-modal-body">
        <div class="records-scroll-wrap">
          <div id="recordsModalContent">
            <div class="rm-empty"><div class="rm-empty-icon">⏳</div><p>Loading records…</p></div>
          </div>
        </div>
      </div>

      <div class="records-modal-footer">
        <span id="recordsFooterInfo" style="font-size:.78rem;color:var(--ink-ghost);"></span>
        <button class="btn btn-ghost btn-sm" type="button" onclick="closeRecordsModal()">Close</button>
      </div>
    </div>
  </div>

  {{-- MOV Upload Modal --}}
  <div class="modal-overlay" id="movModal" aria-hidden="true">
    <div class="modal-box" style="max-width:520px;" role="dialog" aria-modal="true">
      <div class="modal-header">
        <span>📎 Upload MOV</span>
        <button class="modal-close" type="button" onclick="closeModal('movModal')">✕ Close</button>
      </div>
      <div style="padding:1.25rem 1.5rem;">
        <form id="movUploadForm" method="POST" action="" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="mov_record_id" id="mov_record_id" value="{{ old('mov_record_id') }}">
          <div style="margin-bottom:.75rem;">
            <label style="display:block;font-weight:600;margin-bottom:.35rem;">Select file</label>
            <input type="file" name="mov_file" required
                   style="width:100%;padding:.55rem .7rem;border:1.5px solid var(--ivory-deep);border-radius:10px;">
          </div>
          <div id="movExisting" style="display:none;padding:.75rem;border:1px solid var(--ivory-deep);border-radius:var(--radius-md);margin-bottom:.9rem;">
            <div class="muted text-sm" style="margin-bottom:.35rem;">Current MOV:</div>
            <button type="button" id="movPreviewBtn" class="btn btn-outline btn-sm" style="margin-bottom:.4rem;">👁 View File</button>
            <div id="movName" class="muted text-xs"></div>
          </div>
          <div class="d-flex justify-between align-center" style="gap:.75rem;">
            <button type="button" class="btn btn-ghost" onclick="closeModal('movModal')">Cancel</button>
            <button type="submit" class="btn btn-primary">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- MOV Preview Modal --}}
  <div class="print-modal-overlay" id="movPreviewModal" aria-hidden="true">
    <div class="print-modal" style="max-width:1100px;width:95vw;height:92vh;" role="dialog" aria-modal="true">
      <div class="print-modal-header">
        <span id="movPreviewTitle">📎 MOV Preview</span>
        <div style="display:flex;gap:.5rem;align-items:center;">
          <a id="movDownloadBtn" href="#" target="_blank" class="print-modal-close" style="text-decoration:none;">⬇ Download</a>
          <button class="print-modal-close" type="button" onclick="closeMovPreview()">✕ Close</button>
        </div>
      </div>
      <div id="movImageContainer" style="display:none;flex:1;overflow:auto;background:#f5f5f5;align-items:center;justify-content:center;">
        <img id="movPreviewImage" style="max-width:100%;max-height:100%;object-fit:contain;display:block;margin:auto;">
      </div>
      <iframe id="movPreviewFrame" style="flex:1;width:100%;border:none;background:#f5f5f5;display:none;"></iframe>
      <div id="movUnsupported" style="display:none;flex:1;align-items:center;justify-content:center;flex-direction:column;gap:1rem;background:#f5f5f5;">
        <div style="font-size:3rem;">📄</div>
        <p style="color:var(--ink-mid);font-weight:600;" id="movUnsupportedName"></p>
        <p style="color:var(--ink-faint);font-size:.875rem;">This file type cannot be previewed in the browser.</p>
        <a id="movUnsupportedDownload" href="#" target="_blank" class="btn btn-primary">⬇ Download File</a>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
/* ✅ Toast auto-hide */
document.addEventListener('DOMContentLoaded', function () {
  const toast = document.getElementById('toast-success');
  if (!toast) return;
  setTimeout(() => {
    toast.style.transition = "all 0.35s ease";
    toast.style.opacity = "0";
    toast.style.transform = "translateY(-10px)";
    setTimeout(() => toast.remove(), 400);
  }, 2500);
});

/* ── Helpers for dynamically-loaded form partials ── */
/* These must live here (not in the injected HTML) because
   innerHTML-injected <script> tags are NOT executed by browsers. */

function attToggleOthers(chk, txtId) {
  const t = document.getElementById(txtId);
  if (!t) return;
  if (chk.checked) {
    t.removeAttribute('disabled');
    t.focus();
  } else {
    t.setAttribute('disabled', 'disabled');
    t.value = '';
  }
}

function resetSignatory(btn) {
  btn.closest('.sig-box').querySelectorAll('[data-default]').forEach(function(i) {
    i.value = i.dataset.default;
  });
}

/* Generic "others" toggle used across all forms */
function toggleOthersInput(chk, txtId) {
  attToggleOthers(chk, txtId); // same logic, alias
}

/* Re-execute inline scripts from dynamically injected HTML */
function reExecScripts(container) {
  container.querySelectorAll('script').forEach(function(oldScript) {
    const newScript = document.createElement('script');
    Array.from(oldScript.attributes).forEach(a => newScript.setAttribute(a.name, a.value));
    newScript.textContent = oldScript.textContent;
    oldScript.parentNode.replaceChild(newScript, oldScript);
  });
}

/* ── Tab switching ── */
function switchTab(name) {
  document.querySelectorAll('.form-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('tab-' + name)?.classList.add('active');
  document.getElementById('panel-' + name)?.classList.add('active');
  history.replaceState(null, '', '{{ route("ld.index") }}?tab=' + name);
}

/* ── Modal helpers ── */
function openModal(id) {
  document.getElementById(id)?.classList.add('active');
  document.body.style.overflow = 'hidden';
}
function closeModal(id) {
  document.getElementById(id)?.classList.remove('active');
  document.body.style.overflow = '';
}

/* View-only modals close on overlay click */
['viewModal','editModal','genericViewModal'].forEach(id => {
  document.getElementById(id)?.addEventListener('click', e => { if (e.target.id === id) closeModal(id); });
});
document.getElementById('printModal')?.addEventListener('click', e => { if (e.target.id === 'printModal') closePrintModal(); });
document.getElementById('movPreviewModal')?.addEventListener('click', e => { if (e.target.id === 'movPreviewModal') closeMovPreview(); });

/* ══════════════════════════════════════════
   FIXED DATE PICKERS
   - writeRangeValue REMOVED entirely
   - onChange REMOVED (was the bug: fired after 1st click, saved only 1 date)
   - onClose only fires when calendar closes = both dates already chosen
   - dateFormat 'Y-m-d' = internal format, won't overwrite your custom display string
   - Single day   → "March 4, 2026"
   - Same month   → "March 4-5, 2026"
   - Same year    → "March 4 - April 2, 2026"
   - Diff years   → "March 4, 2025 - January 2, 2026"
══════════════════════════════════════════ */
function initDatePickers(root = document) {
  if (!window.flatpickr || !root?.querySelectorAll) return;

  // Destroy existing instances to prevent double-init
  root.querySelectorAll('.date-picker, .date-picker-multi, .date-picker-range').forEach(el => {
    if (el._flatpickr) el._flatpickr.destroy();
  });

  // ── Single date ──
  root.querySelectorAll('.date-picker').forEach(el => {
    flatpickr(el, {
      dateFormat: 'Y-m-d',
      allowInput: false,
      onClose: function(selectedDates, dateStr, instance) {
        if (selectedDates.length === 0) return;
        instance.input.value = instance.formatDate(selectedDates[0], "F j, Y");
      },
    });
  });

  // ── Multiple dates ──
  root.querySelectorAll('.date-picker-multi').forEach(el => {
    flatpickr(el, {
      mode: 'multiple',
      dateFormat: 'Y-m-d',
      allowInput: false,
      onClose: function(selectedDates, dateStr, instance) {
        if (selectedDates.length === 0) return;
        instance.input.value = selectedDates
          .map(d => instance.formatDate(d, "F j, Y"))
          .join(', ');
      },
    });
  });

  // ── Range (the fixed one) ──
  root.querySelectorAll('.date-picker-range').forEach(el => {
    // Save whatever is already in the input (existing DB value on edit forms)
    const existingValue = el.value || '';

    flatpickr(el, {
      mode: 'range',
      // Use the human-readable format so flatpickr can parse existing values like "March 4, 2026"
      dateFormat: 'F j, Y',
      allowInput: false,

      // onReady: runs once after flatpickr initialises.
      // If flatpickr couldn't parse the existing value (e.g. "March 4-5, 2026" range format)
      // it clears the input — so we restore it here.
      onReady: function(selectedDates, dateStr, instance) {
        if (existingValue && instance.input.value === '') {
          instance.input.value = existingValue;
        }
      },

      onClose: function(selectedDates, dateStr, instance) {
        if (selectedDates.length === 0) return;

        const fmt = (d, f) => instance.formatDate(d, f);

        // Single day selected → "March 4, 2026"
        if (selectedDates.length === 1) {
          instance.input.value = fmt(selectedDates[0], "F j, Y");
          return;
        }

        const start = selectedDates[0];
        const end   = selectedDates[1];

        const sameYear  = start.getFullYear() === end.getFullYear();
        const sameMonth = sameYear && start.getMonth() === end.getMonth();

        if (sameMonth) {
          // "March 4-5, 2026"
          instance.input.value = `${fmt(start, "F")} ${start.getDate()}-${end.getDate()}, ${end.getFullYear()}`;
        } else if (sameYear) {
          // "March 4 - April 2, 2026"
          instance.input.value = `${fmt(start, "F j")} - ${fmt(end, "F j, Y")}`;
        } else {
          // "March 4, 2025 - January 2, 2026"
          instance.input.value = `${fmt(start, "F j, Y")} - ${fmt(end, "F j, Y")}`;
        }
      },
    });
  });
}

/* ── Participation: View / Create / Edit ── */
function openViewModal(id) {
  openModal('viewModal');
  document.getElementById('view-modal-body').innerHTML = loadingHtml();
  fetch(`/ld-requests/${id}/show-modal`, { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
    .then(r => r.text()).then(html => { document.getElementById('view-modal-body').innerHTML = html; });
}
function openCreateModal() { openModal('createModal'); }

function bindOthersToggle(chkId, txtId) {
  const chk = document.getElementById(chkId);
  const txt = document.getElementById(txtId);
  if (!chk || !txt) return;
  const sync = () => {
    if (chk.checked) { txt.disabled = false; txt.focus(); }
    else { txt.value = ''; txt.disabled = true; }
  };
  chk.addEventListener('change', sync);
  sync();
}
function initEditModalToggles() {
  bindOthersToggle('e_type_others_chk', 'e_type_others_txt');
  bindOthersToggle('e_nature_others_chk', 'e_nature_others_txt');
  bindOthersToggle('e_cov_others_chk', 'e_cov_others_txt');
}
function openEditModal(id) {
  openModal('editModal');
  const body = document.getElementById('edit-modal-body');
  body.innerHTML = loadingHtml();
  fetch(`/ld-requests/${id}/edit-modal`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.text())
    .then(html => {
      body.innerHTML = html;
      reExecScripts(body);
      initEditModalToggles();
      initDatePickers(body);
    })
    .catch(() => { body.innerHTML = `<div style="padding:1rem">Failed to load edit form.</div>`; });
}

/* ── Generic Form Modal ── */
const formRoutes = {
  'attendance':         '/ld-requests/form/attendance',
  'publication':        '/ld-requests/form/publication',
  'reimbursement':      '/ld-requests/form/reimbursement',
  'travel':             '/ld-requests/form/travel',
  'attendance-edit':    id => `/ld-requests/attendance/${id}/edit-modal`,
  'publication-edit':   id => `/ld-requests/publication/${id}/edit-modal`,
  'reimbursement-edit': id => `/ld-requests/reimbursement/${id}/edit-modal`,
  'travel-edit':        id => `/ld-requests/travel/${id}/edit-modal`,
};

function openFormModal(type, title, id = null) {
  document.getElementById('genericFormTitle').textContent = title;
  document.getElementById('genericFormBody').innerHTML = loadingHtml();
  openModal('genericFormModal');

  const route = typeof formRoutes[type] === 'function' ? formRoutes[type](id) : formRoutes[type];
  fetch(route, { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
    .then(r => r.text())
    .then(html => {
      const container = document.getElementById('genericFormBody');
      container.innerHTML = html;
      reExecScripts(container);
      initDatePickers(container);
    })
    .catch(() => {
      document.getElementById('genericFormBody').innerHTML =
        '<div style="padding:2.5rem;text-align:center;color:var(--ink-faint);">' +
        '<div style="font-size:2.5rem;margin-bottom:.75rem;">🚧</div>' +
        '<strong>Form coming soon</strong><p style="margin-top:.5rem;font-size:.875rem;">This form is under construction.</p></div>';
    });
}

/* ── Generic View Modal ── */
const viewRoutes = {
  attendance:    id => `/ld-requests/attendance/${id}/show-modal`,
  publication:   id => `/ld-requests/publication/${id}/show-modal`,
  reimbursement: id => `/ld-requests/reimbursement/${id}/show-modal`,
  travel:        id => `/ld-requests/travel/${id}/show-modal`,
};
function openGenericView(type, id, title) {
  document.getElementById('genericViewTitle').textContent = title;
  document.getElementById('genericViewBody').innerHTML = loadingHtml();
  openModal('genericViewModal');
  fetch(viewRoutes[type](id), { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
    .then(r => r.text())
    .then(html => { document.getElementById('genericViewBody').innerHTML = html; })
    .catch(() => { document.getElementById('genericViewBody').innerHTML = '<p style="padding:2rem;text-align:center;color:var(--ink-faint);">Could not load details.</p>'; });
}

/* ── Print modal ── */
function openPrintModal(url) {
  document.getElementById('printModalFrame').src = url;
  document.getElementById('printModal')?.classList.add('active');
  document.body.style.overflow = 'hidden';
}
function closePrintModal() {
  document.getElementById('printModal')?.classList.remove('active');
  document.getElementById('printModalFrame').src = '';
  document.body.style.overflow = '';
}

/* ═══════════════════════════════════════════════════
   RECORDS POPUP MODAL
═══════════════════════════════════════════════════ */

const recordsConfig = {
  participation: {
    apiUrl: '/ld-requests/records/participation',
    addFn:  () => { closeRecordsModal(); openCreateModal(); },
    columns: [
      { label: '#', key: '_index' },
      { label: 'Tracking #', key: 'tracking_number' },
      { label: 'Participant Name', key: 'participant_name' },
      { label: 'Position', key: 'position' },
      { label: 'Campus', key: 'campus' },
      { label: 'College / Office', key: 'college_office' },
      { label: 'Employment Status', key: 'employment_status' },
      { label: 'Title of Intervention', key: 'title' },
      { label: 'Type', key: 'types', array: true },
      { label: 'Other Type', key: 'type_others' },
      { label: 'Level', key: 'level', badge: 'gold' },
      { label: 'Nature', key: 'natures', array: true },
      { label: 'Other Nature', key: 'nature_others' },
      { label: 'Competency', key: 'competency' },
      { label: 'Date', key: 'intervention_date' },
      { label: 'Hours', key: 'hours' },
      { label: 'Venue', key: 'venue' },
      { label: 'Organizer', key: 'organizer' },
      { label: 'Endorsed by Org?', key: 'endorsed_by_org', bool: true },
      { label: 'Related to Field?', key: 'related_to_field', bool: true },
      { label: 'Has Pending LDAP?', key: 'has_pending_ldap', bool: true },
      { label: 'Cash Advance?', key: 'has_cash_advance', bool: true },
      { label: 'Financial Requested?', key: 'financial_requested', bool: true },
      { label: 'Amount Requested', key: 'amount_requested', currency: true },
      { label: 'Coverage', key: 'coverage', array: true },
      { label: 'Other Coverage', key: 'coverage_others' },
    ]
  },

  attendance: {
    apiUrl: '/ld-requests/records/attendance',
    addFn:  () => { closeRecordsModal(); openFormModal('attendance','📅 New Attendance Request'); },
    columns: [
      { label: '#', key: '_index' },
      { label: 'Tracking #', key: 'tracking_number' },
      { label: 'Attendee Name', key: 'attendee_name' },
      { label: 'Position', key: 'position' },
      { label: 'Campus', key: 'campus' },
      { label: 'College / Office', key: 'college_office' },
      { label: 'Employment Status', key: 'employment_status' },
      { label: 'Activity Type', key: 'activity_types', array: true },
      { label: 'Other Activity', key: 'activity_type_others' },
      { label: 'Nature', key: 'natures', array: true },
      { label: 'Other Nature', key: 'nature_others' },
      { label: 'Purpose', key: 'purpose' },
      { label: 'Level', key: 'level', badge: 'gold' },
      { label: 'Date', key: 'activity_date' },
      { label: 'Hours', key: 'hours' },
      { label: 'Venue', key: 'venue' },
      { label: 'Organizer', key: 'organizer' },
      { label: 'Financial Requested?', key: 'financial_requested', bool: true },
      { label: 'Amount Requested', key: 'amount_requested', currency: true },
      { label: 'Coverage', key: 'coverage', array: true },
      { label: 'Other Coverage', key: 'coverage_others' },
    ]
  },

  publication: {
    apiUrl: '/ld-requests/records/publication',
    addFn:  () => { closeRecordsModal(); openFormModal('publication','📰 New Publication Incentive Request'); },
    columns: [
      { label: '#', key: '_index' },
      { label: 'Tracking #', key: 'tracking_number' },
      { label: 'Faculty / Employee', key: 'faculty_name' },
      { label: 'Position', key: 'position' },
      { label: 'Campus', key: 'campus' },
      { label: 'College / Office', key: 'college_office' },
      { label: 'Employment Status', key: 'employment_status' },
      { label: 'Title of Paper', key: 'paper_title' },
      { label: 'Co-author/s', key: 'co_authors' },
      { label: 'Journal Title', key: 'journal_title' },
      { label: 'Vol. / Issue / No.', key: 'vol_issue' },
      { label: 'ISSN / ISBN', key: 'issn_isbn' },
      { label: 'Publisher', key: 'publisher' },
      { label: 'Editors', key: 'editors' },
      { label: 'Website', key: 'website' },
      { label: 'Email', key: 'email_address' },
      { label: 'Scope', key: 'pub_scope', badge: 'gold' },
      { label: 'Format', key: 'pub_format' },
      { label: 'Nature', key: 'nature' },
      { label: 'Amount Requested', key: 'amount_requested', currency: true },
      { label: 'Prev. Claimed?', key: 'has_previous_claim', bool: true },
      { label: 'Prev. Claim Amount', key: 'previous_claim_amount', currency: true },
      { label: 'Prev. Paper Title', key: 'prev_paper_title' },
      { label: 'Prev. Co-authors', key: 'prev_co_authors' },
      { label: 'Prev. Journal', key: 'prev_journal_title' },
      { label: 'Prev. Vol./Issue', key: 'prev_vol_issue' },
      { label: 'Prev. ISSN/ISBN', key: 'prev_issn_isbn' },
      { label: 'Prev. DOI', key: 'prev_doi' },
      { label: 'Prev. Publisher', key: 'prev_publisher' },
      { label: 'Prev. Editors', key: 'prev_editors' },
      { label: 'Prev. Scope', key: 'prev_pub_scope', badge: 'gold' },
    ]
  },

  reimbursement: {
    apiUrl: '/ld-requests/records/reimbursement',
    addFn:  () => { closeRecordsModal(); openFormModal('reimbursement','💰 New Reimbursement Request'); },
    columns: [
      { label: '#', key: '_index' },
      { label: 'Tracking #', key: 'tracking_number' },
      { label: 'Department / Office', key: 'department' },
      { label: 'Activity Type', key: 'activity_types', array: true },
      { label: 'Other Activity', key: 'activity_type_others' },
      { label: 'Venue', key: 'venue' },
      { label: 'Date', key: 'activity_date' },
      { label: 'Reason', key: 'reason' },
      { label: 'Remarks', key: 'remarks' },
      { label: 'Expense Items', key: 'expense_items', expenseCell: true },
      { label: 'Total Amount', key: '_total', totalCalc: true },
    ]
  },

  travel: {
    apiUrl: '/ld-requests/records/travel',
    addFn:  () => { closeRecordsModal(); openFormModal('travel','✈️ New Authority to Travel'); },
    columns: [
      { label: '#', key: '_index' },
      { label: 'Tracking #', key: 'tracking_number' },
      { label: 'Employee Name/s', key: 'employee_names', pre: true },
      { label: 'Position/s', key: 'positions', pre: true },
      { label: 'Date/s of Travel', key: 'travel_dates' },
      { label: 'Time', key: 'travel_time' },
      { label: 'Place/s to be Visited', key: 'places_visited' },
      { label: 'Purpose of Travel', key: 'purpose' },
      { label: 'Chargeable Against', key: 'chargeable_against' },
    ]
  },
};

let _allRecordsData = [];
let _filteredRecordsData = [];
let _currentRecordsType = '';

function openRecordsModal(type, title) {
  _currentRecordsType = type;
  _filteredRecordsData = [];

  document.getElementById('recordsModalTitle').textContent = title;
  document.getElementById('recordsSearchInput').value = '';
  document.getElementById('recordsFilterMonth').value = '';
  document.getElementById('recordsFilterYear').value = '';
  document.getElementById('recordsFilterLevel').value = '';
  document.getElementById('recordsFilterFinancial').value = '';
  document.getElementById('recordsCountLabel').textContent = '';
  document.getElementById('recordsFooterInfo').textContent = '';

  const hasLevel     = ['participation','attendance'].includes(type);
  const hasFinancial = ['participation','attendance'].includes(type);
  document.getElementById('recordsFilterLevel').style.display     = hasLevel ? '' : 'none';
  document.getElementById('recordsFilterFinancial').style.display = hasFinancial ? '' : 'none';

  document.getElementById('recordsModalContent').innerHTML =
    '<div class="rm-empty"><div class="rm-empty-icon">⏳</div><p>Loading records…</p></div>';

  document.getElementById('recordsModal').classList.add('active');
  document.body.style.overflow = 'hidden';

  const cfg = recordsConfig[type];
  if (!cfg) return;

  fetch(cfg.apiUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(data => {
      _allRecordsData = data.records || data || [];
      _filteredRecordsData = [..._allRecordsData];
      populateYearFilter(_allRecordsData, type);
      renderRecordsTable(_allRecordsData, type);

      const total = _allRecordsData.length;
      document.getElementById('recordsCountLabel').textContent = `${total} record${total !== 1 ? 's' : ''}`;
      document.getElementById('recordsFooterInfo').textContent = `Showing all ${total} record${total !== 1 ? 's' : ''}`;
    })
    .catch(err => {
      console.error(err);
      document.getElementById('recordsModalContent').innerHTML =
        '<div class="rm-empty"><div class="rm-empty-icon">⚠️</div><p>Could not load records. Please try again.</p></div>';
    });
}

function closeRecordsModal() {
  document.getElementById('recordsModal').classList.remove('active');
  document.body.style.overflow = '';
  _allRecordsData = [];
  _filteredRecordsData = [];
  _currentRecordsType = '';
}

function recordsAddNew() {
  const cfg = recordsConfig[_currentRecordsType];
  if (cfg && cfg.addFn) cfg.addFn();
}

document.getElementById('recordsModal')?.addEventListener('click', e => {
  if (e.target.id === 'recordsModal') closeRecordsModal();
});

const recordsDateKey = {
  participation: 'intervention_date',
  attendance:    'activity_date',
  publication:   'created_at',
  reimbursement: 'activity_date',
  travel:        'travel_dates',
};
const recordsLevelKey = {
  participation: 'level',
  attendance:    'level',
  publication:   'pub_scope',
  reimbursement: null,
  travel:        null,
};
const recordsFinancialKey = {
  participation: 'financial_requested',
  attendance:    'financial_requested',
  publication:   null,
  reimbursement: null,
  travel:        null,
};

function populateYearFilter(data, type) {
  const dateKey = recordsDateKey[type];
  const years = new Set();
  data.forEach(row => {
    const raw = row[dateKey] || row['created_at'] || '';
    const m = String(raw).match(/\d{4}/);
    if (m) years.add(m[0]);
  });

  const sel = document.getElementById('recordsFilterYear');
  const current = sel.value;
  sel.innerHTML = '<option value="">All Years</option>';
  [...years].sort((a,b) => b - a).forEach(y => {
    sel.innerHTML += `<option value="${y}" ${current===y?'selected':''}>${y}</option>`;
  });
}

function applyRecordsFilters() {
  const q         = (document.getElementById('recordsSearchInput')?.value || '').toLowerCase().trim();
  const month     = document.getElementById('recordsFilterMonth')?.value || '';
  const year      = document.getElementById('recordsFilterYear')?.value || '';
  const level     = document.getElementById('recordsFilterLevel')?.value || '';
  const financial = document.getElementById('recordsFilterFinancial')?.value;
  const type      = _currentRecordsType;

  const dateKey  = recordsDateKey[type];
  const levelKey = recordsLevelKey[type];
  const finKey   = recordsFinancialKey[type];

  let filtered = _allRecordsData.filter(row => {
    if (q) {
      const match = Object.values(row).some(v => {
        if (Array.isArray(v)) return v.some(x => String(x).toLowerCase().includes(q));
        return String(v ?? '').toLowerCase().includes(q);
      });
      if (!match) return false;
    }

    if (month) {
      const raw = String(row[dateKey] || row['created_at'] || '');
      const d = new Date(raw.match(/\d{4}-\d{2}-\d{2}/) ? raw : raw.replace(/(\w+ \d+,?\s*\d{4})/,'$1'));
      if (isNaN(d) || (d.getMonth() + 1) !== parseInt(month)) return false;
    }

    if (year) {
      const raw = String(row[dateKey] || row['created_at'] || '');
      const m = raw.match(/\d{4}/);
      if (!m || m[0] !== year) return false;
    }

    if (level && levelKey) {
      if (String(row[levelKey] || '').toLowerCase() !== level.toLowerCase()) return false;
    }

    if (financial !== '' && financial !== undefined && finKey) {
      const val = row[finKey];
      const wanted = financial === '1';
      if (Boolean(val) !== wanted) return false;
    }

    return true;
  });

  _filteredRecordsData = filtered;
  renderRecordsTable(filtered, type);

  const total = filtered.length;
  document.getElementById('recordsCountLabel').textContent =
    filtered.length === _allRecordsData.length
      ? `${total} record${total !== 1 ? 's' : ''}`
      : `${total} of ${_allRecordsData.length} record${_allRecordsData.length !== 1 ? 's' : ''}`;

  document.getElementById('recordsFooterInfo').textContent =
    filtered.length === _allRecordsData.length
      ? `Showing all ${total} record${total !== 1 ? 's' : ''}`
      : `Filtered: ${total} of ${_allRecordsData.length} records`;
}

function clearRecordsFilters() {
  document.getElementById('recordsSearchInput').value = '';
  document.getElementById('recordsFilterMonth').value = '';
  document.getElementById('recordsFilterYear').value = '';
  document.getElementById('recordsFilterLevel').value = '';
  document.getElementById('recordsFilterFinancial').value = '';
  applyRecordsFilters();
}

/* ── Download CSV ── */
function toggleDownloadDrop() {
  const d = document.getElementById('downloadDrop');
  d.style.display = d.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', e => {
  if (!document.getElementById('downloadDropWrap')?.contains(e.target)) {
    const d = document.getElementById('downloadDrop');
    if (d) d.style.display = 'none';
  }
});

function downloadCSV(mode) {
  document.getElementById('downloadDrop').style.display = 'none';
  const type = _currentRecordsType;
  const cfg  = recordsConfig[type];
  if (!cfg) return;

  const rows = mode === 'all'
    ? _allRecordsData
    : (_filteredRecordsData.length ? _filteredRecordsData : _allRecordsData);

  const cols = cfg.columns.filter(c => c.key !== '_index' && !c.totalCalc);

  const csvRows = [];
  csvRows.push(cols.map(c => csvEsc(c.label)).join(','));

  rows.forEach(row => {
    const cells = cols.map(col => {
      if (col.expenseCell) {
        const items = row[col.key] || [];
        const txt = items.map(i => `${i.description||''} x${i.quantity||''} @ ${i.unit_cost||''} = ${i.amount||''}`).join(' | ');
        return csvEsc(txt);
      }
      if (col.array) {
        const arr = Array.isArray(row[col.key]) ? row[col.key] : [];
        return csvEsc(arr.join(', '));
      }
      if (col.bool) return row[col.key] ? 'Yes' : 'No';
      if (col.currency) {
        const n = parseFloat(row[col.key] || 0);
        return n > 0 ? n.toFixed(2) : '';
      }
      return csvEsc(String(row[col.key] ?? ''));
    });
    csvRows.push(cells.join(','));
  });

  const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
  const url  = URL.createObjectURL(blob);
  const a    = document.createElement('a');
  const ts   = new Date().toISOString().slice(0,10);
  a.href     = url;
  a.download = `${type}-records-${mode === 'all' ? 'all' : 'filtered'}-${ts}.csv`;
  a.click();
  URL.revokeObjectURL(url);
}

function csvEsc(val) {
  const s = String(val ?? '').replace(/"/g, '""');
  return /[,"\n\r]/.test(s) ? `"${s}"` : s;
}

function renderRecordsTable(rows, type) {
  const cfg = recordsConfig[type];
  if (!cfg) return;

  if (!rows || rows.length === 0) {
    document.getElementById('recordsModalContent').innerHTML =
      '<div class="rm-empty"><div class="rm-empty-icon">📭</div><p>No records found.</p></div>';
    return;
  }

  let html = '<div>';
  html += '<table style="width:100%;border-collapse:collapse;font-size:.78rem;">';

  html += '<thead><tr>';
  cfg.columns.forEach(col => {
    html += `<th style="padding:.5rem .75rem;background:var(--crimson-deep);border-bottom:2px solid var(--crimson);
      border-right:1px solid var(--ivory-deep);text-align:left;font-size:.68rem;font-weight:700;
      color:var(--ink-faint);text-transform:uppercase;letter-spacing:.4pt;position:sticky;top:0;z-index:1;
      white-space:nowrap;">${esc(col.label)}</th>`;
  });
  html += '</tr></thead>';

  html += '<tbody>';
  rows.forEach((row, idx) => {
    const bg = idx % 2 === 0 ? '#fff' : '#fafafa';
    html += `<tr style="background:${bg};">`;

    cfg.columns.forEach(col => {
      const isWide = col.expenseCell || col.array;
      const cellStyle = isWide
        ? 'padding:.45rem .75rem;border-bottom:1px solid var(--ivory-deep);border-right:1px solid var(--ivory-deep);vertical-align:top;white-space:nowrap;'
        : 'padding:.45rem .75rem;border-bottom:1px solid var(--ivory-deep);border-right:1px solid var(--ivory-deep);vertical-align:top;white-space:nowrap;max-width:180px;overflow:hidden;text-overflow:ellipsis;';
      const rawVal = col.key !== '_index' && !col.array && !col.expenseCell && !col.bool && !col.badge && !col.currency && !col.totalCalc
        ? String(row[col.key] ?? '')
        : '';
      html += `<td style="${cellStyle}" title="${esc(rawVal)}">`;

      if (col.key === '_index') {
        html += `<span style="color:var(--ink-ghost);">${idx + 1}</span>`;

      } else if (col.totalCalc) {
        const items = row.expense_items || [];
        const total = items.reduce((s, x) => s + parseFloat(x.amount || 0), 0);
        html += total > 0
          ? `<strong>Php ${total.toLocaleString('en-PH',{minimumFractionDigits:2})}</strong>`
          : '<span style="color:var(--ink-ghost);">—</span>';

      } else if (col.expenseCell) {
        const items = row[col.key] || [];
        if (items.length === 0) {
          html += '<span style="color:var(--ink-ghost);">—</span>';
        } else {
          html += '<div style="white-space:normal;min-width:260px;">';
          html += '<table style="width:100%;border-collapse:collapse;font-size:.72rem;">';
          html += '<tr style="background:var(--ivory-warm);">'
            + '<th style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);text-align:left;">Payee</th>'
            + '<th style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);text-align:left;">Description</th>'
            + '<th style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);text-align:right;">Qty</th>'
            + '<th style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);text-align:right;">Unit Cost</th>'
            + '<th style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);text-align:right;">Amount</th>'
            + '</tr>';
          items.forEach(item => {
            const amt = parseFloat(item.amount || 0);
            const uc  = parseFloat(item.unit_cost || 0);
            html += `<tr>
              <td style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);">${esc(item.payee||'')}</td>
              <td style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);">${esc(item.description||'')}</td>
              <td style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);text-align:right;">${esc(String(item.quantity||''))}</td>
              <td style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);text-align:right;">${uc>0?'Php '+uc.toLocaleString('en-PH',{minimumFractionDigits:2}):''}</td>
              <td style="padding:.2rem .4rem;border:1px solid var(--ivory-deep);text-align:right;">${amt>0?'Php '+amt.toLocaleString('en-PH',{minimumFractionDigits:2}):''}</td>
            </tr>`;
          });
          html += '</table></div>';
        }

      } else if (col.array) {
        const arr = Array.isArray(row[col.key]) ? row[col.key] : [];
        html += arr.length
          ? '<div style="display:flex;flex-wrap:wrap;gap:.2rem;white-space:normal;">'
            + arr.map(t => `<span class="badge badge-maroon" style="font-size:.65rem;">${esc(t)}</span>`).join('')
            + '</div>'
          : '<span style="color:var(--ink-ghost);">—</span>';

      } else if (col.badge) {
        const v = row[col.key];
        html += v
          ? `<span class="badge badge-${col.badge}" style="font-size:.68rem;">${esc(v)}</span>`
          : '<span style="color:var(--ink-ghost);">—</span>';

      } else if (col.bool) {
        html += row[col.key]
          ? '<span class="badge badge-green" style="font-size:.65rem;">Yes</span>'
          : '<span style="color:var(--ink-ghost);font-size:.72rem;">No</span>';

      } else if (col.currency) {
        const num = parseFloat(row[col.key] || 0);
        html += num > 0
          ? `<span style="font-weight:600;">Php ${num.toLocaleString('en-PH',{minimumFractionDigits:2})}</span>`
          : '<span style="color:var(--ink-ghost);">—</span>';

      } else if (col.pre) {
        const v = row[col.key] || '';
        html += v ? `<span>${esc(v)}</span>` : '<span style="color:var(--ink-ghost);">—</span>';

      } else {
        const v = row[col.key] ?? '';
        html += v !== '' ? `<span>${esc(String(v))}</span>` : '<span style="color:var(--ink-ghost);">—</span>';
      }

      html += '</td>';
    });

    html += '</tr>';
  });

  html += '</tbody></table></div>';
  document.getElementById('recordsModalContent').innerHTML = html;
}

function esc(str) {
  return String(str ?? '')
    .replace(/&/g,'&amp;')
    .replace(/</g,'&lt;')
    .replace(/>/g,'&gt;')
    .replace(/"/g,'&quot;');
}

/* ── MOV modal ── */
let _movFileUrl = null, _movFileName = null;

function openMovModal(uploadUrl, fileUrl, fileName, recordId) {
  document.getElementById('movUploadForm').action = uploadUrl;
  document.getElementById('mov_record_id').value  = recordId;

  const ex = document.getElementById('movExisting');
  const nm = document.getElementById('movName');
  const pb = document.getElementById('movPreviewBtn');

  if (fileUrl) {
    ex.style.display = 'block';
    nm.textContent = fileName || '';
    _movFileUrl = fileUrl; _movFileName = fileName || '';
    pb.onclick = () => openMovPreview(_movFileUrl, _movFileName);
  } else {
    ex.style.display = 'none';
    _movFileUrl = null; _movFileName = null;
    pb.onclick = null;
  }

  openModal('movModal');
}

/* ── MOV preview ── */
function openMovPreview(url, fileName) {
  const frame   = document.getElementById('movPreviewFrame');
  const imgCon  = document.getElementById('movImageContainer');
  const img     = document.getElementById('movPreviewImage');
  const unsupp  = document.getElementById('movUnsupported');
  const dlBtn   = document.getElementById('movDownloadBtn');
  const titleEl = document.getElementById('movPreviewTitle');

  frame.style.display = 'none'; frame.src = '';
  imgCon.style.display = 'none'; img.src = '';
  unsupp.style.display = 'none';

  const name = fileName || url.split('/').pop() || 'file';
  const ext  = name.split('.').pop().toLowerCase();
  titleEl.textContent = '📎 ' + name;
  dlBtn.href = url;

  const imageExts  = ['jpg','jpeg','png','gif','webp','bmp','svg'];
  const officeExts = ['doc','docx','xls','xlsx','ppt','pptx','odt','ods'];

  if (imageExts.includes(ext)) {
    imgCon.style.display = 'flex'; img.src = url;
  } else if (ext === 'pdf') {
    frame.style.display = 'block'; frame.src = url;
  } else if (officeExts.includes(ext)) {
    frame.style.display = 'block';
    frame.src = `https://docs.google.com/gview?url=${encodeURIComponent(window.location.origin + url)}&embedded=true`;
  } else {
    unsupp.style.display = 'flex';
    document.getElementById('movUnsupportedName').textContent = name;
    document.getElementById('movUnsupportedDownload').href = url;
  }

  document.getElementById('movPreviewModal')?.classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeMovPreview() {
  const m = document.getElementById('movPreviewModal');
  m?.classList.remove('active');
  document.getElementById('movPreviewFrame').src = '';
  document.getElementById('movPreviewFrame').style.display = 'none';
  document.getElementById('movPreviewImage').src = '';
  document.getElementById('movImageContainer').style.display = 'none';
  document.getElementById('movUnsupported').style.display = 'none';
  document.body.style.overflow = '';
}

/* ── Global Escape key ── */
document.addEventListener('keydown', function(e) {
  if (e.key !== 'Escape') return;
  closeModal('viewModal');
  closeModal('editModal');
  closeModal('genericViewModal');
  closeModal('createModal');
  closeModal('genericFormModal');
  closeModal('movModal');
  closePrintModal();
  closeMovPreview();
  closeRecordsModal();
});

/* ── Loading helper ── */
function loadingHtml() {
  return '<p style="padding:2rem;color:var(--ink-faint);text-align:center;">Loading...</p>';
}

/* ── On page load ── */
document.addEventListener('DOMContentLoaded', function() {
  const params = new URLSearchParams(location.search);
  switchTab(params.get('tab') || 'participation');

  // Init flatpickr on all quick-add date fields on the page
  initDatePickers(document);

  // Re-open MOV modal if validation failed
  const failedId = @json(old('mov_record_id'));
  if (failedId) {
    document.querySelector(`[data-mov-btn="${failedId}"]`)?.click();
  }

  // Keep form modal open if validation failed
  const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
  const oldInput  = @json(old());

  if (hasErrors) {
    const looksLikeParticipation =
      oldInput.participant_name || oldInput.title || oldInput.intervention_date || oldInput.level;
    const looksLikeTravel =
      oldInput.travel_dates || oldInput.places_visited || oldInput.chargeable_against || oldInput.employee_names || oldInput.emp_names;

    if (looksLikeParticipation) {
      switchTab('participation');
      openCreateModal();
    } else if (looksLikeTravel) {
      switchTab('travel');
      openFormModal('travel', '✈️ New Authority to Travel');
    }
  }
});
</script>
@endpush