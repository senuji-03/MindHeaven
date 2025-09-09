// Sample session data (this would come from your PHP backend)
        let sessionHistory = [
            {
                id: 'SH001',
                userId: 'U12345',
                patientName: 'Sarah Johnson',
                date: '2025-09-08',
                time: '10:30 AM',
                duration: '45 mins',
                status: 'completed',
                sessionType: 'Individual Counseling',
                notes: 'Patient showed significant improvement in managing anxiety symptoms. Discussed coping strategies including breathing exercises and mindfulness techniques. Patient reported better sleep patterns and reduced stress levels. Homework assigned: daily journaling for one week.',
                reason: 'Anxiety and stress management',
                nextAppointment: '2025-09-15'
            },
            {
                id: 'SH002',
                userId: 'U23456',
                patientName: 'Michael Chen',
                date: '2025-09-07',
                time: '2:00 PM',
                duration: '50 mins',
                status: 'completed',
                sessionType: 'Academic Counseling',
                notes: 'Discussed academic pressure and time management strategies. Student expressing concern about upcoming exams and workload. Provided resources for study techniques and stress reduction.',
                reason: 'Academic pressure and burnout',
                nextAppointment: '2025-09-14'
            },
            {
                id: 'SH003',
                userId: 'U34567',
                patientName: 'Emily Davis',
                date: '2025-09-06',
                time: '11:00 AM',
                duration: '60 mins',
                status: 'completed',
                sessionType: 'Group Therapy',
                notes: 'Participated well in group discussion about social anxiety. Shared personal experiences and showed empathy towards other group members. Made good progress in communication skills.',
                reason: 'Social anxiety and relationship issues',
                nextAppointment: '2025-09-13'
            },
            {
                id: 'SH004',
                userId: 'U45678',
                patientName: 'James Wilson',
                date: '2025-09-05',
                time: '3:30 PM',
                duration: '45 mins',
                status: 'cancelled',
                sessionType: 'Individual Counseling',
                notes: 'Session cancelled by patient due to family emergency. Rescheduled for next week.',
                reason: 'Depression and mood disorders',
                nextAppointment: '2025-09-12'
            },
            {
                id: 'SH005',
                userId: 'U56789',
                patientName: 'Lisa Brown',
                date: '2025-09-04',
                time: '9:00 AM',
                duration: '0 mins',
                status: 'no-show',
                sessionType: 'Individual Counseling',
                notes: 'Patient did not attend scheduled session. Follow-up message sent via platform messaging system.',
                reason: 'Relationship counseling',
                nextAppointment: 'TBD'
            },
            {
                id: 'SH006',
                userId: 'U67890',
                patientName: 'David Kim',
                date: '2025-09-03',
                time: '1:00 PM',
                duration: '55 mins',
                status: 'completed',
                sessionType: 'Crisis Intervention',
                notes: 'Emergency session due to acute stress reaction. Provided immediate support and coping strategies. Patient stabilized during session. Scheduled follow-up within 48 hours.',
                reason: 'Crisis intervention',
                nextAppointment: '2025-09-10'
            },
            {
                id: 'SH007',
                userId: 'U78901',
                patientName: 'Anna Martinez',
                date: '2025-09-02',
                time: '4:00 PM',
                duration: '45 mins',
                status: 'rescheduled',
                sessionType: 'Individual Counseling',
                notes: 'Session rescheduled at patient request due to scheduling conflict with classes.',
                reason: 'Academic stress and anxiety',
                nextAppointment: '2025-09-09'
            },
            {
                id: 'SH008',
                userId: 'U89012',
                patientName: 'Robert Taylor',
                date: '2025-09-01',
                time: '10:00 AM',
                duration: '50 mins',
                status: 'completed',
                sessionType: 'Individual Counseling',
                notes: 'Continued work on anger management techniques. Patient practicing deep breathing and progressive muscle relaxation. Reported fewer incidents of anger outbursts over the past week.',
                reason: 'Anger management',
                nextAppointment: '2025-09-08'
            }
        ];

        // Current filtered data
        let filteredHistory = [...sessionHistory];

        // Initialize the page
        function initializeSessionHistory() {
            updateStats();
            renderSessionHistory();
            setDateDefaults();
        }

        // Set default date range (last 30 days)
        function setDateDefaults() {
            const today = new Date();
            const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));
            
            document.getElementById('dateFromFilter').value = thirtyDaysAgo.toISOString().split('T')[0];
            document.getElementById('dateToFilter').value = today.toISOString().split('T')[0];
        }

        // Update statistics
        function updateStats() {
            const totalSessions = sessionHistory.length;
            const thisMonth = sessionHistory.filter(session => {
                const sessionDate = new Date(session.date);
                const today = new Date();
                return sessionDate.getMonth() === today.getMonth() && sessionDate.getFullYear() === today.getFullYear();
            }).length;
            
            const completed = sessionHistory.filter(session => session.status === 'completed').length;
            const cancelled = sessionHistory.filter(session => session.status === 'cancelled').length;

            document.getElementById('totalSessions').textContent = totalSessions;
            document.getElementById('monthSessions').textContent = thisMonth;
            document.getElementById('completedSessions').textContent = completed;
            document.getElementById('cancelledSessions').textContent = cancelled;
        }

        // Render session history table
        function renderSessionHistory() {
            const tbody = document.getElementById('historyTableBody');
            
            if (filteredHistory.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="empty-state">
                            <div class="empty-icon">📝</div>
                            <div>No sessions found matching your criteria</div>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = filteredHistory.map(session => `
                <tr>
                    <td>
                        <div class="patient-info">
                            <div class="patient-name">${session.patientName}</div>
                            <div class="patient-id">ID: ${session.userId}</div>
                        </div>
                    </td>
                    <td>
                        <div class="session-datetime">
                            <div class="session-date">${formatDate(session.date)}</div>
                            <div class="session-time">${session.time}</div>
                            <div class="session-duration">${session.duration}</div>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge status-${session.status}">${session.status.replace('-', ' ')}</span>
                    </td>
                    <td>
                        <div class="session-notes">
                            <div class="notes-preview" id="notes-preview-${session.id}">
                                ${session.notes}
                            </div>
                            <div class="notes-full" id="notes-full-${session.id}">
                                ${session.notes}
                            </div>
                            ${session.notes.length > 100 ? `
                                <div class="notes-toggle" onclick="toggleNotes('${session.id}')">
                                    <span id="toggle-text-${session.id}">Show more</span>
                                </div>
                            ` : ''}
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-small btn-view" onclick="viewSessionDetail('${session.id}')">View</button>
                            <button class="btn-small btn-edit" onclick="editSession('${session.id}')">Edit</button>
                            <button class="btn-small btn-report" onclick="generateReport('${session.id}')">Report</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Format date for display
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        // Toggle notes visibility
        function toggleNotes(sessionId) {
            const preview = document.getElementById(`notes-preview-${sessionId}`);
            const full = document.getElementById(`notes-full-${sessionId}`);
            const toggleText = document.getElementById(`toggle-text-${sessionId}`);
            
            if (preview.style.display !== 'none') {
                preview.style.display = 'none';
                full.style.display = 'block';
                toggleText.textContent = 'Show less';
            } else {
                preview.style.display = 'block';
                full.style.display = 'none';
                toggleText.textContent = 'Show more';
            }
        }

        // Apply filters
        function applyFilters() {
            const patientFilter = document.getElementById('patientFilter').value.toLowerCase();
            const dateFromFilter = document.getElementById('dateFromFilter').value;
            const dateToFilter = document.getElementById('dateToFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;

            filteredHistory = sessionHistory.filter(session => {
                const matchesPatient = patientFilter === '' || 
                    session.patientName.toLowerCase().includes(patientFilter) ||
                    session.userId.toLowerCase().includes(patientFilter);
                
                const matchesDateFrom = dateFromFilter === '' || session.date >= dateFromFilter;
                const matchesDateTo = dateToFilter === '' || session.date <= dateToFilter;
                const matchesStatus = statusFilter === '' || session.status === statusFilter;

                return matchesPatient && matchesDateFrom && matchesDateTo && matchesStatus;
            });

            renderSessionHistory();
        }

        // Clear all filters
        function clearFilters() {
            document.getElementById('patientFilter').value = '';
            document.getElementById('dateFromFilter').value = '';
            document.getElementById('dateToFilter').value = '';
            document.getElementById('statusFilter').value = '';
            
            filteredHistory = [...sessionHistory];
            renderSessionHistory();
        }

        // View session detail
        function viewSessionDetail(sessionId) {
            const session = sessionHistory.find(s => s.id === sessionId);
            if (!session) return;

            document.getElementById('sessionDetailTitle').textContent = `Session Details - ${session.patientName}`;
            
            const modalBody = document.getElementById('sessionDetailBody');
            modalBody.innerHTML = `
                <div class="session-detail-grid">
                    <div class="detail-card">
                        <div class="detail-label">Patient Information</div>
                        <div class="detail-value">
                            <strong>${session.patientName}</strong><br>
                            User ID: ${session.userId}
                        </div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Session Information</div>
                        <div class="detail-value">
                            Session ID: ${session.id}<br>
                            Type: ${session.sessionType}
                        </div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Date & Time</div>
                        <div class="detail-value">
                            ${formatDate(session.date)}<br>
                            ${session.time} (${session.duration})
                        </div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            <span class="status-badge status-${session.status}">${session.status.replace('-', ' ')}</span>
                        </div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Reason for Session</div>
                        <div class="detail-value">${session.reason}</div>
                    </div>
                    <div class="detail-card">
                        <div class="detail-label">Next Appointment</div>
                        <div class="detail-value">${session.nextAppointment}</div>
                    </div>
                </div>
                <div class="detail-card" style="margin-top: 1rem;">
                    <div class="detail-label">Session Notes</div>
                    <div class="detail-value" style="white-space: pre-wrap; line-height: 1.6;">${session.notes}</div>
                </div>
            `;

            document.getElementById('sessionDetailModal').style.display = 'block';
        }

        // Close session detail modal
        function closeSessionDetail() {
            document.getElementById('sessionDetailModal').style.display = 'none';
        }

        // Edit session
        function editSession(sessionId) {
            const session = sessionHistory.find(s => s.id === sessionId);
            if (!session) return;

            const newNotes = prompt('Edit session notes:', session.notes);
            if (newNotes !== null) {
                session.notes = newNotes;
                renderSessionHistory();
                alert('Session notes updated successfully!');
            }
        }

        // Generate report
        function generateReport(sessionId) {
            const session = sessionHistory.find(s => s.id === sessionId);
            if (!session) return;

            alert(`Generating comprehensive report for ${session.patientName}...\nThis would typically create a PDF report with session details, progress notes, and recommendations.`);
        }

        // Export history to CSV
        function exportHistory() {
            const csvContent = "data:text/csv;charset=utf-8," + 
                "Session ID,Patient Name,User ID,Date,Time,Duration,Status,Session Type,Reason,Notes,Next Appointment\n" +
                filteredHistory.map(session => 
                    `"${session.id}","${session.patientName}","${session.userId}","${session.date}","${session.time}","${session.duration}","${session.status}","${session.sessionType}","${session.reason}","${session.notes.replace(/"/g, '""')}","${session.nextAppointment}"`
                ).join("\n");

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `session_history_${new Date().toISOString().split('T')[0]}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Add new session (called from other modules)
        function addNewSession(sessionData) {
            const newSession = {
                id: 'SH' + String(sessionHistory.length + 1).padStart(3, '0'),
                userId: sessionData.userId,
                patientName: sessionData.patientName,
                date: sessionData.date,
                time: sessionData.time,
                duration: sessionData.duration || '45 mins',
                status: sessionData.status || 'completed',
                sessionType: sessionData.sessionType || 'Individual Counseling',
                notes: sessionData.notes || '',
                reason: sessionData.reason || '',
                nextAppointment: sessionData.nextAppointment || 'TBD'
            };

            sessionHistory.unshift(newSession); // Add to beginning of array
            filteredHistory = [...sessionHistory];
            updateStats();
            renderSessionHistory();
            
            console.log('New session added to history:', newSession);
        }

        // Auto-refresh data every 5 minutes
        function autoRefreshHistory() {
            // In a real application, this would fetch updated data from the server
            console.log('Auto-refreshing session history data...');
            
            // Simulate data update (in real app, this would be an AJAX call)
            updateStats();
            renderSessionHistory();
        }

        // Set up auto-refresh
        setInterval(autoRefreshHistory, 300000); // Refresh every 5 minutes

        // Sidebar navigation
        function showSection(section) {
            const items = document.querySelectorAll('.sidebar-item');
            items.forEach(item => item.classList.remove('active'));
            
            event.target.classList.add('active');
            
            switch(section) {
                case 'dashboard':
                    window.location.href = 'dashboard.html';
                    break;
                case 'calendar':
                    window.location.href = 'calendar.html';
                    break;
                case 'appointments':
                    alert('Appointment Management - This would navigate to appointment management page');
                    break;
                case 'history':
                    // Already on history page
                    break;
                case 'forum':
                    alert('Forum - This would navigate to forum page');
                    break;
                case 'resources':
                    alert('Resource Hub - This would navigate to resource hub page');
                    break;
                case 'settings':
                    alert('Settings - This would navigate to settings page');
                    break;
            }
        }

        // Navigation functions
        function showNotifications() {
            alert('Notifications:\n• New session completed by Dr. Smith\n• Patient feedback received\n• Weekly report is ready');
        }

        function showMessages() {
            alert('Messages:\n• Sarah Johnson: Thank you for the session\n• System: Session notes reminder\n• Admin: Monthly review scheduled');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('sessionDetailModal');
            if (event.target === modal) {
                closeSessionDetail();
            }
        }

        // Real-time search functionality
        document.getElementById('patientFilter').addEventListener('input', function() {
            if (this.value.length > 2 || this.value.length === 0) {
                applyFilters();
            }
        });

        // Auto-apply date filters when changed
        document.getElementById('dateFromFilter').addEventListener('change', applyFilters);
        document.getElementById('dateToFilter').addEventListener('change', applyFilters);
        document.getElementById('statusFilter').addEventListener('change', applyFilters);

        // Initialize page on load
        document.addEventListener('DOMContentLoaded', function() {
            initializeSessionHistory();
            console.log('Mindheaven Session History loaded successfully!');
        });