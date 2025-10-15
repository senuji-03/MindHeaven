<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Approve Counselors</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
  <header class="topbar">
    <h1>Approve Counselors</h1>
    <div class="icons">
      <a href="<?= BASE_URL ?>/logout" class="btn-top">Logout</a>
    </div>
  </header>
  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/approve-counselors" class="active">Approve Counselors</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <section>
        <h2>Pending Applications</h2>
        <table>
          <tr><th>Name</th><th>License</th><th>Documents</th><th>Actions</th></tr>
          <tr><td>Dr. Alice Wayne</td><td>#CNSL-9982</td><td><button>View</button></td><td><button>Approve</button> <button>Reject</button></td></tr>
        </table>
      </section>
    </main>
  </div>
</body>
</html>

