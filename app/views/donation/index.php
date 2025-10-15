<?php
$title = 'Donate to MindHeaven - Support Student Mental Health';
ob_start();
?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="hero-title">Support Student Mental Health</h1>
            <p class="hero-subtitle">
                Your donation helps us provide free mental health services, counseling, and resources to undergraduate students. 
                Together, we can make mental health support accessible to all.
            </p>
        </div>
    </div>
</section>

<!-- Donation Form Section -->
<section class="features-section">
        <div class="container">
            <div class="donation-form-container">
                <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
                    <div class="alert alert-success text-center mb-4" style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; border: 1px solid #a7f3d0;">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem; margin-bottom: 0.5rem;"></i>
                        <h4>Thank You for Your Donation!</h4>
                        <p>Your contribution will help us continue providing free mental health services to students.</p>
                    </div>
                <?php endif; ?>
                
                <div class="feature-card">
                    <div class="text-center mb-4">
                        <div class="feature-icon mx-auto mb-3">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h2>Make a Donation</h2>
                        <p class="text-secondary">Every contribution makes a difference in a student's life</p>
                    </div>
                    
                    <form action="<?php echo BASE_URL; ?>/donation/submit" method="POST">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="form-group">
                                <label for="amount" class="form-label">Donation Amount *</label>
                                <select class="form-control" id="amount" name="amount" required>
                                    <option value="">Select Amount</option>
                                    <option value="25">$25 - Support one counseling session</option>
                                    <option value="50">$50 - Help maintain our crisis hotline</option>
                                    <option value="100">$100 - Fund mental health resources</option>
                                    <option value="250">$250 - Support peer support programs</option>
                                    <option value="500">$500 - Sponsor a student's full support</option>
                                    <option value="custom">Custom Amount</option>
                                </select>
                            </div>
                            <div class="form-group full-width" id="customAmountDiv" style="display: none;">
                                <label for="customAmount" class="form-label">Custom Amount ($)</label>
                                <input type="number" class="form-control" id="customAmount" name="customAmount" min="1">
                            </div>
                            <div class="form-group full-width">
                                <label for="message" class="form-label">Message (Optional)</label>
                                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Share why you're supporting MindHeaven or any message you'd like to include..."></textarea>
                            </div>
                            <div class="form-group full-width">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="anonymous" name="anonymous">
                                    <label class="form-check-label" for="anonymous">
                                        Make this donation anonymous
                                    </label>
                                </div>
                            </div>
                            <div class="form-group full-width text-center">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-donate"></i>
                                    Donate Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Impact Section -->
<section class="stats-section">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 style="color: white;">Your Impact</h2>
            <p style="color: rgba(255,255,255,0.9);">See how donations help students every day</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">$25</div>
                    <div class="stat-label">Funds one counseling session</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">$50</div>
                    <div class="stat-label">Maintains crisis hotline for 1 day</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">$100</div>
                    <div class="stat-label">Creates mental health resources</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">$500</div>
                    <div class="stat-label">Sponsors full student support</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section class="features-section">
    <div class="container">
        <div class="section-title">
            <h2>Recent Events & Fundraisers</h2>
            <p>See how our community comes together to support student mental health</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="feature-title">Mental Health Awareness Week</h3>
                    <p class="feature-description">
                        <strong>Date:</strong> March 15-22, 2024<br>
                        <strong>Raised:</strong> $15,000<br>
                        <strong>Impact:</strong> Funded 600 counseling sessions for students
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-running"></i>
                    </div>
                    <h3 class="feature-title">MindHeaven 5K Run</h3>
                    <p class="feature-description">
                        <strong>Date:</strong> February 10, 2024<br>
                        <strong>Raised:</strong> $8,500<br>
                        <strong>Impact:</strong> Supported crisis hotline operations for 2 months
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="feature-title">Alumni Giving Campaign</h3>
                    <p class="feature-description">
                        <strong>Date:</strong> January 2024<br>
                        <strong>Raised:</strong> $25,000<br>
                        <strong>Impact:</strong> Expanded peer support program to 3 more universities
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <h3 class="feature-title">Benefit Concert</h3>
                    <p class="feature-description">
                        <strong>Date:</strong> December 15, 2023<br>
                        <strong>Raised:</strong> $12,000<br>
                        <strong>Impact:</strong> Funded mental health workshops for 500 students
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="feature-title">Book Drive & Sale</h3>
                    <p class="feature-description">
                        <strong>Date:</strong> November 2023<br>
                        <strong>Raised:</strong> $3,500<br>
                        <strong>Impact:</strong> Created mental health resource library
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="feature-title">Community Fundraiser</h3>
                    <p class="feature-description">
                        <strong>Date:</strong> October 2023<br>
                        <strong>Raised:</strong> $18,000<br>
                        <strong>Impact:</strong> Launched 24/7 crisis support service
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="stats-section">
    <div class="container text-center">
        <h2 style="color: white; margin-bottom: 1rem;">Ready to Make a Difference?</h2>
        <p style="color: rgba(255,255,255,0.9); margin-bottom: 2rem; font-size: 1.1rem;">
            Your donation directly supports students in need. Every contribution helps us provide 
            free mental health services and resources.
        </p>
        <a href="#donation-form" class="btn btn-light btn-lg">
            <i class="fas fa-donate"></i>
            Donate Now
        </a>
    </div>
</section>

<style>
.form-control {
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

.form-label {
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.alert {
    border-radius: 12px;
    border: none;
}

.btn-lg {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

#donation-form {
    scroll-margin-top: 100px;
}

/* Custom Grid Layouts */
.donation-form-container {
    max-width: 800px;
    margin: 0 auto;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.text-center {
    text-align: center;
}

.text-secondary {
    color: var(--text-secondary);
}

.mb-3 {
    margin-bottom: 1rem;
}

.mb-4 {
    margin-bottom: 1.5rem;
}

.mx-auto {
    margin-left: auto;
    margin-right: auto;
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.impact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountSelect = document.getElementById('amount');
    const customAmountDiv = document.getElementById('customAmountDiv');
    const customAmountInput = document.getElementById('customAmount');
    
    amountSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customAmountDiv.style.display = 'block';
            customAmountInput.required = true;
        } else {
            customAmountDiv.style.display = 'none';
            customAmountInput.required = false;
            customAmountInput.value = '';
        }
    });
    
    // Smooth scroll to donation form
    document.querySelectorAll('a[href="#donation-form"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.querySelector('.feature-card');
            if (form) {
                form.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require BASE_PATH.'/app/views/layouts/landing.php';
?>
