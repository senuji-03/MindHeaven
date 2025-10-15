<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>System Monitoring</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
  <header class="topbar">
    <h1>System Monitoring</h1>
    <div class="icons">
      <a href="<?= BASE_URL ?>/logout" class="btn-top">Logout</a>
    </div>
  </header>
  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/monitoring" class="active">System Monitoring</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <section>
        <h2>System Health</h2>
        <div class="cards">
          <div class="card">Server Load: Normal</div>
          <div class="card">DB Status: Connected</div>
          <div class="card">Errors (24h): 0</div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>

