<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_admin.php';
class obat extends controller_admin {
	protected $st,$access,$class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		$this->class="Obat";
    }

    public function index() {
		redirect(base_url('admin/'.__class__.'/data'));
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
			$action=common_lib::hak_akses($this->access,'edit','menu')=='1'?'<a href="'.site_url('admin/'.__class__.'/edit/'.$obat_id.'').'" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>':'';
			$action.=common_lib::hak_akses($this->access,'delete','menu')=='1'?'<a href="javascript:void(0);" data-url="'.site_url('admin/'.__class__.'/delete/'.$obat_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation"><i class="fa fa-trash"></i></a>':'';
			
			$entry = array(
				'no' => $no,
				'action' => $action,
				'obat_id' => $obat_id,
				'obat_name' => $obat_name,
				'obat_barcode' => $obat_barcode,
				'kemasan' => $kemasan1.'<br>'.$kemasan2.'<br>'.$kemasan3,
				'harga' => $this->angka($obat_price_non_resep*$obat_kemasan_kecil_konversi).'<br>'.$this->angka($obat_price_non_resep*$obat_kemasan_sedang_konversi).'<br>'.$this->angka($obat_price_non_resep*$obat_kemasan_besar_konversi),
				'harga_resep' => $this->angka($obat_price_resep*$obat_kemasan_kecil_konversi).'<br>'.$this->angka($obat_price_resep*$obat_kemasan_sedang_konversi).'<br>'.$this->angka($obat_price_resep*$obat_kemasan_besar_konversi),
			);
			$json_data['data'][] = $entry;
        }
        echo json_encode($json_data); 
	}
		
    public function delete($id=0) {   
		$has_exist=$this->common_lib->select_row('data_obat','obat_id='.intval($id));
		if(empty($has_exist)) {
			$this->session->set_flashdata('status', '500');
			$this->session->set_flashdata('gagal', 'Data gagal di hapus');
			redirect('admin/obat/data');
		}
		$result=$this->common_lib->delete_semu('data_obat',array('obat_id'=>intval($id)));
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', $result['message']);
		redirect('admin/obat/data');
	}
	
	public function action_validation() {
		if ($_POST['obat_id']) {
			$query = $this->db->query("SELECT data_obat.* FROM data_obat WHERE is_delete=0 AND obat_barcode = '{$_POST['obat_barcode']}' AND obat_id = '{$_POST['obat_id']}' LIMIT 1")->result();
			if ($query) {
				echo json_encode(true);
			} else {
				$query = $this->db->query("SELECT obat_barcode FROM data_obat WHERE is_delete=0 AND obat_barcode = '{$_POST['obat_barcode']}' AND obat_id != '{$_POST['obat_id']}' LIMIT 1")->result();
				echo $query ? json_encode(false) : json_encode(true);
			}
		} else {
			$query = $this->db->query("SELECT obat_barcode FROM data_obat WHERE is_delete=0 AND obat_barcode = '{$_POST['obat_barcode']}' LIMIT 1")->result();
			echo $query ? json_encode(false) : json_encode(true);
		}
	}
	
	public function get_kemasan() { 
		$id = $_POST['id_kemasan'];
		$result = $this->common_lib->select_result('data_kemasan', 'kemasan_id='.$id);
		echo json_encode($result[0]);
	}
	
    public function add() {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
		
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);
        $st = new Stencil();
        $st->slice('head_login');
		 
        $common['class'] = __class__;
        $common['title'] = ucfirst($this->class);
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs([],$this->module);
        $common['dosis_arr'] = $this->common_lib->select_result('data_dosis','is_delete=0'); 
        $common['kemasan_arr'] = $this->common_lib->select_result('data_kemasan','is_delete=0'); 
        $common['obat_id'] = '0'; 
        $common['access'] = $this->access;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/form', $common);
    }
	
	public function edit($id=0) {  
		$has_exist=$this->common_lib->select_row('data_obat','obat_id='.intval($id));
		if(empty($has_exist)) {
			$this->session->set_flashdata('status', '500');
			$this->session->set_flashdata('gagal', 'Data tidak ditemukan');
			redirect('admin/obat/data');
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
        $st = new Stencil();
        $st->slice('head_login');
		
        $breadcrumbs_array = array();
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		foreach($has_exist as $index=>$value) {
			$common[$index]=$value;
		}
		
        $common['class'] = __class__;
        $common['title'] = ucfirst($this->class);
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs([],$this->module);
        $common['dosis_arr'] = $this->common_lib->select_result('data_dosis','is_delete=0'); 
        $common['kemasan_arr'] = $this->common_lib->select_result('data_kemasan','is_delete=0'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
        $common['access'] = $this->access;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/form', $common);
    }
	
	public function action_stored() { 
		$id=isset($_POST['obat_id'])?$_POST['obat_id']:0;
		if(intval($id)>0) {
			$this->mainModel->stored($id);
		} else {
			$this->mainModel->stored();			
		}
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', 'Data berhasil di simpan');
		redirect('admin/obat/data');
	}
		
    public function data() {  
		
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class);
        $st = new Stencil();
        
        $st->slice('head_login');  
        $common['class'] = __class__;
        $common['status'] = $_GET ? base64_decode($_GET['status']) : '';
        $common['message'] = $_GET ? base64_decode($_GET['flag']) : '';
        $common['access'] = $this->access;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
    public function action_data_form() {   
		$result=$this->mainModel->get_data();
		$query=$result['query'];
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
			$json_data=['status'=>200,'message'=>'Data ditemukan','data'=>[]];
			
			$entry = [
				'obat_id' 						=> $obat_id,
				'obat_name' 					=> $obat_name,
				'obat_type' 					=> $obat_type,
				'obat_lokasi' 					=> $obat_lokasi,
				'obat_rak' 						=> $obat_rak,
				'obat_price' 					=> $this->angka_bulat($obat_price),
				'obat_barcode' 					=> $obat_barcode,
				'obat_dosis_id' 				=> $obat_dosis_id,
				'obat_price_resep' 				=> $this->angka_bulat($obat_price_resep),
				'obat_dosis_value' 				=> $obat_dosis_value,
				'obat_margin_resep' 			=> $this->angka_bulat($obat_margin_resep),
				'obat_price_non_resep' 			=> $this->angka_bulat($obat_price_non_resep),
				'obat_margin_non_resep' 		=> $this->angka_bulat($obat_margin_non_resep),
				'obat_kemasan_kecil_id' 		=> $obat_kemasan_kecil_id,
				'obat_kemasan_besar_id' 		=> $obat_kemasan_besar_id,
				'obat_kemasan_sedang_id' 		=> $obat_kemasan_sedang_id,
				'obat_kemasan_kecil_konversi' 	=> $obat_kemasan_kecil_konversi,
				'obat_kemasan_besar_konversi' 	=> $obat_kemasan_besar_konversi,
				'obat_kemasan_sedang_konversi' 	=> $obat_kemasan_sedang_konversi,
			];
			$json_data['data']= $entry;
        }
		
        echo json_encode($json_data); 
	}
}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */