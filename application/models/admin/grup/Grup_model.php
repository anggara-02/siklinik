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
class grup_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
    }
    
	function store_akses($type="administrator",$id)
	{
		$akses=($type=="administrator")?'0~0~0~0':'1~1~1~1'; 
		$data_form=array(
			'role_id'=>$id, 
			'akses_setting_menu'=>$akses, 
			'access_pendaftaran'=>$akses, 
			'access_pemeriksaan'=>$akses, 
			'access_pasien'=>$akses, 
			'akses_setting_grup'=>$akses.($type=="superuser"?'~1':'~0'), 
			'akses_setting_user'=>$akses, 
			'akses_setting_config'=>$akses, 
			'akses_setting_pegawai'=>$akses, 
			'akses_setting_tindakan'=>$akses, 
			'akses_setting_produk'=>$akses, 
			'akses_setting_paket'=>$akses, 
			'akses_setting_supplier'=>$akses, 
			'access_spending'=>$akses, 
			'access_buy'=>$akses, 
			'access_pos'=>$akses, 
			'access_pos_verifikator'=>$akses, 
			'access_piutang'=>$akses, 
			'akses_report_buy'=>$akses, 
			'akses_report_penjualan'=>$akses, 
			'akses_report_stock'=>$akses, 
			'akses_report_daily'=>$akses, 
			'akses_report_komisi'=>$akses, 
			'akses_setting_shift'=>$akses, 
			'akses_setting_kasir'=>$akses, 
			'akses_report_pos'=>$akses, 
			'access_penjualan'=>$akses, 
		);
		$exist=$this->CI->common_lib->select_one('role_id','setting_akses','role_id='.intval($id));
		if(intval($exist)>0)
		{
			$result=$this->CI->common_lib->store_form('setting_akses',$data_form,array('role_id'=>intval($id)));
		}
		else
		{
			$result=$this->CI->common_lib->store_form('setting_akses',$data_form);			
		}
	}
	
	function store_form($id=0,$key)
	{
		$role_name=trim($this->CI->security->sanitize_filename($this->CI->input->post('role_name',true)));
		$role_keterangan=trim($this->CI->security->sanitize_filename($this->CI->input->post('role_keterangan',true))); 
		
		$_SESSION['temp_for_action']=$key; 
		//data master
		$current="akses_setting_shift";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_setting_menu";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_setting_user";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_setting_pegawai";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_setting_produk";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_setting_tindakan";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_setting_paket";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_setting_supplier";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_setting_kasir";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="access_pos_verifikator";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		
		//transaksi
		$current="access_spending";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="access_buy";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="access_pos";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="access_pendaftaran";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="access_pemeriksaan";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="access_piutang";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_report_pos";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="access_penjualan";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		
		//laporan
		$current="access_pasien";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_report_buy";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_report_penjualan";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_report_stock";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_report_daily";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		$current="akses_report_komisi";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		
		//config
		$current="akses_setting_grup";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0').'~'.(isset($_POST[$current.'_access'])?$_POST[$current.'_access']:'0');
		$current="akses_setting_config";
		${$current}=(isset($_POST[$current.'_view'])?$_POST[$current.'_view']:'0').'~'.(isset($_POST[$current.'_add'])?$_POST[$current.'_add']:'0').'~'.(isset($_POST[$current.'_edit'])?$_POST[$current.'_edit']:'0').'~'.(isset($_POST[$current.'_delete'])?$_POST[$current.'_delete']:'0');
		
		$data_form=array(
			'akses_setting_pegawai'=>$akses_setting_pegawai, 
			'akses_setting_produk'=>$akses_setting_produk, 
			'akses_setting_tindakan'=>$akses_setting_tindakan, 
			'akses_setting_paket'=>$akses_setting_paket, 
			'akses_setting_supplier'=>$akses_setting_supplier, 
			'access_spending'=>$access_spending, 
			'access_buy'=>$access_buy, 
			'access_pos'=>$access_pos, 
			'access_pos_verifikator'=>$access_pos_verifikator, 
			'access_piutang'=>$access_piutang, 
			'access_pendaftaran'=>$access_pendaftaran, 
			'access_pemeriksaan'=>$access_pemeriksaan, 
			'access_pasien'=>$access_pasien, 
			'akses_setting_grup'=>$akses_setting_grup, 
			'akses_setting_user'=>$akses_setting_user, 
			'akses_setting_config'=>$akses_setting_config, 
			'akses_report_stock'=>$akses_report_stock, 
			'akses_report_penjualan'=>$akses_report_penjualan, 
			'akses_report_buy'=>$akses_report_buy, 
			'akses_report_daily'=>$akses_report_daily, 
			'akses_report_komisi'=>$akses_report_komisi, 
			
			'akses_setting_menu'=>$akses_setting_menu, 
			'akses_setting_shift'=>$akses_setting_shift, 
			'akses_setting_kasir'=>$akses_setting_kasir, 
			'akses_report_pos'=>$akses_report_pos, 
			'access_penjualan'=>$access_penjualan, 
		);
		$_SESSION['temp_for_action']=$key;
		$result=$this->CI->common_lib->store_form('setting_akses',$data_form,array('role_id'=>intval($id)));
		$status=200;
		$message="Perubahan sukses dilakukan.";
		return array(
			'status'=>$status,
			'message'=>$message,
		);
	}
	function validate_form_edit()
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array( 
                array(
                     'field'   => "role_name",
                     'label'   => 'Nama Grup',
                     'rules'   => 'trim|required|max_length[100]|is_unique_edit_custom[data_role.role_name.role_id.'.$_POST['role_id'].']'
                ), 
                array(
                     'field'   => "role_type",
                     'label'   => 'Tipe Grup',
                     'rules'   => 'trim|required'
                ), 
                array(
                     'field'   => "role_keterangan",
                     'label'   => 'Keterangan',
                     'rules'   => 'trim|max_length[255]'
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
	
	function validate_form()
	{ 
		$status=500;
		$message="Terjadi kesalahan, silahkan ulangi kembali.";
		
            $validation = array(
                array(
                     'field'   => "role_name",
                     'label'   => 'Nama Grup',
                     'rules'   => 'trim|required|max_length[100]|is_unique[data_role.role_name]'
                ), 
                array(
                     'field'   => "role_type",
                     'label'   => 'Tipe Grup',
                     'rules'   => 'trim|required'
                ), 
                array(
                     'field'   => "role_keterangan",
                     'label'   => 'Keterangan',
                     'rules'   => 'trim|max_length[255]'
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
	
	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $role_name=$this->CI->input->get('role_name'); 
        $params['table'] = 'data_role';
        $params['select'] = "*";
        $where='1 and is_delete=0';
         
        if(trim($role_name)!='')
        {
            $where.=' AND role_name LIKE "%'.$role_name.'%"';
        } 
         
        $params['where'] =$where;

        $params['order_by'] = "role_id DESC";

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