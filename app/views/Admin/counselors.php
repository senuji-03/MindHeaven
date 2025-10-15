<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Counselors</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
  <header class="topbar">
    <h1>Manage Counselors</h1>
    <div class="icons">
      <a href="<?= BASE_URL ?>/logout" class="btn-top">Logout</a>
    </div>
  </header>
  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/counselors" class="active">Manage Counselors</a></li>
        <li><a href="<?= BASE_URL ?>/admin/appointments">Appointments</a></li>
        <li><a href="<?= BASE_URL ?>/admin/approve-counselors">Approve Counselors</a></li>
        <li><a href="<?= BASE_URL ?>/admin/resource-hub">Resource Hub</a></li>
      </ul>
    </aside>
    <main class="main-content">
      <section>
        <h2>Counselor Directory</h2>
        <table>
          <tr><th>Name</th><th>Status</th><th>Specialization</th><th>Actions</th></tr>
          <tr><td>Dr. Emily Clark</td><td>Active</td><td>Anxiety</td><td><button>Edit</button> <button>Disable</button></td></tr>
          <tr><td>Mr. John Miles</td><td>Onboarding</td><td>Relationship</td><td><button>Verify</button> <button>Reject</button></td></tr>
        </table>
      </section>
    </main>
  </div>
</body>
</html>

