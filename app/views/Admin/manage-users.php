<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
    <script>
      function viewReport(id){ alert('Viewing report for '+id); }
    </script>
    </head>
<body>
  <header class="topbar">
    <h1>Manage Users</h1>
    <div class="icons">
      <a class="btn-top" href="<?= BASE_URL ?>/logout">Logout</a>
    </div>
  </header>
  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/manage-users" class="active">Manage Users</a></li>
        <li><a href="<?= BASE_URL ?>/admin/moderate-forum">Moderate Forum</a></li>
        <li><a href="<?= BASE_URL ?>/admin/counselors">Manage Counselors</a></li>
        <li><a href="<?= BASE_URL ?>/admin/appointments">Appointments</a></li>
        <li><a href="<?= BASE_URL ?>/admin/approve-counselors">Approve Counselors</a></li>
        <li><a href="<?= BASE_URL ?>/admin/resource-hub">Resource Hub</a></li>
        <li><a href="<?= BASE_URL ?>/admin/reports">Reports & Moods</a></li>
        <li><a href="<?= BASE_URL ?>/admin/donations">Donations</a></li>
        <li><a href="<?= BASE_URL ?>/admin/awareness">Awareness Programs</a></li>
        <li><a href="<?= BASE_URL ?>/admin/monitoring">System Monitoring</a></li>
        <li><a href="<?= BASE_URL ?>/admin/settings">Settings</a></li>
        <li><a href="<?= BASE_URL ?>/admin/profile">Profile</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <section class="toolbar">
        <div class="filters">
          <input class="search-input" type="text" id="userSearch" placeholder="Search users by name or ID..." />
          <select id="roleFilter">
            <option value="all">All roles</option>
            <option value="undergrad">Undergraduate</option>
            <option value="counselor">Counselor</option>
            <option value="moderator">Moderator</option>
            <option value="admin">Admin</option>
            <option value="donor">Donor</option>
            <option value="call_responder">Call Responder</option>
          </select>
          <select id="statusFilter">
            <option value="all">All statuses</option>
            <option value="active">Active</option>
            <option value="suspended">Suspended</option>
            <option value="pending">Pending</option>
          </select>
        </div>
        <div>
          <button class="btn" onclick="bulkEnable()">Enable</button>
          <button class="btn secondary" onclick="bulkDisable()">Disable</button>
          <button class="btn danger" onclick="bulkDelete()">Delete</button>
        </div>
      </section>

      <section>
        <table class="table">
          <thead>
            <tr>
              <th><input type="checkbox" id="selectAll" onclick="toggleAll(this)"/></th>
              <th>User ID</th>
              <th>Name</th>
              <th>Role</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="userTable">
            <tr data-role="undergrad" data-status="active">
              <td><input type="checkbox"/></td>
              <td>U101</td>
              <td>John Doe</td>
              <td><span class="badge">Undergrad</span></td>
              <td><span class="badge success">Active</span></td>
              <td>
                <button class="btn small" onclick="viewReport('U101')">Report</button>
                <button class="btn small secondary">Suspend</button>
              </td>
            </tr>
            <tr data-role="counselor" data-status="pending">
              <td><input type="checkbox"/></td>
              <td>U102</td>
              <td>Jane Smith</td>
              <td><span class="badge info">Counselor</span></td>
              <td><span class="badge warn">Pending</span></td>
              <td>
                <button class="btn small" onclick="verify('U102')">Verify</button>
                <button class="btn small secondary">Reject</button>
              </td>
            </tr>
            <tr data-role="moderator" data-status="suspended">
              <td><input type="checkbox"/></td>
              <td>U103</td>
              <td>Mike Chan</td>
              <td><span class="badge mod">Moderator</span></td>
              <td><span class="badge danger">Suspended</span></td>
              <td>
                <button class="btn small" onclick="unsuspend('U103')">Unsuspend</button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="pagination">
          <button class="btn secondary">Prev</button>
          <span>Page 1 of 10</span>
          <button class="btn secondary">Next</button>
        </div>
      </section>
    </main>
  </div>

  <script>
    function toggleAll(cb){
      document.querySelectorAll('#userTable input[type="checkbox"]').forEach(c => c.checked = cb.checked);
    }
    function bulkEnable(){ alert('Enabled selected users'); }
    function bulkDisable(){ alert('Disabled selected users'); }
    function bulkDelete(){ alert('Deleted selected users'); }
    function verify(id){ alert('Verified counselor '+id); }
    function unsuspend(id){ alert('Unsuspended user '+id); }
    const search = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    const rows = () => Array.from(document.querySelectorAll('#userTable tr'));
    function applyFilters(){
      const q = search.value.toLowerCase();
      const role = roleFilter.value;
      const status = statusFilter.value;
      rows().forEach(r => {
        const id = r.children[1].textContent.toLowerCase();
        const name = r.children[2].textContent.toLowerCase();
        const rRole = r.dataset.role;
        const rStatus = r.dataset.status;
        const matchesQ = !q || id.includes(q) || name.includes(q);
        const matchesRole = role === 'all' || rRole === role;
        const matchesStatus = status === 'all' || rStatus === status;
        r.style.display = (matchesQ && matchesRole && matchesStatus) ? '' : 'none';
      });
    }
    [search, roleFilter, statusFilter].forEach(el => el.addEventListener('input', applyFilters));
  </script>
</body>
</html>