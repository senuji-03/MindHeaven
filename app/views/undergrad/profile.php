<?php
require BASE_PATH.'/app/views/layouts/header.php';
?>

<div class="container">
    <div class="profile-container">
        <div class="profile-header">
            <h1>My Profile</h1>
            <p>Manage your personal information and account settings</p>
        </div>

        <div class="profile-content">
            <div class="profile-section">
                <h2>Personal Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Full Name:</label>
                        <span><?= htmlspecialchars($student['full_name'] ?? 'Not provided') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <span><?= htmlspecialchars($student['email'] ?? 'Not provided') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Phone:</label>
                        <span><?= htmlspecialchars($student['phone_number'] ?? 'Not provided') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Date of Birth:</label>
                        <span><?= $student['date_of_birth'] ? date('F j, Y', strtotime($student['date_of_birth'])) : 'Not provided' ?></span>
                    </div>
                    <div class="info-item">
                        <label>Gender:</label>
                        <span><?= ucfirst(str_replace('_', ' ', $student['gender'] ?? 'Not specified')) ?></span>
                    </div>
                    <div class="info-item">
                        <label>Preferred Language:</label>
                        <span><?= strtoupper($student['preferred_language'] ?? 'English') ?></span>
                    </div>
                </div>
            </div>


            <div class="profile-section">
                <h2>Account Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Username:</label>
                        <span><?= htmlspecialchars($student['username'] ?? 'N/A') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Role:</label>
                        <span><?= ucfirst($student['role'] ?? 'N/A') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Member Since:</label>
                        <span><?= $student['created_at'] ? date('F j, Y', strtotime($student['created_at'])) : 'N/A' ?></span>
                    </div>
                </div>
            </div>

            <div class="profile-section">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 20px;">
                    <h2 style="margin: 0; border: none; padding: 0;">Donation History</h2>
                    <button class="btn secondary" style="padding: 8px 16px; font-size: 14px;" onclick="toggleDonationHistory()">View History</button>
                </div>
                
                <div id="donation-history-content" style="display: none;">
                    <?php if (empty($donations)): ?>
                        <p style="color: #6b7280; font-style: italic;">No donations yet.</p>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #e5e7eb; text-align: left;">
                                        <th style="padding: 12px 8px; font-size: 14px; color: #374151;">Event</th>
                                        <th style="padding: 12px 8px; font-size: 14px; color: #374151;">Amount</th>
                                        <th style="padding: 12px 8px; font-size: 14px; color: #374151;">Status</th>
                                        <th style="padding: 12px 8px; font-size: 14px; color: #374151;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($donations as $donation): ?>
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td style="padding: 12px 8px; font-size: 14px;"><?= htmlspecialchars($donation['event_title'] ?? 'General Donation') ?></td>
                                            <td style="padding: 12px 8px; font-size: 14px;"><?= htmlspecialchars($donation['currency'] ?? 'LKR') ?> <?= htmlspecialchars($donation['amount']) ?></td>
                                            <td style="padding: 12px 8px;">
                                                <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; background: <?= $donation['payment_status'] === 'success' ? '#dcfce7; color: #166534;' : ($donation['payment_status'] === 'pending' ? '#fef9c3; color: #854d0e;' : '#fee2e2; color: #991b1b;') ?>">
                                                    <?= ucfirst($donation['payment_status']) ?>
                                                </span>
                                            </td>
                                            <td style="padding: 12px 8px; font-size: 14px; color: #6b7280;"><?= date('M j, Y', strtotime($donation['created_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="profile-actions">
                <button class="btn primary" onclick="editProfile()">Edit Profile</button>
                <button class="btn secondary" onclick="changePassword()">Change Password</button>
            </div>
        </div>
    </div>
</div>

<style>
.profile-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.profile-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e5e7eb;
}

.profile-header h1 {
    color: #1f2937;
    margin-bottom: 10px;
}

.profile-header p {
    color: #6b7280;
    font-size: 16px;
}

.profile-section {
    background: #fff;
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.profile-section h2 {
    color: #1f2937;
    margin-bottom: 20px;
    font-size: 20px;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 10px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 15px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.info-item label {
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}

.info-item span {
    color: #1f2937;
    font-size: 16px;
    padding: 8px 0;
}

.profile-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn.primary {
    background-color: #4f46e5;
    color: white;
}

.btn.primary:hover {
    background-color: #4338ca;
}

.btn.secondary {
    background-color: #6b7280;
    color: white;
}

.btn.secondary:hover {
    background-color: #4b5563;
}

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .profile-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        max-width: 200px;
    }
}
</style>

<script>
function editProfile() {
    // Redirect to edit profile page or show edit modal
    window.location.href = '<?= BASE_URL ?>/ug/profile/edit';
}

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

function changePassword() {
    // Show change password modal or redirect to password change page
    alert('Change password functionality will be implemented here.');
}
</script>

<?php
require BASE_PATH.'/app/views/layouts/footer.php';
?>
