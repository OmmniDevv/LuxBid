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
  @stack('styles')
</head>
<body>
<div class="page-wrapper">

@php
  $username = session('username', '');
  $initial = strtoupper(substr($username, 0, 1));
  $current = request()->route()->getName();
@endphp

<nav class="mn-nav">
  <a href="{{ route('masyarakat.index') }}" class="mn-brand">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Lux Bid">
    Lux<span>Bid</span>
    <span class="mn-brand-badge">Peserta</span>
  </a>
  <ul class="mn-links" id="mn-links">
    <li><a href="{{ route('masyarakat.index') }}" class="{{ $current === 'masyarakat.index' ? 'active' : '' }}"><i class="fas fa-home"></i> Beranda</a></li>
    <li><a href="{{ route('masyarakat.penawaran') }}" class="{{ $current === 'masyarakat.penawaran' ? 'active' : '' }}"><i class="fas fa-gavel"></i> Penawaran</a></li>
  </ul>
  <div class="mn-right">
    @php $user = \App\Models\Masyarakat::find(session('id_user')); @endphp
    <a href="{{ route('masyarakat.profile') }}" class="mn-user" title="Profil saya" style="text-decoration:none">
      <div class="mn-avatar">
        @if($user && $user->foto)
          <img src="{{ asset('uploads/profile/'.$user->foto) }}" alt="{{ $username }}">
        @else
          {{ $initial }}
        @endif
      </div>
    </a>
    <a href="{{ route('logout') }}" class="mn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" aria-label="Toggle dark mode"><i class="fas fa-moon"></i></button>
    <button class="mn-toggler" id="mn-toggler" aria-label="Toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div class="page-shell">
  <div class="page-inner">

    @yield('content')

  </div>
</div>

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
