<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Counselors - Admin | Mind Haven</title>
    <!-- Fonts & Icons (Design System §2, §15) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
</head>

<body>
    <?php 
    $activePage = 'counselors';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Manage Counselors</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <section class="section-card">
                <div class="section-header">
                    <h2>Counselor Directory</h2>
                </div>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Specialization</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dr. Emily Clark</td>
                            <td><span class="badge status-active">Active</span></td>
                            <td>Anxiety</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Disable</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Mr. John Miles</td>
                            <td><span class="badge status-suspended">Onboarding</span></td>
                            <td>Relationship</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Verify</button>
                                <button class="btn btn-secondary btn-sm">Reject</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>

</html>

