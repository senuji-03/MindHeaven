<?php
$TITLE = 'About - MindHeaven';
$CURRENT_PAGE = 'about';
include BASE_PATH . '/app/views/layouts/header.php';
?>

<main id="main" class="main-content">
    <div class="container">
        <div class="about-hero">
            <div class="hero-content">
                <h1>About MindHeaven</h1>
                <p class="hero-subtitle">Your Mental Health Companion</p>
            </div>
        </div>

        <div class="mission-vision-row">
            <!-- Mission Section -->
            <section class="content-card text-center">
                <div class="card-icon">🎯</div>
                <h2>Our Mission</h2>
                <p>MindHeaven is dedicated to providing comprehensive mental health support for students and the community. We believe that mental wellness is fundamental to academic success and personal growth.</p>
            </section>

            <!-- Vision Section -->
            <section class="content-card text-center">
                <div class="card-icon">🌟</div>
                <h2>Our Vision</h2>
                <p>To create a safe, supportive environment where every individual has access to quality mental health resources, professional counseling, and peer support networks.</p>
            </section>
        </div>

        <div class="content-grid">
            <!-- Services Section -->
            <section class="content-card full-width">
                <div class="card-icon">🛠️</div>
                <h2>Our Services</h2>
                <div class="services-grid">
                    <div class="service-item">
                        <h3>📅 Counseling Sessions</h3>
                        <p>Professional one-on-one counseling with licensed mental health professionals.</p>
                    </div>
                    <div class="service-item">
                        <h3>📊 Mood Tracking</h3>
                        <p>Monitor your emotional well-being with our comprehensive mood tracking tools.</p>
                    </div>
                    <div class="service-item">
                        <h3>✅ Habit Building</h3>
                        <p>Develop positive mental health habits with guided tracking and support.</p>
                    </div>
                    <div class="service-item">
                        <h3>💬 Peer Support</h3>
                        <p>Connect with fellow students in our anonymous discussion forums.</p>
                    </div>
                    <div class="service-item">
                        <h3>📚 Resources</h3>
                        <p>Access a comprehensive library of mental health resources and guides.</p>
                    </div>
                    <div class="service-item">
                        <h3>🆘 Crisis Support</h3>
                        <p>24/7 crisis intervention and emergency mental health support.</p>
                    </div>
                </div>
            </section>

            <!-- Team Section -->
            <section class="content-card full-width">
                <div class="card-icon">👥</div>
                <h2>Our Team</h2>
                <div class="team-grid">
                    <div class="team-member">
                        <div class="member-avatar">👨‍⚕️</div>
                        <h3>Licensed Counselors</h3>
                        <p>Professional mental health counselors with years of experience in student support.</p>
                    </div>
                    <div class="team-member">
                        <div class="member-avatar">👩‍💼</div>
                        <h3>Support Staff</h3>
                        <p>Dedicated support staff ensuring smooth access to all our services.</p>
                    </div>
                    <div class="team-member">
                        <div class="member-avatar">👨‍💻</div>
                        <h3>Technical Team</h3>
                        <p>Technology experts maintaining our secure and user-friendly platform.</p>
                    </div>
                </div>
            </section>

            <!-- Values Section -->
            <section class="content-card full-width">
                <div class="card-icon">💎</div>
                <h2>Our Values</h2>
                <div class="values-list">
                    <div class="value-item">
                        <strong>Confidentiality:</strong> Your privacy and confidentiality are our top priorities.
                    </div>
                    <div class="value-item">
                        <strong>Accessibility:</strong> Mental health support should be accessible to everyone.
                    </div>
                    <div class="value-item">
                        <strong>Empathy:</strong> We approach every interaction with understanding and compassion.
                    </div>
                    <div class="value-item">
                        <strong>Innovation:</strong> We continuously improve our services using the latest research and technology.
                    </div>
                    <div class="value-item">
                        <strong>Community:</strong> We foster a supportive community where everyone belongs.
                    </div>
                </div>
            </section>

            </section>
        </div>

        <!-- Contact Section -->
        <div class="contact-row">
            <section class="content-card text-center">
                <div class="card-icon">📞</div>
                <h2>Get in Touch</h2>
                <p>Have questions or need support? We're here to help.</p>
                <div class="contact-info">
                    <p><strong>📧 Email:</strong> support@mindheaven.edu</p>
                    <p><strong>📱 Phone:</strong> (555) 123-HELP</p>
                    <p><strong>🕒 Hours:</strong> Mon-Fri 8AM-8PM, Sat 9AM-5PM</p>
                </div>
            </section>
        </div>
    </div>
</main>

<style>
.main-content {
    padding: 16px 28px !important;
    max-width: 1200px !important;
    margin: 0 auto;
    box-sizing: border-box;
    width: 100%;
}

.about-hero {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, var(--primary-light) 100%);
    color: white;
    text-align: left;
    padding: 20px 28px;
    border-radius: var(--radius-lg);
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}

.about-hero::after {
    content: '';
    position: absolute;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: rgba(232,168,124,0.15);
    bottom: -40px;
    left: 15%;
    z-index: 0;
}

.hero-content {
    position: relative;
    z-index: 1;
}

.about-hero h1 {
    font-size: 2.1rem;
    margin-bottom: 6px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
}

.about-hero .hero-subtitle {
    font-size: 0.95rem;
    opacity: 0.95;
    font-weight: 500;
    margin: 0;
    color: rgba(255,255,255,0.85);
}

.mission-vision-row,
.contact-row {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 24px;
    margin-bottom: 24px;
}

.mission-vision-row .content-card,
.contact-row .content-card {
    flex: 1 1 350px;
    max-width: 500px;
}

.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

.content-card {
    background: var(--surface);
    padding: 32px;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
    transition: all 0.2s ease;
}

.content-card.full-width {
    grid-column: 1 / -1;
}

.card-icon {
    font-size: 2.5rem;
    margin-bottom: 16px;
    display: block;
}

.content-card h2 {
    color: var(--text-primary);
    margin-bottom: 16px;
    font-size: 1.5rem;
    font-weight: 700;
}

.content-card p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 16px;
}

.text-center {
    text-align: center;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
    margin-top: 24px;
}

.service-item {
    padding: 24px;
    background: var(--bg-mid);
    border-radius: var(--radius-md);
    border-left: 4px solid var(--primary);
    transition: all 0.2s ease;
}

.service-item:hover {
    background: var(--surface);
    box-shadow: var(--shadow-sm);
    border-color: var(--primary-light);
}

.service-item h3 {
    color: var(--text-primary);
    margin-bottom: 8px;
    font-size: 1.1rem;
    font-weight: 700;
}

.service-item p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 32px;
    margin-top: 24px;
}

.team-member {
    text-align: center;
    padding: 24px;
    background: var(--bg-mid);
    border-radius: var(--radius-md);
    border: 1px solid var(--border);
}

.member-avatar {
    font-size: 3rem;
    margin-bottom: 16px;
}

.team-member h3 {
    color: var(--text-primary);
    margin-bottom: 8px;
    font-size: 1.1rem;
    font-weight: 700;
}

.team-member p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
}

.values-list {
    margin-top: 24px;
}

.value-item {
    padding: 16px;
    background: var(--bg-mid);
    border-radius: var(--radius-md);
    margin-bottom: 16px;
    border-left: 4px solid var(--success);
}

.value-item strong {
    color: var(--text-primary);
}

.contact-info {
    margin-top: 24px;
}

.contact-info p {
    margin-bottom: 8px;
    color: var(--text-primary);
}

@media (max-width: 768px) {
    .main-content {
        padding: 16px;
    }
    
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .about-hero h1 {
        font-size: 2rem;
    }
}
</style>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>
