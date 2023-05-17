<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_admin.php';
class jadwal extends controller_admin {
	protected $st,$access,$class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		// $this->access="akses_setting_penjamin";
		$this->class="Jadwal";
    }

    public function index() { 
		redirect(base_url('admin/'.__class__.'/data'));
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
        $common['shift_arr'] = $this->common_lib->select_result('data_shift','is_delete=0 order by shift_hour_start ASC'); 
        $common['dokter_arr'] = $this->common_lib->select_result('data_user join data_role on data_role.role_id=data_user.role_id','data_user.is_delete=0 AND lower(role_name)="dokter"','user_id,user_name,user_karyawan'); 
        $common['perawat_arr'] = $this->common_lib->select_result('data_user join data_role on data_role.role_id=data_user.role_id','data_user.is_delete=0 AND lower(role_name)="perawat"','user_id,user_name,user_karyawan'); 
		
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
            foreach($row AS $variable=>$value) {
                ${$variable}=$value;
            }
			$no++;
			$action='<a href="#" onclick="edit_form('.$jadwal_id.')" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>';
			$action.='<a href="javascript:void(0);" data-url="'.site_url('admin/'.__class__.'/delete/'.$jadwal_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation"><i class="fa fa-trash"></i></a>';
			
			$entry = array(
					'no' =>  $no,
					'action' => $action,
					'jadwal_id'=>$jadwal_id,
					'jadwal_date'=>$jadwal_date,
					'jadwal_poli'=>$jadwal_poli,
					'jadwal_shift_id'=>$jadwal_shift_id,
					'jadwal_shift_name'=>$jadwal_shift_name,
					'jadwal_dokter_id'=>$jadwal_dokter_id,
					'jadwal_dokter_name'=>$jadwal_dokter_name,
					'jadwal_perawat_id'=>$jadwal_perawat_id,
					'jadwal_perawat_name'=>$jadwal_perawat_name,
				
			);
			$json_data['data'][] = $entry;
        }

        echo json_encode($json_data); 
	}
		
    public function delete($id=0) {   
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('data_jadwal','jadwal_id='.intval($id));
		if(empty($has_exist)) {
			redirect(base_url($this->module.'/'.__class__.'/data?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
		$result=$this->common_lib->delete_permanent('data_jadwal',['jadwal_id'=>intval($id)]);
		redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
	}
	
	public function action_validation($id=0) { 
		$id=isset($_POST['jadwal_id'])?$_POST['jadwal_id']:0;
		if(intval($id)>0) {
			$result=$this->mainModel->validate_form($id);
		} else {
			$result=$this->mainModel->validate_form();			
		}
		echo json_encode($result);
	}
	
	public function action_stored() { 
		$id=isset($_POST['jadwal_id'])?$_POST['jadwal_id']:0;
		if(intval($id)>0) {
			$result=$this->mainModel->stored($id);
		} else {
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
            foreach($row AS $key => $value) {
                ${$key}=$value;
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
				'jadwal_id'=>$jadwal_id,
				'jadwal_poli'=>$jadwal_poli,
				'jadwal_date'=>$jadwal_date,
				'jadwal_shift_id'=>$jadwal_shift_id,
				'jadwal_dokter_id'=>$jadwal_dokter_id,
				'jadwal_perawat_id'=>$jadwal_perawat_id,
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
		  
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['dokter_arr'] = $this->common_lib->select_result('data_user join data_role on data_role.role_id=data_user.role_id','data_user.is_delete=0 AND lower(role_name)="dokter"','user_id,user_name,user_karyawan'); 
        $common['perawat_arr'] = $this->common_lib->select_result('data_user join data_role on data_role.role_id=data_user.role_id','data_user.is_delete=0 AND lower(role_name)="perawat"','user_id,user_name,user_karyawan'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
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