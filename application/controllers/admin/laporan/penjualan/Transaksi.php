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
class transaksi extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/penjualan/' . $_model);
        $this->mainModel = new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Laporan Transaksi";
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
        $result = $this->mainModel->data_list_obat();
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
            'data' => array()
        );

        $res = array();
        $no = 1;
        $tagihan = 0;
        $total_trx = 0;

        foreach ($query as $key => $row) {
            foreach ($row as $variable => $value) {
                ${$variable} = $value;
            }

            $is_resep = '1';
            $non_resep = 0;
            $resep = 0;
            $diskon = 0;

            $nama_dokter = $this->dokter($kasir_pendaftaran_id);

            if ($is_resep == $pemeriksaan_obat_resep) {
                $non_resep = $pemeriksaan_obat_price;
            } else {
                $resep = $pemeriksaan_obat_price;
            }

            if ($kasir_disc_persen > 0) {
                $diskon = $kasir_disc;
            } else {
                $diskon = $kasir_disc_rupiah;
            }

            if ($kasir_total != $kasir_bayar) {
                $tagihan      = $kasir_total - $kasir_bayar;
            }else{
                $tagihan = 0;
            }

            if (!isset($res[$kasir_id])) {
                $res[$kasir_id] = array(
                    'no'                => $no,
                    'id'                => $pemeriksaan_obat_id,
                    'invoice'           => $kasir_invoice,
                    'tanggal'           => date_format(new DateTime($kasir_date), 'd F Y'),
                    'total_non_resep'   => $this->angka($non_resep),
                    'total_resep'       => $this->angka($resep),
                    'tuslah'            => $this->angka($kasir_tuslah),
                    'embalage'          => $this->angka($kasir_embalage),
                    'ppn'               => '11',
                    'total_transaksi'   => $this->angka($kasir_total),
                    'total_diskon'      => $this->angka($diskon),
                    'total_tagihan'     => $this->angka($tagihan),
                    'total_dibayar'     => $this->angka($kasir_bayar),
                    'sisa_tagihan'      => $this->angka($tagihan),
                    'kasir'             => $kasir_update_by,
                    'dokter'            => ($nama_dokter != '') ? $nama_dokter : '-',
                    'pasien'            => $this->pasien($kasir_pendaftaran_id),
                    'nama_barang'       => $this->list_obat($pemeriksaan_obat_pemeriksaan_id)
                );
                $total_trx += $kasir_total;
                $no++;
            } else {
                if ($res[$kasir_id]['id'] == $row['kasir_pemeriksaan_id']) {
                    $res[$kasir_id]['total_non_resep'] += $non_resep;
                    $res[$kasir_id]['total_resep'] += $resep;
                }
                $total_trx = $kasir_total;
            }
        }
        $json_data['grand_total'] = 'Rp. '.$this->angka($total_trx);
        $result = array_values($res);
        $json_data['data'] = $result;
        echo json_encode($json_data);
    }

    public function list_obat($id)
    {
        $obat = $this->mainModel->get_obat($id);
        $obat_list = '';
        if ($obat) {
            foreach ($obat->result_array() as $key => $data) {
                if ($key == 0) {
                    $obat_list = $data['pemeriksaan_obat_name'];
                } else {
                    $obat_list .= '<br>' . $data['pemeriksaan_obat_name'] . '<br>';
                }
            }
        }
        return $obat_list;
    }

    public function pasien($id)
    {
        $pasien = $this->mainModel->get_pasien($id);
        $nama_pasien = '';

        foreach ($pasien->result() as $key => $value) {
            $nama_pasien = $value->pendaftaran_pasien_name;
        }

        return $nama_pasien;
    }

    public function dokter($id)
    {
        $dokter = $this->mainModel->get_dokter($id);
        $nama_dokter = '';

        foreach ($dokter->result() as $key => $value) {
            $nama_dokter = $value->pendaftaran_layanan_dokter_name;
        }

        return $nama_dokter;
    }

    public function export() {
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
	
		// Panggil class PHPExcel nya
		$objPHPExcel = new PHPExcel();
		$file        = APPPATH . 'template/laporan/laporan-transaksi.xlsx';
		$objPHPExcel = \PHPExcel_IOFactory::load($file);
		$sheet       = $objPHPExcel->getSheet();
	
		// Panggil model
		$result = $this->mainModel->data_list_obat();
		$query = $result['query'];
		$no = 1;
		$numrow = 6;
		$start_baris = $numrow;

        $is_resep = '1';
		$total_transaksi = 0; 
		$non_resep = 0; 
		$resep = 0; 
        $grand_total = 0;

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

            //non_resep / resep 
            if ($is_resep == $pemeriksaan_obat_resep) {
                $non_resep = $pemeriksaan_obat_price;
            } else {
                $resep = $pemeriksaan_obat_price;
            }

            //Diskon
            if ($kasir_disc_persen > 0) {
                $diskon = $kasir_disc;
            } else {
                $diskon = $kasir_disc_rupiah;
            }

            //Piutang
            if ($kasir_total != $kasir_bayar) {
                $tagihan      = $kasir_total - $kasir_bayar;
            }else{
                $tagihan = 0;
            }

			$nama_dokter = $this->dokter($kasir_pendaftaran_id);
			$obat = $this->mainModel->get_obat($pemeriksaan_obat_pemeriksaan_id)->result_array();
            $nama_dokter = ($nama_dokter != '') ? $nama_dokter : '-';

			$merge = count($obat);
			$merge_fix = $merge > 1 ? ($merge-1) : 0;

			$sheet->setCellValue('A'.$numrow, $no++);
			$sheet->setCellValue('B'.$numrow, $kasir_invoice);
			$sheet->setCellValue('c'.$numrow, date_format(new DateTime($kasir_date), 'd F Y'));
			$sheet->setCellValue('D'.$numrow, $non_resep);
			$sheet->setCellValue('E'.$numrow, $resep);
			$sheet->setCellValue('F'.$numrow, $kasir_tuslah);
			$sheet->setCellValue('G'.$numrow, $kasir_embalage);
			$sheet->setCellValue('H'.$numrow, '11');
			$sheet->setCellValue('I'.$numrow, $kasir_total);
			$sheet->setCellValue('J'.$numrow, $diskon);
			$sheet->setCellValue('K'.$numrow, $tagihan);
			$sheet->setCellValue('L'.$numrow, $kasir_bayar);
			$sheet->setCellValue('M'.$numrow, $tagihan);
			$sheet->setCellValue('N'.$numrow, $kasir_update_by);
			$sheet->setCellValue('O'.$numrow, $nama_dokter);
			$sheet->setCellValue('P'.$numrow, $this->pasien($kasir_pendaftaran_id));

            
        	$baris_hasil = $numrow;
			foreach ($obat as $key => $data) {
                $sheet->setCellValue('Q'.$baris_hasil, $data['pemeriksaan_obat_name']);
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
				$sheet->mergeCells('I' . $numrow . ':I' . ($merge_fix + $numrow));
				$sheet->mergeCells('J' . $numrow . ':J' . ($merge_fix + $numrow));
				$sheet->mergeCells('K' . $numrow . ':K' . ($merge_fix + $numrow));
				$sheet->mergeCells('L' . $numrow . ':L' . ($merge_fix + $numrow));
				$sheet->mergeCells('M' . $numrow . ':M' . ($merge_fix + $numrow));
				$sheet->mergeCells('N' . $numrow . ':N' . ($merge_fix + $numrow));
				$sheet->mergeCells('O' . $numrow . ':O' . ($merge_fix + $numrow));
				$sheet->mergeCells('P' . $numrow . ':P' . ($merge_fix + $numrow));
			}

			$numrow+=($merge_fix);
			$numrow++;
		}

        $total_transaksi = $this->db->query('SELECT SUM(kasir_total) AS total_transaksi FROM trx_pemeriksaan_kasir')->result();

		$sheet->setCellValue('C3',  $total_transaksi[0]->total_transaksi);

		$numrow--;
    	$sheet->getStyle('A'.$start_baris.':Q'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$sheet->getStyle('A'.$start_baris.':Q'.$numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A'.$start_baris.':Q'.$numrow)->applyFromArray(
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
		header("Content-Disposition: attachment; filename=Laporan-Transaksi-".date('d-m-Y').".xls");
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