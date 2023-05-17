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
class resep_dokter extends controller_admin
{
    protected $st, $access, $class;

    public function __construct() {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/penjualan/' . $_model);
		$this->mainModel = new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Laporan Resep Dokter";
    }

    public function index() {
        redirect(base_url('admin/laporan/penjualan/' . __CLASS__ . '/data'));
    }

    public function data() {
		$result = $this->mainModel->get_data();
		$query = $result['query'];
		$harga = 0;
        foreach ($query as $row) {
            foreach($row AS $variable=>$value) {
                ${$variable}=$value;
            }
			$harga += $this->harga($pemeriksaan_id);
		}
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
        $common['harga'] = $this->angka($harga);
        $common['role_arr'] = '';

        $st->paint($this->template . '/' . $this->module, '/laporan/penjualan/' . __function__ . '_' . __class__, $common);
    }

    public function get_datatable() {
		$result = $this->mainModel->get_data();
		$query = $result['query'];
		$total = $result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
        $prev_trx = '';
		$json_data = array(
			'start' => $start, 
			'recordsTotal' => ($_POST['length']>0) ? $_POST['length'] : $total,
			'recordsFiltered' => $total, 
			'data' => array()
		);
        $no = 0 + $start;
        foreach ($query as $row) {
			$no++;
            foreach($row AS $variable=>$value) {
                ${$variable}=$value;
            }
			$dokter = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($pemeriksaan_pendaftaran_id).' AND lower(pendaftaran_layanan_layanan_name)="laboratorium" AND 1');
			$entry = [
				'no' =>  $no,
				'invoice' =>  $invoice,
				'transaksi' =>  $this->format_tanggal($transaksi),
				'pasien_name' =>  $pasien_name,
				'dokter' =>  $dokter ? $dokter[0]['pendaftaran_layanan_perawat_name'] : '',
				'no_r' =>  $this->no_r($pemeriksaan_id),
				'aturan' => $this->aturan($pemeriksaan_id),
				'item' => $this->item($pemeriksaan_id),
				'barcode' => $this->barcode($pemeriksaan_id),
				'barang' => $this->barang($pemeriksaan_id),
				'jumlah' => $this->jumlah($pemeriksaan_id),
				'dasar' => $this->dasar($pemeriksaan_id),
            ];
			$json_data['data'][] = $entry;
        }
        echo json_encode($json_data); 
	}
	
	public function export() {
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
	
		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$file        = APPPATH . 'template/laporan/resep-dokter.xlsx';
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		$sheet       = $objPHPExcel->getSheet();
	
		// Panggil model
		$result = $this->mainModel->get_data();
		$query = $result['query'];
		$no = 1;
		$numrow = 5;
		$start_baris = $numrow;
		$total = 0; 

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
			$total += $this->harga($pemeriksaan_id);

			$dokter = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($pemeriksaan_pendaftaran_id).' AND lower(pendaftaran_layanan_layanan_name)="laboratorium" AND 1');
			$obat = $this->mainModel->get_obat($pemeriksaan_id)->result_array();
			$merge = count($obat);
			$merge_fix = $merge > 1 ? ($merge-1) : 0;

			$sheet->setCellValue('A'.$numrow, $no++);
			$sheet->setCellValue('B'.$numrow, $invoice);
			$sheet->setCellValue('C'.$numrow, PHPExcel_Shared_Date::PHPToExcel($transaksi));
			$sheet->setCellValue('D'.$numrow, $pasien_name);
			$sheet->setCellValue('E'.$numrow, $dokter ? $dokter[0]['pendaftaran_layanan_perawat_name'] : '');

        	$baris_hasil = $numrow;
			foreach ($obat as $key => $data) {
				$sheet->setCellValue('F'.$baris_hasil, $data['pemeriksaan_obat_resep']);
				$sheet->setCellValue('G'.$baris_hasil, $data['pemeriksaan_obat_aturan_pakai']);
				$sheet->setCellValue('H'.$baris_hasil, $data['pemeriksaan_obat_obat_id']);
				$sheet->setCellValue('I'.$baris_hasil, $data['obat_barcode']);
				$sheet->setCellValue('J'.$baris_hasil, $data['obat_name']);
				$sheet->setCellValue('K'.$baris_hasil, $data['pemeriksaan_obat_qty']);
				$sheet->setCellValue('L'.$baris_hasil, $data['kemasan_dasar']);
				$baris_hasil++;
			}$baris_hasil--;

			if ($merge>1) {
				$sheet->mergeCells('A' . $numrow . ':A' . ($merge_fix + $numrow));
				$sheet->mergeCells('B' . $numrow . ':B' . ($merge_fix + $numrow));
				$sheet->mergeCells('C' . $numrow . ':C' . ($merge_fix + $numrow));
				$sheet->mergeCells('D' . $numrow . ':D' . ($merge_fix + $numrow));
				$sheet->mergeCells('E' . $numrow . ':E' . ($merge_fix + $numrow));
			}

			$numrow+=($merge_fix);
			$numrow++;
		}

		$sheet->setCellValue('C3',  $total);

		$numrow--;
    	$sheet->getStyle('A'.$start_baris.':L'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$sheet->getStyle('A'.$start_baris.':L'.$numrow)->applyFromArray(
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
		header("Content-Disposition: attachment; filename=Laporan-Resep-Dokter-".date('d-m-Y').".xls");
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$write->save('php://output');
	}

	public function no_r($id) {
		$obat = $this->mainModel->get_obat($id);
		$obat_list = '';
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['pemeriksaan_obat_resep'] . '<br>';
				} else {
					$obat_list .= $data['pemeriksaan_obat_resep'] . '<br>';
				}
			}
		}
		return $obat_list;
	}

	public function aturan($id) {
		$obat = $this->mainModel->get_obat($id);
		$obat_list = '';
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['pemeriksaan_obat_aturan_pakai'] . '<br>';
				} else {
					$obat_list .= $data['pemeriksaan_obat_aturan_pakai'] . '<br>';
				}
			}
		}
		return $obat_list;
	}

	public function item($id) {
		$obat = $this->mainModel->get_obat($id);
		$obat_list = '';
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['pemeriksaan_obat_obat_id'] . '<br>';
				} else {
					$obat_list .= $data['pemeriksaan_obat_obat_id'] . '<br>';
				}
			}
		}
		return $obat_list;
	}

	public function barcode($id) {
		$obat = $this->mainModel->get_obat($id);
		$obat_list = '';
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['obat_barcode'] . '<br>';
				} else {
					$obat_list .= $data['obat_barcode'] . '<br>';
				}
			}
		}
		return $obat_list;
	}

	public function barang($id) {
		$obat = $this->mainModel->get_obat($id);
		$obat_list = '';
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['obat_name'] . '<br>';
				} else {
					$obat_list .= $data['obat_name'] . '<br>';
				}
			}
		}
		return $obat_list;
	}

	public function jumlah($id) {
		$obat = $this->mainModel->get_obat($id);
		$obat_list = '';
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['pemeriksaan_obat_qty'] . '<br>';
				} else {
					$obat_list .= $data['pemeriksaan_obat_qty'] . '<br>';
				}
			}
		}
		return $obat_list;
	}

	public function dasar($id) {
		$obat = $this->mainModel->get_obat($id);
		$obat_list = '';
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['kemasan_dasar'] . '<br>';
				} else {
					$obat_list .= $data['kemasan_dasar'] . '<br>';
				}
			}
		}
		return $obat_list;
	}

	public function harga($id) {
		$obat = $this->mainModel->get_obat($id);
		$obat_list = 0;
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				$obat_list += $data['pemeriksaan_obat_price'];
			}
		}
		return $obat_list;
	}
}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */