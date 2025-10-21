<?php
$TITLE = 'MindHeaven — ' . htmlspecialchars($category) . ' Resources';
$CURRENT_PAGE = 'resources';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/resources.css'];
$PAGE_JS = ['/MindHeaven/public/css/undergrad/resources.js'];

require BASE_PATH.'/app/views/layouts/header.php';
?>

<main id="main" class="resources-main">
  <!-- Hero Section -->
  <section class="resources-hero">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title"><?= $categoryInfo['icon'] ?> <?= htmlspecialchars($category) ?></h1>
        <p class="hero-subtitle"><?= htmlspecialchars($categoryInfo['description']) ?></p>
        <div class="hero-stats">
          <div class="hero-stat">
            <span class="stat-number"><?= $totalResources ?></span>
            <span class="stat-label">Resources</span>
          </div>
          <div class="hero-stat">
            <span class="stat-number">24/7</span>
            <span class="stat-label">Support Available</span>
          </div>
          <div class="hero-stat">
            <span class="stat-number">Free</span>
            <span class="stat-label">For Students</span>
          </div>
        </div>
      </div>
      <div class="hero-actions">
        <a href="<?= BASE_URL ?>/ug/resources" class="btn btn-outline">
          <span class="btn-icon">←</span>
          Back to All Resources
        </a>
        <button id="emergencyBtn" class="btn btn-danger">
          <span class="btn-icon">🆘</span>
          Emergency Support
        </button>
      </div>
    </div>
  </section>

  <!-- Category Navigation -->
  <section class="category-navigation">
    <div class="section-header">
      <h2 class="section-title">Browse Other Categories</h2>
      <p class="section-subtitle">Explore resources in different areas</p>
    </div>
    
    <div class="categories-grid">
      <?php 
      $categoryIcons = [
        'Mental Health Basics' => '🧠',
        'Anxiety & Stress' => '😰',
        'Depression Support' => '😢',
        'Mindfulness & Meditation' => '🧘‍♀️',
        'Sleep & Wellness' => '💤',
        'Relationships & Social' => '👥',
        'Crisis Support' => '🆘',
        'Self-Help Tools' => '🛠️',
        'Professional Development' => '🎓'
      ];
      
      foreach ($allCategories as $cat => $count): 
        if ($cat === $category) continue; // Skip current category
        $icon = $categoryIcons[$cat] ?? '📚';
      ?>
        <a href="<?= BASE_URL ?>/ug/category-resources?category=<?= urlencode($cat) ?>" class="category-nav-card">
          <div class="category-nav-icon"><?= $icon ?></div>
          <div class="category-nav-content">
            <h3 class="category-nav-title"><?= htmlspecialchars($cat) ?></h3>
            <p class="category-nav-count"><?= $count ?> resources</p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Resources List -->
  <section class="resources-list">
    <div class="section-header">
      <h2 class="section-title">All <?= htmlspecialchars($category) ?> Resources</h2>
      <p class="section-subtitle">Click on any resource to view full details</p>
    </div>
    
    <?php if (!empty($resources)): ?>
      <div class="resources-grid">
        <?php foreach ($resources as $resource): ?>
          <div class="resource-card" onclick="openResourceModal(<?= htmlspecialchars(json_encode($resource)) ?>)">
            <div class="resource-header">
              <div class="resource-type-icon">
                <?php if ($resource['content_type'] === 'video'): ?>
                  🎥
                <?php elseif ($resource['content_type'] === 'audio'): ?>
                  🎵
                <?php else: ?>
                  📄
                <?php endif; ?>
              </div>
              <div class="resource-meta">
                <span class="resource-type"><?= strtoupper($resource['content_type']) ?></span>
                <span class="resource-date"><?= date('M d, Y', strtotime($resource['created_at'])) ?></span>
              </div>
            </div>
            
            <div class="resource-content">
              <h3 class="resource-title"><?= htmlspecialchars($resource['title']) ?></h3>
              <p class="resource-summary"><?= htmlspecialchars($resource['summary']) ?></p>
              
              <?php if (!empty($resource['tags'])): ?>
                <div class="resource-tags">
                  <?php 
                  $tags = explode(',', $resource['tags']);
                  foreach (array_slice($tags, 0, 3) as $tag): 
                  ?>
                    <span class="tag"><?= htmlspecialchars(trim($tag)) ?></span>
                  <?php endforeach; ?>
                  <?php if (count($tags) > 3): ?>
                    <span class="tag-more">+<?= count($tags) - 3 ?> more</span>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
            
            <?php if (!empty($resource['file_path']) && !empty($resource['file_name'])): ?>
              <div class="resource-file">
                <?php 
                $fileExtension = strtolower(pathinfo($resource['file_name'], PATHINFO_EXTENSION));
                $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $fileExists = file_exists(BASE_PATH . '/public' . $resource['file_path']);
                ?>
                
                <?php if ($resource['content_type'] === 'article' && $isImage && $fileExists): ?>
                  <img src="<?= BASE_URL . $resource['file_path'] ?>" alt="<?= htmlspecialchars($resource['title']) ?>" class="resource-thumbnail">
                <?php else: ?>
                  <div class="resource-file-icon">
                    <?php if ($resource['content_type'] === 'video'): ?>
                      🎥
                    <?php elseif ($resource['content_type'] === 'audio'): ?>
                      🎵
                    <?php else: ?>
                      📄
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                
                <div class="resource-file-info">
                  <p class="resource-file-name"><?= htmlspecialchars($resource['file_name']) ?></p>
                  <?php if (!empty($resource['file_size'])): ?>
                    <p class="resource-file-size"><?= number_format($resource['file_size'] / 1024 / 1024, 2) ?> MB</p>
                  <?php endif; ?>
                </div>
              </div>
            <?php endif; ?>
            
            <div class="resource-footer">
              <button class="btn btn-primary btn-small">View Details</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="empty-state">
        <div class="empty-icon">📚</div>
        <h3>No Resources Available</h3>
        <p>There are currently no resources in this category. Check back soon for new content!</p>
        <a href="<?= BASE_URL ?>/ug/resources" class="btn btn-primary">Browse All Resources</a>
      </div>
    <?php endif; ?>
  </section>
</main>

<!-- Resource Modal -->
<div id="resourceModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title" id="resourceModalTitle">Resource Details</h3>
      <button class="modal-close" id="closeResourceModal">&times;</button>
    </div>
    <div class="modal-body">
      <div id="resourceModalContent">
        <!-- Resource content will be loaded here -->
      </div>
    </div>
  </div>
</div>

<style>
/* Category Resources Specific Styles */
.category-navigation {
  padding: 2rem 0;
  background: #f8fafc;
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
  margin-top: 1.5rem;
}

.category-nav-card {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: white;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  text-decoration: none;
  color: inherit;
  transition: all 0.2s ease;
}

.category-nav-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  border-color: #3b82f6;
}

.category-nav-icon {
  font-size: 2rem;
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f0f9ff;
  border-radius: 12px;
}

.category-nav-content {
  flex: 1;
}

.category-nav-title {
  margin: 0 0 0.25rem 0;
  font-size: 1rem;
  font-weight: 600;
  color: #1e293b;
}

.category-nav-count {
  margin: 0;
  font-size: 0.875rem;
  color: #6b7280;
}

.resources-list {
  padding: 2rem 0;
}

.resources-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1.5rem;
  margin-top: 1.5rem;
}

.resource-card {
  background: white;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  padding: 1.5rem;
  cursor: pointer;
  transition: all 0.2s ease;
  position: relative;
  overflow: hidden;
}

.resource-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  border-color: #3b82f6;
}

.resource-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.resource-type-icon {
  font-size: 1.5rem;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f0f9ff;
  border-radius: 8px;
}

.resource-meta {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 0.25rem;
}

.resource-type {
  font-size: 0.75rem;
  font-weight: 600;
  color: #3b82f6;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.resource-date {
  font-size: 0.75rem;
  color: #6b7280;
}

.resource-content {
  margin-bottom: 1rem;
}

.resource-title {
  margin: 0 0 0.75rem 0;
  font-size: 1.125rem;
  font-weight: 600;
  color: #1e293b;
  line-height: 1.4;
}

.resource-summary {
  margin: 0 0 1rem 0;
  color: #64748b;
  line-height: 1.5;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.resource-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.tag {
  background: #f1f5f9;
  color: #475569;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 500;
}

.tag-more {
  background: #e2e8f0;
  color: #64748b;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 500;
}

.resource-file {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: #f8fafc;
  border-radius: 8px;
  margin-bottom: 1rem;
}

.resource-thumbnail {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 8px;
}

.resource-file-icon {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #e0f2fe;
  border-radius: 8px;
  font-size: 1.5rem;
}

.resource-file-info {
  flex: 1;
}

.resource-file-name {
  margin: 0 0 0.25rem 0;
  font-weight: 600;
  color: #1e293b;
  font-size: 0.875rem;
}

.resource-file-size {
  margin: 0;
  color: #6b7280;
  font-size: 0.75rem;
}

.resource-footer {
  display: flex;
  justify-content: flex-end;
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  background: white;
  border-radius: 12px;
  border: 1px solid #e5e7eb;
}

.empty-icon {
  font-size: 4rem;
  margin-bottom: 1rem;
}

.empty-state h3 {
  margin: 0 0 0.5rem 0;
  color: #1e293b;
  font-size: 1.5rem;
}

.empty-state p {
  margin: 0 0 2rem 0;
  color: #64748b;
  font-size: 1rem;
}

/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  margin: 5% auto;
  padding: 0;
  border-radius: 12px;
  width: 90%;
  max-width: 800px;
  max-height: 80vh;
  overflow-y: auto;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.modal-title {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 600;
  color: #1e293b;
}

.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #6b7280;
  padding: 0.5rem;
  border-radius: 4px;
  transition: all 0.2s ease;
}

.modal-close:hover {
  background: #f3f4f6;
  color: #374151;
}

.modal-body {
  padding: 1.5rem;
}

.resource-details {
  line-height: 1.6;
}

.resource-meta {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.resource-category {
  background: #dbeafe;
  color: #1e40af;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 600;
}

.resource-type {
  background: #dcfce7;
  color: #166534;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.75rem;
  font-weight: 600;
}

.resource-summary h4,
.resource-content h4,
.resource-tags h4 {
  margin: 0 0 0.5rem 0;
  color: #1e293b;
  font-size: 1rem;
  font-weight: 600;
}

.resource-summary p,
.resource-content div {
  margin: 0 0 1rem 0;
  color: #374151;
}

.resource-file {
  margin: 1rem 0;
  padding: 1rem;
  background: #f8fafc;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

.resource-file h4 {
  margin: 0 0 0.5rem 0;
  color: #1e293b;
  font-size: 1rem;
  font-weight: 600;
}

.resource-file img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  margin-bottom: 0.5rem;
}

.resource-file div {
  text-align: center;
  padding: 1rem;
  background: #f0f9ff;
  border-radius: 8px;
}

.resource-file p {
  margin: 0.25rem 0;
  color: #374151;
}

.resource-file strong {
  color: #1e293b;
}

.resource-tags p {
  margin: 0;
  color: #6b7280;
  font-style: italic;
}

@media (max-width: 768px) {
  .categories-grid {
    grid-template-columns: 1fr;
  }
  
  .resources-grid {
    grid-template-columns: 1fr;
  }
  
  .modal-content {
    width: 95%;
    margin: 10% auto;
  }
}
</style>

<script>
// Resource modal functionality
function openResourceModal(resource) {
  const modal = document.getElementById('resourceModal');
  const title = document.getElementById('resourceModalTitle');
  const content = document.getElementById('resourceModalContent');
  
  title.textContent = resource.title;
  
  let contentHtml = `
    <div class="resource-details">
      <div class="resource-meta">
        <span class="resource-category">${resource.category}</span>
        <span class="resource-type">${resource.content_type.toUpperCase()}</span>
      </div>
      <div class="resource-summary">
        <h4>Summary</h4>
        <p>${resource.summary}</p>
      </div>
  `;
  
  // Add file display if exists
  if (resource.file_path && resource.file_name) {
    const fileExtension = resource.file_name.split('.').pop().toLowerCase();
    const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension);
    
    if (isImage) {
      contentHtml += `
        <div class="resource-file">
          <h4>Featured Image</h4>
          <img src="${resource.file_path}" alt="${resource.title}" style="max-width: 100%; height: auto; border-radius: 8px;">
        </div>
      `;
    } else {
      contentHtml += `
        <div class="resource-file">
          <h4>Media File</h4>
          <div style="padding: 1rem; background: #f8fafc; border-radius: 8px; text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">
              ${resource.content_type === 'video' ? '🎥' : '🎵'}
            </div>
            <p><strong>${resource.file_name}</strong></p>
            <p>Size: ${(resource.file_size / 1024 / 1024).toFixed(2)} MB</p>
            <a href="${resource.file_path}" target="_blank" class="btn btn-primary">View/Download File</a>
          </div>
        </div>
      `;
    }
  }
  
  // Add content
  if (resource.content) {
    contentHtml += `
      <div class="resource-content">
        <h4>Content</h4>
        <div style="white-space: pre-wrap; line-height: 1.6;">${resource.content}</div>
      </div>
    `;
  }
  
  // Add tags if exist
  if (resource.tags) {
    contentHtml += `
      <div class="resource-tags">
        <h4>Tags</h4>
        <p>${resource.tags}</p>
      </div>
    `;
  }
  
  contentHtml += `</div>`;
  
  content.innerHTML = contentHtml;
  modal.style.display = 'block';
}

// Close modal functionality
document.getElementById('closeResourceModal').onclick = function() {
  document.getElementById('resourceModal').style.display = 'none';
}

window.onclick = function(event) {
  const modal = document.getElementById('resourceModal');
  if (event.target === modal) {
    modal.style.display = 'none';
  }
}

// Emergency button functionality
document.getElementById('emergencyBtn').onclick = function() {
  if (confirm('Are you in immediate danger? If yes, call 911 or your local emergency number.')) {
    window.location.href = 'tel:911';
  } else {
    window.location.href = '<?= BASE_URL ?>/ug/crisis';
  }
}
</script>

<?
require BASE_PATH.'/app/views/layouts/footer.php'; ?>
