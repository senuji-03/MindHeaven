<?php
$TITLE = 'MindHeaven — Resources';
$CURRENT_PAGE = 'resources';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/resources.css'];
$PAGE_JS = ['/MindHeaven/public/js/undergrad/resources.js'];

require BASE_PATH . '/app/views/layouts/header.php';
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
      <?php 
      $allCategories = [
          'Mental Health Basics' => ['icon' => '🧠', 'color1' => '#4facfe', 'color2' => '#00f2fe', 'description' => 'Understanding mental health, common conditions, and when to seek help'],
          'Anxiety & Stress' => ['icon' => '😰', 'color1' => '#ff9a9e', 'color2' => '#fecfef', 'description' => 'Coping strategies and techniques for managing anxiety and stress'],
          'Depression Support' => ['icon' => '😢', 'color1' => '#a18cd1', 'color2' => '#fbc2eb', 'description' => 'Resources and support for dealing with depression'],
          'Mindfulness & Meditation' => ['icon' => '🧘‍♀️', 'color1' => '#84fab0', 'color2' => '#8fd3f4', 'description' => 'Guided practices for mindfulness and meditation'],
          'Sleep & Wellness' => ['icon' => '💤', 'color1' => '#a6c0fe', 'color2' => '#f68084', 'description' => 'Tips for better sleep and overall wellness'],
          'Relationships & Social' => ['icon' => '👥', 'color1' => '#fccb90', 'color2' => '#d57eeb', 'description' => 'Building healthy relationships and social connections'],
          'Crisis Support' => ['icon' => '🆘', 'color1' => '#ff0844', 'color2' => '#ffb199', 'description' => 'Emergency resources and crisis intervention'],
          'Self-Help Tools' => ['icon' => '🛠️', 'color1' => '#43e97b', 'color2' => '#38f9d7', 'description' => 'Interactive tools and exercises for mental wellness'],
          'Professional Development' => ['icon' => '🎓', 'color1' => '#fa709a', 'color2' => '#fee140', 'description' => 'Resources for academic and career success']
      ];
      ?>
      
      <?php foreach ($allCategories as $categoryName => $catDetails): ?>
        <?php 
          // Count how many resources exist for this category
          $count = isset($resourcesByCategory[$categoryName]) ? count($resourcesByCategory[$categoryName]) : 0; 
        ?>
        <div class="category-card" onclick="showCategoryResources('<?= htmlspecialchars($categoryName, ENT_QUOTES) ?>')" style="cursor: pointer; display: flex; flex-direction: column;">
          <!-- Thumbnail Area using CSS Gradient and Emoji -->
          <div class="category-thumbnail" style="height: 160px; background: linear-gradient(135deg, <?= $catDetails['color1'] ?> 0%, <?= $catDetails['color2'] ?> 100%); display: flex; align-items: center; justify-content: center; font-size: 64px;">
            <?= $catDetails['icon'] ?>
          </div>
          
          <div class="category-content" style="flex: 1;">
            <h3 class="category-title" style="margin-bottom: 0.5rem;"><?= htmlspecialchars($categoryName) ?></h3>
            <p class="category-description" style="margin-bottom: 1rem; font-size: 0.9rem;"><?= htmlspecialchars($catDetails['description']) ?></p>
            <p style="font-weight: 600; color: var(--primary); font-size: 0.85rem; margin: 0;"><?= $count ?> Resource<?= $count !== 1 ? 's' : '' ?> Available</p>
          </div>
        </div>
      <?php endforeach; ?>
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
  function openResourceModal(resource) {
    try {
      const modal = document.getElementById('resourceModal');
      const title = document.getElementById('resourceModalTitle');
      const content = document.getElementById('resourceModalContent');

      title.textContent = resource.title;

      function buildFileUrl(filePath) {
        if (!filePath) return '';
        const clean = filePath.replace(/^\/+/, '');
        return '/MindHeaven/public/' + clean;
      }

      let fullFilePath = buildFileUrl(resource.file_path || '');

      let html = `<div class="resource-details">
      <p>${resource.summary}</p>
    `;

      if (resource.file_path) {
        html += `<a href="${fullFilePath}" target="_blank" class="btn btn-primary" style="margin-top: 1rem; display: inline-block;">Open File</a>`;
      }

      if (resource.content) {
        html += `<div style="margin-top:1rem;">${resource.content}</div>`;
      }

      html += `</div>`;

      content.innerHTML = html;
      modal.classList.add('open');
    } catch (err) {
      console.error(err);
    }
  }

  function showCategoryResources(category) {
    const baseUrl = '<?= $categoryBaseUrl ?? (BASE_URL . "/ug/category-resources") ?>';
    window.location.href = baseUrl + '?category=' + encodeURIComponent(category);
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.resource-card, .resource-modal-trigger').forEach(el => {
      el.addEventListener('click', function (e) {
        if (this.tagName === 'A') e.preventDefault();
        const data = this.getAttribute('data-resource');
        if (data) openResourceModal(JSON.parse(data));
      });
    });
  });

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
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>