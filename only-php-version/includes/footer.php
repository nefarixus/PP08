<?php
/** @var string $asset_prefix */
$asset_prefix = $asset_prefix ?? '.';
?>
<footer class="site-footer">
    <div class="site-footer__left">
        <img src="<?= htmlspecialchars($asset_prefix) ?>/images/khronos.png" alt="khronos" class="site-footer__logo">
        <nav class="site-footer__links" aria-label="footer">
            <a href="#" class="site-footer__link">Настройки cookie</a>
            <a href="#" class="site-footer__link">Условия</a>
            <a href="#" class="site-footer__link">Конфиденциальность</a>
            <a href="#" class="site-footer__link">Команда</a>
            <a href="#" class="site-footer__link">Продвижение</a>
            <a href="#" class="site-footer__link">Предложить приложение</a>
        </nav>
    </div>
    <div class="site-footer__right" aria-label="social">
        <a href="#" class="site-footer__social"><img src="<?= htmlspecialchars($asset_prefix) ?>/images/logo-facebook.png" alt=""></a>
        <a href="#" class="site-footer__social"><img src="<?= htmlspecialchars($asset_prefix) ?>/images/logo-instagram.png" alt=""></a>
        <a href="#" class="site-footer__social"><img src="<?= htmlspecialchars($asset_prefix) ?>/images/logo-reddit.png" alt=""></a>
        <a href="#" class="site-footer__social"><img src="<?= htmlspecialchars($asset_prefix) ?>/images/ri_twitter-x-line.png" alt=""></a>
        <a href="#" class="site-footer__social"><img src="<?= htmlspecialchars($asset_prefix) ?>/images/mdi_youtube.png" alt=""></a>
        <a href="#" class="site-footer__social"><img src="<?= htmlspecialchars($asset_prefix) ?>/images/logo-tiktok.png" alt=""></a>
        <a href="#" class="site-footer__social"><img src="<?= htmlspecialchars($asset_prefix) ?>/images/logo-linkedin.png" alt=""></a>
    </div>
</footer>

