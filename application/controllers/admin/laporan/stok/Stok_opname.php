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
class stok_opname extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/stok/' . $_model);
		$this->mainModel=new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Laporan Stok Opname";
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

	 public function get_datatable()
    {
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;

        $qty = '';
        $kemasan = '';
        $data = array();

        $start = isset($_POST['start']) ? $_POST['start'] : 0;
        $prev_trx = '';
        $no = 0 + $start;

        $result = $this->mainModel->get_data();
        $parrent = '';
        $detail_parrent = '';
        $total = $result['total'];
        $json_data = array('start' => $start, 'recordsTotal' => ($_POST['length'] > 0) ? $_POST['length'] : $total, 'recordsFiltered' => $total, 'data' => array());

        if ($result['detailData']) {
            foreach ($result['detailData'] as $val) {
                $id = $val->id_so;
                if (!isset($data[$id])) {
                    $data[$id] = array();
                }

                $hasil = $val->sebelum - $val->sesudah;
                $selisih = ($hasil >= 0 ? $val->sebelum - $val->sesudah : $val->sesudah - $val->sebelum);
                $detail_array[$id][] = [
                    'nama_barang'   => $val->item,
                    'batch'         => $val->batch,
                    'harga_satuan'  => $val->harga_satuan,
                    'sebelum'       => $val->sebelum,
                    'sesudah'       => $val->sesudah,
                    'selisih'       => $selisih,
                ];
            }
        };

        $nama_barang    = '';
        $batch          = '';
        $harga_satuan   = '';
        $sebelum        = '';
        $sesudah        = '';
        $selisih        = '';
        $selisih_harga  = '';

        foreach ($result['parrentData'] as $value) {
            $so_id = $value->so_id;
            foreach ($detail_array[$so_id] as $k => $v) {
                if ($k == 0) {
                    $nama_barang    = '' . $v['nama_barang'] . '</br>';
                    $batch          = '' . $v['batch'] . '</br>';
                    $harga_satuan   = '' . $v['harga_satuan'] . '</br>';
                    $sebelum        = '' . $v['sebelum'] . '</br>';
                    $sesudah        = '' . $v['sesudah'] . '</br>';
                    $selisih        = '' . $v['selisih'] . '</br>';
                    $selisih_harga  = '' . ($v['selisih'] * $v['harga_satuan']) . '</br>';
                } else {
                    $nama_barang    .= '' . $v['nama_barang'] . '</br>';
                    $batch          .= '' . $v['batch'] . '</br>';
                    $harga_satuan   .= '' . $v['harga_satuan'] . '</br>';
                    $sebelum        .= '' . $v['sebelum'] . '</br>';
                    $sesudah        .= '' . $v['sesudah'] . '</br>';
                    $selisih        .= '' . $v['selisih'] . '</br>';
                    $selisih_harga  .= '' . ($v['selisih'] * $v['harga_satuan']) . '</br>';
                }
            }

            $no++;
            
            $action  = common_lib::hak_akses($this->access, 'edit', 'menu') == '1' ? '<a href="' . site_url('admin/' . __class__ . '/view/' . $so_id . '') . '" style="margin-right:5px" class="btn btn-info btn-icon" data-index="' . $so_id . '"><i class="fa fa-eye"></i></a>' : '';
            // $action .= common_lib::hak_akses($this->access,'delete','menu')=='1'?'<a href="javascript:void(0);" data-url="'.site_url('admin/'.__class__.'/delete/'.$so_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation"><i class="fa fa-trash"></i></a>':'';
            
            $json_data['data'][] = array(
                'no'            	=> $no,
                'tanggal_so'    	=> $this->format_tanggal($value->tanggal_so),
                'nama_item'   		=> $nama_barang,
                'harga_satuan'  	=> $harga_satuan,
                'stok_before_so'    => $sebelum,
                'stok_after_so'     => $sesudah,
                'selisih_stok'      => $selisih,
                'selisih_harga'     => $selisih_harga,
                'user'       		=> $this->name_user($value->user_input)->user_karyawan,
            );
        };
		echo json_encode($json_data);
    }

    // public function get_datatable() {  
	// 	$result = $this->mainModel->get_data();
	// 	$query = $result;
	// 	$total = $result['total'];
		
    //     header("Content-type: application/json");
    //     $page = isset($_POST['page']) ? $_POST['page'] : 1;
    //     $start = isset($_POST['start']) ? $_POST['start'] : 0;
    //     $prev_trx = '';
	// 	$json_data = array(
	// 		'start' => $start, 
	// 		'recordsTotal' => ($_POST['length']>0) ? $_POST['length'] : $total,
	// 		'recordsFiltered' => $total, 
	// 		'data' => array()
	// 	);
    //     $no = 0 + $start;

	// 	print_r($query['parrentData']);
	// 	die;

    //     foreach ($query as $row) {
	// 		$no++;
    //         foreach($row AS $variable=>$value) {
    //             ${$variable}=$value;
    //         }

	// 		$entry = [
	// 			'no' 				=>  $no,
	// 			'tanggal_so' 		=>  $id_barang,
	// 			'nama_item' 		=>  $barcode,
	// 			'harga_satuan' 		=>  $produk,
	// 			'stok_before_so' 	=>  $produk,
	// 			'stok_after_so' 	=>  $produk,
	// 			'selisih_stok' 		=>  $produk,
	// 			'selisih_harga' 	=>  $produk,
	// 			'user' 				=>  $produk,
    //         ];
	// 		$json_data['data'][] = $entry;
    //     }
    //     echo json_encode($json_data); 
	// }
	
	public function export() {
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
	
		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$file        = APPPATH . 'template/laporan/stock-opname.xlsx';
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		$sheet       = $objPHPExcel->getSheet();
	
		// Panggil model
		$result = $this->mainModel->export();
        
        // echo "<pre>";
		// print_r(count($result['detailData']));
        // die;

        $no = 1;
		$numrow = 6;
		$start_baris = $numrow; 
        $detail_array = [];
		
		$filter_date = 'ALL Date';
		$filter_start_date = date('d F Y', strtotime($result['filter_start_date']));
		$filter_end_date = date('d F Y', strtotime($result['filter_end_date']));
		
		if ($result['filter_start_date'] && $result['filter_end_date']  != NULL ) {
			$filter_date = $filter_start_date . '  -  ' . $filter_end_date;
		}else {
			$filter_date = 'ALL Date';
		}
        
		$sheet->setCellValue('C3', $filter_date);

        if ($result['detailData']) {
            foreach ($result['detailData'] as $val) {
                $id = $val->id_so;
                if (!isset($data[$id])) {
                    $data[$id] = array();
                }

                $hasil = $val->sebelum - $val->sesudah;
                $selisih = ($hasil >= 0 ? $val->sebelum - $val->sesudah : $val->sesudah - $val->sebelum);
                $detail_array[$id][] = [
                    'nama_barang'   => $val->item,
                    'batch'         => $val->batch,
                    'harga_satuan'  => $val->harga_satuan,
                    'sebelum'       => $val->sebelum,
                    'sesudah'       => $val->sesudah,
                    'selisih'       => $selisih,
                ];
            }
        };

		// Lakukan looping
		foreach ($result['parrentData'] as $row) {
            $so_id = $row->so_id;
            
            $merge = count($result['detailData']);
            $merge_fix = $merge > 1 ? ($merge-1) : 0;

            $sheet->setCellValue('A'.$numrow, $no++);
            $sheet->setCellValue('B'.$numrow, $row->tanggal_so);
            $sheet->setCellValue('I'.$numrow, $this->name_user($row->user_input)->user_karyawan);

            foreach ($detail_array[$so_id] as $key => $value) {
                $sheet->setCellValue('C'.$numrow, $value['nama_barang']);
                $sheet->setCellValue('D'.$numrow, $value['harga_satuan']);
                $sheet->setCellValue('E'.$numrow, $value['sebelum']);
                $sheet->setCellValue('F'.$numrow, $value['sesudah']);
                $sheet->setCellValue('G'.$numrow, $value['selisih']);
                $sheet->setCellValue('H'.$numrow, ($value['selisih'] * $value['harga_satuan']));

                if ($merge>1) {
                    $sheet->mergeCells('A' . $numrow . ':A' . ($merge_fix + $numrow));
                    $sheet->mergeCells('B' . $numrow . ':B' . ($merge_fix + $numrow));
                    $sheet->mergeCells('I' . $numrow . ':I' . ($merge_fix + $numrow));
                }

                $numrow++;
            }
		}

		$numrow--;
    	$sheet->getStyle('A'.$start_baris.':I'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$sheet->getStyle('A'.$start_baris.':I'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A'.$start_baris.':I'.$numrow)->applyFromArray(
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
		header("Content-Disposition: attachment; filename=Laporan-Stock-Opname-".date('d-m-Y').".xls");
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