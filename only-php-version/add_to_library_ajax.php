<?php
    header('Content-Type: application/json');
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'Вы не авторизованы']);
        exit;
    }

    require_once __DIR__ . '/includes/db.php';
    try {
        $pdo = getPDO();
    } catch (Throwable $e) {
        echo json_encode(['error' => 'Ошибка БД']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    if (!$product_id) {
        echo json_encode(['error' => 'Неверный ID']);
        exit;
    }

    $stmt = $pdo->prepare('SELECT price FROM products WHERE id = ?');
    $stmt->execute([$product_id]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prod) {
        echo json_encode(['error' => 'Товар не найден']);
        exit;
    }
    if ((float) ($prod['price'] ?? 0) > 0) {
        echo json_encode(['error' => 'Сначала оформите покупку']);
        exit;
    }

    // Проверяем, есть ли уже
    $stmt = $pdo->prepare("SELECT id FROM user_products WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['error' => 'Уже в библиотеке']);
        exit;
    }

    // Добавляем
    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $product_id]);

    echo json_encode(['success' => true]);
    exit;
?>