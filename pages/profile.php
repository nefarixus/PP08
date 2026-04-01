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
            background-color: #050509;
            color: #f9fafb;
            font-family: var(--font-ui, system-ui, -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif);
        }
        .profile-container {
            max-width: 1120px;
            margin: 56px auto 72px;
            padding: 32px 32px 40px;
            border-radius: 32px;
            background: #0f0f0f;
            border: 1px solid rgba(255, 255, 255, 0.10);
            box-shadow:
                0 40px 80px rgba(0, 0, 0, 0.75),
                0 0 0 1px rgba(0, 0, 0, 0.55);
        }
        .profile-header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 28px;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 24px;
            background: #2a2a2a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 800;
            font-family: var(--font-ui, system-ui, sans-serif);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            box-shadow:
                0 12px 32px rgba(0, 0, 0, 0.55),
                0 0 0 1px rgba(255, 255, 255, 0.08);
        }
        .profile-info h1 {
            margin: 0;
            font-size: 26px;
            font-family: var(--font-ui, system-ui, sans-serif);
            letter-spacing: 0.03em;
            text-transform: none;
        }
        .profile-tagline {
            margin-top: 6px;
            font-size: 13px;
            color: #9ca3af;
        }
        .profile-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 14px;
        }
        .profile-stat-card {
            min-width: 160px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(0, 0, 0, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            color: #e5e7eb;
        }
        .profile-stat-label {
            opacity: 0.75;
        }
        .profile-stat-value {
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            color: #e5e7eb;
            margin-left: 4px;
        }
        .profile-section-header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
            margin-top: 32px;
            margin-bottom: 12px;
        }
        .profile-section-header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        .profile-section-meta {
            font-size: 13px;
            color: #9ca3af;
        }
        .game-grid {
            margin-top: 8px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 18px;
        }
        .game-card {
            background: #141414;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.10);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.65);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .game-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 28px 60px rgba(0, 0, 0, 0.75);
            border-color: rgba(255, 255, 255, 0.16);
        }
        .game-img {
            width: 100%;
            height: 126px;
            object-fit: cover;
            display: block;
        }
        .game-name {
            padding: 10px 12px 12px;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            color: #e5e7eb;
        }
        .game-name span {
            font-size: 11px;
            display: block;
            margin-top: 4px;
            color: #6b7280;
        }
        .empty {
            text-align: center;
            color: #9ca3af;
            font-size: 16px;
            margin: 40px 0 8px;
        }
        .empty-sub {
            text-align: center;
            color: #6b7280;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="mobile-warning">
        <p>Сайт разработан для просмотра на компьютере.</p>
        <p>Пожалуйста, откройте его с десктопного устройства для лучшего опыта.</p>
    </div>
    <?php include '../aside.php'; ?>
    <div class="page-wrapper">
        <div class="container">
            <main class="profile-container">
                <?php if ($purchased_ok): ?>
                    <p style="background:#14532d;color:#bbf7d0;padding:12px 16px;border-radius:12px;margin-bottom:20px;">
                        Оплата прошла успешно — товар добавлен в библиотеку.
                    </p>
                <?php endif; ?>
                <div class="profile-header">
                    <div class="profile-avatar"><?= strtoupper(substr($login, 0, 2)) ?></div>
                    <div class="profile-info">
                        <h1><?= htmlspecialchars($login) ?></h1>
                        <div class="profile-tagline">Личная библиотека VR-приложений</div>
                        <div class="profile-stats">
                            <div class="profile-stat-card">
                                <span class="profile-stat-label">В библиотеке</span>
                                <span class="profile-stat-value"><?= $games_in_lib ?></span>
                            </div>
                            <div class="profile-stat-card">
                                <span class="profile-stat-label">Каталог закрыт на</span>
                                <span class="profile-stat-value"><?= $total_games > 0 ? round(($games_in_lib / $total_games) * 100) : 0 ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-section-header">
                    <h2>Моя библиотека</h2>
                    <div class="profile-section-meta">
                        <?= $games_in_lib ?> из <?= $total_games ?> доступных приложений
                    </div>
                </div>
                <?php if (empty($library)): ?>
                    <p class="empty">Вы ещё не добавили ни одного приложения.</p>
                    <p class="empty-sub">Откройте главную страницу и нажмите «Добавить» или «Купить» на понравившихся проектах.</p>
                <?php else: ?>
                    <div class="game-grid">
                        <?php foreach (array_reverse($library) as $game): ?>
                            <div class="game-card">
                                <img src="../images/<?= htmlspecialchars($game['img']) ?>" alt="<?= htmlspecialchars($game['name']) ?>" class="game-img">
                                <div class="game-name">
                                    <?= htmlspecialchars($game['name']) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </main>
            <?php $asset_prefix = '..'; include __DIR__ . '/../includes/footer.php'; ?>
        </div>
    </div>
    <script src="../scripts/script.js"></script>
</body>
</html>