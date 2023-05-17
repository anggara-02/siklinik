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
class user_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
    
	function action_is_active()
	{
		$user_id=$this->CI->input->post('user_id',true);
		$is_active=$this->CI->input->post('is_active',true);
		$dataArr=array(
			'is_active'=>$is_active,
		);
		$this->CI->db->update('data_user',$dataArr,array('user_id'=>$user_id));
		
		return array(
			'status'=>200,
			'message'=>'Data Sukses diubah',
		);
	}
	
	function stored()
	{
		// $_POST['is_active']=isset($_POST['is_active'])?'1':'0';
		$role_id=$this->CI->input->post('role_id',true);
		$user_karyawan=$this->CI->input->post('user_karyawan',true);
		$user_name=$this->CI->input->post('user_name',true);
		$user_password=$this->CI->input->post('user_password',true);
		$user_sip=$this->CI->input->post('user_sip',true);
		
		$dataArr=array(
			'user_password'=>md5($user_password),
			'role_id'=>$role_id,
			'user_name'=>$user_name,
			'user_sip'=>$user_sip,
			'user_karyawan'=>$user_karyawan,
			'is_active'=>1,
		);
		$this->CI->db->insert('data_user',$dataArr);
		
		return array(
			'status'=>200,
			'message'=>'Data Sukses disimpan',
		);
	}
	
	function stored_edit()
	{
		// $_POST['is_active']=isset($_POST['is_active'])?'1':'0';
		$user_id=$this->CI->input->post('user_id',true);
		$role_id=$this->CI->input->post('role_id',true);
		$user_karyawan=$this->CI->input->post('user_karyawan',true);
		$user_name=$this->CI->input->post('user_name',true);
		$user_sip=$this->CI->input->post('user_sip',true);
		
		$dataArr=array(
			// 'user_password'=>md5($user_password),
			'role_id'=>$role_id,
			'user_name'=>$user_name,
			'user_sip'=>$user_sip,
			'user_karyawan'=>$user_karyawan,
		);
		$this->CI->db->update('data_user',$dataArr,array('user_id'=>$user_id));
		
		return array(
			'status'=>200,
			'message'=>'Data Sukses diubah',
		);
	}
	
	function get_role_by_api()
	{
		$role_arr=file_get_contents(site_url('api/execute/get_data_role_result'));
		$role_arr=json_decode($role_arr,true);
        return $role_arr; 
	}
	
	function store_form($id=0)
	{
		//$data_form=array();
	}
	
	function validate_form_password_old($id=0)
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array(
                array(
                     'field'   => "user_id",
                     'label'   => 'User',
                     'rules'   => 'trim|required'
                ), 
                array(
                     'field'   => "user_password",
                     'label'   => 'Password User',
                     'rules'   => 'trim|required|min_length[6]'
                ), 
                array(
                     'field'   => "user_repassword",
                     'label'   => 'Konfirmasi Password User',
                     'rules'   => 'trim|required|min_length[6]|matches[user_password]'
                ), 
                array(
                     'field'   => "user_keterangan",
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
				$user_password_old=$this->CI->input->post('user_password_old');
				$match=$this->CI->common_lib->select_one('count(*)','data_user','user_id='.intval($id).' AND user_password="'.md5($user_password_old).'"');
				if(intval($match)<=0)
				{
					$status=500;
					$message="Password lama tidak sama.";
				}
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
	
	function validate_form_password()
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array(
                array(
                     'field'   => "user_id",
                     'label'   => 'User',
                     'rules'   => 'trim|required'
                ), 
                array(
                     'field'   => "user_password",
                     'label'   => 'Password User',
                     'rules'   => 'trim|required|min_length[6]'
                ), 
                array(
                     'field'   => "user_repassword",
                     'label'   => 'Konfirmasi Password User',
                     'rules'   => 'trim|required|min_length[6]|matches[user_password]'
                ), 
                array(
                     'field'   => "user_keterangan",
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
	
	function validate_form_edit()
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array(
                array(
                     'field'   => "user_id",
                     'label'   => 'User',
                     'rules'   => 'trim|required'
                ),
                array(
                     'field'   => "user_name",
                     'label'   => 'Nama User',
                     'rules'   => 'trim|required|max_length[100]|is_unique_edit_custom[data_user.user_name.user_id.'.$_POST['user_id'].']'
                ), 
                array(
                     'field'   => "role_id",
                     'label'   => 'Role',
                     'rules'   => 'trim|required'
                ),
                array(
                     'field'   => "user_karyawan",
                     'label'   => 'Nama Karyawan',
                     'rules'   => 'trim|required|max_length[100]'
                ),
               /*  array(
                     'field'   => "user_password",
                     'label'   => 'Password User',
                     'rules'   => 'trim|required|min_length[6]'
                ), */
                // array(
                     // 'field'   => "user_repassword",
                     // 'label'   => 'Konfirmasi Password User',
                     // 'rules'   => 'trim|required|min_length[6]|matches[user_password]'
                // ),
                array(
                     'field'   => "user_keterangan",
                     'label'   => 'Keterangan',
                     'rules'   => 'trim|max_length[255]'
                ), 
			);
			
			$custom_validation=array();
			$change=$this->CI->input->post('change',true);	
			if($change=='1')
			{ 
				$custom_validation[count($validation)] =
                array(
                     'field'   => "user_password",
                     'label'   => 'Password User',
                     'rules'   => 'trim|required|min_length[6]'
                );
               $custom_validation[count($validation)+1] = array(
                     'field'   => "user_repassword",
                     'label'   => 'Konfirmasi Password User',
                     'rules'   => 'trim|required|min_length[6]|matches[user_password]'
                );
			}
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
	
	function validate_form()
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array(
                array(
                     'field'   => "user_name",
                     'label'   => 'Username',
                     'rules'   => 'trim|required|max_length[100]|is_unique[data_user.user_name]'
                ),
                array(
                     'field'   => "role_id",
                     'label'   => 'Role',
                     'rules'   => 'trim|required'
                ),
                array(
                     'field'   => "user_karyawan",
                     'label'   => 'Nama Karyawan',
                     'rules'   => 'trim|required|max_length[100]'
                ),
                array(
                     'field'   => "user_password",
                     'label'   => 'Password User',
                     'rules'   => 'trim|required|min_length[6]'
                ),
                // array(
                     // 'field'   => "user_repassword",
                     // 'label'   => 'Konfirmasi Password User',
                     // 'rules'   => 'trim|required|min_length[6]|matches[user_password]'
                // ),
                array(
                     'field'   => "user_keterangan",
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
	
	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'data_user';
        $params['select'] = "data_user.*,role_name";
        $where='1 and is_delete=0';
         
        if(trim($this->CI->input->get('user_name'))!='')
        {
            $where.=' AND user_name LIKE "%'.$this->CI->input->get('user_name').'%"';
        } 
        if(trim($this->CI->input->get('user_id'))!='')
        {
            $where.=' AND user_id = "'.$this->CI->input->get('user_id').'"';
        } 
        if(trim($this->CI->input->get('user_karyawan'))!='')
        {
            $where.=' AND user_karyawan LIKE "%'.$this->CI->input->get('user_karyawan').'%"';
        } 
         
        $params['where'] =$where;

        $params['join'] = "LEFT JOIN data_role on data_role.role_id=data_user.role_id";
        $params['order_by'] = "user_id DESC";

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