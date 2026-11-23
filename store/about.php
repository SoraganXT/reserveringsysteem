<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/i18n.php';

$pdo = db();
$business = get_active_business($pdo);
if (!$business) {
    die("No business found");
}

$heroTitle = $business['hero_title'] ?? $business['name'] ?? 'Onze Winkel';
$heroSubtitle = $business['hero_subtitle'] ?? 'Ontdek onze unieke selectie en bestel eenvoudig online.';
$storyTitle = $business['story_title'] ?? 'Ons Verhaal';
$storyBody = $business['story_body'] ?? 'Welkom bij onze zaak. We staan garant voor kwaliteit, versheid en persoonlijke service.';
$heroImageUrl = $business['hero_image_url'] ?? 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=1920&q=80';

$hoursStmt = $pdo->prepare('SELECT * FROM opening_hours WHERE business_id = ? ORDER BY day_of_week = 0, day_of_week');
$hoursStmt->execute([$business['id']]);
$hours = $hoursStmt->fetchAll();

$days = [1 => 'Maandag', 2 => 'Dinsdag', 3 => 'Woensdag', 4 => 'Donderdag', 5 => 'Vrijdag', 6 => 'Zaterdag', 0 => 'Zondag'];
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title><?= e($heroTitle) ?> - <?= e($business['name']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: <?= e($business['brand_color'] ?? '#d97706'); ?>;
            --text: #1f2937;
            --bg: #fffbf5;
        }
        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text); background: var(--bg); line-height: 1.6; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .hero {
            height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.7)), url('<?= e($heroImageUrl); ?>') center/cover;
            color: #fff;
            padding: 0 20px;
        }
        .hero h1 { font-size: clamp(3rem, 8vw, 5rem); margin: 0 0 10px; font-weight: 700; }
        .hero p { font-size: clamp(1.2rem, 3vw, 1.5rem); margin: 0 0 40px; font-weight: 300; max-width: 600px; margin-left: auto; margin-right: auto; }
        .btn {
            background: var(--brand);
            color: #fff;
            padding: 16px 36px;
            text-decoration: none;
            border-radius: 99px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: transform 0.3s, box-shadow 0.3s;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); }
        .container { max-width: 1100px; margin: 0 auto; padding: 100px 20px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: start; }
        .story h2 { font-size: 3rem; color: var(--brand); margin-top:0; margin-bottom: 20px; }
        .story p { font-size: 1.1rem; color: #4b5563; margin-bottom: 20px; }
        .info-box { margin-top: 40px; padding-top: 30px; border-top: 2px solid #f3f4f6; }
        .info-box p { font-size: 1.05rem; margin-bottom: 10px; color: var(--text); }
        .hours-box { background: #fff; padding: 50px 40px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.06); position: sticky; top: 40px;}
        .hours-box h3 { font-size: 2.2rem; margin-top: 0; margin-bottom: 30px; text-align: center; color: var(--text); }
        .hour-row { display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #f3f4f6; font-size: 1.1rem; }
        .hour-row:last-child { border: none; }
        .closed { color: #ef4444; font-weight: 600; }
        footer { background: #1f2937; color: #9ca3af; text-align: center; padding: 50px 20px; margin-top: 40px;}
        footer a { color: #f3f4f6; text-decoration: none; font-weight: 600; }
        footer a:hover { color: var(--brand); }
        @media (max-width: 768px) {
            .grid { grid-template-columns: 1fr; gap: 50px; }
        }
    </style>
</head>
<body>
    <section class="hero">
        <div>
            <h1><?= e($heroTitle) ?></h1>
            <p><?= e($heroSubtitle) ?></p>
            <a href="/store/index.php" class="btn">Plaats een Bestelling</a>
        </div>
    </section>

    <section class="container">
        <div class="grid">
            <div class="story">
                <h2><?= e($storyTitle) ?></h2>
                <p><?= nl2br(e($storyBody)) ?></p>
                <?php if (!empty($business['description'])): ?>
                    <p><?= nl2br(e($business['description'])) ?></p>
                <?php endif; ?>
                
                <div class="info-box">
                    <?php if (!empty($business['address'])): ?>
                        <p><strong>Adres:</strong> <?= e($business['address']) ?></p>
                    <?php endif; ?>
                    <?php if(!empty($business['contact_email'])): ?>
                    <p><strong>Email:</strong> <?= e($business['contact_email']) ?></p>
                    <?php endif; ?>
                    <?php if(!empty($business['contact_phone'])): ?>
                    <p><strong>Tel:</strong> <?= e($business['contact_phone']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hours-box">
                <h3>Openingsuren</h3>
                <?php foreach($hours as $h): ?>
                    <div class="hour-row">
                        <span><?= $days[$h['day_of_week']] ?></span>
                        <?php if($h['is_closed'] || empty($h['open_time'])): ?>
                            <span class="closed">Gesloten</span>
                        <?php else: ?>
                            <span><?= substr((string)$h['open_time'], 0, 5) ?> - <?= substr((string)$h['close_time'], 0, 5) ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; <?= date('Y') ?> <?= e($business['name']) ?>. Alle rechten voorbehouden.</p>
        <p style="margin-top: 20px;"><a href="/store/index.php">Ga naar onze Webshop</a></p>
    </footer>
</body>
</html>
