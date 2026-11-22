document.addEventListener('DOMContentLoaded', () => {
  const menu = document.getElementById('menuBtn');
  const sidebar = document.getElementById('sidebar');
  if (menu && sidebar) menu.addEventListener('click', () => sidebar.classList.toggle('open'));

  const compact = document.getElementById('compactToggle');
  if (compact) compact.addEventListener('change', () => {
    document.body.classList.toggle('compact', compact.checked);
  });

  document.querySelectorAll('.nav-item').forEach(link => {
    link.addEventListener('click', () => {
      document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
      link.classList.add('active');
      if (window.innerWidth <= 720) sidebar.classList.remove('open');
    });
  });
});
