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
class kemasan extends controller_admin {
	protected $st,$access,$class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		// $this->access="akses_setting_penjamin";
		$this->class="Kemasan";
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
        $common['role_arr'] = $this->common_lib->select_result('data_kemasan','is_delete=0'); 
		
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
			$action=($kemasan_id==999 ? '<a href="#" style="margin-right:5px" class="btn btn-info btn-icon disabled"><i class="fa fa-edit"></i></a>' : '<a href="#" onclick="edit_form('.$kemasan_id.')" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>');
			$action.=($kemasan_id==999 ? '<a href="#" class="btn btn-danger btn-icon btn-delete disabled"><i class="fa fa-trash"></i></a>' : '<a href="javascript:void(0);" data-url="'.site_url('admin/'.__class__.'/delete/'.$kemasan_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation"><i class="fa fa-trash"></i></a>');
			$entry = array('no'=>$no,'action'=>$action,'kemasan_name'=>$kemasan_name);
			$json_data['data'][] = $entry;
        }

        echo json_encode($json_data); 
	}
		
    public function delete($id=0) {   
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('data_kemasan','kemasan_id='.intval($id));
		if(empty($has_exist)) {
			$this->session->set_flashdata('status', '500');
			$this->session->set_flashdata('gagal', 'Data gagal di hapus');
			redirect('admin/kemasan/data');
		}
		$result=$this->common_lib->delete_semu('data_kemasan',['kemasan_id'=>intval($id)]);
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', $result['message']);
		redirect('admin/kemasan/data');
	}
	
	public function action_validation() {
		if ($_POST['kemasan_id']) {
			$query = $this->db->query("SELECT data_kemasan.* FROM data_kemasan WHERE is_delete=0 AND kemasan_name = '{$_POST['kemasan_name']}' AND kemasan_id = '{$_POST['kemasan_id']}' LIMIT 1")->result();
			if ($query) {
				echo json_encode(true);
			} else {
				$query = $this->db->query("SELECT kemasan_name FROM data_kemasan WHERE is_delete=0 AND kemasan_name = '{$_POST['kemasan_name']}' AND kemasan_id != '{$_POST['kemasan_id']}' LIMIT 1")->result();
				echo $query ? json_encode(false) : json_encode(true);
			}
		} else {
			$query = $this->db->query("SELECT kemasan_name FROM data_kemasan WHERE is_delete=0 AND kemasan_name = '{$_POST['kemasan_name']}' LIMIT 1")->result();
			echo $query ? json_encode(false) : json_encode(true);
		}
	}
	
	public function action_stored() { 
		$id=isset($_POST['kemasan_id'])?$_POST['kemasan_id']:0;
		if(intval($id)>0) {
			$this->mainModel->stored($id);
		} else {
			$this->mainModel->stored();			
		}
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', 'Data berhasil di simpan');
		redirect('admin/kemasan/data');
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
				'kemasan_id'=>$kemasan_id,
				'kemasan_name'=>$kemasan_name,
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