-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 05 2026 г., 17:48
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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_05_04_123456_create_users_table', 1),
(3, '2024_05_04_123457_create_products_table', 1),
(4, '2024_05_04_123458_create_user_products_table', 1),
(5, '2024_05_04_123460_create_orders_table', 1),
(6, '2024_05_04_123461_create_order_items_table', 1),
(7, 'create_sessions_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rating` decimal(3,2) NOT NULL DEFAULT '0.00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `img`, `description`, `price`, `rating`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Ut consequatur tenetur.', 'https://via.placeholder.com/640x480.png/00cc77?text=games+aliquam', 'Cumque dolores sunt odio sunt similique velit voluptatem. Earum necessitatibus distinctio voluptatem earum. Nihil dicta est eveniet saepe tempore. Mollitia vitae inventore earum.', 0.00, 0.49, NULL, NULL, NULL),
(2, 'Tempora dolores voluptas aperiam.', 'https://via.placeholder.com/640x480.png/008899?text=games+eligendi', 'Nemo eaque adipisci quam accusantium mollitia ipsam aut. Error rerum repellat sit aut hic vitae.', 449.00, 0.01, NULL, NULL, NULL),
(3, 'Aliquid ut dolorem.', 'https://via.placeholder.com/640x480.png/0099bb?text=games+recusandae', 'Est amet ipsa tenetur ullam fugiat sit. Iusto quis tempore itaque assumenda explicabo. Architecto autem pariatur perspiciatis voluptates ut esse. Tenetur magnam cumque autem sit quisquam facilis ut.', 299.00, 0.25, NULL, NULL, NULL),
(4, 'Est veniam non qui et.', 'https://via.placeholder.com/640x480.png/0000dd?text=games+ipsum', 'Aut sit nesciunt culpa repellendus voluptates perferendis consequatur praesentium. Itaque quod maxime sequi omnis velit. Qui consequuntur nulla itaque impedit corporis. Cum aut dolores nobis qui harum aut. Ipsum et molestiae nisi consequuntur.', 349.00, 4.59, NULL, NULL, NULL),
(5, 'Necessitatibus eveniet laudantium sunt velit.', 'https://via.placeholder.com/640x480.png/008844?text=games+at', 'In optio veritatis ipsum esse. Totam voluptatum molestiae dolore magni. Non veniam quaerat quaerat eos est placeat. Aut ipsa placeat enim ipsam ex.', 449.00, 3.27, NULL, NULL, NULL),
(6, 'Praesentium ut.', 'https://via.placeholder.com/640x480.png/00dd99?text=games+velit', 'Voluptates et rerum pariatur sunt et accusantium. Qui vitae quia sit dolor qui velit. Aut aperiam dicta ut deserunt hic et esse. Quibusdam doloremque dolorum nam eos.', 299.00, 2.24, NULL, NULL, NULL),
(7, 'Nesciunt recusandae doloribus commodi distinctio.', 'https://via.placeholder.com/640x480.png/00ff00?text=games+neque', 'Omnis commodi consequatur excepturi quas eos et aliquam ipsam. Aut quo repudiandae placeat aliquid.', 299.00, 0.12, NULL, NULL, NULL),
(8, 'Est quo autem dolore.', 'https://via.placeholder.com/640x480.png/0044cc?text=games+non', 'Qui et quia dolorem explicabo praesentium qui quod. Cupiditate et recusandae sapiente nesciunt quae tempore voluptas. Fuga error aliquam iste ut delectus est et dolore. Voluptas natus perspiciatis nihil voluptatem molestiae facere.', 0.00, 1.80, NULL, NULL, NULL),
(9, 'Commodi enim officia.', 'https://via.placeholder.com/640x480.png/00aa00?text=games+dolores', 'Et nihil nesciunt repellendus facilis totam quidem. Iusto blanditiis at accusamus debitis. Ut sint rerum et labore explicabo est. Sint expedita amet velit nesciunt. Sint nisi aut quod sed ea officia cupiditate et.', 449.00, 4.27, NULL, NULL, NULL),
(10, 'Magnam provident sapiente sed.', 'https://via.placeholder.com/640x480.png/001144?text=games+unde', 'A vero a harum et modi. Ab officia qui consequuntur et. Deserunt quis ut officiis maxime laborum. Ab non quo maxime dicta.', 349.00, 2.60, NULL, NULL, NULL),
(11, 'Quis ab recusandae fugit.', 'https://via.placeholder.com/640x480.png/005599?text=games+aperiam', 'Temporibus vitae consequatur nobis id sed. Suscipit et rerum ratione voluptatem veniam quo. Quia est facere facere dolores velit doloribus. Quidem quae voluptatum facilis deserunt doloremque repudiandae occaecati.', 449.00, 1.64, NULL, NULL, NULL),
(12, 'Optio saepe suscipit id.', 'https://via.placeholder.com/640x480.png/00cc77?text=games+ipsum', 'Vel id dolorem est dolor alias. Itaque mollitia dolorem sit. Possimus dolor ut architecto facere. Eos magnam velit reprehenderit laborum iure provident asperiores sed. Reprehenderit delectus asperiores necessitatibus illum autem.', 199.00, 4.64, NULL, NULL, NULL),
(13, 'Voluptatem autem deleniti.', 'https://via.placeholder.com/640x480.png/003333?text=games+fuga', 'Placeat nihil est hic quaerat. Quas aut illum distinctio soluta molestiae suscipit dolor veniam.', 0.00, 2.19, NULL, NULL, NULL),
(14, 'Qui dolor eligendi numquam.', 'https://via.placeholder.com/640x480.png/00ee66?text=games+sint', 'Dolorem harum enim et omnis non voluptas inventore. Enim reprehenderit aut deleniti sit beatae natus reiciendis. Omnis inventore minima nam laboriosam nesciunt. Sapiente vel cupiditate velit dicta doloribus dolor.', 249.00, 4.69, NULL, NULL, NULL),
(15, 'Quidem corrupti provident aliquid.', 'https://via.placeholder.com/640x480.png/0066aa?text=games+ipsum', 'Voluptatibus nisi aut exercitationem dicta eius modi aspernatur. Aut nesciunt debitis ea nesciunt ullam eos. Occaecati natus placeat fuga quos.', 3999.00, 4.98, NULL, NULL, NULL),
(16, 'Dolores consequatur ut blanditiis dolore.', 'https://via.placeholder.com/640x480.png/0077ee?text=games+corrupti', 'Sed voluptatem culpa ut illum ea. Impedit minima qui modi saepe qui sit. Dolor quaerat exercitationem voluptatem nobis neque eaque est nihil.', 3999.00, 1.61, NULL, NULL, NULL),
(17, 'Eos excepturi impedit qui est.', 'https://via.placeholder.com/640x480.png/00bb44?text=games+quo', 'Qui eos beatae consectetur nihil. Ducimus sapiente sit non nihil cum amet. Eaque tenetur consequuntur et rerum.', 199.00, 4.43, NULL, NULL, NULL),
(18, 'Non reprehenderit dolore qui.', 'https://via.placeholder.com/640x480.png/00bb22?text=games+odit', 'Labore illo pariatur fugit minus facere. Repellendus quae consectetur natus voluptates quo vel asperiores rerum. Temporibus non velit nostrum quod quod. Deserunt voluptatem maxime doloribus sit ut eveniet iure.', 349.00, 4.48, NULL, NULL, NULL),
(19, 'Deleniti ullam ipsam dolores.', 'https://via.placeholder.com/640x480.png/0066ff?text=games+et', 'Fuga nisi quisquam sapiente corporis. Consequuntur quasi nobis veritatis laborum architecto. Officia amet non culpa et et. Dignissimos possimus ut nemo.', 199.00, 3.93, NULL, NULL, NULL),
(20, 'Mollitia soluta adipisci quo.', 'https://via.placeholder.com/640x480.png/00ffaa?text=games+consequatur', 'Qui excepturi tempore cumque cupiditate qui maxime labore. Nihil voluptatibus veritatis occaecati voluptatibus.', 199.00, 3.33, NULL, NULL, NULL),
(21, 'Et iure nemo nihil.', 'https://via.placeholder.com/640x480.png/00ff55?text=games+aspernatur', 'Voluptatibus quia nobis facilis sit. Nesciunt at animi et in distinctio aspernatur nesciunt accusantium. Aut magnam exercitationem eveniet.', 349.00, 0.03, NULL, NULL, NULL),
(22, 'Ut quis.', 'https://via.placeholder.com/640x480.png/009977?text=games+optio', 'Molestiae ducimus expedita ab fugiat autem. Ipsum et maxime omnis perferendis debitis dolorem incidunt. Nisi sint amet dolores. Vero rerum natus occaecati.', 349.00, 3.29, NULL, NULL, NULL),
(23, 'Rem sed inventore.', 'https://via.placeholder.com/640x480.png/0011cc?text=games+animi', 'Quo amet qui id omnis. Totam aliquam aut qui laboriosam aut. Quaerat nesciunt corporis recusandae porro mollitia aut saepe.', 249.00, 4.60, NULL, NULL, NULL),
(24, 'Est soluta enim harum.', 'https://via.placeholder.com/640x480.png/0088ff?text=games+aut', 'Velit ut reprehenderit rerum ipsa totam. Consequatur pariatur non culpa nostrum dolores ea. Aut et placeat aliquam temporibus perferendis delectus. Et quia earum veniam ut autem. Vel totam sapiente ratione vero nostrum.', 449.00, 1.95, NULL, NULL, NULL),
(25, 'Corrupti illum a dolorum.', 'https://via.placeholder.com/640x480.png/0066ee?text=games+et', 'Rem earum corrupti laboriosam delectus id veniam facilis. At quam maiores nihil eligendi ab possimus. Omnis harum maxime non assumenda sequi ullam ut quis. Nemo mollitia voluptatem mollitia molestias.', 349.00, 0.62, NULL, NULL, NULL),
(26, 'Minus deserunt ut.', 'https://via.placeholder.com/640x480.png/008844?text=games+corrupti', 'Et praesentium cupiditate enim ipsum blanditiis sunt. Et corrupti quis non facere ipsa enim. Voluptate qui laboriosam perferendis quidem.', 199.00, 3.62, NULL, NULL, NULL),
(27, 'Labore nihil illum cum.', 'https://via.placeholder.com/640x480.png/003333?text=games+cum', 'Amet delectus deleniti exercitationem velit est et consectetur. Quaerat accusamus sed porro nisi ipsam nisi sunt. Vel voluptates animi harum neque repellendus voluptatem ut.', 0.00, 4.29, NULL, NULL, NULL),
(28, 'Esse occaecati facilis.', 'https://via.placeholder.com/640x480.png/00ee44?text=games+molestiae', 'Et eos necessitatibus explicabo officiis rerum aut deleniti deserunt. Dolore ullam dolorem suscipit aut dignissimos aut. Ut aliquam perferendis quam voluptatem. Ipsam ipsam nam quisquam quia vel corporis. Blanditiis eveniet quia aut ex.', 349.00, 3.71, NULL, NULL, NULL),
(29, 'Excepturi vel et corrupti.', 'https://via.placeholder.com/640x480.png/007755?text=games+qui', 'Reprehenderit minima non consectetur possimus incidunt. Minima sunt saepe minus est. Debitis sint eos ea. Sunt ab ut est quo. Et aut debitis incidunt et sed.', 449.00, 1.86, NULL, NULL, NULL),
(30, 'Non vitae blanditiis reiciendis.', 'https://via.placeholder.com/640x480.png/008888?text=games+neque', 'Sunt in ducimus alias omnis. Sunt minima natus voluptas voluptatibus. In distinctio voluptate a sed provident at nihil et.', 349.00, 4.89, NULL, NULL, NULL),
(31, 'Dolorem quibusdam et.', 'https://via.placeholder.com/640x480.png/00cc66?text=games+praesentium', 'Cum accusantium itaque quia ipsum quaerat eum. Voluptatum ut hic voluptates porro vitae eaque perferendis. Dolores quo vel eius aut iure. Et id eveniet voluptatem est.', 349.00, 1.22, NULL, NULL, NULL),
(32, 'Culpa in dolor.', 'https://via.placeholder.com/640x480.png/000022?text=games+eaque', 'Qui dolores aut est voluptas et reiciendis. Eveniet et totam molestiae placeat voluptas iste quasi. Fuga eos vel delectus quae quia necessitatibus. Qui dolorem repellat quod occaecati.', 449.00, 4.91, NULL, NULL, NULL),
(33, 'Consequuntur quos eum.', 'https://via.placeholder.com/640x480.png/00cc44?text=games+pariatur', 'Placeat cum et hic nesciunt. Doloremque itaque tempora suscipit. Autem dolor at voluptas rem sed non.', 249.00, 4.82, NULL, NULL, NULL),
(34, 'Vero est numquam.', 'https://via.placeholder.com/640x480.png/00dd33?text=games+sunt', 'Omnis error consequatur asperiores dolores dolor eum. Sed quaerat eos fugit qui quas est rerum labore. Ut explicabo laudantium repellat.', 449.00, 3.83, NULL, NULL, NULL),
(35, 'Provident autem debitis.', 'https://via.placeholder.com/640x480.png/007711?text=games+sapiente', 'Omnis est voluptates laudantium esse. Unde et maxime expedita. Et tempore temporibus autem beatae ipsa vero quia.', 199.00, 1.96, NULL, NULL, NULL),
(36, 'Excepturi non et hic.', 'https://via.placeholder.com/640x480.png/004499?text=games+mollitia', 'Reprehenderit quo maiores non et odio pariatur non. Quia qui sapiente ratione reprehenderit. Perspiciatis alias et consequatur expedita ut et quia. Quo accusamus temporibus minima.', 299.00, 2.52, NULL, NULL, NULL),
(37, 'Ipsam autem soluta.', 'https://via.placeholder.com/640x480.png/0000dd?text=games+id', 'In veritatis animi asperiores enim non. Veniam dolores iusto voluptatem quas velit. Quis facere pariatur et accusamus aliquid.', 299.00, 0.90, NULL, NULL, NULL),
(38, 'Ducimus quasi.', 'https://via.placeholder.com/640x480.png/00aa99?text=games+amet', 'Consequatur eius dignissimos aperiam magni sit. Voluptas earum officiis excepturi est et dolorum qui. Enim culpa velit atque delectus eius ipsum dolores. Consectetur dolor odit excepturi.', 299.00, 1.12, NULL, NULL, NULL),
(39, 'Ratione tempore enim.', 'https://via.placeholder.com/640x480.png/003300?text=games+occaecati', 'Iure consequatur qui delectus eos deleniti. Dicta numquam totam quaerat qui.', 199.00, 4.48, NULL, NULL, NULL),
(40, 'Nemo commodi totam.', 'https://via.placeholder.com/640x480.png/0066ff?text=games+animi', 'Culpa consequatur ut sunt voluptatum rerum labore ipsa. Consequatur aliquam delectus ea delectus voluptate saepe cum. Dolor nihil incidunt voluptatem voluptatem autem sit voluptatem.', 449.00, 3.30, NULL, NULL, NULL),
(41, 'Quia voluptas.', 'https://via.placeholder.com/640x480.png/00cc66?text=games+quo', 'Dolorem qui cum aliquam eligendi et voluptates itaque. Sequi quisquam veritatis id dolorem voluptatem. Molestiae sint ea facilis eos.', 199.00, 0.05, NULL, NULL, NULL),
(42, 'Et placeat.', 'https://via.placeholder.com/640x480.png/0077aa?text=games+aspernatur', 'Et sit neque dignissimos. Qui nihil adipisci esse numquam iste nihil voluptatem. Eum ullam et molestiae nulla animi. Et suscipit sint aut quo aut dolores voluptates.', 249.00, 0.37, NULL, NULL, NULL),
(43, 'Qui commodi.', 'https://via.placeholder.com/640x480.png/0055dd?text=games+non', 'Fugit quam sit officia qui temporibus corrupti ut. Repellat quae iste eius autem a. Recusandae corrupti nostrum dolor odit id.', 199.00, 1.20, NULL, NULL, NULL),
(44, 'Reprehenderit fuga autem cum.', 'https://via.placeholder.com/640x480.png/00eeee?text=games+modi', 'Voluptatem cumque a recusandae doloribus autem placeat in reiciendis. Necessitatibus dicta mollitia temporibus excepturi fugiat est qui. Est ea distinctio sunt quisquam ut aperiam unde.', 0.00, 0.40, NULL, NULL, NULL),
(45, 'Expedita aut molestiae.', 'https://via.placeholder.com/640x480.png/00dd88?text=games+blanditiis', 'Mollitia ipsam unde totam dolorem temporibus facilis optio. Recusandae facilis consequuntur eos aut libero dolore. Atque vel rerum et culpa doloremque voluptatem quibusdam. Non earum tenetur eveniet ut ratione error rerum.', 449.00, 1.44, NULL, NULL, NULL),
(46, 'Aspernatur minus doloribus unde.', 'https://via.placeholder.com/640x480.png/00cc55?text=games+ab', 'Est quasi corrupti quia quae ea. Alias et et veniam quo excepturi. Ipsam similique nulla aut eos quam.', 0.00, 3.60, NULL, NULL, NULL),
(47, 'Voluptatum provident esse est.', 'https://via.placeholder.com/640x480.png/00ffff?text=games+repudiandae', 'Optio fugit ab eos porro eos cum eaque. Harum quod ut ut aut. Consequuntur qui dolores voluptas alias. Dicta praesentium facere et.', 299.00, 3.75, NULL, NULL, NULL),
(48, 'Exercitationem aspernatur sed.', 'https://via.placeholder.com/640x480.png/0055cc?text=games+consequatur', 'Ullam unde nostrum quidem ad in. Minima placeat aliquid vel adipisci voluptate. Ex velit at quia. Sed sit quis quidem aut. Quod harum rerum facilis quia eligendi provident sit.', 0.00, 0.55, NULL, NULL, NULL),
(49, 'Quam pariatur.', 'https://via.placeholder.com/640x480.png/00ee77?text=games+qui', 'Sunt corporis et sunt aut totam fuga. Ut in ullam dolores sapiente. Voluptatem consectetur neque vel exercitationem corrupti qui ducimus id. Ad ut laudantium sit maxime harum repudiandae ducimus est.', 449.00, 4.69, NULL, NULL, NULL),
(50, 'Aperiam minus quasi vel.', 'https://via.placeholder.com/640x480.png/003333?text=games+id', 'Temporibus et unde earum rem natus. Alias at non laborum dolore ad voluptatem vel soluta. Temporibus fugit earum exercitationem sit eos et.', 3999.00, 4.28, NULL, NULL, NULL),
(51, 'Error ut eos.', 'https://via.placeholder.com/640x480.png/00aaaa?text=games+est', 'Assumenda illo rerum ipsam ut aperiam. Ipsa temporibus molestias rerum excepturi in doloribus quia. Qui cupiditate quasi ut tempora placeat.', 3999.00, 1.09, NULL, NULL, NULL),
(52, 'Modi officiis ipsam.', 'https://via.placeholder.com/640x480.png/0066bb?text=games+officiis', 'Mollitia sunt incidunt quos dolorem quae sunt. At sit expedita et sit non.', 3999.00, 4.60, NULL, NULL, NULL),
(53, 'Quia voluptatum nam.', 'https://via.placeholder.com/640x480.png/00ff99?text=games+natus', 'Qui est distinctio sequi voluptatem repellendus. Dolor laboriosam vitae vitae est est nemo. Fuga numquam distinctio minima molestias sit ea voluptatum qui. Reprehenderit quae et cum mollitia et omnis neque tempora.', 199.00, 3.31, NULL, NULL, NULL),
(54, 'Cum sit voluptatem repellat.', 'https://via.placeholder.com/640x480.png/00ee44?text=games+consectetur', 'Iure dolores ut doloremque doloremque dicta ut laudantium velit. Et ut eveniet recusandae fugit quia sequi. Ea in temporibus ex ut et aut.', 249.00, 1.38, NULL, NULL, NULL),
(55, 'Quia minima reprehenderit ea.', 'https://via.placeholder.com/640x480.png/001155?text=games+corporis', 'Possimus deserunt iusto odit neque in incidunt. At soluta nihil quidem eveniet omnis. Eius est non est praesentium.', 449.00, 2.75, NULL, NULL, NULL),
(56, 'Maiores repudiandae est mollitia alias.', 'https://via.placeholder.com/640x480.png/006666?text=games+incidunt', 'A sed nobis odit autem consequuntur aut. Iste quis ut laudantium illum. Vel consequatur praesentium dolore culpa non.', 299.00, 0.38, NULL, NULL, NULL),
(57, 'Nihil non ut et.', 'https://via.placeholder.com/640x480.png/00ee77?text=games+suscipit', 'Velit qui praesentium ipsa recusandae sint ut. Quis omnis iure id atque. Fugit culpa distinctio quam numquam facilis.', 0.00, 2.20, NULL, NULL, NULL),
(58, 'Et doloremque saepe ratione.', 'https://via.placeholder.com/640x480.png/002211?text=games+quam', 'Nemo non similique incidunt omnis velit tenetur temporibus. Aut dolorem officia deserunt perferendis impedit eum. Eum culpa dolores molestias aspernatur. Sit beatae numquam fugiat similique earum.', 349.00, 1.53, NULL, NULL, NULL),
(59, 'Non perspiciatis maiores.', 'https://via.placeholder.com/640x480.png/003399?text=games+esse', 'Alias nihil incidunt odio cumque. Deserunt veritatis tenetur non quasi. Et minus labore voluptate ab tempore est numquam quos.', 299.00, 3.87, NULL, NULL, NULL),
(60, 'Rerum soluta at quo corrupti.', 'https://via.placeholder.com/640x480.png/0011ff?text=games+fuga', 'Nobis et vel quis dolorum id. Ut ut qui iste. Repudiandae vel beatae minima quasi numquam. Iusto quia ea consequatur et.', 199.00, 4.41, NULL, NULL, NULL);

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
-- Структура таблицы `users`
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
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'kozey.theodora', 'marina98@example.org', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Z614zB88ze', NULL, NULL),
(2, 'amina29', 'helena.tillman@example.org', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '5tc8vmbmab', NULL, NULL),
(3, 'gibson.jane', 'gerhold.jon@example.net', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'ZPV3x0vMbt', NULL, NULL),
(4, 'demond.damore', 'althea93@example.org', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'f9Jh0XHljf', NULL, NULL),
(5, 'dolson', 'maybelle.gorczany@example.net', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'OjWapAT234', NULL, NULL),
(6, 'zbrekke', 'iryan@example.org', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'A62c0gfaIh', NULL, NULL),
(7, 'colin28', 'isaac.braun@example.net', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'CkRGMitmXc', NULL, NULL),
(8, 'mcglynn.ova', 'vincenzo92@example.com', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'hmGFSmw2mk', NULL, NULL),
(9, 'hilton99', 'london48@example.org', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '57cRV7PI1a', NULL, NULL),
(10, 'eerdman', 'rickie79@example.net', '2026-05-05 10:15:34', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '1orS2ldRka', NULL, NULL),
(11, 'bailey.connor', 'jerald21@example.org', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '9WhzZxQXZh', NULL, NULL),
(12, 'bstreich', 'jovany87@example.org', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '0jiFUdU98E', NULL, NULL),
(13, 'meta27', 'drosenbaum@example.net', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'gQgDbA4X4y', NULL, NULL),
(14, 'hwhite', 'lavon81@example.org', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '56TACnQbIY', NULL, NULL),
(15, 'dickinson.stefan', 'fmonahan@example.net', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'izQQdwse7h', NULL, NULL),
(16, 'adolphus.koss', 'pacocha.percy@example.com', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'MOXDSihwaC', NULL, NULL),
(17, 'iwalsh', 'marcella.bailey@example.net', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'ESIXQl4SIs', NULL, NULL),
(18, 'schneider.lora', 'mayer.aylin@example.net', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'B62HLTvXSn', NULL, NULL),
(19, 'aurelie.grimes', 'valerie.ritchie@example.net', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'O5wlpbEP7r', NULL, NULL),
(20, 'vshields', 'gorczany.al@example.org', '2026-05-05 10:31:51', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '8AGVNta7Z7', NULL, NULL),
(21, 'jacobi.gunner', 'coby41@example.org', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'UGE8rDoCVq', NULL, NULL),
(22, 'trantow.pedro', 'umaggio@example.org', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'FxYIvVn38m', NULL, NULL),
(23, 'wwalter', 'kenton29@example.org', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'if4Ko42iaY', NULL, NULL),
(24, 'bertha26', 'rey63@example.com', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Ck6aTeAAXj', NULL, NULL),
(25, 'okeefe.bernhard', 'sdickinson@example.net', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'nNg2Q9WbAf', NULL, NULL),
(26, 'vbode', 'zbalistreri@example.org', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '7kLpTkPCoA', NULL, NULL),
(27, 'stracke.kimberly', 'christiansen.gardner@example.com', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '174fEWiS42', NULL, NULL),
(28, 'iklein', 'skiles.kiarra@example.org', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'xWb1fNHGu0', NULL, NULL),
(29, 'carlie.von', 'hahn.clement@example.net', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'GUfiDnYawV', NULL, NULL),
(30, 'justus52', 'wisozk.andres@example.net', '2026-05-05 11:24:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'IoR7naghPn', NULL, NULL),
(31, 'admin', 'admin@admin.com', NULL, '$2y$12$nzpiHaJunpmJs/lRQykiaOviXI5/.LhQmjeu6IW6aHfbfCE89py5O', 'user', 'Ve5LHLyZ1egSPeRcbwzpntDY5W0WwWKmhsgErLtCPZxSJZgsWxUTl9gSkfVd', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_products`
--

CREATE TABLE `user_products` (
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_products`
--

INSERT INTO `user_products` (`user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL),
(1, 3, NULL, NULL),
(1, 7, NULL, NULL),
(1, 11, NULL, NULL),
(1, 14, NULL, NULL),
(1, 16, NULL, NULL),
(1, 18, NULL, NULL),
(1, 19, NULL, NULL),
(2, 3, NULL, NULL),
(2, 4, NULL, NULL),
(2, 7, NULL, NULL),
(2, 9, NULL, NULL),
(2, 12, NULL, NULL),
(2, 13, NULL, NULL),
(2, 14, NULL, NULL),
(2, 18, NULL, NULL),
(2, 27, NULL, NULL),
(2, 33, NULL, NULL),
(3, 1, NULL, NULL),
(3, 5, NULL, NULL),
(3, 6, NULL, NULL),
(3, 7, NULL, NULL),
(3, 9, NULL, NULL),
(3, 11, NULL, NULL),
(3, 12, NULL, NULL),
(3, 13, NULL, NULL),
(3, 14, NULL, NULL),
(3, 15, NULL, NULL),
(3, 19, NULL, NULL),
(3, 20, NULL, NULL),
(3, 26, NULL, NULL),
(3, 33, NULL, NULL),
(3, 38, NULL, NULL),
(4, 3, NULL, NULL),
(4, 4, NULL, NULL),
(4, 5, NULL, NULL),
(4, 10, NULL, NULL),
(4, 15, NULL, NULL),
(4, 16, NULL, NULL),
(4, 17, NULL, NULL),
(5, 1, NULL, NULL),
(5, 3, NULL, NULL),
(5, 8, NULL, NULL),
(5, 10, NULL, NULL),
(5, 15, NULL, NULL),
(5, 19, NULL, NULL),
(6, 3, NULL, NULL),
(6, 14, NULL, NULL),
(7, 15, NULL, NULL),
(9, 2, NULL, NULL),
(9, 3, NULL, NULL),
(9, 5, NULL, NULL),
(9, 9, NULL, NULL),
(9, 13, NULL, NULL),
(9, 14, NULL, NULL),
(9, 16, NULL, NULL),
(9, 17, NULL, NULL),
(9, 18, NULL, NULL),
(10, 9, NULL, NULL);

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
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_unique` (`login`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_products`
--
ALTER TABLE `user_products`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `user_products_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_products`
--
ALTER TABLE `user_products`
  ADD CONSTRAINT `user_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
