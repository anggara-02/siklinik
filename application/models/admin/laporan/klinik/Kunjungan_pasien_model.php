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
class Kunjungan_pasien_model extends controller_model
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
		$params['table'] 	= 'trx_pendaftaran pendaftaran';
		$params['select'] 	= "*";
		if (trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir')) != '') {
			$where = " pendaftaran_date BETWEEN '{$this->CI->input->get('tanggal_awal')} 00:00:00' AND '{$this->CI->input->get('tanggal_akhir')} 23:59:59'";
			$params['where'] = $where;
		}

		$join	= ' LEFT JOIN trx_pemeriksaan pemeriksaan ON pemeriksaan.pemeriksaan_pendaftaran_id = pendaftaran.pendaftaran_id';
		$params['join'] = $join;
		$params['order_by'] = "pendaftaran_date DESC";

		$query = $this->CI->common_lib->get_query($params);
		$total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query' => $query->result(),
			'total' => $total,
			'filter_start_date' => $this->CI->input->get('tanggal_awal'),
            'filter_end_date' => $this->CI->input->get('tanggal_akhir'),
		);
	}

	public function get_diagnosis($pemeriksaan_id)
	{
		$params['table'] 	= 'trx_pemeriksaan_diagnosis';
		$params['select'] 	= "*";
		$params['where'] 	= "pemeriksaan_diagnosis_pemeriksaan_id = '$pemeriksaan_id'";
		$params['order_by'] = "pemeriksaan_diagnosis_id ASC";

		$query = $this->CI->common_lib->get_query($params);

		return $query;
	}

	public function get_pemeriksaan_medis($pemeriksaan_id)
	{
		$params['table'] 	= 'trx_pemeriksaan';
		$params['select'] 	= "*";
		$params['where'] 	= "pemeriksaan_id = '$pemeriksaan_id'";
		$params['order_by'] = "pemeriksaan_id ASC";

		$query = $this->CI->common_lib->get_query($params);

		return $query;
	}

	public function get_pemeriksaan_laborat($pemeriksaan_id)
	{
		$params = isset($_POST) ? $_POST : array();
		$params['table'] 	= 'trx_pemeriksaan';
		$params['select'] 	= "*";

		$join	= ' LEFT JOIN trx_pendaftaran_layanan ON trx_pendaftaran_layanan.pendaftaran_layanan_pendaftaran_id = trx_pemeriksaan.pemeriksaan_pendaftaran_id AND lower(pendaftaran_layanan_layanan_name)="laboratorium"';
		$params['join'] = $join;
		$params['where'] = "pendaftaran_layanan_pendaftaran_id = '$pemeriksaan_id'";
		$params['order_by'] = "pemeriksaan_id ASC";

		$query = $this->CI->common_lib->get_query($params);
		return $query;
	}

	public function get_resep($pemeriksaan_id)
	{
		$params = isset($_POST) ? $_POST : array();
		$params['table'] 	= 'trx_pemeriksaan_obat_apotek';
		$params['select'] 	= "*";

		$join	= ' LEFT JOIN trx_pemeriksaan ON trx_pemeriksaan.pemeriksaan_id = trx_pemeriksaan_obat_apotek.pemeriksaan_obat_pemeriksaan_id';
		$params['join'] = $join;
		$params['where'] = "pemeriksaan_obat_pemeriksaan_id = '$pemeriksaan_id' AND pemeriksaan_obat_resep != ''";
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