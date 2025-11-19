<?php
$title = 'Donate to MindHeaven - Support Student Mental Health';
ob_start();
?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="hero-title" style="text-align: center;" >Support Student Mental Health</h1>
            <p class="hero-subtitle" style="text-align: center; margin-left: 700px; ">
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
                                <label for="university" class="form-label">Select University to Donate *</label>
                                <select class="form-control" id="university" name="university" required>
                                    <option value="">Select University</option>
                                    <option value="university-of-colombo">University of Colombo</option>
                                    <option value="university-of-peradeniya">University of Peradeniya</option>
                                    <option value="university-of-kelaniya">University of Kelaniya</option>
                                    <option value="university-of-moratuwa">University of Moratuwa</option>
                                    <option value="university-of-jaffna">University of Jaffna</option>
                                    <option value="university-of-ruhuna">University of Ruhuna</option>
                                    <option value="university-of-sri-jayewardenepura">University of Sri Jayewardenepura</option>
                                    <option value="university-of-rajarata">University of Rajarata</option>
                                    <option value="university-of-sabaragamuwa">University of Sabaragamuwa</option>
                                    <option value="university-of-wayamba">University of Wayamba</option>
                                    <option value="university-of-south-eastern-sri-lanka">University of South Eastern Sri Lanka</option>
                                    <option value="university-of-vavuniya">University of Vavuniya</option>
                                    <option value="university-of-batticaloa">University of Batticaloa</option>
                                    <option value="eastern-university-sri-lanka">Eastern University Sri Lanka</option>
                                    <option value="open-university-sri-lanka">Open University Sri Lanka</option>
                                    <option value="university-of-visual-performing-arts">University of Visual and Performing Arts</option>
                                    <option value="general-sir-john-kotelawala-defence-university">General Sir John Kotelawala Defence University</option>
                                    <option value="buddhist-pali-university">Buddhist and Pali University</option>
                                    <option value="other">Other University</option>
                                </select>
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
                                        Send me a payment confirmation message from university
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="anonymous" name="anonymous">
                                    <label class="form-check-label" for="anonymous">
                                        Need your donation history to be issued 
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

<!-- Mental Awareness Session Event -->
<section class="features-section" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
    <div class="container">
        <div class="event-card">
            <div class="event-header">
                <div class="event-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <div class="event-info">
                    <h2 class="event-title">Mental Awareness Session</h2>
                    <p class="event-description">Support our upcoming mental health awareness session for university students</p>
                </div>
            </div>
            
            <div class="funding-progress">
                <div class="progress-info">
                    <div class="progress-stats">
                        <span class="amount-raised">$8,250</span>
                        <span class="amount-target">of $15,000 goal</span>
                    </div>
                    <div class="progress-percentage">55%</div>
                </div>
                
                <div class="progress-bar-container">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 55%;"></div>
                    </div>
                </div>
                
                <div class="progress-details">
                    <div class="detail-item">
                        <i class="fas fa-users"></i>
                        <span>127 donors</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar"></i>
                        <span>15 days left</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-graduation-cap"></i>
                        <span>5 universities</span>
                    </div>
                </div>
            </div>
            
            <div class="event-details">
                <h3>About This Event</h3>
                <p>This mental awareness session will bring together students from 5 universities to learn about mental health, coping strategies, and available resources. Your donation helps us:</p>
                <ul class="benefits-list">
                    <li><i class="fas fa-check"></i> Cover venue and equipment costs</li>
                    <li><i class="fas fa-check"></i> Provide educational materials</li>
                    <li><i class="fas fa-check"></i> Bring in expert speakers</li>
                    <li><i class="fas fa-check"></i> Offer refreshments and networking</li>
                </ul>
            </div>
            
            <div class="event-actions">
                <a href="#donation-form" class="btn btn-primary btn-lg donate-event-btn">
                    <i class="fas fa-donate"></i>
                    Donate to Event
                </a>
                <button class="btn btn-outline btn-lg share-btn">
                    <i class="fas fa-share"></i>
                    Share Event
                </button>
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

/* Event Card Styles */
.event-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin: 2rem 0;
    border: 1px solid #e5e7eb;
}

.event-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.event-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.event-title {
    color: #1f2937;
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.event-description {
    color: #6b7280;
    font-size: 1.1rem;
    margin: 0;
}

/* Funding Progress Styles */
.funding-progress {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e5e7eb;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.progress-stats {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.amount-raised {
    font-size: 1.5rem;
    font-weight: 700;
    color: #10b981;
}

.amount-target {
    font-size: 0.9rem;
    color: #6b7280;
}

.progress-percentage {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
    background: #e5e7eb;
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

.progress-bar-container {
    margin-bottom: 1rem;
}

.progress-bar {
    width: 100%;
    height: 12px;
    background: #e5e7eb;
    border-radius: 6px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    border-radius: 6px;
    transition: width 0.3s ease;
}

.progress-details {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.9rem;
}

.detail-item i {
    color: #10b981;
}

/* Event Details */
.event-details {
    margin-bottom: 2rem;
}

.event-details h3 {
    color: #1f2937;
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.event-details p {
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.benefits-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.benefits-list li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
    color: #374151;
}

.benefits-list i {
    color: #10b981;
    font-size: 0.9rem;
}

/* Event Actions */
.event-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.donate-event-btn {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.donate-event-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    color: white;
    text-decoration: none;
}

.share-btn {
    background: transparent;
    border: 2px solid #10b981;
    color: #10b981;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.share-btn:hover {
    background: #10b981;
    color: white;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .event-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .progress-info {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .progress-details {
        justify-content: center;
    }
    
    .event-actions {
        justify-content: center;
    }
    
    .donate-event-btn,
    .share-btn {
        flex: 1;
        min-width: 200px;
    }
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
    
    // Handle event donation button click
    document.querySelectorAll('.donate-event-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.querySelector('.feature-card');
            if (form) {
                form.scrollIntoView({ behavior: 'smooth' });
                // Add a subtle highlight effect to the form
                form.style.boxShadow = '0 0 20px rgba(16, 185, 129, 0.3)';
                setTimeout(() => {
                    form.style.boxShadow = '';
                }, 2000);
            }
        });
    });
    
    // Handle share button click
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (navigator.share) {
                navigator.share({
                    title: 'Mental Awareness Session - MindHeaven',
                    text: 'Support our mental health awareness session for university students. Help us reach our $15,000 goal!',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Event link copied to clipboard!');
                });
            }
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require BASE_PATH.'/app/views/layouts/landing.php';
?>
