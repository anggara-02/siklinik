<?php
/* ==========DON'T REMOVE============
	Create with Love
	Creator 	: Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified 	: Badra | sipatan.jana@students.amikom.ac.id
	Support 	: Alfons Permana
	Megistra Team : megistra.com
	Contact Us 	: support@megistra.com
==========DON'T REMOVE============ */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_admin.php';
class inkaso extends controller_admin {
	protected $st, $access, $class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		$this->class="Inkaso";
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
        $common['supplier_arr'] = $this->common_lib->select_result('data_supplier','is_delete=0'); 
        $common['access'] = $this->access;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	
	public function detail($id=0) {  
		$has_exist = $this->findModel($id)->result();
		if(empty($has_exist)) {
			redirect(base_url($this->module.'/'.__class__.'/data?status='.base64_encode(500).'&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
        $st = new Stencil();
        $st->slice('head_login');
		
        $breadcrumbs_array = array();
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		foreach($has_exist as $value) {
			$common['penerimaan']=$value;
		}
		
        $common['class'] = __class__;
        $common['title'] = ucfirst($this->class);
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs([],$this->module);
        $common['tanggal_faktur'] = $this->format_tanggal($has_exist[0]->tanggal_faktur);
        $common['tanggal_tempo'] = $this->format_tanggal($has_exist[0]->tanggal_tempo);
        $common['total'] = 'Rp. '.$this->angka($has_exist[0]->total);
        $common['sum_jumlah'] = $has_exist[0]->sum_jumlah ? 'Rp. '.$this->angka($has_exist[0]->sum_jumlah) : 'Rp. 0';
        $common['access'] = $this->access;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/form', $common);
    }

    public function get_datatable() {   
		$result = $this->get_data();
		$query = $result['query'];
		$total = $result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
		$json_data = array(
			'start' => $start, 
			'recordsTotal' => ($_POST['length']>0) ? $_POST['length'] : $total,
			'recordsFiltered' => $total, 
			'data' => array()
		);
        $no = 0 + $start;
        foreach ($query->result() as $row) {
            foreach($row AS $variable=>$value) {
                ${$variable}=$value;
            }
			$no++;
			$action=common_lib::hak_akses($this->access,'inkaso','menu')=='1'?'<a href="'.site_url('admin/'.__class__.'/detail/'.$penerimaan_id.'').'" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-calculator"></i></a>':'';
			$entry = array(
				'no' =>  $no,
				'action' => $action,
				'no_faktur' => $no_faktur,
				'tanggal_faktur' => $this->format_tanggal($tanggal_faktur),
				'tanggal_tempo' => $this->format_tanggal($tanggal_tempo),
				'supplier' => $supplier,
				'total_harga' => 'Rp. '.$this->angka($total_harga),
				'bayar' => $sum_jumlah ? $this->angka($sum_jumlah) : 0,
			);
			$json_data['data'][] = $entry;
        }
        echo json_encode($json_data); 
	}

    public function get_datatable_detail() {   
		$result = $this->get_detail();
		$query = $result['query'];
		$total = $result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
		$json_data = array(
			'start' => $start, 
			'recordsTotal' => ($_POST['length']>0) ? $_POST['length'] : $total,
			'recordsFiltered' => $total, 
			'data' => array()
		);
        $no = 0 + $start;
        foreach ($query->result() as $row) {
            foreach($row AS $variable=>$value) {
                ${$variable}=$value;
            }
			$no++;
			$action="<a href='#' onclick='edit_form({$inkaso_id})' style='margin-right:5px' class='btn btn-info btn-icon'><i class='fa fa-edit'></i></a>";
			$action.='<a href="javascript:void(0);" data-url="'.site_url('admin/'.__class__.'/delete/'.$inkaso_id.'').'" style="margin-right:5px" class="btn btn-danger btn-icon btn-delete confirmation"><i class="fas fa-trash"></i></a>';
			$entry = array(
				'no' =>  $no,
				'action' => $action,
				'tanggal' => $this->format_tanggal($tanggal),
				'cara_bayar' => $cara_bayar,
				'jumlah' => 'Rp. '.$this->angka($jumlah),
			);
			$json_data['data'][] = $entry;
        }
        echo json_encode($json_data); 
	}
	
	public function store_form($id) {
		$_POST['id_penerimaan'] = $id;
		$inkaso_id=isset($_POST['inkaso_id'])?$_POST['inkaso_id']:0;
		if(intval($inkaso_id)>0) {
			$this->mainModel->stored($inkaso_id);
		} else {
			$this->mainModel->stored();
		}
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', 'Data berhasil di simpan');
		redirect('admin/inkaso/detail/'.$id);
	}
		
    public function delete($id=0) {   
		$has_exist=$this->common_lib->select_row('data_inkaso','inkaso_id='.intval($id));
		$id_penerimaan=$has_exist['id_penerimaan'];
		if(empty($has_exist)) {
			$this->session->set_flashdata('status', '500');
			$this->session->set_flashdata('gagal', 'Data gagal di hapus');
			redirect('admin/inkaso/detail/'.$id);
		}
		$this->db->delete('data_inkaso', ['inkaso_id' => $id]);
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', 'Data berhasil di hapus');
		redirect('admin/inkaso/detail/'.$id_penerimaan);
	}
	
	public function action_validation() {
		$inkaso_id 		= isset($_POST['inkaso_id']) ? $_POST['inkaso_id'] :'';
		$id_penerimaan 	= isset($_POST['inkaso_id']) ? $_POST['id_penerimaan'] :'';
		$total_harga 	= isset($_POST['inkaso_id']) ? $_POST['total_harga'] :'0';
		$jumlah 		= isset($_POST['inkaso_id']) ? $_POST['jumlah'] :'0';

		if ($inkaso_id) {
			$query = $this->db->query("SELECT SUM(IF(id_penerimaan, jumlah, 0)) AS sum_jumlah FROM data_inkaso WHERE id_penerimaan = '{$id_penerimaan}' AND inkaso_id != '{$inkaso_id}' LIMIT 1")->result()[0];
			$data_inkaso = $query->sum_jumlah ? $query->sum_jumlah : 0;
			$sub_total_bayar = $data_inkaso + $jumlah;
	
			if ($sub_total_bayar > $total_harga) {
				echo json_encode(false);
			} else {
				echo json_encode(true);
			}
		} else {
			$query = $this->db->query("SELECT SUM(IF(id_penerimaan, jumlah, 0)) AS sum_jumlah FROM data_inkaso WHERE id_penerimaan = '{$id_penerimaan}' LIMIT 1")->result()[0];
			$data_inkaso = $query->sum_jumlah ? $query->sum_jumlah : 0;
			$sub_total_bayar = $data_inkaso + $jumlah;
			if ($sub_total_bayar > $total_harga) {
				echo json_encode(false);
			} else {
				echo json_encode(true);
			}
		}
	}

    public function action_data_form() {   
		$result=$this->get_detail();
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
				'tanggal' => $tanggal,
				'inkaso_id' => $inkaso_id,
				'cara_bayar' => $cara_bayar,
				'jumlah' => $this->angka_bulat($jumlah),
			];
			$json_data['data']= $entry;
        }
        echo json_encode($json_data); 
	}
	
	function get_data() {
		$this->db->select("data_penerimaan.*, s.supplier_name AS supplier, i.sum_jumlah AS sum_jumlah");
		$this->db->from("data_penerimaan");
		$this->db->join('data_pemesanan p', 'p.pemesanan_id=data_penerimaan.id_pemesanan', 'left');
		$this->db->join('data_supplier s', 's.supplier_id=p.pemesanan_supplier_id', 'left');
		$this->db->join('(SELECT SUM(IF(id_penerimaan, jumlah, 0)) AS sum_jumlah, data_inkaso.id_penerimaan AS id_penerimaan FROM data_inkaso GROUP BY id_penerimaan) AS i', 'i.id_penerimaan=data_penerimaan.penerimaan_id', 'left');
		$this->db->where("data_penerimaan.is_delete=0 AND jenis_penerimaan='tempo'");
        if(trim($this->input->get('no_faktur'))!='') {
			$no_faktur = array('no_faktur' => $this->input->get('no_faktur'));
			$this->db->like($no_faktur);
		}
        if(trim($this->input->get('supplier_id'))!='') {
			$supplier_id = array('s.supplier_id' => $this->input->get('supplier_id'));
			$this->db->like($supplier_id);
        }
        if(trim($this->input->get('tanggal_awal'))!='' & trim($this->input->get('tanggal_akhir'))!='') {
			$this->db->where("(tanggal_tempo BETWEEN '{$this->input->get('tanggal_awal')}' AND '{$this->input->get('tanggal_akhir')}')");
        }
		$this->db->order_by("penerimaan_id DESC");
		$query = $this->db->get();
        $total = $this->db->count_all_results();

		return array(
			'query'=>$query,
			'total'=>$total,
		);
	}
	
	function get_detail() {
		$this->db->select("data_inkaso.*, IF(cara_bayar='tunai', 'Tunai', 'Transfer BCA') AS cara_bayar");
		$this->db->from("data_inkaso");
		// $this->db->where("id_penerimaan=".$this->input->get('id_penerimaan'));
        if(trim($this->input->get('id_penerimaan'))!='') {
			$this->db->where("(id_penerimaan = '{$this->input->get('id_penerimaan')}')");
        }
        if(trim($this->input->get('inkaso_id'))!='') {
			$this->db->where("(inkaso_id = '{$this->input->get('inkaso_id')}')");
        }
		$this->db->order_by("inkaso_id ASC");
		$query = $this->db->get();
        $total = $this->db->count_all_results();

		return array(
			'query'=>$query,
			'total'=>$total,
		);
	}
	
	function findModel($id) {
		$this->db->select("data_penerimaan.*, s.supplier_name AS supplier, i.sum_jumlah AS sum_jumlah");
		$this->db->from("data_penerimaan");
		$this->db->join('data_pemesanan p', 'p.pemesanan_id=data_penerimaan.id_pemesanan', 'left');
		$this->db->join('data_supplier s', 's.supplier_id=p.pemesanan_supplier_id', 'left');
		$this->db->join('(SELECT SUM(IF(id_penerimaan, jumlah, 0)) AS sum_jumlah, data_inkaso.id_penerimaan AS id_penerimaan FROM data_inkaso GROUP BY id_penerimaan) AS i', 'i.id_penerimaan=data_penerimaan.penerimaan_id', 'left');
		$this->db->where("penerimaan_id=".$id);
		$this->db->limit(1);
		$query = $this->db->get();

		return  $query;
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