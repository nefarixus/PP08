-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 04 2026 г., 16:19
-- Версия сервера: 8.0.30
-- Версия PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `sidequest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_05_04_123456_create_users_table', 1),
(2, '2024_05_04_123457_create_products_table', 1),
(3, '2024_05_04_123458_create_user_products_table', 1),
(4, '2024_05_04_123459_create_personal_access_tokens_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(6, 'create_sessions_table', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `status` enum('pending','paid_test','cancelled') NOT NULL DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `total`, `created_at`) VALUES
(11, 14, 'paid_test', 199.00, '2026-04-07 16:27:26'),
(12, 13, 'pending', 199.00, '2026-04-17 05:23:03'),
(13, 13, 'paid_test', 349.00, '2026-04-17 05:23:20'),
(14, 13, 'paid_test', 3999.00, '2026-04-17 05:23:57'),
(15, 15, 'paid_test', 349.00, '2026-04-22 11:44:29');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price_at_purchase`) VALUES
(11, 11, 5, 199.00),
(12, 12, 5, 199.00),
(13, 13, 4, 349.00),
(14, 14, 12, 3999.00),
(15, 15, 4, 349.00);

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `img` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `img`) VALUES
(1, 'Jolly Match-3', 'Классический match-3 в ярком VR-оформлении.', 0.00, 'Listing_play_for_free.jpg'),
(2, 'Maestro', 'Музыкальное VR-приключение.', 0.00, 'copy-of-meta_asset_cover_trailer_2560x1440_only.png'),
(3, 'BANTER', 'Общение и миры в виртуальной реальности.', 0.00, 'banter_new_listing_v3_copy-1-1.png'),
(4, 'Metacity patrol', 'Киберпанк-песочница: районы Metacity.', 349.00, 'app-lab-cover-art-landscape_new.png'),
(5, 'Cave Crave', 'Исследование пещер и головоломки.', 199.00, '38974446_1776802149753873_1245728995774615929_n.jpg'),
(6, 'Oktoberfest', 'Аттракционы и атмосфера Октоберфеста.', 0.00, 'oktoberfest-rides-store-cover-square.png'),
(7, 'My Monsters', 'Собери и вырасти своих монстров.', 0.00, 'mym_landscape_2560x1440.png'),
(8, 'Grit and Valor', 'Экшен и тактика в VR.', 299.00, '499307426_1707159933498868_8457147349349778285_n.jpg'),
(9, 'Frost Survival ВР', 'Выживание в морозных условиях.', 249.00, '499617803_2485113945220600_1576221352827465812_n.jpg'),
(10, 'Arcaxer 2', 'Ролевая игра Arcaxer — вторая часть.', 449.00, 'sidequesta2listingimage.png'),
(12, 'Assassin\'s Creed Shadows', 'Приключение во вселенной Assassin\'s Creed в VR.', 3999.00, 'EN_EGST_StoreLandscape_2560x1440_2560x1440-35f77ef342bb2d3a3efac25f4fa4d4e0.jfif');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Q3xa7y2tUIZMCgKxO19ydsOP1KKktm0JUO9P7Edf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 YaBrowser/26.3.0.0 Safari/537.36', 'ZXlKcGRpSTZJak5xYW1OUVJEaFNibE5NWkhsbFRIcHVMMjVLYkhjOVBTSXNJblpoYkhWbElqb2lZV0UwYlZVclZWSldUMWRtUkdzMVFtOXhVamcwVkhRelF6QjRNMlJQZGxWT1UwRnRVMVZpVkhwNFZFSldTVWR4TXpORVRGUnFUMFpOVkRkMU5YWXJTRWMwUnl0emRXc3hZbEF4UkU4eFYwZ3JkV3A2TkZGU1JERnVOMEl2TDNaUGFWazNZMVZzU2xwS1F6VnBaVE55UmxwV1VHMHlTMmgxVlRkS1QxQlVMMGxZV0hobU5sZERjVEUyYW1oVU1tczBVSFpoWjBWQ1JGRmpRbEZWU2xWM1dXVlVTVEpOVHpseE4waGxWMGxqZWxBNVJIWnJRV1ZsUW5STU5EZElNM0ZRYkhWT1FqZE9hbXBGV1ZOV1IwVTJWR1pHY2t3NVRsbHZTVlZIVm05TFlqWkRRVVp5TDJRNFdrcHBUMUpvVWpkSVQyZEpkVlY0UldaT05ETldVakZHVXlJc0ltMWhZeUk2SWpNNE9HTmpNall5TlRNeU9HSXlNalZtWkdJellqRmlORFEzTXpVM01EaGlPVFJoT1dNd056WXdOVGcxWXpnM1l6bGpOR00wTWpabFlXTTVOekl3TldVaUxDSjBZV2NpT2lJaWZRPT0=', 1777900456);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `role`) VALUES
(13, 'admin', '$2y$10$3RSHKa8WStFKzaTCdo36H.8fhBenhIWNoPVn6TWoefHp5WvmgrWe2', 'admin@admin.com', 'admin'),
(14, 'test', '$2y$10$/5sPEUXXpfE/i/N7GOVegecBVDvxnGvtbuFl3KB9jDAf2mc3BoPPm', 'test@test.com', 'user'),
(15, 'tester', '$2y$10$NtEvGtjBIkz2PheYPKMPeuBXaFsKyeG2a.i3IromZ9yNUaiLxbz2K', 'tester@tester.com', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `user_products`
--

CREATE TABLE `user_products` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_products`
--

INSERT INTO `user_products` (`id`, `user_id`, `product_id`, `added_at`) VALUES
(52, 14, 3, '2026-04-07 16:27:18'),
(53, 14, 5, '2026-04-07 16:27:27'),
(54, 13, 2, '2026-04-17 05:23:12'),
(55, 13, 4, '2026-04-17 05:23:21'),
(56, 13, 12, '2026-04-17 05:23:57'),
(57, 15, 3, '2026-04-22 11:44:27'),
(58, 15, 4, '2026-04-22 11:44:30');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_products`
--
ALTER TABLE `user_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `user_products`
--
ALTER TABLE `user_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_products`
--
ALTER TABLE `user_products`
  ADD CONSTRAINT `user_products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
