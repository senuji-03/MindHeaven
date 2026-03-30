<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - University Representative | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/style.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>University Representative</p>
        </div>

        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/university-rep/dashboard" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item active">
                <span class="icon">📅</span>
                Manage Events
            </a>
            <a href="<?= BASE_URL ?>/university-rep/announcements" class="nav-item">
                <span class="icon">📰</span>
                Announcements
            </a>
            <a href="<?= BASE_URL ?>/university-rep/resources" class="nav-item">
                <span class="icon">📚</span>
                Resources
            </a>
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <span class="icon">🏫</span>
                University Profile
            </a>
            <a href="<?= BASE_URL ?>/university-rep/analytics" class="nav-item">
                <span class="icon">📈</span>
                Analytics
            </a>
            <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item">
                <span class="icon">👤</span>
                My Profile
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Manage Events</h1>
            <div class="topbar-right">
                <div class="notification-icon">
                    🔔
                    <span class="badge">2</span>
                </div>
                <div class="user-profile">
                    <span>Rep Name</span>
                    <div class="avatar">R</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <div class="page-header">
                <h2>📅 Mental Health Events & Workshops</h2>
                <a href="<?= BASE_URL ?>/university-rep/events/create" class="btn btn-primary">➕ Create New Event</a>
            </div>

            <!-- Filter Section -->
            <div class="section-card">
                <div class="filter-bar">
                    <input type="text" placeholder="Search events..." class="search-input" id="searchEvents">
                    <select class="filter-select">
                        <option value="">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                        <option value="archived">Archived</option>
                        <option value="pending_approval">Pending Approval</option>
                    </select>
                    <select class="filter-select">
                        <option value="">All Types</option>
                        <option value="workshop">Workshop</option>
                        <option value="seminar">Seminar</option>
                        <option value="campaign">Campaign</option>
                        <option value="talk">Talk</option>
                    </select>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="events-grid">
                <?php if (isset($events) && !empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <div class="event-card">
                            <div class="event-image"
                                style="background-color: #f8fafc; text-align: center; display: flex; align-items: center; justify-content: center; overflow: hidden; height: 200px;">
                                <?php if (!empty($event['image_path'])): ?>
                                    <img src="<?= BASE_URL . '/' . htmlspecialchars($event['image_path']) ?>" alt="Event Poster"
                                        style="max-width: 100%; max-height: 100%; height: auto; display: block; margin: 0 auto; object-fit: contain;">
                                <?php else: ?>
                                    <div style="color: #9ca3af; display: flex; flex-direction: column; align-items: center;">
                                        <span style="font-size: 3rem;">📸</span>
                                        <span style="font-size: 0.875rem; margin-top: 0.5rem;">No Image</span>
                                    </div>
                                <?php endif; ?>
                                <div class="event-status <?= htmlspecialchars($event['status']) ?>">
                                    <?= ucfirst(htmlspecialchars($event['status'])) ?>
                                </div>
                            </div>
                            <div class="event-content">
                                <h3><?= htmlspecialchars($event['event_title']) ?></h3>
                                <p class="event-type">🎯
                                    <?= ucfirst(str_replace('_', ' ', htmlspecialchars($event['event_type']))) ?></p>
                                <p class="event-date">📅 <?= date('F j, Y', strtotime($event['event_date'])) ?> |
                                    <?= date('g:i A', strtotime($event['start_time'])) ?> -
                                    <?= date('g:i A', strtotime($event['end_time'])) ?></p>
                                <p class="event-venue">📍 <?= htmlspecialchars($event['venue']) ?></p>
                                <p class="event-mode"><?= ucfirst(htmlspecialchars($event['mode'])) ?> Event</p>
                                <?php if ($event['max_participants']): ?>
                                    <p class="event-participants">👥 Max: <?= htmlspecialchars($event['max_participants']) ?>
                                        participants</p>
                                <?php endif; ?>
                                <div class="event-stats">
                                    <span>📅 Created: <?= date('M j, Y', strtotime($event['created_at'])) ?></span>
                                    <?php if ($event['organized_by']): ?>
                                        <span>🏢 <?= htmlspecialchars($event['organized_by']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="event-actions">
                                <button class="btn-icon btn-view" title="View"
                                    onclick="viewEvent(<?= $event['id'] ?>)">👁️</button>
                                <button class="btn-icon btn-edit" title="Edit"
                                    onclick="editEvent(<?= $event['id'] ?>)">✏️</button>
                                <button class="btn-icon btn-delete" title="Delete"
                                    onclick="deleteEvent(<?= $event['id'] ?>)">🗑️</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-events">
                        <div class="no-events-icon">📅</div>
                        <h3>No Events Found</h3>
                        <p>You haven't created any events yet. Start by creating your first event!</p>
                        <a href="<?= BASE_URL ?>/university-rep/events/create" class="btn btn-primary">Create Your First
                            Event</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Empty State (Show when no events) -->
            <div class="empty-state" style="display: none;">
                <div class="empty-icon">📅</div>
                <h3>No Events Yet</h3>
                <p>Create your first mental health event or workshop</p>
                <a href="<?= BASE_URL ?>/university-rep/events/create" class="btn btn-primary">Create Event</a>
            </div>
        </div>
    </div>

    <style>
        .no-events {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 2px dashed #cbd5e1;
        }

        .no-events-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .no-events h3 {
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .no-events p {
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .event-participants {
            color: #64748b;
            font-size: 0.875rem;
            margin: 0.25rem 0;
        }

        .event-mode {
            color: #3b82f6;
            font-size: 0.875rem;
            margin: 0.25rem 0;
        }
    </style>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js"></script>
    <script>
        function viewEvent(eventId) {
            // Redirect to view event page (you can create this later)
            window.open('<?= BASE_URL ?>/university-rep/events/view/' + eventId, '_blank');
        }

        function editEvent(eventId) {
            // Redirect to edit event page
            window.location.href = '<?= BASE_URL ?>/university-rep/events/edit/' + eventId;
        }

        function deleteEvent(eventId) {
            if (confirm('Are you sure you want to delete this event? This action cannot be undone.')) {
                // Create a form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?= BASE_URL ?>/university-rep/events/delete';

                const eventIdInput = document.createElement('input');
                eventIdInput.type = 'hidden';
                eventIdInput.name = 'event_id';
                eventIdInput.value = eventId;

                form.appendChild(eventIdInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Search functionality
        document.getElementById('searchEvents').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const eventCards = document.querySelectorAll('.event-card');

            eventCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>