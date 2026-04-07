<?php
    session_start();

    require_once __DIR__ . '/includes/db.php';
    $pdo = getPDO();

    // Получаем данные
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$email || empty($password)) {
        $_SESSION['error'] = "Введите email и пароль";
        header('Location: ./pages/login.php');
        exit;
    }

    // Ищем пользователя
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверяем существование пользователя и верификацию хэшированного пароля
    if (!$user || !password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Неверный email или пароль";
        header('Location: ./pages/login.php');
        exit;
    }

    // Успех — сохраняем в сессии
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['login'] = $user['login'];
    $_SESSION['email'] = $user['email'];
    // Сохраняем роль пользователя для последующей проверки прав доступа
    $_SESSION['role'] = $user['role'] ?? 'user';

    if (!empty($_SESSION['redirect_after_login'])) {
        $r = $_SESSION['redirect_after_login'];
        unset($_SESSION['redirect_after_login']);
        if (preg_match('#^pages/[a-z0-9_]+\.php#i', $r)) {
            header('Location: ' . $r);
            exit;
        }
    }

    header('Location: index.php');
    exit;
?>