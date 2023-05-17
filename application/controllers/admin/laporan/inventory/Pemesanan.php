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
class pemesanan extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/laporan/inventory/' . $_model);
        $this->mainModel = new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Laporan Inventory Pemesanan";
    }

    public function index()
    {
        redirect(base_url('admin/laporan/inventory/' . __CLASS__ . '/data'));
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

        $st->paint($this->template . '/' . $this->module, '/laporan/inventory/' . __function__ . '_' . __class__, $common);
    }

    public function get_datatable()
    {
        header("Content-type: application/json");
        $data = $this->mainModel->get_data();
        $no = 1;
        foreach ($data['data'] as $value) {
            $entry = array(
                'no' => $no,
                'no_sp' => $value['pemesanan_no_sp'],
                'tanggal_pemesanan' => $value['pemesanan_tanggal'],
                'supplier' => $value['supplier_name'],
                'petugas' => $value['user_karyawan'],
                'grand_total' => $data['grand_total'][$value['pemesanan_id']],
                'item_id' => $value['id_barang'],
                'item_barcode' => $value['detail_pemesanan_barcode'],
                'nama_barang' => $value['detail_pemesanan_nama_barang'],
                'kemasan' => $value['detail_pemesanan_kemasan'],
                'jumlah' => $value['detail_pemesanan_qty'],
                'harga' => $value['harga_per_item'],
                'total' => $value['total'],
            );
            $no++;
            $json_data['data'][] = $entry;
        }
        echo json_encode($json_data);
    }

    public function export()
    {

        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $objPHPExcel = new PHPExcel();
        $file        = APPPATH . 'template/pemesanan.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($file);
        $sheet       = $objPHPExcel->getSheet();

        $browser = $_SERVER['HTTP_USER_AGENT'];
        $get_browser = $this->get_browser_name($browser);

        // Panggil model
        $data = $this->mainModel->get_data();
        $no = 1;
        foreach ($data['data'] as $value) {
            $entry = array(
                'no' => $no,
                'no_sp' => $value['pemesanan_no_sp'],
                'tanggal_pemesanan' => $value['pemesanan_tanggal'],
                'supplier' => $value['supplier_name'],
                'petugas' => $value['user_karyawan'],
                'grand_total' => $data['grand_total'][$value['pemesanan_id']],
                'item_id' => $value['id_barang'],
                'item_barcode' => $value['detail_pemesanan_barcode'],
                'nama_barang' => $value['detail_pemesanan_nama_barang'],
                'kemasan' => $value['detail_pemesanan_kemasan'],
                'jumlah' => $value['detail_pemesanan_qty'],
                'harga' => $value['harga_per_item'],
                'total' => $value['total'],
            );
            $no++;
            $json_data['data'][] = $entry;
        }

        $query = $json_data['data'];
        $grand_total = $data['count_grand_total'];
        $merge = $data['same'];
        $parent = $data['parent'];
        $no = 1;
        $numrow = 6;
        $start_baris = $numrow;
        $total = 0;
        $count_merge = 0;
        $rowspan = 6;
        $date = date('d F Y H:i:s');

        // Lakukan looping
        foreach ($query as $row) {
            foreach ($row as $variable => $value) {
                ${$variable} = $value;
            }

            // foreach ($parent as $value) {
            //     $count_merge = $merge[$value['pemesanan_id']] - 1;
            //     $total = $rowspan + $count_merge;
            //     $sheet->mergeCellsByColumnAndRow(1, $rowspan, 1, $total);
            // }

            $sheet->mergeCellsByColumnAndRow(2, 2, 3, 2);
            $sheet->mergeCellsByColumnAndRow(2, 3, 3, 3);
            $sheet->mergeCellsByColumnAndRow(2, 4, 3, 4);

            $sheet->setCellValue('C2', $date);
            $sheet->setCellValue('C3', $get_browser);
            $sheet->setCellValue('C4', $this->angka($grand_total));


            $sheet->setCellValue('A' . $numrow, $no++);
            $sheet->setCellValue('B' . $numrow, $no_sp);
            $sheet->setCellValue('C' . $numrow, $tanggal_pemesanan);
            $sheet->setCellValue('D' . $numrow, $supplier);
            $sheet->setCellValue('E' . $numrow, $petugas);
            $sheet->setCellValue('F' . $numrow, $grand_total);
            $sheet->setCellValue('G' . $numrow, $item_id);
            $sheet->setCellValue('H' . $numrow, $item_barcode);
            $sheet->setCellValue('I' . $numrow, $nama_barang);
            $sheet->setCellValue('J' . $numrow, $kemasan);
            $sheet->setCellValue('K' . $numrow, $jumlah);
            $sheet->setCellValue('L' . $numrow, $harga);
            $sheet->setCellValue('M' . $numrow, $total);

            $numrow++;
            // $rowspan++;
        }

        $numrow--;

        $sheet->getStyle('C2:D2')->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C3:D3')->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C4:D4')->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A' . $start_baris . ':M' . $numrow)->getAlignment()->setWrapText(true)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A' . $start_baris . ':E' . $numrow)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F' . $start_baris . ':G' . $numrow)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H' . $start_baris . ':J' . $numrow)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('K' . $start_baris . ':M' . $numrow)->getAlignment()->setWrapText(true)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('A' . $start_baris . ':M' . $numrow)->applyFromArray(
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
        header("Content-Disposition: attachment; filename=Pemesanan-" . date('d-m-Y') . ".xls");
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $write->save('php://output');
    }

    function get_browser_name($user_agent)
    {
        $t = strtolower($user_agent);
        $t = " " . $t;
        if (strpos($t, 'opera') || strpos($t, 'opr/')) return 'Opera';
        elseif (strpos($t, 'edge')) return 'Edge';
        elseif (strpos($t, 'chrome')) return 'Chrome';
        elseif (strpos($t, 'safari')) return 'Safari';
        elseif (strpos($t, 'firefox')) return 'Firefox';
        elseif (strpos($t, 'msie') || strpos($t, 'trident/7')) return 'Internet Explorer';
        return 'Unkown';
    }
}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */