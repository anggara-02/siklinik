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
class Alkes_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
	
	function stored($id=false)
	{
		if ($id) {
			$alkes_id=$this->CI->input->post('alkes_id',true);
		}
		$alkes_name			= $this->CI->input->post('alkes_name',true);
		$alkes_price		= $this->CI->input->post('alkes_price',true);
		$alkes_margin		= $this->CI->input->post('alkes_margin',true);
		$alkes_kemasan		= $this->CI->input->post('alkes_kemasan',true);
		$alkes_barcode		= $this->CI->input->post('alkes_barcode',true);
		$alkes_price_sale	= $this->CI->input->post('alkes_price_sale',true);
		$alkes_lokasi		= $this->CI->input->post('alkes_lokasi',true);
		$alkes_rak			= $this->CI->input->post('alkes_rak',true);
		$alkes_type			= $this->CI->input->post('alkes_type',true);

		if ($id) {
			$dataArr=[
				'alkes_id'			=> $alkes_id,
				'alkes_name'		=> $alkes_name,
				'alkes_price'		=> $alkes_price,
				'alkes_margin'		=> $alkes_margin,
				'alkes_kemasan'		=> $alkes_kemasan,
				'alkes_barcode'		=> $alkes_barcode,
				'alkes_price_sale'	=> $alkes_price_sale,
				'alkes_lokasi'		=> $alkes_lokasi,
				'alkes_rak'			=> $alkes_rak,
				'alkes_type'		=> $alkes_type,
			];
			$this->CI->db->update('data_alkes', $dataArr, ['alkes_id'=>$alkes_id]);
		} else {
			$dataArr=[
				'alkes_name'		=> $alkes_name,
				'alkes_price'		=> $alkes_price,
				'alkes_margin'		=> $alkes_margin,
				'alkes_kemasan'		=> $alkes_kemasan,
				'alkes_barcode'		=> $alkes_barcode,
				'alkes_price_sale'	=> $alkes_price_sale,
				'alkes_lokasi'		=> $alkes_lokasi,
				'alkes_rak'			=> $alkes_rak,
				'alkes_type'		=> $alkes_type,
			];
			$this->CI->db->insert('data_alkes', $dataArr);
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
                     'field'   => "alkes_id",
                     'label'   => 'ID',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "alkes_name",
                     'label'   => 'Nama Alkes',
                     'rules'   => 'trim|required|max_length[200]|is_unique_edit_custom[data_alkes.alkes_name.alkes_id.'.$_POST['alkes_id'].']'
                ],
			];
		} else {
			$custom_validation = [
				[
						'field'   => "alkes_name",
						'label'   => 'Nama Alkes',
						'rules'   => 'trim|required|max_length[200]|is_unique[data_alkes.alkes_name]'
				],
			];
		}
		
		$validation = [
			[
				 'field'   => "alkes_barcode",
				 'label'   => 'Barcode',
				 'rules'   => 'trim|required'
			],
			[
				 'field'   => "alkes_kemasan",
				 'label'   => 'Kemasan',
				 'rules'   => 'trim|required'
			],
			[
				 'field'   => "alkes_price",
				 'label'   => 'Harga Modal',
				 'rules'   => 'trim|required',
			],
			[
				 'field'   => "alkes_margin",
				 'label'   => 'Margin',
				 'rules'   => 'trim|required',
			],
			[
				 'field'   => "alkes_price_sale",
				 'label'   => 'Harga Setelah Margin',
				 'rules'   => 'trim|required'
			],
			[
				 'field'   => "alkes_type",
				 'label'   => 'Alkes Tipe',
				 'rules'   => 'trim|required'
			],
		];
		
		$this->CI->form_validation->set_rules(array_merge($custom_validation, $validation));
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
        
        $params['table'] = 'data_alkes';
        $params['select'] = "data_alkes.*";
        $where='is_delete=0';
         
        if(trim($this->CI->input->get('alkes_name'))!='')
        {
            $where.=' AND alkes_name LIKE "%'.$this->CI->input->get('alkes_name').'%"';
        } 
        if(trim($this->CI->input->get('alkes_id'))!='')
        {
            $where.=' AND alkes_id = "'.$this->CI->input->get('alkes_id').'"';
        }
         
        $params['where'] =$where;
        $params['order_by'] = "alkes_id DESC";

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