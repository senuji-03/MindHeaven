<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        /* Remove scrollbar and add smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        body {
            overflow-x: hidden;
        }
        
        ::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background: transparent;
        }
        
        /* For Firefox */
        html {
            scrollbar-width: none;
        }
        
        /* Hero section styling */
        .hero-title {
            text-align: right;
            margin-right: 20px;
        }
        
        .hero-subtitle {
            text-align: right;
            margin-right: 20px;
        }
        
        .hero-buttons {
            text-align: right;
            margin-right: 20px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .users-table th,
        .users-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        .users-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }
        .users-table tr:hover {
            background-color: #f9fafb;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-role-admin { background-color: #fef3c7; color: #92400e; }
        .badge-role-counselor { background-color: #dbeafe; color: #1e40af; }
        .badge-role-undergrad { background-color: #dcfce7; color: #166534; }
        .badge-role-moderator { background-color: #f3e8ff; color: #7c3aed; }
        .badge-role-call_responder { background-color: #fecaca; color: #dc2626; }
        .badge-role-donor { background-color: #fde68a; color: #d97706; }
        .btn-approve { background-color: #10b981; color: white; }
        .btn-reject { background-color: #ef4444; color: white; }
        
        .btn-icon {
            padding: 6px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-edit {
            background-color: #3b82f6;
            color: white;
        }
        .btn-edit:hover {
            background-color: #2563eb;
        }
        .btn-delete {
            background-color: #ef4444;
            color: white;
        }
        .btn-delete:hover {
            background-color: #dc2626;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6b7280;
        }
        .form-row {
            margin-bottom: 15px;
        }
        .form-row label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #374151;
        }
        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        .btn-danger {
            background-color: #ef4444;
            color: white;
        }
        .search-input {
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            width: 300px;
        }
        .filter-section {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 8px;
        }
        .filter-group {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        /* Tab Navigation Styles */
        .tab-navigation {
            display: flex;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 20px;
        }
        
        .tab-btn {
            padding: 12px 24px;
            border: none;
            background: none;
            cursor: pointer;
            font-weight: 500;
            color: #6b7280;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .tab-btn:hover {
            color: #374151;
            background-color: #f9fafb;
        }
        
        .tab-btn.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        /* Enhanced Pending Counselors Styles */
        .pending-counselor-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .pending-counselor-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }
        
        .pending-counselor-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .pending-counselor-info h4 {
            margin: 0 0 5px 0;
            color: #1f2937;
            font-size: 18px;
        }
        
        .pending-counselor-contact {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #6b7280;
            font-size: 14px;
        }
        
        .pending-counselor-badge {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .pending-counselor-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        
        .detail-value {
            font-weight: 500;
            color: #1f2937;
        }
        
        .pending-counselor-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            border-top: 1px solid #f3f4f6;
            padding-top: 15px;
        }
        
        .btn-approve-enhanced {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease;
        }
        
        .btn-approve-enhanced:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(16, 185, 129, 0.3);
        }
        
        .btn-reject-enhanced {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease;
        }
        
        .btn-reject-enhanced:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }
        
        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        .empty-state h3 {
            margin: 0 0 10px 0;
            color: #4b5563;
        }
        
        .empty-state p {
            margin: 0;
        }
        
        @media (max-width: 768px) {
            .pending-counselor-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .pending-counselor-details {
                grid-template-columns: 1fr;
            }
            
            .pending-counselor-actions {
                flex-direction: column;
            }
            
            .pending-counselor-contact {
                flex-direction: column;
                gap: 5px;
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
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item active">
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
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span>
                Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/donations" class="nav-item">
                <span class="icon"></span>
                Donation logs
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
            <h1>Manage Users</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

       

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Success/Error Messages -->
            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <?php if(isset($error)): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Header with Actions -->
            <div class="page-header">
                <h2>User Management</h2>
                <div style="display: flex; gap: 10px;">
                <button class="btn btn-primary" onclick="openCreateModal()">
                    ➕ Create New User
                </button>
                    <button class="btn btn-primary" onclick="openCreateUndergradModal()">
                        🎓 Create Undergraduate
                    </button>
                    <button class="btn btn-primary" onclick="openCreateCounselorModal()">
                        👨‍⚕️ Create Counselor
                    </button>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="tab-navigation" style="margin-bottom: 20px;">
                <button class="tab-btn active" onclick="showTab('all-users')">All Users</button>
                <button class="tab-btn" onclick="showTab('undergraduates')">Undergraduate Students</button>
                <button class="tab-btn" onclick="showTab('counselors')">Counselors</button>
                <button class="tab-btn" onclick="showTab('pending-counselors')">Pending Counselors (<?= count($pendingCounselors ?? []) ?>)</button>
            </div>

            <!-- All Users Tab -->
            <div id="all-users-tab" class="tab-content active">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-group">
                        <input type="text" placeholder="Search by name, email, or username..." class="search-input" id="searchInput" onkeyup="filterUsers()">
                        <select class="form-input" id="roleFilter" onchange="filterUsers()">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                            <option value="counselor">Counselor</option>
                            <option value="undergrad">Undergraduate</option>
                        <option value="moderator">Moderator</option>
                            <option value="call_responder">Call Responder</option>
                            <option value="donor">Donor</option>
                            <option value="university_rep">University Representative</option>
                    </select>
                    </div>
                </div>

                <!-- All Users Table -->
                <div class="section-card">
                    <h3 style="margin-bottom: 15px;">All Users</h3>
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <?php if(isset($users) && !empty($users)): ?>
                                <?php foreach($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['display_name'] ?? $user['full_name']) ?></td>
                                        <td><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($user['phone_number'] ?? 'N/A') ?></td>
                                        <td>
                                            <span class="badge badge-role-<?= htmlspecialchars($user['role']) ?>">
                                                <?= ucfirst(htmlspecialchars($user['role'])) ?>
                                            </span>
                                        </td>
                                        <td><?= $user['created_at'] ? date('Y-m-d', strtotime($user['created_at'])) : 'N/A' ?></td>
                                        <td>
                                            <button class="btn-icon btn-edit" onclick="openEditModal(<?= htmlspecialchars(json_encode($user)) ?>)">
                                                ✏️ Edit
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteUser(<?= htmlspecialchars($user['id']) ?>)">
                                                🗑️ Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 40px; color: #6b7280;">
                                        No users found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Undergraduate Students Tab -->
            <div id="undergraduates-tab" class="tab-content" style="display: none;">
                <div class="filter-section">
                    <div class="filter-group">
                        <input type="text" placeholder="Search undergraduate students..." class="search-input" id="undergradSearchInput" onkeyup="filterUndergrads()">
                    </div>
                </div>

            <div class="section-card">
                    <h3 style="margin-bottom: 15px;">Undergraduate Students (<?= count($undergraduateStudents ?? []) ?>)</h3>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                            <th>Email</th>
                                <th>Phone</th>
                                <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                        <tbody id="undergradTableBody">
                            <?php if(isset($undergraduateStudents) && !empty($undergraduateStudents)): ?>
                                <?php foreach($undergraduateStudents as $student): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($student['id']) ?></td>
                                        <td><?= htmlspecialchars($student['username']) ?></td>
                                        <td><?= htmlspecialchars($student['full_name']) ?></td>
                                        <td><?= htmlspecialchars($student['email']) ?></td>
                                        <td><?= htmlspecialchars($student['phone_number']) ?></td>
                                        <td><?= date('Y-m-d', strtotime($student['created_at'])) ?></td>
                                        <td>
                                            <button class="btn-icon btn-edit" onclick="openEditUndergradModal(<?= htmlspecialchars(json_encode($student)) ?>)">
                                                ✏️ Edit
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteUser(<?= htmlspecialchars($student['id']) ?>)">
                                                🗑️ Delete
                                            </button>
                            </td>
                        </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 40px; color: #6b7280;">
                                        No undergraduate students found
                            </td>
                        </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Counselors Tab -->
            <div id="counselors-tab" class="tab-content" style="display: none;">
                <div class="filter-section">
                    <div class="filter-group">
                        <input type="text" placeholder="Search counselors..." class="search-input" id="counselorSearchInput" onkeyup="filterCounselors()">
                    </div>
                </div>

                <div class="section-card">
                    <h3 style="margin-bottom: 15px;">Counselors (<?= count($counselors ?? []) ?>)</h3>
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Specialization</th>
                                <th>Experience</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="counselorTableBody">
                            <?php if(isset($counselors) && !empty($counselors)): ?>
                                <?php foreach($counselors as $counselor): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($counselor['id']) ?></td>
                                        <td><?= htmlspecialchars($counselor['username']) ?></td>
                                        <td><?= htmlspecialchars($counselor['full_name']) ?></td>
                                        <td><?= htmlspecialchars($counselor['email']) ?></td>
                                        <td><?= htmlspecialchars($counselor['phone_number']) ?></td>
                                        <td><?= htmlspecialchars($counselor['specialization'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($counselor['experience_years'] ?? 'N/A') ?> years</td>
                                        <td><?= date('Y-m-d', strtotime($counselor['created_at'])) ?></td>
                                        <td>
                                            <button class="btn-icon btn-edit" onclick="openEditCounselorModal(<?= htmlspecialchars(json_encode($counselor)) ?>)">
                                                ✏️ Edit
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteUser(<?= htmlspecialchars($counselor['id']) ?>)">
                                                🗑️ Delete
                                            </button>
                            </td>
                        </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; padding: 40px; color: #6b7280;">
                                        No counselors found
                            </td>
                        </tr>
                            <?php endif; ?>
                    </tbody>
                </table>
                </div>
            </div>

            <!-- Pending Counselors Tab - Enhanced UI -->
            <div id="pending-counselors-tab" class="tab-content" style="display: none;">
                <div class="filter-section">
                    <div class="filter-group">
                        <input type="text" placeholder="Search pending counselors..." class="search-input" id="pendingCounselorSearchInput" onkeyup="filterPendingCounselors()">
                    </div>
                </div>

                <div class="section-card">
                    <h3 style="margin-bottom: 15px;">Pending Counselors (<?= count($pendingCounselors ?? []) ?>)</h3>
                    
                    <?php if(isset($pendingCounselors) && !empty($pendingCounselors)): ?>
                        <div id="pendingCounselorCards">
                            <?php foreach($pendingCounselors as $counselor): ?>
                                <div class="pending-counselor-card">
                                    <div class="pending-counselor-header">
                                        <div class="pending-counselor-info">
                                            <h4><?= htmlspecialchars($counselor['full_name']) ?></h4>
                                            <div class="pending-counselor-contact">
                                                <div class="contact-item">
                                                    <span>📧</span>
                                                    <span><?= htmlspecialchars($counselor['email']) ?></span>
                                                </div>
                                                <div class="contact-item">
                                                    <span>📱</span>
                                                    <span><?= htmlspecialchars($counselor['phone_number']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pending-counselor-badge">
                                            Pending Approval
                                        </div>
                                    </div>
                                    
                                    <div class="pending-counselor-details">
                                        <div class="detail-item">
                                            <span class="detail-label">Username</span>
                                            <span class="detail-value"><?= htmlspecialchars($counselor['username']) ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">License Number</span>
                                            <span class="detail-value"><?= htmlspecialchars($counselor['license_number']) ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Specialization</span>
                                            <span class="detail-value"><?= htmlspecialchars($counselor['specialization'] ?? 'N/A') ?></span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Experience</span>
                                            <span class="detail-value"><?= htmlspecialchars($counselor['experience_years'] ?? 'N/A') ?> years</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Applied Date</span>
                                            <span class="detail-value"><?= date('Y-m-d', strtotime($counselor['created_at'])) ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="pending-counselor-actions">
                                        <form method="POST" action="<?= BASE_URL ?>/admin/approveCounselor" style="display: inline;">
                                            <input type="hidden" name="counselor_id" value="<?= htmlspecialchars($counselor['user_id']) ?>">
                                            <button type="submit" class="btn-approve-enhanced" onclick="return confirm('Approve this counselor?')">
                                                <span>✅</span>
                                                <span>Approve</span>
                                            </button>
                                        </form>
                                        <form method="POST" action="<?= BASE_URL ?>/admin/rejectCounselor" style="display: inline;">
                                            <input type="hidden" name="counselor_id" value="<?= htmlspecialchars($counselor['user_id']) ?>">
                                            <button type="submit" class="btn-reject-enhanced" onclick="return confirm('Reject this counselor? This will deactivate their account.')">
                                                <span>❌</span>
                                                <span>Reject</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">👨‍⚕️</div>
                            <h3>No Pending Counselors</h3>
                            <p>There are currently no counselor applications awaiting approval.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create New User</h3>
                <button class="close-btn" onclick="closeCreateModal()">&times;</button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/manage-users/create">
                <div class="form-row">
                    <label>Username *</label>
                    <input type="text" name="username" required class="form-input" placeholder="Enter username">
                </div>

                <div class="form-row">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" required class="form-input" placeholder="Enter full name">
                </div>

                <div class="form-row">
                    <label>Email *</label>
                    <input type="email" name="email" required class="form-input" placeholder="user@gmail.com">
                </div>

                <div class="form-row">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone_number" required class="form-input" placeholder="0718580160">
                </div>

                <div class="form-row">
                    <label>Role *</label>
                    <select name="role" required class="form-input">
                        <option value="">Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="counselor">Counselor</option>
                        <option value="undergrad">Undergraduate Student</option>
                        <option value="moderator">Moderator</option>
                        <option value="call_responder">Call Responder</option>
                        <option value="donor">Donor</option>
                        <option value="university_rep">University Representative</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Password *</label>
                    <input type="password" name="password" required class="form-input" placeholder="Enter password" minlength="6">
                </div>

                    <div class="form-row">
                        <label>Confirm Password *</label>
                    <input type="password" name="confirm_password" required class="form-input" placeholder="Confirm password">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit User</h3>
                <button class="close-btn" onclick="closeEditModal()">&times;</button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/manage-users/update">
                <input type="hidden" name="user_id" id="edit_user_id">
                
                <div class="form-row">
                    <label>Username *</label>
                    <input type="text" name="username" id="edit_username" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" id="edit_full_name" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Email *</label>
                    <input type="email" name="email" id="edit_email" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone_number" id="edit_phone_number" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Role *</label>
                    <select name="role" id="edit_role" required class="form-input">
                        <option value="admin">Admin</option>
                        <option value="counselor">Counselor</option>
                        <option value="undergrad">Undergraduate Student</option>
                        <option value="moderator">Moderator</option>
                        <option value="call_responder">Call Responder</option>
                        <option value="donor">Donor</option>
                        <option value="university_rep">University Representative</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>New Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-input" placeholder="Enter new password">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Undergraduate Student Modal -->
    <div id="createUndergradModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create Undergraduate Student</h3>
                <button class="close-btn" onclick="closeCreateUndergradModal()">&times;</button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/manage-users/create">
                <input type="hidden" name="role" value="undergrad">
                
                <div class="form-row">
                    <label>Username *</label>
                    <input type="text" name="username" required class="form-input" placeholder="Enter username">
                </div>

                <div class="form-row">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" required class="form-input" placeholder="Enter full name">
                </div>

                <div class="form-row">
                    <label>Email *</label>
                    <input type="email" name="email" required class="form-input" placeholder="student@gmail.com">
                </div>

                <div class="form-row">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone_number" required class="form-input" placeholder="0718580160">
                </div>

                <div class="form-row" id="university_name_field" style="display: none;">
                    <label>University Name</label>
                    <input type="text" name="university_name" class="form-input" placeholder="Enter university name">
                </div>

                <div class="form-row" id="position_field" style="display: none;">
                    <label>Position</label>
                    <input type="text" name="position" class="form-input" placeholder="Enter position/title">
                </div>

                <div class="form-row">
                    <label>Password *</label>
                    <input type="password" name="password" required class="form-input" placeholder="Enter password" minlength="6">
                </div>

                <div class="form-row">
                    <label>Confirm Password *</label>
                    <input type="password" name="confirm_password" required class="form-input" placeholder="Confirm password">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeCreateUndergradModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Counselor Modal -->
    <div id="createCounselorModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create Counselor</h3>
                <button class="close-btn" onclick="closeCreateCounselorModal()">&times;</button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/manage-users/create">
                <input type="hidden" name="role" value="counselor">
                
                <div class="form-row">
                    <label>Username *</label>
                    <input type="text" name="username" required class="form-input" placeholder="Enter username">
                </div>

                <div class="form-row">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" required class="form-input" placeholder="Enter full name">
                </div>

                <div class="form-row">
                    <label>Email *</label>
                    <input type="email" name="email" required class="form-input" placeholder="counselor@gmail.com">
                </div>

                <div class="form-row">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone_number" required class="form-input" placeholder="0718580160">
                </div>

                <div class="form-row">
                    <label>License Number *</label>
                    <input type="text" name="license_number" required class="form-input" placeholder="Enter professional license number">
                </div>

                <div class="form-row">
                    <label>Specialization *</label>
                    <select name="specialization" required class="form-input">
                        <option value="">Select specialization</option>
                        <option value="Clinical Psychology">Clinical Psychology</option>
                        <option value="Counseling Psychology">Counseling Psychology</option>
                        <option value="Marriage and Family Therapy">Marriage and Family Therapy</option>
                        <option value="Substance Abuse Counseling">Substance Abuse Counseling</option>
                        <option value="Trauma Therapy">Trauma Therapy</option>
                        <option value="Child and Adolescent Therapy">Child and Adolescent Therapy</option>
                        <option value="Cognitive Behavioral Therapy">Cognitive Behavioral Therapy</option>
                        <option value="Group Therapy">Group Therapy</option>
                        <option value="Crisis Intervention">Crisis Intervention</option>
                        <option value="Psychiatric Social Work">Psychiatric Social Work</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Years of Experience</label>
                    <input type="number" name="years_experience" class="form-input" placeholder="Number of years" min="0" max="50">
                </div>

                <div class="form-row">
                    <label>Professional Bio</label>
                    <textarea name="bio" rows="4" class="form-input" placeholder="Tell us about your professional background..."></textarea>
                </div>

                <div class="form-row">
                    <label>Password *</label>
                    <input type="password" name="password" required class="form-input" placeholder="Enter password" minlength="6">
                </div>

                <div class="form-row">
                    <label>Confirm Password *</label>
                    <input type="password" name="confirm_password" required class="form-input" placeholder="Confirm password">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeCreateCounselorModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Counselor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Undergraduate Student Modal -->
    <div id="editUndergradModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Undergraduate Student</h3>
                <button class="close-btn" onclick="closeEditUndergradModal()">&times;</button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/manage-users/update">
                <input type="hidden" name="user_id" id="edit_undergrad_user_id">
                <input type="hidden" name="role" value="undergrad">
                
                <div class="form-row">
                    <label>Username *</label>
                    <input type="text" name="username" id="edit_undergrad_username" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" id="edit_undergrad_full_name" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Email *</label>
                    <input type="email" name="email" id="edit_undergrad_email" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone_number" id="edit_undergrad_phone_number" required class="form-input">
                </div>


                <div class="form-row">
                    <label>New Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-input" placeholder="Enter new password">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeEditUndergradModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Counselor Modal -->
    <div id="editCounselorModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Counselor</h3>
                <button class="close-btn" onclick="closeEditCounselorModal()">&times;</button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/manage-users/update">
                <input type="hidden" name="user_id" id="edit_counselor_user_id">
                <input type="hidden" name="role" value="counselor">
                
                <div class="form-row">
                    <label>Username *</label>
                    <input type="text" name="username" id="edit_counselor_username" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" id="edit_counselor_full_name" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Email *</label>
                    <input type="email" name="email" id="edit_counselor_email" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone_number" id="edit_counselor_phone_number" required class="form-input">
                </div>

                <div class="form-row">
                    <label>License Number *</label>
                    <input type="text" name="license_number" id="edit_counselor_license_number" required class="form-input">
                </div>

                <div class="form-row">
                    <label>Specialization *</label>
                    <select name="specialization" id="edit_counselor_specialization" required class="form-input">
                        <option value="">Select specialization</option>
                        <option value="Clinical Psychology">Clinical Psychology</option>
                        <option value="Counseling Psychology">Counseling Psychology</option>
                        <option value="Marriage and Family Therapy">Marriage and Family Therapy</option>
                        <option value="Substance Abuse Counseling">Substance Abuse Counseling</option>
                        <option value="Trauma Therapy">Trauma Therapy</option>
                        <option value="Child and Adolescent Therapy">Child and Adolescent Therapy</option>
                        <option value="Cognitive Behavioral Therapy">Cognitive Behavioral Therapy</option>
                        <option value="Group Therapy">Group Therapy</option>
                        <option value="Crisis Intervention">Crisis Intervention</option>
                        <option value="Psychiatric Social Work">Psychiatric Social Work</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Years of Experience</label>
                    <input type="number" name="years_experience" id="edit_counselor_years_experience" class="form-input" min="0" max="50">
                </div>

                <div class="form-row">
                    <label>Professional Bio</label>
                    <textarea name="bio" id="edit_counselor_bio" rows="4" class="form-input"></textarea>
                </div>

                <div class="form-row">
                    <label>New Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-input" placeholder="Enter new password">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeEditCounselorModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Counselor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirm Delete</h3>
                <button class="close-btn" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div style="padding: 20px 0;">
                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/manage-users/delete" id="deleteForm">
                <input type="hidden" name="user_id" id="delete_user_id">
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab functions
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').style.display = 'block';
            
            // Add active class to clicked tab button
            event.target.classList.add('active');
        }

        // Modal functions
        function openCreateModal() {
            document.getElementById('createModal').classList.add('active');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.remove('active');
        }

        function openCreateUndergradModal() {
            document.getElementById('createUndergradModal').classList.add('active');
        }

        function closeCreateUndergradModal() {
            document.getElementById('createUndergradModal').classList.remove('active');
        }

        function openCreateCounselorModal() {
            document.getElementById('createCounselorModal').classList.add('active');
        }

        function closeCreateCounselorModal() {
            document.getElementById('createCounselorModal').classList.remove('active');
        }

        function openEditModal(user) {
            document.getElementById('edit_user_id').value = user.id;
            document.getElementById('edit_username').value = user.username;
            document.getElementById('edit_full_name').value = user.display_name || user.full_name;
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_phone_number').value = user.phone_number || '';
            document.getElementById('edit_role').value = user.role;
            document.getElementById('editModal').classList.add('active');
        }

        function openEditUndergradModal(student) {
            document.getElementById('edit_undergrad_user_id').value = student.id;
            document.getElementById('edit_undergrad_username').value = student.username;
            document.getElementById('edit_undergrad_full_name').value = student.full_name;
            document.getElementById('edit_undergrad_email').value = student.email;
            document.getElementById('edit_undergrad_phone_number').value = student.phone_number;
            document.getElementById('editUndergradModal').classList.add('active');
        }

        function openEditCounselorModal(counselor) {
            document.getElementById('edit_counselor_user_id').value = counselor.id;
            document.getElementById('edit_counselor_username').value = counselor.username;
            document.getElementById('edit_counselor_full_name').value = counselor.full_name;
            document.getElementById('edit_counselor_email').value = counselor.email;
            document.getElementById('edit_counselor_phone_number').value = counselor.phone_number;
            document.getElementById('edit_counselor_license_number').value = counselor.license_number || '';
            document.getElementById('edit_counselor_specialization').value = counselor.specialization || '';
            document.getElementById('edit_counselor_years_experience').value = counselor.experience_years || '';
            document.getElementById('edit_counselor_bio').value = counselor.bio || '';
            document.getElementById('editCounselorModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        function closeEditUndergradModal() {
            document.getElementById('editUndergradModal').classList.remove('active');
        }

        function closeEditCounselorModal() {
            document.getElementById('editCounselorModal').classList.remove('active');
        }

        function deleteUser(userId) {
            document.getElementById('delete_user_id').value = userId;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Filter functions
        function filterUsers() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const roleFilter = document.getElementById('roleFilter').value;
            const rows = document.querySelectorAll('#usersTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const roleCell = row.querySelector('.badge');
                const role = roleCell ? roleCell.textContent.toLowerCase() : '';

                let show = true;

                if (searchTerm && !text.includes(searchTerm)) {
                    show = false;
                }
                if (roleFilter && !role.includes(roleFilter)) {
                    show = false;
                }

                row.style.display = show ? '' : 'none';
            });
        }

        function filterUndergrads() {
            const searchTerm = document.getElementById('undergradSearchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#undergradTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const show = !searchTerm || text.includes(searchTerm);
                row.style.display = show ? '' : 'none';
            });
        }

        function filterCounselors() {
            const searchTerm = document.getElementById('counselorSearchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#counselorTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const show = !searchTerm || text.includes(searchTerm);
                row.style.display = show ? '' : 'none';
            });
        }

        function filterPendingCounselors() {
            const searchTerm = document.getElementById('pendingCounselorSearchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.pending-counselor-card');

            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const show = !searchTerm || text.includes(searchTerm);
                card.style.display = show ? '' : 'none';
            });
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.remove('active');
                }
            });
        }

        // Password confirmation validation for all create forms
        document.querySelectorAll('form[action*="create"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const password = form.querySelector('input[name="password"]').value;
                const confirmPassword = form.querySelector('input[name="confirm_password"]').value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                }
            });
        });

        // Show/hide University Representative fields based on role selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.querySelector('select[name="role"]');
            const universityNameField = document.getElementById('university_name_field');
            const positionField = document.getElementById('position_field');
            
            if (roleSelect) {
                roleSelect.addEventListener('change', function() {
                    if (this.value === 'university_rep') {
                        universityNameField.style.display = 'block';
                        positionField.style.display = 'block';
                    } else {
                        universityNameField.style.display = 'none';
                        positionField.style.display = 'none';
                    }
                });
            }
            
            // Ensure "All Users" tab is shown by default
            showTab('all-users');
        });
    </script>
</body>
</html>