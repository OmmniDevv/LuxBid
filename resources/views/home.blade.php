<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <title>LuxBid — Platform Pelelangan Online Premium</title>
  <meta name="description" content="Platform pelelangan daring yang transparan, aman, dan elegan. Daftar gratis dan mulai menawar sekarang.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    /* ══════════════════════════════════════════
       HOME PAGE — PREMIUM STYLES
    ══════════════════════════════════════════ */
    :root{
      --ease-home:.3s cubic-bezier(.4,0,.2,1);
    }
    body{overflow-x:hidden;font-family:var(--font-sans)}

    /* ── NAVBAR ─────────────────────────── */
    .hn{
      position:fixed;inset:0 0 auto 0;z-index:200;
      height:64px;display:flex;align-items:center;justify-content:space-between;
      padding:0 2.5rem;
      background:rgba(250,250,249,.88);
      backdrop-filter:blur(20px) saturate(180%);
      -webkit-backdrop-filter:blur(20px) saturate(180%);
      border-bottom:1px solid var(--gold-ln);
      box-shadow:0 1px 0 rgba(202,138,4,.05);
    }
    [data-theme="dark"] .hn{background:rgba(12,10,9,.92);border-bottom-color:var(--border)}
    .hn-brand{
      font-family:var(--font-serif);font-size:1.3rem;font-weight:700;
      color:var(--text);text-decoration:none;
      display:inline-flex;align-items:center;gap:.6rem;
      transition:opacity var(--ease-fast);
    }
    .hn-brand:hover{opacity:.85;color:var(--text);text-decoration:none}
    .hn-brand img{width:40px;height:40px;object-fit:contain;border-radius:8px}
    .hn-brand span{color:var(--accent)}

    .hn-links{display:flex;align-items:center;gap:.1rem;list-style:none;margin:0;padding:0}
    .hn-links a{
      font-size:.8rem;font-weight:500;color:var(--text-2);
      text-decoration:none;padding:.4rem .9rem;
      border-radius:100px;transition:all var(--ease-fast);
    }
    .hn-links a:hover{color:var(--text);background:var(--surface-2)}
    .hn-cta{
      background:var(--ink)!important;color:var(--cream)!important;
      padding:.42rem 1.2rem!important;font-weight:600!important;
    }
    .hn-cta:hover{background:var(--accent)!important;color:var(--ink)!important}
    [data-theme="dark"] .hn-cta{background:var(--accent)!important;color:var(--ink)!important}
    [data-theme="dark"] .hn-cta:hover{background:var(--accent-l)!important}

    .hn-right{display:flex;align-items:center;gap:.5rem}
    .hn-burger{
      display:none;background:none;border:1.5px solid var(--border-2);
      border-radius:var(--rss);width:36px;height:36px;cursor:pointer;
      flex-direction:column;align-items:center;justify-content:center;gap:5px;
      padding:0;
    }
    .hn-burger span{display:block;width:16px;height:1.5px;background:var(--text);border-radius:2px;transition:all var(--ease)}

    /* Mobile menu */
    .hn-mobile{
      display:none;position:fixed;top:64px;left:0;right:0;bottom:0;
      background:rgba(250,250,249,.98);backdrop-filter:blur(20px);
      -webkit-backdrop-filter:blur(20px);
      z-index:199;padding:1rem 1.25rem 2rem;
      flex-direction:column;gap:.25rem;
      border-top:1px solid var(--border);
      overflow-y:auto;
    }
    .hn-mobile.open{display:flex}
    [data-theme="dark"] .hn-mobile{background:rgba(12,10,9,.98);border-top-color:var(--border)}
    .hn-mobile a{
      display:flex;align-items:center;gap:.6rem;
      padding:.72rem 1rem;border-radius:var(--rss);
      font-size:.9rem;color:var(--text);text-decoration:none;
      border:1px solid transparent;
      transition:all var(--ease-fast);
    }
    .hn-mobile a:hover,.hn-mobile a.active{background:var(--accent-p);border-color:var(--accent-ln);color:var(--text)}
    .hn-mobile .m-cta{
      background:var(--ink);color:var(--cream)!important;
      text-align:center;justify-content:center;margin-top:.5rem;
      border-color:transparent!important;
    }
    .hn-mobile .m-cta:hover{background:var(--accent);color:var(--ink)!important}
    [data-theme="dark"] .hn-mobile .m-cta{background:var(--accent);color:var(--ink)!important}

    /* ── HERO ───────────────────────────── */
    .hero{
      min-height:100vh;display:flex;flex-direction:column;
      align-items:center;justify-content:center;
      text-align:center;padding:8rem 1.5rem 5rem;
      position:relative;background:var(--bg);overflow:hidden;
    }

    /* 3D depth rings — layered concentric circles */
    .hero-ring{
      position:absolute;border-radius:50%;
      border:1px solid var(--gold-ln);pointer-events:none;
      top:50%;left:50%;transform:translate(-50%,-50%);
    }
    .hero-ring-1{width:680px;height:680px;animation:ring-pulse 6s ease-in-out infinite}
    .hero-ring-2{width:900px;height:900px;opacity:.5;animation:ring-pulse 6s ease-in-out infinite .8s}
    .hero-ring-3{width:1120px;height:1120px;opacity:.25;animation:ring-pulse 6s ease-in-out infinite 1.6s}

    /* Gold radial glow */
    .hero-glow{
      position:absolute;width:600px;height:600px;border-radius:50%;
      background:radial-gradient(circle,rgba(202,138,4,.07) 0%,transparent 70%);
      top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;
    }

    /* 3D Floating auction objects */
    .hero-3d{
      position:absolute;pointer-events:none;
      animation:float3d 4s ease-in-out infinite;
    }
    .hero-3d-hammer{
      top:15%;right:10%;width:72px;height:72px;
      animation-delay:0s;
    }
    .hero-3d-gem{
      top:20%;left:9%;width:54px;height:54px;
      animation-delay:1.2s;
    }
    .hero-3d-tag{
      bottom:22%;right:8%;width:60px;height:60px;
      animation-delay:.6s;
    }
    .hero-3d-coin{
      bottom:20%;left:8%;width:48px;height:48px;
      animation-delay:1.8s;
    }

    /* SVG icon containers */
    .float-obj{
      width:100%;height:100%;
      background:var(--surface);
      border:1px solid var(--accent-ln);
      border-radius:var(--r);
      display:flex;align-items:center;justify-content:center;
      font-size:1.8rem;color:var(--accent);
      box-shadow:0 8px 32px rgba(202,138,4,.12),0 2px 8px rgba(0,0,0,.06);
      backdrop-filter:blur(8px);
      -webkit-backdrop-filter:blur(8px);
    }
    [data-theme="dark"] .float-obj{
      background:rgba(28,25,23,.7);
      box-shadow:0 8px 32px rgba(202,138,4,.15),0 2px 8px rgba(0,0,0,.4);
    }

    @keyframes ring-pulse{0%,100%{opacity:.6;transform:translate(-50%,-50%) scale(1)}50%{opacity:.3;transform:translate(-50%,-50%) scale(1.02)}}
    @keyframes float3d{0%,100%{transform:translateY(0) rotate(0deg)}33%{transform:translateY(-10px) rotate(2deg)}66%{transform:translateY(-5px) rotate(-1deg)}}

    /* Hero content */
    .hero-badge{
      display:inline-flex;align-items:center;gap:.5rem;
      background:var(--accent-p);border:1px solid var(--accent-ln);
      border-radius:100px;padding:.32rem 1.1rem;
      font-size:.68rem;font-weight:700;letter-spacing:.12em;
      text-transform:uppercase;color:var(--accent);
      margin-bottom:1.75rem;position:relative;z-index:1;
    }
    .hero-badge::before{
      content:'';width:6px;height:6px;border-radius:50%;
      background:var(--accent);
      animation:blink-dot 2.5s ease-in-out infinite;
    }
    @keyframes blink-dot{0%,100%{opacity:1}50%{opacity:.2}}

    .hero-title{
      font-family:var(--font-serif);
      font-size:clamp(2.75rem,7vw,5.25rem);
      font-weight:700;line-height:1.04;
      letter-spacing:-.035em;color:var(--text);
      max-width:780px;position:relative;z-index:1;
    }
    .hero-title em{font-style:italic;color:var(--accent)}

    .hero-sub{
      margin-top:1.5rem;font-size:1rem;
      color:var(--text-2);max-width:460px;
      line-height:1.8;position:relative;z-index:1;
    }

    .hero-btns{
      display:flex;gap:.85rem;margin-top:2.5rem;
      flex-wrap:wrap;justify-content:center;position:relative;z-index:1;
    }
    .btn-hero-p{
      display:inline-flex;align-items:center;gap:.5rem;
      background:var(--ink);color:var(--cream);
      padding:.85rem 2.1rem;border-radius:100px;
      font-size:.9rem;font-weight:600;text-decoration:none;
      font-family:var(--font-sans);
      box-shadow:0 4px 20px rgba(28,25,23,.2);
      transition:all var(--ease-home);
    }
    .btn-hero-p:hover{
      background:var(--accent);color:var(--ink);
      transform:translateY(-3px);box-shadow:0 8px 28px rgba(202,138,4,.3);
      text-decoration:none;
    }
    [data-theme="dark"] .btn-hero-p{background:var(--accent);color:var(--ink)}
    [data-theme="dark"] .btn-hero-p:hover{background:var(--accent-l);color:var(--ink)}

    .btn-hero-o{
      display:inline-flex;align-items:center;gap:.5rem;
      background:transparent;color:var(--text);
      padding:.83rem 1.9rem;border-radius:100px;
      font-size:.9rem;font-weight:500;text-decoration:none;
      font-family:var(--font-sans);
      border:1.5px solid var(--border-2);
      transition:all var(--ease-home);
    }
    .btn-hero-o:hover{
      border-color:var(--accent-ln);background:var(--accent-p);
      color:var(--text);transform:translateY(-3px);text-decoration:none;
    }

    .hero-trust{
      margin-top:1.75rem;display:flex;align-items:center;gap:.6rem;
      font-size:.75rem;color:var(--text-3);position:relative;z-index:1;
    }
    .hero-trust-dot{
      width:7px;height:7px;border-radius:50%;
      background:var(--success);display:inline-block;
      box-shadow:0 0 0 3px rgba(21,128,61,.15);
    }

    /* ── STATS BAR ──────────────────────── */
    .stats-bar{
      background:var(--ink);display:flex;
      justify-content:center;flex-wrap:wrap;
    }
    [data-theme="dark"] .stats-bar{background:#0A0806}
    .stats-bar-item{
      text-align:center;padding:2.25rem 3.25rem;
      border-right:1px solid rgba(255,255,255,.07);
    }
    .stats-bar-item:last-child{border-right:none}
    .stats-bar-n{
      font-family:var(--font-serif);font-size:2.25rem;
      color:var(--gold-l);display:block;line-height:1;font-weight:700;
    }
    .stats-bar-l{
      font-size:.68rem;color:rgba(250,250,249,.38);
      text-transform:uppercase;letter-spacing:.1em;margin-top:.35rem;
    }

    /* ── SECTION COMMONS ────────────────── */
    .sec{position:relative}
    .inner{max-width:1080px;margin:0 auto;padding:6rem 1.5rem}
    .sec-lbl{
      display:inline-block;font-size:.65rem;font-weight:700;
      letter-spacing:.16em;text-transform:uppercase;
      color:var(--accent);margin-bottom:.75rem;
    }
    .sec-title{
      font-family:var(--font-serif);
      font-size:clamp(1.9rem,3.5vw,2.85rem);
      line-height:1.1;color:var(--text);letter-spacing:-.02em;
    }
    .sec-desc{
      margin-top:.9rem;font-size:.95rem;
      color:var(--text-2);max-width:480px;line-height:1.8;
    }

    /* Reveal on scroll */
    .rv{opacity:0;transform:translateY(24px);transition:opacity .55s ease,transform .55s ease}
    .rv.in{opacity:1;transform:none}
    .rv.delay-1{transition-delay:.1s}
    .rv.delay-2{transition-delay:.18s}
    .rv.delay-3{transition-delay:.26s}

    /* ── HOW IT WORKS ───────────────────── */
    #how{background:var(--surface-2)}
    [data-theme="dark"] #how{background:var(--surface)}
    .steps-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem;margin-top:3rem}
    .step-card{
      background:var(--surface);border:1px solid var(--border);
      border-radius:var(--r);padding:1.75rem;
      position:relative;overflow:hidden;
      transition:transform var(--ease-home),box-shadow var(--ease-home),border-color var(--ease-home);
      cursor:default;
    }
    .step-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-lg);border-color:var(--accent-ln)}
    .step-card::after{
      content:'';position:absolute;inset:0;
      background:linear-gradient(135deg,rgba(255,255,255,.04) 0%,transparent 60%);
      pointer-events:none;
    }
    .step-num{
      font-family:var(--font-serif);font-size:4rem;font-weight:700;
      color:var(--surface-3);position:absolute;
      top:.2rem;right:.85rem;line-height:1;
      transition:color var(--ease-home);
    }
    .step-card:hover .step-num{color:var(--accent-ln)}
    .step-ico{
      width:44px;height:44px;border-radius:var(--rss);
      background:var(--accent-p);border:1px solid var(--accent-ln);
      display:flex;align-items:center;justify-content:center;
      font-size:1.15rem;color:var(--accent);margin-bottom:1.1rem;
    }
    .step-card h4{font-family:var(--font-serif);font-size:1.05rem;color:var(--text);margin-bottom:.4rem}
    .step-card p{font-size:.82rem;color:var(--text-2);line-height:1.65}

    /* ── FEATURES SECTION ───────────────── */
    #features{background:var(--accent-p)}
    [data-theme="dark"] #features{background:rgba(202,138,4,.04);border-top:1px solid var(--border);border-bottom:1px solid var(--border)}
    .features-grid{display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center;margin-top:3rem}
    .feature-list{display:flex;flex-direction:column;gap:1rem}
    .feature-item{
      display:flex;gap:.9rem;align-items:flex-start;
      background:var(--surface);border:1px solid var(--border);
      border-radius:var(--rs);padding:1.1rem;
      transition:transform var(--ease-home),box-shadow var(--ease-home);
    }
    .feature-item:hover{transform:translateX(5px);box-shadow:var(--shadow)}
    .feature-ico{
      width:38px;height:38px;min-width:38px;border-radius:var(--rss);
      background:var(--accent-p);border:1px solid var(--accent-ln);
      display:flex;align-items:center;justify-content:center;
      font-size:.95rem;color:var(--accent);
    }
    .feature-item h5{font-family:var(--font-serif);font-size:.95rem;margin-bottom:.2rem;color:var(--text)}
    .feature-item p{font-size:.8rem;color:var(--text-2);line-height:1.6;margin:0}

    /* Mock auction card (right side preview) */
    .auction-preview{
      background:var(--surface);border-radius:var(--r);
      border:1px solid var(--border);padding:1.4rem;
      box-shadow:var(--shadow-lg);
    }
    .ap-bar{display:flex;align-items:center;gap:.45rem;margin-bottom:1.15rem}
    .ap-dot{width:9px;height:9px;border-radius:50%}
    .ap-title{font-size:.72rem;color:var(--text-2);margin-left:.35rem;font-weight:500}
    .ap-lot{
      background:var(--surface-2);border:1px solid var(--border);
      border-radius:var(--rs);padding:1rem;margin-bottom:.75rem;
    }
    .ap-lot-cat{font-size:.64rem;color:var(--text-3);text-transform:uppercase;letter-spacing:.08em}
    .ap-lot-name{font-family:var(--font-serif);font-weight:700;font-size:.95rem;color:var(--text);margin:.2rem 0}
    .ap-lot-row{display:flex;align-items:center;justify-content:space-between;margin-top:.75rem}
    .ap-lot-price{font-family:var(--font-serif);font-size:1.3rem;color:var(--success);font-weight:700}
    .ap-live-badge{
      font-size:.65rem;background:rgba(21,128,61,.1);
      color:var(--success);padding:.22rem .55rem;
      border-radius:100px;font-weight:600;
      border:1px solid rgba(21,128,61,.2);
      display:inline-flex;align-items:center;gap:.35rem;
    }
    .ap-live-badge::before{
      content:'';width:5px;height:5px;border-radius:50%;
      background:var(--success);animation:blink-dot 1.5s infinite;
    }
    .ap-bid-btn{
      width:100%;margin-top:.9rem;background:var(--ink);color:var(--cream);
      border:none;border-radius:100px;padding:.65rem;
      font-size:.82rem;font-weight:600;cursor:pointer;
      font-family:var(--font-sans);transition:background var(--ease-home);
      display:block;text-align:center;text-decoration:none;
    }
    .ap-bid-btn:hover{background:var(--accent);color:var(--ink);text-decoration:none}
    [data-theme="dark"] .ap-bid-btn{background:var(--accent);color:var(--ink)}
    [data-theme="dark"] .ap-bid-btn:hover{background:var(--accent-l)}

    /* ── LIVE AUCTIONS SECTION ──────────── */
    #auctions{background:var(--bg)}
    .auction-grid{
      display:grid;grid-template-columns:repeat(auto-fill,minmax(285px,1fr));
      gap:1.5rem;margin-top:2.5rem;
    }
    .auction-card{
      background:var(--surface);border:1.5px solid var(--border);
      border-radius:var(--r);overflow:hidden;
      display:flex;flex-direction:column;
      transition:transform var(--ease-home),box-shadow var(--ease-home),border-color var(--ease-home);
    }
    .auction-card:hover{transform:translateY(-5px);box-shadow:var(--shadow-lg);border-color:var(--accent-ln)}
    .auction-card-img{width:100%;height:160px;object-fit:cover;display:block}
    .auction-card-imgph{
      width:100%;height:160px;background:linear-gradient(135deg,var(--surface-2),var(--accent-p));
      display:flex;align-items:center;justify-content:center;
      font-size:2.5rem;color:var(--text-3);
    }
    .auction-card-body{padding:1.25rem;display:flex;flex-direction:column;gap:.7rem;flex:1}
    .auction-card-top{display:flex;align-items:center;justify-content:space-between}
    .ac-live{font-size:.65rem;font-weight:700;color:var(--success);background:rgba(21,128,61,.1);border:1px solid rgba(21,128,61,.2);padding:.18rem .6rem;border-radius:100px;display:inline-flex;align-items:center;gap:.35rem}
    .ac-live::before{content:'';width:5px;height:5px;border-radius:50%;background:var(--success);animation:blink-dot 1.5s infinite}
    .ac-lot{font-size:.68rem;color:var(--text-3);font-weight:500}
    .ac-name{font-family:var(--font-serif);font-size:1.1rem;color:var(--text);line-height:1.3;font-weight:700}
    .ac-desc{font-size:.79rem;color:var(--text-2);line-height:1.6;margin:0}
    .ac-meta{display:flex;gap:.9rem;font-size:.72rem;color:var(--text-2)}
    .ac-price-box{
      background:var(--surface-2);border-radius:var(--rss);
      padding:.85rem 1rem;
      display:flex;justify-content:space-between;align-items:flex-end;
    }
    .ac-price-lbl{font-size:.64rem;color:var(--text-3);margin-bottom:.1rem}
    .ac-price{font-family:var(--font-serif);font-size:1.3rem;color:var(--success);font-weight:700}
    .ac-btn{
      display:block;width:100%;padding:.72rem;
      background:var(--ink);color:var(--cream);
      border:none;border-radius:100px;
      font-size:.88rem;font-weight:600;
      text-align:center;text-decoration:none;cursor:pointer;
      font-family:var(--font-sans);transition:all var(--ease-home);
    }
    .ac-btn:hover{background:var(--accent);color:var(--ink);text-decoration:none;transform:translateY(-1px)}
    [data-theme="dark"] .ac-btn{background:var(--accent);color:var(--ink)}
    [data-theme="dark"] .ac-btn:hover{background:var(--accent-l)}
    .ac-gate{
      background:var(--accent-p);border:1px solid var(--accent-ln);
      border-radius:var(--rss);padding:.9rem;text-align:center;
    }
    .ac-gate p{font-size:.76rem;color:var(--text-2);margin-bottom:.6rem}
    .ac-gate-btns{display:flex;gap:.5rem;justify-content:center}
    .ac-gate-login{
      flex:1;padding:.5rem .8rem;border-radius:100px;
      font-size:.8rem;font-weight:600;text-align:center;
      text-decoration:none;background:var(--ink);color:var(--cream);
      transition:all var(--ease-fast);
    }
    .ac-gate-login:hover{background:var(--accent);color:var(--ink);text-decoration:none}
    [data-theme="dark"] .ac-gate-login{background:var(--accent);color:var(--ink)}
    .ac-gate-reg{
      flex:1;padding:.48rem .8rem;border-radius:100px;
      font-size:.8rem;font-weight:600;text-align:center;
      text-decoration:none;background:transparent;color:var(--text);
      border:1.5px solid var(--border-2);transition:all var(--ease-fast);
    }
    .ac-gate-reg:hover{border-color:var(--accent-ln);background:var(--accent-p);text-decoration:none;color:var(--text)}

    .empty-box{
      text-align:center;padding:4rem 2rem;margin-top:2.5rem;
      background:var(--surface);border:1px solid var(--border);
      border-radius:var(--r);
    }
    .empty-box-ico{font-size:2.5rem;opacity:.18;color:var(--accent);margin-bottom:.9rem}
    .empty-box h3{font-family:var(--font-serif);font-size:1.35rem;color:var(--text);margin-bottom:.4rem}
    .empty-box p{font-size:.88rem;color:var(--text-2)}

    /* ── ACCESS SECTION ─────────────────── */
    #access{background:var(--surface-2)}
    [data-theme="dark"] #access{background:var(--surface)}
    .access-card{
      max-width:520px;margin:3rem auto 0;
      background:var(--accent-p);border:1.5px solid var(--accent-ln);
      border-radius:var(--r);padding:2.5rem;
      transition:transform var(--ease-home),box-shadow var(--ease-home);
    }
    .access-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-lg)}
    .access-ico{
      width:52px;height:52px;border-radius:12px;
      background:rgba(202,138,4,.12);
      display:flex;align-items:center;justify-content:center;
      font-size:1.3rem;color:var(--accent);margin-bottom:1.1rem;
    }
    .access-title{font-family:var(--font-serif);font-size:1.5rem;color:var(--text);margin-bottom:.4rem}
    .access-desc{font-size:.84rem;color:var(--text-2);line-height:1.65;margin-bottom:1.35rem}
    .access-checks{list-style:none;display:flex;flex-direction:column;gap:.45rem;margin-bottom:1.85rem}
    .access-checks li{
      font-size:.82rem;color:var(--text-2);
      display:flex;align-items:center;gap:.55rem;
    }
    .access-checks li::before{
      content:'';width:18px;height:18px;min-width:18px;border-radius:50%;
      background:rgba(202,138,4,.15);
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2 6l3 3 5-5' stroke='%23CA8A04' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
      background-repeat:no-repeat;background-position:center;background-size:10px;
    }
    .access-btn{
      display:flex;align-items:center;justify-content:center;gap:.45rem;
      padding:.85rem 1.6rem;border-radius:100px;
      font-size:.88rem;font-weight:600;text-decoration:none;
      width:100%;font-family:var(--font-sans);
      background:var(--ink);color:var(--cream);
      transition:all var(--ease-home);
    }
    .access-btn:hover{background:var(--accent);color:var(--ink);transform:translateY(-1px);text-decoration:none}
    [data-theme="dark"] .access-btn{background:var(--accent);color:var(--ink)}
    [data-theme="dark"] .access-btn:hover{background:var(--accent-l)}
    .access-reg{text-align:center;margin-top:1rem;font-size:.78rem;color:var(--text-2)}
    .access-reg a{color:var(--accent);font-weight:600;text-decoration:none}
    .access-reg a:hover{text-decoration:underline}
    .access-staff{
      display:inline-flex;align-items:center;gap:.4rem;
      margin-top:.65rem;font-size:.73rem;font-weight:600;
      color:var(--accent);background:rgba(202,138,4,.08);
      border:1px solid var(--accent-ln);border-radius:100px;
      padding:.32rem .9rem;text-decoration:none;
      transition:all var(--ease-fast);
    }
    .access-staff:hover{background:rgba(202,138,4,.15);color:var(--accent);text-decoration:none}

    /* ── CTA SELLER SECTION ─────────────── */
    #seller{background:var(--ink);position:relative;overflow:hidden}
    [data-theme="dark"] #seller{background:#0A0806}
    .seller-ring-1{position:absolute;width:520px;height:520px;border-radius:50%;border:1px solid rgba(202,138,4,.12);top:-160px;right:-120px;pointer-events:none}
    .seller-ring-2{position:absolute;width:320px;height:320px;border-radius:50%;border:1px solid rgba(202,138,4,.08);bottom:-80px;left:60px;pointer-events:none}
    .seller-grid{display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;position:relative;z-index:1}
    .seller-lbl{font-size:.65rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--gold-l);margin-bottom:.75rem;display:block}
    .seller-title{font-family:var(--font-serif);font-size:clamp(1.85rem,3.5vw,2.6rem);color:#FAF9F8;line-height:1.1}
    .seller-title em{font-style:italic;color:var(--gold-l)}
    .seller-desc{margin-top:.85rem;font-size:.88rem;color:rgba(250,250,249,.42);line-height:1.8;max-width:400px}
    .seller-steps{display:flex;flex-direction:column;gap:1.1rem;margin-top:2rem}
    .seller-step{display:flex;align-items:flex-start;gap:1rem}
    .seller-step-n{
      width:32px;height:32px;min-width:32px;border-radius:50%;
      background:rgba(202,138,4,.15);border:1px solid rgba(202,138,4,.28);
      display:flex;align-items:center;justify-content:center;
      font-family:var(--font-serif);font-size:.85rem;font-weight:700;color:var(--gold-l);
    }
    .seller-step-body h4{font-size:.88rem;font-weight:600;color:#FAF9F8;margin-bottom:.2rem}
    .seller-step-body p{font-size:.78rem;color:rgba(250,250,249,.38);line-height:1.6}
    .seller-card{
      background:rgba(250,250,249,.04);border:1px solid rgba(202,138,4,.18);
      border-radius:var(--r);padding:2.25rem;
    }
    .seller-perks{display:flex;flex-direction:column;gap:.85rem;margin:1.6rem 0}
    .seller-perk{display:flex;align-items:center;gap:.75rem;font-size:.84rem;color:rgba(250,250,249,.6)}
    .seller-perk-ico{
      width:28px;height:28px;min-width:28px;border-radius:var(--rss);
      background:rgba(202,138,4,.12);display:flex;align-items:center;justify-content:center;
      color:var(--gold-l);font-size:.75rem;
    }
    .btn-seller{
      display:inline-flex;align-items:center;justify-content:center;gap:.5rem;
      width:100%;padding:.9rem;
      background:var(--accent);color:var(--ink);
      border-radius:100px;font-size:.9rem;font-weight:700;
      text-decoration:none;font-family:var(--font-sans);
      transition:all var(--ease-home);
    }
    .btn-seller:hover{background:var(--gold-l);transform:translateY(-2px);text-decoration:none;color:var(--ink)}
    .btn-seller-note{text-align:center;margin-top:.8rem;font-size:.7rem;color:rgba(250,250,249,.25)}
    .btn-seller-note a{color:var(--gold-l);text-decoration:none}
    .btn-seller-note a:hover{text-decoration:underline}

    /* ── FOOTER ─────────────────────────── */
    .site-footer{background:var(--ink);padding:2.75rem 2.5rem 1.75rem}
    [data-theme="dark"] .site-footer{background:#070503}
    .footer-inner{max-width:1080px;margin:0 auto;display:flex;justify-content:space-between;align-items:flex-start;gap:2rem;flex-wrap:wrap}
    .footer-brand a{
      font-family:var(--font-serif);font-size:1.2rem;
      color:#FAF9F8;text-decoration:none;
      display:inline-flex;align-items:center;gap:.55rem;
    }
    .footer-brand a span{color:var(--gold-l)}
    .footer-brand a:hover{opacity:.8}
    .footer-brand img{width:28px;height:28px;object-fit:contain;border-radius:5px;opacity:.8}
    .footer-tagline{font-size:.75rem;color:rgba(250,250,249,.28);margin-top:.3rem}
    .footer-links{display:flex;flex-direction:column;gap:.4rem}
    .footer-links a{font-size:.8rem;color:rgba(250,250,249,.32);text-decoration:none;transition:color var(--ease-fast)}
    .footer-links a:hover{color:var(--gold-l)}
    .footer-bottom{
      max-width:1080px;margin:2rem auto 0;
      padding-top:1.4rem;border-top:1px solid rgba(255,255,255,.06);
      display:flex;justify-content:space-between;
      font-size:.7rem;color:rgba(250,250,249,.18);flex-wrap:wrap;gap:.4rem;
    }

    /* ── RESPONSIVE ─────────────────────── */
    @media(max-width:1024px){
      .features-grid{grid-template-columns:1fr}.auction-preview{display:none}
      .seller-grid{grid-template-columns:1fr}
    }
    @media(max-width:768px){
      .hn{padding:0 1.25rem}
      .hn-links{display:none}
      .hn-burger{display:flex}
      .hero-3d{display:none}
      .hero-ring-2,.hero-ring-3{display:none}
      .inner{padding:4rem 1.25rem}
      .stats-bar-item{padding:1.75rem 2rem}
      .site-footer{padding:2rem 1.25rem 1.5rem}
    }
    @media(max-width:480px){
      .hero-title{font-size:clamp(2rem,9vw,2.75rem)}
      .hero-ring-1{width:360px;height:360px}
      .hero-btns .btn-hero-p,.hero-btns .btn-hero-o{padding:.75rem 1.4rem;font-size:.85rem}
    }
    @media(min-width:769px){.hn-mobile{display:none!important}}
  </style>
</head>
<body>
@php $is_logged_in = session('status') === 'login'; @endphp

{{-- ─── NAVBAR ─────────────────────────────── --}}
<nav class="hn" id="hn">
  <a href="{{ route('home') }}" class="hn-brand">
    <img src="{{ asset('assets/images/logo.png') }}" alt="LuxBid">
    Lux<span>Bid</span>
  </a>

  <ul class="hn-links">
    <li><a href="#how">Cara Kerja</a></li>
    <li><a href="#auctions">Lelang Aktif</a></li>
    <li><a href="#features">Fitur</a></li>
    @if($is_logged_in)
      <li><a href="{{ route('masyarakat.index') }}" style="color:var(--accent);font-weight:600"><i class="fas fa-user-circle"></i> {{ session('username') }}</a></li>
      <li><a href="{{ route('logout') }}" class="hn-cta">Keluar</a></li>
    @else
      <li><a href="{{ route('login.masyarakat') }}">Masuk</a></li>
      <li><a href="/login-admin" style="font-size:.77rem;color:var(--text-2);border:1.5px solid var(--border-2);border-radius:100px;padding:.38rem .9rem;transition:all var(--ease-fast)" onmouseover="this.style.borderColor='var(--accent-ln)';this.style.color='var(--accent)'" onmouseout="this.style.borderColor='var(--border-2)';this.style.color='var(--text-2)'"><i class="fas fa-user-shield" style="font-size:.7rem"></i> Staff</a></li>
      <li><a href="{{ route('daftar.masyarakat') }}" class="hn-cta">Daftar Gratis</a></li>
    @endif
  </ul>

  <div class="hn-right">
    <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode"><i class="fas fa-moon"></i></button>
    <button class="hn-burger" id="hn-burger" aria-label="Menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

{{-- Mobile nav --}}
<div class="hn-mobile" id="hn-mobile">
  <a href="#how" onclick="closeMobile()">Cara Kerja</a>
  <a href="#auctions" onclick="closeMobile()">Lelang Aktif</a>
  <a href="#features" onclick="closeMobile()">Fitur</a>
  @if($is_logged_in)
    <a href="{{ route('masyarakat.index') }}" onclick="closeMobile()" style="color:var(--accent);font-weight:600"><i class="fas fa-user-circle"></i> {{ session('username') }}</a>
    <a href="{{ route('logout') }}" class="m-cta" onclick="closeMobile()">Keluar</a>
  @else
    <a href="{{ route('login.masyarakat') }}" onclick="closeMobile()">Masuk</a>
    <a href="/login-admin" onclick="closeMobile()"><i class="fas fa-user-shield" style="font-size:.8rem"></i> Login Staff</a>
    <a href="{{ route('daftar.masyarakat') }}" class="m-cta" onclick="closeMobile()">Daftar Gratis</a>
  @endif
</div>

{{-- ─── HERO ─────────────────────────────────── --}}
<section class="hero">
  {{-- Depth rings --}}
  <div class="hero-ring hero-ring-1"></div>
  <div class="hero-ring hero-ring-2"></div>
  <div class="hero-ring hero-ring-3"></div>
  <div class="hero-glow"></div>

  {{-- Floating 3D objects --}}
  <div class="hero-3d hero-3d-hammer"><div class="float-obj"><i class="fas fa-gavel"></i></div></div>
  <div class="hero-3d hero-3d-gem"><div class="float-obj" style="font-size:1.5rem"><i class="bi bi-gem"></i></div></div>
  <div class="hero-3d hero-3d-tag"><div class="float-obj" style="font-size:1.5rem"><i class="bi bi-tag"></i></div></div>
  <div class="hero-3d hero-3d-coin"><div class="float-obj" style="font-size:1.4rem"><i class="bi bi-coin"></i></div></div>

  <div class="hero-badge">Platform Pelelangan Resmi &amp; Terpercaya</div>

  <h1 class="hero-title">
    Ikuti Lelang,<br>Dapatkan Barang <em>Impianmu</em>
  </h1>

  <p class="hero-sub">
    Pelelangan online yang transparan, aman, dan mudah diakses.<br>
    Daftar gratis dan mulai menawar sekarang.
  </p>

  <div class="hero-btns">
    <a href="{{ route('daftar.masyarakat') }}" class="btn-hero-p">
      <i class="fas fa-user-plus"></i> Daftar Sekarang
    </a>
    <a href="#how" class="btn-hero-o">
      Pelajari Cara Kerja
    </a>
  </div>

  <div class="hero-trust">
    <span class="hero-trust-dot"></span>
    Platform aktif &middot; Lebih dari 2.400+ peserta terdaftar
  </div>
</section>

{{-- ─── STATS BAR ───────────────────────────── --}}
<div class="stats-bar">
  <div class="stats-bar-item"><span class="stats-bar-n">2.400+</span><div class="stats-bar-l">Pengguna Terdaftar</div></div>
  <div class="stats-bar-item"><span class="stats-bar-n">890+</span><div class="stats-bar-l">Lelang Selesai</div></div>
  <div class="stats-bar-item"><span class="stats-bar-n">99%</span><div class="stats-bar-l">Transaksi Sukses</div></div>
  <div class="stats-bar-item"><span class="stats-bar-n">50+</span><div class="stats-bar-l">Kategori Barang</div></div>
</div>

{{-- ─── HOW IT WORKS ────────────────────────── --}}
<section class="sec" id="how">
  <div class="inner">
    <span class="sec-lbl rv">Proses Mudah</span>
    <h2 class="sec-title rv">Cara Kerja Lelang</h2>
    <p class="sec-desc rv">Hanya beberapa langkah untuk mulai mengikuti lelang dan mendapatkan barang incaran Anda.</p>

    <div class="steps-grid">
      <div class="step-card rv">
        <div class="step-num">01</div>
        <div class="step-ico"><i class="bi bi-pencil-square"></i></div>
        <h4>Daftar Akun</h4>
        <p>Buat akun gratis dengan data diri. Verifikasi dilakukan cepat oleh petugas kami.</p>
      </div>
      <div class="step-card rv delay-1">
        <div class="step-num">02</div>
        <div class="step-ico"><i class="bi bi-search"></i></div>
        <h4>Cari Barang Lelang</h4>
        <p>Telusuri daftar barang yang sedang dilelang. Filter sesuai kategori dan harga.</p>
      </div>
      <div class="step-card rv delay-2">
        <div class="step-num">03</div>
        <div class="step-ico"><i class="bi bi-cash-coin"></i></div>
        <h4>Ajukan Penawaran</h4>
        <p>Masukkan nominal penawaran. Pantau terus karena waktu lelang sangat terbatas!</p>
      </div>
      <div class="step-card rv delay-3">
        <div class="step-num">04</div>
        <div class="step-ico"><i class="bi bi-trophy"></i></div>
        <h4>Menang &amp; Selesai</h4>
        <p>Penawar tertinggi saat waktu habis menjadi pemenang resmi dan dapat download faktur.</p>
      </div>
    </div>
  </div>
</section>

{{-- ─── FEATURES ────────────────────────────── --}}
<section class="sec" id="features">
  <div class="inner">
    <span class="sec-lbl rv">Mengapa Kami</span>
    <h2 class="sec-title rv">Fitur Unggulan Platform</h2>
    <p class="sec-desc rv">Dirancang untuk pengalaman lelang yang transparan, aman, dan menyenangkan.</p>

    <div class="features-grid rv">
      <div class="feature-list">
        <div class="feature-item">
          <div class="feature-ico"><i class="bi bi-shield-lock"></i></div>
          <div><h5>Keamanan Terjamin</h5><p>Data &amp; transaksi Anda terlindungi. Semua pengguna terverifikasi oleh petugas resmi.</p></div>
        </div>
        <div class="feature-item">
          <div class="feature-ico"><i class="bi bi-broadcast"></i></div>
          <div><h5>Penawaran Real-Time</h5><p>Lihat penawaran terbaru secara langsung setiap 3 detik tanpa perlu reload halaman.</p></div>
        </div>
        <div class="feature-item">
          <div class="feature-ico"><i class="bi bi-bar-chart-line"></i></div>
          <div><h5>Riwayat Transparan</h5><p>Semua histori penawaran dan transaksi tercatat lengkap dan dapat diakses kapan saja.</p></div>
        </div>
        <div class="feature-item">
          <div class="feature-ico"><i class="bi bi-phone"></i></div>
          <div><h5>Akses dari Mana Saja</h5><p>Platform responsif, nyaman digunakan dari HP, tablet, maupun komputer.</p></div>
        </div>
      </div>

      <div class="auction-preview">
        <div class="ap-bar">
          <div class="ap-dot" style="background:#FF6058"></div>
          <div class="ap-dot" style="background:#FFBC2E"></div>
          <div class="ap-dot" style="background:#29CB41"></div>
          <span class="ap-title">LuxBid — Lelang Aktif</span>
        </div>
        @if($lelang_aktif->isEmpty())
          <div class="ap-lot" style="text-align:center;padding:2rem;color:var(--text-2)">
            <div style="font-size:1.75rem;opacity:.2;margin-bottom:.5rem"><i class="bi bi-box-seam"></i></div>
            <div style="font-size:.85rem">Belum ada lelang aktif saat ini.</div>
          </div>
        @else
          @foreach($lelang_aktif->take(2) as $i => $l)
          @php $harga_tampil = $l->penawaran_tertinggi ?? $l->barang->harga_awal; @endphp
          <div class="ap-lot" @if($i>0) style="opacity:.8" @endif>
            <div class="ap-lot-cat">Lot #{{ str_pad($l->id_lelang,4,'0',STR_PAD_LEFT) }} &middot; {{ \Carbon\Carbon::parse($l->tgl_lelang)->format('d M Y') }}</div>
            <div class="ap-lot-name">{{ $l->barang->nama_barang }}</div>
            <div style="font-size:.72rem;color:var(--text-2)">{{ $l->jumlah_penawar }} penawar</div>
            <div class="ap-lot-row">
              <div>
                <div style="font-size:.65rem;color:var(--text-3)">{{ $l->penawaran_tertinggi ? 'Tertinggi' : 'Harga awal' }}</div>
                <div class="ap-lot-price">Rp {{ number_format($harga_tampil,0,',','.') }}</div>
              </div>
              <div class="ap-live-badge">Live</div>
            </div>
            @if($i === 0)
              @if($is_logged_in)
                <a href="{{ route('masyarakat.penawaran') }}" class="ap-bid-btn">Ajukan Penawaran &rarr;</a>
              @else
                <a href="#access" class="ap-bid-btn">Masuk untuk Menawar</a>
              @endif
            @endif
          </div>
          @endforeach
          @if($lelang_aktif->count() > 2)
            <div style="text-align:center;font-size:.73rem;color:var(--text-3);margin-top:.5rem">
              +{{ $lelang_aktif->count() - 2 }} lelang aktif lainnya
            </div>
          @endif
        @endif
      </div>
    </div>
  </div>
</section>

{{-- ─── LIVE AUCTIONS ───────────────────────── --}}
<section class="sec" id="auctions">
  <div class="inner">
    <span class="sec-lbl rv">Live Sekarang</span>
    <h2 class="sec-title rv">Lelang Aktif</h2>
    <p class="sec-desc rv">Barang-barang berikut sedang dalam proses lelang. Login untuk mengajukan penawaran.</p>

    @if($lelang_aktif->isEmpty())
      <div class="empty-box rv">
        <div class="empty-box-ico"><i class="bi bi-box-seam"></i></div>
        <h3>Belum Ada Lelang Aktif</h3>
        <p>Saat ini belum ada lelang yang sedang berjalan. Pantau terus untuk update terbaru.</p>
      </div>
    @else
      <div class="auction-grid">
        @foreach($lelang_aktif as $l)
        @php
          $harga_tampil = $l->penawaran_tertinggi ?? $l->barang->harga_awal;
          $ada_penawaran = !is_null($l->penawaran_tertinggi);
        @endphp
        <div class="auction-card rv">
          @if($l->foto)
            <img src="{{ asset('uploads/barang/'.$l->foto) }}" class="auction-card-img" alt="{{ $l->barang->nama_barang }}">
          @else
            <div class="auction-card-imgph"><i class="bi bi-box-seam"></i></div>
          @endif
          <div class="auction-card-body">
            <div class="auction-card-top">
              <div class="ac-live">Aktif</div>
              <div class="ac-lot">Lot #{{ str_pad($l->id_lelang,4,'0',STR_PAD_LEFT) }}</div>
            </div>
            <div class="ac-name">{{ $l->barang->nama_barang }}</div>
            @if($l->barang->deskripsi_barang)
              <p class="ac-desc">{{ Str::limit($l->barang->deskripsi_barang, 80) }}</p>
            @endif
            <div class="ac-meta">
              <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($l->tgl_lelang)->format('d M Y') }}</span>
              <span><i class="fas fa-users"></i> {{ $l->jumlah_penawar }} penawar</span>
            </div>
            <div class="ac-price-box">
              <div>
                <div class="ac-price-lbl">{{ $ada_penawaran ? 'Penawaran tertinggi' : 'Harga awal' }}</div>
                <div class="ac-price">Rp {{ number_format($harga_tampil,0,',','.') }}</div>
              </div>
              @if($ada_penawaran)
                <div style="text-align:right;font-size:.7rem;color:var(--text-3)">
                  Harga awal<br>
                  <span style="color:var(--text-2);font-weight:500">Rp {{ number_format($l->barang->harga_awal,0,',','.') }}</span>
                </div>
              @endif
            </div>
            @if($is_logged_in)
              <a href="{{ route('masyarakat.penawaran') }}" class="ac-btn">
                <i class="fas fa-gavel"></i> Ajukan Penawaran
              </a>
            @else
              <div class="ac-gate">
                <p><i class="fas fa-lock" style="font-size:.75rem"></i> Login untuk mengajukan penawaran</p>
                <div class="ac-gate-btns">
                  <a href="{{ route('login.masyarakat') }}" class="ac-gate-login">Masuk</a>
                  <a href="{{ route('daftar.masyarakat') }}" class="ac-gate-reg">Daftar Gratis</a>
                </div>
              </div>
            @endif
          </div>
        </div>
        @endforeach
      </div>

      @if(!$is_logged_in)
        <div style="margin-top:2.25rem;text-align:center" class="rv">
          <p style="font-size:.87rem;color:var(--text-2);margin-bottom:1.1rem">Sudah punya akun? Langsung masuk dan ikuti lelang.</p>
          <a href="{{ route('login.masyarakat') }}" class="btn-hero-p" style="display:inline-flex">
            <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
          </a>
          <span style="margin:0 .75rem;color:var(--text-3);font-size:.85rem">atau</span>
          <a href="{{ route('daftar.masyarakat') }}" class="btn-hero-o" style="display:inline-flex">Daftar Akun Gratis</a>
        </div>
      @endif
    @endif
  </div>
</section>

{{-- ─── ACCESS / LOGIN ─────────────────────── --}}
<section class="sec" id="access">
  <div class="inner">
    <span class="sec-lbl rv">Akses Platform</span>
    <h2 class="sec-title rv">Login ke LuxBid</h2>
    <p class="sec-desc rv">Masuk atau daftar untuk mulai mengikuti lelang aktif secara langsung.</p>

    <div class="access-card rv">
      <div class="access-ico"><i class="fas fa-gavel"></i></div>
      <h3 class="access-title">Peserta Lelang</h3>
      <p class="access-desc">Ikuti lelang, ajukan penawaran, dan menangkan barang incaran Anda di platform pelelangan terpercaya.</p>
      <ul class="access-checks">
        <li>Akses semua lelang aktif secara real-time</li>
        <li>Ajukan dan perbarui penawaran kapan saja</li>
        <li>Pantau riwayat &amp; status penawaran Anda</li>
        <li>Download faktur resmi jika menjadi pemenang</li>
      </ul>
      <a href="{{ route('login.masyarakat') }}" class="access-btn">
        <i class="fas fa-sign-in-alt"></i> Masuk sebagai Peserta
      </a>
      <div class="access-reg">
        Belum punya akun? <a href="{{ route('daftar.masyarakat') }}">Daftar di sini &rarr;</a>
      </div>
      <div style="text-align:center;margin-top:.75rem">
        <a href="/login-admin" class="access-staff">
          <i class="fas fa-user-shield" style="font-size:.7rem"></i> Login sebagai Staff / Admin
        </a>
      </div>
    </div>
  </div>
</section>

{{-- ─── SELLER CTA ──────────────────────────── --}}
<section class="sec" id="seller">
  <div class="seller-ring-1"></div>
  <div class="seller-ring-2"></div>
  <div class="inner">
    <div class="seller-grid">
      <div>
        <span class="seller-lbl">Untuk Pemilik Barang</span>
        <h2 class="seller-title">Lelang Barang Anda<br><em>Bersama LuxBid</em></h2>
        <p class="seller-desc">Percayakan barang berharga Anda kepada platform lelang yang transparan, aman, dan dikelola tim profesional.</p>
        <div class="seller-steps">
          <div class="seller-step">
            <div class="seller-step-n">1</div>
            <div class="seller-step-body"><h4>Hubungi Tim Kami</h4><p>Kirim pesan via WhatsApp atau email. Tim kami merespons dalam 1×24 jam.</p></div>
          </div>
          <div class="seller-step">
            <div class="seller-step-n">2</div>
            <div class="seller-step-body"><h4>Verifikasi &amp; Penilaian</h4><p>Petugas memverifikasi kondisi dan menentukan harga awal yang wajar.</p></div>
          </div>
          <div class="seller-step">
            <div class="seller-step-n">3</div>
            <div class="seller-step-body"><h4>Lelang Dibuka</h4><p>Barang Anda dilelang secara live dan dapat dipantau penawaran secara real-time.</p></div>
          </div>
          <div class="seller-step">
            <div class="seller-step-n">4</div>
            <div class="seller-step-body"><h4>Terima Hasil</h4><p>Setelah lelang selesai, hasil transaksi diproses dan diserahkan kepada Anda.</p></div>
          </div>
        </div>
      </div>

      <div class="seller-card rv">
        <span class="seller-lbl">Keuntungan Bergabung</span>
        <h3 style="font-family:var(--font-serif);font-size:1.35rem;color:#FAF9F8;margin-top:.4rem;line-height:1.2">
          Mengapa Memilih LuxBid?
        </h3>
        <div class="seller-perks">
          <div class="seller-perk"><div class="seller-perk-ico"><i class="fas fa-shield-alt"></i></div> Proses lelang transparan &amp; terpercaya</div>
          <div class="seller-perk"><div class="seller-perk-ico"><i class="fas fa-users"></i></div> Jangkauan ribuan peserta aktif</div>
          <div class="seller-perk"><div class="seller-perk-ico"><i class="fas fa-bolt"></i></div> Harga terbaik melalui kompetisi penawaran</div>
          <div class="seller-perk"><div class="seller-perk-ico"><i class="fas fa-headset"></i></div> Didampingi petugas dari awal hingga selesai</div>
          <div class="seller-perk"><div class="seller-perk-ico"><i class="fas fa-file-alt"></i></div> Laporan hasil lelang resmi &amp; tercatat</div>
          <div class="seller-perk"><div class="seller-perk-ico"><i class="fas fa-lock"></i></div> Data barang &amp; transaksi terjaga keamanannya</div>
        </div>
        <a href="/kontak" class="btn-seller">
          <i class="fas fa-paper-plane"></i> Konsultasi Gratis Sekarang
        </a>
        <div class="btn-seller-note">
          Atau hubungi via <a href="https://wa.me/6285869074622" target="_blank" rel="noopener">WhatsApp</a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ─── FOOTER ──────────────────────────────── --}}
<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-brand">
      <a href="{{ route('home') }}">
        <img src="{{ asset('assets/images/logo.png') }}" alt="LuxBid">
        Lux<span>Bid</span>
      </a>
      <p class="footer-tagline">Platform Pelelangan Online</p>
    </div>
    <div class="footer-links">
      <a href="/kontak">Kontak</a>
      <a href="/bantuan">Bantuan &amp; FAQ</a>
      <a href="/kebijakan-privasi">Kebijakan Privasi</a>
    </div>
  </div>
  <div class="footer-bottom">
    <span>&copy; 2026 LuxBid. Hak cipta dilindungi.</span>
    <span>Made by TEAM HUNTERS &middot; MIT License</span>
  </div>
</footer>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/theme.js') }}"></script>
<script>
// Mobile menu toggle
const hnBurger = document.getElementById('hn-burger');
const hnMobile = document.getElementById('hn-mobile');
let mobileOpen = false;

function openMobile() {
  mobileOpen = true;
  hnMobile.classList.add('open');
  document.body.style.overflow = 'hidden';
  hnBurger.setAttribute('aria-expanded', 'true');
  // Animate spans to X
  const spans = hnBurger.querySelectorAll('span');
  spans[0].style.transform = 'translateY(6.5px) rotate(45deg)';
  spans[1].style.opacity = '0';
  spans[2].style.transform = 'translateY(-6.5px) rotate(-45deg)';
}
function closeMobile() {
  mobileOpen = false;
  hnMobile.classList.remove('open');
  document.body.style.overflow = '';
  hnBurger.setAttribute('aria-expanded', 'false');
  const spans = hnBurger.querySelectorAll('span');
  spans[0].style.transform = '';
  spans[1].style.opacity = '';
  spans[2].style.transform = '';
}
hnBurger.addEventListener('click', () => mobileOpen ? closeMobile() : openMobile());

// Scroll reveal
const rvEls = document.querySelectorAll('.rv');
const obs = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('in'); obs.unobserve(e.target); }
  });
}, { threshold: 0.10 });
rvEls.forEach(el => obs.observe(el));

// Navbar subtle scroll effect
window.addEventListener('scroll', () => {
  const nav = document.getElementById('hn');
  if (window.scrollY > 30) {
    nav.style.boxShadow = '0 2px 20px rgba(28,25,23,.1)';
  } else {
    nav.style.boxShadow = '';
  }
}, { passive: true });
</script>
</body>
</html>
