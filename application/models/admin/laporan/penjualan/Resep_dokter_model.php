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
class Resep_dokter_model extends controller_model
{
    protected $role_arr;
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }
	
	function get_data() { 
        $params = isset($_POST) ? $_POST : array();
        $params['table'] 	= 'trx_pemeriksaan';
        $params['select'] 	= "trx_pemeriksaan_kasir.kasir_invoice AS invoice, trx_pemeriksaan_kasir.kasir_date AS transaksi, data_pasien.pasien_name AS pasien_name, trx_pemeriksaan.pemeriksaan_id AS pemeriksaan_id, trx_pemeriksaan.pemeriksaan_status AS pemeriksaan_status, trx_pemeriksaan.pemeriksaan_pendaftaran_id AS pemeriksaan_pendaftaran_id";
		$where 	= "pemeriksaan_status = 'kasir'";

        if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='') {
            $where .= " AND transaksi BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
        }

        $join 	= ' LEFT JOIN trx_pemeriksaan_kasir ON trx_pemeriksaan_kasir.kasir_pemeriksaan_id=trx_pemeriksaan.pemeriksaan_id';
        $join 	.= ' LEFT JOIN data_pasien ON data_pasien.pasien_id=trx_pemeriksaan.pemeriksaan_pasien_id';
        // $join 	.= ' LEFT JOIN data_pasien ON data_pasien.pasien_id=trx_pemeriksaan.pemeriksaan_pasien_id';
		$params['where'] 	= $where;
        $params['join'] 	= $join;
        $params['order_by'] = "transaksi DESC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query->result(),
			'total'=>$total,
			'filter_start_date' => $this->CI->input->get('tanggal_awal'),
            'filter_end_date' => $this->CI->input->get('tanggal_akhir'),
		);
	}

	function get_obat($id) {
		$params['table'] 	= 'trx_pemeriksaan_obat_apotek';
		$params['select'] 	= "trx_pemeriksaan_obat_apotek.*, data_obat.*, data_kemasan.kemasan_name AS kemasan_dasar";	
		$where 	= "pemeriksaan_obat_pemeriksaan_id = {$id}";
		$join 	= ' LEFT JOIN data_obat ON data_obat.obat_id=trx_pemeriksaan_obat_apotek.pemeriksaan_obat_obat_id';
		$join 	.= ' LEFT JOIN data_kemasan ON data_kemasan.kemasan_id=data_obat.obat_kemasan_kecil_id';
		$params['where'] 	= $where;
		$params['join'] 	= $join;
		$params['order_by'] = "pemeriksaan_obat_obat_id DESC";
		$query = $this->CI->common_lib->get_query($params);
		return $query;
	}

	function get_dokter($id) {
		$params['table'] 	= 'trx_pemeriksaan';
		$params['select'] 	= "trx_pemeriksaan.*, trx_pendaftaran.*";	
		$where 	= "pemeriksaan_id = {$id}";
		$join 	= ' LEFT JOIN trx_pendaftaran ON trx_pendaftaran.pendaftaran_id=trx_pemeriksaan.pemeriksaan_pendaftaran_id';
		$join 	.= ' LEFT JOIN data_kemasan ON data_kemasan.kemasan_id=data_obat.obat_kemasan_kecil_id';
		$params['where'] 	= $where;
		$params['join'] 	= $join;
		$params['order_by'] = "pemeriksaan_obat_obat_id DESC";
		$query = $this->CI->common_lib->get_query($params);
		return $query;
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