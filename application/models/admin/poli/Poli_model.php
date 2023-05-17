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
class Poli_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
	
	function stored($id=false)
	{
		if ($id) {$poli_id=$this->CI->input->post('poli_id',true);}
		$poli_name=$this->CI->input->post('poli_name',true);

		if ($id) {
			$dataArr=[
				'poli_id'=>$poli_id,
				'poli_name'=>$poli_name,
			];
			$this->CI->db->update('data_poli', $dataArr, ['poli_id'=>$poli_id]);
		} else {
			$dataArr=[
				'poli_name'=>$poli_name,
			];
			$this->CI->db->insert('data_poli', $dataArr);
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
			$validation = [
                [
                     'field'   => "poli_id",
                     'label'   => 'ID',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "poli_name",
                     'label'   => 'Poli',
                     'rules'   => 'trim|required|max_length[100]|is_unique_edit_custom[data_poli.poli_name.poli_id.'.$_POST['poli_id'].']'
                ],
			];
		} else {
			$validation = [
				[
						'field'   => "poli_name",
						'label'   => 'Poli',
						'rules'   => 'trim|required|max_length[100]|is_unique[data_poli.poli_name]'
				],
			];
		}
		
		$this->CI->form_validation->set_rules(array_merge($validation));
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
        
        $params['table'] = 'data_poli';
        $params['select'] = "data_poli.*";
        $where='1 and is_delete=0';
         
        if(trim($this->CI->input->get('poli_name'))!='')
        {
            $where.=' AND poli_name LIKE "%'.$this->CI->input->get('poli_name').'%"';
        } 
        if(trim($this->CI->input->get('poli_id'))!='')
        {
            $where.=' AND poli_id = "'.$this->CI->input->get('poli_id').'"';
        }
         
        $params['where'] =$where;

        // $params['join'] = "LEFT JOIN data_role on data_role.role_id=data_poli.role_id";
        $params['order_by'] = "poli_id DESC";

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