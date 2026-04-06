<?php
$TITLE = 'MindHeaven — ' . htmlspecialchars($category) . ' Resources';
$CURRENT_PAGE = 'resources';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/resources.css'];
$PAGE_JS = ['/MindHeaven/public/js/undergrad/resources.js'];

require BASE_PATH . '/app/views/layouts/header.php';
?>

<main id="main" class="resources-main">
  <!-- (UNCHANGED TOP PART — keep your existing HTML ABOVE resources loop) -->

  <?php if (!empty($resources)): ?>
    <div class="resources-grid" id="all-resources">
      <?php foreach ($resources as $resource): ?>
        <div class="resource-card" data-resource="<?= htmlspecialchars(json_encode($resource), ENT_QUOTES, 'UTF-8') ?>">

          <div class="resource-content">
            <h3 class="resource-title"><?= htmlspecialchars($resource['title']) ?></h3>
            <p class="resource-summary"><?= htmlspecialchars($resource['summary']) ?></p>

            <?php if (!empty($resource['tags'])): ?>
              <div class="resource-tags">
                <?php
                $tags = array_map('trim', explode(',', $resource['tags']));
                foreach (array_slice($tags, 0, 3) as $tag):
                  ?>
                  <span class="tag"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
                <?php if (count($tags) > 3): ?>
                  <span class="tag-more">+<?= count($tags) - 3 ?></span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>

          <?php if (!empty($resource['file_path'])): ?>
            <div class="resource-file">
              <?php
              $isImage = false;
              if (!empty($resource['file_name'])) {
                $ext = strtolower(pathinfo($resource['file_name'], PATHINFO_EXTENSION));
                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
              }
              ?>

              <?php if ($resource['content_type'] === 'article' && $isImage): ?>
                <img src="<?= BASE_URL ?>/<?= ltrim($resource['file_path'], '/') ?>" class="resource-thumbnail">
              <?php else: ?>
                <div class="resource-file-icon">
                  <?= $resource['content_type'] === 'video' ? '🎬' : ($resource['content_type'] === 'audio' ? '🎧' : '📎') ?>
                </div>
              <?php endif; ?>

              <div class="resource-file-info">
                <p><?= htmlspecialchars($resource['file_name'] ?? '') ?></p>
                <?php if (!empty($resource['file_size'])): ?>
                  <p><?= number_format($resource['file_size'] / 1024 / 1024, 2) ?> MB</p>
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
  <?php endif; ?>
</main>

<script>
  function openResourceModal(resource) {
    try {
      const modal = document.getElementById('resourceModal');
      const title = document.getElementById('resourceModalTitle');
      const content = document.getElementById('resourceModalContent');

      title.textContent = resource.title;

      function buildFileUrl(p) {
        if (!p) return '';
        return '/MindHeaven/public/' + p.replace(/^\/+/, '');
      }

      let fileUrl = buildFileUrl(resource.file_path || '');

      let html = `<div class="resource-details">
<p>${resource.summary}</p>
`;

      if (resource.file_path) {
        html += `<a href="${fileUrl}" target="_blank">Open File</a>`;
      }

      html += `</div>`;

      content.innerHTML = html;
      modal.style.display = 'block';
    } catch (e) { console.error(e); }
  }

  document.querySelectorAll('.resource-card').forEach(card => {
    card.onclick = () => {
      const data = card.getAttribute('data-resource');
      if (data) openResourceModal(JSON.parse(data));
    };
  });
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>