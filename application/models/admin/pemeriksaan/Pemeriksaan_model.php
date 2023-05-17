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
class pemeriksaan_model extends controller_model{
	protected $role_arr;
    public function __construct() {
        parent::__construct(); 
		$this->CI=& get_instance();
		$this->CI->load->model('admin/registration/registration_model'); 
    }
    
	
	function store_form_kasir($id)
	{
		$bank_name=$this->CI->input->post('bank_name');
		$tipe_paid_cash=common_lib::remove_currency_format($this->CI->input->post('tipe_paid_cash'));
		$tipe_paid=common_lib::remove_currency_format($this->CI->input->post('tipe_paid'));
		$date=date('Y-m-d H:i:s');
		
		$kasir_status=$this->CI->common_lib->select_one('kasir_status','trx_pemeriksaan_kasir','kasir_id="'.intval($id).'"');
		$kasir_total=$this->CI->common_lib->select_one('kasir_total','trx_pemeriksaan_kasir','kasir_id="'.intval($id).'"');
		$paid=$this->CI->common_lib->select_one('kasir_cash+kasir_bayar','trx_pemeriksaan_kasir','kasir_id="'.intval($id).'"');
		
		$sisa=$kasir_total-($paid+$tipe_paid_cash+$tipe_paid);
		$status="Belum Lunas";
		if($sisa>0)
		{
			return array(
				'status'=>500,
				'message'=>'Total Pembayaran kurang dari tagihan.',
			);
		}
		else
		{
			 
			$status="Lunas";
			$kembalian=abs($sisa);
			
			$admin_user_name=common_lib::admin_user_name();
			$dataLog=array(
				'log_kasir_id'=>$id,
				'log_date'=>$date,
				'log_tipe_bayar'=>$bank_name,
				'log_tipe_bayar_value'=>$tipe_paid,
				'log_bayar_cash'=>$tipe_paid_cash ,
				'log_bayar_kembalian'=>$kembalian,
				'log_input_by'=>$admin_user_name,
				// 'kasir_status'=>$status,
			);
			
			$this->CI->db->insert('trx_pemeriksaan_kasir_log',$dataLog);
			 
			
			$this->CI->db->query('
				UPDATE trx_pemeriksaan_kasir SET 
				kasir_bayar=kasir_bayar+'.$tipe_paid.'
				,kasir_cash=kasir_cash+'.$tipe_paid_cash.'
				,kasir_last_update="'.$date.'"
				,kasir_status="'.$status.'"
				WHERE kasir_id='.$id.'
			');
			
			
			return array(
				'status'=>200,
				'message'=>'Pembayaran sukses disimpan.',
			);
		}
	}
	
	function get_data_kasir()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'trx_pemeriksaan_kasir';
        $params['select'] = "trx_pemeriksaan_kasir.*,pendaftaran_pasien_name";
        $params['join'] = " LEFT JOIN data_pasien on pasien_id=kasir_pasien_id";
        $params['join'] .= " JOIN trx_pendaftaran on pendaftaran_id=kasir_pendaftaran_id";
        $where='1';
         
        if(trim($this->CI->input->get('search'))!='')
        {
            $where.=' AND (pasien_name LIKE "%'.$this->CI->input->get('search').'%" OR kasir_invoice LIKE "%'.$this->CI->input->get('search').'%")';
        } 
         
        if(trim($this->CI->input->get('status'))!='')
        {
            $where.=' AND kasir_status="'.$this->CI->input->get('status').'"';
        } 
         
        if(trim($this->CI->input->get('date_start'))!='')
        {
			$date_start=date('Y-m-d',strtotime($this->CI->input->get('date_start')));
            $where.=' AND kasir_date >= "'.$date_start.'"';
        }
        if(trim($this->CI->input->get('date_end'))!='')
        {
			$date_end=date('Y-m-d',strtotime($this->CI->input->get('date_end')));
            $where.=' AND kasir_date <= "'.$date_end.'"';
        } 
         
        $params['where'] =$where;
        $params['order_by'] = "kasir_id DESC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query,
			'total'=>$total,
		);
	}

	function store_form_apotek($id=0)
	{
		// echo '<pre>';print_r($_POST);exit;
		$today=date('Y-m-d');
		$datetime=date('Y-m-d H:i:s');
		$status=500;
		$message='Tidak ada aksi';
		$obat_id=isset($_POST['obat_id'])?$_POST['obat_id']:array();
		$obat_name=isset($_POST['obat_name'])?$_POST['obat_name']:array();
		$obat_price=isset($_POST['obat_price'])?$_POST['obat_price']:array();
		$obat_resep=isset($_POST['obat_resep'])?$_POST['obat_resep']:array();
		$obat_dosis=isset($_POST['obat_dosis'])?$_POST['obat_dosis']:array();
		$obat_aturan_pakai=isset($_POST['obat_aturan_pakai'])?$_POST['obat_aturan_pakai']:array();
		$obat_kemasan_id=isset($_POST['obat_kemasan_id'])?$_POST['obat_kemasan_id']:array();
		$obat_qty=isset($_POST['obat_qty'])?$_POST['obat_qty']:array();
		$obat_type=isset($_POST['obat_type'])?$_POST['obat_type']:array();
		$obat_total=isset($_POST['obat_total'])?$_POST['obat_total']:array();
		$obat_kemasan_name=isset($_POST['obat_kemasan_name'])?$_POST['obat_kemasan_name']:array();
		$is_obat=isset($_POST['is_obat'])?$_POST['is_obat']:array();
		
		
		$apotek_subtotal=isset($_POST['apotek_subtotal'])?$_POST['apotek_subtotal']:0;
		$apotek_tuslah=isset($_POST['apotek_tuslah'])?$_POST['apotek_tuslah']:0;
		$apotek_embalage=isset($_POST['apotek_embalage'])?$_POST['apotek_embalage']:0;
		$apotek_disc_rp=isset($_POST['apotek_disc_rp'])?$_POST['apotek_disc_rp']:0;
		$apotek_disc_persen=isset($_POST['apotek_disc_persen'])?$_POST['apotek_disc_persen']:0;
		$apotek_grandtotal=isset($_POST['apotek_grandtotal'])?$_POST['apotek_grandtotal']:0;
		$apotek_disc=isset($_POST['apotek_disc'])?$_POST['apotek_disc']:0;
		$pasien_name=isset($_POST['pasien_name'])?$_POST['pasien_name']:'';
		$pasien_alamat=isset($_POST['pasien_alamat'])?$_POST['pasien_alamat']:'';
		$pasien_age=isset($_POST['pasien_age'])?$_POST['pasien_age']:'';
		$pasien_phone=isset($_POST['pasien_phone'])?$_POST['pasien_phone']:'';
		
		if($id==0) //pasien baru
		{
			if(trim($pasien_name)=='')
			{
				return array(
					'status'=>500,
					'message'=>'Isian Nama Pasien tidak boleh kosong',
				);
			}
			else if(trim($pasien_alamat)=='')
			{
				return array(
					'status'=>500,
					'message'=>'Isian Alamat tidak boleh kosong',
				);
			}
			else if(trim($pasien_age)=='')
			{
				return array(
					'status'=>500,
					'message'=>'Isian Usia tidak boleh kosong',
				);
			}
			else if(trim($pasien_phone)=='')
			{
				return array(
					'status'=>500,
					'message'=>'Isian No Telp tidak boleh kosong',
				);
			}
		}
		
		//validasi
		if(empty($obat_id))
		{
			return array(
				'status'=>500,
				'message'=>'Isian transaksi tidak boleh kosong',
			);
		}
		else if($apotek_tuslah=='')
		{
			return array(
				'status'=>500,
				'message'=>'Isian Tuslah tidak boleh kosong',
			);
		}
		else if($apotek_embalage=='')
		{
			return array(
				'status'=>500,
				'message'=>'Isian Embalage tidak boleh kosong',
			);
		}
		else if($apotek_disc_rp=='')
		{
			return array(
				'status'=>500,
				'message'=>'Isian Disc Rp tidak boleh kosong',
			);
		}
		else if($apotek_disc_persen=='')
		{
			return array(
				'status'=>500,
				'message'=>'Isian Disc % tidak boleh kosong',
			);
		}
		
		foreach($obat_id as $index=>$value)
		{
			$total_need=(isset($obat_qty[$index])?$obat_qty[$index]:0);
			
			//cek stok
			$_is_obat=isset($is_obat[$index])?$is_obat[$index]:-1;
			$_obat_name=isset($obat_name[$index])?$obat_name[$index]:'-';
			$cek_stok=$this->CI->common_lib->select_one('sum(qty)','data_stok','expired_date>="'.trim($today).'" AND id_barang='.$value.' and is_obat='.$_is_obat.' AND penyimpanan="etalase" ');
			// echo '<pre>';print_r($_POST);exit;
			if($cek_stok<$total_need)
			{
				return array(
					'status'=>500,
					'message'=>'Stok '.$_obat_name.' di etalase tidak mencukupi hanya tersedia '.intval($cek_stok).'',
				);
				
			}
		}
		
		//insert data 
		if($id==0)
		{
				$admin_user_id=common_lib::admin_user_id();
				$pendaftaran_no=$this->CI->registration_model->pendaftaran_no();
				$data_form=array(
					'pendaftaran_no'=>$pendaftaran_no,
					'pendaftaran_pasien_pernikahan'=>$pasien_age,
					'pendaftaran_pasien_id'=>0,
					'pendaftaran_pasien_rm'=>'-',
					'pendaftaran_date'=>date('Y-m-d H:i:s'),
					'pendaftaran_pasien_name'=>$this->CI->input->post('pasien_name'),
					'pendaftaran_pasien_nik'=>$this->CI->input->post('pasien_alamat'),
					'pendaftaran_pasien_penanggung_jawab_telp'=>$this->CI->input->post('pasien_phone'),
					'pendaftaran_pasien_ibu'=>'-',
					'pendaftaran_pasien_address'=>$this->CI->input->post('pasien_alamat'),
					'pendaftaran_pasien_gender'=>'-',
					'pendaftaran_pasien_birthplace'=>'-',
					'pendaftaran_pasien_birthdate'=>date('Y-m-d',strtotime($this->CI->input->post('pendaftaran_pasien_birthdate'))),
					// 'pendaftaran_pasien_pernikahan'=>$this->CI->input->post('pendaftaran_pasien_pernikahan'),
					'pendaftaran_penjamin_id'=>0,
					'pendaftaran_penjamin_nama'=>'-',
					'pendaftaran_penjamin_no'=>'-',
					'pendaftaran_status'=>'kasir',
					'pendaftaran_from'=>'apotek',
				);
				
				$this->CI->db->insert('trx_pendaftaran',$data_form);
				$pendaftaran_id=$this->CI->db->insert_id();
				
				
				$data_pemeriksaan=array(
					'pemeriksaan_status'=>'kasir',
					'pemeriksaan_date'=>$datetime,
					'pemeriksaan_pendaftaran_id'=>$pendaftaran_id,
					'pemeriksaan_pasien_id'=>0,
				); 
					
				$data_pemeriksaan['pemeriksaan_insert_date']=$datetime;
				$data_pemeriksaan['pemeriksaan_insert_by']=$admin_user_id;
				$this->CI->db->insert('trx_pemeriksaan',$data_pemeriksaan);
				$id=$this->CI->db->insert_id();
		}
		
		if(!empty($obat_id))
		{
			//rollback data dulu
			$stockArr=$this->CI->db->query('SELECT * FROM data_stok_log 
			WHERE jenis_transaksi=99 AND id_penerimaan_alkes='.$id.'
			ORDER BY expired_date ASC')->result_array();
			foreach($stockArr as $row)
			{
					$this->CI->db->query('UPDATE data_stok SET qty=qty+'.$row['qty'].'
						where id_barang='.$row['id_barang'].' AND is_obat='.$row['is_obat'].'
						AND expired_date="'.$row['expired_date'].'"
						AND batch="'.$row['batch'].'"
					');
				
					$this->CI->db->query('UPDATE data_stok_log SET jenis_transaksi=100
						where id='.$row['id'].' AND jenis_transaksi=99
					');
			}
			
			$this->CI->db->query('DELETE FROM `trx_pemeriksaan_obat_apotek` WHERE `pemeriksaan_obat_pemeriksaan_id`='.$id);
			foreach($obat_id as $index=>$value)
			{
				$data=array(
					'pemeriksaan_obat_pemeriksaan_id'=>$id,
					'pemeriksaan_obat_obat_id'=>$value,
					'pemeriksaan_obat_type'=>(isset($obat_type[$index])?$obat_type[$index]:'-'),
					'pemeriksaan_obat_resep'=>(isset($obat_resep[$index])?$obat_resep[$index]:'-'),
					'pemeriksaan_obat_name'=>(isset($obat_name[$index])?$obat_name[$index]:'-'),
					'pemeriksaan_obat_kemasan_id'=>(isset($obat_kemasan_id[$index])?$obat_kemasan_id[$index]:0),
					'pemeriksaan_obat_kemasan_name'=>(isset($obat_kemasan_name[$index])?$obat_kemasan_name[$index]:0),
					'pemeriksaan_obat_qty'=>(isset($obat_qty[$index])?$obat_qty[$index]:0),
					'pemeriksaan_obat_price'=>(isset($obat_price[$index])?$obat_price[$index]:0),
					'pemeriksaan_obat_aturan_pakai'=>(isset($obat_aturan_pakai[$index])?$obat_aturan_pakai[$index]:'-'),
					'pemeriksaan_obat_is_obat'=>(isset($is_obat[$index])?$is_obat[$index]:'-1'),
				);
				
				$this->CI->db->insert('trx_pemeriksaan_obat_apotek',$data);
				$apt_id=$this->CI->db->insert_id();
				
				$_is_obat=isset($is_obat[$index])?$is_obat[$index]:-1;
				$where='id_barang='.$value.' and is_obat='.$_is_obat.' AND qty>0 AND penyimpanan="etalase"';
				if($_is_obat=='1')
				{
					$where.=' AND expired_date>"'.$today.'"';
				}
				//pengurangan stock
				$stockArr=$this->CI->db->query('SELECT * FROM data_stok 
				WHERE '.$where.'
				ORDER BY expired_date ASC')->result_array();
				$total_need=(isset($obat_qty[$index])?$obat_qty[$index]:0);
				foreach($stockArr as $row)
				{
					if($total_need>0)
					{
						$total_reduce=($row['qty']>=$total_need)?$total_need:$row['qty'];
						
						$stok_log=array(
							'barcode'=>0,
							'id_barang'=>$value,
							'is_obat'=>$_is_obat,
							'qty'=>$total_reduce,
							'expired_date'=>$row['expired_date'],
							'batch'=>$row['batch'],
							'jenis_transaksi'=>99,
							'id_kemasan'=>0,
							'id_penerimaan_obat'=>$apt_id,
							'id_penerimaan_alkes'=>$id,
						);
						
						$this->CI->db->insert('data_stok_log',$stok_log);
						
						$this->CI->db->query('UPDATE data_stok SET qty=qty-'.$total_reduce.'
						where id_barang='.$value.' AND is_obat='.$_is_obat.' AND penyimpanan="etalase"
						');
						
						$total_need-=$total_reduce;
					}
					else
					{
						break;
					}
				}
				
			}
		}
		
		
		$dataArr=array(
			'pemeriksaan_apotek_subtotal'=>common_lib::remove_currency_format($apotek_subtotal),
			'pemeriksaan_apotek_tuslah'=>common_lib::remove_currency_format($apotek_tuslah),
			'pemeriksaan_apotek_embalage'=>common_lib::remove_currency_format($apotek_embalage),
			'pemeriksaan_apotek_disc_rupiah'=>common_lib::remove_currency_format($apotek_disc_rp),
			'pemeriksaan_apotek_disc'=>common_lib::remove_currency_format($apotek_disc),
			'pemeriksaan_apotek_disc_persen'=>$apotek_disc_persen,
			'pemeriksaan_apotek_total'=>common_lib::remove_currency_format($apotek_grandtotal),
		);
		$this->CI->db->update('trx_pemeriksaan',$dataArr,array('pemeriksaan_id'=>$id));
		
		
		$status=200;
		$message='Sukses menyimpan data apotek.';
		
		$pemeriksaan_pendaftaran_id=$this->CI->common_lib->select_one('pemeriksaan_pendaftaran_id','trx_pemeriksaan','pemeriksaan_id="'.intval($id).'"');
		$response=$this->status_pemeriksaan($id,$pemeriksaan_pendaftaran_id);
		$message.=' '.$response['message'];		
		
		
		
		return array(
			'status'=>$status,
			'message'=>$message,
		);
	}
    
	function send_to_lab()
	{
		$pemeriksaan_id=$this->CI->input->post('pemeriksaan_id',true);
		
		$pemeriksaan_pendaftaran_id=$this->CI->common_lib->select_one('pemeriksaan_pendaftaran_id','trx_pemeriksaan','pemeriksaan_id="'.intval($pemeriksaan_id).'"');
		$datetime=date('Y-m-d H:i:s');
		$dataArr=array(
			'pendaftaran_status'=>'laboratorium',
		);
		$this->CI->db->update('trx_pendaftaran',$dataArr,array('pendaftaran_id'=>$pemeriksaan_pendaftaran_id));
		
		$datetime=date('Y-m-d H:i:s');
		$dataArr=array(
			'pemeriksaan_status'=>'laboratorium',
		);
		$this->CI->db->update('trx_pemeriksaan',$dataArr,array('pemeriksaan_id'=>$pemeriksaan_id));
		 
		
		return array(
			'status'=>200,
			'message'=>'Data Sukses dikirim ke laboratorium.',
		);
	}   
	  
	function store_form_lab($id=0)
	{
		$path='';
		// echo '<pre>';print_r($_POST);
		$pendaftaran_layanan_id=isset($_POST['pendaftaran_layanan_id'])?$_POST['pendaftaran_layanan_id']:array();
		$status=500;
		$message='Tidak ada file yg disimpan.';
		
		
		if(!empty($pendaftaran_layanan_id))
		{
			foreach($pendaftaran_layanan_id as $index=>$value)
			{
				// echo '<pre>';print_r($pendaftaran_layanan_layanan_id);
				$name='pendaftaran_layanan_hasil_'.$index;
				$file_tmp =isset($_FILES[$name]['tmp_name'])?$_FILES[$name]['tmp_name']:'';
				$file_name =isset($_FILES[$name]['tmp_name'])?$_FILES[$name]['name']:'';
				if(trim($file_tmp)!='')
				{
					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					$path="assets/uploads/laboratorium/lab_".uniqid().'.'.$ext;
					move_uploaded_file($file_tmp,$path);
					
					$data_layanan=array(
						'pendaftaran_layanan_hasil'=>trim($path),
					);
					$this->CI->db->update('trx_pendaftaran_layanan',$data_layanan,array('pendaftaran_layanan_id'=>$value));
					$status=200;
					$message='Terdapat file yg disimpan.';
				}			
			}
			
		}
		$pemeriksaan_pendaftaran_id=$this->CI->common_lib->select_one('pemeriksaan_pendaftaran_id','trx_pemeriksaan','pemeriksaan_id="'.intval($id).'"');
		$response=$this->status_pemeriksaan($id,$pemeriksaan_pendaftaran_id);
		$message.=' '.$response['message'];
		return array(
			'status'=>$status,
			'message'=>$message,
		);
	}
	
	
	
	/* generate penjualan kode */
	function generate_code($custom_date='')
	{
		$date=(trim($custom_date)!='')?date('Y-m',strtotime($custom_date)):date('Y-m');
		// $admin_id=common_lib::admin_user_id();
		$first=date('Ym',strtotime($date));
		$inc=1;
		$exist=$this->CI->common_lib->select_one('kasir_invoice','trx_pemeriksaan_kasir','kasir_date="'.$date.'" order by kasir_id DESC');
		$first = 'INV-'.date('Ymd');
		$pjg = strlen($exist);
		$pjg2 = strlen($first);
		$cut = $pjg-$pjg2;
		$last_code = $exist;
		$last_code = substr($exist, $cut*-1);
		$incpad = (intval($last_code)<=0)?str_pad($inc, 3, '0', STR_PAD_LEFT):str_pad(($last_code+1), 3, '0', STR_PAD_LEFT);  
		return $first.$incpad; 
	}
	
	
	function status_pemeriksaan($id,$pemeriksaan_pendaftaran_id)
	{
		$status=$this->CI->input->post('submit');
		
		if($status=='pendaftaran')
		{
			$data_layanan=array(
				'pemeriksaan_status'=>'belum diperiksa',
			);
			$this->CI->db->update('trx_pemeriksaan',$data_layanan,array('pemeriksaan_id'=>$id));
			$data_layanan=array(
				'pendaftaran_status'=>'pendaftaran',
			);
			$this->CI->db->update('trx_pendaftaran',$data_layanan,array('pendaftaran_id'=>$pemeriksaan_pendaftaran_id));
		}
		else if($status=='kasir')
		{
			
			//generate invoice
			
			$kasir_id=$this->CI->common_lib->select_one('kasir_id','trx_pemeriksaan_kasir','kasir_pemeriksaan_id="'.intval($id).'" AND kasir_pendaftaran_id="'.intval($pemeriksaan_pendaftaran_id).'"');
			$kasir_pasien_id=$this->CI->common_lib->select_one('pemeriksaan_pasien_id','trx_pemeriksaan','pemeriksaan_id="'.intval($id).'"');
			$tagihan_obat=$this->CI->common_lib->select_one('sum(pemeriksaan_obat_price*pemeriksaan_obat_qty)','trx_pemeriksaan_obat_apotek','pemeriksaan_obat_pemeriksaan_id="'.intval($id).'"');
			
			$this->CI->db->query('UPDATE `trx_pendaftaran_layanan` 
				SET  `pendaftaran_layanan_price`=(select layanan_total from data_layanan where layanan_id=pendaftaran_layanan_pemeriksaan_id)
				where `pendaftaran_layanan_pendaftaran_id`='.$pemeriksaan_pendaftaran_id
			);
			
			$pemeriksaanArr=$this->CI->common_lib->select_row('trx_pemeriksaan','pemeriksaan_id="'.intval($id).'"');
			$tagihan_tindakan=$this->CI->common_lib->select_one('sum(pendaftaran_layanan_price)','trx_pendaftaran_layanan','pendaftaran_layanan_pendaftaran_id="'.intval($pemeriksaan_pendaftaran_id).'"');
			$invoice_no=$this->generate_code();
			$dataArr=array(
				'kasir_invoice'=>$invoice_no,
				'kasir_pemeriksaan_id'=>$id,
				'kasir_pendaftaran_id'=>$pemeriksaan_pendaftaran_id,
				'kasir_pasien_id'=>intval($kasir_pasien_id),
				'kasir_layanan_price'=>intval($tagihan_tindakan),
				'kasir_subtotal'=>$pemeriksaanArr['pemeriksaan_apotek_subtotal'],
				'kasir_tuslah'=>$pemeriksaanArr['pemeriksaan_apotek_tuslah'],
				'kasir_embalage'=>$pemeriksaanArr['pemeriksaan_apotek_embalage'],
				'kasir_disc'=>$pemeriksaanArr['pemeriksaan_apotek_disc'],
				'kasir_disc_rupiah'=>$pemeriksaanArr['pemeriksaan_apotek_disc_rupiah'],
				'kasir_disc_persen'=>$pemeriksaanArr['pemeriksaan_apotek_disc_persen'],
				'kasir_grandtotal'=>$pemeriksaanArr['pemeriksaan_apotek_total'],
				'kasir_total'=>($pemeriksaanArr['pemeriksaan_apotek_total']+intval($tagihan_tindakan)),
				
			);
			$admin_user_name=common_lib::admin_user_name();
			if(intval($kasir_id)<=0)
			{
				$dataArr['kasir_date']=date('Y-m-d');
				$dataArr['kasir_input_date']=date('Y-m-d H:i:s');
				$dataArr['kasir_update_by']=$admin_user_name;
				$this->CI->db->insert('trx_pemeriksaan_kasir',$dataArr);
			}
			else
			{
				$dataArr['kasir_last_update']=date('Y-m-d H:i:s');
				$dataArr['kasir_update_by']=$admin_user_name;				
				$this->CI->db->update('trx_pemeriksaan_kasir',$dataArr,array('kasir_id'=>$kasir_id));
			}
			
			
			
			$data_layanan=array(
				'pemeriksaan_status'=>'kasir',
			);
			$this->CI->db->update('trx_pemeriksaan',$data_layanan,array('pemeriksaan_id'=>$id));
			
			$data_layanan=array(
				'pendaftaran_status'=>'kasir',
			);
			$this->CI->db->update('trx_pendaftaran',$data_layanan,array('pendaftaran_id'=>$pemeriksaan_pendaftaran_id));
			
		}
		else if($status=='apotek')
		{
			$obat_exist=$this->CI->common_lib->select_one('count(*)','trx_pemeriksaan_obat','pemeriksaan_obat_pemeriksaan_id="'.intval($id).'"');
			
			if(intval($obat_exist)>0)
			{
				$data_layanan=array(
					'pemeriksaan_status'=>'apotek',
				);
				$this->CI->db->update('trx_pemeriksaan',$data_layanan,array('pemeriksaan_id'=>$id));
				$data_layanan=array(
					'pendaftaran_status'=>'apotek',
				);
				$this->CI->db->update('trx_pendaftaran',$data_layanan,array('pendaftaran_id'=>$pemeriksaan_pendaftaran_id));
			}
			else
			{
				
				return array(
					'status'=>500,
					'message'=>'Submit ke Apotek gagal, karena tidak ada inputan obat.',
				);
			}
		}
		else if($status=='sudah diperiksa')
		{
			$data_layanan=array(
				'pemeriksaan_status'=>'sudah diperiksa',
			);
			$this->CI->db->update('trx_pemeriksaan',$data_layanan,array('pemeriksaan_id'=>$id));
			$data_layanan=array(
				'pendaftaran_status'=>'pemeriksaan',
			);
			$this->CI->db->update('trx_pendaftaran',$data_layanan,array('pendaftaran_id'=>$pemeriksaan_pendaftaran_id));
		}	
				
		return array(
			'status'=>200,
			'message'=>'',
		);
	}
	
	function store_form($id=0)
	{ 
		$status=200;
		$message='Data berhasil diubah.';
		$pemeriksaan_id=$this->CI->input->post('pemeriksaan_id');
		$admin_user_id=common_lib::admin_user_id();
		$data_pasien=array( 
			'pemeriksaan_alergi'=>$this->CI->input->post('pemeriksaan_alergi'),
			'pemeriksaan_anamnesis'=>$this->CI->input->post('pemeriksaan_anamnesis'),
			'pemeriksaan_pemeriksaan'=>$this->CI->input->post('pemeriksaan_pemeriksaan'),
			'pemeriksaan_weight'=>$this->CI->input->post('pemeriksaan_weight',true),
			'pemeriksaan_height'=>$this->CI->input->post('pemeriksaan_height',true),
			'pemeriksaan_tension'=>$this->CI->input->post('pemeriksaan_tension',true),
			'pemeriksaan_respiration'=>$this->CI->input->post('pemeriksaan_respiration',true),
			'pemeriksaan_nadi'=>$this->CI->input->post('pemeriksaan_nadi',true),
			'pemeriksaan_suhu'=>$this->CI->input->post('pemeriksaan_suhu',true),
			'pemeriksaan_status'=>$this->CI->input->post('submit',true),
			'pemeriksaan_update_date'=>date('Y-m-d H:i:s'), 
			'pemeriksaan_update_by'=>$admin_user_id, 
		);
		
		$this->CI->db->update('trx_pemeriksaan',$data_pasien,array('pemeriksaan_id'=>$pemeriksaan_id));
		
		 
		$pemeriksaan_diagnosis_id=isset($_POST['pemeriksaan_diagnosis_id'])?$_POST['pemeriksaan_diagnosis_id']:array();
		$pemeriksaan_diagnosis_name=isset($_POST['pemeriksaan_diagnosis_name'])?$_POST['pemeriksaan_diagnosis_name']:array();
		$pemeriksaan_diagnosis_pemeriksaan_id=$pemeriksaan_id;
		$this->CI->db->query('DELETE FROM `trx_pemeriksaan_diagnosis` WHERE `pemeriksaan_diagnosis_pemeriksaan_id`='.intval($pemeriksaan_id).'');
		if(!empty($pemeriksaan_diagnosis_id))
		{
			foreach($pemeriksaan_diagnosis_id as $index=>$value)
			{
				$data_layanan=array(
					'pemeriksaan_diagnosis_pemeriksaan_id'=>intval($pemeriksaan_id),
					'pemeriksaan_diagnosis_id'=>(isset($pemeriksaan_diagnosis_id[$index])?$pemeriksaan_diagnosis_id[$index]:0),
					'pemeriksaan_diagnosis_name'=>(isset($pemeriksaan_diagnosis_name[$index])?$pemeriksaan_diagnosis_name[$index]:'-'),
				);
				$this->CI->db->insert('trx_pemeriksaan_diagnosis',$data_layanan);
			}
		}
		
		$pendaftaran_layanan_id=isset($_POST['pendaftaran_layanan_id'])?$_POST['pendaftaran_layanan_id']:array();
		$pendaftaran_layanan_pendaftaran_id=isset($_POST['pendaftaran_layanan_pendaftaran_id'])?$_POST['pendaftaran_layanan_pendaftaran_id']:array();
		$pendaftaran_layanan_pemeriksaan_id=isset($_POST['pendaftaran_layanan_pemeriksaan_id'])?$_POST['pendaftaran_layanan_pemeriksaan_id']:array();
		$pendaftaran_layanan_dokter_id=isset($_POST['pendaftaran_layanan_dokter_id'])?$_POST['pendaftaran_layanan_dokter_id']:array();
		$pendaftaran_layanan_perawat_id=isset($_POST['pendaftaran_layanan_perawat_id'])?$_POST['pendaftaran_layanan_perawat_id']:array();
		$pendaftaran_layanan_layanan_name=isset($_POST['pendaftaran_layanan_layanan_name'])?$_POST['pendaftaran_layanan_layanan_name']:array();
		$pendaftaran_layanan_dokter_name=isset($_POST['pendaftaran_layanan_dokter_name'])?$_POST['pendaftaran_layanan_dokter_name']:array();
		$pendaftaran_layanan_perawat_name=isset($_POST['pendaftaran_layanan_perawat_name'])?$_POST['pendaftaran_layanan_perawat_name']:array();
		$pendaftaran_layanan_pemeriksaan_name=isset($_POST['pendaftaran_layanan_pemeriksaan_name'])?$_POST['pendaftaran_layanan_pemeriksaan_name']:array();
		$not_in='';
		if(!empty($pendaftaran_layanan_pemeriksaan_id))
		{
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
				if(isset($pendaftaran_layanan_id[$index])&&$pendaftaran_layanan_id[$index]>0)
				{
					$this->CI->db->update('trx_pendaftaran_layanan',$data_layanan,array('pendaftaran_layanan_id'=>$pendaftaran_layanan_id[$index]));
					$not_in.=(trim($not_in)!='')?','.$pendaftaran_layanan_id[$index]:$pendaftaran_layanan_id[$index];
				}
				else 
				{
					$this->CI->db->insert('trx_pendaftaran_layanan',$data_layanan);
					$_pendaftaran_layanan_id=$this->CI->db->insert_id();
					$not_in.=(trim($not_in)!='')?','.$_pendaftaran_layanan_id:$_pendaftaran_layanan_id;
				}
			}
			
		}
		
		if(trim($not_in)!='')
		{
			$this->CI->db->query('DELETE FROM `trx_pendaftaran_layanan` WHERE `pendaftaran_layanan_pendaftaran_id`='.intval($pendaftaran_layanan_pendaftaran_id).'
				and pendaftaran_layanan_id not IN ('.$not_in.')
			');
		}
		else
		{			
			$this->CI->db->query('DELETE FROM `trx_pendaftaran_layanan` WHERE `pendaftaran_layanan_pendaftaran_id`='.intval($pendaftaran_layanan_pendaftaran_id).'
			');
		}
		
		// $pemeriksaan_obat_id=$this->CI->input->post('pemeriksaan_obat_id');
		
		$pemeriksaan_obat_name=isset($_POST['pemeriksaan_obat_name'])?$_POST['pemeriksaan_obat_name']:array();
		$pemeriksaan_obat_kemasan_id=isset($_POST['pemeriksaan_obat_kemasan_id'])?$_POST['pemeriksaan_obat_kemasan_id']:array();
		$pemeriksaan_obat_kemasan_name=isset($_POST['pemeriksaan_obat_kemasan_name'])?$_POST['pemeriksaan_obat_kemasan_name']:array();
		$pemeriksaan_obat_resep=isset($_POST['pemeriksaan_obat_resep'])?$_POST['pemeriksaan_obat_resep']:array();
		$pemeriksaan_obat_qty=isset($_POST['pemeriksaan_obat_qty'])?$_POST['pemeriksaan_obat_qty']:array();
		$pemeriksaan_obat_dosis=isset($_POST['pemeriksaan_obat_dosis'])?$_POST['pemeriksaan_obat_dosis']:array();
		$pemeriksaan_obat_aturan_pakai=isset($_POST['pemeriksaan_obat_aturan_pakai'])?$_POST['pemeriksaan_obat_aturan_pakai']:array();
		$pemeriksaan_obat_pemeriksaan_id=$pemeriksaan_id;
		$this->CI->db->query('DELETE FROM `trx_pemeriksaan_obat` WHERE `pemeriksaan_obat_pemeriksaan_id`='.intval($pemeriksaan_id).'');
		if(!empty($pemeriksaan_obat_name))
		{
			foreach($pemeriksaan_obat_name as $index=>$value)
			{
				$data_obat=array(
					'pemeriksaan_obat_pemeriksaan_id'=>intval($pemeriksaan_id),
					// 'pemeriksaan_obat_id'=>(isset($pemeriksaan_obat_id[$index])?$pemeriksaan_obat_id[$index]:0),
					'pemeriksaan_obat_name'=>(isset($pemeriksaan_obat_name[$index])?$pemeriksaan_obat_name[$index]:'-'),
					'pemeriksaan_obat_qty'=>(isset($pemeriksaan_obat_qty[$index])?$pemeriksaan_obat_qty[$index]:'0'),
					'pemeriksaan_obat_dosis'=>(isset($pemeriksaan_obat_dosis[$index])?$pemeriksaan_obat_dosis[$index]:'0'),
					'pemeriksaan_obat_aturan_pakai'=>(isset($pemeriksaan_obat_aturan_pakai[$index])?$pemeriksaan_obat_aturan_pakai[$index]:'-'),
					'pemeriksaan_obat_kemasan_id'=>(isset($pemeriksaan_obat_kemasan_id[$index])?$pemeriksaan_obat_kemasan_id[$index]:'-'),
					'pemeriksaan_obat_kemasan_name'=>(isset($pemeriksaan_obat_kemasan_name[$index])?$pemeriksaan_obat_kemasan_name[$index]:'-'),
					'pemeriksaan_obat_resep'=>(isset($pemeriksaan_obat_resep[$index])?$pemeriksaan_obat_resep[$index]:'-'),
				);
				$this->CI->db->insert('trx_pemeriksaan_obat',$data_obat);
			}
			
		}
		
		$response=$this->status_pemeriksaan($id,$pendaftaran_layanan_pendaftaran_id);
		$status=$response['status'];
		$message=($response['status']!=200)?$response['message']:$message;
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
                     'field'   => "pemeriksaan_alergi",
                     'label'   => 'Alergi',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_weight",
                     'label'   => 'Berat',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_height",
                     'label'   => 'Tinggi',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_tension",
                     'label'   => 'Tekanan Darah',
                     'rules'   => 'trim|required'
                ),   
                array(
                     'field'   => "pemeriksaan_respiration",
                     'label'   => 'Respiratory Rate',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_nadi",
                     'label'   => 'Nadi',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_suhu",
                     'label'   => 'Suhu Tubuh',
                     'rules'   => 'trim|required'
                ),   
                array(
                     'field'   => "pemeriksaan_anamnesis",
                     'label'   => 'Anamnesis',
                     'rules'   => 'trim|required'
                ),    
                array(
                     'field'   => "pemeriksaan_pemeriksaan",
                     'label'   => 'Pemeriksaan Fisik',
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
                     'field'   => "pemeriksaan_alergi",
                     'label'   => 'Alergi',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_weight",
                     'label'   => 'Berat',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_height",
                     'label'   => 'Tinggi',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_tension",
                     'label'   => 'Tekanan Darah',
                     'rules'   => 'trim|required'
                ),   
                array(
                     'field'   => "pemeriksaan_respiration",
                     'label'   => 'Respiratory Rate',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_nadi",
                     'label'   => 'Nadi',
                     'rules'   => 'trim|required'
                ),  
                array(
                     'field'   => "pemeriksaan_suhu",
                     'label'   => 'Suhu Tubuh',
                     'rules'   => 'trim|required'
                ),   
                array(
                     'field'   => "pemeriksaan_anamnesis",
                     'label'   => 'Anamnesis',
                     'rules'   => 'trim|required'
                ),    
                array(
                     'field'   => "pemeriksaan_pemeriksaan",
                     'label'   => 'Pemeriksaan Fisik',
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
	
	function get_data_apotek()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'trx_pemeriksaan';
        $params['select'] = "*";
        $params['join'] = "JOIN trx_pendaftaran on pendaftaran_id=pemeriksaan_pendaftaran_id";
        $where='1 AND pendaftaran_status!="pendaftaran"';
         
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
        $params['order_by'] = "pemeriksaan_id DESC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query,
			'total'=>$total,
		);
	}

	function get_data_lab()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'trx_pemeriksaan';
        $params['select'] = "*";
        $params['join'] = "JOIN trx_pendaftaran on pendaftaran_id=pemeriksaan_pendaftaran_id";
        $where='1 AND pendaftaran_status!="pendaftaran" AND pendaftaran_pasien_id>0';
         
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
        $params['order_by'] = "pemeriksaan_id DESC";

        $query = $this->CI->common_lib->get_query($params);
        $total = $this->CI->common_lib->get_query($params, true);

		return array(
			'query'=>$query,
			'total'=>$total,
		);
	}

	function get_data()
	{ 
        $params = isset($_POST) ? $_POST : array();
        
        $params['table'] = 'trx_pemeriksaan';
        $params['select'] = "*";
        $params['join'] = "JOIN trx_pendaftaran on pendaftaran_id=pemeriksaan_pendaftaran_id";
        $where='1 AND pendaftaran_status!="pendaftaran"';
         
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
        $params['order_by'] = "pemeriksaan_id DESC";

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