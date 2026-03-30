<?php
$title = 'MindHeaven - Mental Health Care for Students';
ob_start();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Your Mental Health Matters</h1>
            <p class="hero-subtitle">
                MindHeaven provides comprehensive mental health support, resources, and community for undergraduate
                students.
                Take control of your mental wellness journey with us.
            </p>
            <div class="hero-buttons">
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

<!-- University Donation Events Section -->
<?php if (!empty($eventsByUniversity)): ?>
    <section class="features-section" style="background-color: #f8fafc; padding-bottom: 2rem;">
        <div class="container">
            <div class="section-title">
                <h2>University Fundraising Events</h2>
                <p>Support mental health initiatives across different universities</p>
            </div>

            <?php foreach ($eventsByUniversity as $uniName => $events): ?>
                <div style="margin-bottom: 3rem;">
                    <h3
                        style="margin-bottom: 1.5rem; color: var(--primary-dark); border-bottom: 2px solid var(--border-color); padding-bottom: 0.5rem;">
                        <i class="fas fa-university"></i> <?= htmlspecialchars($uniName) ?>
                    </h3>
                    <div class="features-grid">
                        <?php foreach ($events as $event): ?>
                            <div class="feature-item">
                                <div class="feature-card"
                                    style="padding: 0; overflow: hidden; display: flex; flex-direction: column; height: 100%;">
                                    <?php if (!empty($event['image_path'])): ?>
                                        <div
                                            style="width: 100%; text-align: center; background-color: #f8fafc; border-bottom: 1px solid #e5e7eb;">
                                            <img src="<?= BASE_URL . '/' . htmlspecialchars($event['image_path']) ?>" alt="Event Image"
                                                style="max-width: 100%; height: auto; max-height: 250px; display: block; margin: 0 auto;">
                                        </div>
                                    <?php else: ?>
                                        <div
                                            style="width: 100%; height: 200px; background: var(--border-color); display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image" style="font-size: 3rem; color: #9ca3af;"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                                        <h4
                                            style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">
                                            <?= htmlspecialchars($event['event_title']) ?>
                                        </h4>
                                        <p
                                            style="color: var(--text-secondary); font-size: 0.95rem; margin-bottom: 1rem; flex-grow: 1;">
                                            <?= htmlspecialchars($event['short_description'] ?? 'Support this mental health initiative.') ?>
                                        </p>
                                        <div
                                            style="font-size: 0.85rem; color: var(--primary-color); font-weight: 600; margin-bottom: 1rem;">
                                            <i class="far fa-calendar-alt"></i> Deadline:
                                            <?= (!empty($event['event_date']) && strpos($event['event_date'], '0000') === false) ? htmlspecialchars(date('M d, Y', strtotime($event['event_date']))) : 'To be announced' ?>
                                        </div>
                                        <div style="display: flex; gap: 0.5rem; margin-top: auto;">
                                            <a href="<?= BASE_URL ?>/university-rep/events/view/<?= $event['id'] ?>"
                                                class="btn btn-outline"
                                                style="flex: 1; text-align: center; justify-content: center; padding: 0.5rem;">View
                                                Details</a>
                                            <a href="<?= BASE_URL ?>/donation?event_id=<?= $event['id'] ?>" class="btn btn-success"
                                                style="flex: 1; text-align: center; justify-content: center; padding: 0.5rem;">Donate</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

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
                    <a href="<?php echo BASE_URL; ?>/forum" class="btn btn-outline">
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
require BASE_PATH . '/app/views/layouts/landing.php';
?>