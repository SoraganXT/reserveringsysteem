</main>
<footer class="site-footer">
    <div class="container footer-inner">
        <div class="footer-brand"><?= e($business['name'] ?? APP_NAME); ?></div>
        <div class="footer-divider"></div>
        <span class="footer-note"><?= e(t('footer.note')); ?> &copy; <?= date('Y'); ?>. All rights reserved.</span>
        <span style="opacity: 0.5;">Powered by <?= e(APP_NAME); ?></span>
    </div>
</footer>
<script src="/js/main.js"></script>
</body>
</html>
