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
class registration extends controller_admin {
	protected $st,$access,$class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		$this->access="akses_trx_registration";
		$this->class="Pendaftaran";
    }

    public function index() { 
		redirect(base_url('admin/'.__class__.'/data'));
	}
	
	
    public function send_to_pemeriksaan() { 
		$id=isset($_POST['pendaftaran_id'])?$_POST['pendaftaran_id']:0;
		$result=$this->mainModel->send_to_pemeriksaan($id);					
		echo json_encode($result);
	
	}
	
    public function search_pasien_by_rm_nik_penjamin() { 
	 
        $search=str_replace('%20', ' ', $this->input->get('term'));   
        $findAll=$this->db->query('select * from data_pasien where 1 AND (pasien_rm LIKE "%'.$search.'%" OR pasien_nik LIKE "%'.$search.'%" OR pasien_penjamin_no LIKE "%'.$search.'%") order by pasien_name asc limit 15')->result_array();

        $data=array();
        if(!empty($findAll))
        {
            $no=1;
            foreach($findAll AS $rowArr)
            {   
                 $data[$no]['id']=$rowArr['pasien_id']; 
				 // $data[$no]['label']=$rowArr['pasien_nama'].' | '.$rowArr['pasien_rm_number'].' | '.$rowArr['pasien_alamat'];
				 $data[$no]['label']=$rowArr['pasien_name'].' | '.$rowArr['pasien_rm'];
				 $data[$no]['pasien_rm']=$rowArr['pasien_rm'];
				 $data[$no]['pasien_name']=$rowArr['pasien_name'];
				 $data[$no]['pasien_nik']=$rowArr['pasien_nik'];                 
				 $data[$no]['pasien_penjamin_id']=$rowArr['pasien_penjamin_id'];                 
				 $data[$no]['pasien_penjamin_no']=$rowArr['pasien_penjamin_no'];                 
				 $data[$no]['pasien_ibu']=$rowArr['pasien_ibu'];                 
				 $data[$no]['pasien_address']=$rowArr['pasien_address'];                 
				 $data[$no]['pasien_gender']=$rowArr['pasien_gender'];                 
				 $data[$no]['pasien_birthplace']=$rowArr['pasien_birthplace'];                 
				 $data[$no]['pasien_birthdate']=$rowArr['pasien_birthdate'];                 
				 $data[$no]['pasien_pernikahan']=$rowArr['pasien_pernikahan'];                 
                 $no++;

            }
        }
        echo json_encode($data);
    
	}
	
		
    public function delete($id=0) {   
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('trx_pendaftaran','pendaftaran_id='.intval($id));
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/data?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
		// $result=$this->common_lib->delete_permanent('trx_pendaftaran',array('pendaftaran_id'=>intval($id)));
		$result=$this->mainModel->delete_semu(intval($id));
		redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				
		
	}
	
	public function action_is_status($id=0) { 
		$id=isset($_POST['pendaftaran_id'])?$_POST['pendaftaran_id']:0;
		
		$result=$this->mainModel->action_is_status();			
		
		echo json_encode($result);
	}
	
	public function action_validation($id=0) { 
		$id=isset($_POST['pendaftaran_id'])?$_POST['pendaftaran_id']:0;
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
		$id=isset($_POST['pendaftaran_id'])?$_POST['pendaftaran_id']:0;
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
				'pendaftaran_no'=>$pendaftaran_no, 
				'pendaftaran_status'=>ucfirst($pendaftaran_status), 
				'pendaftaran_pasien_name'=>$pendaftaran_pasien_name, 
				'pendaftaran_pasien_rm'=>$pendaftaran_pasien_rm, 
				'pendaftaran_pasien_gender'=>(trim($pendaftaran_pasien_gender)=='female'?'Perempuan':'Laki-Laki'), 
				'pendaftaran_date'=>date('d-m-Y',strtotime($pendaftaran_date)), 
				'pendaftaran_pasien_birthdate'=>date('d-m-Y',strtotime($pendaftaran_pasien_birthdate)), 
				'poli'=>'-', 
			);
			$json_data['data']= $entry;
				

        }
		
        echo json_encode($json_data); 
	}
	
	public function edit($id=0) {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('trx_pendaftaran','pendaftaran_id='.intval($id).' AND pendaftaran_is_delete=0 AND pendaftaran_status="pendaftaran"');
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
				$result=$this->mainModel->store_form($id);
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
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
		
		$common['detail'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($id).''); 
		
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['penjamin_arr'] = $this->common_lib->select_result('data_penjamin','is_delete=0'); 
        $currentShift = common_lib::currenShift(); 
        $common['jadwal_lab_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="laboratorium" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        $common['jadwal_umum_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="umum" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        $common['layanan_arr'] = $this->common_lib->select_result('data_layanan join data_poli on layanan_poli_id=poli_id','data_layanan.is_delete=0'); 
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
		// echo '<pre>';print_r($_POST);exit;
		if($this->input->post("save"))
		{ 
			$result=$this->mainModel->validate_form();
			$data=$result;
			if($data['status']==200)
			{
				// $_SESSION['temp_for_action']=$this->keyAdmin;
				$result=$this->mainModel->store_form();
				// $result=$this->common_lib->store_form('trx_pendaftaran',$_POST);
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
        $common['penjamin_arr'] = $this->common_lib->select_result('data_penjamin','is_delete=0'); 
        $currentShift = common_lib::currenShift(); 
        $common['jadwal_lab_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="laboratorium" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        $common['jadwal_umum_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="umum" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        $common['layanan_arr'] = $this->common_lib->select_result('data_layanan join data_poli on layanan_poli_id=poli_id','data_layanan.is_delete=0'); 
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
		$action='';
		$action=common_lib::hak_akses($this->access,'edit','menu')=='1'&&($pendaftaran_status=='pendaftaran')?'<a href="'.base_url('admin/'.__class__.'/edit/'.$pendaftaran_id.'').'" onclick="edit_form('.$pendaftaran_id.')" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>':'';
		// $action.=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="'.site_url('admin/'.__class__.'/password/'.$pendaftaran_id.'').'" style="margin-right:5px" class="btn btn-warning btn-icon"><i class="fa fa-lock"></i></a>':'';
		$icon=($pendaftaran_status=='pendaftaran')?'check':'times';
		$trx_action=(strtolower($pendaftaran_status)=='pendaftaran')?"send_to_pemeriksaan('pemeriksaan',".$pendaftaran_id.")":"return false;";
		$_pendaftaran_status=($pendaftaran_status=='pendaftaran')?'<div class="badge badge-primary">Pendaftaran</div>':'<div class="badge badge-success">Pemeriksaan</div>';
		$action.=common_lib::hak_akses($this->access,'edit','menu')=='1'&&strtolower($pendaftaran_status)=='pendaftaran'?'<a href="#" onclick="'.$trx_action.'" style="margin-right:5px" class="btn btn-success btn-icon"><i class="fa fa-'.$icon.'"></i></a>':'';
		$action.=common_lib::hak_akses($this->access,'delete','menu')=='1'&&strtolower($pendaftaran_status)=='pendaftaran'?'<a onclick="return validasi_delete('.$pendaftaran_id.');" href="'.site_url('admin/'.__class__.'/delete/'.$pendaftaran_id.'').'" class="btn btn-danger btn-icon btn-delete"><i class="fa fa-trash"></i></a>':'';
        
		
		$entry = array( 
			'no' =>  $no,
			'action' => $action,
			'pendaftaran_no'=>$pendaftaran_no, 
			'pendaftaran_status'=>$_pendaftaran_status, 
			'pendaftaran_pasien_name'=>$pendaftaran_pasien_name, 
			'pendaftaran_pasien_rm'=>$pendaftaran_pasien_rm, 
			'pendaftaran_penjamin_nama'=>$pendaftaran_penjamin_nama, 
			'pendaftaran_pasien_gender'=>(trim($pendaftaran_pasien_gender)=='female'?'Perempuan':'Laki-Laki'), 
			'pendaftaran_date'=>date('d-m-Y',strtotime($pendaftaran_date)), 
			'pendaftaran_pasien_birthdate'=>date('d-m-Y',strtotime($pendaftaran_pasien_birthdate)), 
			'poli'=>'-', 
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
		
		$action=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="#" onclick="edit_form('.$pendaftaran_id.')" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>':'';
		// $action.=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="'.site_url('admin/'.__class__.'/password/'.$pendaftaran_id.'').'" style="margin-right:5px" class="btn btn-warning btn-icon"><i class="fa fa-lock"></i></a>':'';
		$icon=($is_active=='1')?'times':'check';
		$_is_active=($is_active=='0')?'1':'0';
		$action.=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="#" onclick="trx_aktif('.$_is_active.','.$pendaftaran_id.')" style="margin-right:5px" class="btn btn-warning btn-icon"><i class="fa fa-'.$icon.'"></i></a>':'';
		$action.=common_lib::hak_akses($this->access,'delete','menu')=='1'?'<a onclick="return validasi_delete();" href="'.site_url('admin/'.__class__.'/delete/'.$pendaftaran_id.'').'" class="btn btn-danger btn-icon btn-delete"><i class="fa fa-trash"></i></a>':'';
        
        $entry = array('id' => $no,
            'cell' => array(
                'no' =>  $no,
                'action' => $action,
                'user_karyawan'=>$user_karyawan,
                'pendaftaran_id'=>$pendaftaran_id,
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