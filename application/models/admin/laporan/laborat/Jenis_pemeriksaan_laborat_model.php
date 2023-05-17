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
class Jenis_pemeriksaan_laborat_model extends controller_model
{
    protected $role_arr;
    public function __construct() {
        parent::__construct();
        $this->CI = &get_instance();
    }
	
	function get_data() { 
        $params = isset($_POST) ? $_POST : array();
        $params['table'] 	= 'trx_pemeriksaan';
        $params['select'] 	= "trx_pemeriksaan.pemeriksaan_date AS tanggal, trx_pendaftaran_layanan.pendaftaran_layanan_dokter_name AS dokter, trx_pendaftaran_layanan.pendaftaran_layanan_pemeriksaan_name AS pemeriksaan, trx_pendaftaran_layanan.pendaftaran_layanan_price AS harga";
        if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='') {
            $where = " tanggal BETWEEN '{$this->CI->input->get('tanggal_awal')} 00:00:00' AND '{$this->CI->input->get('tanggal_akhir')} 23:59:59'";
            $params['where'] = $where;
        }
        $join	= ' LEFT JOIN trx_pendaftaran_layanan ON trx_pendaftaran_layanan.pendaftaran_layanan_pendaftaran_id=trx_pemeriksaan.pemeriksaan_pendaftaran_id AND lower(pendaftaran_layanan_layanan_name)="laboratorium"';
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