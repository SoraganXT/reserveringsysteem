<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/header.php';
require_role('admin');

$business = get_active_business($pdo);
if (!$business) {
    echo '<div class="container">No active business found.</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $brandColor = trim($_POST['brand_color'] ?? '');
    $themeColor = trim($_POST['theme_color'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $contactEmail = trim($_POST['contact_email'] ?? '');
    $contactPhone = trim($_POST['contact_phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $heroTitle = trim($_POST['hero_title'] ?? '');
    $heroSubtitle = trim($_POST['hero_subtitle'] ?? '');
    $storyTitle = trim($_POST['story_title'] ?? '');
    $storyBody = trim($_POST['story_body'] ?? '');
    $heroImageUrl = trim($_POST['hero_image_url'] ?? '');
    $logoPath = $business['logo_path'];

    if (!empty($_FILES['logo']['name'])) {
        $uploadDir = __DIR__ . '/../uploads/logos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = time() . '_' . basename($_FILES['logo']['name']);
        $target = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
            $logoPath = '/uploads/logos/' . $filename;
        } else {
            $errors[] = 'Logo upload failed.';
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare('UPDATE businesses SET name = ?, brand_color = ?, theme_color = ?, logo_path = ?, website = ?, contact_email = ?, contact_phone = ?, address = ?, hero_title = ?, hero_subtitle = ?, story_title = ?, story_body = ?, hero_image_url = ?, updated_at = NOW() WHERE id = ?');
        $stmt->execute([
            $name,
            $brandColor,
            $themeColor,
            $logoPath,
            $website,
            $contactEmail,
            $contactPhone,
            $address,
            $heroTitle,
            $heroSubtitle,
            $storyTitle,
            $storyBody,
            $heroImageUrl,
            $business['id'],
        ]);
        $success = true;
        $business = get_active_business($pdo);
    }
}
?>
<section class="container">
    <div class="section-title">
        <h2>Branding</h2>
        <a class="button secondary" href="/admin/businesses.php">Back to stores</a>
    </div>

    <?php if ($success): ?>
        <div class="card">Branding updated.</div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="card" style="border-left: 4px solid #ef4444;">
            <?php foreach ($errors as $error): ?>
                <p><?= e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form class="card form-grid" method="post" enctype="multipart/form-data">
        <div>
            <label for="name">Business name</label>
            <input id="name" name="name" value="<?= e($business['name']); ?>">
        </div>
        <div>
            <label for="brand_color">Brand color</label>
            <input id="brand_color" name="brand_color" value="<?= e($business['brand_color']); ?>" placeholder="#0f766e">
        </div>
        <div>
            <label for="theme_color">Theme color</label>
            <input id="theme_color" name="theme_color" value="<?= e($business['theme_color']); ?>" placeholder="#0b1320">
        </div>
        <div>
            <label for="logo">Logo</label>
            <input id="logo" type="file" name="logo">
        </div>
        <div>
            <label for="website">Website</label>
            <input id="website" name="website" value="<?= e($business['website'] ?? ''); ?>" placeholder="https://voorbeeld.be">
        </div>
        <div>
            <label for="contact_email">Contact email</label>
            <input id="contact_email" name="contact_email" value="<?= e($business['contact_email'] ?? ''); ?>" placeholder="info@winkel.be">
        </div>
        <div>
            <label for="contact_phone">Contact phone</label>
            <input id="contact_phone" name="contact_phone" value="<?= e($business['contact_phone'] ?? ''); ?>" placeholder="+32 2 123 45 67">
        </div>
        <div>
            <label for="address">Address</label>
            <input id="address" name="address" value="<?= e($business['address'] ?? ''); ?>" placeholder="Straat 1, 1000 Brussel">
        </div>
        <div>
            <label for="hero_title">Homepage hero title</label>
            <input id="hero_title" name="hero_title" value="<?= e($business['hero_title'] ?? ''); ?>" placeholder="Sunrise Bakery">
        </div>
        <div>
            <label for="hero_subtitle">Homepage hero subtitle</label>
            <textarea id="hero_subtitle" name="hero_subtitle" rows="2"><?= e($business['hero_subtitle'] ?? ''); ?></textarea>
        </div>
        <div>
            <label for="story_title">Story title</label>
            <input id="story_title" name="story_title" value="<?= e($business['story_title'] ?? ''); ?>" placeholder="Ons Verhaal">
        </div>
        <div>
            <label for="story_body">Story content</label>
            <textarea id="story_body" name="story_body" rows="4"><?= e($business['story_body'] ?? ''); ?></textarea>
        </div>
        <div>
            <label for="hero_image_url">Hero image URL</label>
            <input id="hero_image_url" name="hero_image_url" value="<?= e($business['hero_image_url'] ?? ''); ?>" placeholder="https://images.unsplash.com/...">
        </div>
        <button class="button" type="submit">Save branding</button>
    </form>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
