// Deleted;session_start();
// Deleted;
// Deleted;if (!isset($_SESSION['user_id'])) {
// Deleted;    header('Location: pages/login.php');
// Deleted;    exit;
// Deleted;}
// Deleted;
// Deleted;$order_id = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);
// Deleted;if (!$order_id) {
// Deleted;    header('Location: index.php');
// Deleted;    exit;
// Deleted;}
// Deleted;
// Deleted;require_once __DIR__ . '/includes/db.php';
// Deleted;$pdo = getPDO();
// Deleted;
// Deleted;// Проверяем, принадлежит ли заказ пользователю и оплачен ли он
// Deleted;$stmt = $pdo->prepare('
// Deleted;    SELECT o.id, p.name
// Deleted;    FROM orders o
// Deleted;    JOIN order_items oi ON o.id = oi.order_id
// Deleted;    JOIN products p ON oi.product_id = p.id
// Deleted;    WHERE o.id = ? AND o.user_id = ? AND o.status = ?
// Deleted;');
// Deleted;$stmt->execute([$order_id, $_SESSION['user_id'], 'paid_test']);
// Deleted;$order = $stmt->fetch(PDO::FETCH_ASSOC);
// Deleted;
// Deleted;if (!$order) {
// Deleted;    header('Location: index.php');
// Deleted;    exit;
// Deleted;}
// Deleted;
// Deleted;// Добавляем товар в библиотеку (на случай, если что-то пошло не так ранее)
// Deleted;$stmt = $pdo->prepare('
// Deleted;    INSERT IGNORE INTO user_products (user_id, product_id)
// Deleted;    SELECT o.user_id, oi.product_id
// Deleted;    FROM orders o
// Deleted;    JOIN order_items oi ON o.id = oi.order_id
// Deleted;    WHERE o.id = ?
// Deleted;');
// Deleted;$stmt->execute([$order_id]);
// Deleted;
// Deleted;$product_name = htmlspecialchars($order['name']);
// Deleted;?>
