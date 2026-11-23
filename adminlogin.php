<?php

declare(strict_types=1);

$pageTitle = 'Personeel';
require_once __DIR__ . '/includes/i18n.php';
$pageTitle = t('staff.title');
require_once __DIR__ . '/includes/header.php';

$user = current_user();
if ($user) {
    if ($user['role'] === 'admin') {
        header('Location: /admin/index.php');
        exit;
    }

    if ($user['role'] === 'owner') {
        header('Location: /dashboard/index.php');
        exit;
    }
}
?>
<section class="container">
    <div class="card" style="max-width: 520px; margin: 0 auto; text-align: center;">
        <h2><?= e(t('staff.title')); ?></h2>
        <p><?= e(t('staff.subtitle')); ?></p>
        <a class="button" href="/auth/login.php"><?= e(t('staff.button')); ?></a>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
