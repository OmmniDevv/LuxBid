<!DOCTYPE html>
<html lang="id">
<head>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Lux Bid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/modern.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  @stack('styles')
</head>
<body>
<div class="page-wrapper">

@php
  $username = session('username', 'Admin');
  $initial = strtoupper(substr($username, 0, 1));
  $isAdmin = session('id_level') == 1;
  $current = request()->route()->getName();
  $prefix = $isAdmin ? 'administrator' : 'petugas';
@endphp

<nav class="mn-nav">
  <a href="{{ $isAdmin ? route('administrator.index') : route('petugas.index') }}" class="mn-brand">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Lux Bid">
    Lux<span>Bid</span>
    <span class="mn-brand-badge">{{ $isAdmin ? 'Admin' : 'Petugas' }}</span>
  </a>
  <ul class="mn-links" id="mn-links">
    <li><a href="{{ $isAdmin ? route('administrator.index') : route('petugas.index') }}" class="{{ in_array($current, ['administrator.index','petugas.index']) ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dasbor</a></li>
    <li><a href="{{ $isAdmin ? route('administrator.barang') : route('petugas.barang') }}" class="{{ in_array($current, ['administrator.barang','petugas.barang']) ? 'active' : '' }}"><i class="fas fa-box"></i> Pendataan Barang</a></li>
    @if($isAdmin)
    <li><a href="{{ route('administrator.petugas') }}" class="{{ $current === 'administrator.petugas' ? 'active' : '' }}"><i class="fas fa-users"></i> Data Petugas</a></li>
    @else
    <li><a href="{{ route('petugas.aktivasi') }}" class="{{ $current === 'petugas.aktivasi' ? 'active' : '' }}"><i class="fas fa-play-circle"></i> Aktivasi Lelang</a></li>
    @endif
    <li><a href="{{ $isAdmin ? route('administrator.laporan') : route('petugas.laporan') }}" class="{{ in_array($current, ['administrator.laporan','petugas.laporan']) ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Laporan</a></li>
  </ul>
  <div class="mn-right">
    <div class="mn-user">
      <div class="mn-avatar" style="background:var(--ink);color:var(--gold-l);border-color:rgba(184,134,11,.3)">{{ $initial }}</div>
    </div>
    <a href="{{ route('logout.petugas') }}" class="mn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" aria-label="Toggle dark mode"><i class="fas fa-moon"></i></button>
    <button class="mn-toggler" id="mn-toggler" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div class="page-shell">
<div class="page-inner">

@yield('content')

</div><!-- /page-inner -->
</div><!-- /page-shell -->

<footer class="mn-footer">
  <span>&copy; 2026 <strong>Lux Bid</strong> &mdash; Platform Pelelangan Online</span>
  <span>Made by &middot; TEAM HUNTERS</span>
</footer>

</div><!-- /page-wrapper -->

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
  const toggler = document.getElementById('mn-toggler');
  const links = document.getElementById('mn-links');
  if (toggler && links) {
    toggler.addEventListener('click', () => links.classList.toggle('open'));
    document.addEventListener('click', (e) => {
      if (!toggler.contains(e.target) && !links.contains(e.target)) links.classList.remove('open');
    });
    links.querySelectorAll('a').forEach(a => a.addEventListener('click', () => links.classList.remove('open')));
  }
  document.querySelectorAll('.alert-close').forEach(btn => btn.addEventListener('click', () => btn.closest('.alert-m').remove()));
  const fadeEls = document.querySelectorAll('.fade-up');
  if (fadeEls.length) {
    const obs = new IntersectionObserver((entries) => {
      entries.forEach((e, i) => {
        if (e.isIntersecting) { setTimeout(() => e.target.style.animationPlayState = 'running', i * 60); obs.unobserve(e.target); }
      });
    }, { threshold: 0.1 });
    fadeEls.forEach(el => { el.style.animationPlayState = 'paused'; obs.observe(el); });
  }
</script>
@stack('scripts')

<script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
