<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin | Mind Haven</title>
    <!-- Fonts & Icons (Design System §2, §15) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        :root {
            --primary:#3D8B6E; --primary-light:#6BB89A; --primary-dark:#2A6B52;
            --bg-deep:#1C2B2A; --surface:#FFFFFF; --border:#D6E4DD;
            --radius-sm:8px;
        }
        body { font-family:'DM Sans','Inter',system-ui,sans-serif; }
        /* existing page styles below */
    </style>

    <style>
        .badge-active {
            background-color: #e6f4ea;
            color: #1e8e3e;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 0.85em;

            font-weight: 500;
        }

        .badge-inactive {
            background-color: #f3f4f6;
            color: #4b5563;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 0.85em;
            font-weight: 500;
        }

        .badge-suspended {
            background-color: #fce8e8;
            color: #d93025;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 0.85em;
            font-weight: 500;
        }

        .btn-action {
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
            cursor: pointer;
            font-size: 0.8em;
            margin-right: 4px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 4px;
        }

        .btn-activate {
            background-color: #e6f4ea;
            color: #1e8e3e;
        }

        .btn-deactivate {
            background-color: #e5e7eb;
            color: #374151;
        }

        .btn-suspend {
            background-color: #fef08a;
            color: #854d0e;
        }

        .btn-reset {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .action-forms {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .action-forms form {
            margin: 0;
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
        
        /* Tab Navigation Styles */
        .tab-navigation {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 12px;
        }

        .tab-btn {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            color: #4b5563;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .tab-btn:hover {
            color: #1f2937;
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        .tab-btn.active {
            color: #4f46e5;
            background-color: #e0e7ff;
            border-color: #c7d2fe;
            font-weight: 600;
            box-shadow: inset 0 0 0 1px #c7d2fe;
        }
    </style>
</head>

<body>
    <!-- Sidebar (Design System §1,§15) -->
    <?php 
    $activePage = 'manage-users';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <!-- Top Bar -->
        <?php 
        $topbarTitle = 'Manage Users';
        include '_topbar.php'; 
        ?>

       

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Success/Error Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_GET['success']) ?>
                    <?php if (isset($_SESSION['temp_username']) && isset($_SESSION['temp_password'])): ?>
                        <br><br>
                        <strong>Username:</strong> <?= htmlspecialchars($_SESSION['temp_username']) ?><br>
                        <strong>Temporary Password:</strong> <?= htmlspecialchars($_SESSION['temp_password']) ?><br>
                        <em>Please copy these credentials and send them to the representative. This password is shown only
                            once.</em>
                        <?php
                        unset($_SESSION['temp_username']);
                        unset($_SESSION['temp_password']);
                        ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Header with Actions -->
            <div class="page-header">
                <h2>User Management</h2>
                <div style="display: flex; gap: 10px;">
                    <a href="<?= BASE_URL ?>/admin/suspended-users" class="btn btn-secondary">
                        <span class="icon">🛑</span> Suspended Users
                    </a>
                    <button class="btn btn-primary" onclick="openCreateModal()">
                        ➕ Create New User
                    </button>
                    <button class="btn btn-primary" onclick="openCreateUndergradModal()">
                        🎓 Create Undergraduate
                    </button>
                    <button class="btn btn-primary" onclick="openCreateCounselorModal()">
                        👨‍⚕️ Create Counselor
                    </button>
                    <button class="btn btn-primary" onclick="openCreateUniRepModal()">
                        🏛️ Create Uni Rep
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
            <div id="all-users-tab" class="tab-content">
                <!-- Filter Section -->
                <div class="filter-section">
                    <div class="filter-group">
                        <input type="text" placeholder="Search by name, email, or username..." class="search-input"
                            id="searchInput" onkeyup="filterUsers()">

                        <select class="form-input" id="roleFilter" onchange="filterUsers()">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="counselor">Counselor</option>
                            <option value="undergrad">Undergraduate</option>
                            <option value="moderator">Moderator</option>
                            <option value="call_responder">Call Responder</option>
                            <option value="donor">Donor</option>
                            <option value="university_representative">University Representative</option>
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
                                <th>Role</th>
                                <th>Status</th>
                                <th>Strikes</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <?php if (isset($users) && !empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['display_name'] ?? $user['full_name']) ?></td>
                                        <td><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
                                        <td>
                                            <span class="badge role-<?= htmlspecialchars($user['role']) ?>">
                                                <?= ucfirst(htmlspecialchars($user['role'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClass = 'badge-active';
                                            if ($user['status'] === 'inactive')
                                                $statusClass = 'badge-inactive';
                                            if ($user['status'] === 'suspended')
                                                $statusClass = 'badge-suspended';
                                            ?>
                                            <span class="<?= $statusClass ?>">
                                                <?= ucfirst(htmlspecialchars($user['status'] ?? 'active')) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($user['strike_count'] ?? '0') ?>
                                        </td>
                                        <td><?= $user['created_at'] ? date('Y-m-d', strtotime($user['created_at'])) : 'N/A' ?>
                                        </td>
                                        <td>
                                            <div class="action-forms">
                                                <button class="btn-icon btn-edit" title="Edit"
                                                    onclick='openEditModal(<?= htmlspecialchars(json_encode($user)) ?>)'>✏️</button>

                                                <?php if (($user['status'] ?? 'active') !== 'active'): ?>
                                                    <form action="<?= BASE_URL ?>/admin/manage-users/activate" method="POST"
                                                        style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                        <button type="submit" class="btn-action btn-activate"
                                                            title="Activate">Activate</button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if (($user['status'] ?? 'active') !== 'inactive'): ?>
                                                    <form action="<?= BASE_URL ?>/admin/manage-users/deactivate" method="POST"
                                                        style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                        <button type="submit" class="btn-action btn-deactivate"
                                                            title="Deactivate">Deactivate</button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if (($user['status'] ?? 'active') !== 'suspended'): ?>
                                                    <button class="btn-action btn-suspend" title="Suspend"
                                                        onclick="openSuspendModal(<?= $user['id'] ?>)">Suspend</button>
                                                <?php endif; ?>

                                                <form action="<?= BASE_URL ?>/admin/manage-users/reset-strikes" method="POST"
                                                    style="display:inline;">
                                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                    <button type="submit" class="btn-action btn-reset"
                                                        title="Reset Strikes">Reset Strikes</button>
                                                </form>
                                                <button class="btn-icon btn-delete" title="Delete"
                                                    onclick="deleteUser(<?= htmlspecialchars($user['id']) ?>)">🗑️</button>
                                            </div>
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
                        <input type="text" placeholder="Search undergraduate students..." class="search-input"
                            id="undergradSearchInput" onkeyup="filterUndergrads()">
                    </div>
                </div>

                <div class="section-card">
                    <h3 style="margin-bottom: 15px;">Undergraduate Students (<?= count($undergraduateStudents ?? []) ?>)
                    </h3>
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Strikes</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="undergradTableBody">
                            <?php if (isset($undergraduateStudents) && !empty($undergraduateStudents)): ?>
                                <?php foreach ($undergraduateStudents as $student): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($student['id']) ?></td>
                                        <td><?= htmlspecialchars($student['username']) ?></td>
                                        <td><?= htmlspecialchars($student['full_name']) ?></td>
                                        <td><?= htmlspecialchars($student['email']) ?></td>
                                        <td>
                                            <?php
                                            $statusClass = 'badge-active';
                                            if ($student['status'] === 'inactive')
                                                $statusClass = 'badge-inactive';
                                            if ($student['status'] === 'suspended')
                                                $statusClass = 'badge-suspended';
                                            ?>
                                            <span class="<?= $statusClass ?>">
                                                <?= ucfirst(htmlspecialchars($student['status'] ?? 'active')) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($student['strike_count'] ?? '0') ?>
                                        </td>
                                        <td><?= date('Y-m-d', strtotime($student['created_at'])) ?></td>
                                        <td>
                                            <div class="action-forms">
                                                <button class="btn-icon btn-edit" title="Edit"
                                                    onclick='openEditUndergradModal(<?= htmlspecialchars(json_encode($student)) ?>)'>✏️</button>

                                                <?php if (($student['status'] ?? 'active') !== 'active'): ?>
                                                    <form action="<?= BASE_URL ?>/admin/manage-users/activate" method="POST"
                                                        style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?= $student['id'] ?>">
                                                        <button type="submit" class="btn-action btn-activate"
                                                            title="Activate">Activate</button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if (($student['status'] ?? 'active') !== 'inactive'): ?>
                                                    <form action="<?= BASE_URL ?>/admin/manage-users/deactivate" method="POST"
                                                        style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?= $student['id'] ?>">
                                                        <button type="submit" class="btn-action btn-deactivate"
                                                            title="Deactivate">Deactivate</button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if (($student['status'] ?? 'active') !== 'suspended'): ?>
                                                    <button class="btn-action btn-suspend" title="Suspend"
                                                        onclick="openSuspendModal(<?= $student['id'] ?>)">Suspend</button>
                                                <?php endif; ?>

                                                <form action="<?= BASE_URL ?>/admin/manage-users/reset-strikes" method="POST"
                                                    style="display:inline;">
                                                    <input type="hidden" name="user_id" value="<?= $student['id'] ?>">
                                                    <button type="submit" class="btn-action btn-reset"
                                                        title="Reset Strikes">Reset Strikes</button>
                                                </form>
                                                <button class="btn-icon btn-delete" title="Delete"
                                                    onclick="deleteUser(<?= htmlspecialchars($student['id']) ?>)">🗑️</button>
                                            </div>
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
                        <input type="text" placeholder="Search counselors..." class="search-input"
                            id="counselorSearchInput" onkeyup="filterCounselors()">
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
                                <th>Specialization</th>
                                <th>Status</th>
                                <th>Strikes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="counselorTableBody">
                            <?php if (isset($counselors) && !empty($counselors)): ?>
                                <?php foreach ($counselors as $counselor): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($counselor['id']) ?></td>
                                        <td><?= htmlspecialchars($counselor['username']) ?></td>
                                        <td><?= htmlspecialchars($counselor['full_name']) ?></td>
                                        <td><?= htmlspecialchars($counselor['email']) ?></td>
                                        <td><?= htmlspecialchars($counselor['specialization'] ?? 'N/A') ?></td>
                                        <td>
                                            <?php
                                            $statusClass = 'badge-active';
                                            if ($counselor['status'] === 'inactive')
                                                $statusClass = 'badge-inactive';
                                            if ($counselor['status'] === 'suspended')
                                                $statusClass = 'badge-suspended';
                                            ?>
                                            <span class="<?= $statusClass ?>">
                                                <?= ucfirst(htmlspecialchars($counselor['status'] ?? 'active')) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($counselor['strike_count'] ?? '0') ?>
                                        </td>
                                        <td>
                                            <div class="action-forms">
                                                <button class="btn-icon btn-edit" title="Edit"
                                                    onclick='openEditCounselorModal(<?= htmlspecialchars(json_encode($counselor)) ?>)'>✏️</button>

                                                <?php if (($counselor['status'] ?? 'active') !== 'active'): ?>
                                                    <form action="<?= BASE_URL ?>/admin/manage-users/activate" method="POST"
                                                        style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?= $counselor['id'] ?>">
                                                        <button type="submit" class="btn-action btn-activate"
                                                            title="Activate">Activate</button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if (($counselor['status'] ?? 'active') !== 'inactive'): ?>
                                                    <form action="<?= BASE_URL ?>/admin/manage-users/deactivate" method="POST"
                                                        style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?= $counselor['id'] ?>">
                                                        <button type="submit" class="btn-action btn-deactivate"
                                                            title="Deactivate">Deactivate</button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if (($counselor['status'] ?? 'active') !== 'suspended'): ?>
                                                    <button class="btn-action btn-suspend" title="Suspend"
                                                        onclick="openSuspendModal(<?= $counselor['id'] ?>)">Suspend</button>
                                                <?php endif; ?>

                                                <form action="<?= BASE_URL ?>/admin/manage-users/reset-strikes" method="POST"
                                                    style="display:inline;">
                                                    <input type="hidden" name="user_id" value="<?= $counselor['id'] ?>">
                                                    <button type="submit" class="btn-action btn-reset"
                                                        title="Reset Strikes">Reset Strikes</button>
                                                </form>
                                                <button class="btn-icon btn-delete" title="Delete"
                                                    onclick="deleteUser(<?= htmlspecialchars($counselor['id']) ?>)">🗑️</button>
                                            </div>
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
                                            <span class="detail-value"><?= htmlspecialchars($counselor['years_experience'] ?? 'N/A') ?> years</span>
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
                        <option value="university_representative">University Representative</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Password *</label>
                    <input type="password" name="password" required class="form-input" placeholder="Enter password"
                        minlength="6">
                </div>

                <div class="form-row">
                    <label>Confirm Password *</label>
                    <input type="password" name="confirm_password" required class="form-input"
                        placeholder="Confirm password">
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
                        <option value="university_representative">University Representative</option>
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
                    <input type="password" name="password" required class="form-input" placeholder="Enter password"
                        minlength="6">
                </div>

                <div class="form-row">
                    <label>Confirm Password *</label>
                    <input type="password" name="confirm_password" required class="form-input"
                        placeholder="Confirm password">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary"
                        onclick="closeCreateUndergradModal()">Cancel</button>
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
                    <input type="text" name="license_number" required class="form-input"
                        placeholder="Enter professional license number">
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
                    <input type="number" name="years_experience" class="form-input" placeholder="Number of years"
                        min="0" max="50">
                </div>

                <div class="form-row">
                    <label>Professional Bio</label>
                    <textarea name="bio" rows="4" class="form-input"
                        placeholder="Tell us about your professional background..."></textarea>
                </div>

                <div class="form-row">
                    <label>Password *</label>
                    <input type="password" name="password" required class="form-input" placeholder="Enter password"
                        minlength="6">
                </div>

                <div class="form-row">
                    <label>Confirm Password *</label>
                    <input type="password" name="confirm_password" required class="form-input"
                        placeholder="Confirm password">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary"
                        onclick="closeCreateCounselorModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Counselor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create University Representative Modal -->
    <div id="createUniRepModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Create University Representative</h3>
                <button class="close-btn" onclick="closeCreateUniRepModal()">&times;</button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/manage-users/create">
                <input type="hidden" name="role" value="university_representative">

                <div class="form-row">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" required class="form-input" placeholder="Enter full name">
                </div>

                <div class="form-row">
                    <label>Official University Email *</label>
                    <input type="email" name="email" required class="form-input" placeholder="rep@university.edu"
                        title="An autogenerated password will be sent/available for setup.">
                </div>

                <div class="form-row">
                    <label>University Name *</label>
                    <input type="text" name="university_name" required class="form-input"
                        placeholder="Enter university name">
                </div>

                <div class="form-row">
                    <label>Phone Number *</label>
                    <input type="tel" name="phone_number" required class="form-input" placeholder="0718580160">
                </div>

                <div class="form-row">
                    <label>Position</label>
                    <input type="text" name="position" class="form-input" placeholder="e.g., Student Affairs Director">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeCreateUniRepModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Representative</button>
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
                    <input type="text" name="license_number" id="edit_counselor_license_number" required
                        class="form-input">
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
                    <input type="number" name="years_experience" id="edit_counselor_years_experience" class="form-input"
                        min="0" max="50">
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

    <!-- Suspend User Modal -->
    <div id="suspendModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Suspend User</h3>
                <button class="close-btn" onclick="closeSuspendModal()">&times;</button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/admin/manage-users/suspend" id="suspendForm">
                <input type="hidden" name="user_id" id="suspend_user_id">
                <div class="form-row">
                    <label>Duration</label>
                    <select name="suspension_days" class="form-input">
                        <option value="">Indefinite</option>
                        <option value="1">1 Day</option>
                        <option value="3">3 Days</option>
                        <option value="7">1 Week</option>
                        <option value="14">2 Weeks</option>
                        <option value="30">1 Month</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeSuspendModal()">Cancel</button>
                    <button type="submit" class="btn btn-suspend">Suspend User</button>
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

        function openCreateUniRepModal() {
            document.getElementById('createUniRepModal').classList.add('active');
        }

        function closeCreateUniRepModal() {
            document.getElementById('createUniRepModal').classList.remove('active');
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
            document.getElementById('edit_counselor_years_experience').value = counselor.years_experience || '';
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

        function openSuspendModal(userId) {
            document.getElementById('suspend_user_id').value = userId;
            document.getElementById('suspendModal').classList.add('active');
        }

        function closeSuspendModal() {
            document.getElementById('suspendModal').classList.remove('active');
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
        window.onclick = function (event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.remove('active');
                }
            });
        }

        // Password confirmation validation for all create forms
        document.querySelectorAll('form[action*="create"]').forEach(form => {
            form.addEventListener('submit', function (e) {
                const password = form.querySelector('input[name="password"]').value;
                const confirmPassword = form.querySelector('input[name="confirm_password"]').value;

                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                }
            });
        });

        // Show/hide University Representative fields based on role selection
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.querySelector('select[name="role"]');
            const universityNameField = document.getElementById('university_name_field');
            const positionField = document.getElementById('position_field');

            if (roleSelect) {
                roleSelect.addEventListener('change', function () {
                    if (this.value === 'university_representative') {
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

