<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/i18n.php';
require_once __DIR__ . '/cart.php';

$pdo = db();
$business = get_active_business($pdo);
$brandColor = brand_color($business);
$themeColor = theme_color($business);
$pageTitle = $pageTitle ?? APP_NAME;
$user = current_user();
$lang = current_lang();
$cartCount = cart_count();
?>
<!doctype html>
<html lang="<?= e($lang); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle); ?></title>
    <link rel="stylesheet" href="/css/main.css">
    <style>:root{--brand-color:<?= e($brandColor); ?>;--theme-color:<?= e($themeColor); ?>;}</style>
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= e($business['website'] ?? '/store/about.php'); ?>">
            <span class="brand-mark"><?= e(substr($business['name'] ?? APP_NAME, 0, 1)); ?></span>
            <span class="brand-name"><?= e($business['name'] ?? APP_NAME); ?></span>
        </a>
        <nav class="nav">
            <a href="/store/index.php"><?= e(t('nav.store')); ?></a>
            <a class="nav-cart" href="/store/cart.php" aria-label="<?= e(t('nav.cart')); ?>">
                <svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M7 7h14l-1.7 8.5a2 2 0 0 1-2 1.5H9.2a2 2 0 0 1-2-1.6L5 4H2" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="9.5" cy="20" r="1.5" fill="currentColor"/>
                    <circle cx="17.5" cy="20" r="1.5" fill="currentColor"/>
                </svg>
                <span class="sr-only"><?= e(t('nav.cart')); ?></span>
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge" data-cart-count><?= e($cartCount); ?></span>
                <?php else: ?>
                    <span class="cart-badge" data-cart-count style="display:none;">0</span>
                <?php endif; ?>
            </a>
            <?php if ($user && $user['role'] === 'admin'): ?>
                <a href="/admin/index.php"><?= e(t('nav.admin')); ?></a>
            <?php elseif ($user && $user['role'] === 'owner'): ?>
                <a href="/dashboard/index.php"><?= e(t('nav.dashboard')); ?></a>
            <?php endif; ?>
            <?php if ($user): ?>
                <a class="nav-cta" href="/auth/logout.php"><?= e(t('nav.logout')); ?></a>
            <?php endif; ?>
            <div class="lang-switch">
                <a class="<?= $lang === 'nl' ? 'active' : ''; ?>" href="<?= e(lang_url('nl')); ?>">NL</a>
                <span>/</span>
                <a class="<?= $lang === 'fr' ? 'active' : ''; ?>" href="<?= e(lang_url('fr')); ?>">FR</a>
            </div>
        </nav>
    </div>
</header>
<main class="page">
