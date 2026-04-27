<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In — BatStateU L&D Requests</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Geist:wght@300;400;500;600&display=swap" rel="stylesheet">
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
  --red:      #991b1b; --red-bg:#fee2e2; --red-bd:#fecaca;
  --f-display:'DM Serif Display', Georgia, serif;
  --f-body:   'Geist', system-ui, sans-serif;
  --r-sm:6px; --r-md:10px; --r-lg:14px; --r-xl:18px; --r-2xl:24px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{
  font-family:var(--f-body);font-size:15px;line-height:1.6;
  color:var(--ink);background:var(--bg);min-height:100vh;
  -webkit-font-smoothing:antialiased;
  display:flex;flex-direction:column;
}
body::before{
  content:'';position:fixed;inset:0;
  background:
    radial-gradient(ellipse 900px 600px at 10% 20%,rgba(124,21,51,.055) 0%,transparent 70%),
    radial-gradient(ellipse 700px 500px at 90% 80%,rgba(181,131,42,.04) 0%,transparent 70%);
  pointer-events:none;z-index:0;
}
.app-header{
  position:relative;z-index:10;height:60px;background:var(--c-dk);
  display:flex;align-items:center;padding:0 2rem;gap:1rem;
  box-shadow:0 1px 0 rgba(255,255,255,.05),0 2px 12px rgba(0,0,0,.18);flex-shrink:0;
}
.app-header::after{
  content:'';position:absolute;bottom:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent 0%,var(--g) 30%,var(--g-lt) 50%,var(--g) 70%,transparent 100%);opacity:.7;
}
.brand{display:flex;align-items:center;gap:.75rem;text-decoration:none;}
.brand-logo{
  width:36px;height:36px;border-radius:50%;background:white;overflow:hidden;
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 0 0 2px rgba(255,255,255,.12);flex-shrink:0;
}
.brand-logo img{width:100%;height:100%;object-fit:contain;}
.brand-logo span{font-family:var(--f-display);color:var(--c);font-size:13px;font-weight:700;}
.brand-text{line-height:1.2;}
.brand-text strong{display:block;color:#fff;font-family:var(--f-display);font-size:.95rem;font-weight:400;letter-spacing:.01em;}
.brand-text small{color:var(--g-lt);font-size:.6rem;letter-spacing:.12em;text-transform:uppercase;opacity:.85;}
.main{flex:1;display:flex;align-items:center;justify-content:center;padding:3rem 1.25rem;position:relative;z-index:1;}
.login-wrap{width:100%;max-width:420px;}
.login-eyebrow{text-align:center;margin-bottom:1.75rem;animation:fadeUp .5s ease both;}
.login-eyebrow .sys-label{
  display:inline-block;font-size:.6rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;
  color:var(--g);background:var(--g-pale);border:1px solid rgba(181,131,42,.25);
  padding:.22rem .85rem;border-radius:20px;margin-bottom:.85rem;
}
.login-eyebrow h1{font-family:var(--f-display);font-size:1.85rem;color:var(--ink);line-height:1.2;margin-bottom:.35rem;}
.login-eyebrow p{font-size:.845rem;color:var(--ink-4);}
.card{
  background:var(--surface);border-radius:var(--r-2xl);border:1px solid var(--border);
  box-shadow:0 1px 3px rgba(0,0,0,.04),0 6px 24px rgba(0,0,0,.06),0 24px 64px rgba(0,0,0,.04);
  overflow:hidden;animation:fadeUp .5s .1s ease both;
}
.card-accent{height:3px;background:linear-gradient(90deg,var(--c-dk) 0%,var(--c) 35%,var(--g) 65%,var(--g-lt) 100%);}
.card-body{padding:2rem 2rem 1.75rem;}
.field{display:flex;flex-direction:column;gap:.3rem;margin-bottom:1rem;}
.field label{font-size:.72rem;font-weight:600;color:var(--ink-2);letter-spacing:.02em;}
.input-wrap{position:relative;}
.input-wrap .input-icon{
  position:absolute;left:.85rem;top:50%;transform:translateY(-50%);
  color:var(--ink-5);display:flex;align-items:center;pointer-events:none;transition:color .15s;
}
.input-wrap input{
  width:100%;padding:.65rem .9rem .65rem 2.55rem;
  border:1.5px solid var(--border);border-radius:var(--r-md);
  font-family:var(--f-body);font-size:.875rem;color:var(--ink);
  background:var(--surface-2);outline:none;
  transition:border-color .15s,box-shadow .15s,background .15s;
}
.input-wrap input:focus{border-color:var(--c);box-shadow:0 0 0 3px var(--c-ring);background:white;}
.input-wrap:focus-within .input-icon{color:var(--c);}
.input-wrap input.is-invalid{border-color:var(--red);}
.toggle-pw{
  position:absolute;right:.75rem;top:50%;transform:translateY(-50%);
  background:none;border:none;cursor:pointer;color:var(--ink-5);
  padding:.2rem;display:flex;align-items:center;transition:color .15s;
}
.toggle-pw:hover{color:var(--ink-3);}
.field-error{font-size:.72rem;color:var(--red);margin-top:.25rem;font-weight:500;}
.form-meta{display:flex;align-items:center;justify-content:space-between;margin:1rem 0 1.5rem;}
.remember{display:flex;align-items:center;gap:.45rem;cursor:pointer;font-size:.82rem;color:var(--ink-3);user-select:none;}
.remember input[type=checkbox]{accent-color:var(--c);width:15px;height:15px;cursor:pointer;flex-shrink:0;}
.forgot{font-size:.82rem;color:var(--c);text-decoration:none;font-weight:500;letter-spacing:.01em;transition:color .15s;}
.forgot:hover{color:var(--c-dk);text-decoration:underline;}
.btn-submit{
  width:100%;display:flex;align-items:center;justify-content:center;gap:.5rem;
  padding:.7rem 1.5rem;border-radius:var(--r-md);background:var(--c);color:white;
  font-family:var(--f-body);font-size:.9rem;font-weight:600;letter-spacing:.01em;
  border:none;cursor:pointer;
  box-shadow:0 1px 4px rgba(124,21,51,.2),0 2px 8px rgba(124,21,51,.12);
  transition:background .15s,box-shadow .15s,transform .15s;
  position:relative;overflow:hidden;
}
.btn-submit::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.08) 0%,transparent 60%);pointer-events:none;}
.btn-submit:hover{background:var(--c-dk);box-shadow:0 2px 8px rgba(124,21,51,.3),0 4px 16px rgba(124,21,51,.16);transform:translateY(-1px);}
.alert-error{
  display:flex;align-items:flex-start;gap:.6rem;
  background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd);
  border-radius:var(--r-md);padding:.75rem 1rem;font-size:.84rem;margin-bottom:1.25rem;
}
.alert-error svg{flex-shrink:0;margin-top:1px;}
.card-footer{
  padding:1rem 2rem;background:var(--surface-2);border-top:1px solid var(--border-sm);
  text-align:center;font-size:.78rem;color:var(--ink-4);
}
.card-footer a{color:var(--c);font-weight:500;text-decoration:none;}
.card-footer a:hover{text-decoration:underline;}
.page-footer{
  text-align:center;padding:1.1rem 2rem;font-size:.7rem;color:var(--ink-5);
  border-top:1px solid var(--border-sm);background:var(--surface);
  letter-spacing:.04em;position:relative;z-index:1;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
@media(max-width:480px){
  .main{padding:2rem 1rem;align-items:flex-start;}
  .card-body{padding:1.5rem 1.25rem 1.25rem;}
  .card-footer{padding:.85rem 1.25rem;}
  .login-eyebrow h1{font-size:1.6rem;}
  .form-meta{flex-direction:column;align-items:flex-start;gap:.5rem;}
}
</style>
</head>
<body>

<header class="app-header">
  <a class="brand" href="#">
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
</header>

<main class="main">
  <div class="login-wrap">

    <div class="login-eyebrow">
      <div class="sys-label">L&amp;D Request System</div>
      <h1>Welcome back</h1>
      <p>Sign in to manage your learning &amp; development requests.</p>
    </div>

    <div class="card">
      <div class="card-accent"></div>
      <div class="card-body">

        {{-- Server-side error --}}
        @if ($errors->any())
          <div class="alert-error">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <circle cx="8" cy="8" r="7.25" stroke="currentColor" stroke-width="1.5"/>
              <path d="M8 4.5v4M8 10.5v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span>{{ $errors->first() }}</span>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
          @csrf

          {{-- Email --}}
          <div class="field">
            <label for="email">Email address</label>
            <div class="input-wrap">
              <svg class="input-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <rect x="1.25" y="3.25" width="13.5" height="9.5" rx="1.5" stroke="currentColor" stroke-width="1.35"/>
                <path d="M1.5 4.5l6.5 4.5 6.5-4.5" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="you@batstate-u.edu.ph"
                autocomplete="email"
                class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                required
              >
            </div>
            @error('email')
              <span class="field-error">{{ $message }}</span>
            @enderror
          </div>

          {{-- Password --}}
          <div class="field">
            <label for="password">Password</label>
            <div class="input-wrap">
              <svg class="input-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <rect x="2.75" y="7.25" width="10.5" height="7" rx="1.5" stroke="currentColor" stroke-width="1.35"/>
                <path d="M5 7.25V5a3 3 0 016 0v2.25" stroke="currentColor" stroke-width="1.35" stroke-linecap="round"/>
                <circle cx="8" cy="10.5" r="1" fill="currentColor"/>
              </svg>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                autocomplete="current-password"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                required
              >
              <button type="button" class="toggle-pw" id="togglePw" aria-label="Show password">
                <svg id="eyeIcon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z" stroke="currentColor" stroke-width="1.35" stroke-linejoin="round"/>
                  <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.35"/>
                </svg>
              </button>
            </div>
          </div>

          {{-- Remember + Forgot --}}
          <div class="form-meta">
            <label class="remember">
              <input type="checkbox" name="remember" id="remember">
              Keep me signed in
            </label>
            <a href="#" class="forgot">Forgot password?</a>
          </div>

          <button type="submit" class="btn-submit">Sign in</button>
        </form>

      </div>

      <div class="card-footer">
        Need access? <a href="mailto:rms@batstate-u.edu.ph">Contact the RMS office</a>
      </div>
    </div>

  </div>
</main>

<footer class="page-footer">
  &copy; {{ date('Y') }} &nbsp;&middot;&nbsp; Batangas State University &nbsp;&middot;&nbsp; Research Management Services &nbsp;&middot;&nbsp; Request Form System
</footer>

<script>
const togglePw = document.getElementById('togglePw');
const pwInput  = document.getElementById('password');
const eyeIcon  = document.getElementById('eyeIcon');

togglePw.addEventListener('click', () => {
  const isText = pwInput.type === 'text';
  pwInput.type = isText ? 'password' : 'text';
  eyeIcon.innerHTML = isText
    ? `<path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z" stroke="currentColor" stroke-width="1.35" stroke-linejoin="round"/><circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.35"/>`
    : `<path d="M1.5 1.5l13 13M6.5 6.65A3.5 3.5 0 0011.35 11.5M4.5 4.6C2.8 5.7 1.7 7.4 1 8c.9 1.8 3.5 5 7 5 1.5 0 2.9-.5 4-1.4M8 4.5c3.3.3 5.5 3 6 3.5-.4.9-1.2 2.1-2.5 3.1" stroke="currentColor" stroke-width="1.35" stroke-linecap="round"/>`;
  togglePw.setAttribute('aria-label', isText ? 'Show password' : 'Hide password');
});
</script>

</body>
</html>
