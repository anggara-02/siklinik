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

require_once APPPATH.'/extend/controller_model.php';
class Obat_model extends controller_model{
	protected $role_arr, $keyAdmin;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
		$this->keyAdmin=common_lib::keySession('admin');
    }
	
	function stored($id=false)
	{
		if ($id) {$obat_id=$this->CI->input->post('obat_id',true);}
		if ($id) {
			$dataArr=[
				'obat_id' 						=> $obat_id,
				'user_id' 						=> $_SESSION[$this->keyAdmin]['user_id'],
				'obat_name' 					=> $this->CI->input->post('obat_name',true),
				'obat_type' 					=> $this->CI->input->post('obat_type',true),
				'obat_price' 					=> $this->CI->input->post('obat_price',true),
				'obat_barcode' 					=> $this->CI->input->post('obat_barcode',true),
				'obat_dosis_id' 				=> $this->CI->input->post('obat_dosis_id',true),
				'obat_price_resep' 				=> $this->CI->input->post('obat_price_resep',true),
				'obat_dosis_value' 				=> $this->CI->input->post('obat_dosis_value',true),
				'obat_margin_resep' 			=> $this->CI->input->post('obat_margin_resep',true),
				'obat_price_non_resep' 			=> $this->CI->input->post('obat_price_non_resep',true),
				'obat_margin_non_resep' 		=> $this->CI->input->post('obat_margin_non_resep',true),
				'obat_kemasan_kecil_id' 		=> $this->CI->input->post('obat_kemasan_kecil_id',true),
				'obat_kemasan_besar_id' 		=> $this->CI->input->post('obat_kemasan_besar_id',true),
				'obat_kemasan_sedang_id' 		=> $this->CI->input->post('obat_kemasan_sedang_id',true),
				'obat_kemasan_kecil_konversi' 	=> $this->CI->input->post('obat_kemasan_kecil_konversi',true),
				'obat_kemasan_besar_konversi' 	=> $this->CI->input->post('obat_kemasan_besar_konversi',true),
				'obat_kemasan_sedang_konversi' 	=> $this->CI->input->post('obat_kemasan_sedang_konversi',true),
				'obat_lokasi' 					=> $this->CI->input->post('obat_lokasi',true),
				'obat_rak' 						=> $this->CI->input->post('obat_rak',true),
			];
			$this->CI->db->update('data_obat', $dataArr, ['obat_id'=>$obat_id]);
		} else {
			$dataArr=[
				'user_id' 						=> $_SESSION[$this->keyAdmin]['user_id'],
				'obat_name' 					=> $this->CI->input->post('obat_name',true),
				'obat_type' 					=> $this->CI->input->post('obat_type',true),
				'obat_price' 					=> $this->CI->input->post('obat_price',true),
				'obat_barcode' 					=> $this->CI->input->post('obat_barcode',true),
				'obat_dosis_id' 				=> $this->CI->input->post('obat_dosis_id',true),
				'obat_price_resep' 				=> $this->CI->input->post('obat_price_resep',true),
				'obat_dosis_value' 				=> $this->CI->input->post('obat_dosis_value',true),
				'obat_margin_resep' 			=> $this->CI->input->post('obat_margin_resep',true),
				'obat_price_non_resep' 			=> $this->CI->input->post('obat_price_non_resep',true),
				'obat_margin_non_resep' 		=> $this->CI->input->post('obat_margin_non_resep',true),
				'obat_kemasan_kecil_id' 		=> $this->CI->input->post('obat_kemasan_kecil_id',true),
				'obat_kemasan_besar_id' 		=> $this->CI->input->post('obat_kemasan_besar_id',true),
				'obat_kemasan_sedang_id' 		=> $this->CI->input->post('obat_kemasan_sedang_id',true),
				'obat_kemasan_kecil_konversi' 	=> $this->CI->input->post('obat_kemasan_kecil_konversi',true),
				'obat_kemasan_besar_konversi' 	=> $this->CI->input->post('obat_kemasan_besar_konversi',true),
				'obat_kemasan_sedang_konversi' 	=> $this->CI->input->post('obat_kemasan_sedang_konversi',true),
				'obat_lokasi' 					=> $this->CI->input->post('obat_lokasi',true),
				'obat_rak' 						=> $this->CI->input->post('obat_rak',true),
			];
			$this->CI->db->insert('data_obat', $dataArr);
		}
		
		return [
			'status'=>200,
			'message'=>'Data Sukses disimpan',
		];
	}
	
	function validate_form($id=false)
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		if ($id) {
			$custom_validation = [
                [
                     'field'   => "obat_id",
                     'label'   => 'ID',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "obat_barcode",
                     'label'   => 'Barcode',
                     'rules'   => 'trim|required|max_length[200]|is_unique_edit_custom[data_obat.obat_barcode.obat_id.'.$_POST['obat_id'].']'
                ],
			];
		} else {
			$custom_validation = [
				[
						'field'   => "obat_barcode",
						'label'   => 'Barcode',
						'rules'   => 'trim|required|max_length[200]|is_unique[data_obat.obat_barcode]'
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
		if ($this->CI->form_validation->run() == TRUE)
		{
			$data['status']=200;
			$data['message']="Ok.";
			return $data;
		} else {
			$data['status']=500;
			$data['message']=validation_errors(); 
			return $data;
		}
    }
	
	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'data_obat';
        $params['select'] = "data_obat.*, k.kemasan_name AS kemasan1, l.kemasan_name AS kemasan2, m.kemasan_name AS kemasan3";
        $where='is_delete=0';
         
        if(trim($this->CI->input->get('obat_name'))!='')
        {
            $where.=' AND obat_name LIKE "%'.$this->CI->input->get('obat_name').'%"';
        } 
        if(trim($this->CI->input->get('obat_id'))!='')
        {
            $where.=' AND obat_id = "'.$this->CI->input->get('obat_id').'"';
        }
		
        $join=' LEFT JOIN data_dosis on data_dosis.dosis_id=data_obat.obat_dosis_id';
		$join.=' LEFT JOIN data_kemasan k on k.kemasan_id=data_obat.obat_kemasan_kecil_id';
		$join.=' LEFT JOIN data_kemasan l on l.kemasan_id=data_obat.obat_kemasan_sedang_id';
		$join.=' LEFT JOIN data_kemasan m on m.kemasan_id=data_obat.obat_kemasan_besar_id';
         
        $params['where'] =$where;
        $params['join'] = $join;
        $params['order_by'] = "obat_id DESC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query,
			'total'=>$total,
		);
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