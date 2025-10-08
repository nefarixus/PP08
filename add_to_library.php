<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: ./pages/login.php');
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
        die("Ошибка подключения: " . $e->getMessage());
    }

    $user_id = $_SESSION['user_id'];
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    if (!$product_id) {
        die("Неверный ID продукта");
    }

    // Проверяем, есть ли уже в библиотеке
    $stmt = $pdo->prepare("SELECT id FROM user_products WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Это приложение уже в вашей библиотеке.";
    } else {
        // Добавляем
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $product_id]);
        $_SESSION['success'] = "Приложение добавлено в библиотеку!";
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
?>