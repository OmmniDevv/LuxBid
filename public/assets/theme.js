// Unified theme system — single source of truth
(function () {
  function applyTheme(dark) {
    document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
    var icon = document.querySelector('#dm-toggle i');
    if (icon) icon.className = dark ? 'fas fa-sun' : 'fas fa-moon';
  }

  // Apply immediately (no flash)
  applyTheme(localStorage.getItem('theme') === 'dark');

  // Wire toggle after DOM ready
  document.addEventListener('DOMContentLoaded', function () {
    applyTheme(localStorage.getItem('theme') === 'dark');
    var btn = document.getElementById('dm-toggle');
    if (btn) {
      btn.addEventListener('click', function () {
        var dark = document.documentElement.getAttribute('data-theme') !== 'dark';
        localStorage.setItem('theme', dark ? 'dark' : 'light');
        applyTheme(dark);
      });
    }
  });
})();
