<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_front.php';
class account extends controller_front {
	protected $st; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->moduleAdmin.'/'.__class__.'/'.__class__.'_model'); 
		
		$this->mainModel=new $_model();
    }

    public function logout() {  
	
		$result=$this->mainModel->do_logout();
		return $result;
	}
	
    public function login() {  
		// $this->logout();
		$result=common_lib::hasLogin($this->moduleAdmin);
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$data=common_lib::getState($this);  
		
        $common['config'] = common_lib::getConfig();
        $common['title'] = 'Login Sistem';
        $st = new Stencil();
		 
		if($this->input->post("submit"))
		{
			$data=$this->mainModel->validate_login();
			if($data['status']==200)
			{ 
				redirect(base_url($this->moduleAdmin.'/dashboard'));
			}
		} 
		 
        $st->slice('head_login');
        $st->layout('template_login');
        $common['ThemeUrl'] =$this->ThemeUrl;
        $common['status'] = $data['status'];
        $common['message'] = $data['message'];
        $common['js_files'] = ''; 
        $common['css_files'] = '';
        $common['data_shift'] = $this->common_lib->select_result('data_shift','shift_is_active=1 AND is_delete=0');
		$common['shift_time'] =date('H:i:s');
		
		
        $st->paint($this->template.'/'.$this->moduleAdmin,__class__.'/'.__function__, $common);
    }

}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */