<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awareness Programs - Admin | Mind Haven</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        .appointment {
            background: var(--surface);
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
            color: var(--text-primary);
            font-weight: 500;
        }
        section h2 {
            font-size: 1.25rem;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php 
    $activePage = 'awareness';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php 
        $topbarTitle = 'Awareness Programs';
        include '_topbar.php'; 
        ?>

        <div class="content-wrapper">
            <section>
                <h2>Upcoming Programs</h2>
                <div class="appointment">
                    <i class="fas fa-calendar-alt" style="margin-right: 10px; color: var(--primary);"></i>
                    Mental Health Awareness Week - 2025-09-10
                </div>
            </section>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>
</html>
