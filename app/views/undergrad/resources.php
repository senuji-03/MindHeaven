<?php
$TITLE = 'MindHeaven — Resources';
$CURRENT_PAGE = 'resources';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/resources.css'];
$PAGE_JS = ['/MindHeaven/public/js/undergrad/resources.js'];

require BASE_PATH . '/app/views/layouts/header.php';

// Helper for beautiful fallback gradients
function getFallbackGradient($name) {
    $gradients = [
        ['#4facfe', '#00f2fe'], // Blue
        ['#ff9a9e', '#fecfef'], // Pink
        ['#a18cd1', '#fbc2eb'], // Purple
        ['#84fab0', '#8fd3f4'], // Green
        ['#a6c0fe', '#f68084'], // Indigo/Red
        ['#fccb90', '#d57eeb'], // Orange
        ['#ff0844', '#ffb199'], // Red
        ['#43e97b', '#38f9d7'], // Light Green
        ['#fa709a', '#fee140']  // Rose/Yellow
    ];
    // Map name to a consistent index
    $index = abs(crc32($name)) % count($gradients);
    return $gradients[$index];
}
?>

<main id="main" class="resources-main">
  <!-- Hero Section -->
  <section class="resources-hero">
    <div class="hero-content">
      <div>
        <h1 class="hero-title">Wellness Hub</h1>
        <p class="hero-subtitle">Explore expertly curated resources tailored for your mental health and well-being.</p>
        <div class="hero-actions">
          <a href="#categories" class="btn btn-primary" style="display:inline-flex; width: fit-content;">Browse Categories</a>
        </div>
      </div>
      <div class="hero-stats">
        <div class="hero-stat">
          <span class="stat-number"><?= htmlspecialchars($stats['total_resources'] ?? 0) ?></span>
          <span class="stat-label">Resources Available</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Categories Section -->
  <section id="categories" class="resource-categories">
    <div class="section-header">
      <h2 class="section-title">Explore by Category</h2>
      <p class="section-subtitle">Find exactly what you need from our extensive library</p>
    </div>
    
    <div class="categories-grid">
      <?php if (empty($categories)): ?>
        <p style="text-align: center; grid-column: 1/-1; padding: 40px; color: var(--text-secondary);">No categories found. Check back later!</p>
      <?php else: ?>
        <?php foreach ($categories as $cat): ?>
          <?php 
            $categoryName = $cat['name'];
            $count = isset($resourcesByCategory[$categoryName]) ? count($resourcesByCategory[$categoryName]) : 0; 
            $gradient = getFallbackGradient($categoryName);
          ?>
          <div class="category-card" onclick="showCategoryResources('<?= htmlspecialchars($categoryName, ENT_QUOTES) ?>')" style="cursor: pointer; display: flex; flex-direction: column; overflow: hidden; border-radius: var(--radius-lg); transition: transform 0.3s ease;">
            
            <div class="category-thumbnail" style="height: 180px; position: relative; overflow: hidden; background: linear-gradient(135deg, <?= $gradient[0] ?> 0%, <?= $gradient[1] ?> 100%);">
              <?php if (!empty($cat['thumbnail'])): ?>
                <img src="<?= BASE_URL ?>/<?= htmlspecialchars($cat['thumbnail']) ?>" 
                     alt="<?= htmlspecialchars($categoryName) ?>"
                     style="width: 100%; height: 100%; object-fit: cover;">
              <?php else: ?>
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 64px; opacity: 0.8;">
                   <!-- Logic to show a relevant emoji if no image? 
                        We can keep it simple for now or use the first letter -->
                   <span style="font-weight: 800; color: white; opacity: 0.4;">
                       <?= strtoupper(substr($categoryName, 0, 1)) ?>
                   </span>
                </div>
              <?php endif; ?>
            </div>
            
            <div class="category-content" style="flex: 1; padding: 24px; background: white; border: 1px solid var(--border); border-top: none; border-bottom-left-radius: var(--radius-lg); border-bottom-right-radius: var(--radius-lg);">
              <h3 class="category-title" style="margin-bottom: 0.5rem; color: var(--text-primary); font-weight: 700;"><?= htmlspecialchars($categoryName) ?></h3>
              <p class="category-description" style="margin-bottom: 1.5rem; font-size: 0.9rem; color: var(--text-secondary); line-height: 1.5;">
                  <?= htmlspecialchars(isset($cat['description']) ? $cat['description'] : 'Explore our collection of ' . $categoryName . ' resources.') ?>
              </p>
              <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: var(--primary); font-size: 0.85rem; padding-top: 12px; border-top: 1px solid var(--bg-soft);">
                  <i class="fas fa-layer-group"></i>
                  <?= $count ?> Resource<?= $count !== 1 ? 's' : '' ?> Available
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>
  
  <!-- Modal -->
  <div id="resourceModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 id="resourceModalTitle" class="modal-title"></h3>
        <button id="closeResourceModal" class="modal-close">&times;</button>
      </div>
      <div id="resourceModalContent" class="modal-body"></div>
    </div>
  </div>
</main>

<script>
  function showCategoryResources(category) {
    const baseUrl = '<?= $categoryBaseUrl ?? (BASE_URL . "/ug/category-resources") ?>';
    window.location.href = baseUrl + '?category=' + encodeURIComponent(category);
  }

  document.addEventListener('DOMContentLoaded', function () {
    const closeModalBtn = document.getElementById('closeResourceModal');
    if(closeModalBtn) {
      closeModalBtn.onclick = function () {
        document.getElementById('resourceModal').classList.remove('open');
      };
    }

    window.onclick = function (e) {
      const modal = document.getElementById('resourceModal');
      if (e.target === modal) modal.classList.remove('open');
    };
  });
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>