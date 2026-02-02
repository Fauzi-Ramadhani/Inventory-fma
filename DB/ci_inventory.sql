-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Nov 2023 pada 07.39
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `eoq`
--

CREATE TABLE `eoq` (
  `id` int(11) NOT NULL,
  `periode` varchar(50) DEFAULT NULL,
  `tgl_eoq` datetime DEFAULT NULL,
  `periode_tahun` year(4) DEFAULT NULL,
  `reorder_poin` int(11) DEFAULT NULL,
  `jarak_tiap_pesan` int(11) DEFAULT NULL,
  `frequensi_pesan` int(11) DEFAULT NULL,
  `jumlah_total_pesanan` int(11) DEFAULT NULL,
  `barang_id` varchar(20) DEFAULT NULL,
  `biaya_pesan` double DEFAULT NULL,
  `biaya_simpan` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `eoq`
--

INSERT INTO `eoq` (`id`, `periode`, `tgl_eoq`, `periode_tahun`, `reorder_poin`, `jarak_tiap_pesan`, `frequensi_pesan`, `jumlah_total_pesanan`, `barang_id`, `biaya_pesan`, `biaya_simpan`) VALUES
(1, 'Tahunan', '2023-08-04 14:53:26', 2023, 2, 2, 0, 1, 'KD-0001', 10, 1000),
(2, 'Tahunan', '2023-08-04 14:56:14', 2023, 2, 2, 0, 1, 'KD-0001', 10, 1000),
(3, 'Tahunan', '2023-11-22 13:09:55', 2023, 2, 2, 0, 1, 'KD-0001', 10, 1000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_barang`
--

CREATE TABLE `ms_barang` (
  `kd_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(150) DEFAULT NULL,
  `satuan` varchar(50) DEFAULT NULL,
  `ket_barang` varchar(255) DEFAULT NULL,
  `harga_barang` double DEFAULT NULL,
  `leadtime` int(11) DEFAULT 1,
  `percentage_biaya_simpan` int(11) DEFAULT 0,
  `biaya_simpan` double DEFAULT NULL,
  `stok_awal` int(11) DEFAULT NULL,
  `pemakaian` int(11) DEFAULT NULL,
  `stok_akhir` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `ms_barang`
--

INSERT INTO `ms_barang` (`kd_barang`, `nama_barang`, `satuan`, `ket_barang`, `harga_barang`, `leadtime`, `percentage_biaya_simpan`, `biaya_simpan`, `stok_awal`, `pemakaian`, `stok_akhir`) VALUES
('KD-0001', 'Kacamata Pria', '2', 'Kacamata Pria\r\nWarna: Hitam', 20000, 2, 5, 1000, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ms_supplier`
--

CREATE TABLE `ms_supplier` (
  `id_supplier` int(11) NOT NULL,
  `kd_supplier` varchar(30) DEFAULT NULL,
  `nama_supplier` varchar(50) DEFAULT NULL,
  `alamat_supplier` varchar(255) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `pic_supplier` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `ms_supplier`
--

INSERT INTO `ms_supplier` (`id_supplier`, `kd_supplier`, `nama_supplier`, `alamat_supplier`, `no_hp`, `email`, `pic_supplier`) VALUES
(1, 'SUP-0001', 'Farhan Aldi', 'Bintara', '081577779999', 'nadya@gmail.com', 'Nadyakun'),
(2, 'SUP-0002', 'Pororo', 'Ujung Menteng', '0219878123', 'proro@gmail.com', 'Mbroror');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_login`
--

CREATE TABLE `tb_login` (
  `id_login` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `level` varchar(30) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tb_login`
--

INSERT INTO `tb_login` (`id_login`, `username`, `password`, `level`, `nama`, `foto`) VALUES
(1, 'pemilik', '58399557dae3c60e23c78606771dfa3d', 'Pemilik', 'Asep', '50e382331b59b2fa263f2fd5e2ce8f84.png'),
(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'Ikhsan', '54da95a73d41593c2b3a69cc7638034c.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_keluar`
--

CREATE TABLE `tr_barang_keluar` (
  `id_tr_k` varchar(30) NOT NULL,
  `tgl_tr_k` timestamp NULL DEFAULT current_timestamp(),
  `id_login` int(11) DEFAULT NULL,
  `ket_tr_k` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tr_barang_keluar`
--

INSERT INTO `tr_barang_keluar` (`id_tr_k`, `tgl_tr_k`, `id_login`, `ket_tr_k`) VALUES
('TRP0408230001', '2023-08-04 07:52:25', 2, 'Terjamin Terpercaya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_keluar_beli`
--

CREATE TABLE `tr_barang_keluar_beli` (
  `id` int(11) NOT NULL,
  `id_tr_k` varchar(30) DEFAULT NULL,
  `kd_barang` varchar(20) DEFAULT NULL,
  `jumlah_beli` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tr_barang_keluar_beli`
--

INSERT INTO `tr_barang_keluar_beli` (`id`, `id_tr_k`, `kd_barang`, `jumlah_beli`) VALUES
(1, 'TRP0408230001', 'KD-0001', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_keluar_dtl`
--

CREATE TABLE `tr_barang_keluar_dtl` (
  `id_tr_kdetail` int(11) NOT NULL,
  `kd_barang` varchar(20) DEFAULT NULL,
  `jumlah_awal` int(11) DEFAULT NULL,
  `jumlah_keluar` int(11) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `id_tr_k` varchar(30) DEFAULT NULL,
  `id_tr_m` varchar(30) DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `id_tr_mdetail` int(11) DEFAULT NULL,
  `jumlah_beli` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tr_barang_keluar_dtl`
--

INSERT INTO `tr_barang_keluar_dtl` (`id_tr_kdetail`, `kd_barang`, `jumlah_awal`, `jumlah_keluar`, `harga`, `id_tr_k`, `id_tr_m`, `tgl_masuk`, `id_tr_mdetail`, `jumlah_beli`) VALUES
(1, 'KD-0001', 2, 1, 20000, 'TRP0408230001', 'BRM0408230001', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_masuk`
--

CREATE TABLE `tr_barang_masuk` (
  `id_tr_m` varchar(30) NOT NULL,
  `tgl_tr_m` timestamp NULL DEFAULT current_timestamp(),
  `id_login` int(11) DEFAULT NULL,
  `ket_tr_m` varchar(255) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tr_barang_masuk`
--

INSERT INTO `tr_barang_masuk` (`id_tr_m`, `tgl_tr_m`, `id_login`, `ket_tr_m`, `id_supplier`) VALUES
('BRM0408230001', '2023-08-04 07:51:23', 2, 'Barang Baru', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_masuk_dtl`
--

CREATE TABLE `tr_barang_masuk_dtl` (
  `id_tr_mdetail` int(11) NOT NULL,
  `kd_barang` varchar(20) DEFAULT NULL,
  `jumlah_masuk` int(11) DEFAULT NULL,
  `id_tr_m` varchar(30) DEFAULT NULL,
  `tgl_masuk` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tr_barang_masuk_dtl`
--

INSERT INTO `tr_barang_masuk_dtl` (`id_tr_mdetail`, `kd_barang`, `jumlah_masuk`, `id_tr_m`, `tgl_masuk`) VALUES
(1, 'KD-0001', 2, 'BRM0408230001', '2023-08-04 14:08:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_barang_masuk_dtl_pakai`
--

CREATE TABLE `tr_barang_masuk_dtl_pakai` (
  `id_tr_mdetail` int(11) NOT NULL,
  `kd_barang` varchar(20) DEFAULT NULL,
  `jumlah_masuk` int(11) DEFAULT NULL,
  `id_tr_m` varchar(30) DEFAULT NULL,
  `tgl_masuk` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `tr_barang_masuk_dtl_pakai`
--

INSERT INTO `tr_barang_masuk_dtl_pakai` (`id_tr_mdetail`, `kd_barang`, `jumlah_masuk`, `id_tr_m`, `tgl_masuk`) VALUES
(1, 'KD-0001', 1, 'BRM0408230001', '2023-08-04 14:08:23');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_dtl_keluar`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_dtl_keluar` (
`id_tr_kdetail` int(11)
,`kd_barang` varchar(20)
,`jumlah_awal` int(11)
,`jumlah_keluar` int(11)
,`harga` double
,`id_tr_k` varchar(30)
,`tgl_tr_k` timestamp
,`ket_tr_k` varchar(255)
,`id_tr_m` varchar(30)
,`tgl_masuk` datetime
,`id_tr_mdetail` int(11)
,`jumlah_beli` int(11)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_dtl_keluar`
--
DROP TABLE IF EXISTS `v_dtl_keluar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_dtl_keluar`  AS SELECT `k`.`id_tr_kdetail` AS `id_tr_kdetail`, `k`.`kd_barang` AS `kd_barang`, `k`.`jumlah_awal` AS `jumlah_awal`, `k`.`jumlah_keluar` AS `jumlah_keluar`, `k`.`harga` AS `harga`, `k`.`id_tr_k` AS `id_tr_k`, `b`.`tgl_tr_k` AS `tgl_tr_k`, `b`.`ket_tr_k` AS `ket_tr_k`, `k`.`id_tr_m` AS `id_tr_m`, `k`.`tgl_masuk` AS `tgl_masuk`, `k`.`id_tr_mdetail` AS `id_tr_mdetail`, `k`.`jumlah_beli` AS `jumlah_beli` FROM (`tr_barang_keluar_dtl` `k` join `tr_barang_keluar` `b` on(`k`.`id_tr_k` = `b`.`id_tr_k`))  ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `eoq`
--
ALTER TABLE `eoq`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ms_barang`
--
ALTER TABLE `ms_barang`
  ADD PRIMARY KEY (`kd_barang`) USING BTREE;

--
-- Indeks untuk tabel `ms_supplier`
--
ALTER TABLE `ms_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`id_login`) USING BTREE;

--
-- Indeks untuk tabel `tr_barang_keluar`
--
ALTER TABLE `tr_barang_keluar`
  ADD PRIMARY KEY (`id_tr_k`) USING BTREE;

--
-- Indeks untuk tabel `tr_barang_keluar_beli`
--
ALTER TABLE `tr_barang_keluar_beli`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indeks untuk tabel `tr_barang_keluar_dtl`
--
ALTER TABLE `tr_barang_keluar_dtl`
  ADD PRIMARY KEY (`id_tr_kdetail`) USING BTREE;

--
-- Indeks untuk tabel `tr_barang_masuk`
--
ALTER TABLE `tr_barang_masuk`
  ADD PRIMARY KEY (`id_tr_m`) USING BTREE;

--
-- Indeks untuk tabel `tr_barang_masuk_dtl`
--
ALTER TABLE `tr_barang_masuk_dtl`
  ADD PRIMARY KEY (`id_tr_mdetail`) USING BTREE;

--
-- Indeks untuk tabel `tr_barang_masuk_dtl_pakai`
--
ALTER TABLE `tr_barang_masuk_dtl_pakai`
  ADD PRIMARY KEY (`id_tr_mdetail`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `eoq`
--
ALTER TABLE `eoq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `ms_supplier`
--
ALTER TABLE `ms_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_login`
--
ALTER TABLE `tb_login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tr_barang_keluar_beli`
--
ALTER TABLE `tr_barang_keluar_beli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tr_barang_keluar_dtl`
--
ALTER TABLE `tr_barang_keluar_dtl`
  MODIFY `id_tr_kdetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tr_barang_masuk_dtl`
--
ALTER TABLE `tr_barang_masuk_dtl`
  MODIFY `id_tr_mdetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tr_barang_masuk_dtl_pakai`
--
ALTER TABLE `tr_barang_masuk_dtl_pakai`
  MODIFY `id_tr_mdetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
