<?php

session_start();

$email = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#f5f7fb" />
  <link rel="icon" href="profile/western-logo.png">
  <title>Profile updated Western Union</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap');

    :root {
      color-scheme: light;
      --ink: #17231f;
      --muted: #718078;
      --green: #ffe70e;
      --green-dark: #f7e70f;
      --mint: #eaf5ef;
      --line: #e7ece8;
      --paper: #ffffff;
      --bg: #f5f7f5;
      --shadow: 0 28px 80px rgba(34, 58, 45, .10), 0 3px 12px rgba(34, 58, 45, .04);
    }

    * { box-sizing: border-box; }
    body {
      min-height: 100vh;
      margin: 0;
      display: grid;
      place-items: center;
      padding: 28px 18px;
      color: var(--ink);
      background:
        radial-gradient(ellipse at 15% 8%, rgba(190, 226, 203, .32), transparent 34%),
        radial-gradient(ellipse at 88% 92%, rgba(217, 230, 221, .38), transparent 34%),
        var(--bg);
      font-family: 'DM Sans', sans-serif;
    }

    .page { width: min(100%, 510px); animation: rise-in .7s cubic-bezier(.2,.75,.25,1) both; }
    .brand { display: flex; justify-content: center; align-items: center; gap: 10px; margin-bottom: 24px; color: #41554a; font: 800 16px 'Manrope', sans-serif; letter-spacing: -.5px; }
    .brand-mark { display: grid; place-items: center; width: 31px; height: 31px; border-radius: 10px; color: white; background: var(--green); box-shadow: 0 5px 13px #267b5a38; }
    .card { position: relative; overflow: hidden; padding: 43px 48px 34px; border: 1px solid rgba(225, 233, 227, .9); border-radius: 24px; background: var(--paper); box-shadow: var(--shadow); text-align: center; }
    .card::before { position: absolute; top: 0; left: 15%; width: 70%; height: 1px; background: linear-gradient(90deg, transparent, #acd4bb, transparent); content: ''; }
    .success-icon { position: relative; display: grid; place-items: center; width: 82px; height: 82px; margin: 0 auto 23px; border-radius: 50%; color: var(--green); background: var(--mint); animation: pop-in .6s .15s cubic-bezier(.18,1.5,.4,1) both; }
    .success-icon::after { position: absolute; inset: -8px; border: 1px solid #d9eee0; border-radius: inherit; content: ''; animation: ring-in .7s .25s ease-out both; }
    .check { width: 36px; height: 36px; }
    .check path { stroke-dasharray: 36; stroke-dashoffset: 36; animation: draw-check .55s .55s ease forwards; }
    .eyebrow { margin: 0 0 9px; color: var(--green); font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; }
    h1 { margin: 0; font: 800 clamp(26px, 6vw, 32px)/1.2 'Manrope', sans-serif; letter-spacing: -1.15px; }
    .intro { max-width: 340px; margin: 13px auto 27px; color: var(--muted); font-size: 14px; line-height: 1.7; }
    .profile { display: flex; align-items: center; gap: 14px; padding: 15px; border: 1px solid var(--line); border-radius: 15px; background: #fbfcfb; text-align: left; animation: fade-in .6s .35s both; }
    .avatar { display: grid; flex: 0 0 48px; place-items: center; width: 48px; height: 48px; border-radius: 50%; color: #605a28; background: linear-gradient(145deg, #d3eadb, #afd1bc); font: 700 15px 'Manrope', sans-serif; }
    .profile-copy { min-width: 0; flex: 1; }
    .profile-name { overflow: hidden; margin: 0 0 3px; font-size: 14px; font-weight: 700; text-overflow: ellipsis; white-space: nowrap; }
    .profile-email { overflow: hidden; margin: 0; color: var(--muted); font-size: 12px; text-overflow: ellipsis; white-space: nowrap; }
    .edit-tag { display: inline-flex; align-items: center; gap: 5px; padding: 6px 9px; border-radius: 20px; color: var(--green); background: var(--mint); font-size: 10px; font-weight: 700; white-space: nowrap; }
    .updated { display: flex; justify-content: center; align-items: center; gap: 7px; margin: 16px 0 24px; color: #85918a; font-size: 11px; }
    .updated svg { color: var(--green); }
    .actions { display: grid; gap: 10px; }
    button, a { font: inherit; }
    .primary { display: inline-flex; justify-content: center; align-items: center; gap: 9px; width: 100%; min-height: 49px; border: 0; border-radius: 11px; color: white; background: var(--green); box-shadow: 0 5px 12px #267b5a2a; cursor: pointer; font-size: 13px; font-weight: 700; text-decoration: none; transition: transform .2s, background .2s, box-shadow .2s; }
    .primary:hover { transform: translateY(-2px); background: var(--green-dark); box-shadow: 0 8px 18px #267b5a35; }
    .primary:active { transform: translateY(0); }
    .secondary { padding: 9px; border: 0; color: #63736a; background: transparent; cursor: pointer; font-size: 12px; font-weight: 600; text-decoration: none; transition: color .2s; }
    .secondary:hover { color: var(--green); }
    .footer { margin: 18px 0 0; color: #9aa49e; font-size: 11px; text-align: center; }
    .toast { position: fixed; right: 22px; bottom: 22px; display: flex; align-items: center; gap: 9px; padding: 12px 16px; border: 1px solid #dbe9de; border-radius: 12px; color: #285d43; background: white; box-shadow: 0 12px 32px #20382b20; font-size: 13px; opacity: 0; transform: translateY(12px); pointer-events: none; transition: opacity .25s, transform .25s; }
    .toast.show { opacity: 1; transform: translateY(0); }
    .toast svg { color: var(--green); }
    @keyframes rise-in { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pop-in { from { opacity: 0; transform: scale(.65); } to { opacity: 1; transform: scale(1); } }
    @keyframes ring-in { from { opacity: 0; transform: scale(.8); } to { opacity: 1; transform: scale(1); } }
    @keyframes draw-check { to { stroke-dashoffset: 0; } }
    @keyframes fade-in { from { opacity: 0; transform: translateY(7px); } to { opacity: 1; transform: translateY(0); } }
    @media (max-width: 520px) { .card { padding: 36px 23px 28px; border-radius: 20px; } .brand { margin-bottom: 19px; } }
    @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; scroll-behavior: auto !important; transition-duration: .01ms !important; } }
  </style>
</head>
<body>
  <main class="page">
    <div class="brand" aria-label="Northstar">
      <span class="brand-mark" aria-hidden="true"><svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M12 2.8 14.4 9.6 21.2 12l-6.8 2.4-2.4 6.8-2.4-6.8L2.8 12l6.8-2.4L12 2.8Z" fill="currentColor"/></svg></span>
      WESTERN UNION
    </div>

    <section class="card" aria-labelledby="headline">
      <div class="success-icon" aria-hidden="true">
        <svg class="check" viewBox="0 0 36 36" fill="none"><path d="m9 18.5 6 6L27.5 12" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <p class="eyebrow" style="color: #000000;">All set</p>
      <h1 id="headline">Profile updated</h1>
      <p class="intro">Your changes have been saved successfully. Your profile is looking up to date.</p>

      <div class="profile" aria-label="Updated profile">
        <div class="avatar" id="avatar" aria-hidden="true">JD</div>
        <div class="profile-copy">
          <p class="profile-email" id="profileEmail"><?= $email ?></p>
        </div>
        <span class="edit-tag" style="color: #000000;"><svg width="12" height="12" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="m3 10.9-.7 3 3-.7 7.2-7.3-2.3-2.3L3 10.9Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/><path d="m9.4 4.6 2.3 2.3" stroke="currentColor" stroke-width="1.4"/></svg>Updated</span>
      </div>

      <p class="updated"><svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true"><circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.3"/><path d="M8 4.5V8l2.2 1.3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg><span id="updatedTime">Just now</span></p>

      <div class="actions">
        <a class="primary" href="dashboard.php" id="dashboardLink" style="color: #000000;">Go to dashboard <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3.3 8h9.4M8.5 3.8 12.7 8l-4.2 4.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #000000;"/></svg></a>
      </div>
    </section>
    <p class="footer">Need a hand? <a href="#" style="color:inherit">Contact support</a></p>
  </main>

  <div class="toast" id="toast" role="status" aria-live="polite"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="m3.5 8.2 3 3 6-6.4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg><span id="toastText">You're all caught up.</span></div>

  <script>
    // Optional: pass ?name=Jamie%20Doe&email=jamie@example.com to personalize the confirmation.
    const params = new URLSearchParams(window.location.search);
    const name = params.get('name');
    const email = params.get('email');

    if (name) {
      document.getElementById('profileName').textContent = name;
      document.getElementById('avatar').textContent = name.trim().split(/\s+/).slice(0, 2).map(part => part[0]).join('').toUpperCase();
    }
    if (email) document.getElementById('profileEmail').textContent = email;
    document.getElementById('updatedTime').textContent = new Intl.DateTimeFormat(undefined, { hour: 'numeric', minute: '2-digit' }).format(new Date()) + ' · today';

    const toast = document.getElementById('toast');
    let toastTimer;
    function showToast(message) {
      document.getElementById('toastText').textContent = message;
      toast.classList.add('show');
      clearTimeout(toastTimer);
      toastTimer = setTimeout(() => toast.classList.remove('show'), 2600);
    }
    document.getElementById('dashboardLink').addEventListener('click', event => {
      if (event.currentTarget.getAttribute('href') === '#dashboard') {
        event.preventDefault();
        showToast('Your dashboard is ready.');
      }
    });
    document.getElementById('profileLink').addEventListener('click', event => {
      if (event.currentTarget.getAttribute('href') === '#profile') {
        event.preventDefault();
        showToast('Your profile is up to date.');
      }
    });
  </script>
</body>
</html>
