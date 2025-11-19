<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Log - Admin | MindHeaven</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/Admin/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🧠 MindHeaven</h2>
            <p>Admin Panel</p>
        </div>
        <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/admin" class="nav-item">
                <span class="icon">📊</span>
                Dashboard
            </a>
            <a href="<?= BASE_URL ?>/admin/manage-users" class="nav-item active">
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
                <span class="icon">➡️</span> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="page-header">
            <div class="header-content">
                <h1>💰 Donation Log</h1>
                <p>Track and manage all donations received by the system</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="exportDonations()">
                    <i class="fas fa-download"></i> Export CSV
                </button>
                <button class="btn btn-secondary" onclick="refreshDonations()">
                    <i class="fas fa-sync"></i> Refresh
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <h3>Total Donations</h3>
                    <p class="stat-number">$24,750</p>
                    <p class="stat-change positive">+12.5% this month</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div class="stat-content">
                    <h3>Total Donors</h3>
                    <p class="stat-number">156</p>
                    <p class="stat-change positive">+8 new this week</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-content">
                    <h3>This Month</h3>
                    <p class="stat-number">$3,420</p>
                    <p class="stat-change positive">+18.3% vs last month</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <h3>Average Donation</h3>
                    <p class="stat-number">$158.65</p>
                    <p class="stat-change positive">+5.2% vs last month</p>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="filters-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search donations, donors, or amounts..." id="searchInput">
            </div>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="recent">Recent</button>
                <button class="filter-btn" data-filter="large">Large ($500+)</button>
                <button class="filter-btn" data-filter="anonymous">Anonymous</button>
                <button class="filter-btn" data-filter="recurring">Recurring</button>
            </div>
        </div>

        <!-- Donations Table -->
        <div class="content-section">
            <div class="table-header">
                <h3>Donation History</h3>
                <div class="table-actions">
                    <select class="form-select" id="sortBy">
                        <option value="date-desc">Date (Newest First)</option>
                        <option value="date-asc">Date (Oldest First)</option>
                        <option value="amount-desc">Amount (Highest First)</option>
                        <option value="amount-asc">Amount (Lowest First)</option>
                        <option value="donor-asc">Donor (A-Z)</option>
                    </select>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="donations-table">
                    <thead>
                        <tr>
                            <th>Donor</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="donationsTableBody">
                        <!-- Donation entries will be populated here -->
                    </tbody>
        </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-section">
            <div class="pagination-info">
                <span>Showing 1-20 of 156 donations</span>
            </div>
            <div class="pagination">
                <button class="pagination-btn" disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <span class="pagination-numbers">
                    <button class="pagination-number active">1</button>
                    <button class="pagination-number">2</button>
                    <button class="pagination-number">3</button>
                    <span class="pagination-ellipsis">...</span>
                    <button class="pagination-number">8</button>
                </span>
                <button class="pagination-btn">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Donation Details Modal -->
    <div id="donationModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Donation Details</h3>
                <button class="modal-close" onclick="closeDonationModal()">&times;</button>
            </div>
            <div class="modal-body" id="donationDetails">
                <!-- Donation details will be populated here -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeDonationModal()">Close</button>
                <button class="btn btn-primary" onclick="printDonation()">
                    <i class="fas fa-print"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>

    <script>
        // Dummy donation data
        const donationsData = [
            {
                id: 1,
                donor: "Sarah Johnson",
                email: "sarah.j@email.com",
                amount: 500,
                date: "2024-12-15",
                type: "One-time",
                status: "Completed",
                paymentMethod: "Credit Card",
                transactionId: "TXN-001-2024",
                isAnonymous: false,
                notes: "Supporting mental health initiatives"
            },
            {
                id: 2,
                donor: "Anonymous",
                email: "anonymous@email.com",
                amount: 1000,
                date: "2024-12-14",
                type: "One-time",
                status: "Completed",
                paymentMethod: "Bank Transfer",
                transactionId: "TXN-002-2024",
                isAnonymous: true,
                notes: "Anonymous donation for student support"
            },
            {
                id: 3,
                donor: "Michael Chen",
                email: "m.chen@company.com",
                amount: 250,
                date: "2024-12-13",
                type: "Recurring",
                status: "Completed",
                paymentMethod: "PayPal",
                transactionId: "TXN-003-2024",
                isAnonymous: false,
                notes: "Monthly recurring donation"
            },
            {
                id: 4,
                donor: "Emily Rodriguez",
                email: "emily.r@university.edu",
                amount: 75,
                date: "2024-12-12",
                type: "One-time",
                status: "Completed",
                paymentMethod: "Credit Card",
                transactionId: "TXN-004-2024",
                isAnonymous: false,
                notes: "Supporting counseling services"
            },
            {
                id: 5,
                donor: "David Thompson",
                email: "david.t@email.com",
                amount: 2000,
                date: "2024-12-11",
                type: "One-time",
                status: "Pending",
                paymentMethod: "Bank Transfer",
                transactionId: "TXN-005-2024",
                isAnonymous: false,
                notes: "Large donation for mental health programs"
            },
            {
                id: 6,
                donor: "Anonymous",
                email: "anonymous@email.com",
                amount: 150,
                date: "2024-12-10",
                type: "One-time",
                status: "Completed",
                paymentMethod: "Credit Card",
                transactionId: "TXN-006-2024",
                isAnonymous: true,
                notes: "Anonymous contribution"
            },
            {
                id: 7,
                donor: "Lisa Wang",
                email: "lisa.w@company.com",
                amount: 300,
                date: "2024-12-09",
                type: "Recurring",
                status: "Completed",
                paymentMethod: "PayPal",
                transactionId: "TXN-007-2024",
                isAnonymous: false,
                notes: "Monthly recurring donation"
            },
            {
                id: 8,
                donor: "Robert Martinez",
                email: "robert.m@email.com",
                amount: 50,
                date: "2024-12-08",
                type: "One-time",
                status: "Completed",
                paymentMethod: "Credit Card",
                transactionId: "TXN-008-2024",
                isAnonymous: false,
                notes: "Small donation to support the cause"
            },
            {
                id: 9,
                donor: "Anonymous",
                email: "anonymous@email.com",
                amount: 750,
                date: "2024-12-07",
                type: "One-time",
                status: "Completed",
                paymentMethod: "Bank Transfer",
                transactionId: "TXN-009-2024",
                isAnonymous: true,
                notes: "Anonymous large donation"
            },
            {
                id: 10,
                donor: "Jennifer Lee",
                email: "jennifer.l@university.edu",
                amount: 125,
                date: "2024-12-06",
                type: "One-time",
                status: "Completed",
                paymentMethod: "Credit Card",
                transactionId: "TXN-010-2024",
                isAnonymous: false,
                notes: "Supporting student mental health"
            },
            {
                id: 11,
                donor: "Anonymous",
                email: "anonymous@email.com",
                amount: 400,
                date: "2024-12-05",
                type: "One-time",
                status: "Completed",
                paymentMethod: "PayPal",
                transactionId: "TXN-011-2024",
                isAnonymous: true,
                notes: "Anonymous donation"
            },
            {
                id: 12,
                donor: "Thomas Anderson",
                email: "thomas.a@company.com",
                amount: 600,
                date: "2024-12-04",
                type: "Recurring",
                status: "Completed",
                paymentMethod: "Bank Transfer",
                transactionId: "TXN-012-2024",
                isAnonymous: false,
                notes: "Monthly recurring donation"
            },
            {
                id: 13,
                donor: "Maria Garcia",
                email: "maria.g@email.com",
                amount: 80,
                date: "2024-12-03",
                type: "One-time",
                status: "Completed",
                paymentMethod: "Credit Card",
                transactionId: "TXN-013-2024",
                isAnonymous: false,
                notes: "Supporting mental health awareness"
            },
            {
                id: 14,
                donor: "Anonymous",
                email: "anonymous@email.com",
                amount: 1200,
                date: "2024-12-02",
                type: "One-time",
                status: "Completed",
                paymentMethod: "Bank Transfer",
                transactionId: "TXN-014-2024",
                isAnonymous: true,
                notes: "Large anonymous donation"
            },
            {
                id: 15,
                donor: "James Wilson",
                email: "james.w@university.edu",
                amount: 175,
                date: "2024-12-01",
                type: "One-time",
                status: "Completed",
                paymentMethod: "PayPal",
                transactionId: "TXN-015-2024",
                isAnonymous: false,
                notes: "Supporting counseling services"
            }
        ];

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            renderDonations();
            initializeFilters();
            initializeSearch();
        });

        // Render donations table
        function renderDonations() {
            const tbody = document.getElementById('donationsTableBody');
            tbody.innerHTML = '';

            donationsData.forEach(donation => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div class="donor-info">
                            <div class="donor-name">${donation.donor}</div>
                            <div class="donor-email">${donation.email}</div>
                        </div>
                    </td>
                    <td>
                        <div class="amount">$${donation.amount.toLocaleString()}</div>
                    </td>
                    <td>
                        <div class="date">${formatDate(donation.date)}</div>
                    </td>
                    <td>
                        <span class="type-badge ${donation.type.toLowerCase().replace('-', '')}">${donation.type}</span>
                    </td>
                    <td>
                        <span class="status-badge ${donation.status.toLowerCase()}">${donation.status}</span>
                    </td>
                    <td>
                        <div class="payment-method">
                            <i class="fas fa-${getPaymentIcon(donation.paymentMethod)}"></i>
                            ${donation.paymentMethod}
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn" onclick="viewDonation(${donation.id})" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn" onclick="editDonation(${donation.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn" onclick="printReceipt(${donation.id})" title="Print Receipt">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }

        // Get payment method icon
        function getPaymentIcon(method) {
            switch(method) {
                case 'Credit Card': return 'credit-card';
                case 'PayPal': return 'paypal';
                case 'Bank Transfer': return 'university';
                default: return 'money-bill';
            }
        }

        // View donation details
        function viewDonation(id) {
            const donation = donationsData.find(d => d.id === id);
            if (!donation) return;

            const modal = document.getElementById('donationModal');
            const details = document.getElementById('donationDetails');
            
            details.innerHTML = `
                <div class="donation-details">
                    <div class="detail-section">
                        <h4>Donor Information</h4>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Name:</label>
                                <span>${donation.donor}</span>
                            </div>
                            <div class="detail-item">
                                <label>Email:</label>
                                <span>${donation.email}</span>
                            </div>
                            <div class="detail-item">
                                <label>Anonymous:</label>
                                <span>${donation.isAnonymous ? 'Yes' : 'No'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h4>Donation Details</h4>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Amount:</label>
                                <span class="amount-large">$${donation.amount.toLocaleString()}</span>
                            </div>
                            <div class="detail-item">
                                <label>Date:</label>
                                <span>${formatDate(donation.date)}</span>
                            </div>
                            <div class="detail-item">
                                <label>Type:</label>
                                <span>${donation.type}</span>
                            </div>
                            <div class="detail-item">
                                <label>Status:</label>
                                <span class="status-badge ${donation.status.toLowerCase()}">${donation.status}</span>
                            </div>
                            <div class="detail-item">
                                <label>Payment Method:</label>
                                <span>${donation.paymentMethod}</span>
                            </div>
                            <div class="detail-item">
                                <label>Transaction ID:</label>
                                <span>${donation.transactionId}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="detail-section">
                        <h4>Notes</h4>
                        <p class="donation-notes">${donation.notes}</p>
                    </div>
  </div>
            `;
            
            modal.style.display = 'flex';
        }

        // Close donation modal
        function closeDonationModal() {
            document.getElementById('donationModal').style.display = 'none';
        }

        // Edit donation
        function editDonation(id) {
            alert('Edit donation functionality coming soon!');
        }

        // Print receipt
        function printReceipt(id) {
            alert('Print receipt functionality coming soon!');
        }

        // Print donation
        function printDonation() {
            window.print();
        }

        // Export donations
        function exportDonations() {
            alert('Export functionality coming soon!');
        }

        // Refresh donations
        function refreshDonations() {
            alert('Donations refreshed!');
        }

        // Initialize filters
        function initializeFilters() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    // Filter logic would go here
                });
            });
        }

        // Initialize search
        function initializeSearch() {
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#donationsTableBody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    </script>

    <style>
        /* Donation-specific styles */
        .donations-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .donations-table th {
            background: #f8fafc;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e2e8f0;
        }

        .donations-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .donations-table tr:hover {
            background: #f8fafc;
        }

        .donor-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .donor-name {
            font-weight: 600;
            color: #1e293b;
        }

        .donor-email {
            font-size: 0.85rem;
            color: #64748b;
        }

        .amount {
            font-weight: 700;
            color: #059669;
            font-size: 1.1rem;
        }

        .date {
            color: #64748b;
            font-size: 0.9rem;
        }

        .type-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-badge.onetime {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .type-badge.recurring {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge.completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .payment-method {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            background: #f8fafc;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: #e2e8f0;
            color: #475569;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h3 {
            margin: 0;
            color: #1e293b;
        }

        .table-actions {
            display: flex;
            gap: 12px;
        }

        .pagination-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding: 20px 0;
        }

        .pagination-info {
            color: #64748b;
            font-size: 0.9rem;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pagination-btn {
            padding: 8px 16px;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination-btn:hover:not(:disabled) {
            background: #f3f4f6;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-numbers {
            display: flex;
            gap: 4px;
        }

        .pagination-number {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            background: white;
            color: #374151;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination-number.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination-number:hover:not(.active) {
            background: #f3f4f6;
        }

        .pagination-ellipsis {
            padding: 8px 4px;
            color: #64748b;
        }

        /* Donation details modal */
        .donation-details {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .detail-section h4 {
            margin: 0 0 15px 0;
            color: #1e293b;
            font-size: 1.1rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-item label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-item span {
            color: #1e293b;
            font-weight: 500;
        }

        .amount-large {
            font-size: 1.3rem;
            font-weight: 700;
            color: #059669;
        }

        .donation-notes {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            color: #374151;
            font-style: italic;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
            
            .pagination-section {
                flex-direction: column;
                gap: 15px;
            }
            
            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>