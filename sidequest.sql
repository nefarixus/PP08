-- phpMyAdmin SQL Dump
-- Merged: extended schema + original data
--
-- Хост: localhost
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

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_05_04_123456_create_users_table', 1),
(3, '2024_05_04_123457_create_products_table', 1),
(4, '2024_05_04_123458_create_user_products_table', 1),
(5, '2024_05_04_123460_create_orders_table', 1),
(6, '2024_05_04_123461_create_order_items_table', 1),
(7, 'create_sessions_table', 1);

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
-- Структура таблицы `users`
-- Изменения: id → bigint UNSIGNED, добавлены email_verified_at, remember_token, created_at, updated_at
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Данные из оригинального дампа (реальные пользователи)
--

INSERT INTO `users` (`id`, `login`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(13, 'admin', 'admin@admin.com', NULL, '$2y$10$3RSHKa8WStFKzaTCdo36H.8fhBenhIWNoPVn6TWoefHp5WvmgrWe2', 'admin', NULL, NULL, NULL),
(14, 'test', 'test@test.com', NULL, '$2y$10$/5sPEUXXpfE/i/N7GOVegecBVDvxnGvtbuFl3KB9jDAf2mc3BoPPm', 'user', NULL, NULL, NULL),
(15, 'tester', 'tester@tester.com', NULL, '$2y$10$NtEvGtjBIkz2PheYPKMPeuBXaFsKyeG2a.i3IromZ9yNUaiLxbz2K', 'user', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
-- Изменения: id → bigint UNSIGNED, добавлены rating, deleted_at, created_at, updated_at
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rating` decimal(3,2) NOT NULL DEFAULT '0.00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Данные из оригинального дампа (реальные продукты) + новые колонки с дефолтными значениями
--

INSERT INTO `products` (`id`, `name`, `img`, `description`, `price`, `rating`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1,  'Jolly Match-3',          'Listing_play_for_free.jpg',                                                             'Классический match-3 в ярком VR-оформлении.',                       0.00,   0.00, NULL, NULL, NULL),
(2,  'Maestro',                'copy-of-meta_asset_cover_trailer_2560x1440_only.png',                                   'Музыкальное VR-приключение.',                                       0.00,   0.00, NULL, NULL, NULL),
(3,  'BANTER',                 'banter_new_listing_v3_copy-1-1.png',                                                    'Общение и миры в виртуальной реальности.',                          0.00,   0.00, NULL, NULL, NULL),
(4,  'Metacity patrol',        'app-lab-cover-art-landscape_new.png',                                                   'Киберпанк-песочница: районы Metacity.',                             349.00, 0.00, NULL, NULL, NULL),
(5,  'Cave Crave',             '38974446_1776802149753873_1245728995774615929_n.jpg',                                   'Исследование пещер и головоломки.',                                 199.00, 0.00, NULL, NULL, NULL),
(6,  'Oktoberfest',            'oktoberfest-rides-store-cover-square.png',                                              'Аттракционы и атмосфера Октоберфеста.',                             0.00,   0.00, NULL, NULL, NULL),
(7,  'My Monsters',            'mym_landscape_2560x1440.png',                                                           'Собери и вырасти своих монстров.',                                  0.00,   0.00, NULL, NULL, NULL),
(8,  'Grit and Valor',         '499307426_1707159933498868_8457147349349778285_n.jpg',                                  'Экшен и тактика в VR.',                                             299.00, 0.00, NULL, NULL, NULL),
(9,  'Frost Survival ВР',      '499617803_2485113945220600_1576221352827465812_n.jpg',                                  'Выживание в морозных условиях.',                                    249.00, 0.00, NULL, NULL, NULL),
(10, 'Arcaxer 2',              'sidequesta2listingimage.png',                                                           'Ролевая игра Arcaxer — вторая часть.',                              449.00, 0.00, NULL, NULL, NULL),
(12, 'Assassin\'s Creed Shadows', 'EN_EGST_StoreLandscape_2560x1440_2560x1440-35f77ef342bb2d3a3efac25f4fa4d4e0.jfif', 'Приключение во вселенной Assassin\'s Creed в VR.',                  3999.00,0.00, NULL, NULL, NULL);

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

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
-- Изменения: id и user_id → bigint UNSIGNED, status → varchar, добавлен updated_at
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Данные из оригинального дампа
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `total`, `created_at`, `updated_at`) VALUES
(11, 14, 'paid_test', 199.00, '2026-04-07 16:27:26', NULL),
(12, 13, 'pending',   199.00, '2026-04-17 05:23:03', NULL),
(13, 13, 'paid_test', 349.00, '2026-04-17 05:23:20', NULL),
(14, 13, 'paid_test', 3999.00,'2026-04-17 05:23:57', NULL),
(15, 15, 'paid_test', 349.00, '2026-04-22 11:44:29', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
-- Изменения: id, order_id, product_id → bigint UNSIGNED, добавлены created_at, updated_at
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Данные из оригинального дампа
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price_at_purchase`, `created_at`, `updated_at`) VALUES
(11, 11, 5,  199.00,  NULL, NULL),
(12, 12, 5,  199.00,  NULL, NULL),
(13, 13, 4,  349.00,  NULL, NULL),
(14, 14, 12, 3999.00, NULL, NULL),
(15, 15, 4,  349.00,  NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_products`
-- Изменения: user_id, product_id → bigint UNSIGNED, убран id и added_at,
--            добавлены created_at и updated_at, составной PRIMARY KEY
--

CREATE TABLE `user_products` (
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Данные из оригинального дампа (added_at → created_at)
--

INSERT INTO `user_products` (`user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(14, 3,  '2026-04-07 16:27:18', NULL),
(14, 5,  '2026-04-07 16:27:27', NULL),
(13, 2,  '2026-04-17 05:23:12', NULL),
(13, 4,  '2026-04-17 05:23:21', NULL),
(13, 12, '2026-04-17 05:23:57', NULL),
(15, 3,  '2026-04-22 11:44:27', NULL),
(15, 4,  '2026-04-22 11:44:30', NULL);

--
-- Индексы сохранённых таблиц
--

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_unique` (`login`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

ALTER TABLE `user_products`
  ADD PRIMARY KEY (`user_id`, `product_id`),
  ADD KEY `user_products_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT
--

ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ограничения внешнего ключа
--

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

ALTER TABLE `user_products`
  ADD CONSTRAINT `user_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
