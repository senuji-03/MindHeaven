<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
  <header class="topbar">
    <h1>Profile</h1>
    <div class="icons">
      <a href="<?= BASE_URL ?>/logout" class="btn-top">Logout</a>
    </div>
  </header>
  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/profile" class="active">Profile</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <section>
        <h2>Admin Details</h2>
        <div>Name: <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></div>
        <div>Role: <?= htmlspecialchars($_SESSION['role'] ?? 'admin') ?></div>
      </section>
    </main>
  </div>
</body>
</html>

