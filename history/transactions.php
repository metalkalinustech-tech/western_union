<?php
  session_start();
  $user_email = $_SESSION['user_email'];
  $user_password = $_SESSION['user_password'];
  $name="";
  $phone="";
  $balance =0;
 require_once '../db_config.php';
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

 $history = $conn->query("SELECT * FROM transaction_history WHERE user_id = '$user_email' ORDER BY id DESC");

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="A responsive transaction history table for a banking dashboard.">
    <link rel="icon" href="../profile/western-logo.png">
  <title>Transaction History</title>
  <link rel="stylesheet" href="transactions.css">
</head>
<body>
  <main class="page">
    <header class="page-header">
      <div><p class="eyebrow">ACCOUNT OVERVIEW</p><h1>Transaction history</h1><p class="subtitle">Review recent activity on your Everyday Checking account.</p></div>
      <button class="export-button" type="button" aria-label="Download transaction history as a CSV">↓ <span>Export</span></button>
    </header>
    <section class="account-card" aria-label="Account balance">
      <div><span class="account-label"><?= $user_email ?></span><span class="account-number" style="color:#000;">WESTERN UNION</span></div>
      <div class="balance"><span class="account-label">Available balance</span><strong>$<?= $balance ?></strong></div>
    </section>
    <section class="transactions" aria-labelledby="transactions-heading">
    <?php if($history->num_rows>0): ?>
      <div class="section-heading"><div><h2 id="transactions-heading">Recent transactions</h2><p>Showing your latest activity</p></div><label class="search"><span class="sr-only">Search transactions</span><span aria-hidden="true">⌕</span><input type="search" placeholder="Search transactions"></label></div>
      <div class="table-wrap"><table>
        <thead><tr><th scope="col">Transaction</th><th scope="col">Date</th><th scope="col">Category</th><th scope="col">Status</th><th scope="col" class="amount-heading">Amount</th></tr></thead>
        <tbody>
      <?php   while($his = $history->fetch_assoc()): ?>
          <tr><td><div class="merchant"><span class="merchant-icon grocery">W</span><span><strong><?= $his['sender_name']?></strong><small>•••• 4829 · Card purchase</small></span></div></td><td><?= $his['date']?></td><td><span class="category"><?= $his['transaction_type']?></span></td><td><span class="status posted"><i></i><?= $his['t_status']?></span></td><td class="amount expense">$<?= $his['amount']?></td></tr>
        <?php endwhile; ?>
        </tbody>
        <?php else: ?>
          <p>No records found.</p>
        <?php endif; ?>
        <?php $conn->close(); ?>
      </table></div>
      <footer class="table-footer"><span>Showing <strong>1</strong> of <strong>1</strong> transactions</span><nav aria-label="Transaction pages"><button class="page-arrow" type="button" aria-label="Previous page" disabled>‹</button><button class="page-number current" type="button" aria-current="page">1</button><button class="page-arrow" type="button" aria-label="Next page">›</button></nav></footer>
    </section>
    <p class="demo-note">Transactions history.</p>
  </main>
</body>
</html>
