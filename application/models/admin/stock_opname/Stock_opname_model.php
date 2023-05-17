<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_model.php';

class Stock_opname_model extends controller_model
{
    protected $role_arr, $keyAdmin;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->keyAdmin = common_lib::keySession('admin');
    }

    public function balance($so_id, $qty_after, $id_kemasan = NULL)
    {
        $array = $this->CI->db->query("SELECT * FROM data_stok WHERE id = '{$so_id}'");
        foreach ($array->result() as $key => $value) {
            $input_stok_log = array();
            $input_stok_log['stok_id']      = $value->id;
            $input_stok_log['barcode']      = $value->barcode;
            $input_stok_log['is_obat']      = $value->is_obat;
            $input_stok_log['id_kemasan']   = $value->id_kemasan;
            $input_stok_log['qty']          = $value->qty;
            $input_stok_log['expired_date'] = $value->expired_date;
            $input_stok_log['batch']        = $value->batch;
            $input_stok_log['jenis_transaksi'] = 2;
            $this->CI->db->insert('data_stok_log', $input_stok_log);
        }

        foreach ($array->result() as $key => $value) {
            $input_stok_log = array();
            $input_stok_log['stok_id']      = $value->id;
            $input_stok_log['barcode']      = $value->barcode;
            $input_stok_log['is_obat']      = $value->is_obat;
            $input_stok_log['id_kemasan']   = $id_kemasan;
            $input_stok_log['qty']          = $qty_after;
            $input_stok_log['expired_date'] = $value->expired_date;
            $input_stok_log['batch']        = $value->batch;
            $input_stok_log['jenis_transaksi'] = 3;
            $this->CI->db->insert('data_stok_log', $input_stok_log);
        }

        $input_so = array();
        $input_so['qty'] = $qty_after;
        $this->CI->db->where('id', $so_id);
        $this->CI->db->update('data_stok', $input_so);
    }

    public function trx_save($array)
    {
        $status = false;
        $data = array();

        try {
            $input_so = array();
            $input_so['kode_so'] = $array['kode_so'];
            $input_so['tanggal_so'] = $array['tanggal_so'];
            $input_so['keterangan'] = $array['keterangan'];
            $input_so['penyimpanan'] = $array['penyimpanan'];
            $input_so['user_input'] = $_SESSION[$this->keyAdmin]['user_id'];

            $this->CI->db->insert('data_so', $input_so);
            $so_id = $this->CI->db->insert_id();

            /* input ke detail so */
            $input_detail = array();
            if (!empty($array['detail_barang'])) {
                foreach ($array['detail_barang'] as $key => $value) {
                    
                    $input_detail[$key]['id_so'] = $so_id;
                    $input_detail[$key]['id_stok'] = $value['id'];
                    $input_detail[$key]['qty'] = $value['qty_after'];
                    $input_detail[$key]['qty_sebelum'] = $value['qty'];
                    $input_detail[$key]['is_obat'] = $value['is_obat'];
                    $input_detail[$key]['so_detail_kemasan_id'] = $value['id_kemasan'];
                    
                    $qty_konversi = ($input_detail[$key]['is_obat'] == '1' ? $value['qty_konversi'] : $value['qty_after']);

                    $this->balance($value['id'], $qty_konversi, $value['id_kemasan']);
                }
            }
            $this->CI->db->insert_batch('data_so_detail', $input_detail);

            $query_so['kode_so'] = $array['kode_so'] . $so_id;
            $this->CI->db->where('so_id', $so_id);
            $this->CI->db->update('data_so', $query_so);

            $message = "Data berhasil ditambah";
            $status = true;
        } catch (Exception $e) {
            $status = false;
        }

        if ($status == false) {
            $data['status'] = 500;
            $data['message'] = "Data gagal disimpan";
        } else {
            $data['status'] = 200;
            $data['message'] = $message;
        }

        return $data;
    }

    function get_data($id = 0)
    {
        $json_data = array();

        if ($id == 0) {
            /*=========== Get data parrent ============*/
            $query_so = isset($_POST) ? $_POST : [];
            $query_so['table'] = "data_so";
            $query_so['select'] = "data_so.*";
            $where = "is_delete = '0'";

            if (trim($this->CI->input->get('kode_so')) != '') {
                $where .= " AND kode_so LIKE '%{$this->CI->input->get('kode_so')}%'";
            }

            if (trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir')) != '') {
                $where .= " AND create_at BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
            }

            $query_so['where'] = $where;
            $query_so['order_by'] = "so_id DESC";

            $query_parrent = $this->CI->common_lib->get_query($query_so);
            $total_parrent = $this->CI->common_lib->get_query($query_so, true);
            $json_data['parrentData'] = $query_parrent->result();
            $json_data['total'] = $total_parrent;

            /*=========== Get detail ============*/
            $query_detail = isset($_POST) ? $_POST : [];



            $query_detail['table'] = 'data_so_detail';
            $query_detail['select'] = "IF(stok.is_obat=0, alkes.alkes_name, obat.obat_name) AS item, IF(stok.is_obat=0, alkes.alkes_kemasan, kemasan.kemasan_name) AS kemasan, stok.harga_satuan AS harga_satuan, data_so_detail.qty AS sesudah, data_so_detail.qty_sebelum AS sebelum, so.is_delete AS is_delete, data_so_detail.id_so AS id_so, stok.barcode AS barcode, stok.batch AS batch, so.kode_so AS kode_so, so.create_at AS create_at";
            $where_detail = "is_delete='0'";

            if (trim($this->CI->input->get('kode_so')) != '') {
                $where .= " AND kode_so LIKE '%{$this->CI->input->get('kode_so')}%'";
            }

            if (trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir')) != '') {
                $where .= " AND create_at BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
            }

            $join_detail = ' LEFT JOIN data_so so ON so.so_id=data_so_detail.id_so';
            $join_detail .= ' LEFT JOIN data_stok stok ON stok.id=data_so_detail.id_stok';
            $join_detail .= ' LEFT JOIN data_alkes alkes ON alkes.alkes_barcode=stok.barcode AND stok.is_obat=0';
            $join_detail .= ' LEFT JOIN data_obat obat ON obat.obat_barcode=stok.barcode AND stok.is_obat=1';
            $join_detail .= ' LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id=data_so_detail.so_detail_kemasan_id AND stok.is_obat=1';

            $query_detail['join'] = $join_detail;
            $query_detail['where'] = $where_detail;
            
            $query_detail['order_by'] = "id_so DESC";
            
            //total dari all query detail
            
            $total_parrent = $this->CI->common_lib->get_query($query_detail, true);
            $query_detail['length'] = $total_parrent;
            $query_detailData = $this->CI->common_lib->get_query($query_detail);

            $json_data['detailData'] = $query_detailData->result();
        } else {

            /*=========== Get data parrent by id ============*/
            $query_so['table'] = "data_so";
            $query_so['select'] = "data_so.*";
            $where = " is_delete=0 AND so_id = '{$id}'";
            $query_so['where'] = $where;
            $query_so['order_by'] = "so_id DESC";

            $query_parrent = $this->CI->common_lib->get_query($query_so);
            $total_parrent = $this->CI->common_lib->get_query($query_so, true);
            $json_data['parrentData'] = $query_parrent->result();
            $json_data['total'] = $total_parrent;


            /*=========== Get detail by id ============*/
            $query_detail['table'] = 'data_so_detail';
            $query_detail['select'] = "IF(stok.is_obat=0, alkes.alkes_name, obat.obat_name) AS item, kemasan.kemasan_name AS kemasan, stok.expired_date AS expired_date, data_so_detail.qty AS sesudah, data_so_detail.qty_sebelum AS sebelum, stok.batch AS batch, data_so_detail.so_detail_id AS so_detail_id, data_so_detail.id_so AS id_so, data_so_detail.is_obat AS is_obat";
            $where_detail = "id_so='{$id}'";

            $join_detail = ' LEFT JOIN data_so so ON so.so_id=data_so_detail.id_so';
            $join_detail .= ' LEFT JOIN data_stok stok ON stok.id=data_so_detail.id_stok';
            $join_detail .= ' LEFT JOIN data_alkes alkes ON alkes.alkes_barcode=stok.barcode';
            $join_detail .= ' LEFT JOIN data_obat obat ON obat.obat_barcode=stok.barcode';
            $join_detail .= ' LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id = data_so_detail.so_detail_kemasan_id';

            $query_detail['join'] = $join_detail;
            $query_detail['where'] = $where_detail;
            $query_detail['order_by'] = "id_so DESC";

            $query_detailData = $this->CI->common_lib->get_query($query_detail);
            $json_data['detailData'] = $query_detailData->result();
        }
        return $json_data;
    }
}
