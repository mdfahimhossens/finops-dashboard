<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Welcome | FinOps</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg: #0b1220;
      --card: rgba(255,255,255,.06);
      --stroke: rgba(255,255,255,.10);
      --text: rgba(255,255,255,.92);
      --muted: rgba(255,255,255,.68);
      --primary: #5b7cfa;
      --primary2:#22c55e;
      --shadow: 0 18px 60px rgba(0,0,0,.45);
    }

    *{ box-sizing:border-box; }
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background: radial-gradient(1200px 600px at 50% -20%, rgba(91,124,250,.35), transparent 60%),
                  radial-gradient(900px 500px at 10% 10%, rgba(34,197,94,.25), transparent 55%),
                  radial-gradient(900px 500px at 90% 30%, rgba(168,85,247,.22), transparent 55%),
                  var(--bg);
      color: var(--text);
      min-height: 100vh;
      overflow-x:hidden;
    }

    /* Subtle animated dots */
    .dots{
      position: fixed;
      inset:0;
      background-image: radial-gradient(rgba(255,255,255,.08) 1px, transparent 1px);
      background-size: 28px 28px;
      mask-image: radial-gradient(circle at center, black 0 55%, transparent 75%);
      opacity: .6;
      animation: drift 14s ease-in-out infinite alternate;
      pointer-events:none;
    }
    @keyframes drift{
      from{ transform: translate3d(0,0,0); }
      to  { transform: translate3d(-18px, -12px, 0); }
    }

    /* Top right auth links */
    .topbar{
      position: relative;
      display:flex;
      justify-content:flex-end;
      padding: 26px 34px;
      gap: 18px;
      z-index: 2;
    }
    .toplink{
      color: var(--muted);
      text-decoration:none;
      font-weight:600;
      font-size: 14px;
      padding: 8px 10px;
      border-radius: 10px;
      transition: .2s ease;
    }
    .toplink:hover{
      color: var(--text);
      background: rgba(255,255,255,.06);
      transform: translateY(-1px);
    }

    /* Center layout */
    .wrap{
      position: relative;
      z-index: 2;
      min-height: calc(100vh - 92px);
      display:grid;
      place-items:center;
      padding: 24px;
    }

    .card{
      width: min(860px, 92vw);
      background: linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.04));
      border: 1px solid var(--stroke);
      border-radius: 22px;
      box-shadow: var(--shadow);
      backdrop-filter: blur(10px);
      padding: 38px 38px 30px;
      position: relative;
      overflow:hidden;
    }

    /* Soft glow */
    .card::before{
      content:"";
      position:absolute;
      width: 420px;
      height: 420px;
      background: radial-gradient(circle, rgba(91,124,250,.35), transparent 60%);
      top:-160px;
      left:-160px;
      filter: blur(12px);
      opacity:.9;
      animation: glow 6s ease-in-out infinite alternate;
    }
    .card::after{
      content:"";
      position:absolute;
      width: 360px;
      height: 360px;
      background: radial-gradient(circle, rgba(34,197,94,.28), transparent 60%);
      bottom:-160px;
      right:-160px;
      filter: blur(14px);
      opacity:.85;
      animation: glow 7.2s ease-in-out infinite alternate-reverse;
    }
    @keyframes glow{
      from{ transform: translate3d(0,0,0) scale(1); }
      to{ transform: translate3d(18px, 10px, 0) scale(1.06); }
    }

    .content{
      position:relative;
      display:grid;
      grid-template-columns: 1.1fr .9fr;
      gap: 28px;
      align-items:center;
    }

    .brand{
      display:flex;
      align-items:center;
      gap: 12px;
      margin-bottom: 14px;
    }
    .logo{
      width: 165px;
      height: 55px;
      border-radius: 14px;
      display:grid;
      place-items:center;
      /* background: rgba(255,255,255,.07); */
      /* border: 1px solid rgba(255,255,255,.10); */
      /* box-shadow: 0 10px 28px rgba(0,0,0,.25); */
      transform: translateY(6px);
      opacity:0;
      animation: pop .7s ease forwards;
    }
    .logo img{
      width: 100%;

    }
    @keyframes pop{
      to{ transform: translateY(0); opacity:1; }
    }
    .brand small{
      color: var(--muted);
      font-weight: 600;
      letter-spacing: .2px;
    }

    h1{
      font-size: clamp(28px, 3.6vw, 44px);
      line-height: 1.12;
      margin: 8px 0 10px;
      transform: translateY(8px);
      opacity:0;
      animation: fadeUp .75s ease .08s forwards;
    }
    .sub{
      color: var(--muted);
      font-size: 15px;
      line-height: 1.7;
      margin: 0 0 18px;
      max-width: 48ch;
      transform: translateY(8px);
      opacity:0;
      animation: fadeUp .75s ease .16s forwards;
    }
    @keyframes fadeUp{
      to{ transform: translateY(0); opacity:1; }
    }

    .badges{
      display:flex;
      flex-wrap:wrap;
      gap:10px;
      margin: 16px 0 22px;
      transform: translateY(8px);
      opacity:0;
      animation: fadeUp .75s ease .22s forwards;
    }
    .badge{
      font-size: 12px;
      font-weight: 600;
      color: rgba(255,255,255,.82);
      padding: 8px 10px;
      border-radius: 999px;
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.10);
    }

    .actions{
      display:flex;
      gap: 12px;
      flex-wrap:wrap;
      transform: translateY(8px);
      opacity:0;
      animation: fadeUp .75s ease .28s forwards;
    }

    /* Animated Buttons */
    .btn{
      border: 0;
      cursor:pointer;
      text-decoration:none;
      font-weight: 700;
      border-radius: 14px;
      padding: 12px 16px;
      display:inline-flex;
      align-items:center;
      gap: 10px;
      transition: transform .18s ease, box-shadow .18s ease, background .18s ease, border-color .18s ease;
      will-change: transform;
      user-select:none;
      position: relative;
      overflow:hidden;
    }
    .btn .icon{
      width: 18px;
      height: 18px;
      display:inline-block;
    }

    .btn-primary{
      color: white;
      background: linear-gradient(135deg, rgba(91,124,250,1), rgba(91,124,250,.75));
      box-shadow: 0 12px 26px rgba(91,124,250,.35);
    }
    .btn-success{
      color: white;
      background: linear-gradient(135deg, rgba(34,197,94,1), rgba(34,197,94,.75));
      box-shadow: 0 12px 26px rgba(34,197,94,.28);
    }
    .btn-ghost{
      color: rgba(255,255,255,.86);
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.12);
    }

    .btn::before{
      content:"";
      position:absolute;
      top:0; left:-120%;
      width: 120%;
      height: 100%;
      background: linear-gradient(120deg, transparent, rgba(255,255,255,.22), transparent);
      transform: skewX(-18deg);
      transition: left .55s ease;
      opacity:.95;
    }

    .btn:hover{
      transform: translateY(-2px);
    }
    .btn:hover::before{
      left: 140%;
    }
    .btn:active{
      transform: translateY(0px) scale(.98);
    }

    /* Right panel (mini preview card) */
    .panel{
      background: rgba(0,0,0,.18);
      border: 1px solid rgba(255,255,255,.10);
      border-radius: 18px;
      padding: 18px;
      position:relative;
      transform: translateY(10px);
      opacity:0;
      animation: fadeUp .75s ease .18s forwards;
    }

    .panel-title{
      font-weight: 700;
      font-size: 14px;
      margin: 2px 0 10px;
      color: rgba(255,255,255,.88);
    }

    .stat{
      display:flex;
      justify-content:space-between;
      align-items:center;
      padding: 10px 12px;
      border-radius: 14px;
      background: rgba(255,255,255,.05);
      border: 1px solid rgba(255,255,255,.08);
      margin-bottom: 10px;
    }
    .stat span{
      color: var(--muted);
      font-size: 13px;
      font-weight: 600;
    }
    .stat strong{
      color: rgba(255,255,255,.9);
      font-size: 13px;
    }

    .foot{
      margin-top: 45px;
      color: rgba(255,255,255,.50);
      font-size: 12px;
      text-align:center;
      position:relative;
      z-index:2;
    }
    .foot a{
      text-decoration: none;
      color: #C7C8CB;
    }
    /* Responsive */
    @media (max-width: 860px){
      .content{ grid-template-columns: 1fr; }
      .panel{ order: 2; }
    }

    @media screen and (max-width: 571px) {
      .card {
  width: 100% !important;
  padding: 30px 30px 30px;
}
.brand small {
  font-size: 13px !important;
}
.content h1 {
  font-size: 25px;
}
.sub {
  font-size: 13px;
}
.badges {
  gap: 5px;
  justify-content: center;
}
#features {
  padding: 10px;
}
.stat span {
  font-size: 12px;
}
.stat strong {
  font-size: 10px;
}

.btn.btn-primary {
  font-size: 14px;
}
.btn.btn-success {
  font-size: 14px;
}
.actions {
  justify-content: center;
}
.foot{
  margin-top: 25px;
}
    }
  </style>
</head>

<body>
  <div class="dots"></div>

  <main class="wrap">
    <section class="card">
      <div class="content">
        <div>
          <div class="brand">
            <div class="logo" aria-hidden="true">
              <!-- Simple cube icon -->
              <img src="{{asset('contents/admin')}}/images/FinOps_Logo.png" alt="">
            </div>
          </div>

          <h1>Welcome to your finance command center.</h1>
          <p class="sub">
            Track income, manage expenses, and generate clean reports — all in one secure place.
            Log in to continue or create an account to get started.
          </p>

          <div class="badges">
            <span class="badge">Secure Login</span>
            <span class="badge">Income & Expense</span>
            <span class="badge">Reports & Insights</span>
          </div>

          <div class="actions">
            @auth
              <a class="btn btn-primary" href="{{ url('/dashboard') }}">
                <span class="icon">➜</span> Go to Dashboard
              </a>
            @else
              <a class="btn btn-primary" href="{{ route('login') }}">
                <span class="icon">🔐</span> Log in
              </a>

              @if (Route::has('register'))
                <a class="btn btn-success" href="{{ route('register') }}">
                  <span class="icon">✨</span> Sign Up
                </a>
              @endif

            @endauth
          </div>
        </div>

        <aside class="panel" id="features">
          <div class="panel-title">Quick Overview</div>

          <div class="stat">
            <span>Income Tracking:</span>
            <strong>Fast & Organized</strong>
          </div>
          <div class="stat">
            <span>Expense Control:</span>
            <strong>Category Wise</strong>
          </div>
          <div class="stat">
            <span>Monthly Reports:</span>
            <strong>Clear Charts</strong>
          </div>
          <div class="stat">
            <span>Role Support:</span>
            <strong>Admin / Manager / Viewer</strong>
          </div>
        </aside>
      </div>
    </section>

    <div class="foot">
      Developed by <strong><a href="https://www.linkedin.com/in/mdfahimhossens" target="_blank">Fahim</a></strong> • © {{ date('Y') }} All Rights Reserved
    </div>
  </main>
</body>
</html>
