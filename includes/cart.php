<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

function cart_get(): array
{
    ensure_session();
    $cart = $_SESSION['cart'] ?? [];

    if (!is_array($cart)) {
        $cart = [];
    }

    return $cart;
}

function cart_set(array $cart): void
{
    ensure_session();
    $_SESSION['cart'] = $cart;
}

function cart_add(int $productId, int $quantity): void
{
    $cart = cart_get();
    $current = (int) ($cart[$productId] ?? 0);
    $cart[$productId] = max(0, $current + $quantity);
    cart_set($cart);
}

function cart_update(array $updates): void
{
    $cart = cart_get();

    foreach ($updates as $productId => $quantity) {
        $id = (int) $productId;
        $qty = max(0, (int) $quantity);

        if ($qty === 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $qty;
        }
    }

    cart_set($cart);
}

function cart_clear(): void
{
    ensure_session();
    unset($_SESSION['cart']);
}

function cart_count(): int
{
    $cart = cart_get();
    $total = 0;
    foreach ($cart as $qty) {
        $total += max(0, (int) $qty);
    }
    return $total;
}
