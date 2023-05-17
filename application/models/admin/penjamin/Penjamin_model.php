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
class Penjamin_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
	
	function stored($id=false)
	{
		if ($id) {$penjamin_id=$this->CI->input->post('penjamin_id',true);}
		$penjamin_name=$this->CI->input->post('penjamin_name',true);

		if ($id) {
			$dataArr=[
				'penjamin_id'=>$penjamin_id,
				'penjamin_name'=>$penjamin_name,
			];
			$this->CI->db->update('data_penjamin', $dataArr, ['penjamin_id'=>$penjamin_id]);
		} else {
			$dataArr=[
				'penjamin_name'=>$penjamin_name,
			];
			$this->CI->db->insert('data_penjamin', $dataArr);
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
                     'field'   => "penjamin_id",
                     'label'   => 'Penjamin',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "penjamin_name",
                     'label'   => 'Jenis Penjamin',
                     'rules'   => 'trim|required|max_length[100]|is_unique_edit_custom[data_penjamin.penjamin_name.penjamin_id.'.$_POST['penjamin_id'].']'
                ],
			];
		} else {
			$validation = [
				[
						'field'   => "penjamin_name",
						'label'   => 'Jenis Penjamin',
						'rules'   => 'trim|required|max_length[100]|is_unique[data_penjamin.penjamin_name]'
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
        
        $params['table'] = 'data_penjamin';
        $params['select'] = "data_penjamin.*";
        $where='1 and is_delete=0';
         
        if(trim($this->CI->input->get('penjamin_name'))!='')
        {
            $where.=' AND penjamin_name LIKE "%'.$this->CI->input->get('penjamin_name').'%"';
        } 
        if(trim($this->CI->input->get('penjamin_id'))!='')
        {
            $where.=' AND penjamin_id = "'.$this->CI->input->get('penjamin_id').'"';
        }
         
        $params['where'] =$where;

        // $params['join'] = "LEFT JOIN data_role on data_role.role_id=data_penjamin.role_id";
        $params['order_by'] = "penjamin_id DESC";

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