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
class Suplier_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
	
	function stored($id=false)
	{
		if ($id) {$supplier_id=$this->CI->input->post('supplier_id',true);}
		$supplier_name=$this->CI->input->post('supplier_name',true);
		$supplier_address=$this->CI->input->post('supplier_address',true);
		$supplier_phone=$this->CI->input->post('supplier_phone',true);
		$supplier_sales_name=$this->CI->input->post('supplier_sales_name',true);
		$supplier_sales_phone=$this->CI->input->post('supplier_sales_phone',true);

		if ($id) {
			$dataArr=[
				'supplier_id'=>$supplier_id,
				'supplier_name'=>$supplier_name,
				'supplier_address'=>$supplier_address,
				'supplier_phone'=>$supplier_phone,
				'supplier_sales_name'=>$supplier_sales_name,
				'supplier_sales_phone'=>$supplier_sales_phone,
			];
			$this->CI->db->update('data_supplier', $dataArr, ['supplier_id'=>$supplier_id]);
		} else {
			$dataArr=[
				'supplier_name'=>$supplier_name,
				'supplier_address'=>$supplier_address,
				'supplier_phone'=>$supplier_phone,
				'supplier_sales_name'=>$supplier_sales_name,
				'supplier_sales_phone'=>$supplier_sales_phone,
			];
			$this->CI->db->insert('data_supplier', $dataArr);
		}
		
		return [
			'status'=>200,
			'message'=>'Data Sukses disimpan',
		];
	}
	
	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'data_supplier';
        $params['select'] = "data_supplier.*";
        $where='1 and is_delete=0';
         
        if(trim($this->CI->input->get('supplier_name'))!='')
        {
            $where.=' AND supplier_name LIKE "%'.$this->CI->input->get('supplier_name').'%"';
        } 
        if(trim($this->CI->input->get('supplier_id'))!='')
        {
            $where.=' AND supplier_id = "'.$this->CI->input->get('supplier_id').'"';
        }
         
        $params['where'] =$where;

        // $params['join'] = "LEFT JOIN data_role on data_role.role_id=data_supplier.role_id";
        $params['order_by'] = "supplier_id DESC";

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