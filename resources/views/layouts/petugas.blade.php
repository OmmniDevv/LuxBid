<!DOCTYPE html>
<html lang="id">
<head>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Lux Bid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    /* ── ADMIN SIDEBAR LAYOUT ─────────────────────────────── */
    :root{
      --sb-w: 240px;
      --sb-w-col: 64px;
      --sb-bg: var(--surface);
      --sb-border: var(--border);
    }

    html { margin: 0; padding: 0; }
    body { margin: 0; padding: 0; font-family: var(--font-sans); background: var(--bg); }

    /* Admin wrapper: sidebar + content side-by-side */
    .admin-wrapper {
      display: flex;
      min-height: 100vh;
    }

    /* ── SIDEBAR ───────────────────────────── */
    .sb {
      position: fixed;
      inset: 0 auto 0 0;
      width: var(--sb-w);
      background: var(--sb-bg);
      border-right: 1px solid var(--sb-border);
      box-shadow: 4px 0 24px rgba(28,25,23,.06);
      display: flex;
      flex-direction: column;
      z-index: 300;
      transition: width 280ms cubic-bezier(.4,0,.2,1), transform 280ms cubic-bezier(.4,0,.2,1);
      overflow: hidden;
    }

    .sb.collapsed { width: var(--sb-w-col); }

    [data-theme="dark"] .sb {
      box-shadow: 4px 0 24px rgba(0,0,0,.25);
    }

    /* Brand */
    .sb-brand {
      display: flex;
      align-items: center;
      gap: .65rem;
      padding: 1.3rem 1.2rem 1.1rem;
      text-decoration: none;
      color: var(--text);
      border-bottom: 1px solid var(--sb-border);
      min-height: 68px;
      flex-shrink: 0;
      transition: opacity 200ms ease;
      overflow: hidden;
      white-space: nowrap;
    }
    .sb-brand:hover { opacity: .85; text-decoration: none; color: var(--text); }
    .sb-brand img { width: 34px; height: 34px; object-fit: contain; border-radius: 8px; flex-shrink: 0; }
    .sb-brand-text {
      font-family: var(--font-serif);
      font-size: 1.25rem;
      font-weight: 700;
      letter-spacing: -.01em;
      white-space: nowrap;
    }
    .sb-brand-text span { color: var(--accent); }
    .sb-brand-badge {
      font-family: var(--font-sans);
      font-size: .53rem; font-weight: 700; letter-spacing: .09em;
      text-transform: uppercase;
      background: var(--accent-p); color: var(--accent);
      border: 1px solid var(--accent-ln);
      padding: .15rem .45rem; border-radius: 100px;
      flex-shrink: 0;
    }
    .sb.collapsed .sb-brand-text,
    .sb.collapsed .sb-brand-badge { display: none; }

    /* Nav list */
    .sb-nav {
      flex: 1;
      padding: .9rem 0;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .sb-nav-label {
      font-family: var(--font-sans);
      font-size: .6rem; font-weight: 700; letter-spacing: .1em;
      text-transform: uppercase;
      color: var(--text-3);
      padding: .9rem 1.3rem .35rem;
      white-space: nowrap;
      overflow: hidden;
    }
    .sb.collapsed .sb-nav-label { opacity: 0; }

    .sb-link {
      display: flex;
      align-items: center;
      gap: .75rem;
      padding: .6rem 1.2rem;
      margin: .1rem .55rem;
      border-radius: var(--rs);
      font-family: var(--font-sans);
      font-size: .82rem; font-weight: 500;
      color: var(--text-2);
      text-decoration: none;
      white-space: nowrap;
      overflow: hidden;
      transition: background 200ms ease, color 200ms ease;
      position: relative;
    }
    .sb-link:hover {
      background: var(--accent-p);
      color: var(--text);
      text-decoration: none;
    }
    .sb-link.active {
      background: var(--accent-p);
      color: var(--accent);
      font-weight: 600;
    }
    .sb-link.active::before {
      content: '';
      position: absolute;
      left: 0; top: 20%; bottom: 20%;
      width: 3px;
      background: var(--accent);
      border-radius: 0 3px 3px 0;
    }
    .sb-link svg { flex-shrink: 0; width: 16px; height: 16px; }
    .sb-link-text { overflow: hidden; text-overflow: ellipsis; }
    .sb.collapsed .sb-link-text { display: none; }
    .sb.collapsed .sb-link { justify-content: center; padding: .6rem 0; margin: .1rem .75rem; }
    .sb.collapsed .sb-link.active::before { top: 15%; bottom: 15%; }

    /* Tooltip on collapsed */
    .sb.collapsed .sb-link { position: relative; }
    .sb.collapsed .sb-link[data-tip]::after {
      content: attr(data-tip);
      position: absolute;
      left: calc(100% + 10px);
      top: 50%; transform: translateY(-50%);
      background: var(--ink-s);
      color: #fff;
      font-size: .72rem; font-weight: 500;
      padding: .3rem .65rem;
      border-radius: var(--rss);
      white-space: nowrap;
      pointer-events: none;
      opacity: 0;
      transition: opacity 150ms ease;
      z-index: 400;
    }
    .sb.collapsed .sb-link[data-tip]:hover::after { opacity: 1; }

    /* Bottom section */
    .sb-bottom {
      padding: .85rem .55rem 1rem;
      border-top: 1px solid var(--sb-border);
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      gap: .3rem;
    }

    .sb-user {
      display: flex;
      align-items: center;
      gap: .65rem;
      padding: .55rem .65rem;
      border-radius: var(--rs);
      overflow: hidden;
      white-space: nowrap;
    }
    .sb-user-info { overflow: hidden; }
    .sb-user-name {
      font-size: .8rem; font-weight: 600;
      color: var(--text);
      overflow: hidden; text-overflow: ellipsis;
    }
    .sb-user-role {
      font-size: .67rem; color: var(--text-3); letter-spacing: .03em;
      overflow: hidden; text-overflow: ellipsis;
    }
    .sb.collapsed .sb-user-info { display: none; }
    .sb.collapsed .sb-user { justify-content: center; padding: .55rem 0; }

    .sb-actions {
      display: flex;
      gap: .35rem;
      padding: 0 .1rem;
    }
    .sb.collapsed .sb-actions { flex-direction: column; align-items: center; }

    .sb-logout {
      flex: 1;
      display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
      font-family: var(--font-sans); font-size: .76rem; font-weight: 500;
      color: var(--text-2); text-decoration: none;
      padding: .4rem .7rem; border-radius: var(--rss);
      border: 1.5px solid var(--border-2);
      background: transparent; cursor: pointer;
      transition: all 180ms ease;
      white-space: nowrap; overflow: hidden;
    }
    .sb-logout:hover { background: var(--danger-bg); color: var(--danger); border-color: var(--danger-border); text-decoration: none; }
    .sb-logout svg { flex-shrink: 0; width: 14px; height: 14px; }
    .sb-logout-text { overflow: hidden; }
    .sb.collapsed .sb-logout-text { display: none; }
    .sb.collapsed .sb-logout { flex: unset; padding: .45rem; }

    .sb-collapse-btn {
      display: inline-flex; align-items: center; justify-content: center;
      width: 30px; height: 30px;
      background: none; border: 1.5px solid var(--border-2);
      border-radius: var(--rss); cursor: pointer;
      color: var(--text-2);
      transition: all 180ms ease;
      flex-shrink: 0;
    }
    .sb-collapse-btn:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-p); }
    .sb-collapse-btn svg { width: 13px; height: 13px; transition: transform 280ms ease; }
    .sb.collapsed .sb-collapse-btn svg { transform: rotate(180deg); }

    /* Dark mode toggle inside sb */
    .sb-dm {
      display: inline-flex; align-items: center; justify-content: center;
      width: 30px; height: 30px;
      background: none; border: 1.5px solid var(--border-2);
      border-radius: var(--rss); cursor: pointer;
      color: var(--text-2);
      transition: all 180ms ease;
      flex-shrink: 0;
    }
    .sb-dm:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-p); }
    .sb-dm svg { width: 13px; height: 13px; }

    /* ── MAIN CONTENT ─────────────────────── */
    .admin-content {
      flex: 1;
      margin-left: var(--sb-w);
      transition: margin-left 280ms cubic-bezier(.4,0,.2,1);
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .admin-content.collapsed { margin-left: var(--sb-w-col); }

    /* Top bar (breadcrumb + actions strip) */
    .admin-topbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: .9rem 2rem;
      border-bottom: 1px solid var(--sb-border);
      background: var(--surface);
      min-height: 52px;
      flex-shrink: 0;
    }
    .admin-topbar-title {
      font-family: var(--font-serif);
      font-size: 1.05rem; font-weight: 600;
      color: var(--text);
      letter-spacing: -.01em;
    }

    /* Mobile topbar (visible only on small screens) */
    .admin-mobile-bar {
      display: none;
      align-items: center;
      justify-content: space-between;
      padding: .85rem 1.25rem;
      border-bottom: 1px solid var(--sb-border);
      background: var(--surface);
      position: sticky;
      top: 0;
      z-index: 250;
    }
    .admin-mobile-brand {
      font-family: var(--font-serif);
      font-size: 1.1rem; font-weight: 700;
      color: var(--text); text-decoration: none;
      letter-spacing: -.01em;
    }
    .admin-mobile-brand span { color: var(--accent); }
    .admin-mobile-actions { display: flex; gap: .4rem; }

    .mn-toggler {
      display: none;
      background: none;
      border: 1.5px solid var(--border-2);
      width: 34px; height: 34px; border-radius: var(--rss);
      cursor: pointer;
      flex-direction: column; align-items: center; justify-content: center; gap: 4px;
      padding: 0;
      transition: border-color 180ms ease;
    }
    .mn-toggler span {
      display: block; width: 15px; height: 1.5px;
      background: var(--text); border-radius: 2px;
      transition: all 280ms ease;
    }
    .mn-toggler:hover { border-color: var(--accent); }

    .admin-main {
      flex: 1;
      padding: 2rem 2rem 3.5rem;
      background: var(--bg);
    }

    /* Sidebar overlay for mobile */
    .sb-overlay {
      display: none;
      position: fixed; inset: 0;
      background: rgba(28,25,23,.45);
      z-index: 299;
      backdrop-filter: blur(2px);
    }

    /* Footer */
    .admin-footer {
      padding: 1rem 2rem;
      border-top: 1px solid var(--sb-border);
      background: var(--surface);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: .5rem;
      font-size: .73rem;
      color: var(--text-3);
      flex-shrink: 0;
    }

    /* ── RESPONSIVE ────────────────────────── */
    @media (max-width: 960px) {
      .sb {
        transform: translateX(-100%);
        width: var(--sb-w) !important; /* always full width on mobile open */
      }
      .sb.mobile-open { transform: translateX(0); }
      .sb-overlay.active { display: block; }
      .sb-collapse-btn { display: none; }

      .admin-content { margin-left: 0 !important; }
      .admin-topbar { display: none; }
      .admin-mobile-bar { display: flex; }
      .mn-toggler { display: flex; }
      .admin-main { padding: 1.25rem 1rem 3rem; }
      .admin-footer { padding: .75rem 1rem; }
    }

    /* Gold divider used in sidebar */
    .sb-divider {
      height: 1px;
      background: var(--sb-border);
      margin: .4rem .55rem;
    }

    /* Alert close button */
    .alert-close {
      background: none; border: none; cursor: pointer;
      color: inherit; opacity: .7; padding: 0; line-height: 1;
    }
    .alert-close:hover { opacity: 1; }
  </style>
  @stack('styles')
</head>
<body>

@php
  $username = session('username', 'Admin');
  $initial = strtoupper(substr($username, 0, 1));
  $isAdmin = session('id_level') == 1;
  $current = request()->route()->getName();
  $prefix = $isAdmin ? 'administrator' : 'petugas';
@endphp

{{-- Sidebar Overlay (mobile) --}}
<div class="sb-overlay" id="sb-overlay"></div>

<div class="admin-wrapper">

  {{-- ── SIDEBAR ───────────────────────────── --}}
  <aside class="sb" id="sidebar">

    {{-- Brand --}}
    <a href="{{ $isAdmin ? route('administrator.index') : route('petugas.index') }}" class="sb-brand">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Lux Bid">
      <span class="sb-brand-text">Lux<span>Bid</span></span>
      <span class="sb-brand-badge">{{ $isAdmin ? 'Admin' : 'Petugas' }}</span>
    </a>

    {{-- Navigation --}}
    <nav class="sb-nav" id="sb-nav">
      <div class="sb-nav-label">Menu Utama</div>

      <a href="{{ $isAdmin ? route('administrator.index') : route('petugas.index') }}"
         class="sb-link {{ in_array($current, ['administrator.index','petugas.index']) ? 'active' : '' }}"
         data-tip="Dasbor">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        <span class="sb-link-text">Dasbor</span>
      </a>

      <a href="{{ $isAdmin ? route('administrator.barang') : route('petugas.barang') }}"
         class="sb-link {{ in_array($current, ['administrator.barang','petugas.barang']) ? 'active' : '' }}"
         data-tip="Pendataan Barang">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
        <span class="sb-link-text">Pendataan Barang</span>
      </a>

      @if($isAdmin)
      <a href="{{ route('administrator.petugas') }}"
         class="sb-link {{ $current === 'administrator.petugas' ? 'active' : '' }}"
         data-tip="Data Petugas">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <span class="sb-link-text">Data Petugas</span>
      </a>
      @else
      <a href="{{ route('petugas.aktivasi') }}"
         class="sb-link {{ $current === 'petugas.aktivasi' ? 'active' : '' }}"
         data-tip="Aktivasi Lelang">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        <span class="sb-link-text">Aktivasi Lelang</span>
      </a>
      @endif

      <a href="{{ $isAdmin ? route('administrator.laporan') : route('petugas.laporan') }}"
         class="sb-link {{ in_array($current, ['administrator.laporan','petugas.laporan']) ? 'active' : '' }}"
         data-tip="Laporan">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        <span class="sb-link-text">Laporan</span>
      </a>
    </nav>

    {{-- Bottom: user + actions --}}
    <div class="sb-bottom">
      <div class="sb-user">
        <div class="mn-avatar" style="background:var(--ink);color:var(--gold-l);border-color:rgba(184,134,11,.3)">{{ $initial }}</div>
        <div class="sb-user-info">
          <div class="sb-user-name">{{ $username }}</div>
          <div class="sb-user-role">{{ $isAdmin ? 'Administrator' : 'Petugas' }}</div>
        </div>
      </div>
      <div class="sb-divider"></div>
      <div class="sb-actions">
        <a href="{{ route('logout.petugas') }}" class="sb-logout">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          <span class="sb-logout-text">Logout</span>
        </a>
        <button class="sb-dm" id="dm-toggle" title="Toggle dark mode" aria-label="Toggle dark mode">
          <svg id="dm-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
          <svg id="dm-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </button>
        <button class="sb-collapse-btn" id="sb-collapse-btn" title="Collapse sidebar" aria-label="Collapse sidebar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
      </div>
    </div>

  </aside>

  {{-- ── MAIN CONTENT ─────────────────────── --}}
  <div class="admin-content" id="admin-content">

    {{-- Mobile top bar --}}
    <div class="admin-mobile-bar">
      <a href="{{ $isAdmin ? route('administrator.index') : route('petugas.index') }}" class="admin-mobile-brand">Lux<span>Bid</span></a>
      <div class="admin-mobile-actions">
        <button class="sb-dm" id="dm-toggle-mobile" title="Toggle dark mode" aria-label="Toggle dark mode">
          <svg id="dm-icon-moon-m" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
          <svg id="dm-icon-sun-m" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        </button>
        <button class="mn-toggler" id="mn-toggler" aria-label="Menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>

    {{-- Desktop top bar --}}
    <div class="admin-topbar">
      <span class="admin-topbar-title">
        @if(in_array($current, ['administrator.index','petugas.index'])) Dasbor
        @elseif(in_array($current, ['administrator.barang','petugas.barang'])) Pendataan Barang
        @elseif($current === 'administrator.petugas') Data Petugas
        @elseif($current === 'petugas.aktivasi') Aktivasi Lelang
        @elseif(in_array($current, ['administrator.laporan','petugas.laporan'])) Laporan
        @else Panel {{ $isAdmin ? 'Administrator' : 'Petugas' }}
        @endif
      </span>
      <span style="font-size:.75rem;color:var(--text-3);font-family:var(--font-sans)">
        Selamat datang, <strong style="color:var(--text)">{{ $username }}</strong>
      </span>
    </div>

    {{-- Page content --}}
    <main class="admin-main">
      @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="admin-footer">
      <span>&copy; 2026 <strong>Lux Bid</strong> &mdash; Platform Pelelangan Online</span>
      <span>Made by &middot; TEAM HUNTERS</span>
    </footer>

  </div>{{-- /admin-content --}}

</div>{{-- /admin-wrapper --}}

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
(function () {
  'use strict';

  // ── Sidebar collapse (desktop) ─────────────
  var sb = document.getElementById('sidebar');
  var content = document.getElementById('admin-content');
  var colBtn = document.getElementById('sb-collapse-btn');
  var SB_KEY = 'sb_collapsed';

  function applyCollapse(collapsed) {
    if (collapsed) {
      sb.classList.add('collapsed');
      content.classList.add('collapsed');
    } else {
      sb.classList.remove('collapsed');
      content.classList.remove('collapsed');
    }
  }

  applyCollapse(localStorage.getItem(SB_KEY) === '1');

  if (colBtn) {
    colBtn.addEventListener('click', function () {
      var isCol = sb.classList.contains('collapsed');
      localStorage.setItem(SB_KEY, isCol ? '0' : '1');
      applyCollapse(!isCol);
    });
  }

  // ── Mobile sidebar toggle ──────────────────
  var toggler = document.getElementById('mn-toggler');
  var overlay = document.getElementById('sb-overlay');

  function openMobileSb() {
    sb.classList.add('mobile-open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
  function closeMobileSb() {
    sb.classList.remove('mobile-open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  if (toggler) toggler.addEventListener('click', function () {
    sb.classList.contains('mobile-open') ? closeMobileSb() : openMobileSb();
  });
  if (overlay) overlay.addEventListener('click', closeMobileSb);

  // Close mobile sidebar when a nav link is clicked
  if (sb) {
    sb.querySelectorAll('.sb-link').forEach(function (a) {
      a.addEventListener('click', function () {
        if (window.innerWidth <= 960) closeMobileSb();
      });
    });
  }

  // ── Alert close ────────────────────────────
  document.querySelectorAll('.alert-close').forEach(function (btn) {
    btn.addEventListener('click', function () { btn.closest('.alert-m').remove(); });
  });

  // ── Fade-up observer ───────────────────────
  var fadeEls = document.querySelectorAll('.fade-up');
  if (fadeEls.length && 'IntersectionObserver' in window) {
    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e, i) {
        if (e.isIntersecting) {
          setTimeout(function () { e.target.style.animationPlayState = 'running'; }, i * 60);
          obs.unobserve(e.target);
        }
      });
    }, { threshold: 0.1 });
    fadeEls.forEach(function (el) { el.style.animationPlayState = 'paused'; obs.observe(el); });
  }

  // ── Dark mode icon sync ────────────────────
  function syncDmIcons() {
    var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    ['', '-m'].forEach(function (sfx) {
      var moon = document.getElementById('dm-icon-moon' + sfx);
      var sun = document.getElementById('dm-icon-sun' + sfx);
      if (moon) moon.style.display = isDark ? 'none' : '';
      if (sun) sun.style.display = isDark ? '' : 'none';
    });
  }
  syncDmIcons();

  // Attach dm toggle listeners (theme.js handles the actual toggle via #dm-toggle)
  var dmMobile = document.getElementById('dm-toggle-mobile');
  if (dmMobile) {
    dmMobile.addEventListener('click', function () {
      var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
      var next = isDark ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('theme', next);
      syncDmIcons();
    });
  }
  var dmMain = document.getElementById('dm-toggle');
  if (dmMain) {
    dmMain.addEventListener('click', function () {
      syncDmIcons();
    });
  }
})();
</script>
@stack('scripts')

<script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
