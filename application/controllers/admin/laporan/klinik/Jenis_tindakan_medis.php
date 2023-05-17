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
class jenis_tindakan_medis extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/klinik/' . $_model);
        $this->mainModel = new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Laporan Jenis Tindakan Medis";
    }

    public function index()
    {
        redirect(base_url('admin/laporan/klinik/' . __CLASS__ . '/data'));
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

        $st->paint($this->template . '/' . $this->module, '/laporan/klinik/' . __function__ . '_' . __class__, $common);
    }

    public function get_datatable()
    {
        $result = $this->mainModel->get_data();
        $query = $result['query'];
        $total = $result['total'];

        // header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
        $prev_trx = '';

        $json_data = array(
            'start' => $start,
            'recordsTotal' => (isset($_POST['length']) > 0) ? $_POST['length'] : $total,
            'recordsFiltered' => $total,
            'data' => array()
        );
        $no = 0 + $start;

        // print_r($query);die;

        $grand_total = 0;
        foreach ($query as $row) {
            $no++;
            foreach ($row as $variable => $value) {
                ${$variable} = $value;
            }

            $grand_total += $harga;
            $entry = [ 
                'no' =>  $no,
                'hari' =>  $this->day_name(date('w', strtotime($tanggal))),
                'shift' =>  $shift,
                'tanggal' =>  $this->format_tanggal($tanggal),
                'dokter' =>  $dokter,
                'tindakan' =>  $pemeriksaan,
                'harga' => 'Rp. ' . $this->angka($harga)
            ];
            $json_data['data'][] = $entry;
        }
        $json_data['grand_total'] = 'Rp. ' . $this->angka($grand_total);
        echo json_encode($json_data);
    }

    public function export(){
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
	
		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$file        = APPPATH . 'template/laporan/laporan-jenis-tindakan.xlsx';
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		$sheet       = $objPHPExcel->getSheet();
	
		// Panggil model
		$result = $this->mainModel->get_data();
		$query = $result['query'];
		$no = 1;
		$numrow = 6;
		$start_baris = $numrow;
		$total_biaya = 0; 

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

			$obat = $this->mainModel->data_list_obat($kasir_pemeriksaan_id)->result_array();
			$merge = count($obat);
			$merge_fix = $merge > 1 ? ($merge-1) : 0;

			$sheet->setCellValue('A'.$numrow, $no++);
			$sheet->setCellValue('B'.$numrow, $kasir_invoice);
			$sheet->setCellValue('C'.$numrow, date_format(new DateTime($kasir_date), 'd F Y'));
			$sheet->setCellValue('D'.$numrow, $kasir_last_update);
			$sheet->setCellValue('E'.$numrow, $kasir_update_by);
			$sheet->setCellValue('F'.$numrow, $kasir_total);
			$sheet->setCellValue('G'.$numrow, $kasir_bayar);
			$sheet->setCellValue('H'.$numrow, $tagihan);
			$sheet->setCellValue('I'.$numrow, $kasir_pemeriksaan_id);

        	$baris_hasil = $numrow;
			foreach ($obat as $key => $data) {
				$sheet->setCellValue('I'.$baris_hasil, $data['pemeriksaan_obat_name']);
				$baris_hasil++;
			}$baris_hasil--;

			if ($merge>1) {
				$sheet->mergeCells('A' . $numrow . ':A' . ($merge_fix + $numrow));
				$sheet->mergeCells('B' . $numrow . ':B' . ($merge_fix + $numrow));
				$sheet->mergeCells('C' . $numrow . ':C' . ($merge_fix + $numrow));
				$sheet->mergeCells('D' . $numrow . ':D' . ($merge_fix + $numrow));
				$sheet->mergeCells('E' . $numrow . ':E' . ($merge_fix + $numrow));
				$sheet->mergeCells('F' . $numrow . ':F' . ($merge_fix + $numrow));
				$sheet->mergeCells('G' . $numrow . ':G' . ($merge_fix + $numrow));
				$sheet->mergeCells('H' . $numrow . ':H' . ($merge_fix + $numrow));
			}

			// $biaya += $tagihan;
			$numrow+=($merge_fix);
			$numrow++;
		}

		$sheet->setCellValue('C3',  $biaya);

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
		header("Content-Disposition: attachment; filename=Laporan-Klinik-Jenis-Tindakan-Medis-".date('d-m-Y').".xls");
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