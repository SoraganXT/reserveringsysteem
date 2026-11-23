<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';

$pdo = db();
$now = date('Y-m-d H:i:s');

$users = [
    [
        'name' => 'Platform Admin',
        'email' => 'admin@demo.local',
        'password' => 'Admin123!',
        'role' => 'admin',
        'business_id' => null,
    ],
    [
        'name' => 'Store Owner',
        'email' => 'owner@demo.local',
        'password' => 'Owner123!',
        'role' => 'owner',
        'business_id' => 1,
    ],
];

foreach ($users as $user) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$user['email']]);

    if ($stmt->fetch()) {
        echo "User already exists: {$user['email']}\n";
        continue;
    }

    $hash = password_hash($user['password'], PASSWORD_DEFAULT);
    $insert = $pdo->prepare('INSERT INTO users (business_id, name, email, password_hash, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $insert->execute([
        $user['business_id'],
        $user['name'],
        $user['email'],
        $hash,
        $user['role'],
        $now,
        $now,
    ]);

    echo "Created user: {$user['email']}\n";
}

echo "Seed complete. Delete scripts/seed.php after running for security.\n";
