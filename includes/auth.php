<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

function ensure_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function current_user(): ?array
{
    ensure_session();
    return $_SESSION['user'] ?? null;
}

function login_user(array $user): void
{
    ensure_session();
    $_SESSION['user'] = [
        'id' => (int) $user['id'],
        'business_id' => $user['business_id'] !== null ? (int) $user['business_id'] : null,
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role'],
    ];
}

function logout_user(): void
{
    ensure_session();
    $_SESSION = [];
    session_destroy();
}

function require_login(): void
{
    if (!current_user()) {
        header('Location: /auth/login.php');
        exit;
    }
}

function require_role(string $role): void
{
    require_login();
    $user = current_user();

    if (!$user || $user['role'] !== $role) {
        http_response_code(403);
        echo 'Access denied.';
        exit;
    }
}

function is_admin(): bool
{
    $user = current_user();
    return $user && $user['role'] === 'admin';
}

function is_owner(): bool
{
    $user = current_user();
    return $user && $user['role'] === 'owner';
}
