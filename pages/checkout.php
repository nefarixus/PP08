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

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: ../index.php');
    exit;
}

$price = (float) ($product['price'] ?? 0);
if ($price <= 0) {
    header('Location: product.php?id=' . $product_id);
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT id FROM user_products WHERE user_id = ? AND product_id = ?');
$stmt->execute([$user_id, $product_id]);
if ($stmt->fetch()) {
    header('Location: product.php?id=' . $product_id);
    exit;
}

$err = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Оформление — <?= htmlspecialchars($product['name']) ?></title>
    <style>
        .checkout-wrap { max-width: 520px; margin: 48px auto; padding: 24px; color: #fff; }
        .checkout-card { background: #1d1d1d; border-radius: 16px; padding: 24px; }
        .checkout-card img { width: 100%; max-height: 200px; object-fit: cover; border-radius: 12px; margin-bottom: 16px; }
        .checkout-price { font-size: 22px; margin: 12px 0; color: #a78bfa; }
        .checkout-btn {
            display: inline-block; margin-top: 20px; padding: 14px 28px;
            background: linear-gradient(90deg, #7c3aed, #db2777); color: #fff;
            border: none; border-radius: 999px; font-size: 16px; cursor: pointer; font-family: inherit;
        }
        .checkout-btn:hover { opacity: 0.92; }
        .checkout-err { color: #f87171; margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="mobile-warning">
        <p>Сайт разработан для просмотра на компьютере.</p>
    </div>
    <?php include __DIR__ . '/../aside.php'; ?>
    <div class="page-wrapper">
        <div class="container">
            <main class="checkout-wrap">
                <h1>Оформление</h1>
                <?php if ($err): ?>
                    <p class="checkout-err"><?= htmlspecialchars($err) ?></p>
                <?php endif; ?>
                <div class="checkout-card">
                    <img src="../images/<?= htmlspecialchars($product['img']) ?>" alt="">
                    <h2><?= htmlspecialchars($product['name']) ?></h2>
                    <p class="checkout-price"><?= number_format($price, 2, ',', ' ') ?> ₽</p>
                    <p style="color:#aaa;font-size:14px;">Далее откроется тестовая оплата (без реальных денег).</p>
                    <form action="../create_order.php" method="post">
                        <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                        <button type="submit" class="checkout-btn">Перейти к оплате</button>
                    </form>
                </div>
                <p style="margin-top:20px;"><a href="product.php?id=<?= (int) $product['id'] ?>" style="color:#a78bfa;">← Назад к карточке</a></p>
            </main>
        </div>
    </div>
    <script src="../scripts/script.js"></script>
</body>
</html>
