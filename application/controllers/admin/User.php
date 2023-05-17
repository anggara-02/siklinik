<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_admin.php';
class user extends controller_admin {
	protected $st,$access,$class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		$this->access="akses_setting_user";
		$this->class="Managemen User";
    }

    public function index() { 
		redirect(base_url('admin/'.__class__.'/data'));
	}
		
    public function delete($id=0) {   
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('data_user','user_id='.intval($id));
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/data?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
		// $result=$this->common_lib->delete_permanent('data_user',array('user_id'=>intval($id)));
		$result=$this->common_lib->delete_semu('data_user',array('user_id'=>intval($id)));
		redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				
		
	}
	
    public function mypassword($id=0) {  
		$id=common_lib::admin_user_id();
		// common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('data_user','user_id='.intval($id));
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/data?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		
        $common['title'] = ucfirst('Password');
        $st = new Stencil(); 
		if($this->input->post("save"))
		{ 
			$result=$this->mainModel->validate_form_password_old($id);
			$data=$result;
			if($data['status']==200)
			{ 
				unset($_POST['user_password_old']);
				$_SESSION['temp_for_action']=$this->keyAdmin;
				$_POST['user_password']=md5($_POST['user_password']);
				unset($_POST['user_repassword']);//unset post yang g perlu disimpan
				
				$result=$this->common_lib->store_form('data_user',$_POST,array('user_id'=>intval($id)));
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/mypassword?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
				// $data=common_lib::setState($result); 
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		} 
        
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
        // $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['role_arr'] = $this->common_lib->select_result('data_role','is_delete=0'); 
        $common['pegawai_arr'] = $this->common_lib->select_result('data_pegawai','is_delete=0'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	
    public function password($id=0) {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('data_user','user_id='.intval($id));
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/data?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		
        $common['title'] = ucfirst(__function__.' - '.$this->class);
        $st = new Stencil(); 
		if($this->input->post("save"))
		{ 
			$result=$this->mainModel->validate_form_password();
			$data=$result;
			if($data['status']==200)
			{ 
				$_SESSION['temp_for_action']=$this->keyAdmin;
				$_POST['user_password']=md5($_POST['user_password']);
				unset($_POST['user_repassword']);//unset post yang g perlu disimpan
				
				$result=$this->common_lib->store_form('data_user',$_POST,array('user_id'=>intval($id)));
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
				// $data=common_lib::setState($result); 
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		} 
        
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['role_arr'] = $this->common_lib->select_result('data_role','is_delete=0'); 
        $common['pegawai_arr'] = $this->common_lib->select_result('data_pegawai','is_delete=0'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	
	public function action_is_active($id=0) { 
		$id=isset($_POST['user_id'])?$_POST['user_id']:0;
		
		$result=$this->mainModel->action_is_active();			
		
		echo json_encode($result);
	}
	
	public function action_validation($id=0) { 
		$id=isset($_POST['user_id'])?$_POST['user_id']:0;
		if(intval($id)>0)
		{
			$result=$this->mainModel->validate_form_edit();
		}
		else
		{
			$result=$this->mainModel->validate_form();			
		}
		echo json_encode($result);
	}
	
	public function action_stored() { 
		$id=isset($_POST['user_id'])?$_POST['user_id']:0;
		if(intval($id)>0)
		{
			$result=$this->mainModel->stored_edit();
		}
		else
		{
			$result=$this->mainModel->stored();			
		}
		echo json_encode($result);
	}
	
    public function action_data_form() {   
	
		$result=$this->mainModel->get_data();
		$query=$result['query'];
		$total=$result['total'];
		$json_data=array(
			'status'=>500,
			'message'=>'Data tidak ditemukan',
			'data'=>array(),
		);
		$no=0;
        foreach ($query->result() as $row) {
            
            foreach($row AS $variable=>$value)
            {
                ${$variable}=$value;
            }
			$no++;  
		
		
			$json_data=array(
				'status'=>200,
				'message'=>'Data ditemukan',
				'data'=>array(),
			);
			
			$entry = array( 
				'no' =>  $no,
				'action' => '',
				'user_karyawan'=>$user_karyawan,
				'role_id'=>$role_id,
				'user_id'=>$user_id,
				'user_sip'=>$user_sip,
				'role_name'=>$role_name,
				'user_name'=>$user_name,
				'user_keterangan'=>$user_keterangan,
				'is_active'=>($is_active=="1")?"Aktif":"Nonaktif",
				'last_login'=>(trim($last_login!='')&&$last_login!='0000-00-00')?date('d M Y H:i:s',strtotime($last_login)):'-',
			);
			$json_data['data']= $entry;
				

        }
		
        echo json_encode($json_data); 
	}
	
	public function edit($id=0) {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('data_user','user_id='.intval($id));
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/data?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		
        $common['title'] = ucfirst(__function__.' - '.$this->class);
        $st = new Stencil(); 
		if($this->input->post("save"))
		{ 
			$result=$this->mainModel->validate_form_edit();
			$data=$result;
			if($data['status']==200)
			{ 
				$_SESSION['temp_for_action']=$this->keyAdmin;
				$_POST['is_active']=isset($_POST['is_active'])?'1':'0';
				if(isset($_POST['change'])&&$_POST['change']=='1')
				{
					$_POST['user_password']=md5($_POST['user_password']);
					unset($_POST['user_repassword']);//unset post yang g perlu disimpan
				}
				else
				{
					unset($_POST['user_password']);//unset post yang g perlu disimpan
					unset($_POST['user_repassword']);//unset post yang g perlu disimpan
				}
				unset($_POST['change']);//unset post yang g perlu disimpan
				
				$result=$this->common_lib->store_form('data_user',$_POST,array('user_id'=>intval($id)));
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
				// $data=common_lib::setState($result); 
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		} 
        
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['role_arr'] = $this->common_lib->select_result('data_role','is_delete=0'); 
        $common['pegawai_arr'] = $this->common_lib->select_result('data_pegawai','is_delete=0'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	
    public function add() {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
		
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		 
        $common['title'] = ucfirst(__function__.' - '.$this->class);
        $st = new Stencil(); 
		if($this->input->post("save"))
		{ 
			$result=$this->mainModel->validate_form();
			$data=$result;
			if($data['status']==200)
			{
				$_POST['user_password']=md5($_POST['user_password']);
				unset($_POST['user_repassword']);//unset post yang g perlu disimpan
				$_SESSION['temp_for_action']=$this->keyAdmin;
				$result=$this->common_lib->store_form('data_user',$_POST);
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
				// $data=common_lib::setState($result); 
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		} 
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		
        $common['class'] = __class__;
        $st->slice('head_login'); 
        $common['role_arr'] = $this->common_lib->select_result('data_role','is_delete=0'); 
        $common['pegawai_arr'] = $this->common_lib->select_result('data_pegawai','is_delete=0'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

    public function get_datatable() {   
		$result=$this->mainModel->get_data();
		$query=$result['query'];
		$total=$result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
		 $json_data = array('start' => $start, 'recordsTotal' => ($_POST['length']>0)?$_POST['length']:$total,'recordsFiltered' => $total, 'data' => array());
        $prev_trx = '';
        $no = 0 + $start;
        foreach ($query->result() as $row) {
            
            foreach($row AS $variable=>$value)
            {
                ${$variable}=$value;
            }
        $no++;  $label_confirm="'Yakin hapus data ini?'";
		
		$action=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="#" onclick="edit_form('.$user_id.')" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>':'';
		// $action.=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="'.site_url('admin/'.__class__.'/password/'.$user_id.'').'" style="margin-right:5px" class="btn btn-warning btn-icon"><i class="fa fa-lock"></i></a>':'';
		$icon=($is_active=='1')?'times':'check';
		$_is_active=($is_active=='0')?'1':'0';
		$action.=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="#" onclick="trx_aktif('.$_is_active.','.$user_id.')" style="margin-right:5px" class="btn btn-warning btn-icon"><i class="fa fa-'.$icon.'"></i></a>':'';
		$action.=common_lib::hak_akses($this->access,'delete','menu')=='1'?'<a onclick="return validasi_delete();" href="'.site_url('admin/'.__class__.'/delete/'.$user_id.'').'" class="btn btn-danger btn-icon btn-delete"><i class="fa fa-trash"></i></a>':'';
        
        $entry = array(
                'no' =>  $no,
                'action' => $action,
                'user_karyawan'=>$user_karyawan,
                'user_id'=>$user_id,
                'user_sip'=>$user_sip,
                'role_name'=>$role_name,
                'user_name'=>$user_name,
                'user_keterangan'=>$user_keterangan,
                'is_active'=>($is_active=="1")?"Aktif":"Nonaktif",
                'last_login'=>(trim($last_login!='')&&$last_login!='0000-00-00')?date('d M Y H:i:s',strtotime($last_login)):'-',
             
        );
        $json_data['data'][] = $entry;
            

        }

        echo json_encode($json_data); 
	}
	
    public function get_data() {   
		$result=$this->mainModel->get_data();
		$query=$result['query'];
		$total=$result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $pagination = ceil($total/$_POST['rp']);
        $json_data = array('page' => $page, 'pagination' => $pagination, 'total' => $total, 'rows' => array());
        $prev_trx = '';
        $no = 0 + ($_POST['rp'] * ($page - 1));
        foreach ($query->result() as $row) {
            
            foreach($row AS $variable=>$value)
            {
                ${$variable}=$value;
            }
        $no++;  $label_confirm="'Yakin hapus data ini?'";
		
		$action=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="#" onclick="edit_form('.$user_id.')" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>':'';
		// $action.=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="'.site_url('admin/'.__class__.'/password/'.$user_id.'').'" style="margin-right:5px" class="btn btn-warning btn-icon"><i class="fa fa-lock"></i></a>':'';
		$icon=($is_active=='1')?'times':'check';
		$_is_active=($is_active=='0')?'1':'0';
		$action.=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="#" onclick="trx_aktif('.$_is_active.','.$user_id.')" style="margin-right:5px" class="btn btn-warning btn-icon"><i class="fa fa-'.$icon.'"></i></a>':'';
		$action.=common_lib::hak_akses($this->access,'delete','menu')=='1'?'<a onclick="return validasi_delete();" href="'.site_url('admin/'.__class__.'/delete/'.$user_id.'').'" class="btn btn-danger btn-icon btn-delete"><i class="fa fa-trash"></i></a>':'';
        
        $entry = array('id' => $no,
            'cell' => array(
                'no' =>  $no,
                'action' => $action,
                'user_karyawan'=>$user_karyawan,
                'user_id'=>$user_id,
                'user_sip'=>$user_sip,
                'role_name'=>$role_name,
                'user_name'=>$user_name,
                'user_keterangan'=>$user_keterangan,
                'is_active'=>($is_active=="1")?"Aktif":"Nonaktif",
                'last_login'=>(trim($last_login!='')&&$last_login!='0000-00-00')?date('d M Y H:i:s',strtotime($last_login)):'-',
             
            ),
        );
        $json_data['rows'][] = $entry;
            

        }

        echo json_encode($json_data); 
	}
		
    public function data() {  
		
		common_lib::hak_akses($this->access,__function__,'controller'); 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class);
        $st = new Stencil();
        
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
        $common['access'] = $this->access;
        $common['role_arr'] = $this->common_lib->select_result('data_role','is_delete=0'); 
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */