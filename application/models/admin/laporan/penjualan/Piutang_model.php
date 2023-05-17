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
class Piutang_model extends controller_model
{
	protected $role_arr;
	public function __construct()
	{
		parent::__construct();
		$this->CI = &get_instance();
	}

	public function get_data()
	{
		$params = isset($_POST) ? $_POST : array();

		$params['table'] 	= "trx_pemeriksaan_kasir";
		$params['select'] 	= "*";
		$where = "1 AND kasir_status LIKE '%belum%'";

		if (trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir')) != '') {
			$where .= " AND kasir_date BETWEEN '{$this->CI->input->get('tanggal_awal')}' AND '{$this->CI->input->get('tanggal_akhir')}'";
		}

		$params['where'] 	= $where;
		$params['order_by'] = "kasir_invoice ASC";

		$query = $this->CI->common_lib->get_query($params);
		$total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query' => $query->result(),
			'total' => $total,
			'filter_start_date' => $this->CI->input->get('tanggal_awal'),
            'filter_end_date' => $this->CI->input->get('tanggal_akhir'),
		);
	}

	function data_list_obat($id)
	{
		$params['table'] 	= "trx_pemeriksaan_obat_apotek";
		$params['select'] 	= "trx_pemeriksaan_obat_apotek.* ";
		$where = "pemeriksaan_obat_pemeriksaan_id = '$id' ";
		$join = ' LEFT JOIN trx_pemeriksaan_kasir ON trx_pemeriksaan_kasir.kasir_pemeriksaan_id = pemeriksaan_obat_pemeriksaan_id';

		$params['join'] 	= $join;
		$params['where'] 	= $where;
		$params['order_by'] = "pemeriksaan_obat_id ASC";

		$query = $this->CI->common_lib->get_query($params);

		return $query;
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