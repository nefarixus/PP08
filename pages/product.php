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
$description = trim((string) ($product['description'] ?? ''));
$in_library = false;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare('SELECT id FROM user_products WHERE user_id = ? AND product_id = ?');
    $stmt->execute([(int) $_SESSION['user_id'], $product_id]);
    $in_library = (bool) $stmt->fetch();
}

$logged_in = isset($_SESSION['user_id']);
$price_badge_class = 'pd-price-badge' . ($price > 0 ? '' : ' pd-price-badge--free');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title><?= htmlspecialchars($product['name']) ?> — СайдКвест</title>
</head>
<body>
    <div class="mobile-warning">
        <p>Сайт разработан для просмотра на компьютере.</p>
    </div>
    <?php include __DIR__ . '/../aside.php'; ?>
    <div class="page-wrapper">
        <div class="container">
            <main class="pd-wrap">
                <article class="pd-card">
                    <div class="pd-hero">
                        <img src="../images/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                    <div class="pd-divider"></div>
                    <div class="pd-panel">
                        <h1 class="pd-title"><?= htmlspecialchars($product['name']) ?></h1>
                        <div class="pd-meta">
                            <?php if ($price > 0): ?>
                                <span class="<?= htmlspecialchars($price_badge_class) ?>"><?= number_format($price, 2, ',', ' ') ?> ₽</span>
                            <?php else: ?>
                                <span class="<?= htmlspecialchars($price_badge_class) ?>">Бесплатно</span>
                            <?php endif; ?>
                        </div>
                        <?php if ($description !== ''): ?>
                            <p class="pd-desc"><?= nl2br(htmlspecialchars($description)) ?></p>
                        <?php else: ?>
                            <p class="pd-desc pd-desc--empty">Описание скоро появится.</p>
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
                    </div>
                </article>
            </main>
            <?php $asset_prefix = '..'; include __DIR__ . '/../includes/footer.php'; ?>
        </div>
    </div>
    <script>window.SITE_ROOT = '../';</script>
    <script src="../scripts/script.js"></script>
</body>
</html>
