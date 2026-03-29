<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindheaven - Resource Hub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        /* Navigation Bar */
        .navbar {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(30, 64, 175, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: white;
            border-radius: 50%;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e40af;
            font-weight: bold;
        }

        .nav-icons {
            display: flex;
            gap: 20px;
        }

        .nav-icon {
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s;
        }

        .nav-icon:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Container */
        .main-container {
            display: flex;
            margin-top: 80px;
            min-height: calc(100vh - 80px);
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding: 2rem 0;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-item {
            padding: 12px 24px;
            cursor: pointer;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-item:hover {
            background: #eff6ff;
            border-left-color: #2563eb;
            color: #2563eb;
        }

        .sidebar-item.active {
            background: #eff6ff;
            border-left-color: #2563eb;
            color: #2563eb;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* Header Section */
        .page-header {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.75rem;
            color: #1e293b;
            font-weight: 700;
        }

        .page-subtitle {
            color: #64748b;
            margin-top: 0.5rem;
        }

        .stats-container {
            display: flex;
            gap: 2rem;
            margin-top: 1.5rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #3b82f6;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        /* Filter Section */
        .filter-section {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .filter-group {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            color: #64748b;
        }

        .filter-btn:hover {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            border-color: transparent;
        }

        .search-box {
            flex: 1;
            min-width: 300px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        /* Resource Grid */
        .resources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .resource-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .resource-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }

        .resource-thumbnail {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            position: relative;
        }

        .resource-thumbnail.article {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .resource-thumbnail.video {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }

        .resource-thumbnail.audio {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .resource-type-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.9);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .resource-content {
            padding: 1.5rem;
        }

        .resource-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .resource-description {
            color: #64748b;
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .resource-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .tag {
            background: #eff6ff;
            color: #3b82f6;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .resource-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .resource-author {
            font-size: 0.75rem;
            color: #64748b;
        }

        .resource-date {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .resource-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .action-btn {
            flex: 1;
            padding: 0.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .btn-view {
            background: #3b82f6;
            color: white;
        }

        .btn-view:hover {
            background: #2563eb;
        }

        .btn-edit {
            background: #f59e0b;
            color: white;
        }

        .btn-edit:hover {
            background: #d97706;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        /* Add Resource Button */
        .add-resource-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.3s;
            z-index: 100;
        }

        .add-resource-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(16, 185, 129, 0.4);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background-color: white;
            margin: 3% auto;
            padding: 0;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }

        .close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 50%;
            transition: background 0.3s;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .modal-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            font-family: inherit;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .file-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f9fafb;
        }

        .file-upload-area:hover {
            border-color: #3b82f6;
            background: #f0f9ff;
        }

        .file-upload-area.active {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .upload-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #64748b;
        }

        .upload-text {
            color: #64748b;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .upload-subtext {
            font-size: 0.875rem;
            color: #94a3b8;
        }

        .file-input {
            display: none;
        }

        .file-selected {
            margin-top: 1rem;
            padding: 0.75rem;
            background: #eff6ff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .file-name {
            color: #1e40af;
            font-weight: 500;
        }

        .remove-file {
            background: #ef4444;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.75rem;
        }

        .modal-actions {
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            background: #f9fafb;
            border-radius: 0 0 12px 12px;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        /* View Resource Modal */
        .resource-detail-content {
            padding: 2rem;
        }

        .detail-header {
            margin-bottom: 2rem;
        }

        .detail-title {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .detail-meta {
            display: flex;
            gap: 2rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        .detail-section {
            margin-bottom: 2rem;
        }

        .detail-section-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.75rem;
        }

        .detail-text {
            color: #64748b;
            line-height: 1.6;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #64748b;
            margin-bottom: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                padding: 1rem;
            }

            .resources-grid {
                grid-template-columns: 1fr;
            }

            .filter-section {
                flex-direction: column;
            }

            .search-box {
                min-width: 100%;
            }

            .stats-container {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
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
                <div class="nav-icon">
                    🔔
                    <span class="badge">3</span>
                </div>
                <div class="nav-icon">
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
                <li class="sidebar-item">📅 Calendar</a></li>
                <li class="sidebar-item"><a href="appointmentmgt">🗓 Appointment Management</a></li>
                <li class="sidebar-item"><a href="sessionHistory">📋 Session History</a></li>
              
                <li class="sidebar-item active">📚 Resource Hub</li>
                <li class="sidebar-item"><a href="counselor_profile">👤 Profile</a></li>
                
                <li class="sidebar-item logout-item"><a href="<?php echo BASE_URL; ?>/logout" onclick="return confirm('Are you sure you want to logout?')">🚪 Logout</a></li>
            </ul>
        </div>


        <!-- Main Content -->
        <div class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="header-content">
                    <div style="flex: 1;">
                        <h1 class="page-title">📚 Resource Hub</h1>
                        <p class="page-subtitle">Manage and access mental health resources, articles, videos, and audio content</p>
                    </div>
                </div>
                <div class="stats-container">
                    <div class="stat-item">
                        <div class="stat-number" id="totalResources">0</div>
                        <div class="stat-label">Total Resources</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="articlesCount">0</div>
                        <div class="stat-label">Articles</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="videosCount">0</div>
                        <div class="stat-label">Videos</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="audioCount">0</div>
                        <div class="stat-label">Audio</div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-group">
                    <button class="filter-btn active" data-filter="all">All Resources</button>
                    <button class="filter-btn" data-filter="article">📄 Articles</button>
                    <button class="filter-btn" data-filter="video">🎥 Videos</button>
                    <button class="filter-btn" data-filter="audio">🎵 Audio</button>
                </div>
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" class="search-input" id="searchInput" placeholder="Search resources...">
                </div>
            </div>

            <!-- Resources Grid -->
            <div class="resources-grid" id="resourcesGrid">
                <!-- Resources will be dynamically loaded here -->
            </div>
        </div>
    </div>

    <!-- Add Resource Button -->
    <button class="add-resource-btn" onclick="showAddResourceModal()">+</button>

    <!-- Add/Edit Resource Modal -->
    <div id="resourceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Add New Resource</h3>
                <button class="close" onclick="closeModal('resourceModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="resourceForm">
                    <input type="hidden" id="resourceId">
                    
                    <div class="form-group">
                        <label class="form-label" for="resourceType">Resource Type *</label>
                        <select id="resourceType" class="form-select" required onchange="updateUploadArea()">
                            <option value="">Select Type</option>
                            <option value="article">📄 Article</option>
                            <option value="video">🎥 Video</option>
                            <option value="audio">🎵 Audio</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="resourceTitle">Title *</label>
                        <input type="text" id="resourceTitle" class="form-input" placeholder="Enter resource title" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="resourceDescription">Description *</label>
                        <textarea id="resourceDescription" class="form-textarea" placeholder="Enter resource description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="resourceCategory">Category *</label>
                        <select id="resourceCategory" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="anxiety">Anxiety Management</option>
                            <option value="depression">Depression Support</option>
                            <option value="stress">Stress Relief</option>
                            <option value="mindfulness">Mindfulness & Meditation</option>
                            <option value="relationships">Relationships</option>
                            <option value="self-care">Self-Care</option>
                            <option value="sleep">Sleep Hygiene</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Upload File</label>
                        <div class="file-upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                            <div class="upload-icon">📁</div>
                            <p class="upload-text">Click to upload or drag and drop</p>
                            <p class="upload-subtext" id="uploadSubtext">Select a file type first</p>
                        </div>
                        <input type="file" id="fileInput" class="file-input">
                        <div id="fileSelected" class="file-selected" style="display: none;">
                            <span class="file-name" id="fileName"></span>
                            <button type="button" class="remove-file" onclick="removeFile()">Remove</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="resourceUrl">Or Enter URL</label>
                        <input type="url" id="resourceUrl" class="form-input" placeholder="https://example.com/resource">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="resourceTags">Tags (comma separated)</label>
                        <input type="text" id="resourceTags" class="form-input" placeholder="mental health, wellness, self-help">
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('resourceModal')">Cancel</button>
                <button class="btn-primary" onclick="saveResource()">Save Resource</button>
            </div>
        </div>
    </div>

    <!-- View Resource Modal -->
    <div id="viewResourceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Resource Details</h3>
                <button class="close" onclick="closeModal('viewResourceModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="resource-detail-content" id="resourceDetailContent">
                    <!-- Resource details will be loaded here -->
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('viewResourceModal')">Close</button>
                <button class="btn-primary" onclick="editResourceFromView()">Edit Resource</button>
            </div>
        </div>
    </div>

    <script>
        let resources = [
            {
                id: 1,
                type: 'article',
                title: 'Understanding Anxiety: A Comprehensive Guide',
                description: 'Learn about the different types of anxiety disorders and effective coping strategies for managing anxiety symptoms.',
                category: 'anxiety',
                author: 'Dr. Sarah Mitchell',
                date: '2024-12-10',
                tags: ['relationships', 'communication', 'boundaries'],
                url: 'https://example.com/healthy-relationships'
            },
            {
                id: 5,
                type: 'video',
                title: 'Breathing Exercises for Anxiety',
                description: 'Simple breathing techniques you can use anywhere to manage anxiety and reduce stress in the moment.',
                category: 'anxiety',
                author: 'Wellness Institute',
                date: '2024-12-22',
                tags: ['anxiety', 'breathing', 'techniques'],
                url: 'https://example.com/breathing-exercises'
            },
            {
                id: 6,
                type: 'audio',
                title: 'Daily Affirmations for Self-Confidence',
                description: 'Positive affirmations to boost self-esteem and develop a more confident mindset.',
                category: 'self-care',
                author: 'Positive Minds Collective',
                date: '2024-12-19',
                tags: ['self-care', 'confidence', 'affirmations'],
                url: 'https://example.com/affirmations'
            }
        ];

        let currentFilter = 'all';
        let editingResourceId = null;
        let currentViewingResource = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderResources();
            updateStats();
            setupEventListeners();
        });

        function setupEventListeners() {
            // Filter buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.dataset.filter;
                    renderResources();
                });
            });

            // Search input
            document.getElementById('searchInput').addEventListener('input', function() {
                renderResources();
            });

            // File input
            document.getElementById('fileInput').addEventListener('change', function() {
                if (this.files.length > 0) {
                    showSelectedFile(this.files[0]);
                }
            });

            // Drag and drop
            const uploadArea = document.getElementById('uploadArea');
            
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('active');
            });

            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('active');
            });

            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('active');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    document.getElementById('fileInput').files = files;
                    showSelectedFile(files[0]);
                }
            });
        }

        function renderResources() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            let filteredResources = resources;

            // Filter by type
            if (currentFilter !== 'all') {
                filteredResources = filteredResources.filter(r => r.type === currentFilter);
            }

            // Filter by search
            if (searchTerm) {
                filteredResources = filteredResources.filter(r => 
                    r.title.toLowerCase().includes(searchTerm) ||
                    r.description.toLowerCase().includes(searchTerm) ||
                    r.category.toLowerCase().includes(searchTerm) ||
                    r.tags.some(tag => tag.toLowerCase().includes(searchTerm))
                );
            }

            const grid = document.getElementById('resourcesGrid');
            
            if (filteredResources.length === 0) {
                grid.innerHTML = `
                    <div class="empty-state" style="grid-column: 1/-1;">
                        <div class="empty-icon">📚</div>
                        <h2 class="empty-title">No resources found</h2>
                        <p class="empty-text">Try adjusting your filters or search terms, or add a new resource to get started.</p>
                        <button class="btn-primary" onclick="showAddResourceModal()">Add Resource</button>
                    </div>
                `;
                return;
            }

            grid.innerHTML = filteredResources.map(resource => `
                <div class="resource-card" data-id="${resource.id}">
                    <div class="resource-thumbnail ${resource.type}">
                        ${getResourceIcon(resource.type)}
                        <span class="resource-type-badge">${resource.type}</span>
                    </div>
                    <div class="resource-content">
                        <h3 class="resource-title">${resource.title}</h3>
                        <p class="resource-description">${resource.description}</p>
                        <div class="resource-tags">
                            ${resource.tags.slice(0, 3).map(tag => `<span class="tag">${tag}</span>`).join('')}
                        </div>
                        <div class="resource-meta">
                            <span class="resource-author">By ${resource.author}</span>
                            <span class="resource-date">${formatDate(resource.date)}</span>
                        </div>
                        <div class="resource-actions">
                            <button class="action-btn btn-view" onclick="viewResource(${resource.id})">View</button>
                            <button class="action-btn btn-edit" onclick="editResource(${resource.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteResource(${resource.id})">Delete</button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function getResourceIcon(type) {
            const icons = {
                'article': '📄',
                'video': '🎥',
                'audio': '🎵'
            };
            return icons[type] || '📁';
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }

        function updateStats() {
            document.getElementById('totalResources').textContent = resources.length;
            document.getElementById('articlesCount').textContent = resources.filter(r => r.type === 'article').length;
            document.getElementById('videosCount').textContent = resources.filter(r => r.type === 'video').length;
            document.getElementById('audioCount').textContent = resources.filter(r => r.type === 'audio').length;
        }

        function showAddResourceModal() {
            editingResourceId = null;
            document.getElementById('modalTitle').textContent = 'Add New Resource';
            document.getElementById('resourceForm').reset();
            document.getElementById('resourceId').value = '';
            resetUploadArea();
            document.getElementById('resourceModal').style.display = 'block';
        }

        function viewResource(id) {
            const resource = resources.find(r => r.id === id);
            if (!resource) return;

            currentViewingResource = resource;

            const detailContent = document.getElementById('resourceDetailContent');
            detailContent.innerHTML = `
                <div class="detail-header">
                    <h2 class="detail-title">${resource.title}</h2>
                    <div class="detail-meta">
                        <span>📁 ${resource.type.charAt(0).toUpperCase() + resource.type.slice(1)}</span>
                        <span>👤 ${resource.author}</span>
                        <span>📅 ${formatDate(resource.date)}</span>
                    </div>
                </div>
                
                <div class="detail-section">
                    <h4 class="detail-section-title">Description</h4>
                    <p class="detail-text">${resource.description}</p>
                </div>

                <div class="detail-section">
                    <h4 class="detail-section-title">Category</h4>
                    <p class="detail-text">${resource.category.charAt(0).toUpperCase() + resource.category.slice(1)}</p>
                </div>

                <div class="detail-section">
                    <h4 class="detail-section-title">Tags</h4>
                    <div class="resource-tags">
                        ${resource.tags.map(tag => `<span class="tag">${tag}</span>`).join('')}
                    </div>
                </div>

                ${resource.url ? `
                <div class="detail-section">
                    <h4 class="detail-section-title">Resource Link</h4>
                    <a href="${resource.url}" target="_blank" style="color: #3b82f6; text-decoration: none;">${resource.url}</a>
                </div>
                ` : ''}
            `;

            document.getElementById('viewResourceModal').style.display = 'block';
        }

        function editResourceFromView() {
            closeModal('viewResourceModal');
            if (currentViewingResource) {
                editResource(currentViewingResource.id);
            }
        }

        function editResource(id) {
            const resource = resources.find(r => r.id === id);
            if (!resource) return;

            editingResourceId = id;
            document.getElementById('modalTitle').textContent = 'Edit Resource';
            document.getElementById('resourceId').value = resource.id;
            document.getElementById('resourceType').value = resource.type;
            document.getElementById('resourceTitle').value = resource.title;
            document.getElementById('resourceDescription').value = resource.description;
            document.getElementById('resourceCategory').value = resource.category;
            document.getElementById('resourceUrl').value = resource.url || '';
            document.getElementById('resourceTags').value = resource.tags.join(', ');
            
            updateUploadArea();
            document.getElementById('resourceModal').style.display = 'block';
        }

        function saveResource() {
            const form = document.getElementById('resourceForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const fileInput = document.getElementById('fileInput');
            const urlInput = document.getElementById('resourceUrl');

            // Validate that either file or URL is provided
            if (!fileInput.files.length && !urlInput.value && !editingResourceId) {
                showNotification('Please upload a file or provide a URL', 'error');
                return;
            }

            const tagsValue = document.getElementById('resourceTags').value;
            const tags = tagsValue ? tagsValue.split(',').map(t => t.trim()).filter(t => t) : [];

            const resourceData = {
                id: editingResourceId || Date.now(),
                type: document.getElementById('resourceType').value,
                title: document.getElementById('resourceTitle').value,
                description: document.getElementById('resourceDescription').value,
                category: document.getElementById('resourceCategory').value,
                author: 'Current User', // This would come from session in real app
                date: new Date().toISOString().split('T')[0],
                tags: tags,
                url: urlInput.value || (fileInput.files.length > 0 ? 'uploaded-file.ext' : '')
            };

            if (editingResourceId) {
                // Update existing resource
                const index = resources.findIndex(r => r.id === editingResourceId);
                if (index !== -1) {
                    // Preserve original author and date if editing
                    resourceData.author = resources[index].author;
                    resourceData.date = resources[index].date;
                    resources[index] = resourceData;
                    showNotification('Resource updated successfully!', 'success');
                }
            } else {
                // Add new resource
                resources.unshift(resourceData);
                showNotification('Resource added successfully!', 'success');
            }

            closeModal('resourceModal');
            renderResources();
            updateStats();
        }

        function deleteResource(id) {
            if (!confirm('Are you sure you want to delete this resource? This action cannot be undone.')) {
                return;
            }

            resources = resources.filter(r => r.id !== id);
            renderResources();
            updateStats();
            showNotification('Resource deleted successfully!', 'success');
        }

        function updateUploadArea() {
            const type = document.getElementById('resourceType').value;
            const subtext = document.getElementById('uploadSubtext');
            const fileInput = document.getElementById('fileInput');
            
            if (!type) {
                subtext.textContent = 'Select a file type first';
                fileInput.accept = '*/*';
                return;
            }

            const acceptTypes = {
                'article': '.pdf,.doc,.docx,.txt',
                'video': '.mp4,.avi,.mov,.wmv,.webm',
                'audio': '.mp3,.wav,.ogg,.m4a'
            };

            fileInput.accept = acceptTypes[type] || '*/*';
            subtext.textContent = `Accepted formats: ${acceptTypes[type] || 'All files'}`;
        }

        function showSelectedFile(file) {
            document.getElementById('uploadArea').style.display = 'none';
            document.getElementById('fileSelected').style.display = 'flex';
            document.getElementById('fileName').textContent = file.name;
        }

        function removeFile() {
            document.getElementById('fileInput').value = '';
            document.getElementById('uploadArea').style.display = 'block';
            document.getElementById('fileSelected').style.display = 'none';
            resetUploadArea();
        }

        function resetUploadArea() {
            document.getElementById('uploadArea').classList.remove('active');
            document.getElementById('uploadArea').style.display = 'block';
            document.getElementById('fileSelected').style.display = 'none';
            document.getElementById('fileInput').value = '';
            updateUploadArea();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            if (modalId === 'resourceModal') {
                editingResourceId = null;
            }
            if (modalId === 'viewResourceModal') {
                currentViewingResource = null;
            }
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6';
            
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                padding: 1rem 1.5rem;
                background: ${bgColor};
                color: white;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                z-index: 3000;
                animation: slideInRight 0.3s ease-out;
                max-width: 300px;
                font-weight: 500;
            `;
            
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
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

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    if (modal.id === 'resourceModal') {
                        closeModal('resourceModal');
                    } else if (modal.id === 'viewResourceModal') {
                        closeModal('viewResourceModal');
                    }
                }
            });
        };

        // Keyboard shortcuts
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const resourceModal = document.getElementById('resourceModal');
                const viewModal = document.getElementById('viewResourceModal');
                
                if (resourceModal.style.display === 'block') {
                    closeModal('resourceModal');
                } else if (viewModal.style.display === 'block') {
                    closeModal('viewResourceModal');
                }
            }
            
            if (event.key === '+' && event.ctrlKey) {
                event.preventDefault();
                showAddResourceModal();
            }
        });
    </script>
</body>
</html>