<?php

declare(strict_types=1);

$pageTitle = 'Uitleg';
require_once __DIR__ . '/includes/i18n.php';
$pageTitle = t('uitleg.title');
require_once __DIR__ . '/includes/header.php';
?>
<section class="container hero">
    <div>
        <span class="badge"><?= e(t('uitleg.title')); ?></span>
        <h1><?= e(t('uitleg.hero.title')); ?></h1>
        <p><?= e(t('uitleg.hero.subtitle')); ?></p>
        <div class="filter-bar">
            <a class="button" href="/store/index.php"><?= e(t('uitleg.cta')); ?></a>
        </div>
    </div>
    <div class="hero-card">
        <h3><?= e(t('uitleg.features.title')); ?></h3>
        <ul>
            <li><?= e(t('uitleg.features.1')); ?></li>
            <li><?= e(t('uitleg.features.2')); ?></li>
            <li><?= e(t('uitleg.features.3')); ?></li>
            <li><?= e(t('uitleg.features.4')); ?></li>
            <li><?= e(t('uitleg.features.5')); ?></li>
        </ul>
    </div>
</section>

<section class="container">
    <div class="section-title">
        <h2><?= e(t('uitleg.usecases.title')); ?></h2>
    </div>
    <div class="card-grid">
        <div class="card">
            <h3><?= e(t('uitleg.bakery.title')); ?></h3>
            <p><?= e(t('uitleg.bakery.desc')); ?></p>
        </div>
        <div class="card">
            <h3><?= e(t('uitleg.florist.title')); ?></h3>
            <p><?= e(t('uitleg.florist.desc')); ?></p>
        </div>
        <div class="card">
            <h3><?= e(t('uitleg.night.title')); ?></h3>
            <p><?= e(t('uitleg.night.desc')); ?></p>
        </div>
    </div>
</section>

<section class="container">
    <div class="section-title">
        <h2><?= e(t('uitleg.steps.title')); ?></h2>
    </div>
    <div class="card-grid">
        <div class="card">
            <h3>1</h3>
            <p><?= e(t('uitleg.steps.1')); ?></p>
        </div>
        <div class="card">
            <h3>2</h3>
            <p><?= e(t('uitleg.steps.2')); ?></p>
        </div>
        <div class="card">
            <h3>3</h3>
            <p><?= e(t('uitleg.steps.3')); ?></p>
        </div>
    </div>
</section>

<section class="container">
    <div class="section-title">
        <h2><?= e(t('uitleg.results.title')); ?></h2>
    </div>
    <div class="card-grid">
        <div class="card">
            <p><?= e(t('uitleg.results.1')); ?></p>
        </div>
        <div class="card">
            <p><?= e(t('uitleg.results.2')); ?></p>
        </div>
        <div class="card">
            <p><?= e(t('uitleg.results.3')); ?></p>
        </div>
    </div>
</section>

<section class="container">
    <div class="section-title">
        <h2><?= e(t('uitleg.growth.title')); ?></h2>
    </div>
    <div class="card-grid">
        <div class="card">
            <p><?= e(t('uitleg.growth.1')); ?></p>
        </div>
        <div class="card">
            <p><?= e(t('uitleg.growth.2')); ?></p>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
