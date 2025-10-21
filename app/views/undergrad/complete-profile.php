<?php
require BASE_PATH.'/app/views/layouts/header.php';
?>

<div class="container">
    <div class="complete-profile-container">
        <div class="profile-header">
            <h1>Complete Your Profile</h1>
            <p>Please provide additional information to complete your undergraduate student profile</p>
        </div>

        <?php if(isset($errors) && !empty($errors)): ?>
            <div class="error-message">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/ug/profile/complete" id="completeProfileForm">
            <div class="profile-section">
                <h2>Personal Information</h2>
                
                <div class="form-group">
                    <label for="full_name">Full Name *</label>
                    <input type="text" 
                           id="full_name" 
                           name="full_name" 
                           value="<?= htmlspecialchars($form_data['full_name'] ?? '') ?>"
                           placeholder="Enter your full name"
                           required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                           placeholder="your.email@university.edu"
                           required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number *</label>
                    <input type="tel" 
                           id="phone_number" 
                           name="phone_number" 
                           value="<?= htmlspecialchars($form_data['phone_number'] ?? '') ?>"
                           placeholder="+1 (555) 123-4567"
                           required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" 
                               id="date_of_birth" 
                               name="date_of_birth" 
                               value="<?= htmlspecialchars($form_data['date_of_birth'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select gender...</option>
                            <option value="male" <?= ($form_data['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= ($form_data['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
                            <option value="other" <?= ($form_data['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Other</option>
                            <option value="prefer_not_to_say" <?= ($form_data['gender'] ?? '') === 'prefer_not_to_say' ? 'selected' : '' ?>>Prefer not to say</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Complete Profile</button>
                <a href="<?= BASE_URL ?>/ug" class="btn secondary">Skip for Now</a>
            </div>
        </form>
    </div>
</div>

<style>
.complete-profile-container {
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

.form-group {
    margin-bottom: 20px;
}

.form-row {
    display: flex;
    gap: 15px;
}

.form-row .form-group {
    flex: 1;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #374151;
}

input[type="text"], 
input[type="email"], 
input[type="tel"], 
input[type="date"], 
select {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

input:focus, select:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.error-message {
    color: #dc2626;
    background-color: #fef2f2;
    border: 1px solid #fecaca;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.error-message ul {
    margin: 0;
    padding-left: 20px;
}

.form-actions {
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
    .form-row {
        flex-direction: column;
    }
    
    .form-actions {
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
document.getElementById('completeProfileForm').addEventListener('submit', function(e) {
    const requiredFields = ['full_name', 'email', 'phone_number'];
    let hasErrors = false;
    
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (!field.value.trim()) {
            field.style.borderColor = '#dc2626';
            hasErrors = true;
        } else {
            field.style.borderColor = '#d1d5db';
        }
    });
    
    // Email validation
    const email = document.getElementById('email').value;
    if (email && !isValidEmail(email)) {
        document.getElementById('email').style.borderColor = '#dc2626';
        hasErrors = true;
    }
    
    if (hasErrors) {
        e.preventDefault();
        alert('Please fill in all required fields.');
    }
});

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
</script>

<?php
require BASE_PATH.'/app/views/layouts/footer.php';
?>
