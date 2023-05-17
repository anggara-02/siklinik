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
class penerimaan extends controller_admin
{
	protected $st, $access, $class;

	public function __construct()
	{
		parent::__construct();
		$_model = __class__ . '_model';
		$this->load->model($this->module . '/' . __class__ . '/' . $_model);
		$this->mainModel = new $_model();
		$this->class = "Penerimaan";
	}

	public function index()
	{
		redirect(base_url('admin/' . __class__ . '/data'));
	}

	public function do_upload()
	{
		if ($_FILES['image_faktur']['size'] > 0) {
			if ($this->input->post('penerimaan_id') == 0) {
				$this->common_lib->do_upload('image_faktur', "assets/uploads/image_penerimaan/", "jpg|png|jpeg|pdf|doc");
				$upload_data = $this->upload->data();
				$image_faktur = $upload_data['file_name'];
			} else {
				$has_exist = $this->common_lib->select_row('data_penerimaan', 'penerimaan_id=' . intval($this->input->post('penerimaan_id')));
				$path = './assets/uploads/image_penerimaan/';
				unlink($path . $has_exist['image_faktur']);

				$this->common_lib->do_upload('image_faktur', "assets/uploads/image_penerimaan/", "jpg|png|jpeg|pdf|doc");
				$upload_data = $this->upload->data();
				$image_faktur = $upload_data['file_name'];
			}
		} else {
			$has_exist = $this->common_lib->select_row('data_penerimaan', 'penerimaan_id=' . intval($this->input->post('penerimaan_id')));
			$image_faktur = $has_exist['image_faktur'];
		}

		$data = array(
			'penerimaan_id' => $this->input->post('penerimaan_id'),
			'id_pemesanan' => $this->input->post('id_pemesanan'),
			'no_faktur' => $this->input->post('no_faktur'),
			'tanggal_faktur' => $this->input->post('tanggal_faktur'),
			'jenis_penerimaan' => $this->input->post('jenis_penerimaan'),
			'tanggal_tempo' => $this->input->post('tanggal_tempo'),
			'image_faktur' => $image_faktur,
			'penyimpanan' => $this->input->post('penyimpanan'),
			'total_harga' => $this->input->post('total_harga'),
			'diskon_perfaktur_rp' => $this->input->post('diskon_perfaktur_rp'),
			'diskon_perfaktur_persen' => $this->input->post('diskon_perfaktur_persen'),
			'total' => $this->input->post('total'),
		);
		$result = $this->mainModel->stored($data);
		echo json_encode($result);
	}

	public function trx_save()
	{
		$data = array(
			'penyimpanan' => $this->input->post('penyimpanan'),
			'penerimaan_id' => $this->input->post('penerimaan_id'),
			'obat' => $this->input->post('obat'),
			'alkes' => $this->input->post('alkes'),
		);
		$result = $this->mainModel->trx_save($data);
		echo json_encode($result);
	}

	public function after_save()
	{
		$this->session->set_flashdata('status', '200');
		$this->session->set_flashdata('sukses', 'Data berhasil di simpan');
		redirect('admin/penerimaan/data');
	}

	public function download($nama_file)
	{
		force_download('assets/uploads/image_penerimaan/' . $nama_file, NULL);
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
			$action = common_lib::hak_akses($this->access, 'edit', 'menu') == '1' ? '<a href="' . site_url('admin/' . __class__ . '/edit/' . $penerimaan_id . '') . '" style="margin-right:5px" class="btn btn-info btn-icon" data-index="' . $penerimaan_id . '"><i class="fa fa-edit"></i></a>' : '';
			// $action .= common_lib::hak_akses($this->access, 'delete', 'menu') == '1' ? '<a href="javascript:void(0)" data-url="'.site_url('admin/'.__class__.'/delete/'.$penerimaan_id.'').'" class="btn btn-danger btn-icon btn-delete confirmation" data-index="'.$penerimaan_id.'"><i class="fa fa-trash"></i></a>' : '';
			// $action .= common_lib::hak_akses($this->access, 'print', 'menu') == '1' ? '<a onclick="return validasi_delete();" href="#" class="btn btn-warning btn-icon"><i class="fa fa-print"></i></a>' : '';

			$entry = array(
				'no' 				=> $no,
				'action' 			=> $action,
				'penerimaan_id'		=> $penerimaan_id,
				'no_faktur' 		=> $no_faktur,
				'tanggal_faktur' 	=> date('d-m-Y', strtotime($tanggal_faktur)),
				'tanggal_tempo' 	=> date('d-m-Y', strtotime($tanggal_tempo)),
				'supplier' 			=> $supplier,
				'total' 			=> $this->angka($total),
				'item' 				=> $this->get_item($penerimaan_id),
				'kemasan' 			=> $this->get_kemasan($penerimaan_id),
				'jumlah' 			=> $this->get_jumlah($penerimaan_id),
				'tanggal_input' 	=> date('d F Y H:i:s', strtotime($tanggal_input)),
			);
			$json_data['data'][] = $entry;
		}
		echo json_encode($json_data);
	}

	public function delete($id = 0)
	{
		$has_exist = $this->common_lib->select_row('data_penerimaan', 'penerimaan_id=' . intval($id));
		if (empty($has_exist)) {
			redirect(base_url($this->module . '/' . __class__ . '/data?status=500&flag=' . base64_encode('Data tidak ditemukan.') . ''));
		}
 
		$result = $this->common_lib->delete_semu('data_penerimaan', array('penerimaan_id' => intval($id)));
		redirect(base_url($this->module . '/' . __class__ . '/data?status=' . $result['status'] . '&flag=' . base64_encode($result['message']) . ''));
	}

	public function action_validation_action_no_faktur()
	{
		if ($_POST['id_penerimaan'] != 0) {
			$query = $this->db->query("SELECT penerimaan_id FROM data_penerimaan WHERE is_delete=0 AND penerimaan_id = '{$_POST['id_penerimaan']}' AND id_pemesanan = '{$_POST['id_pemesanan']}' AND no_faktur = '{$_POST['no_faktur']}' LIMIT 1")->result();
			if ($query) {
				echo json_encode(true);
			} else {
				$query = $this->db->query("SELECT penerimaan_id FROM data_penerimaan WHERE is_delete=0 AND penerimaan_id != '{$_POST['id_penerimaan']}' AND id_pemesanan = '{$_POST['id_pemesanan']}' AND no_faktur = '{$_POST['no_faktur']}' LIMIT 1")->result();
				echo $query ? json_encode(false) : json_encode(true);
			}
		} else {
			$query = $this->db->query("SELECT penerimaan_id FROM data_penerimaan WHERE is_delete=0 AND no_faktur = '{$_POST['no_faktur']}' AND id_pemesanan = '{$_POST['id_pemesanan']}' LIMIT 1")->result();
			echo $query ? json_encode(false) : json_encode(true);
		}
	}

	public function get_item($penerimaan_id)
	{
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
		$common['pemesanan_arr'] = $this->common_lib->select_result('data_pemesanan', "is_delete='0' AND is_penerimaan = '0'");
		$common['penerimaan_id'] = 0;
		$common['nama_file'] = 0;
		$common['access'] = $this->access;

		$st->paint($this->template . '/' . $this->module, __class__ . '/form', $common);
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
		$common['pemesanan_arr'] = $this->common_lib->select_result('data_pemesanan', "is_delete='0'");
		$common['nama_file'] = $has_exist['image_faktur'];
		$common['access'] = $this->access;

		$st->paint($this->template . '/' . $this->module, __class__ . '/form', $common);
	}

	public function store_form()
	{
		$id = isset($_POST['penerimaan_id']) ? $_POST['penerimaan_id'] : 0;
		if (intval($id) > 0) {
			$result = $this->mainModel->stored($id);
		} else {
			$result = $this->mainModel->stored();
		}

		if ($result['status'] == 200) {
			$result['url'] = $this->module . '/' . __class__ . '/data?status=' . $result['status'] . '&flag=' . base64_encode($result['message']);
		}
		echo json_encode($result);
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
		$common['supplier_arr'] = $this->common_lib->select_result('data_supplier', 'is_delete=0');
		$common['access'] = $this->access;

		$st->paint($this->template . '/' . $this->module, __class__ . '/' . __function__, $common);
	}

	public function action_data_form()
	{
		$id_penerimaan = $this->input->get('id_penerimaan');

		$result = $this->mainModel->get_data($id_penerimaan);

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
				'pemesanan_id' => $pemesanan_id,
				'no_sp' => $pemesanan_no_sp,
				'pemesanan_tanggal' => $pemesanan_tanggal,
				'supplier' => $supplier,
				'no_faktur' => $no_faktur,
				'tanggal_faktur' => $tanggal_faktur,
				'jenis_penerimaan' => $jenis_penerimaan,
				'tanggal_tempo' => $tanggal_tempo,
				'image_faktur' => $image_faktur,
				'penyimpanan' => $penyimpanan,
				'obat' => $this->mainModel->get_obat($id_penerimaan)->result_array(),
				'alkes' => $this->mainModel->get_alkes($id_penerimaan)->result_array(),
				'total_harga' => $total_harga,
				'diskon_perfaktur_rp' => $diskon_perfaktur_rp,
				'diskon_perfaktur_persen' => $diskon_perfaktur_persen,
				'total' => $total,
			);
			$json_data['data'][] = $entry;
		}
		echo json_encode($json_data);
	}

	public function get_detail_pemesanan()
	{
		$id = $this->input->post('id');

		$result = $this->mainModel->get_detail_pemesanan($id);
		$parrentData = [];

		foreach ($result['detailData'] as $val) {
			$id = $val->detail_pemesanan_pemesanan_id;
			if (!isset($data[$id])) {
				$data[$id] = array();
			}

			//If Obat
			if ($val->is_obat == 1) {
				$data[$id]['obat'][] = array(
					'id'           => $id,
					'barcode'      => $val->detail_pemesanan_barcode,
					'nama_barang'  => $val->detail_pemesanan_nama_barang,
					'kemasan'      => $val->detail_pemesanan_kemasan,
					'qty'          => $val->detail_pemesanan_qty,
					'is_obat'      => $val->is_obat,
				);
			}

			//If Alkes
			if ($val->is_obat == 0) {
				$data[$id]['alkes'][] = array(
					'id'           => $id,
					'barcode'      => $val->detail_pemesanan_barcode,
					'nama_barang'  => $val->detail_pemesanan_nama_barang,
					'kemasan'      => $val->detail_pemesanan_kemasan,
					'qty'          => $val->detail_pemesanan_qty,
					'is_obat'      => $val->is_obat,
				);
			}
		};

		foreach ($result['parrentData'] as $value) {
			if (isset($data[$value->pemesanan_id])) {
				$detail = $data[$value->pemesanan_id];
			} else {
				$detail = '';
			}
			$parrentData['data'][] = array(
				'id'        => $value->pemesanan_id,
				'no_sp'     => $value->pemesanan_no_sp,
				'jenis_sp'  => $value->pemesanan_jenis_sp,
				'tanggal'   => $value->pemesanan_tanggal,
				'supplier'  => $value->supplier_name,
				'detail'    => $detail
			);
		};
		echo json_encode($parrentData);
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