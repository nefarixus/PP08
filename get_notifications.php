<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['items' => []]);
    exit;
}

require_once __DIR__ . '/includes/db.php';
$pdo = getPDO();

$user_id = (int) $_SESSION['user_id'];

$stmt = $pdo->prepare(
    'SELECT p.name, up.added_at
     FROM user_products up
     JOIN products p ON p.id = up.product_id
     WHERE up.user_id = ?
     ORDER BY up.added_at DESC
     LIMIT 8'
);
$stmt->execute([$user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['items' => $items], JSON_UNESCAPED_UNICODE);
exit;

