<?php

declare(strict_types=1);

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: pages/login.php');
    exit;
}

$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
if (!$product_id) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/includes/db.php';
$pdo = getPDO();

$stmt = $pdo->prepare('SELECT id, name, price FROM products WHERE id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    $_SESSION['error'] = 'Товар не найден.';
    header('Location: index.php');
    exit;
}

$price = (float) $product['price'];
if ($price <= 0) {
    header('Location: pages/product.php?id=' . $product_id);
    exit;
}

$user_id = (int) $_SESSION['user_id'];

$stmt = $pdo->prepare('SELECT id FROM user_products WHERE user_id = ? AND product_id = ?');
$stmt->execute([$user_id, $product_id]);
if ($stmt->fetch()) {
    $_SESSION['error'] = 'Это приложение уже в вашей библиотеке.';
    header('Location: pages/product.php?id=' . $product_id);
    exit;
}

$stmt = $pdo->prepare(
    'SELECT o.id FROM orders o
     JOIN order_items oi ON o.id = oi.order_id
     WHERE o.user_id = ? AND oi.product_id = ? AND o.status = ?'
);
$stmt->execute([$user_id, $product_id, 'pending']);
$pending_order_id = $stmt->fetchColumn();
if ($pending_order_id) {
    header('Location: pages/pay_test.php?order_id=' . (int) $pending_order_id);
    exit;
}

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare('INSERT INTO orders (user_id, status, total) VALUES (?, ?, ?)');
    $stmt->execute([$user_id, 'pending', $price]);
    $order_id = (int) $pdo->lastInsertId();

    $stmt = $pdo->prepare(
        'INSERT INTO order_items (order_id, product_id, price_at_purchase) VALUES (?, ?, ?)'
    );
    $stmt->execute([$order_id, $product_id, $price]);

    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    $_SESSION['error'] = 'Не удалось создать заказ. Проверьте, что в базе выполнена миграция (таблицы orders, order_items).';
    header('Location: pages/checkout.php?product_id=' . $product_id);
    exit;
}

header('Location: pages/pay_test.php?order_id=' . $order_id);
exit;
