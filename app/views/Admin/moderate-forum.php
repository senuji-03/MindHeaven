<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moderate Forum</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
  <header class="topbar">
    <h1>Moderate Forum</h1>
    <div class="icons">
      <a href="<?= BASE_URL ?>/logout" class="btn-top">Logout</a>
    </div>
  </header>

  <div class="container">
    <aside class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= BASE_URL ?>/admin">Dashboard</a></li>
        <li><a href="<?= BASE_URL ?>/admin/manage-users">Manage Users</a></li>
        <li><a href="<?= BASE_URL ?>/admin/moderate-forum" class="active">Moderate Forum</a></li>
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
      <div class="toolbar">
        <div class="tabs">
          <button class="tab active" data-tab="preview">Preview</button>
          <button class="tab" data-tab="queue">Flagged Queue</button>
        </div>
        <div>
          <button class="btn" onclick="bulkFlag()">Flag Selected</button>
          <button class="btn secondary" onclick="bulkDelete()">Delete Selected</button>
        </div>
      </div>

      <!-- Embed/preview the UG forum page -->
      <section id="forumPreview" class="embed">
        <div class="embed-header">
          <strong>Student Forum Preview</strong>
          <a href="<?= BASE_URL ?>/ug/forum" target="_blank" class="btn secondary">Open in new tab</a>
          <span class="chip">Moderator View</span>
        </div>
        <iframe src="<?= BASE_URL ?>/ug/forum" style="width:100%; height:500px; border:0; background:#fff"></iframe>
      </section>

      <!-- Flag/Delete queue (frontend only) -->
      <section id="queueList" class="list" style="display:none;">
        <h2>Flagged/Reported Items</h2>
        <div id="queue">
          <div class="row">
            <input type="checkbox" />
            <span class="title">Thread: "Struggling with exam anxiety"</span>
            <span class="chip">Reported</span>
            <button class="btn secondary" onclick="approveItem(this)">Approve</button>
            <button class="btn" onclick="deleteItem(this)">Delete</button>
          </div>
          <div class="row">
            <input type="checkbox" />
            <span class="title">Reply: "Just skip exams"</span>
            <span class="chip">Flagged</span>
            <button class="btn secondary" onclick="approveItem(this)">Approve</button>
            <button class="btn" onclick="deleteItem(this)">Delete</button>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
    // Tabs
    document.querySelectorAll('.tab').forEach(btn => {
      btn.addEventListener('click', function(){
        document.querySelectorAll('.tab').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const tab = this.dataset.tab;
        document.getElementById('forumPreview').style.display = tab === 'preview' ? 'block' : 'none';
        document.getElementById('queueList').style.display = tab === 'queue' ? 'block' : 'none';
      });
    });
    function approveItem(btn){
      const row = btn.closest('.row');
      row.querySelector('.chip').textContent = 'Approved';
      row.querySelector('.chip').style.background = '#d1fae5';
      row.querySelector('.chip').style.color = '#065f46';
    }
    function deleteItem(btn){
      const row = btn.closest('.row');
      row.remove();
    }
    function bulkFlag(){
      document.querySelectorAll('#queue .row input[type="checkbox"]:checked').forEach(cb=>{
        const row = cb.closest('.row');
        row.querySelector('.chip').textContent = 'Flagged';
        row.querySelector('.chip').style.background = '#fee2e2';
        row.querySelector('.chip').style.color = '#991b1b';
      });
    }
    function bulkDelete(){
      document.querySelectorAll('#queue .row input[type="checkbox"]:checked').forEach(cb=>{
        cb.closest('.row').remove();
      });
    }
  </script>
</body>
</html>

