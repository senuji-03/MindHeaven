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
           
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item">
                <span class="icon">🏫</span>
                University Profile
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
            <h1>Create New Event</h1>
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
                <h2>📅 Create Mental Health Event</h2>
                <a href="<?= BASE_URL ?>/university-rep/events" class="btn btn-secondary">← Back to Events</a>
            </div>

            <!-- Event Creation Form -->
            <form method="POST" action="<?= BASE_URL ?>/university-rep/events/store" enctype="multipart/form-data" class="event-form">
                
                <!-- Section 1: Basic Event Details -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">🧾</span>
                        <h3>Basic Event Details</h3>
                    </div>

                    <div class="form-row">
                        <label for="event_title">Event Title *</label>
                        <input type="text" id="event_title" name="event_title" required 
                               placeholder="e.g., Stress Relief Workshop 2025" class="form-input">
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
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" required rows="5" 
                                  placeholder="Detailed explanation of the event and its purpose..." class="form-input"></textarea>
                    </div>

                    <div class="form-row">
                        <label for="organized_by">Organized By *</label>
                        <input type="text" id="organized_by" name="organized_by" required 
                               placeholder="e.g., Faculty / Department / Student Union / Counseling Unit" class="form-input">
                    </div>

                    <div class="form-row">
                        <label>Target Audience *</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="target_audience[]" value="undergraduates">
                                Undergraduates
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="target_audience[]" value="staff">
                                Staff
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="target_audience[]" value="all_students">
                                All Students
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="target_audience[]" value="specific_faculty">
                                Specific Faculty
                            </label>
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

                <!-- Section 2: Event Logistics -->
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
                            <label for="start_time">Start Time *</label>
                            <input type="time" id="start_time" name="start_time" required class="form-input">
                        </div>

                        <div class="form-row">
                            <label for="end_time">End Time *</label>
                            <input type="time" id="end_time" name="end_time" required class="form-input">
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="venue">Venue *</label>
                        <input type="text" id="venue" name="venue" required 
                               placeholder="e.g., Main Auditorium / Zoom Meeting / Hybrid" class="form-input">
                    </div>

                    <div class="form-row">
                        <label>Mode *</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="mode" value="on_site" required>
                                On-site
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="mode" value="online">
                                Online
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="mode" value="hybrid">
                                Hybrid
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="registration_link">Registration Link (Optional)</label>
                        <input type="url" id="registration_link" name="registration_link" 
                               placeholder="https://example.com/register" class="form-input">
                    </div>
                </div>

                <!-- Section 3: Speaker/Guest Information -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">👥</span>
                        <h3>Speaker / Guest Information</h3>
                    </div>

                    <div class="form-row">
                        <label for="guest_name">Guest / Speaker Name</label>
                        <input type="text" id="guest_name" name="guest_name" 
                               placeholder="e.g., Dr. Jane Smith" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="guest_designation">Guest Designation / Organization</label>
                        <input type="text" id="guest_designation" name="guest_designation" 
                               placeholder="e.g., Clinical Psychologist, National Hospital" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="guest_contact">Guest Contact (Optional - For Admin Reference)</label>
                        <input type="text" id="guest_contact" name="guest_contact" 
                               placeholder="Email or Phone Number" class="form-input">
                        <small>This will not be shown publicly</small>
                    </div>
                </div>

                <!-- Section 4: Media & Resources -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">📸</span>
                        <h3>Media & Resources</h3>
                    </div>

                    <div class="form-row">
                        <label for="event_poster">Event Image / Poster Upload *</label>
                        <input type="file" id="event_poster" name="event_poster" 
                               accept="image/jpeg,image/png,image/jpg" required class="form-input">
                        <small>Upload promotional image or poster (JPG/PNG, Max 5MB)</small>
                    </div>

                    <div class="form-row">
                        <label for="supporting_docs">Supporting Documents / Brochure (Optional)</label>
                        <input type="file" id="supporting_docs" name="supporting_docs" 
                               accept=".pdf,.doc,.docx" class="form-input">
                        <small>Upload additional event resources (PDF, DOC, Max 10MB)</small>
                    </div>

                    <div class="form-row">
                        <label for="gallery">Gallery Images (Optional)</label>
                        <input type="file" id="gallery" name="gallery[]" 
                               accept="image/jpeg,image/png,image/jpg" multiple class="form-input">
                        <small>Upload multiple images for event gallery</small>
                    </div>
                </div>

                <!-- Section 5: Visibility & Control -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">🔔</span>
                        <h3>Visibility & Control</h3>
                    </div>

                    <div class="form-row">
                        <label for="publish_status">Publish Status *</label>
                        <select id="publish_status" name="publish_status" required class="form-input">
                            <option value="draft">Draft (Not Visible)</option>
                            <option value="published">Published (Live)</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <label class="checkbox-label">
                            <input type="checkbox" name="notify_students" value="1" checked>
                            Notify students from my university when published
                        </label>
                    </div>

                    <div class="info-box">
                        <strong>ℹ️ Note:</strong> This event will be submitted for admin approval before appearing publicly.
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" onclick="history.back()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" name="action" value="draft" class="btn btn-secondary">Save as Draft</button>
                    <button type="submit" name="action" value="publish" class="btn btn-primary">Publish Event</button>
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

            // Validate file size
            const poster = document.getElementById('event_poster');
            if (poster.files.length > 0) {
                const fileSize = poster.files[0].size / 1024 / 1024; // in MB
                if (fileSize > 5) {
                    e.preventDefault();
                    alert('Event poster must be less than 5MB!');
                    return false;
                }
            }

            return true;
        });

        // Preview image before upload
        document.getElementById('event_poster').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    // Create preview (you can add this later)
                    console.log('Image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>