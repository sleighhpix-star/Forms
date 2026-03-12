<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'BatStateU L&D Requests')</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --crimson:        #7C1533;
  --crimson-deep:   #5C0E24;
  --crimson-mid:    #9B1D3F;
  --crimson-soft:   #B8264E;
  --crimson-glow:   rgba(124,21,51,.12);
  --gold:           #B8832A;
  --gold-light:     #D4A855;
  --gold-pale:      #F5E6C8;
  --gold-shimmer:   rgba(184,131,42,.2);
  --ivory:          #FDFAF5;
  --ivory-warm:     #FAF5EC;
  --ivory-deep:     #EDE6D8;
  --ink:            #1A1210;
  --ink-mid:        #3D2E28;
  --ink-soft:       #6B5B52;
  --ink-faint:      #9B8E87;
  --ink-ghost:      #C8C0BB;
  --surface:        #FFFFFF;
  --surface-raised: #FEFCF9;
  --surface-sunken: #F7F2EC;
  --border:         rgba(124,21,51,.08);
  --border-gold:    rgba(184,131,42,.25);
  --shadow-xs:  0 1px 3px rgba(26,18,16,.06);
  --shadow-sm:  0 2px 8px rgba(26,18,16,.08), 0 1px 2px rgba(26,18,16,.04);
  --shadow-md:  0 4px 20px rgba(124,21,51,.1), 0 1px 4px rgba(26,18,16,.05);
  --shadow-lg:  0 8px 40px rgba(124,21,51,.14), 0 2px 8px rgba(26,18,16,.06);
  --shadow-xl:  0 20px 60px rgba(124,21,51,.18), 0 4px 16px rgba(26,18,16,.08);
  --radius-sm:  6px;
  --radius-md:  10px;
  --radius-lg:  16px;
  --radius-xl:  20px;
  --font-display: 'Playfair Display', Georgia, serif;
  --font-body:    'Plus Jakarta Sans', system-ui, sans-serif;
  --transition: all .2s cubic-bezier(.4,0,.2,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:var(--font-body);background:var(--ivory);color:var(--ink);min-height:100vh;-webkit-font-smoothing:antialiased;background-image:radial-gradient(ellipse 80% 50% at 50% -20%,rgba(124,21,51,.04) 0%,transparent 60%)}

/* ── Utility ── */
.text-muted{color:var(--ink-faint)}.text-crimson{color:var(--crimson)}.text-sm{font-size:.85rem}.text-xs{font-size:.75rem}.fw-600{font-weight:600}
.mt-1{margin-top:.5rem}.mt-2{margin-top:1rem}.mt-3{margin-top:1.5rem}.mb-1{margin-bottom:.5rem}.mb-2{margin-bottom:1rem}
.d-flex{display:flex}.gap-1{gap:.5rem}.gap-2{gap:1rem}.align-center{align-items:center}.justify-between{justify-content:space-between}.flex-wrap{flex-wrap:wrap}

/* ── Header ── */
.app-header{
  background:var(--crimson-deep);
  background-image:linear-gradient(135deg,#4A0B1C 0%,#6B1228 40%,#7C1533 70%,#8E1B3C 100%);
  height:68px;padding:0 2.5rem;
  display:flex;align-items:center;justify-content:space-between;
  position:sticky;top:0;z-index:200;
  box-shadow:0 1px 0 rgba(255,255,255,.06),0 4px 24px rgba(0,0,0,.3);
}
.app-header::after{
  content:'';position:absolute;bottom:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent 0%,var(--gold) 30%,var(--gold-light) 50%,var(--gold) 70%,transparent 100%);
  opacity:.6;
}
.brand{display:flex;align-items:center;gap:1rem;text-decoration:none}
.brand-icon{width:44px;height:44px;border-radius:50%;overflow:hidden;background:white;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 0 0 2px rgba(255,255,255,.15),0 2px 8px rgba(0,0,0,.3)}
.brand-icon img{width:100%;height:100%;object-fit:contain}
.brand-text{color:white;line-height:1.25}
.brand-text strong{display:block;font-family:var(--font-display);font-size:.975rem;font-weight:600;letter-spacing:.01em;color:#fff}
.brand-text small{font-size:.62rem;color:var(--gold-pale);letter-spacing:.12em;text-transform:uppercase;opacity:.8}
.header-divider{width:1px;height:28px;background:rgba(255,255,255,.12);margin:0 .75rem}
.nav-link{padding:.4rem .9rem;border-radius:var(--radius-sm);color:rgba(255,255,255,.65);text-decoration:none;font-size:.8rem;font-weight:500;transition:var(--transition);letter-spacing:.01em}
.nav-link:hover{background:rgba(255,255,255,.1);color:white}
.nav-link.active{background:rgba(255,255,255,.15);color:white}

/* ── Page wrapper ── */
.page{max-width:1100px;margin:0 auto;padding:2.5rem 1.75rem 5rem}
.page-wide{max-width:1320px}

/* ── Cards ── */
.card{background:var(--surface);border-radius:var(--radius-lg);box-shadow:var(--shadow-md);overflow:hidden;border:1px solid var(--border)}
.card-section{padding:1.75rem 2rem;border-bottom:1px solid var(--ivory-deep)}
.card-section:last-child{border-bottom:none}
.section-label{font-size:.67rem;font-weight:700;letter-spacing:.13em;text-transform:uppercase;color:var(--crimson);margin-bottom:1.25rem;display:flex;align-items:center;gap:.65rem}
.section-label::before{content:'';width:3px;height:14px;background:linear-gradient(to bottom,var(--gold-light),var(--gold));border-radius:2px;flex-shrink:0}
.section-label::after{content:'';flex:1;height:1px;background:linear-gradient(to right,var(--gold-pale),transparent)}

/* ── Form fields ── */
.field-grid{display:grid;gap:1.1rem}
.cols-2{grid-template-columns:1fr 1fr}.cols-3{grid-template-columns:1fr 1fr 1fr}
.span-2{grid-column:span 2}.span-3{grid-column:span 3}
.field{display:flex;flex-direction:column;gap:.3rem}
.field label{font-size:.75rem;font-weight:600;color:var(--ink-mid);letter-spacing:.02em}
.field label .req{color:var(--crimson-soft);margin-left:2px}
.field label .hint{font-weight:400;color:var(--ink-faint);font-size:.7rem;margin-left:.3rem}
.field input[type=text],.field input[type=date],.field input[type=number],.field select,.field textarea{
  width:100%;padding:.6rem .9rem;border:1.5px solid var(--ivory-deep);border-radius:var(--radius-md);
  font-family:var(--font-body);font-size:.875rem;color:var(--ink);background:var(--surface-raised);
  outline:none;transition:border-color .18s,box-shadow .18s,background .18s
}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--crimson);box-shadow:0 0 0 3px var(--crimson-glow);background:white}
.field textarea{resize:vertical;min-height:76px}
.field.has-error input,.field.has-error select,.field.has-error textarea{border-color:#dc2626!important}
.field-error{font-size:.73rem;color:#dc2626;margin-top:.2rem}

/* ── Checkboxes/Radios ── */
.check-group{display:flex;flex-wrap:wrap;gap:.5rem .65rem;padding-top:.15rem}
.check-item{display:flex;align-items:center;gap:.4rem;cursor:pointer}
.check-item span{font-size:.845rem;color:var(--ink-mid)}
.check-item input[type=checkbox],.check-item input[type=radio]{accent-color:var(--crimson);width:15px;height:15px;cursor:pointer;flex-shrink:0}
.others-input{padding:.32rem .65rem;border:1.5px solid var(--ivory-deep);border-radius:var(--radius-sm);font-family:var(--font-body);font-size:.8rem;width:150px;outline:none;transition:border-color .18s;background:var(--surface-raised)}
.others-input:focus{border-color:var(--crimson)}

/* ── Yes/No ── */
.yn-row{display:grid;grid-template-columns:1fr auto;align-items:center;gap:1rem;padding:.7rem 0;border-bottom:1px solid var(--ivory-deep);font-size:.875rem;color:var(--ink-mid)}
.yn-row:last-child{border-bottom:none}
.yn-opts{display:flex;gap:.85rem}
.yn-opts label{display:flex;align-items:center;gap:.3rem;font-size:.845rem;font-weight:500;cursor:pointer}

/* ── Financial box ── */
.fin-box{background:linear-gradient(135deg,var(--ivory-warm),var(--ivory-deep));border-radius:var(--radius-md);border:1px solid var(--gold-pale);padding:1.1rem 1.35rem;margin-top:.9rem}

/* ── Signatories ── */
.sig-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.sig-box{border:1.5px solid var(--ivory-deep);border-radius:var(--radius-md);padding:1rem 1.15rem;background:var(--surface-raised);transition:border-color .2s}
.sig-box:focus-within{border-color:var(--gold)}
.sig-role{font-size:.64rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--gold);margin-bottom:.35rem}
.sig-name{font-family:var(--font-display);font-size:.95rem;color:var(--crimson);margin-bottom:.1rem}
.sig-position{font-size:.78rem;color:var(--ink-soft);margin-bottom:.6rem}

/* ── Buttons ── */
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.58rem 1.35rem;border-radius:var(--radius-md);font-family:var(--font-body);font-size:.855rem;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:var(--transition);white-space:nowrap;letter-spacing:.01em}
.btn-primary{background:linear-gradient(135deg,var(--crimson-mid),var(--crimson));color:white;box-shadow:0 2px 8px rgba(124,21,51,.25)}
.btn-primary:hover{background:linear-gradient(135deg,var(--crimson),var(--crimson-deep));box-shadow:0 4px 16px rgba(124,21,51,.4);transform:translateY(-1px)}
.btn-outline{background:white;color:var(--crimson);border:1.5px solid var(--crimson)}
.btn-outline:hover{background:var(--crimson);color:white;transform:translateY(-1px);box-shadow:0 4px 12px rgba(124,21,51,.25)}
.btn-gold{background:linear-gradient(135deg,var(--gold-light),var(--gold));color:white;box-shadow:0 2px 8px rgba(184,131,42,.25)}
.btn-gold:hover{background:linear-gradient(135deg,var(--gold),#8B6018);transform:translateY(-1px);box-shadow:0 4px 14px rgba(184,131,42,.4)}
.btn-ghost{background:transparent;color:var(--ink-soft);border:1.5px solid var(--ivory-deep)}
.btn-ghost:hover{background:var(--ivory-deep);color:var(--ink-mid)}
.btn-danger{background:#dc2626;color:white}
.btn-danger:hover{background:#b91c1c;transform:translateY(-1px)}
.btn-sm{padding:.36rem .85rem;font-size:.785rem;border-radius:var(--radius-sm)}
.form-actions{padding:1.35rem 2rem;background:linear-gradient(to bottom,var(--ivory-deep),var(--ivory-warm));display:flex;justify-content:flex-end;gap:.75rem;border-top:1px solid var(--ivory-deep)}

/* ── Badges ── */
.badge{display:inline-flex;align-items:center;padding:.2rem .7rem;border-radius:20px;font-size:.7rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase}
.badge-maroon{background:rgba(124,21,51,.1);color:var(--crimson);border:1px solid rgba(124,21,51,.15)}
.badge-gold{background:rgba(184,131,42,.12);color:#7A530E;border:1px solid rgba(184,131,42,.2)}
.badge-pending{background:#FEF3C7;color:#92400E;border:1px solid #FDE68A}
.badge-reviewed{background:#DBEAFE;color:#1E40AF;border:1px solid #BFDBFE}
.badge-approved{background:#D1FAE5;color:#065F46;border:1px solid #A7F3D0}
.badge-rejected{background:#FEE2E2;color:#991B1B;border:1px solid #FECACA}
.badge-green{background:rgba(5,150,105,.1);color:#065F46;border:1px solid rgba(5,150,105,.2)}

/* ── Alerts ── */
.alert{padding:.9rem 1.25rem;border-radius:var(--radius-md);font-size:.875rem;margin-bottom:1.5rem;display:flex;gap:.65rem;align-items:flex-start}
.alert-success{background:#D1FAE5;color:#065F46;border:1px solid #A7F3D0}
.alert-error{background:#FEE2E2;color:#991B1B;border:1px solid #FECACA}

/* ── Table ── */
.table-wrap{border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-sm);border:1px solid var(--border)}
.data-table{width:100%;border-collapse:collapse;background:white}
.data-table thead tr{background:linear-gradient(135deg,var(--crimson-deep) 0%,var(--crimson) 100%)}
.data-table thead th{padding:.9rem 1.1rem;text-align:left;font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.88);white-space:nowrap}
.data-table tbody tr{border-bottom:1px solid var(--ivory-deep);transition:background .15s}
.data-table tbody tr:last-child{border-bottom:none}
.data-table tbody tr:hover{background:#FDF7F8}
.data-table tbody td{padding:.85rem 1.1rem;font-size:.845rem;vertical-align:middle}
.data-table tbody td.muted{color:var(--ink-faint);font-size:.8rem}

/* ── Search/Filter ── */
.search-bar input{padding:.55rem 1rem;border:1.5px solid var(--ivory-deep);border-radius:var(--radius-md);font-family:var(--font-body);font-size:.875rem;width:240px;outline:none;background:white;transition:border-color .18s,box-shadow .18s}
.search-bar input:focus{border-color:var(--crimson);box-shadow:0 0 0 3px var(--crimson-glow)}
.filter-select{padding:.55rem .9rem;border:1.5px solid var(--ivory-deep);border-radius:var(--radius-md);font-family:var(--font-body);font-size:.875rem;outline:none;background:white;cursor:pointer;color:var(--ink-mid);transition:border-color .18s}
.filter-select:focus{border-color:var(--crimson)}

/* ── Detail grid ── */
.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:.9rem 2rem}
.detail-field .dlabel{font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:.25rem}
.detail-field .dval{font-size:.9rem;color:var(--ink)}

/* ── Pagination ── */
.pagination{display:flex;gap:.3rem;justify-content:center;margin-top:1.5rem}
.pagination .page-item a,.pagination .page-item span{display:block;padding:.42rem .75rem;border-radius:var(--radius-sm);font-size:.8rem;border:1.5px solid var(--ivory-deep);color:var(--ink-mid);text-decoration:none;transition:var(--transition)}
.pagination .page-item.active span{background:var(--crimson);border-color:var(--crimson);color:white}
.pagination .page-item a:hover{background:var(--crimson);border-color:var(--crimson);color:white}

/* ── Empty state ── */
.empty-state{text-align:center;padding:4.5rem 2rem;color:var(--ink-faint);background:white}
.empty-state .empty-icon{font-size:2.75rem;opacity:.25;margin-bottom:1rem;display:block}
.empty-state p{font-size:.9rem;margin-bottom:.5rem}

/* ── Ref badge ── */
.ref-badge{display:inline-flex;align-items:center;gap:.3rem;background:var(--gold-pale);color:var(--crimson-deep);border:1px solid var(--border-gold);font-size:.7rem;font-weight:700;letter-spacing:.06em;padding:.28rem .85rem;border-radius:20px;font-family:var(--font-body)}

/* ── Responsive ── */
@media(max-width:768px){
  .cols-2,.cols-3,.sig-grid,.detail-grid{grid-template-columns:1fr}
  .span-2,.span-3{grid-column:span 1}
  .page{padding:1.5rem 1rem 4rem}
  .app-header{padding:0 1.25rem}
  .card-section{padding:1.25rem 1.1rem}
  .form-actions{flex-direction:column-reverse}
}

/* ── Print ── */
@media print{
  .no-print{display:none!important}
  .app-header{display:none!important}
  body{background:white}
  .page{padding:0;max-width:none}
  .card{box-shadow:none;border-radius:0;border:none}
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
        <span style="font-family:var(--font-display);color:var(--crimson);font-size:13px;font-weight:700;">BSU</span>
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

<footer class="no-print" style="text-align:center;padding:1.25rem 2rem;font-size:.72rem;color:var(--ink-ghost);border-top:1px solid var(--ivory-deep);background:var(--surface);letter-spacing:.04em;">
  &copy; {{ date('Y') }} &nbsp;&middot;&nbsp; Batangas State University &nbsp;&middot;&nbsp; Research Management Services &nbsp;&middot;&nbsp; L&amp;D Request System
</footer>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  if (window.flatpickr) {
    flatpickr('.date-picker',       { dateFormat: 'F j, Y', allowInput: true });
    flatpickr('.date-picker-multi', { mode: 'multiple', dateFormat: 'F j, Y', allowInput: true });
    flatpickr('.date-picker-range', { mode: 'range',    dateFormat: 'F j, Y', allowInput: true });
  }
});
</script>
@stack('scripts')
</body>
</html>