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
class Pemesanan_model extends controller_model
{
	protected $role_arr;
	public function __construct()
	{
		parent::__construct();
		$this->CI = &get_instance();
	}

	public function get_data()
	{
		$temp_detail = array();
		$grand_total = 0;
		$count_grand_total = 0;
		$res = array();

		$detail = $this->CI->db->query("
			SELECT data_detail_pemesanan.*, IFNULL(data_alkes.alkes_price, 0) AS alkes_price, IFNULL(data_obat.obat_price, 0) AS obat_price, IFNULL(data_alkes.alkes_id, 0) AS alkes_id, IFNULL(data_obat.obat_id, 0) AS obat_id 
			FROM data_detail_pemesanan 
			LEFT JOIN data_obat ON data_obat.obat_barcode = data_detail_pemesanan.detail_pemesanan_barcode 
			LEFT JOIN data_alkes ON data_alkes.alkes_barcode = data_detail_pemesanan.detail_pemesanan_barcode 
			WHERE 1
			ORDER BY detail_pemesanan_id ASC
		");
		$detail_pemesanan = $detail->result_array();

		$count_same_parents = $this->CI->db->query("
		SELECT detail_pemesanan_pemesanan_id, count(*) as result 
		FROM data_detail_pemesanan GROUP BY detail_pemesanan_pemesanan_id;
		");

		$sql = $this->CI->db->query("
			SELECT data_pemesanan.*, data_user.user_karyawan, data_supplier.supplier_name
			FROM data_pemesanan 
			LEFT JOIN data_user 
			ON data_user.user_id = data_pemesanan.user_karyawan
			LEFT JOIN data_supplier
			ON data_supplier.supplier_id = data_pemesanan.pemesanan_supplier_id
			WHERE data_pemesanan.is_penerimaan = '0'
			ORDER BY data_pemesanan.pemesanan_id
			");
		$parents = $sql->result_array();


		foreach ($detail_pemesanan as $key => $value) {
			foreach ($parents as $k => $val) {
				if ($value['is_obat'] == 0) {
					$total_price = $value['detail_pemesanan_qty'] * $value['alkes_price'];
					$price_per_item = (float) $value['alkes_price'];
					$id_barang = $value['alkes_id'];
				} else {
					$total_price = $value['detail_pemesanan_qty'] * $value['obat_price'];
					$price_per_item = (float) $value['obat_price'];
					$id_barang = $value['obat_id'];
				}

				$tot = array('total' => $total_price, 'harga_per_item' => $price_per_item, 'id_barang' => $id_barang);
				$detail = array_merge($tot, $value);

				if ($value['detail_pemesanan_pemesanan_id'] == $val['pemesanan_id']) {
					$temp_detail['data'][] = array_merge($val, $detail);
					$grand_total += $total_price;
				}
			}

			$temp_detail['grand_total'][$value['detail_pemesanan_pemesanan_id']] = $grand_total;
			$count_grand_total = array_sum($temp_detail['grand_total']);
			$temp_detail['count_grand_total'] = $count_grand_total;

			foreach ($count_same_parents->result_array() as $res) {
				$temp_detail['same'][$res['detail_pemesanan_pemesanan_id']] = $res['result'];
			}
		}
		$temp_detail['parent'] = $parents;
		return $temp_detail;
	}

	public function is_obat($id, $is_obat)
	{
		if ($is_obat != 0) {
			$sql = $this->CI->db->query("
				SELECT obat_price FROM data_obat WHERE obat_id = '$id' ORDER BY obat_id
			");
		} else {
			$sql = $this->CI->db->query("
				SELECT alkes_price FROM data_alkes WHERE alkes_id = '$id' ORDER BY alkes_id
			");
		}
		return $sql->result();
	}

	function group_by($key, $data)
	{
		$result = array();

		foreach ($data as $val) {
			if (array_key_exists($key, $val)) {
				$result[$val[$key]][] = $val;
			} else {
				$result[""][] = $val;
			}
		}

		return $result;
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