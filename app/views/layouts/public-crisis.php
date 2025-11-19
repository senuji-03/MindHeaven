<?php
$TITLE = 'Crisis Support - MindHeaven';
$CURRENT_PAGE = 'public-crisis';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $TITLE; ?></title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
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
        background: #f9fafb;
        min-height: 100vh;
    }
    
    /* Navbar Styles */
    .navbar {
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    
    .navbar-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 2rem;
    }
    
    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
        color: #4f46e5;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .navbar-nav {
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    
    .nav-link {
        color: #6b7280;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }
    
    .nav-link:hover,
    .nav-link.active {
        color: #4f46e5;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }
    
    .btn-donate {
        background: #10b981;
        color: white;
    }
    
    .btn-donate:hover {
        background: #059669;
        transform: translateY(-1px);
    }
    
    .btn-crisis {
        background: #ef4444;
        color: white;
    }
    
    .btn-crisis:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    /* Main Content */
    .main-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    /* Hero Section */
    .crisis-hero {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        text-align: center;
    }
    
    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.95;
        margin-bottom: 2rem;
    }
    
    .emergency-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .emergency-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        min-width: 200px;
        justify-content: center;
    }
    
    .emergency-btn.primary {
        background: white;
        color: #1f2937;
    }
    
    .emergency-btn.primary:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    .emergency-btn.secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    .emergency-btn.secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
    
    /* Resources Grid */
    .resources-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .crisis-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .crisis-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }
    
    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .card-header h2 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    
    .card-subtitle {
        color: #6b7280;
        font-size: 0.9rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .resource-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .resource-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }
    
    .resource-icon {
        font-size: 1.5rem;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .resource-content {
        flex: 1;
    }
    
    .resource-content h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }
    
    .resource-content p {
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }
    
    .btn-small {
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
        background: #4f46e5;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-small:hover {
        background: #4338ca;
    }
    
    .btn-outline-small {
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
        background: transparent;
        color: #4f46e5;
        border: 1px solid #4f46e5;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-outline-small:hover {
        background: #4f46e5;
        color: white;
    }
    
    /* Warning Signs */
    .warning-signs {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .warning-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 1.5rem;
    }
    
    .warning-column h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    
    .warning-list {
        list-style: none;
        padding: 0;
    }
    
    .warning-list li {
        padding: 0.75rem 1rem;
        background: #fef2f2;
        border-left: 4px solid #ef4444;
        margin-bottom: 0.5rem;
        border-radius: 0 8px 8px 0;
        color: #374151;
        font-size: 0.9rem;
    }
    
    .help-reminder {
        padding: 1rem 1.5rem;
        background: #e0f2fe;
        border-radius: 8px;
        border-left: 4px solid #0284c7;
    }
    
    .help-reminder p {
        margin: 0;
        color: #0c4a6e;
        font-size: 0.9rem;
    }
    
    /* Login Prompt */
    .login-prompt {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .login-prompt h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .login-prompt p {
        margin-bottom: 1.5rem;
        opacity: 0.9;
    }
    
    .prompt-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn-white {
        background: white;
        color: #667eea;
    }
    
    .btn-white:hover {
        background: #f8fafc;
        transform: translateY(-1px);
    }
    
    .btn-white-outline {
        background: transparent;
        color: white;
        border: 2px solid white;
    }
    
    .btn-white-outline:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    
    /* Footer */
    .footer {
        background: #1f2937;
        color: white;
        text-align: center;
        padding: 2rem;
        margin-top: 3rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .navbar-content {
            padding: 1rem;
            flex-wrap: wrap;
        }
        
        .navbar-nav {
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .main-content {
            padding: 1rem;
        }
        
        .hero-title {
            font-size: 2rem;
        }
        
        .resources-grid {
            grid-template-columns: 1fr;
        }
        
        .warning-grid {
            grid-template-columns: 1fr;
        }
        
        .emergency-buttons {
            flex-direction: column;
        }
    }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-content">
            <a href="<?php echo BASE_URL; ?>/" class="navbar-brand">
                <i class="fas fa-brain"></i>
                MindHeaven
            </a>
            
            <div class="navbar-nav">
                <a href="<?php echo BASE_URL; ?>/" class="nav-link">Home</a>
                <a href="<?php echo BASE_URL; ?>/public/resources" class="nav-link">Resource Hub</a>
                <a href="<?php echo BASE_URL; ?>/public/forum" class="nav-link">Forum Discussion</a>
                <a href="<?php echo BASE_URL; ?>/donation" class="btn btn-donate">Donate Now</a>
                <a href="<?php echo BASE_URL; ?>/public/crisis" class="btn btn-crisis active">
                    <i class="fas fa-exclamation-triangle"></i>
                    Crisis Support
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <section class="crisis-hero">
            <h1 class="hero-title">🚨 Crisis Support</h1>
            <p class="hero-subtitle">You're not alone. Help is available 24/7.</p>
            <div class="emergency-buttons">
                <a href="tel:988" class="emergency-btn primary">
                    <span>📞</span>
                    <span>
                        <strong>Call 988</strong><br>
                        <small>Suicide & Crisis Lifeline</small>
                    </span>
                </a>
                <a href="tel:911" class="emergency-btn secondary">
                    <span>🚨</span>
                    <span>
                        <strong>Call 911</strong><br>
                        <small>Emergency Services</small>
                    </span>
                </a>
            </div>
        </section>

        <!-- Login Prompt -->
        <div class="login-prompt">
            <h3>Need Immediate Support?</h3>
            <p>Login to access our live chat support, schedule appointments, and connect with trained counselors.</p>
            <div class="prompt-actions">
                <a href="<?php echo BASE_URL; ?>/login" class="btn btn-white">Login</a>
                <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-white-outline">Sign Up</a>
            </div>
        </div>

        <!-- Crisis Resources Grid -->
        <div class="resources-grid">
            <!-- Immediate Help -->
            <div class="crisis-card">
                <div class="card-header">
                    <h2>🚨 Immediate Help</h2>
                    <p class="card-subtitle">Available right now, 24/7</p>
                </div>
                <div class="card-body">
                    <div class="resource-list">
                        <div class="resource-item">
                            <div class="resource-icon">📞</div>
                            <div class="resource-content">
                                <h3>988 Suicide & Crisis Lifeline</h3>
                                <p>Free, confidential support for anyone in crisis</p>
                                <a href="tel:988" class="btn-small">Call Now</a>
                            </div>
                        </div>
                        <div class="resource-item">
                            <div class="resource-icon">💬</div>
                            <div class="resource-content">
                                <h3>Crisis Text Line</h3>
                                <p>Text HOME to 741741 for immediate support</p>
                                <a href="sms:741741&body=HOME" class="btn-outline-small">Text Now</a>
                            </div>
                        </div>
                        <div class="resource-item">
                            <div class="resource-icon">🏥</div>
                            <div class="resource-content">
                                <h3>Emergency Room</h3>
                                <p>Go to your nearest emergency room for immediate care</p>
                                <a href="tel:911" class="btn-small">Call 911</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campus Resources -->
            <div class="crisis-card">
                <div class="card-header">
                    <h2>🏫 Campus Resources</h2>
                    <p class="card-subtitle">University-specific support services</p>
                </div>
                <div class="card-body">
                    <div class="resource-list">
                        <div class="resource-item">
                            <div class="resource-icon">👥</div>
                            <div class="resource-content">
                                <h3>Counseling Center</h3>
                                <p>Professional mental health services on campus</p>
                                <a href="<?php echo BASE_URL; ?>/login" class="btn-small">Access Services</a>
                            </div>
                        </div>
                        <div class="resource-item">
                            <div class="resource-icon">🏠</div>
                            <div class="resource-content">
                                <h3>Resident Advisor (RA)</h3>
                                <p>24/7 support from trained student staff</p>
                                <a href="<?php echo BASE_URL; ?>/login" class="btn-outline-small">Contact RA</a>
                            </div>
                        </div>
                        <div class="resource-item">
                            <div class="resource-icon">👨‍⚕️</div>
                            <div class="resource-content">
                                <h3>Student Health Services</h3>
                                <p>Medical and mental health support</p>
                                <a href="<?php echo BASE_URL; ?>/login" class="btn-small">Get Help</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Online Resources -->
            <div class="crisis-card">
                <div class="card-header">
                    <h2>🌐 Online Resources</h2>
                    <p class="card-subtitle">Free and confidential support</p>
                </div>
                <div class="card-body">
                    <div class="resource-list">
                        <div class="resource-item">
                            <div class="resource-icon">💻</div>
                            <div class="resource-content">
                                <h3>Crisis Chat</h3>
                                <p>24/7 online chat support</p>
                                <a href="<?php echo BASE_URL; ?>/login" class="btn-small">Start Chat</a>
                            </div>
                        </div>
                        <div class="resource-item">
                            <div class="resource-icon">📱</div>
                            <div class="resource-content">
                                <h3>Mobile Apps</h3>
                                <p>Download crisis support apps</p>
                                <a href="<?php echo BASE_URL; ?>/public/resources" class="btn-outline-small">View Resources</a>
                            </div>
                        </div>
                        <div class="resource-item">
                            <div class="resource-icon">📚</div>
                            <div class="resource-content">
                                <h3>Self-Help Resources</h3>
                                <p>Articles, videos, and guides</p>
                                <a href="<?php echo BASE_URL; ?>/public/resources" class="btn-small">Browse</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Signs Section -->
        <section class="warning-signs">
            <div class="card-header">
                <h2>⚠️ Warning Signs to Watch For</h2>
                <p class="card-subtitle">Recognizing when you or someone else needs help</p>
            </div>
            <div class="card-body">
                <div class="warning-grid">
                    <div class="warning-column">
                        <h3>In Yourself</h3>
                        <ul class="warning-list">
                            <li>Thoughts of suicide or self-harm</li>
                            <li>Feeling hopeless or trapped</li>
                            <li>Extreme mood swings</li>
                            <li>Withdrawing from friends and activities</li>
                            <li>Changes in sleep or appetite</li>
                            <li>Increased use of alcohol or drugs</li>
                        </ul>
                    </div>
                    <div class="warning-column">
                        <h3>In Others</h3>
                        <ul class="warning-list">
                            <li>Talking about wanting to die</li>
                            <li>Giving away possessions</li>
                            <li>Saying goodbye to people</li>
                            <li>Sudden calm after depression</li>
                            <li>Isolation and withdrawal</li>
                            <li>Risky or reckless behavior</li>
                        </ul>
                    </div>
                </div>
                <div class="help-reminder">
                    <p><strong>Remember:</strong> It's okay to ask for help. Reaching out is a sign of strength, not weakness. If you or someone you know is in immediate danger, call 911 or 988 immediately.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> MindHeaven. All rights reserved. | <a href="<?php echo BASE_URL; ?>/" style="color: white;">Home</a> | <a href="<?php echo BASE_URL; ?>/public/resources" style="color: white;">Resources</a></p>
    </footer>
</body>
</html>

