<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Profile - University Representative | MindHeaven</title>

    <!-- Fonts (§2) and Icons (§15) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ── Design System Tokens (§1) ── */
        :root {
            --primary:        #3D8B6E;
            --primary-light:  #6BB89A;
            --primary-dark:   #2A6B52;
            --bg-deep:        #1C2B2A;
            --bg-soft:        #F5F0E8;
            --bg-mid:         #EEF6F2;
            --text-primary:   #1E3A34;
            --text-secondary: #6B8C7E;
            --surface:        #FFFFFF;
            --border:         #D6E4DD;
            --crisis:         #D64F4F;
            --success:        #4CAF82;
            --shadow-sm:      0 1px 3px rgba(30,58,52,0.06);
            --shadow-md:      0 4px 12px rgba(30,58,52,0.08);
            --shadow-lg:      0 12px 32px rgba(30,58,52,0.10);
            --radius-sm:      8px;
            --radius-md:      14px;
            --radius-lg:      20px;
            --radius-full:    9999px;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', 'Inter', system-ui, sans-serif;
            background: var(--bg-soft);
            color: var(--text-primary);
            line-height: 1.7;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 280px; height: 100vh;
            background: var(--bg-deep);
            position: fixed; left: 0; top: 0;
            display: flex; flex-direction: column;
            z-index: 1000; overflow-y: auto;
        }
        .sidebar::-webkit-scrollbar { display: none; }

        .sidebar-header {
            padding: 36px 28px 28px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-header h2 { font-size: 1.4rem; font-weight: 700; color: var(--primary-light); margin-bottom: 6px; }
        .sidebar-header p  { font-size: 0.75rem; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 1.5px; }

        .sidebar-nav { flex: 1; padding: 24px 16px; }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.65); text-decoration: none;
            border-radius: var(--radius-sm);
            margin-bottom: 4px; font-weight: 500; font-size: 0.95rem;
            transition: all 0.25s ease;
        }
        .nav-item i { width: 20px; text-align: center; font-size: 1rem; }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: white; transform: translateX(3px); }
        .nav-item.active { background: var(--primary); color: white; box-shadow: 0 4px 12px rgba(61,139,110,0.3); }

        .sidebar-footer { padding: 20px 16px; border-top: 1px solid rgba(255,255,255,0.08); }
        .logout-btn {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            color: #FFB3B3; text-decoration: none;
            border-radius: var(--radius-sm); font-weight: 600; font-size: 0.9rem; transition: all 0.25s;
        }
        .logout-btn:hover { background: rgba(214,79,79,0.1); }

        /* ── Main Layout ── */
        .main-content { margin-left: 280px; min-height: 100vh; }

        /* ── Topbar ── */
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 40px;
            background: var(--surface); border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 100;
        }
        .topbar h1 { font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; }
        .user-profile {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 18px;
            background: var(--bg-mid); border-radius: var(--radius-full);
            border: 1px solid var(--border);
            font-weight: 600; font-size: 0.9rem; color: var(--text-secondary);
        }
        .avatar {
            width: 34px; height: 34px;
            background: var(--primary); color: white; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem;
        }

        /* ── Content ── */
        .content-wrapper { padding: 36px 40px; max-width: 960px; }

        /* ── Alerts ── */
        .alert-container { margin-bottom: 24px; }
        .alert {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 20px; border-radius: var(--radius-md);
            font-weight: 600; font-size: 0.93rem; margin-bottom: 12px;
        }
        .alert-success { background: #E8F5E9; color: #2E7D32; border: 1px solid #C8E6C9; }
        .alert-error   { background: #FFEBEE; color: #C62828; border: 1px solid #FFCDD2; }
        .alert-close   { background: none; border: none; cursor: pointer; font-size: 1.1rem; margin-left: auto; opacity: 0.6; }
        .alert-close:hover { opacity: 1; }

        /* ── Page Header ── */
        .page-intro {
            margin-bottom: 28px;
        }
        .page-intro h2 { font-size: 1.35rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .page-intro p  { font-size: 0.9rem; color: var(--text-secondary); }

        /* ── Form Section Cards ── */
        .form-section {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 28px 32px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .section-heading {
            display: flex; align-items: flex-start; gap: 14px;
            padding-bottom: 18px; margin-bottom: 24px;
            border-bottom: 1px solid var(--border);
        }
        .section-icon-box {
            width: 42px; height: 42px; flex-shrink: 0;
            border-radius: var(--radius-sm);
            background: var(--bg-mid); color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
        }
        .section-heading h3 { font-size: 1.05rem; font-weight: 700; color: var(--text-primary); margin-bottom: 3px; }
        .section-heading small { font-size: 0.82rem; color: var(--text-secondary); }

        /* ── Form Elements (§8) ── */
        .form-row { margin-bottom: 18px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 18px; }

        .form-label {
            display: block; font-size: 0.85rem; font-weight: 600;
            color: var(--text-primary); margin-bottom: 6px;
        }
        .form-input {
            width: 100%; padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit; font-size: 0.9rem;
            color: var(--text-primary); background: var(--surface);
            transition: border-color 0.25s, box-shadow 0.25s;
        }
        .form-input:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(61,139,110,0.12);
        }
        textarea.form-input { resize: vertical; min-height: 90px; }
        .form-helper { font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px; }

        /* ── Bank section accent ── */
        .form-section.bank-section { border-left: 4px solid var(--primary); }

        /* ── Actions ── */
        .form-actions { display: flex; justify-content: flex-end; margin-top: 8px; }

        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 28px;
            border-radius: var(--radius-full);
            font-family: inherit; font-weight: 600; font-size: 0.9rem;
            cursor: pointer; border: none; text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(61,139,110,0.3);
        }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
            .content-wrapper { padding: 24px 20px; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>University Representative</p>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/university-rep/dashboard" class="nav-item">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item">
                <i class="fas fa-calendar-alt"></i> Manage Events
            </a>
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item active">
                <i class="fas fa-university"></i> University Profile
            </a>
            <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item">
                <i class="fas fa-user-circle"></i> My Profile
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h1>University Profile</h1>
            <div class="user-profile">
                <span><?= htmlspecialchars($_SESSION['university_name'] ?? 'University') ?></span>
                <div class="avatar"><?= strtoupper(substr($_SESSION['university_name'] ?? 'U', 0, 1)) ?></div>
            </div>
        </div>

        <div class="content-wrapper">
            <!-- Alerts -->
            <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
            <div class="alert-container">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?= htmlspecialchars($_SESSION['success']) ?></span>
                        <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                        <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Page Intro -->
            <div class="page-intro">
                <h2><i class="fas fa-university" style="color:var(--primary);margin-right:10px;"></i>Your University's Public Profile</h2>
                <p>Manage the public face of your university and configure your receiving bank details.</p>
            </div>

            <form method="POST" action="<?= BASE_URL ?>/university-rep/university-profile/update">

                <!-- Section 1: Public Identity -->
                <div class="form-section">
                    <div class="section-heading">
                        <div class="section-icon-box"><i class="fas fa-landmark"></i></div>
                        <div>
                            <h3>Public Identity</h3>
                            <small>Name, address and website visible to donors and students.</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-label" for="name">Official University Name *</label>
                        <input type="text" id="name" name="name" required
                               class="form-input" autocomplete="organization"
                               value="<?= htmlspecialchars($university['name'] ?? '') ?>">
                    </div>

                    <div class="form-row">
                        <label class="form-label" for="address">Address *</label>
                        <textarea id="address" name="address" required rows="3"
                                  class="form-input" autocomplete="street-address"><?= htmlspecialchars($university['address'] ?? '') ?></textarea>
                    </div>

                    <div class="form-grid">
                        <div>
                            <label class="form-label" for="city">City *</label>
                            <input type="text" id="city" name="city" required
                                   class="form-input" autocomplete="address-level2"
                                   value="<?= htmlspecialchars($university['city'] ?? '') ?>">
                        </div>
                        <div>
                            <label class="form-label" for="state">State</label>
                            <input type="text" id="state" name="state"
                                   class="form-input" autocomplete="address-level1"
                                   value="<?= htmlspecialchars($university['state'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-label" for="website">Official Website</label>
                        <input type="url" id="website" name="website"
                               placeholder="https://youruniversity.ac.lk"
                               class="form-input" autocomplete="url"
                               value="<?= htmlspecialchars($university['website'] ?? '') ?>">
                    </div>
                </div>

                <!-- Section 2: Verification & Contact -->
                <div class="form-section">
                    <div class="section-heading">
                        <div class="section-icon-box"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <h3>Verification &amp; Contact</h3>
                            <small>Crucial for trust and communication.</small>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div>
                            <label class="form-label" for="email">Official Email Address *</label>
                            <input type="email" id="email" name="email" required
                                   class="form-input" autocomplete="email"
                                   value="<?= htmlspecialchars($university['email'] ?? '') ?>">
                        </div>
                        <div>
                            <label class="form-label" for="phone">Working Landline / Office Number *</label>
                            <input type="tel" id="phone" name="phone" required
                                   class="form-input" autocomplete="tel"
                                   value="<?= htmlspecialchars($university['phone'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Bank Details -->
                <div class="form-section bank-section">
                    <div class="section-heading">
                        <div class="section-icon-box"><i class="fas fa-piggy-bank"></i></div>
                        <div>
                            <h3>Bank Details</h3>
                            <small>Represents where donation money will be transferred.</small>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div>
                            <label class="form-label" for="bank_name">Bank Name *</label>
                            <input type="text" id="bank_name" name="bank_name" required
                                   class="form-input" autocomplete="off"
                                   value="<?= htmlspecialchars($university['bank_name'] ?? '') ?>">
                        </div>
                        <div>
                            <label class="form-label" for="bank_branch">Bank Branch *</label>
                            <input type="text" id="bank_branch" name="bank_branch" required
                                   class="form-input" autocomplete="off"
                                   value="<?= htmlspecialchars($university['bank_branch'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="form-label" for="account_name">Account Name *</label>
                        <input type="text" id="account_name" name="account_name" required
                               class="form-input" autocomplete="off"
                               value="<?= htmlspecialchars($university['account_name'] ?? '') ?>">
                        <span class="form-helper">Should ideally match the University name (e.g., "Kelaniya University – Mental Health Fund").</span>
                    </div>

                    <div class="form-grid">
                        <div>
                            <label class="form-label" for="account_number">Account Number *</label>
                            <input type="text" id="account_number" name="account_number" required
                                   class="form-input" autocomplete="off"
                                   value="<?= htmlspecialchars($university['account_number'] ?? '') ?>">
                        </div>
                        <div>
                            <label class="form-label" for="bank_code">Bank Code</label>
                            <input type="text" id="bank_code" name="bank_code"
                                   class="form-input" autocomplete="off"
                                   value="<?= htmlspecialchars($university['bank_code'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js?v=<?= time() ?>"></script>
</body>
</html>