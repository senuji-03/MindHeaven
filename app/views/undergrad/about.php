<?php
$TITLE = 'About - MindHeaven';
$CURRENT_PAGE = 'about';
include BASE_PATH . '/app/views/layouts/header.php';
?>

<main id="main" class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>About MindHeaven</h1>
            <p class="page-subtitle">Your Mental Health Companion</p>
        </div>

        <div class="content-grid">
            <!-- Mission Section -->
            <section class="content-card">
                <div class="card-icon">🎯</div>
                <h2>Our Mission</h2>
                <p>MindHeaven is dedicated to providing comprehensive mental health support for students and the community. We believe that mental wellness is fundamental to academic success and personal growth.</p>
            </section>

            <!-- Vision Section -->
            <section class="content-card">
                <div class="card-icon">🌟</div>
                <h2>Our Vision</h2>
                <p>To create a safe, supportive environment where every individual has access to quality mental health resources, professional counseling, and peer support networks.</p>
            </section>

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

            <!-- Contact Section -->
            <section class="content-card">
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
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
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

.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.content-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

.content-card.full-width {
    grid-column: 1 / -1;
}

.card-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    display: block;
}

.content-card h2 {
    color: #1f2937;
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.content-card p {
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.service-item {
    padding: 1.5rem;
    background: #f9fafb;
    border-radius: 8px;
    border-left: 4px solid #4f46e5;
}

.service-item h3 {
    color: #1f2937;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.service-item p {
    color: #6b7280;
    font-size: 0.9rem;
    margin: 0;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-top: 1.5rem;
}

.team-member {
    text-align: center;
    padding: 1.5rem;
    background: #f9fafb;
    border-radius: 8px;
}

.member-avatar {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.team-member h3 {
    color: #1f2937;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.team-member p {
    color: #6b7280;
    font-size: 0.9rem;
    margin: 0;
}

.values-list {
    margin-top: 1.5rem;
}

.value-item {
    padding: 1rem;
    background: #f9fafb;
    border-radius: 8px;
    margin-bottom: 1rem;
    border-left: 4px solid #10b981;
}

.value-item strong {
    color: #1f2937;
}

.contact-info {
    margin-top: 1.5rem;
}

.contact-info p {
    margin-bottom: 0.5rem;
    color: #374151;
}

@media (max-width: 768px) {
    .main-content {
        padding: 1rem;
    }
    
    .content-grid {
        grid-template-columns: 1fr;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
}
</style>

<?php include BASE_PATH . '/app/views/layouts/footer.php'; ?>
