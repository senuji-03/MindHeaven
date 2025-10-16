<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindheaven - Counselor Dashboard</title>
    <link rel="stylesheet" href="\MindHeaven\public\css\counselor\Cdashboard.css">
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
                 <li class="sidebar-item active"><a href="#" style="color: #2563eb;">📊 Dashboard</a></li>
                <li class="sidebar-item"><a href="calender.php">📅 Calendar</a></li>
                <li class="sidebar-item "><a href="appointmentmgt.php">🗓 Appointment Management</a></li>
                <li class="sidebar-item"><a href="sessionHistory.php">📋 Session History</a></li>
                <li class="sidebar-item"><a href="#">💭 Forum</a></li>
                <li class="sidebar-item"><a href="#">📚 Resource Hub</a></li>
                <li class="sidebar-item"><a href="counselor_profile.php">👤 Profile</a></li>
                <li class="sidebar-item"><a href="#">⚙ Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Total Patients</div>
                            <div class="stat-value">142</div>
                        </div>
                        <div class="stat-icon">👥</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Today's Sessions</div>
                            <div class="stat-value">8</div>
                        </div>
                        <div class="stat-icon">📅</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Average Rating</div>
                            <div class="stat-value">4.8</div>
                        </div>
                        <div class="stat-icon">⭐</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div>
                            <div class="stat-title">Success Rate</div>
                            <div class="stat-value">94%</div>
                        </div>
                        <div class="stat-icon">📈</div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Appointments -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Upcoming Appointments</h2>
                </div>
                <div class="appointment-row">
                    <div class="patient-info">
                        <h4>Sarah Johnson</h4>
                        <p>Reason: Anxiety and stress management</p>
                    </div>
                    <div class="time-slot">
                        <div class="date">Today</div>
                        <div class="time">10:30 AM</div>
                    </div>
                    <div class="media-type video-call">
                        🔹 Video Call
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-start" onclick="startMeeting('Sarah Johnson')">Start</button>
                        <button class="btn btn-reschedule" onclick="reschedule('Sarah Johnson', 'Anxiety and stress management')">Reschedule</button>
                        <button class="btn btn-feedback" onclick="sendFeedback('Sarah Johnson', 'Anxiety and stress management')">Feedback</button>
                    </div>
                </div>
                <div class="appointment-row">
                    <div class="patient-info">
                        <h4>Michael Chen</h4>
                        <p>Reason: Academic pressure and burnout</p>
                    </div>
                    <div class="time-slot">
                        <div class="date">Today</div>
                        <div class="time">2:00 PM</div>
                    </div>
                    <div class="media-type audio-call">
                        🎧 Audio Call
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-start" onclick="startMeeting('Michael Chen')">Start</button>
                        <button class="btn btn-reschedule" onclick="reschedule('Michael Chen', 'Academic pressure and burnout')">Reschedule</button>
                        <button class="btn btn-feedback" onclick="sendFeedback('Michael Chen', 'Academic pressure and burnout')">Feedback</button>
                    </div>
                </div>
                <div class="appointment-row">
                    <div class="patient-info">
                        <h4>Emily Davis</h4>
                        <p>Reason: Social anxiety and relationship issues</p>
                    </div>
                    <div class="time-slot">
                        <div class="date">Tomorrow</div>
                        <div class="time">11:00 AM</div>
                    </div>
                    <div class="media-type video-call">
                        🔹 Video Call
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-start" onclick="startMeeting('Emily Davis')">Start</button>
                        <button class="btn btn-reschedule" onclick="reschedule('Emily Davis', 'Social anxiety and relationship issues')">Reschedule</button>
                        <button class="btn btn-feedback" onclick="sendFeedback('Emily Davis', 'Social anxiety and relationship issues')">Feedback</button>
                    </div>
                </div>
            </div>

            <!-- Recent Student Feedbacks -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Recent Student Feedbacks</h2>
                    <button class="view-all-btn" onclick="viewAllFeedbacks()">View All</button>
                </div>
                <div class="feedback-item">
                    <div class="feedback-header">
                        <span class="student-name">Alex Thompson</span>
                        <div class="rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                    <p class="feedback-text">Dr. Smith was incredibly helpful and understanding. The session really helped me manage my anxiety better. I feel more confident about handling stressful situations now.</p>
                </div>
                <div class="feedback-item">
                    <div class="feedback-header">
                        <span class="student-name">Maria Rodriguez</span>
                        <div class="rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">☆</span>
                        </div>
                    </div>
                    <p class="feedback-text">Great counseling session. The techniques shared for managing time and reducing academic stress were very practical. Looking forward to the next session.</p>
                </div>
                <div class="feedback-item">
                    <div class="feedback-header">
                        <span class="student-name">James Wilson</span>
                        <div class="rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                    </div>
                    <p class="feedback-text">Excellent support during a difficult time. The counselor provided valuable insights and coping strategies that have made a real difference in my daily life.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reschedule Modal -->
    <div id="rescheduleModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Reschedule Appointment</h3>
                <button class="close" onclick="closeModal('rescheduleModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div id="reschedulePatientInfo" class="patient-info-card">
                    <!-- Patient info will be populated here -->
                </div>
                <form id="rescheduleForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="newDate">New Date</label>
                            <input type="date" id="newDate" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="newTime">New Time</label>
                            <select id="newTime" class="form-input" required>
                                <option value="">Select Time</option>
                                <option value="09:00">9:00 AM</option>
                                <option value="09:30">9:30 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="10:30">10:30 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="11:30">11:30 AM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="14:30">2:30 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="15:30">3:30 PM</option>
                                <option value="16:00">4:00 PM</option>
                                <option value="16:30">4:30 PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="rescheduleReason">Reason for Rescheduling</label>
                        <textarea id="rescheduleReason" class="form-textarea" placeholder="Please provide a reason for rescheduling..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('rescheduleModal')">Cancel</button>
                <button class="btn-primary" onclick="submitReschedule()">Reschedule Appointment</button>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Send Patient Feedback</h3>
                <button class="close" onclick="closeModal('feedbackModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div id="feedbackPatientInfo" class="patient-info-card">
                    <!-- Patient info will be populated here -->
                </div>
                <form id="feedbackForm">
                    <div class="form-group">
                        <label class="form-label" for="feedbackType">Feedback Type</label>
                        <select id="feedbackType" class="form-input" required>
                            <option value="">Select Type</option>
                            <option value="progress">Progress Update</option>
                            <option value="recommendation">Recommendations</option>
                            <option value="homework">Homework Assignment</option>
                            <option value="encouragement">Encouragement & Support</option>
                            <option value="concerns">Areas of Concern</option>
                            <option value="general">General Feedback</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="feedbackMessage">Feedback Message</label>
                        <textarea id="feedbackMessage" class="form-textarea" placeholder="Share your observations, recommendations, or encouragement for the patient..." required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="sessionRating">Session Progress Rating</label>
                            <select id="sessionRating" class="form-input" required>
                                <option value="">Select Rating</option>
                                <option value="5">Excellent Progress</option>
                                <option value="4">Good Progress</option>
                                <option value="3">Satisfactory Progress</option>
                                <option value="2">Needs Improvement</option>
                                <option value="1">Minimal Progress</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="followUpDate">Follow-up Date</label>
                            <input type="date" id="followUpDate" class="form-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="actionItems">Action Items / Next Steps</label>
                        <textarea id="actionItems" class="form-textarea" placeholder="List any homework, exercises, or tasks for the patient to complete..." style="min-height: 80px;"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('feedbackModal')">Cancel</button>
                <button class="btn-primary" onclick="submitFeedback()">Send Feedback</button>
            </div>
        </div>
    </div>

    <script src="\MindHeaven\public\js\counselor\Cdashboard.js"></script>
</body>
</html>