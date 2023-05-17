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
class Retur_supplier_model extends controller_model
{
	protected $role_arr, $keyAdmin;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->keyAdmin = common_lib::keySession('admin');
    }

	function get_penerimaan($id)
	{
		$json_data = array();

		/*=========== Get data parrent by id ============*/
        $sql_parrent = "
        SELECT data_penerimaan.*, s.supplier_id, s.supplier_name, p.pemesanan_tanggal
        FROM data_penerimaan
        LEFT JOIN data_pemesanan p ON p.pemesanan_id = data_penerimaan.id_pemesanan
        LEFT JOIN data_supplier s ON s.supplier_id = p.pemesanan_supplier_id
        WHERE data_penerimaan.is_delete = '0' AND p.is_delete = '0' AND penerimaan_id = '$id'
        ORDER BY penerimaan_id DESC
		";
        
		$json_data['parrentData'] = $this->CI->db->query($sql_parrent)->result_array();
		
		/*
		$sql_detail_alkes ="
			SELECT data_penerimaan_alkes.*, data_penerimaan.*, a.alkes_kemasan AS kemasan, a.alkes_name AS alkes_name
			FROM data_penerimaan_alkes
			LEFT JOIN data_penerimaan ON data_penerimaan.penerimaan_id = data_penerimaan_alkes.id_penerimaan
			LEFT JOIN data_alkes a ON a.alkes_id = data_penerimaan_alkes.id_alkes
			WHERE data_penerimaan.is_delete = '0' AND data_penerimaan.penerimaan_id = '$id'
			ORDER BY data_penerimaan.penerimaan_id DESC
		";		
		$json_data['alkes'] = $this->CI->db->query($sql_detail_alkes)->result_array();
		
		$sql_detail_obat ="
            SELECT data_penerimaan_obat.*, data_penerimaan.*, data_obat.*
            FROM data_penerimaan_obat
            LEFT JOIN data_penerimaan ON data_penerimaan.penerimaan_id = data_penerimaan_obat.id_penerimaan
            LEFT JOIN data_obat ON data_obat.obat_id = data_penerimaan_obat.id_kemasan
            WHERE data_penerimaan.is_delete = '0' AND data_penerimaan.penerimaan_id = '$id'
            ORDER BY data_penerimaan.penerimaan_id DESC
		";		
		$json_data['obat'] = $this->CI->db->query($sql_detail_obat)->result_array();
        */

		$json_data['alkes'] = $this->get_alkes($id)->result_array();
		$json_data['obat'] = $this->get_obat($id)->result_array();
		return $json_data;
	}

	function trx_save($data){
		$status = false;
		$id_penerimaan = $data['id_penerimaan'];
		try {
			/* update data_penerimaan and set retur */
			$this->CI->db->set('retur_supplier', '1');
			$this->CI->db->set('tanggal_retur', $data['tgl_retur']);
			$this->CI->db->where('penerimaan_id', $id_penerimaan);
			$this->CI->db->update('data_penerimaan');

			$sql = "
				SELECT penyimpanan FROM data_penerimaan WHERE is_delete = '0' AND retur_supplier = '1' AND penerimaan_id = '$id_penerimaan'
			";

			$penyimpanan = $this->CI->db->query($sql)->result();
			$penyimpanan_new = '';
			foreach ($penyimpanan as $key => $value) {
				$penyimpanan_new = $value->penyimpanan;
			}
			$this->balance($id_penerimaan, $penyimpanan_new);

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
	
	public function balance($id_penerimaan, $penyimpanan) {
        $alkes = $this->alkes($id_penerimaan);
        $obat = $this->obat($id_penerimaan);
        foreach ($alkes as $key => $value) {
            $data = $this->get_stok($value->barcode, 0, $value->kemasan, NULL, $value->batch, $penyimpanan);
            if (count($data) != 0) {
                $input_so = array();
                $input_so['qty'] = ($data[0]->qty - $value->qty);
                $this->CI->db->where('id', $data[0]->id);
                $this->CI->db->update('data_stok', $input_so);
				$stok_id = $data[0]->id;
            } else {
                $input_stok = array();
                $input_stok['barcode'] 		= $value->barcode;
                $input_stok['is_obat'] 		= 0;
                $input_stok['id_kemasan'] 	= $value->kemasan;
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
            $input_stok_log['id_kemasan'] 	= $value->kemasan;
            $input_stok_log['qty'] 			= $value->qty;
            $input_stok_log['batch'] 		= $value->batch;
            $input_stok_log['jenis_transaksi'] = 5;
            
            $this->CI->db->insert('data_stok_log', $input_stok_log);
        }

        foreach ($obat as $key => $value) {
            $data = $this->get_stok($value->barcode, 1, $value->kemasan, $value->expired_date, $value->batch, $penyimpanan);
            if (count($data) != 0) {
                $input_so = array();
                $input_so['qty'] = ($data[0]->qty - $value->qty_real);
                $this->CI->db->where('id', $data[0]->id);
                $this->CI->db->update('data_stok', $input_so);
				$stok_id = $data[0]->id;
            } else {
                $input_stok = array();
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
            $input_stok_log['stok_id']		= $stok_id;
            $input_stok_log['barcode'] 		= $value->barcode;
            $input_stok_log['is_obat'] 		= 1;
            $input_stok_log['id_kemasan'] 	= $value->kemasan;
            $input_stok_log['qty'] 			= $value->qty_real;
            $input_stok_log['expired_date'] = $value->expired_date;
            $input_stok_log['batch'] 		= $value->batch;
            $input_stok_log['jenis_transaksi'] = 5;
            $this->CI->db->insert('data_stok_log', $input_stok_log);
        }
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

    public function get_stok($barcode, $is_obat, $id_kemasan, $expired_date, $batch, $penyimpanan) {
        $params = [];
        $params['table'] 	= 'data_stok';
        $params['select'] 	= "data_stok.*";
        $params['where'] 	= "barcode='{$barcode}' AND is_obat='{$is_obat}' AND id_kemasan='{$id_kemasan}' AND batch='{$batch}' AND penyimpanan='{$penyimpanan}'";

        if ($expired_date != NULL) {
            $params['where'] .= " AND expired_date = '{$expired_date}' ";
        }
        
        $query = $this->CI->common_lib->get_query($params)->result();
        return $query;
    }

    function get_data($id_penerimaan = 0)
	{
		$params = isset($_POST) ? $_POST : array();

		if ($id_penerimaan == 0) {

			$params['table'] = 'data_penerimaan';
			$params['select'] = "data_penerimaan.*, s.supplier_name AS supplier, p.pemesanan_supplier_id AS supplier_id";
			$where = "is_delete = '0' AND retur_supplier = '1'";
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
}