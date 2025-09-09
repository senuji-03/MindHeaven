<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <!-- Use BASE_URL so paths work in any environment -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/admin/style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <!-- Updated links to use MVC routes instead of .html files -->
        <a href="<?php echo BASE_URL; ?>/admin">Dashboard</a>
        <a href="<?php echo BASE_URL; ?>/admin/manage-users" class="active">Manage Users</a>
        <a href="<?php echo BASE_URL; ?>/admin/resource-hub">Resource Hub</a>
    </div>

    <div class="main-content">
        <header><h1>Manage Users</h1></header>
        <section>
            <table>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>U101</td>
                    <td>John Doe</td>
                    <td>Student</td>
                    <td><button onclick="viewReport('U101')">View Report</button></td>
                </tr>
                <tr>
                    <td>U102</td>
                    <td>Jane Smith</td>
                    <td>Counselor</td>
                    <td><button onclick="viewReport('U102')">View Report</button></td>
                </tr>
            </table>
        </section>
    </div>

    <script src="<?php echo BASE_URL; ?>/public/js/admin/script.js"></script>
</body>
</html>