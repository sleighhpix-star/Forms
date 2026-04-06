<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'BatStateU — L&D Requests')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Geist:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
:root {
  --c:        #7C1533;
  --c-dk:     #5C0E24;
  --c-md:     #9B1D3F;
  --c-lt:     rgba(124,21,51,.06);
  --c-ring:   rgba(124,21,51,.14);
  --g:        #B5832A;
  --g-lt:     #D4A84C;
  --g-pale:   #F7EDD8;
  --bg:       #F7F4EF;
  --surface:  #FFFFFF;
  --surface-2:#FDFAF6;
  --border:   #E8E0D3;
  --border-sm:#F0E8DC;
  --ink:      #1C1410;
  --ink-2:    #3E3028;
  --ink-3:    #6E5E54;
  --ink-4:    #9D8E87;
  --ink-5:    #C4B8B2;
  --green:    #15803d; --green-bg:#dcfce7; --green-bd:#86efac;
  --amber:    #92400e; --amber-bg:#fef3c7; --amber-bd:#fde68a;
  --red:      #991b1b; --red-bg:#fee2e2;   --red-bd:#fecaca;
  --blue:     #1e40af; --blue-bg:#dbeafe;  --blue-bd:#bfdbfe;
  --f-display:'DM Serif Display', Georgia, serif;
  --f-body:   'Geist', system-ui, sans-serif;
  --r-sm:6px; --r-md:10px; --r-lg:14px; --r-xl:18px; --r-2xl:24px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:var(--f-body);font-size:15px;line-height:1.6;color:var(--ink);background:var(--bg);min-height:100vh;-webkit-font-smoothing:antialiased}
h1,h2,h3{font-family:var(--f-display);line-height:1.25}
.display{font-family:var(--f-display)}
.text-muted{color:var(--ink-4)}.text-sm{font-size:.875rem}.text-xs{font-size:.75rem}.text-crimson{color:var(--c)}
.fw-500{font-weight:500}.fw-600{font-weight:600}
.d-flex{display:flex}.align-center{align-items:center}.justify-between{justify-content:space-between}.flex-wrap{flex-wrap:wrap}
.gap-1{gap:.5rem}.gap-2{gap:1rem}.mt-1{margin-top:.5rem}.mt-2{margin-top:1rem}.mb-1{margin-bottom:.5rem}.mb-2{margin-bottom:1rem}

/* HEADER */
.app-header{position:sticky;top:0;z-index:300;height:60px;background:var(--c-dk);display:flex;align-items:center;padding:0 2rem;gap:1rem;box-shadow:0 1px 0 rgba(255,255,255,.05),0 2px 12px rgba(0,0,0,.18)}
.app-header::after{content:'';position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent 0%,var(--g) 30%,var(--g-lt) 50%,var(--g) 70%,transparent 100%);opacity:.7}
.brand{display:flex;align-items:center;gap:.75rem;text-decoration:none;flex-shrink:0}
.brand-logo{width:36px;height:36px;border-radius:50%;background:white;overflow:hidden;display:flex;align-items:center;justify-content:center;box-shadow:0 0 0 2px rgba(255,255,255,.12)}
.brand-logo img{width:100%;height:100%;object-fit:contain}
.brand-logo span{font-family:var(--f-display);color:var(--c);font-size:13px;font-weight:700}
.brand-text{line-height:1.2}
.brand-text strong{display:block;color:#fff;font-family:var(--f-display);font-size:.95rem;font-weight:400;letter-spacing:.01em}
.brand-text small{color:var(--g-lt);font-size:.6rem;letter-spacing:.12em;text-transform:uppercase;opacity:.85}
.header-sep{width:1px;height:24px;background:rgba(255,255,255,.1);margin:0 .5rem;flex-shrink:0}
.h-nav{display:flex;align-items:center;gap:2px}
.h-nav-link{padding:.32rem .78rem;border-radius:var(--r-sm);color:rgba(255,255,255,.55);text-decoration:none;font-size:.76rem;font-weight:500;letter-spacing:.01em;transition:background .15s,color .15s}
.h-nav-link:hover{background:rgba(255,255,255,.08);color:rgba(255,255,255,.9)}
.h-nav-link.active{background:rgba(255,255,255,.12);color:#fff}
.header-spacer{flex:1}

/* PAGE CONTAINERS */
.page{max-width:1080px;margin:0 auto;padding:2.5rem 1.75rem 6rem}
.page-lg{max-width:1360px}
.page-sm{max-width:860px}

/* CARDS */
.card{background:var(--surface);border-radius:var(--r-xl);border:1px solid var(--border);overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.04),0 4px 16px rgba(0,0,0,.04)}
.card-section{padding:1.6rem 2rem;border-bottom:1px solid var(--border-sm)}
.card-section:last-child{border-bottom:none}
.section-label{font-size:.62rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin-bottom:1.1rem;display:flex;align-items:center;gap:.6rem}
.section-label::before{content:'';width:3px;height:12px;flex-shrink:0;background:linear-gradient(to bottom,var(--g-lt),var(--g));border-radius:2px}
.section-label::after{content:'';flex:1;height:1px;background:linear-gradient(to right,var(--g-pale),transparent)}

/* FORM FIELDS */
.field-grid{display:grid;gap:1rem}
.cols-2{grid-template-columns:1fr 1fr}.cols-3{grid-template-columns:1fr 1fr 1fr}
.span-2{grid-column:span 2}.span-3{grid-column:span 3}
.field{display:flex;flex-direction:column;gap:.3rem}
.field label{font-size:.72rem;font-weight:600;color:var(--ink-2);letter-spacing:.02em}
.field label .req{color:var(--c-md);margin-left:2px}
.field label .hint{font-weight:400;color:var(--ink-4);font-size:.68rem;margin-left:.3rem}
.field input[type=text],.field input[type=email],.field input[type=number],.field input[type=date],.field select,.field textarea{width:100%;padding:.6rem .9rem;border:1.5px solid var(--border);border-radius:var(--r-md);font-family:var(--f-body);font-size:.875rem;color:var(--ink);background:var(--surface-2);outline:none;transition:border-color .15s,box-shadow .15s,background .15s}
.field input:focus,.field select:focus,.field textarea:focus{border-color:var(--c);box-shadow:0 0 0 3px var(--c-ring);background:white}
.field textarea{resize:vertical;min-height:76px}
.field.has-error input,.field.has-error select,.field.has-error textarea{border-color:var(--red)!important}
.field-error{font-size:.72rem;color:var(--red);margin-top:.2rem;font-weight:500}
.is-invalid{border-color:var(--red)!important}
.check-group{display:flex;flex-wrap:wrap;gap:.4rem .6rem;padding-top:.1rem}
.check-item{display:flex;align-items:center;gap:.4rem;cursor:pointer}
.check-item span{font-size:.84rem;color:var(--ink-2)}
.check-item input[type=checkbox],.check-item input[type=radio]{accent-color:var(--c);width:15px;height:15px;cursor:pointer;flex-shrink:0}
.others-input{padding:.3rem .65rem;border:1.5px solid var(--border);border-radius:var(--r-sm);font-family:var(--f-body);font-size:.8rem;width:160px;outline:none;transition:border-color .15s;background:var(--surface-2)}
.others-input:focus{border-color:var(--c);box-shadow:0 0 0 3px var(--c-ring)}
.yn-row{display:grid;grid-template-columns:1fr auto;align-items:center;gap:1rem;padding:.65rem 0;border-bottom:1px solid var(--border-sm);font-size:.875rem;color:var(--ink-2)}
.yn-row:last-child{border-bottom:none}
.yn-opts{display:flex;gap:.75rem}
.yn-opts label{display:flex;align-items:center;gap:.3rem;font-size:.84rem;font-weight:500;cursor:pointer}
.fin-box{background:linear-gradient(135deg,var(--g-pale),#F2E9D8);border:1px solid rgba(181,131,42,.2);border-radius:var(--r-md);padding:1.1rem 1.35rem;margin-top:.9rem}

/* SIGNATORIES */
.sig-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;margin-top:.5rem}
.sig-box{border:1.5px solid var(--border);border-radius:var(--r-md);padding:.8rem 1rem;background:var(--surface-2);transition:border-color .18s,background .18s}
.sig-box:focus-within{border-color:var(--g);background:white}
.sig-role{font-size:.6rem;font-weight:600;color:var(--g);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.4rem}
.sig-field-wrap{position:relative}
.sig-name-input{width:100%;border:none;border-bottom:1.5px dashed var(--border);background:transparent;font-size:.85rem;font-weight:600;color:var(--c);padding:.15rem 1.4rem .15rem 0;outline:none;font-family:var(--f-body);transition:border-color .15s}
.sig-name-input:focus{border-bottom-color:var(--c);border-bottom-style:solid}
.sig-pos-input{width:100%;border:none;border-bottom:1px dashed var(--border-sm);background:transparent;font-size:.72rem;color:var(--ink-3);padding:.15rem 1.4rem .15rem 0;outline:none;font-family:var(--f-body);margin-top:.3rem;transition:border-color .15s}
.sig-pos-input:focus{border-bottom-color:var(--c);border-bottom-style:solid}
.sig-edit-icon{position:absolute;right:0;top:50%;transform:translateY(-50%);font-size:.65rem;color:var(--ink-5);pointer-events:none}
.sig-box:focus-within .sig-edit-icon{color:var(--c)}
.sig-reset-btn{margin-top:.5rem;font-size:.65rem;color:var(--ink-5);background:none;border:none;cursor:pointer;padding:0;text-decoration:underline;text-underline-offset:2px;font-family:var(--f-body)}
.sig-reset-btn:hover{color:var(--c)}

/* BUTTONS */
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.25rem;border-radius:var(--r-md);font-family:var(--f-body);font-size:.845rem;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap;letter-spacing:.01em}
.btn-primary{background:var(--c);color:white;box-shadow:0 1px 4px rgba(124,21,51,.2),0 2px 8px rgba(124,21,51,.12)}
.btn-primary:hover{background:var(--c-dk);box-shadow:0 2px 8px rgba(124,21,51,.3),0 4px 16px rgba(124,21,51,.16);transform:translateY(-1px)}
.btn-outline{background:white;color:var(--c);border:1.5px solid var(--c)}
.btn-outline:hover{background:var(--c);color:white;transform:translateY(-1px);box-shadow:0 2px 8px rgba(124,21,51,.2)}
.btn-gold{background:var(--g);color:white;box-shadow:0 1px 4px rgba(181,131,42,.2)}
.btn-gold:hover{background:#9A6E20;transform:translateY(-1px);box-shadow:0 2px 10px rgba(181,131,42,.3)}
.btn-ghost{background:transparent;color:var(--ink-3);border:1.5px solid var(--border)}
.btn-ghost:hover{background:var(--border-sm);color:var(--ink-2)}
.btn-danger{background:#dc2626;color:white}
.btn-danger:hover{background:#b91c1c;transform:translateY(-1px)}
.btn-sm{padding:.32rem .8rem;font-size:.77rem;border-radius:var(--r-sm)}
.form-actions{padding:1.25rem 2rem;background:var(--bg);display:flex;justify-content:flex-end;gap:.75rem;border-top:1px solid var(--border)}

/* BADGES */
.badge{display:inline-flex;align-items:center;padding:.18rem .6rem;border-radius:20px;font-size:.68rem;font-weight:600;letter-spacing:.04em;text-transform:uppercase;line-height:1}
.badge-crimson,.badge-maroon{background:rgba(124,21,51,.09);color:var(--c);border:1px solid rgba(124,21,51,.16)}
.badge-gold{background:rgba(181,131,42,.1);color:#7A530E;border:1px solid rgba(181,131,42,.22)}
.badge-green{background:var(--green-bg);color:var(--green);border:1px solid var(--green-bd)}
.badge-amber{background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-bd)}
.badge-red{background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)}
.badge-blue{background:var(--blue-bg);color:var(--blue);border:1px solid var(--blue-bd)}
.badge-neutral{background:#F0EBE3;color:var(--ink-3);border:1px solid var(--border)}

/* ALERTS & TOAST */
.alert{padding:.85rem 1.2rem;border-radius:var(--r-md);font-size:.875rem;margin-bottom:1.5rem;display:flex;gap:.6rem;align-items:flex-start}
.alert-success{background:var(--green-bg);color:var(--green);border:1px solid var(--green-bd)}
.alert-error{background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)}
.toast{position:fixed;top:20px;right:20px;z-index:99999;background:#1a2e22;color:#dcfce7;padding:.75rem 1.25rem;border-radius:var(--r-lg);font-size:.875rem;font-weight:500;display:flex;align-items:center;gap:.65rem;box-shadow:0 8px 32px rgba(0,0,0,.2);animation:toastIn .28s cubic-bezier(.34,1.4,.64,1) forwards}
@keyframes toastIn{from{opacity:0;transform:translateY(-12px) scale(.96)}to{opacity:1;transform:none}}

/* DATA TABLE */
.data-table{width:100%;border-collapse:collapse;background:white}
.data-table thead tr{background:#F5F0E8}
.data-table thead th{padding:.7rem 1.1rem;text-align:left;white-space:nowrap;font-size:.62rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-4);border-bottom:2px solid var(--border)}
.data-table tbody tr{border-bottom:1px solid var(--border-sm);transition:background .1s}
.data-table tbody tr:last-child{border-bottom:none}
.data-table tbody tr:hover{background:#FDFAF4}
.data-table tbody td{padding:.8rem 1.1rem;font-size:.845rem;vertical-align:middle}
.data-table tbody td.muted{color:var(--ink-4);font-size:.8rem}

/* FILTER */
.filter-select,.filter-input{padding:.48rem .85rem;border:1.5px solid var(--border);border-radius:var(--r-md);font-family:var(--f-body);font-size:.82rem;outline:none;background:white;color:var(--ink-2);transition:border-color .15s,box-shadow .15s;cursor:pointer}
.filter-select:focus,.filter-input:focus{border-color:var(--c);box-shadow:0 0 0 3px var(--c-ring)}
.filter-input{cursor:text}
.filter-input::placeholder{color:var(--ink-5)}

/* DETAIL VIEW */
.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:.85rem 2rem}
.detail-field .dlabel{font-size:.62rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--ink-5);margin-bottom:.25rem}
.detail-field .dval{font-size:.9rem;color:var(--ink)}

/* PAGINATION */
.pagination{display:flex;gap:.25rem;justify-content:center}
.pagination .page-item a,.pagination .page-item span{display:block;padding:.38rem .72rem;border-radius:var(--r-sm);font-size:.78rem;border:1.5px solid var(--border);color:var(--ink-3);text-decoration:none;transition:all .12s}
.pagination .page-item.active span{background:var(--c);border-color:var(--c);color:white}
.pagination .page-item a:hover{background:var(--c);border-color:var(--c);color:white}

/* EMPTY STATE */
.empty-state{text-align:center;padding:4rem 2rem;color:var(--ink-4)}
.empty-state .empty-icon{font-size:2.5rem;opacity:.2;display:block;margin-bottom:.75rem}
.empty-state p{font-size:.9rem;margin-bottom:.75rem}

/* REF BADGE */
.ref-badge{display:inline-flex;align-items:center;gap:.3rem;background:var(--g-pale);color:var(--c-dk);border:1px solid rgba(181,131,42,.25);font-size:.68rem;font-weight:600;letter-spacing:.06em;padding:.25rem .8rem;border-radius:20px;font-family:var(--f-body)}

@media(max-width:768px){
  .cols-2,.cols-3,.sig-grid,.detail-grid{grid-template-columns:1fr}
  .span-2,.span-3{grid-column:span 1}
  .page{padding:1.25rem 1rem 4rem}
  .app-header{padding:0 1rem}
  .card-section{padding:1.25rem 1.1rem}
  .form-actions{flex-direction:column-reverse}
}
@media print{
  .no-print{display:none!important}
  body{background:white}
  .page{padding:0;max-width:none}
  .card{box-shadow:none;border-radius:0;border:none}
  .app-header{display:none!important}
}
</style>
@stack('styles')
</head>
<body>
<header class="app-header no-print">
  <a class="brand" href="{{ route('ld.index') }}">
    <div class="brand-logo">
      @php $logoPath = public_path('images/batstateu-logo.png'); @endphp
      @if(file_exists($logoPath))
        <img src="{{ asset('images/batstateu-logo.png') }}" alt="BatStateU">
      @else
        <span>BSU</span>
      @endif
    </div>
    <div class="brand-text">
      <strong>Batangas State University</strong>
      <small>Research Management Services</small>
    </div>
  </a>

  <div class="header-spacer"></div>
</header>
<main>@yield('content')</main>
<footer class="no-print" style="text-align:center;padding:1.1rem 2rem;font-size:.7rem;color:var(--ink-5);border-top:1px solid var(--border-sm);background:var(--surface);letter-spacing:.04em;">
  &copy; {{ date('Y') }} &nbsp;&middot;&nbsp; Batangas State University &nbsp;&middot;&nbsp; Research Management Services &nbsp;&middot;&nbsp; L&amp;D Request System
</footer>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  if (!window.flatpickr) return;
  flatpickr('.date-picker',       { dateFormat:'F j, Y', allowInput:true });
  flatpickr('.date-picker-multi', { mode:'multiple', dateFormat:'F j, Y', allowInput:true });
  flatpickr('.date-picker-range', { mode:'range', dateFormat:'F j, Y', allowInput:true });
});
</script>
@stack('scripts')
</body>
</html>