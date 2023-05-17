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
class setting extends controller_admin {
	protected $st,$access,$class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel = new $_model();
		$this->class = "Setting";
    }

    public function index() { 
		redirect(base_url('admin/'.__class__.'/data'));
	}
	
    public function data() {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
        $this->session->set_userdata("last_url", __class__.'/'.__function__);
		$common = common_lib::getState($this);
        $st = new Stencil();
        $st->slice('head_login');
		$has_exist = $this->common_lib->select_result('setting');
		$common['setting_id'] = $has_exist ? $has_exist[0]['setting_id'] : '0';
		$common['logo'] = $has_exist ? $has_exist[0]['logo'] : '0';
        $common['title'] = ucfirst($this->class); 
        $common['class'] = __class__;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

	public function do_upload() {
		if ($_FILES['logo']['size']>0) {
			if ($this->input->post('setting_id')==0) {
				$this->common_lib->do_upload("logo", "assets/uploads/logo/", "jpg|png|jpeg");
				$upload_data = $this->upload->data();
				$logo = $upload_data['file_name'];
			} else {
				$has_exist = $this->common_lib->select_row('setting', 'setting_id=' . intval($this->input->post('setting_id')));
				$path = './assets/uploads/logo/';
				unlink($path.$has_exist['logo']);
				
				$this->common_lib->do_upload("logo", "assets/uploads/logo/", "jpg|png|jpeg");
				$upload_data = $this->upload->data();
				$logo = $upload_data['file_name'];
			}
		} else {
			$has_exist = $this->common_lib->select_row('setting', 'setting_id=' . intval($this->input->post('setting_id')));
			$logo = $has_exist['logo'];
		}
		
		$data = array(
			'setting_id' => $this->input->post('setting_id'),
			'nama_klinik'=> $this->input->post('nama_klinik'),
			'no_telpon' => $this->input->post('no_telpon'),
			'email' => $this->input->post('email'),
			'alamat' => $this->input->post('alamat'),
			'logo' => $logo,
			'apoteker' => $this->input->post('apoteker'),
			'sipa' => $this->input->post('sipa'),
			'sia' => $this->input->post('sia'),
			'min_promo' => $this->input->post('min_promo'),
			'konversi_poin' => $this->input->post('konversi_poin'),
		);

		$result = $this->mainModel->stored($data);
        echo json_encode($result);
	}

    public function after_save()
    {
        $this->session->set_flashdata('status', '200');
        $this->session->set_flashdata('sukses', 'Data berhasil di simpan');
        redirect('admin/setting/data');
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
				'setting_id' => $setting_id,
				'nama_klinik'=> $nama_klinik,
				'no_telpon' => $no_telpon,
				'email' => $email,
				'alamat' => $alamat,
				'logo' => $logo,
				'apoteker' => $apoteker,
				'sipa' => $sipa,
				'sia' => $sia,
				'min_promo' => $min_promo,
				'konversi_poin' => $konversi_poin,
			);
			$json_data['data']= $entry;
        }
        echo json_encode($json_data); 
	}

	public function download($nama_file) {
		force_download('assets/uploads/logo/'.$nama_file,NULL);
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