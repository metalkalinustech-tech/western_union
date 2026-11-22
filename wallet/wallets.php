<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#cfab07">
  <link rel="icon" href="../profile/western-logo.png">
  <title>Wallets</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php
  session_start();
  $user_email = $_SESSION['user_email'];
  $user_password = $_SESSION['user_password'];
  $name="";
  $phone="";
  $balance =0;

   require_once '../db_config.php';

$query = "SELECT * FROM wu_users WHERE email='$user_email' AND passwords='$user_password'";
$out = mysqli_query($conn, $query);

    if (mysqli_num_rows($out) == 1) {
        $user = mysqli_fetch_assoc($out);
        $name = htmlspecialchars($user['full_name']);
        $phone = htmlspecialchars($user['phone']);
    } else {
        echo $conn->error;
        exit();
    }   

    //amount query
  $sql = $conn->query("SELECT COALESCE(SUM(
        CASE
            WHEN transaction_type = 'Credit' THEN amount
            WHEN transaction_type IN ('Credit', 'debit') THEN -amount
            ELSE 0
        END
    ), 0) AS total_balance
    FROM transaction_history
    WHERE user_id = '$user_email'
      AND t_status = 'Successfully'
");

if($sql->num_rows>0){
    $result = $sql->fetch_assoc();

    $totalBalance = (int) $result['total_balance'];

    $balance = number_format($totalBalance, 2);
}else{
    echo $conn->error;
}



//profile query
$profile_picture_path = "../profile/default.png";
$qyery_profile = "SELECT * FROM user_profile WHERE user_id='$user_email'";
$result_profile = mysqli_query($conn, $qyery_profile);

if (mysqli_num_rows($result_profile) == 1) {
        $profile = mysqli_fetch_assoc($result_profile);  
        $profile_picture_path = htmlspecialchars($profile['profile_picture']);

    }else{
      echo $conn->error;
    }



?>
  <header class="topbar">
    <a class="brand" href="#home" aria-label="UnionPay Demo home"><span class="brand-mark">W</span><span>WESTERN<span class="brand-light"> UNION</span></span><small>Account</small></a>
    <nav aria-label="Main navigation"><a href="#home" class="nav-link active">Overview</a><a href="#activity" class="nav-link">Activity</a></nav>
    <img class="profile" aria-label="Profile" src="<?=htmlspecialchars('../'.$profile_picture_path)?>">
  </header>
  <main id="home">
    <section class="welcome">
      <p class="eyebrow">PERSONAL ACCOUNT <span class="dot"></span> ACTIVE</p>
      <h3>Good afternoon, <?= $name ?></h3>
      <p>Manage your money, your way.</p>
    </section>
    <section class="balance-card" aria-label="Account balance">
      <div><span class="card-label">AVAILABLE BALANCE</span><button class="eye" id="toggleBalance" aria-label="Hide balance">◉</button></div>
      <div class="balance" id="balance">$<?= $balance ?></div>
      <div class="account-row"><span>Everyday account</span><span>•••• 4821</span></div>
      <div class="card-decoration" aria-hidden="true">W</div>
    </section>
    <section class="actions" aria-label="Money actions">
      <button class="action-button primary" data-page="deposit"><span class="action-icon">＋</span><span>Recieve</span><span class="arrow">›</span></button>
      <button class="action-button secondary" data-page="withdraw"><span class="action-icon">−</span><span>Send</span><span class="arrow">›</span></button>
    </section>
    <section class="activity" id="activity">
      <div class="section-heading"><div><p class="eyebrow">YOUR ACCOUNT</p><h2>Recent activity</h2></div><button id="viewAll" class="text-button">View all <span>›</span></button></div>
      <div class="activity-list" id="activityList">
        <article class="transaction"><span class="transaction-icon incoming">↓</span><div class="transaction-info"><strong>Payroll deposit</strong><small>Today, 9:42 AM · Direct deposit</small></div><strong class="amount positive">+$1,850.00</strong></article>
        <article class="transaction"><span class="transaction-icon">↗</span><div class="transaction-info"><strong>Market Street Coffee</strong><small>Yesterday · Card ending 4821</small></div><strong class="amount">−$6.50</strong></article>
        <article class="transaction"><span class="transaction-icon incoming">↓</span><div class="transaction-info"><strong>Transfer received</strong><small>Nov 10 · From Alex M.</small></div><strong class="amount positive">+$75.00</strong></article>
      </div>
    </section>
    <footer>wallets and transaction .</footer>
  </main>
  <div class="modal-backdrop" id="modal" hidden>
    <section class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
      <button class="close" id="closeModal" aria-label="Close">×</button>
      <div class="modal-symbol" id="modalSymbol">＋</div>
      <p class="eyebrow"><?= $user_email ?></p>
      <h2 id="modalTitle">Receive money</h2>
      <p class="modal-copy" id="modalCopy">Enter your MTNC code to receive money</p>
      <form id="moneyForm">
        <label for="amountInput">Mntc code:</label>
        <div class="amount-input"><span>MTNC</span><input id="amountInput" type="number" min="10" max="10" step="0.01" placeholder="XXX XXXX XXX" required></div>
        <p class="hint" id="formHint">Enter your MTNC code to recieve.</p>
        <label for="sourceSelect" id="sourceLabel">Tranfer</label>
        <select id="sourceSelect"><option>Receive Money</option><option>Debit card · •••• 1182</option></select>
        <button class="submit-button" id="submitButton" type="submit">Review deposit <span>→</span></button>
      </form>
      <p class="secure-note">▣ &nbsp; Secure experience</p>WU
      <div class="notice" id="notice" role="status" hidden></div>
    </section>
  </div>
  <script src="app.js"></script>
</body>
</html>

