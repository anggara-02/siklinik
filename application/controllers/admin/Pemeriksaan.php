<?php

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/extend/controller_admin.php';
class pemeriksaan extends controller_admin {
	protected $st,$access,$class; 
	
    public function __construct() {
        parent::__construct(); 
		$_model=__class__.'_model';
		$this->load->model($this->module.'/'.__class__.'/'.$_model); 
		$this->mainModel=new $_model();
		$this->access="akses_trx_pemeriksaan";
		$this->class="Pemeriksaan";
    }

    public function index() { 
		redirect(base_url('admin/'.__class__.'/data'));
	}

    public function kasir_index() {  
		
		common_lib::hak_akses($this->access,__function__,'controller'); 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class).' Kasir';
        $st = new Stencil();
        
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
        $common['access'] = $this->access;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	 
	public function kasir_edit($id=0) {  
	
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('trx_pemeriksaan_kasir join trx_pendaftaran on pendaftaran_id=kasir_pendaftaran_id','kasir_id='.intval($id).' AND kasir_status ="Belum Lunas"');
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/apotek?status=500&flag='.base64_encode('Data tidak ditemukan atau sudah lunas.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		$title='Kasir';
        $common['title'] = ucfirst($title.' - '.$this->class);
        $st = new Stencil(); 
		if($this->input->post("submit"))
		{  
			$result=$this->mainModel->store_form_kasir($id);
				// echo $result['status'];exit;
			if($result['status']==200)
			{
				redirect(base_url($this->module.'/'.__class__.'/kasir?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
			}
			$common['status'] = $result['status'];
			$common['message'] = $result['message']; 
		} 
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
		
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $currentShift = common_lib::currenShift(); 
		// $common['obat'] = $this->common_lib->select_result('trx_pemeriksaan_obat','pemeriksaan_obat_pemeriksaan_id='.intval($id).''); 
		$common['trx_obat'] = $this->common_lib->select_result('trx_pemeriksaan_obat_apotek','pemeriksaan_obat_pemeriksaan_id='.$has_exist['kasir_pemeriksaan_id']); 
		$common['layananArr'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.$has_exist['kasir_pendaftaran_id']); 
		$common['layanan_umum'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($has_exist['kasir_pendaftaran_id']).' and lower(pendaftaran_layanan_layanan_name)="umum"');  
		$common['layanan_lab'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($has_exist['kasir_pendaftaran_id']).' and lower(pendaftaran_layanan_layanan_name)="laboratorium"'); 
		$common['data_bank'] = $this->common_lib->select_result('data_bank','is_delete=0'); 
       
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	
    public function get_datatable_kasir() {   
		$result=$this->mainModel->get_data_kasir();
		$query=$result['query'];
		$total=$result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
		 $json_data = array('start' => $start, 'recordsTotal' => ($_POST['length']>0)?$_POST['length']:$total,'recordsFiltered' => $total, 'data' => array());
        $prev_trx = '';
        $no = 0 + $start;
        foreach ($query->result() as $row) {
            
            foreach($row AS $variable=>$value)
            {
                ${$variable}=$value;
            }
        $no++;  $label_confirm="'Yakin hapus data ini?'";
		$action='';
		$action=common_lib::hak_akses($this->access,'edit','menu')=='1'&&($kasir_status=='Belum Lunas')?'<a href="'.base_url('admin/'.__class__.'/kasir/edit/'.$kasir_id.'').'"style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>':'';
        
		// $pemeriksaan_status=(strtolower($pemeriksaan_status)=='belum diperiksa')?'<div class="badge badge-primary">Belum Diperiksa</div>':((strtolower($pemeriksaan_status)=='sudah diperiksa')?'<div class="badge badge-success">Sudah Diperiksa</div>':'<div class="badge badge-warning">Laboratorium</div>');
		$kasir_status=(strtolower($kasir_status)=='belum lunas')?'<div class="badge badge-danger">Belum Lunas</div>':'<div class="badge badge-success">Sudah Lunas</div>';
		$entry = array( 
			'no' =>  $no,
			'action' => $action,
			'kasir_invoice'=>$kasir_invoice, 
			'kasir_status'=>$kasir_status,  
			'kasir_date'=>date('d-m-Y',strtotime($kasir_date)), 
			'pasien_name'=>ucwords($pendaftaran_pasien_name), 
			'kasir_total'=>common_lib::currency_format($kasir_total)
		);
		
        $json_data['data'][] = $entry;
            

        }

        echo json_encode($json_data); 
	}
	 
    public function apotek_index() {  
		
		common_lib::hak_akses($this->access,__function__,'controller'); 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class).' Farmasi';
        $st = new Stencil();
        
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
        $common['access'] = $this->access;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	 
	public function apotek_add($id=0) {  
	
		common_lib::hak_akses($this->access,__function__,'controller'); 
		 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		$title='Farmasi';
        $common['title'] = ucfirst($title.' - '.$this->class);
        $st = new Stencil(); 
		if($this->input->post("submit"))
		{  
			$result=$this->mainModel->store_form_apotek();
				// echo $result['status'];exit;
			if($result['status']==200)
			{
				redirect(base_url($this->module.'/'.__class__.'/apotek?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
			}
			$common['status'] = $result['status'];
			$common['message'] = $result['message']; 
		} 
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
				
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $currentShift = common_lib::currenShift(); 
		// $common['obat'] = $this->common_lib->select_result('trx_pemeriksaan_obat','pemeriksaan_obat_pemeriksaan_id='.intval($id).''); 
		$common['obat'] = array(); 
		
		$common['kemasan_arr'] = $this->common_lib->select_result('data_kemasan','is_delete=0'); 
		$common['trx_resep'] = $this->common_lib->select_result('trx_pemeriksaan_obat_apotek','pemeriksaan_obat_type="resep" AND pemeriksaan_obat_pemeriksaan_id='.$id); 
		$common['trx_non_resep'] = $this->common_lib->select_result('trx_pemeriksaan_obat_apotek','pemeriksaan_obat_type="non_resep" AND pemeriksaan_obat_pemeriksaan_id='.$id); 
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	 
	public function apotek_edit($id=0) {  
	
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('trx_pemeriksaan JOIN trx_pendaftaran on pendaftaran_id=pemeriksaan_pendaftaran_id','pemeriksaan_id='.intval($id).' AND pemeriksaan_status ="apotek"');
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/apotek?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		$title='Farmasi';
        $common['title'] = ucfirst($title.' - '.$this->class);
        $st = new Stencil(); 
		if($this->input->post("submit"))
		{  
			$result=$this->mainModel->store_form_apotek($id);
				// echo $result['status'];exit;
			if($result['status']==200)
			{
				redirect(base_url($this->module.'/'.__class__.'/apotek?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
			}
			$common['status'] = $result['status'];
			$common['message'] = $result['message']; 
		} 
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
		
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $currentShift = common_lib::currenShift(); 
		$common['obat'] = $this->common_lib->select_result('trx_pemeriksaan_obat','pemeriksaan_obat_pemeriksaan_id='.intval($id).''); 
		// $common['layanan_lab'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($has_exist['pemeriksaan_pendaftaran_id']).' and lower(pendaftaran_layanan_layanan_name)="laboratorium"'); 
		$common['kemasan_arr'] = $this->common_lib->select_result('data_kemasan','is_delete=0'); 
		$common['trx_resep'] = $this->common_lib->select_result('trx_pemeriksaan_obat_apotek','pemeriksaan_obat_type="resep" AND pemeriksaan_obat_pemeriksaan_id='.$id); 
		$common['trx_non_resep'] = $this->common_lib->select_result('trx_pemeriksaan_obat_apotek','pemeriksaan_obat_type="non_resep" AND pemeriksaan_obat_pemeriksaan_id='.$id); 
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	
    public function get_kemasan_by_id() { 
		$id=$this->input->post('id');
		$type=$this->input->post('type');
		$result = array();
		if(strtolower($type)=='0')
		{
			$kemasan_id = $this->common_lib->select_one('kemasan_id','data_kemasan','lower(kemasan_name)="pcs"'); 
			$result[]=array(
				'kemasan_id'=>$kemasan_id,
				'kemasan_name'=>'Pcs',
				'konversi'=>1,
			);
		}
		else
		{
			$kemasan_id = $this->common_lib->select_one('obat_kemasan_kecil_id','data_obat','obat_id='.intval($id).''); 
			$kemasan_name = $this->common_lib->select_one('kemasan_name','data_kemasan','kemasan_id='.intval($kemasan_id).''); 
			$konversi = $this->common_lib->select_one('obat_kemasan_kecil_konversi','data_obat','obat_id='.intval($id).''); 
			$result[]=array(
				'kemasan_id'=>$kemasan_id,
				'kemasan_name'=>$kemasan_name,
				'konversi'=>$konversi,
			);
			
			$kemasan_id = $this->common_lib->select_one('obat_kemasan_sedang_id','data_obat','obat_id='.intval($id).''); 
			$kemasan_name = $this->common_lib->select_one('kemasan_name','data_kemasan','kemasan_id='.intval($kemasan_id).''); 
			$konversi = $this->common_lib->select_one('obat_kemasan_sedang_konversi','data_obat','obat_id='.intval($id).''); 
			if(intval($kemasan_id)>0&&trim($kemasan_name)!='')
			{
				$result[]=array(
					'kemasan_id'=>$kemasan_id,
					'kemasan_name'=>$kemasan_name,
					'konversi'=>$konversi,
				);
			}
			$kemasan_id = $this->common_lib->select_one('obat_kemasan_besar_id','data_obat','obat_id='.intval($id).''); 
			$kemasan_name = $this->common_lib->select_one('kemasan_name','data_kemasan','kemasan_id='.intval($kemasan_id).''); 
			$konversi = $this->common_lib->select_one('obat_kemasan_besar_konversi','data_obat','obat_id='.intval($id).''); 
			if(intval($kemasan_id)>0&&trim($kemasan_name)!='')
			{
				$result[]=array(
					'kemasan_id'=>$kemasan_id,
					'kemasan_name'=>$kemasan_name,
					'konversi'=>$konversi,
				);
			}
		}
		
        echo json_encode($result);
	}
    
	public function search_obat_by_name() { 
	 
        $search=str_replace('%20', ' ', $this->input->get('term'));   
        $findAll=$this->db->query('
		select * from (
			(
				SELECT "1" is_obat,obat_type as tipe,obat_id as id, `obat_name` as name,`obat_barcode` as barcode,`obat_price_resep` as price_resep,`obat_price_non_resep` as "price_non_resep",`obat_kemasan_kecil_id` as "kecil_kemasan",`obat_kemasan_kecil_konversi` as "kecil_konversi",`obat_kemasan_sedang_id` as "sedang_kemasan",`obat_kemasan_sedang_konversi` as "sedang_konversi",`obat_kemasan_besar_id` as "besar_kemasan",`obat_kemasan_besar_konversi` as "besar_konversi" FROM `data_obat` WHERE 1
			)
			union
			(
				SELECT "0" is_obat,"alkes" as tipe,alkes_id as id, alkes_name as "name",alkes_barcode as "barcode", `alkes_price_sale` as "price_non_resep", `alkes_price_sale` as "price_resep" ,"2" as "kecil_kemasan","1" as "kecil_konversi","2" as "sedang_kemasan","1" as "sedang_konversi","2" as "besar_kemasan","1" as "besar_konversi"
				FROM `data_alkes`
			)
		) as result
		 where 1 AND (barcode LIKE "%'.$search.'%" OR name LIKE "%'.$search.'%") order by name asc
		limit 15')->result_array();

        $data=array();
        if(!empty($findAll))
        {
            $no=1;
            foreach($findAll AS $rowArr)
            {   
				$rowArr['obat_type']=str_replace('_',' ',$rowArr['tipe']);
                 $data[$no]['id']=$rowArr['id']; 
				 // $data[$no]['label']=$rowArr['pasien_nama'].' | '.$rowArr['pasien_rm_number'].' | '.$rowArr['pasien_alamat'];
				 $data[$no]['label']=$rowArr['obat_type'].' | '.$rowArr['name'];            
				 $data[$no]['obat_name']=$rowArr['name'];            
				 $data[$no]['obat_price_resep']=$rowArr['price_resep'];                 
				 $data[$no]['obat_price_non_resep']=$rowArr['price_non_resep'];                 
				 $data[$no]['is_obat']=$rowArr['is_obat'];                 
				 $data[$no]['obat_type']=$rowArr['obat_type'];                 
                 $no++;

            }
        }
        echo json_encode($data);
    
	}
	  	
	public function search_diagnosis() { 
	 
        $search=str_replace('%20', ' ', $this->input->get('term'));   
        $findAll=$this->db->query('
		select * from data_diagnosa
		 where 1 AND (diagnosa_name LIKE "%'.$search.'%" OR diagnosa_icdx LIKE "%'.$search.'%") order by diagnosa_name asc
		limit 15')->result_array();

        $data=array();
        if(!empty($findAll))
        {
            $no=1;
            foreach($findAll AS $rowArr)
            {    
                 $data[$no]['id']=$rowArr['diagnosa_id']; 
				 $data[$no]['label']=$rowArr['diagnosa_name'];                 
                 $no++;

            }
        }
        echo json_encode($data);
    
	}
	  	 
    public function get_datatable_apotek() {   
		$result=$this->mainModel->get_data_apotek();
		$query=$result['query'];
		$total=$result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
		 $json_data = array('start' => $start, 'recordsTotal' => ($_POST['length']>0)?$_POST['length']:$total,'recordsFiltered' => $total, 'data' => array());
        $prev_trx = '';
        $no = 0 + $start;
        foreach ($query->result() as $row) {
            
            foreach($row AS $variable=>$value)
            {
                ${$variable}=$value;
            }
        $no++;  $label_confirm="'Yakin hapus data ini?'";
		$action='';
		$action=common_lib::hak_akses($this->access,'edit','menu')=='1'&&($pemeriksaan_status=='apotek')?'<a href="'.base_url('admin/'.__class__.'/apotek/edit/'.$pemeriksaan_id.'').'"style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>':'';
        
		// $pemeriksaan_status=(strtolower($pemeriksaan_status)=='belum diperiksa')?'<div class="badge badge-primary">Belum Diperiksa</div>':((strtolower($pemeriksaan_status)=='sudah diperiksa')?'<div class="badge badge-success">Sudah Diperiksa</div>':'<div class="badge badge-warning">Laboratorium</div>');
		$pemeriksaan_status=(strtolower($pemeriksaan_status)=='belum diperiksa')?'<div class="badge badge-primary">Belum Diperiksa</div>':((strtolower($pemeriksaan_status)=='sudah diperiksa')?'<div class="badge badge-success">Sudah Diperiksa</div>':(strtolower($pemeriksaan_status)=='laboratorium'?'<div class="badge badge-warning">Laboratorium</div>':'<div class="badge badge-dark">'.ucwords($pemeriksaan_status).'</div>'));
		$entry = array( 
			'no' =>  $no,
			'action' => $action,
			'pendaftaran_no'=>$pendaftaran_no, 
			'pendaftaran_pasien_rm'=>$pendaftaran_pasien_rm, 
			'pendaftaran_pasien_name'=>$pendaftaran_pasien_name, 
			'pendaftaran_penjamin_nama'=>$pendaftaran_penjamin_nama, 
			'pendaftaran_penjamin_no'=>$pendaftaran_penjamin_no, 
			'pendaftaran_pasien_address'=>$pendaftaran_pasien_address, 
			'pendaftaran_pasien_birthdate'=>$pendaftaran_pasien_birthdate, 
			'pendaftaran_pasien_gender'=>(trim($pendaftaran_pasien_gender)=='female'?'Perempuan':'Laki-Laki'), 
			'pendaftaran_date'=>date('d-m-Y',strtotime($pendaftaran_date)), 
			'pendaftaran_status'=>ucfirst($pendaftaran_status), 
			'pemeriksaan_status'=>ucfirst($pemeriksaan_status), 
			'pemeriksaan_alergi'=>$pemeriksaan_alergi,
			'pemeriksaan_weight'=>$pemeriksaan_weight,
			'pemeriksaan_height'=>$pemeriksaan_height,
			'pemeriksaan_tension'=>$pemeriksaan_tension,
			'pemeriksaan_respiration'=>$pemeriksaan_respiration,
			'pemeriksaan_nadi'=>$pemeriksaan_nadi,
			'pemeriksaan_suhu'=>$pemeriksaan_suhu,
			'pemeriksaan_anamnesis'=>$pemeriksaan_anamnesis,
			'pemeriksaan_pemeriksaan'=>$pemeriksaan_pemeriksaan,
			'pemeriksaan_apotek_total'=>common_lib::currency_format($pemeriksaan_apotek_total)
		);
		
        $json_data['data'][] = $entry;
            

        }

        echo json_encode($json_data); 
	}
 	
    public function search_pasien_by_rm_nik_penjamin() { 
	 
        $search=str_replace('%20', ' ', $this->input->get('term'));   
        $findAll=$this->db->query('select * from data_pasien where 1 AND (pasien_rm LIKE "%'.$search.'%" OR pasien_nik LIKE "%'.$search.'%" OR pasien_penjamin_no LIKE "%'.$search.'%") order by pasien_name asc limit 15')->result_array();

        $data=array();
        if(!empty($findAll))
        {
            $no=1;
            foreach($findAll AS $rowArr)
            {   
                 $data[$no]['id']=$rowArr['pasien_id']; 
				 // $data[$no]['label']=$rowArr['pasien_nama'].' | '.$rowArr['pasien_rm_number'].' | '.$rowArr['pasien_alamat'];
				 $data[$no]['label']=$rowArr['pasien_name'].' | '.$rowArr['pasien_rm'];
				 $data[$no]['pasien_rm']=$rowArr['pasien_rm'];
				 $data[$no]['pasien_name']=$rowArr['pasien_name'];
				 $data[$no]['pasien_nik']=$rowArr['pasien_nik'];                 
				 $data[$no]['pasien_penjamin_id']=$rowArr['pasien_penjamin_id'];                 
				 $data[$no]['pasien_penjamin_no']=$rowArr['pasien_penjamin_no'];                 
				 $data[$no]['pasien_ibu']=$rowArr['pasien_ibu'];                 
				 $data[$no]['pasien_address']=$rowArr['pasien_address'];                 
				 $data[$no]['pasien_gender']=$rowArr['pasien_gender'];                 
				 $data[$no]['pasien_birthplace']=$rowArr['pasien_birthplace'];                 
				 $data[$no]['pasien_birthdate']=$rowArr['pasien_birthdate'];                 
				 $data[$no]['pasien_pernikahan']=$rowArr['pasien_pernikahan'];                 
                 $no++;

            }
        }
        echo json_encode($data);
    
	}
	  
	public function action_validation($id=0) { 
		$id=isset($_POST['pemeriksaan_id'])?$_POST['pemeriksaan_id']:0;
		if(intval($id)>0)
		{
			$result=$this->mainModel->validate_form_edit();
		}
		else
		{
			$result=$this->mainModel->validate_form();			
		}
		echo json_encode($result);
	}
	
	public function action_stored() { 
		$id=isset($_POST['pemeriksaan_id'])?$_POST['pemeriksaan_id']:0;
		if(intval($id)>0)
		{
			$result=$this->mainModel->stored_edit();
		}
		else
		{
			$result=$this->mainModel->stored();			
		}
		echo json_encode($result);
	}

    public function get_datatable_lab() {   
		$result=$this->mainModel->get_data_lab();
		$query=$result['query'];
		$total=$result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
		 $json_data = array('start' => $start, 'recordsTotal' => ($_POST['length']>0)?$_POST['length']:$total,'recordsFiltered' => $total, 'data' => array());
        $prev_trx = '';
        $no = 0 + $start;
        foreach ($query->result() as $row) {
            
            foreach($row AS $variable=>$value)
            {
                ${$variable}=$value;
            }
        $no++;  $label_confirm="'Yakin hapus data ini?'";
		$action='';
		$action=common_lib::hak_akses($this->access,'edit','menu')=='1'&&($pemeriksaan_status=='laboratorium')?'<a href="'.base_url('admin/'.__class__.'/lab/edit/'.$pemeriksaan_id.'').'" onclick="edit_form('.$pemeriksaan_id.')" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>':'';
        
		// $pemeriksaan_status=(strtolower($pemeriksaan_status)=='belum diperiksa')?'<div class="badge badge-primary">Belum Diperiksa</div>':((strtolower($pemeriksaan_status)=='sudah diperiksa')?'<div class="badge badge-success">Sudah Diperiksa</div>':'<div class="badge badge-warning">Laboratorium</div>');
		$pemeriksaan_status=(strtolower($pemeriksaan_status)=='belum diperiksa')?'<div class="badge badge-primary">Belum Diperiksa</div>':((strtolower($pemeriksaan_status)=='sudah diperiksa')?'<div class="badge badge-success">Sudah Diperiksa</div>':(strtolower($pemeriksaan_status)=='laboratorium'?'<div class="badge badge-warning">Laboratorium</div>':'<div class="badge badge-dark">'.ucwords($pemeriksaan_status).'</div>'));
		$entry = array( 
			'no' =>  $no,
			'action' => $action,
			'pendaftaran_no'=>$pendaftaran_no, 
			'pendaftaran_pasien_rm'=>$pendaftaran_pasien_rm, 
			'pendaftaran_pasien_name'=>$pendaftaran_pasien_name, 
			'pendaftaran_penjamin_nama'=>$pendaftaran_penjamin_nama, 
			'pendaftaran_penjamin_no'=>$pendaftaran_penjamin_no, 
			'pendaftaran_pasien_address'=>$pendaftaran_pasien_address, 
			'pendaftaran_pasien_birthdate'=>$pendaftaran_pasien_birthdate, 
			'pendaftaran_pasien_gender'=>(trim($pendaftaran_pasien_gender)=='female'?'Perempuan':'Laki-Laki'), 
			'pendaftaran_date'=>date('d-m-Y',strtotime($pendaftaran_date)), 
			'pendaftaran_status'=>ucfirst($pendaftaran_status), 
			'pemeriksaan_status'=>ucfirst($pemeriksaan_status), 
			'pemeriksaan_alergi'=>$pemeriksaan_alergi,
			'pemeriksaan_weight'=>$pemeriksaan_weight,
			'pemeriksaan_height'=>$pemeriksaan_height,
			'pemeriksaan_tension'=>$pemeriksaan_tension,
			'pemeriksaan_respiration'=>$pemeriksaan_respiration,
			'pemeriksaan_nadi'=>$pemeriksaan_nadi,
			'pemeriksaan_suhu'=>$pemeriksaan_suhu,
			'pemeriksaan_anamnesis'=>$pemeriksaan_anamnesis,
			'pemeriksaan_pemeriksaan'=>$pemeriksaan_pemeriksaan
		);
		
        $json_data['data'][] = $entry;
            

        }

        echo json_encode($json_data); 
	}
 
    public function lab_index() {  
		
		common_lib::hak_akses($this->access,__function__,'controller'); 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst('Laboratorium');
        $st = new Stencil();
        
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
        $common['access'] = $this->access;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	 
	public function lab_edit($id=0) {  
	
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('trx_pemeriksaan JOIN trx_pendaftaran on pendaftaran_id=pemeriksaan_pendaftaran_id','pemeriksaan_id='.intval($id).' AND pemeriksaan_status ="laboratorium"');
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/lab?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		$title='Laboratorium';
        $common['title'] = ucfirst($title.' - '.$this->class);
        $st = new Stencil(); 
		if($this->input->post("submit"))
		{  
			$result=$this->mainModel->store_form_lab($id);
				// echo $result['status'];exit;
			if($result['status']==200)
			{
				redirect(base_url($this->module.'/'.__class__.'/lab?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
			}
			$common['status'] = $result['status'];
			$common['message'] = $result['message']; 
		} 
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
		
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $currentShift = common_lib::currenShift(); 
		// $common['obat'] = $this->common_lib->select_result('trx_pemeriksaan_obat','pemeriksaan_obat_pemeriksaan_id='.intval($id).''); 
		// $common['layanan_diagnosis'] = $this->common_lib->select_result('data_diagnosa','1'); 
		// $common['diagnosis'] = $this->common_lib->select_result('trx_pemeriksaan_diagnosis','pemeriksaan_diagnosis_pemeriksaan_id='.intval($id).''); 
		// $common['layanan_umum'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($has_exist['pemeriksaan_pendaftaran_id']).' and lower(pendaftaran_layanan_layanan_name)="umum"'); 
		// $common['master_layanan_lab'] = $this->common_lib->select_result('data_layanan','is_delete=0 AND lower(layanan_poli_name)="laboratorium"'); 
		$common['layanan_lab'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($has_exist['pemeriksaan_pendaftaran_id']).' and lower(pendaftaran_layanan_layanan_name)="laboratorium"'); 
        // $common['jadwal_lab_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="laboratorium" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        // $common['jadwal_umum_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="umum" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        // $common['kemasan_arr'] = $this->common_lib->select_result('data_kemasan','is_delete=0'); 
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	 
	public function edit($id=0) {  
		common_lib::hak_akses($this->access,__function__,'controller'); 
		$has_exist=$this->common_lib->select_row('trx_pemeriksaan JOIN trx_pendaftaran on pendaftaran_id=pemeriksaan_pendaftaran_id','pemeriksaan_id='.intval($id).' AND pemeriksaan_status NOT IN ("pendaftaran","laboratorium")');
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/data?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		
        $common['title'] = ucfirst(__function__.' - '.$this->class);
        $st = new Stencil(); 
		if($this->input->post("submit"))
		{ 
			// echo '<pre>';print_r($_POST);exit;
			$result=$this->mainModel->validate_form_edit();
			
			$data=$result;
			if($data['status']==200)
			{ 
				$result=$this->mainModel->store_form($id);
				
				$data=$result;
				if($result['status']==200)
				{
					redirect(base_url($this->module.'/'.__class__.'/data?status='.$result['status'].'&flag='.base64_encode($result['message']).''));
				}
			}
			$common['status'] = $data['status'];
			$common['message'] = $data['message']; 
		} 
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
		
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $currentShift = common_lib::currenShift(); 
		$common['obat'] = $this->common_lib->select_result('trx_pemeriksaan_obat','pemeriksaan_obat_pemeriksaan_id='.intval($id).''); 
		$common['layanan_diagnosis'] = $this->common_lib->select_result('data_diagnosa','1'); 
		$common['diagnosis'] = $this->common_lib->select_result('trx_pemeriksaan_diagnosis','pemeriksaan_diagnosis_pemeriksaan_id='.intval($id).''); 
		$common['layanan_umum'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($has_exist['pemeriksaan_pendaftaran_id']).' and lower(pendaftaran_layanan_layanan_name)="umum"'); 
		$common['master_layanan_lab'] = $this->common_lib->select_result('data_layanan JOIN data_poli on layanan_poli_id=poli_id AND data_poli.is_delete=0','data_layanan.is_delete=0 AND lower(poli_name)="laboratorium"'); 
		$common['master_layanan_umum'] = $this->common_lib->select_result('data_layanan JOIN data_poli on layanan_poli_id=poli_id AND data_poli.is_delete=0','data_layanan.is_delete=0 AND lower(poli_name)="umum"'); 
		$common['layanan_lab'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($has_exist['pemeriksaan_pendaftaran_id']).' and lower(pendaftaran_layanan_layanan_name)="laboratorium"'); 
        $common['jadwal_lab_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="laboratorium" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        $common['jadwal_umum_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="umum" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        $common['kemasan_arr'] = $this->common_lib->select_result('data_kemasan','is_delete=0'); 
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	  
	public function view($id=0) {  
		common_lib::hak_akses($this->access,'data','controller'); 
		$has_exist=$this->common_lib->select_row('trx_pemeriksaan JOIN trx_pendaftaran on pendaftaran_id=pemeriksaan_pendaftaran_id','pemeriksaan_id='.intval($id).' AND pemeriksaan_status NOT IN ("pendaftaran","laboratorium")');
		if(empty($has_exist))
		{
			redirect(base_url($this->module.'/'.__class__.'/data?status=500&flag='.base64_encode('Data tidak ditemukan.').''));
		}
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);  
		
        $common['title'] = ucfirst(__function__.' - '.$this->class);
        $st = new Stencil(); 
		 
        $breadcrumbs_array = array();
        /* $breadcrumbs_array[] = array(
            'name' => 'Dashboard',
            'class' => "fa fa-home",
            'link' => base_url().'admin/dashboard',
            'current' => false, //boolean
        );
         $breadcrumbs_array[] = array(
            'name' => $common['title'],
            'class' => "clip-grid-2",
            'link' => '#',
            'current' => true, //boolean
        ); */
        $common['breadcrumbs'] = $this->common_lib->create_breadcrumbs($breadcrumbs_array,$this->module);
		$common['data']=$has_exist;
		foreach($has_exist as $index=>$value)
		{
			$common[$index]=$value;
		}
		
		
        $common['class'] = __class__;
		$st->slice('head_login'); 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
		
        $currentShift = common_lib::currenShift(); 
		$common['obat'] = $this->common_lib->select_result('trx_pemeriksaan_obat','pemeriksaan_obat_pemeriksaan_id='.intval($id).''); 
		$common['layanan_diagnosis'] = $this->common_lib->select_result('data_diagnosa','1'); 
		$common['diagnosis'] = $this->common_lib->select_result('trx_pemeriksaan_diagnosis','pemeriksaan_diagnosis_pemeriksaan_id='.intval($id).''); 
		$common['layanan_umum'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($has_exist['pemeriksaan_pendaftaran_id']).' and lower(pendaftaran_layanan_layanan_name)="umum"'); 
		$common['master_layanan_lab'] = $this->common_lib->select_result('data_layanan JOIN data_poli on layanan_poli_id=poli_id AND data_poli.is_delete=0','data_layanan.is_delete=0 AND lower(poli_name)="laboratorium"'); 
		$common['master_layanan_umum'] = $this->common_lib->select_result('data_layanan JOIN data_poli on layanan_poli_id=poli_id AND data_poli.is_delete=0','data_layanan.is_delete=0 AND lower(poli_name)="umum"'); 
		$common['layanan_lab'] = $this->common_lib->select_result('trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id='.intval($has_exist['pemeriksaan_pendaftaran_id']).' and lower(pendaftaran_layanan_layanan_name)="laboratorium"'); 
        $common['jadwal_lab_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="laboratorium" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        $common['jadwal_umum_arr'] = $this->common_lib->select_row('data_jadwal','jadwal_poli="umum" AND jadwal_date="'.date('Y-m-d').'" AND jadwal_shift_id='.$currentShift.''); 
        $common['kemasan_arr'] = $this->common_lib->select_result('data_kemasan','is_delete=0'); 
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }
	 	 
    public function get_datatable() {   
		$result=$this->mainModel->get_data();
		$query=$result['query'];
		$total=$result['total'];
		
        header("Content-type: application/json");
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        
        $start = isset($_POST['start']) ? $_POST['start'] : 0;
		 $json_data = array('start' => $start, 'recordsTotal' => ($_POST['length']>0)?$_POST['length']:$total,'recordsFiltered' => $total, 'data' => array());
        $prev_trx = '';
        $no = 0 + $start;
        foreach ($query->result() as $row) {
            
            foreach($row AS $variable=>$value)
            {
                ${$variable}=$value;
            }
        $no++;  $label_confirm="'Yakin hapus data ini?'";
		$action='';
		$action=common_lib::hak_akses($this->access,'edit','menu')=='1'&&$pemeriksaan_status!='laboratorium'&&$pemeriksaan_status!='kasir'&&$pemeriksaan_status!='apotek'?'<a href="'.base_url('admin/'.__class__.'/edit/'.$pemeriksaan_id.'').'" onclick="edit_form('.$pemeriksaan_id.')" style="margin-right:5px" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>':'';
        
		$pemeriksaan_status=(strtolower($pemeriksaan_status)=='belum diperiksa')?'<div class="badge badge-primary">Belum Diperiksa</div>':((strtolower($pemeriksaan_status)=='sudah diperiksa')?'<div class="badge badge-success">Sudah Diperiksa</div>':(strtolower($pemeriksaan_status)=='laboratorium'?'<div class="badge badge-warning">Laboratorium</div>':'<div class="badge badge-dark">'.ucwords($pemeriksaan_status).'</div>'));
		$entry = array( 
			'no' =>  $no,
			'action' => $action,
			'pendaftaran_no'=>$pendaftaran_no, 
			'pendaftaran_pasien_rm'=>$pendaftaran_pasien_rm, 
			'pendaftaran_pasien_name'=>$pendaftaran_pasien_name, 
			'pendaftaran_penjamin_nama'=>$pendaftaran_penjamin_nama, 
			'pendaftaran_penjamin_no'=>$pendaftaran_penjamin_no, 
			'pendaftaran_pasien_address'=>$pendaftaran_pasien_address, 
			'pendaftaran_pasien_birthdate'=>$pendaftaran_pasien_birthdate, 
			'pendaftaran_pasien_gender'=>(trim($pendaftaran_pasien_gender)=='female'?'Perempuan':'Laki-Laki'), 
			'pendaftaran_date'=>date('d-m-Y',strtotime($pendaftaran_date)), 
			'pendaftaran_status'=>ucfirst($pendaftaran_status), 
			'pemeriksaan_status'=>ucfirst($pemeriksaan_status), 
			'pemeriksaan_alergi'=>$pemeriksaan_alergi,
			'pemeriksaan_weight'=>$pemeriksaan_weight,
			'pemeriksaan_height'=>$pemeriksaan_height,
			'pemeriksaan_tension'=>$pemeriksaan_tension,
			'pemeriksaan_respiration'=>$pemeriksaan_respiration,
			'pemeriksaan_nadi'=>$pemeriksaan_nadi,
			'pemeriksaan_suhu'=>$pemeriksaan_suhu,
			'pemeriksaan_anamnesis'=>$pemeriksaan_anamnesis,
			'pemeriksaan_pemeriksaan'=>$pemeriksaan_pemeriksaan
		);
		
        $json_data['data'][] = $entry;
            

        }

        echo json_encode($json_data); 
	}
	 
    public function data() {  
		
		common_lib::hak_akses($this->access,__function__,'controller'); 
        $this->session->set_userdata("last_url", __class__.'/'.__function__); 
		$common=common_lib::getState($this);    
        $common['title'] = ucfirst($this->class);
        $st = new Stencil();
        
        $st->slice('head_login');  
        $common['class'] = __class__; 
        $common['js_files'] = ''; 
        $common['css_files'] = '';
        $common['access'] = $this->access;
		
        $st->paint($this->template.'/'.$this->module,__class__.'/'.__function__, $common);
    }

}

/* ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ */