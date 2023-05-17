<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_model.php';
class registration_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
    
	function send_to_pemeriksaan()
	{
		$pendaftaran_id=$this->CI->input->post('pendaftaran_id',true);
		
		$datetime=date('Y-m-d H:i:s');
		$dataArr=array(
			'pendaftaran_status'=>'pemeriksaan',
		);
		$this->CI->db->update('trx_pendaftaran',$dataArr,array('pendaftaran_id'=>$pendaftaran_id));
		
		$pendaftaran_pasien_id=$this->CI->common_lib->select_one('pendaftaran_pasien_id','trx_pendaftaran','pendaftaran_id>="'.intval($pendaftaran_id).'"');
		$exist=$this->CI->common_lib->select_one('pemeriksaan_id','trx_pemeriksaan','pemeriksaan_pendaftaran_id>="'.intval($pendaftaran_id).'"');
		$admin_user_id=common_lib::admin_user_id();
		$currentShift = common_lib::currenShift(); 
		$currenShiftName = common_lib::currenShiftName(); 
		$data_pemeriksaan=array(
			'pemeriksaan_status'=>'Belum Diperiksa',
			'pemeriksaan_date'=>$datetime,
			'pemeriksaan_pendaftaran_id'=>$pendaftaran_id,
			'pemeriksaan_pasien_id'=>$pendaftaran_pasien_id,
		);
		if(intval($exist)<=0)
		{
			$data_pemeriksaan['pemeriksaan_shift_id']=$currentShift;
			$data_pemeriksaan['pemeriksaan_shift_name']=$currenShiftName;
			$data_pemeriksaan['pemeriksaan_insert_date']=$datetime;
			$data_pemeriksaan['pemeriksaan_insert_by']=$admin_user_id;
			$this->CI->db->insert('trx_pemeriksaan',$data_pemeriksaan);
		}
		else
		{
			$data_pemeriksaan['pemeriksaan_update_date']=$datetime;
			$data_pemeriksaan['pemeriksaan_update_by']=$admin_user_id;
			$this->CI->db->update('trx_pemeriksaan',$data_pemeriksaan,array('pemeriksaan_pendaftaran_id='=>$pendaftaran_id));			
		}
		
		return array(
			'status'=>200,
			'message'=>'Data Sukses dikirim ke pemeriksaan.',
		);
	}
	 
	function action_is_status()
	{
		$pendaftaran_id=$this->CI->input->post('pendaftaran_id',true);
		$pendaftaran_status=$this->CI->input->post('pendaftaran_status',true);
		$dataArr=array(
			'pendaftaran_status'=>$pendaftaran_status,
		);
		$this->CI->db->update('trx_pendaftaran',$dataArr,array('pendaftaran_id'=>$pendaftaran_id));
		
		return array(
			'status'=>200,
			'message'=>'Data Sukses diubah',
		);
	}
	 
	function get_role_by_api()
	{
		$role_arr=file_get_contents(site_url('api/execute/get_data_role_result'));
		$role_arr=json_decode($role_arr,true);
        return $role_arr; 
	}
	
	
	function delete_semu($id)
	{
		$this->CI->db->query('UPDATE `trx_pendaftaran` SET  `pendaftaran_is_delete`=1
			where `pendaftaran_id`='.intval($id).'');
	}
	
	function pendaftaran_no()
	{
		$first='';
		$digit=3;
		$inc=1;
		$exist=$this->CI->common_lib->select_one('pendaftaran_no','trx_pendaftaran','pendaftaran_date>="'.date('Y-m-d 00:00:00').'" order by pendaftaran_id DESC');
		$last_code = intval($exist);
		
		$incpad = (intval($last_code)<=0)?str_pad($inc, $digit, '0', STR_PAD_LEFT):str_pad(($last_code+1), $digit, '0', STR_PAD_LEFT);  
		return $first.$incpad; 
	}
	
	
	function generate_pasien_rm_number()
	{
		$first='RM';
		$digit=6;
		$inc=1;
		$exist=$this->CI->common_lib->select_one('pasien_rm','data_pasien','1 order by pasien_id DESC');
		
		$arr=explode($first,$exist);
		$exist=end($arr);
		$last_code = intval($exist);
		$incpad = (intval($last_code)<=0)?str_pad($inc, $digit, '0', STR_PAD_LEFT):str_pad(($last_code+1), $digit, '0', STR_PAD_LEFT);  
		
		return $first.$incpad; 
	}
	
	
	function store_form($id=0)
	{
		$pendaftaran_pasien_id=$this->CI->input->post('pendaftaran_pasien_id',true);
		$pendaftaran_penjamin_id=$this->CI->input->post('pendaftaran_penjamin_id',true);
		$pasien_penjamin_name=$this->CI->common_lib->select_one('penjamin_name','data_penjamin','penjamin_id='.intval($pendaftaran_penjamin_id));
		$pendaftaran_no=$this->pendaftaran_no();
		$pasien_rm_number=$this->generate_pasien_rm_number();
		$data_pasien=array(
			'pasien_birthdate'=>common_lib::convertdate('Y-m-d',$this->CI->input->post('pendaftaran_birthdate',true)),
			'pasien_rm'=>$pasien_rm_number,
			'pasien_name'=>$this->CI->input->post('pendaftaran_pasien_name',true),
			'pasien_nik'=>$this->CI->input->post('pendaftaran_pasien_nik',true),
			'pasien_penjamin_id'=>$this->CI->input->post('pendaftaran_penjamin_id',true),
			'pasien_penjamin_name'=>$pasien_penjamin_name,
			'pasien_penjamin_no'=>$this->CI->input->post('pendaftaran_penjamin_no',true),
			'pasien_ibu'=>$this->CI->input->post('pendaftaran_pasien_ibu',true),
			'pasien_address'=>$this->CI->input->post('pendaftaran_pasien_address',true),
			'pasien_gender'=>$this->CI->input->post('pendaftaran_pasien_gender',true),
			'pasien_birthplace'=>$this->CI->input->post('pendaftaran_pasien_birthplace',true),
			'pasien_birthdate'=>date('Y-m-d',strtotime($this->CI->input->post('pendaftaran_pasien_birthdate'))),
			'pasien_pernikahan'=>$this->CI->input->post('pendaftaran_pasien_pernikahan',true),
		);
		if(intval($pendaftaran_pasien_id)==0)
		{
			$this->CI->db->insert('data_pasien',$data_pasien);
			$pasien_id=$this->CI->db->insert_id();
		}
		else
		{
			unset($data_pasien['pasien_rm']);
			$this->CI->db->update('data_pasien',$data_pasien,array('pasien_id'=>$pendaftaran_pasien_id));
			$pasien_id=$pendaftaran_pasien_id;
		}
		
		
		$data_form=array(
			'pendaftaran_no'=>$pendaftaran_no,
			'pendaftaran_pasien_id'=>$pasien_id,
			'pendaftaran_pasien_rm'=>$pasien_rm_number,
			'pendaftaran_date'=>date('Y-m-d H:i:s'),
			'pendaftaran_pasien_name'=>$this->CI->input->post('pendaftaran_pasien_name'),
			'pendaftaran_pasien_nik'=>$this->CI->input->post('pendaftaran_pasien_nik'),
			'pendaftaran_pasien_ibu'=>$this->CI->input->post('pendaftaran_pasien_ibu'),
			'pendaftaran_pasien_address'=>$this->CI->input->post('pendaftaran_pasien_address'),
			'pendaftaran_pasien_gender'=>$this->CI->input->post('pendaftaran_pasien_gender'),
			'pendaftaran_pasien_birthplace'=>$this->CI->input->post('pendaftaran_pasien_birthplace'),
			'pendaftaran_pasien_birthdate'=>date('Y-m-d',strtotime($this->CI->input->post('pendaftaran_pasien_birthdate'))),
			'pendaftaran_pasien_pernikahan'=>$this->CI->input->post('pendaftaran_pasien_pernikahan'),
			'pendaftaran_penjamin_id'=>intval($this->CI->input->post('pendaftaran_penjamin_id')),
			'pendaftaran_penjamin_nama'=>$pasien_penjamin_name,
			'pendaftaran_penjamin_no'=>$this->CI->input->post('pendaftaran_penjamin_no'),
			'pendaftaran_pasien_penanggung_jawab_pekerjaan'=>$this->CI->input->post('pendaftaran_pasien_penanggung_jawab_pekerjaan'),
			'pendaftaran_pasien_penanggung_jawab_telp'=>$this->CI->input->post('pendaftaran_pasien_penanggung_jawab_telp'),
			'pendaftaran_pasien_penanggung_jawab_name'=>$this->CI->input->post('pendaftaran_pasien_penanggung_jawab_name'),
			'pendaftaran_status'=>'pendaftaran',
		);
		if(intval($id)==0)
		{
			$this->CI->db->insert('trx_pendaftaran',$data_form);
			$pendaftaran_layanan_pendaftaran_id=$this->CI->db->insert_id();
			$message='Pendaftaran Berhasil disimpan.';
		}
		else
		{
			unset($data_form['pendaftaran_no']);
			unset($data_form['pendaftaran_date']);
			unset($data_form['pendaftaran_pasien_rm']);
			$this->CI->db->update('trx_pendaftaran',$data_form,['pendaftaran_id'=>$id]);
			$pendaftaran_layanan_pendaftaran_id=$id;
			$message='Pendaftaran Berhasil diubah.';
		}
		
		$pendaftaran_layanan_pemeriksaan_id=$this->CI->input->post('pendaftaran_layanan_pemeriksaan_id');
		$pendaftaran_layanan_dokter_id=$this->CI->input->post('pendaftaran_layanan_dokter_id');
		$pendaftaran_layanan_perawat_id=$this->CI->input->post('pendaftaran_layanan_perawat_id');
		$pendaftaran_layanan_layanan_name=$this->CI->input->post('pendaftaran_layanan_layanan_name');
		$pendaftaran_layanan_dokter_name=$this->CI->input->post('pendaftaran_layanan_dokter_name');
		$pendaftaran_layanan_perawat_name=$this->CI->input->post('pendaftaran_layanan_perawat_name');
		$pendaftaran_layanan_pemeriksaan_name=$this->CI->input->post('pendaftaran_layanan_pemeriksaan_name');
		$this->CI->db->query('DELETE FROM `trx_pendaftaran_layanan` WHERE `pendaftaran_layanan_pendaftaran_id`='.intval($pendaftaran_layanan_pendaftaran_id).'');
		foreach($pendaftaran_layanan_pemeriksaan_id as $index=>$value)
		{
			$data_layanan=array(
				'pendaftaran_layanan_pendaftaran_id'=>intval($pendaftaran_layanan_pendaftaran_id),
				'pendaftaran_layanan_layanan_id'=>0,
				'pendaftaran_layanan_layanan_name'=>(isset($pendaftaran_layanan_layanan_name[$index])?$pendaftaran_layanan_layanan_name[$index]:'-'),
				'pendaftaran_layanan_dokter_id'=>(isset($pendaftaran_layanan_dokter_id[$index])?$pendaftaran_layanan_dokter_id[$index]:0),
				'pendaftaran_layanan_dokter_name'=>(isset($pendaftaran_layanan_dokter_name[$index])?$pendaftaran_layanan_dokter_name[$index]:'-'),
				'pendaftaran_layanan_perawat_id'=>(isset($pendaftaran_layanan_perawat_id[$index])?$pendaftaran_layanan_perawat_id[$index]:0),
				'pendaftaran_layanan_perawat_name'=>(isset($pendaftaran_layanan_perawat_name[$index])?$pendaftaran_layanan_perawat_name[$index]:'-'),
				'pendaftaran_layanan_pemeriksaan_id'=>(isset($pendaftaran_layanan_pemeriksaan_id[$index])?$pendaftaran_layanan_pemeriksaan_id[$index]:'-'),
				'pendaftaran_layanan_pemeriksaan_name'=>(isset($pendaftaran_layanan_pemeriksaan_name[$index])?$pendaftaran_layanan_pemeriksaan_name[$index]:'-'),
			);
			$this->CI->db->insert('trx_pendaftaran_layanan',$data_layanan);
		}
		
		
		return array(
			'status'=>200,
			'message'=>$message,
		);
	}
	
	function validate_form_edit()
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array(
                array(
                     'field'   => "pendaftaran_pasien_name",
                     'label'   => 'Nama',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_nik",
                     'label'   => 'NIK',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_ibu",
                     'label'   => 'Ibu',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_address",
                     'label'   => 'Alamat',
                     'rules'   => 'trim|required'
                ),   
                array(
                     'field'   => "pendaftaran_pasien_gender",
                     'label'   => 'Jenis Kelamin',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_birthplace",
                     'label'   => 'Tempat Lahir',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_birthdate",
                     'label'   => 'Tanggal Lahir',
                     'rules'   => 'trim|required'
                ),   
                array(
                     'field'   => "pendaftaran_pasien_pernikahan",
                     'label'   => 'Status Perkawinan',
                     'rules'   => 'trim|required'
                ),    
                array(
                     'field'   => "pendaftaran_pasien_penanggung_jawab_pekerjaan",
                     'label'   => 'Pekerjaan Penanggung Jawab',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_penanggung_jawab_telp",
                     'label'   => 'No Telp Penanggung Jawab',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_penanggung_jawab_name",
                     'label'   => 'Nama Penanggung Jawab',
                     'rules'   => 'trim|required'
                ),  
			);
			 
			$custom_validation=array();
			$this->CI->form_validation->set_rules(array_merge($validation,$custom_validation));

			if ($this->CI->form_validation->run() == TRUE)
			{
				
				$status=200;
				$message="Terjadi kesalahan, silahkan ulangi kembali.";
			}
			else
			{
				$status=500;
				$message=validation_errors(); 
				return array(
					'status'=>$status,
					'message'=>$message,
				);
			}
          
          return array(
              'status'=>$status,
              'message'=>$message,
          );
         

    }
	
	function validate_form()
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array(
                array(
                     'field'   => "pendaftaran_pasien_name",
                     'label'   => 'Nama',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_nik",
                     'label'   => 'NIK',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_ibu",
                     'label'   => 'Ibu',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_address",
                     'label'   => 'Alamat',
                     'rules'   => 'trim|required'
                ),   
                array(
                     'field'   => "pendaftaran_pasien_gender",
                     'label'   => 'Jenis Kelamin',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_birthplace",
                     'label'   => 'Tempat Lahir',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_birthdate",
                     'label'   => 'Tanggal Lahir',
                     'rules'   => 'trim|required'
                ),   
                array(
                     'field'   => "pendaftaran_pasien_pernikahan",
                     'label'   => 'Status Perkawinan',
                     'rules'   => 'trim|required'
                ),    
                array(
                     'field'   => "pendaftaran_pasien_penanggung_jawab_pekerjaan",
                     'label'   => 'Pekerjaan Penanggung Jawab',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_penanggung_jawab_telp",
                     'label'   => 'No Telp Penanggung Jawab',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pendaftaran_pasien_penanggung_jawab_name",
                     'label'   => 'Nama Penanggung Jawab',
                     'rules'   => 'trim|required'
                ),  
			);
			
			$custom_validation=array();
			$this->CI->form_validation->set_rules(array_merge($validation,$custom_validation));

			if ($this->CI->form_validation->run() == TRUE)
			{
				
				$status=200;
				$message="Ok.";
			}
			else
			{
				$status=500;
				$message=validation_errors(); 
				return array(
					'status'=>$status,
					'message'=>$message,
				);
			}
          
          return array(
              'status'=>$status,
              'message'=>$message,
          );
         

    }
	
	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'trx_pendaftaran';
        $params['select'] = "trx_pendaftaran.*";
        $where='1 AND pendaftaran_is_delete=0 AND pendaftaran_pasien_id>0';
         
        if(trim($this->CI->input->get('search'))!='')
        {
            $where.=' AND (pendaftaran_pasien_name LIKE "%'.$this->CI->input->get('search').'%" OR pendaftaran_pasien_rm LIKE "%'.$this->CI->input->get('search').'%" OR pendaftaran_no LIKE "%'.$this->CI->input->get('search').'%" OR pendaftaran_status LIKE "%'.$this->CI->input->get('search').'%" )';
        } 
        if(trim($this->CI->input->get('pendaftaran_id'))!='')
        {
            $where.=' AND pendaftaran_id = "'.$this->CI->input->get('pendaftaran_id').'"';
        } 
        if(trim($this->CI->input->get('date_start'))!='')
        {
			$date_start=date('Y-m-d',strtotime($this->CI->input->get('date_start')));
            $where.=' AND pendaftaran_date >= "'.$date_start.' 00:00:00"';
        }
        if(trim($this->CI->input->get('date_end'))!='')
        {
			$date_end=date('Y-m-d',strtotime($this->CI->input->get('date_end')));
            $where.=' AND pendaftaran_date <= "'.$date_end.' 23:59:59"';
        } 
         
        $params['where'] =$where;
        $params['order_by'] = "pendaftaran_id DESC";

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
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */