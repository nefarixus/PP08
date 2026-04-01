<?php

declare(strict_types=1);

session_start();

$product_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$product_id) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';
$pdo = getPDO();

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: ../index.php');
    exit;
}

$price = (float) ($product['price'] ?? 0);
$description = $product['description'] ?? '';
$in_library = false;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare('SELECT id FROM user_products WHERE user_id = ? AND product_id = ?');
    $stmt->execute([(int) $_SESSION['user_id'], $product_id]);
    $in_library = (bool) $stmt->fetch();
}

$logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title><?= htmlspecialchars($product['name']) ?> — СайдКвест</title>
    <style>
        .pd-wrap { max-width: 720px; margin: 40px auto; padding: 24px; color: #fff; }
        .pd-hero { border-radius: 16px; overflow: hidden; margin-bottom: 24px; }
        .pd-hero img { width: 100%; display: block; max-height: 320px; object-fit: cover; }
        .pd-desc { color: #c4c4c4; line-height: 1.6; margin: 16px 0; }
        .pd-price { font-size: 22px; color: #a78bfa; margin: 12px 0; }
        .pd-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 20px; }
        .pd-btn {
            padding: 12px 24px; border-radius: 999px; border: none; cursor: pointer;
            font-family: inherit; font-size: 15px; text-decoration: none; display: inline-block;
        }
        .pd-btn-primary { background: linear-gradient(90deg, #7c3aed, #db2777); color: #fff; }
        .pd-btn-secondary { background: #333; color: #fff; }
        .pd-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    </style>
</head>
<body>
    <div class="mobile-warning">
        <p>Сайт разработан для просмотра на компьютере.</p>
    </div>
    <?php include __DIR__ . '/../aside.php'; ?>
    <div class="page-wrapper">
        <div class="container">
            <main class="pd-wrap">
                <div class="pd-hero">
                    <img src="../images/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
                <h1><?= htmlspecialchars($product['name']) ?></h1>
                <?php if ($price > 0): ?>
                    <p class="pd-price"><?= number_format($price, 2, ',', ' ') ?> ₽</p>
                <?php else: ?>
                    <p class="pd-price">Бесплатно</p>
                <?php endif; ?>
                <?php if ($description !== ''): ?>
                    <p class="pd-desc"><?= nl2br(htmlspecialchars($description)) ?></p>
                <?php endif; ?>

                <div class="pd-actions">
                    <a href="../index.php" class="pd-btn pd-btn-secondary">← К каталогу</a>
                    <?php if (!$logged_in): ?>
                        <a href="login.php" class="pd-btn pd-btn-primary">Войти, чтобы добавить или купить</a>
                    <?php elseif ($in_library): ?>
                        <button type="button" class="pd-btn pd-btn-secondary" disabled>Уже в библиотеке</button>
                    <?php elseif ($price > 0): ?>
                        <a href="checkout.php?product_id=<?= (int) $product['id'] ?>" class="pd-btn pd-btn-primary">Купить</a>
                    <?php else: ?>
                        <button type="button" class="pd-btn pd-btn-primary add-button" data-product-id="<?= (int) $product['id'] ?>">Добавить в библиотеку</button>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
    <script>window.SITE_ROOT = '../';</script>
    <script src="../scripts/script.js"></script>
</body>
</html>
