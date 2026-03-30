<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Event - University Representative | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/style.css">
</head>

<body>
    <?php $isRep = isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'university_representative'; ?>
    <?php if ($isRep): ?>
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
    <?php else: ?>
        <style>
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 2rem !important;
            }

            .topbar {
                display: none !important;
            }

            .content-wrapper {
                max-width: 1200px;
                margin: 0 auto;
                margin-top: 40px;
            }
        </style>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>View Event</h1>
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
                <h2>📅 Event Details</h2>
                <div class="header-actions">
                    <?php if (isset($isOwner) && $isOwner): ?>
                        <a href="<?= BASE_URL ?>/university-rep/events/edit/<?= $event['id'] ?>" class="btn btn-primary">✏️
                            Edit Event</a>
                    <?php endif; ?>
                    <a href="<?= (isset($isOwner) && $isOwner) ? BASE_URL . '/university-rep/events' : BASE_URL . '/' ?>"
                        class="btn btn-secondary">← Back</a>
                </div>
            </div>

            <!-- Event Details Card -->
            <div class="event-details-card">
                <!-- Event Image Banner -->
                <?php if (!empty($event['image_path'])): ?>
                    <div
                        style="width: 100%; text-align: center; background-color: #f8fafc; border-bottom: 1px solid #e5e7eb; padding: 1rem 0;">
                        <img src="<?= BASE_URL . '/' . htmlspecialchars($event['image_path']) ?>" alt="Event Poster"
                            style="max-width: 100%; height: auto; max-height: 400px; display: inline-block;">
                    </div>
                <?php else: ?>
                    <div
                        style="width: 100%; height: 200px; background: #f8fafc; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #9ca3af;">
                        <span style="font-size: 4rem;">📸</span>
                        <span style="font-size: 1rem; margin-top: 0.5rem;">No Image Available</span>
                    </div>
                <?php endif; ?>

                <!-- Event Header -->
                <div class="event-header">
                    <div class="event-title-section">
                        <h1><?= htmlspecialchars($event['event_title']) ?></h1>
                        <div class="event-meta">
                            <span class="event-type">🎯
                                <?= ucfirst(str_replace('_', ' ', $event['event_type'])) ?></span>
                            <span
                                class="event-status status-<?= $event['status'] ?>"><?= ucfirst($event['status']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Event Information Grid -->
                <div class="event-info-grid">
                    <!-- Basic Details -->
                    <div class="info-section">
                        <h3>📋 Basic Information</h3>
                        <div class="info-item">
                            <label>University:</label>
                            <p><?= htmlspecialchars($event['university_name'] ?? 'Not Specified') ?></p>
                        </div>
                        <div class="info-item">
                            <label>Description:</label>
                            <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                        </div>
                        <div class="info-item">
                            <label>Target Amount:</label>
                            <p><?= $event['target_amount'] ? '$' . number_format((float) $event['target_amount'], 2) : 'Not specified or N/A' ?>
                            </p>
                        </div>
                        <div class="info-item">
                            <label>Organized By:</label>
                            <p><?= htmlspecialchars($event['organized_by']) ?></p>
                        </div>
                        <div class="info-item">
                            <label>Target Audience:</label>
                            <p>
                                <?php
                                $ta = $event['target_audience'] ?? null;
                                if (!empty($ta)) {
                                    if (is_string($ta)) {
                                        // Attempt JSON decode if it looks like a JSON array
                                        if (strpos(trim($ta), '[') === 0 && ($decoded = json_decode($ta, true))) {
                                            $ta = $decoded;
                                        } else {
                                            $ta = explode(',', $ta);
                                        }
                                    }

                                    if (is_array($ta)) {
                                        echo htmlspecialchars(implode(', ', array_map('ucfirst', array_map('trim', $ta))));
                                    } else {
                                        echo htmlspecialchars(ucfirst(trim($ta)));
                                    }
                                } else {
                                    echo "Not specified";
                                }
                                ?>
                            </p>
                        </div>
                        <div class="info-item">
                            <label>Accessibility:</label>
                            <p><?= $event['open_for'] === 'all_universities' ? 'Open to All Universities' : 'Specific University Students Only' ?>
                            </p>
                        </div>
                    </div>

                    <!-- Event Logistics -->
                    <div class="info-section">
                        <h3>📅 Event Logistics</h3>
                        <div class="info-item">
                            <label>Date:</label>
                            <p><?= date('F j, Y', strtotime($event['event_date'])) ?></p>
                        </div>
                        <div class="info-item">
                            <label>Time:</label>
                            <p><?= date('g:i A', strtotime($event['start_time'])) ?> -
                                <?= date('g:i A', strtotime($event['end_time'])) ?>
                            </p>
                        </div>
                        <div class="info-item">
                            <label>Venue:</label>
                            <p><?= htmlspecialchars($event['venue']) ?></p>
                        </div>
                        <div class="info-item">
                            <label>Mode:</label>
                            <p><?= ucfirst($event['mode']) ?> Event</p>
                        </div>
                        <?php if ($event['max_participants']): ?>
                            <div class="info-item">
                                <label>Maximum Participants:</label>
                                <p><?= htmlspecialchars($event['max_participants']) ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($event['registration_deadline']): ?>
                            <div class="info-item">
                                <label>Registration Deadline:</label>
                                <p><?= date('F j, Y', strtotime($event['registration_deadline'])) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Contact Information -->
                    <?php if ($event['contact_person'] || $event['contact_email'] || $event['contact_phone']): ?>
                        <div class="info-section">
                            <h3>📞 Contact Information</h3>
                            <?php if ($event['contact_person']): ?>
                                <div class="info-item">
                                    <label>Contact Person:</label>
                                    <p><?= htmlspecialchars($event['contact_person']) ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if ($event['contact_email']): ?>
                                <div class="info-item">
                                    <label>Email:</label>
                                    <p><a
                                            href="mailto:<?= htmlspecialchars($event['contact_email']) ?>"><?= htmlspecialchars($event['contact_email']) ?></a>
                                    </p>
                                </div>
                            <?php endif; ?>
                            <?php if ($event['contact_phone']): ?>
                                <div class="info-item">
                                    <label>Phone:</label>
                                    <p><a
                                            href="tel:<?= htmlspecialchars($event['contact_phone']) ?>"><?= htmlspecialchars($event['contact_phone']) ?></a>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Additional Information -->
                    <?php if ($event['additional_info']): ?>
                        <div class="info-section">
                            <h3>ℹ️ Additional Information</h3>
                            <div class="info-item">
                                <p><?= nl2br(htmlspecialchars($event['additional_info'])) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Event Metadata -->
                    <div class="info-section">
                        <h3>📊 Event Metadata</h3>
                        <div class="info-item">
                            <label>Created:</label>
                            <p><?= date('F j, Y \a\t g:i A', strtotime($event['created_at'])) ?></p>
                        </div>
                        <div class="info-item">
                            <label>Last Updated:</label>
                            <p><?= date('F j, Y \a\t g:i A', strtotime($event['updated_at'])) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="event-actions">
                    <?php if (isset($isOwner) && $isOwner): ?>
                        <a href="<?= BASE_URL ?>/university-rep/events/edit/<?= $event['id'] ?>" class="btn btn-primary">✏️
                            Edit Event</a>
                        <?php if ($event['status'] !== 'closed'): ?>
                            <form action="<?= BASE_URL ?>/university-rep/events/close" method="POST"
                                style="margin: 0; display: inline-block;"
                                onsubmit="return confirm('Are you sure you want to close this event?');">
                                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                <button type="submit" class="btn btn-secondary" style="background: #f59e0b;">🔒 Mark as
                                    Closed</button>
                            </form>
                        <?php endif; ?>
                        <button onclick="deleteEvent(<?= $event['id'] ?>)" class="btn btn-danger">🗑️ Delete Event</button>
                    <?php else: ?>
                        <!-- Public Buttons -->
                        <?php if ($event['status'] === 'approved'): ?>
                            <button class="btn btn-primary" onclick="alert('Donation functionality coming soon!')">💖
                                Donate</button>
                            <button class="btn btn-secondary" onclick="alert('Payment confirmation feature coming soon!')">📝
                                Request Confirmation</button>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a href="<?= (isset($isOwner) && $isOwner) ? BASE_URL . '/university-rep/events' : BASE_URL . '/' ?>"
                        class="btn btn-secondary">← Back</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .event-details-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .event-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
        }

        .event-title-section h1 {
            font-size: 2rem;
            margin: 0 0 1rem 0;
            font-weight: 600;
        }

        .event-meta {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .event-type {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .event-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .status-published {
            background: #10b981;
            color: white;
        }

        .status-draft {
            background: #f59e0b;
            color: white;
        }

        .status-cancelled {
            background: #ef4444;
            color: white;
        }

        .event-info-grid {
            padding: 2rem;
            display: grid;
            gap: 2rem;
        }

        .info-section h3 {
            color: #374151;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.5rem;
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-item label {
            font-weight: 600;
            color: #6b7280;
            display: block;
            margin-bottom: 0.25rem;
        }

        .info-item p {
            color: #374151;
            margin: 0;
            line-height: 1.5;
        }

        .info-item a {
            color: #3b82f6;
            text-decoration: none;
        }

        .info-item a:hover {
            text-decoration: underline;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .event-actions {
            padding: 1.5rem 2rem;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }
    </style>

    <script>
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
    </script>
</body>

</html>