<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_admin.php';
class barang_terjual extends controller_admin
{
	protected $st, $access, $class;

	public function __construct()
	{
		parent::__construct();
		$_model = __class__ . '_model';
		$this->load->model($this->module . '/laporan/penjualan/' . $_model);
		$this->mainModel = new $_model();
		$this->access = "akses_setting_user";
		$this->class = "Laporan Barang Terjual";
	}

	public function index()
	{
		redirect(base_url('admin/laporan/penjualan/' . __CLASS__ . '/data'));
	}

	public function data()
	{
		common_lib::hak_akses($this->access, __function__, 'controller');
		$this->session->set_userdata("last_url", __class__ . '/' . __function__);
		$common = common_lib::getState($this);
		$common['title'] = ucfirst($this->class);
		$st = new Stencil();

		$st->slice('head_login');
		$common['class'] = __class__;
		$common['js_files'] = '';
		$common['css_files'] = '';
		$common['access'] = $this->access;
		$common['role_arr'] = '';

		$st->paint($this->template . '/' . $this->module, '/laporan/penjualan/' . __function__ . '_' . __class__, $common);
	}

	public function get_datatable()
	{
		$result = $this->mainModel->get_data();
		$query = $result['query'];
		$total = $result['total'];

		header("Content-type: application/json");
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$start = isset($_POST['start']) ? $_POST['start'] : 0;
		$prev_trx = '';
		$json_data = array(
			'start' => $start,
			'recordsTotal' => isset($_POST['length']) > 0 ? $_POST['length'] : $total,
			'recordsFiltered' => $total,
			'res' => array()
		);
		$no = 0 + $start;

		// print_r($query);
		// die;

		foreach ($query as $row) {
			// $no++;
			/* $exm = [
				[date] => 2022-06-04
				[barang_id] => 3
				[kemasan_id] => 3
				[is_obat] => 1
				[qty] => 1
				[obat_name] => Ambroxol
				[diskon_kasir] => 0.00
				[diskon_persen_kasir] => 0
			] */

			foreach ($row as $variable => $value) {
				${$variable} = $value;
			}
			
			$list_barang = $this->mainModel->get_data_where($pemeriksaan_id);
			
			$id		 = '';
			$barcode = '';
			$nama	 = '';
			$diskon_persen  = '';
			$diskon_rupiah  = '';
			$qty_terjual = '';

			$data_barang = $this->mainModel->get_obat($barang_id);
			foreach ($data_barang as $key => $value) {
				$id		 = $value->obat_id;
				$barcode = $value->obat_barcode;
				$nama	 = $value->obat_name;
			}

			/* 14 November 2022 - Sementara data obat aja
			if ($is_obat == 1) {
				$data_barang = $this->mainModel->get_obat($barang_id);
				foreach ($data_barang as $key => $value) {
					$id		 = $value->obat_id;
					$barcode = $value->obat_barcode;
					$nama	 = $value->obat_name;
				}
			} else {
				$data_barang = $this->mainModel->get_alkes($barang_id);
				foreach ($data_barang as $key => $value) {
					$id		 = $value->alkes_id;
					$barcode = $value->alkes_barcode;
					$nama	 = $value->alkes_name;
				}
			}
			*/

			$diskon_persen  = $diskon_persen_kasir;
			$diskon_rupiah  = $diskon_kasir;

			if ($diskon_persen && $diskon_rupiah < 1) {
				$diskon = 0;
			} else if ($diskon_rupiah > 0) {
				$diskon = $diskon_rupiah;
			} else {
				$diskon = $diskon_persen;
			};

			$cek_konversi =  $this->mainModel->get_harga_kemasan($barang_id, $kemasan_id);

			$harga_modal = $this->get_harga($barang_id);
			$harga_modal_format = $this->angka_bulat($harga_modal['harga_modal']);
			$harga_jual = $this->get_harga($barang_id);
			$harga_jual_format = $this->angka_bulat($harga_jual['harga_jual']);


			$qty_terjual = $qty * $cek_konversi['konversi'];
			$total_modal = ($harga_modal_format * $qty_terjual) - $diskon;
			$total_jual = ($harga_jual_format * $qty_terjual) - $diskon;

			$entry = [
				'item_id' =>  $id,
				'item_barcode' =>  $barcode,
				'nama_barang' => $nama,
				'diskon' => $this->angka($diskon),
				'jumlah_beli' => $qty_terjual,
				'kemasan_terkecil' => $this->get_kemasan_dasar($barang_id),
				'harga_modal' => $this->angka($harga_modal_format),	 		//table data_obat->obat_price 
				'total_modal' => $total_modal,
				'harga_jual' => $this->angka($harga_jual_format),
				'total_jual' => $total_jual,
			];
			$json_data['res'][] = $entry;
		}

		$data = array();
		$grand_total_harga_jual = 0;
		if (count($json_data['res']) > 0) {
			foreach ($json_data['res'] as $key => $value) {
				$id = $value['item_id'];
				$harga_modal = $value['harga_modal'];

				if (!empty($id)) {
					if (!isset($data[$id])) {
						$no++;
						$data[$id] = array(
							'no' =>  $no,
							'item_id' => $value['item_id'],
							'item_barcode' =>  $value['item_barcode'],
							'nama_barang' => $value['nama_barang'],
							'diskon' => $value['diskon'],
							'jumlah_beli' => $value['jumlah_beli'],
							'kemasan_terkecil' => $value['kemasan_terkecil'],
							'harga_modal' => $value['harga_modal'],
							'total_modal' => $value['total_modal'],
							'harga_jual' => $value['harga_jual'],
							'total_jual' => $value['total_jual']
						);
					} else {
						if ($data[$id]['item_id'] == $value['item_id'] && $data[$id]['kemasan_terkecil'] == $value['kemasan_terkecil'] && $data[$id]['harga_modal'] == $harga_modal) {
							$data[$id]['diskon'] += $value['diskon'];
							$data[$id]['jumlah_beli'] += $value['jumlah_beli'];
							$data[$id]['total_modal'] += $value['total_modal'];
							$data[$id]['total_jual'] += $value['total_jual'];
						}
					}
				}
				$grand_total_harga_jual += $value['total_jual'];
			}
		}

		$json_data['grand_total_harga_jual'] = 'Rp. ' . $this->angka($grand_total_harga_jual);

		$result = array_values($data);
		$json_data['data'] = $result;
		echo json_encode($json_data);
	}

	public function get_kemasan_dasar($id_barang)
	{
		$obat = $this->mainModel->get_obat($id_barang);
		$list = '';
		if ($obat) {
			foreach ($obat as $key => $data) {
				$list = $data->kemasan;
			}
		}
		return $list;
	}

	function get_harga($id)
	{
		$obat = $this->mainModel->get_obat($id);
		$harga_modal = '';
		$harga_jual = '';
		if ($obat) {
			foreach ($obat as $key => $data) {
				$harga_modal = $this->angka_bulat($data->obat_price);
				$harga_jual = $this->angka_bulat($data->obat_price_non_resep);
			}
		}
		$res = array('harga_modal' => $harga_modal, 'harga_jual' => $harga_jual);
		return $res;
	}

	public function dasar($id)
	{
		$obat = $this->mainModel->get_obat($id);
		$obat_list = '';
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				$obat_list = $data['kemasan'];
			}
		}
		return $obat_list;
	}

	public function export()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$file        = APPPATH . 'template/laporan/laporan-barang-terjual.xlsx';
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		$sheet       = $objPHPExcel->getSheet();

		// Panggil model
		$result = $this->mainModel->get_data();
		$query = $result['query'];
		$no = 1;
		$numrow = 5;
		$start_baris = $numrow;
		$json_data = [];

		$filter_date = 'ALL Date';
		$filter_start_date = date('d F Y', strtotime($result['filter_start_date']));
		$filter_end_date = date('d F Y', strtotime($result['filter_end_date']));
		
		if ($result['filter_start_date'] && $result['filter_end_date']  != NULL ) {
			$filter_date = $filter_start_date . '  -  ' . $filter_end_date;
		}else {
			$filter_date = 'ALL Date';
		}

		$sheet->setCellValue('C2', $filter_date);

		// Lakukan looping
		foreach ($query as $row) {
			foreach ($row as $variable => $value) {
				${$variable} = $value;
			}

			// $dokter = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($pemeriksaan_id).' AND lower(pendaftaran_layanan_layanan_name)="umum" AND 1');
			// $obat = $this->mainModel->get_obat($barang_id);
			// $merge = count($obat);
			// $merge_fix = $merge > 1 ? ($merge-1) : 0;

			$id		 = '';
			$barcode = '';
			$nama	 = '';
			$diskon_persen  = '';
			$diskon_rupiah  = '';
			$qty_terjual = '';

			if ($is_obat == 1) {
				$data_barang = $this->mainModel->get_obat($barang_id);
				foreach ($data_barang as $key => $value) {
					$id		 = $value->obat_id;
					$barcode = $value->obat_barcode;
					$nama	 = $value->obat_name;
				}
			} else {
				$data_barang = $this->mainModel->get_alkes($barang_id);
				foreach ($data_barang as $key => $value) {
					$id		 = $value->alkes_id;
					$barcode = $value->alkes_barcode;
					$nama	 = $value->alkes_name;
				}
			}

			$diskon_persen  = $diskon_persen_kasir;
			$diskon_rupiah  = $diskon_kasir;

			if ($diskon_persen && $diskon_rupiah < 1) {
				$diskon = 0;
			} else if ($diskon_rupiah > 0) {
				$diskon = $diskon_rupiah;
			} else {
				$diskon = $diskon_persen;
			};

			$cek_konversi =  $this->mainModel->get_harga_kemasan($barang_id, $kemasan_id);
			$harga_modal = $this->get_harga($barang_id);
			$harga_modal_format = $this->angka_bulat($harga_modal['harga_modal']);
			$harga_jual = $this->get_harga($barang_id);
			$harga_jual_format = $this->angka_bulat($harga_jual['harga_jual']);


			$qty_terjual = $qty * $cek_konversi['konversi'];
			$total_modal = ($harga_modal_format * $qty_terjual) - $diskon;
			$total_jual = ($harga_jual_format * $qty_terjual) - $diskon;

			$entry = [
				'item_id' =>  $id,
				'item_barcode' =>  $barcode,
				'nama_barang' => $nama,
				'diskon' => $diskon,
				'jumlah_beli' => $qty_terjual,
				'kemasan_terkecil' => $this->get_kemasan_dasar($barang_id),
				'harga_modal' => $harga_modal_format,	 		//table data_obat->obat_price 
				'total_modal' => $total_modal,
				'harga_jual' => $harga_jual_format,
				'total_jual' => $total_jual,
			];

			$json_data['res'][] = $entry;
		}

		$data = array();
		$grand_total_harga_jual = 0;
		if (count($json_data['res']) > 0) {
			foreach ($json_data['res'] as $key => $value) {
				$id = $value['item_id'];
				$harga_modal = $value['harga_modal'];

				if (!empty($id)) {
					if (!isset($data[$id])) {
						$no++;
						$data[$id] = array(
							'no' =>  $no,
							'item_id' => $value['item_id'],
							'item_barcode' =>  $value['item_barcode'],
							'nama_barang' => $value['nama_barang'],
							'diskon' => $value['diskon'],
							'jumlah_beli' => $value['jumlah_beli'],
							'kemasan_terkecil' => $value['kemasan_terkecil'],
							'harga_modal' => $value['harga_modal'],
							'total_modal' => $value['total_modal'],
							'harga_jual' => $value['harga_jual'],
							'total_jual' => $value['total_jual']
						);
					} else {
						if ($data[$id]['item_id'] == $value['item_id'] && $data[$id]['kemasan_terkecil'] == $value['kemasan_terkecil'] && $data[$id]['harga_modal'] == $harga_modal) {
							$data[$id]['diskon'] += $value['diskon'];
							$data[$id]['jumlah_beli'] += $value['jumlah_beli'];
							$data[$id]['total_modal'] += $value['total_modal'];
							$data[$id]['total_jual'] += $value['total_jual'];
						}
					}
				}
				$grand_total_harga_jual += $value['total_jual'];
			}
		}

		$json_data['grand_total_harga_jual'] = $grand_total_harga_jual;

		$result = array_values($data);
		$json_data['data'] = $result;

		$nomor = 1;
		foreach ($json_data['data'] as $key => $value) {
			$dokter = $this->common_lib->select_result('trx_pendaftaran_layanan', 'pendaftaran_layanan_pendaftaran_id=' . intval($pemeriksaan_id) . ' AND lower(pendaftaran_layanan_layanan_name)="umum" AND 1');
			// $merge = count($obat);
			// $merge_fix = $merge > 1 ? ($merge-1) : 0;

			$sheet->setCellValue('A' . $numrow, $nomor);
			$sheet->setCellValue('B' . $numrow, $value['item_id']);
			$sheet->setCellValue('C' . $numrow, $value['item_barcode']);
			$sheet->setCellValue('D' . $numrow, $value['nama_barang']);
			$sheet->setCellValue('E' . $numrow, $value['diskon']);
			$sheet->setCellValue('F' . $numrow, $value['jumlah_beli']);
			$sheet->setCellValue('G' . $numrow, $value['kemasan_terkecil']);
			$sheet->setCellValue('H' . $numrow, $value['harga_modal']);
			$sheet->setCellValue('I' . $numrow, $value['total_modal']);
			$sheet->setCellValue('J' . $numrow, $value['harga_jual']);
			$nomor++;

			// $sheet->setCellValue('C'.$numrow, PHPExcel_Shared_Date::PHPToExcel($value['date']));
			// $sheet->setCellValue('D'.$numrow, $pasien_name);
			// $sheet->setCellValue('E'.$numrow, $dokter ? $dokter[0]['pendaftaran_layanan_perawat_name'] : '');

			// $baris_hasil = $numrow;
			// foreach ($obat as $key => $data) {
			// 	$sheet->setCellValue('F'.$baris_hasil, $data['pemeriksaan_obat_resep']);
			// 	$sheet->setCellValue('G'.$baris_hasil, $data['pemeriksaan_obat_aturan_pakai']);
			// 	$sheet->setCellValue('H'.$baris_hasil, $data['pemeriksaan_obat_obat_id']);
			// 	$sheet->setCellValue('I'.$baris_hasil, $data['obat_barcode']);
			// 	$sheet->setCellValue('J'.$baris_hasil, $data['obat_name']);
			// 	$sheet->setCellValue('K'.$baris_hasil, $data['pemeriksaan_obat_qty']);
			// 	$sheet->setCellValue('L'.$baris_hasil, $data['kemasan_dasar']);
			// 	$baris_hasil++;
			// }$baris_hasil--;

			// if ($merge>1) {
			// 	$sheet->mergeCells('A' . $numrow . ':A' . ($merge_fix + $numrow));
			// 	$sheet->mergeCells('B' . $numrow . ':B' . ($merge_fix + $numrow));
			// 	$sheet->mergeCells('C' . $numrow . ':C' . ($merge_fix + $numrow));
			// 	$sheet->mergeCells('D' . $numrow . ':D' . ($merge_fix + $numrow));
			// 	$sheet->mergeCells('E' . $numrow . ':E' . ($merge_fix + $numrow));
			// }

			// $numrow+=($merge_fix);
			$numrow++;
		}

		$sheet->setCellValue('C3', $json_data['grand_total_harga_jual']);


		$numrow--;
		$sheet->getStyle('A' . $start_baris . ':J' . $numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle('A' . $start_baris . ':G' . $numrow)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$sheet->getStyle('C3:C3')->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$sheet->getStyle('A' . $start_baris . ':J' . $numrow)->applyFromArray(
			[
				'borders' => [
					'allborders' => [
						'style' => PHPExcel_Style_Border::BORDER_THIN
					]
				]
			]
		);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=Laporan-Barang-Terjual-" . date('d-m-Y') . ".xls");
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$write->save('php://output');
	}
}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */