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
class Inkaso_model extends controller_model{
	protected $role_arr, $keyAdmin;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
		$this->keyAdmin=common_lib::keySession('admin');
    }
	
	function stored($id=false) {
		if ($id) {
			$dataArr=[
				'jumlah' => $this->CI->input->post('jumlah',true),
				'tanggal' => $this->CI->input->post('tanggal',true),
				'cara_bayar' => $this->CI->input->post('cara_bayar',true),
				'id_penerimaan' => $this->CI->input->post('id_penerimaan',true),
			];
			$this->CI->db->update('data_inkaso', $dataArr, ['inkaso_id'=>$id]);
		} else {
			$dataArr=[
				'jumlah' => $this->CI->input->post('jumlah',true),
				'tanggal' => $this->CI->input->post('tanggal',true),
				'cara_bayar' => $this->CI->input->post('cara_bayar',true),
				'id_penerimaan' => $this->CI->input->post('id_penerimaan',true),
			];
			$this->CI->db->insert('data_inkaso', $dataArr);
		}
		return true;
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