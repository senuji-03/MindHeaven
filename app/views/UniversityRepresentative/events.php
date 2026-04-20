<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - University Representative | MindHeaven</title>

    <!-- Fonts and Icons (Design System §2, §15) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ── Design System Tokens (§1) ── */
        :root {
            --primary:        #3D8B6E;
            --primary-light:  #6BB89A;
            --primary-dark:   #2A6B52;
            --accent-warm:    #E8A87C;
            --accent-calm:    #A8C5DA;
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

        /* ── Sidebar (§10 Sidebar Pattern) ── */
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

        /* ── Alerts (§7 Card variant) ── */
        .alert-container { margin-bottom: 24px; }
        .alert {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 20px;
            border-radius: var(--radius-md);
            font-weight: 600; font-size: 0.93rem;
            margin-bottom: 12px;
        }
        .alert-success { background: #E8F5E9; color: #2E7D32; border: 1px solid #C8E6C9; }
        .alert-error   { background: #FFEBEE; color: #C62828; border: 1px solid #FFCDD2; }
        .alert-close { background: none; border: none; cursor: pointer; font-size: 1.1rem; margin-left: auto; opacity: 0.6; }
        .alert-close:hover { opacity: 1; }

        /* ── Page Header ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 28px;
        }
        .page-header h2 { font-size: 1.35rem; font-weight: 700; color: var(--text-primary); }

        /* ── Primary Button (§6) ── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 8px; padding: 10px 22px;
            border-radius: var(--radius-full);
            font-family: inherit; font-weight: 600; font-size: 0.88rem;
            cursor: pointer; border: none;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(61,139,110,0.3);
        }

        /* ── Filter Bar ── */
        .filter-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px 24px;
            margin-bottom: 28px;
            box-shadow: var(--shadow-sm);
        }
        .filter-bar { display: flex; gap: 16px; flex-wrap: wrap; align-items: center; }
        .search-input, .filter-select {
            padding: 10px 16px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit; font-size: 0.9rem;
            color: var(--text-primary);
            background: var(--surface);
            transition: border-color 0.25s, box-shadow 0.25s;
        }
        .search-input { flex: 1; min-width: 200px; }
        .search-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(61,139,110,0.12);
        }

        /* ── Events Grid (§9) ── */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        /* ── Event Card (§7) ── */
        .event-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            display: flex; flex-direction: column;
        }
        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        .event-image {
            height: 180px;
            background: var(--bg-mid);
            position: relative;
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .event-image img {
            max-width: 100%; max-height: 100%;
            object-fit: contain;
        }
        .no-image-placeholder {
            display: flex; flex-direction: column; align-items: center;
            color: var(--text-secondary);
        }
        .no-image-placeholder i { font-size: 2.5rem; opacity: 0.3; }
        .no-image-placeholder span { font-size: 0.8rem; margin-top: 8px; opacity: 0.5; }

        .event-status {
            position: absolute; top: 12px; right: 12px;
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .event-status.pending   { background: #FFF3E0; color: #EF6C00; }
        .event-status.approved  { background: #E8F5E9; color: #2E7D32; }
        .event-status.rejected  { background: #FFEBEE; color: #C62828; }
        .event-status.closed    { background: #ECEFF1; color: #546E7A; }
        .event-status.cancelled { background: #FCE4EC; color: #880E4F; }

        .event-content { padding: 20px 24px; flex: 1; }
        .event-content h3 {
            font-size: 1.05rem; font-weight: 700;
            color: var(--text-primary); margin-bottom: 10px;
            line-height: 1.4;
        }
        .event-meta-row {
            display: flex; align-items: center; gap: 6px;
            font-size: 0.83rem; color: var(--text-secondary);
            margin-bottom: 5px;
        }
        .event-meta-row i { color: var(--primary); width: 14px; }
        .event-mode-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.78rem; font-weight: 600;
            padding: 3px 10px;
            border-radius: var(--radius-full);
            background: var(--bg-mid); color: var(--primary);
            margin-top: 8px;
        }

        .event-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: var(--bg-soft);
        }
        .event-created { font-size: 0.78rem; color: var(--text-secondary); }
        .event-actions { display: flex; gap: 8px; }

        .btn-icon {
            width: 34px; height: 34px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .btn-view:hover  { border-color: var(--primary); color: var(--primary); background: var(--bg-mid); }
        .btn-edit:hover  { border-color: var(--accent-warm); color: var(--accent-warm); background: #FFF8F3; }
        .btn-delete:hover{ border-color: var(--crisis); color: var(--crisis); background: #FFF0F0; }

        /* ── No Events State ── */
        .no-events {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 40px;
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 2px dashed var(--border);
        }
        .no-events i { font-size: 3rem; color: var(--primary-light); opacity: 0.4; margin-bottom: 16px; }
        .no-events h3 { font-size: 1.15rem; color: var(--text-primary); margin-bottom: 8px; }
        .no-events p  { color: var(--text-secondary); margin-bottom: 24px; font-size: 0.9rem; }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
            .content-wrapper { padding: 24px 20px; }
            .events-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php 
    $activePage = 'events';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <?php 
        $topbarTitle = 'Manage Events';
        include '_topbar.php'; 
        ?>

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

            <!-- Page Header -->
            <div class="page-header">
                <h2><i class="fas fa-calendar-alt" style="color:var(--primary);margin-right:10px;"></i>Mental Health Events &amp; Workshops</h2>
                <a href="<?= BASE_URL ?>/university-rep/events/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Event
                </a>
            </div>

            <!-- Filter Bar -->
            <div class="filter-card">
                <div class="filter-bar">
                    <input type="text" placeholder="Search events..." class="search-input" id="searchEvents">
                    <select class="filter-select" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="closed">Closed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="events-grid">
                <?php if (isset($events) && !empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <div class="event-card">
                            <div class="event-image">
                                <?php if (!empty($event['image_path'])): ?>
                                    <img src="<?= BASE_URL . '/' . htmlspecialchars($event['image_path']) ?>" alt="Event Poster">
                                <?php else: ?>
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-image"></i>
                                        <span>No Image</span>
                                    </div>
                                <?php endif; ?>
                                <div class="event-status <?= htmlspecialchars($event['status']) ?>">
                                    <?= ucfirst(htmlspecialchars($event['status'])) ?>
                                </div>
                            </div>

                            <div class="event-content">
                                <h3><?= htmlspecialchars($event['event_title']) ?></h3>
                                <div class="event-meta-row">
                                    <i class="fas fa-tag"></i>
                                    <span><?= ucfirst(str_replace('_', ' ', htmlspecialchars($event['event_type']))) ?></span>
                                </div>
                                <div class="event-meta-row">
                                    <i class="fas fa-calendar-day"></i>
                                    <span><?= date('F j, Y', strtotime($event['event_date'])) ?></span>
                                </div>
                                <div class="event-meta-row">
                                    <i class="fas fa-clock"></i>
                                    <span><?= date('g:i A', strtotime($event['start_time'])) ?> – <?= date('g:i A', strtotime($event['end_time'])) ?></span>
                                </div>
                                <div class="event-meta-row">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?= htmlspecialchars($event['venue']) ?></span>
                                </div>
                                <?php if ($event['max_participants']): ?>
                                    <div class="event-meta-row">
                                        <i class="fas fa-users"></i>
                                        <span>Max: <?= htmlspecialchars($event['max_participants']) ?> participants</span>
                                    </div>
                                <?php endif; ?>
                                <span class="event-mode-badge">
                                    <i class="fas fa-<?= $event['mode'] === 'online' ? 'video' : 'building' ?>"></i>
                                    <?= ucfirst(htmlspecialchars($event['mode'])) ?> Event
                                </span>
                            </div>

                            <div class="event-footer">
                                <span class="event-created">
                                    <i class="fas fa-calendar-plus" style="margin-right:4px;"></i>
                                    <?= date('M j, Y', strtotime($event['created_at'])) ?>
                                </span>
                                <div class="event-actions">
                                    <button class="btn-icon btn-view" title="View" onclick="viewEvent(<?= $event['id'] ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-icon btn-edit" title="Edit" onclick="editEvent(<?= $event['id'] ?>)">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn-icon btn-delete" title="Delete" onclick="deleteEvent(<?= $event['id'] ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-events">
                        <i class="fas fa-calendar-times"></i>
                        <h3>No Events Found</h3>
                        <p>You haven't created any events yet. Start by creating your first mental health event!</p>
                        <a href="<?= BASE_URL ?>/university-rep/events/create" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Your First Event
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js?v=<?= time() ?>"></script>
    <script>
        function viewEvent(eventId) {
            window.open('<?= BASE_URL ?>/university-rep/events/view/' + eventId, '_blank');
        }
        function editEvent(eventId) {
            window.location.href = '<?= BASE_URL ?>/university-rep/events/edit/' + eventId;
        }
        function deleteEvent(eventId) {
            if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= BASE_URL ?>/university-rep/events/delete';
                const input = document.createElement('input');
                input.type = 'hidden'; input.name = 'event_id'; input.value = eventId;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Live search + status filter
        const searchInput = document.getElementById('searchEvents');
        const filterStatus = document.getElementById('filterStatus');
        const cards = document.querySelectorAll('.event-card');

        function filterCards() {
            const q = searchInput.value.toLowerCase();
            const s = filterStatus.value.toLowerCase();
            cards.forEach(card => {
                const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const statusEl = card.querySelector('.event-status');
                const status = statusEl?.textContent.trim().toLowerCase() || '';
                const matchQ = !q || title.includes(q);
                const matchS = !s || status === s;
                card.closest('.event-card').style.display = matchQ && matchS ? '' : 'none';
            });
        }
        searchInput.addEventListener('input', filterCards);
        filterStatus.addEventListener('change', filterCards);
    </script>
</body>
</html>