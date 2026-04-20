<?php
// app/views/UniversityRepresentative/donations.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Donations - University Representative | MindHeaven</title>
    
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ── Design System Tokens ── */
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
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar::-webkit-scrollbar { display: none; }

        .sidebar-header {
            padding: 36px 28px 28px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-header h2 {
            font-size: 1.4rem; font-weight: 700;
            color: var(--primary-light);
            margin-bottom: 6px;
        }
        .sidebar-header p {
            font-size: 0.75rem; color: rgba(255,255,255,0.5);
            text-transform: uppercase; letter-spacing: 1.5px;
        }

        .sidebar-nav { flex: 1; padding: 24px 16px; }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            border-radius: var(--radius-sm);
            margin-bottom: 4px;
            font-weight: 500; font-size: 0.95rem;
            transition: all 0.25s ease;
        }
        .nav-item i { width: 20px; text-align: center; font-size: 1rem; }
        .nav-item:hover { background: rgba(255,255,255,0.07); color: white; transform: translateX(3px); }
        .nav-item.active {
            background: var(--primary); color: white;
            box-shadow: 0 4px 12px rgba(61,139,110,0.3);
        }

        .sidebar-footer {
            padding: 20px 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .logout-btn {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            color: #FFB3B3; text-decoration: none;
            border-radius: var(--radius-sm);
            font-weight: 600; font-size: 0.9rem;
            transition: all 0.25s;
        }
        .logout-btn:hover { background: rgba(214,79,79,0.1); }

        /* ── Main Layout ── */
        .main-content { margin-left: 280px; min-height: 100vh; }

        /* ── Topbar ── */
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 40px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 100;
        }
        .topbar h1 { font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; }
        .user-profile {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 18px;
            background: var(--bg-mid);
            border-radius: var(--radius-full);
            border: 1px solid var(--border);
            font-weight: 600; font-size: 0.9rem; color: var(--text-secondary);
        }
        .avatar {
            width: 34px; height: 34px;
            background: var(--primary); color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.85rem;
        }

        /* ── Content Wrapper ── */
        .content-wrapper { padding: 36px 40px; }

        /* ── Table Styling ── */
        .data-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 28px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            text-align: left; padding: 16px;
            font-size: 0.8rem; text-transform: uppercase;
            letter-spacing: 1px; color: var(--text-secondary);
            border-bottom: 2px solid var(--bg-mid);
        }
        .data-table td { padding: 16px; font-size: 0.93rem; border-bottom: 1px solid var(--bg-mid); }
        .data-table tr:last-child td { border-bottom: none; }
        
        .badge { padding: 4px 12px; border-radius: var(--radius-full); font-size: 0.75rem; font-weight: 700; }
        .badge-success { background: #E8F5E9; color: #2E7D32; }

        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            margin-top: 24px; color: var(--text-secondary);
            text-decoration: none; font-size: 0.9rem; font-weight: 500;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--primary); }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
            .sidebar { width: 0; display: none; }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php 
    $activePage = ''; // Not in main 4 sidebar items as per request
    include '_sidebar.php'; 
    ?>

    <div class="main-content">
        <!-- Topbar -->
        <?php 
        $topbarTitle = 'Donations';
        include '_topbar.php'; 
        ?>

        <div class="content-wrapper">
            <div class="page-header" style="margin-bottom: 24px;">
                <p style="color: var(--text-secondary);">Direct contributions received for your university events.</p>
            </div>

            <div class="data-card">
                <?php if (empty($donations)): ?>
                    <p style="color: var(--text-secondary); text-align: center; padding: 40px;">No donations recorded for your events yet.</p>
                <?php else: ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Event</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                                <th>Status</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donations as $donation): ?>
                                <tr>
                                    <td><?= date('M j, Y', strtotime($donation['created_at'])) ?></td>
                                    <td><strong style="color: var(--text-primary);"><?= htmlspecialchars($donation['event_title']) ?></strong></td>
                                    <td><span style="font-weight: 700; color: var(--primary);"><?= htmlspecialchars($donation['currency']) ?> <?= number_format($donation['amount'], 2) ?></span></td>
                                    <td style="font-family: monospace; font-size: 0.85rem; color: var(--text-secondary);"><?= htmlspecialchars($donation['transaction_id']) ?></td>
                                    <td><span class="badge badge-success"><?= htmlspecialchars(ucfirst($donation['payment_status'])) ?></span></td>
                                    <td style="font-style: italic; font-size: 0.85rem; color: var(--text-secondary);"><?= htmlspecialchars($donation['donor_message']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <a href="<?= BASE_URL ?>/university-rep/dashboard" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>
