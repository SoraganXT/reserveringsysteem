<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_role('admin');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name === '' || $slug === '') {
        $errors[] = 'Please enter a name and slug.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO businesses (name, slug, description, active, created_at, updated_at) VALUES (?, ?, ?, 0, NOW(), NOW())');
        $stmt->execute([$name, $slug, $description]);
        $success = true;
    }
}

if (isset($_GET['activate'])) {
    $id = (int) $_GET['activate'];
    $pdo->exec('UPDATE businesses SET active = 0');
    $stmt = $pdo->prepare('UPDATE businesses SET active = 1 WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: /admin/businesses.php');
    exit;
}

$businesses = $pdo->query('SELECT * FROM businesses ORDER BY created_at DESC')->fetchAll();
?>
<section class="container">
    <div class="section-title">
        <h2>Stores</h2>
        <a class="button" href="/admin/branding.php">Branding</a>
    </div>

    <?php if ($success): ?>
        <div class="card">Store created successfully.</div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="card" style="border-left: 4px solid #ef4444;">
            <?php foreach ($errors as $error): ?>
                <p><?= e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card form-grid">
        <h3>Create new store</h3>
        <form method="post" class="form-grid">
            <div>
                <label for="name">Business name</label>
                <input id="name" name="name" required>
            </div>
            <div>
                <label for="slug">Slug</label>
                <input id="slug" name="slug" required>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3"></textarea>
            </div>
            <button class="button" type="submit">Create store</button>
        </form>
    </div>

    <table class="table" style="margin-top: 24px;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($businesses as $biz): ?>
                <tr>
                    <td><?= e($biz['name']); ?></td>
                    <td><?= e($biz['slug']); ?></td>
                    <td><?= $biz['active'] ? 'Active' : 'Inactive'; ?></td>
                    <td>
                        <?php if (!$biz['active']): ?>
                            <a class="button secondary" href="/admin/businesses.php?activate=<?= e($biz['id']); ?>">Set active</a>
                        <?php else: ?>
                            <span class="badge">Current</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
