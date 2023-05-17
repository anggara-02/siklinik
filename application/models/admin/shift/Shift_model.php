<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_model.php';
class shift_model extends controller_model{
	protected $shift_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
    
	function store_form($id=0)
	{
		//$data_form=array();
	}
	function validate_form_edit()
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array( 
                array(
                     'field'   => "shift_name",
                     'label'   => 'Nama Shift',
                     'rules'   => 'trim|required|max_length[200]|is_unique_edit_custom[data_shift.shift_name.shift_id.'.$_POST['shift_id'].']'
                ), 
                array(
                     'field'   => "shift_keterangan",
                     'label'   => 'Keterangan',
                     'rules'   => 'trim|max_length[255]'
                ), 
			);
			
			$custom_validation=array();
			$this->CI->form_validation->set_rules(array_merge($validation,$custom_validation));

			if ($this->CI->form_validation->run() == TRUE)
			{
				
				$status=200;
				$message="Ok.";
			}
			else
			{
				$status=500;
				$message=validation_errors(); 
				return array(
					'status'=>$status,
					'message'=>$message,
				);
			}
          
          return array(
              'status'=>$status,
              'message'=>$message,
          );
         

    }
	
	function validate_form()
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array(
                array(
                     'field'   => "shift_name",
                     'label'   => 'Nama Shift',
                     'rules'   => 'trim|required|max_length[200]|is_unique[data_shift.shift_name]'
                ), 
                array(
                     'field'   => "shift_keterangan",
                     'label'   => 'Keterangan',
                     'rules'   => 'trim|max_length[255]'
                ), 
			);
			
			$custom_validation=array();
			$this->CI->form_validation->set_rules(array_merge($validation,$custom_validation));

			if ($this->CI->form_validation->run() == TRUE)
			{
				
				$status=200;
				$message="Terjadi kesalahan, silahkan ulangi kembali.";
			}
			else
			{
				$status=500;
				$message=validation_errors(); 
				return array(
					'status'=>$status,
					'message'=>$message,
				);
			}
          
          return array(
              'status'=>$status,
              'message'=>$message,
          );
         

    }
	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $shift_name=$this->CI->input->get('shift_name'); 
        $params['table'] = 'data_shift';
        $params['select'] = "*";
        $where='1 and is_delete=0';
         
        if(trim($shift_name)!='')
        {
            $where.=' AND shift_name LIKE "%'.$shift_name.'%"';
        } 
         
        $params['where'] =$where;

        $params['order_by'] = "shift_id DESC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query,
			'total'=>$total,
		);
	}
}