<?php

declare(strict_types=1);

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';

if (!isAdminSession()) {
    http_response_code(403);
    die('Доступ только для администратора (логин admin).');
}

$pdo = getPDO();
$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $description = trim((string) ($_POST['description'] ?? ''));
    $img = trim((string) ($_POST['img'] ?? ''));
    $price_raw = str_replace(',', '.', (string) ($_POST['price'] ?? '0'));
    $price = is_numeric($price_raw) ? round((float) $price_raw, 2) : null;

    $img = basename($img);

    if ($name === '' || $img === '') {
        $err = 'Укажите название и имя файла картинки (файл положите в папку images/).';
    } elseif ($price === null || $price < 0) {
        $err = 'Укажите корректную цену (0 — бесплатно).';
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO products (name, img, description, price) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([
            $name,
            $img,
            $description !== '' ? $description : null,
            $price,
        ]);
        $msg = 'Товар добавлен (id ' . $pdo->lastInsertId() . ').';
    }
}

$products = $pdo->query('SELECT id, name, price, img FROM products ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Каталог — админ</title>
    <style>
        .adm-wrap { max-width: 900px; margin: 40px auto; padding: 24px; color: #fff; }
        .adm-form { background: #1d1d1d; padding: 24px; border-radius: 16px; margin-bottom: 32px; }
        .adm-form label { display: block; margin-top: 12px; color: #aaa; font-size: 14px; }
        .adm-form input, .adm-form textarea {
            width: 100%; margin-top: 4px; padding: 10px 12px; border-radius: 8px;
            border: 1px solid #444; background: #121212; color: #fff; font-family: inherit;
        }
        .adm-form textarea { min-height: 100px; resize: vertical; }
        .adm-form button {
            margin-top: 20px; padding: 12px 24px; border-radius: 999px; border: none;
            background: #7c3aed; color: #fff; cursor: pointer; font-size: 15px;
        }
        .adm-ok { color: #4ade80; margin-bottom: 12px; }
        .adm-err { color: #f87171; margin-bottom: 12px; }
        table.adm-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        table.adm-table th, table.adm-table td { padding: 10px; text-align: left; border-bottom: 1px solid #333; }
        table.adm-table th { color: #888; }
    </style>
</head>
<body>
    <div class="mobile-warning">
        <p>Сайт разработан для просмотра на компьютере.</p>
    </div>
    <?php include __DIR__ . '/../aside.php'; ?>
    <div class="page-wrapper">
        <div class="container">
            <main class="adm-wrap">
                <h1>Управление каталогом</h1>
                <p style="color:#888;margin-bottom:20px;">Добавление товаров в таблицу <code>products</code>. Картинку заранее положи в <code>images/</code> и укажи только имя файла.</p>
                <?php if ($msg): ?><p class="adm-ok"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
                <?php if ($err): ?><p class="adm-err"><?= htmlspecialchars($err) ?></p><?php endif; ?>

                <form method="post" class="adm-form">
                    <h2>Новый товар</h2>
                    <label for="name">Название</label>
                    <input type="text" id="name" name="name" required maxlength="255">

                    <label for="description">Описание</label>
                    <textarea id="description" name="description" placeholder="Необязательно"></textarea>

                    <label for="price">Цена (₽), 0 = бесплатно</label>
                    <input type="text" id="price" name="price" value="0" inputmode="decimal">

                    <label for="img">Имя файла обложки (в папке images)</label>
                    <input type="text" id="img" name="img" required placeholder="например Listing_play_for_free.jpg">

                    <button type="submit">Добавить в каталог</button>
                </form>

                <h2>Текущие позиции</h2>
                <table class="adm-table">
                    <thead>
                        <tr><th>ID</th><th>Название</th><th>Цена</th><th>Файл img</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?= (int) $p['id'] ?></td>
                                <td><?= htmlspecialchars($p['name']) ?></td>
                                <td><?= (float) $p['price'] > 0 ? number_format((float) $p['price'], 2, ',', ' ') . ' ₽' : '0' ?></td>
                                <td><?= htmlspecialchars($p['img']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p style="margin-top:24px;"><a href="profile.php" style="color:#a78bfa;">← Профиль</a></p>
            </main>
        </div>
    </div>
    <script src="../scripts/script.js"></script>
</body>
</html>
