<?php

    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    require_once __DIR__ . '/../includes/db.php';
    $pdo = getPDO();

    $user_id = $_SESSION['user_id'];
    $login = $_SESSION['login'];

    // Получаем игры из библиотеки пользователя
    $stmt = $pdo->prepare("
        SELECT p.* FROM products p
        JOIN user_products up ON p.id = up.product_id
        WHERE up.user_id = ?
        ORDER BY up.added_at DESC
    ");
    $stmt->execute([$user_id]);
    $library = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Общая статистика
    $stmt_all = $pdo->query("SELECT COUNT(*) as total FROM products");
    $total_games = $stmt_all->fetch()['total'];

    $games_in_lib = count($library);
    $purchased_ok = isset($_GET['paid']) && $_GET['paid'] === '1';
?>