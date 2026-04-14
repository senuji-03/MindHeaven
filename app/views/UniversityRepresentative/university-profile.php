<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage University Profile - University Rep | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/forms.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>University Representative</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/university-rep/dashboard" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item">
                <span class="icon">📅</span>
                Manage Events
            </a>
            
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item active">
                <span class="icon">🏫</span>
                University Profile
            </a>
          
            <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item">
                <span class="icon">👤</span>
                My Profile
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
        <div class="topbar">
            <h1>Manage University Profile</h1>
            <div class="topbar-right">
                <div class="user-profile">
                    <span><?= htmlspecialchars($_SESSION['university_name'] ?? 'University') ?></span>
                    <div class="avatar"><?= strtoupper(substr($_SESSION['university_name'] ?? 'U', 0, 1)) ?></div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <!-- Content -->
        <div class="content-wrapper">
            <div class="page-header">
                <h2>🏫 Your University's Public Profile</h2>
                <p>Manage the public face of your university and configure your receiving bank details.</p>
            </div>

            <!-- University Profile Form -->
            <form method="POST" action="<?= BASE_URL ?>/university-rep/university-profile/update" class="event-form">
                
                <!-- Section 1: Public Identity -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">🏛️</span>
                        <h3>Public Identity</h3>
                    </div>

                    <div class="form-row">
                        <label for="name">Official University Name *</label>
                        <input type="text" id="name" name="name" required 
                               class="form-input" autocomplete="organization"
                               value="<?= htmlspecialchars($university['name'] ?? '') ?>">
                    </div>

                    <div class="form-row">
                        <label for="address">Address *</label>
                        <textarea id="address" name="address" required rows="3" 
                                  class="form-input" autocomplete="street-address"><?= htmlspecialchars($university['address'] ?? '') ?></textarea>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="city">City *</label>
                            <input type="text" id="city" name="city" required 
                                   class="form-input" autocomplete="address-level2" value="<?= htmlspecialchars($university['city'] ?? '') ?>">
                        </div>
                        <div class="form-row">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" 
                                   class="form-input" autocomplete="address-level1" value="<?= htmlspecialchars($university['state'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="website">Official Website</label>
                        <input type="url" id="website" name="website" 
                               placeholder="https://youruniversity.ac.lk" class="form-input" autocomplete="url"
                               value="<?= htmlspecialchars($university['website'] ?? '') ?>">
                    </div>
                </div>

                <!-- Section 2: Verification & Contact -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">📞</span>
                        <h3>Verification & Contact</h3>
                        <small style="display:block; color:#64748b; margin-top:4px;">Crucial for trust and communication</small>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="email">Official Email Address *</label>
                            <input type="email" id="email" name="email" required 
                                   class="form-input" autocomplete="email"
                                   value="<?= htmlspecialchars($university['email'] ?? '') ?>">
                        </div>
                        <div class="form-row">
                            <label for="phone">Working Landline / Office Number *</label>
                            <input type="tel" id="phone" name="phone" required 
                                   class="form-input" autocomplete="tel" value="<?= htmlspecialchars($university['phone'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Bank Details -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">🏦</span>
                        <h3>Bank Details</h3>
                        <small style="display:block; color:#64748b; margin-top:4px;">Represents where the donation money goes</small>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="bank_name">Bank Name *</label>
                            <input type="text" id="bank_name" name="bank_name" required 
                                   class="form-input" autocomplete="off" value="<?= htmlspecialchars($university['bank_name'] ?? '') ?>">
                        </div>
                        <div class="form-row">
                            <label for="bank_branch">Bank Branch *</label>
                            <input type="text" id="bank_branch" name="bank_branch" required 
                                   class="form-input" autocomplete="off" value="<?= htmlspecialchars($university['bank_branch'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="account_name">Account Name *</label>
                        <input type="text" id="account_name" name="account_name" required 
                               class="form-input" autocomplete="off" value="<?= htmlspecialchars($university['account_name'] ?? '') ?>">
                        <small>Should ideally match the University name (e.g., "Kelaniya University - Mental Health Fund").</small>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="account_number">Account Number *</label>
                            <input type="text" id="account_number" name="account_number" required 
                                   class="form-input" autocomplete="off" value="<?= htmlspecialchars($university['account_number'] ?? '') ?>">
                        </div>
                        <div class="form-row">
                            <label for="bank_code">Bank Code</label>
                            <input type="text" id="bank_code" name="bank_code" 
                                   class="form-input" autocomplete="off" value="<?= htmlspecialchars($university['bank_code'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js"></script>
</body>
</html>