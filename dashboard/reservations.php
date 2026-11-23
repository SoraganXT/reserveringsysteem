<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_role('owner');

if (!$business) {
    echo '<div class="container">No active business found.</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationId = (int) ($_POST['reservation_id'] ?? 0);
    $status = $_POST['status'] ?? 'new';
    $allowed = ['new', 'preparing', 'ready', 'picked_up'];

    if ($reservationId && in_array($status, $allowed, true)) {
        $stmt = $pdo->prepare('UPDATE reservations SET status = ?, updated_at = NOW() WHERE id = ? AND business_id = ?');
        $stmt->execute([$status, $reservationId, $business['id']]);
    }
}

$reservationsStmt = $pdo->prepare('SELECT r.*, t.start_time, t.end_time FROM reservations r LEFT JOIN time_slots t ON r.time_slot_id = t.id WHERE r.business_id = ? ORDER BY r.pickup_date DESC');
$reservationsStmt->execute([$business['id']]);
$reservations = $reservationsStmt->fetchAll();
?>
<section class="container">
    <div class="section-title">
        <h2>Reservations</h2>
        <a class="button secondary" href="/dashboard/index.php">Back to dashboard</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Pickup</th>
                <th>Time</th>
                <th>Status</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= e($reservation['customer_name']); ?></td>
                    <td><?= e($reservation['pickup_date']); ?></td>
                    <td><?= e($reservation['start_time']); ?> - <?= e($reservation['end_time']); ?></td>
                    <td><span class="status-pill status-<?= e($reservation['status']); ?>"><?= e($reservation['status']); ?></span></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="reservation_id" value="<?= e($reservation['id']); ?>">
                            <select name="status">
                                <option value="new">New</option>
                                <option value="preparing">In Preparation</option>
                                <option value="ready">Ready for Pickup</option>
                                <option value="picked_up">Picked Up</option>
                            </select>
                            <button class="button secondary" type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
