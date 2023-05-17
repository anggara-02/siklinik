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
class Pasien_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
		$this->CI->load->model('admin/registration/registration_model'); 
		$this->registration_model=new registration_model();
    }
	
	function klinik_stored($id=0)
	{		
		$pasien_id=$this->CI->input->post('pasien_id',true);
		$pasien_name=$this->CI->input->post('pasien_name',true);
		$pasien_rm=($this->CI->input->post('pasien_rm',true));
		$pasien_nik=($this->CI->input->post('pasien_nik',true));
		$pasien_penjamin_id=intval($this->CI->input->post('pasien_penjamin_id',true));
		$pasien_penjamin_name=$this->CI->common_lib->select_one('penjamin_name','data_penjamin','penjamin_id="'.intval($pasien_penjamin_id).'"');
		// $pasien_penjamin_name=($this->CI->input->post('pasien_penjamin_name',true));
		$pasien_penjamin_no=($this->CI->input->post('pasien_penjamin_no',true));
		$pasien_ibu=($this->CI->input->post('pasien_ibu',true));
		$pasien_address=($this->CI->input->post('pasien_address',true));
		$pasien_gender=($this->CI->input->post('pasien_gender',true));
		$pasien_birthplace=($this->CI->input->post('pasien_birthplace',true));
		$pasien_birthdate=($this->CI->input->post('pasien_birthdate',true));
		$pasien_pernikahan=($this->CI->input->post('pasien_pernikahan',true));

		$dataArr=[
			'pasien_birthdate'=>date('Y-m-d',strtotime($pasien_birthdate)),
			'pasien_name'=>$pasien_name,
			// 'pasien_rm'=>$pasien_rm,
			'pasien_nik'=>$pasien_nik,
			'pasien_penjamin_id'=>$pasien_penjamin_id,
			'pasien_penjamin_name'=>$pasien_penjamin_name,
			'pasien_penjamin_no'=>$pasien_penjamin_no,
			'pasien_ibu'=>$pasien_ibu,
			'pasien_address'=>$pasien_address,
			'pasien_gender'=>$pasien_gender,
			'pasien_birthplace'=>$pasien_birthplace,
			'pasien_pernikahan'=>$pasien_pernikahan,
		];
		if (intval($pasien_id)>0) {
			$this->CI->db->update('data_pasien', $dataArr, ['pasien_id'=>$pasien_id]);
		} 
		
		
		return [
			'status'=>200,
			'message'=>'Data Sukses disimpan',
		];
	}
	
	function klinik_validate_form($id=0)
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali."; 
		$validation = [
			[
				 'field'   => "pasien_name",
				 'label'   => 'Nama',
				 'rules'   => 'trim|required'
			],
			[
				 'field'   => "pasien_nik",
				 'label'   => 'NIK',
				 'rules'   => 'trim|required'
			], 
		];
	
		
		$this->CI->form_validation->set_rules(array_merge($validation));
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
	
	function get_data_klinik()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'data_pasien';
        $params['select'] = "data_pasien.*";
        $where='1';
         
        if(trim($this->CI->input->get('keyword'))!='')
        {
            $where.=' AND (pasien_name LIKE "%'.$this->CI->input->get('keyword').'%" OR pasien_rm LIKE "%'.$this->CI->input->get('keyword').'%" OR pasien_nik LIKE "%'.$this->CI->input->get('keyword').'%" OR pasien_penjamin_no LIKE "%'.$this->CI->input->get('keyword').'%")';
        }  
		
        $params['where'] =$where;

        // $params['join'] = "LEFT JOIN data_role on data_role.role_id=data_jadwal.role_id";
        $params['order_by'] = "pasien_id DESC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query,
			'total'=>$total,
		);
	}

	function apotek_stored($id=0)
	{		
		$pendaftaran_id=$this->CI->input->post('pendaftaran_id',true);
		$pendaftaranArr = $this->CI->common_lib->select_row('trx_pendaftaran','pendaftaran_id='.intval($pendaftaran_id).''); 
		
		$pasien_name=$this->CI->input->post('pasien_name',true);
		$pasien_membership_id=$this->CI->input->post('pasien_membership_id',true);
		$pasien_address=($this->CI->input->post('pasien_address',true));
		$pasien_birthdate=($this->CI->input->post('pasien_birthdate',true));
		$pendaftaran_pasien_penanggung_jawab_telp=($this->CI->input->post('pendaftaran_pasien_penanggung_jawab_telp',true));

		$currentShift = common_lib::currenShift(); 
		$currenShiftName = common_lib::currenShiftName(); 
		$dataArr=[
			'pendaftaran_pasien_pernikahan'=>intval($pasien_birthdate),
			'pendaftaran_pasien_name'=>$pasien_name,
			'pendaftaran_pasien_address'=>$pasien_address,
			'pendaftaran_membership_id'=>$pasien_membership_id,
			'pendaftaran_pasien_penanggung_jawab_telp'=>$pendaftaran_pasien_penanggung_jawab_telp,
		];
		if (intval($pendaftaran_id)>0) {
			$this->CI->db->update('trx_pendaftaran', $dataArr, 
			[
				'pendaftaran_pasien_name'=>$pendaftaranArr['pendaftaran_pasien_name'],
				'pendaftaran_pasien_address'=>$pendaftaranArr['pendaftaran_pasien_address'],
				'pendaftaran_pasien_pernikahan'=>$pendaftaranArr['pendaftaran_pasien_pernikahan'],
				'pendaftaran_pasien_penanggung_jawab_telp'=>$pendaftaranArr['pendaftaran_pasien_penanggung_jawab_telp'],	
			]			
			);
		}
		else
		{
			$dataArr['pendaftaran_date']=date('Y-m-d');
			$dataArr['pendaftaran_no']=$this->registration_model->pendaftaran_no();
			$dataArr['pendaftaran_status']='apotek';
			$this->CI->db->insert('trx_pendaftaran', $dataArr);
		}
		
		
		return [
			'status'=>200,
			'message'=>'Data Sukses disimpan',
		];
	}
	
	function apotek_validate_form($id=0)
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali."; 
		$validation = [
			[
				 'field'   => "pasien_name",
				 'label'   => 'Nama',
				 'rules'   => 'trim|required'
			],
			[
				 'field'   => "pasien_birthdate",
				 'label'   => 'Tanggal Lahir',
				 'rules'   => 'trim|required'
			], 
			[
				 'field'   => "pendaftaran_pasien_penanggung_jawab_telp",
				 'label'   => 'No Telp',
				 'rules'   => 'trim|required'
			], 
			[
				 'field'   => "pasien_address",
				 'label'   => 'Alamat',
				 'rules'   => 'trim|required'
			], 
		];
	
		
		$this->CI->form_validation->set_rules(array_merge($validation));
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
	
	function get_data_apotek()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'trx_pendaftaran';
        $params['select'] = "trx_pendaftaran.*,membership_name";
        $where='1 AND pendaftaran_pasien_id=0';
         
        if(trim($this->CI->input->get('keyword'))!='')
        {
            $where.=' AND (pendaftaran_pasien_name LIKE "%'.$this->CI->input->get('keyword').'%" OR pendaftaran_pasien_penanggung_jawab_telp LIKE "%'.$this->CI->input->get('keyword').'%")';
        }  
		
        $params['where'] =$where;

        $params['join'] = "LEFT JOIN data_membership on pendaftaran_membership_id=id";
        $params['order_by'] = "pendaftaran_id DESC";
        $params['group_by'] = "pendaftaran_pasien_name,pendaftaran_pasien_address,pendaftaran_pasien_penanggung_jawab_telp";

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