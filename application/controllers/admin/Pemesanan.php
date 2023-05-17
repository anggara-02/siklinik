<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_admin.php';
class pemesanan extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/' . __class__ . '/' . $_model);
        $this->keyAdmin = common_lib::keySession('admin');
        $this->mainModel = new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Pemesanan";
    }

    public function index()
    {
        redirect(base_url('admin/' . __class__ . '/data'));
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

        foreach ($result['detailData'] as $val) {
            $id = $val->detail_pemesanan_pemesanan_id;
            if (!isset($data[$id])) {
                $data[$id] = array();
            }
            $data[$id][] = array(
                'barcode'      => $val->detail_pemesanan_barcode,
                'nama_barang'  => $val->detail_pemesanan_nama_barang,
                'kemasan'      => $val->detail_pemesanan_kemasan,
                'qty'          => $val->detail_pemesanan_qty
            );
        };

        foreach ($result['parrentData'] as $value) {
            $pemesanan_id = $value->pemesanan_id;
            if (isset($data[$value->pemesanan_id])) {
                $item = '';
                foreach ($data[$value->pemesanan_id] as $k => $v) {
                    if ($k == 0) {
                        $item = $v['nama_barang'] . '</br>';
                        $kemasan = $v['kemasan'] . '</br>';
                        $qty = $v['qty'] . '</br>';
                    } else {
                        $item .= $v['nama_barang'] . '</br>';
                        $kemasan .= $v['kemasan'] . '</br>';
                        $qty .= $v['qty'] . '</br>';
                    }
                }
            } else {
                $item = '';
                $kemasan = '';
                $qty = '';
            }
            $no++;

            $action  = common_lib::hak_akses($this->access, 'edit', 'menu') == '1' ? '<a href="' . site_url('admin/' . __class__ . '/edit/' . $pemesanan_id . '') . '" style="margin-right:5px" class="btn btn-info btn-icon" data-index="' . $pemesanan_id . '"><i class="fa fa-edit"></i></a>' : '';
            $action .= common_lib::hak_akses($this->access, 'delete', 'menu') == '1' ? '<a href="javascript:void(0);" data-url="' . site_url('admin/' . __class__ . '/delete/' . $pemesanan_id . '') . '" style="margin-right:5px" class="btn btn-danger btn-icon btn-delete confirmation" data-index="' . $pemesanan_id . '" ><i class="fa fa-trash"></i></a>' : '';
            if ($value->pemesanan_jenis_sp != 'Narkotik') {
                $action .= common_lib::hak_akses($this->access, 'print', 'menu') == '1' ? '<a target="_blank" href="' . site_url('admin/' . __class__ . '/print_pdf/' . $pemesanan_id . '') . '" style="margin-right:5px" class="btn btn-warning btn-icon" data-index="' . $pemesanan_id . '" ><i class="fa fa-print"></i></a>' : '';
            }


            $json_data['data'][] = array(
                'no'        => $no,
                'id'        => $value->pemesanan_id,
                'action'    => $action,
                'no_sp'     => $value->pemesanan_no_sp,
                'jenis_sp'  => $value->pemesanan_jenis_sp,
                'tanggal'   => date('dd-mm-YY', strtotime($value->pemesanan_tanggal)),
                'supplier'  => $value->supplier_name,
                'item'      => $item,
                'kemasan'   => $kemasan,
                'jumlah'       => $qty,
            );
        };
        echo json_encode($json_data);
    }

    public function data()
    {
        $this->session->set_userdata("last_url", __class__ . '/' . __function__);
        $common = common_lib::getState($this);
        $common['title'] = ucfirst($this->class);
        $st = new Stencil();

        $st->slice('head_login');
        $common['class'] = __class__;
        $common['js_files'] = '';
        $common['css_files'] = '';
        $common['status'] = $_GET ? base64_decode($_GET['status']) : '';
        $common['supplier_arr'] = $this->common_lib->select_result('data_supplier', 'is_delete=0');
        $common['access'] = $this->access;

        $st->paint($this->template . '/' . $this->module, __class__ . '/' . __function__, $common);
    }

    public function add()
    {
        common_lib::hak_akses($this->access, __function__, 'controller');

        $this->session->set_userdata("last_url", __class__ . '/' . __function__);
        $common = common_lib::getState($this);
        $st = new Stencil();
        $st->slice('head_login');

        $common['class'] = __class__;
        $common['title'] = ucfirst($this->class);
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs([], $this->module);
        $common['supplier_arr'] = $this->common_lib->select_result('data_supplier', 'is_delete=0');
        $common['kemasan_arr'] = $this->common_lib->select_result('data_kemasan', 'is_delete=0');
        $common['pemesanan_id'] = '0';
        $common['access'] = $this->access;

        $st->paint($this->template . '/' . $this->module, __class__ . '/form', $common);
    }

    public function action_validation()
    {
        $no_sp = $_POST['no_SP'];
        $id = $_POST['pemesanan_id'];

        $sql = $this->db->query("
            SELECT pemesanan_no_sp, pemesanan_id FROM data_pemesanan WHERE pemesanan_no_sp = '$no_sp' AND is_delete='0'
        ");
        $exists = $sql->result_array();
        if ($sql->num_rows() > 0) {
            if ($id == $exists[0]['pemesanan_id']) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }
        } else {
            echo json_encode(true);
        }
    }

    public function after_save()
    {
        $this->session->set_flashdata('status', '200');
        $this->session->set_flashdata('sukses', 'Data berhasil di simpan');
        redirect('admin/pemesanan/data');
    }

    public function get_product_by_barcode()
    {
        $barcode = $this->input->get('barcode');

        $get_obat = $this->mainModel->get_obat($barcode);
        $get_alkes = $this->mainModel->get_alkes($barcode);
        $data = array();
        if (!empty($get_obat) || !empty($get_alkes)) {
            foreach ($get_obat as $rowArr) {
                $data['id'] = $rowArr->obat_id;
                $data['label'] = $rowArr->obat_name;
                $data['value'] = $rowArr->obat_name;
                $data['barcode'] = $rowArr->obat_barcode;
                $data['is_obat'] = 1;
            }

            foreach ($get_alkes as $rowArr) {
                $data['id'] = $rowArr->alkes_id;
                $data['label'] = $rowArr->alkes_name;
                $data['value'] = $rowArr->alkes_name;
                $data['barcode'] = $rowArr->alkes_barcode;
                $data['is_obat'] = 0;
            }
        } else {
            $data['status'] = FALSE;
        }
        echo json_encode($data);
    }

    public function get_obat()
    {
        $search = $this->input->get('term');
        $findAll_obat = $this->db->query('
            SELECT * FROM data_obat WHERE 1 AND 
            (obat_name LIKE "%' . $search . '%" OR obat_barcode LIKE "%' . $search . '%") 
            ORDER BY obat_id asc limit 15')->result_array();

        $findAll_alkes = $this->db->query('
            SELECT * FROM data_alkes WHERE 1 AND is_delete = 0 AND  
            (alkes_name LIKE "%' . $search . '%" OR alkes_barcode LIKE "%' . $search . '%") 
            ORDER BY alkes_id asc limit 15')->result_array();

        $data_obat = array();
        if (!empty($findAll_obat) || !empty($findAll_alkes)) {
            $no = 1;
            foreach ($findAll_obat as $rowArr) {
                $data_obat[$no]['id'] = $rowArr['obat_id'];
                // $data_obat[$no]['label'] = $rowArr['obat_barcode'] . '-' . $rowArr['obat_name'];
                $data_obat[$no]['label'] = $rowArr['obat_name'];
                $data_obat[$no]['value'] = $rowArr['obat_name'];
                $data_obat[$no]['barcode'] = $rowArr['obat_barcode'];
                $data_obat[$no]['is_obat'] = 1;
                $no++;
            }

            foreach ($findAll_alkes as $rowArr) {
                $data_obat[$no]['id'] = $rowArr['alkes_id'];
                // $data_obat[$no]['label'] = $rowArr['alkes_barcode'] . '-' . $rowArr['alkes_name'];
                $data_obat[$no]['label'] = $rowArr['alkes_name'];
                $data_obat[$no]['value'] = $rowArr['alkes_name'];
                $data_obat[$no]['barcode'] = $rowArr['alkes_barcode'];
                $data_obat[$no]['is_obat'] = 0;
                $no++;
            }
        }
        echo json_encode($data_obat);
    }

    public function get_kemasan()
    {
        $id = $this->input->post('id_item');
        $is_obat = $this->input->post('is_obat');
        $result = [];
        if ($is_obat == 1) {
            /* Kemasan Obat WHERE id */
            $sql = "SELECT data_obat.*, kemasan_kecil.kemasan_name as kecil, kemasan_sedang.kemasan_name as sedang, kemasan_besar.kemasan_name as besar
                FROM data_obat
                LEFT JOIN data_kemasan as kemasan_kecil ON data_obat.obat_kemasan_kecil_id = kemasan_kecil.kemasan_id
                LEFT JOIN data_kemasan as kemasan_sedang ON data_obat.obat_kemasan_sedang_id = kemasan_sedang.kemasan_id
                LEFT JOIN data_kemasan as kemasan_besar ON data_obat.obat_kemasan_besar_id = kemasan_besar.kemasan_id
                WHERE data_obat.obat_id = '$id'
                ORDER BY data_obat.obat_id 
                LIMIT 10";
            $query = $this->db->query($sql);

            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => '',
                    'text' => '',
                );
                $result[] = array(
                    'id' => $value['obat_kemasan_kecil_id'],
                    'text' => $value['kecil'],
                );
                $result[] = array(
                    'id' => $value['obat_kemasan_sedang_id'],
                    'text' => $value['sedang'],
                );
                $result[] = array(
                    'id' => $value['obat_kemasan_besar_id'],
                    'text' => $value['besar'],
                );
            }
        } else {
            /* Kemasan Alkes WHERE id */
            $sql = "SELECT * FROM data_alkes WHERE 1 AND alkes_id = '$id' ORDER BY alkes_id LIMIT 10";
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $value) {
                // $result[] = array(
                //     'id' => '',
                //     'text' => '',
                // );
                $result[] = array(
                    'id' => $value['alkes_id'],
                    'text' => $value['alkes_kemasan'],
                );
            }
        }
        echo json_encode($result);
    }

    public function trx_save()
    {
        $pemesanan_id = $this->input->post('pemesanan_id');
        $no_sp = $this->input->post('no_sp');
        $jenis_sp = $this->input->post('jenis_sp');
        $tanggal = $this->input->post('tanggal');
        $supplier = $this->input->post('supplier');
        $detail_barang = $this->input->post('detail_barang');

        $result = $result = $this->mainModel->trx_save($no_sp, $jenis_sp, $tanggal, $supplier, $detail_barang, $pemesanan_id);
        if ($result['status'] == 200) {
            $result['url'] = $this->module . '/' . __class__ . '/data?status=' . $result['status'] . '&flag=' . base64_encode($result['message']);
        }

        echo json_encode($result);
    }

    public function trx_edit()
    {
        $pemesanan_id = $this->input->get('pemesanan_id');
        $result = $this->mainModel->get_data($pemesanan_id);
        // print_r($result);die();
        echo json_encode($result);
    }

    public function edit($id = 0)
    {
        $has_exist = $this->common_lib->select_row('data_pemesanan', 'pemesanan_id=' . intval($id));

        if (empty($has_exist)) {
            $this->session->set_flashdata('status', '500');
            $this->session->set_flashdata('gagal', 'ID tidak ditemukan');
            redirect('admin/pemesanan/data');
        }

        $this->session->set_userdata("last_url", __class__ . '/' . __function__);
        $common = common_lib::getState($this);
        $st = new Stencil();
        $st->slice('head_login');

        $breadcrumbs_array = array();
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array, $this->module);

        $common['pemesanan_id'] = $id;
        $common['title'] = ucfirst($this->class);
        $common['class'] = __class__;
        $common['js_files'] = '';
        $common['css_files'] = '';
        $common['supplier_arr'] = $this->common_lib->select_result('data_supplier', 'is_delete=0');
        $common['access'] = $this->access;

        $st->paint($this->template . '/' . $this->module, __class__ . '/form', $common);
    }

    public function delete($id = 0)
    {
        $has_exist = $this->common_lib->select_row('data_pemesanan', 'pemesanan_id=' . intval($id));
        if (empty($has_exist)) {
            $this->session->set_flashdata('status', '500');
            $this->session->set_flashdata('sukses', 'Data tidak ditemukan');
            redirect('admin/pemesanan/data');
        }

        $result = $this->common_lib->delete_semu('data_pemesanan', array('pemesanan_id' => intval($id)));
        $this->session->set_flashdata('status', '200');
        $this->session->set_flashdata('sukses', $result['message']);
        redirect('admin/pemesanan/data');
    }

    public function print_pdf($id = 0)
    {
        include APPPATH . 'third_party/tcpdf/tcpdf/tcpdf.php';

        $has_exist = $this->common_lib->select_row('data_pemesanan', 'pemesanan_id=' . intval($id));
        $result = $this->mainModel->get_data($id);

        //Get data in Setting
        $setting = $this->common_lib->select_row('setting');

        $res_setting = array(
            'nama_klinik'   => $setting['nama_klinik'],
            'no_telpon'     => $setting['no_telpon'],
            'email'         => $setting['email'],
            'alamat'        => $setting['alamat'],
            'apoteker'      => $setting['apoteker'],
            'sipa'          => $setting['sipa'],
            'sia'           => $setting['sia'],
            'logo'          => $setting['logo']
        );

        $data['setting'] = $res_setting;
        $data['jenis_sp'] = $has_exist['pemesanan_jenis_sp'];
        $data['data'] = $result['data'][0];

        // $data['jenis_sp'] = 'psikotropik';

        $html = '';

        if (strtolower($data['jenis_sp']) != 'generik') {
            // Pengajuan pemesanan berdasarkan jenis SP 
            if ($data['jenis_sp'] == 'oot') {
                $data['judul'] = 'SURAT PESANAN OBAT-OBAT TERTENTU (OOT)';
                $data['text_pengajuan_pemesanan'] = 'OOT(Obat-Obat tertentu) ';
                $data['text_tujuan_pengajuan'] = 'Untuk keperluan Apotek';
            } else if ($data['jenis_sp'] == 'psikotropik') {
                $data['judul'] = 'SURAT PESANAN PSIKOTROPIKA';
                $data['text_pengajuan_pemesanan'] = 'Psikotropika ';
                $data['text_tujuan_pengajuan'] = 'Psikotropika tersebut akan diguakan untuk memenuhi kebutuhan:';
            } else {
                $data['judul'] = 'SURAT PESANAN OBAT MENGANDUNG PREKURSOR FARMASI';
                $data['text_pengajuan_pemesanan'] = 'obat mengandung Prekursor Farmasi ';
                $data['text_tujuan_pengajuan'] = 'Untuk keperluan Apotek';
            }

            $html = $this->load->view('free/admin/template_print_jenis_sp.php', $data, true);
        } else {
            $data['judul'] = 'SURAT PESANAN';
            $data['text_tujuan_pengajuan'] = 'obat-obatan keperluan Apotek';
            $html = $this->load->view('free/admin/template_print_reguler_sp', $data, true);
        }

        /* TCPDF START */
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION[$this->keyAdmin]['user_karyawan'] . '(' . $_SESSION[$this->keyAdmin]['user_sip'] ?  $_SESSION[$this->keyAdmin]['user_sip'] : '-' . ')');
        $pdf->SetTitle($data['judul']);
        $pdf->SetSubject($data['text_tujuan_pengajuan']);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage(PDF_ORIENTATION, PDF_SIZE);

        $pdf->SetFont("times", "", 12);
        $pdf->writeHTML($html, true, false, false, false, '');

        $pdf->lastPage();

        $pdf->Output($data['judul'] . "_" . date("YmdHis") . ".pdf", "I", "_blank");
        /* TCPDF END */
    }
}
