<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindheaven - Counselor Profile</title>
     <link rel="stylesheet" href="\MindHeaven\public\css\counselor\counselor_profile.css">
</head>
<body>
    <?php
        $counselor = isset($counselor) && is_array($counselor) ? $counselor : array();
        $c_full_name = isset($counselor['full_name']) ? $counselor['full_name'] : 'Counselor';
        $c_email = isset($counselor['email']) ? $counselor['email'] : '';
        $c_phone = isset($counselor['phone_number']) ? $counselor['phone_number'] : '';
        $c_license = isset($counselor['license_number']) ? $counselor['license_number'] : '';
        $c_spec = isset($counselor['specialization']) ? $counselor['specialization'] : '';
        $c_exp = isset($counselor['experience_years']) ? $counselor['experience_years'] : '';
        $c_bio = isset($counselor['bio']) ? $counselor['bio'] : '';
        $qualifications = isset($qualifications) && is_array($qualifications) ? $qualifications : [];
    ?>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <div class="logo-icon">M</div>
                Mindheaven
            </div>
            <div class="nav-icons">
                <div class="nav-icon" onclick="showNotifications()">
                    🔔
                    <span class="badge">3</span>
                </div>
                <div class="nav-icon" onclick="showMessages()">
                    💬
                    <span class="badge">7</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-picture-container">
                    <img id="profilePic" src="https://via.placeholder.com/150" alt="Profile Picture" class="profile-picture">
                    <button class="change-photo-btn" onclick="openPhotoModal()">📷</button>
                </div>
                <div class="profile-info">
                    <h1 class="profile-name" id="profileName"><?php echo htmlspecialchars($c_full_name); ?></h1>
                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-value" id="totalSessions">247</div>
                            <div class="stat-label">Sessions Conducted</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">4.8</div>
                            <div class="stat-label">Average Rating</div>
                        </div>
                        <!-- <div class="stat-item">
                            <div class="stat-value">94%</div>
                            <div class="stat-label">Success Rate</div>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Personal Details Section -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Personal Details</h2>
                    <button class="edit-btn" onclick="editSection('personal')">✏️ Edit</button>
                </div>
                <div class="section-content">
                    <div class="info-grid" id="personalDetails">
                        <div class="info-item">
                            <label class="info-label">Full Name</label>
                            <div class="info-value" id="c_full_name"><?php echo htmlspecialchars($c_full_name); ?></div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Mobile Number</label>
                            <div class="info-value" id="c_phone"><?php echo htmlspecialchars($c_phone); ?></div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Email Address</label>
                            <div class="info-value readonly"><?php echo htmlspecialchars($c_email); ?></div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">License Number</label>
                            <div class="info-value readonly"><?php echo htmlspecialchars($c_license); ?></div>
                        </div>
                    </div>
                </div>
                <div class="save-section" id="personalSave">
                    <button class="cancel-btn" onclick="cancelEdit('personal')">Cancel</button>
                    <button class="save-btn" onclick="saveSection('personal')">Save Changes</button>
                </div>
            </div>

            <!-- Professional Summary -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Professional Details</h2>
                    <button class="edit-btn" onclick="editSection('professional')">✏️ Edit</button>
                </div>
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">Specialization</label>
                            <div class="info-value " id="c_spec"><?php echo htmlspecialchars($c_spec); ?></div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Years of Experience</label>
                            <div class="info-value " id="c_exp"><?php echo htmlspecialchars((string)$c_exp); ?></div>
                        </div>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <label class="info-label">Bio</label>
                            <div class="info-value " id="c_bio"><?php echo htmlspecialchars($c_bio); ?></div>
                        </div>
                    </div>
                </div>
                <div class="save-section" id="professionalSave">
                    <button class="cancel-btn" onclick="cancelEdit('professional')">Cancel</button>
                    <button class="save-btn" onclick="saveSection('professional')">Save Changes</button>
                </div>
            </div>

            <!-- Qualifications Section -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Qualifications & Experience</h2>
                    <div>
                        <button class="edit-btn" onclick="addQualification()" style="margin-right: 10px;">➕ Add</button>
                        <button class="edit-btn" onclick="editSection('qualification')">✏️ Edit</button>
                    </div>
                </div>
                <div class="section-content">
                    <div class="qualification-list" id="qualificationList">
                        <?php if (empty($qualifications)): ?>
                            <div class="qualification-item empty-state" style="text-align: center; color: #888;">
                                No qualifications added yet. Click Add to create one.
                            </div>
                        <?php else: ?>
                            <?php foreach ($qualifications as $qual): ?>
                            <div class="qualification-item" data-id="<?php echo $qual['id']; ?>">
                                <div class="qualification-header">
                                    <div>
                                        <div class="qualification-title"><?php echo htmlspecialchars($qual['title']); ?></div>
                                        <div class="qualification-institution"><?php echo htmlspecialchars($qual['institution']); ?></div>
                                    </div>
                                    <span class="qualification-year"><?php echo htmlspecialchars($qual['year_range']); ?></span>
                                </div>
                                <p class="qualification-description"><?php echo nl2br(htmlspecialchars($qual['description'])); ?></p>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="save-section" id="qualificationSave">
                    <button class="cancel-btn" onclick="cancelEdit('qualification')">Cancel</button>
                    <button class="save-btn" onclick="saveSection('qualification')">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Upload Modal -->
    <div id="photoModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Change Profile Picture</h3>
            </div>
            <div class="modal-body">
                <label for="photoUpload" class="upload-label">
                    📁 Choose Photo
                </label>
                <input type="file" id="photoUpload" accept="image/*" onchange="previewPhoto(event)">
            </div>
            <div class="modal-actions">
                <button class="cancel-btn" onclick="closePhotoModal()">Cancel</button>
                <button class="save-btn" onclick="uploadPhoto()">Upload</button>
            </div>
        </div>
    </div>

    <script src="\MindHeaven\public\js\counselor\counselor_profile.js"></script>
</body>
</html>