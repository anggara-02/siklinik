<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

require_once APPPATH . '/extend/controller_model.php';
class Penerimaan_model extends controller_model
{
	protected $role_arr, $keyAdmin;
	public function __construct() {
		parent::__construct();
		$this->CI = &get_instance();
		$this->keyAdmin = common_lib::keySession('admin');
	}

    public function alkes($id_penerimaan) {
        $alkes = $this->CI->db->query(" SELECT data_alkes.alkes_barcode AS barcode, data_alkes.alkes_kemasan AS kemasan, data_penerimaan_alkes.*
										FROM data_penerimaan_alkes 
										LEFT JOIN data_alkes ON data_alkes.alkes_id=data_penerimaan_alkes.id_alkes 
										WHERE id_penerimaan = '{$id_penerimaan}'
										GROUP BY penerimaan_alkes_id
									")->result();
        return $alkes;
    }

    public function obat($id_penerimaan) {
        $obat = $this->CI->db->query("	SELECT data_obat.obat_barcode AS barcode, data_obat.obat_kemasan_kecil_id AS kemasan, 
											IF(data_obat.obat_kemasan_kecil_id=data_penerimaan_obat.id_kemasan, data_penerimaan_obat.qty, IF(data_obat.obat_kemasan_sedang_id=data_penerimaan_obat.id_kemasan, (data_penerimaan_obat.qty*data_obat.obat_kemasan_sedang_konversi), (data_penerimaan_obat.qty*data_obat.obat_kemasan_besar_konversi))) AS qty_real, data_penerimaan_obat.*
									  	FROM data_penerimaan_obat 
									  	LEFT JOIN data_obat ON data_obat.obat_id=data_penerimaan_obat.id_obat 
									  	WHERE id_penerimaan = '{$id_penerimaan}'
										GROUP BY penerimaan_obat_id
									")->result();
        return $obat;
    }

    public function get_stok($id_barang, $is_obat, $id_kemasan, $expired_date, $batch, $penyimpanan) {
        $params = [];
        $params['table'] 	= 'data_stok';
        $params['select'] 	= "data_stok.*";
        $params['where'] 	= "id_barang='{$id_barang}' AND is_obat='{$is_obat}' AND id_kemasan='{$id_kemasan}' AND batch='{$batch}' AND penyimpanan='{$penyimpanan}'";
		
		if ($expired_date != NULL) {
            $params['where'] .= " AND expired_date = '{$expired_date}' ";
        }

		$query = $this->CI->common_lib->get_query($params)->result();
        return $query;
    }

    public function balance($id_penerimaan, $penyimpanan) {
        $alkes = $this->alkes($id_penerimaan);
        $obat = $this->obat($id_penerimaan);

        foreach ($alkes as $key => $value) {
            $data = $this->get_stok($value->id_alkes, 0, 999, NULL, $value->batch, $penyimpanan);
			if (count($data) != 0) {
                $input_so = array();
                $input_so['qty'] = ($data[0]->qty + $value->qty);
                $this->CI->db->where('id', $data[0]->id);
                $this->CI->db->update('data_stok', $input_so);
				$stok_id = $data[0]->id;
            } else {
                $input_stok = array();
                $input_stok['id_barang'] 	= $value->id_alkes;
                $input_stok['barcode'] 		= $value->barcode;
                $input_stok['is_obat'] 		= 0;
                $input_stok['id_kemasan'] 	= 999;
                $input_stok['qty'] 			= $value->qty;
                $input_stok['batch'] 		= $value->batch;
                $input_stok['harga_satuan'] = $value->harga;
                $input_stok['penyimpanan'] 	= $penyimpanan;
                $this->CI->db->insert('data_stok', $input_stok);
				$stok_id = $this->CI->db->insert_id();
            }

            $input_stok_log = array();
            $input_stok_log['stok_id'] 		= $stok_id;
            $input_stok_log['barcode'] 		= $value->barcode;
            $input_stok_log['is_obat'] 		= 0;
            $input_stok_log['id_kemasan'] 	= 999;
            $input_stok_log['qty'] 			= $value->qty;
            $input_stok_log['batch'] 		= $value->batch;
            $input_stok_log['jenis_transaksi'] = 1;
            $this->CI->db->insert('data_stok_log', $input_stok_log);
        }

        foreach ($obat as $key => $value) {
            $data = $this->get_stok($value->id_obat, 1, $value->kemasan, $value->expired_date, $value->batch, $penyimpanan);
            if (count($data) != 0) {
                $input_so = array();
                $input_so['qty'] = ($data[0]->qty + $value->qty_real);
                $this->CI->db->where('id', $data[0]->id);
                $this->CI->db->update('data_stok', $input_so);
				$stok_id = $data[0]->id;
            } else {
                $input_stok = array();
                $input_stok['id_barang'] 	= $value->id_obat;
                $input_stok['barcode'] 		= $value->barcode;
                $input_stok['is_obat'] 		= 1;
                $input_stok['id_kemasan'] 	= $value->kemasan;
                $input_stok['qty'] 			= $value->qty_real;
                $input_stok['expired_date'] = $value->expired_date;
                $input_stok['batch'] 		= $value->batch;
                $input_stok['harga_satuan'] = $value->harga;
                $input_stok['penyimpanan'] 	= $penyimpanan;
                $this->CI->db->insert('data_stok', $input_stok);
				$stok_id = $this->CI->db->insert_id();
            }

            $input_stok_log = array();
            $input_stok_log['stok_id'] 		= $stok_id;
            $input_stok_log['barcode'] 		= $value->barcode;
            $input_stok_log['is_obat'] 		= 1;
            $input_stok_log['id_kemasan'] 	= $value->kemasan;
            $input_stok_log['qty'] 			= $value->qty_real;
            $input_stok_log['expired_date'] = $value->expired_date;
            $input_stok_log['batch'] 		= $value->batch;
            $input_stok_log['jenis_transaksi'] = 1;
            $this->CI->db->insert('data_stok_log', $input_stok_log);
        }
    }
	
	function trx_save($data){
		$status = false;
		$id_penerimaan = $data['penerimaan_id'];
		$penyimpanan = $data['penyimpanan'];
		$diskon = 0;

		try {
			/* input ke data_penerimaan_obat */
			$penerimaan_obat = [];
			if (!empty($data['obat'])) {
				foreach ($data['obat'] as $key => $value) {
					$obat_id = '';
					$id_kemasan = $value['kemasan'];
					$sql = $this->CI->db->query("SELECT * FROM data_kemasan WHERE kemasan_name='$id_kemasan'");
					$res = $sql->result();
					$sql_obat = $this->CI->db->query("SELECT * FROM data_obat WHERE obat_barcode='{$value['barcode']}'");
					$res_obat = $sql_obat->result();

					$set_diskon = 0.15; //Diskon 15%
					$disc = $value['diskon']/100;

					/* Rumus Harga baru : 
						Jika diskon per ite <= 15% = diskon tetap
						Jika diskon per item > 15% = (diskon - 15%) / 2
					*/


					if ($disc != 0 ||$disc != '') {
						if ($disc <= $set_diskon) {
							$diskon = $disc;
						}else{
							$diskon = ($disc-$set_diskon)/2;
						}
					}

					$ppn = $value['price'] * ($value['ppn'] / 100);
					$diskon = $value['price'] * $diskon;

					$harga_obat_penerimaan = $value['price'] - $diskon + $ppn;

					// $harga_obat_penerimaan =$value['price'] - ($value['price'] * ($value['ppn'] / 100));

					foreach ($res as $val) {
						$id_kemasan = $val->kemasan_id;
					}

					foreach ($res_obat as $val) {
						/* Jika harga obat di penerimaan > harga obat di master maka di update harga */
						if ($harga_obat_penerimaan > $val->obat_price) {
							$change_price = array();
							$harga_kemasan_kecil = $val->obat_price;
							$margin_non_resep = ($val->obat_margin_non_resep * $harga_kemasan_kecil) + $harga_kemasan_kecil; 
							$margin_resep = ($val->obat_margin_resep * $harga_kemasan_kecil) + $harga_kemasan_kecil; 

							$change_price['obat_price_resep'] = $margin_non_resep;
							$change_price['obat_price_non_resep'] = $margin_resep;
							$change_price['obat_old_price'] = $val->obat_price;
							$change_price['obat_price'] = $harga_obat_penerimaan;
							$this->CI->db->where('obat_id', $val->obat_id);
							$this->CI->db->update('data_obat', $change_price);
						}
						$obat_id = $val->obat_id;
					}

					$penerimaan_obat[] = array(
						'id_penerimaan' => $id_penerimaan,
						'id_obat' => $obat_id,
						'id_kemasan' => $id_kemasan,
						'qty' => $value['qty'],
						'harga' => $value['price'],
						'ppn' => $value['ppn'],
						'diskon' => $value['diskon'],
						'expired_date' => $value['expired'],
						'batch' => $value['batch'],
					);
				}
				$this->CI->db->insert_batch('data_penerimaan_obat', $penerimaan_obat);
			}
			
			/* input ke data_penerimaan_alkes */
			$penerimaan_alkes = [];
			if (!empty($data['alkes'])) {
				foreach ($data['alkes'] as $key => $value) {
					$alkes_id = '';
					$sql = $this->CI->db->query("SELECT * FROM data_alkes WHERE alkes_barcode='{$value['barcode']}'");
					$res = $sql->result();

					foreach ($res as $val) {
						$alkes_id = $val->alkes_id;
					}
					
					$penerimaan_alkes[] = array(
						'id_penerimaan' => $id_penerimaan,
						'id_alkes' => $alkes_id,
						'qty' => $value['qty'],
						'harga' => $value['price'],
						'ppn' => $value['ppn'],
						'diskon' => $value['diskon'],
						'batch' => $value['batch'],
					);
				}
				$this->CI->db->insert_batch('data_penerimaan_alkes', $penerimaan_alkes);
			}
			$this->balance($id_penerimaan, $penyimpanan);

			$status = true;
        } catch (Exception $e) {
            $status =false;
        }
        
        if ($status == false) {
            $data['status']=500;
            $data['message'] = "Data gagal disimpan";
        } else {
            $data['status']=200;
            $data['message'] = 'Data berhasil ditambah';
        }
        return $data;
	}
	
	function stored($data) {
		$id_penerimaan = $data['penerimaan_id'];
		try {
			if ($id_penerimaan == 0) {
				$input_penerimaan = array();
				$input_penerimaan['no_faktur'] = $data['no_faktur'];
				$input_penerimaan['tanggal_faktur'] = $data['tanggal_faktur'];
				$input_penerimaan['jenis_penerimaan'] = $data['jenis_penerimaan'];
				$input_penerimaan['tanggal_tempo'] = $data['tanggal_tempo'];
				$input_penerimaan['image_faktur'] = $data['image_faktur'];
				$input_penerimaan['penyimpanan'] = $data['penyimpanan'];
				$input_penerimaan['total_harga'] = $data['total_harga'];
				$input_penerimaan['diskon_perfaktur_rp'] = $data['diskon_perfaktur_rp'];
				$input_penerimaan['diskon_perfaktur_persen'] = $data['diskon_perfaktur_persen'];
				$input_penerimaan['total'] = $data['total'];
				$input_penerimaan['is_permanent'] = 0;
				$input_penerimaan['id_pemesanan'] = $data['id_pemesanan'];
				$input_penerimaan['tanggal_input'] = date('Y-m-d H:i:s');
				
				$this->CI->db->insert('data_penerimaan', $input_penerimaan);
				$penerimaan_id = $this->CI->db->insert_id();

				/*Pemesanan sudah di penerimaan*/
				$res = array(
					'is_penerimaan' => 1,
				);
				$this->CI->db->where('pemesanan_id', $data['id_pemesanan']);
				$this->CI->db->update('data_pemesanan', $res);
			} else {
				$input_penerimaan = array();
				$input_penerimaan['no_faktur'] = $data['no_faktur'];
				$input_penerimaan['tanggal_faktur'] = $data['tanggal_faktur'];
				$input_penerimaan['jenis_penerimaan'] = $data['jenis_penerimaan'];
				$input_penerimaan['tanggal_tempo'] = $data['tanggal_tempo'];
				$input_penerimaan['image_faktur'] = $data['image_faktur'];
				$input_penerimaan['penyimpanan'] = $data['penyimpanan'];
				$input_penerimaan['total_harga'] = $data['total_harga'];
				$input_penerimaan['diskon_perfaktur_rp'] = $data['diskon_perfaktur_rp'];
				$input_penerimaan['diskon_perfaktur_persen'] = $data['diskon_perfaktur_persen'];
				$input_penerimaan['total'] = $data['total'];
				$input_penerimaan['is_permanent'] = 0;
				$input_penerimaan['id_pemesanan'] = $data['id_pemesanan'];
				
				$this->CI->db->where('penerimaan_id', $id_penerimaan);
				$this->CI->db->update('data_penerimaan', $input_penerimaan);
				$penerimaan_id = $id_penerimaan;

				/*Pemesanan sudah di penerimaan*/
				$res = array(
					'is_penerimaan' => 1,
				);
				$this->CI->db->where('pemesanan_id', $data['id_pemesanan']);
				$this->CI->db->update('data_pemesanan', $res);
			}
		} catch (\Throwable $th) {}
		return $penerimaan_id;
	}

	function validate_form($id = false)
	{
		$status = 500;
		$message = "Terjadi kesalahan, silahkan ulangi kembali.";
		if ($id) {
			$custom_validation = [
				[
					'field'   => "penerimaan_id",
					'label'   => 'ID',
					'rules'   => 'trim|required'
				],
				[
					'field'   => "obat_barcode",
					'label'   => 'Barcode',
					'rules'   => 'trim|required|max_length[200]|is_unique_edit_custom[data_penerimaan.obat_barcode.penerimaan_id.' . $_POST['penerimaan_id'] . ']'
				],
			];
		} else {
			$custom_validation = [
				[
					'field'   => "obat_barcode",
					'label'   => 'Barcode',
					'rules'   => 'trim|required|max_length[200]|is_unique[data_penerimaan.obat_barcode]'
				],
			];
		}

		$validation = [
			[
				'field'   => "obat_name",
				'label'   => 'Nama Obat',
				'rules'   => 'trim|required'
			],
			[
				'field'   => "obat_type",
				'label'   => 'Jenis Obat',
				'rules'   => 'trim|required',
			],
			[
				'field'   => "obat_dosis_value",
				'label'   => 'Dosis',
				'rules'   => 'trim|required',
			],
			[
				'field'   => "obat_dosis_id",
				'label'   => 'Satuan Dosis',
				'rules'   => 'trim|required'
			],
			[
				'field'   => "obat_price",
				'label'   => 'Harga Kemasan Kecil (HNA+PPN)',
				'rules'   => 'trim|required'
			],
			[
				'field'   => "obat_margin_resep",
				'label'   => 'Margin Resep',
				'rules'   => 'trim|required',
			],
			[
				'field'   => "obat_margin_non_resep",
				'label'   => 'Margin Non Resep',
				'rules'   => 'trim|required',
			],
			[
				'field'   => "obat_price_resep",
				'label'   => 'Harga Setelah Margin (Resep)',
				'rules'   => 'trim|required'
			],
			[
				'field'   => "obat_price_non_resep",
				'label'   => 'Harga Setelah Margin (Non Resep)',
				'rules'   => 'trim|required'
			],
			[
				'field'   => "obat_kemasan_kecil_id",
				'label'   => 'Kemasan Kecil',
				'rules'   => 'trim|required',
			],
			[
				'field'   => "obat_kemasan_kecil_konversi",
				'label'   => 'Kemasan Kecil Konversi',
				'rules'   => 'trim|required',
			],
			[
				'field'   => "obat_kemasan_sedang_id",
				'label'   => 'Kemasan Sedang',
				'rules'   => 'trim|required'
			],
			[
				'field'   => "obat_kemasan_sedang_konversi",
				'label'   => 'Kemasan Sedang Konversi',
				'rules'   => 'trim|required',
			],
			[
				'field'   => "obat_kemasan_besar_id",
				'label'   => 'Kemasan Besar',
				'rules'   => 'trim|required'
			],
			[
				'field'   => "obat_kemasan_besar_konversi",
				'label'   => 'Kemasan Besar Konversi',
				'rules'   => 'trim|required'
			],
		];

		$this->CI->form_validation->set_rules(array_merge($custom_validation, $validation));
		// $this->CI->form_validation->set_error_delimiters('<b>', '</b>');
		if ($this->CI->form_validation->run() == TRUE) {
			$data['status'] = 200;
			$data['message'] = "Ok.";
			return $data;
		} else {
			$data['status'] = 500;
			$data['message'] = validation_errors();
			return $data;
		}
	}

	function get_data($id_penerimaan = 0)
	{
		$params = isset($_POST) ? $_POST : array();

		if ($id_penerimaan == 0) {

			$params['table'] = 'data_penerimaan';
			$params['select'] = "data_penerimaan.*, s.supplier_name AS supplier, p.pemesanan_supplier_id AS supplier_id";
			$where = "is_delete = '0' AND retur_supplier = '0'";
			$join = ' LEFT JOIN data_pemesanan p on p.pemesanan_id=data_penerimaan.id_pemesanan';
			$join .= ' LEFT JOIN data_supplier s on s.supplier_id=p.pemesanan_supplier_id';
	
			if (trim($this->CI->input->get('no_faktur')) != '') {
				$where .= ' AND no_faktur LIKE "%' . $this->CI->input->get('no_faktur') . '%"';
			}
	
			if(trim($this->CI->input->get('supplier_id'))!='')
            {
                $where.=" AND supplier_id = '{$this->CI->input->get('supplier_id')}'";
            }
            
            if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='')
            {
                $where.=" AND tanggal_faktur BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
            }
			
			// $join.=' LEFT JOIN data_kemasan l on l.kemasan_id=data_penerimaan.obat_kemasan_sedang_id';
			// $join.=' LEFT JOIN data_kemasan m on m.kemasan_id=data_penerimaan.obat_kemasan_besar_id';
	
			$params['join'] = $join;
			$params['where'] = $where;
			$params['order_by'] = "penerimaan_id DESC";
	
			$query = $this->CI->common_lib->get_query($params);
			$total = $this->CI->common_lib->get_query($params, true);
	
			return array(
				'query' => $query,
				'total' => $total,
			);
		}else{
			
			$params['table'] = 'data_penerimaan';
			$params['select'] = "data_penerimaan.*, s.supplier_name AS supplier, data_pemesanan.pemesanan_id, data_pemesanan.pemesanan_no_sp, data_pemesanan.pemesanan_tanggal";
			$where = "is_delete = '0' AND penerimaan_id = '{$id_penerimaan}'";
	
			if (trim($this->CI->input->get('obat_name')) != '') {
				$where .= ' AND obat_name LIKE "%' . $this->CI->input->get('obat_name') . '%"';
			}
	
			if (trim($this->CI->input->get('penerimaan_id')) != '') {
				$where .= ' AND penerimaan_id = "' . $this->CI->input->get('penerimaan_id') . '"';
			}
	
			if (trim($this->CI->input->get('penerimaan_id')) != '') {
				$where .= ' AND penerimaan_id = "' . $this->CI->input->get('penerimaan_id') . '"';
			}
	
			$join = ' LEFT JOIN data_pemesanan on data_pemesanan.pemesanan_id=data_penerimaan.id_pemesanan';
			$join .= ' LEFT JOIN data_supplier s on s.supplier_id=data_pemesanan.pemesanan_supplier_id';
			// $join.=' LEFT JOIN data_kemasan l on l.kemasan_id=data_penerimaan.obat_kemasan_sedang_id';
			// $join.=' LEFT JOIN data_kemasan m on m.kemasan_id=data_penerimaan.obat_kemasan_besar_id';
	
			$params['where'] = $where;
			$params['join'] = $join;
			$params['order_by'] = "penerimaan_id DESC";
	
			$query = $this->CI->common_lib->get_query($params);
			$total = $this->CI->common_lib->get_query($params, true);
	
			return array(
				'query' => $query,
				'total' => $total,
			);

		}
	}

	function get_alkes($penerimaan_id)
	{
		$params['table'] = 'data_penerimaan_alkes';
		$params['select'] = "data_penerimaan_alkes.*, alkes.*";	
		$where = "id_penerimaan = '$penerimaan_id'";
		$join = 'LEFT JOIN data_alkes alkes on alkes.alkes_id = data_penerimaan_alkes.id_alkes';
		$params['where'] = $where;
		$params['join'] = $join;
		$params['order_by'] = "penerimaan_alkes_id DESC";
		$query = $this->CI->common_lib->get_query($params);
		return $query;
	}
	
	function get_obat($penerimaan_id)
	{
		$params['table'] = 'data_penerimaan_obat';
		$params['select'] = "data_penerimaan_obat.*, obat.obat_name AS obat_name, kemasan.kemasan_name AS kemasan_name, obat.obat_barcode AS obat_barcode, obat.obat_id AS obat_id";
		$where = "id_penerimaan = '$penerimaan_id' ";
		$join = 'LEFT JOIN data_obat obat on obat.obat_id=data_penerimaan_obat.id_obat';
		$join .= ' LEFT JOIN data_kemasan kemasan on kemasan.kemasan_id=data_penerimaan_obat.id_kemasan';
		$params['where'] = $where;
		$params['join'] = $join;
		$params['order_by'] = "penerimaan_obat_id DESC";
		$query = $this->CI->common_lib->get_query($params);
		return $query;
	}

	function get_detail_pemesanan($id)
	{
		$json_data = array();

		/*=========== Get data parrent by id ============*/
		$params['table'] = "data_pemesanan";
		$params['select'] = "data_pemesanan.*, s.supplier_id, s.supplier_name";
		$where = " is_delete=0 AND pemesanan_id = '{$id}'";
		$join = " LEFT JOIN data_supplier s ON pemesanan_supplier_id = s.supplier_id ";

		$params['join'] = $join;
		$params['where'] = $where;
		$params['order_by'] = "pemesanan_id DESC";

		$query_parrent = $this->CI->common_lib->get_query($params);
		$total_parrent = $this->CI->common_lib->get_query($params, true);

		$json_data['parrentData'] = $query_parrent->result();
		$json_data['total'] = $total_parrent;

		/*=========== Get detail by id ============*/
		$params1['table'] = 'data_pemesanan';
		$params1['select'] = "data_pemesanan.*, d.*, s.supplier_id, s.supplier_name";
		$where1 = "is_delete=0 AND pemesanan_id = '{$id}'";

		$join = ' LEFT JOIN data_supplier s ON pemesanan_supplier_id = s.supplier_id';
		$join .= ' LEFT JOIN data_detail_pemesanan d on pemesanan_id = d.detail_pemesanan_pemesanan_id';

		$params1['join'] = $join;
		$params1['where'] = $where1;
		$params1['order_by'] = "pemesanan_id DESC";

		$query_detailData = $this->CI->common_lib->get_query($params1);
		$json_data['detailData'] = $query_detailData->result();

		return $json_data;
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