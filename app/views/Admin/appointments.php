<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        /* Additional styles for appointments table */
        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .appointments-table th,
        .appointments-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .appointments-table th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }
        
        .appointments-table tr:hover {
            background-color: #f9fafb;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .card-header h3 {
            margin: 0;
            color: #1f2937;
        }
        
        .card-tools {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
        }
        
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        
        .btn-icon {
            padding: 6px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .btn-icon:hover {
            background-color: #e5e7eb;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        
        .empty-state-content {
            max-width: 400px;
            margin: 0 auto;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .empty-state h3 {
            margin: 0 0 0.5rem 0;
            color: #374151;
        }
        
        .empty-state p {
            margin: 0;
            color: #6b7280;
        }
        
        .filter-bar {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .search-input {
            flex: 1;
            min-width: 200px;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .filter-select {
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            min-width: 150px;
        }
        
        .filter-select:focus,
        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input,
            .filter-select {
                width: 100%;
            }
            
            .card-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .card-tools {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 Mind Haven</h2>
            <p>Admin Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item">
                <span class="icon">👥</span>
                Manage Users
            </a>
           
            <a href="<?= BASE_URL ?>/admin/moderate-forum" class="nav-item">
                <span class="icon">💬</span>
                Moderate Forum
            </a>
            
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item active">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item">
                <span class="icon">📈</span>
                Reports
            </a>
            <a href="<?= BASE_URL ?>/admin/donations" class="nav-item">
                <span class="icon"></span>
                Donation logs
            </a>
           
        </nav>

        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/logout" class="logout-btn">
                <span class="icon">🚪</span>
                Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <h1>Appointment History</h1>
            <div class="topbar-right">
                <div class="notification-icon">
                    🔔
                    <span class="badge">3</span>
                </div>
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="page-header">
                <h2>📅 Appointment History & Management</h2>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">📋</div>
                    <div class="stat-details">
                        <h3>Total Appointments</h3>
                        <p class="stat-number">1,245</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">✅</div>
                    <div class="stat-details">
                        <h3>Completed</h3>
                        <p class="stat-number">1,089</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">⏳</div>
                    <div class="stat-details">
                        <h3>Upcoming</h3>
                        <p class="stat-number">45</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon purple">❌</div>
                    <div class="stat-details">
                        <h3>Cancelled</h3>
                        <p class="stat-number">111</p>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="section-card" style="margin-bottom: 20px;">
                <div class="filter-bar">
                    <input type="text" placeholder="Search by student or counselor..." class="search-input">
                    <select class="filter-select">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="no_show">No Show</option>
                    </select>
                    <input type="date" class="filter-select">
                </div>
            </div>

            <!-- Appointments Table -->
            <div class="section-card">
                <div class="card-header">
                    <h3>📋 All Appointments</h3>
                    <div class="card-tools">
                        <button id="refreshAppointments" class="btn btn-primary">
                            <span class="btn-icon">🔄</span>
                            <span class="btn-text">Refresh</span>
                        </button>
                        <button id="exportAppointmentsCsv" class="btn btn-secondary">
                            <span class="btn-icon">📤</span>
                            <span class="btn-text">Export CSV</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="appointmentsEmptyState" class="empty-state" style="display:none;">
                        <div class="empty-state-content">
                            <div class="empty-state-icon">📅</div>
                            <h3>No appointments found</h3>
                            <p>No appointments have been scheduled yet. The appointments table may not exist or may be empty.</p>
                            <p><strong>Note:</strong> If you're seeing this message, it means the database connection is working, but there are no appointments to display.</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="appointments-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Counselor</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="appointmentsTableBody">
                                <!-- Dynamic content will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
    
    <script>
    // ----------------------
    // ADMIN APPOINTMENTS MANAGEMENT
    // ----------------------
    
    // Global variables
    let allAppointments = [];
    let filteredAppointments = [];
    
    // ----------------------
    // UTILITY FUNCTIONS
    // ----------------------
    
    function formatDate(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleDateString();
    }
    
    function formatTime(timeStr) {
        const t = new Date('1970-01-01T' + timeStr + 'Z');
        return t.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
    }
    
    function getStatusBadgeClass(status) {
        switch(status.toLowerCase()) {
            case 'completed': return 'badge status-active';
            case 'scheduled': return 'badge role-moderator';
            case 'cancelled': return 'badge status-inactive';
            case 'no_show': return 'badge' + ' style="background:#f8d7da;color:#721c24;"';
            default: return 'badge role-counselor';
        }
    }
    
    function getTypeBadgeClass(type) {
        switch(type.toLowerCase()) {
            case 'individual': return 'badge role-counselor';
            case 'group': return 'badge role-moderator';
            case 'crisis': return 'badge' + ' style="background:#f8d7da;color:#721c24;"';
            case 'assessment': return 'badge' + ' style="background:#fff3cd;color:#856404;"';
            case 'follow-up': return 'badge' + ' style="background:#d1ecf1;color:#0c5460;"';
            default: return 'badge role-counselor';
        }
    }
    
    // ----------------------
    // DATA FETCHING FUNCTIONS
    // ----------------------
    
    async function fetchAllAppointments() {
        try {
            console.log('Fetching appointments from database...');
            const url = '<?= BASE_URL ?>/admin/get-appointments';
            console.log('Fetching from URL:', url);
            
            // Test the test method first
            const testUrl = '<?= BASE_URL ?>/admin/test-method';
            console.log('Testing URL:', testUrl);
            try {
                const testResponse = await fetch(testUrl);
                const testText = await testResponse.text();
                console.log('Test method response:', testText);
            } catch (testError) {
                console.error('Test method error:', testError);
            }
            
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const responseText = await response.text();
            console.log('Raw response:', responseText);
            
            let data;
            try {
                data = JSON.parse(responseText);
                console.log('Parsed JSON:', data);
            } catch (parseError) {
                console.error('JSON parse error:', parseError);
                console.error('Response was not valid JSON:', responseText);
                throw new Error('Invalid JSON response: ' + responseText.substring(0, 100));
            }
            
            if (data.success) {
                allAppointments = data.appointments || [];
                filteredAppointments = [...allAppointments];
                renderAppointments();
                updateStats();
                
                // Show message if no appointments found
                if (data.message) {
                    console.log('Appointments info:', data.message);
                }
            } else {
                console.error('Failed to fetch appointments:', data.message);
                showAlert('Failed to load appointments: ' + (data.message || 'Unknown error'), 'error');
            }
        } catch (error) {
            console.error('Error fetching appointments:', error);
            showAlert('Error loading appointments: ' + error.message, 'error');
            
            // Fallback: Load demo data
            loadDemoAppointments();
        }
    }
    
    function loadDemoAppointments() {
        console.log('Loading demo appointments...');
        allAppointments = [
            {
                id: 1245,
                student_name: 'John Doe',
                counselor_name: 'Dr. Sarah Johnson',
                title: 'Individual Counseling Session',
                type: 'individual',
                date: '2025-01-20',
                time: '10:00',
                status: 'completed',
                notes: 'Regular check-in session'
            },
            {
                id: 1244,
                student_name: 'Jane Smith',
                counselor_name: 'Dr. Emily Chen',
                title: 'Group Therapy Session',
                type: 'group',
                date: '2025-01-22',
                time: '14:00',
                status: 'scheduled',
                notes: 'Group therapy for anxiety management'
            },
            {
                id: 1243,
                student_name: 'Mike Johnson',
                counselor_name: 'Mr. David Silva',
                title: 'Crisis Intervention',
                type: 'crisis',
                date: '2025-01-18',
                time: '11:30',
                status: 'cancelled',
                notes: 'Emergency counseling session'
            },
            {
                id: 1242,
                student_name: 'Sarah Lee',
                counselor_name: 'Dr. Sarah Johnson',
                title: 'Assessment Session',
                type: 'assessment',
                date: '2025-01-23',
                time: '15:00',
                status: 'scheduled',
                notes: 'Initial psychological assessment'
            },
            {
                id: 1241,
                student_name: 'Alex Kumar',
                counselor_name: 'Dr. Emily Chen',
                title: 'Follow-up Session',
                type: 'follow-up',
                date: '2025-01-19',
                time: '09:00',
                status: 'completed',
                notes: 'Follow-up after previous session'
            }
        ];
        filteredAppointments = [...allAppointments];
        renderAppointments();
        updateStats();
    }
    
    // ----------------------
    // RENDERING FUNCTIONS
    // ----------------------
    
    function renderAppointments() {
        const tbody = document.getElementById('appointmentsTableBody');
        const emptyState = document.getElementById('appointmentsEmptyState');
        
        if (!filteredAppointments.length) {
            emptyState.style.display = 'block';
            tbody.innerHTML = '';
            return;
        }
        
        emptyState.style.display = 'none';
        tbody.innerHTML = filteredAppointments.map(appointment => `
            <tr>
                <td>#${appointment.id}</td>
                <td>${appointment.student_name || 'N/A'}</td>
                <td>${appointment.counselor_name || 'N/A'}</td>
                <td>${appointment.title || 'N/A'}</td>
                <td><span class="${getTypeBadgeClass(appointment.type)}">${appointment.type || 'N/A'}</span></td>
                <td>${formatDate(appointment.date)}</td>
                <td>${formatTime(appointment.time)}</td>
                <td><span class="${getStatusBadgeClass(appointment.status)}">${appointment.status || 'N/A'}</span></td>
                <td>
                    <button class="btn-icon" title="View Details" onclick="viewAppointmentDetails(${appointment.id})">👁️</button>
                    <button class="btn-icon" title="Edit Appointment" onclick="editAppointment(${appointment.id})">✏️</button>
                    <button class="btn-icon" title="Download Report" onclick="downloadAppointmentReport(${appointment.id})">📄</button>
                </td>
            </tr>
        `).join('');
    }
    
    function updateStats() {
        const total = allAppointments.length;
        const completed = allAppointments.filter(a => a.status === 'completed').length;
        const upcoming = allAppointments.filter(a => a.status === 'scheduled').length;
        const cancelled = allAppointments.filter(a => a.status === 'cancelled').length;
        
        // Update stat cards
        const statCards = document.querySelectorAll('.stat-number');
        if (statCards[0]) statCards[0].textContent = total;
        if (statCards[1]) statCards[1].textContent = completed;
        if (statCards[2]) statCards[2].textContent = upcoming;
        if (statCards[3]) statCards[3].textContent = cancelled;
    }
    
    // ----------------------
    // FILTERING FUNCTIONS
    // ----------------------
    
    function filterAppointments() {
        const searchTerm = document.querySelector('.search-input').value.toLowerCase();
        const statusFilter = document.querySelector('.filter-select').value;
        const dateFilter = document.querySelector('input[type="date"]').value;
        
        filteredAppointments = allAppointments.filter(appointment => {
            const matchesSearch = !searchTerm || 
                appointment.student_name?.toLowerCase().includes(searchTerm) ||
                appointment.counselor_name?.toLowerCase().includes(searchTerm) ||
                appointment.title?.toLowerCase().includes(searchTerm);
            
            const matchesStatus = !statusFilter || appointment.status === statusFilter;
            
            const matchesDate = !dateFilter || appointment.date === dateFilter;
            
            return matchesSearch && matchesStatus && matchesDate;
        });
        
        renderAppointments();
    }
    
    // ----------------------
    // ACTION FUNCTIONS
    // ----------------------
    
    function viewAppointmentDetails(appointmentId) {
        const appointment = allAppointments.find(a => a.id === appointmentId);
        if (!appointment) return;
        
        const details = `
            Appointment Details:
            ID: #${appointment.id}
            Student: ${appointment.student_name}
            Counselor: ${appointment.counselor_name}
            Title: ${appointment.title}
            Type: ${appointment.type}
            Date: ${formatDate(appointment.date)}
            Time: ${formatTime(appointment.time)}
            Status: ${appointment.status}
            Notes: ${appointment.notes || 'None'}
        `;
        
        alert(details);
    }
    
    function editAppointment(appointmentId) {
        const appointment = allAppointments.find(a => a.id === appointmentId);
        if (!appointment) return;
        
        // For now, just show an alert. In a real implementation, this would open an edit modal
        alert(`Edit appointment #${appointmentId} - This would open an edit form in a real implementation`);
    }
    
    function downloadAppointmentReport(appointmentId) {
        const appointment = allAppointments.find(a => a.id === appointmentId);
        if (!appointment) return;
        
        // Create CSV content
        const csvContent = `Appointment Report
ID,Student,Counselor,Title,Type,Date,Time,Status,Notes
${appointment.id},${appointment.student_name},${appointment.counselor_name},${appointment.title},${appointment.type},${appointment.date},${appointment.time},${appointment.status},${appointment.notes || ''}`;
        
        // Download the file
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `appointment-${appointmentId}-report.csv`;
        a.click();
        URL.revokeObjectURL(url);
    }
    
    function exportAllAppointments() {
        if (!allAppointments.length) {
            showAlert('No appointments to export', 'error');
            return;
        }
        
        const csvContent = [
            'ID,Student,Counselor,Title,Type,Date,Time,Status,Notes',
            ...allAppointments.map(a => 
                `${a.id},${a.student_name},${a.counselor_name},${a.title},${a.type},${a.date},${a.time},${a.status},${a.notes || ''}`
            )
        ].join('\n');
        
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `all-appointments-${new Date().toISOString().split('T')[0]}.csv`;
        a.click();
        URL.revokeObjectURL(url);
        
        showAlert('Appointments exported successfully', 'success');
    }
    
    function showAlert(message, type = 'info') {
        // Create alert element
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'error' ? 'error' : type === 'success' ? 'success' : 'info'}`;
        alert.textContent = message;
        alert.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            z-index: 1000;
            max-width: 400px;
            word-wrap: break-word;
        `;
        
        if (type === 'error') {
            alert.style.backgroundColor = '#ef4444';
        } else if (type === 'success') {
            alert.style.backgroundColor = '#10b981';
        } else {
            alert.style.backgroundColor = '#3b82f6';
        }
        
        document.body.appendChild(alert);
        
        // Remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, 5000);
    }
    
    // ----------------------
    // EVENT LISTENERS
    // ----------------------
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Admin appointments page loaded');
        
        // Load appointments on page load
        fetchAllAppointments();
        
        // Add event listeners
        document.getElementById('refreshAppointments').addEventListener('click', fetchAllAppointments);
        document.getElementById('exportAppointmentsCsv').addEventListener('click', exportAllAppointments);
        
        // Add filter event listeners
        document.querySelector('.search-input').addEventListener('input', filterAppointments);
        document.querySelector('.filter-select').addEventListener('change', filterAppointments);
        document.querySelector('input[type="date"]').addEventListener('change', filterAppointments);
        
        // Auto-refresh every 30 seconds
        setInterval(fetchAllAppointments, 30000);
    });
    </script>
</body>
</html>