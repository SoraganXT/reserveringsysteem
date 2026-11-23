<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_role('owner');

if (!$business) {
    echo '<div class="container">No active business found.</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$calendarStmt = $pdo->prepare('SELECT pickup_date, COUNT(*) AS total FROM reservations WHERE business_id = ? GROUP BY pickup_date ORDER BY pickup_date ASC');
$calendarStmt->execute([$business['id']]);
$calendar = $calendarStmt->fetchAll();
?>
<section class="container">
    <div class="section-title">
        <h2>Calendar overview</h2>
        <a class="button secondary" href="/dashboard/index.php">Back to dashboard</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Reservations</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($calendar as $day): ?>
                <tr>
                    <td><?= e($day['pickup_date']); ?></td>
                    <td><?= e($day['total']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
