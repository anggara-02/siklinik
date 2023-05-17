<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_admin.php';
class rekap_stok extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/stok/' . $_model);
		$this->mainModel=new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Laporan Rekap Stok";
    }

    public function index() {
        redirect(base_url('admin/laporan/stok/' . __CLASS__ . '/data'));
    }

    public function data() {
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

        $st->paint($this->template . '/' . $this->module, '/laporan/stok/' . __function__ . '_' . __class__, $common);
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

			$entry = [
				'no' =>  $no,
				'id_barang' =>  $id_barang,
				'barcode' =>  $barcode,
				'produk' =>  $produk,
				'expired_date' => ($expired_date==NULL ? '-' : $this->format_tanggal($expired_date)),
				'batch' => $batch,
				'etalase' => $this->angka($this->mainModel->etalase($id_barang, $expired_date, $batch, $id_kemasan)),
				'gudang' => $this->angka($this->mainModel->gudang($id_barang, $expired_date, $batch, $id_kemasan)),
				'promo' => $this->angka($this->mainModel->promo($id_barang, $expired_date, $batch, $id_kemasan)),
				'kemasan' => $kemasan,
				'harga' => 'Rp. '.$this->angka($harga)
            ];
			$json_data['data'][] = $entry;
        }
        echo json_encode($json_data); 
	}
	
	public function export() {
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
	
		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$file        = APPPATH . 'template/laporan/rekap-stok.xlsx';
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		$sheet       = $objPHPExcel->getSheet();
	
		// Panggil model
		$result = $this->mainModel->get_data();
		$query = $result['query'];
		$no = 1;
		$numrow = 5;
		$start_baris = $numrow; 
		
		$filter_date = 'ALL Expired Date';
		$filter_start_date = date('d F Y', strtotime($result['filter_start_date']));
		$filter_end_date = date('d F Y', strtotime($result['filter_end_date']));
		
		if ($result['filter_start_date'] && $result['filter_end_date']  != NULL ) {
			$filter_date = $filter_start_date . '  -  ' . $filter_end_date;
		}else {
			$filter_date = 'ALL Expired Date';
		}

		$sheet->setCellValue('B2', $filter_date);
	
		// Lakukan looping
		foreach ($query as $row) {
			foreach ($row as $variable => $value) {
				${$variable} = $value;
			}
	
			$sheet->setCellValue('A'.$numrow, $no++);
			$sheet->setCellValue('B'.$numrow, $id_barang);
			$sheet->setCellValue('C'.$numrow, $barcode);
			$sheet->setCellValue('D'.$numrow, $produk);
			$sheet->setCellValue('E'.$numrow, ($expired_date == NULL ? '-' : PHPExcel_Shared_Date::PHPToExcel($expired_date)));
			$sheet->setCellValue('F'.$numrow, $batch);
			$sheet->setCellValue('G'.$numrow, $this->angka($this->mainModel->etalase($id_barang, $expired_date, $batch, $id_kemasan)));
			$sheet->setCellValue('H'.$numrow, $this->angka($this->mainModel->gudang($id_barang, $expired_date, $batch, $id_kemasan)));
			$sheet->setCellValue('I'.$numrow, $kemasan);
			$sheet->setCellValue('J'.$numrow, $harga);
			$numrow++;
		}

		$numrow--;
    	$sheet->getStyle('A'.$start_baris.':J'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$sheet->getStyle('A'.$start_baris.':J'.$numrow)->applyFromArray(
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
		header("Content-Disposition: attachment; filename=Laporan-Rekap-Stok-".date('d-m-Y').".xls");
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$write->save('php://output');
	}
}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */