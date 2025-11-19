<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & User Moods - Admin | Mind Haven</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            color: white;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-header p {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left-color: #60a5fa;
        }

        .nav-item.active {
            background: rgba(96, 165, 250, 0.1);
            color: #60a5fa;
            border-left-color: #60a5fa;
        }

        .nav-item .icon {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: #f8fafc;
        }

        .topbar {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .topbar h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f1f5f9;
            border-radius: 50px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .content-wrapper {
            padding: 2rem;
        }

        /* Summary Cards */
        .summary-section {
            margin-bottom: 2rem;
        }

        .summary-section h2 {
            color: #1e293b;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .card-title {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .card-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .card-change.positive {
            color: #059669;
        }

        .card-change.negative {
            color: #dc2626;
        }

        /* Reports Section */
        .reports-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .reports-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reports-header h2 {
            color: #1e293b;
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
        }

        .filter-tab {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
        }

        .filter-tab:hover:not(.active) {
            background: #f1f5f9;
            color: #475569;
        }

        .reports-list {
            padding: 0;
        }

        .report-item {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .report-item:hover {
            background: #f8fafc;
        }

        .report-item:last-child {
            border-bottom: none;
        }

        .report-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .report-icon.high-risk {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #dc2626;
        }

        .report-icon.medium-risk {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #d97706;
        }

        .report-icon.low-risk {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #059669;
        }

        .report-content {
            flex: 1;
        }

        .report-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .report-meta {
            font-size: 0.85rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .report-status {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .report-status.pending {
            background: #fef3c7;
            color: #d97706;
        }

        .report-status.resolved {
            background: #d1fae5;
            color: #059669;
        }

        .report-status.investigating {
            background: #dbeafe;
            color: #2563eb;
        }

        .report-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .action-btn.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .action-btn.primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .action-btn.secondary {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .action-btn.secondary:hover {
            background: #e2e8f0;
            color: #475569;
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
        }

        .chart-period {
            font-size: 0.85rem;
            color: #64748b;
        }

        .chart-placeholder {
            height: 200px;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 0.9rem;
            border: 2px dashed #e2e8f0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .charts-section {
                grid-template-columns: 1fr;
            }

            .report-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .report-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* Animation for smooth transitions */
        .card, .report-item, .chart-card {
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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
            
            <a href="<?= BASE_URL ?>/admin/appointments" class="nav-item">
                <span class="icon">📅</span>
                Appointments
            </a>
            <a href="<?= BASE_URL ?>/admin/reports" class="nav-item active">
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <h1>Reports & User Moods</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Summary Section -->
            <div class="summary-section">
                <h2>📊 Dashboard Overview</h2>
        <div class="cards">
                    <div class="card">
                        <div class="card-title">Average Mood</div>
                        <div class="card-value">😊 7.2/10</div>
                        <div class="card-change positive">↗️ +0.3 from last week</div>
                    </div>
                    <div class="card">
                        <div class="card-title">New Reports</div>
                        <div class="card-value">12</div>
                        <div class="card-change negative">↘️ -2 from yesterday</div>
                    </div>
                    <div class="card">
                        <div class="card-title">High Risk Users</div>
                        <div class="card-value">3</div>
                        <div class="card-change">→ No change</div>
                    </div>
                    <div class="card">
                        <div class="card-title">Active Sessions</div>
                        <div class="card-value">47</div>
                        <div class="card-change positive">↗️ +8 from yesterday</div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">📈 Mood Trends</div>
                        <div class="chart-period">Last 7 days</div>
                    </div>
                    <div class="chart-placeholder">
                        📊 Mood trend chart would be displayed here
                    </div>
                </div>
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title">📊 Report Categories</div>
                        <div class="chart-period">This month</div>
                    </div>
                    <div class="chart-placeholder">
                        🥧 Report category pie chart would be displayed here
                    </div>
                </div>
            </div>

            <!-- Reports Section -->
            <div class="reports-section">
                <div class="reports-header">
                    <h2>🚨 Recent Reports</h2>
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-filter="all">All</button>
                        <button class="filter-tab" data-filter="high">High Risk</button>
                        <button class="filter-tab" data-filter="medium">Medium</button>
                        <button class="filter-tab" data-filter="low">Low</button>
                    </div>
                </div>
                <div class="reports-list">
                    <div class="report-item" data-risk="high">
                        <div class="report-icon high-risk">⚠️</div>
                        <div class="report-content">
                            <div class="report-title">User U103 reported inappropriate content in forum thread</div>
                            <div class="report-meta">
                                <span>Reported by: Sarah M.</span>
                                <span>2 hours ago</span>
                                <span class="report-status pending">Pending</span>
                            </div>
                        </div>
                        <div class="report-actions">
                            <button class="action-btn primary" onclick="investigateReport(this)">🔍 Investigate</button>
                            <button class="action-btn secondary" onclick="resolveReport(this)">✅ Resolve</button>
                        </div>
                    </div>
                    
                    <div class="report-item" data-risk="medium">
                        <div class="report-icon medium-risk">⚠️</div>
                        <div class="report-content">
                            <div class="report-title">Thread flagged for review - potential bullying</div>
                            <div class="report-meta">
                                <span>Reported by: Auto-mod</span>
                                <span>4 hours ago</span>
                                <span class="report-status investigating">Investigating</span>
                            </div>
                        </div>
                        <div class="report-actions">
                            <button class="action-btn primary" onclick="investigateReport(this)">🔍 Investigate</button>
                            <button class="action-btn secondary" onclick="resolveReport(this)">✅ Resolve</button>
                        </div>
                    </div>
                    
                    <div class="report-item" data-risk="low">
                        <div class="report-icon low-risk">ℹ️</div>
                        <div class="report-content">
                            <div class="report-title">User requested content removal - personal information</div>
                            <div class="report-meta">
                                <span>Reported by: John D.</span>
                                <span>6 hours ago</span>
                                <span class="report-status resolved">Resolved</span>
                            </div>
                        </div>
                        <div class="report-actions">
                            <button class="action-btn secondary" onclick="viewDetails(this)">👁️ View Details</button>
                        </div>
                    </div>
                    
                    <div class="report-item" data-risk="high">
                        <div class="report-icon high-risk">🚨</div>
                        <div class="report-content">
                            <div class="report-title">Crisis intervention needed - user expressing suicidal thoughts</div>
                            <div class="report-meta">
                                <span>Reported by: Crisis Bot</span>
                                <span>8 hours ago</span>
                                <span class="report-status investigating">Investigating</span>
                            </div>
                        </div>
                        <div class="report-actions">
                            <button class="action-btn primary" onclick="investigateReport(this)">🚨 Urgent</button>
                            <button class="action-btn secondary" onclick="resolveReport(this)">✅ Resolve</button>
                        </div>
                    </div>
                    
                    <div class="report-item" data-risk="medium">
                        <div class="report-icon medium-risk">⚠️</div>
                        <div class="report-content">
                            <div class="report-title">Spam detected in multiple forum posts</div>
                            <div class="report-meta">
                                <span>Reported by: Auto-mod</span>
                                <span>12 hours ago</span>
                                <span class="report-status pending">Pending</span>
                            </div>
                        </div>
                        <div class="report-actions">
                            <button class="action-btn primary" onclick="investigateReport(this)">🔍 Investigate</button>
                            <button class="action-btn secondary" onclick="resolveReport(this)">✅ Resolve</button>
                        </div>
                    </div>
                </div>
        </div>
  </div>

    <script>
        // Filter functionality
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                // Add active class to clicked tab
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                const reportItems = document.querySelectorAll('.report-item');
                
                reportItems.forEach(item => {
                    if (filter === 'all' || item.dataset.risk === filter) {
                        item.style.display = 'flex';
                        item.style.animation = 'fadeInUp 0.3s ease';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Report action functions
        function investigateReport(btn) {
            const reportItem = btn.closest('.report-item');
            const title = reportItem.querySelector('.report-title').textContent;
            
            // Update status
            const status = reportItem.querySelector('.report-status');
            status.textContent = 'Investigating';
            status.className = 'report-status investigating';
            
            // Show notification
            showNotification(`Investigating report: ${title}`, 'info');
            
            // Add visual feedback
            reportItem.style.background = '#dbeafe';
            setTimeout(() => {
                reportItem.style.background = '';
            }, 2000);
        }

        function resolveReport(btn) {
            const reportItem = btn.closest('.report-item');
            const title = reportItem.querySelector('.report-title').textContent;
            
            if (confirm(`Are you sure you want to resolve this report: "${title}"?`)) {
                // Update status
                const status = reportItem.querySelector('.report-status');
                status.textContent = 'Resolved';
                status.className = 'report-status resolved';
                
                // Hide action buttons and show view details
                const actions = reportItem.querySelector('.report-actions');
                actions.innerHTML = '<button class="action-btn secondary" onclick="viewDetails(this)">👁️ View Details</button>';
                
                // Show notification
                showNotification('Report resolved successfully!', 'success');
                
                // Add visual feedback
                reportItem.style.background = '#d1fae5';
                setTimeout(() => {
                    reportItem.style.background = '';
                }, 2000);
            }
        }

        function viewDetails(btn) {
            const reportItem = btn.closest('.report-item');
            const title = reportItem.querySelector('.report-title').textContent;
            
            showNotification(`Viewing details for: ${title}`, 'info');
        }

        // Show notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <span>${type === 'success' ? '✅' : type === 'warning' ? '⚠️' : 'ℹ️'}</span>
                <span>${message}</span>
            `;
            
            // Add notification styles
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#d1fae5' : type === 'warning' ? '#fef3c7' : '#dbeafe'};
                color: ${type === 'success' ? '#065f46' : type === 'warning' ? '#92400e' : '#1e40af'};
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                gap: 0.5rem;
                z-index: 10000;
                animation: slideInRight 0.3s ease;
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Add loading animation to report items
            const reportItems = document.querySelectorAll('.report-item');
            reportItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>

