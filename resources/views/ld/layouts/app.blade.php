<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'BatStateU L&D Requests')</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
<style>
/* ── Reset & Variables ───────────────────────────────────────────────────── */
:root {
  --maroon:       #8B1A2B;
  --maroon-dark:  #6B1220;
  --maroon-light: #c4314a;
  --gold:         #C8922A;
  --gold-light:   #f5dea0;
  --cream:        #FDF8F3;
  --warm-white:   #FFFCF8;
  --gray-100:     #F5F1ED;
  --gray-200:     #E8E2DA;
  --gray-300:     #CCC4B8;
  --gray-500:     #8A7F72;
  --gray-700:     #4A4139;
  --gray-900:     #1E1A16;
  --shadow:       0 4px 24px rgba(139,26,43,.10);
}
*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { font-family:'DM Sans',sans-serif; background:var(--cream); color:var(--gray-900); min-height:100vh; }

/* ── Utility ─────────────────────────────────────────────────────────────── */
.text-muted  { color:var(--gray-500); }
.text-maroon { color:var(--maroon); }
.text-sm     { font-size:.85rem; }
.text-xs     { font-size:.75rem; }
.fw-600      { font-weight:600; }
.mt-1  { margin-top:.5rem; }
.mt-2  { margin-top:1rem; }
.mt-3  { margin-top:1.5rem; }
.mb-1  { margin-bottom:.5rem; }
.mb-2  { margin-bottom:1rem; }
.d-flex { display:flex; }
.gap-1  { gap:.5rem; }
.gap-2  { gap:1rem; }
.align-center { align-items:center; }
.justify-between { justify-content:space-between; }
.flex-wrap { flex-wrap:wrap; }

/* ── Header ──────────────────────────────────────────────────────────────── */
.app-header {
  background:var(--maroon); height:74px; padding:0 2rem;
  display:flex; align-items:center; justify-content:space-between;
  position:sticky; top:0; z-index:200;
  box-shadow:0 2px 12px rgba(0,0,0,.2);
}
.brand { display:flex; align-items:center; gap:.85rem; text-decoration:none; }
.brand-icon {
  width:52px; height:52px; border-radius:50%;
  overflow:hidden; flex-shrink:0;
  background:white;
  display:flex; align-items:center; justify-content:center;
  box-shadow: 0 0 0 2px rgba(255,255,255,.3);
}
.brand-icon img {
  width:100%; height:100%; object-fit:contain;
}
.brand-text { color:white; line-height:1.2; }
.brand-text strong { display:block; font-family:'DM Serif Display',serif; font-size:1rem; }
.brand-text small  { font-size:.65rem; color:rgba(255,255,255,.6); letter-spacing:.07em; text-transform:uppercase; }

.header-nav { display:flex; gap:.25rem; }
.nav-link {
  padding:.45rem 1.1rem; border-radius:6px; color:rgba(255,255,255,.75);
  text-decoration:none; font-size:.85rem; font-weight:500;
  transition:all .2s;
}
.nav-link:hover { background:rgba(255,255,255,.12); color:white; }
.nav-link.active { background:rgba(255,255,255,.2); color:white; }

/* ── Page wrapper ────────────────────────────────────────────────────────── */
.page { max-width:1080px; margin:0 auto; padding:2.5rem 1.5rem 5rem; }
.page-wide { max-width:1280px; }

/* ── Cards ───────────────────────────────────────────────────────────────── */
.card {
  background:white; border-radius:14px;
  box-shadow:var(--shadow); overflow:hidden;
}
.card-section {
  padding:1.6rem 2rem; border-bottom:1px solid var(--gray-100);
}
.card-section:last-child { border-bottom:none; }

.section-label {
  font-size:.68rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase;
  color:var(--maroon); margin-bottom:1.2rem;
  display:flex; align-items:center; gap:.6rem;
}
.section-label::after { content:''; flex:1; height:1px; background:var(--gold-light); }

/* ── Form fields ─────────────────────────────────────────────────────────── */
.field-grid   { display:grid; gap:1rem; }
.cols-2 { grid-template-columns:1fr 1fr; }
.cols-3 { grid-template-columns:1fr 1fr 1fr; }
.span-2 { grid-column:span 2; }
.span-3 { grid-column:span 3; }

.field { display:flex; flex-direction:column; gap:.35rem; }
.field label {
  font-size:.775rem; font-weight:600; color:var(--gray-700); letter-spacing:.01em;
}
.field label .req { color:var(--maroon-light); margin-left:2px; }
.field label .hint {
  font-weight:400; color:var(--gray-500); font-size:.72rem; margin-left:.3rem;
}

.field input[type=text],
.field input[type=date],
.field input[type=number],
.field select,
.field textarea {
  width:100%; padding:.58rem .85rem;
  border:1.5px solid var(--gray-200); border-radius:8px;
  font-family:'DM Sans',sans-serif; font-size:.875rem; color:var(--gray-900);
  background:var(--warm-white); outline:none;
  transition:border-color .18s, box-shadow .18s;
}
.field input:focus,
.field select:focus,
.field textarea:focus {
  border-color:var(--maroon);
  box-shadow:0 0 0 3px rgba(139,26,43,.08);
  background:white;
}
.field textarea { resize:vertical; min-height:72px; }

/* Error state */
.field.has-error input,
.field.has-error select,
.field.has-error textarea { border-color:#e03c3c !important; }
.field-error { font-size:.75rem; color:#c0392b; margin-top:.2rem; }

/* ── Checkboxes / Radios ─────────────────────────────────────────────────── */
.check-group { display:flex; flex-wrap:wrap; gap:.5rem .75rem; padding-top:.1rem; }
.check-item  { display:flex; align-items:center; gap:.4rem; cursor:pointer; }
.check-item span { font-size:.85rem; color:var(--gray-700); }
.check-item input[type=checkbox],
.check-item input[type=radio] {
  accent-color:var(--maroon); width:15px; height:15px; cursor:pointer; flex-shrink:0;
}
.others-input {
  padding:.3rem .65rem; border:1.5px solid var(--gray-200); border-radius:6px;
  font-family:'DM Sans',sans-serif; font-size:.8rem; width:140px; outline:none;
  transition:border-color .18s;
}
.others-input:focus { border-color:var(--maroon); }

/* ── Yes/No rows ─────────────────────────────────────────────────────────── */
.yn-row {
  display:grid; grid-template-columns:1fr auto;
  align-items:center; gap:1rem;
  padding:.65rem 0; border-bottom:1px solid var(--gray-100);
  font-size:.875rem; color:var(--gray-700);
}
.yn-row:last-child { border-bottom:none; }
.yn-opts { display:flex; gap:.85rem; }
.yn-opts label { display:flex; align-items:center; gap:.3rem; font-size:.85rem; font-weight:500; cursor:pointer; }

/* ── Financial box ───────────────────────────────────────────────────────── */
.fin-box {
  background:var(--gray-100); border-radius:10px;
  padding:1.1rem 1.25rem; margin-top:.85rem;
}

/* ── Signatories ─────────────────────────────────────────────────────────── */
.sig-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
.sig-box {
  border:1.5px solid var(--gray-200); border-radius:10px;
  padding:1rem 1.1rem; background:var(--warm-white);
}
.sig-role     { font-size:.68rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--gold); margin-bottom:.3rem; }
.sig-name     { font-family:'DM Serif Display',serif; font-size:.95rem; color:var(--maroon); margin-bottom:.1rem; }
.sig-position { font-size:.78rem; color:var(--gray-500); margin-bottom:.6rem; }

/* ── Buttons ─────────────────────────────────────────────────────────────── */
.btn {
  display:inline-flex; align-items:center; gap:.4rem;
  padding:.6rem 1.4rem; border-radius:8px; font-family:'DM Sans',sans-serif;
  font-size:.875rem; font-weight:600; cursor:pointer; border:none;
  text-decoration:none; transition:all .2s; white-space:nowrap;
}
.btn-primary { background:var(--maroon); color:white; }
.btn-primary:hover { background:var(--maroon-dark); box-shadow:0 4px 12px rgba(139,26,43,.3); }
.btn-outline { background:white; color:var(--maroon); border:1.5px solid var(--maroon); }
.btn-outline:hover { background:var(--maroon); color:white; }
.btn-gold { background:var(--gold); color:white; }
.btn-gold:hover { background:#a87620; }
.btn-ghost { background:transparent; color:var(--gray-700); border:1.5px solid var(--gray-200); }
.btn-ghost:hover { background:var(--gray-100); }
.btn-danger { background:#c0392b; color:white; }
.btn-danger:hover { background:#a93226; }
.btn-sm { padding:.38rem .85rem; font-size:.8rem; }

.form-actions {
  padding:1.4rem 2rem; background:var(--gray-100);
  display:flex; justify-content:flex-end; gap:.75rem;
}

/* ── Badges ──────────────────────────────────────────────────────────────── */
.badge {
  display:inline-block; padding:.18rem .65rem; border-radius:20px;
  font-size:.72rem; font-weight:700; letter-spacing:.03em;
}
.badge-maroon   { background:rgba(139,26,43,.1); color:var(--maroon); }
.badge-gold     { background:rgba(200,146,42,.14); color:#7A5A10; }
.badge-pending  { background:#FFF3CD; color:#856404; }
.badge-reviewed { background:#D1ECF1; color:#0c5460; }
.badge-approved { background:#D4EDDA; color:#155724; }
.badge-rejected { background:#F8D7DA; color:#721c24; }
.badge-green    { background:rgba(30,130,76,.1); color:#1a6b3c; }

/* ── Alerts / Flash ──────────────────────────────────────────────────────── */
.alert {
  padding:.85rem 1.25rem; border-radius:10px;
  font-size:.875rem; margin-bottom:1.5rem; display:flex; gap:.6rem; align-items:flex-start;
}
.alert-success { background:#D4EDDA; color:#155724; border:1px solid #c3e6cb; }
.alert-error   { background:#F8D7DA; color:#721c24; border:1px solid #f5c6cb; }

/* ── Table ───────────────────────────────────────────────────────────────── */
.table-wrap { border-radius:14px; overflow:hidden; box-shadow:var(--shadow); }
.data-table { width:100%; border-collapse:collapse; background:white; }
.data-table thead tr { background:var(--maroon); }
.data-table thead th {
  padding:.8rem 1rem; text-align:left;
  font-size:.7rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase;
  color:rgba(255,255,255,.85); white-space:nowrap;
}
.data-table tbody tr { border-bottom:1px solid var(--gray-100); transition:background .12s; }
.data-table tbody tr:hover { background:var(--cream); }
.data-table tbody td { padding:.75rem 1rem; font-size:.855rem; vertical-align:middle; }
.data-table tbody td.muted { color:var(--gray-500); font-size:.8rem; }

/* ── Search bar ──────────────────────────────────────────────────────────── */
.search-bar input {
  padding:.55rem 1rem; border:1.5px solid var(--gray-200); border-radius:8px;
  font-family:'DM Sans',sans-serif; font-size:.875rem; width:240px; outline:none;
  background:white; transition:border-color .18s;
}
.search-bar input:focus { border-color:var(--maroon); }
.filter-select {
  padding:.55rem .9rem; border:1.5px solid var(--gray-200); border-radius:8px;
  font-family:'DM Sans',sans-serif; font-size:.875rem; outline:none;
  background:white; cursor:pointer; color:var(--gray-700);
  transition:border-color .18s;
}
.filter-select:focus { border-color:var(--maroon); }

/* ── Detail Grid (show page) ─────────────────────────────────────────────── */
.detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem 2rem; }
.detail-field .dlabel {
  font-size:.7rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase;
  color:var(--gray-500); margin-bottom:.2rem;
}
.detail-field .dval { font-size:.9rem; color:var(--gray-900); }

/* ── Pagination ──────────────────────────────────────────────────────────── */
.pagination { display:flex; gap:.3rem; justify-content:center; margin-top:1.5rem; }
.pagination .page-item a,
.pagination .page-item span {
  display:block; padding:.4rem .7rem; border-radius:6px; font-size:.82rem;
  border:1.5px solid var(--gray-200); color:var(--gray-700); text-decoration:none;
  transition:all .15s;
}
.pagination .page-item.active span { background:var(--maroon); border-color:var(--maroon); color:white; }
.pagination .page-item a:hover { background:var(--maroon); border-color:var(--maroon); color:white; }

/* ── Empty state ─────────────────────────────────────────────────────────── */
.empty-state {
  text-align:center; padding:4rem 2rem; color:var(--gray-500); background:white;
}
.empty-state .empty-icon { font-size:3rem; opacity:.35; margin-bottom:1rem; }
.empty-state p { font-size:.9rem; }

/* ── Ref badge ───────────────────────────────────────────────────────────── */
.ref-badge {
  display:inline-block; background:var(--gold-light); color:var(--maroon-dark);
  border:1px solid var(--gold); font-size:.72rem; font-weight:700; letter-spacing:.05em;
  padding:.25rem .8rem; border-radius:20px;
}

/* ── Responsive ──────────────────────────────────────────────────────────── */
@media(max-width:768px) {
  .cols-2,.cols-3,.sig-grid,.detail-grid { grid-template-columns:1fr; }
  .span-2,.span-3 { grid-column:span 1; }
  .page { padding:1.5rem 1rem 4rem; }
  .app-header { padding:0 1rem; }
  .card-section { padding:1.2rem 1.1rem; }
  .form-actions { flex-direction:column-reverse; }
}

/* ── Print styles ────────────────────────────────────────────────────────── */
@media print {
  .no-print { display:none !important; }
  .app-header { display:none !important; }
  body { background:white; }
  .page { padding:0; max-width:none; }
  .card { box-shadow:none; border-radius:0; }
}
</style>
@stack('styles')
</head>
<body>

<header class="app-header no-print">
  <a class="brand" href="{{ route('ld.index') }}">
    <div class="brand-icon">
      @php $logoPath = public_path('images/batstateu-logo.png'); @endphp
      @if(file_exists($logoPath))
        <img src="{{ asset('images/batstateu-logo.png') }}" alt="BatStateU Logo">
      @else
        <span style="font-family:'DM Serif Display',serif; color:var(--maroon); font-size:13px; font-weight:700;">BSU</span>
      @endif
    </div>
    <div class="brand-text">
      <strong>Batangas State University</strong>
      <small>Research Management Services</small>
    </div>
  </a>

</header>

<main>
  @yield('content')
</main>

@stack('scripts')
</body>
</html>