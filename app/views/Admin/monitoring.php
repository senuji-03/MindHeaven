<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Monitoring - Admin | Mind Haven</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .card {
            background: var(--surface);
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            color: var(--text-primary);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        section h2 {
            font-size: 1.25rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php 
    $activePage = 'monitoring';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php 
        $topbarTitle = 'System Monitoring';
        include '_topbar.php'; 
        ?>

        <div class="content-wrapper">
            <section>
                <h2>System Health</h2>
                <div class="cards">
                    <div class="card">
                        <i class="fas fa-server" style="color: var(--primary);"></i>
                        Server Load: Normal
                    </div>
                    <div class="card">
                        <i class="fas fa-database" style="color: var(--primary);"></i>
                        DB Status: Connected
                    </div>
                    <div class="card">
                        <i class="fas fa-exclamation-triangle" style="color: var(--crisis);"></i>
                        Errors (24h): 0
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>
</html>
