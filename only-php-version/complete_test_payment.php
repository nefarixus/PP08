<?php

declare(strict_types=1);

session_start();

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Нужна авторизация']);
    exit;
}

$order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
if (!$order_id) {
    echo json_encode(['error' => 'Неверный заказ']);
    exit;
}

$user_id = (int) $_SESSION['user_id'];

require_once __DIR__ . '/includes/db.php';
$pdo = getPDO();

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        'SELECT id, status, total FROM orders WHERE id = ? AND user_id = ? FOR UPDATE'
    );
    $stmt->execute([$order_id, $user_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        $pdo->rollBack();
        echo json_encode(['error' => 'Заказ не найден']);
        exit;
    }

    if ($order['status'] !== 'pending') {
        $pdo->rollBack();
        echo json_encode(['error' => 'Заказ уже обработан']);
        exit;
    }

    $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ? AND user_id = ?');
    $stmt->execute(['paid_test', $order_id, $user_id]);

    $stmt = $pdo->prepare('SELECT product_id FROM order_items WHERE order_id = ?');
    $stmt->execute([$order_id]);
    $product_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $ins = $pdo->prepare(
        'INSERT IGNORE INTO user_products (user_id, product_id) VALUES (?, ?)'
    );
    foreach ($product_ids as $pid) {
        $ins->execute([$user_id, (int) $pid]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['error' => 'Ошибка оплаты. Выполнена ли миграция БД?']);
}
