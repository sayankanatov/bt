-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 03 2018 г., 03:29
-- Версия сервера: 5.6.38
-- Версия PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `balatime`
--

-- --------------------------------------------------------

--
-- Структура таблицы `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `bik` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `banks`
--

INSERT INTO `banks` (`id`, `bik`, `title`) VALUES
(1, 'ATYNKZKA', 'Altyn Bank'),
(2, 'LARIKZKA', 'AsiaCredit Bank'),
(3, 'KINCKZKA', 'Bank RBK'),
(4, 'TBKBKZKA', 'Capital Bank Kazakhstan'),
(5, 'NFBAKZ23', 'Delta Bank'),
(6, 'IRTYKZKA', 'ForteBank'),
(7, 'CASPKZKA', 'Kaspi Bank'),
(8, 'SENIKZKA', 'Qazaq Banki'),
(9, 'TNGRKZKX', 'Tengri Bank'),
(10, 'ALMNKZKA', 'АТФБанк'),
(11, 'KSNVKZKA', 'Банк Kassa Nova'),
(12, 'ASFBKZKA', 'Банк Астаны'),
(13, 'KCJBKZKX', 'Банк ЦентрКредит'),
(14, 'ABNAKZKX', 'Банк ЭкспоКредит'),
(15, 'ALFAKZKA', 'ДБ Альфа-Банк'),
(16, 'BKCHKZKA', 'ДБ Банк Китая в Казахстане'),
(17, 'KZIBKZKA', 'ДБ КЗИ Банк'),
(18, 'NBPAKZKA', 'ДБ Национальный Банк Пакистана'),
(19, 'INLMKZKA', 'ДБ АО Банк Хоум Кредит'),
(20, 'SABRKZKA', 'ДБ АО Сбербанк России'),
(21, 'VTBAKZKZ', 'ДО АО Банк ВТБ (Казахстан)'),
(22, 'EURIKZKA', 'Евразийский Банк'),
(23, 'HCSKKZKA', 'Жилстройсбербанк Казахстана'),
(24, 'ZAJSKZ22', 'Заман-Банк'),
(25, 'HLALKZKZ', 'Исламский Банк Al-Hilal'),
(26, 'KAZSKZKA', 'Казинвестбанк'),
(27, 'KZKOKZKX', 'Казкоммерцбанк'),
(28, 'HSBKKZKX', 'Народный сберегательный банк Казахстана'),
(29, 'NURSKZKX', 'Нурбанк'),
(30, 'CITIKZKA', 'Ситибанк Казахстан'),
(31, 'ICBKKZKX', 'ТП Банк Китая в Алматы'),
(32, 'TSESKZKA', 'Цеснабанк'),
(33, 'SHBKKZKA', 'Шинхан Банк Казахстан'),
(34, 'EXKAKZKA', 'Эксимбанк Казахстан');

-- --------------------------------------------------------

--
-- Структура таблицы `childrens`
--

CREATE TABLE `childrens` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `iin` int(100) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `code` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `description`, `code`) VALUES
(1, 'Абай', 1),
(2, ' Акколь ', 2),
(3, 'Аксай ', 3),
(4, 'Аксу', 4),
(5, 'Актау ', 5),
(6, 'Актюбинск', 6),
(7, 'Алга ', 7),
(8, 'Алматы', 8),
(9, 'Аральск ', 9),
(10, 'Аркалык', 10),
(11, 'Астана', 11),
(12, 'Асу-Булак ', 12),
(13, 'Атбасар ', 13),
(14, 'Атырау', 14),
(15, 'Аягоз', 15),
(16, 'Байконур', 16),
(17, 'Балхаш', 17),
(18, 'Булаево', 18),
(19, 'Державинск ', 19),
(20, 'Ерейментау', 20),
(21, 'Есик ', 21),
(22, 'Есиль', 22),
(23, 'Жанаозен', 23),
(24, 'Жанатас ', 24),
(25, 'Жаркент', 25),
(26, 'Жезказган', 26),
(27, ' Жем ', 26),
(28, 'Жетысай', 28),
(29, 'Житикара ', 29),
(30, 'Зайсан', 30),
(32, 'Казалинск', 32),
(33, 'Зыряновск ', 31),
(34, 'Кандыагаш', 33),
(35, 'Капчагай', 34),
(36, 'Караганда', 35),
(37, 'Каражал ', 36),
(38, 'Каратау', 37),
(39, 'Каркаралинск', 38),
(40, 'Каскелен', 39),
(41, 'Кентау ', 40),
(42, 'Кокшетау', 41),
(43, 'Костанай', 42),
(44, 'Кульсары', 43),
(45, 'Курчатов', 44),
(46, 'Кызылорда ', 45),
(47, 'Ленгер ', 46),
(48, 'Лисаковск', 47),
(49, 'Макинск ', 48),
(50, 'Мамлютка ', 49),
(51, 'Павлодар', 50),
(52, 'Петропавловск', 51),
(53, 'Приозерск ', 52),
(54, 'Риддер ', 53),
(55, 'Рудный', 54),
(56, 'Сарканд ', 55),
(57, 'Сары-Агаш ', 56),
(58, 'Сатпаев  ', 57),
(59, 'Семипалатинск', 58),
(60, 'Сергеевка', 59),
(61, 'Серебрянск ', 60),
(62, 'Степногорск ', 61),
(63, 'Степняк', 62),
(64, 'Тайынша', 63),
(65, 'Талгар ', 64),
(66, 'Талдыкорган', 65),
(67, 'Тараз ', 66),
(68, 'Текели', 67),
(69, 'Темир', 68),
(70, 'Темиртау ', 69),
(71, 'Туркестан ', 70),
(72, 'Уральск ', 71),
(73, 'Усть-Каменогорск ', 72),
(74, 'Ушарал ', 73),
(75, 'Уштобе ', 74),
(76, 'Форт-Шевченко ', 75),
(77, ' Хромтау ', 76),
(78, 'Достык', 77),
(81, 'Шымкент', 78),
(101, 'Кордай', 79),
(102, 'Отеген Батыра', 80),
(106, 'Экибастуз', 2134);

-- --------------------------------------------------------

--
-- Структура таблицы `city_users`
--

CREATE TABLE `city_users` (
  `id` int(11) NOT NULL,
  `city_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `city_users`
--

INSERT INTO `city_users` (`id`, `city_id`, `user_id`) VALUES
(1, 11, 2),
(2, 8, 49);

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `name`, `telephone`, `email`, `role_name`) VALUES
(1, 'Тест Тест Тестович', '+3333333333', NULL, 'Командир'),
(2, 'Ivanov', '+1839929832984289784438', NULL, NULL),
(3, 'Petrov', '+9329249289129', NULL, NULL),
(4, 'Sidorova', '+3288928929829', NULL, 'Бух'),
(5, 'Petechkin', '11111111', NULL, 'Клад'),
(6, 'Test Vospitatel TEST', '3333333', NULL, NULL),
(7, 'Second Mentor', '777777777', NULL, NULL),
(8, 'Third Mentor 1111', '+9999999999', NULL, NULL),
(9, 'Тестовая', '+82383873283831', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `child_count` int(11) DEFAULT NULL,
  `first_mentor_id` int(11) DEFAULT NULL,
  `second_mentor_id` int(11) DEFAULT NULL,
  `kindergarten_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `category`, `title`, `child_count`, `first_mentor_id`, `second_mentor_id`, `kindergarten_id`) VALUES
(1, 'Первая младшая', 'Болашак', 10, 7, 8, 4),
(2, 'Вторая младшая', 'Балапан', 15, 8, 9, 4),
(7, 'Первая младшая', 'Кошакан', 20, 6, 8, 4),
(8, 'Первая младшая', 'Ласточка', 10, 6, 6, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `group_categories`
--

CREATE TABLE `group_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `group_categories`
--

INSERT INTO `group_categories` (`id`, `name`) VALUES
(1, 'Первая младшая'),
(2, 'Вторая младшая'),
(3, 'Средняя'),
(4, 'Старшая'),
(5, 'Предшкольная');

-- --------------------------------------------------------

--
-- Структура таблицы `kaz_regions`
--

CREATE TABLE `kaz_regions` (
  `id` int(11) NOT NULL,
  `name_ru` varchar(255) NOT NULL,
  `name_kz` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kaz_regions`
--

INSERT INTO `kaz_regions` (`id`, `name_ru`, `name_kz`) VALUES
(1, 'Северо-Казахстанская', 'Северо-Казахстанская'),
(2, 'Южно-Казахстанская', 'Южно-Казахстанская'),
(3, 'Акмолинская', 'Акмолинская'),
(4, 'Актюбинская', 'Актюбинская'),
(5, 'Алматинская', 'Алматинская'),
(6, 'Атырауская', 'Атырауская'),
(7, 'Восточно-Казахстанская', 'Восточно-Казахстанская'),
(8, 'Жамбылская', 'Жамбылская'),
(9, 'Западно-Казахстанская', 'Западно-Казахстанская'),
(10, 'Карагандинская', 'Карагандинская'),
(11, 'Костанайская', 'Костанайская'),
(12, 'Кзылординская', 'Кзылординская'),
(13, 'Мангистауская', 'Мангистауская'),
(14, 'Павлодарская', 'Павлодарская');

-- --------------------------------------------------------

--
-- Структура таблицы `kindergartens`
--

CREATE TABLE `kindergartens` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(10) NOT NULL DEFAULT 'ГККП',
  `num` int(11) NOT NULL COMMENT 'Порядковый номер сада',
  `type` varchar(255) DEFAULT NULL,
  `iik` varchar(255) DEFAULT NULL,
  `bik` varchar(255) DEFAULT NULL,
  `bin` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `telephone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `lang` varchar(100) DEFAULT NULL,
  `group_count` int(11) DEFAULT NULL,
  `worktime_start` time DEFAULT NULL,
  `worktime_end` time DEFAULT NULL,
  `child_reception` time DEFAULT NULL,
  `project_capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kindergartens`
--

INSERT INTO `kindergartens` (`id`, `name`, `category`, `num`, `type`, `iik`, `bik`, `bin`, `bank`, `region`, `city`, `address`, `telephone`, `email`, `lang`, `group_count`, `worktime_start`, `worktime_end`, `child_reception`, `project_capacity`) VALUES
(1, 'Karligash13', 'ГККП', 1, '', '', '', '', '', '', '', '', '', '', '', 0, '00:00:00', '00:00:00', '00:00:00', 0),
(2, 'Balapan', 'ГККП', 2, '', '', '', '', '', '', '', '', '', '', '', 0, '00:00:00', '00:00:00', '00:00:00', 0),
(3, 'Terem', 'ГККП', 5, 'Ясли-сад', '3289282381998239213', '', '23218932189983298123', 'Altyn Bank', 'Алматинская', 'Алматы', 'TETST', '5378532783785', 'manager4@mail.com', 'Казахский', 20, '08:00:00', '18:00:00', '08:00:00', 0),
(4, 'Papin Remen\'', 'ГККП', 6, 'Ясли-сад', '123456', NULL, '12345699876', 'АТФБанк', 'Алматинская', 'Алматы', 'TES54455', '658997437327', 'manager5@mail.com', 'Русский', 4, '08:00:00', '19:00:00', '09:00:00', 240),
(5, 'Ogonek', 'ГККП', 5, 'Ясли-сад', '48393298392', NULL, '2383289342983249', 'Altyn Bank', 'Алматинская', 'Алматы', 'Test', '803898211921', 'manager6@mail.com', 'Смешанный', 4, '08:00:00', '18:00:00', '10:00:00', 240),
(6, 'Lolli Pop', 'ГККП', 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Test1111', 'ГККП', 444, 'Детский сад', '28912982189128912', NULL, '328932918213992183', 'Altyn Bank', 'Северо-Казахстанская', 'Алматы', 'TETST', NULL, 'test@mail.com', 'Русский', 15, '07:00:00', '07:00:00', '07:00:00', 240),
(8, 'Bolashak', 'ГККП', 123, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `kindergarten_cities`
--

CREATE TABLE `kindergarten_cities` (
  `id` int(11) NOT NULL,
  `kindergarten_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kindergarten_cities`
--

INSERT INTO `kindergarten_cities` (`id`, `kindergarten_id`, `city_id`) VALUES
(1, 1, 8),
(2, 2, 8),
(3, 3, 8),
(4, 4, 8),
(5, 5, 8),
(6, 6, 8),
(7, 7, 8),
(8, 8, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `kindergarten_clients`
--

CREATE TABLE `kindergarten_clients` (
  `id` int(11) NOT NULL,
  `kindergarten_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kindergarten_clients`
--

INSERT INTO `kindergarten_clients` (`id`, `kindergarten_id`, `client_id`) VALUES
(1, 4, 1),
(2, 4, 2),
(3, 4, 3),
(4, 4, 4),
(5, 4, 5),
(6, 4, 6),
(7, 4, 7),
(8, 4, 8),
(9, 4, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `kindergarten_langs`
--

CREATE TABLE `kindergarten_langs` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kindergarten_langs`
--

INSERT INTO `kindergarten_langs` (`id`, `code`, `title`) VALUES
(1, 'ru', 'Русский'),
(2, 'kz', 'Казахский'),
(3, 'kz-ru', 'Смешанный');

-- --------------------------------------------------------

--
-- Структура таблицы `kindergarten_types`
--

CREATE TABLE `kindergarten_types` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kindergarten_types`
--

INSERT INTO `kindergarten_types` (`id`, `title`) VALUES
(1, 'Ясли-сад'),
(2, 'Детский сад');

-- --------------------------------------------------------

--
-- Структура таблицы `kindergarten_users`
--

CREATE TABLE `kindergarten_users` (
  `id` int(11) NOT NULL,
  `kindergarten_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kindergarten_users`
--

INSERT INTO `kindergarten_users` (`id`, `kindergarten_id`, `user_id`) VALUES
(1, 1, 50),
(2, 2, 51),
(3, 3, 52),
(4, 4, 53),
(5, 5, 54),
(6, 6, 55),
(7, 7, 56),
(8, 8, 57);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_05_10_130540_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `permission_roles`
--

CREATE TABLE `permission_roles` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `permission_users`
--

CREATE TABLE `permission_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, '2018-04-25 22:01:58', '2018-04-25 22:01:58'),
(2, 'Координатор', NULL, '2018-05-05 09:01:55', '2018-05-18 04:58:57'),
(3, 'Менеджер', NULL, '2018-05-05 09:02:12', '2018-05-18 04:59:05'),
(4, 'Заведующий', 'Управление всеми процессами', '2018-05-25 05:12:13', '2018-05-25 05:12:13'),
(5, 'Методист', 'База данных - участник', '2018-05-25 05:12:22', '2018-05-25 05:12:22'),
(6, 'Медицинская сестра', 'Модуль - календарь прививок', '2018-05-25 05:12:34', '2018-05-25 05:12:34'),
(7, 'Бухгалтер', 'База - поставщики, База - склад', '2018-05-25 05:12:41', '2018-05-25 05:12:41'),
(8, 'Кладовщик', 'Выдача продуктов со склада', '2018-05-25 05:12:49', '2018-05-25 05:12:49'),
(9, 'Воспитатель', 'Работа в группах', '2018-05-25 05:12:58', '2018-05-25 05:12:58');

-- --------------------------------------------------------

--
-- Структура таблицы `role_clients`
--

CREATE TABLE `role_clients` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role_clients`
--

INSERT INTO `role_clients` (`id`, `role_id`, `client_id`) VALUES
(1, 4, 1),
(2, 5, 2),
(3, 6, 3),
(4, 7, 4),
(5, 8, 5),
(6, 9, 6),
(7, 9, 7),
(8, 9, 8),
(9, 9, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `role_users`
--

CREATE TABLE `role_users` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `role_users`
--

INSERT INTO `role_users` (`role_id`, `user_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(2, 2),
(2, 49),
(3, 50),
(3, 51),
(3, 52),
(3, 53),
(3, 54),
(3, 55),
(3, 56),
(3, 57);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `number`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', '$2y$10$ADML/rShPfPbcUcblG.p3OGrDQA3OIvHqLDQUhc/tDxGpQX00bGqC', '', 'XF5FsonfTCQjkwcArQM0IJvtWFJV97JvUH4FEZj0KJMjocwenDIgDGlY3z9u', '2018-04-25 08:02:35', '2018-05-18 04:59:39'),
(2, 'Sayan', 'sayan@mail.com', '$2y$10$C4NcTyy0I5H4ts2XjSsJSOmdQkQPvDHohPSEQv1hhS6Q0mBM5203C', '', '7SqLsvZwia6xoLwc56WwVJRVGHjTavL4yN9nM7j3HcUn8Nd3pp1sHigx5eDQ', '2018-04-25 22:27:22', '2018-05-20 22:25:56'),
(49, 'Координатор', 'koor@mail.com', '$2y$10$s0sL4clcLQWa1iDyPpFU4ewn8SSj3hg2k79H/Zpwm7fbq6hmEZefi', NULL, 'cl5ygtSA6afMaXSUSivzt35SKL4qo0Y0ReD32eCp812hyF2F7nCOAPSLto2U', '2018-05-24 02:25:48', '2018-05-24 02:25:48'),
(50, 'Алматы687', 'manager@mail.com', '$2y$10$DmpHomsar1TJEUrNlYJbm.zIL2hLmYj/GCqqih04vURXJr8tGMyEO', '87757255445', 'rnF3cmOcvumiZeIWNYhgxn2F5pDuyQTBuTajYWxN3GgQMR1QPQ1KD3HC80kc', '2018-05-24 02:27:42', '2018-05-24 02:27:42'),
(51, 'Алматы543', 'manager2@mail.com', '$2y$10$42m4ekW4ma0twdOT/u1i6.pkO3egtW9d9T69FlpNo.CBqBkYHR0te', '87757255444', NULL, '2018-05-24 04:38:51', '2018-05-24 04:38:51'),
(52, 'Алматы541', 'manager4@mail.com', '$2y$10$fogt6kJmXjwiwhca46.sx.jjksjb9JjZIT148njtyDyhuUTh7FLoe', '5378532783785', 'cLW1VG7wxxnAtqTdK8DOTo0W3HSsBJnwiUH6HFFEAv1Z0buUQVYacwkI8qIW', '2018-05-24 23:11:35', '2018-05-24 23:11:35'),
(53, 'Алматы685', 'manager5@mail.com', '$2y$10$MvzPQ46x0uDFoh3ggm98C.q7NSjBBCIhSOwoIESuF24B6RTpycljW', '658997437327', 'TpUuQKtWM267sGqV2U6nKp5p0j0c9HB0tp1Nqxe0kSi8l3vTSVg9uzR4gieN', '2018-05-25 00:04:57', '2018-05-25 00:04:57'),
(54, 'Алматы65', 'manager6@mail.com', '$2y$10$MRQI6.33mH2m98AbMfTVB.avHxXaXZd8DfgoZCKThnHxMirgPYnyi', '803898211921', 'RzmE2sNf9U3MkkcxXK24HRZtQluhtj6RASeqGcBZcqXffvabsPHedZCUfoiw', '2018-05-28 02:40:57', '2018-05-28 02:40:57'),
(55, 'Алматы738', 'manager7@mail.com', '$2y$10$UU.TIOQB8n6hgVBbUTG4zOzEkuL9wEN3ay8W6tooo.1j.ayX4bNMy', NULL, NULL, '2018-05-28 06:26:00', '2018-05-28 06:26:00'),
(56, 'Алматы856', 'test@mail.com', '$2y$10$M/IdPNZMWC1BMTYhDssCDOCnUCH7GExQrwM3NUTAZT87iSWUP2a4e', NULL, 'bg3jvd1I55EASzxv4vmx8fLHL7giD8jnVRMc7V0DhKhUbyxqvNMeiexsysAw', '2018-05-29 02:26:52', '2018-05-29 02:26:52'),
(57, 'Алматы460', 'bolashak@mail.com', '$2y$10$SNUB0FXvlHaQgLqhJscwXOGbvl1HIb3wKLht.TrSlLsKQOtfcIiKu', NULL, NULL, '2018-06-01 01:23:21', '2018-06-01 01:23:21');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `childrens`
--
ALTER TABLE `childrens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `city_users`
--
ALTER TABLE `city_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_users_ibfk_1` (`city_id`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `telephone` (`telephone`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `group_categories`
--
ALTER TABLE `group_categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kaz_regions`
--
ALTER TABLE `kaz_regions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kindergartens`
--
ALTER TABLE `kindergartens`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kindergarten_cities`
--
ALTER TABLE `kindergarten_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kindergarten_id` (`kindergarten_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Индексы таблицы `kindergarten_clients`
--
ALTER TABLE `kindergarten_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `kindergarten_id` (`kindergarten_id`);

--
-- Индексы таблицы `kindergarten_langs`
--
ALTER TABLE `kindergarten_langs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kindergarten_types`
--
ALTER TABLE `kindergarten_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `kindergarten_users`
--
ALTER TABLE `kindergarten_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Индексы таблицы `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_roles_role_id_foreign` (`role_id`);

--
-- Индексы таблицы `permission_users`
--
ALTER TABLE `permission_users`
  ADD PRIMARY KEY (`user_id`,`permission_id`),
  ADD KEY `permission_users_permission_id_foreign` (`permission_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Индексы таблицы `role_clients`
--
ALTER TABLE `role_clients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `role_users_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `childrens`
--
ALTER TABLE `childrens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT для таблицы `city_users`
--
ALTER TABLE `city_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `group_categories`
--
ALTER TABLE `group_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `kaz_regions`
--
ALTER TABLE `kaz_regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `kindergartens`
--
ALTER TABLE `kindergartens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `kindergarten_cities`
--
ALTER TABLE `kindergarten_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `kindergarten_clients`
--
ALTER TABLE `kindergarten_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `kindergarten_langs`
--
ALTER TABLE `kindergarten_langs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `kindergarten_types`
--
ALTER TABLE `kindergarten_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `kindergarten_users`
--
ALTER TABLE `kindergarten_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `role_clients`
--
ALTER TABLE `role_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `childrens`
--
ALTER TABLE `childrens`
  ADD CONSTRAINT `childrens_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Ограничения внешнего ключа таблицы `city_users`
--
ALTER TABLE `city_users`
  ADD CONSTRAINT `city_users_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `kindergarten_cities`
--
ALTER TABLE `kindergarten_cities`
  ADD CONSTRAINT `kindergarten_cities_ibfk_1` FOREIGN KEY (`kindergarten_id`) REFERENCES `kindergartens` (`id`),
  ADD CONSTRAINT `kindergarten_cities_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Ограничения внешнего ключа таблицы `kindergarten_clients`
--
ALTER TABLE `kindergarten_clients`
  ADD CONSTRAINT `kindergarten_clients_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `kindergarten_clients_ibfk_2` FOREIGN KEY (`kindergarten_id`) REFERENCES `kindergartens` (`id`);

--
-- Ограничения внешнего ключа таблицы `permission_roles`
--
ALTER TABLE `permission_roles`
  ADD CONSTRAINT `permission_roles_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `permission_users`
--
ALTER TABLE `permission_users`
  ADD CONSTRAINT `permission_users_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `role_users`
--
ALTER TABLE `role_users`
  ADD CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
