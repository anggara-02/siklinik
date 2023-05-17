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
class Barang_terjual_model extends controller_model
{
    protected $role_arr;
    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }

	public function get_data(){
		$params = isset($_POST) ? $_POST : array();
		$params['table'] 	= "trx_pemeriksaan_kasir";
		$params['select'] 	= "
			kasir_date AS date,
			trx_pemeriksaan_obat_apotek.pemeriksaan_obat_obat_id AS barang_id, 
			trx_pemeriksaan_obat_apotek.pemeriksaan_obat_kemasan_id AS kemasan_id, 
			trx_pemeriksaan_obat_apotek.pemeriksaan_obat_is_obat AS is_obat, 
			trx_pemeriksaan_obat_apotek.pemeriksaan_obat_qty AS qty,
			trx_pemeriksaan_obat_apotek.pemeriksaan_obat_name AS obat_name,
			trx_pemeriksaan_kasir.kasir_disc AS diskon_kasir, 
			kasir_disc_persen AS diskon_persen_kasir,
			trx_pemeriksaan.pemeriksaan_id AS pemeriksaan_id
		";

		$where = '1';

		if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='') {
			$where .= " AND date BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
		}

		$join = ' LEFT JOIN trx_pemeriksaan ON trx_pemeriksaan.pemeriksaan_id = trx_pemeriksaan_kasir.kasir_pemeriksaan_id';
		$join .= ' LEFT JOIN trx_pemeriksaan_obat_apotek ON trx_pemeriksaan_obat_apotek.pemeriksaan_obat_pemeriksaan_id = trx_pemeriksaan.pemeriksaan_id';
		
		$params['join'] 	= $join;
		$params['where'] 	= $where;
		$params['order_by'] = "obat_name ASC";

		// $params['table'] 	= "trx_pemeriksaan_kasir";
		// $params['select'] 	= "*";
		// $where = '1';
		// if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='') {
		// 	$where .= " AND date BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
		// }
		// $params['where'] 	= $where;
		// $params['order_by'] = "kasir_id DESC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		foreach ($query->result() as $key => $value) {
			$id_barang = $value->barang_id;
			$id_kemasan = $value->kemasan_id;
			$data_kemasan_terjual = $this->get_harga_kemasan($id_barang, $id_kemasan);

			$res[] = array(
				'date' => $value->date,
				'barang_id' => $value->barang_id,
				'kemasan_id' => $value->kemasan_id,
				'is_obat' => $value->is_obat,
				'qty' => $value->qty,
				'obat_name' => $value->obat_name,
				'diskon_kasir' => $value->diskon_kasir,
				'diskon_persen_kasir' => $value->diskon_persen_kasir,
				'kemasan_dijual' => $data_kemasan_terjual['kemasan'],
				'konversi_kemasan' => $data_kemasan_terjual['konversi']
			);
		}

		// $res_obat = $this->get_obat($id_barang);

		return array(
			'query'=>$query->result(),
			'total'=>$total,
			'filter_start_date' => $this->CI->input->get('tanggal_awal'),
            'filter_end_date' => $this->CI->input->get('tanggal_akhir'),
		);
	}

	function get_dokter($id) {
		$params['table'] 	= 'trx_pemeriksaan';
		$params['select'] 	= "trx_pemeriksaan.*, trx_pendaftaran.*";	
		$where 	= "pemeriksaan_id = {$id}";
		$join 	= ' LEFT JOIN trx_pendaftaran ON trx_pendaftaran.pendaftaran_id=trx_pemeriksaan.pemeriksaan_pendaftaran_id';
		$join 	.= ' LEFT JOIN data_kemasan ON data_kemasan.kemasan_id=data_obat.obat_kemasan_kecil_id';
		$params['where'] 	= $where;
		$params['join'] 	= $join;
		$params['order_by'] = "pemeriksaan_obat_obat_id DESC";
		$query = $this->CI->common_lib->get_query($params);
		return $query;
	}
	
	function get_obat($id)
	{
		$params['table'] 	= 'trx_pemeriksaan_obat_apotek';
		$params['select'] 	= "trx_pemeriksaan_obat_apotek.*, data_obat.*, data_kemasan.kemasan_name AS kemasan";	
		$where 	= "obat_id = {$id}";
		$join 	= ' LEFT JOIN data_obat ON data_obat.obat_id=trx_pemeriksaan_obat_apotek.pemeriksaan_obat_obat_id';
		$join 	.= ' LEFT JOIN data_kemasan ON data_kemasan.kemasan_id=data_obat.obat_kemasan_kecil_id';
		$params['where'] 	= $where;
		$params['join'] 	= $join;
		$params['order_by'] = "pemeriksaan_obat_pemeriksaan_id ASC";
		$query = $this->CI->common_lib->get_query($params);
		return $query->result();
	}
	
	function get_alkes($id)
	{
		$params['table'] 	= 'trx_pemeriksaan_obat_apotek';
		$params['select'] 	= "trx_pemeriksaan_obat_apotek.*, data_alkes.*, data_kemasan.kemasan_name AS kemasan";	
		$where 	= "alkes_id = '$id'";
		$join 	= ' LEFT JOIN data_alkes ON data_alkes.alkes_id = trx_pemeriksaan_obat_apotek.pemeriksaan_obat_obat_id';
		$join 	.= ' LEFT JOIN data_kemasan ON data_kemasan.kemasan_id = data_alkes.alkes_kemasan';
		$params['where'] 	= $where;
		$params['join'] 	= $join;
		$params['order_by'] = "pemeriksaan_obat_name ASC";
		$query = $this->CI->common_lib->get_query($params);
		return $query->result();
	}
	
	function get_data_where($id)
	{
		$params['table'] 	= 'trx_pemeriksaan_obat_apotek';
		$params['select'] 	= "trx_pemeriksaan_obat_apotek.*";	
		$where 	= "pemeriksaan_obat_pemeriksaan_id = '$id'";
		$params['where'] 	= $where;
		$params['order_by'] = "pemeriksaan_obat_name ASC";

		$query = $this->CI->common_lib->get_query($params);
		return $query->result();
	}

	public function get_harga_kemasan($barang_id, $kemasan_id, $qty = 0){
		// $params['table'] 	= 'trx_pemeriksaan_obat_apotek';
		// $params['select'] 	= "trx_pemeriksaan_obat_apotek.*, data_obat.*, data_kemasan.kemasan_id AS id_kemasan";	
		// $where 	= "obat_kemasan_kecil_id = {$id} OR obat_kemasan_sedang_id = {$id} OR obat_kemasan_besar_id = {$id}";
		// $join 	= ' LEFT JOIN data_obat ON data_obat.obat_id=trx_pemeriksaan_obat_apotek.pemeriksaan_obat_obat_id';
		// $join 	.= ' LEFT JOIN data_kemasan ON data_kemasan.kemasan_id=data_obat.obat_kemasan_kecil_id';
		// $params['join'] 	= $join;
		// $params['where'] 	= $where;
		// $params['order_by'] = "pemeriksaan_obat_obat_id DESC";

		$kemasan = '';
		$status = '';
			
		$params_kecil['table'] 	= 'data_obat';
		$params_kecil['select'] 	= 'obat_kemasan_kecil_id,obat_kemasan_kecil_konversi AS konversi, data_kemasan.kemasan_name AS kemasan, obat_id';	
		$where 	= "obat_kemasan_kecil_id = '{$kemasan_id}' AND obat_id = '{$barang_id}'";
		$join 	= ' LEFT JOIN data_kemasan ON data_kemasan.kemasan_id = obat_kemasan_kecil_id';
		$params_kecil['join'] 	= $join;
		$params_kecil['where'] 	= $where;
		$params_kecil['order_by'] = "obat_kemasan_kecil_id DESC";
		$kemasan_kecil = $this->CI->common_lib->get_query($params_kecil);
		
		if ($kemasan_kecil->num_rows() <= 0) {
			$params_sedang['table'] 	= 'data_obat';
			$params_sedang['select'] 	= 'obat_kemasan_sedang_id, obat_kemasan_sedang_konversi AS konversi, data_kemasan.kemasan_name AS kemasan, obat_id';	
			$where 	= "obat_kemasan_sedang_id = '{$kemasan_id}' AND obat_id = '{$barang_id}'";
			$join 	= ' LEFT JOIN data_kemasan ON data_kemasan.kemasan_id = obat_kemasan_sedang_id';
			$params_sedang['join'] 	= $join;
			$params_sedang['where'] 	= $where;
			$params_sedang['order_by'] = "obat_kemasan_sedang_id DESC";
			$kemasan_sedang = $this->CI->common_lib->get_query($params_sedang);

			if ($kemasan_sedang->num_rows() <= 0 ) {
				$params_besar['table'] 	= 'data_obat';
				$params_besar['select'] 	= 'obat_kemasan_besar_id, obat_kemasan_besar_konversi AS konversi, data_kemasan.kemasan_name AS kemasan, obat_id';	
				$where 	= "obat_kemasan_besar_id = '{$kemasan_id}' AND obat_id = '{$barang_id}'";
				$join 	= ' LEFT JOIN data_kemasan ON data_kemasan.kemasan_id = obat_kemasan_besar_id';
				$params_besar['join'] 	= $join;
				$params_besar['where'] 	= $where;
				$params_besar['order_by'] = "obat_kemasan_besar_id DESC";
				$kemasan_besar = $this->CI->common_lib->get_query($params_besar);

				if ($kemasan_besar->num_rows() > 0) {
					$kemasan = $kemasan_besar->result();
					$status = 'besar';
				}
			}else{
				$kemasan = $kemasan_sedang->result();
				$status = 'sedang';
			}
			
		}else{
			$kemasan = $kemasan_kecil->result();
			$status = 'kecil';
		}

		$konversi = '';

		foreach ($kemasan as $value) {
			$konversi = $value->konversi;
		}
		$json =array();
		
		$json = array('kemasan'=> $status, 'konversi' => $konversi);
		// print_r($json);
		return $json;
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