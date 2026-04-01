<?php
    session_start();

    require_once __DIR__ . '/includes/db.php';
    $pdo = getPDO();

    // Получаем данные из формы
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$email || empty($password)) {
        $_SESSION['error'] = "Все поля обязательны.";
        header('Location: ./pages/reg.php');
        exit;
    }

    // Логин = часть email до @
    $login = explode('@', $email)[0];

    // Проверяем, не существует ли уже такой email
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Пользователь с таким email уже существует.";
        header('Location: ./pages/reg.php');
        exit;
    }

    // Вставляем пользователя (пароль без хэширования)
    $stmt = $pdo->prepare("INSERT INTO users (login, password, email) VALUES (?, ?, ?)");
    $stmt->execute([$login, $password, $email]);

    // Сохраняем успех в сессии
    $_SESSION['registration_success'] = true;
    $_SESSION['registered_email'] = $email;

    // Перенаправляем
    header('Location: ./pages/login.php?registered=1');
    exit;
?>