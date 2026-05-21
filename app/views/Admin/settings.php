<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin | Mind Haven</title>
    <!-- Fonts & Icons (Design System §2, §15) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>
<body>
    <?php 
    $activePage = 'settings';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <!-- Top Bar -->
        <?php 
        $topbarTitle = 'Settings';
        include '_topbar.php'; 
        ?>

        <!-- Content -->
        <div class="content-wrapper">
            <section>
                <h2>Platform Settings</h2>
                <div>Theme: Light</div>
                <div>Notifications: Enabled</div>
            </section>
        </div>
    </div>
</body>
</html>



