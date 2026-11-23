<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/cart.php';
require_once __DIR__ . '/../includes/i18n.php';

$pdo = db();
$business = get_active_business($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    $wantsJson = str_contains($accept, 'application/json') || !empty($_SERVER['HTTP_X_REQUESTED_WITH']);

    if (!$business) {
        if ($wantsJson) {
            header('Content-Type: application/json');
            echo json_encode(['count' => cart_count()]);
            exit;
        }

        echo '<div class="container">' . e(t('common.no_business')) . '</div>';
        exit;
    }

    if ($action === 'add') {
        $productId = (int) ($_POST['product_id'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 0);

        if ($productId > 0 && $quantity > 0) {
            cart_add($productId, $quantity);
        }

        if ($wantsJson) {
            header('Content-Type: application/json');
            echo json_encode(['count' => cart_count()]);
            exit;
        }

        header('Location: /store/cart.php');
        exit;
    }

    if ($action === 'update') {
        $updates = $_POST['qty'] ?? [];
        if (is_array($updates)) {
            cart_update($updates);
        }

        header('Location: /store/cart.php');
        exit;
    }
}

require_once __DIR__ . '/../includes/header.php';

if (!$business) {
    echo '<div class="container">' . e(t('common.no_business')) . '</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$cart = cart_get();
$items = [];
$totalItems = cart_count();

if ($cart) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders) AND business_id = ?");
    $ids = array_keys($cart);
    $params = array_merge($ids, [$business['id']]);
    $stmt->execute($params);
    $items = $stmt->fetchAll();
}
?>
<section class="container">
    <div class="section-title">
        <h2><?= e(t('cart.title')); ?></h2>
        <a class="button secondary" href="/store/index.php"><?= e(t('hero.cta.primary')); ?></a>
    </div>

    <?php if ($totalItems === 0): ?>
        <div class="card">
            <p><?= e(t('cart.empty')); ?></p>
            <a class="button secondary" href="/store/index.php"><?= e(t('hero.cta.primary')); ?></a>
        </div>
    <?php else: ?>
        <form method="post" class="card">
            <input type="hidden" name="action" value="update">
            <table class="table">
                <thead>
                    <tr>
                        <th><?= e(t('store.title')); ?></th>
                        <th><?= e(t('store.qty')); ?></th>
                        <th><?= e(t('store.stock')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <strong><?= e(field($item, 'name')); ?></strong>
                                <div class="muted-text"><?= e(field($item, 'description')); ?></div>
                            </td>
                            <td>
                                <input type="number" name="qty[<?= e($item['id']); ?>]" min="0" value="<?= e($cart[$item['id']] ?? 0); ?>">
                            </td>
                            <td><?= e($item['stock_qty']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="form-actions">
                <button class="button secondary" type="submit"><?= e(t('cart.update')); ?></button>
                <a class="button" href="/store/checkout.php"><?= e(t('cart.checkout')); ?></a>
            </div>
        </form>
    <?php endif; ?>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
