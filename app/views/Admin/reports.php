<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & User Moods - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            color: white;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-header p {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left-color: #60a5fa;
        }

        .nav-item.active {
            background: rgba(96, 165, 250, 0.1);
            color: #60a5fa;
            border-left-color: #60a5fa;
        }

        .nav-item .icon {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: #f8fafc;
        }

        .topbar {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .topbar h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f1f5f9;
            border-radius: 50px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .content-wrapper {
            padding: 2rem;
        }

        /* Summary Cards */
        .summary-section {
            margin-bottom: 2rem;
        }

        .summary-section h2 {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .card-title {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .card-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .card-change.positive {
            color: #059669;
        }

        .card-change.negative {
            color: #dc2626;
        }

        /* Reports Section */
        .reports-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .reports-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reports-header h2 {
            color: #1e293b;
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
        }

        .filter-tab {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
        }

        .filter-tab:hover:not(.active) {
            background: #f1f5f9;
            color: #475569;
        }

        .reports-list {
            padding: 0;
        }

        .report-item {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .report-item:hover {
            background: #f8fafc;
        }

        .report-item:last-child {
            border-bottom: none;
        }

        .report-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .report-icon.high-risk {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #dc2626;
        }

        .report-icon.medium-risk {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #d97706;
        }

        .report-icon.low-risk {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #059669;
        }

        .report-content {
            flex: 1;
        }

        .report-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .report-meta {
            font-size: 0.85rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .report-status {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .report-status.pending {
            background: #fef3c7;
            color: #d97706;
        }

        .report-status.resolved {
            background: #d1fae5;
            color: #059669;
        }

        .report-status.investigating {
            background: #dbeafe;
            color: #2563eb;
        }

        .report-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .action-btn.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .action-btn.primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .action-btn.secondary {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .action-btn.secondary:hover {
            background: #e2e8f0;
            color: #475569;
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
        }

        .chart-period {
            font-size: 0.85rem;
            color: #64748b;
        }

        .chart-placeholder {
            height: 200px;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 0.9rem;
            border: 2px dashed #e2e8f0;
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

            .cards {
                grid-template-columns: 1fr;
            }

            .charts-section {
                grid-template-columns: 1fr;
            }

            .report-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .report-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* Animation for smooth transitions */
        .card, .report-item, .chart-card {
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
    </style>
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
            
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
            
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item active">
                <span class="icon">📈</span>
                Reports
                        </a>
            <a href="<?= BASE_URL ?>/admin/university-events" class="nav-item">
                <span class="icon">🏛️</span>
                University Events
            </a>
            <a href="<?= BASE_URL ?>/admin/donations" class="nav-item">
                <span class="icon"></span>
                Donation logs
            </a>
           
                    <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <span class="icon">✏️</span>
                Edit Resources
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

