<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_admin.php';
class distribusi extends controller_admin
{
    protected $st, $access, $class;

    public function __construct()
    {
        parent::__construct();
        $_model = __class__ . '_model';
        $this->load->model($this->module . '/' . __class__ . '/' . $_model);
        $this->mainModel = new $_model();
        $this->access = "akses_setting_user";
        $this->class = "Distribusi Antar Gudang";
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
                $id = $val->id_distribusi;
                if (!isset($data[$id])) {
                    $data[$id] = array();
                }

                $detail_array[$id][] = [
                    'nama_barang'   => $val->item,
                    'batch'         => $val->batch,
                    'kemasan'       => $val->kemasan,
                    'harga_satuan'  => $val->harga_satuan,
                    'qty'           => $val->qty,
                ];
            }
        };

        foreach ($result['parrentData'] as $value) {
            $id_distribusi = $value->id;
            $nama_barang    = '';
            $kemasan        = '';
            $harga_satuan   = '';
            $qty            = '';
            if (isset($detail_array[$id_distribusi])) {
                foreach ($detail_array[$id_distribusi] as $k => $v) {
                    if ($k == 0) {
                        $nama_barang    = '' . $v['nama_barang'] . ' - ' . $v['batch'] . '</br>';
                        $kemasan        = '' . $v['kemasan'] . '</br>';
                        $harga_satuan   = '' . $v['harga_satuan'] . '</br>';
                        $qty            = '' . $v['qty'] . '</br>';
                    } else {
                        $nama_barang    .= '' . $v['nama_barang'] . ' - ' . $v['batch'] . '</br>';
                        $kemasan        .= '' . $v['kemasan'] . '</br>';
                        $harga_satuan   .= '' . $v['harga_satuan'] . '</br>';
                        $qty            .= '' . $v['qty'] . '</br>';
                    }
                }
            } else {
                $nama_barang    = '';
                $kemasan        = '';
                $harga_satuan   = '';
                $qty            = '';
            }
            $no++;

            $action  = common_lib::hak_akses($this->access, 'edit', 'menu') == '1' ? '<a href="' . site_url('admin/' . __class__ . '/view/' . $value->id . '') . '" style="margin-right:5px" class="btn btn-info btn-icon" data-index="' . $value->id . '"><i class="fa fa-eye"></i></a>' : '';
            // $action .= common_lib::hak_akses($this->access,'delete','menu')=='1'?'<a href="javascript:void(0);" data-url="'.site_url('admin/'.__class__.'/delete/'.$so_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation"><i class="fa fa-trash"></i></a>':'';
            $tujuan = ($value->tujuan == 'etalase') ? 'Etalase' : (($value->tujuan == 'gudang' ? 'Gudang' : 'Promo'));

            $json_data['data'][] = array(
                'no'            => $no,
                'id'            => $value->id,
                'action'        => $action,
                'kode'          => $value->kode,
                'tanggal'       => $this->format_tanggal($value->tanggal),
                'tujuan'        => $tujuan,
                'nama_barang'   => $nama_barang,
                'kemasan'       => $kemasan,
                'harga_satuan'  => $harga_satuan,
                'qty'           => $qty,
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
        $common['id'] = '0';
        $common['access'] = $this->access;

        $st->paint($this->template . '/' . $this->module, __class__ . '/form', $common);
    }

    public function view($id)
    {
        $has_exist = $this->common_lib->select_row('data_distribusi', 'id=' . intval($id));
        if (empty($has_exist)) {
            $this->session->set_flashdata('status', '500');
            $this->session->set_flashdata('sukses', 'Data tidak ditemukan.');
            redirect('admin/distribusi/data');
        }

        $this->session->set_userdata("last_url", __class__ . '/' . __function__);
        $common = common_lib::getState($this);
        $st = new Stencil();
        $st->slice('head_login');

        $breadcrumbs_array = array();
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array, $this->module);

        $common['id'] = $id;
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
        redirect('admin/distribusi/data');
    }

    public function get_stok()
    {
        $date = date('Y-m-d');
        $search = $this->input->get('term');
        $penyimpanan = $this->input->get('sumber');
        $findAll_obat = $this->db->query("
            SELECT * FROM data_stok 
            LEFT JOIN data_obat obat ON obat.obat_barcode=data_stok.barcode
            WHERE 1 AND (barcode LIKE '%{$search}%' OR obat.obat_name LIKE '%{$search}%') AND (is_obat=1 AND expired_date > '{$date}' AND penyimpanan = '{$penyimpanan}') 
            GROUP BY barcode ORDER BY obat_id asc limit 15")->result_array();

        $findAll_alkes = $this->db->query("
            SELECT * FROM data_stok 
            LEFT JOIN data_alkes alkes ON alkes.alkes_barcode = data_stok.barcode
            WHERE 1 AND (barcode LIKE '%{$search}%' OR alkes.alkes_name LIKE '%{$search}%') AND (is_obat=0 AND penyimpanan = '{$penyimpanan}')
            GROUP BY barcode ORDER BY alkes_id asc limit 15")->result_array();

        $result = array();
        if (!empty($findAll_obat) || !empty($findAll_alkes)) {
            $no = 1;
            foreach ($findAll_obat as $rowArr) {
                $result[$no]['id']      = $rowArr['obat_id'];
                $result[$no]['id_stok'] = $rowArr['id'];
                $result[$no]['label']   = $rowArr['obat_barcode'] . '-' . $rowArr['obat_name'];
                $result[$no]['value']   = $rowArr['obat_name'];
                $result[$no]['barcode'] = $rowArr['obat_barcode'];
                $result[$no]['is_obat'] = 1;
                $no++;
            }

            foreach ($findAll_alkes as $rowArr) {
                $result[$no]['id']      = $rowArr['alkes_id'];
                $result[$no]['id_stok'] = $rowArr['id'];
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
        $penyimpanan = $this->input->post('sumber');

        $result = [];
        $result[] = ['id' => '', 'text' => '', 'is_obat' => ''];
        if ($is_obat == 1) {
            /* Kemasan Obat WHERE id */

            // $sql = "SELECT data_stok.*, kemasan.kemasan_name as kemasan FROM data_stok
            //     LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id = data_stok.id_kemasan
            //     WHERE data_stok.barcode = '$barcode' AND data_stok.is_obat = '$is_obat' AND data_stok.penyimpanan != '{$penyimpanan}' GROUP BY id_kemasan ORDER BY data_stok.id";
            // $query = $this->db->query($sql);

            // foreach ($query->result_array() as $value) {
            //     $result[] = array(
            //         'id' => $value['id_kemasan'],
            //         'text' => $value['kemasan'],
            //         'is_obat' => $is_obat,
            //     );
            // }

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
                WHERE data_stok.barcode = '$barcode' AND data_stok.is_obat = '$is_obat' AND data_stok.penyimpanan = '$penyimpanan' GROUP BY id_kemasan ORDER BY data_stok.id";
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
        $is_obat = $this->input->post('is_obat');
        $penyimpanan = $this->input->post('penyimpanan');
        $barcode = $this->input->post('barcode');
        
        $result = [];
        $result[]= ['id' => '', 'text' => ''];

        if ($is_obat == 1) {
            /* Kemasan Obat WHERE id */
            // $sql = "SELECT data_stok.* FROM data_stok WHERE barcode = '{$barcode}' AND data_stok.id_kemasan = '{$id_kemasan}' AND data_stok.is_obat = '{$is_obat}' AND data_stok.penyimpanan != '{$penyimpanan}' GROUP BY expired_date ORDER BY data_stok.id";
            $sql = "SELECT data_stok.* FROM data_stok WHERE barcode = '$barcode' AND is_obat = '$is_obat' AND penyimpanan = '$penyimpanan' GROUP BY expired_date ORDER BY id";
            $query = $this->db->query($sql);

            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => $value['id'],
                    'text' => $value['expired_date'],
                    'is_obat' => $is_obat,
                );
            }
        } else {
            /* Kemasan Alkes WHERE id */
            // $sql = "SELECT data_stok.* FROM data_stok WHERE data_stok.id_kemasan = '{$id_kemasan}' AND data_stok.is_obat = '{$is_obat}' AND data_stok.penyimpanan != '{$penyimpanan}' GROUP BY expired_date ORDER BY data_stok.id";
            $sql = "SELECT data_stok.* FROM data_stok WHERE is_obat = '$is_obat' AND penyimpanan = '$penyimpanan' GROUP BY expired_date ORDER BY id";
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => $value['id'],
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
        $prefix = $this->input->post('prefix'); //Bisa tanggal untuk Obat dan kemasan untuk Non Alkes
        $penyimpanan = $this->input->post('sumber');
        $barcode = $this->input->post('barcode');

        $sql = '';
        $result[]= ['id' => '', 'text' => ''];

        if ($is_obat == 1) {
            /* Batch Alkes WHERE id */
            // $sql = "SELECT data_stok.* FROM data_stok WHERE barcode = '{$barcode}' AND data_stok.expired_date = '{$prefix}' AND data_stok.is_obat = {$is_obat} AND data_stok.penyimpanan != '{$penyimpanan}' ORDER BY data_stok.id";
            $sql = "SELECT data_stok.* FROM data_stok WHERE barcode = '$barcode' AND expired_date = '$prefix' AND is_obat = '$is_obat' AND penyimpanan = '$penyimpanan' ORDER BY id";
            $query = $this->db->query($sql);

            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => $value['id'],
                    'text' => $value['batch'],
                );
            }
        } else {
            /* Batch Alkes WHERE id */
            $sql = "SELECT data_stok.* FROM data_stok WHERE barcode = '$barcode' AND id_kemasan = '$prefix' AND is_obat = '$is_obat' AND penyimpanan = '$penyimpanan' ORDER BY id";
            $query = $this->db->query($sql);
            
            foreach ($query->result_array() as $value) {
                $result[] = array(
                    'id' => $value['id'],
                    'text' => $value['batch'],
                );
            }
        }
        echo json_encode($result);
    }

    public function get_stok_satuan()
    {
        $is_obat = $this->input->post('is_obat');
        $id_stok = $this->input->post('id_stok');
        $kemasan = $this->input->post('kemasan');
        $status  = $this->input->post('status');
        $qty  = $this->input->post('qty');

        $result = [];

        // (status = 1) => Cek stok in batch. (status = 0) => Add to array
        if ($status != 1) {
            if ($is_obat == 1) {
                /* Obat WHERE id */
                $sql = "SELECT data_stok.*, obat.obat_kemasan_kecil_id, obat.obat_kemasan_sedang_id, obat.obat_kemasan_besar_id, obat.obat_kemasan_kecil_konversi, obat.obat_kemasan_sedang_konversi, obat.obat_kemasan_besar_konversi, obat.obat_name AS nama_barang, obat.obat_id AS id_obat, kemasan.kemasan_name AS kemasan, data_stok.expired_date AS ex_date
                    FROM data_stok 
                    LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id = data_stok.id_kemasan
                    LEFT JOIN data_obat obat ON obat.obat_barcode=data_stok.barcode
                    WHERE data_stok.id = '$id_stok'";
                $query = $this->db->query($sql);

                $kuantiti = 0;

                foreach ($query->result_array() as $value) {

                    $nama_kemasan = $this->kemasan_by_name($kemasan);
                    $id_kemasan = $this->kemasan_by_id($kemasan);

                    // Konversi ke Kuantiti terKecil
                    if ($value['obat_kemasan_kecil_id'] == $kemasan) {
                        $kuantiti = $qty * $value['obat_kemasan_kecil_konversi'];
                    } else if ($value['obat_kemasan_sedang_id'] == $kemasan) {
                        $kuantiti = $qty * $value['obat_kemasan_sedang_konversi'];
                    } else if ($value['obat_kemasan_besar_id'] == $kemasan) {
                        $kuantiti = $qty * $value['obat_kemasan_besar_konversi'];
                    }

                    $result[$id_stok]['id'] = $value['id'];
                    $result[$id_stok]['id_obat'] = $value['id_obat'];
                    $result[$id_stok]['nama_barang'] = $value['nama_barang'];
                    $result[$id_stok]['kemasan'] = $nama_kemasan;
                    $result[$id_stok]['id_kemasan'] = $id_kemasan;
                    $result[$id_stok]['ex_date'] = $value['ex_date'];
                    $result[$id_stok]['batch'] = $value['batch'];
                    $result[$id_stok]['qty_konversi'] = floor($kuantiti);
                }
            } else {
                /* Alkes WHERE id */
                $sql = "SELECT data_stok.* , alkes.alkes_name AS nama_barang, data_stok.id_kemasan AS kemasan
                    FROM data_stok 
                    LEFT JOIN data_alkes alkes ON alkes.alkes_barcode=data_stok.barcode
                    WHERE data_stok.id = '$id_stok'";
                $query = $this->db->query($sql);
                
                foreach ($query->result_array() as $value) {
                    
                    $nama_kemasan = $this->kemasan_by_name($kemasan);
                    $id_kemasan = $this->kemasan_by_id($kemasan);

                    $result[$id_stok]['id'] = $value['id'];
                    $result[$id_stok]['nama_barang'] = $value['nama_barang'];
                    $result[$id_stok]['kemasan'] = $nama_kemasan;
                    $result[$id_stok]['id_kemasan'] = $id_kemasan;
                    $result[$id_stok]['ex_date'] = '-';
                    $result[$id_stok]['batch'] = $value['batch'];
                    $result[$id_stok]['qty'] = $value['qty'];
                }
            }
        } else {
            if ($is_obat == 1) {
                $obat = "
                    SELECT data_obat.*, data_stok.* 
                    FROM data_obat 
                    JOIN data_stok ON data_stok.id_barang = data_obat.obat_id 
                    WHERE data_stok.id = '$id_stok'
                ";

                $query_obat = $this->db->query($obat);

                $kuantiti = 0;

                foreach ($query_obat->result_array() as  $value) {

                    // Konversi ke Kuantiti terKecil
                    if ($value['obat_kemasan_kecil_id'] == $kemasan) {
                        $kuantiti = $value['qty'] / $value['obat_kemasan_kecil_konversi'];
                    } else if ($value['obat_kemasan_sedang_id'] == $kemasan) {
                        $kuantiti = $value['qty'] / $value['obat_kemasan_sedang_konversi'];
                    } else if ($value['obat_kemasan_besar_id'] == $kemasan) {
                        $kuantiti = $value['qty'] / $value['obat_kemasan_besar_konversi'];
                    }

                    $result[$id_stok]['id'] = $value['id'];
                    $result[$id_stok]['qty'] = floor($kuantiti);
                }
            } else {
                $sql = "
                    SELECT data_alkes.*, data_stok.*
                    FROM data_alkes
                    JOIN data_stok ON data_stok.id_barang = data_alkes.alkes_id
                    WHERE data_stok.id = '$id_stok'
                ";
                $query = $this->db->query($sql);

                foreach ($query->result_array() as  $value) {
                    $result[$id_stok]['id'] = $value['id'];
                    $result[$id_stok]['qty'] = $value['qty'];
                }
            }
        }
        echo json_encode($result);
    }

    public function get_sisa_sediaan()
    {
        $qty = $this->input->post('qty') ? $this->input->post('qty') : 0;
        $id_stok = $this->input->post('id_stok');
        $kemasan = $this->input->post('kemasan');

        $result = [];
        $this->db->select("data_stok.*");
        $this->db->from("data_stok");
        $this->db->where("id=" . $id_stok);
        $this->db->limit(1);
        $query = $this->db->get();
        $query = $query->result();

        $is_obat = '';
        $sql = '';
        $kuantiti = 0;

        foreach ($query as $key => $value) {
            $is_obat = $value->is_obat;

            if ($is_obat == 1) {
                $sql = "
                    SELECT data_obat.*, data_stok.* 
                    FROM data_obat 
                    JOIN data_stok ON data_stok.id_barang = data_obat.obat_id 
                    WHERE data_stok.id = '$id_stok'
                ";
            } else {
                $sql = "
                    SELECT data_obat.*, data_stok.* 
                    FROM data_obat 
                    JOIN data_stok ON data_stok.id_barang = data_obat.obat_id 
                    WHERE data_stok.id = '$id_stok'
                ";
            }
        }

        $sql_query = $this->db->query($sql);

        foreach ($sql_query->result_array() as $key => $value) {
            if ($is_obat == 1) {
                if ($value['obat_kemasan_kecil_id'] == $kemasan) {
                    $kuantiti = $value['qty'] / $value['obat_kemasan_kecil_konversi'];
                } else if ($value['obat_kemasan_sedang_id'] == $kemasan) {
                    $kuantiti = $value['qty'] / $value['obat_kemasan_sedang_konversi'];
                } else if ($value['obat_kemasan_besar_id'] == $kemasan) {
                    $kuantiti = $value['qty'] / $value['obat_kemasan_besar_konversi'];
                }
                $result[$id_stok]['id'] = $value['id'];
                $result[$id_stok]['qty'] = floor($kuantiti);
            } else {
                $result[$id_stok]['id'] = $value['id'];
                $result[$id_stok]['qty'] = $value['qty'];
            }
        }

        if ($qty > $result[$id_stok]['qty']) {
            $result['status'] = '500';
        } else {
            $result['status'] = '200';
        }
        echo json_encode($result);
    }

    public function trx_save()
    {
        $type = ($this->input->post('tujuan') == 'etalase') ? 'E' : (($this->input->post('tujuan') == 'gudang' ? 'G' : 'P'));
        // $type = $this->input->post('tujuan')=='etalase' ? 'E' : 'G'; 
        $data['id'] = $this->input->post('id');
        $data['kode'] = $type . 'DIS-' . date('Y') . date('m') . date('d');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tujuan'] = $this->input->post('tujuan');
        $data['sumber'] = $this->input->post('sumber');
        $data['detail_barang'] = $this->input->post('detail_barang');
        $result = $this->mainModel->trx_save($data);
        echo json_encode($result);
    }

    public function trx_edit()
    {
        $id = $this->input->get('id');
        $result = $this->mainModel->get_data($id);
        $parrentData = array();

        foreach ($result['detailData'] as $val) {
            $id = $val->id_distribusi;
            if (!isset($data[$id])) {
                $data[$id] = array();
            }

            $data[$id][] = array(
                'id_distribusi' => $val->id_distribusi,
                'id'            => $id,
                'nama_barang'   => $val->item,
                'kemasan'       => $val->kemasan,
                'ex_date'       => ($val->expired_date ? $val->expired_date : '-'),
                'batch'         => $val->batch,
                'qty'           => $val->qty,
                'is_obat'       => $val->is_obat,
            );
        };

        foreach ($result['parrentData'] as $value) {
            if (isset($data[$value->id])) {
                $detail = $data[$value->id];
            } else {
                $detail = '';
            }
            $parrentData['data'][] = array(
                'id'        => $value->id,
                'tanggal'   => $value->tanggal,
                'tujuan'    => $value->tujuan,
                'sumber'    => $value->sumber,
                'detail'    => $detail,
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
}
