<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_model.php';
class config_model extends controller_model{
	protected $role_arr;
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
                     'field'   => "config_name",
                     'label'   => 'Nama',
                     'rules'   => 'trim|required|max_length[200]'
                ), 
                array(
                     'field'   => "config_phone",
                     'label'   => 'Telp',
                     'rules'   => 'trim|required|max_length[255]'
                ), 
                array(
                     'field'   => "config_fax",
                     'label'   => 'Fax',
                     'rules'   => 'trim|required|max_length[200]'
                ), 
                array(
                     'field'   => "config_email",
                     'label'   => 'Email',
                     'rules'   => 'trim|required|max_length[100]|valid_email'
                ), 
                array(
                     'field'   => "config_province_name",
                     'label'   => 'Provinsi',
                     'rules'   => 'trim|required|max_length[200]'
                ), 
                array(
                     'field'   => "config_city_name",
                     'label'   => 'Kab/Kota',
                     'rules'   => 'trim|required|max_length[200]'
                ), 
                array(
                     'field'   => "config_address",
                     'label'   => 'Alamat',
                     'rules'   => 'trim|required|max_length[255]'
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
	
	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
         
        $params['table'] = 'setting_config';
        $params['select'] = "*";
        $where='1 and is_delete=0';
         
         
        $params['where'] =$where;

        $params['order_by'] = "setting_config DESC";

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
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */