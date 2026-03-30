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
      <!-- Keywords and Automated Flags removed and moved to Moderate Forum -->            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item">
                <span class="icon">???</span>
                University Events
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
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <?= $_SESSION['success'];
          unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
          <?= $_SESSION['error'];
          unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <div class="toolbar">
        <div class="tabs">
          <button class="tab active" data-tab="preview">Preview</button>
          <button class="tab" data-tab="queue">Flagged Queue</button>
          <button class="tab" data-tab="auto-flags">Automated Flags</button>
          <a href="<?= BASE_URL ?>/admin/report-categories" class="tab-link"
            style="text-decoration:none; display:flex; align-items:center;">
            Customize Categories
          </a>
          <a href="<?= BASE_URL ?>/admin/keywords" class="tab-link"
            style="text-decoration:none; display:flex; align-items:center; margin-left:10px;">
            Manage Keywords
          </a>
        </div>
        <div>
          <!-- <button class="btn" onclick="bulkFlag()">Flag Selected</button> -->
          <!-- <button class="btn secondary" onclick="bulkDelete()">Delete Selected</button> -->
        </div>
      </div>

      <!-- Embed/preview the UG forum page -->
      <section id="forumPreview" class="embed">
        <div class="embed-header">
          <strong>Student Forum Preview</strong>
          <span class="chip">Moderator View</span>
        </div>
        <iframe src="<?= BASE_URL ?>/forum?embed=true"
          style="width:100%; height:calc(100vh - 220px); min-height:600px; border:0; background:#fff; border-radius: 8px;"></iframe>
      </section>

      <!-- Flag/Delete queue (frontend only) -->
      <section id="queueList" class="list" style="display:none;">
        <h2>Flagged/Reported Items</h2>
        <div id="queue">
          <?php if (empty($reports)): ?>
            <p>No pending reports.</p>
          <?php else: ?>
            <?php foreach ($reports as $report): ?>
              <div class="row">
                <!-- <input type="checkbox" /> -->
                <div class="report-details" style="flex: 1;">
                  <span class="title">
                    <strong><?= htmlspecialchars($report['content_type']) ?>:</strong>
                    <?= htmlspecialchars($report['content_title']) ?>
                  </span>
                  <p class="snippet"><?= htmlspecialchars($report['content_snippet']) ?></p>
                  <div class="meta">
                    <span class="chip">Reported by: <?= htmlspecialchars($report['reporter_name']) ?></span>
                    <span class="chip">Category: <?= htmlspecialchars($report['category_name']) ?></span>
                    <span class="chip">Reason: <?= htmlspecialchars($report['explanation']) ?></span>
                  </div>
                  <div class="user-stats" style="margin-top: 5px; font-size: 0.9em; color: #555;">
                    <strong>Owner:</strong> <?= htmlspecialchars($report['owner_name']) ?> |
                    <strong>Strikes:</strong> <span
                      style="color: red;"><?= htmlspecialchars($report['strike_count'] ?? 0) ?></span> |
                    <strong>Status:</strong> <?= htmlspecialchars($report['account_status'] ?? 'active') ?>
                  </div>
                </div>

                <div class="actions">
                  <form action="<?= BASE_URL ?>/admin/update-report-status" method="POST" style="display:inline;">
                    <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                    <input type="hidden" name="status" value="resolved">
                    <button type="submit" class="btn secondary">Approve (Keep Content)</button>
                  </form>

                  <button type="button" class="btn secondary" style="background-color: #f59e0b; margin-left: 5px;"
                    onclick="openEditModal(<?= htmlspecialchars(json_encode($report)) ?>)">
                    Edit Content
                  </button>

                  <form action="<?= BASE_URL ?>/admin/update-report-status" method="POST"
                    style="display:inline; margin-left: 5px;">
                    <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                    <input type="hidden" name="status" value="resolved">
                    <input type="hidden" name="delete_content" value="1">
                    <button type="submit" class="btn danger"
                      onclick="return confirm('Are you sure you want to delete this content? This will add a strike to the user.')">Delete
                      & Resolve</button>
                  </form>

                  <?php if (($report['account_status'] ?? 'active') !== 'suspended' && ($report['account_status'] ?? 'active') !== 'banned'): ?>
                    <button type="button" class="btn danger" style="margin-left: 5px; background-color: #dc2626;"
                      onclick="openSuspendModal(<?= $report['owner_id'] ?>, '<?= htmlspecialchars($report['owner_name']) ?>')">
                      Suspend User
                    </button>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </section>

      <!-- Automated Flags Section -->
      <section id="autoFlagsList" class="list" style="display:none;">
        <h2>Automated System Flags</h2>
        <div id="autoQueue">
          <?php if (empty($systemFlags)): ?>
            <p>No content currently flagged by the system.</p>
          <?php else: ?>
            <?php foreach ($systemFlags as $flag): ?>
              <div class="row" style="background: #fff4f4; border-left: 4px solid #ef4444;">
                <div class="report-details" style="flex: 1;">
                  <span class="title">
                    <strong><?= htmlspecialchars($flag['content_type']) ?>:</strong>
                    <?= htmlspecialchars($flag['content_title']) ?>
                  </span>
                  <p class="snippet"><?= htmlspecialchars($flag['content_snippet']) ?></p>
                  <div class="user-stats" style="margin-top: 5px; font-size: 0.9em; color: #555;">
                    <strong>Matched Keyword:</strong> <span class="match-highlight"
                      style="background-color: #fca5a5; padding: 2px 5px; border-radius: 4px; font-weight: bold;"><?= htmlspecialchars($flag['matched_keyword']) ?></span>
                    |
                    <strong>Owner:</strong> <?= htmlspecialchars($flag['owner_name']) ?> |
                    <strong>Strikes:</strong> <span
                      style="color: red;"><?= htmlspecialchars($flag['strike_count'] ?? 0) ?></span> |
                    <strong>Status:</strong> <?= htmlspecialchars($flag['account_status'] ?? 'active') ?>
                  </div>
                  <div class="meta" style="margin-top: 5px;">
                    <span class="chip">Date: <?= htmlspecialchars($flag['created_at']) ?></span>
                  </div>
                </div>

                <div class="actions">
                  <form action="<?= BASE_URL ?>/admin/update-system-flag-status" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $flag['id'] ?>">
                    <input type="hidden" name="status" value="reviewed">
                    <button type="submit" class="btn secondary">Approve (Keep Content)</button>
                  </form>

                  <button type="button" class="btn secondary" style="background-color: #f59e0b; margin-left: 5px;"
                    onclick="openEditModal(<?= htmlspecialchars(json_encode($flag)) ?>, true)">
                    Edit Content
                  </button>

                  <form action="<?= BASE_URL ?>/admin/update-system-flag-status" method="POST"
                    style="display:inline; margin-left: 5px;">
                    <input type="hidden" name="id" value="<?= $flag['id'] ?>">
                    <input type="hidden" name="status" value="resolved">
                    <input type="hidden" name="delete_content" value="1">
                    <button type="submit" class="btn danger"
                      onclick="return confirm('Are you sure you want to delete this content? This will add a strike to the user.')">Delete
                      & Resolve</button>
                  </form>

                  <?php if (($flag['account_status'] ?? 'active') !== 'suspended' && ($flag['account_status'] ?? 'active') !== 'banned'): ?>
                    <button type="button" class="btn danger" style="margin-left: 5px; background-color: #dc2626;"
                      onclick="openSuspendModal(<?= $flag['owner_id'] ?>, '<?= htmlspecialchars($flag['owner_name']) ?>')">
                      Suspend User
                    </button>
                  <?php endif; ?>

                  <a href="<?= BASE_URL ?>/forum/thread/<?= $flag['content_type'] === 'thread' ? $flag['content_id'] : '' ?>"
                    target="_blank" class="btn secondary" style="margin-left:5px;">View Context</a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </section>

      </main>
    </div>

    <!-- Edit Content Modal -->
    <div id="editModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Reported Content</h2>
        <form action="<?= BASE_URL ?>/admin/edit-reported-content" method="POST">
          <input type="hidden" name="report_id" id="editReportId">
          <input type="hidden" name="flag_id" id="editFlagId">
          <input type="hidden" name="post_id" id="editPostId">

          <div class="form-row">
            <label for="editContent">Content:</label>
            <textarea name="content" id="editContent" rows="6"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Suspend User Modal -->
  <div id="suspendModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeSuspendModal()">&times;</span>
      <h2>Suspend User</h2>
      <p>Suspending user: <span id="suspendUserName" style="font-weight:bold;"></span></p>
      <form action="<?= BASE_URL ?>/admin/suspend-user" method="POST">
        <input type="hidden" name="user_id" id="suspendUserId">

        <div class="form-row">
          <label for="suspensionDays">Duration (Days):</label>
          <select name="suspension_days" id="suspensionDays" class="form-input">
            <option value="1">1 Day</option>
            <option value="3">3 Days</option>
            <option value="7">7 Days</option>
            <option value="30">30 Days</option>
            <option value="">Indefinite</option>
          </select>
        </div>

        <button type="submit" class="btn btn-danger">Confirm Suspension</button>
      </form>
    </div>
  </div>

  <script>
    // Tabs
    document.querySelectorAll('.tab').forEach(btn => {
      btn.addEventListener('click', function (e) {
        // Remove active class from all tabs
        document.querySelectorAll('.tab').forEach(b => b.classList.remove('active'));

        // Add active class to clicked tab
        this.classList.add('active');

        const tab = this.dataset.tab;
        if (tab) {
          document.getElementById('forumPreview').style.display = tab === 'preview' ? 'block' : 'none';
          document.getElementById('queueList').style.display = tab === 'queue' ? 'block' : 'none';
          document.getElementById('autoFlagsList').style.display = tab === 'auto-flags' ? 'block' : 'none';
        }
      });
    });

    // Handle initial tab based on URL parameter
    window.addEventListener('load', function () {
      const urlParams = new URLSearchParams(window.location.search);
      const tab = urlParams.get('tab');
      if (tab) {
        const tabBtn = document.querySelector(`.tab[data-tab="${tab}"]`);
        if (tabBtn) tabBtn.click();
      }
    });

    // Edit Modal Functions
    const editModal = document.getElementById('editModal');

    function openEditModal(item, isSystemFlag = false) {
      if (isSystemFlag) {
        document.getElementById('editFlagId').value = item.id;
        document.getElementById('editReportId').value = '';
      } else {
        document.getElementById('editReportId').value = item.id;
        document.getElementById('editFlagId').value = '';
      }

      document.getElementById('editPostId').value = item.content_id;

      // Decode html entities for editing
      const txt = document.createElement("textarea");
      txt.innerHTML = item.full_content || item.content_snippet;

      document.getElementById('editContent').value = txt.value;

      editModal.style.display = "block";
    }

    function closeEditModal() {
      editModal.style.display = "none";
    }

    // Suspend Modal Functions
    const suspendModal = document.getElementById('suspendModal');

    function openSuspendModal(userId, userName) {
      document.getElementById('suspendUserId').value = userId;
      document.getElementById('suspendUserName').textContent = userName;
      suspendModal.style.display = "block";
    }

    function closeSuspendModal() {
      suspendModal.style.display = "none";
    }

    window.onclick = function (event) {
      if (event.target == editModal) {
        closeEditModal();
      }
      if (event.target == suspendModal) {
        closeSuspendModal();
      }
    }
  </script>
</body>

</html>
