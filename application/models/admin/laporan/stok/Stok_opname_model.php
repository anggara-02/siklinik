<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_model.php';
class Stok_opname_model extends controller_model
{
    protected $role_arr;
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
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
 
        $json_data['tanggal_awal'] = $this->CI->input->get('tanggal_awal');
        $json_data['tanggal_akhhir'] = $this->CI->input->get('tanggal_akhir');

        return $json_data;
    }
	
	// function get_data() { 
    //     $params = isset($_POST) ? $_POST : array();
    //     $params['table'] 	= 'data_stok';
    //     $params['select'] 	= "DISTINCT data_stok.id_barang AS id_barang, data_stok.barcode AS barcode, IF(data_stok.is_obat=1, data_obat.obat_name, data_alkes.alkes_name) AS produk, data_stok.expired_date AS expired_date, data_stok.batch AS batch, data_kemasan.kemasan_name AS kemasan, IF(data_stok.is_obat=1, data_obat.obat_price, data_stok.harga_satuan) AS harga, data_stok.id_kemasan AS id_kemasan";
            
    //     if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='')
    //     {
    //         $where = " expired_date BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
    //         $params['where'] = $where;
    //     }

    //     $join	= 'LEFT JOIN data_kemasan ON data_kemasan.kemasan_id=data_stok.id_kemasan';
	// 	$join	.= ' LEFT JOIN data_obat ON data_obat.obat_id=data_stok.id_barang AND data_stok.is_obat=1';
	// 	$join	.= ' LEFT JOIN data_alkes ON data_alkes.alkes_id=data_stok.id_barang AND data_stok.is_obat=0';
    //     $params['join'] = $join;
    //     $params['order_by'] = "expired_date ASC";

    //     $query = $this->CI->common_lib->get_query($params);
    //     $total = $this->CI->common_lib->get_query($params, true);

	// 	return array(
	// 		'query'=>$query->result(),
	// 		'total'=>$total,
    //         'filter_start_date' => $this->CI->input->get('tanggal_awal'),
    //         'filter_end_date' => $this->CI->input->get('tanggal_akhir'),
	// 	);
	// }

    public function etalase($id_barang, $expired_date, $batch, $id_kemasan) {
        $expired_date = $expired_date ? "expired_date='".$expired_date."'" : 'expired_date IS NULL';
        $model = $this->CI->db->query("SELECT SUM(IF(data_stok.penyimpanan='etalase', qty, 0)) AS etalase FROM data_stok WHERE id_barang='{$id_barang}' AND {$expired_date} AND batch='{$batch}' AND id_kemasan = '{$id_kemasan}'")->result();
        return $model[0]->etalase;
    }

    public function gudang($id_barang, $expired_date, $batch, $id_kemasan) {
        $expired_date = $expired_date ? "expired_date='".$expired_date."'" : 'expired_date IS NULL';
        $model = $this->CI->db->query("SELECT SUM(IF(data_stok.penyimpanan='gudang', qty, 0)) AS gudang FROM data_stok WHERE id_barang='{$id_barang}' AND {$expired_date} AND batch='{$batch}' AND id_kemasan = '{$id_kemasan}'")->result();
        return $model[0]->gudang;
    }
    
    public function promo($id_barang, $expired_date, $batch, $id_kemasan) {
        $expired_date = $expired_date ? "expired_date='".$expired_date."'" : 'expired_date IS NULL';
        $model = $this->CI->db->query("SELECT SUM(IF(data_stok.penyimpanan='promo', qty, 0)) AS promo FROM data_stok WHERE id_barang='{$id_barang}' AND {$expired_date} AND batch='{$batch}' AND id_kemasan = '{$id_kemasan}'")->result();
        return $model[0]->promo;
    }

    public function export(){
        $json_data = array();

        /*=========== Get data parrent ============*/
        $params['table'] = "data_so";
        $params['select'] = "data_so.*";
        $where = "is_delete = '0'";

        if (trim($this->CI->input->get('kode_so')) != '') {
            $where .= " AND kode_so LIKE '%{$this->CI->input->get('kode_so')}%'";
        }

        if (trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir')) != '') {
            $where .= " AND create_at BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
        }

        $params['where'] = $where;
        $params['order_by'] = "so_id DESC";

        $query_parrent = $this->CI->common_lib->get_query($params);
        $total_parrent = $this->CI->common_lib->get_query($params, true);
        $json_data['parrentData'] = $query_parrent->result();

        /*=========== Get detail ============*/
        $params['table'] = 'data_so_detail';
        $params['select'] = "IF(stok.is_obat=0, alkes.alkes_name, obat.obat_name) AS item, IF(stok.is_obat=0, alkes.alkes_kemasan, kemasan.kemasan_name) AS kemasan, stok.harga_satuan AS harga_satuan, data_so_detail.qty AS sesudah, data_so_detail.qty_sebelum AS sebelum, so.is_delete AS is_delete, data_so_detail.id_so AS id_so, stok.barcode AS barcode, stok.batch AS batch, so.kode_so AS kode_so, so.create_at AS create_at";
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

        $params['join'] = $join_detail;
        $params['where'] = $where_detail;
        
        $params['order_by'] = "id_so DESC";
        
        //total dari all query detail
        $total_parrent = $this->CI->common_lib->get_query($params, true);
        $query_detailData = $this->CI->common_lib->get_query($params);

        $json_data['detailData'] = $query_detailData->result();
 
        $json_data['filter_start_date'] = $this->CI->input->get('tanggal_awal');
        $json_data['filter_end_date'] = $this->CI->input->get('tanggal_akhir');

        return $json_data;
    }

    public function get_detail($id_so){
        $params['table'] = 'data_so_detail';
        $params['select'] = "data_so_detail.so_detail_id, IF(stok.is_obat=0, alkes.alkes_name, obat.obat_name) AS item, IF(stok.is_obat=0, alkes.alkes_kemasan, kemasan.kemasan_name) AS kemasan, stok.harga_satuan AS harga_satuan, data_so_detail.qty AS sesudah, data_so_detail.qty_sebelum AS sebelum, data_so_detail.id_so AS id_so, stok.barcode AS barcode, stok.batch AS batch";
        $where_detail = "1";

        $join_detail = ' LEFT JOIN data_stok stok ON stok.id=data_so_detail.id_stok';
        $join_detail .= ' LEFT JOIN data_alkes alkes ON alkes.alkes_barcode=stok.barcode AND stok.is_obat=0';
        $join_detail .= ' LEFT JOIN data_obat obat ON obat.obat_barcode=stok.barcode AND stok.is_obat=1';
        $join_detail .= ' LEFT JOIN data_kemasan kemasan ON kemasan.kemasan_id=data_so_detail.so_detail_kemasan_id AND stok.is_obat=1';
        
        $params['join'] = $join_detail;
        $params['where'] = $where_detail;   
        
        $params['order_by'] = "so_detail_id DESC";
        
        //total dari all query detail
        $total_parrent = $this->CI->common_lib->get_query($params, true);
        $query_detailData = $this->CI->common_lib->get_query($params);

        return $query_detailData;
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