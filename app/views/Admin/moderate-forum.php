<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderate Forum - <?= ($_SESSION['role'] === 'admin') ? 'Admin' : 'Moderator' ?> | Mind Haven</title>
    <!-- Fonts and Icons (from Design System) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        :root {
            --primary:#3D8B6E; --primary-light:#6BB89A; --primary-dark:#2A6B52;
            --bg-deep:#1C2B2A; --bg-soft:#F5F0E8; --bg-mid:#EEF6F2;
            --text-primary:#1E3A34; --text-secondary:#6B8C7E;
            --surface:#FFFFFF; --border:#D6E4DD;
            --radius-sm:8px; --radius-lg:20px; --radius-full:9999px;
            --shadow-sm:0 1px 3px rgba(30,58,52,.06);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', 'Inter', system-ui, -apple-system, sans-serif;
            background: #F5F0E8; /* --bg-soft */
            min-height: 100vh;
            color: #1E3A34; /* --text-primary */
        }

        .sidebar {
            width:280px; height:100vh; background:var(--bg-deep);
            position:fixed; left:0; top:0;
            display:flex; flex-direction:column; z-index:1000;
        }
        .sidebar-header { padding:36px 28px 28px; border-bottom:1px solid rgba(255,255,255,.08); }
        .sidebar-header h2 { font-size:1.4rem; font-weight:700; color:var(--primary-light); margin-bottom:6px; }
        .sidebar-header p  { font-size:.75rem; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:1.5px; }
        .sidebar-nav { flex:1; padding:24px 16px; overflow-y:auto; }
        .nav-item {
            display:flex; align-items:center; gap:12px;
            padding:12px 16px; color:rgba(255,255,255,.65);
            text-decoration:none; border-radius:var(--radius-sm);
            margin-bottom:4px; font-weight:500; font-size:.95rem;
            transition:all .25s ease;
        }
        .nav-item i { width:20px; text-align:center; font-size:1rem; }
        .nav-item:hover { background:rgba(255,255,255,.07); color:white; transform:translateX(3px); }
        .nav-item.active { background:var(--primary); color:white; box-shadow:0 4px 12px rgba(61,139,110,.3); }
        .sidebar-footer { padding:20px 16px; border-top:1px solid rgba(255,255,255,.08); }
        .logout-btn {
            display:flex; align-items:center; gap:12px;
            padding:12px 16px; color:#FFB3B3;
            text-decoration:none; border-radius:var(--radius-sm);
            font-weight:600; font-size:.9rem; transition:all .25s;
        }
        .logout-btn:hover { background:rgba(214,79,79,.1); }
            transition: all 0.3s ease;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        <?php include '_forum_styles.php'; ?>

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:not(.secondary) {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn:not(.secondary):hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        .btn.secondary {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .btn.secondary:hover {
            background: #e2e8f0;
            color: #475569;
        }

        .embed {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .embed-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .embed-header strong {
            font-size: 1.1rem;
            color: #1e293b;
        }

        .chip {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .list h2 {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
            font-size: 1.3rem;
        }

        .row {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .row:hover {
            background: #f8fafc;
        }

        .row:last-child {
            border-bottom: none;
        }

        .row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #667eea;
        }

        .row .title {
            flex: 1;
            font-weight: 500;
            color: #1e293b;
        }

        .row .chip {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }

        .row .chip:not(.approved) {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #991b1b;
        }

        .row .chip.approved {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }

        .row .btn {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .toolbar-actions {
            display: flex;
            gap: 0.75rem;
        }

        .embed-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .embed-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .list-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .list-header h2 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
            padding: 0;
            background: none;
            border: none;
        }

        .list-stats {
            display: flex;
            gap: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        .stat-item {
            color: #64748b;
        }

        .content-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .content-info .meta {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        iframe {
            border: none;
            border-radius: 0 0 12px 12px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .tabs {
                justify-content: center;
            }

            .embed-header {
                flex-direction: column;
                text-align: center;
            }

            .row {
                flex-direction: column;
                align-items: stretch;
                gap: 0.5rem;
            }

            .row .title {
                margin-bottom: 0.5rem;
            }
        }

        /* Animation for smooth transitions */
        .embed, .list {
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading state */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            color: #64748b;
        }

        .loading::after {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid #e2e8f0;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>


<body>
  <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p><?= (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? 'Admin Panel' : 'Moderator Panel' ?></p>
        </div>
        <nav class="sidebar-nav">
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>/admin" class="nav-item"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item"><i class="fas fa-users"></i> Manage Users</a>
                <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active"><i class="fas fa-comments"></i> Moderate Forum</a>
                <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item"><i class="fas fa-calendar-check"></i> Appointments</a>
                <a href="<?= BASE_URL ?>/admin/reports" class="nav-item"><i class="fas fa-chart-bar"></i> System Reports</a>
                <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item"><i class="fas fa-university"></i> University Events</a>
                <a href="<?= BASE_URL ?>/admin/donations" class="nav-item"><i class="fas fa-hand-holding-usd"></i> Donation Logs</a>
                <a href="<?= BASE_URL ?>/EditPosts" class="nav-item"><i class="fas fa-edit"></i> Edit Resources</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="<?= BASE_URL ?>/Moderator/resource-hub" class="nav-item"><i class="fas fa-book"></i> Resource Hub</a>
                <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item active"><i class="fas fa-comments"></i> Moderate Forum</a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Top Bar -->
    <div class="topbar">
      <h1>Moderate Forum</h1>
      <div class="topbar-right">
        <?php if ($_SESSION['role'] === 'admin'): ?>
          <a href="<?= BASE_URL ?>/admin/profile" style="text-decoration: none; color: inherit;">
            <div class="admin-profile" style="cursor: pointer;">
              <span>Admin User</span>
              <div class="avatar">A</div>
            </div>
          </a>
        <?php else: ?>
          <div style="display: flex; align-items: center; gap: 0.75rem; background: #f8fafc; padding: 0.5rem 1rem; border-radius: 99px; border: 1px solid #e2e8f0;">
            <div style="width: 32px; height: 32px; background: #6366f1; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">
              <?= strtoupper(substr($_SESSION['role'], 0, 1)) ?>
            </div>
            <span style="font-size: 0.875rem; font-weight: 600; color: #1e293b;">Moderator</span>
          </div>
        <?php endif; ?>
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

      <?php 
      // Set active tab based on query param for the partial
      $activeTab = $_GET['tab'] ?? 'preview';
      include '_forum_tabs.php'; 
      ?>


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
                <div class="list-header">
                    <h2>
                        🚩 Flagged/Reported Items
                    </h2>

                </div>
        <div id="queue">
          <?php if (empty($reports)): ?>
            <p>No pending reports.</p>
          <?php else: ?>
            <?php foreach ($reports as $report): ?>
              <div class="row">
                <!-- <input type="checkbox" /> -->
                <div class="report-details" style="flex: 1;">
                  <span class="title">
                    <strong><?= htmlspecialchars(!empty($report['content_type']) ? $report['content_type'] : 'unknown') ?>:</strong>
                    <?= htmlspecialchars($report['content_title'] ?? 'Unknown/Deleted Content') ?>
                  </span>
                  <p class="snippet"><?= htmlspecialchars($report['content_snippet'] ?? 'Content could not be loaded.') ?></p>
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

                  <?php if (!empty($report['context_url'])): ?>
                    <a href="<?= htmlspecialchars($report['context_url']) ?>" target="_blank" class="btn secondary" style="margin-left:5px;">View Context</a>
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
                    <strong><?= htmlspecialchars(!empty($flag['content_type']) ? $flag['content_type'] : 'unknown') ?>:</strong>
                    <?= htmlspecialchars($flag['content_title'] ?? 'Unknown/Deleted Content') ?>
                  </span>
                  <p class="snippet"><?= htmlspecialchars($flag['content_snippet'] ?? 'Content could not be loaded.') ?></p>
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

                  <?php if (!empty($flag['context_url'])): ?>
                    <a href="<?= htmlspecialchars($flag['context_url']) ?>" target="_blank" class="btn secondary" style="margin-left:5px;">View Context</a>
                  <?php endif; ?>
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

  <script>    // Tab Switching Logic
    document.querySelectorAll('.tab[data-tab]').forEach(tabBtn => {
      tabBtn.addEventListener('click', function (e) {
        // Since we are now using <a> tags in the shared partial, 
        // we prevent default only for on-page tabs
        e.preventDefault();
        
        // Update active class
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        const tab = this.dataset.tab;
        if (tab) {
          // Update visual sections
          document.getElementById('forumPreview').style.display = tab === 'preview' ? 'block' : 'none';
          document.getElementById('queueList').style.display = tab === 'queue' ? 'block' : 'none';
          document.getElementById('autoFlagsList').style.display = tab === 'auto-flags' ? 'block' : 'none';
          
          // Update URL without reload to preserve state
          const newUrl = new URL(window.location);
          newUrl.searchParams.set('tab', tab);
          window.history.pushState({}, '', newUrl);
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
