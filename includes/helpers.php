<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function get_active_business(PDO $pdo): ?array
{
    static $cached = null;

    if ($cached !== null) {
        return $cached;
    }

    $stmt = $pdo->query('SELECT * FROM businesses WHERE active = 1 ORDER BY id ASC LIMIT 1');
    $cached = $stmt->fetch();

    return $cached ?: null;
}

function brand_color(array $business = null): string
{
    if ($business && !empty($business['brand_color'])) {
        return (string) $business['brand_color'];
    }

    return '#0f766e';
}

function theme_color(array $business = null): string
{
    if ($business && !empty($business['theme_color'])) {
        return (string) $business['theme_color'];
    }

    return '#0b1320';
}
