<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donations</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
  <header class="topbar">
    <h1>Donations</h1>
    <div class="icons">
      <a href="<?= BASE_URL ?>/logout" class="btn-top">Logout</a>
    </div>
  </header>
  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/donations" class="active">Donations</a></li>
        <li><a href="<?= BASE_URL ?>/admin/awareness">Awareness Programs</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <section>
        <h2>Recent Donations</h2>
        <table>
          <tr><th>Donor</th><th>Amount</th><th>Date</th></tr>
          <tr><td>Anonymous</td><td>$200</td><td>2025-08-10</td></tr>
          <tr><td>Jane Doe</td><td>$50</td><td>2025-08-12</td></tr>
        </table>
      </section>
    </main>
  </div>
</body>
</html>

