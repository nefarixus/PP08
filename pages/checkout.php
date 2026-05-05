<?php

declare(strict_types=1);

session_start();

$product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
if (!$product_id) {
    header('Location: ../index.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'pages/checkout.php?product_id=' . $product_id;
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';
$pdo = getPDO();

$stmt = $pdo->prepare('SELECT name, price FROM products WHERE id = ? AND price > 0');
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: ../index.php');
    exit;
}

$price = (float) $product['price'];
$name = htmlspecialchars($product['name']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Оплата <?= $name ?> — СайдКвест</title>
</head>
<body>
    <div class="mobile-warning">
        <p>Сайт разработан для просмотра на компьютере.</p>
    </div>
    <?php include __DIR__ . '/../aside.php'; ?>
    <div class="page-wrapper">
        <div class="container">
            <main class="ch-wrap">
                <article class="ch-card">
                    <h1 class="ch-title">Оплата покупки</h1>
                    <p class="ch-product-name"><?= $name ?></p>
                    <p class="ch-price"><?= number_format($price, 2, ',', ' ') ?> ₽</p>
                    <form id="paymentForm" method="POST" action="../create_order.php">
                        <input type="hidden" name="product_id" value="<?= (int) $product_id ?>">
                        <button type="submit" class="pd-btn pd-btn-primary ch-pay-btn">Оплатить тестовым платежом</button>
                    </form>
                    <p class="ch-note">Это тестовый платеж. Никакие реальные деньги не списываются.</p>
                </article>
            </main>
            <?php $asset_prefix = '..'; include __DIR__ . '/../includes/footer.php'; ?>
        </div>
    </div>
    <script>window.SITE_ROOT = '../';</script>
    <script src="../scripts/script.js"></script>
</body>
</html>
