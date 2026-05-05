// Deleted;session_start();
// Deleted;
// Deleted;if (!isset($_SESSION['user_id'])) {
// Deleted;    http_response_code(401);
// Deleted;    exit('Unauthorized');
// Deleted;}
// Deleted;
// Deleted;$user_id = (int) $_SESSION['user_id'];
// Deleted;$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
// Deleted;
// Deleted;if (!$product_id) {
// Deleted;    header('Location: pages/checkout.php?product_id=' . ($product_id ?? ''));
// Deleted;    exit;
// Deleted;}
// Deleted;
// Deleted;require_once __DIR__ . '/includes/db.php';
// Deleted;$pdo = getPDO();
// Deleted;
// Deleted;// Проверяем, не куплен ли товар уже
// Deleted;$stmt = $pdo->prepare('SELECT id FROM user_products WHERE user_id = ? AND product_id = ?');
// Deleted;$stmt->execute([$user_id, $product_id]);
// Deleted;$in_library = (bool) $stmt->fetch();
// Deleted;
// Deleted;if ($in_library) {
// Deleted;    header("Location: pages/product.php?id=$product_id");
// Deleted;    exit;
// Deleted;}
// Deleted;
// Deleted;// Получаем цену товара
// Deleted;$stmt = $pdo->prepare('SELECT price FROM products WHERE id = ? AND price > 0');
// Deleted;$stmt->execute([$product_id]);
// Deleted;$product = $stmt->fetch();
// Deleted;
// Deleted;if (!$product) {
// Deleted;    header('Location: index.php');
// Deleted;    exit;
// Deleted;}
// Deleted;
// Deleted;$price = (float) $product['price'];
// Deleted;
// Deleted;// Начинаем транзакцию
// Deleted;$pdo->beginTransaction();
// Deleted;try {
// Deleted;    // 1. Создаем заказ
// Deleted;    $stmt = $pdo->prepare('INSERT INTO orders (user_id, total, status) VALUES (?, ?, ?)');
// Deleted;    $stmt->execute([$user_id, $price, 'pending']);
// Deleted;    $order_id = $pdo->lastInsertId();
// Deleted;
// Deleted;    // 2. Добавляем позицию заказа
// Deleted;    $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, price_at_purchase) VALUES (?, ?, ?)');
// Deleted;    $stmt->execute([$order_id, $product_id, $price]);
// Deleted;
// Deleted;    // 3. Помечаем заказ как оплаченный (тестовая оплата)
// Deleted;    $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
// Deleted;    $stmt->execute(['paid_test', $order_id]);
// Deleted;
// Deleted;    // 4. Добавляем товар в библиотеку пользователя
// Deleted;    $stmt = $pdo->prepare('INSERT IGNORE INTO user_products (user_id, product_id) VALUES (?, ?)');
// Deleted;    $stmt->execute([$user_id, $product_id]);
// Deleted;
// Deleted;    $pdo->commit();
// Deleted;
// Deleted;    // Перенаправляем на страницу завершения
// Deleted;    header("Location: complete_test_payment.php?order_id=$order_id");
// Deleted;    exit;
// Deleted;} catch (Exception $e) {
// Deleted;    $pdo->rollBack();
// Deleted;    error_log("Order creation failed: " . $e->getMessage());
// Deleted;    http_response_code(500);
// Deleted;    exit('Internal Server Error');
// Deleted;}
