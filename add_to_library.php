// Deleted;if (!$product_id) {
// Deleted;$product = $stmt->fetch();
// Deleted;
// Deleted;if (!$product || (float) $product['price'] > 0) {
// Deleted;$stmt->execute([$user_id, $product_id]);
// Deleted;if ($stmt->rowCount() > 0) {
// Deleted;$stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id) VALUES (?, ?)");
// Deleted;$success = $stmt->execute([$user_id, $product_id]);
// Deleted;
// Deleted;if ($success) {
