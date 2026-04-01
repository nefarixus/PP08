-- Миграция: каталог (описание, цена) + заказы для тестовой оплаты
-- Выполни в phpMyAdmin или mysql CLI для базы `sidequest`.
-- НИЧЕГО из старых таблиц удалять не нужно — только добавляем столбцы и новые таблицы.

-- 1) Расширение каталога
ALTER TABLE `products`
  ADD COLUMN `description` TEXT NULL DEFAULT NULL AFTER `name`,
  ADD COLUMN `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `description`;

-- 2) Заказы
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `status` enum('pending','paid_test','cancelled') NOT NULL DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 3) Позиции заказа
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 4) Примеры данных (по желанию): короткие описания и цены для демо
UPDATE `products` SET `description` = 'Классический match-3 в ярком VR-оформлении.', `price` = 0.00 WHERE `id` = 1;
UPDATE `products` SET `description` = 'Музыкальное VR-приключение.', `price` = 0.00 WHERE `id` = 2;
UPDATE `products` SET `description` = 'Общение и миры в виртуальной реальности.', `price` = 0.00 WHERE `id` = 3;
UPDATE `products` SET `description` = 'Киберпанк-песочница: районы Metacity.', `price` = 349.00 WHERE `id` = 4;
UPDATE `products` SET `description` = 'Исследование пещер и головоломки.', `price` = 199.00 WHERE `id` = 5;
UPDATE `products` SET `description` = 'Аттракционы и атмосфера Октоберфеста.', `price` = 0.00 WHERE `id` = 6;
UPDATE `products` SET `description` = 'Собери и вырасти своих монстров.', `price` = 0.00 WHERE `id` = 7;
UPDATE `products` SET `description` = 'Экшен и тактика в VR.', `price` = 299.00 WHERE `id` = 8;
UPDATE `products` SET `description` = 'Выживание в морозных условиях.', `price` = 249.00 WHERE `id` = 9;
UPDATE `products` SET `description` = 'Ролевая игра Arcaxer — вторая часть.', `price` = 449.00 WHERE `id` = 10;
UPDATE `products` SET `description` = 'Приключение во вселенной Assassin\'s Creed в VR.', `price` = 3999.00 WHERE `id` = 12;
