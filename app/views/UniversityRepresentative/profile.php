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
        <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
        <div class="alert-container">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <span class="alert-icon">✅</span>
                    <span class="alert-message"><?= htmlspecialchars($_SESSION['success']) ?></span>
                    <button class="alert-close">&times;</button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <span class="alert-icon">❌</span>
                    <span class="alert-message"><?= htmlspecialchars($_SESSION['error']) ?></span>
                    <button class="alert-close">&times;</button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Top Bar -->
        <div class="topbar" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 30px; background: white; border-bottom: 1px solid #e2e8f0; margin-bottom: 0;">
            <div class="topbar-left">
                <h1 style="margin: 0; font-size: 1.5rem; color: #1e293b;">My Profile</h1>
            </div>
            <div class="topbar-right">
                <div class="user-profile" style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($_SESSION['university_name'] ?? 'University') ?></span>
                    <div class="avatar" style="width: 35px; height: 35px; border-radius: 50%; background: #3b82f6; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                        <?= strtoupper(substr($_SESSION['university_name'] ?? 'U', 0, 1)) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header (Context) -->
        <div class="page-header" style="padding: 24px 30px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
            <div class="header-content">
                <p style="margin: 0; color: #64748b;">Manage your personal information and professional context.</p>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="profile-content">
            <form method="POST" action="<?= BASE_URL ?>/university-rep/profile/update" class="event-form">
                
                <!-- Account Details -->
                <div class="profile-section" style="margin-bottom: 24px; background: white; border-radius: 12px; padding: 25px; border: 1px solid #e2e8f0;">
                    <div class="section-header" style="border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; padding-bottom: 15px;">
                        <h3 style="margin:0;"><i class="fas fa-user-circle"></i> Account Details</h3>
                        <small style="color:#64748b; margin-top:4px; display:block;">Your core account identifiers.</small>
                    </div>
                    <div class="section-content">
                        <div class="form-row" style="margin-bottom:15px;">
                            <label for="full_name" style="display:block; margin-bottom:5px; font-weight:600; color:#1e293b;">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" required 
                                   class="form-input" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;"
                                   autocomplete="name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
                        </div>

                        <div class="form-row" style="display:flex; gap:20px; margin-bottom:15px;">
                            <div style="flex:1;">
                                <label for="username" style="display:block; margin-bottom:5px; font-weight:600; color:#1e293b;">Username</label>
                                <input type="text" id="username" name="username" readonly 
                                       class="form-input" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; background-color:#f1f5f9; color:#64748b;"
                                       autocomplete="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>">
                                <small style="color:#64748b;">Username cannot be changed.</small>
                            </div>
                            <div style="flex:1;">
                                <label for="email" style="display:block; margin-bottom:5px; font-weight:600; color:#1e293b;">Email Address *</label>
                                <input type="email" id="email" name="email" required 
                                       class="form-input" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;"
                                       autocomplete="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Context -->
                <div class="profile-section" style="background: white; border-radius: 12px; padding: 25px; border: 1px solid #e2e8f0;">
                    <div class="section-header" style="border-bottom: 1px solid #e2e8f0; margin-bottom: 20px; padding-bottom: 15px;">
                        <h3 style="margin:0;"><i class="fas fa-briefcase"></i> Professional Context</h3>
                        <small style="color:#64748b; margin-top:4px; display:block;">Your role at the university.</small>
                    </div>
                    <div class="section-content">
                        <div class="form-row" style="display:flex; gap:20px; margin-bottom:15px;">
                            <div style="flex:1;">
                                <label for="position" style="display:block; margin-bottom:5px; font-weight:600; color:#1e293b;">Position / Job Title *</label>
                                <input type="text" id="position" name="position" required 
                                       class="form-input" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;"
                                       autocomplete="organization-title" value="<?= htmlspecialchars($user['position'] ?? '') ?>">
                            </div>
                            <div style="flex:1;">
                                <label for="department" style="display:block; margin-bottom:5px; font-weight:600; color:#1e293b;">Department / Office</label>
                                <input type="text" id="department" name="department" 
                                       class="form-input" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;"
                                       autocomplete="organization" value="<?= htmlspecialchars($user['department'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="form-row" style="display:flex; gap:20px; margin-bottom:15px;">
                            <div style="flex:1;">
                                <label for="office_phone" style="display:block; margin-bottom:5px; font-weight:600; color:#1e293b;">Direct Phone Number</label>
                                <input type="tel" id="office_phone" name="office_phone" 
                                       class="form-input" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px;"
                                       autocomplete="tel" value="<?= htmlspecialchars($user['office_phone'] ?? '') ?>">
                            </div>
                            <div style="flex:1;">
                                <label for="university_name" style="display:block; margin-bottom:5px; font-weight:600; color:#1e293b;">Representing University</label>
                                <input type="text" id="university_name" name="university_name" readonly
                                       class="form-input" style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:6px; background-color:#f1f5f9; color:#64748b;"
                                       autocomplete="off" value="<?= htmlspecialchars($user['university_name'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions" style="margin-top: 24px; text-align: right;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 24px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Save Profile Updates</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
