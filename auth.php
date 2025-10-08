<?php
    session_start();

    // Подключение к БД
    $host = '127.0.0.1';
    $dbname = 'sidequest';
    $username = 'root';
    $password_db = ''; // Укажи свой пароль, если есть

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password_db);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Ошибка подключения: " . $e->getMessage());
    }

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

    if (!$user || $user['password'] !== $password) { // Пароль не хэширован
        $_SESSION['error'] = "Неверный email или пароль";
        header('Location: ./pages/login.php');
        exit;
    }

    // Успех — сохраняем в сессии
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['login'] = $user['login'];
    $_SESSION['email'] = $user['email'];

    // Перенаправляем на главную
    header('Location: index.php');
    exit;
?>