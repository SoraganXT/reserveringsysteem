<?php

declare(strict_types=1);

$pageTitle = 'Reservaties';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/i18n.php';
?>
<section class="container hero">
    <div>
        <span class="badge"><?= e(t('hero.badge')); ?></span>
        <h1><?= e(t('hero.title')); ?></h1>
        <p><?= e(t('hero.subtitle')); ?></p>
        <div class="filter-bar">
            <a class="button" href="/store/index.php"><?= e(t('hero.cta.primary')); ?></a>
            <a class="button secondary" href="/store/cart.php"><?= e(t('hero.cta.secondary')); ?></a>
        </div>
    </div>
    <div class="hero-card">
        <h3><?= e(t('hero.why.title')); ?></h3>
        <ul>
            <li><?= e(t('hero.why.1')); ?></li>
            <li><?= e(t('hero.why.2')); ?></li>
            <li><?= e(t('hero.why.3')); ?></li>
            <li><?= e(t('hero.why.4')); ?></li>
        </ul>
        <div class="card-grid" style="margin-top: 20px;">
            <div class="card">
                <h4><?= e(t('hero.today')); ?></h4>
                <p><?= e(t('hero.today.desc')); ?></p>
            </div>
            <div class="card">
                <h4><?= e(t('hero.tomorrow')); ?></h4>
                <p><?= e(t('hero.tomorrow.desc')); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="section-title">
        <h2><?= e(t('section.local.title')); ?></h2>
    </div>
    <div class="card-grid">
        <div class="card">
            <h3><?= e(t('section.local.bakery')); ?></h3>
            <p><?= e(t('section.local.bakery.desc')); ?></p>
        </div>
        <div class="card">
            <h3><?= e(t('section.local.night')); ?></h3>
            <p><?= e(t('section.local.night.desc')); ?></p>
        </div>
        <div class="card">
            <h3><?= e(t('section.local.florist')); ?></h3>
            <p><?= e(t('section.local.florist.desc')); ?></p>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
