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

require_once APPPATH.'/extend/controller_model.php';
class Setting_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
	
	function stored($data) {
		$setting_id = $data['setting_id'];
		try {
			if ($setting_id == 0) {
				$input_penerimaan = [];
				$input_penerimaan['nama_klinik'] = $data['nama_klinik'];
				$input_penerimaan['no_telpon'] = $data['no_telpon'];
				$input_penerimaan['email'] = $data['email'];
				$input_penerimaan['alamat'] = $data['alamat'];
				$input_penerimaan['logo'] = $data['logo'];
				$input_penerimaan['apoteker'] = $data['apoteker'];
				$input_penerimaan['sipa'] = $data['sipa'];
				$input_penerimaan['sia'] = $data['sia'];
				$input_penerimaan['min_promo'] = $data['min_promo'];
				$input_penerimaan['konversi_poin'] = $data['konversi_poin'];
				$this->CI->db->insert('setting', $input_penerimaan);
				$setting_id = $this->CI->db->insert_id();
			} else {
				$input_penerimaan = [];
				$input_penerimaan['nama_klinik'] = $data['nama_klinik'];
				$input_penerimaan['no_telpon'] = $data['no_telpon'];
				$input_penerimaan['email'] = $data['email'];
				$input_penerimaan['alamat'] = $data['alamat'];
				$input_penerimaan['logo'] = $data['logo'];
				$input_penerimaan['apoteker'] = $data['apoteker'];
				$input_penerimaan['sipa'] = $data['sipa'];
				$input_penerimaan['sia'] = $data['sia'];
				$input_penerimaan['min_promo'] = $data['min_promo'];
				$input_penerimaan['konversi_poin'] = $data['konversi_poin'];
				
				$this->CI->db->where('setting_id', $setting_id);
				$this->CI->db->update('setting', $input_penerimaan);
			}
		} catch (\Throwable $th) {
			return 0;
		}
		return 1;
	}
	
	function get_data() { 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'setting';
        $params['select'] = "setting.*";
        $params['order_by'] = "setting_id DESC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query,
			'total'=>$total,
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