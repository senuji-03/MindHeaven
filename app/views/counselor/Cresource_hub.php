<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindHeaven - Counselor Resource Hub</title>
    <link rel="stylesheet" href="\MindHeaven\public\css\counselor\Cdashboard.css">
    <link rel="stylesheet" href="/MindHeaven/public/css/undergrad/resources.css">
    <style>
        /* Custom adjustments for counselor view */
        .resources-main {
            padding: 2rem;
            max-width: 100%;
            margin: 0;
        }
        .resources-hero {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }
        .category-card {
            cursor: pointer;
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
                <div class="nav-icon">🔔<span class="badge">3</span></div>
                <div class="nav-icon">💬<span class="badge">7</span></div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content resources-main">
            <!-- Hero Section -->
            <section class="resources-hero">
                <div class="hero-content">
                    <div>
                        <h1 class="hero-title">Wellness Hub</h1>
                        <p class="hero-subtitle">Access professional resources and educational content curated for counselor support.</p>
                        <div class="hero-actions">
                            <a href="#categories" class="btn btn-primary" style="display:inline-flex; width: fit-content; background: white; color: #2563eb;">Browse Categories</a>
                        </div>
                    </div>
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="stat-number"><?= htmlspecialchars($stats['total_resources'] ?? 0) ?></span>
                            <span class="stat-label">Total Resources</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Categories Section -->
            <section id="categories" class="resource-categories">
                <div class="section-header">
                    <h2 class="section-title">Explore by Category</h2>
                    <p class="section-subtitle">Categorized professional development and student-facing materials</p>
                </div>

                <div class="categories-grid">
                    <?php
                    $allCategoriesData = [
                        'Mental Health Basics' => ['icon' => '🧠', 'color1' => '#4facfe', 'color2' => '#00f2fe', 'description' => 'Understanding fundamental concepts and mental health basics.'],
                        'Anxiety & Stress' => ['icon' => '😰', 'color1' => '#ff9a9e', 'color2' => '#fecfef', 'description' => 'Management strategies for anxiety and high-stress situations.'],
                        'Depression Support' => ['icon' => '😢', 'color1' => '#a18cd1', 'color2' => '#fbc2eb', 'description' => 'Deep dives into depression symptoms and support mechanisms.'],
                        'Mindfulness & Meditation' => ['icon' => '🧘‍♀️', 'color1' => '#84fab0', 'color2' => '#8fd3f4', 'description' => 'Guided practices for mindfulness and stress reduction.'],
                        'Sleep & Wellness' => ['icon' => '💤', 'color1' => '#a6c0fe', 'color2' => '#f68084', 'description' => 'Optimal sleep hygiene and overall physical wellness tips.'],
                        'Relationships & Social' => ['icon' => '👥', 'color1' => '#fccb90', 'color2' => '#d57eeb', 'description' => 'Building and maintaining healthy social connections.'],
                        'Crisis Support' => ['icon' => '🆘', 'color1' => '#ff0844', 'color2' => '#ffb199', 'description' => 'Immediate response protocols and crisis intervention.'],
                        'Self-Help Tools' => ['icon' => '🛠️', 'color1' => '#43e97b', 'color2' => '#38f9d7', 'description' => 'Practical tools and exercises for daily emotional management.'],
                        'Professional Development' => ['icon' => '🎓', 'color1' => '#fa709a', 'color2' => '#fee140', 'description' => 'Advanced resources for counselor growth and academic success.']
                    ];
                    ?>

                    <?php foreach ($allCategoriesData as $name => $cat): ?>
                        <?php $count = isset($resourcesByCategory[$name]) ? count($resourcesByCategory[$name]) : 0; ?>
                        <div class="category-card" onclick="window.location.href='<?= BASE_URL ?>/counselor/category-resources?category=<?= urlencode($name) ?>'">
                            <div class="category-thumbnail" style="height: 160px; background: linear-gradient(135deg, <?= $cat['color1'] ?> 0%, <?= $cat['color2'] ?> 100%); display: flex; align-items: center; justify-content: center; font-size: 64px;">
                                <?= $cat['icon'] ?>
                            </div>
                            <div class="category-content">
                                <h3 class="category-title"><?= htmlspecialchars($name) ?></h3>
                                <p class="category-description" style="font-size: 0.9rem; color: #64748b;"><?= htmlspecialchars($cat['description']) ?></p>
                                <p style="font-weight: 600; color: #2563eb; font-size: 0.85rem; margin-top: 1rem;"><?= $count ?> Resource<?= $count !== 1 ? 's' : '' ?> Available</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
