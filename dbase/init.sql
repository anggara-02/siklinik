-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 20 Nov 2021 pada 13.35
-- Versi server: 10.3.14-MariaDB
-- Versi PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `private_siresto`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data`
--

DROP TABLE IF EXISTS `data`;
CREATE TABLE IF NOT EXISTS `data` (
  `data_id` int(11) NOT NULL AUTO_INCREMENT,
  `data_name` varchar(255) NOT NULL,
  `data_stock` float NOT NULL DEFAULT 0,
  `data_keterangan` text NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_user_id` int(11) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_bank`
--

DROP TABLE IF EXISTS `data_bank`;
CREATE TABLE IF NOT EXISTS `data_bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(200) NOT NULL,
  `bank_keterangan` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`bank_id`),
  KEY `spending_name` (`bank_name`,`is_delete`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `data_bank`
--

INSERT INTO `data_bank` (`bank_id`, `bank_name`, `bank_keterangan`, `is_delete`, `is_permanent`, `last_update`, `last_user_id`) VALUES
(1, 'Cash', NULL, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_log`
--

DROP TABLE IF EXISTS `data_log`;
CREATE TABLE IF NOT EXISTS `data_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_table` varchar(200) NOT NULL,
  `log_column` varchar(200) NOT NULL,
  `log_type` varchar(50) NOT NULL,
  `log_script` text NOT NULL,
  `log_date` date NOT NULL,
  `log_execute` date NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_log`
--

INSERT INTO `data_log` (`log_id`, `log_table`, `log_column`, `log_type`, `log_script`, `log_date`, `log_execute`) VALUES
(1, 'data_log', 'log_id', 'init', 'select 1', '2021-10-20', '2021-11-20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_menu`
--

DROP TABLE IF EXISTS `data_menu`;
CREATE TABLE IF NOT EXISTS `data_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `menu_category_id` int(11) NOT NULL,
  `menu_price_bruto` decimal(15,2) NOT NULL DEFAULT 0.00,
  `menu_disc` decimal(15,2) NOT NULL DEFAULT 0.00,
  `menu_margin` float NOT NULL DEFAULT 0,
  `menu_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `menu_image` text DEFAULT NULL,
  `menu_keterangan` varchar(255) NOT NULL,
  `menu_insert_date` datetime NOT NULL,
  `menu_insert_user` int(11) NOT NULL,
  `menu_is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`menu_id`),
  KEY `menu_name` (`menu_name`,`is_delete`,`menu_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_menu_category`
--

DROP TABLE IF EXISTS `data_menu_category`;
CREATE TABLE IF NOT EXISTS `data_menu_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `category_keterangan` text NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_menu_category`
--

INSERT INTO `data_menu_category` (`category_id`, `category_name`, `category_keterangan`, `is_delete`, `is_permanent`, `last_update`, `last_user_id`) VALUES
(1, 'Food', '', 0, 1, NULL, NULL),
(2, 'Beverage\r\n', '', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pasien`
--

DROP TABLE IF EXISTS `data_pasien`;
CREATE TABLE IF NOT EXISTS `data_pasien` (
  `pasien_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pasien_rm_number` text DEFAULT NULL,
  `pasien_nama` varchar(255) NOT NULL,
  `pasien_medsos` varchar(255) NOT NULL,
  `pasien_email` varchar(255) NOT NULL,
  `pasien_facebook` varchar(255) NOT NULL,
  `pasien_instagram` varchar(255) NOT NULL,
  `pasien_twitter` varchar(255) NOT NULL,
  `pasien_birthdate` date NOT NULL,
  `pasien_riwayat` text NOT NULL,
  `pasien_kondisi_kulit` text NOT NULL,
  `pasien_telp` varchar(255) NOT NULL,
  `pasien_alamat` text NOT NULL,
  `pasien_pertama` enum('Y','N') NOT NULL DEFAULT 'Y',
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `pasien_insert_user` int(11) NOT NULL,
  `pasien_insert_date` datetime NOT NULL,
  `pasien_last_update` date DEFAULT NULL,
  `pasien_last_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`pasien_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pegawai`
--

DROP TABLE IF EXISTS `data_pegawai`;
CREATE TABLE IF NOT EXISTS `data_pegawai` (
  `pegawai_id` int(11) NOT NULL AUTO_INCREMENT,
  `pegawai_type` varchar(200) NOT NULL DEFAULT 'staff',
  `pegawai_name` varchar(255) NOT NULL,
  `pegawai_phone` varchar(255) NOT NULL,
  `pegawai_keterangan` text NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pegawai_id`),
  KEY `pegawai_name` (`pegawai_name`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_role`
--

DROP TABLE IF EXISTS `data_role`;
CREATE TABLE IF NOT EXISTS `data_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `role_type` enum('superuser','administrator') NOT NULL DEFAULT 'administrator',
  `role_keterangan` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `data_role`
--

INSERT INTO `data_role` (`role_id`, `role_name`, `role_type`, `role_keterangan`, `is_delete`, `is_permanent`, `last_update`, `last_user_id`) VALUES
(1, 'administrator', 'superuser', '', 0, 1, '2018-04-29 09:09:01', 1),
(2, 'Kasir', 'administrator', '', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_satuan`
--

DROP TABLE IF EXISTS `data_satuan`;
CREATE TABLE IF NOT EXISTS `data_satuan` (
  `satuan_id` int(11) NOT NULL AUTO_INCREMENT,
  `satuan_name` varchar(200) NOT NULL,
  `satuan_keterangan` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`satuan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_shift`
--

DROP TABLE IF EXISTS `data_shift`;
CREATE TABLE IF NOT EXISTS `data_shift` (
  `shift_id` int(11) NOT NULL AUTO_INCREMENT,
  `shift_name` varchar(100) NOT NULL,
  `shift_hour_start` time NOT NULL,
  `shift_hour_end` time NOT NULL,
  `shift_is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 1,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_shift`
--

INSERT INTO `data_shift` (`shift_id`, `shift_name`, `shift_hour_start`, `shift_hour_end`, `shift_is_active`, `is_delete`, `is_permanent`, `last_update`, `last_user_id`) VALUES
(1, 'Pagi', '06:00:00', '12:00:00', 1, 0, 1, NULL, NULL),
(2, 'Siang', '12:00:00', '17:00:00', 1, 0, 1, NULL, NULL),
(3, 'Sore', '17:00:00', '22:00:00', 1, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_supplier`
--

DROP TABLE IF EXISTS `data_supplier`;
CREATE TABLE IF NOT EXISTS `data_supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_phone` varchar(255) NOT NULL,
  `supplier_keterangan` text NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`),
  KEY `supplier_name` (`supplier_name`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_tindakan`
--

DROP TABLE IF EXISTS `data_tindakan`;
CREATE TABLE IF NOT EXISTS `data_tindakan` (
  `tindakan_id` int(11) NOT NULL AUTO_INCREMENT,
  `tindakan_name` varchar(255) NOT NULL,
  `tindakan_type` varchar(50) NOT NULL DEFAULT 'obat',
  `tindakan_price_bruto` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tindakan_disc` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tindakan_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tindakan_keterangan` varchar(255) NOT NULL,
  `tindakan_commition` float NOT NULL DEFAULT 0,
  `tindakan_insert_date` datetime NOT NULL,
  `tindakan_insert_user` int(11) NOT NULL,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`tindakan_id`),
  KEY `tindakan_name` (`tindakan_name`,`tindakan_type`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_tindakan_detail`
--

DROP TABLE IF EXISTS `data_tindakan_detail`;
CREATE TABLE IF NOT EXISTS `data_tindakan_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_paket_id` int(11) NOT NULL,
  `detail_product_id` int(11) NOT NULL,
  `detail_price` decimal(15,2) NOT NULL,
  `detail_qty` int(11) NOT NULL,
  `detail_subtotal` decimal(15,2) NOT NULL,
  `detail_insert_date` int(11) NOT NULL,
  `detail_insert_user` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `is_permanent` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`detail_id`),
  KEY `detail_paket_id` (`detail_paket_id`,`detail_product_id`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_user`
--

DROP TABLE IF EXISTS `data_user`;
CREATE TABLE IF NOT EXISTS `data_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `pegawai_id` int(11) NOT NULL DEFAULT 0,
  `user_karyawan` varchar(200) DEFAULT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_keterangan` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_suspend` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_user`
--

INSERT INTO `data_user` (`user_id`, `role_id`, `user_name`, `pegawai_id`, `user_karyawan`, `user_password`, `user_keterangan`, `last_login`, `is_suspend`, `is_active`, `is_delete`, `is_permanent`, `last_update`, `last_user_id`) VALUES
(1, 1, 'admin', 0, '', '2aefc34200a294a3cc7db81b43a81873', '', '2021-11-20 19:04:58', 0, 1, 0, 0, '2021-11-06 09:44:36', 1),
(2, 1, 'icha', 9, 'Icha', 'e10adc3949ba59abbe56e057f20f883e', '', '2021-11-01 20:02:28', 0, 1, 0, 0, '2021-11-01 19:57:10', 1),
(4, 2, 'nina', 4, 'Nina', 'e10adc3949ba59abbe56e057f20f883e', '', '2021-11-01 21:48:04', 0, 1, 0, 0, '2021-11-01 19:58:24', 1),
(5, 1, 'widia', 10, 'Widia', '2aefc34200a294a3cc7db81b43a81873', '', '2021-11-02 18:13:14', 0, 1, 0, 0, '2021-11-02 18:12:53', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_akses`
--

DROP TABLE IF EXISTS `setting_akses`;
CREATE TABLE IF NOT EXISTS `setting_akses` (
  `akses_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `access_pendaftaran` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `access_pemeriksaan` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `access_pasien` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_setting_grup` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_setting_user` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_setting_config` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_setting_pegawai` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_setting_tindakan` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_setting_produk` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_setting_paket` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_setting_supplier` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `access_spending` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `access_buy` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `access_pos` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `access_piutang` varchar(20) NOT NULL DEFAULT ' 0~0~0~0 ',
  `akses_report_buy` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_report_penjualan` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_report_stock` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_report_daily` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `akses_report_komisi` varchar(20) NOT NULL DEFAULT '0~0~0~0',
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` tinyint(1) DEFAULT NULL,
  `last_user_id` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`akses_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `setting_akses`
--

INSERT INTO `setting_akses` (`akses_id`, `role_id`, `access_pendaftaran`, `access_pemeriksaan`, `access_pasien`, `akses_setting_grup`, `akses_setting_user`, `akses_setting_config`, `akses_setting_pegawai`, `akses_setting_tindakan`, `akses_setting_produk`, `akses_setting_paket`, `akses_setting_supplier`, `access_spending`, `access_buy`, `access_pos`, `access_piutang`, `akses_report_buy`, `akses_report_penjualan`, `akses_report_stock`, `akses_report_daily`, `akses_report_komisi`, `is_delete`, `is_permanent`, `last_update`, `last_user_id`) VALUES
(1, 1, '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', ' 0~0~0~0 ', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', 0, 0, 127, 4),
(2, 2, '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '1~1~1~1', ' 0~0~0~0 ', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', '0~0~0~0', 0, 0, 127, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_config`
--

DROP TABLE IF EXISTS `setting_config`;
CREATE TABLE IF NOT EXISTS `setting_config` (
  `config_name` varchar(200) NOT NULL,
  `config_province_name` varchar(100) NOT NULL,
  `config_city_name` varchar(200) NOT NULL,
  `config_address` text NOT NULL,
  `config_email` varchar(100) NOT NULL,
  `config_phone` varchar(255) NOT NULL,
  `config_fax` varchar(200) NOT NULL,
  `config_whatsapp` varchar(20) DEFAULT NULL,
  `config_logo` text DEFAULT NULL,
  `config_app_pembulatan` enum('0','50','100','1000') NOT NULL,
  `config_app_description` varchar(255) NOT NULL,
  `config_app_keywords` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `setting_config`
--

INSERT INTO `setting_config` (`config_name`, `config_province_name`, `config_city_name`, `config_address`, `config_email`, `config_phone`, `config_fax`, `config_whatsapp`, `config_logo`, `config_app_pembulatan`, `config_app_description`, `config_app_keywords`) VALUES
('WSJ Skincare', 'Jawa Barat', 'Kota Bekasi', 'Jl. Rose Garden 3 No.31, Jaka Setia, Kec. Bekasi Selatan', 'wsj.skincare@mail.com', '0857-8888-8416', '-', NULL, '', '50', '-', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_penerimaan`
--

DROP TABLE IF EXISTS `trx_penerimaan`;
CREATE TABLE IF NOT EXISTS `trx_penerimaan` (
  `penerimaan_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penerimaan_tanggal` date NOT NULL,
  `penerimaan_shift` varchar(100) DEFAULT NULL,
  `penerimaan_status` varchar(50) NOT NULL DEFAULT 'pembelian',
  `penerimaan_code` varchar(100) NOT NULL,
  `penerimaan_no` varchar(50) DEFAULT NULL,
  `penerimaan_tipe` enum('cash','tempo','titip','konsinyasi') NOT NULL DEFAULT 'cash',
  `penerimaan_tempo` date DEFAULT NULL,
  `penerimaan_dp` decimal(15,2) DEFAULT NULL,
  `penerimaan_supplier_id` int(11) NOT NULL,
  `penerimaan_supplier_name` varchar(200) NOT NULL,
  `penerimaan_harga` decimal(15,2) NOT NULL,
  `penerimaan_disc_rp` decimal(15,2) NOT NULL,
  `penerimaan_disc_persen` float NOT NULL,
  `penerimaan_ppn_rp` decimal(15,2) NOT NULL,
  `penerimaan_ppn_persen` float NOT NULL,
  `penerimaan_harga_net` decimal(15,2) NOT NULL,
  `penerimaan_keterangan` varchar(255) DEFAULT NULL,
  `penerimaan_input_by` int(11) NOT NULL,
  `penerimaan_input_date` datetime NOT NULL,
  `penerimaan_input_shift` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_update_id` text DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`penerimaan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_penerimaan_detail`
--

DROP TABLE IF EXISTS `trx_penerimaan_detail`;
CREATE TABLE IF NOT EXISTS `trx_penerimaan_detail` (
  `penerimaan_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penerimaan_id` bigint(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `penerimaan_detail_satuan_id` int(11) NOT NULL,
  `penerimaan_detail_satuan_name` varchar(255) DEFAULT NULL,
  `penerimaan_detail_satuan_konversi` int(11) NOT NULL DEFAULT 1,
  `penerimaan_detail_harga` decimal(15,2) NOT NULL,
  `penerimaan_detail_disc_rp` decimal(15,2) NOT NULL,
  `penerimaan_detail_disc_persen` float NOT NULL,
  `penerimaan_detail_harga_net` decimal(15,2) NOT NULL,
  `penerimaan_detail_qty` int(11) NOT NULL,
  `penerimaan_detail_total` decimal(15,2) NOT NULL,
  `penerimaan_detail_input_by` int(11) NOT NULL,
  `penerimaan_detail_input_date` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_update_id` text DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`penerimaan_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_penjualan`
--

DROP TABLE IF EXISTS `trx_penjualan`;
CREATE TABLE IF NOT EXISTS `trx_penjualan` (
  `penjualan_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penjualan_shift` varchar(100) NOT NULL,
  `penjualan_pasien_id` int(11) NOT NULL DEFAULT 0,
  `penjualan_pasien_name` varchar(255) NOT NULL DEFAULT '-',
  `penjualan_pasien_telp` varchar(255) NOT NULL DEFAULT '-',
  `penjualan_terapis_id` int(11) NOT NULL DEFAULT 0,
  `penjualan_terapis_name` varchar(255) NOT NULL DEFAULT '-',
  `penjualan_hairstylist_id` int(11) NOT NULL DEFAULT 0,
  `penjualan_hairstylist_name` varchar(255) NOT NULL DEFAULT '-',
  `penjualan_date` date NOT NULL,
  `penjualan_code` varchar(255) NOT NULL,
  `penjualan_bank_id` int(11) NOT NULL DEFAULT 0,
  `penjualan_bank_name` varchar(255) NOT NULL DEFAULT '-',
  `penjualan_harga` decimal(15,2) NOT NULL,
  `penjualan_disc_rp` decimal(15,2) NOT NULL,
  `penjualan_harga_net` decimal(15,2) NOT NULL,
  `penjualan_bayar` decimal(15,2) NOT NULL,
  `penjualan_pembayaran_other` decimal(15,2) NOT NULL DEFAULT 0.00,
  `penjualan_pembayaran_cash` decimal(15,0) NOT NULL DEFAULT 0,
  `penjualan_keterangan` text NOT NULL,
  `penjualan_input_by` int(11) NOT NULL,
  `penjualan_input_date` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_update_id` int(11) DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`penjualan_id`),
  KEY `penjualan_pasien_id` (`penjualan_pasien_id`,`penjualan_date`,`penjualan_code`,`penjualan_bank_id`,`is_delete`,`is_permanent`,`is_valid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_penjualan_detail`
--

DROP TABLE IF EXISTS `trx_penjualan_detail`;
CREATE TABLE IF NOT EXISTS `trx_penjualan_detail` (
  `penjualan_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penjualan_id` bigint(20) NOT NULL,
  `pegawai_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `penjualan_detail_satuan_id` int(11) NOT NULL,
  `penjualan_detail_satuan_name` varchar(255) DEFAULT NULL,
  `penjualan_detail_satuan_konversi` int(11) NOT NULL DEFAULT 1,
  `penjualan_detail_harga` decimal(15,2) NOT NULL,
  `penjualan_detail_disc_rp` decimal(15,2) NOT NULL,
  `penjualan_detail_disc_persen` float NOT NULL,
  `penjualan_detail_harga_net` decimal(15,2) NOT NULL,
  `penjualan_detail_qty` int(11) NOT NULL,
  `penjualan_detail_total` decimal(15,2) NOT NULL,
  `penjualan_detail_input_by` int(11) NOT NULL,
  `penjualan_detail_input_date` datetime NOT NULL,
  `penjualan_detail_note` varchar(100) NOT NULL DEFAULT '-',
  `penjualan_detail_komisi` float NOT NULL DEFAULT 0,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_update_id` text DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`penjualan_detail_id`),
  KEY `penjualan_id` (`penjualan_id`,`product_id`,`penjualan_detail_satuan_id`,`penjualan_detail_satuan_name`,`penjualan_detail_input_date`,`is_delete`),
  KEY `pegawai_id` (`pegawai_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_penjualan_paket_detail`
--

DROP TABLE IF EXISTS `trx_penjualan_paket_detail`;
CREATE TABLE IF NOT EXISTS `trx_penjualan_paket_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `detail_penjualan_id` int(11) NOT NULL,
  `detail_penjualan_detail_id` int(11) NOT NULL,
  `detail_product_id` int(11) NOT NULL,
  `detail_product_name` varchar(255) NOT NULL,
  `detail_qty` int(11) NOT NULL,
  `detail_insert_date` int(11) NOT NULL,
  `detail_insert_user` int(11) NOT NULL,
  `last_update` int(11) NOT NULL,
  `last_user_id` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `is_permanent` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`detail_id`),
  KEY `detail_penjualan_id` (`detail_penjualan_id`,`detail_product_id`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_piutang`
--

DROP TABLE IF EXISTS `trx_piutang`;
CREATE TABLE IF NOT EXISTS `trx_piutang` (
  `piutang_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pegawai_id` int(11) NOT NULL,
  `piutang_tanggal` date NOT NULL,
  `piutang_bayar` decimal(15,2) NOT NULL,
  `piutang_total` decimal(15,2) NOT NULL,
  `piutang_keterangan` varchar(255) NOT NULL,
  `piutang_input_by` int(11) NOT NULL,
  `piutang_input_date` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 1,
  `last_update` datetime DEFAULT NULL,
  `last_update_id` text DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`piutang_id`),
  KEY `pegawai_id` (`pegawai_id`,`piutang_tanggal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_piutang_bayar`
--

DROP TABLE IF EXISTS `trx_piutang_bayar`;
CREATE TABLE IF NOT EXISTS `trx_piutang_bayar` (
  `piutang_bayar_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `piutang_id` bigint(20) NOT NULL,
  `penjualan_id` bigint(20) NOT NULL,
  `piutang_bayar_date` date NOT NULL,
  `piutang_bayar_type` varchar(40) NOT NULL,
  `piutang_bayar_nominal` decimal(15,2) NOT NULL,
  `piutang_bayar_reff` varchar(40) DEFAULT NULL,
  `piutang_bayar_bank` varchar(100) DEFAULT NULL,
  `piutang_bayar_keterangan` varchar(255) DEFAULT NULL,
  `piutang_bayar_input_by` int(11) NOT NULL,
  `piutang_bayar_input_date` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 1,
  `last_update` datetime DEFAULT NULL,
  `last_update_id` text DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`piutang_bayar_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_spending`
--

DROP TABLE IF EXISTS `trx_spending`;
CREATE TABLE IF NOT EXISTS `trx_spending` (
  `spending_id` int(11) NOT NULL AUTO_INCREMENT,
  `spending_name` varchar(255) NOT NULL,
  `spending_date` date NOT NULL,
  `spending_nominal` decimal(15,2) NOT NULL,
  `spending_keterangan` text NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`spending_id`),
  KEY `spending_name` (`spending_name`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_stock`
--

DROP TABLE IF EXISTS `trx_stock`;
CREATE TABLE IF NOT EXISTS `trx_stock` (
  `stock_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stock_product_id` int(11) NOT NULL,
  `stock_price` decimal(15,2) NOT NULL,
  `stock_qty` int(11) NOT NULL,
  `stock_sale` int(11) NOT NULL DEFAULT 0,
  `stock_keterangan` text DEFAULT NULL,
  `stock_input_by` int(11) NOT NULL,
  `stock_input_date` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` int(11) NOT NULL DEFAULT 0,
  `last_update` datetime DEFAULT NULL,
  `last_update_id` text DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`stock_id`),
  KEY `stock_product_id` (`stock_product_id`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_stock_log`
--

DROP TABLE IF EXISTS `trx_stock_log`;
CREATE TABLE IF NOT EXISTS `trx_stock_log` (
  `stock_log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stock_log_product_id` int(11) NOT NULL,
  `stock_log_transaction_type` varchar(100) NOT NULL,
  `stock_log_transaction_id` bigint(20) NOT NULL,
  `stock_log_price` decimal(15,2) NOT NULL,
  `stock_log_price_sell` decimal(15,2) NOT NULL DEFAULT 0.00,
  `stock_log_qty` int(11) NOT NULL,
  `stock_log_keterangan` text DEFAULT NULL,
  `stock_log_input_by` int(11) NOT NULL,
  `stock_log_input_date` datetime NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0,
  `is_permanent` int(11) NOT NULL DEFAULT 1,
  `last_update` datetime DEFAULT NULL,
  `last_update_id` text DEFAULT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`stock_log_id`),
  KEY `stock_log_product_id` (`stock_log_product_id`,`stock_log_transaction_type`,`stock_log_transaction_id`,`is_delete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
