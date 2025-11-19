<?php
$TITLE = 'Public Discussion Forum - MindHeaven';
$CURRENT_PAGE = 'public-forum';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $TITLE; ?></title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/MindHeaven/public/css/Admin/style.css">
    <link rel="stylesheet" href="/MindHeaven/public/css/public/forum.css">
    
    <style>
    /* Global Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        line-height: 1.6;
        color: #1f2937;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        overflow-x: hidden;
        scroll-behavior: smooth;
        margin: 0;
        padding: 0;
    }
    
    .container {
        width: 100%;
        margin: 0;
        padding: 0 1rem;
        width: 100%;
    }
    
    /* Navbar Styles */
    .navbar {
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
        flex-shrink: 0;
        width: 100%;
    }
    
    .navbar-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 0;
        width: 100%;
        margin: 0;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        color: #4f46e5;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }
    
    .navbar-nav {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex: 1;
        justify-content: center;
    }
    
    .nav-link {
        color: #6b7280;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
        white-space: nowrap;
    }
    
    .nav-link:hover,
    .nav-link.active {
        color: #4f46e5;
    }
    
    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        white-space: nowrap;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary {
        background: #4f46e5;
        color: white;
    }
    
    .btn-primary:hover {
        background: #4338ca;
    }
    
    .btn-outline {
        background: transparent;
        color: #4f46e5;
        border: 2px solid #4f46e5;
    }
    
    .btn-outline:hover {
        background: #4f46e5;
        color: white;
    }
    
    .btn-donate {
        background: #10b981;
        color: white;
    }
    
    .btn-donate:hover {
        background: #059669;
    }
    
    .btn-crisis {
        background: #dc2626;
        color: white;
    }
    
    .btn-crisis:hover {
        background: #b91c1c;
    }
    
    .profile-dropdown {
        position: relative;
    }
    
    .btn-profile {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .profile-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        min-width: 200px;
        display: none;
        z-index: 1000;
    }
    
    .profile-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        color: #374151;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .profile-item:hover {
        background: #f9fafb;
    }
    
    /* Main Content */
    main {
        flex: 1;
        width: 100%;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .main-content {
        width: 100%;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    /* Footer Styles */
    .footer {
        background: #1f2937;
        color: white;
        padding: 3rem 0 1rem;
        margin-top: auto;
        flex-shrink: 0;
    }
    
    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    
    .footer-section h5 {
        margin-bottom: 1rem;
        color: #f9fafb;
    }
    
    .footer-section p {
        margin-bottom: 0.5rem;
    }
    
    .footer-section a {
        color: #d1d5db;
        text-decoration: none;
    }
    
    .footer-section a:hover {
        color: white;
    }
    
    .footer-bottom {
        border-top: 1px solid #374151;
        padding-top: 1rem;
        text-align: center;
        color: #9ca3af;
    }
    
    /* Ensure scrolling works properly */
    html {
        overflow-x: hidden;
        overflow-y: auto;
        scroll-behavior: smooth;
    }
    
    /* Hide scrollbar while maintaining scroll functionality */
    html {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE and Edge */
    }
    
    html::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
    }
    
    body {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE and Edge */
    }
    
    body::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
    }
    
    /* Override any conflicting styles from external CSS */
    .main-content * {
        box-sizing: border-box;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .navbar-content {
            flex-direction: column;
            gap: 1rem;
        }
        
        .navbar-nav {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .navbar-actions {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="<?php echo BASE_URL; ?>/" class="navbar-brand">
                    <i class="fas fa-heart"></i>
                    MindHeaven
                </a>
                
                <div class="navbar-nav">
                    <a href="<?php echo BASE_URL; ?>/" class="nav-link">Home</a>
                    <a href="<?php echo BASE_URL; ?>/public/resources" class="nav-link">Resource Hub</a>
                    <a href="<?php echo BASE_URL; ?>/public/forum" class="nav-link active">Forum Discussion</a>
                    <a href="<?php echo BASE_URL; ?>/donation" class="btn btn-donate">Donate Now</a>
                    <a href="<?php echo BASE_URL; ?>/ug/crisis" class="btn btn-crisis">
                        <i class="fas fa-exclamation-triangle"></i>
                        Crisis Support
                    </a>
                </div>
                
                <div class="navbar-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Profile Dropdown -->
                        <div class="profile-dropdown">
                            <button class="btn btn-profile" onclick="toggleProfileDropdown()">
                                <i class="fas fa-user-circle"></i>
                                <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="profile-menu" id="profileMenu">
                                <a href="<?php echo BASE_URL; ?>/ug" class="profile-item">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </a>
                                <a href="<?php echo BASE_URL; ?>/ug/profile" class="profile-item">
                                    <i class="fas fa-user"></i>
                                    Profile
                                </a>
                                <a href="<?php echo BASE_URL; ?>/logout" class="profile-item">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline">Log In</a>
                        <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-primary">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

<main id="main" class="main-content">
        <div class="page-header">
            <h1>Public Discussion Forum</h1>
            <p class="page-subtitle">Share, support, and connect with fellow students - No login required</p>
        </div>

        <!-- Forum Stats -->
        <div class="forum-stats">
            <div class="stat-card">
                <div class="stat-number">24</div>
                <div class="stat-label">Active Threads</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">156</div>
                <div class="stat-label">Total Posts</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Online Now</div>
            </div>
        </div>

        <!-- Login Prompt -->
        <div class="login-prompt">
            <div class="prompt-content">
                <h3>Want to participate in discussions?</h3>
                <p>Login to create new threads, reply to posts, and access all forum features.</p>
                <div class="prompt-actions">
                    <a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary">Login</a>
                    <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-outline">Sign Up</a>
                </div>
            </div>
        </div>

        <!-- Forum Categories -->
        <div class="forum-categories">
            <div class="category-tabs">
                <button class="tab-btn active" data-category="all">All Threads</button>
                <button class="tab-btn" data-category="general">General</button>
                <button class="tab-btn" data-category="academic">Academic</button>
                <button class="tab-btn" data-category="relationships">Relationships</button>
                <button class="tab-btn" data-category="anxiety">Anxiety</button>
                <button class="tab-btn" data-category="depression">Depression</button>
                <button class="tab-btn" data-category="self-care">Self-Care</button>
                <button class="tab-btn" data-category="resources">Resources</button>
            </div>
        </div>

        <!-- Threads List -->
        <div class="threads-container">
            <div class="threads-header">
                <h3>Discussion Threads</h3>
                <div class="sort-options">
                    <select id="sortThreads">
                        <option value="recent">Most Recent</option>
                        <option value="popular">Most Popular</option>
                        <option value="replies">Most Replies</option>
                    </select>
                </div>
            </div>

            <div class="threads-list" id="threadsList">
                <!-- Sample Threads -->
                <div class="thread-item" data-category="academic">
                    <div class="thread-header">
                        <div class="thread-title">
                            <h4>Struggling with exam anxiety</h4>
                            <span class="category-badge academic">Academic</span>
                        </div>
                        <div class="thread-meta">
                            <span class="author">Anonymous</span>
                            <span class="timestamp">2 hours ago</span>
                        </div>
                    </div>
                    <div class="thread-preview">
                        <p>I have my finals coming up next week and I'm feeling really overwhelmed. Any tips for managing exam stress?</p>
                    </div>
                    <div class="thread-stats">
                        <span class="replies">8 replies</span>
                        <span class="views">24 views</span>
                        <span class="last-activity">Last reply 30 min ago</span>
                    </div>
                    <div class="thread-actions">
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline btn-small">Login to Reply</a>
                    </div>
                </div>

                <div class="thread-item" data-category="general">
                    <div class="thread-header">
                        <div class="thread-title">
                            <h4>Study group for CS students</h4>
                            <span class="category-badge general">General</span>
                        </div>
                        <div class="thread-meta">
                            <span class="author">CSStudent2024</span>
                            <span class="timestamp">5 hours ago</span>
                        </div>
                    </div>
                    <div class="thread-preview">
                        <p>Looking to form a study group for CS 101. Anyone interested in meeting twice a week?</p>
                    </div>
                    <div class="thread-stats">
                        <span class="replies">12 replies</span>
                        <span class="views">45 views</span>
                        <span class="last-activity">Last reply 1 hour ago</span>
                    </div>
                    <div class="thread-actions">
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline btn-small">Login to Reply</a>
                    </div>
                </div>

                <div class="thread-item" data-category="self-care">
                    <div class="thread-header">
                        <div class="thread-title">
                            <h4>Morning routine that changed my life</h4>
                            <span class="category-badge self-care">Self-Care</span>
                        </div>
                        <div class="thread-meta">
                            <span class="author">Anonymous</span>
                            <span class="timestamp">1 day ago</span>
                        </div>
                    </div>
                    <div class="thread-preview">
                        <p>I started a simple 10-minute morning routine and it's made such a difference in my mental health. Sharing what works for me...</p>
                    </div>
                    <div class="thread-stats">
                        <span class="replies">15 replies</span>
                        <span class="views">67 views</span>
                        <span class="last-activity">Last reply 2 hours ago</span>
                    </div>
                    <div class="thread-actions">
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline btn-small">Login to Reply</a>
                    </div>
                </div>

                <div class="thread-item" data-category="relationships">
                    <div class="thread-header">
                        <div class="thread-title">
                            <h4>Feeling isolated in college</h4>
                            <span class="category-badge relationships">Relationships</span>
                        </div>
                        <div class="thread-meta">
                            <span class="author">Anonymous</span>
                            <span class="timestamp">2 days ago</span>
                        </div>
                    </div>
                    <div class="thread-preview">
                        <p>I'm a freshman and having trouble making friends. Everyone seems to have their groups already. Any advice?</p>
                    </div>
                    <div class="thread-stats">
                        <span class="replies">23 replies</span>
                        <span class="views">89 views</span>
                        <span class="last-activity">Last reply 4 hours ago</span>
                    </div>
                    <div class="thread-actions">
                        <a href="<?php echo BASE_URL; ?>/login" class="btn btn-outline btn-small">Login to Reply</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-time Activity Feed -->
        <div class="activity-feed">
            <h3>Recent Activity</h3>
            <div class="activity-list" id="activityList">
                <div class="activity-item">
                    <span class="activity-icon">💬</span>
                    <span class="activity-text">New reply in "Struggling with exam anxiety"</span>
                    <span class="activity-time">2 min ago</span>
                </div>
                <div class="activity-item">
                    <span class="activity-icon">📝</span>
                    <span class="activity-text">New thread: "Tips for better sleep"</span>
                    <span class="activity-time">15 min ago</span>
                </div>
                <div class="activity-item">
                    <span class="activity-icon">👍</span>
                    <span class="activity-text">5 new likes on "Morning routine" thread</span>
                    <span class="activity-time">1 hour ago</span>
                </div>
            </div>
        </div>
</main>

<style>
.main-content {
    padding: 2rem;
    width: 100%;
    margin: 0 auto;
    background: #f8fafc;
    min-height: 100vh;
    max-width: 1200px;
}

.page-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem 0;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.page-header h1 {
    font-size: 2.5rem;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.2rem;
    color: #6b7280;
    margin: 0;
}

/* Forum Stats */
.forum-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #4f46e5;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6b7280;
    font-size: 0.9rem;
}

/* Login Prompt */
.login-prompt {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.prompt-content h3 {
    margin: 0 0 1rem 0;
    font-size: 1.5rem;
}

.prompt-content p {
    margin: 0 0 1.5rem 0;
    opacity: 0.9;
}

.prompt-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Category Tabs */
.forum-categories {
    margin-bottom: 2rem;
}

.category-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

.tab-btn {
    padding: 0.75rem 1.5rem;
    border: 1px solid #d1d5db;
    background: white;
    color: #6b7280;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.tab-btn:hover {
    background: #f9fafb;
    color: #374151;
    transform: translateY(-1px);
}

.tab-btn.active {
    background: #4f46e5;
    color: white;
    border-color: #4f46e5;
    transform: translateY(-1px);
}

/* Threads */
.threads-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    margin-bottom: 2rem;
    overflow: hidden;
}

.threads-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
}

.threads-header h3 {
    color: #1f2937;
    margin: 0;
}

.sort-options select {
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: white;
    color: #374151;
}

.threads-list {
    padding: 0;
}

.thread-item {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #f3f4f6;
    transition: background-color 0.3s ease;
    cursor: pointer;
}

.thread-item:hover {
    background: #f9fafb;
}

.thread-item:last-child {
    border-bottom: none;
}

.thread-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.thread-title {
    flex: 1;
}

.thread-title h4 {
    color: #1f2937;
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.category-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.category-badge.general { background: #dbeafe; color: #1e40af; }
.category-badge.academic { background: #fef3c7; color: #92400e; }
.category-badge.relationships { background: #fce7f3; color: #be185d; }
.category-badge.anxiety { background: #fef2f2; color: #dc2626; }
.category-badge.depression { background: #f3f4f6; color: #374151; }
.category-badge.self-care { background: #d1fae5; color: #065f46; }
.category-badge.resources { background: #e0e7ff; color: #3730a3; }

.thread-meta {
    text-align: right;
    color: #6b7280;
    font-size: 0.875rem;
}

.thread-meta .author {
    display: block;
    font-weight: 600;
}

.thread-meta .timestamp {
    display: block;
}

.thread-preview {
    color: #6b7280;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.thread-stats {
    display: flex;
    gap: 1rem;
    color: #9ca3af;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.thread-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

/* Activity Feed */
.activity-feed {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
}

.activity-feed h3 {
    color: #1f2937;
    margin-bottom: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
    transition: background-color 0.3s ease;
}

.activity-item:hover {
    background: #f9fafb;
    border-radius: 6px;
    margin: 0 -0.5rem;
    padding: 0.75rem 0.5rem;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    font-size: 1.2rem;
}

.activity-text {
    flex: 1;
    color: #374151;
}

.activity-time {
    color: #9ca3af;
    font-size: 0.875rem;
}

/* Buttons */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn-primary {
    background: #4f46e5;
    color: white;
}

.btn-primary:hover {
    background: #4338ca;
    transform: translateY(-2px);
}

.btn-outline {
    background: transparent;
    color: #4f46e5;
    border: 2px solid #4f46e5;
}

.btn-outline:hover {
    background: #4f46e5;
    color: white;
    transform: translateY(-2px);
}

.btn-small {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-content {
        padding: 1rem;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .thread-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .thread-meta {
        text-align: left;
    }
    
    .category-tabs {
        justify-content: center;
    }
    
    .prompt-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .threads-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .sort-options {
        align-self: center;
    }
    
    .thread-actions {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .forum-stats {
        grid-template-columns: 1fr;
    }
    
    .category-tabs {
        flex-direction: column;
        align-items: center;
    }
    
    .tab-btn {
        width: 100%;
        max-width: 200px;
    }
}
</style>

<script>
// Category filtering
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        // Add active class to clicked button
        this.classList.add('active');
        
        const category = this.dataset.category;
        filterThreads(category);
    });
});

function filterThreads(category) {
    const threads = document.querySelectorAll('.thread-item');
    threads.forEach(thread => {
        if (category === 'all' || thread.dataset.category === category) {
            thread.style.display = 'block';
        } else {
            thread.style.display = 'none';
        }
    });
}

// Sort threads
document.getElementById('sortThreads').addEventListener('change', function() {
    const sortBy = this.value;
    // In a real application, you would sort the threads based on the selected option
    console.log('Sorting by:', sortBy);
});

// Simulate real-time activity updates
function updateActivity() {
    const activities = [
        { icon: '💬', text: 'New reply in discussion thread', time: '1 min ago' },
        { icon: '📝', text: 'New thread created', time: '5 min ago' },
        { icon: '👍', text: 'New like on thread', time: '10 min ago' },
        { icon: '👥', text: 'New user joined forum', time: '15 min ago' }
    ];
    
    const randomActivity = activities[Math.floor(Math.random() * activities.length)];
    
    // Add new activity to the top
    const activityList = document.getElementById('activityList');
    const newActivity = document.createElement('div');
    newActivity.className = 'activity-item';
    newActivity.innerHTML = `
        <span class="activity-icon">${randomActivity.icon}</span>
        <span class="activity-text">${randomActivity.text}</span>
        <span class="activity-time">${randomActivity.time}</span>
    `;
    
    activityList.insertBefore(newActivity, activityList.firstChild);
    
    // Remove oldest activity if more than 5
    if (activityList.children.length > 5) {
        activityList.removeChild(activityList.lastChild);
    }
}

// Update activity every 30 seconds
setInterval(updateActivity, 30000);

// Thread click handler
document.querySelectorAll('.thread-item').forEach(thread => {
    thread.addEventListener('click', function() {
        const title = this.querySelector('h4').textContent;
        alert(`Opening thread: "${title}"\n\nPlease login to view full thread and participate in discussions.`);
    });
});
</script>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5>MindHeaven</h5>
                    <p>Providing comprehensive mental health support for undergraduate students. Your mental wellness is our priority.</p>
                </div>
                
                <div class="footer-section">
                    <h5>Quick Links</h5>
                    <p><a href="<?php echo BASE_URL; ?>/">Home</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/public/resources">Resource Hub</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/public/forum">Forum Discussion</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/donation">Donate</a></p>
                </div>
                
                <div class="footer-section">
                    <h5>Support</h5>
                    <p><a href="<?php echo BASE_URL; ?>/ug/crisis">Crisis Support</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/ug/about">About Us</a></p>
                    <p><a href="<?php echo BASE_URL; ?>/ug/contact">Contact</a></p>
                </div>
                
                <div class="footer-section">
                    <h5>Emergency</h5>
                    <p><a href="tel:988">988 Suicide & Crisis Lifeline</a></p>
                    <p><a href="tel:911">Emergency Services: 911</a></p>
                    <p><a href="sms:741741">Crisis Text Line: Text HOME to 741741</a></p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 MindHeaven. All rights reserved. | <a href="<?php echo BASE_URL; ?>/privacy">Privacy Policy</a> | <a href="<?php echo BASE_URL; ?>/terms">Terms of Service</a></p>
            </div>
        </div>
    </footer>

    
    <script>
    // Profile dropdown functionality
    function toggleProfileDropdown() {
        const menu = document.getElementById('profileMenu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.profile-dropdown');
        const menu = document.getElementById('profileMenu');
        if (dropdown && !dropdown.contains(event.target)) {
            menu.style.display = 'none';
        }
    });
    </script>
</body>
</html>
