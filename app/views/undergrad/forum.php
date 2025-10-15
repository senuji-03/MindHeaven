<?php
$TITLE = 'Peer Discussion Forum - MindHeaven';
$CURRENT_PAGE = 'forum';
include BASE_PATH . '/app/views/layouts/header.php';
?>

<main id="main" class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Peer Discussion Forum</h1>
            <p class="page-subtitle">Share, support, and connect with fellow students</p>
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

        <!-- Create New Thread -->
        <div class="create-thread-section">
            <button class="create-thread-btn" onclick="toggleCreateThread()">
                <span class="btn-icon">✏️</span>
                Create New Thread
            </button>
        </div>

        <!-- Create Thread Form (Hidden by default) -->
        <div id="createThreadForm" class="create-thread-form" style="display: none;">
            <div class="form-container">
                <h3>Create New Discussion Thread</h3>
                <form id="threadForm">
                    <div class="form-group">
                        <label for="threadTitle">Thread Title</label>
                        <input type="text" id="threadTitle" name="title" placeholder="Enter a descriptive title..." required>
                    </div>
                    
                    <div class="form-group">
                        <label for="threadCategory">Category</label>
                        <select id="threadCategory" name="category" required>
                            <option value="">Select a category...</option>
                            <option value="general">General Discussion</option>
                            <option value="academic">Academic Stress</option>
                            <option value="relationships">Relationships</option>
                            <option value="anxiety">Anxiety & Worry</option>
                            <option value="depression">Depression Support</option>
                            <option value="self-care">Self-Care Tips</option>
                            <option value="resources">Resources & Tools</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="threadContent">Your Message</label>
                        <textarea id="threadContent" name="content" rows="6" placeholder="Share your thoughts, ask questions, or offer support..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="anonymousPost" name="anonymous">
                            <span class="checkmark"></span>
                            Post anonymously
                        </label>
                        <small class="help-text">Your username will be hidden, but moderators can still see it for safety purposes.</small>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" onclick="toggleCreateThread()">Cancel</button>
                        <button type="submit" class="btn-primary">Create Thread</button>
                    </div>
                </form>
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
    </div>
</main>

<style>
.main-content {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.page-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem 0;
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

/* Create Thread */
.create-thread-section {
    margin-bottom: 2rem;
}

.create-thread-btn {
    background: #4f46e5;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: background-color 0.3s ease;
}

.create-thread-btn:hover {
    background: #4338ca;
}

.create-thread-form {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    margin-bottom: 2rem;
}

.form-container {
    padding: 2rem;
}

.form-container h3 {
    color: #1f2937;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #374151;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.help-text {
    display: block;
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-primary, .btn-secondary {
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #4f46e5;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #4338ca;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

/* Category Tabs */
.forum-categories {
    margin-bottom: 2rem;
}

.category-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
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
}

.tab-btn.active {
    background: #4f46e5;
    color: white;
    border-color: #4f46e5;
}

/* Threads */
.threads-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    margin-bottom: 2rem;
}

.threads-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
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
}

.threads-list {
    padding: 0;
}

.thread-item {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #f3f4f6;
    cursor: pointer;
    transition: background-color 0.3s ease;
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

@media (max-width: 768px) {
    .main-content {
        padding: 1rem;
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
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
// Toggle create thread form
function toggleCreateThread() {
    const form = document.getElementById('createThreadForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

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

// Thread form submission
document.getElementById('threadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const title = formData.get('title');
    const category = formData.get('category');
    const content = formData.get('content');
    const anonymous = formData.get('anonymous');
    
    // Simulate thread creation
    alert(`Thread "${title}" created successfully!`);
    
    // Reset form and hide it
    this.reset();
    toggleCreateThread();
    
    // In a real application, you would send this data to the server
    console.log('Thread data:', { title, category, content, anonymous });
});

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
        alert(`Opening thread: "${title}"\n\nIn a real application, this would open the full thread view.`);
    });
});
</script>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>
