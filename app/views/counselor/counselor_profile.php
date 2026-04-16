<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindheaven - Counselor Profile</title>
    <link rel="stylesheet" href="/MindHeaven/public/css/counselor/counselor_profile.css">
    <link rel="stylesheet" href="/MindHeaven/public/css/notifications.css">
</head>

<body>
    <?php
    $counselor = isset($counselor) && is_array($counselor) ? $counselor : array();
    $c_full_name = isset($counselor['full_name']) ? $counselor['full_name'] : 'Counselor';
    $c_email = isset($counselor['email']) ? $counselor['email'] : '';
    $c_phone = isset($counselor['phone_number']) ? $counselor['phone_number'] : '';
    $c_license = isset($counselor['license_number']) ? $counselor['license_number'] : '';
    $c_spec = isset($counselor['specialization']) ? $counselor['specialization'] : '';
    $c_exp = isset($counselor['years_experience']) ? $counselor['years_experience'] : '';
    $c_bio = isset($counselor['bio']) ? $counselor['bio'] : '';
    $c_profile_pic = isset($counselor['profile_picture']) && !empty($counselor['profile_picture'])
        ? $counselor['profile_picture']
        : 'https://via.placeholder.com/150';
    $qualifications = isset($qualifications) && is_array($qualifications) ? $qualifications : array();
    ?>

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

    <div class="main-container">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>

        <div class="main-content">
            <div class="profile-header">
                <div class="profile-picture-container">
                    <img id="profilePic" src="<?php echo htmlspecialchars($c_profile_pic); ?>" alt="Profile Picture"
                        class="profile-picture">
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
                    </div>
                </div>
            </div>

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

            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Professional Details</h2>
                    <button class="edit-btn" onclick="editSection('professional')">✏️ Edit</button>
                </div>
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">Specialization</label>
                            <div class="info-value" id="c_spec"><?php echo htmlspecialchars($c_spec); ?></div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Years of Experience</label>
                            <div class="info-value" id="c_exp"><?php echo htmlspecialchars((string) $c_exp); ?></div>
                        </div>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <label class="info-label">Bio</label>
                            <div class="info-value" id="c_bio"><?php echo htmlspecialchars($c_bio); ?></div>
                        </div>
                    </div>
                </div>
                <div class="save-section" id="professionalSave">
                    <button class="cancel-btn" onclick="cancelEdit('professional')">Cancel</button>
                    <button class="save-btn" onclick="saveSection('professional')">Save Changes</button>
                </div>
            </div>

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
                                <div class="qualification-item" data-id="<?php echo htmlspecialchars($qual['id']); ?>">
                                    <div class="qualification-header">
                                        <div>
                                            <div class="qualification-title">
                                                <?php echo htmlspecialchars($qual['title'] ?? 'Untitled Qualification'); ?>
                                            </div>
                                            <div class="qualification-institution">
                                                <?php echo htmlspecialchars($qual['institution'] ?? ''); ?>
                                            </div>
                                        </div>
                                        <span class="qualification-year">
                                            <?php echo htmlspecialchars($qual['year_range'] ?? $qual['year'] ?? ''); ?>
                                        </span>
                                    </div>
                                    <p class="qualification-description">
                                        <?php echo nl2br(htmlspecialchars($qual['description'] ?? '')); ?>
                                    </p>
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

            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Donation History</h2>
                    <button class="edit-btn" onclick="toggleDonationHistory()">View History</button>
                </div>
                <div class="section-content" id="donation-history-content" style="display: none;">
                    <?php if (empty($donations)): ?>
                        <p style="color: #888; text-align: center; padding: 20px;">No donations yet.</p>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #eee; text-align: left;">
                                        <th style="padding: 12px 8px; font-size: 14px; color: #666;">Event</th>
                                        <th style="padding: 12px 8px; font-size: 14px; color: #666;">University</th>
                                        <th style="padding: 12px 8px; font-size: 14px; color: #666;">Bank Info</th>
                                        <th style="padding: 12px 8px; font-size: 14px; color: #666;">Amount</th>
                                        <th style="padding: 12px 8px; font-size: 14px; color: #666;">Status</th>
                                        <th style="padding: 12px 8px; font-size: 14px; color: #666;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($donations as $donation): ?>
                                        <tr style="border-bottom: 1px solid #f9f9f9;">
                                            <td style="padding: 12px 8px; font-size: 14px; color: #333;"><?php echo htmlspecialchars($donation['event_title'] ?? 'General Donation'); ?></td>
                                            <td style="padding: 12px 8px; font-size: 14px; color: #333;"><?php echo htmlspecialchars($donation['university_name'] ?? 'N/A'); ?></td>
                                            <td style="padding: 12px 8px; font-size: 12px; color: #555;">
                                                <?php if (!empty($donation['bank_name'])): ?>
                                                    <div><strong>Bank:</strong> <?php echo htmlspecialchars($donation['bank_name']); ?></div>
                                                    <div><strong>Branch:</strong> <?php echo htmlspecialchars($donation['bank_branch'] ?? 'N/A'); ?></div>
                                                    <div><strong>Acc:</strong> <?php echo htmlspecialchars($donation['account_number'] ?? 'N/A'); ?></div>
                                                <?php else: ?>
                                                    <span style="font-style: italic; color: #999;">No bank details</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="padding: 12px 8px; font-size: 14px; color: #333;"><?php echo htmlspecialchars($donation['currency'] ?? 'LKR'); ?> <?php echo htmlspecialchars($donation['amount']); ?></td>
                                            <td style="padding: 12px 8px;">
                                                <span style="padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase; background: <?php echo $donation['payment_status'] === 'success' ? '#e6f4ea; color: #1e7e34;' : ($donation['payment_status'] === 'pending' ? '#fff3cd; color: #856404;' : '#f8d7da; color: #721c24;'); ?>">
                                                    <?php echo htmlspecialchars(ucfirst($donation['payment_status'])); ?>
                                                </span>
                                            </td>
                                            <td style="padding: 12px 8px; font-size: 14px; color: #777;"><?php echo date('M j, Y', strtotime($donation['created_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDonationHistory() {
            const content = document.getElementById('donation-history-content');
            const btn = event.target;
            if (content.style.display === 'none') {
                content.style.display = 'block';
                btn.textContent = 'Hide History';
            } else {
                content.style.display = 'none';
                btn.textContent = 'View History';
            }
        }
    </script>

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

    <script src="/MindHeaven/public/js/counselor/counselor_profile.js"></script>
    <script src="/MindHeaven/public/js/notifications.js"></script>
</body>

</html>
