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
class kunjungan_pasien extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/klinik/' . $_model);
        $this->mainModel = new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Laporan Kunjungan Pasien";
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

        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
        $prev_trx = '';
        $json_data = array(
            'start' => $start,
            'recordsTotal' => ($_POST['length'] > 0) ? $_POST['length'] : $total,
            'recordsFiltered' => $total,
            'data' => array()
        );

        $no = 0 + $start;

        foreach ($query as $row) {
            $no++;
            foreach ($row as $variable => $value) {
                ${$variable} = $value;
            }
            $entry = [
                'no'                    => $no,
                'tanggal'               => $this->format_tanggal($pendaftaran_date),
                'shift'                 => ($pemeriksaan_shift_name != '') ? $pemeriksaan_shift_name : '-',
                'no_rm'                 => $pendaftaran_pasien_rm,
                'nama'                  => $pendaftaran_pasien_name,
                'tanggal_lahir'         => $this->format_tanggal($pendaftaran_pasien_birthdate),
                'alamat'                => $pendaftaran_pasien_address,
                'no_telepon'            => $pendaftaran_pasien_penanggung_jawab_telp,
                'penjamin'              => ($pendaftaran_pasien_penanggung_jawab_name != '') ? $pendaftaran_pasien_penanggung_jawab_name : '-',
                'diagnosis'             => $this->get_diagnosis($pemeriksaan_id),
                'pemeriksaan_medis'     => ($pemeriksaan_pemeriksaan != '') ? $pemeriksaan_pemeriksaan : '-',
                'pemeriksaan_laborat'   => $this->get_pemeriksaan_laborat($pemeriksaan_id),
                'resep_obat'            => $this->get_resep($pemeriksaan_id),
            ];
            $json_data['data'][] = $entry;
        }
        echo json_encode($json_data);
    }

    public function get_diagnosis($pemeriksaan_id)
    {
        $diagnosis = $this->mainModel->get_diagnosis($pemeriksaan_id);

        $diagnosis_list = '-';
        if ($diagnosis) {
            foreach ($diagnosis->result_array() as $key => $data) {
                if ($key == 0) {
                    $diagnosis_list = '- ' . $data['pemeriksaan_diagnosis_name'];
                } else {
                    $diagnosis_list .= '<br>- ' . $data['pemeriksaan_diagnosis_name'];
                }
            }
        }

        return $diagnosis_list;
    }

    public function get_pemeriksaan_medis($pemeriksaan_id)
    {
        $pemeriksaan_medis = $this->mainModel->get_pemeriksaan_medis($pemeriksaan_id);

        $pemeriksaan_medis_list = '';
        if ($pemeriksaan_medis) {
            foreach ($pemeriksaan_medis->result_array() as $key => $data) {
                if ($key == 0) {
                    $pemeriksaan_medis_list = $data['pemeriksaan_pemeriksaan'];
                } else {
                    $pemeriksaan_medis_list .= '<br>' . $data['pemeriksaan_pemeriksaan'];
                }
            }
        }

        return $pemeriksaan_medis_list;
    }

    public function get_pemeriksaan_laborat($pemeriksaan_id)
    {
        $pemeriksaan_laborat = $this->mainModel->get_pemeriksaan_laborat($pemeriksaan_id);

        $pemeriksaan_laborat_list = '-';
        if ($pemeriksaan_laborat) {
            foreach ($pemeriksaan_laborat->result_array() as $key => $data) {
                if ($key == 0) {
                    $pemeriksaan_laborat_list = '- ' . $data['pendaftaran_layanan_pemeriksaan_name'];
                } else {
                    $pemeriksaan_laborat_list .= '<br>- ' . $data['pendaftaran_layanan_pemeriksaan_name'];
                }
            }
        }

        return $pemeriksaan_laborat_list;
    }

    public function get_resep($pemeriksaan_id)
    {
        $resep = $this->mainModel->get_resep($pemeriksaan_id);

        $resep_list = '-';
        if ($resep) {
            foreach ($resep->result_array() as $key => $data) {
                if ($key == 0) {
                    $resep_list = '- ' . $data['pemeriksaan_obat_name'];
                } else {
                    $resep_list .= '<br>- ' . $data['pemeriksaan_obat_name'];
                }
            }
        }

        return $resep_list;
    }

    public function export() {
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
	
		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$file        = APPPATH . 'template/laporan/kunjungan-pasien.xlsx';
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

            // 'diagnosis'             => $this->get_diagnosis($pemeriksaan_id),
            // 'pemeriksaan_medis'     => $pemeriksaan_pemeriksaan,
            // 'pemeriksaan_laborat'   => $this->get_pemeriksaan_laborat($pemeriksaan_id),
            // 'resep_obat'            => $this->get_resep($pemeriksaan_id),

			$resep                  = $this->mainModel->get_resep($pemeriksaan_id)->result_array();
			$diagnosis              = $this->mainModel->get_diagnosis($pemeriksaan_id)->result_array();
            $pemeriksaan_laborat    = $this->mainModel->get_pemeriksaan_laborat($pemeriksaan_id)->result_array(); 

            $merge = array();
			array_push($merge, count($diagnosis),count($resep), count($pemeriksaan_laborat));

            $merge_max = max($merge);

			$merge_fix = $merge_max > 1 ? ($merge_max - 1) : 0;
            
			$sheet->setCellValue('A'.$numrow, $no++);
			$sheet->setCellValue('B'.$numrow, date('d F Y', strtotime($pendaftaran_date)));
			$sheet->setCellValue('C'.$numrow, $pemeriksaan_shift_name);
			$sheet->setCellValue('D'.$numrow, $pendaftaran_pasien_rm);
			$sheet->setCellValue('E'.$numrow, $pendaftaran_pasien_name);
			$sheet->setCellValue('F'.$numrow, date('d F Y', strtotime($pendaftaran_pasien_birthdate)));
			$sheet->setCellValue('G'.$numrow, $pendaftaran_pasien_birthplace);
			$sheet->setCellValue('H'.$numrow, $pendaftaran_pasien_penanggung_jawab_telp);
			$sheet->setCellValue('I'.$numrow, $pendaftaran_penjamin_nama);
            
        	$baris_diagnosis = $numrow;
            foreach ($diagnosis as $key => $data) {
                $sheet->setCellValue('J'.$baris_diagnosis, $data['pemeriksaan_diagnosis_name']);
                $baris_diagnosis++;
            }
            $baris_diagnosis--;
            
            $sheet->setCellValue('K'.$numrow, $pemeriksaan_pemeriksaan);
            
            $baris_pemeriksaan_laborat = $numrow;
            foreach ($pemeriksaan_laborat as $key => $data) {
                $sheet->setCellValue('L'.$baris_pemeriksaan_laborat, $data['pendaftaran_layanan_pemeriksaan_name']);
                $baris_pemeriksaan_laborat++;
            }
            $baris_pemeriksaan_laborat--;
            
            $baris_resep = $numrow;
            foreach ($resep as $key => $data) {
                $sheet->setCellValue('M'.$baris_resep, $data['pemeriksaan_obat_name']);
                $baris_resep++;
            }
            $baris_resep--;

			if ($merge_max > 1) {
                $sheet->mergeCells('A' . $numrow . ':A' . ($merge_fix + $numrow));
				$sheet->mergeCells('B' . $numrow . ':B' . ($merge_fix + $numrow));
				$sheet->mergeCells('C' . $numrow . ':C' . ($merge_fix + $numrow));
				$sheet->mergeCells('D' . $numrow . ':D' . ($merge_fix + $numrow));
				$sheet->mergeCells('E' . $numrow . ':E' . ($merge_fix + $numrow));
				$sheet->mergeCells('F' . $numrow . ':F' . ($merge_fix + $numrow));
				$sheet->mergeCells('G' . $numrow . ':G' . ($merge_fix + $numrow));
				$sheet->mergeCells('H' . $numrow . ':H' . ($merge_fix + $numrow));
				$sheet->mergeCells('I' . $numrow . ':I' . ($merge_fix + $numrow));
				// $sheet->mergeCells('K' . $numrow . ':K' . ($merge_fix + $numrow));
			}
            
			$numrow += ($merge_fix);
			$numrow++;
		}
		$numrow--;

    	$sheet->getStyle('A'.$start_baris.':I'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$sheet->getStyle('A'.$start_baris.':I'.$numrow)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$sheet->getStyle('J'.$start_baris.':M'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$sheet->getStyle('J'.$start_baris.':M'.$numrow)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$sheet->getStyle('A'.$start_baris.':M'.$numrow)->applyFromArray(
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
		header("Content-Disposition: attachment; filename=Laporan-Klinik-Kunjungan-Pasien-".date('d-m-Y').".xls");
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