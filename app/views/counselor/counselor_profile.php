<?php
$TITLE = 'Mindheaven - Counselor Profile';
$CURRENT_PAGE = 'counselor_profile';
$PAGE_CSS = ['/MindHeaven/public/css/counselor/counselor_profile.css'];
require BASE_PATH . '/app/views/layouts/header.php';

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

<div class="main-content">

    <!-- ── Profile Header ── -->
    <div class="profile-header">
        <div class="profile-picture-container">
            <img id="profilePic" src="<?php echo htmlspecialchars($c_profile_pic); ?>" alt="Profile Picture" class="profile-picture">
            <button class="change-photo-btn" onclick="openPhotoModal()" title="Change Photo"><i class="fa-solid fa-camera"></i></button>
        </div>
        <div class="profile-info">
            <h1 class="profile-name" id="profileName"><?php echo htmlspecialchars($c_full_name); ?></h1>
            <p class="profile-role" id="profileSpec"><?php echo htmlspecialchars($c_spec ?: 'Counselor'); ?></p>
            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-value" id="totalSessions"><?php echo (int) ($totalSessions ?? 0); ?></div>
                    <div class="stat-label">Sessions Conducted</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?php echo number_format((float) ($avgRating ?? 0), 1); ?></div>
                    <div class="stat-label">Average Rating</div>
                </div>
            </div>
        </div>
        <button class="edit-profile-btn" onclick="openEditModal()" id="editProfileBtn">
            <i class="fa-solid fa-pen-to-square"></i> Edit Profile
        </button>
    </div>

    <!-- ── Personal Details (Read-only view) ── -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Personal Details</h2>
        </div>
        <div class="section-content">
            <div class="info-grid">
                <div class="info-item">
                    <label class="info-label">Full Name</label>
                    <div class="info-value" id="view_full_name"><?php echo htmlspecialchars($c_full_name); ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Mobile Number</label>
                    <div class="info-value" id="view_phone"><?php echo htmlspecialchars($c_phone); ?></div>
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
    </div>

    <!-- ── Professional Details (Read-only view) ── -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Professional Details</h2>
        </div>
        <div class="section-content">
            <div class="info-grid">
                <div class="info-item">
                    <label class="info-label">Specialization</label>
                    <div class="info-value" id="view_spec"><?php echo htmlspecialchars($c_spec); ?></div>
                </div>
                <div class="info-item">
                    <label class="info-label">Years of Experience</label>
                    <div class="info-value" id="view_exp"><?php echo htmlspecialchars((string) $c_exp); ?></div>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <label class="info-label">Bio</label>
                    <div class="info-value" id="view_bio" style="min-height: 80px; align-items: flex-start; padding-top: 14px;"><?php echo htmlspecialchars($c_bio); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Qualifications & Experience (Read-only view) ── -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Qualifications &amp; Experience</h2>
        </div>
        <div class="section-content">
            <div class="qualification-list" id="qualificationList">
                <?php if (empty($qualifications)): ?>
                    <div class="qualification-item empty-state" style="text-align: center; color: var(--text-secondary); border: 1px dashed var(--border-strong);">
                        <i class="fa-solid fa-graduation-cap" style="font-size:2rem;margin-bottom:10px;display:block;"></i>
                        No qualifications added yet. Click <strong>Edit Profile</strong> to add one.
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
    </div>

    <!-- ── Donation History ── -->
    <div class="section-card">
        <div class="section-header">
            <h2 class="section-title">Donation History</h2>
            <button class="edit-btn" onclick="toggleDonationHistory()"><i class="fa-regular fa-eye"></i> <span id="dh-btn-text">View History</span></button>
        </div>
        <div class="section-content" id="donation-history-content" style="display: none; padding:0;">
            <?php if (empty($donations)): ?>
                <div style="padding: 2.5rem; text-align: center; color: var(--text-secondary);">
                    <i class="fa-solid fa-hand-holding-heart" style="font-size:2rem; margin-bottom:12px; display:block;"></i>
                    No donations yet.
                </div>
            <?php else: ?>
                <div class="donations-table-wrapper">
                    <table class="donations-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>University</th>
                                <th>Bank Info</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donations as $donation): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($donation['event_title'] ?? 'General Donation'); ?></td>
                                    <td><?php echo htmlspecialchars($donation['university_name'] ?? 'N/A'); ?></td>
                                    <td>
                                        <?php if (!empty($donation['bank_name'])): ?>
                                            <div><strong>Bank:</strong> <?php echo htmlspecialchars($donation['bank_name']); ?></div>
                                            <div><strong>Branch:</strong> <?php echo htmlspecialchars($donation['bank_branch'] ?? 'N/A'); ?></div>
                                            <div><strong>Acc:</strong> <?php echo htmlspecialchars($donation['account_number'] ?? 'N/A'); ?></div>
                                        <?php else: ?>
                                            <span style="font-style: italic; color: var(--text-secondary);">No bank details</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($donation['currency'] ?? 'LKR'); ?> <?php echo htmlspecialchars($donation['amount']); ?></strong></td>
                                    <td>
                                        <span class="session-status-badge <?php echo $donation['payment_status'] === 'success' ? 'active' : ($donation['payment_status'] === 'pending' ? 'archived' : 'closed'); ?>">
                                            <?php echo htmlspecialchars(ucfirst($donation['payment_status'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($donation['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div><!-- /.main-content -->

<!-- ══════════════════════════════════════════
     EDIT PROFILE MODAL
══════════════════════════════════════════ -->
<div id="editProfileModal" class="modal edit-profile-modal">
    <div class="modal-content edit-modal-content">

        <!-- Modal Header -->
        <div class="modal-header edit-modal-header">
            <div class="edit-modal-title-group">
                <i class="fa-solid fa-user-pen edit-modal-icon"></i>
                <h3 class="modal-title">Edit Profile</h3>
            </div>
            <button class="modal-close-btn" onclick="closeEditModal()" title="Close"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <!-- Tab Navigation -->
        <div class="modal-tabs">
            <button class="modal-tab active" id="tab-personal" onclick="switchTab('personal')">
                <i class="fa-solid fa-user"></i> Personal
            </button>
            <button class="modal-tab" id="tab-professional" onclick="switchTab('professional')">
                <i class="fa-solid fa-briefcase"></i> Professional
            </button>
            <button class="modal-tab" id="tab-qualifications" onclick="switchTab('qualifications')">
                <i class="fa-solid fa-graduation-cap"></i> Qualifications
            </button>
        </div>

        <!-- Modal Body -->
        <div class="edit-modal-body">

            <!-- Tab: Personal Details -->
            <div class="modal-tab-content active" id="tabcontent-personal">
                <div class="form-group">
                    <label class="form-label" for="edit_full_name">Full Name</label>
                    <input type="text" id="edit_full_name" class="form-input" placeholder="Enter your full name">
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit_phone">Mobile Number</label>
                    <input type="tel" id="edit_phone" class="form-input" placeholder="Enter 10-digit mobile number" maxlength="10" pattern="[0-9]{10}" inputmode="numeric" title="Mobile number must be exactly 10 digits">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input readonly-input" value="<?php echo htmlspecialchars($c_email); ?>" disabled>
                        <span class="form-hint"><i class="fa-solid fa-lock"></i> Cannot be changed</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">License Number</label>
                        <input type="text" class="form-input readonly-input" value="<?php echo htmlspecialchars($c_license); ?>" disabled>
                        <span class="form-hint"><i class="fa-solid fa-lock"></i> Cannot be changed</span>
                    </div>
                </div>
            </div>

            <!-- Tab: Professional Details -->
            <div class="modal-tab-content" id="tabcontent-professional">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_spec">Specialization</label>
                        <input type="text" id="edit_spec" class="form-input" placeholder="e.g. Clinical Psychology">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_exp">Years of Experience</label>
                        <input type="number" id="edit_exp" class="form-input" min="0" max="60" placeholder="e.g. 5">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit_bio">Bio</label>
                    <textarea id="edit_bio" class="form-textarea" rows="5" placeholder="Write a short professional bio..."></textarea>
                </div>
            </div>

            <!-- Tab: Qualifications -->
            <div class="modal-tab-content" id="tabcontent-qualifications">
                <div id="editQualList" class="edit-qual-list">
                    <!-- Populated by JS from existing quals -->
                </div>
                <button class="add-qual-btn" onclick="addQualificationRow()">
                    <i class="fa-solid fa-plus"></i> Add Qualification
                </button>
            </div>

        </div><!-- /.edit-modal-body -->

        <!-- Modal Footer -->
        <div class="edit-modal-footer">
            <div id="editModalMsg" class="edit-modal-msg"></div>
            <div class="edit-modal-actions">
                <button class="cancel-btn" onclick="closeEditModal()">Cancel</button>
                <button class="save-btn" id="saveProfileBtn" onclick="saveProfileModal()">
                    <i class="fa-solid fa-floppy-disk"></i> Save Changes
                </button>
            </div>
        </div>

    </div><!-- /.edit-modal-content -->
</div><!-- /#editProfileModal -->

<!-- Photo Upload Modal (unchanged) -->
<div id="photoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Change Profile Picture</h3>
        </div>
        <div class="modal-body">
            <label for="photoUpload" class="upload-label">
                <i class="fa-solid fa-folder-open"></i> Choose Photo
            </label>
            <input type="file" id="photoUpload" accept="image/*" onchange="previewPhoto(event)">
        </div>
        <div class="modal-actions">
            <button class="cancel-btn" onclick="closePhotoModal()">Cancel</button>
            <button class="save-btn" onclick="uploadPhoto()">Upload</button>
        </div>
    </div>
</div>

<!-- Embedded PHP data for JS -->
<script>
    const PROFILE_DATA = {
        full_name:  <?php echo json_encode($c_full_name); ?>,
        phone:      <?php echo json_encode($c_phone); ?>,
        spec:       <?php echo json_encode($c_spec); ?>,
        exp:        <?php echo json_encode((string)$c_exp); ?>,
        bio:        <?php echo json_encode($c_bio); ?>,
        qualifications: <?php echo json_encode(array_map(function($q) {
            return [
                'id'          => $q['id']          ?? '',
                'title'       => $q['title']        ?? '',
                'institution' => $q['institution']  ?? '',
                'year'        => $q['year_range']   ?? $q['year'] ?? '',
                'description' => $q['description']  ?? '',
            ];
        }, $qualifications)); ?>
    };

    function toggleDonationHistory() {
        const content = document.getElementById('donation-history-content');
        const btnText = document.getElementById('dh-btn-text');
        if (content.style.display === 'none') {
            content.style.display = 'block';
            btnText.textContent = 'Hide History';
        } else {
            content.style.display = 'none';
            btnText.textContent = 'View History';
        }
    }
</script>

<script src="/MindHeaven/public/js/counselor/counselor_profile.js"></script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
