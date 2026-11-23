<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/i18n.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = t('login.error');
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            login_user($user);
            if ($user['role'] === 'admin') {
                header('Location: /admin/index.php');
            } else {
                header('Location: /dashboard/index.php');
            }
            exit;
        }
        $errors[] = t('login.error');
    }
}
?>
<section class="container">
    <div class="card" style="max-width: 420px; margin: 0 auto;">
        <h2><?= e(t('login.title')); ?></h2>
        <?php if ($errors): ?>
            <div class="card" style="border-left: 4px solid #ef4444;">
                <?php foreach ($errors as $error): ?>
                    <p><?= e($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form class="form-grid" method="post">
            <div>
                <label for="email"><?= e(t('login.email')); ?></label>
                <input id="email" name="email" type="email" required>
            </div>
            <div>
                <label for="password"><?= e(t('login.password')); ?></label>
                <input id="password" name="password" type="password" required>
            </div>
            <button class="button" type="submit"><?= e(t('login.button')); ?></button>
        </form>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
