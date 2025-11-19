<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Warning - Moderator</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <link rel="stylesheet" href="/MindHeaven/public/css/moderator/Moderator.css">
    <style>
        .warn-form-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .warning-form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .form-header {
            background: #fef3c7;
            padding: 1.5rem;
            border-bottom: 1px solid #f59e0b;
        }
        
        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #92400e;
            margin: 0 0 0.5rem 0;
        }
        
        .form-subtitle {
            color: #a16207;
            font-size: 1rem;
            margin: 0;
        }
        
        .form-content {
            padding: 2rem;
        }
        
        .user-info-card {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .user-info-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .user-details h3 {
            margin: 0 0 0.25rem 0;
            color: #1e293b;
            font-size: 1.25rem;
        }
        
        .user-details p {
            margin: 0;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .user-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 0.75rem;
            background: white;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #3b82f6;
            display: block;
        }
        
        .stat-label {
            font-size: 0.75rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .warning-templates {
            margin-bottom: 1.5rem;
        }
        
        .templates-header {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }
        
        .template-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .template-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        
        .template-btn:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }
        
        .template-btn.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-warn {
            background: #f59e0b;
            color: white;
        }
        
        .btn-warn:hover {
            background: #d97706;
        }
        
        .btn-outline {
            background: white;
            color: #6b7280;
            border: 1px solid #d1d5db;
        }
        
        .btn-outline:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }
        
        .warning-preview {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 1rem;
            margin-top: 1rem;
            display: none;
        }
        
        .warning-preview h4 {
            margin: 0 0 0.5rem 0;
            color: #92400e;
            font-size: 0.9rem;
        }
        
        .warning-preview p {
            margin: 0;
            color: #a16207;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        
        .success-message {
            background: #d1fae5;
            border: 1px solid #10b981;
            color: #065f46;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            display: none;
        }
        
        .error-message {
            background: #fee2e2;
            border: 1px solid #ef4444;
            color: #991b1b;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            display: none;
        }
        
        .users-dashboard {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .users-list-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .users-list-header {
            background: #f8fafc;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .users-list-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 0.5rem 0;
        }
        
        .users-list-subtitle {
            color: #6b7280;
            font-size: 1rem;
            margin: 0;
        }
        
        .users-list {
            padding: 1rem;
        }
        
        .user-card {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .user-card:hover {
            background: #f1f5f9;
            border-color: #3b82f6;
            transform: translateY(-1px);
        }
        
        .user-card.selected {
            background: #dbeafe;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        
        .user-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
        }
        
        .user-card-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .user-card-info h4 {
            margin: 0 0 0.25rem 0;
            color: #1e293b;
            font-size: 1.1rem;
        }
        
        .user-card-info p {
            margin: 0;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .user-card-stats {
            display: flex;
            gap: 1rem;
            margin-top: 0.75rem;
        }
        
        .user-stat {
            text-align: center;
            padding: 0.5rem;
            background: white;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            flex: 1;
        }
        
        .user-stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #3b82f6;
            display: block;
        }
        
        .user-stat-label {
            font-size: 0.75rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .warning-form-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .no-user-selected {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }
        
        .no-user-selected-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .no-user-selected h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #374151;
        }
        
        .no-user-selected p {
            font-size: 1rem;
        }
        
        @media (max-width: 768px) {
            .warn-form-container {
                padding: 1rem;
            }
            
            .users-dashboard {
                grid-template-columns: 1fr;
            }
            
            .user-stats {
                grid-template-columns: 1fr;
            }
            
            .template-buttons {
                flex-direction: column;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Heaven</h2>
            <p>Moderator Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/ModeratorDashboard" class="nav-item">
                <!-- <span class="icon">📊</span> -->
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/EditPosts" class="nav-item">
                <!-- <span class="icon">✏</span> -->
                Edit Resources
            </a>
            <a href="<?= BASE_URL ?>/FlaggedUsers" class="nav-item">
                <!-- <span class="icon">🚩</span> -->
                Flagged Users
            </a>
            <a href="<?= BASE_URL ?>/WarnForm" class="nav-item active">
                <!-- <span class="icon">⚠</span> -->
                Warn Users
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
            <h1>Send Warning</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Moderator</span>
                    <div class="avatar">M</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <div class="warn-form-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title"> Send Warning</h1>
                    <p class="page-subtitle">Issue a formal warning to a user for policy violations</p>
                </div>

                <!-- Users Dashboard -->
                <div class="users-dashboard">
                    <!-- Users List -->
                    <div class="users-list-container">
                        <div class="users-list-header">
                            <h2 class="users-list-title"> Users to Warn</h2>
                            <p class="users-list-subtitle">Select a user to issue a warning</p>
                        </div>
                        <div class="users-list">
                            <?php
                            // Dummy users data
                            $dummyUsers = array(
                                array(
                                    'id' => 201,
                                    'username' => 'john_doe',
                                    'email' => 'john.doe@email.com',
                                    'strikes' => 2,
                                    'joinDate' => '2024-01-15',
                                    'lastActivity' => '2024-03-10',
                                    'reason' => 'Inappropriate language in forum posts'
                                ),
                                array(
                                    'id' => 202,
                                    'username' => 'sarah_smith',
                                    'email' => 'sarah.smith@email.com',
                                    'strikes' => 1,
                                    'joinDate' => '2024-02-20',
                                    'lastActivity' => '2024-03-12',
                                    'reason' => 'Spamming behavior detected'
                                ),
                                array(
                                    'id' => 203,
                                    'username' => 'mike_wilson',
                                    'email' => 'mike.wilson@email.com',
                                    'strikes' => 3,
                                    'joinDate' => '2023-12-10',
                                    'lastActivity' => '2024-03-14',
                                    'reason' => 'Multiple guideline violations'
                                )
                            );
                            ?>
                            
                            <?php foreach ($dummyUsers as $user): ?>
                            <div class="user-card" data-user-id="<?= $user['id']; ?>" data-username="<?= htmlspecialchars($user['username']); ?>" data-email="<?= htmlspecialchars($user['email']); ?>" data-strikes="<?= $user['strikes']; ?>" data-join-date="<?= $user['joinDate']; ?>" data-last-activity="<?= $user['lastActivity']; ?>">
                                <div class="user-card-header">
                                    <div class="user-card-avatar">
                                        <?= strtoupper(substr($user['username'], 0, 1)); ?>
                                    </div>
                                    <div class="user-card-info">
                                        <h4><?= htmlspecialchars($user['username']); ?></h4>
                                        <p><?= htmlspecialchars($user['email']); ?></p>
                                    </div>
                                </div>
                                <div class="user-card-stats">
                                    <div class="user-stat">
                                        <span class="user-stat-value"><?= $user['strikes']; ?></span>
                                        <span class="user-stat-label">Strikes</span>
                                    </div>
                                    <div class="user-stat">
                                        <span class="user-stat-value"><?= date('M j', strtotime($user['joinDate'])); ?></span>
                                        <span class="user-stat-label">Joined</span>
                                    </div>
                                    <div class="user-stat">
                                        <span class="user-stat-value"><?= date('M j', strtotime($user['lastActivity'])); ?></span>
                                        <span class="user-stat-label">Last Active</span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Warning Form Section -->
                    <div class="warning-form-section" id="warningFormSection">
                        <?php if (isset($data['userId']) && $data['userId']): ?>
                            <!-- Show form for specific user from URL -->
                            <div class="form-header">
                                <h2 class="form-title">Warning Form</h2>
                                <p class="form-subtitle">Issue warning to: <?= htmlspecialchars(isset($data['username']) ? $data['username'] : 'Unknown User'); ?></p>
                            </div>
                            <div class="form-content">
                                <!-- User Information Card -->
                                <div class="user-info-card">
                                    <div class="user-info-header">
                                        <div class="user-avatar">
                                            <?= strtoupper(substr(isset($data['username']) ? $data['username'] : 'U', 0, 1)); ?>
                                        </div>
                                        <div class="user-details">
                                            <h3><?= htmlspecialchars(isset($data['username']) ? $data['username'] : 'Unknown User'); ?></h3>
                                            <p>User ID: #<?= isset($data['userId']) ? $data['userId'] : 'Unknown'; ?> | Email: <?= htmlspecialchars(isset($data['email']) ? $data['email'] : 'N/A'); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="user-stats">
                                        <div class="stat-item">
                                            <span class="stat-value"><?= isset($data['strikes']) ? $data['strikes'] : 0; ?></span>
                                            <span class="stat-label">Current Strikes</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value"><?= isset($data['joinDate']) ? $data['joinDate'] : 'N/A'; ?></span>
                                            <span class="stat-label">Join Date</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value"><?= isset($data['lastActivity']) ? $data['lastActivity'] : 'N/A'; ?></span>
                                            <span class="stat-label">Last Active</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Warning Templates -->
                                <div class="warning-templates">
                                    <div class="templates-header">Quick Templates:</div>
                                    <div class="template-buttons">
                                        <button type="button" class="template-btn" data-template="inappropriate">Inappropriate Language</button>
                                        <button type="button" class="template-btn" data-template="spam">Spam/Harassment</button>
                                        <button type="button" class="template-btn" data-template="content">Inappropriate Content</button>
                                        <button type="button" class="template-btn" data-template="guidelines">Guideline Violation</button>
                                    </div>
                                </div>

                                <!-- Warning Form -->
                                <form method="POST" action="" id="warningForm">
                                    <div class="form-group">
                                        <label for="violationType" class="form-label">Violation Type</label>
                                        <select name="violationType" id="violationType" class="form-input" required>
                                            <option value="">Select violation type...</option>
                                            <option value="inappropriate_language">Inappropriate Language</option>
                                            <option value="spam_harassment">Spam/Harassment</option>
                                            <option value="inappropriate_content">Inappropriate Content</option>
                                            <option value="guideline_violation">Community Guideline Violation</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="severity" class="form-label">Warning Severity</label>
                                        <select name="severity" id="severity" class="form-input" required>
                                            <option value="">Select severity level...</option>
                                            <option value="low">Low - First warning</option>
                                            <option value="medium">Medium - Repeated offense</option>
                                            <option value="high">High - Serious violation</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="message" class="form-label">Warning Message</label>
                                        <textarea name="message" id="message" class="form-input form-textarea" placeholder="Enter detailed warning message..." required></textarea>
                                    </div>

                        <div class="form-group">
                                        <label for="additionalNotes" class="form-label">Additional Notes (Optional)</label>
                                        <textarea name="additionalNotes" id="additionalNotes" class="form-input form-textarea" placeholder="Any additional context or notes for this warning..."></textarea>
                                    </div>

                                    <div class="warning-preview" id="warningPreview">
                                        <h4>Warning Preview:</h4>
                                        <p id="previewText"></p>
                        </div>

                        <div class="form-actions">
                                        <button type="submit" class="btn btn-warn">
                                            Send Warning
                                        </button>
                                        <a href="<?= BASE_URL ?>/FlaggedUsers" class="btn btn-outline">
                                            Cancel
                                        </a>
                        </div>
                    </form>
                            </div>
                        <?php else: ?>
                            <!-- Show no user selected message -->
                            <div class="no-user-selected">
                                <div class="no-user-selected-icon">👆</div>
                                <h3>Select a User</h3>
                                <p>Choose a user from the list to issue a warning</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        <script>
            // Template messages
            const templates = {
                inappropriate: "You have been warned for using inappropriate language in our community. Please maintain respectful communication with other members.",
                spam: "You have been warned for spamming or harassing other community members. Such behavior is not tolerated and may result in further action.",
                content: "You have been warned for sharing inappropriate content. Please ensure all shared content follows our community guidelines.",
                guidelines: "You have been warned for violating our community guidelines. Please review the rules and ensure your future behavior complies with our standards."
            };

            // User selection functionality
            document.querySelectorAll('.user-card').forEach(card => {
                card.addEventListener('click', function() {
                    // Remove selected class from all cards
                    document.querySelectorAll('.user-card').forEach(c => c.classList.remove('selected'));
                    // Add selected class to clicked card
                    this.classList.add('selected');
                    
                    // Get user data
                    const userId = this.dataset.userId;
                    const username = this.dataset.username;
                    const email = this.dataset.email;
                    const strikes = this.dataset.strikes;
                    const joinDate = this.dataset.joinDate;
                    const lastActivity = this.dataset.lastActivity;
                    
                    // Update the warning form section
                    updateWarningForm(userId, username, email, strikes, joinDate, lastActivity);
                });
            });

            function updateWarningForm(userId, username, email, strikes, joinDate, lastActivity) {
                const formSection = document.getElementById('warningFormSection');
                
                formSection.innerHTML = `
                    <div class="form-header">
                        <h2 class="form-title">Warning Form</h2>
                        <p class="form-subtitle">Issue warning to: ${username}</p>
                    </div>
                    <div class="form-content">
                        <!-- User Information Card -->
                        <div class="user-info-card">
                            <div class="user-info-header">
                                <div class="user-avatar">
                                    ${username.charAt(0).toUpperCase()}
                                </div>
                                <div class="user-details">
                                    <h3>${username}</h3>
                                    <p>User ID: #${userId} | Email: ${email}</p>
                                </div>
                            </div>
                            
                            <div class="user-stats">
                                <div class="stat-item">
                                    <span class="stat-value">${strikes}</span>
                                    <span class="stat-label">Current Strikes</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">${joinDate}</span>
                                    <span class="stat-label">Join Date</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">${lastActivity}</span>
                                    <span class="stat-label">Last Active</span>
                                </div>
                            </div>
                        </div>

                        <!-- Warning Templates -->
                        <div class="warning-templates">
                            <div class="templates-header">Quick Templates:</div>
                            <div class="template-buttons">
                                <button type="button" class="template-btn" data-template="inappropriate">Inappropriate Language</button>
                                <button type="button" class="template-btn" data-template="spam">Spam/Harassment</button>
                                <button type="button" class="template-btn" data-template="content">Inappropriate Content</button>
                                <button type="button" class="template-btn" data-template="guidelines">Guideline Violation</button>
        </div>
                        </div>

                        <!-- Warning Form -->
                        <form method="POST" action="" id="warningForm">
                            <input type="hidden" name="userId" value="${userId}">
                            <div class="form-group">
                                <label for="violationType" class="form-label">Violation Type</label>
                                <select name="violationType" id="violationType" class="form-input" required>
                                    <option value="">Select violation type...</option>
                                    <option value="inappropriate_language">Inappropriate Language</option>
                                    <option value="spam_harassment">Spam/Harassment</option>
                                    <option value="inappropriate_content">Inappropriate Content</option>
                                    <option value="guideline_violation">Community Guideline Violation</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="severity" class="form-label">Warning Severity</label>
                                <select name="severity" id="severity" class="form-input" required>
                                    <option value="">Select severity level...</option>
                                    <option value="low">Low - First warning</option>
                                    <option value="medium">Medium - Repeated offense</option>
                                    <option value="high">High - Serious violation</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message" class="form-label">Warning Message</label>
                                <textarea name="message" id="message" class="form-input form-textarea" placeholder="Enter detailed warning message..." required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="additionalNotes" class="form-label">Additional Notes (Optional)</label>
                                <textarea name="additionalNotes" id="additionalNotes" class="form-input form-textarea" placeholder="Any additional context or notes for this warning..."></textarea>
                            </div>

                            <div class="warning-preview" id="warningPreview">
                                <h4>Warning Preview:</h4>
                                <p id="previewText"></p>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-warn">
                                     Send Warning
                                </button>
                                <a href="<?= BASE_URL ?>/FlaggedUsers" class="btn btn-outline">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                `;
                
                // Re-attach event listeners for the new form
                attachFormEventListeners();
            }

            function attachFormEventListeners() {
                // Template button functionality
                document.querySelectorAll('.template-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        // Remove active class from all buttons
                        document.querySelectorAll('.template-btn').forEach(b => b.classList.remove('active'));
                        // Add active class to clicked button
                        this.classList.add('active');
                        
                        // Set the message
                        const template = this.dataset.template;
                        document.getElementById('message').value = templates[template];
                        
                        // Update preview
                        updatePreview();
                    });
                });

                // Update preview when message changes
                const messageField = document.getElementById('message');
                if (messageField) {
                    messageField.addEventListener('input', updatePreview);
                }

                // Form submission with confirmation
                const warningForm = document.getElementById('warningForm');
                if (warningForm) {
                    warningForm.addEventListener('submit', function(e) {
                        const message = document.getElementById('message').value.trim();
                        if (!message) {
                            e.preventDefault();
                            alert('Please enter a warning message.');
                            return;
                        }
                        
                        if (!confirm('Are you sure you want to send this warning? This action will be recorded.')) {
                            e.preventDefault();
                        }
                    });
                }
            }

            function updatePreview() {
                const message = document.getElementById('message');
                const preview = document.getElementById('warningPreview');
                const previewText = document.getElementById('previewText');
                
                if (message && preview && previewText) {
                    if (message.value.trim()) {
                        previewText.textContent = message.value;
                        preview.style.display = 'block';
                    } else {
                        preview.style.display = 'none';
                    }
                }
            }

            // Initialize event listeners on page load
            document.addEventListener('DOMContentLoaded', function() {
                attachFormEventListeners();
            });
        </script>
    </div>
</body>
</html>
