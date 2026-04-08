<?php // footer.php – closes main-wrapper and HTML document ?>
</div><!-- /.main-wrapper -->

<script>
    // Expose BASE_URL for all page scripts
    window.BASE_URL = '<?= defined("BASE_URL") ? rtrim(BASE_URL, "/") : "/MindHeaven/public" ?>';

    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');

    if (mobileMenuToggle && sidebar) {
        mobileMenuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');
            const expanded = sidebar.classList.contains('open');
            this.setAttribute('aria-expanded', expanded);
        });

        // Close sidebar on outside click (mobile)
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 768 &&
                sidebar.classList.contains('open') &&
                !sidebar.contains(e.target) &&
                !mobileMenuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
</script>

<?php if (!empty($PAGE_JS)): ?>
    <?php foreach ($PAGE_JS as $js): ?>
        <script src="<?= htmlspecialchars($js) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>