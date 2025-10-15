<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointments</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
  <header class="topbar">
    <h1>Appointments</h1>
    <div class="icons">
      <a href="<?= BASE_URL ?>/logout" class="btn-top">Logout</a>
    </div>
  </header>
  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/appointments" class="active">Appointments</a></li>
        <li><a href="<?= BASE_URL ?>/admin/counselors">Manage Counselors</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <section>
        <h2>Upcoming Appointments</h2>
        <div class="appointment">2025-08-20 — Counseling with Student A</div>
        <div class="appointment">2025-08-22 — Counseling with Student B</div>
      </section>
    </main>
  </div>
</body>
</html>

