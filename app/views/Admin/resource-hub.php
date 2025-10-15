<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resource Hub</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <!-- Update links to use routes instead of .html files -->
        <a href="<?= BASE_URL ?>/admin">Dashboard</a>
        <a href="<?= BASE_URL ?>/admin/manage-users">Manage Users</a>
        <a href="<?= BASE_URL ?>/admin/resource-hub" class="active">Resource Hub</a>
    </div>

    <div class="main-content">
        <header><h1>Resource Hub</h1></header>
        <section class="resources">
            <div class="resource">
                <h3>Managing Exam Stress</h3>
                <p>Short guide to manage anxiety before exams.</p>
                <div class="likes">
                    👍 <span id="like1">12</span>
                    👎 <span id="dislike1">2</span>
                </div>
                <button onclick="like('like1')">Like</button>
                <button onclick="dislike('dislike1')">Dislike</button>
            </div>
        </section>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>
</html>