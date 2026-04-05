<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - University Representative | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/university-rep/forms.css">
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
                <span class="icon">📊</span> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item active">
                <span class="icon">📅</span> Manage Events
            </a>
            <a href="<?= BASE_URL ?>/university-rep/announcements" class="nav-item">
                <span class="icon">📰</span> Announcements
            </a>
            <a href="<?= BASE_URL ?>/university-rep/resources" class="nav-item">
                <span class="icon">📚</span> Resources
            </a>

            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <span class="icon">🏫</span> University Profile
            </a>
            <a href="<?= BASE_URL ?>/university-rep/analytics" class="nav-item">
                <span class="icon">📈</span> Analytics
            </a>

            <a href="<?= BASE_URL ?>/university-rep/profile" class="nav-item">
                <span class="icon">👤</span> My Profile
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h1>Create New Event</h1>
            <div class="topbar-right">
                <div class="notification-icon">🔔<span class="badge">2</span></div>
                <div class="user-profile"><span>Rep Name</span>
                    <div class="avatar">R</div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="page-header">
                <h2>📅 Create Mental Health Event</h2>
                <a href="<?= BASE_URL ?>/university-rep/events" class="btn btn-secondary">← Back to Events</a>
            </div>

            <!-- Event Creation Form -->
            <form method="POST" action="<?= BASE_URL ?>/university-rep/events/store" enctype="multipart/form-data"
                class="event-form">

                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">🧾</span>
                        <h3>Basic Event Details</h3>
                    </div>

                    <div class="form-row">
                        <label for="event_title">Event Title *</label>
                        <input type="text" id="event_title" name="event_title" required
                            placeholder="e.g., Mental Health Fundraiser" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="event_type">Event Type *</label>
                        <select id="event_type" name="event_type" required class="form-input">
                            <option value="">Select Event Type</option>
                            <option value="awareness_program">Awareness Program</option>
                            <option value="workshop">Workshop</option>
                            <option value="talk">Talk</option>
                            <option value="campaign">Campaign</option>
                            <option value="seminar">Seminar</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label for="short_description">Short Description (Optional)</label>
                        <input type="text" id="short_description" name="short_description"
                            placeholder="Brief summary for the card view" class="form-input" maxlength="255">
                    </div>

                    <div class="form-row">
                        <label for="description">Full Description *</label>
                        <textarea id="description" name="description" required rows="5"
                            placeholder="Detailed explanation of the event..." class="form-input"></textarea>
                    </div>

                    <div class="form-row">
                        <label for="target_amount">Target Amount (Optional, for fundraisers)</label>
                        <input type="number" id="target_amount" name="target_amount" step="0.01" min="0"
                            placeholder="e.g., 1000.00" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="organized_by">Organized By (Optional)</label>
                        <input type="text" id="organized_by" name="organized_by" placeholder="e.g., Psychology Dept"
                            class="form-input">
                    </div>

                    <div class="form-row">
                        <label>Target Audience (Optional)</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label"><input type="checkbox" name="target_audience[]"
                                    value="undergraduates"> Undergraduates</label>
                            <label class="checkbox-label"><input type="checkbox" name="target_audience[]" value="staff">
                                Staff</label>
                            <label class="checkbox-label"><input type="checkbox" name="target_audience[]"
                                    value="all_students"> All Students</label>
                            <label class="checkbox-label"><input type="checkbox" name="target_audience[]"
                                    value="specific_faculty"> Specific Faculty</label>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="open_for">Open For *</label>
                        <select id="open_for" name="open_for" required class="form-input">
                            <option value="">Select Accessibility</option>
                            <option value="all_universities">Open to All Universities</option>
                            <option value="specific_university">Specific University Students Only</option>
                        </select>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">📅</span>
                        <h3>Event Logistics</h3>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="event_date">Date *</label>
                            <input type="date" id="event_date" name="event_date" required class="form-input">
                        </div>
                        <div class="form-row">
                            <label for="start_time">Start Time (Optional)</label>
                            <input type="time" id="start_time" name="start_time" class="form-input">
                        </div>
                        <div class="form-row">
                            <label for="end_time">End Time (Optional)</label>
                            <input type="time" id="end_time" name="end_time" class="form-input">
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="venue">Venue *</label>
                        <input type="text" id="venue" name="venue" required placeholder="e.g., Main Auditorium / Zoom"
                            class="form-input">
                    </div>

                    <div class="form-row">
                        <label>Mode *</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="mode" value="on_site" required>
                                On-site</label>
                            <label class="radio-label"><input type="radio" name="mode" value="online"> Online</label>
                            <label class="radio-label"><input type="radio" name="mode" value="hybrid"> Hybrid</label>
                        </div>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="max_participants">Maximum Participants (Optional)</label>
                            <input type="number" id="max_participants" name="max_participants" placeholder="e.g., 50"
                                class="form-input">
                        </div>
                        <div class="form-row">
                            <label for="registration_deadline">Registration Deadline (Optional)</label>
                            <input type="date" id="registration_deadline" name="registration_deadline"
                                class="form-input">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">📞</span>
                        <h3>Contact Information & Media</h3>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="contact_person">Contact Person (Optional)</label>
                            <input type="text" id="contact_person" name="contact_person" placeholder="e.g., Jane Doe"
                                class="form-input">
                        </div>
                        <div class="form-row">
                            <label for="contact_email">Contact Email (Optional)</label>
                            <input type="email" id="contact_email" name="contact_email" placeholder="email@example.com"
                                class="form-input">
                        </div>
                        <div class="form-row">
                            <label for="contact_phone">Contact Phone (Optional)</label>
                            <input type="tel" id="contact_phone" name="contact_phone" placeholder="+1234567890"
                                class="form-input">
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="additional_info">Additional Information (Optional)</label>
                        <textarea id="additional_info" name="additional_info" rows="3"
                            placeholder="Any extra instructions..." class="form-input"></textarea>
                    </div>

                    <div class="form-row">
                        <label for="event_poster">Event Image / Poster Upload *</label>
                        <input type="file" id="event_poster" name="event_poster" accept="image/jpeg,image/png,image/jpg"
                            required class="form-input">
                        <small>Upload promotional image or poster (JPG/PNG, Max 5MB)</small>
                    </div>

                    <div class="info-box"
                        style="margin-top: 20px; background: #e0e7ff; padding: 10px; border-radius: 5px;">
                        <strong>ℹ️ Note:</strong> This event will be submitted as "Pending" for admin approval before
                        appearing publicly.
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="history.back()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit for Approval</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js"></script>
    <script>
        document.querySelector('.event-form').addEventListener('submit', function (e) {
            const poster = document.getElementById('event_poster');
            if (poster.files.length > 0) {
                const fileSize = poster.files[0].size / 1024 / 1024;
                if (fileSize > 5) {
                    e.preventDefault();
                    alert('Event poster must be less than 5MB!');
                    return false;
                }
            }
            return true;
        });
    </script>
</body>

</html>