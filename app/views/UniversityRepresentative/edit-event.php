<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - University Representative | MindHeaven</title>
    
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ── Design System Tokens ── */
        :root {
            --primary:        #3D8B6E;
            --primary-light:  #6BB89A;
            --primary-dark:   #2A6B52;
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

        /* ── Sidebar ── */
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
        .content-wrapper { padding: 36px 40px; max-width: 900px; }

        /* ── Form Section Cards ── */
        .form-section {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 28px 32px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .section-title {
            display: flex; align-items: center; gap: 12px;
            padding-bottom: 16px; margin-bottom: 24px;
            border-bottom: 1px solid var(--border);
        }
        .section-icon {
            width: 40px; height: 40px;
            border-radius: var(--radius-sm);
            background: var(--bg-mid); color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
        }
        .section-title h3 { font-size: 1.05rem; font-weight: 700; color: var(--text-primary); }

        /* ── Form Elements ── */
        .form-row { margin-bottom: 20px; }
        .form-row-group { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }

        label {
            display: block; font-size: 0.85rem; font-weight: 600;
            color: var(--text-primary); margin-bottom: 8px;
        }
        .form-input {
            width: 100%; padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit; font-size: 0.92rem;
            color: var(--text-primary); background: var(--surface);
            transition: border-color 0.25s, box-shadow 0.25s;
        }
        .form-input:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(61,139,110,0.12);
        }
        textarea.form-input { resize: vertical; min-height: 120px; }

        .checkbox-group, .radio-group {
            display: flex; flex-wrap: wrap; gap: 16px;
            padding: 4px 0;
        }
        .checkbox-label, .radio-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.9rem; font-weight: 500; cursor: pointer;
            color: var(--text-secondary);
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 8px; padding: 12px 28px;
            border-radius: var(--radius-full);
            font-family: inherit; font-weight: 600; font-size: 0.9rem;
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
        .btn-secondary { background: var(--bg-mid); color: var(--text-secondary); }
        .btn-secondary:hover { background: var(--border); color: var(--text-primary); }

        .info-box {
            background: var(--bg-mid);
            padding: 16px 20px;
            border-radius: var(--radius-md);
            font-size: 0.88rem;
            color: var(--text-primary);
            border-left: 4px solid var(--primary);
        }

        small { color: var(--text-secondary); font-size: 0.78rem; margin-top: 4px; display: block; }

        .page-header { margin-bottom: 28px; display: flex; justify-content: space-between; align-items: center; }
        .page-header h2 { font-size: 1.35rem; font-weight: 700; color: var(--text-primary); }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
            .content-wrapper { padding: 24px 20px; }
            .sidebar { width: 0; display: none; }
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
        <!-- Top Bar -->
        <?php 
        $topbarTitle = 'Edit Event';
        include '_topbar.php'; 
        ?>

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
                        <label for="short_description">Short Description (Optional)</label>
                        <input type="text" id="short_description" name="short_description" 
                               value="<?= htmlspecialchars($event['short_description'] ?? '') ?>"
                               placeholder="Brief summary for the card view" class="form-input" maxlength="255">
                    </div>

                    <div class="form-row">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" required rows="5" 
                                  placeholder="Detailed explanation of the event and its purpose..." class="form-input"><?= htmlspecialchars($event['description']) ?></textarea>
                    </div>

                    <div class="form-row">
                        <label for="target_amount">Target Amount (Optional)</label>
                        <input type="number" id="target_amount" name="target_amount" step="0.01" min="0" 
                               value="<?= htmlspecialchars($event['target_amount'] ?? '') ?>"
                               placeholder="e.g., 1000.00" class="form-input">
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

                    <div class="form-row">
                        <label>Current Event Poster</label>
                        <div style="margin-bottom: 1rem; padding: 1rem; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; text-align: center;">
                            <?php if (!empty($event['image_path'])): ?>
                                <img src="<?= BASE_URL . '/' . htmlspecialchars($event['image_path']) ?>" alt="Current Poster" style="max-width: 100%; max-height: 200px; display: inline-block;">
                            <?php else: ?>
                                <div style="color: #9ca3af; padding: 2rem;">
                                    <span style="font-size: 2rem;">📸</span>
                                    <p>No image currently uploaded</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="event_poster">Event Image / Poster Upload (Leave empty to keep current image)</label>
                        <input type="file" id="event_poster" name="event_poster" 
                               accept="image/jpeg,image/png,image/jpg" class="form-input">
                        <small>Upload promotional image or poster (JPG/PNG, Max 5MB)</small>
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
