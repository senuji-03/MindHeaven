<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reports & User Moods</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
  <header class="topbar">
    <h1>Reports & User Moods</h1>
    <div class="icons">
      <a href="<?= BASE_URL ?>/logout" class="btn-top">Logout</a>
    </div>
  </header>
  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/reports" class="active">Reports & Moods</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <section>
        <h2>Summary</h2>
        <div class="cards">
          <div class="card">Avg Mood: 😊</div>
          <div class="card">New Reports: 5</div>
          <div class="card">High Risk: 2</div>
        </div>
      </section>
      <section>
        <h2>Recent Reports</h2>
        <ul>
          <li>User U103 reported inappropriate content.</li>
          <li>Thread flagged for review.</li>
        </ul>
      </section>
    </main>
  </div>
</body>
</html>

