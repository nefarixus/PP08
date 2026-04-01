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
    $price_raw = str_replace(',', '.', (string) ($_POST['price'] ?? '0'));
    $price = is_numeric($price_raw) ? round((float) $price_raw, 2) : null;

    $img = '';
    if (!empty($_FILES['img_file']) && is_array($_FILES['img_file'])) {
        $f = $_FILES['img_file'];
        if (($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $tmp = (string) $f['tmp_name'];
            $orig = (string) ($f['name'] ?? '');
            $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (!in_array($ext, $allowed, true)) {
                $err = 'Неверный формат изображения. Разрешено: jpg, jpeg, png, webp, gif.';
            } else {
                $safe = preg_replace('/[^a-z0-9._-]+/i', '_', pathinfo($orig, PATHINFO_FILENAME));
                $safe = trim((string) $safe, '._-');
                if ($safe === '') {
                    $safe = 'cover';
                }
                $filename = $safe . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '.' . $ext;
                $destDir = __DIR__ . '/../images';
                if (!is_dir($destDir)) {
                    @mkdir($destDir, 0777, true);
                }
                $dest = $destDir . '/' . $filename;
                if (!move_uploaded_file($tmp, $dest)) {
                    $err = 'Не удалось сохранить файл. Проверь права на папку images/.';
                } else {
                    $img = $filename;
                }
            }
        } elseif (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            $err = 'Ошибка загрузки файла (код ' . (int) $f['error'] . ').';
        }
    }

    if ($name === '' || $img === '') {
        if ($err === '') {
            $err = 'Укажите название и выберите файл обложки.';
        }
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
    <link rel="icon" href="../images/logo.svg" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Каталог — админ</title>
    <style>
        .adm-wrap {
            max-width: 980px;
            margin: 44px auto 60px;
            padding: 24px 8px 32px;
            color: #fff;
        }
        .adm-wrap h1 {
            font-size: 26px;
            margin-bottom: 4px;
        }
        .adm-subtitle {
            color: #9ca3af;
            font-size: 13px;
            margin-bottom: 22px;
        }
        .adm-form {
            background: rgba(20, 20, 20, 0.72);
            padding: 22px 26px 26px;
            border-radius: 18px;
            margin-bottom: 32px;
            border: 1px solid rgba(55, 65, 81, 0.9);
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.9);
        }
        .adm-form h2 {
            margin-top: 0;
            margin-bottom: 14px;
            padding: 0;
            font-size: 18px;
            font-family: var(--font-ui);
            font-weight: 700;
            letter-spacing: 0.01em;
        }
        .adm-form label {
            display: block;
            margin-top: 14px;
            color: #9ca3af;
            font-size: 13px;
        }
        .adm-form input,
        .adm-form textarea {
            width: 100%;
            margin-top: 4px;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(0, 0, 0, 0.28);
            color: #e5e7eb;
            font-family: inherit;
            font-size: 14px;
        }
        .adm-form textarea {
            min-height: 110px;
            resize: vertical;
        }
        .adm-form input:focus,
        .adm-form textarea:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.22);
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.12);
        }
        .adm-form button {
            margin-top: 22px;
            padding: 12px 26px;
            border-radius: 999px;
            border: none;
            background: #2a2a2a;
            color: #fff;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
        }
        .adm-form button:hover {
            box-shadow: 0 20px 55px rgba(0, 0, 0, 0.55);
            transform: translateY(-1px);
        }
        .adm-ok {
            color: #4ade80;
            margin-bottom: 10px;
            font-size: 13px;
        }
        .adm-err {
            color: #f87171;
            margin-bottom: 10px;
            font-size: 13px;
        }
        table.adm-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-top: 10px;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.10);
            background: rgba(20, 20, 20, 0.72);
        }
        table.adm-table thead {
            background: rgba(0, 0, 0, 0.22);
        }
        table.adm-table th,
        table.adm-table td {
            padding: 10px 12px;
            text-align: left;
        }
        table.adm-table th {
            color: #9ca3af;
            font-weight: 500;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        table.adm-table tbody tr {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        table.adm-table tbody tr:nth-child(odd) {
            background: rgba(0, 0, 0, 0.12);
        }
        table.adm-table tbody tr:nth-child(even) {
            background: rgba(0, 0, 0, 0.20);
        }
        table.adm-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
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
                <p class="adm-subtitle">Добавление товаров в таблицу <code>products</code>. Картинку заранее положи в <code>images/</code> и укажи только имя файла.</p>
                <?php if ($msg): ?><p class="adm-ok"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
                <?php if ($err): ?><p class="adm-err"><?= htmlspecialchars($err) ?></p><?php endif; ?>

                <form method="post" class="adm-form" enctype="multipart/form-data">
                    <h2>Новый товар</h2>
                    <label for="name">Название</label>
                    <input type="text" id="name" name="name" required maxlength="255">

                    <label for="description">Описание</label>
                    <textarea id="description" name="description" placeholder="Необязательно"></textarea>

                    <label for="price">Цена (₽), 0 = бесплатно</label>
                    <input type="text" id="price" name="price" value="0" inputmode="decimal">

                    <label for="img_file">Обложка (изображение)</label>
                    <input type="file" id="img_file" name="img_file" accept="image/*" required>

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
                
            </main>
        </div>
    </div>
    <script src="../scripts/script.js"></script>
</body>
</html>
