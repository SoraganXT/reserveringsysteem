<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_role('admin');

$statsStmt = $pdo->query('SELECT status, COUNT(*) AS total FROM reservations GROUP BY status');
$stats = $statsStmt->fetchAll();

$businesses = $pdo->query('SELECT COUNT(*) AS total FROM businesses')->fetch();
?>
<section class="container">
    <div class="section-title">
        <h2>Platform admin</h2>
        <a class="button" href="/admin/businesses.php">Manage stores</a>
    </div>
    <div class="card-grid">
        <div class="card">
            <h3>Total stores</h3>
            <p><?= e($businesses['total'] ?? 0); ?></p>
        </div>
        <?php foreach ($stats as $stat): ?>
            <div class="card">
                <h3><?= e(ucfirst($stat['status'])); ?></h3>
                <p><?= e($stat['total']); ?> reservations</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
