<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Counselors - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>
<body>
    <!-- Sidebar -->
    <?php 
    $activePage = 'manage-users';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php 
        $topbarTitle = 'Approve Counselors';
        include '_topbar.php'; 
        ?>

        <div class="content-wrapper">
            <div class="page-header">
                <h2>👨‍⚕️ Counselor Applications</h2>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon orange">⏳</div>
                    <div class="stat-details">
                        <h3>Pending Approval</h3>
                        <p class="stat-number">5</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">✅</div>
                    <div class="stat-details">
                        <h3>Approved</h3>
                        <p class="stat-number">32</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue">👨‍⚕️</div>
                    <div class="stat-details">
                        <h3>Active Counselors</h3>
                        <p class="stat-number">28</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">📅</div>
                    <div class="stat-details">
                        <h3>Total Sessions</h3>
                        <p class="stat-number">1,245</p>
                    </div>
                </div>
            </div>

            <!-- Pending Applications -->
            <div class="section-card">
                <div class="section-header">
                    <h2>⏳ Pending Applications</h2>
                </div>

                <!-- Application Card 1 -->
                <div class="counselor-app-card">
                    <div class="app-header">
                        <div class="counselor-info">
                            <div class="counselor-avatar">DS</div>
                            <div>
                                <h3>Dr. Sarah Johnson</h3>
                                <p>Clinical Psychologist</p>
                            </div>
                        </div>
                        <span class="app-status pending">⏳ Pending</span>
                    </div>
                    <div class="app-details">
                        <div class="detail-row">
                            <strong>📧 Email:</strong> sarah.johnson@email.com
                        </div>
                        <div class="detail-row">
                            <strong>📞 Phone:</strong> +94 77 123 4567
                        </div>
                        <div class="detail-row">
                            <strong>🎓 Qualification:</strong> PhD in Clinical Psychology
                        </div>
                        <div class="detail-row">
                            <strong>🏥 Experience:</strong> 8 years in counseling and therapy
                        </div>
                        <div class="detail-row">
                            <strong>🎯 Specialization:</strong> Anxiety, Depression, Trauma
                        </div>
                        <div class="detail-row">
                            <strong>📄 License Number:</strong> PSY-2024-0845
                        </div>
                        <div class="detail-row">
                            <strong>📅 Applied:</strong> January 15, 2025
                        </div>
                    </div>
                    <div class="app-documents">
                        <strong>📎 Attached Documents:</strong>
                        <div class="doc-list">
                            <a href="#" class="doc-link">📄 CV.pdf</a>
                            <a href="#" class="doc-link">📄 License.pdf</a>
                            <a href="#" class="doc-link">📄 Certificates.pdf</a>
                        </div>
                    </div>
                    <div class="app-actions">
                        <button class="btn btn-success">✅ Approve</button>
                        <button class="btn btn-danger">❌ Reject</button>
                        <button class="btn btn-secondary">📧 Request More Info</button>
                    </div>
                </div>

                <!-- Application Card 2 -->
                <div class="counselor-app-card">
                    <div class="app-header">
                        <div class="counselor-info">
                            <div class="counselor-avatar">MP</div>
                            <div>
                                <h3>Mr. Michael Perera</h3>
                                <p>Licensed Counselor</p>
                            </div>
                        </div>
                        <span class="app-status pending">⏳ Pending</span>
                    </div>
                    <div class="app-details">
                        <div class="detail-row">
                            <strong>📧 Email:</strong> m.perera@email.com
                        </div>
                        <div class="detail-row">
                            <strong>📞 Phone:</strong> +94 71 987 6543
                        </div>
                        <div class="detail-row">
                            <strong>🎓 Qualification:</strong> MSc in Counseling Psychology
                        </div>
                        <div class="detail-row">
                            <strong>🏥 Experience:</strong> 5 years in student counseling
                        </div>
                        <div class="detail-row">
                            <strong>🎯 Specialization:</strong> Stress Management, Academic Pressure
                        </div>
                        <div class="detail-row">
                            <strong>📄 License Number:</strong> COUNS-2023-1234
                        </div>
                        <div class="detail-row">
                            <strong>📅 Applied:</strong> January 18, 2025
                        </div>
                    </div>
                    <div class="app-documents">
                        <strong>📎 Attached Documents:</strong>
                        <div class="doc-list">
                            <a href="#" class="doc-link">📄 Resume.pdf</a>
                            <a href="#" class="doc-link">📄 Credentials.pdf</a>
                        </div>
                    </div>
                    <div class="app-actions">
                        <button class="btn btn-success">✅ Approve</button>
                        <button class="btn btn-danger">❌ Reject</button>
                        <button class="btn btn-secondary">📧 Request More Info</button>
                    </div>
                </div>
            </div>

            <!-- Approved Counselors -->
            <div class="section-card" style="margin-top: 30px;">
                <div class="section-header">
                    <h2>✅ Approved Counselors</h2>
                </div>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Specialization</th>
                            <th>Status</th>
                            <th>Sessions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dr. Emily Chen</td>
                            <td>emily.chen@email.com</td>
                            <td>Anxiety, Depression</td>
                            <td><span class="badge status-active">Active</span></td>
                            <td>145</td>
                            <td>
                                <button class="btn-icon" title="View Profile">👁️</button>
                                <button class="btn-icon" title="Suspend">⏸️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Mr. David Silva</td>
                            <td>d.silva@email.com</td>
                            <td>Stress Management</td>
                            <td><span class="badge status-active">Active</span></td>
                            <td>98</td>
                            <td>
                                <button class="btn-icon" title="View Profile">👁️</button>
                                <button class="btn-icon" title="Suspend">⏸️</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
    <style>
        .counselor-app-card {
            padding: 25px;
            border-bottom: 1px solid #ecf0f1;
            transition: background 0.3s;
        }
        .counselor-app-card:hover {
            background: #f8f9fa;
        }
        .app-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .counselor-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .counselor-avatar {
            width: 60px;
            height: 60px;
            background: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }
        .counselor-info h3 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 3px;
        }
        .counselor-info p {
            color: #7f8c8d;
            font-size: 14px;
        }
        .app-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .app-status.pending {
            background: #fff3cd;
            color: #856404;
        }
        .app-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        .detail-row {
            font-size: 14px;
            color: #555;
        }
        .detail-row strong {
            color: #2c3e50;
        }
        .app-documents {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .app-documents strong {
            display: block;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        .doc-list {
            display: flex;
            gap: 15px;
        }
        .doc-link {
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }
        .doc-link:hover {
            text-decoration: underline;
        }
        .app-actions {
            display: flex;
            gap: 10px;
        }
    </style>
</body>
</html>

