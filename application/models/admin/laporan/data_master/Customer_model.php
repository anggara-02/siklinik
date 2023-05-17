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
class Customer_model extends controller_model
{
    protected $role_arr;
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }
	
	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'trx_pendaftaran';
        $params['select'] = "pendaftaran_id, IF(trx_pendaftaran.pendaftaran_pasien_id != 0, data_pasien.pasien_name, trx_pendaftaran.pendaftaran_pasien_name) AS nama, IF(trx_pendaftaran.pendaftaran_pasien_id != 0, data_pasien.pasien_penjamin_no, trx_pendaftaran.pendaftaran_pasien_penanggung_jawab_telp) AS nomor_telpon, IF(trx_pendaftaran.pendaftaran_pasien_id != 0, data_pasien.pasien_address, trx_pendaftaran.pendaftaran_pasien_address) AS alamat";
        $where='1';
        $join	= 'LEFT JOIN data_pasien ON data_pasien.pasien_id=trx_pendaftaran.pendaftaran_pasien_id AND trx_pendaftaran.pendaftaran_pasien_id != 0';
        $params['join'] = $join;
        $params['where'] =$where;
        $params['order_by'] = "nama ASC";
        $params['group_by'] = "nama,alamat,nomor_telpon";

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