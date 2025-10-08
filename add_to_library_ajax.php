<?php
    header('Content-Type: application/json');
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'Вы не авторизованы']);
        exit;
    }

    $host = '127.0.0.1';
    $dbname = 'sidequest';
    $username = 'root';
    $password_db = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Ошибка БД']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    if (!$product_id) {
        echo json_encode(['error' => 'Неверный ID']);
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