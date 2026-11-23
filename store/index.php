<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/i18n.php';

if (!$business) {
    echo '<div class="container">' . e(t('common.no_business')) . '</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$categoriesStmt = $pdo->prepare('SELECT * FROM categories WHERE business_id = ? ORDER BY sort_order, name');
$categoriesStmt->execute([$business['id']]);
$categories = $categoriesStmt->fetchAll();

$productsStmt = $pdo->prepare('SELECT p.*, c.name AS category_name, c.name_fr AS category_name_fr FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.business_id = ? AND p.is_active = 1 ORDER BY p.name');
$productsStmt->execute([$business['id']]);
$products = $productsStmt->fetchAll();
?>
<section class="hero">
    <h1><?= e($business['name']); ?></h1>
    <p><?= e($business['description'] ?? 'Welkom bij onze winkel. Ontdek ons assortiment en reserveer direct online.'); ?></p>
</section>

<section class="container">
    <div class="section-title">
        <h2><?= e(t('store.title')); ?></h2>
        <a class="button nav-cart" href="/store/cart.php" style="position: relative; padding-right: 1.5rem;">
            <svg class="nav-icon" style="width: 20px; height: 20px;" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M7 7h14l-1.7 8.5a2 2 0 0 1-2 1.5H9.2a2 2 0 0 1-2-1.6L5 4H2" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="9.5" cy="20" r="1.5" fill="currentColor"/>
                <circle cx="17.5" cy="20" r="1.5" fill="currentColor"/>
            </svg>
            <?= e(t('nav.cart')); ?>
            <?php if ($cartCount > 0): ?>
                <span class="cart-badge" data-cart-count style="top: -6px; right: -6px;"><?= e($cartCount); ?></span>
            <?php else: ?>
                <span class="cart-badge" data-cart-count style="display:none; top: -6px; right: -6px;">0</span>
            <?php endif; ?>
        </a>
    </div>
    <div class="filter-bar">
        <button data-filter="all" class="active"><?= e(t('store.filter.all')); ?></button>
        <?php foreach ($categories as $category): ?>
            <button data-filter="<?= e($category['id']); ?>"><?= e(field($category, 'name')); ?></button>
        <?php endforeach; ?>
    </div>
    <div class="card-grid">
        <?php foreach ($products as $product): ?>
            <div class="card" data-category="<?= e($product['category_id']); ?>">
                <span class="badge"><?= e(field($product, 'category_name') ?: t('store.general')); ?></span>
                <h3><?= e(field($product, 'name')); ?></h3>
                <p><?= e(field($product, 'description')); ?></p>
                <p class="muted-text"><strong><?= e(t('store.stock')); ?>:</strong> <?= e($product['stock_qty']); ?></p>
                <form method="post" action="/store/cart.php" class="cart-inline" data-cart-add>
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= e($product['id']); ?>">
                    <label><?= e(t('store.qty')); ?></label>
                    <div class="qty-wrapper">
                        <input type="number" name="quantity" min="1" value="1">
                        <button class="button secondary" type="submit">
                            <svg class="nav-icon" style="width:18px;height:18px;margin-right:4px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <?= e(t('store.add')); ?>
                        </button>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
