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
class pasien extends controller_admin {
	protected $st,$access,$class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		$this->access="akses_setting_pasien";
		$this->class="Pasien";
    }

    public function index() { 
		redirect(base_url('admin/'.__class__.'/data'));
	}
	
    public function klinik() {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class).' Klinik';
        $st = new Stencil();
        
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

    public function klinik_edit($id=0) {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('data_pasien','pasien_id='.intval($id));
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/klinik/index?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class);
        $st = new Stencil();
        
		
		if($this->input->post("submit"))
		{ 
			$result=$this->mainModel->klinik_validate_form($id);
			
			$data=$result;
			if($data['status']==200)
			{ 
				$result=$this->mainModel->klinik_stored($id);
				
				$data=$result;
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/klinik/index?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		}
		
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		$common['penjamin_arr'] = $this->common_lib->select_result('data_penjamin','is_delete=0'); 
		$common['pemeriksaan_arr'] = $this->common_lib->select_result('trx_pemeriksaan','pemeriksaan_pasien_id='.$id); 
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

    public function get_datatable() {
		$result=$this->mainModel->get_data_klinik();
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
			$action='<a href="'.base_url('admin/pasien/klinik/edit/'.$pasien_id).'" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>';
			// $action.='<a href="'.base_url('admin/pasien/klinik/edit/'.$pasien_id).'" data-url="'.site_url('admin/'.__class__.'/delete/'.$jadwal_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation"><i class="fa fa-trash"></i></a>';
			$pasien_penjamin_name=$this->common_lib->select_one('penjamin_name','data_penjamin','penjamin_id="'.intval($pasien_penjamin_id).'"');
			$entry = array(
					'no' =>  $no,
					'action' => $action,
					'pasien_id'=>$pasien_id,
					'pasien_name'=>$pasien_name,
					'pasien_rm'=>$pasien_rm,
					'pasien_nik'=>$pasien_nik,
					'pasien_penjamin_id'=>$pasien_penjamin_id,
					'pasien_penjamin_name'=>$pasien_penjamin_name,
					'pasien_penjamin_no'=>$pasien_penjamin_no,
					'pasien_ibu'=>$pasien_ibu,
					'pasien_address'=>$pasien_address,
					'pasien_gender'=>$pasien_gender,
					'pasien_birthplace'=>$pasien_birthplace,
					'pasien_birthdate'=>date('d-m-Y',strtotime($pasien_birthdate)),
					'pasien_pernikahan'=>$pasien_pernikahan,				
			);
			$json_data['data'][] = $entry;
        }

        echo json_encode($json_data); 
	}
	
    public function apotek() {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class).' Apotek';
        $st = new Stencil();
        
        $st->slice('head_login');  
        $common['access'] = $this->access; 
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		$common['membership_arr'] = $this->common_lib->select_result('data_membership','is_delete=0'); 
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

    public function apotek_add($id=0) {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
		 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class);
        $st = new Stencil();
        
		
		if($this->input->post("submit"))
		{ 
			$result=$this->mainModel->apotek_validate_form();
			
			$data=$result;
			if($data['status']==200)
			{ 
				$result=$this->mainModel->apotek_stored();
				
				$data=$result;
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/apotek/index?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		}
		
		 
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		$common['penjamin_arr'] = $this->common_lib->select_result('data_penjamin','is_delete=0');  
		$common['membership_arr'] = $this->common_lib->select_result('data_membership','is_delete=0'); 
		$common['pemeriksaan_arr'] = array(); 
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

    public function apotek_edit($id=0) {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('trx_pendaftaran','pendaftaran_id='.intval($id));
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/aporek/index?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class);
        $st = new Stencil();
        
		
		if($this->input->post("submit"))
		{ 
			$result=$this->mainModel->apotek_validate_form($id);
			
			$data=$result;
			if($data['status']==200)
			{ 
				$result=$this->mainModel->apotek_stored($id);
				
				$data=$result;
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/apotek/index?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		}
		
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		$common['penjamin_arr'] = $this->common_lib->select_result('data_penjamin','is_delete=0'); 
		$common['pemeriksaan_arr'] = $this->common_lib->select_result('trx_pendaftaran 
		join trx_pemeriksaan on pemeriksaan_pendaftaran_id=pendaftaran_id
		join trx_pemeriksaan_obat_apotek on pemeriksaan_obat_pemeriksaan_id=pemeriksaan_id
		','pendaftaran_pasien_name="'.$has_exist['pendaftaran_pasien_name'].'" AND pendaftaran_pasien_birthdate="'.$has_exist['pendaftaran_pasien_birthdate'].'"  AND pendaftaran_pasien_penanggung_jawab_telp="'.$has_exist['pendaftaran_pasien_penanggung_jawab_telp'].'"
		order by pemeriksaan_id asc
		'); 
		$common['membership_arr'] = $this->common_lib->select_result('data_membership','is_delete=0'); 
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

    public function get_datatable_apotek() {
		$result=$this->mainModel->get_data_apotek();
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
			$action='<a href="'.base_url('admin/pasien/apotek/edit/'.$pendaftaran_id).'" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>';
			$entry = array(
					'no' =>  $no,
					'action' => $action,
					'pendaftaran_id'=>$pendaftaran_id,
					'membership'=>ucwords($membership_name),
					'pasien_name'=>$pendaftaran_pasien_name,
					'pasien_address'=>$pendaftaran_pasien_address,
					'pendaftaran_pasien_penanggung_jawab_telp'=>$pendaftaran_pasien_penanggung_jawab_telp,
					'pasien_birthdate'=>intval($pendaftaran_pasien_pernikahan),
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

}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */