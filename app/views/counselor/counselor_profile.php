<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindheaven - Counselor Profile</title>
     <link rel="stylesheet" href="\MindHeaven\public\css\counselor\counselor_profile.css">
</head>
<body>
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
        <div class="sidebar">
            <ul class="sidebar-menu">
                 <li class="sidebar-item"><a href="dashboard">📊 Dashboard</a></li>
                <li class="sidebar-item"><a href="calender">📅 Calendar</a></li>
                <li class="sidebar-item "><a href="appointmentmgt">🗓️ Appointment Management</a></li>
                <li class="sidebar-item"><a href="sessionHistory">📋 Session History</a></li>
                <li class="sidebar-item"><a href="forum">💭 Forum</a></li>
                <li class="sidebar-item"><a href="resources">📚 Resource Hub</a></li>
                <li class="sidebar-item active">👤 Profile</li>
                <li class="sidebar-item">⚙️ Settings</li>
                <li class="sidebar-item logout-item"><a href="<?php echo BASE_URL; ?>/logout" onclick="return confirm('Are you sure you want to logout?')">🚪 Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-picture-container">
                    <img id="profilePic" src="https://via.placeholder.com/150" alt="Profile Picture" class="profile-picture">
                    <button class="change-photo-btn" onclick="openPhotoModal()">📷</button>
                </div>
                <div class="profile-info">
                    <h1 class="profile-name" id="profileName">Dr. Sarah Mitchell</h1>
                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-value" id="totalSessions">247</div>
                            <div class="stat-label">Sessions Conducted</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">4.8</div>
                            <div class="stat-label">Average Rating</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">94%</div>
                            <div class="stat-label">Success Rate</div>
                        </div>
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
                            <div class="info-value readonly">Dr. Sarah Mitchell</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Mobile Number</label>
                            <div class="info-value readonly">+94 77 123 4567</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Email Address</label>
                            <div class="info-value readonly">sarah.mitchell@mindheaven.com</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Location</label>
                            <div class="info-value" id="location">Colombo, Sri Lanka</div>
                        </div>
                    </div>
                </div>
                <div class="save-section" id="personalSave">
                    <button class="cancel-btn" onclick="cancelEdit('personal')">Cancel</button>
                    <button class="save-btn" onclick="saveSection('personal')">Save Changes</button>
                </div>
            </div>

            <!-- Qualifications Section -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Qualifications & Experience</h2>
                    <button class="edit-btn" onclick="editSection('qualification')">✏️ Edit</button>
                </div>
                <div class="section-content">
                    <div class="qualification-list" id="qualificationList">
                        <div class="qualification-item">
                            <div class="qualification-header">
                                <div>
                                    <div class="qualification-title">Ph.D. in Clinical Psychology</div>
                                    <div class="qualification-institution">University of Colombo</div>
                                </div>
                                <span class="qualification-year">2015 - 2019</span>
                            </div>
                            <p class="qualification-description">Specialized in cognitive behavioral therapy and adolescent mental health. Research focus on anxiety disorders and stress management techniques.</p>
                        </div>
                        <div class="qualification-item">
                            <div class="qualification-header">
                                <div>
                                    <div class="qualification-title">M.Sc. in Counseling Psychology</div>
                                    <div class="qualification-institution">University of Kelaniya</div>
                                </div>
                                <span class="qualification-year">2012 - 2014</span>
                            </div>
                            <p class="qualification-description">Advanced training in therapeutic techniques including CBT, DBT, and mindfulness-based interventions.</p>
                        </div>
                        <div class="qualification-item">
                            <div class="qualification-header">
                                <div>
                                    <div class="qualification-title">Senior Counselor</div>
                                    <div class="qualification-institution">Mindheaven Mental Health Center</div>
                                </div>
                                <span class="qualification-year">2019 - Present</span>
                            </div>
                            <p class="qualification-description">Providing individual and group therapy sessions for students and young adults. Specializing in academic stress, anxiety, depression, and relationship counseling.</p>
                        </div>
                        <div class="qualification-item">
                            <div class="qualification-header">
                                <div>
                                    <div class="qualification-title">Clinical Psychologist</div>
                                    <div class="qualification-institution">National Hospital Colombo</div>
                                </div>
                                <span class="qualification-year">2014 - 2019</span>
                            </div>
                            <p class="qualification-description">Conducted psychological assessments and therapy for diverse patient populations. Developed treatment plans and collaborated with multidisciplinary teams.</p>
                        </div>
                    </div>
                </div>
                <div class="save-section" id="qualificationSave">
                    <button class="cancel-btn" onclick="cancelEdit('qualification')">Cancel</button>
                    <button class="save-btn" onclick="saveSection('qualification')">Save Changes</button>
                </div>
            </div>

            <!-- Available Time Slots Section -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Available Time Slots</h2>
                    <button class="edit-btn" onclick="editSection('timeslots')">✏️ Edit</button>
                </div>
                <div class="section-content">
                    <div class="time-slots-grid" id="timeSlotsGrid">
                        <div class="day-slot">
                            <div class="day-name">Monday</div>
                            <div class="time-slot">
                                <input type="checkbox" id="mon-9" checked disabled>
                                <label for="mon-9">9:00 AM - 10:00 AM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="mon-10" checked disabled>
                                <label for="mon-10">10:00 AM - 11:00 AM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="mon-14" checked disabled>
                                <label for="mon-14">2:00 PM - 3:00 PM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="mon-15" disabled>
                                <label for="mon-15">3:00 PM - 4:00 PM</label>
                            </div>
                        </div>
                        <div class="day-slot">
                            <div class="day-name">Tuesday</div>
                            <div class="time-slot">
                                <input type="checkbox" id="tue-9" checked disabled>
                                <label for="tue-9">9:00 AM - 10:00 AM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="tue-11" checked disabled>
                                <label for="tue-11">11:00 AM - 12:00 PM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="tue-14" checked disabled>
                                <label for="tue-14">2:00 PM - 3:00 PM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="tue-16" disabled>
                                <label for="tue-16">4:00 PM - 5:00 PM</label>
                            </div>
                        </div>
                        <div class="day-slot">
                            <div class="day-name">Wednesday</div>
                            <div class="time-slot">
                                <input type="checkbox" id="wed-10" checked disabled>
                                <label for="wed-10">10:00 AM - 11:00 AM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="wed-11" checked disabled>
                                <label for="wed-11">11:00 AM - 12:00 PM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="wed-14" disabled>
                                <label for="wed-14">2:00 PM - 3:00 PM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="wed-15" checked disabled>
                                <label for="wed-15">3:00 PM - 4:00 PM</label>
                            </div>
                        </div>
                        <div class="day-slot">
                            <div class="day-name">Thursday</div>
                            <div class="time-slot">
                                <input type="checkbox" id="thu-9" checked disabled>
                                <label for="thu-9">9:00 AM - 10:00 AM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="thu-10" disabled>
                                <label for="thu-10">10:00 AM - 11:00 AM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="thu-14" checked disabled>
                                <label for="thu-14">2:00 PM - 3:00 PM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="thu-16" checked disabled>
                                <label for="thu-16">4:00 PM - 5:00 PM</label>
                            </div>
                        </div>
                        <div class="day-slot">
                            <div class="day-name">Friday</div>
                            <div class="time-slot">
                                <input type="checkbox" id="fri-9" checked disabled>
                                <label for="fri-9">9:00 AM - 10:00 AM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="fri-10" checked disabled>
                                <label for="fri-10">10:00 AM - 11:00 AM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="fri-11" disabled>
                                <label for="fri-11">11:00 AM - 12:00 PM</label>
                            </div>
                            <div class="time-slot">
                                <input type="checkbox" id="fri-14" checked disabled>
                                <label for="fri-14">2:00 PM - 3:00 PM</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="save-section" id="timeslotsSave">
                    <button class="cancel-btn" onclick="cancelEdit('timeslots')">Cancel</button>
                    <button class="save-btn" onclick="saveSection('timeslots')">Save Changes</button>
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