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
class mutasi_stok extends controller_admin
{
    protected $st, $access, $class;

    public function __construct() {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/stok/' . $_model);
		$this->mainModel=new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Laporan Mutasi Stok";
    }

    public function index() {
        redirect(base_url('admin/laporan/stok/' . __CLASS__ . '/data'));
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
				'create_at' =>  $this->format_tanggal($create_at),
				'id_barang' =>  $id_barang,
				'barcode' =>  $barcode,
				'produk' =>  $produk,
				'kemasan' =>  $kemasan,
				'batch' => $batch,
				'expired_date' => ($expired_date==NULL ? '-' : $this->format_tanggal($expired_date)),
				'etalase' => $this->angka($masuk),
				'gudang' => $this->angka($keluar),
				'keterangan' => $keterangan
            ];
			$json_data['data'][] = $entry;
        }
        echo json_encode($json_data); 
	}
	
	public function export() {
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
	
		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$file        = APPPATH . 'template/laporan/rekap-mutasi-stok.xlsx';
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		$sheet       = $objPHPExcel->getSheet();
	
		// Panggil model
		$result = $this->mainModel->get_data();
		$query = $result['query'];
		$no = 1;
		$numrow = 5;
		$start_baris = $numrow; 

		$filter_date = 'ALL Transaksi Date';
		$filter_start_date = date('d F Y', strtotime($result['filter_start_date']));
		$filter_end_date = date('d F Y', strtotime($result['filter_end_date']));
		
		if ($result['filter_start_date'] && $result['filter_end_date']  != NULL ) {
			$filter_date = $filter_start_date . '  -  ' . $filter_end_date;
		}else {
			$filter_date = 'ALL Transaksi Date';
		}

		$sheet->setCellValue('C2', $filter_date);
	
		// Lakukan looping
		foreach ($query as $row) {
			foreach ($row as $variable => $value) {
				${$variable} = $value;
			}
	
			$sheet->setCellValue('A'.$numrow, $no++);
			$sheet->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel($create_at));
			$sheet->setCellValue('C'.$numrow, $id_barang);
			$sheet->setCellValue('D'.$numrow, $barcode);
			$sheet->setCellValue('E'.$numrow, $produk);
			$sheet->setCellValue('F'.$numrow, $kemasan);
			$sheet->setCellValue('G'.$numrow, $batch);
			$sheet->setCellValue('H'.$numrow, ($expired_date == NULL ? '-' : PHPExcel_Shared_Date::PHPToExcel($expired_date)));
			$sheet->setCellValue('I'.$numrow, $this->angka($masuk));
			$sheet->setCellValue('J'.$numrow, $this->angka($keluar));
			$sheet->setCellValue('K'.$numrow, $keterangan);
			$numrow++;
		}

		$numrow--;
    	$sheet->getStyle('A'.$start_baris.':K'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$sheet->getStyle('A'.$start_baris.':K'.$numrow)->applyFromArray(
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
		header("Content-Disposition: attachment; filename=Laporan-Mutasi-Stok-".date('d-m-Y').".xls");
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