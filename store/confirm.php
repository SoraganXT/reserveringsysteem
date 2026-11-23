<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/i18n.php';

if (!$business) {
    echo '<div class="container">' . e(t('common.no_business')) . '</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$reservationId = (int) ($_GET['id'] ?? 0);
if ($reservationId === 0) {
    echo '<div class="container">' . e(t('error.not_found')) . '</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$resStmt = $pdo->prepare('SELECT r.*, t.start_time, t.end_time FROM reservations r LEFT JOIN time_slots t ON r.time_slot_id = t.id WHERE r.id = ? AND r.business_id = ?');
$resStmt->execute([$reservationId, $business['id']]);
$reservation = $resStmt->fetch();

if (!$reservation) {
    echo '<div class="container">' . e(t('error.not_found')) . '</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$itemStmt = $pdo->prepare('SELECT ri.quantity, p.name, p.name_fr FROM reservation_items ri JOIN products p ON ri.product_id = p.id WHERE ri.reservation_id = ?');
$itemStmt->execute([$reservationId]);
$items = $itemStmt->fetchAll();
?>
<section class="container">
    <div class="card">
        <h2><?= e(t('confirm.title')); ?></h2>
        <p><?= e(sprintf(t('confirm.message'), $reservation['customer_name'])); ?></p>
        <p><strong><?= e(t('confirm.pickup_date')); ?>:</strong> <?= e($reservation['pickup_date']); ?></p>
        <p><strong><?= e(t('confirm.pickup_time')); ?>:</strong> <?= e($reservation['start_time']); ?> - <?= e($reservation['end_time']); ?></p>
        <h3><?= e(t('confirm.items')); ?></h3>
        <ul>
            <?php foreach ($items as $item): ?>
                <li><?= e(field($item, 'name')); ?> x <?= e($item['quantity']); ?></li>
            <?php endforeach; ?>
        </ul>
        <a class="button secondary" href="/store/index.php"><?= e(t('confirm.back')); ?></a>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
