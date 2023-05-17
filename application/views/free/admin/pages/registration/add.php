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
        <div class="row">
          <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">  
					<form class="form-horizontal" id="psForm" method="POST" action="" enctype="multipart/form-data">
					  <?php 
							if(trim($status)!='' AND trim($message)!=''){
						  ?>
								<div class="row custom_message">
									<div class="col-sm-12 control-label"> 
										<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
										  <div style="text-align:left;"><i class="<?php echo ($status==200)?'icon-thumbs-up':'icon-remove'; ?>"></i><?php echo $message; ?></div>
										  

										</div>
									</div>
								</div>
						  <?php
							}
						  ?>  
						  
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No RM/NIK/BPJS</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" id="search_pasien" name="search_pasien"  value="<?php echo $this->input->post('search_pasien')?$this->input->post('search_pasien'):(isset($search_pasien)?$search_pasien:''); ?>">
						<input type="hidden" class="form-control" name="pendaftaran_pasien_id" value="<?php echo $this->input->post('pendaftaran_pasien_id')?$this->input->post('pendaftaran_pasien_id'):(isset($pendaftaran_pasien_id)?$pendaftaran_pasien_id:'0'); ?>"> 
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Pasien</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" name="pendaftaran_pasien_name"  maxlength="255" required value="<?php echo $this->input->post('pendaftaran_pasien_name')?$this->input->post('pendaftaran_pasien_name'):(isset($pendaftaran_pasien_name)?$pendaftaran_pasien_name:''); ?>"> 
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NIK</label>
					<div class="col-sm-12 col-md-7">
						<input type="number" class="form-control" name="pendaftaran_pasien_nik" maxlength="30"  required value="<?php echo $this->input->post('pendaftaran_pasien_nik')?$this->input->post('pendaftaran_pasien_nik'):(isset($pendaftaran_pasien_nik)?$pendaftaran_pasien_nik:''); ?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Ibu Kandung</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" name="pendaftaran_pasien_ibu"  maxlength="255" required value="<?php echo $this->input->post('pendaftaran_pasien_ibu')?$this->input->post('pendaftaran_pasien_ibu'):(isset($pendaftaran_pasien_ibu)?$pendaftaran_pasien_ibu:''); ?>"> 
					</div>
				</div> 
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
					<div class="col-sm-12 col-md-7">
						<textarea cols="30" rows="5" name="pendaftaran_pasien_address"  class="form-control h-auto"><?php echo $this->input->post('pendaftaran_pasien_address')?$this->input->post('pendaftaran_pasien_address'):(isset($pendaftaran_pasien_address)?$pendaftaran_pasien_address:''); ?></textarea>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
					<div class="col-sm-12 col-md-7">
						<select class="form-input form-select2 form-control" style="width: 100%;" name="pendaftaran_pasien_gender" data-placeholder="Pilih Jenis Kelamin">
							<option >Silahkan Pilih</option>
							<option value="male" <?php echo $this->input->post('pendaftaran_pasien_gender')=='male'?'selected':(isset($pendaftaran_pasien_gender)&&$pendaftaran_pasien_gender=='male'?'selected':''); ?>>Laki-laki</option>
							<option value="female" <?php echo $this->input->post('pendaftaran_pasien_gender')=='female'?'selected':(isset($pendaftaran_pasien_gender)&&$pendaftaran_pasien_gender=='female'?'selected':''); ?>>Perempuan</option>
						</select>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tempat Lahir</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" name="pendaftaran_pasien_birthplace" maxlength="255" required value="<?php echo $this->input->post('pendaftaran_pasien_birthplace')?$this->input->post('pendaftaran_pasien_birthplace'):(isset($pendaftaran_pasien_birthplace)?$pendaftaran_pasien_birthplace:''); ?>"> 
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Lahir</label>
					<div class="col-sm-12 col-md-7">
						<input type="date" class="form-control" name="pendaftaran_pasien_birthdate" required value="<?php echo $this->input->post('pendaftaran_pasien_birthdate')?$this->input->post('pendaftaran_pasien_birthdate'):(isset($pendaftaran_pasien_birthdate)?$pendaftaran_pasien_birthdate:''); ?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Perkawinan</label>
					<div class="col-sm-12 col-md-7">
						<select name="pendaftaran_pasien_pernikahan" class="form-input form-select2 form-control" style="width: 100%;" data-placeholder="Pilih Status Perkawinan">
							<option >Silahkan Pilih</option>
							<option value="kawin" <?php echo $this->input->post('pendaftaran_pasien_pernikahan')=='kawin'?'selected':(isset($pendaftaran_pasien_pernikahan)&&$pendaftaran_pasien_pernikahan=='kawin'?'selected':''); ?>>Kawin</option>
							<option value="tidak kawin" <?php echo $this->input->post('pendaftaran_pasien_pernikahan')=='tidak kawin'?'selected':(isset($pendaftaran_pasien_pernikahan)&&$pendaftaran_pasien_pernikahan=='tidak kawin'?'selected':''); ?>>Tidak Kawin</option>
						</select>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Penjaminan</label>
					<div class="col-sm-12 col-md-7">
						<select name="pendaftaran_penjamin_id" class="form-input form-select2 form-control" style="width: 100%;" data-placeholder="Pilih Jenis Penjaminan">
							<option >Silahkan Pilih</option>
							<?php foreach($penjamin_arr as $row){?>
								<option value="<?php echo $row['penjamin_id'];?>" <?php echo $this->input->post('pendaftaran_penjamin_id')==$row['penjamin_id']?'selected':(isset($pendaftaran_penjamin_id)&&$pendaftaran_penjamin_id==$row['penjamin_id']?'selected':''); ?>><?php echo $row['penjamin_name'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Penjaminan</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" name="pendaftaran_penjamin_no" value="<?php echo $this->input->post('pendaftaran_penjamin_no')?$this->input->post('pendaftaran_penjamin_no'):(isset($pendaftaran_penjamin_no)?$pendaftaran_penjamin_no:''); ?>">
					</div>
				</div>
				<hr/>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pekerjaan Penanggung Jawab</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" required name="pendaftaran_pasien_penanggung_jawab_pekerjaan" value="<?php echo $this->input->post('pendaftaran_pasien_penanggung_jawab_pekerjaan')?$this->input->post('pendaftaran_pasien_penanggung_jawab_pekerjaan'):(isset($pendaftaran_pasien_penanggung_jawab_pekerjaan)?$pendaftaran_pasien_penanggung_jawab_pekerjaan:''); ?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telp Penanggung Jawab</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" required name="pendaftaran_pasien_penanggung_jawab_telp" value="<?php echo $this->input->post('pendaftaran_pasien_penanggung_jawab_telp')?$this->input->post('pendaftaran_pasien_penanggung_jawab_telp'):(isset($pendaftaran_pasien_penanggung_jawab_telp)?$pendaftaran_pasien_penanggung_jawab_telp:''); ?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Penanggung Jawab</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" required name="pendaftaran_pasien_penanggung_jawab_name" value="<?php echo $this->input->post('pendaftaran_pasien_penanggung_jawab_name')?$this->input->post('pendaftaran_pasien_penanggung_jawab_name'):(isset($pendaftaran_pasien_penanggung_jawab_name)?$pendaftaran_pasien_penanggung_jawab_name:''); ?>">
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Layanan Medis</label>
					<div class="col-sm-12 col-md-7">
						<select name="div_pendaftaran_layanan_layanan_name" id="div_pendaftaran_layanan_layanan_name" onchange="change_nakes()" class="form-input form-select2 form-control" style="width: 100%;" data-placeholder="Pilih Layanan Medis">
							<option value="">Silahkan Pilih</option>
							<option value="Umum" data-dokter-id="<?php echo (isset($jadwal_umum_arr['jadwal_dokter_id'])?$jadwal_umum_arr['jadwal_dokter_id']:0);?>" data-dokter-name="<?php echo (isset($jadwal_umum_arr['jadwal_dokter_name'])?$jadwal_umum_arr['jadwal_dokter_name']:'-');?>" data-perawat-id="<?php echo (isset($jadwal_umum_arr['jadwal_perawat_id'])?$jadwal_umum_arr['jadwal_perawat_id']:'0');?>" data-perawat-name="<?php echo (isset($jadwal_umum_arr['jadwal_perawat_name'])?$jadwal_umum_arr['jadwal_perawat_name']:'-');?>" <?php echo $this->input->post('div_pendaftaran_layanan_layanan_name')=='Umum'?'selected':(isset($div_pendaftaran_layanan_layanan_name)&&$div_pendaftaran_layanan_layanan_name=='Umum'?'selected':''); ?>>Umum</option>
							<option value="Laboratorium" data-dokter-id="<?php echo (isset($jadwal_lab_arr['jadwal_dokter_id'])?$jadwal_lab_arr['jadwal_dokter_id']:0);?>" data-dokter-name="<?php echo (isset($jadwal_lab_arr['jadwal_dokter_name'])?$jadwal_lab_arr['jadwal_dokter_name']:'-');?>" data-perawat-id="<?php echo (isset($jadwal_lab_arr['jadwal_perawat_id'])?$jadwal_lab_arr['jadwal_perawat_id']:'0');?>" data-perawat-name="<?php echo (isset($jadwal_lab_arr['jadwal_perawat_name'])?$jadwal_lab_arr['jadwal_perawat_name']:'-');?>"  <?php echo $this->input->post('div_pendaftaran_layanan_layanan_name')=='Laboratorium'?'selected':(isset($div_pendaftaran_layanan_layanan_name)&&$div_pendaftaran_layanan_layanan_name=='Laboratorium'?'selected':''); ?>>Laboratorium</option>
						</select>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Dokter</label>
					<div class="col-sm-12 col-md-7">
						<input type="hidden" class="form-control" name="div_pendaftaran_layanan_dokter_id" value="<?php echo $this->input->post('div_pendaftaran_layanan_dokter_id')?$this->input->post('div_pendaftaran_layanan_dokter_id'):(isset($jadwal_arr['jadwal_dokter_id'])?$jadwal_arr['jadwal_dokter_id']:0); ?>" readonly> 
						<input type="text" class="form-control" name="div_pendaftaran_layanan_dokter_name" value="<?php echo $this->input->post('div_pendaftaran_layanan_dokter_name')?$this->input->post('div_pendaftaran_layanan_dokter_name'):(isset($jadwal_arr['jadwal_dokter_name'])?$jadwal_arr['jadwal_dokter_name']:'-'); ?>" readonly> 
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Perawat</label>
					<div class="col-sm-12 col-md-7">
						<input type="hidden" class="form-control" name="div_pendaftaran_layanan_perawat_id" value="<?php echo $this->input->post('div_pendaftaran_layanan_perawat_id')?$this->input->post('div_pendaftaran_layanan_perawat_id'):(isset($jadwal_arr['jadwal_perawat_id'])?$jadwal_arr['jadwal_perawat_id']:0); ?>" readonly> 
						<input type="text" class="form-control" name="div_pendaftaran_layanan_perawat_name" value="<?php echo $this->input->post('div_pendaftaran_layanan_perawat_name')?$this->input->post('div_pendaftaran_layanan_perawat_name'):(isset($jadwal_arr['jadwal_perawat_name'])?$jadwal_arr['jadwal_perawat_name']:'-'); ?>" readonly> 
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original4">
								<div class="col-md-11 px-1">
									<select id="div_pendaftaran_layanan_pemeriksaan_id" name="div_pendaftaran_layanan_pemeriksaan_id" class="form-input form-select2 form-control" style="width: 100%;" data-placeholder="Pilih Pemeriksaan">
										<option value="" >Silahkan Pilih</option>
										<?php foreach($layanan_arr as $row){?>
										<option value="<?php echo $row['layanan_id'];?>" data-layanan="<?php echo strtolower($row['poli_name']);?>"><?php echo $row['layanan_name'];?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-1 px-1">
									<div>
										<button class="btn btn-info btn-clone4" type="button" onclick="add_rows()"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-product4 table-bordered table-sm">
								<thead>
									<tr>
										<th>Nama Pemeriksaan</th>
									</tr>
								</thead>
								<tbody class="row_add">
									<?php
										$pendaftaran_layanan_layanan_id=$this->input->post('pendaftaran_layanan_layanan_id');
										$pendaftaran_layanan_layanan_name=$this->input->post('pendaftaran_layanan_layanan_name');
										$pendaftaran_layanan_dokter_id=$this->input->post('pendaftaran_layanan_dokter_id');
										$pendaftaran_layanan_dokter_name=$this->input->post('pendaftaran_layanan_dokter_name');
										$pendaftaran_layanan_perawat_id=$this->input->post('pendaftaran_layanan_perawat_id');
										$pendaftaran_layanan_perawat_name=$this->input->post('pendaftaran_layanan_perawat_name');
										$pendaftaran_layanan_pemeriksaan_id=$this->input->post('pendaftaran_layanan_pemeriksaan_id');
										$pendaftaran_layanan_pemeriksaan_name=$this->input->post('pendaftaran_layanan_pemeriksaan_name');
										// echo '<pre>';print_r($pendaftaran_layanan_layanan_id);
										if(!empty($pendaftaran_layanan_layanan_id))
										{
											foreach($pendaftaran_layanan_layanan_id as $index=>$value)
											{
									?>
										<tr>
											<td>
											
												<button class="btn btn-info btn-clone4 btn-sm" type="button" onclick="$(this).parent().remove();return false;"><i class="fa fa-minus"></i></button>
												<?php echo isset($pendaftaran_layanan_layanan_name[$index])?'['.$pendaftaran_layanan_layanan_name[$index].']':'-';?>
												<?php echo isset($pendaftaran_layanan_pemeriksaan_name[$index])?$pendaftaran_layanan_pemeriksaan_name[$index]:'-';?>
												<br/>
												<small>Dokter : <?php echo isset($pendaftaran_layanan_dokter_name[$index])?$pendaftaran_layanan_dokter_name[$index]:'-';?></small>
												<br/>
												<small>Perawat : <?php echo isset($pendaftaran_layanan_perawat_name[$index])?$pendaftaran_layanan_perawat_name[$index]:'-';;?></small>
												<input type="hidden" name="pendaftaran_layanan_layanan_id[]" value="<?php echo isset($pendaftaran_layanan_layanan_id[$index])?$pendaftaran_layanan_layanan_id[$index]:0;?>">
												<input type="hidden" name="pendaftaran_layanan_dokter_id[]" value="<?php echo isset($pendaftaran_layanan_dokter_id[$index])?$pendaftaran_layanan_dokter_id[$index]:0;?>">
												<input type="hidden" name="pendaftaran_layanan_perawat_id[]" value="<?php echo isset($pendaftaran_layanan_perawat_id[$index])?$pendaftaran_layanan_perawat_id[$index]:0;?>">
												<input type="hidden" name="pendaftaran_layanan_pemeriksaan_id[]" value="<?php echo isset($pendaftaran_layanan_pemeriksaan_id[$index])?$pendaftaran_layanan_pemeriksaan_id[$index]:0;?>">
												<input type="hidden" name="pendaftaran_layanan_layanan_name[]" value="<?php echo isset($pendaftaran_layanan_layanan_name[$index])?$pendaftaran_layanan_layanan_name[$index]:'-';?>">
												<input type="hidden" name="pendaftaran_layanan_dokter_name[]" value="<?php echo isset($pendaftaran_layanan_dokter_name[$index])?$pendaftaran_layanan_dokter_name[$index]:'-';?>">
												<input type="hidden" name="pendaftaran_layanan_perawat_name[]" value="<?php echo isset($pendaftaran_layanan_perawat_name[$index])?$pendaftaran_layanan_perawat_name[$index]:'-';?>">
												<input type="hidden" name="pendaftaran_layanan_pemeriksaan_name[]" value="<?php echo isset($pendaftaran_layanan_pemeriksaan_name[$index])?$pendaftaran_layanan_pemeriksaan_name[$index]:'-';?>">
												
											</td>
										</tr>
										<?php }}
									?>
									
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
					<div class="col-sm-12 col-md-7">
						<button class="btn btn-primary" name="save" value="1" type="submit">Simpan</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	 </div> 
 </div>  
 <script>
 
$(document).ready(function() { 
	setTimeout(function(){ 
		$('.custom_message').hide();
	}, 5000);	
	find_pasien_lama();
});

	
function change_nakes()
{
	dokter_id=$('[name="div_pendaftaran_layanan_layanan_name"] option:selected').attr('data-dokter-id');
	dokter_name=$('[name="div_pendaftaran_layanan_layanan_name"] option:selected').attr('data-dokter-name');
	perawat_id=$('[name="div_pendaftaran_layanan_layanan_name"] option:selected').attr('data-perawat-id');
	perawat_name=$('[name="div_pendaftaran_layanan_layanan_name"] option:selected').attr('data-perawat-name');
	poli=$('[name="div_pendaftaran_layanan_layanan_name"] option:selected').val().toLowerCase();
	$('[name="div_pendaftaran_layanan_dokter_id"]').val(dokter_id);
	$('[name="div_pendaftaran_layanan_dokter_name"]').val(dokter_name);
	$('[name="div_pendaftaran_layanan_perawat_id"]').val(perawat_id);
	$('[name="div_pendaftaran_layanan_perawat_name"]').val(perawat_name);
	// $('[name="div_pendaftaran_layanan_pemeriksaan_id"]').val(perawat_name);
	
	$("#div_pendaftaran_layanan_pemeriksaan_id option[data-layanan=laboratorium]").hide();
	$("#div_pendaftaran_layanan_pemeriksaan_id option[data-layanan=umum]").hide();
	$("#div_pendaftaran_layanan_pemeriksaan_id option[data-layanan=" + poli + "]").show();
	$("#div_pendaftaran_layanan_pemeriksaan_id").val('');
	
	
	// $('#div_pendaftaran_layanan_pemeriksaan_id').select2('destroy');
	// $('#div_pendaftaran_layanan_pemeriksaan_id').select2();
	console.log(dokter_id+'|'+dokter_name);
	console.log(perawat_id+'|'+perawat_name);
}

function find_pasien_lama()
{ 
	
	  var cacheItem = {};
	  $("#search_pasien").autocomplete({
		  minLength: 2,
		  source: function( request, response ) {
			  var term = request.term;
			  if ( term in cacheItem ) {
				  response( cacheItem[ term ] );
				  return;
			  } 
			  $.getJSON( "<?php echo site_url();?>admin/<?php echo $class?>/search_pasien_by_rm_nik_penjamin", request, function( data, status, xhr ) {
				  $('#pendaftaran_pasien_id').val(''); 
				  cacheItem[ term ] = data;
				  response( data ); 
			  });
		  },
		  select: function (event, ui) {
			return false;
		  },
		  focus: function (event, ui) {  
				$('[name="pendaftaran_pasien_id"]').val(ui.item.id);     
				$('[name="search_pasien"]').val(ui.item.label);     
				$('[name="pasien_rm_number"]').val(ui.item.pasien_rm_number);     
				$('[name="pendaftaran_pasien_name"]').val(ui.item.pasien_name);     
				$('[name="pendaftaran_pasien_nik"]').val(ui.item.pasien_nik);     
				$('[name="pendaftaran_pasien_ibu"]').val(ui.item.pasien_ibu);     
				$('[name="pendaftaran_pasien_address"]').val(ui.item.pasien_address);     
				$('[name="pendaftaran_pasien_gender"]').val(ui.item.pasien_gender);     
				$('[name="pendaftaran_pasien_birthplace"]').val(ui.item.pasien_birthplace);     
				$('[name="pendaftaran_pasien_birthdate"]').val(ui.item.pasien_birthdate);     
				$('[name="pendaftaran_pasien_pernikahan"]').val(ui.item.pasien_pernikahan);     
				$('[name="pendaftaran_penjamin_id"]').val(ui.item.pasien_penjamin_id);     
				$('[name="pendaftaran_penjamin_no"]').val(ui.item.pasien_penjamin_no);     
				$('.pasien_rm_number').show();
				$('[name="pendaftaran_birthdate"]').val(ui.item.pasien_birthdate);  
				$('[name="search_pasien"]').val(ui.item.label);        
				return false;
		  },
	  }).on("focus", function () {
		$(this).autocomplete("search", '');
	  });

}


function add_rows()
{
	div_pendaftaran_layanan_pemeriksaan_id=$('[name="div_pendaftaran_layanan_pemeriksaan_id"]').val();
	div_pendaftaran_layanan_pemeriksaan_name=$('[name="div_pendaftaran_layanan_pemeriksaan_id"]  option:selected').text();
	div_pendaftaran_layanan_layanan_id=0;
	div_pendaftaran_layanan_layanan_name=$('[name="div_pendaftaran_layanan_layanan_name"]').val();
	div_pendaftaran_layanan_dokter_id=$('[name="div_pendaftaran_layanan_dokter_id"]').val();
	div_pendaftaran_layanan_dokter_name=$('[name="div_pendaftaran_layanan_dokter_name"]').val();
	div_pendaftaran_layanan_perawat_id=$('[name="div_pendaftaran_layanan_perawat_id"]').val();
	div_pendaftaran_layanan_perawat_name=$('[name="div_pendaftaran_layanan_perawat_name"]').val();
	if(div_pendaftaran_layanan_perawat_name==''||div_pendaftaran_layanan_perawat_id=='' ||div_pendaftaran_layanan_pemeriksaan_id=='' ||div_pendaftaran_layanan_pemeriksaan_name=='' ||div_pendaftaran_layanan_layanan_name=='' ||div_pendaftaran_layanan_dokter_id=='' ||div_pendaftaran_layanan_dokter_name=='')
	{
		alert('Silahkan isi semua data');
	}
	else
	{
		html='<tr class="tr_data trr_'+div_pendaftaran_layanan_pemeriksaan_id+'">'
					+'<td class="td">'
					+'<button class="btn btn-info btn-clone4 btn-sm" type="button" onclick="$(this).parent().remove();return false;"><i class="fa fa-minus"></i></button>'
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
				
		$('.row_add').append(html);
		
		
		// $('[name="div_pendaftaran_layanan_pemeriksaan_id"]').val('');
		// $('[name="div_pendaftaran_layanan_layanan_name"]').val('');
		// $('[name="div_pendaftaran_layanan_dokter_id"]').val('0');
		// $('[name="div_pendaftaran_layanan_dokter_name"]').val('');
		// $('[name="div_pendaftaran_layanan_perawat_id"]').val('0');
		// $('[name="div_pendaftaran_layanan_perawat_name"]').val('');
	}
}
 </script>