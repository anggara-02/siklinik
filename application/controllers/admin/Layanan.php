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
class layanan extends controller_admin {
	protected $st,$access,$class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		$this->class="Layanan Medis";
    }

    public function index() { 
		redirect(base_url('admin/'.__class__.'/data'));
	}
	
    public function data() {  
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class);
        $st = new Stencil();
        
        $st->slice('head_login');  
        $common['class'] = __class__;
        $common['role_arr'] = $this->common_lib->select_result('data_poli','is_delete=0'); 
		
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
			$action='<a href="#" onclick="edit_form('.$layanan_id.')" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>';
			$action.='<a href="javascript:void(0);" data-url="'.site_url('admin/'.__class__.'/delete/'.$layanan_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation"><i class="fa fa-trash"></i></a>';
			
			$entry = array(
					'no' =>  $no,
					'action' => $action,
					'poli_name'=>$poli_name,
					'layanan_id'=>$layanan_id,
					'layanan_bph'=>$this->angka($layanan_bph),
					'layanan_name'=>$layanan_name,
					'layanan_tarif'=>$this->angka($layanan_tarif),
					'layanan_total'=>$this->angka($layanan_total),
			);
			$json_data['data'][] = $entry;
        }

        echo json_encode($json_data); 
	}
		
    public function delete($id=0) {   
		$has_exist=$this->common_lib->select_row('data_layanan','layanan_id='.intval($id));
		if(empty($has_exist)) {
			$this->session->set_flashdata('status', '500');
			$this->session->set_flashdata('gagal', 'Data gagal di hapus');
			redirect('admin/layanan/data');
		}
		$result=$this->common_lib->delete_semu('data_layanan',['layanan_id'=>intval($id)]);
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', $result['message']);
		redirect('admin/layanan/data');
	}
	
	public function action_validation() {
		if ($_POST['layanan_id']) {
			$query = $this->db->query("SELECT data_layanan.* FROM data_layanan WHERE is_delete=0 AND layanan_name = '{$_POST['layanan_name']}' AND layanan_id = '{$_POST['layanan_id']}' LIMIT 1")->result();
			if ($query) {
				echo json_encode(true);
			} else {
				$query = $this->db->query("SELECT layanan_name FROM data_layanan WHERE is_delete=0 AND layanan_name = '{$_POST['layanan_name']}' AND layanan_id != '{$_POST['layanan_id']}' LIMIT 1")->result();
				echo $query ? json_encode(false) : json_encode(true);
			}
		} else {
			$query = $this->db->query("SELECT layanan_name FROM data_layanan WHERE is_delete=0 AND layanan_name = '{$_POST['layanan_name']}' LIMIT 1")->result();
			echo $query ? json_encode(false) : json_encode(true);
		}
	}
	
	public function action_stored() { 
		$id=isset($_POST['layanan_id'])?$_POST['layanan_id']:0;
		if(intval($id)>0) {
			$this->mainModel->stored($id);
		} else {
			$this->mainModel->stored();			
		}
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', 'Data berhasil di simpan');
		redirect('admin/layanan/data');
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
				'layanan_id'=>$layanan_id,
				'layanan_bph'=>$this->angka_bulat($layanan_bph),
				'layanan_name'=>$layanan_name,
				'layanan_tarif'=>$this->angka_bulat($layanan_tarif),
				'layanan_total'=>$this->angka_bulat($layanan_total),
				'layanan_poli_id'=>$layanan_poli_id,
				'layanan_poli_name'=>$layanan_poli_name,
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