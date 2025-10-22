<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - University Representative | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/forms.css">
</head>
<body>
    <!-- Sidebar (Same as dashboard) -->
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
            <h1>Edit Event</h1>
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
                <h2>📅 Edit Mental Health Event</h2>
                <a href="<?= BASE_URL ?>/university-rep/events" class="btn btn-secondary">← Back to Events</a>
            </div>

            <!-- Event Edit Form -->
            <form method="POST" action="<?= BASE_URL ?>/university-rep/events/update" enctype="multipart/form-data" class="event-form">
                <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['id']) ?>">
                
                <!-- Section 1: Basic Event Details -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">🧾</span>
                        <h3>Basic Event Details</h3>
                    </div>

                    <div class="form-row">
                        <label for="event_title">Event Title *</label>
                        <input type="text" id="event_title" name="event_title" required 
                               value="<?= htmlspecialchars($event['event_title']) ?>"
                               placeholder="e.g., Stress Relief Workshop 2025" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="event_type">Event Type *</label>
                        <select id="event_type" name="event_type" required class="form-input">
                            <option value="">Select Event Type</option>
                            <option value="awareness_program" <?= $event['event_type'] === 'awareness_program' ? 'selected' : '' ?>>Awareness Program</option>
                            <option value="workshop" <?= $event['event_type'] === 'workshop' ? 'selected' : '' ?>>Workshop</option>
                            <option value="talk" <?= $event['event_type'] === 'talk' ? 'selected' : '' ?>>Talk</option>
                            <option value="campaign" <?= $event['event_type'] === 'campaign' ? 'selected' : '' ?>>Campaign</option>
                            <option value="seminar" <?= $event['event_type'] === 'seminar' ? 'selected' : '' ?>>Seminar</option>
                            <option value="other" <?= $event['event_type'] === 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" required rows="5" 
                                  placeholder="Detailed explanation of the event and its purpose..." class="form-input"><?= htmlspecialchars($event['description']) ?></textarea>
                    </div>

                    <div class="form-row">
                        <label for="organized_by">Organized By *</label>
                        <input type="text" id="organized_by" name="organized_by" required 
                               value="<?= htmlspecialchars($event['organized_by']) ?>"
                               placeholder="e.g., Faculty / Department / Student Union / Counseling Unit" class="form-input">
                    </div>

                    <div class="form-row">
                        <label>Target Audience *</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="target_audience[]" value="undergraduates" 
                                       <?= in_array('undergraduates', $event['target_audience']) ? 'checked' : '' ?>>
                                Undergraduates
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="target_audience[]" value="staff"
                                       <?= in_array('staff', $event['target_audience']) ? 'checked' : '' ?>>
                                Staff
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="target_audience[]" value="all_students"
                                       <?= in_array('all_students', $event['target_audience']) ? 'checked' : '' ?>>
                                All Students
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="target_audience[]" value="specific_faculty"
                                       <?= in_array('specific_faculty', $event['target_audience']) ? 'checked' : '' ?>>
                                Specific Faculty
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="open_for">Open For *</label>
                        <select id="open_for" name="open_for" required class="form-input">
                            <option value="">Select Accessibility</option>
                            <option value="all_universities" <?= $event['open_for'] === 'all_universities' ? 'selected' : '' ?>>Open to All Universities</option>
                            <option value="specific_university" <?= $event['open_for'] === 'specific_university' ? 'selected' : '' ?>>Specific University Students Only</option>
                        </select>
                    </div>
                </div>

                <!-- Section 2: Event Logistics -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">📅</span>
                        <h3>Event Logistics</h3>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="event_date">Date *</label>
                            <input type="date" id="event_date" name="event_date" required 
                                   value="<?= htmlspecialchars($event['event_date']) ?>" class="form-input">
                        </div>

                        <div class="form-row">
                            <label for="start_time">Start Time *</label>
                            <input type="time" id="start_time" name="start_time" required 
                                   value="<?= htmlspecialchars($event['start_time']) ?>" class="form-input">
                        </div>

                        <div class="form-row">
                            <label for="end_time">End Time *</label>
                            <input type="time" id="end_time" name="end_time" required 
                                   value="<?= htmlspecialchars($event['end_time']) ?>" class="form-input">
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="venue">Venue *</label>
                        <input type="text" id="venue" name="venue" required 
                               value="<?= htmlspecialchars($event['venue']) ?>"
                               placeholder="e.g., Main Auditorium / Zoom Meeting / Hybrid" class="form-input">
                    </div>

                    <div class="form-row">
                        <label>Mode *</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="mode" value="on_site" required
                                       <?= $event['mode'] === 'on_site' ? 'checked' : '' ?>>
                                On-site
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="mode" value="online"
                                       <?= $event['mode'] === 'online' ? 'checked' : '' ?>>
                                Online
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="mode" value="hybrid"
                                       <?= $event['mode'] === 'hybrid' ? 'checked' : '' ?>>
                                Hybrid
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="max_participants">Maximum Participants</label>
                        <input type="number" id="max_participants" name="max_participants" 
                               value="<?= htmlspecialchars($event['max_participants']) ?>"
                               placeholder="e.g., 50" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="registration_deadline">Registration Deadline</label>
                        <input type="date" id="registration_deadline" name="registration_deadline" 
                               value="<?= htmlspecialchars($event['registration_deadline']) ?>" class="form-input">
                    </div>
                </div>

                <!-- Section 3: Contact Information -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">📞</span>
                        <h3>Contact Information</h3>
                    </div>

                    <div class="form-row">
                        <label for="contact_person">Contact Person</label>
                        <input type="text" id="contact_person" name="contact_person" 
                               value="<?= htmlspecialchars($event['contact_person']) ?>"
                               placeholder="e.g., Dr. Jane Smith" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="contact_email">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" 
                               value="<?= htmlspecialchars($event['contact_email']) ?>"
                               placeholder="contact@university.edu" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="contact_phone">Contact Phone</label>
                        <input type="tel" id="contact_phone" name="contact_phone" 
                               value="<?= htmlspecialchars($event['contact_phone']) ?>"
                               placeholder="+94 11 123 4567" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="additional_info">Additional Information</label>
                        <textarea id="additional_info" name="additional_info" rows="3" 
                                  placeholder="Any additional details or special instructions..." class="form-input"><?= htmlspecialchars($event['additional_info']) ?></textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" onclick="history.back()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js"></script>
    <script>
        // Form validation
        document.querySelector('.event-form').addEventListener('submit', function(e) {
            // Check if at least one target audience is selected
            const checkboxes = document.querySelectorAll('input[name="target_audience[]"]:checked');
            if (checkboxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one target audience!');
                return false;
            }

            return true;
        });
    </script>
</body>
</html>
