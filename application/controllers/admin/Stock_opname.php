<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_admin.php';
class stock_opname extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/' . __class__ . '/' . $_model);
        $this->mainModel = new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Stock Opname";
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
                } else {
                    $nama_barang    .= '' . $v['nama_barang'] . '</br>';
                    $batch          .= '' . $v['batch'] . '</br>';
                    $harga_satuan   .= '' . $v['harga_satuan'] . '</br>';
                    $sebelum        .= '' . $v['sebelum'] . '</br>';
                    $sesudah        .= '' . $v['sesudah'] . '</br>';
                    $selisih        .= '' . $v['selisih'] . '</br>';
                }
            }

            $no++;
            
            $action  = common_lib::hak_akses($this->access, 'edit', 'menu') == '1' ? '<a href="' . site_url('admin/' . __class__ . '/view/' . $so_id . '') . '" style="margin-right:5px" class="btn btn-info btn-icon" data-index="' . $so_id . '"><i class="fa fa-eye"></i></a>' : '';
            // $action .= common_lib::hak_akses($this->access,'delete','menu')=='1'?'<a href="javascript:void(0);" data-url="'.site_url('admin/'.__class__.'/delete/'.$so_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation"><i class="fa fa-trash"></i></a>':'';
            
            $json_data['data'][] = array(
                'no'            => $no,
                'id'            => $value->so_id,
                'action'        => $action,  
                'kode_so'       => $value->kode_so,
                'tanggal_so'    => $this->format_tanggal($value->tanggal_so),
                'keterangan'    => $value->keterangan,
                'nama_barang'   => $nama_barang,
                'batch'         => $batch,
                'harga_satuan'  => $harga_satuan,
                'sebelum'       => $sebelum,
                'sesudah'       => $sesudah,
                'selisih'       => $selisih,
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
        $common['access'] = $this->access;
        $common['so_id'] = 0;

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
        $common['tanggal'] = date('Y-m-d');
        $common['so_id'] = '0';
        $common['access'] = $this->access;

        $st->paint($this->template . '/' . $this->module, __class__ . '/form', $common);
    }

    public function view($id)
    {
        $has_exist = $this->common_lib->select_row('data_so', 'so_id=' . intval($id));
        if (empty($has_exist)) {
            $this->session->set_flashdata('status', '500');
            $this->session->set_flashdata('sukses', 'Data tidak ditemukan.');
            redirect('admin/stock_opname/data');
        }

        $this->session->set_userdata("last_url", __class__ . '/' . __function__);
        $common = common_lib::getState($this);
        $st = new Stencil();
        $st->slice('head_login');

        $breadcrumbs_array = array();
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array, $this->module);

        $common['so_id'] = $id;
        $common['title'] = ucfirst($this->class);
        $common['tanggal'] = date('Y-m-d');
        $common['class'] = __class__;
        $common['supplier_arr'] = $this->common_lib->select_result('data_supplier', 'is_delete=0');
        $common['access'] = $this->access;

        $st->paint($this->template . '/' . $this->module, __class__ . '/form', $common);
    }

    public function after_save()
    {
        $this->session->set_flashdata('status', '200');
        $this->session->set_flashdata('sukses', 'Data berhasil di simpan');
        redirect('admin/stock_opname/data');
    }

    public function get_stok()
    {
        $date = date('Y-m-d');
        $search = $this->input->get('term');
        $penyimpanan = $this->input->get('penyimpanan');

        $findAll_obat = $this->db->query("
            SELECT * FROM data_stok 
            LEFT JOIN data_obat obat ON obat.obat_barcode=data_stok.barcode
            WHERE 1 AND (barcode LIKE '%{$search}%' OR obat.obat_name LIKE '%{$search}%') AND (is_obat=1 AND expired_date > '{$date}' AND penyimpanan='{$penyimpanan}') 
            GROUP BY barcode ORDER BY obat_id asc limit 15
        ")->result_array();

        $findAll_alkes = $this->db->query("
            SELECT * FROM data_stok 
            LEFT JOIN data_alkes alkes ON alkes.alkes_barcode=data_stok.barcode
            WHERE 1 AND (barcode LIKE '%{$search}%' OR alkes.alkes_name LIKE '%{$search}%') AND (is_obat=0 AND penyimpanan='{$penyimpanan}')
            GROUP BY barcode ORDER BY alkes_id asc limit 15
        ")->result_array();

        $result = array();
        if (!empty($findAll_obat) || !empty($findAll_alkes)) {
            $no = 1;
            foreach ($findAll_obat as $rowArr) {
                $result[$no]['id']      = $rowArr['obat_id'];
                $result[$no]['label']   = $rowArr['obat_barcode'] . '-' . $rowArr['obat_name'];
                $result[$no]['value']   = $rowArr['obat_name'];
                $result[$no]['barcode'] = $rowArr['obat_barcode'];
                $result[$no]['is_obat'] = 1;
                $no++;
            }

            foreach ($findAll_alkes as $rowArr) {
                $result[$no]['id']      = $rowArr['alkes_id'];
                $result[$no]['label']   = $rowArr['alkes_barcode'] . '-' . $rowArr['alkes_name'];
                $result[$no]['value']   = $rowArr['alkes_name'];
                $result[$no]['barcode'] = $rowArr['alkes_barcode'];
                $result[$no]['is_obat'] = 0;
                $no++;
            }
        }
        echo json_encode($result);
    }

    public function get_kemasan()
    {
        $barcode = $this->input->post('barcode');
        $is_obat = $this->input->post('is_obat');
        $penyimpanan = $this->input->post('penyimpanan');
        $result = [];
        $result[] = ['id' => '', 'text' => '', 'is_obat' => ''];
        if ($is_obat == 1) {
            /* Kemasan Obat WHERE id */
            // $sql = "SELECT data_stok.*, kemasan.kemasan_name as kemasan FROM data_stok
            //     LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id = data_stok.id_kemasan
            //     WHERE data_stok.barcode = '$barcode' AND data_stok.is_obat = '$is_obat' AND data_stok.penyimpanan = '{$penyimpanan}' GROUP BY id_kemasan ORDER BY data_stok.id";
            // $query = $this->db->query($sql);

            // foreach ($query->result_array() as $value) {
            //     $result[] = array(
            //         'id' => $value['id_kemasan'],
            //         'text' => $value['kemasan'],
            //         'is_obat' => $is_obat,
            //     );
            // }

            /*Menampilkan Semua Kemasan */
            $kemasan_id = $this->common_lib->select_one('obat_kemasan_kecil_id', 'data_obat', 'obat_barcode =' . intval($barcode) . '');
            $kemasan_name = $this->common_lib->select_one('kemasan_name', 'data_kemasan', 'kemasan_id=' . intval($kemasan_id) . '');
            $result[] = array(
                'id' => $kemasan_id,
                'text' => $kemasan_name,
                'is_obat' => $is_obat,
            );

            $kemasan_id = $this->common_lib->select_one('obat_kemasan_sedang_id', 'data_obat', 'obat_barcode =' . intval($barcode) . '');
            $kemasan_name = $this->common_lib->select_one('kemasan_name', 'data_kemasan', 'kemasan_id=' . intval($kemasan_id) . '');
            if (intval($kemasan_id) > 0 && trim($kemasan_name) != '') {
                $result[] = array(
                    'id' => $kemasan_id,
                    'text' => $kemasan_name,
                    'is_obat' => $is_obat,
                );
            }
            $kemasan_id = $this->common_lib->select_one('obat_kemasan_besar_id', 'data_obat', 'obat_barcode =' . intval($barcode) . '');
            $kemasan_name = $this->common_lib->select_one('kemasan_name', 'data_kemasan', 'kemasan_id=' . intval($kemasan_id) . '');
            if (intval($kemasan_id) > 0 && trim($kemasan_name) != '') {
                $result[] = array(
                    'id' => $kemasan_id,
                    'text' => $kemasan_name,
                    'is_obat' => $is_obat,
                );
            }
        } else {
            /* Kemasan Alkes WHERE id */
            $sql = "SELECT data_stok.*, kemasan.kemasan_name as kemasan FROM data_stok
                LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id = data_stok.id_kemasan 
                WHERE data_stok.barcode = '$barcode' AND data_stok.is_obat = '$is_obat' AND data_stok.penyimpanan = '{$penyimpanan}' GROUP BY id_kemasan ORDER BY data_stok.id";
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => $value['id_kemasan'],
                    'text' => $value['kemasan'],
                    'is_obat' => $is_obat,
                );
            }
        }
        echo json_encode($result);
    }

    public function get_exp_date()
    {
        // $id_kemasan = $this->input->post('id_kemasan');
        $barcode = $this->input->post('barcode');
        $is_obat = $this->input->post('is_obat');
        $penyimpanan = $this->input->post('penyimpanan');

        $result = [];
        $result[] = ['id' => '', 'text' => '', 'is_obat' => ''];

        if ($is_obat == 1) {
            /* Kemasan Obat WHERE id */
            $sql = "SELECT data_stok.* FROM data_stok WHERE data_stok.barcode = '{$barcode}' AND data_stok.is_obat = '{$is_obat}' AND data_stok.penyimpanan = '{$penyimpanan}' GROUP BY expired_date ORDER BY data_stok.id";
            $query = $this->db->query($sql);

            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => $value['expired_date'],
                    'text' => $value['expired_date'],
                    'is_obat' => $is_obat,
                );
            }
        } else {
            /* Kemasan Alkes WHERE id */
            $sql = "SELECT data_stok.* FROM data_stok WHERE data_stok.barcode = '{$barcode}' AND data_stok.is_obat = '{$is_obat}' AND data_stok.penyimpanan = '{$penyimpanan}' GROUP BY expired_date ORDER BY data_stok.id";
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => $value['expired_date'],
                    'text' => $value['expired_date'],
                    'is_obat' => $is_obat,
                );
            }
        }
        echo json_encode($result);
    }

    public function get_batch()
    {
        $is_obat = $this->input->post('is_obat');
        $prefix = $this->input->post('prefix');
        $penyimpanan = $this->input->post('penyimpanan');
        $barcode = $this->input->post('barcode');
        $result = [];
        $result[] = ['id' => '', 'text' => ''];
        if ($is_obat == 1) {
            /* Batch Alkes WHERE id */
            $sql = "SELECT data_stok.* FROM data_stok WHERE data_stok.expired_date = '{$prefix}' AND data_stok.is_obat = {$is_obat} AND data_stok.penyimpanan = '{$penyimpanan}' AND data_stok.barcode = '{$barcode}' ORDER BY data_stok.id";

            $query = $this->db->query($sql);

            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => $value['batch'],
                    'text' => $value['batch'],
                );
            }
        } else {
            /* Batch Alkes WHERE id */
            $sql = "SELECT data_stok.* FROM data_stok WHERE data_stok.id_kemasan = '{$prefix}' AND data_stok.is_obat = {$is_obat} AND data_stok.penyimpanan = '{$penyimpanan}' AND data_stok.barcode = '{$barcode}' ORDER BY data_stok.id";
            $query = $this->db->query($sql);

            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => $value['batch'],
                    'text' => $value['batch'],
                );
            }
        }
        echo json_encode($result);
    }

    public function get_stok_konversi(){
        $is_obat = $this->input->post('is_obat');
        $id = $this->input->post('id');
        $kemasan = $this->input->post('kemasan');
        $penyimpanan = $this->input->post('penyimpanan');
        $batch = $this->input->post('batch');
        $barcode = $this->input->post('barcode');
        $ex_date = $this->input->post('ex_date');

        $result = [];
        if ($is_obat == 1) {
            $sql = "
                SELECT * 
                FROM data_obat 
                JOIN data_stok ON data_stok.id_barang = data_obat.obat_id 
                WHERE data_stok.barcode = '{$barcode}' 
                AND data_obat.obat_id = '{$id}'
                AND data_stok.penyimpanan = '{$penyimpanan}' 
                AND data_stok.batch = '{$batch}'
                AND data_stok.expired_date = '{$ex_date}'
                ORDER BY data_stok.id ASC
            ";

            $query = $this->db->query($sql);

            $kuantiti = 0;

            foreach ($query->result_array() as  $value) {
                if ($value['obat_kemasan_kecil_id'] == $kemasan) {
                    $kuantiti = $value['qty'] / $value['obat_kemasan_kecil_konversi'];
                } else if ($value['obat_kemasan_sedang_id'] == $kemasan) {
                    $kuantiti = $value['qty'] / $value['obat_kemasan_sedang_konversi'];
                } else if ($value['obat_kemasan_besar_id'] == $kemasan) {
                    $kuantiti = $value['qty'] / $value['obat_kemasan_besar_konversi'];
                }

                $result[$id]['id'] = $value['id'];
                $result[$id]['qty'] = floor($kuantiti);
            }
        }else{
            $sql = "
                SELECT stok.id AS stok_id, alkes.alkes_name, stok.barcode, stok.id_kemasan, stok.qty 
                FROM data_alkes alkes
                JOIN data_stok stok ON stok.id_barang = alkes.alkes_id 
                WHERE stok.barcode = '{$barcode}' 
                AND alkes.alkes_id = '{$id}'
                AND stok.penyimpanan = '{$penyimpanan}' 
                AND stok.batch = '{$batch}'
                ORDER BY stok.id ASC
            ";
            $query = $this->db->query($sql);

            foreach ($query->result_array() as  $value) {
                $result[$id]['id'] = $value['stok_id'];
                $result[$id]['qty'] = $value['qty'];
            }
        }
        echo json_encode($result);
    }

    public function get_stok_satuan()
    {
        $is_obat = $this->input->post('is_obat');
        $id_barang = $this->input->post('id');
        $kemasan = $this->input->post('kemasan');
        $penyimpanan = $this->input->post('penyimpanan');
        $batch = $this->input->post('batch');
        $barcode = $this->input->post('barcode');
        $ex_date = $this->input->post('ex_date');

        $result = [];
        if ($is_obat == 1) {
            /* Obat WHERE id */
            $sql = "SELECT data_stok.* , obat.obat_name AS nama_barang, obat.obat_id AS id_obat, kemasan.kemasan_name AS kemasan, data_stok.expired_date AS ex_date
                    FROM data_stok 
                    LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id = data_stok.id_kemasan
                    LEFT JOIN data_obat obat ON obat.obat_barcode=data_stok.barcode
                    WHERE obat.obat_id = '{$id_barang}' AND data_stok.barcode = '{$barcode}' AND data_Stok.penyimpanan = '{$penyimpanan}' AND data_stok.expired_date = '{$ex_date}' AND data_stok.batch = '{$batch}'";
            $query = $this->db->query($sql);

            foreach ($query->result_array() as $value) {

                $nama_kemasan = $this->kemasan_by_name($kemasan);
                $id_kemasan = $this->kemasan_by_id($kemasan);
                
                $result[$id_barang]['id'] = $value['id'];
                $result[$id_barang]['id_barang'] = $value['id_obat'];
                $result[$id_barang]['nama_barang'] = $value['nama_barang'];
                $result[$id_barang]['kemasan'] = $nama_kemasan;
                $result[$id_barang]['id_kemasan'] = $id_kemasan;
                $result[$id_barang]['ex_date'] = $value['ex_date'];
                $result[$id_barang]['batch'] = $value['batch'];
                $result[$id_barang]['qty'] = $value['qty'];
            }
        } else{
            /* Alkes WHERE id */
            $sql = "SELECT data_stok.* ,alkes.alkes_id AS alkes_id, alkes.alkes_name AS nama_barang, data_stok.id_kemasan AS kemasan
                    FROM data_stok 
                    LEFT JOIN data_alkes alkes ON alkes.alkes_barcode=data_stok.barcode
                    WHERE alkes.alkes_id = '{$id_barang}' AND data_stok.barcode = '{$barcode}' AND data_Stok.penyimpanan = '{$penyimpanan}' AND data_stok.batch = '{$batch}'";
            $query = $this->db->query($sql);
            
            foreach ($query->result_array() as $value) {
                $nama_kemasan = $this->kemasan_by_name($kemasan);
                $id_kemasan = $this->kemasan_by_id($kemasan);
                
                $result[$id_barang]['id'] = $value['id'];
                $result[$id_barang]['id_barang'] = $value['alkes_id'];
                $result[$id_barang]['nama_barang'] = $value['nama_barang'];
                $result[$id_barang]['kemasan'] = $nama_kemasan;
                $result[$id_barang]['id_kemasan'] = $id_kemasan;
                $result[$id_barang]['ex_date'] = '-';
                $result[$id_barang]['batch'] = $value['batch'];
                $result[$id_barang]['qty'] = $value['qty'];
            }
        }
        echo json_encode($result);
    }

    public function trx_save()
    {
        $type = $this->input->post('penyimpanan') == 'etalase' ? 'E' : 'G';
        $data['so_id'] = $this->input->post('so_id');
        $data['kode_so'] = $type . 'SO-' . date('Y') . date('m') . date('d');
        $data['tanggal_so'] = $this->input->post('tanggal_so');
        $data['penyimpanan'] = $this->input->post('penyimpanan');
        $data['keterangan'] = $this->input->post('keterangan');
        $data['detail_barang'] = $this->input->post('detail_barang');

        $result = $this->mainModel->trx_save($data);
        echo json_encode($result);
    }

    public function trx_edit()
    {
        $so_id = $this->input->get('so_id');
        $result = $this->mainModel->get_data($so_id);
        $parrentData = array();

        foreach ($result['detailData'] as $val) {
            $id = $val->id_so;
            if (!isset($data[$id])) {
                $data[$id] = array();
            }

            $data[$id][] = array(
                'so_detail_id'  => $val->so_detail_id,
                'id_so'         => $id,
                'nama_barang'   => $val->item,
                'kemasan'       => $val->kemasan,
                'ex_date'       => ($val->expired_date == '' ? '-' : $val->expired_date),
                'batch'         => $val->batch,
                'qty'           => $val->sebelum,
                'qty_after'     => $val->sesudah,
                'is_obat'       => $val->is_obat,
            );
        };

        foreach ($result['parrentData'] as $value) {
            if (isset($data[$value->so_id])) {
                $detail = $data[$value->so_id];
            } else {
                $detail = '';
            }
            $parrentData['data'][] = array(
                'id'            => $value->so_id,
                'tanggal_so'    => $value->tanggal_so,
                'keterangan'    => $value->keterangan,
                'penyimpanan'   => $value->penyimpanan,
                'detail'        => $detail,
            );
        };

        echo json_encode($parrentData);
    }

    public function delete($id = 0)
    {
        $has_exist = $this->common_lib->select_row('data_pemesanan', 'pemesanan_id=' . intval($id));
        if (empty($has_exist)) {
            redirect(base_url($this->module . '/' . __class__ . '/data?status=500&flag=' . base64_encode('Data tidak ditemukan.') . ''));
        }

        $result = $this->common_lib->delete_semu('data_pemesanan', array('pemesanan_id' => intval($id)));

        redirect(base_url($this->module . '/' . __class__ . '/data?status=' . $result['status'] . '&flag=' . base64_encode($result['message']) . ''));
    }

    //kemasan by name_kemasan
    public function kemasan_by_name($id)
    {
        // $id = $this->input->get('id');
        $kemasan_name = $this->common_lib->select_one('kemasan_name', 'data_kemasan', 'kemasan_id=' . intval($id) . '');

        // echo json_encode($kemasan_name);
        return $kemasan_name;
    }

    public function kemasan_by_id($id)
    {
        // $id = $this->input->get('id');
        $kemasan_id = $this->common_lib->select_one('kemasan_id', 'data_kemasan', 'kemasan_id=' . intval($id) . '');

        // echo json_encode($kemasan_name);
        return $kemasan_id;
    }

    public function search_kemasan()
    {
        $id = $this->input->get('id');
        $id_kemasan = $this->input->get('id_kemasan');
        $penyimpanan = $this->input->get('penyimpanan');
        $batch = $this->input->get('batch');
        $barcode = $this->input->get('barcode');
        $new_qty = $this->input->get('new_qty');

        $obat = "
                SELECT data_obat.*
                FROM data_obat 
                JOIN data_stok ON data_stok.id_barang = data_obat.obat_id 
                WHERE data_stok.barcode = '{$barcode}' 
                AND data_obat.obat_id = '{$id}'
                AND data_stok.penyimpanan = '{$penyimpanan}' 
                AND data_stok.batch = '{$batch}'
            ";

        $query_obat = $this->db->query($obat);

        $kuantiti = 0;

        $result = array();

        foreach ($query_obat->result_array() as  $value) {

            $kemasan_id = $this->kemasan_by_id($id_kemasan);


            if ($value['obat_kemasan_kecil_id'] == $kemasan_id) {
                $kuantiti = $new_qty * $value['obat_kemasan_kecil_konversi'];
            } else if ($value['obat_kemasan_sedang_id'] == $kemasan_id) {
                $kuantiti = $new_qty * $value['obat_kemasan_sedang_konversi'];
            } else if ($value['obat_kemasan_besar_id'] == $kemasan_id) {
                $kuantiti = $new_qty * $value['obat_kemasan_besar_konversi'];
            }


            $result['obat_id'] = $value['obat_id'];
            $result['new_qty'] = floor($kuantiti);
            $result['id_kemasan'] = $kemasan_id;
        }

        echo json_encode($result);
    }
}