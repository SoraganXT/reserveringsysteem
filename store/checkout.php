<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/cart.php';
require_once __DIR__ . '/../includes/i18n.php';

if (!$business) {
    echo '<div class="container">' . e(t('common.no_business')) . '</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$cart = cart_get();
if (!$cart) {
    header('Location: /store/cart.php');
    exit;
}

$placeholders = implode(',', array_fill(0, count($cart), '?'));
$ids = array_keys($cart);
$params = array_merge($ids, [$business['id']]);
$productsStmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders) AND business_id = ?");
$productsStmt->execute($params);
$products = $productsStmt->fetchAll();

$slotsStmt = $pdo->prepare('SELECT * FROM time_slots WHERE business_id = ? ORDER BY day_of_week, start_time');
$slotsStmt->execute([$business['id']]);
$timeSlots = $slotsStmt->fetchAll();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = trim($_POST['customer_name'] ?? '');
    $customerEmail = trim($_POST['customer_email'] ?? '');
    $customerPhone = trim($_POST['customer_phone'] ?? '');
    $pickupDate = trim($_POST['pickup_date'] ?? '');
    $timeSlotId = (int) ($_POST['time_slot_id'] ?? 0);
    $notes = trim($_POST['notes'] ?? '');

    if ($customerName === '' || $customerEmail === '' || $pickupDate === '') {
        $errors[] = t('error.contact');
    }

    if ($timeSlotId === 0) {
        $errors[] = t('error.time');
    }

    $items = [];
    foreach ($products as $product) {
        $qty = (int) ($cart[$product['id']] ?? 0);
        if ($qty > 0) {
            $items[] = [
                'product_id' => (int) $product['id'],
                'quantity' => $qty,
                'stock_qty' => (int) $product['stock_qty'],
            ];
        }
    }

    if (!$items) {
        $errors[] = t('error.empty_cart');
    }

    if (!$errors) {
        $slotCheck = $pdo->prepare('SELECT id, day_of_week FROM time_slots WHERE id = ? AND business_id = ?');
        $slotCheck->execute([$timeSlotId, $business['id']]);
        $slot = $slotCheck->fetch();
        if (!$slot) {
            $errors[] = t('error.invalid_slot');
        } else {
            $pickupDay = (int) date('w', strtotime($pickupDate));
            if ((int) $slot['day_of_week'] !== $pickupDay) {
                $errors[] = t('error.invalid_slot');
            }
        }
    }

    if (!$errors) {
        $pdo->beginTransaction();
        try {
            foreach ($items as $item) {
                if ($item['quantity'] > $item['stock_qty']) {
                    throw new RuntimeException(t('error.stock'));
                }
            }

            $insertReservation = $pdo->prepare('INSERT INTO reservations (business_id, customer_name, customer_email, customer_phone, pickup_date, time_slot_id, status, notes, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())');
            $insertReservation->execute([
                $business['id'],
                $customerName,
                $customerEmail,
                $customerPhone,
                $pickupDate,
                $timeSlotId,
                'new',
                $notes,
            ]);

            $reservationId = (int) $pdo->lastInsertId();
            $insertItem = $pdo->prepare('INSERT INTO reservation_items (reservation_id, product_id, quantity) VALUES (?, ?, ?)');
            $updateStock = $pdo->prepare('UPDATE products SET stock_qty = stock_qty - ? WHERE id = ? AND business_id = ?');

            foreach ($items as $item) {
                $insertItem->execute([$reservationId, $item['product_id'], $item['quantity']]);
                $updateStock->execute([$item['quantity'], $item['product_id'], $business['id']]);
            }

            $pdo->commit();
            cart_clear();
            header('Location: /store/confirm.php?id=' . $reservationId);
            exit;
        } catch (Throwable $error) {
            $pdo->rollBack();
            $errors[] = $error->getMessage() ?: t('error.save');
        }
    }
}
?>
<section class="container">
    <div class="section-title">
        <h2><?= e(t('checkout.title')); ?></h2>
        <a class="button secondary" href="/store/cart.php"><?= e(t('cart.title')); ?></a>
    </div>

    <div class="card" style="margin-bottom: 20px;">
        <h3><?= e(t('checkout.summary')); ?></h3>
        <ul>
            <?php foreach ($products as $product): ?>
                <?php $qty = (int) ($cart[$product['id']] ?? 0); ?>
                <?php if ($qty > 0): ?>
                    <li><?= e(field($product, 'name')); ?> x <?= e($qty); ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php if ($errors): ?>
        <div class="card" style="border-left: 4px solid #ef4444;">
            <strong><?= e(t('error.check')); ?></strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="card form-grid" method="post">
        <div>
            <h3><?= e(t('checkout.customer')); ?></h3>
        </div>
        <div>
            <label for="customer_name"><?= e(t('checkout.name')); ?></label>
            <input id="customer_name" name="customer_name" required>
        </div>
        <div>
            <label for="customer_email"><?= e(t('checkout.email')); ?></label>
            <input id="customer_email" type="email" name="customer_email" required>
        </div>
        <div>
            <label for="customer_phone"><?= e(t('checkout.phone')); ?></label>
            <input id="customer_phone" name="customer_phone">
        </div>
        <div>
            <h3><?= e(t('checkout.pickup')); ?></h3>
        </div>
        <div>
            <label for="pickup_date"><?= e(t('checkout.date')); ?></label>
            <input id="pickup_date" type="date" name="pickup_date" data-slot-date required>
        </div>
        <div>
            <label for="time_slot_id"><?= e(t('checkout.slot')); ?></label>
            <select id="time_slot_id" name="time_slot_id" required>
                <option value=""><?= e(t('common.select_time')); ?></option>
                <?php foreach ($timeSlots as $slot): ?>
                    <option value="<?= e($slot['id']); ?>" data-slot-day="<?= e($slot['day_of_week']); ?>">
                        <?= e(day_name((int) $slot['day_of_week'])); ?> - <?= e(sprintf('%s - %s', $slot['start_time'], $slot['end_time'])); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="notes"><?= e(t('checkout.notes')); ?></label>
            <textarea id="notes" name="notes" rows="3"></textarea>
        </div>

        <button class="button" type="submit"><?= e(t('checkout.submit')); ?></button>
    </form>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
