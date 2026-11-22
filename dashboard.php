<?php
session_start();
 if (!isset($_SESSION['user_email'])) {
        header("Location: index.html");
        exit();
    }


$user_email = $_SESSION['user_email'];
$user_password = $_SESSION['user_password'];

$name ="";
$email ="";
$phone ="";
$balance = 0;


require_once 'db_config.php';

$query = "SELECT * FROM wu_users WHERE email='$user_email' AND passwords='$user_password'";
$result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $name = htmlspecialchars($user['full_name']);
        $email = htmlspecialchars($user['email']);
        $phone = htmlspecialchars($user['phone']);
    } else {
        echo "<div>Invalid session. Please log in again.</div>";
        session_destroy();
        header("Location: index.html");
        exit();
    }   

    $qyery_profile = "SELECT * FROM user_profile WHERE user_id='$user_email'";
    $result_profile = mysqli_query($conn, $qyery_profile);


        $profile_picture_path = "/profile/default.png"; // Default profile picture path
        $region = "";
        $states = "";
        $city = "";
        $country = "";
        $status = "update profile";
        $account_status = "unverified";
        $status_color = "color: #f8361d;";
        $profile_btn ="<a href='profile-form.html' class='btn btn-warning' style='background-color: #ff0f07; border-color: #f01a12; color: #ffffff; width: 100%;'>Update Profile</a>";

    if (mysqli_num_rows($result_profile) == 1) {
        $profile = mysqli_fetch_assoc($result_profile);  
        $profile_picture_path = htmlspecialchars($profile['profile_picture']);
        $region = htmlspecialchars($profile['region']);
        $states = htmlspecialchars($profile['states']);
        $city = htmlspecialchars($profile['city']);
        $country = htmlspecialchars($profile['country']);
        $status = "manage profile";
        $account_status = "Your account is verified";
        $status_color = "color: #28a745;";
        $profile_btn = "<a href='#' class='btn btn-success' style='background-color: #c9f7d4; border-color: #28a745; color: #0f0303; width: 100%;'>Manage Profile</a>";

    } else {
        // If no profile exists, you can set default values or handle it as needed
        $region = 'Unknown';
        $states = 'Unknown';
        $city = 'Unknown';
        $country = 'Unknown';
    } 

$sql = $conn->query("SELECT COALESCE(SUM(
        CASE
            WHEN transaction_type = 'Credit' THEN amount
            WHEN transaction_type IN ('Credit', 'debit') THEN -amount
            ELSE 0
        END
    ), 0) AS total_balance
    FROM transaction_history
    WHERE user_id = '$email'
      AND t_status = 'Successfully'
");

if($sql->num_rows>0){
    $result = $sql->fetch_assoc();

    $totalBalance = (int) $result['total_balance'];

    $balance = number_format($totalBalance, 2);
}else{
    echo $conn->error;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
<script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
  <link rel="icon" href="profile/western-logo.png">
  <title>Western Union Dashboard</title>
  <link rel="stylesheet" href="assets/styles.css">
  <script src="assets/app.js" defer></script>
</head>
<body>
  <script>
    function logout() {
        // Clear session data and redirect to login page
        alert('You have been logged out successfully.');
        window.location.href = 'logout.php';
    }
  </script>
  <style>

    .wrap-trans{
      display:flex;
      justify-content:space-around;
      align-items:space-between;
      div{
        width:50%;
        padding:20px 30px;
        border:solid 1px #ccc;
        margin:0 5px;
        border-radius:5px;
        cursor:pointer;
        font-weight:800;
        font-size:18px;
        font-family: Manrope, sans-serif;
        text-align:center;
      }
      .deposite{
        background:var(--navy);
        color: #ddcb28;
      }
      .withdraw{
        color:  var(--navy);
        background: #fcf6c2;
      }
    }
  </style>

<div class="app-shell">
  <aside class="sidebar" id="sidebar">
    <a class="brand" href="index.php"><span class="brand-mark">W</span><span style="color: #FFDD00;">Western Union<small>ACCOUNT DASHBOARD</small></span></a>
    <div class="nav-label">WORKSPACE</div>
    <a class="nav-item active" href="#overview"><span>▦</span> Overview</a>
    <a class="nav-item" href="/wallet/wallets.php"><span class="bi bi-wallet2"></span> Wallets</a>
    <a class="nav-item" href="#"><span class="bi bi-wallet2"></span> Loans</a>
    <a class="nav-item" href="/history/transactions.php"><span>↔</span> Account history</a>
    <a class="nav-item" href="#profile"><span>◎</span> My profile</a>
    <a class="nav-item" href="#settings"><span>⚙</span> Settings</a>
    <div class="sidebar-bottom">
      <div class="sidebar-user"><div><img src="<?=htmlspecialchars($profile_picture_path)?>" alt="Profile Picture" class="avatar2"></div><div style="color: #f0bb2b;"><?= htmlspecialchars($name) ?></strong><small>Saving Account</small></div><span class="dots">•••</span></div>
    </div>
  </aside>
  <main class="main">
    <header class="topbar">
      <button class="menu-btn" id="menuBtn" aria-label="Toggle navigation">☰</button>
      <div class="crumb" style="color: #070202;">WORKSPACE <span>/</span> <strong>Dashboard</strong></div>
      <div class="top-actions"><i class="bi bi-power" title="Logout" onclick="logout()" style="border: none; cursor: pointer; font-size: 18px; color: #000000;  margin-right: 10px;"><small style="color: #0f0303; font-size: 10px;">logout</small></i><div> <img src="./profile/western-logo.png" alt="profile" class="avatar small-avatar"></div></div>
    </header>
    <section class="content" id="overview">
      <div class="welcome-row">
      <div>
      <p class="eyebrow">Thursday, NOVEMBER 13, 2026</p>
      <h3><small>Good day,</small> <br> <?= htmlspecialchars($name) ?> <span>✦</span></h3>
      <p class="muted">Welcome to Western Union Bank official Website!</p>
    </div>
      <div><img src="<?=htmlspecialchars($profile_picture_path)?>" alt="Profile Picture" class="avatar"></div>
    </div>

      <div class="stats-grid" >
        <article class="balance-card">
          <div class="card-top"><span>AVAILABLE BALANCE</span><span class="balance-icon">↗</span></div>
          <div class="balance-amount"><b>$</b><?= $balance ?></div>
          <div class="balance-foot"><span class="live-dot"></span>  Account Balance</div>
          <div class="balance-wave"></div>
        </article>
        <article class="stat-card"><div class="stat-head"><span>ACCOUNT STATUS</span><span class="stat-icon green">✓</span></div><div class="stat-value">Active</div><div class="stat-note">Profile status</div><div class="stat-line"><span style="width:82%"></span></div></article>
        <article class="stat-card"><div class="stat-head"><span>TRANSACTIONS</span><span class="stat-icon purple">↔</span></div><div class="stat-value">12</div><div class="stat-note">Illustrative activity count</div><div class="mini-bars"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div></article>
        <article class="stat-card"><div class="stat-head"><span>PROFILE COMPLETION</span><span class="stat-icon orange">◎</span></div><div class="stat-value">85%</div><div class="stat-note">Add remaining details when ready</div><div class="stat-line orange-line"><span style="width:85%"></span></div></article>
      </div>

      <div class="section-grid">
    <section class="panel history-panel" id="history" style="overflow:auto;">
            <main class="container">
    <header class="header">
      <div>
        <h2 class="section-title" style="color: #04040e;">Transaction History</h2>
        <p class="subtitle">Review your recent account activity</p>
      </div>
      <select class="filter" aria-label="Filter transactions">
        <option>All transactions</option>
        <option>Income</option>
        <option>Expenses</option>
      </select>
    </header>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Transaction</th>
            <th>Date</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $history = $conn->query("SELECT * FROM transaction_history WHERE user_id = '$user_email' ORDER BY id DESC LIMIT 5");
            if($history->num_rows>0){
              while($his = $history->fetch_assoc()){
              echo '<tr>
              <td><span class="merchant">'.$his['sender_name'].'</span></td>
              <td>'.$his['date'].'</td>
              <td>'.$his['transaction_type'].'</td>
              <td class="amount debit">$'.$his['amount'].'</td>
              <td><span class="status completed">'.$his['t_status'].'</span></td>
            </tr>';
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </main> 
  </section>

        <section class="panel profile-summary" id="profile">
          <div class="panel-heading"><div><h2>Profile overview</h2><p>Your account information</p></div><a href="#edit-profile">Edit <span>↗</span></a></div>
          <div class="profile-person"><div class="profile-avatar"><img src="<?=htmlspecialchars($profile_picture_path)?>" alt="Profile Picture" class="avatar2"></div><div><strong><?= htmlspecialchars($name) ?></strong><small><?= htmlspecialchars($email) ?></small></div></div>
          <div class="detail-list">
            <div><span>Phone number</span><strong><?= htmlspecialchars($phone) ?></strong></div>
            <div><span>Country</span><strong><?= htmlspecialchars($country) ?></strong></div>
            <div><span>State / Department</span><strong><?= htmlspecialchars($states) ?></strong></div>
            <div><span>Region</span><strong><?= htmlspecialchars($region) ?></strong></div>
            <div><span>City</span><strong><?= htmlspecialchars($city) ?></strong></div>
            <div><span>Account status</span><strong class="active-text" style="<?= $status_color ?>"><?= htmlspecialchars($account_status) ?></strong></div>
          </div>
          <div><?= $profile_btn ?></div>
        </section>
      </div>

      <section class="panel settings-panel" id="settings">
        <div class="panel-heading"><div><h2>Settings & preferences</h2><p>Account controls for the dashboard experience</p></div><span class="section-tag">PREFERENCES</span></div>
        <div class="setting-row"><div><strong>Email notifications</strong><p>Receive sample account activity notifications.</p></div><label class="switch"><input type="checkbox" checked><span></span></label></div>
        <div class="setting-row"><div><strong>Security alerts</strong><p>Show a notice for sign-in and profile changes.</p></div><label class="switch"><input type="checkbox" checked><span></span></label></div>
        <div class="setting-row"><div><strong>Compact dashboard</strong><p>Use a denser layout for account information.</p></div><label class="switch"><input type="checkbox" id="compactToggle"><span></span></label></div>
        <div class="setting-row"><div><strong>Display currency</strong><p>US Dollar (USD) — fixed sample currency.</p></div><span class="currency-label">USD · $</span></div>
      </section>
      <footer>© 2026 Western Union <span>online financial services</span></footer>
    </section>
  </main>
</div>
</body>
</html>