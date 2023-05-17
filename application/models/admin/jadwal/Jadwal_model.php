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
class Jadwal_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
	
	function stored($id=false)
	{
		if ($id) {$jadwal_id=$this->CI->input->post('jadwal_id',true);}
		$jadwal_date=$this->CI->input->post('jadwal_date',true);
		$jadwal_poli=($this->CI->input->post('jadwal_poli',true));
		$jadwal_shift_id=intval($this->CI->input->post('jadwal_shift_id',true));
		$jadwal_dokter_id=intval($this->CI->input->post('jadwal_dokter_id',true));
		$jadwal_perawat_id=intval($this->CI->input->post('jadwal_perawat_id',true));
		$jadwal_shift_name=$this->CI->common_lib->select_one('shift_name','data_shift','shift_id="'.intval($jadwal_shift_id).'"');
		$jadwal_dokter_name=$this->CI->common_lib->select_one('user_karyawan','data_user','user_id="'.intval($jadwal_dokter_id).'"');
		$jadwal_perawat_name=$this->CI->common_lib->select_one('user_karyawan','data_user','user_id="'.intval($jadwal_perawat_id).'"');

		$dataArr=[
			'jadwal_date'=>date('Y-m-d',strtotime($jadwal_date)),
			'jadwal_poli'=>$jadwal_poli,
			'jadwal_shift_id'=>$jadwal_shift_id,
			'jadwal_shift_name'=>$jadwal_shift_name,
			'jadwal_dokter_id'=>$jadwal_dokter_id,
			'jadwal_dokter_name'=>$jadwal_dokter_name,
			'jadwal_perawat_id'=>$jadwal_perawat_id,
			'jadwal_perawat_name'=>$jadwal_perawat_name,
		];
		if ($id) {
			$this->CI->db->update('data_jadwal', $dataArr, ['jadwal_id'=>$jadwal_id]);
		} else {
			$this->CI->db->insert('data_jadwal', $dataArr);
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
			$validation = [
                [
                     'field'   => "jadwal_date",
                     'label'   => 'Tanggal',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "jadwal_poli",
                     'label'   => 'Poli',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "jadwal_shift_id",
                     'label'   => 'Shift',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "jadwal_dokter_id",
                     'label'   => 'Dokter',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "jadwal_perawat_id",
                     'label'   => 'Perawat',
                     'rules'   => 'trim|required'
                ],
			];
		} else {
			$validation = [
                [
                     'field'   => "jadwal_date",
                     'label'   => 'Tanggal',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "jadwal_poli",
                     'label'   => 'Poli',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "jadwal_shift_id",
                     'label'   => 'Shift',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "jadwal_dokter_id",
                     'label'   => 'Dokter',
                     'rules'   => 'trim|required'
                ],
                [
                     'field'   => "jadwal_perawat_id",
                     'label'   => 'Perawat',
                     'rules'   => 'trim|required'
                ],
			];
		}
		
		$this->CI->form_validation->set_rules(array_merge($validation));
		if ($this->CI->form_validation->run() == TRUE)
		{
			$data['status']=200;
			$data['message']="Ok.";
			
			$jadwal_date=$this->CI->input->post('jadwal_date',true);
			$jadwal_shift_id=$this->CI->input->post('jadwal_shift_id',true);
			$jadwal_poli=$this->CI->input->post('jadwal_poli',true);
			$exist=$this->CI->common_lib->select_one('count(*)','data_jadwal','jadwal_poli="'.$jadwal_poli.'" AND jadwal_date="'.$jadwal_date.'" AND jadwal_shift_id="'.$jadwal_shift_id.'" AND jadwal_id<>'.intval($id).'');
			if(intval($exist)>0)
			{				
				$data['status']=500;
				$data['message']="Jadwal dengan tanggal dan shift tersebut sudah pernah diinput.";
			}
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
        
        $params['table'] = 'data_jadwal';
        $params['select'] = "data_jadwal.*";
        $where='1';
         
        if(trim($this->CI->input->get('keyword'))!='')
        {
            $where.=' AND (jadwal_dokter_name LIKE "%'.$this->CI->input->get('keyword').'%" OR jadwal_perawat_name LIKE "%'.$this->CI->input->get('keyword').'%" OR jadwal_poli LIKE "%'.$this->CI->input->get('keyword').'%")';
        } 
        if(trim($this->CI->input->get('start_date'))!='')
        {
            $where.=' AND jadwal_date >= "'.$this->CI->input->get('start_date').'"';
        }
        if(trim($this->CI->input->get('end_date'))!='')
        {
            $where.=' AND jadwal_date <= "'.$this->CI->input->get('end_date').'"';
        }
        if(trim($this->CI->input->get('jadwal_shift_id'))!='')
        {
            $where.=' AND jadwal_date = "'.$this->CI->input->get('jadwal_shift_id').'"';
        }
        if(trim($this->CI->input->get('jadwal_id'))!='')
        {
            $where.=' AND jadwal_id = "'.$this->CI->input->get('jadwal_id').'"';
        }
         
        $params['where'] =$where;

        // $params['join'] = "LEFT JOIN data_role on data_role.role_id=data_jadwal.role_id";
        $params['order_by'] = "jadwal_date DESC";

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