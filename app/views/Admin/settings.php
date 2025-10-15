<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
  <header class="topbar">
    <h1>Settings</h1>
    <div class="icons">
      <a href="<?= BASE_URL ?>/logout" class="btn-top">Logout</a>
    </div>
  </header>
  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/settings" class="active">Settings</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <section>
        <h2>Platform Settings</h2>
        <div>Theme: Light</div>
        <div>Notifications: Enabled</div>
      </section>
    </main>
  </div>
</body>
</html>

