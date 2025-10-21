<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderate Forum - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <span class="icon">👥</span>
                Manage Users
            </a>
            <a href="<?= BASE_URL ?>/admin/resource-hub" class="nav-item">
                <span class="icon">📚</span>
                Resource Hub
            </a>
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
            <a href="<?= BASE_URL ?>/admin/counselors" class="nav-item">
                <span class="icon">👨‍⚕️</span>
                Manage Counselors
            </a>
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span>
                Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/settings" class="nav-item">
                <span class="icon">⚙️</span>
                Settings
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Moderate Forum</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
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

