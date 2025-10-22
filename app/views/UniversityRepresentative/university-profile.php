<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage University Profile - University Rep | Mind Haven</title>
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
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/university-rep/events" class="nav-item">
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
            <a href="<?= BASE_URL ?>/university-rep/university-profile" class="nav-item active">
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
            <h1>Manage University Profile</h1>
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
                <h2>🏫 Your University's Public Page</h2>
                <a href="<?= BASE_URL ?>/universities/preview" target="_blank" class="btn btn-secondary">
                    👁️ Preview Public Page
                </a>
            </div>

            <!-- University Profile Form -->
            <form method="POST" action="<?= BASE_URL ?>/university-rep/university-profile/update" enctype="multipart/form-data" class="event-form">
                
                <!-- Section 1: Basic University Information -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">🏫</span>
                        <h3>Basic University Information</h3>
                    </div>

                    <div class="form-row">
                        <label for="university_name">University Name *</label>
                        <input type="text" id="university_name" name="university_name" required 
                               placeholder="e.g., University of Colombo" class="form-input" 
                               value="University of Colombo">
                    </div>

                    <div class="form-row">
                        <label for="university_description">About the University *</label>
                        <textarea id="university_description" name="university_description" required rows="6" 
                                  placeholder="Brief description of your university and mental health initiatives..." 
                                  class="form-input">The University of Colombo is committed to student mental health and wellbeing. We provide comprehensive counseling services and support programs.</textarea>
                    </div>

                    <div class="form-row">
                        <label for="university_website">University Website</label>
                        <input type="url" id="university_website" name="university_website" 
                               placeholder="https://university.edu.lk" class="form-input"
                               value="https://cmb.ac.lk">
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="established_year">Established Year</label>
                            <input type="number" id="established_year" name="established_year" 
                                   placeholder="e.g., 1921" class="form-input" value="1921">
                        </div>

                        <div class="form-row">
                            <label for="student_population">Student Population</label>
                            <input type="number" id="student_population" name="student_population" 
                                   placeholder="e.g., 15000" class="form-input" value="15000">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Visual Branding -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">🎨</span>
                        <h3>Visual Branding</h3>
                    </div>

                    <div class="form-row">
                        <label for="university_logo">University Logo *</label>
                        <input type="file" id="university_logo" name="university_logo" 
                               accept="image/jpeg,image/png" class="form-input">
                        <small>Upload your university logo (PNG/JPG, Max 2MB). This appears on the public page.</small>
                        <div class="current-image" style="margin-top: 10px;">
                            <img src="https://via.placeholder.com/150" alt="Current Logo" style="max-width: 150px; border-radius: 8px;">
                            <p style="font-size: 12px; color: #64748b;">Current Logo</p>
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="banner_image">Banner Image</label>
                        <input type="file" id="banner_image" name="banner_image" 
                               accept="image/jpeg,image/png" class="form-input">
                        <small>Upload a banner image for your university page (1200x400px recommended)</small>
                        <div class="current-image" style="margin-top: 10px;">
                            <img src="https://via.placeholder.com/600x200" alt="Current Banner" style="max-width: 100%; border-radius: 8px;">
                            <p style="font-size: 12px; color: #64748b;">Current Banner</p>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Contact & Location -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">📍</span>
                        <h3>Contact & Location Information</h3>
                    </div>

                    <div class="form-row">
                        <label for="address">Campus Address *</label>
                        <textarea id="address" name="address" required rows="3" 
                                  placeholder="Full campus address..." class="form-input">94, Cumaratunga Munidasa Mawatha, Colombo 00300</textarea>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required 
                                   placeholder="+94 11 2581835" class="form-input" value="+94 11 2581835">
                        </div>

                        <div class="form-row">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required 
                                   placeholder="contact@university.edu.lk" class="form-input" 
                                   value="info@cmb.ac.lk">
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="map_link">Google Maps Link</label>
                        <input type="url" id="map_link" name="map_link" 
                               placeholder="https://maps.google.com/..." class="form-input">
                        <small>Paste your Google Maps location link for easy navigation</small>
                    </div>
                </div>

                <!-- Section 4: Counseling Services -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">💚</span>
                        <h3>Counseling & Mental Health Services</h3>
                    </div>

                    <div class="form-row">
                        <label for="counseling_center_name">Counseling Center Name</label>
                        <input type="text" id="counseling_center_name" name="counseling_center_name" 
                               placeholder="e.g., Student Counseling Unit" class="form-input"
                               value="Student Counseling & Welfare Unit">
                    </div>

                    <div class="form-row">
                        <label for="counseling_description">Services Description</label>
                        <textarea id="counseling_description" name="counseling_description" rows="4" 
                                  placeholder="Describe the mental health services available..." 
                                  class="form-input">Our counseling center provides free, confidential services including individual counseling, group therapy, crisis intervention, and wellness workshops.</textarea>
                    </div>

                    <div class="form-row-group">
                        <div class="form-row">
                            <label for="counseling_phone">Counseling Hotline</label>
                            <input type="tel" id="counseling_phone" name="counseling_phone" 
                                   placeholder="+94 XX XXX XXXX" class="form-input" value="+94 11 2584444">
                        </div>

                        <div class="form-row">
                            <label for="counseling_email">Counseling Email</label>
                            <input type="email" id="counseling_email" name="counseling_email" 
                                   placeholder="counseling@university.edu.lk" class="form-input"
                                   value="counseling@cmb.ac.lk">
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="operating_hours">Operating Hours</label>
                        <input type="text" id="operating_hours" name="operating_hours" 
                               placeholder="e.g., Monday - Friday, 9:00 AM - 5:00 PM" class="form-input"
                               value="Monday - Friday, 8:30 AM - 4:30 PM">
                    </div>

                    <div class="form-row">
                        <label for="emergency_contact">24/7 Emergency Contact (If Available)</label>
                        <input type="tel" id="emergency_contact" name="emergency_contact" 
                               placeholder="+94 XX XXX XXXX" class="form-input">
                    </div>
                </div>

                <!-- Section 5: Social Media & Links -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">🔗</span>
                        <h3>Social Media & Additional Links</h3>
                    </div>

                    <div class="form-row">
                        <label for="facebook">Facebook Page</label>
                        <input type="url" id="facebook" name="facebook" 
                               placeholder="https://facebook.com/university" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="instagram">Instagram Handle</label>
                        <input type="text" id="instagram" name="instagram" 
                               placeholder="@universityofficial" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="twitter">Twitter Handle</label>
                        <input type="text" id="twitter" name="twitter" 
                               placeholder="@university" class="form-input">
                    </div>

                    <div class="form-row">
                        <label for="linkedin">LinkedIn Page</label>
                        <input type="url" id="linkedin" name="linkedin" 
                               placeholder="https://linkedin.com/company/university" class="form-input">
                    </div>
                </div>

                <!-- Section 6: Visibility Settings -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon">👁️</span>
                        <h3>Visibility Settings</h3>
                    </div>

                    <div class="form-row">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_published" value="1" checked>
                            Publish this page on the public homepage
                        </label>
                        <small>Uncheck to hide your university from the public listing</small>
                    </div>

                    <div class="form-row">
                        <label class="checkbox-label">
                            <input type="checkbox" name="accept_donations" value="1" checked>
                            Enable "Donate" button on public page
                        </label>
                        <small>Allow visitors to support your university's mental health programs</small>
                    </div>

                    <div class="info-box">
                        <strong>ℹ️ Note:</strong> Changes to your university profile will be reviewed by admin before appearing publicly.
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" onclick="history.back()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/university-rep/script.js"></script>
</body>
</html>