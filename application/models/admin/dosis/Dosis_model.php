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
class Dosis_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
	
	function stored($id=false)
	{
		if ($id) {$dosis_id=$this->CI->input->post('dosis_id',true);}
		$dosis_name=$this->CI->input->post('dosis_name',true);

		if ($id) {
			$dataArr=[
				'dosis_id'=>$dosis_id,
				'dosis_name'=>$dosis_name,
			];
			$this->CI->db->update('data_dosis', $dataArr, ['dosis_id'=>$dosis_id]);
		} else {
			$dataArr=[
				'dosis_name'=>$dosis_name,
			];
			$this->CI->db->insert('data_dosis', $dataArr);
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
                     'field'   => "dosis_id",
                     'label'   => 'ID',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "dosis_name",
                     'label'   => 'Satuan Dosis',
                     'rules'   => 'trim|required|max_length[200]|is_unique_edit_custom[data_dosis.dosis_name.dosis_id.'.$_POST['dosis_id'].']'
                ],
			];
		} else {
			$validation = [
				[
						'field'   => "dosis_name",
						'label'   => 'Satuan Dosis',
						'rules'   => 'trim|required|max_length[200]|is_unique[data_dosis.dosis_name]'
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
        
        $params['table'] = 'data_dosis';
        $params['select'] = "data_dosis.*";
        $where='1 and is_delete=0';
         
        if(trim($this->CI->input->get('dosis_name'))!='')
        {
            $where.=' AND dosis_name LIKE "%'.$this->CI->input->get('dosis_name').'%"';
        } 
        if(trim($this->CI->input->get('dosis_id'))!='')
        {
            $where.=' AND dosis_id = "'.$this->CI->input->get('dosis_id').'"';
        }
         
        $params['where'] =$where;

        // $params['join'] = "LEFT JOIN data_role on data_role.role_id=data_dosis.role_id";
        $params['order_by'] = "dosis_id DESC";

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