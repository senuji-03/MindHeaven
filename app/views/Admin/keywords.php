<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Keywords - Admin | Mind Haven</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        <?php include '_forum_styles.php'; ?>
    </style>
</head>

<body>
    <!-- Sidebar (Design System) -->
    <?php 
    $activePage = 'moderate-forum';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <?php 
        $topbarTitle = 'Manage Keywords';
        include '_topbar.php'; 
        ?>

        <div class="content-wrapper">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="add-form">
                <h3>Add New Flag Keyword</h3>
                <form action="<?= BASE_URL ?>/admin/keywords/add" method="POST" class="add-form-inline">
                    <input type="text" name="keyword" class="form-input" placeholder="Enter keyword..." required
                        minlength="2">
                    <button type="submit" class="btn btn-primary">Add Keyword</button>
                </form>
            </div>

            <?php 
            $activeTab = 'keywords';
            include '_forum_tabs.php'; 
            ?>

            <h3>Existing Keywords</h3>
            <div class="keyword-list">
                <?php if (empty($keywords)): ?>
                    <p>No keywords defined.</p>
                <?php else: ?>
                    <?php foreach ($keywords as $k): ?>
                        <div class="keyword-item">
                            <span>
                                <?= htmlspecialchars($k['keyword']) ?>
                            </span>
                            <form action="<?= BASE_URL ?>/admin/keywords/delete" method="POST" style="margin:0;">
                                <input type="hidden" name="id" value="<?= $k['id'] ?>">
                                <button type="submit" class="btn danger"
                                    onclick="return confirm('Delete this keyword?')">Delete</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>

