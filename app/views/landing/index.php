<?php
$title = 'MindHeaven - Mental Health Care for Students';
ob_start();
?>

<!-- Hero Section -->
<section class="hero-section" style="margin-left: -10px; float: right; width: 100%;">
        <div class="container">
            <div class="hero-content">
            <h1 class="hero-title" style="text-align: left; margin-left: 15px;">Your Mental Health Matters</h1>
            <p class="hero-subtitle" style="text-align: leftt; margin-left: 15px;">
                MindHeaven provides comprehensive mental health support, resources, and community for undergraduate students. 
                Take control of your mental wellness journey with us.
            </p>
            <div class="hero-buttons" style="text-align: right; margin-left: 15px;">
                <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-primary hero-btn">
                    <i class="fas fa-user-plus"></i>
                    Get Started Today
                </a>
                <a href="<?php echo BASE_URL; ?>/ug/resources" class="btn btn-outline hero-btn">
                    <i class="fas fa-book"></i>
                    Explore Resources
                </a>
            </div>
        </div>
    </div>
</section>
<div style="clear: both;"></div>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-title">
            <h2>Why Choose MindHeaven?</h2>
            <p>We provide comprehensive mental health support tailored specifically for undergraduate students</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h3 class="feature-title">Professional Counseling</h3>
                    <p class="feature-description">
                        Connect with licensed mental health professionals through secure video sessions. 
                        Get personalized support for anxiety, depression, stress, and more.
                    </p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Peer Support Forum</h3>
                    <p class="feature-description">
                        Join our anonymous discussion forum where students share experiences, 
                        offer support, and build a community of understanding and empathy.
                    </p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3 class="feature-title">Self-Assessment Tools</h3>
                    <p class="feature-description">
                        Take comprehensive mental health assessments and receive instant feedback 
                        with personalized recommendations for your wellness journey.
                    </p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="feature-title">Resource Hub</h3>
                    <p class="feature-description">
                        Access curated mental health resources, articles, videos, and tools 
                        designed specifically for college students and their unique challenges.
                    </p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3 class="feature-title">24/7 Crisis Support</h3>
                    <p class="feature-description">
                        Immediate help when you need it most. Our crisis support team is available 
                        around the clock to provide emergency mental health assistance.
                    </p>
                </div>
            </div>
            
            <div class="feature-item">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Progress Tracking</h3>
                    <p class="feature-description">
                        Monitor your mental health journey with mood tracking, habit monitoring, 
                        and progress visualization tools to celebrate your growth.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">5,000+</div>
                <div class="stat-label">Students Helped</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">Licensed Counselors</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Crisis Support</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">95%</div>
                <div class="stat-label">Student Satisfaction</div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="features-section">
    <div class="container">
        <div class="section-title">
            <h2>Ready to Start Your Mental Health Journey?</h2>
            <p>Join thousands of students who have found support, community, and healing through MindHeaven</p>
        </div>
        
        <div class="cta-grid">
            <div class="cta-item">
                <div class="feature-card cta-card">
                    <div class="feature-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="feature-title">Get Started</h3>
                    <p class="feature-description">
                        Create your free account and take our mental health assessment 
                        to get personalized recommendations.
                    </p>
                    <a href="<?php echo BASE_URL; ?>/signup" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i>
                        Sign Up Now
                    </a>
                </div>
            </div>
            
            <div class="cta-item">
                <div class="feature-card cta-card">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="feature-title">Support Others</h3>
                    <p class="feature-description">
                        Help us continue providing free mental health services 
                        to students by making a donation.
                    </p>
                    <a href="<?php echo BASE_URL; ?>/donation" class="btn btn-success">
                        <i class="fas fa-donate"></i>
                        Donate Now
                    </a>
                </div>
            </div>
            
            <div class="cta-item">
                <div class="feature-card cta-card">
                    <div class="feature-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="feature-title">Join Community</h3>
                    <p class="feature-description">
                        Connect with peers in our supportive forum and share 
                        your experiences with others who understand.
                    </p>
                    <a href="<?php echo BASE_URL; ?>/ug/forum" class="btn btn-outline">
                        <i class="fas fa-users"></i>
                        Join Forum
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
require BASE_PATH.'/app/views/layouts/landing.php';
?>
