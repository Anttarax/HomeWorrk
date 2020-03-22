-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2020. Már 21. 20:56
-- Kiszolgáló verziója: 10.4.6-MariaDB
-- PHP verzió: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `project1`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `alkatresz`
--

CREATE TABLE `alkatresz` (
  `alkatresz_id` int(11) NOT NULL,
  `nev` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `ar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `alkatresz`
--

INSERT INTO `alkatresz` (`alkatresz_id`, `nev`, `ar`) VALUES
(1, 'Lökhárító', 20000),
(2, 'Ülés', 50000);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `alkat_rendel`
--

CREATE TABLE `alkat_rendel` (
  `rendel_id` int(11) NOT NULL,
  `alkatresz_id` int(11) NOT NULL,
  `db` int(11) NOT NULL,
  `lap_id` int(11) NOT NULL,
  `beszall_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `alkat_rendel`
--

INSERT INTO `alkat_rendel` (`rendel_id`, `alkatresz_id`, `db`, `lap_id`, `beszall_id`) VALUES
(1, 2, 4, 1, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `beszallitok`
--

CREATE TABLE `beszallitok` (
  `beszall_id` int(11) NOT NULL,
  `arres` double NOT NULL,
  `nev` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `beszallitok`
--

INSERT INTO `beszallitok` (`beszall_id`, `arres`, `nev`) VALUES
(1, 1.1, 'Autó Kft.'),
(2, 3, 'Szuper Kft');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `folyamat_rendel`
--

CREATE TABLE `folyamat_rendel` (
  `folyamat_rendel_id` int(11) NOT NULL,
  `folyamat_id` int(11) NOT NULL,
  `lap_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `folyamat_rendel`
--

INSERT INTO `folyamat_rendel` (`folyamat_rendel_id`, `folyamat_id`, `lap_id`) VALUES
(1, 2, 1),
(2, 1, 1),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `munka`
--

CREATE TABLE `munka` (
  `munka_id` int(11) NOT NULL,
  `szerelo_id` int(11) NOT NULL,
  `lap_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `munka`
--

INSERT INTO `munka` (`munka_id`, `szerelo_id`, `lap_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `munkafolyamatok`
--

CREATE TABLE `munkafolyamatok` (
  `folyamat_id` int(11) NOT NULL,
  `ar` int(11) NOT NULL,
  `nev` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `munkafolyamatok`
--

INSERT INTO `munkafolyamatok` (`folyamat_id`, `ar`, `nev`) VALUES
(1, 5000, 'olajcsere'),
(2, 10000, 'motor javítás');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `munkalap`
--

CREATE TABLE `munkalap` (
  `lap_id` int(11) NOT NULL,
  `marka` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `típus` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `km` int(11) NOT NULL,
  `leiras` text COLLATE utf8_hungarian_ci NOT NULL,
  `kezdet` datetime NOT NULL,
  `veg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `munkalap`
--

INSERT INTO `munkalap` (`lap_id`, `marka`, `típus`, `km`, `leiras`, `kezdet`, `veg`) VALUES
(1, 'Audi', 'SUV', 10000, 'Elromlott a motor', '2020-03-21 12:00:00', '2020-03-21 13:00:00'),
(2, 'asd', 'asd', 10, 'asd', '2020-03-21 17:15:32', '2020-03-21 17:15:32');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szerelo`
--

CREATE TABLE `szerelo` (
  `szerelo_id` int(11) NOT NULL,
  `nev` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `szerelo`
--

INSERT INTO `szerelo` (`szerelo_id`, `nev`) VALUES
(1, 'Tóth János'),
(2, 'Fazekas István');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Antarax', 'vancsura.pisti@gmail.com', NULL, '$2y$10$OW94FRgEOjKUBLI7wrFjYOgKHv.Gzvvus6ZI2bm0xVu/U7Lc4xtFa', NULL, '2020-03-20 09:51:17', '2020-03-20 09:51:17');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `alkatresz`
--
ALTER TABLE `alkatresz`
  ADD PRIMARY KEY (`alkatresz_id`);

--
-- A tábla indexei `alkat_rendel`
--
ALTER TABLE `alkat_rendel`
  ADD PRIMARY KEY (`rendel_id`);

--
-- A tábla indexei `beszallitok`
--
ALTER TABLE `beszallitok`
  ADD PRIMARY KEY (`beszall_id`);

--
-- A tábla indexei `folyamat_rendel`
--
ALTER TABLE `folyamat_rendel`
  ADD PRIMARY KEY (`folyamat_rendel_id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `munka`
--
ALTER TABLE `munka`
  ADD PRIMARY KEY (`munka_id`);

--
-- A tábla indexei `munkafolyamatok`
--
ALTER TABLE `munkafolyamatok`
  ADD PRIMARY KEY (`folyamat_id`);

--
-- A tábla indexei `munkalap`
--
ALTER TABLE `munkalap`
  ADD PRIMARY KEY (`lap_id`);

--
-- A tábla indexei `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- A tábla indexei `szerelo`
--
ALTER TABLE `szerelo`
  ADD PRIMARY KEY (`szerelo_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `alkatresz`
--
ALTER TABLE `alkatresz`
  MODIFY `alkatresz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `alkat_rendel`
--
ALTER TABLE `alkat_rendel`
  MODIFY `rendel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `beszallitok`
--
ALTER TABLE `beszallitok`
  MODIFY `beszall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `munka`
--
ALTER TABLE `munka`
  MODIFY `munka_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `munkafolyamatok`
--
ALTER TABLE `munkafolyamatok`
  MODIFY `folyamat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `munkalap`
--
ALTER TABLE `munkalap`
  MODIFY `lap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT a táblához `szerelo`
--
ALTER TABLE `szerelo`
  MODIFY `szerelo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
