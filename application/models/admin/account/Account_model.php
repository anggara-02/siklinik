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
class account_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct();
    }
    
    function do_login_session($user=array()) {
		$_CI=&get_instance();
		$_SESSION[$this->keyAdmin]=$user;
	}
	
    function do_login($user=array(),$shift=1) {
		$_CI=&get_instance();
		
		$sqlUser='UPDATE data_user SET last_login="'.date('Y-m-d H:i:s').'"
					WHERE user_id="'.  intval($user['user_id']).'"';  
		$_CI->db->query($sqlUser);
		
		
		$user=$_CI->common_lib->select_row('data_user','user_id="'.$user['user_id'].'"');
		$role=$_CI->common_lib->select_row('data_role','role_id="'.$user['role_id'].'"');
		$akses=$_CI->common_lib->select_row('setting_akses','role_id="'.$user['role_id'].'"');
		$shift=$_CI->common_lib->select_row('data_shift','shift_id="'.$shift.'"');
		$_SESSION[$this->keyAdmin]=$user;
		$_SESSION[$this->keyAdmin]['shift']=$shift;
		$_SESSION[$this->keyAdmin]['grup']=$role;
		$_SESSION[$this->keyAdmin]['akses']=$akses;
	}
	
    function do_logout() {
		unset($_SESSION[$this->keyAdmin]) ;
		redirect('manage');
	}
	
    function validate_login() {
		
		$_CI=&get_instance();
        $validation = array(
                array(
                    'field'   => 'user_name',
                    'label'   => 'Username',
                    'rules'   => 'trim|required'
                ),
                array(
                    'field'   => 'user_password',
                    'label'   => 'Password',
                    'rules'   => 'trim|required|min_length[6]'
                ), 
            );
			
		  $_CI->form_validation->set_rules($validation);
		  if ($_CI->form_validation->run() == TRUE)
		  {	
				$user_name=$_CI->input->post('user_name',true);
				$user_password=$_CI->input->post('user_password',true);
				$shift=$_CI->input->post('shift',true);
				$user=$_CI->common_lib->select_row('data_user','user_name="'.$user_name.'" AND user_password="'.md5($user_password).'" AND is_delete=0');
				$valid=$_CI->common_lib->select_one('role_id','data_user','user_name="'.$user_name.'" AND user_password="'.md5($user_password).'" AND is_delete=0');
				$is_active=$_CI->common_lib->select_one('is_active','data_user','user_name="'.$user_name.'" AND user_password="'.md5($user_password).'"');
				$is_suspend=$_CI->common_lib->select_one('is_suspend','data_user','user_name="'.$user_name.'" AND user_password="'.md5($user_password).'"');
				$is_access=false;
				if(empty($user))
				{ 
					return array(
					  'status'=>500,
					  'message'=>"Username atau password salah!",
					);
				}
				else if($user['is_active']!="1")
				{ 
					return array(
					  'status'=>500,
					  'message'=>"Username ditolak login karena belum diaktifkan. Silahkan Hubungi admin!",
					);
				} 
				else if($user['is_suspend']!="0")
				{ 
					return array(
					  'status'=>500,
					  'message'=>"Username ditolak login karena sedang disuspend. Silahkan Hubungi admin!",
					);
				} 
				else{
				
					$this->do_login($user,$shift);
					
					return array(
					  'status'=>200,
					  'message'=>"Login sukses",
					);
					
				}
				/* if(!empty($this->role_arr))
				{
					foreach($this->role_arr as $value)
					{
						if($valid==$value)
						{
							$is_access=true;
							break;
						}
					}
				} */ 

		  }
		  else 
		  { 
			  return array(
				  'status'=>500,
				  'message'=>validation_errors(),
			  );

		  }
		  
		  
		return array(
		  'status'=>500,
		  'message'=>"Tidak terjadi apapun",
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