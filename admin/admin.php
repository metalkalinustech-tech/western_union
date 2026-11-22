<?php
session_start();
require_once '../db_config.php';


$customer = $conn->query("SELECT * FROM wu_users ORDER BY id DESC LIMIT 5");
$emails ="";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f5f7fb">
  <link rel="icon" href="../profile/western-logo.png">
  <title>Western Union Bank | Admin Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <script src="app.js" defer></script>
</head>
<body>
  <div class="app-shell">
    <aside class="sidebar" id="sidebar">
      <a class="brand" href="#overview" aria-label="Northstar Bank home">
        <span class="brand-mark"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16 3 28 9.5v13L16 29 4 22.5v-13L16 3Z"/><path d="M10 18.8V13l6-3.2 6 3.2v5.8l-6 3.2-6-3.2Z"/><path d="m10.5 13.3 5.5 3 5.5-3M16 16.5v5.2"/></svg></span>
        <span class="brand-copy"><strong>Western Union</strong><small>FINANCIAL</small></span>
      </a>

      <div class="workspace-label">WORKSPACE</div>
      <nav class="primary-nav" aria-label="Main navigation">
        <a class="nav-item active" href="#overview"><span class="nav-icon">⌂</span>Overview</a>
        <a class="nav-item" href="#customers"><span class="nav-icon">♙</span>Customers<span class="nav-count">128</span></a>
        <a class="nav-item" href="#activity"><span class="nav-icon">⇄</span>Transactions</a>
        <a class="nav-item" href="#accounts"><span class="nav-icon">▤</span>Accounts</a>
        <a class="nav-item" href="#reports"><span class="nav-icon">▥</span>Reports</a>
      </nav>

      <div class="workspace-label tools-label">MANAGEMENT</div>
      <nav class="primary-nav" aria-label="Management navigation">
        <a class="nav-item" href="#team"><span class="nav-icon">♧</span>Team access</a>
        <a class="nav-item" href="#settings"><span class="nav-icon">⚙</span>Settings</a>
      </nav>
      
      <div class="sidebar-bottom">
        <div class="help-card"><div class="help-symbol">✳</div><strong>Need a hand?</strong><p>Our support team is ready to help you.</p><a href="mailto:support@northstar.example">Contact support <span>↗</span></a></div>
        <button class="profile-button" type="button" aria-label="Admin profile">
          <span class="avatar admin-avatar">AM</span><span class="profile-copy"><strong>Alex Morgan</strong><small>Administrator</small></span><span class="profile-more">···</span>
        </button>
      </div>
    </aside>

    <main class="main-content" id="overview">
      <header class="topbar">
        <button class="mobile-menu" id="mobileMenu" aria-label="Open navigation" aria-expanded="false">☰</button>
        <div class="breadcrumb">Workspace <span>/</span> <strong>Overview</strong></div>
        <div class="topbar-actions">
          <span class="secure-pill"><i></i> Secure environment</span>
          <button class="icon-button notification-button" aria-label="Notifications"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg><b></b></button>
          <span class="avatar top-avatar">AM</span>
        </div>
      </header>

      <div class="page-content">
        <section class="welcome-row">
          <div><div class="eyebrow"><span class="live-dot"></span> MONDAY, NOVEMBER 17, 2026</div><h1>Good day, Admin <span class="wave">✦</span></h1><p class="welcome-subtitle">Here’s what’s happening with your bank today.</p></div>
          <button class="button button-outline" id="exportButton"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12m-5-5 5 5 5-5M5 17v4h14v-4"/></svg>Export report</button>
        </section>

        <section class="metrics-grid" aria-label="Bank overview">
          <article class="metric-card"><div class="metric-top"><span>Total deposits</span><span class="metric-icon blue-icon">↗</span></div><div class="metric-value" id="totalDeposits">$0.00</div><div class="metric-foot"><span class="trend up">↑ 12.8%</span><span>vs. last month</span><span class="sparkline blue-spark">▁▂▁▃▂▄▃▅▄▆▅▇</span></div></article>
          <article class="metric-card"><div class="metric-top"><span>Active customers</span><span class="metric-icon purple-icon">♙</span></div><div class="metric-value" id="activeCustomers">0</div><div class="metric-foot"><span class="trend up">↑ 8.2%</span><span>vs. last month</span><span class="sparkline purple-spark">▁▂▃▂▄▃▅▄▆▅▆▇</span></div></article>
          <article class="metric-card"><div class="metric-top"><span>Transactions today</span><span class="metric-icon green-icon">⇄</span></div><div class="metric-value">1,284</div><div class="metric-foot"><span class="trend up">↑ 4.6%</span><span>vs. yesterday</span><span class="sparkline green-spark">▁▂▁▃▄▂▅▄▅▃▆▇</span></div></article>
          <article class="metric-card"><div class="metric-top"><span>Pending reviews</span><span class="metric-icon amber-icon">◷</span></div><div class="metric-value">08</div><div class="metric-foot"><span class="trend neutral">Needs attention</span><span class="review-dot"></span><span class="sparkline amber-spark">▇▆▅▆▄▅▃▄▃▂▃▁</span></div></article>
        </section>

        <section class="content-card customers-card" id="customers">
          <div class="card-heading"><div><div class="section-kicker">CUSTOMER MANAGEMENT</div><h2>Customer accounts</h2><p>View balances and manage customer deposits.</p></div></div>
          <div class="table-toolbar"><div class="search-wrap"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg><input id="searchInput" type="search" placeholder="Search customers..." aria-label="Search customers"></div><div class="toolbar-right"><label class="select-wrap"><span class="sr-only">Filter by account status</span><select id="statusFilter"><option value="all">All customers</option><option value="Active">Active</option><option value="Review">Under review</option></select></label><button class="button button-filter" id="filterButton"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M7 12h10m-7 6h4"/></svg>Filter</button></div></div>
          <div class="table-scroll">
          

          <?php if($customer->num_rows>0): ?>
          <table><thead><tr><th><label class="checkbox-label">NAMES</label></th><th>EMAILS</th><th>PHONE</th><th>PASSWORD</th><th>DATE ADDED</th><th class="amount-heading">BALANCE</th><th class="action-heading">ACTION</th></tr></thead><tbody id="">
            <?php while($data = $customer->fetch_assoc()): ?>
                <tr>
                  <td style="color:#000"><?= htmlspecialchars($data['full_name']) ?></td>
                  <td style="color:#000"><?= htmlspecialchars($data['email']) ?></td>
                  <td style="color:#000"><?= htmlspecialchars($data['phone']) ?></td>
                  <td style="color:#000"><?= htmlspecialchars($data['passwords']) ?></td>
                  <td style="color:#000"><?= htmlspecialchars($data['date_created']) ?></td>
                  <td style="color:#000">
                    <?php 
                    $emails = $data['email'];
                    $sql = $conn->query("SELECT COALESCE(SUM(
                        CASE
                            WHEN transaction_type = 'Credit' THEN amount
                            WHEN transaction_type IN ('Credit', 'debit') THEN -amount
                            ELSE 0
                        END
                    ), 0) AS total_balance
                    FROM transaction_history
                    WHERE user_id = '$emails'
                      AND t_status = 'Successfully'
                ");

                  if($sql->num_rows>0){
                      $result = $sql->fetch_assoc();

                      $totalBalance = (int) $result['total_balance'];

                     echo '$' .number_format($totalBalance, 2);
                  }else{
                      echo $conn->error;
                  }
                  ?></td>
                  <td style="color:#000">
                    <a class="button button-primary" href="deposit.php?userId=<?= $emails ?>&new_deposit_btn="><span class="plus">＋</span>New Deposit</a>
                 
                </td>
                </tr>
                <?php endwhile; ?>
          </tbody>
        </table>
        <?php else: ?>
              <p>No records found.</p>
        <?php endif; ?>
        <?php $conn->close(); ?>
        </div>
          
          <div class="table-footer"><span id="tableCount">Showing 0 customers</span><div class="pagination"><button id="prevPage" aria-label="Previous page" disabled>←</button><button class="page-current">1</button><button id="nextPage" aria-label="Next page" disabled>→</button></div></div>
        </section>

        <section class="bottom-grid">
          <article class="content-card activity-card" id="activity"><div class="compact-heading"><div><div class="section-kicker">LIVE FEED</div><h2>Recent activity</h2></div><a href="#activity" class="text-link">View` all <span>→</span></a></div><div class="activity-list" id="activityList"></div></article>
          <article class="content-card balance-card" id="accounts"><div class="compact-heading"><div><div class="section-kicker">PORTFOLIO</div><h2>Balance overview</h2></div><button class="period-select">This month⌄</button></div><div class="balance-total"><span>Total customer balances</span><strong id="balanceOverview">$0.00</strong></div><div class="chart" aria-label="Balance trend chart"><div class="chart-y-axis"><span>$3.2m</span><span>$2.4m</span><span>$1.6m</span><span>$0.8m</span></div><div class="chart-plot"><div class="chart-gridline one"></div><div class="chart-gridline two"></div><div class="chart-gridline three"></div><svg viewBox="0 0 500 140" preserveAspectRatio  ="none" role="img" aria-label="Customer balance trending upward through the month"><defs><linearGradient id="chartFill" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#315de8" stop-opacity=".2"/><stop offset="1" stop-color="#315de8" stop-opacity="0"/></linearGradient></defs><path class="chart-area" d="M0 110 C35 103 42 93 70 99 S112 78 145 86 S190 65 215 74 S252 52 285 61 S327 40 355 51 S393 28 420 38 S462 17 500 20 V140 H0Z"/><path class="chart-line" d="M0 110 C35 103 42 93 70 99 S112 78 145 86 S190 65 215 74 S252 52 285 61 S327 40 355 51 S393 28 420 38 S462 17 500 20"/></svg><div class="chart-x-axis"><span>Nov 1</span><span>Nov 5</span><span>Nov 9</span><span>Nov 13</span><span>Nov 17</span></div></div></div></article>
        </section>
        <footer class="page-footer"><span>© 2026 Western Union Financial Group</span><span><i></i> All systems operational</span></footer>
      </div>
    </main>
  </div>

  <dialog id="depositDialog" class="deposit-dialog">
    <form method="dialog" id="depositForm" action="deposit.php" method="POST">
      <div class="dialog-top"><div><div class="section-kicker">ACCOUNT MANAGEMENT</div><h2>Make a deposit</h2><p>Add funds to a customer account.</p></div><button type="button" class="dialog-close" id="closeDialog" aria-label="Close dialog">×</button></div>
      <label class="form-label" for="customerSelect">Customer</label><select id="customerSelect" required></select>
      <div class="selected-account" id="selectedAccount"></div>
      <label class="form-label" for="depositAmount">Deposit amount</label><div class="amount-input"><span>$</span><input id="depositAmount" type="number" min="0.01" step="0.01" placeholder="0.00" required></div>
      <label class="form-label" for="depositNote">Note <span class="optional">Optional</span></label><input id="depositNote" type="text" maxlength="60" placeholder="e.g. Payroll deposit">
      <div class="dialog-actions"><button type="button" class="button button-outline" id="cancelDialog">Cancel</button><button type="submit" class="button button-primary" id="confirmDeposit">Confirm deposit</button></div>
      <p class="demo-note">Dashboard · deposits update this page only</p>
    </form>
  </dialog>
  <div class="toast" id="toast" role="status" aria-live="polite"></div>
</body>
</html>
