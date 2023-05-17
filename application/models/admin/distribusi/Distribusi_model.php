<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_model.php';

class Distribusi_model extends controller_model
{
    protected $role_arr, $keyAdmin;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->keyAdmin = common_lib::keySession('admin');
    }

    public function get_stok($barcode, $is_obat, $id_kemasan, $expired_date, $batch, $penyimpanan)
    {
        $params = isset($_POST) ? $_POST : array();

        $params['table'] = 'data_stok';
        $params['select'] = "data_stok.*";
        $where = "barcode='{$barcode}' AND is_obat='{$is_obat}' AND id_kemasan='{$id_kemasan}' AND expired_date='{$expired_date}' AND batch='{$batch}' AND penyimpanan='{$penyimpanan}'";
        $params['where'] = $where;
        $query = $this->CI->common_lib->get_query($params)->result();
        return $query;
    }

    public function balance($so_id, $qty, $tujuan)
    {
        $array = $this->CI->db->query("SELECT * FROM data_stok WHERE id = '{$so_id}'")->result();

        foreach ($array as $key => $value) {
            $input_stok_log = array();
            $input_stok_log['stok_id']          = $value->id;
            $input_stok_log['barcode']          = $value->barcode;
            $input_stok_log['is_obat']          = $value->is_obat;
            $input_stok_log['id_kemasan']       = $value->id_kemasan;
            $input_stok_log['qty']              = $qty;
            $input_stok_log['expired_date']     = $value->expired_date;
            $input_stok_log['batch']            = $value->batch;
            $input_stok_log['jenis_transaksi']  = 4;
            $this->CI->db->insert('data_stok_log', $input_stok_log);
        }

        foreach ($array as $key => $value) {
            $data = $this->get_stok($value->barcode, $value->is_obat, $value->id_kemasan, $value->expired_date, $value->batch, $tujuan);
            if (count($data) != 0) {
                $input_so = array();
                $input_so['qty'] = ($data[0]->qty + $qty);
                $this->CI->db->where('id', $data[0]->id);
                $this->CI->db->update('data_stok', $input_so);
            } else {
                $input_stok = array();
                $input_stok['id_barang']        = $value->id_barang;
                $input_stok['barcode']          = $value->barcode;
                $input_stok['is_obat']          = $value->is_obat;
                $input_stok['id_kemasan']       = $value->id_kemasan;
                $input_stok['qty']              = $qty;
                $input_stok['expired_date']     = $value->expired_date;
                $input_stok['batch']            = $value->batch;
                $input_stok['harga_satuan']     = $value->harga_satuan;
                $input_stok['penyimpanan']      = $tujuan;
                $this->CI->db->insert('data_stok', $input_stok);
            }
        }

        foreach ($array as $key => $value) {
            $input_so = array();
            $input_so['qty'] = ($value->qty - $qty);
            $this->CI->db->where('id', $value->id);
            $this->CI->db->update('data_stok', $input_so);
        }
    }

    public function trx_save($array)
    {
        $status = false;
        $data = array();
        
        try {
            $input_distribusi = array();
            $input_distribusi['kode'] = $array['kode'];
            $input_distribusi['tanggal'] = $array['tanggal'];
            $input_distribusi['sumber'] = $array['sumber'];
            $input_distribusi['tujuan'] = $array['tujuan'];

            $this->CI->db->insert('data_distribusi', $input_distribusi);
            $distribusi_id = $this->CI->db->insert_id();

            /* input ke detail_distribusi */
            $input_detail = array();
            if (!empty($array['detail_barang'])) {
                foreach ($array['detail_barang'] as $key => $value) {
                    $input_detail[$key]['id_distribusi'] = $distribusi_id;
                    $input_detail[$key]['id_stok'] = $value['id'];
                    if ($value['is_obat'] == 1) {
                        $input_detail[$key]['qty'] = $value['qty_konversi'];
                        $this->balance($value['id'], $value['qty_konversi'], $array['tujuan']);
                    }else{
                        $input_detail[$key]['qty'] = $value['qty'];
                        $this->balance($value['id'], $value['qty'], $array['tujuan']);
                    }
                }
            }

            $this->CI->db->insert_batch('data_distribusi_detail', $input_detail);

            $query_distribusi['kode'] = $array['kode'] . $distribusi_id;
            $this->CI->db->where('id', $distribusi_id);
            $this->CI->db->update('data_distribusi', $query_distribusi);

            $message = "Data berhasil ditambah";
            $status = true;
        } catch (Exception $e) {
            $message = "Data gagal disimpan";
            $status = false;
        }

        if ($status == false) {
            $data['status'] = 500;
            $data['message'] = $message;
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
            $query_so['table'] = "data_distribusi";
            $query_so['select'] = "data_distribusi.*";
            $where = "is_delete=0";

            if (trim($this->CI->input->get('kode')) != '') {
                $where .= " AND kode LIKE '%{$this->CI->input->get('kode')}%'";
            }

            if (trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir')) != '') {
                $where .= " AND tanggal BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
            }

            $query_so['where'] = $where;
            $query_so['order_by'] = "id DESC";

            $query_parrent = $this->CI->common_lib->get_query($query_so);
            $total_parrent = $this->CI->common_lib->get_query($query_so, true);
            $json_data['parrentData'] = $query_parrent->result();
            $json_data['total'] = $total_parrent;

            /*=========== Get detail ============*/
            $query_detail = isset($_POST) ? $_POST : [];

            $query_detail['table'] = 'data_distribusi_detail';
            $query_detail['select'] = "IF(stok.is_obat=0, alkes.alkes_name, obat.obat_name) AS item, IF(stok.is_obat=0, alkes.alkes_kemasan, kemasan.kemasan_name) AS kemasan, stok.harga_satuan AS harga_satuan, distribusi.kode AS kode, stok.batch AS batch, distribusi.tanggal AS tanggal, distribusi.is_delete AS is_delete, data_distribusi_detail.*";
            $where_detail = "is_delete=0";

            if (trim($this->CI->input->get('kode')) != '') {
                $where .= " AND kode LIKE '%{$this->CI->input->get('kode')}%'";
            }

            if (trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir')) != '') {
                $where .= " AND tanggal BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
            }

            $join_detail = ' LEFT JOIN data_distribusi distribusi ON distribusi.id=data_distribusi_detail.id_distribusi';
            $join_detail .= ' LEFT JOIN data_stok stok ON stok.id=data_distribusi_detail.id_stok';
            $join_detail .= ' LEFT JOIN data_alkes alkes ON alkes.alkes_barcode=stok.barcode AND stok.is_obat=0';
            $join_detail .= ' LEFT JOIN data_obat obat ON obat.obat_barcode=stok.barcode AND stok.is_obat=1';
            $join_detail .= ' LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id=stok.id_kemasan AND stok.is_obat=1';

            $query_detail['join'] = $join_detail;
            $query_detail['where'] = $where_detail;
            $query_detail['order_by'] = "id_distribusi DESC";

            $query_detailData = $this->CI->common_lib->get_query($query_detail);
            $json_data['detailData'] = $query_detailData->result();
        } else {

            /*=========== Get data parrent by id ============*/
            $query_so['table'] = "data_distribusi";
            $query_so['select'] = "data_distribusi.*";
            $where = " is_delete=0 AND id = '{$id}'";
            $query_so['where'] = $where;
            $query_so['order_by'] = "id DESC";

            $query_parrent = $this->CI->common_lib->get_query($query_so);
            $total_parrent = $this->CI->common_lib->get_query($query_so, true);
            $json_data['parrentData'] = $query_parrent->result();
            $json_data['total'] = $total_parrent;


            /*=========== Get detail by id ============*/
            $query_detail['table'] = 'data_distribusi_detail';
            $query_detail['select'] = "data_distribusi_detail.*, IF(stok.is_obat=0, alkes.alkes_name, obat.obat_name) AS item, IF(stok.is_obat=0, alkes.alkes_kemasan, kemasan.kemasan_name) AS kemasan, stok.expired_date AS expired_date, stok.batch AS batch, stok.is_obat AS is_obat";
            $where_detail = "id_distribusi='{$id}'";

            $join_detail = ' LEFT JOIN data_distribusi distribusi ON distribusi.id=data_distribusi_detail.id_distribusi';
            $join_detail .= ' LEFT JOIN data_stok stok ON stok.id=data_distribusi_detail.id_stok';
            $join_detail .= ' LEFT JOIN data_alkes alkes ON alkes.alkes_barcode=stok.barcode AND stok.is_obat=0';
            $join_detail .= ' LEFT JOIN data_obat obat ON obat.obat_barcode=stok.barcode AND stok.is_obat=1';
            $join_detail .= ' LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id=stok.id_kemasan AND stok.is_obat=1';

            $query_detail['join'] = $join_detail;
            $query_detail['where'] = $where_detail;
            $query_detail['order_by'] = "id_distribusi DESC";

            $query_detailData = $this->CI->common_lib->get_query($query_detail);
            $json_data['detailData'] = $query_detailData->result();
        }

        return $json_data;
    }
}