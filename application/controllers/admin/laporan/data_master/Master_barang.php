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
class master_barang extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/data_master/' . $_model);
        $this->mainModel = new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Laporan Master Barang";
    }

    public function index()
    {
        redirect(base_url('admin/laporan/data_master/' . __CLASS__ . '/data'));
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

        $st->paint($this->template . '/' . $this->module, '/laporan/data_master/' . __function__ . '_' . __class__, $common);
    }

    public function get_datatable()
    {
        $result = $this->mainModel->get_data();
        $query = $result['query'];
        $total = $result['total'];

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;

        $start = isset($_POST['start']) ? $_POST['start'] : 0;
        $json_data = array('start' => $start, 'recordsTotal' => ($_POST['length'] > 0) ? $_POST['length'] : $total, 'recordsFiltered' => $total, 'data' => array());
        $prev_trx = '';
        $no = 0 + $start;
        foreach ($query as $row) {
            foreach ($row as $variable => $value) {
                ${$variable} = $value;
            }

            $no++;
            $type_obat = $obat_type;
            $type_obat = str_replace('_', ' ', $obat_type);
            $entry = array(
                'no'                    => $no,
                'item_id'               => $obat_id,
                'item_barcode'          => $obat_barcode,
                'produk_name'           => $obat_name,
                'stok'                  => $this->angka($this->mainModel->stok($obat_id)),
                'kemasan_dasar'         => $kemasan1,
                'isi_dasar'             => $obat_kemasan_kecil_konversi,
                'kemasan_sedang'        => $kemasan2,
                'isi_sedang'            => $obat_kemasan_sedang_konversi,
                'kemasan_besar'         => $kemasan3,
                'isi_besar'             => $obat_kemasan_besar_konversi,
                'harga_modal'           => $this->angka($obat_price),
                'margin_resep'          => $this->angka($obat_margin_resep),
                'harga_jual_resep'      => $this->angka($obat_price_resep),
                'margin_non_resep'      => $this->angka($obat_margin_non_resep),
                'harga_jual_non_resep'  => $this->angka($obat_price_non_resep),
                'jenis_obat'            => ucwords($type_obat),
                'lokasi'                => ($obat_lokasi != '') ? $obat_lokasi : '',
                'rak'                   => ($obat_rak != '') ? $obat_rak : '',
                'status'                => 'Aktif',
                'inputer'               => $nama_user,
                'tanggal_update'        => $this->format_tanggal($update_at)
            );
            $json_data['data'][] = $entry;
        }
        echo json_encode($json_data);
    }

    public function export()
    {
        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
		$file        = APPPATH . 'template/laporan/master-barang.xlsx';
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		$sheet       = $objPHPExcel->getSheet();

        // Panggil model 
        $result = $this->mainModel->get_data();
        $query = $result['query'];
        $no = 1;
        $numrow = 5;
		$start_baris = $numrow; 

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

            $type_obat = $obat_type;
            $type_obat = str_replace('_', ' ', $obat_type);

            $sheet->setCellValue('A' . $numrow, $no++);
            $sheet->setCellValue('B' . $numrow, $obat_id);
            $sheet->setCellValue('C' . $numrow, $obat_barcode);
            $sheet->setCellValue('D' . $numrow, $obat_name);
            $sheet->setCellValue('E' . $numrow, ($this->mainModel->stok($obat_id) != '') ? $this->mainModel->stok($obat_id) : 0);
            $sheet->setCellValue('F' . $numrow, $kemasan1);
            $sheet->setCellValue('G' . $numrow, $obat_kemasan_kecil_konversi);
            $sheet->setCellValue('H' . $numrow, $kemasan2);
            $sheet->setCellValue('I' . $numrow, $obat_kemasan_sedang_konversi);
            $sheet->setCellValue('J' . $numrow, $kemasan3);
            $sheet->setCellValue('K' . $numrow, $obat_kemasan_besar_konversi);
            $sheet->setCellValue('L' . $numrow, $obat_price);
            $sheet->setCellValue('M' . $numrow, $obat_margin_resep);
            $sheet->setCellValue('N' . $numrow, $obat_price_resep);
            $sheet->setCellValue('O' . $numrow, $obat_margin_non_resep);
            $sheet->setCellValue('P' . $numrow, $obat_price_non_resep);
            $sheet->setCellValue('Q' . $numrow, ucwords($type_obat));
            $sheet->setCellValue('R' . $numrow, 'Aktif');
            $sheet->setCellValue('S' . $numrow, $nama_user);
            $sheet->setCellValue('T' . $numrow, $this->format_tanggal($update_at));
            $numrow++;
        }

		$numrow--;
    	$sheet->getStyle('A'.$start_baris.':T'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$sheet->getStyle('A'.$start_baris.':T'.$numrow)->applyFromArray(
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
		header("Content-Disposition: attachment; filename=Laporan-Data-Master-Master-Barang-".date('d-m-Y').".xls");
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