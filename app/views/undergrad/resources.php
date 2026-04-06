<?php
$TITLE = 'MindHeaven — Resources';
$CURRENT_PAGE = 'resources';
$PAGE_CSS = ['/MindHeaven/public/css/undergrad/resources.css'];
$PAGE_JS = ['/MindHeaven/public/js/undergrad/resources.js'];

require BASE_PATH . '/app/views/layouts/header.php';
?>

<!-- (KEEP ALL YOUR EXISTING HTML ABOVE THIS SCRIPT SECTION UNCHANGED) -->

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
        html += `<a href="${fullFilePath}" target="_blank">Open File</a>`;
      }

      if (resource.content) {
        html += `<div>${resource.content}</div>`;
      }

      html += `</div>`;

      content.innerHTML = html;
      modal.style.display = 'block';
    } catch (err) {
      console.error(err);
    }
  }

  function showCategoryResources(category) {
    window.location.href = '<?= BASE_URL ?>/ug/category-resources?category=' + encodeURIComponent(category);
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

  document.getElementById('closeResourceModal').onclick = function () {
    document.getElementById('resourceModal').style.display = 'none';
  };

  window.onclick = function (e) {
    const modal = document.getElementById('resourceModal');
    if (e.target === modal) modal.style.display = 'none';
  };
</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>