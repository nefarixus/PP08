<?php
    session_start();

    // Подключение к базе данных
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