<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Cantarell:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Профиль — <?= htmlspecialchars($login) ?></title>
    <style>
        body {
            background-color: #0f0f0f;
            color: white;
            font-family: 'Roboto', sans-serif;
        }
        .profile-container {
            border-radius: 50px;
            max-width: 1200px;
            margin: 60px auto;
            padding: 20px;
        }
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }
        .profile-info h1 {
            margin: 0;
            font-size: 28px;
        }
        .profile-stats {
            display: flex;
            gap: 20px;
            margin-top: 10px;
            color: #aaa;
        }
        .game-grid {
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .game-card {
            background: #1d1d1d;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .game-card:hover {
            transform: scale(1.05);
        }
        .game-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }
        .game-name {
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
        .empty {
            text-align: center;
            color: #888;
            font-size: 18px;
            margin: 50px 0;
        }
    </style>
</head>
<body>
    <?php include '../aside.php'; ?>
    <div class="page-wrapper">
        <div class="container">
            <main class="profile-container">
                <div class="profile-header">
                    <div class="profile-avatar"><?= strtoupper(substr($login, 0, 2)) ?></div>
                    <div class="profile-info">
                        <h1><?= htmlspecialchars($login) ?></h1>
                        <div class="profile-stats">
                            <span><?= $games_in_lib ?> игр в библиотеке</span>
                            <span><?= round(($games_in_lib / $total_games) * 100) ?>% завершено</span>
                        </div>
                    </div>
                </div>

                <h2>Моя библиотека</h2>
                <?php if (empty($library)): ?>
                    <p class="empty">Вы ещё не добавили ни одного приложения.</p>
                <?php else: ?>
                    <div class="game-grid">
                        <?php foreach (array_reverse($library) as $game): ?>
                            <div class="game-card">
                                <img src="../images/<?= htmlspecialchars($game['img']) ?>" alt="<?= htmlspecialchars($game['name']) ?>" class="game-img">
                                <div class="game-name"><?= htmlspecialchars($game['name']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
    <script src="../scripts/script.js"></script>
</body>
</html>