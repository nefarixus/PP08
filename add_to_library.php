<?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: ./pages/login.php');
        exit;
    }

    require_once __DIR__ . '/includes/db.php';
    $pdo = getPDO();

    $user_id = $_SESSION['user_id'];
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

    if (!$product_id) {
        die("Неверный ID продукта");
    }

    $stmt = $pdo->prepare('SELECT price FROM products WHERE id = ?');
    $stmt->execute([$product_id]);
    $prod = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$prod) {
        die("Товар не найден");
    }
    if ((float) ($prod['price'] ?? 0) > 0) {
        $_SESSION['error'] = 'Платные приложения добавляются после покупки.';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit;
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