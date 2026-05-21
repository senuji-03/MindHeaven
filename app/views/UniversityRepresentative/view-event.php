<?php
// app/views/UniversityRepresentative/view-event.php

$isRep = isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'university_representative';

// Design System variables (fallback if not global)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - <?= htmlspecialchars(isset($event['event_title']) ? $event['event_title'] : 'View Event') ?> | MindHaven</title>
    
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #3D8B6E;
            --primary-light: #4A9F7E;
            --primary-dark: #2F6B54;
            --secondary: #1C2B2A;
            --bg-soft: #F4F7F5;
            --bg-mid: #E8F0ED;
            --surface: #FFFFFF;
            --text-primary: #1C2B2A;
            --text-secondary: #5C716E;
            --border: #D1DBD8;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-full: 9999px;
            --shadow-sm: 0 2px 4px rgba(28, 43, 42, 0.05);
            --shadow-md: 0 8px 24px rgba(28, 43, 42, 0.08);
            --crisis: #D64F4F;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DM Sans', sans-serif;
        }

        body {
            background-color: var(--bg-soft);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: var(--secondary);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 40px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--primary-light);
        }

        .sidebar-header p {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex-grow: 1;
            padding: 30px 20px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: var(--radius-sm);
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .nav-item.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(61, 139, 110, 0.3);
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-footer {
            padding: 30px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            color: #FFB3B3;
            text-decoration: none;
            border-radius: var(--radius-sm);
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: rgba(214, 79, 79, 0.1);
        }

        /* Main Content area */
        .main-content {
            margin-left: <?= $isRep ? '280px' : '0' ?>;
            padding: 48px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Topbar */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 48px;
        }

        .topbar h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: var(--surface);
            border-radius: var(--radius-full);
            box-shadow: var(--shadow-sm);
        }

        .user-profile .avatar {
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* Event Layout */
        .event-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 32px;
        }

        .page-header h2 {
            font-size: 1.4rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        /* Cards and Components */
        .card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .event-banner {
            width: 100%;
            height: 480px;
            background: var(--bg-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .event-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--text-secondary);
        }

        .no-image i {
            font-size: 4rem;
            margin-bottom: 16px;
            opacity: 0.3;
        }

        .event-main-content {
            padding: 48px;
        }

        .event-titles {
            margin-bottom: 40px;
            border-bottom: 1px solid var(--bg-mid);
            padding-bottom: 32px;
        }

        .event-titles h1 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 16px;
            line-height: 1.1;
        }

        .tag-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .tag {
            padding: 6px 16px;
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .tag-type { background: var(--bg-mid); color: var(--primary-dark); }
        .tag-status { background: var(--primary); color: white; }
        .tag-status.status-pending { background: #f59e0b; }
        .tag-status.status-rejected { background: var(--crisis); }
        .tag-status.status-closed { background: var(--text-secondary); }

        .info-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 48px;
        }

        .info-section {
            margin-bottom: 40px;
        }

        .info-section h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-section h3 i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .item-row {
            margin-bottom: 20px;
        }

        .item-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            margin-bottom: 6px;
            display: block;
        }

        .item-value {
            font-size: 1.05rem;
            color: var(--text-primary);
            font-weight: 500;
        }

        .description-box {
            background: var(--bg-soft);
            padding: 24px;
            border-radius: var(--radius-md);
            font-size: 1.05rem;
            line-height: 1.7;
            color: var(--text-secondary);
        }

        .sidebar-stats {
            background: var(--bg-soft);
            border-radius: var(--radius-md);
            padding: 24px;
            border: 1px solid var(--border);
        }

        .stat-item {
            margin-bottom: 24px;
        }

        .stat-item:last-child { margin-bottom: 0; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 24px;
            border-radius: var(--radius-full);
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(61, 139, 110, 0.2); }

        .btn-outline { background: transparent; border: 1.5px solid var(--border); color: var(--text-secondary); }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); background: var(--bg-mid); }

        .btn-danger { background: rgba(214, 79, 79, 0.1); color: var(--crisis); }
        .btn-danger:hover { background: var(--crisis); color: white; }

        .action-bar {
            padding: 32px 48px;
            background: var(--bg-mid);
            display: flex;
            gap: 16px;
            align-items: center;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 992px) {
            .sidebar { width: 0; overflow: hidden; }
            .main-content { margin-left: 0; padding: 24px; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<?php if ($isRep): ?>
    <?php 
    $activePage = 'events';
    include '_sidebar.php'; 
    ?>
<?php endif; ?>

<main class="main-content">
    <?php if ($isRep): ?>
        <?php 
        $topbarTitle = 'Event Details';
        include '_topbar.php'; 
        ?>
    <?php else: ?>
        <div class="topbar">
            <h1>Event Details</h1>
        </div>
    <?php endif; ?>

    <div class="event-container">
        <div class="page-header">
            <h2><i class="far fa-calendar-check" style="margin-right: 8px;"></i> Information Hub</h2>
            <div class="header-actions">
                <a href="<?= (isset($isOwner) && $isOwner) ? BASE_URL . '/university-rep/events' : BASE_URL . '/' ?>" class="btn btn-outline">
                    <i class="fas fa-chevron-left"></i> Back
                </a>
                <?php if (isset($isOwner) && $isOwner): ?>
                    <a href="<?= BASE_URL ?>/university-rep/events/edit/<?= $event['id'] ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Content
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <article class="card">
            <!-- Banner Image -->
            <div class="event-banner">
                <?php if (!empty($event['image_path'])): ?>
                    <img src="<?= BASE_URL . '/' . htmlspecialchars($event['image_path']) ?>" alt="Event Poster">
                <?php else: ?>
                    <div class="no-image">
                        <i class="far fa-image"></i>
                        <span>No visual assets available</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="event-main-content">
                <div class="event-titles">
                    <div class="tag-group" style="margin-bottom: 16px;">
                        <span class="tag tag-type"><?= ucfirst(str_replace('_', ' ', $event['event_type'])) ?></span>
                        <span class="tag tag-status status-<?= $event['status'] ?>"><?= ucfirst($event['status']) ?></span>
                    </div>
                    <h1><?= htmlspecialchars($event['event_title']) ?></h1>
                    <p style="color: var(--text-secondary); font-size: 1.1rem; font-weight: 500;">
                        <i class="fas fa-building" style="margin-right: 8px; color: var(--primary);"></i>
                        <?= htmlspecialchars(isset($event['university_name']) ? $event['university_name'] : 'Academic Institute') ?>
                    </p>
                </div>

                <div class="info-grid">
                    <div class="left-col">
                        <section class="info-section">
                            <h3><i class="fas fa-info-circle"></i> About this Event</h3>
                            <div class="description-box">
                                <?= nl2br(htmlspecialchars($event['description'])) ?>
                            </div>
                        </section>

                        <?php if (isset($event['additional_info']) && !empty($event['additional_info'])): ?>
                            <section class="info-section">
                                <h3><i class="fas fa-plus-circle"></i> Practical Information</h3>
                                <p style="color: var(--text-secondary); line-height: 1.8;">
                                    <?= nl2br(htmlspecialchars($event['additional_info'])) ?>
                                </p>
                            </section>
                        <?php endif; ?>
                    </div>

                    <div class="right-col">
                        <div class="sidebar-stats">
                            <section class="info-section" style="margin-bottom: 0;">
                                <h3><i class="fas fa-map-marker-alt"></i> Logistics</h3>
                                
                                <div class="stat-item">
                                    <span class="item-label">Date</span>
                                    <span class="item-value"><?= !empty($event['event_date']) ? date('F j, Y', strtotime($event['event_date'])) : 'TBD' ?></span>
                                </div>
                                
                                <div class="stat-item">
                                    <span class="item-label">Time</span>
                                    <span class="item-value">
                                        <?= !empty($event['start_time']) ? date('g:i A', strtotime($event['start_time'])) : 'TBD' ?> -
                                        <?= !empty($event['end_time']) ? date('g:i A', strtotime($event['end_time'])) : 'TBD' ?>
                                    </span>
                                </div>

                                <div class="stat-item">
                                    <span class="item-label">Venue</span>
                                    <span class="item-value"><?= htmlspecialchars($event['venue']) ?> (<?= ucfirst($event['mode']) ?>)</span>
                                </div>

                                <?php if (!empty($event['target_amount'])): ?>
                                    <div class="stat-item">
                                        <span class="item-label">Fundraising Goal</span>
                                        <span class="item-value" style="color: var(--primary-dark); font-weight: 700;">
                                            LKR <?= number_format((float) $event['target_amount'], 2) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </section>

                            <hr style="margin: 24px 0; border: none; border-top: 1px solid var(--border);">

                            <section class="info-section" style="margin-bottom: 0;">
                                <h3><i class="fas fa-phone"></i> Direct Contact</h3>
                                <div class="stat-item">
                                    <span class="item-label">Organizer</span>
                                    <span class="item-value"><?= htmlspecialchars(isset($event['organized_by']) ? $event['organized_by'] : 'University Rep') ?></span>
                                </div>
                                <?php if (!empty($event['contact_email'])): ?>
                                    <div class="stat-item">
                                        <span class="item-label">Email Support</span>
                                        <a href="mailto:<?= htmlspecialchars($event['contact_email']) ?>" style="color: var(--primary); font-weight: 600; text-decoration: none; font-size: 0.95rem;">
                                            <?= htmlspecialchars($event['contact_email']) ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="action-bar">
                <?php if (isset($isOwner) && $isOwner): ?>
                    <form action="<?= BASE_URL ?>/university-rep/events/close" method="POST" style="margin: 0;" onsubmit="return confirm('Ensure all processes are finalized before closing.');">
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                        <button type="submit" class="btn btn-primary" <?= ($event['status'] === 'closed') ? 'disabled' : '' ?> style="background: #f59e0b;">
                            <i class="fas fa-lock"></i> Mark as Finalized
                        </button>
                    </form>
                    <button onclick="deleteEvent(<?= $event['id'] ?>)" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Delete Entry
                    </button>
                <?php else: ?>
                    <?php if ($event['status'] === 'approved'): ?>
                        <a href="<?= BASE_URL ?>/donation/event/<?= $event['id'] ?>" class="btn btn-primary">
                            <i class="fas fa-heart"></i> Make a Donation
                        </a>
                        <a href="<?= BASE_URL ?>/donation/request-confirmation/<?= $event['id'] ?>" class="btn btn-outline" style="background: white;">
                            <i class="fas fa-file-invoice-dollar"></i> Request Confirmation
                        </a>
                    <?php else: ?>
                        <div style="background: var(--bg-soft); padding: 12px 24px; border-radius: var(--radius-full); border: 1px solid var(--border); color: var(--text-secondary); font-weight: 600;">
                            <i class="fas fa-info-circle" style="margin-right: 8px;"></i> 
                            This event is currently <?= $event['status'] ?> and not accepting contributions.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <div style="margin-left: auto; font-size: 0.85rem; color: var(--text-secondary);">
                    ID: <?= str_pad($event['id'], 5, '0', STR_PAD_LEFT) ?>
                </div>
            </div>
        </article>
    </div>
</main>

<script>
    function deleteEvent(eventId) {
        if (confirm('CAUTION: This event data will be permanently removed. This action cannot be undone.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= BASE_URL ?>/university-rep/events/delete';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'event_id';
            input.value = eventId;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

</body>
</html>