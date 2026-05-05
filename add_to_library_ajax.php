// Deleted;$input = json_decode(file_get_contents('php://input'), true);
// Deleted;$product_id = $input['product_id'] ?? null;
// Deleted;
// Deleted;if (!is_int($product_id) || $product_id <= 0) {
// Deleted;$pdo = getPDO();
// Deleted;$stmt->execute([$product_id]);
// Deleted;$product = $stmt->fetch();
// Deleted;
// Deleted;if (!$product || (float) $product['price'] > 0) {
// Deleted;$stmt = $pdo->prepare("SELECT id FROM user_products WHERE user_id = ? AND product_id = ?");
// Deleted;$stmt->execute([$user_id, $product_id]);
// Deleted;if ($stmt->rowCount() > 0) {
// Deleted;$stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id) VALUES (?, ?)");
// Deleted;$success = $stmt->execute([$user_id, $product_id]);
// Deleted;
// Deleted;if ($success) {
