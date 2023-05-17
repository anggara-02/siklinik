<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_front.php';
class log extends controller_front {
	protected $st; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
    }

    public function execute() {  
		$log_execute=date('Y-m-d');
		// $db2 = $this->load->database('default', TRUE);
		$query=$this->db->query('select log_id from data_log where 1 order by log_id DESC limit 1')->row_array();
		$last_cron=intval($query['log_id']);
		
		$data=$this->cron();
		$script=array_reverse($data['script']);
		// echo '<pre>';print_r($script);
		foreach($script as $row)
		{
			
			if($row['log_id']>$last_cron)
			{
				// echo '<pre>';print_r($row);exit;
				//jalankan fungsi init log
				$array_log=array(
					'log_id'=>$row['log_id'],
					'log_table'=>$row['log_table'],
					'log_column'=>$row['log_column'],
					'log_type'=>$row['log_type'],
					'log_script'=>$row['log_script'],
					'log_date'=>$row['log_date'],
					'log_execute'=>$log_execute,
				);
				
				$this->db->query($row['log_script']);
				$this->db->insert('data_log',$array_log);
				$last_cron=$row['log_id'];
				echo 'sukses eksekusi '.$row['log_type'].' '.$row['log_table'].'<br/>';
			}
		}
	
		
	}
	
    public function init() {  
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `data_log` (
			  `log_id` int(11) NOT NULL AUTO_INCREMENT,
			  `log_table` varchar(200) NOT NULL,
			  `log_column` varchar(200) NOT NULL,
			  `log_type` varchar(50) NOT NULL,
			  `log_script` text NOT NULL,
			  `log_date` date NOT NULL,
			  `log_execute` date NOT NULL,
			  PRIMARY KEY (`log_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;
			");
			// `log_id`, `log_table`, `log_column`, `log_type`, `log_script`, `log_date`, `log_execute`
			echo 'inisialisasi modul log berhasil.';
	}
	
    public function cron() {  
		$script=array( 
			array(
				'log_id'=>'134',
				'log_table'=>'data_so',
				'log_column'=>'user_input',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_so ADD user_input INT(11) NOT NULL AFTER is_permanent;
				",
				'log_date'=>'2022-11-12',
			),
			array(
				'log_id'=>'133',
				'log_table'=>'data_penerimaan',
				'log_column'=>'tanggal_input',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_penerimaan ADD tanggal_input DATETIME NULL AFTER tanggal_retur;
				",
				'log_date'=>'2022-11-12',
			),
			array(
				'log_id'=>'132',
				'log_table'=>'data_obat',
				'log_column'=>'obat_lokasi',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_obat ADD obat_lokasi VARCHAR(25) NULL DEFAULT NULL AFTER obat_kemasan_besar_konversi, ADD obat_rak VARCHAR(25) NULL DEFAULT NULL AFTER obat_lokasi;
				",
				'log_date'=>'2022-11-12',
			),
			array(
				'log_id'=>'131',
				'log_table'=>'data_alkes',
				'log_column'=>'alkes_type',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_alkes ADD alkes_type VARCHAR(50) NULL DEFAULT NULL AFTER alkes_rak;
				",
				'log_date'=>'2022-11-12',
			),
			array(
				'log_id'=>'130',
				'log_table'=>'data_alkes',
				'log_column'=>'alkes_lokasi',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_alkes ADD alkes_lokasi VARCHAR(25) NULL DEFAULT NULL AFTER alkes_price_sale, ADD alkes_rak VARCHAR(25) NULL DEFAULT NULL AFTER alkes_lokasi;
				",
				'log_date'=>'2022-11-12',
			),
			array(
				'log_id'=>'129',
				'log_table'=>'data_distribusi',
				'log_column'=>'tujuan',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_distribusi CHANGE tujuan tujuan ENUM('etalase','gudang','promo') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'128',
				'log_table'=>'data_so_detail',
				'log_column'=>'so_detail_kemasan_id',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_so_detail ADD so_detail_kemasan_id INT(50) NOT NULL DEFAULT '0' AFTER is_obat;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'127',
				'log_table'=>'trx_pendaftaran',
				'log_column'=>'pendaftaran_from',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pendaftaran` ADD `pendaftaran_from` VARCHAR(20) NOT NULL DEFAULT 'pendaftaran' AFTER `pendaftaran_status`;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'126',
				'log_table'=>'setting',
				'log_column'=>'setting_id',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `setting` CHANGE `setting_id` `setting_id` INT(11) NOT NULL AUTO_INCREMENT;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'125',
				'log_table'=>'setting',
				'log_column'=>'setting_id',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `setting` ADD PRIMARY KEY(`setting_id`);
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'124',
				'log_table'=>'setting',
				'log_column'=>'setting_id',
				'log_type'=>'add_column',
				'log_script'=>"
					CREATE TABLE `setting` ( `setting_id` INT NOT NULL , `nama_klinik` VARCHAR(255) NOT NULL , `no_telpon` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `alamat` TEXT NOT NULL , `logo` VARCHAR(255) NOT NULL , `apoteker` VARCHAR(255) NOT NULL , `sipa` VARCHAR(255) NOT NULL , `sia` VARCHAR(255) NOT NULL , `min_promo` DECIMAL(20.2) NOT NULL , `konversi_poin` VARCHAR(255) NOT NULL ) ENGINE = InnoDB;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'123',
				'log_table'=>'trx_pemeriksaan',
				'log_column'=>'pemeriksaan_shift',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan` ADD `pemeriksaan_shift_id` INT NOT NULL DEFAULT '0' AFTER `pemeriksaan_date`, ADD `pemeriksaan_shift_name` VARCHAR(100) NOT NULL DEFAULT '' AFTER `pemeriksaan_shift_id`;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'122',
				'log_table'=>'data_distribusi',
				'log_column'=>'sumber',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_distribusi ADD sumber ENUM('gudang', 'etalase', 'promo') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER tanggal;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'121',
				'log_table'=>'data_alkes',
				'log_column'=>'alkes_old_price',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_alkes ADD alkes_old_price DECIMAL(15,2) NOT NULL AFTER alkes_barcode;
				",
				'log_date'=>'2022-04-17',
			), 
			array(
				'log_id'=>'120',
				'log_table'=>'data_stok',
				'log_column'=>'penyimpanan',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_stok CHANGE penyimpanan penyimpanan ENUM('etalase','gudang', 'promo') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'119',
				'log_table'=>'data_obat',
				'log_column'=>'update_at',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_obat` CHANGE `update_at` `update_at` DATETIME on update CURRENT_TIMESTAMP NULL DEFAULT NULL;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'118',
				'log_table'=>'data_obat',
				'log_column'=>'create_at',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_obat` ADD `create_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `is_permanent`, ADD `update_at` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `create_at`;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'117',
				'log_table'=>'trx_pendaftaran',
				'log_column'=>'pendaftaran_membership_id',
				'log_type'=>'add_table',
				'log_script'=>"
					ALTER TABLE `trx_pendaftaran` ADD `pendaftaran_membership_id` INT NOT NULL AFTER `pendaftaran_pasien_rm`;
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'116',
				'log_table'=>'trx_membership_log',
				'log_column'=>'log_membership_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `trx_membership_log` (
					 `log_id` int(11) NOT NULL AUTO_INCREMENT,
					 `log_membership_id` int(11) NOT NULL,
					 `log_trx_kasir_id` int(11) NOT NULL,
					 `log_date` datetime NOT NULL,
					 `log_nominal` decimal(15,2) NOT NULL,
					 `log_poin_convert` float NOT NULL,
					 `log_poin_before` float NOT NULL,
					 `log_poin` float NOT NULL,
					 `log_poin_after` float NOT NULL,
					 `log_input_by` varchar(255) NOT NULL,
					 PRIMARY KEY (`log_id`),
					 KEY `log_membership_id` (`log_membership_id`,`log_trx_kasir_id`,`log_date`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'115',
				'log_table'=>'trx_membership',
				'log_column'=>'membership_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `trx_membership` (
					 `membership_id` int(11) NOT NULL AUTO_INCREMENT,
					 `membership_pendaftaran_id` int(11) NOT NULL,
					 `membership_pasien_id` int(11) NOT NULL,
					 `membership_type_id` int(11) NOT NULL,
					 `membership_type` varchar(20) NOT NULL DEFAULT 'silver',
					 `membership_date` datetime NOT NULL,
					 `membership_poin` float NOT NULL,
					 `membership_input_by` varchar(255) NOT NULL,
					 `membership_update_by` varchar(255) DEFAULT NULL,
					 `membership_last_update` datetime DEFAULT NULL,
					 PRIMARY KEY (`membership_id`),
					 KEY `membership_pendaftaran_id` (`membership_pendaftaran_id`,`membership_pasien_id`,`membership_type_id`,`membership_type`,`membership_date`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'114',
				'log_table'=>'data_membership_log',
				'log_column'=>'id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_membership_log` (
					 `log_id` int(11) NOT NULL AUTO_INCREMENT,
					 `id` int(11) NOT NULL,
					 `membership_name` varchar(20) NOT NULL,
					 `membership_convert` int(11) NOT NULL COMMENT 'untuk dapat 1 poin',
					 `membership_update_date` datetime NOT NULL,
					 `membership_update_by` varchar(255) NOT NULL,
					 PRIMARY KEY (`log_id`),
					 KEY `id` (`id`,`membership_name`,`membership_convert`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'113',
				'log_table'=>'data_membership',
				'log_column'=>'id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_membership` (
					 `id` int(11) NOT NULL AUTO_INCREMENT,
					 `membership_name` varchar(20) NOT NULL,
					 `membership_convert` decimal(15,2) NOT NULL COMMENT 'untuk dapat 1 poin',
					 `membership_input_date` datetime NOT NULL,
					 `membership_input_by` varchar(255) NOT NULL,
					 `membership_update_date` datetime DEFAULT NULL,
					 `membership_update_by` varchar(255) DEFAULT NULL,
					 `is_delete` tinyint(1) DEFAULT '0',
					 PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-04-17',
			),
			array(
				'log_id'=>'112',
				'log_table'=>'data_detail_pemesanan',
				'log_column'=>'detail_pemesanan_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_detail_pemesanan` (
				  `detail_pemesanan_id` int(11) NOT NULL AUTO_INCREMENT,
				  `detail_pemesanan_pemesanan_id` int(11) NOT NULL,
				  `detail_pemesanan_barcode` varchar(255) NOT NULL,
				  `detail_pemesanan_nama_barang` varchar(255) NOT NULL,
				  `detail_pemesanan_kemasan` varchar(255) NOT NULL,
				  `detail_pemesanan_qty` int(11) NOT NULL,
				  `is_obat` tinyint(4) NOT NULL DEFAULT '1',
				  PRIMARY KEY (`detail_pemesanan_id`),
				  KEY `detail_pemesanan_pemesanan_id` (`detail_pemesanan_pemesanan_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'111',
				'log_table'=>'pemesanan_id',
				'log_column'=>'stok_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_pemesanan` (
					  `pemesanan_id` int(11) NOT NULL AUTO_INCREMENT,
					  `pemesanan_no_sp` varchar(255) NOT NULL,
					  `pemesanan_jenis_sp` varchar(255) NOT NULL,
					  `pemesanan_tanggal` date NOT NULL,
					  `pemesanan_supplier_id` int(11) NOT NULL,
					  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
					  `is_permanent` tinyint(1) NOT NULL DEFAULT '0',
					  `is_penerimaan` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = Tidak ada di penerimaan\r\n1 = Sudah ada di penerimaan',
					  PRIMARY KEY (`pemesanan_id`),
					  KEY `pemesanan_supplier` (`pemesanan_supplier_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'110',
				'log_table'=>'data_stok_log',
				'log_column'=>'stok_id',
				'log_type'=>'add_column',
				'log_script'=>"
					DROP TABLE IF EXISTS `data_detail_pemesanan`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'109',
				'log_table'=>'data_stok_log',
				'log_column'=>'stok_id',
				'log_type'=>'add_column',
				'log_script'=>"
					DROP TABLE IF EXISTS `data_pemesanan`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'108',
				'log_table'=>'data_stok_log',
				'log_column'=>'stok_id',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_stok_log` ADD `stok_id` INT NULL DEFAULT NULL AFTER `id`;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'107',
				'log_table'=>'data_obat',
				'log_column'=>'obat_old_price',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_obat ADD obat_old_price DECIMAL(15,2) NULL DEFAULT NULL AFTER obat_dosis_id;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'104',
				'log_table'=>'data_pemesanan',
				'log_column'=>'is_penerimaan',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_pemesanan ADD is_penerimaan TINYINT NOT NULL DEFAULT '0' COMMENT '0 = Tidak ada di penerimaan\r\n1 = Sudah ada di penerimaan' AFTER is_permanent;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'103',
				'log_table'=>'data_kemasan',
				'log_column'=>'jenis_transaksi',
				'log_type'=>'add_data',
				'log_script'=>"
					INSERT INTO `data_kemasan` (`kemasan_id`, `kemasan_name`, `is_delete`, `is_permanent`) VALUES ('999', 'Pcs', '0', '0');
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'102',
				'log_table'=>'data_stok_log',
				'log_column'=>'jenis_transaksi',
				'log_type'=>'change_column',
				'log_script'=>"
					ALTER TABLE data_stok_log CHANGE jenis_transaksi jenis_transaksi INT(11) NOT NULL COMMENT '1 = penerimaan 2 = so out 3 = so in 4 = distribusi 5 = retur';
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'101',
				'log_table'=>'data_stok_log',
				'log_column'=>'batch',
				'log_type'=>'change_column',
				'log_script'=>"
					ALTER TABLE `data_stok_log` CHANGE `expired_date` `expired_date` VARCHAR(11) NULL DEFAULT NULL;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'100',
				'log_table'=>'data_stok_log',
				'log_column'=>'batch',
				'log_type'=>'change_column',
				'log_script'=>"
					ALTER TABLE `data_stok_log` CHANGE `batch` `batch` VARCHAR(11) NOT NULL;
				",
				'log_date'=>'2022-01-23',
			), 
			array(
				'log_id'=>'99',
				'log_table'=>'data_stok_log',
				'log_column'=>'jenis_transaksi',
				'log_type'=>'change_column',
				'log_script'=>"
					ALTER TABLE `data_stok_log` CHANGE `jenis_transaksi` `jenis_transaksi` INT(11) NOT NULL COMMENT '1 = penerimaan 2 = so out 3 = so in 4 = distribusi';
				",
				'log_date'=>'2022-01-23',
			), 
			array(
				'log_id'=>'98',
				'log_table'=>'data_stok',
				'log_column'=>'batch',
				'log_type'=>'change_column',
				'log_script'=>"
					ALTER TABLE `data_stok` CHANGE `batch` `batch` VARCHAR(11) NOT NULL;
				",
				'log_date'=>'2022-01-23',
			), 
			array(
				'log_id'=>'97',
				'log_table'=>'data_stok',
				'log_column'=>'id_kemasan',
				'log_type'=>'change_column',
				'log_script'=>"
					ALTER TABLE `data_stok` CHANGE `id_kemasan` `id_kemasan` VARCHAR(100) NULL DEFAULT NULL;
				",
				'log_date'=>'2022-01-23',
			), 
			array(
				'log_id'=>'96',
				'log_table'=>'data_layanan',
				'log_column'=>'layanan_poli_name',
				'log_type'=>'change_column',
				'log_script'=>"
					ALTER TABLE `data_layanan` CHANGE `layanan_poli_name` `layanan_poli_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL; 
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'95',
				'log_table'=>'data_stok_log',
				'log_column'=>'jenis_transaksi',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_obat` DROP PRIMARY KEY;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'94',
				'log_table'=>'data_stok_log',
				'log_column'=>'jenis_transaksi',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_stok_log CHANGE jenis_transaksi jenis_transaksi INT(11) NOT NULL COMMENT '1 = penerimaan 2 = so out 3 = so in 4 = distribusi 5 = retur';
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'93',
				'log_table'=>'data_penerimaan',
				'log_column'=>'retur_supplier',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE data_penerimaan ADD retur_supplier TINYINT NULL DEFAULT '0' COMMENT '0 = Retur NO\r\n1 = Retur YES' AFTER id_pemesanan, ADD tanggal_retur DATE NULL DEFAULT NULL AFTER retur_supplier;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'92',
				'log_table'=>'data_distribusi',
				'log_column'=>'id',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_distribusi` ADD `is_delete` TINYINT(2) NULL DEFAULT '0' AFTER `tujuan`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'91',
				'log_table'=>'data_distribusi_detail',
				'log_column'=>'id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_distribusi_detail` ( `id` INT NOT NULL AUTO_INCREMENT , `id_distribusi` INT NOT NULL , `id_stok` INT NOT NULL , `qty` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'90',
				'log_table'=>'data_so_detail',
				'log_column'=>'qty_sebelum',
				'log_type'=>'add_column',
				'log_script'=>"
					CREATE TABLE `data_distribusi` ( `id` INT NOT NULL AUTO_INCREMENT , `kode` VARCHAR(100) NOT NULL , `tanggal` DATE NOT NULL , `tujuan` ENUM('etalase','gudang') NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'89',
				'log_table'=>'data_so_detail',
				'log_column'=>'qty_sebelum',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_so_detail` ADD `qty_sebelum` INT NOT NULL AFTER `qty`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'88',
				'log_table'=>'data_so_detail',
				'log_column'=>'barcode',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_so_detail` DROP `barcode`, DROP `id_kemasan`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'87',
				'log_table'=>'data_so',
				'log_column'=>'create_at',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_so` ADD `create_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `penyimpanan`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'86',
				'log_table'=>'data_so_detail',
				'log_column'=>'is_obat',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_so_detail` ADD `is_obat` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'85',
				'log_table'=>'data_so_detail',
				'log_column'=>'is_delete',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_so_detail` ADD `is_delete` TINYINT(1) NOT NULL DEFAULT '0' AFTER `qty`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'84',
				'log_table'=>'data_so',
				'log_column'=>'kode_so',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_so` ADD `kode_so` VARCHAR(100) NULL DEFAULT NULL AFTER `so_id`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'83',
				'log_table'=>'data_so_detail',
				'log_column'=>'so_detail_id',
				'log_type'=>'add_column',
				'log_script'=>"
					CREATE TABLE `data_so_detail` ( 
					  `so_detail_id` INT NOT NULL AUTO_INCREMENT , 
					  `barcode` VARCHAR(255) NOT NULL , 
					  `id_kemasan` INT NOT NULL , 
					  `id_so` INT NOT NULL , 
					  `id_stok` INT NOT NULL , 
					  `qty` INT NOT NULL , PRIMARY KEY (`so_detail_id`)
					) ENGINE = MyISAM;

				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'82',
				'log_table'=>'data_so',
				'log_column'=>'so_id',
				'log_type'=>'add_column',
				'log_script'=>"
					CREATE TABLE `data_so` ( 
					  `so_id` INT NOT NULL AUTO_INCREMENT , 
					  `tanggal_so` DATE NOT NULL , 
					  `keterangan` TEXT NOT NULL , 
					  `penyimpanan` ENUM('etalase','gudang') NOT NULL , 
					  `is_delete` TINYINT(1) NOT NULL DEFAULT '0' , 
					  `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`so_id`)
					) ENGINE = MyISAM;

				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'81',
				'log_table'=>'data_inkaso',
				'log_column'=>'inkaso_id',
				'log_type'=>'add_column',
				'log_script'=>"
					CREATE TABLE `data_inkaso` ( 
					  `inkaso_id` INT(11) NOT NULL AUTO_INCREMENT , 
					  `tanggal` DATE NOT NULL , 
					  `cara_bayar` ENUM('tunai','bca') NOT NULL , 
					  `jumlah` DECIMAL(20,2) NOT NULL , 
					  `id_penerimaan` INT NOT NULL , 
					  PRIMARY KEY (`inkaso_id`)
					) ENGINE = MyISAM;

				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'80',
				'log_table'=>'data_detail_pemesanan',
				'log_column'=>'detail_pemesanan_id',
				'log_type'=>'add_column',
				'log_script'=>"
					CREATE TABLE `data_detail_pemesanan` (
					  `detail_pemesanan_id` int(11) NOT NULL AUTO_INCREMENT,
					  `detail_pemesanan_pemesanan_id` int(11) NOT NULL,
					  `detail_pemesanan_barcode` varchar(255) NOT NULL,
					  `detail_pemesanan_nama_barang` varchar(255) NOT NULL,
					  `detail_pemesanan_kemasan` varchar(255) NOT NULL,
					  `detail_pemesanan_qty` int(11) NOT NULL,
					  `is_obat` tinyint(4) NOT NULL DEFAULT '1',
					  PRIMARY KEY (`detail_pemesanan_id`),
					  KEY `detail_pemesanan_pemesanan_id` (`detail_pemesanan_pemesanan_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;

				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'79',
				'log_table'=>'data_pemesanan',
				'log_column'=>'pemesanan_id',
				'log_type'=>'add_column',
				'log_script'=>"
					CREATE TABLE `data_pemesanan` (
					  `pemesanan_id` int(11) NOT NULL AUTO_INCREMENT,
					  `pemesanan_no_sp` varchar(255) NOT NULL,
					  `pemesanan_jenis_sp` varchar(255) NOT NULL,
					  `pemesanan_tanggal` date NOT NULL,
					  `pemesanan_supplier_id` int(11) NOT NULL,
					  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
					  `is_permanent` tinyint(1) NOT NULL DEFAULT '0',
					  PRIMARY KEY (`pemesanan_id`),
					  KEY `pemesanan_supplier` (`pemesanan_supplier_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'78',
				'log_table'=>'data_penerimaan_obat',
				'log_column'=>'id_obat',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_alkes` ADD `alkes_kemasan` VARCHAR(100) NOT NULL AFTER `alkes_name`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'77',
				'log_table'=>'data_penerimaan_obat',
				'log_column'=>'id_obat',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_penerimaan_obat` ADD `id_obat` INT(11) NOT NULL AFTER `id_penerimaan`;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'76',
				'log_table'=>'data_penerimaan_obat',
				'log_column'=>'id',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_penerimaan_obat` CHANGE `id` `penerimaan_obat_id` INT(11) NOT NULL AUTO_INCREMENT;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'75',
				'log_table'=>'data_penerimaan_alkes',
				'log_column'=>'id',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_penerimaan_alkes` CHANGE `id` `penerimaan_alkes_id` INT(11) NOT NULL AUTO_INCREMENT;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'74',
				'log_table'=>'data_penerimaan',
				'log_column'=>'id',
				'log_type'=>'add_table',
				'log_script'=>"
					ALTER TABLE `data_penerimaan` CHANGE `id` `penerimaan_id` INT(11) NOT NULL AUTO_INCREMENT;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'73',
				'log_table'=>'data_penerimaan_alkes',
				'log_column'=>'id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_penerimaan_alkes` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `id_penerimaan` INT(11) NOT NULL , `id_alkes` INT(11) NOT NULL , `qty` INT(11) NOT NULL , `harga` DECIMAL(15.2) NOT NULL , `ppn` DECIMAL(15.2) NOT NULL , `diskon` DECIMAL(15.2) NOT NULL , `batch` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
				",
				'log_date'=>'2022-01-23',
			),
			array(
				'log_id'=>'72',
				'log_table'=>'data_penerimaan_obat',
				'log_column'=>'id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_penerimaan_obat` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `id_penerimaan` INT(11) NOT NULL , `id_kemasan` INT(11) NOT NULL , `qty` INT(11) NOT NULL , `harga` DECIMAL(15.2) NOT NULL , `ppn` DECIMAL(15.2) NOT NULL , `diskon` DECIMAL(15.2) NOT NULL , `expired_date` DATE NOT NULL , `batch` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
				",
				'log_date'=>'2022-01-23',
			),     
			array(
				'log_id'=>'71',
				'log_table'=>'data_penerimaan',
				'log_column'=>'id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_penerimaan` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `no_faktur` VARCHAR(100) NULL DEFAULT NULL , `tanggal_faktur` DATE NULL DEFAULT NULL , `jenis_penerimaan` ENUM('lunas','tempo') NULL DEFAULT NULL , `tanggal_tempo` DATE NULL DEFAULT NULL , `image_faktur` VARCHAR(100) NULL DEFAULT NULL , `penyimpanan` ENUM('gudang','etalase') NULL DEFAULT NULL , `total_harga` DECIMAL(15.2) NULL DEFAULT NULL , `diskon_perfaktur_rp` DECIMAL(15.2) NULL DEFAULT NULL , `diskon_perfaktur_persen` DECIMAL(15.2) NULL DEFAULT NULL , `total` DECIMAL(15.2) NULL DEFAULT NULL , `is_delete` TINYINT(1) NULL DEFAULT '0' , `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' , `id_pemesanan` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
				",
				'log_date'=>'2022-01-23',
			),    
			array(
				'log_id'=>'70',
				'log_table'=>'trx_pendaftaran',
				'log_column'=>'pendaftaran_pasien_birthplace',
				'log_type'=>'add_table',
				'log_script'=>"
					ALTER TABLE `trx_pendaftaran` CHANGE `pendaftaran_pasien_birthplace` `pendaftaran_pasien_birthplace` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_birthdate` `pendaftaran_pasien_birthdate` DATE NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_pernikahan` `pendaftaran_pasien_pernikahan` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_penanggung_jawab_name` `pendaftaran_pasien_penanggung_jawab_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_penanggung_jawab_telp` `pendaftaran_pasien_penanggung_jawab_telp` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_penanggung_jawab_pekerjaan` `pendaftaran_pasien_penanggung_jawab_pekerjaan` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'69',
				'log_table'=>'trx_pendaftaran',
				'log_column'=>'pendaftaran_pasien_birthplace',
				'log_type'=>'add_table',
				'log_script'=>"
					ALTER TABLE `trx_pendaftaran` CHANGE `pendaftaran_pasien_birthplace` `pendaftaran_pasien_birthplace` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_birthdate` `pendaftaran_pasien_birthdate` DATE NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_pernikahan` `pendaftaran_pasien_pernikahan` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_penanggung_jawab_name` `pendaftaran_pasien_penanggung_jawab_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_penanggung_jawab_telp` `pendaftaran_pasien_penanggung_jawab_telp` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `pendaftaran_pasien_penanggung_jawab_pekerjaan` `pendaftaran_pasien_penanggung_jawab_pekerjaan` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
				",
				'log_date'=>'2022-01-23',
			),      
			array(
				'log_id'=>'68',
				'log_table'=>'trx_pemeriksaan_obat_apotek',
				'log_column'=>'pemeriksaan_obat_is_obat',
				'log_type'=>'add_table',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_obat_apotek` ADD `pemeriksaan_obat_is_obat` INT NOT NULL DEFAULT '1' AFTER `pemeriksaan_obat_type`;
				",
				'log_date'=>'2022-01-23',
			),   
			array(
				'log_id'=>'67',
				'log_table'=>'data_stok_log',
				'log_column'=>'id_barang',
				'log_type'=>'add_table',
				'log_script'=>"
					ALTER TABLE `data_stok_log` ADD `id_barang` INT NOT NULL AFTER `barcode`;
				",
				'log_date'=>'2022-01-23',
			),    
			array(
				'log_id'=>'66',
				'log_table'=>'data_stok',
				'log_column'=>'id_barang',
				'log_type'=>'add_table',
				'log_script'=>"
					ALTER TABLE `data_stok` ADD `id_barang` INT NOT NULL AFTER `barcode`;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'65',
				'log_table'=>'data_stok',
				'log_column'=>'id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE IF NOT EXISTS `data_stok` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `barcode` varchar(255) NOT NULL,
					  `is_obat` tinyint(1) NOT NULL DEFAULT '1',
					  `id_kemasan` varchar(100) DEFAULT NULL,
					  `qty` int(11) NOT NULL,
					  `expired_date` date DEFAULT NULL,
					  `batch` varchar(11) NOT NULL,
					  `harga_satuan` decimal(20,0) NOT NULL,
					  `penyimpanan` enum('etalase','gudang') NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'64',
				'log_table'=>'data_stok_log',
				'log_column'=>'id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE IF NOT EXISTS `data_stok_log` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `barcode` int(11) NOT NULL,
					  `is_obat` int(11) NOT NULL,
					  `id_kemasan` int(11) NOT NULL,
					  `qty` int(11) NOT NULL,
					  `expired_date` varchar(11) DEFAULT NULL,
					  `batch` varchar(11) NOT NULL,
					  `jenis_transaksi` int(11) NOT NULL COMMENT '1 = penerimaan 2 = so out 3 = so in 4 = distribusi 5 = retur',
					  `id_penerimaan_obat` int(11) DEFAULT NULL,
					  `id_penerimaan_alkes` int(11) DEFAULT NULL,
					  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				",
				'log_date'=>'2022-01-23',
			),     
			array(
				'log_id'=>'63',
				'log_table'=>'trx_pemeriksaan_kasir_log',
				'log_column'=>'log_id',
				'log_type'=>'add_data',
				'log_script'=>"
					CREATE TABLE `trx_pemeriksaan_kasir_log` (
					 `log_id` int(11) NOT NULL AUTO_INCREMENT,
					 `log_kasir_id` int(11) NOT NULL,
					 `log_date` datetime NOT NULL,
					 `log_tipe_bayar` varchar(255) DEFAULT NULL,
					 `log_tipe_bayar_value` decimal(15,2) NOT NULL DEFAULT 0.00,
					 `log_bayar_cash` decimal(15,2) NOT NULL,
					 `log_bayar_kembalian` int(11) NOT NULL,
					 `log_input_by` varchar(255) NOT NULL,
					 `log_is_delete` tinyint(1) NOT NULL DEFAULT 0,
					 PRIMARY KEY (`log_id`),
					 KEY `log_kasir_id` (`log_kasir_id`,`log_date`,`log_tipe_bayar`,`log_is_delete`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-01-23',
			),     
			array(
				'log_id'=>'62',
				'log_table'=>'data_bank',
				'log_column'=>'bank_id',
				'log_type'=>'add_data',
				'log_script'=>"
					INSERT INTO `data_bank` (`bank_id`, `bank_name`, `bank_keterangan`, `is_delete`, `is_permanent`, `last_update`, `last_user_id`) VALUES (NULL, 'Cash/Tunai', NULL, '0', '0', NULL, NULL), (NULL, 'Debit BCA', NULL, '0', '0', NULL, NULL)
				",
				'log_date'=>'2022-01-23',
			),     
			array(
				'log_id'=>'61',
				'log_table'=>'data_bank',
				'log_column'=>'bank_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_bank` (
					 `bank_id` int(11) NOT NULL AUTO_INCREMENT,
					 `bank_name` varchar(200) NOT NULL,
					 `bank_keterangan` varchar(255) DEFAULT NULL,
					 `is_delete` tinyint(1) NOT NULL DEFAULT 0,
					 `is_permanent` tinyint(1) NOT NULL DEFAULT 0,
					 `last_update` datetime DEFAULT NULL,
					 `last_user_id` int(11) DEFAULT NULL,
					 PRIMARY KEY (`bank_id`),
					 KEY `spending_name` (`bank_name`,`is_delete`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8
				",
				'log_date'=>'2022-01-23',
			),     
			array(
				'log_id'=>'60',
				'log_table'=>'trx_pemeriksaan_obat_apotek',
				'log_column'=>'pemeriksaan_obat_dosis',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_obat_apotek`  ADD `pemeriksaan_obat_dosis` VARCHAR(250) NOT NULL  AFTER `pemeriksaan_obat_price`;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'59',
				'log_table'=>'trx_pemeriksaan_kasir',
				'log_column'=>'kasir_input_date',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_kasir` ADD `kasir_input_date` DATETIME NOT NULL AFTER `kasir_status`, ADD `kasir_last_update` DATETIME NULL DEFAULT NULL AFTER `kasir_input_date`, ADD `kasir_update_by` VARCHAR(255) NULL DEFAULT NULL AFTER `kasir_last_update`;
				",
				'log_date'=>'2022-01-23',
			), 
			array(
				'log_id'=>'58',
				'log_table'=>'trx_pemeriksaan_kasir',
				'log_column'=>'kasir_date',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_kasir` ADD `kasir_date` DATE NOT NULL AFTER `kasir_invoice`;
				",
				'log_date'=>'2022-01-23',
			), 
			array(
				'log_id'=>'57',
				'log_table'=>'trx_pemeriksaan_kasir',
				'log_column'=>'kasir_disc',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_kasir` ADD `kasir_disc` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `kasir_embalage`;
				",
				'log_date'=>'2022-01-23',
			), 
			array(
				'log_id'=>'56',
				'log_table'=>'trx_pemeriksaan_kasir',
				'log_column'=>'kasir_layanan_price',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_kasir` ADD `kasir_layanan_price` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `kasir_grandtotal`, ADD `kasir_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `kasir_layanan_price`;
				",
				'log_date'=>'2022-01-23',
			), 
			array(
				'log_id'=>'55',
				'log_table'=>'trx_pendaftaran_layanan',
				'log_column'=>'pendaftaran_layanan_price',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pendaftaran_layanan` ADD `pendaftaran_layanan_price` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `pendaftaran_layanan_hasil`;
				",
				'log_date'=>'2022-01-23',
			),    
			array(
				'log_id'=>'54',
				'log_table'=>'trx_pemeriksaan',
				'log_column'=>'pemeriksaan_apotek_disc',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan` ADD `pemeriksaan_apotek_disc` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `pemeriksaan_apotek_embalage`;
				",
				'log_date'=>'2022-01-23',
			),   
			array(
				'log_id'=>'53',
				'log_table'=>'trx_pemeriksaan_kasir',
				'log_column'=>'kasir_id',
				'log_type'=>'add_column',
				'log_script'=>"
					CREATE TABLE `trx_pemeriksaan_kasir` (
					 `kasir_id` int(11) NOT NULL AUTO_INCREMENT,
					 `kasir_invoice` varchar(100) NOT NULL,
					 `kasir_pemeriksaan_id` int(11) NOT NULL,
					 `kasir_pendaftaran_id` int(11) NOT NULL,
					 `kasir_pasien_id` int(11) NOT NULL,
					 `kasir_subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
					 `kasir_tuslah` decimal(15,2) NOT NULL DEFAULT 0.00,
					 `kasir_embalage` decimal(15,2) NOT NULL DEFAULT 0.00,
					 `kasir_disc_rupiah` decimal(15,2) NOT NULL DEFAULT 0.00,
					 `kasir_disc_persen` float NOT NULL,
					 `kasir_grandtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
					 `kasir_tipe_bayar` varchar(255) NOT NULL DEFAULT 'Cash',
					 `kasir_bayar` decimal(15,2) NOT NULL,
					 `kasir_cash` decimal(15,2) NOT NULL,
					 `kasir_status` varchar(100) NOT NULL DEFAULT 'Belum Lunas',
					 PRIMARY KEY (`kasir_id`),
					 KEY `kasir_pemeriksaan_id` (`kasir_pemeriksaan_id`,`kasir_pendaftaran_id`,`kasir_pasien_id`,`kasir_subtotal`,`kasir_grandtotal`,`kasir_status`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-01-23',
			),   
			array(
				'log_id'=>'52',
				'log_table'=>'trx_pemeriksaan_diagnosis',
				'log_column'=>'pemeriksaan_diagnosis_price',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_diagnosis` ADD `pemeriksaan_diagnosis_price` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `pemeriksaan_diagnosis_name`;
				",
				'log_date'=>'2022-01-23',
			),   
			array(
				'log_id'=>'51',
				'log_table'=>'trx_pemeriksaan',
				'log_column'=>'pemeriksaan_apotek_subtotal',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan` ADD `pemeriksaan_apotek_subtotal` DECIMAL(15,2) NOT NULL DEFAULT '0.00', ADD `pemeriksaan_apotek_tuslah` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `pemeriksaan_apotek_subtotal`, ADD `pemeriksaan_apotek_embalage` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `pemeriksaan_apotek_tuslah`, ADD `pemeriksaan_apotek_disc_rupiah` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `pemeriksaan_apotek_embalage`, ADD `pemeriksaan_apotek_disc_persen` FLOAT NOT NULL DEFAULT '0' AFTER `pemeriksaan_apotek_disc_rupiah`, ADD `pemeriksaan_apotek_total` DECIMAL(15,2) NOT NULL DEFAULT '0.00' AFTER `pemeriksaan_apotek_disc_persen`;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'50',
				'log_table'=>'trx_pemeriksaan_obat',
				'log_column'=>'pemeriksaan_obat_pemeriksaan_id',
				'log_type'=>'add_column',
				'log_script'=>"
					CREATE TABLE `trx_pemeriksaan_obat_apotek` (
					 `pemeriksaan_obat_id` int(11) NOT NULL AUTO_INCREMENT,
					 `pemeriksaan_obat_pemeriksaan_id` bigint(20) NOT NULL,
					 `pemeriksaan_obat_obat_id` int(11) NOT NULL,
					 `pemeriksaan_obat_type` varchar(50) NOT NULL,
					 `pemeriksaan_obat_resep` varchar(50) NOT NULL,
					 `pemeriksaan_obat_name` varchar(255) NOT NULL,
					 `pemeriksaan_obat_kemasan_id` int(11) NOT NULL,
					 `pemeriksaan_obat_kemasan_name` varchar(255) NOT NULL,
					 `pemeriksaan_obat_qty` int(11) NOT NULL,
					 `pemeriksaan_obat_price` decimal(15,2) NOT NULL,
					 `pemeriksaan_obat_aturan_pakai` varchar(100) NOT NULL,
					 PRIMARY KEY (`pemeriksaan_obat_id`),
					 KEY `pemeriksaan_obat_id` (`pemeriksaan_obat_name`),
					 KEY `pemeriksaan_obat_pemeriksaan_id` (`pemeriksaan_obat_pemeriksaan_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-01-23',
			),   
			
			array(
				'log_id'=>'49',
				'log_table'=>'trx_pemeriksaan_obat',
				'log_column'=>'pemeriksaan_obat_pemeriksaan_id',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_obat` ADD `pemeriksaan_obat_pemeriksaan_id` BIGINT NOT NULL FIRST, ADD INDEX (`pemeriksaan_obat_pemeriksaan_id`);
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'48',
				'log_table'=>'trx_pemeriksaan_obat',
				'log_column'=>'pemeriksaan_obat_kemasan_name',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_obat` ADD `pemeriksaan_obat_kemasan_name` VARCHAR(255) NOT NULL AFTER `pemeriksaan_obat_kemasan_id`;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'47',
				'log_table'=>'trx_pemeriksaan_obat',
				'log_column'=>'pemeriksaan_obat_kemasan_id',
				'log_type'=>'delete_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_obat` ADD `pemeriksaan_obat_kemasan_id` INT NOT NULL AFTER `pemeriksaan_obat_name`;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'46',
				'log_table'=>'trx_pemeriksaan_obat',
				'log_column'=>'pemeriksaan_obat_resep',
				'log_type'=>'delete_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_obat` ADD `pemeriksaan_obat_resep` VARCHAR(50) NULL DEFAULT NULL;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'45',
				'log_table'=>'trx_pemeriksaan_obat',
				'log_column'=>'pemeriksaan_obat_pemeriksaan_id',
				'log_type'=>'delete_column',
				'log_script'=>"
					ALTER TABLE `trx_pemeriksaan_obat` DROP `pemeriksaan_obat_pemeriksaan_id`;
				",
				'log_date'=>'2021-01-23',
			),  
			array(
				'log_id'=>'44',
				'log_table'=>'data_diagnosa',
				'log_column'=>'diagnosa_id',
				'log_type'=>'add_data',
				'log_script'=>"
					select 1
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'43',
				'log_table'=>'data_diagnosa',
				'log_column'=>'diagnosa_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE IF NOT EXISTS `data_diagnosa` (
					  `diagnosa_id` int(11) NOT NULL AUTO_INCREMENT,
					  `diagnosa_icdx` varchar(20) NOT NULL,
					  `diagnosa_name` varchar(255) NOT NULL,
					  `diagnosa_deskripsi` text NOT NULL,
					  PRIMARY KEY (`diagnosa_id`),
					  KEY `diagnosa_icdx` (`diagnosa_icdx`,`diagnosa_name`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				",
				'log_date'=>'2022-01-23',
			),  
			array(
				'log_id'=>'42',
				'log_table'=>'trx_pendaftaran_layanan',
				'log_column'=>'pendaftaran_layanan_hasil',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pendaftaran_layanan` ADD `pendaftaran_layanan_hasil` TEXT NULL DEFAULT NULL AFTER `pendaftaran_layanan_pemeriksaan_name`;
				",
				'log_date'=>'2022-01-16',
			), 
			array(
				'log_id'=>'41',
				'log_table'=>'trx_pemeriksaan_obat',
				'log_column'=>'pemeriksaan_obat_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `trx_pemeriksaan_obat` (
					 `pemeriksaan_obat_id` bigint(20) NOT NULL AUTO_INCREMENT,
					 `pemeriksaan_obat_pemeriksaan_id` bigint(20) NOT NULL,
					 `pemeriksaan_obat_name` varchar(255) NOT NULL,
					 `pemeriksaan_obat_qty` int(11) NOT NULL,
					 `pemeriksaan_obat_dosis` float NOT NULL,
					 `pemeriksaan_obat_aturan_pakai` varchar(100) NOT NULL,
					 PRIMARY KEY (`pemeriksaan_obat_id`),
					 KEY `pemeriksaan_obat_id` (`pemeriksaan_obat_id`,`pemeriksaan_obat_pemeriksaan_id`,`pemeriksaan_obat_name`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-01-16',
			), 
			array(
				'log_id'=>'40',
				'log_table'=>'trx_pemeriksaan_diagnosis',
				'log_column'=>'pemeriksaan_diagnosis_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `trx_pemeriksaan_diagnosis` (
					 `pemeriksaan_diagnosis_id` int(11) NOT NULL,
					 `pemeriksaan_diagnosis_pemeriksaan_id` int(11) NOT NULL,
					 `pemeriksaan_diagnosis_name` VARCHAR(255) NOT NULL,
					 KEY `pemeriksaan_diagnosis_id` (`pemeriksaan_diagnosis_id`,`pemeriksaan_diagnosis_pemeriksaan_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-01-16',
			),  
			array(
				'log_id'=>'39',
				'log_table'=>'trx_pemeriksaan',
				'log_column'=>'pemeriksaan_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `trx_pemeriksaan` (
					 `pemeriksaan_id` bigint(20) NOT NULL AUTO_INCREMENT,
					 `pemeriksaan_date` datetime NOT NULL,
					 `pemeriksaan_pendaftaran_id` int(11) NOT NULL,
					 `pemeriksaan_pasien_id` int(11) NOT NULL,
					 `pemeriksaan_alergi` text DEFAULT NULL,
					 `pemeriksaan_weight` float DEFAULT NULL,
					 `pemeriksaan_height` float DEFAULT NULL,
					 `pemeriksaan_tension` float DEFAULT NULL,
					 `pemeriksaan_respiration` float DEFAULT NULL,
					 `pemeriksaan_nadi` float DEFAULT NULL,
					 `pemeriksaan_suhu` float DEFAULT NULL,
					 `pemeriksaan_anamnesis` text DEFAULT NULL,
					 `pemeriksaan_pemeriksaan` text DEFAULT NULL,
					 `pemeriksaan_status` varchar(100) NOT NULL DEFAULT 'belum' COMMENT 'belum,sudah, laboratorium',
					 `pemeriksaan_insert_date` datetime NOT NULL,
					 `pemeriksaan_insert_by` int(11) NOT NULL,
					 `pemeriksaan_update_date` datetime DEFAULT NULL,
					 `pemeriksaan_update_by` int(11) DEFAULT NULL,
					 PRIMARY KEY (`pemeriksaan_id`),
					 UNIQUE KEY `pemeriksaan_date` (`pemeriksaan_date`,`pemeriksaan_pendaftaran_id`,`pemeriksaan_pasien_id`,`pemeriksaan_status`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2022-01-16',
			),  
			array(
				'log_id'=>'38',
				'log_table'=>'data_obat',
				'log_column'=>'user_id',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_obat` ADD `user_id` INT NULL DEFAULT NULL AFTER `obat_kemasan_besar_konversi`; 
				",
				'log_date'=>'2021-12-18',
			), 
			array(
				'log_id'=>'37',
				'log_table'=>'data_alkes',
				'log_column'=>'is_permanent',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_alkes` ADD `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`;										
				",
				'log_date'=>'2021-12-18',
			), 
			array(
				'log_id'=>'36',
				'log_table'=>'data_alkes',
				'log_column'=>'alkes_is_delete',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_alkes` CHANGE `alkes_is_delete` `is_delete` TINYINT(1) NOT NULL DEFAULT '0';
										
				",
				'log_date'=>'2021-12-18',
			),   
			array(
				'log_id'=>'35',
				'log_table'=>'data_obat',
				'log_column'=>'is_permanent',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_obat` ADD `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`; 										
				",
				'log_date'=>'2021-12-18',
			),   
			array(
				'log_id'=>'34',
				'log_table'=>'data_obat',
				'log_column'=>'obat_is_delete',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_obat` CHANGE `obat_is_delete` `is_delete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=delete semu'; 										
				",
				'log_date'=>'2021-12-18',
			),   
			array(
				'log_id'=>'33',
				'log_table'=>'data_layanan',
				'log_column'=>'layanan_poli_name',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_layanan` CHANGE `layanan_poli_name` `layanan_poli_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL; 										
				",
				'log_date'=>'2021-12-18',
			), 
			array(
				'log_id'=>'32',
				'log_table'=>'data_layanan',
				'log_column'=>'layanan_poli_name',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_layanan` CHANGE `layanan_poli_name` `layanan_poli_name` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL; 										
				",
				'log_date'=>'2021-12-18',
			),  
			array(
				'log_id'=>'31',
				'log_table'=>'data_layanan',
				'log_column'=>'is_permanent',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_layanan` ADD `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`; 										
				",
				'log_date'=>'2021-12-18',
			),  
			array(
				'log_id'=>'30',
				'log_table'=>'data_layanan',
				'log_column'=>'layanan_is_delete',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_layanan` CHANGE `layanan_is_delete` `is_delete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=delete semu';										
				",
				'log_date'=>'2021-12-18',
			),     
			array(
				'log_id'=>'29',
				'log_table'=>'data_dosis',
				'log_column'=>'is_permanent',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_dosis` ADD `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`; 										
				",
				'log_date'=>'2021-12-18',
			),   
			array(
				'log_id'=>'28',
				'log_table'=>'data_dosis',
				'log_column'=>'dosis_is_delete',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_dosis` CHANGE `dosis_is_delete` `is_delete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=delete semu'; 										
				",
				'log_date'=>'2021-12-18',
			),    
			array(
				'log_id'=>'27',
				'log_table'=>'data_kemasan',
				'log_column'=>'is_permanent',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_kemasan` ADD `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`; 										
				",
				'log_date'=>'2021-12-18',
			),  
			array(
				'log_id'=>'26',
				'log_table'=>'data_kemasan',
				'log_column'=>'kemasan_is_delete',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_kemasan` CHANGE `kemasan_is_delete` `is_delete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=delete semu'; 					
				",
				'log_date'=>'2021-12-18',
			),     
			array(
				'log_id'=>'25',
				'log_table'=>'data_supplier',
				'log_column'=>'supplier_sales_name',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_supplier` ADD `supplier_sales_name` VARCHAR(200) NOT NULL AFTER `supplier_phone`, ADD `supplier_sales_phone` VARCHAR(200) NOT NULL AFTER `supplier_sales_name`; 					
				",
				'log_date'=>'2021-12-18',
			),   
			array(
				'log_id'=>'24',
				'log_table'=>'data_supplier',
				'log_column'=>'is_permanent',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_supplier` ADD `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`; 
				",
				'log_date'=>'2021-12-18',
			),  
			array(
				'log_id'=>'23',
				'log_table'=>'data_jadwal',
				'log_column'=>'jadwal_poli',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_supplier` ADD `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`; 
					
				",
				'log_date'=>'2021-12-18',
			),  
			array(
				'log_id'=>'22',
				'log_table'=>'data_supplier',
				'log_column'=>'supplier_is_delete',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_supplier` CHANGE `supplier_is_delete` `is_delete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=delete semu'; 
				",
				'log_date'=>'2021-12-18',
			),  
			array(
				'log_id'=>'21',
				'log_table'=>'data_poli',
				'log_column'=>'is_permanent',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_poli` ADD `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`;
					
				",
				'log_date'=>'2021-12-18',
			), 
			array(
				'log_id'=>'20',
				'log_table'=>'data_jadwal',
				'log_column'=>'jadwal_poli',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_poli` CHANGE `poli_is_delete` `is_delete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=delete semu';
					
				",
				'log_date'=>'2021-12-18',
			), 
			array(
				'log_id'=>'19',
				'log_table'=>'data_penjamin',
				'log_column'=>'is_permanent',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_penjamin` ADD `is_permanent` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_delete`;
				",
				'log_date'=>'2021-12-18',
			),  
			array(
				'log_id'=>'18',
				'log_table'=>'data_penjamin',
				'log_column'=>'penjamin_is_delete',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_penjamin` CHANGE `penjamin_is_delete` `is_delete` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=delete semu';				
				",	
				'log_date'=>'2021-12-18',
			),  
			array(
				'log_id'=>'17',
				'log_table'=>'data_jadwal',
				'log_column'=>'jadwal_poli',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `data_jadwal` ADD `jadwal_poli` VARCHAR(50) NOT NULL DEFAULT '-' AFTER `jadwal_date`;
				",
				'log_date'=>'2021-12-18',
			), 
			array(
				'log_id'=>'16',
				'log_table'=>'trx_pendaftaran',
				'log_column'=>'pendaftaran_is_delete',
				'log_type'=>'add_column',
				'log_script'=>"
					ALTER TABLE `trx_pendaftaran` ADD `pendaftaran_is_delete` TINYINT(1) NOT NULL DEFAULT '0' AFTER `pendaftaran_pasien_penanggung_jawab_pekerjaan`;
				",
				'log_date'=>'2021-12-18',
			),  
			array(
				'log_id'=>'15',
				'log_table'=>'data_jadwal',
				'log_column'=>'jadwal_id',
				'log_type'=>'add_data',
				'log_script'=>"
					CREATE TABLE `data_jadwal` (
					 `jadwal_id` int(11) NOT NULL AUTO_INCREMENT,
					 `jadwal_date` date NOT NULL,
					 `jadwal_shift_id` int(11) NOT NULL,
					 `jadwal_shift_name` varchar(255) NOT NULL,
					 `jadwal_dokter_id` int(11) NOT NULL,
					 `jadwal_dokter_name` varchar(255) NOT NULL,
					 `jadwal_perawat_id` int(11) NOT NULL,
					 `jadwal_perawat_name` varchar(255) NOT NULL,
					 PRIMARY KEY (`jadwal_id`),
					 KEY `jadwal_date` (`jadwal_date`,`jadwal_shift_id`,`jadwal_dokter_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
					
				",
				'log_date'=>'2021-12-18',
			), 
			array(
				'log_id'=>'14',
				'log_table'=>'data_pasien_kategori',
				'log_column'=>'pasien_kategori_id',
				'log_type'=>'add_data',
				'log_script'=>"
					INSERT INTO `data_pasien_kategori` (`pasien_kategori_id`, `pasien_kategori_par_id`, `pasien_kategori_name`) VALUES
					(1, 0, 'BPJS'),
					(2, 0, 'Asuransi'),
					(3, 0, 'Umum'),
					(4, 0, 'SKD'),
					(5, 0, 'Gratis'),
					(6, 1, 'Berobat'),
					(7, 1, 'Pronalis'),
					(8, 1, 'Rujukan'),
					(9, 2, 'Berobat'),
					(10, 2, 'Rujukan'),
					(11, 3, 'Berobat'),
					(12, 3, 'Rujukan'),
					(13, 5, 'Umum'),
					(14, 5, 'Karyawan'),
					(15, 5, 'Relasi/Keluarga');
					
				",
				'log_date'=>'2021-12-14',
			), 
			array(
				'log_id'=>'13',
				'log_table'=>'data_pasien_kategori',
				'log_column'=>'pasien_kategori_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_pasien_kategori` (
					 `pasien_kategori_id` int(11) NOT NULL AUTO_INCREMENT,
					 `pasien_kategori_par_id` int(11) NOT NULL,
					 `pasien_kategori_name` varchar(255) NOT NULL,
					 PRIMARY KEY (`pasien_kategori_id`),
					 KEY `pasien_kategori_par_id` (`pasien_kategori_par_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
					
				",
				'log_date'=>'2021-12-14',
			),    
			array(
				'log_id'=>'12',
				'log_table'=>'trx_pendaftaran_layanan',
				'log_column'=>'pendaftaran_layanan_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `trx_pendaftaran_layanan` (
				 `pendaftaran_layanan_id` int(11) NOT NULL AUTO_INCREMENT,
				 `pendaftaran_layanan_pendaftaran_id` int(11) NOT NULL,
				 `pendaftaran_layanan_layanan_id` int(11) NOT NULL,
				 `pendaftaran_layanan_layanan_name` varchar(255) DEFAULT NULL,
				 `pendaftaran_layanan_dokter_id` int(11) DEFAULT NULL,
				 `pendaftaran_layanan_dokter_name` varchar(255) DEFAULT NULL,
				 `pendaftaran_layanan_perawat_id` int(11) DEFAULT NULL,
				 `pendaftaran_layanan_perawat_name` varchar(255) DEFAULT NULL,
				 `pendaftaran_layanan_pemeriksaan_id` int(11) DEFAULT NULL,
				 `pendaftaran_layanan_pemeriksaan_name` varchar(255) DEFAULT NULL,
				 PRIMARY KEY (`pendaftaran_layanan_id`),
				 KEY `pendaftaran_layanan_pendaftaran_id` (`pendaftaran_layanan_pendaftaran_id`,`pendaftaran_layanan_layanan_id`,`pendaftaran_layanan_dokter_id`,`pendaftaran_layanan_perawat_id`,`pendaftaran_layanan_pemeriksaan_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-14',
			),    
			array(
				'log_id'=>'11',
				'log_table'=>'data_pasien',
				'log_column'=>'pasien_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `trx_pendaftaran` (
					 `pendaftaran_id` bigint(20) NOT NULL AUTO_INCREMENT,
					 `pendaftaran_date` datetime NOT NULL,
					 `pendaftaran_no` varchar(50) NOT NULL,
					 `pendaftaran_pasien_id` int(11) NOT NULL,
					 `pendaftaran_pasien_name` varchar(255) NOT NULL,
					 `pendaftaran_pasien_rm` varchar(100) NOT NULL,
					 `pendaftaran_status` varchar(20) NOT NULL DEFAULT 'pending',
					 `pendaftaran_kategori_id` int(11) NOT NULL,
					 `pendaftaran_kategori_name` varchar(255) NOT NULL,
					 `pendaftaran_kategori_sub_id` int(11) NOT NULL,
					 `pendaftaran_kategori_sub_name` varchar(255) NOT NULL,
					 `pendaftaran_penjamin_id` int(11) NOT NULL,
					 `pendaftaran_penjamin_nama` varchar(255) NOT NULL,
					 `pendaftaran_penjamin_no` varchar(100) NOT NULL,
					 `pendaftaran_pasien_nik` varchar(30) DEFAULT NULL,
					 `pendaftaran_pasien_ibu` varchar(255) DEFAULT NULL,
					 `pendaftaran_pasien_address` text DEFAULT NULL,
					 `pendaftaran_pasien_gender` varchar(50) DEFAULT NULL,
					 `pendaftaran_pasien_birthplace` varchar(255) NOT NULL,
					 `pendaftaran_pasien_birthdate` date NOT NULL,
					 `pendaftaran_pasien_pernikahan` varchar(50) NOT NULL,
					 `pendaftaran_pasien_penanggung_jawab_name` varchar(255) NOT NULL,
					 `pendaftaran_pasien_penanggung_jawab_telp` varchar(50) NOT NULL,
					 `pendaftaran_pasien_penanggung_jawab_pekerjaan` varchar(100) NOT NULL,
					 PRIMARY KEY (`pendaftaran_id`),
					 KEY `pendaftaran_date` (`pendaftaran_date`,pendaftaran_status,pendaftaran_no,`pendaftaran_pasien_id`,`pendaftaran_pasien_rm`,`pendaftaran_kategori_id`,`pendaftaran_kategori_sub_id`,`pendaftaran_penjamin_no`,`pendaftaran_pasien_nik`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-14',
			),  
			array(
				'log_id'=>'10',
				'log_table'=>'data_pasien',
				'log_column'=>'pasien_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_pasien` (
					 `pasien_id` int(11) NOT NULL AUTO_INCREMENT,
					 `pasien_name` varchar(255) NOT NULL,
					 `pasien_rm` varchar(100) NOT NULL,
					 `pasien_nik` varchar(30) NOT NULL,
					 `pasien_penjamin_id` int(11) DEFAULT NULL,
					 `pasien_penjamin_name` varchar(255) DEFAULT NULL,
					 `pasien_penjamin_no` varchar(100) DEFAULT NULL,
					 `pasien_ibu` varchar(255) DEFAULT NULL,
					 `pasien_address` text DEFAULT NULL,
					 `pasien_gender` varchar(50) DEFAULT NULL,
					 `pasien_birthplace` varchar(255) DEFAULT NULL,
					 `pasien_birthdate` date DEFAULT NULL,
					 `pasien_pernikahan` varchar(50) NOT NULL,
					 PRIMARY KEY (`pasien_id`),
					 KEY `pasien_name` (`pasien_name`,`pasien_rm`,`pasien_nik`,`pasien_penjamin_id`,`pasien_penjamin_name`,`pasien_penjamin_no`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-14',
			),  
			array(
				'log_id'=>'9',
				'log_table'=>'data_alkes',
				'log_column'=>'alkes_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_alkes` (
					 `alkes_id` int(11) NOT NULL AUTO_INCREMENT,
					 `alkes_name` varchar(255) NOT NULL,
					 `alkes_barcode` varchar(200) NOT NULL,
					 `alkes_price` decimal(15,2) NOT NULL,
					 `alkes_margin` decimal(15,2) NOT NULL,
					 `alkes_price_sale` decimal(15,2) NOT NULL,
					 `alkes_is_delete` tinyint(1) NOT NULL DEFAULT 0,
					 PRIMARY KEY (`alkes_id`),
					 KEY `alkes_name` (`alkes_name`,`alkes_price_sale`,`alkes_is_delete`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-09',
			),  
			array(
				'log_id'=>'8',
				'log_table'=>'data_obat',
				'log_column'=>'obat_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_obat` (
					 `obat_id` int(11) NOT NULL AUTO_INCREMENT,
					 `obat_barcode` varchar(255) NOT NULL,
					 `obat_name` varchar(255) NOT NULL,
					 `obat_type` enum('generic','non_generic') NOT NULL DEFAULT 'generic',
					 `obat_dosis_value` float NOT NULL,
					 `obat_dosis_id` int(11) NOT NULL,
					 `obat_price` decimal(15,2) NOT NULL,
					 `obat_margin_resep` decimal(15,2) NOT NULL,
					 `obat_margin_non_resep` decimal(15,2) NOT NULL,
					 `obat_price_resep` decimal(15,2) NOT NULL,
					 `obat_price_non_resep` decimal(15,2) NOT NULL,
					 `obat_kemasan_kecil_id` int(11) NOT NULL,
					 `obat_kemasan_kecil_konversi` int(11) NOT NULL,
					 `obat_kemasan_sedang_id` int(11) NOT NULL,
					 `obat_kemasan_sedang_konversi` int(11) NOT NULL,
					 `obat_kemasan_besar_id` int(11) NOT NULL,
					 `obat_kemasan_besar_konversi` int(11) NOT NULL,
					 `obat_is_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=delete semu',
					 PRIMARY KEY (`obat_id`),
					 KEY `obat_barcode` (`obat_is_delete`,`obat_barcode`,`obat_name`,`obat_type`,`obat_dosis_id`,`obat_kemasan_kecil_id`,`obat_kemasan_sedang_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-09',
			),
			array(
				'log_id'=>'7',
				'log_table'=>'data_dosis',
				'log_column'=>'dosis_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_dosis` (
					`dosis_id` int(11) NOT NULL AUTO_INCREMENT,
					`dosis_name` varchar(255) NOT NULL,
					`dosis_is_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=delete semu',
					PRIMARY KEY (`dosis_id`),
					KEY `dosis_name` (`dosis_name`,`dosis_is_delete`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-09',
			),    
			array(
				'log_id'=>'6',
				'log_table'=>'data_supplier',
				'log_column'=>'supplier_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_supplier` (
					 `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
					 `supplier_name` varchar(255) NOT NULL,
					 `supplier_address` text NOT NULL,
					 `supplier_phone` varchar(200) NOT NULL,
					 `supplier_is_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=delete semu',
					 PRIMARY KEY (`supplier_id`),
					 KEY `supplier_name` (`supplier_name`,`supplier_is_delete`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1

				",
				'log_date'=>'2021-12-09',
			),   
			array(
				'log_id'=>'5',
				'log_table'=>'data_layanan',
				'log_column'=>'layanan_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_layanan` (
					 `layanan_id` int(11) NOT NULL AUTO_INCREMENT,
					 `layanan_poli_id` int(11) NOT NULL,
					 `layanan_poli_name` varchar(255) NOT NULL,
					 `layanan_name` varchar(255) NOT NULL,
					 `layanan_tarif` decimal(15,2) NOT NULL DEFAULT 0.00,
					 `layanan_bph` decimal(15,2) NOT NULL DEFAULT 0.00,
					 `layanan_total` decimal(15,2) NOT NULL DEFAULT 0.00,
					 `layanan_is_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=delete semu',
					 PRIMARY KEY (`layanan_id`),
					 KEY `layanan_poli_id` (`layanan_poli_id`,`layanan_poli_name`,`layanan_name`,`layanan_tarif`,`layanan_bph`,`layanan_total`,`layanan_is_delete`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-09',
			),   
			array(
				'log_id'=>'4',
				'log_table'=>'data_kemasan',
				'log_column'=>'kemasan_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_kemasan` (
					`kemasan_id` int(11) NOT NULL AUTO_INCREMENT,
					`kemasan_name` varchar(255) NOT NULL,
					`kemasan_is_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=delete semu',
					PRIMARY KEY (`kemasan_id`),
					KEY `kemasan_name` (`kemasan_name`,`kemasan_is_delete`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-09',
			), 
			array(
				'log_id'=>'3',
				'log_table'=>'data_poli',
				'log_column'=>'poli_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_poli` (
					`poli_id` int(11) NOT NULL AUTO_INCREMENT,
					`poli_name` varchar(255) NOT NULL,
					`poli_is_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=delete semu',
					PRIMARY KEY (`poli_id`),
					KEY `poli_name` (`poli_name`,`poli_is_delete`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-09',
			),
			array(
				'log_id'=>'2',
				'log_table'=>'data_penjamin',
				'log_column'=>'penjamin_id',
				'log_type'=>'add_table',
				'log_script'=>"
					CREATE TABLE `data_penjamin` (
						 `penjamin_id` int(11) NOT NULL AUTO_INCREMENT,
						 `penjamin_name` varchar(255) NOT NULL,
						 `penjamin_is_delete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1=delete semu',
						 PRIMARY KEY (`penjamin_id`),
						 KEY `penjamin_name` (`penjamin_name`,`penjamin_is_delete`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1
				",
				'log_date'=>'2021-12-09',
			),
			array(
				'log_id'=>'1',
				'log_table'=>'data_log',
				'log_column'=>'log_id',
				'log_type'=>'init',
				'log_script'=>"select 1",
				'log_date'=>'2021-10-20',
			),
		);
	
		return array(
			'script'=>$script,
		);
    }

}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */