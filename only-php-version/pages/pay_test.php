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
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Оплата</title>
    <style>
        .pay-wrap { max-width: 480px; margin: 48px auto; padding: 24px; color: #fff; }
        .pay-card { background: #1d1d1d; border-radius: 16px; padding: 24px; text-align: center; }
        .pay-card img { max-width: 100%; border-radius: 12px; margin-bottom: 16px; }
        .pay-card h2 { padding: 0; margin: 8px 0 10px; font-size: 20px; font-weight: 700; letter-spacing: 0.01em; }
        .pay-total { font-size: 24px; color: #4ade80; margin: 16px 0; }
        .pay-fields {
            background: rgba(0,0,0,0.18);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 14px;
            padding: 16px;
            margin: 18px 0 18px;
            text-align: left;
        }
        .pay-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px; }
        .pay-fields label { display:block; font-size: 12px; color:#9ca3af; margin-top: 10px; }
        .pay-fields input {
            width: 100%;
            margin-top: 4px;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(0,0,0,0.25);
            color: #e5e7eb;
            font-family: inherit;
        }
        .pay-fields input:focus { outline: none; border-color: rgba(255,255,255,0.22); box-shadow: 0 0 0 1px rgba(255,255,255,0.12); }
        .pay-btn {
            padding: 14px 32px;
            background: #2a2a2a;
            color: #fff;
            border: none;
            border-radius: 999px;
            font-size: 16px;
            cursor: pointer;
            font-family: inherit;
            width: 100%;
            box-shadow: 0 16px 40px rgba(0,0,0,0.45);
        }
        .pay-btn:hover { transform: translateY(-1px); box-shadow: 0 20px 55px rgba(0,0,0,0.55); }
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
                <h1>Оплата</h1>
                <div class="pay-card">
                    <img src="../images/<?= htmlspecialchars($row['img']) ?>" alt="">
                    <h2><?= htmlspecialchars($row['name']) ?></h2>
                    <p class="pay-total"><?= number_format((float) $row['total'], 2, ',', ' ') ?> ₽</p>
                    <div class="pay-fields" aria-label="payment-form">
                        <label>Номер карты</label>
                        <input type="text" inputmode="numeric" autocomplete="cc-number" placeholder="0000 0000 0000 0000">
                        <div class="pay-row">
                            <div>
                                <label>Срок</label>
                                <input type="text" inputmode="numeric" autocomplete="cc-exp" placeholder="MM/YY">
                            </div>
                            <div>
                                <label>CVC</label>
                                <input type="password" inputmode="numeric" autocomplete="cc-csc" placeholder="***">
                            </div>
                        </div>
                        <label>Имя держателя</label>
                        <input type="text" autocomplete="cc-name" placeholder="IVAN IVANOV">
                    </div>
                    <button type="button" class="pay-btn" id="payTestBtn">Оплатить</button>
                    <p id="payMsg" style="margin-top:12px;color:#f87171;"></p>
                </div>
                <p style="margin-top:20px;"><a href="../index.php" style="color:#a78bfa;">На главную</a></p>
            </main>
            <?php $asset_prefix = '..'; include __DIR__ . '/../includes/footer.php'; ?>
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
