<?php

declare(strict_types=1);

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$order_id = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);
if (!$order_id) {
    header('Location: ../index.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';
$pdo = getPDO();
$user_id = (int) $_SESSION['user_id'];

$stmt = $pdo->prepare(
    'SELECT o.id, o.status, o.total, o.created_at, p.name, p.img
     FROM orders o
     JOIN order_items oi ON o.id = oi.order_id
     JOIN products p ON oi.product_id = p.id
     WHERE o.id = ? AND o.user_id = ?'
);
$stmt->execute([$order_id, $user_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header('Location: ../index.php');
    exit;
}

if ($row['status'] === 'paid_test') {
    header('Location: profile.php?paid=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Тестовая оплата</title>
    <style>
        .pay-wrap { max-width: 480px; margin: 48px auto; padding: 24px; color: #fff; }
        .pay-card { background: #1d1d1d; border-radius: 16px; padding: 24px; text-align: center; }
        .pay-card img { max-width: 100%; border-radius: 12px; margin-bottom: 16px; }
        .pay-total { font-size: 24px; color: #4ade80; margin: 16px 0; }
        .pay-mock {
            background: #262626; border: 1px dashed #525252; border-radius: 12px;
            padding: 16px; margin: 20px 0; color: #a3a3a3; font-size: 14px;
        }
        .pay-btn {
            padding: 14px 32px; background: #16a34a; color: #fff; border: none;
            border-radius: 999px; font-size: 16px; cursor: pointer; font-family: inherit;
        }
        .pay-btn:hover { background: #15803d; }
        .pay-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    </style>
</head>
<body>
    <div class="mobile-warning">
        <p>Сайт разработан для просмотра на компьютере.</p>
    </div>
    <?php include __DIR__ . '/../aside.php'; ?>
    <div class="page-wrapper">
        <div class="container">
            <main class="pay-wrap">
                <h1>Тестовая оплата</h1>
                <div class="pay-card">
                    <img src="../images/<?= htmlspecialchars($row['img']) ?>" alt="">
                    <h2><?= htmlspecialchars($row['name']) ?></h2>
                    <p class="pay-total"><?= number_format((float) $row['total'], 2, ',', ' ') ?> ₽</p>
                    <div class="pay-mock">
                        Имитация платёжного окна.<br>
                        Нажмите кнопку ниже, чтобы зачислить покупку в библиотеку (режим учебного проекта).
                    </div>
                    <button type="button" class="pay-btn" id="payTestBtn">Оплатить (тест)</button>
                    <p id="payMsg" style="margin-top:12px;color:#f87171;"></p>
                </div>
                <p style="margin-top:20px;"><a href="../index.php" style="color:#a78bfa;">На главную</a></p>
            </main>
        </div>
    </div>
    <script>
    document.getElementById('payTestBtn').addEventListener('click', async function() {
        const btn = this;
        const msg = document.getElementById('payMsg');
        msg.textContent = '';
        btn.disabled = true;
        const fd = new URLSearchParams();
        fd.set('order_id', '<?= (int) $order_id ?>');
        const r = await fetch('../complete_test_payment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: fd.toString()
        });
        const j = await r.json();
        if (j.success) {
            window.location.href = 'profile.php?paid=1';
        } else {
            msg.textContent = j.error || 'Ошибка';
            btn.disabled = false;
        }
    });
    </script>
    <script src="../scripts/script.js"></script>
</body>
</html>
