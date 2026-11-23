<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_role('owner');

if (!$business) {
    echo '<div class="container">No active business found.</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$statsStmt = $pdo->prepare('SELECT status, COUNT(*) AS total FROM reservations WHERE business_id = ? GROUP BY status');
$statsStmt->execute([$business['id']]);
$stats = $statsStmt->fetchAll();

$todayStmt = $pdo->prepare('SELECT * FROM reservations WHERE business_id = ? AND pickup_date = CURDATE() ORDER BY created_at DESC');
$todayStmt->execute([$business['id']]);
$todayReservations = $todayStmt->fetchAll();
?>
<section class="container">
    <div class="section-title">
        <h2>Store dashboard</h2>
        <div class="filter-bar">
            <a class="button" href="/dashboard/reservations.php">Reservations</a>
            <a class="button secondary" href="/dashboard/products.php">Products</a>
            <a class="button secondary" href="/dashboard/calendar.php">Calendar</a>
        </div>
    </div>
    <div class="card-grid">
        <?php foreach ($stats as $stat): ?>
            <div class="card">
                <h3><?= e(ucfirst($stat['status'])); ?></h3>
                <p><?= e($stat['total']); ?> reservations</p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="section-title">
        <h3>Today</h3>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Pickup</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todayReservations as $reservation): ?>
                <tr>
                    <td><?= e($reservation['customer_name']); ?></td>
                    <td><?= e($reservation['pickup_date']); ?></td>
                    <td><span class="status-pill status-<?= e($reservation['status']); ?>"><?= e($reservation['status']); ?></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
