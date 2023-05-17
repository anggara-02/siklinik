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
class shift extends controller_admin {
	protected $st,$class;    
	 
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		$this->access="akses_setting_shift";
		$this->class="Managemen Shift";
    }

    public function index() { 
		redirect(base_url('admin/'.__class__.'/data'));
	}
		
    public function delete($id=0) { 
		common_lib::hak_akses($this->access,__function__,'controller');	
		$has_exist=$this->common_lib->select_row('data_shift','shift_id='.intval($id));
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/data?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
		// $result=$this->common_lib->delete_permanent('data_shift',array('shift_id'=>intval($id)));
		$result=$this->common_lib->delete_semu('data_shift',array('shift_id'=>intval($id)));
		redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				
		
	}
    public function edit($id=0) {  
		$has_exist=$this->common_lib->select_row('data_shift','shift_id='.intval($id));
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
				$result=$this->common_lib->store_form('data_shift',$_POST,array('shift_id'=>intval($id)));
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
				// $data=common_lib::setState($result); 
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		} 
        
		$common['data']=$has_exist;
		
		$st->slice('head_login'); 
        $common['shift_arr'] = $this->common_lib->select_result('data_shift','is_delete=0'); 
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
				$_SESSION['temp_for_action']=$this->keyAdmin;
				$result=$this->common_lib->store_form('data_shift',$_POST);
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
				// $data=common_lib::setState($result); 
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		} 
        $st->slice('head_login'); 
        $common['shift_arr'] = $this->common_lib->select_result('data_shift','is_delete=0'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	
    public function get_data() {   
		
		$result=$this->mainModel->get_data();
		$query=$result['query'];
		$total=$result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $_POST['rp'] = isset($_POST['rp']) ? $_POST['rp'] : 1;
        $json_data = array('page' => $page, 'total' => $total, 'rows' => array());
        $prev_trx = '';
        $no = 0 + ($_POST['rp'] * ($page - 1));
        foreach ($query->result() as $row) {
            
            foreach($row AS $variable=>$value)
            {
                ${$variable}=$value;
            }
        $no++;  $label_confirm="'Yakin hapus data ini?'";
        $entry = array('id' => $no,
            'cell' => array(
                'no' =>  $no,
				'action' => (common_lib::hak_akses($this->access,'edit','menu')=='1')?'<a href="'.site_url('admin/'.__class__.'/edit/'.$shift_id.'').'" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Edit</a>':'',
                'delete' =>  (common_lib::hak_akses($this->access,'delete','menu')=='1')?' <a onclick="return confirm('.$label_confirm.');" href="'.site_url('admin/'.__class__.'/delete/'.$shift_id.'').'" class="btn btn-sm btn-danger">Delete</a>':'',
                // 'delete' =>  ' <a onclick="return confirm('.$label_confirm.');" href="'.site_url('admin/'.__class__.'/delete/'.$shift_id.'').'" class="btn btn-sm btn-danger">Delete</a>',
                'shift_name'=>$shift_name,
                'shift_keterangan'=>$shift_keterangan, 
             
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
        $common['title'] = ucfirst(__function__.' - '.$this->class);
        $st = new Stencil();
		 
		if($this->input->post('save'))
		{
			// echo '<pre>';print_r($_POST);exit;
			$shift_id=$this->input->post('shift_id');
			$shift_name=$this->input->post('shift_name');
			$shift_hour_start=$this->input->post('shift_hour_start');
			$shift_hour_end=$this->input->post('shift_hour_end');
			$shift_is_active=$this->input->post('shift_is_active');
			foreach($shift_id as $index=>$value)
			{
				$_shift_hour_start=isset($shift_hour_start[$index])?$shift_hour_start[$index]:'00:00:00';
				$_shift_hour_end=isset($shift_hour_end[$index])?$shift_hour_end[$index]:'23:59:59';
				$_shift_is_active=isset($shift_is_active[$index])?$shift_is_active[$index]:'1';
				$data=array(
					'shift_hour_start'=>$_shift_hour_start,
					'shift_hour_end'=>$_shift_hour_end,
					'shift_is_active'=>$_shift_is_active,
				);
				$this->db->update('data_shift',$data,array('shift_id'=>$value));
			}
		}	
		 
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
        $common['access'] = $this->access;
        $common['shiftArr'] = $this->common_lib->select_result('data_shift','is_delete=0');
		
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