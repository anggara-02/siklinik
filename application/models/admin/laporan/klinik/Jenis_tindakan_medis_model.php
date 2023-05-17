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
class Jenis_tindakan_medis_model extends controller_model
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
        $params['select'] 	= "trx_pemeriksaan.pemeriksaan_date AS tanggal, trx_pendaftaran_layanan.pendaftaran_layanan_dokter_name AS dokter, trx_pemeriksaan.pemeriksaan_pemeriksaan AS pemeriksaan, trx_pendaftaran_layanan.pendaftaran_layanan_pemeriksaan_name AS tindakan, trx_pendaftaran_layanan.pendaftaran_layanan_price AS harga, trx_pemeriksaan.pemeriksaan_shift_name AS shift";
		$where = "1 AND pemeriksaan != ''";

        if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='') {
            $where .= " AND tanggal BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
        }

        $join	= ' LEFT JOIN trx_pendaftaran_layanan ON trx_pendaftaran_layanan.pendaftaran_layanan_pendaftaran_id=trx_pemeriksaan.pemeriksaan_pendaftaran_id AND lower(pendaftaran_layanan_layanan_name) !="laboratorium"';
		$params['where'] = $where;
        $params['join'] = $join;
        $params['order_by'] = "tanggal ASC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query->result(),
			'total'=>$total,
			'filter_start_date' => $this->CI->input->get('tanggal_awal'),
            'filter_end_date' => $this->CI->input->get('tanggal_akhir'),
		);
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