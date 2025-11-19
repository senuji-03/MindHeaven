<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - University Representative | MindHeaven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 MindHeaven</h2>
            <p>University Representative</p>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/university-rep/dashboard" class="nav-item">
                <span class="icon">📊</span> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item">
                <span class="icon">📅</span> Manage Events
            </a>
           
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <span class="icon">🏫</span> University Profile
            </a>
            <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item active">
                <span class="icon">👤</span> My Profile
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">➡️</span> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="page-header">
            <div class="header-content">
                <h1>👤 My Profile</h1>
                <p>Manage your personal information and account settings</p>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="profile-content">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="<?= BASE_URL ?>/images/profile-pic.png" alt="Profile Picture" id="profileImage">
                        <button class="avatar-edit" onclick="changeProfilePicture()">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <div class="profile-info">
                        <h2>Dr. Sarah Johnson</h2>
                        <p class="profile-title">University Representative</p>
                        <p class="profile-university">University of California, Berkeley</p>
                        <div class="profile-status">
                            <span class="status-badge active">Active</span>
                            <span class="member-since">Member since: January 2024</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Sections -->
            <div class="profile-sections">
                <!-- Personal Information -->
                <div class="profile-section">
                    <div class="section-header">
                        <h3><i class="fas fa-user"></i> Personal Information</h3>
                        <button class="btn btn-outline" onclick="editPersonalInfo()">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>
                    <div class="section-content">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Full Name</label>
                                <p>Dr. Sarah Johnson</p>
                            </div>
                            <div class="info-item">
                                <label>Email</label>
                                <p>sarah.johnson@berkeley.edu</p>
                            </div>
                            <div class="info-item">
                                <label>Phone</label>
                                <p>+1 (555) 123-4567</p>
                            </div>
                            <div class="info-item">
                                <label>Department</label>
                                <p>Student Affairs</p>
                            </div>
                            <div class="info-item">
                                <label>Position</label>
                                <p>Director of Student Wellness</p>
                            </div>
                            <div class="info-item">
                                <label>Office Location</label>
                                <p>Student Union Building, Room 205</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- University Information -->
                <div class="profile-section">
                    <div class="section-header">
                        <h3><i class="fas fa-university"></i> University Information</h3>
                        <button class="btn btn-outline" onclick="editUniversityInfo()">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>
                    <div class="section-content">
                        <div class="info-grid">
                            <div class="info-item">
                                <label>University</label>
                                <p>University of California, Berkeley</p>
                            </div>
                            <div class="info-item">
                                <label>University ID</label>
                                <p>UCB-REP-2024-001</p>
                            </div>
                            <div class="info-item">
                                <label>Representative Since</label>
                                <p>January 15, 2024</p>
                            </div>
                            <div class="info-item">
                                <label>Student Population</label>
                                <p>45,000+ students</p>
                            </div>
                            <div class="info-item">
                                <label>University Type</label>
                                <p>Public Research University</p>
                            </div>
                            <div class="info-item">
                                <label>Location</label>
                                <p>Berkeley, California, USA</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div class="profile-section">
                    <div class="section-header">
                        <h3><i class="fas fa-cog"></i> Account Settings</h3>
                    </div>
                    <div class="section-content">
                        <div class="settings-grid">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Change Password</h4>
                                    <p>Update your account password</p>
                                </div>
                                <button class="btn btn-outline" onclick="changePassword()">
                                    <i class="fas fa-key"></i> Change
                                </button>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Notification Preferences</h4>
                                    <p>Manage email and system notifications</p>
                                </div>
                                <button class="btn btn-outline" onclick="manageNotifications()">
                                    <i class="fas fa-bell"></i> Manage
                                </button>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Privacy Settings</h4>
                                    <p>Control your privacy and data sharing</p>
                                </div>
                                <button class="btn btn-outline" onclick="managePrivacy()">
                                    <i class="fas fa-shield-alt"></i> Manage
                                </button>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>Two-Factor Authentication</h4>
                                    <p>Add extra security to your account</p>
                                </div>
                                <button class="btn btn-outline" onclick="setup2FA()">
                                    <i class="fas fa-mobile-alt"></i> Setup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Summary -->
                <div class="profile-section">
                    <div class="section-header">
                        <h3><i class="fas fa-chart-line"></i> Activity Summary</h3>
                    </div>
                    <div class="section-content">
                        <div class="activity-stats">
                            <div class="stat-item">
                                <div class="stat-icon blue">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="stat-info">
                                    <h4>Events Created</h4>
                                    <p class="stat-number">12</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon green">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="stat-info">
                                    <h4>Announcements</h4>
                                    <p class="stat-number">24</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon orange">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="stat-info">
                                    <h4>Resources Uploaded</h4>
                                    <p class="stat-number">18</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon purple">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-info">
                                    <h4>Students Reached</h4>
                                    <p class="stat-number">2,450</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Personal Info Modal -->
    <div id="personalInfoModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Personal Information</h3>
                <button class="modal-close" onclick="closePersonalInfoModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="personalInfoForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-input" id="fullName" value="Dr. Sarah Johnson">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-input" id="email" value="sarah.johnson@berkeley.edu">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" class="form-input" id="phone" value="+1 (555) 123-4567">
                        </div>
                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" class="form-input" id="department" value="Student Affairs">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" class="form-input" id="position" value="Director of Student Wellness">
                        </div>
                        <div class="form-group">
                            <label>Office Location</label>
                            <input type="text" class="form-input" id="officeLocation" value="Student Union Building, Room 205">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closePersonalInfoModal()">Cancel</button>
                <button class="btn btn-primary" onclick="savePersonalInfo()">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Change Password</h3>
                <button class="modal-close" onclick="closePasswordModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="passwordForm">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" class="form-input" id="currentPassword" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-input" id="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" class="form-input" id="confirmPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closePasswordModal()">Cancel</button>
                <button class="btn btn-primary" onclick="savePassword()">Update Password</button>
            </div>
        </div>
    </div>

    <script>
        // Profile functions
        function changeProfilePicture() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('profileImage').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            };
            input.click();
        }

        function editPersonalInfo() {
            document.getElementById('personalInfoModal').style.display = 'flex';
        }

        function closePersonalInfoModal() {
            document.getElementById('personalInfoModal').style.display = 'none';
        }

        function savePersonalInfo() {
            alert('Personal information updated successfully!');
            closePersonalInfoModal();
        }

        function editUniversityInfo() {
            alert('University information editing feature coming soon!');
        }

        function changePassword() {
            document.getElementById('passwordModal').style.display = 'flex';
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').style.display = 'none';
            document.getElementById('passwordForm').reset();
        }

        function savePassword() {
            const current = document.getElementById('currentPassword').value;
            const newPass = document.getElementById('newPassword').value;
            const confirm = document.getElementById('confirmPassword').value;
            
            if (!current || !newPass || !confirm) {
                alert('Please fill in all fields');
                return;
            }
            
            if (newPass !== confirm) {
                alert('New passwords do not match');
                return;
            }
            
            alert('Password updated successfully!');
            closePasswordModal();
        }

        function manageNotifications() {
            alert('Notification preferences feature coming soon!');
        }

        function managePrivacy() {
            alert('Privacy settings feature coming soon!');
        }

        function setup2FA() {
            alert('Two-factor authentication setup coming soon!');
        }
    </script>

    <style>
        /* Profile-specific styles */
        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .profile-avatar {
            position: relative;
            width: 120px;
            height: 120px;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #e2e8f0;
        }

        .avatar-edit {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #3b82f6;
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        }

        .profile-info h2 {
            font-size: 1.8rem;
            color: #1e293b;
            margin: 0 0 8px 0;
            font-weight: 600;
        }

        .profile-title {
            color: #64748b;
            font-size: 1rem;
            margin: 0 0 4px 0;
        }

        .profile-university {
            color: #3b82f6;
            font-size: 0.9rem;
            margin: 0 0 12px 0;
            font-weight: 500;
        }

        .profile-status {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .member-since {
            color: #64748b;
            font-size: 0.8rem;
        }

        .profile-sections {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .profile-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-header h3 {
            font-size: 1.2rem;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-item label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item p {
            font-size: 1rem;
            color: #1e293b;
            margin: 0;
            font-weight: 500;
        }

        .settings-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .setting-info h4 {
            font-size: 1rem;
            color: #1e293b;
            margin: 0 0 4px 0;
            font-weight: 600;
        }

        .setting-info p {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0;
        }

        .activity-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .stat-icon.blue { background: #dbeafe; color: #1d4ed8; }
        .stat-icon.green { background: #dcfce7; color: #16a34a; }
        .stat-icon.orange { background: #fed7aa; color: #ea580c; }
        .stat-icon.purple { background: #e9d5ff; color: #7c3aed; }

        .stat-info h4 {
            font-size: 0.9rem;
            color: #64748b;
            margin: 0 0 4px 0;
            font-weight: 500;
        }

        .stat-number {
            font-size: 1.5rem;
            color: #1e293b;
            margin: 0;
            font-weight: 700;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .activity-stats {
                grid-template-columns: 1fr;
            }

            .setting-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</body>
</html>
