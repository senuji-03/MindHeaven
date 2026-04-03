<?php // footer.php – closes main-wrapper and HTML document ?>
</div><!-- /.main-wrapper -->

<script>
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
</body>

</html>