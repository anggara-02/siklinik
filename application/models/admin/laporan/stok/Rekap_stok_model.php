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
class Rekap_stok_model extends controller_model
{
    protected $role_arr;
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }
	
	function get_data() { 
        $params = isset($_POST) ? $_POST : array();
        $params['table'] 	= 'data_stok';
        $params['select'] 	= "DISTINCT data_stok.id_barang AS id_barang, data_stok.barcode AS barcode, IF(data_stok.is_obat=1, data_obat.obat_name, data_alkes.alkes_name) AS produk, data_stok.expired_date AS expired_date, data_stok.batch AS batch, data_kemasan.kemasan_name AS kemasan, IF(data_stok.is_obat=1, data_obat.obat_price, data_stok.harga_satuan) AS harga, data_stok.id_kemasan AS id_kemasan";
            
        if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='')
        {
            $where = " expired_date BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
            $params['where'] = $where;
        }

        $join	= 'LEFT JOIN data_kemasan ON data_kemasan.kemasan_id=data_stok.id_kemasan';
		$join	.= ' LEFT JOIN data_obat ON data_obat.obat_id=data_stok.id_barang AND data_stok.is_obat=1';
		$join	.= ' LEFT JOIN data_alkes ON data_alkes.alkes_id=data_stok.id_barang AND data_stok.is_obat=0';
        $params['join'] = $join;
        $params['order_by'] = "expired_date ASC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query->result(),
			'total'=>$total,
            'filter_start_date' => $this->CI->input->get('tanggal_awal'),
            'filter_end_date' => $this->CI->input->get('tanggal_akhir'),
		);
	}

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
}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */