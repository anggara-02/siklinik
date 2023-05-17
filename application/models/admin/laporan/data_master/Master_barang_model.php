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
class Master_barang_model extends controller_model
{
	protected $role_arr;
	public function __construct()
	{
		parent::__construct();
		$this->CI = &get_instance();
	}

	function get_data()
	{
		$params = isset($_POST) ? $_POST : array();

		$params['table'] = 'data_obat';
		$params['select'] = "data_obat.*, k.kemasan_name AS kemasan1, l.kemasan_name AS kemasan2, m.kemasan_name AS kemasan3, u.user_karyawan AS nama_user";
		$where = ' is_delete=0';

        if(trim($this->CI->input->get('tanggal_awal') && $this->CI->input->get('tanggal_akhir'))!='') {
            $where .= " AND update_at BETWEEN '{$this->CI->input->get('tanggal_awal')} 00:00:00' AND '{$this->CI->input->get('tanggal_akhir')} 23:59:59'";
        }

		$join = ' LEFT JOIN data_dosis on data_dosis.dosis_id=data_obat.obat_dosis_id';
		$join .= ' LEFT JOIN data_user u on u.user_id=data_obat.user_id';
		$join .= ' LEFT JOIN data_kemasan k on k.kemasan_id=data_obat.obat_kemasan_kecil_id';
		$join .= ' LEFT JOIN data_kemasan l on l.kemasan_id=data_obat.obat_kemasan_sedang_id';
		$join .= ' LEFT JOIN data_kemasan m on m.kemasan_id=data_obat.obat_kemasan_besar_id';
		$params['where'] = $where;
		$params['join'] = $join;
		$params['order_by'] = "obat_id DESC";

		$query = $this->CI->common_lib->get_query($params);
		$total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query' => $query->result(),
			'total' => $total,
			'filter_start_date' => $this->CI->input->get('tanggal_awal'),
            'filter_end_date' => $this->CI->input->get('tanggal_akhir'),
		);
	}

    public function stok($obat_id) {
        $model = $this->CI->db->query("SELECT SUM(qty) AS stok FROM data_stok WHERE id_barang='{$obat_id}'")->result();
        return $model[0]->stok;
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