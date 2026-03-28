<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & User Moods - Admin | Mind Haven</title>
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
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
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
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item active">
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
            <h1>Reports Management</h1>
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
                <div
                    style="background-color: #d1fae5; color: #065f46; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    <?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div
                    style="background-color: #fee2e2; color: #991b1b; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="filters" style="margin-bottom: 20px;">
                <form action="<?= BASE_URL ?>/admin/reports" method="GET">
                    <label for="status">Filter by Status:</label>
                    <select name="status" id="status" onchange="this.form.submit()" style="padding: 5px;">
                        <option value="pending" <?= $currentStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="reviewed" <?= $currentStatus === 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                        <option value="resolved" <?= $currentStatus === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                        <option value="dismissed" <?= $currentStatus === 'dismissed' ? 'selected' : '' ?>>Dismissed
                        </option>
                    </select>
                </form>
            </div>

            <div class="reports-table-container">
                <?php if (empty($reports)): ?>
                    <p>No reports found for this status.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Reporter</th>
                                <th>Content Owner</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports as $report): ?>
                                <tr>
                                    <td><?= $report['id'] ?></td>
                                    <td><?= htmlspecialchars($report['category_name']) ?></td>
                                    <td><?= ucfirst($report['content_type']) ?></td>
                                    <td><?= htmlspecialchars($report['reporter_name']) ?></td>
                                    <td><?= htmlspecialchars($report['owner_name']) ?></td>
                                    <td><?= date('M j, Y g:i a', strtotime($report['created_at'])) ?></td>
                                    <td>
                                        <span class="status-badge <?= $report['status'] ?>">
                                            <?= ucfirst($report['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-view" onclick='openReportModal(<?= json_encode($report) ?>)'>
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Report Details Modal -->
    <div id="reportModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeReportModal()">&times;</span>
            <h2>Report Details #<span id="modalReportIdDisplay"></span></h2>

            <div class="modal-section">
                <h3>Report Information</h3>
                <div class="modal-data">
                    <p><strong>Category:</strong> <span id="modalCategory"></span></p>
                    <p><strong>Reporter:</strong> <span id="modalReporter"></span></p>
                    <p><strong>Explanation:</strong> <span id="modalExplanation"></span></p>
                    <p><strong>Date:</strong> <span id="modalDate"></span></p>
                </div>
            </div>

            <div class="modal-section">
                <h3>Reported Content</h3>
                <div class="modal-data">
                    <p><strong>Type:</strong> <span id="modalContentType"></span></p>
                    <p><strong>Owner:</strong> <span id="modalContentOwner"></span></p>
                    <p><strong>Content ID:</strong> <span id="modalContentId"></span></p>
                    <div style="margin-top: 10px;">
                        <a href="#" id="modalContentLink" target="_blank" style="color: #3b82f6;">View Content on
                            Site</a>
                    </div>
                </div>
            </div>

            <div class="action-bar">
                <!-- Suspend User Form -->
                <form action="<?= BASE_URL ?>/admin/suspend-user" method="POST"
                    onsubmit="return confirm('Are you sure you want to suspend this user?');">
                    <input type="hidden" name="user_id" id="modalUserIdInput">
                    <button type="submit" class="btn-danger">Suspend Owner</button>
                </form>

                <!-- Update Status Form -->
                <form action="<?= BASE_URL ?>/admin/update-report-status" method="POST">
                    <input type="hidden" name="report_id" id="modalReportIdInput">

                    <div style="margin-bottom: 10px;">
                        <label>
                            <input type="checkbox" name="delete_content" value="1" id="deleteContentCheckbox">
                            Delete Reported Content (if Resolving)
                        </label>
                    </div>

                    <select name="status" style="padding: 8px; border-radius: 4px; margin-right: 10px;">
                        <option value="pending">Mark as Pending</option>
                        <option value="reviewed">Mark as Reviewed</option>
                        <option value="resolved">Mark as Resolved</option>
                        <option value="dismissed">Dismiss Report</option>
                    </select>

                    <button type="submit" class="btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById("reportModal");

        function openReportModal(report) {
            document.getElementById("modalReportIdDisplay").innerText = report.id;
            document.getElementById("modalCategory").innerText = report.category_name;
            document.getElementById("modalReporter").innerText = report.reporter_name;
            document.getElementById("modalExplanation").innerText = report.explanation || 'None';
            document.getElementById("modalDate").innerText = report.created_at;

            document.getElementById("modalContentType").innerText = report.content_type;
            document.getElementById("modalContentOwner").innerText = report.owner_name;
            document.getElementById("modalContentId").innerText = report.content_id;

            // Construct content link
            let link = '<?= BASE_URL ?>/forum/thread/' + (report.content_type === 'thread' ? report.content_id : 'post/' + report.content_id);
            // If it's a post/reply, we might need logic to find thread ID. 
            // For now, simpler to exact thread if type is thread, else generic or handle in backend.
            // A simple hack: if post, we can't easily jump to it without thread ID.
            // Ideally, the report query would join threads to get thread_id for posts.
            // For now let's just make it a weak link or search.
            document.getElementById("modalContentLink").href = '<?= BASE_URL ?>/forum'; // Placeholder if we lack complex thread resolution logic on client side

            document.getElementById("modalReportIdInput").value = report.id;
            document.getElementById("modalUserIdInput").value = report.content_owner_id;

            // Pre-select status
            const statusSelect = document.querySelector('select[name="status"]');
            statusSelect.value = report.status;

            modal.style.display = "block";
        }

        function closeReportModal() {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                closeReportModal();
            }
        }
    </script>
</body>

</html>