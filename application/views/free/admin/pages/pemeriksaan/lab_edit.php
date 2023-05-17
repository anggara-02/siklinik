<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ -->
	
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>   
<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Laboratorium</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Pemeriksaan</a></div>
      	<div class="breadcrumb-item">Laboratorium</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Laboratorium</h4>
      	</div>
      	<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td width="200">No RM</td>
							<td width="10" align="center">:</td>
							<td><?php echo isset($pendaftaran_pasien_rm)?$pendaftaran_pasien_rm:'-';?></td>
							<td width="200">Nama Pasien</td>
							<td width="10" align="center">:</td>
							<td><?php echo isset($pendaftaran_pasien_name)?$pendaftaran_pasien_name:'-';?></td>
						</tr>
						<tr>
							<td width="200">Jenis Penjaminan</td>
							<td width="10" align="center">:</td>
							<td><?php echo isset($pendaftaran_penjamin_nama)?$pendaftaran_penjamin_nama:'-';?></td>
							<td width="200">Usia</td>
							<td width="10" align="center">:</td>
							<td><?php echo isset($pendaftaran_pasien_birthdate)?$this->common_lib->calculate_age($pendaftaran_pasien_birthdate):'-';?></td>
						</tr>
						<tr>
							<td width="200">No Penjaminan</td>
							<td width="10" align="center">:</td>
							<td><?php echo isset($pendaftaran_penjamin_no)?$pendaftaran_penjamin_no:'-';?></td>
							<td width="200">Alamat</td>
							<td width="10" align="center">:</td>
							<td><?php echo isset($pendaftaran_pasien_address)?$pendaftaran_pasien_address:'-';?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-body">
			<form action="#" method="POST" enctype="multipart/form-data" enctype="multipart/form-data">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-7">
						<div class="table-responsive">
							<table class="table table-product2 table-bordered table-sm">
								<thead>
									<tr>
										<th>Layanan Laboratorium</th>
										<th>Hasil</th>
									</tr>
								</thead>
								<tbody class="row_add_lab">
									<?php if(!empty($layanan_lab)){
												$index=0;
												foreach($layanan_lab as $row){
												$file=trim($row['pendaftaran_layanan_hasil'])!=''&&file_exists(FCPATH.$row['pendaftaran_layanan_hasil'])?base_url($row['pendaftaran_layanan_hasil']):'';
										?>
										<tr>
											<td>
												[<?php echo $row['pendaftaran_layanan_layanan_name'];?>] <?php echo $row['pendaftaran_layanan_pemeriksaan_name'];?>
												<br/>
												<small>Dokter : <?php echo $row['pendaftaran_layanan_dokter_name'];?></small>
												<br/>
												<small>Perawat : <?php echo $row['pendaftaran_layanan_perawat_name'];?></small>
												<input type="hidden" name="pendaftaran_layanan_id[]" value="<?php echo $row['pendaftaran_layanan_id'];?>">
											</td>
											<td>
												<input type="file" class="form-control" name="pendaftaran_layanan_hasil_<?php echo $index;?>" <?php echo trim($file)!=''?'':'required';?>												accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf">
												<br/>
												<?php if(trim($file)!=''){?>
												<a href="<?php echo $file;?>" target="__BLANK"><i class="fa fa-file fa-2x"></i> Hasil <?php echo $row['pendaftaran_layanan_pemeriksaan_name'];?></a>
												<?php } ?>
											</td>
											
										</tr>
									<?php $index++; } } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-2 col-lg-2"></label>
					<div class="col-sm-12 col-md-9">
						<input type="hidden" class="form-control" name="pemeriksaan_id" value="<?php echo (isset($pemeriksaan_id)?$pemeriksaan_id:'');?>"> 
						<button class="btn btn-primary" name="submit" value="sudah diperiksa">Submit ke Pemeriksaan</button>
						<button class="btn btn-warning" name="submit" value="pendaftaran">Submit ke Pendaftaran</button>
						<button class="btn btn-dark" name="submit" value="apotek">Submit ke Apotek</button>
						<button class="btn btn-success" name="submit" value="kasir">Submit ke Kasir</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
	$(function(){
		$('.form-select2').select2();
	});
	
	function add_row_diagnosa()
	{
		diagnosis_id=$('[name="diagnosis_id"]').val();
		diagnosis_name=$('[name="diagnosis_id"]  option:selected').text();
		if(diagnosis_id==''||diagnosis_name=='')
		{
			alert('Silahkan pilih diagnosa');
		}
		else
		{
			
			html='<tr class="tr_data trr_'+diagnosis_id+'">'
						+'<td class="td">'
							+'<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();return false;"><i class="fa fa-minus"></i></button>'
							+diagnosis_name 
							+'<input type="hidden" name="pemeriksaan_diagnosis_id[]" value="'+diagnosis_id+'">'
							+'<input type="hidden" name="pemeriksaan_diagnosis_name[]" value="'+diagnosis_name+'">' 
						+'</td>'
				+'</tr>'
				;
					
			$('.row_add_diagnosis').append(html);
		}
	}

	
	function add_lab()
	{
		div_pendaftaran_layanan_pemeriksaan_id=$('[name="pendaftaran_layanan_lab_id"]').val();
		div_pendaftaran_layanan_pemeriksaan_name=$('[name="pendaftaran_layanan_lab_id"]  option:selected').text();
		div_pendaftaran_layanan_layanan_id=0;
		div_pendaftaran_layanan_layanan_name=$('[name="div_pendaftaran_layanan_lab_layanan_name"]').val();
		div_pendaftaran_layanan_dokter_id=$('[name="jadwal_lab_dokter_id"]').val();
		div_pendaftaran_layanan_dokter_name=$('[name="jadwal_lab_dokter_name"]').val();
		div_pendaftaran_layanan_perawat_id=$('[name="jadwal_lab_perawat_id"]').val();
		div_pendaftaran_layanan_perawat_name=$('[name="jadwal_lab_perawat_name"]').val();
		if(div_pendaftaran_layanan_perawat_name==''||div_pendaftaran_layanan_perawat_id=='' ||div_pendaftaran_layanan_pemeriksaan_id=='' ||div_pendaftaran_layanan_pemeriksaan_name=='' ||div_pendaftaran_layanan_layanan_name=='' ||div_pendaftaran_layanan_dokter_id=='' ||div_pendaftaran_layanan_dokter_name=='')
		{
			alert('Silahkan isi semua data');
		}
		else
		{
			html='<tr class="tr_data trr_'+div_pendaftaran_layanan_pemeriksaan_id+'">'
						+'<td class="td">'
							+'<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();return false;"><i class="fa fa-minus"></i></button>'
							+'['+div_pendaftaran_layanan_layanan_name+'] '+div_pendaftaran_layanan_pemeriksaan_name
							+'<br/>'
							+'<small>Dokter : '+div_pendaftaran_layanan_dokter_name+'</small>'
							+'<br/>'
							+'<small>Perawat : '+div_pendaftaran_layanan_perawat_name+'</small>'
							+'<input type="hidden" name="pendaftaran_layanan_layanan_id[]" value="'+div_pendaftaran_layanan_layanan_id+'">'
							+'<input type="hidden" name="pendaftaran_layanan_pemeriksaan_id[]" value="'+div_pendaftaran_layanan_pemeriksaan_id+'">'
							+'<input type="hidden" name="pendaftaran_layanan_dokter_id[]" value="'+div_pendaftaran_layanan_dokter_id+'">'
							+'<input type="hidden" name="pendaftaran_layanan_perawat_id[]" value="'+div_pendaftaran_layanan_perawat_id+'">'
							+'<input type="hidden" name="pendaftaran_layanan_layanan_name[]" value="'+div_pendaftaran_layanan_layanan_name+'">'
							+'<input type="hidden" name="pendaftaran_layanan_dokter_name[]" value="'+div_pendaftaran_layanan_dokter_name+'">'
							+'<input type="hidden" name="pendaftaran_layanan_perawat_name[]" value="'+div_pendaftaran_layanan_perawat_name+'">'
							+'<input type="hidden" name="pendaftaran_layanan_pemeriksaan_name[]" value="'+div_pendaftaran_layanan_pemeriksaan_name+'">'
						+'</td>'
				+'</tr>'
				;
					
			$('.row_add_lab').append(html);
			
			
			// $('[name="div_pendaftaran_layanan_pemeriksaan_id"]').val('0');
			// $('[name="div_pendaftaran_layanan_layanan_name"]').val('');
			// $('[name="div_pendaftaran_layanan_dokter_id"]').val('0');
			// $('[name="div_pendaftaran_layanan_dokter_name"]').val('');
			// $('[name="div_pendaftaran_layanan_perawat_id"]').val('0');
			// $('[name="div_pendaftaran_layanan_perawat_name"]').val('');
		}
	}
	
	function add_tindakan()
	{
		div_pendaftaran_layanan_pemeriksaan_id=$('[name="div_pendaftaran_layanan_id"]').val();
		div_pendaftaran_layanan_pemeriksaan_name=$('[name="div_pendaftaran_layanan_id"]  option:selected').text();
		div_pendaftaran_layanan_layanan_id=0;
		div_pendaftaran_layanan_layanan_name=$('[name="div_pendaftaran_layanan_layanan_name"]').val();
		div_pendaftaran_layanan_dokter_id=$('[name="jadwal_dokter_id"]').val();
		div_pendaftaran_layanan_dokter_name=$('[name="jadwal_dokter_name"]').val();
		div_pendaftaran_layanan_perawat_id=$('[name="jadwal_perawat_id"]').val();
		div_pendaftaran_layanan_perawat_name=$('[name="jadwal_perawat_name"]').val();
		if(div_pendaftaran_layanan_perawat_name==''||div_pendaftaran_layanan_perawat_id=='' ||div_pendaftaran_layanan_pemeriksaan_id=='' ||div_pendaftaran_layanan_pemeriksaan_name=='' ||div_pendaftaran_layanan_layanan_name=='' ||div_pendaftaran_layanan_dokter_id=='' ||div_pendaftaran_layanan_dokter_name=='')
		{
			alert('Silahkan isi semua data');
		}
		else
		{
			html='<tr class="tr_data trr_'+div_pendaftaran_layanan_pemeriksaan_id+'">'
						+'<td class="td">'
							+'<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();return false;"><i class="fa fa-minus"></i></button>'
							+'['+div_pendaftaran_layanan_layanan_name+'] '+div_pendaftaran_layanan_pemeriksaan_name
							+'<br/>'
							+'<small>Dokter : '+div_pendaftaran_layanan_dokter_name+'</small>'
							+'<br/>'
							+'<small>Perawat : '+div_pendaftaran_layanan_perawat_name+'</small>'
							+'<input type="hidden" name="pendaftaran_layanan_layanan_id[]" value="'+div_pendaftaran_layanan_layanan_id+'">'
							+'<input type="hidden" name="pendaftaran_layanan_pemeriksaan_id[]" value="'+div_pendaftaran_layanan_pemeriksaan_id+'">'
							+'<input type="hidden" name="pendaftaran_layanan_dokter_id[]" value="'+div_pendaftaran_layanan_dokter_id+'">'
							+'<input type="hidden" name="pendaftaran_layanan_perawat_id[]" value="'+div_pendaftaran_layanan_perawat_id+'">'
							+'<input type="hidden" name="pendaftaran_layanan_layanan_name[]" value="'+div_pendaftaran_layanan_layanan_name+'">'
							+'<input type="hidden" name="pendaftaran_layanan_dokter_name[]" value="'+div_pendaftaran_layanan_dokter_name+'">'
							+'<input type="hidden" name="pendaftaran_layanan_perawat_name[]" value="'+div_pendaftaran_layanan_perawat_name+'">'
							+'<input type="hidden" name="pendaftaran_layanan_pemeriksaan_name[]" value="'+div_pendaftaran_layanan_pemeriksaan_name+'">'
						+'</td>'
						+'<td>'
						+'</td>'
				+'</tr>'
				;
					
			$('.row_add_tindakan').append(html);
			
			
			// $('[name="div_pendaftaran_layanan_pemeriksaan_id"]').val('0');
			// $('[name="div_pendaftaran_layanan_layanan_name"]').val('');
			// $('[name="div_pendaftaran_layanan_dokter_id"]').val('0');
			// $('[name="div_pendaftaran_layanan_dokter_name"]').val('');
			// $('[name="div_pendaftaran_layanan_perawat_id"]').val('0');
			// $('[name="div_pendaftaran_layanan_perawat_name"]').val('');
		}
	}

	function add_row_obat()
	{
		pemeriksaan_obat_resep=$('[name="pemeriksaan_obat_resep"]').val();
		pemeriksaan_obat_name=$('[name="pemeriksaan_obat_name"]').val();
		pemeriksaan_obat_kemasan_id=$('[name="pemeriksaan_obat_kemasan_id"]').val();
		pemeriksaan_obat_kemasan_name=$('[name="pemeriksaan_obat_kemasan_id"]  option:selected').text();
		pemeriksaan_obat_qty=$('[name="pemeriksaan_obat_qty"]').val();
		pemeriksaan_obat_dosis=$('[name="pemeriksaan_obat_dosis"]').val();
		pemeriksaan_obat_aturan_pakai=$('[name="pemeriksaan_obat_aturan_pakai"]').val();
		if(pemeriksaan_obat_resep==''||pemeriksaan_obat_name==''||pemeriksaan_obat_kemasan_id==''||pemeriksaan_obat_qty==''||pemeriksaan_obat_dosis==''||pemeriksaan_obat_aturan_pakai=='')
		{
			alert('Silahkan pilih diagnosa');
		}
		else
		{
			html='<tr class="tr_data">'
						+'<td class="td">'
							+'<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();return false;"><i class="fa fa-minus"></i></button>'
						+'</td>'
						+'<td class="td">'
							+pemeriksaan_obat_resep 
							+'<input type="hidden" name="pemeriksaan_obat_resep[]" value="'+pemeriksaan_obat_resep+'">' 
						+'</td>'
						+'<td class="td">'+pemeriksaan_obat_name 
							+'<input type="hidden" name="pemeriksaan_obat_name[]" value="'+pemeriksaan_obat_name+'">' 
						+'</td>'
						+'<td class="td">'+pemeriksaan_obat_kemasan_name 
							+'<input type="hidden" name="pemeriksaan_obat_kemasan_name[]" value="'+pemeriksaan_obat_kemasan_name+'">' 
							+'<input type="hidden" name="pemeriksaan_obat_kemasan_id[]" value="'+pemeriksaan_obat_kemasan_id+'">' 
						+'</td>'
						+'<td class="td">'+pemeriksaan_obat_qty 
							+'<input type="hidden" name="pemeriksaan_obat_qty[]" value="'+pemeriksaan_obat_qty+'">' 
						+'</td>'
						+'<td class="td">'+pemeriksaan_obat_dosis 
							+'<input type="hidden" name="pemeriksaan_obat_dosis[]" value="'+pemeriksaan_obat_dosis+'">' 
						+'</td>'
						+'<td class="td">'+pemeriksaan_obat_aturan_pakai 
							+'<input type="hidden" name="pemeriksaan_obat_aturan_pakai[]" value="'+pemeriksaan_obat_aturan_pakai+'">' 
						+'</td>'
				+'</tr>'
				; 
					
			$('.add_row_obat').append(html);
			
			
			$('[name="pemeriksaan_obat_resep"]').val('');
			$('[name="pemeriksaan_obat_name"]').val('');
			// pemeriksaan_obat_kemasan_id=$('[name="pemeriksaan_obat_kemasan_id"]').val();
			// pemeriksaan_obat_kemasan_name=$('[name="pemeriksaan_obat_kemasan_id"]  option:selected').text();
			$('[name="pemeriksaan_obat_qty"]').val('');
			$('[name="pemeriksaan_obat_dosis"]').val('');
			$('[name="pemeriksaan_obat_aturan_pakai"]').val('');
		}
	}
</script>