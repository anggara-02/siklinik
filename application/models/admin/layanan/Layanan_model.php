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
class Layanan_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
	
	function stored($id=false)
	{
		if ($id) {$layanan_id=$this->CI->input->post('layanan_id',true);}
		$layanan_bph=$this->CI->input->post('layanan_bph',true);
		$layanan_name=$this->CI->input->post('layanan_name',true);
		$layanan_tarif=$this->CI->input->post('layanan_tarif',true);
		$layanan_total=$this->CI->input->post('layanan_total',true);
		$layanan_poli_id=$this->CI->input->post('layanan_poli_id',true);

		if ($id) {
			$dataArr=[
				'layanan_id'=>$layanan_id,
				'layanan_bph'=>$layanan_bph,
				'layanan_name'=>$layanan_name,
				'layanan_tarif'=>$layanan_tarif,
				'layanan_total'=>$layanan_total,
				'layanan_poli_id'=>$layanan_poli_id,
			];
			$this->CI->db->update('data_layanan', $dataArr, ['layanan_id'=>$layanan_id]);
		} else {
			$dataArr=[
				'layanan_bph'=>$layanan_bph,
				'layanan_name'=>$layanan_name,
				'layanan_tarif'=>$layanan_tarif,
				'layanan_total'=>$layanan_total,
				'layanan_poli_id'=>$layanan_poli_id,
			];
			$this->CI->db->insert('data_layanan', $dataArr);
		}
		
		return [
			'status'=>200,
			'message'=>'Data Sukses disimpan',
		];
	}
	
	function validate_form($id=false)
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		if ($id) {
			$custom_validation = [
                [
                     'field'   => "layanan_id",
                     'label'   => 'ID',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "layanan_name",
                     'label'   => 'Nama Layanan Medis',
                     'rules'   => 'trim|required|max_length[200]|is_unique_edit_custom[data_layanan.layanan_name.layanan_id.'.$_POST['layanan_id'].']'
                ],
			];
		} else {
			$custom_validation = [
				[
						'field'   => "layanan_name",
						'label'   => 'Nama Layanan Medis',
						'rules'   => 'trim|required|max_length[200]|is_unique[data_layanan.layanan_name]'
				],
			];
		}
		
		$validation = [
			[
				 'field'   => "layanan_poli_id",
				 'label'   => 'Poli',
				 'rules'   => 'trim|required'
			],
			[
				 'field'   => "layanan_tarif",
				 'label'   => 'Tarif Layanan Medis',
				 'rules'   => 'trim|required',
			],
			[
				 'field'   => "layanan_bph",
				 'label'   => 'Tarif BHP',
				 'rules'   => 'trim|required',
			],
			[
				 'field'   => "layanan_total",
				 'label'   => 'Total Tarif',
				 'rules'   => 'trim|required'
			],
		];
		
		$this->CI->form_validation->set_rules(array_merge($custom_validation, $validation));
		if ($this->CI->form_validation->run() == TRUE)
		{
			$data['status']=200;
			$data['message']="Ok.";
			return $data;
		} else {
			$data['status']=500;
			$data['message']=validation_errors(); 
			return $data;
		}
    }
	
	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'data_layanan';
        $params['select'] = "data_layanan.*, poli_name";
        $where='is_delete=0';
         
        if(trim($this->CI->input->get('layanan_name'))!='')
        {
            $where.=' AND layanan_name LIKE "%'.$this->CI->input->get('layanan_name').'%"';
        } 
        if(trim($this->CI->input->get('layanan_id'))!='')
        {
            $where.=' AND layanan_id = "'.$this->CI->input->get('layanan_id').'"';
        }
         
        $params['where'] =$where;
        $params['join'] = "LEFT JOIN data_poli on data_poli.poli_id=data_layanan.layanan_poli_id";
        $params['order_by'] = "layanan_id DESC";

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