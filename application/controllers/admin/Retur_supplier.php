<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_admin.php';
class retur_supplier extends controller_admin
{
	protected $st, $access, $class;

	public function __construct()
	{
		parent::__construct();
		$_model = __class__ . '_model';
		$this->load->model($this->module . '/' . __class__ . '/' . $_model);
		$this->mainModel = new $_model();
		$this->class = "Retur Supplier";
	}

	public function index()
	{
		redirect(base_url('admin/' . __class__ . '/data'));
	}

	public function after_save() {
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', 'Data berhasil di simpan');
		redirect('admin/Retur_supplier/data');
	}

	public function add()
	{
		$date = date("Y-m-d H:i:s");
		common_lib::hak_akses($this->access, __function__, 'controller');

		$this->session->set_userdata("last_url", __class__ . '/' . __function__);
		$common = common_lib::getState($this);
		$st = new Stencil();
		$st->slice('head_login');

		$common['class'] = __class__;
		$common['title'] = ucfirst($this->class);
		$common['breadcrumbs'] = $this->common_lib->create_breadcrumbs([], $this->module);
		$common['penerimaan_arr'] = $this->common_lib->select_result('data_penerimaan', "is_delete='0' AND retur_supplier='0'");
		$common['penerimaan_id'] = 0;
		$common['access'] = $this->access;

		$st->paint($this->template . '/' . $this->module, __class__ . '/form', $common);
	}

	public function data()
	{

		$this->session->set_userdata("last_url", __class__ . '/' . __function__);
		$common = common_lib::getState($this);
		$common['title'] = ucfirst($this->class);
		$st = new Stencil();

		$st->slice('head_login');
		$common['class'] = __class__;
		$common['js_files'] = '';
		$common['css_files'] = '';
		$common['status'] = $_GET ? base64_decode($_GET['status']) : '';
		$common['supplier_arr'] = $this->common_lib->select_result('data_supplier', "is_delete = '0'");
		$common['access'] = $this->access;

		$st->paint($this->template . '/' . $this->module, __class__ . '/' . __function__, $common);
	}

	public function get_detail_penerimaan(){
		$id = $this->input->post('id');

		$result = $this->mainModel->get_penerimaan($id);
		$data = [];
		$data['data'] = $result;

		echo json_encode($data);
	}

	public function trx_save() {
		$data = array(
			'id_penerimaan' => $this->input->post('id_penerimaan'),
			'tgl_retur' => $this->input->post('tgl_retur'),
		);
		$result = $this->mainModel->trx_save($data);
        echo json_encode($result);
    }
	
	public function get_datatable()
	{
		$result = $this->mainModel->get_data();
		$query = $result['query'];
		$total = $result['total'];

		header("Content-type: application/json");
		$page = isset($_POST['page']) ? $_POST['page'] : 1;

		$start = isset($_POST['start']) ? $_POST['start'] : 0;
		$json_data = array('start' => $start, 'recordsTotal' => ($_POST['length'] > 0) ? $_POST['length'] : $total, 'recordsFiltered' => $total, 'data' => array());
		$prev_trx = '';
		$no = 0 + $start;
		foreach ($query->result() as $row) {
			foreach ($row as $variable => $value) {
				${$variable} = $value;
			}
			$no++;
			$action = common_lib::hak_akses($this->access, 'edit', 'menu') == '1' ? '<a href="'.site_url('admin/'.__class__.'/edit/'.$penerimaan_id.'').'" style="margin-right:5px" class="btn btn-info btn-icon" data-index="'.$penerimaan_id.'"><i class="fa fa-eye"></i></a>' : '';
			// $action .= common_lib::hak_akses($this->access, 'delete', 'menu') == '1' ? '<a href="javascript:void(0)" data-url="'.site_url('admin/'.__class__.'/delete/'.$penerimaan_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation" data-index="'.$penerimaan_id.'"><i class="fa fa-trash"></i></a>' : '';
			// $action .= common_lib::hak_akses($this->access, 'print', 'menu') == '1' ? '<a onclick="return validasi_delete();" href="#" class="btn btn-warning btn-icon"><i class="fa fa-print"></i></a>' : '';

			$entry = array(
				'no' =>  $no,
				'action' => $action,
				'penerimaan_id' => $penerimaan_id,
				'no_faktur' => $no_faktur,
				'tanggal_faktur' => $tanggal_faktur,
				'tanggal_tempo' => $tanggal_tempo,
				'supplier' => $supplier,
				'total' => $this->angka($total),
				'item' => $this->get_item($penerimaan_id),
				'kemasan' => $this->get_kemasan($penerimaan_id),
				'jumlah' => $this->get_jumlah($penerimaan_id),
			);
			$json_data['data'][] = $entry;
		}
		echo json_encode($json_data);
	}

	public function get_item($penerimaan_id) {
		$alkes = $this->mainModel->get_alkes($penerimaan_id);
		$obat = $this->mainModel->get_obat($penerimaan_id);
		$alkes_list = '';
		$obat_list = '';
		if ($alkes) {
			foreach ($alkes->result_array() as $key => $data) {
				if ($key == 0) {
					$alkes_list = $data['alkes_name'] . '<br>';
				} else {
					$alkes_list .= $data['alkes_name'] . '<br>';
				}
			}
		}
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['obat_name'] . '<br>';
				} else {
					$obat_list .= $data['obat_name'] . '<br>';
				}
			}
		}
		return $alkes_list . $obat_list;
	}

	public function get_kemasan($penerimaan_id)
	{
		$alkes = $this->mainModel->get_alkes($penerimaan_id);
		$obat = $this->mainModel->get_obat($penerimaan_id);
		$alkes_list = '';
		$obat_list = '';
		if ($alkes) {
			foreach ($alkes->result_array() as $key => $data) {
				if ($key == 0) {
					$alkes_list = $data['alkes_kemasan'] . '<br>';
				} else {
					$alkes_list .= $data['alkes_kemasan'] . '<br>';
				}
			}
		}
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['kemasan_name'] . '<br>';
				} else {
					$obat_list .= $data['kemasan_name'] . '<br>';
				}
			}
		}
		return $alkes_list . $obat_list;
	}

	public function get_jumlah($penerimaan_id)
	{
		$alkes = $this->mainModel->get_alkes($penerimaan_id);
		$obat = $this->mainModel->get_obat($penerimaan_id);
		$alkes_list = '';
		$obat_list = '';
		if ($alkes) {
			foreach ($alkes->result_array() as $key => $data) {
				if ($key == 0) {
					$alkes_list = $data['qty'] . '<br>';
				} else {
					$alkes_list .= $data['qty'] . '<br>';
				}
			}
		}
		if ($obat) {
			foreach ($obat->result_array() as $key => $data) {
				if ($key == 0) {
					$obat_list = $data['qty'] . '<br>';
				} else {
					$obat_list .= $data['qty'] . '<br>';
				}
			}
		}
		return $alkes_list . $obat_list;
	}

	public function edit($id = 0)
	{
		$has_exist = $this->common_lib->select_row('data_penerimaan', 'penerimaan_id=' . intval($id));
		if (empty($has_exist)) {
			$this->session->set_flashdata('status', '500');
			$this->session->set_flashdata('gagal', 'Maaf data tidak di temukan');
			redirect('admin/penerimaan/data');
		}
		$this->session->set_userdata("last_url", __class__ . '/' . __function__);
		$common = common_lib::getState($this);
		$st = new Stencil();
		$st->slice('head_login');

		$breadcrumbs_array = array();
		$common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array, $this->module);
		foreach ($has_exist as $index => $value) {
			$common[$index] = $value;
		}

		$common['class'] = __class__;
		$common['title'] = ucfirst($this->class);
		$common['penerimaan_id'] = $id;
		$common['breadcrumbs'] = $this->common_lib->create_breadcrumbs([], $this->module);
		$common['penerimaan_arr'] =$this->common_lib->select_result('data_penerimaan', "is_delete=0 AND penerimaan_id ='$id'");
		$common['penerimaan_id'] = $id;
		$common['nama_file'] = $has_exist['image_faktur'];
		$common['access'] = $this->access;

		$st->paint($this->template . '/' . $this->module, __class__ . '/form', $common);
	}

	public function action_data_form()
	{
		$penerimaan_id = $this->input->get('penerimaan_id');

		$result = $this->mainModel->get_data($penerimaan_id);
		$query = $result['query'];
		
		$json_data = array(
			'status' => 500,
			'message' => 'Data tidak ditemukan',
			'data' => array(),
		);
		
		foreach ($query->result() as $row) {
			foreach ($row as $key => $value) {
				${$key} = $value;
			}
			$json_data = ['status' => 200, 'message' => 'Data ditemukan', 'data' => []];

			$entry = array(
				'penerimaan_id' => $penerimaan_id,
				'supplier' => $supplier,
				'no_faktur' => $no_faktur,
				'tanggal_faktur' => $tanggal_faktur,
				'jenis_penerimaan' => $jenis_penerimaan,
				'tanggal_tempo' => $tanggal_tempo,
				'image_faktur' => $image_faktur,
				'penyimpanan' => $penyimpanan,
				'obat' => $this->mainModel->get_obat($penerimaan_id)->result_array(), 
				'alkes' => $this->mainModel->get_alkes($penerimaan_id)->result_array(),
				'total_harga' => $total_harga,
				'diskon_perfaktur_rp' => $diskon_perfaktur_rp,
				'diskon_perfaktur_persen' => $diskon_perfaktur_persen,
				'total' => $total,
				'retur_supplier' => $retur_supplier,
				'tanggal_retur' => $tanggal_retur,
			);
			$json_data['data'][] = $entry;
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