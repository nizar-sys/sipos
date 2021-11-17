-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Nov 2021 pada 12.59
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sipos`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(34, 'default', 'Menghapus beberapa data produk', NULL, NULL, NULL, 'App\\Models\\User', 10, '[]', NULL, '2021-10-28 20:30:40', '2021-10-28 20:30:40'),
(35, 'default', 'Menghapus beberapa data produk', NULL, NULL, NULL, 'App\\Models\\User', 10, '[]', NULL, '2021-10-31 19:25:06', '2021-10-31 19:25:06'),
(36, 'default', 'Menghapus beberapa data produk', NULL, NULL, NULL, 'App\\Models\\User', 10, '[]', NULL, '2021-11-03 20:09:41', '2021-11-03 20:09:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_10_20_053554_create_activity_log_table', 2),
(6, '2021_10_20_053555_add_event_column_to_activity_log_table', 2),
(7, '2021_10_20_053556_add_batch_uuid_column_to_activity_log_table', 2),
(10, '2021_10_23_130343_create_tb_products_table', 3),
(11, '2021_11_04_025124_create_tb_carts_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('nizarid04@gmail.com', '$2y$10$h4z2CqoAtTlR6VG4MUNpo.d2zp.cco6kpQkislaoZuWLUzClaKJTG', '2021-10-19 20:53:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_carts`
--

CREATE TABLE `tb_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` bigint(20) NOT NULL,
  `status` enum('oncart','ordered') COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_carts`
--

INSERT INTO `tb_carts` (`id`, `user_id`, `product_id`, `qty`, `status`, `subtotal`, `created_at`, `updated_at`) VALUES
(19, 11, 8, 1, 'oncart', 16000, '2021-11-05 01:35:13', '2021-11-05 01:35:13'),
(21, 11, 5, 100, 'oncart', 600000000, '2021-11-05 01:35:16', '2021-11-05 01:35:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_products`
--

CREATE TABLE `tb_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_produk` bigint(20) NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_produk` bigint(20) NOT NULL,
  `diskon_produk` int(11) NOT NULL,
  `stok_produk` bigint(20) NOT NULL,
  `gambar_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_products`
--

INSERT INTO `tb_products` (`id`, `kode_produk`, `nama_produk`, `slug_produk`, `kategori_produk`, `harga_produk`, `diskon_produk`, `stok_produk`, `gambar_produk`, `created_at`, `updated_at`) VALUES
(4, 7759594830, 'Hp Xiaomi Redmi 8', 'hp-xiaomi-redmi-8', 'Handphone', 2000000, 12, 230, 'Produk -1635995681.jpg', '2021-11-03 20:10:39', '2021-11-03 20:14:41'),
(5, 895839202, 'Razer Phone', 'razer-phone', 'Handphone', 6000000, 0, 300, 'Produk -1635995704.jpg', '2021-11-03 20:10:39', '2021-11-03 20:15:04'),
(6, 7233474018, 'Piring Zaman Majapahit', 'piring-zaman-majapahit', 'Barang Dapur', 400000, 2, 10000, 'Produk -1635995727.jpg', '2021-11-03 20:10:39', '2021-11-03 20:15:27'),
(7, 573934849, 'Monitor Lcd', 'monitor-lcd', 'Elektronik', 300000, 10, 200, 'Produk -1635995560.jpg', '2021-11-03 20:10:40', '2021-11-03 20:12:40'),
(8, 7843784391, 'Mouse Pad', 'mouse-pad', 'Aksesoris', 20000, 20, 500, 'Produk -1635995618.jpg', '2021-11-03 20:10:40', '2021-11-03 20:13:38'),
(9, 889498588, 'Sim Card Sakti', 'sim-card-sakti', 'Elektronik', 50000, 0, 100, 'Produk -1635995662.jpg', '2021-11-03 20:10:40', '2021-11-03 20:14:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `slug`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `avatar`, `created_at`, `updated_at`) VALUES
(10, 'admin', 'admin', '1', 'nizarid04@gmail.com', '2021-11-02 02:58:55', '$2y$10$fguSN5TVlIY2nYfZ46Q3DusAD0q42nhQ98uaAP4DvPkUeBGK48Ji2', 'VEYHVYShFHF6Aczjhn0SRV8FdmVAFcGKszYsREMrXH2rRYsHsWU64c5zsNtt', '1634709659.png', '2021-10-17 22:37:13', '2021-11-02 02:58:55'),
(11, 'users', 'users', '0', 'users@gmail.com', NULL, '$2y$10$tOJtFvsFxgfQIoGgofticOdIvlGXdQorEpQ8.7Dqn2P4CS8RxkLlK', 'U1HrxmJV42cTGjiRNYZyxXmf0gk6qX17eOLChYus0ISqCuhPru2dRzjVpvYw', 'avatar.png', '2021-10-17 22:37:13', '2021-10-17 22:37:13'),
(36, 'pengguna1', 'pengguna1', '0', 'p1@gmail', NULL, '$2y$10$yv0dtwzGhMod2SrAgkNACe1zSibN4DSyGJ0h9oRQK/ox3jx92j5ci', 'uPO4tJazfhCdMjIwvTo0yEXdlaJqyxiX8GuZAc0q2Ps2Np48V9OoPslUVkjJtBKB8IbH6qUyCNLKG5ANkykGV8M5fb60CViD5mBc', 'avatar.png', '2021-10-26 08:24:50', '2021-10-26 08:24:50'),
(37, 'pengguna2', 'pengguna2', '1', 'p2@gmail', NULL, '$2y$10$c4.7Fhxbjr1xb993Nqonv.G9njanwKdSKIjaWV6TIFjRDm85GhGQK', 'basEPjja8u1Xw9ARdcKx87Dkl1stlebWJWDDKYIjXoBM50X6momXhCk03RlwuvwlLOD0GgK3nEjAmIzw6N3jusdCh7ZH9hhR2NXr', 'avatar.png', '2021-10-26 08:24:50', '2021-10-26 08:24:50'),
(38, 'pengguna3', 'pengguna3', '0', 'p3@gmail', NULL, '$2y$10$YtDLGeEon2.Vk3eVxoHdiuhRhttHWt0c1tMFpQ9bBJVUzWyUjPK5C', 'ykixK23J52neNWOn6gWoS3eqCUS1dPPqAdwNrCyfiLOpNOp4LAfXIiazUlUzUpsyjxTh5cwZK8RdI0qJMaQDni7k1TzLHr3qheY4', 'avatar.png', '2021-10-26 08:24:50', '2021-10-26 08:24:50');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `tb_carts`
--
ALTER TABLE `tb_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_carts_user_id_foreign` (`user_id`),
  ADD KEY `tb_carts_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `tb_products`
--
ALTER TABLE `tb_products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_carts`
--
ALTER TABLE `tb_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `tb_products`
--
ALTER TABLE `tb_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_carts`
--
ALTER TABLE `tb_carts`
  ADD CONSTRAINT `tb_carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `tb_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
