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
    <h1>Pemeriksaan</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Pemeriksaan</a></div>
      	<div class="breadcrumb-item">Form</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Pemeriksaan</h4>
      	</div>
      	<div class="card-body">
		
	  <?php 
			if(trim($status)!='' AND trim($message)!=''){
		  ?> 
				<div class="col-sm-12 control-label custom_message" id="custom_message"> 
					<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
					  <div style="text-align:left;"><i class="<?php echo ($status==200)?'icon-thumbs-up':'icon-remove'; ?>"></i><?php echo $message; ?></div>
					  </div>
				</div> 

		  <?php
			}
			else{
		  ?>	
				<div class="col-sm-12 control-label custom_message" style="display:none" id="custom_message"> 
					<div class="callout  mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
					  <div style="text-align:left;" class="message">-</div>
					  </div>
				</div> 
		  <?php } ?>
		  
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
			<form action="#" method="POST">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alergi</label>
					<div class="col-sm-12 col-md-7">
						<textarea name="pemeriksaan_alergi" id="pemeriksaan_alergi" cols="30" rows="5" class="form-control h-auto"><?php echo $this->input->post('pemeriksaan_alergi')?$this->input->post('pemeriksaan_alergi'):(isset($pemeriksaan_alergi)?$pemeriksaan_alergi:'');?></textarea> 
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-2">
						<label>Berat Badan</label>
						<input type="number" step="0.01" class="form-control" name="pemeriksaan_weight" value="<?php echo $this->input->post('pemeriksaan_weight')?$this->input->post('pemeriksaan_weight'):(isset($pemeriksaan_weight)?$pemeriksaan_weight:'');?>"  required> 
					</div>
					<div class="col-sm-12 col-md-2">
						<label>Tinggi Badan</label>
						<input type="number" step="0.01" class="form-control" name="pemeriksaan_height" value="<?php echo $this->input->post('pemeriksaan_height')?$this->input->post('pemeriksaan_height'):(isset($pemeriksaan_height)?$pemeriksaan_height:'');?>"  required> 
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Tanda Vital</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-2">
						<label>Tekanan Darah</label>
						<input type="number" step="0.01" class="form-control" name="pemeriksaan_tension" value="<?php echo $this->input->post('pemeriksaan_tension')?$this->input->post('pemeriksaan_tension'):(isset($pemeriksaan_tension)?$pemeriksaan_tension:'');?>"  required> 
					</div>
					<div class="col-sm-12 col-md-2">
						<label>Respiratory Rate</label>
						<input type="number" step="0.01" class="form-control" name="pemeriksaan_respiration" value="<?php echo $this->input->post('pemeriksaan_respiration')?$this->input->post('pemeriksaan_respiration'):(isset($pemeriksaan_respiration)?$pemeriksaan_respiration:'');?>"  required> 
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-2">
						<label>Nadi</label>
						<input type="number" step="0.01" class="form-control" name="pemeriksaan_nadi" value="<?php echo $this->input->post('pemeriksaan_nadi')?$this->input->post('pemeriksaan_nadi'):(isset($pemeriksaan_nadi)?$pemeriksaan_nadi:'');?>"  required> 
					</div>
					<div class="col-sm-12 col-md-2">
						<label>Suhu Tubuh</label>
						<input type="number" step="0.01" class="form-control" name="pemeriksaan_suhu" value="<?php echo $this->input->post('pemeriksaan_suhu')?$this->input->post('pemeriksaan_suhu'):(isset($pemeriksaan_suhu)?$pemeriksaan_suhu:'');?>"  required> 
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Anamnesis</label>
					<div class="col-sm-12 col-md-7">
						<textarea name="pemeriksaan_anamnesis" id="pemeriksaan_anamnesis" cols="30" rows="5" class="form-control h-auto"><?php echo $this->input->post('pemeriksaan_anamnesis')?$this->input->post('pemeriksaan_anamnesis'):(isset($pemeriksaan_anamnesis)?$pemeriksaan_anamnesis:'');?></textarea> 
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pemeriksaan Fisik</label>
					<div class="col-sm-12 col-md-7">
						<textarea name="pemeriksaan_pemeriksaan" id="pemeriksaan_pemeriksaan" cols="30" rows="5" class="form-control h-auto"><?php echo $this->input->post('pemeriksaan_pemeriksaan')?$this->input->post('pemeriksaan_pemeriksaan'):(isset($pemeriksaan_pemeriksaan)?$pemeriksaan_pemeriksaan:'');?></textarea> 
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diagnosis</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original">
								<div class="col-md-11 px-1">
								
									<input type="text" class="form-control" id="search_diagnosis" name="search_diagnosis"  value="<?php echo $this->input->post('search_diagnosis')?$this->input->post('search_diagnosis'):(isset($search_diagnosis)?$search_diagnosis:''); ?>">
									<input type="hidden" class="form-control" name="diagnosis_id" value="<?php echo $this->input->post('diagnosis_id')?$this->input->post('diagnosis_id'):(isset($diagnosis_id)?$diagnosis_id:'0'); ?>"> 
									<input type="hidden" class="form-control" name="diagnosis_name" value="<?php echo $this->input->post('diagnosis_name')?$this->input->post('diagnosis_name'):(isset($diagnosis_name)?$diagnosis_name:''); ?>"> 
								</div>
								<div class="col-md-1 px-1">
									<div>
										<button class="btn btn-info btn-clone" type="button" onclick="add_row_diagnosa()"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-product table-bordered table-sm">
								<thead>
									<tr>
										<th>Diagnosis</th>
									</tr>
								</thead>
								<tbody class="row_add_diagnosis">
									<?php foreach($diagnosis as $row){?>
										<tr class="tr_data trr_<?php echo $row['pemeriksaan_diagnosis_id'];?>">
											<td class="td">
												<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();return false;"><i class="fa fa-minus"></i></button>
												<?php echo $row['pemeriksaan_diagnosis_name'];?>
												<input type="hidden" name="pemeriksaan_diagnosis_id[]" value="<?php echo $row['pemeriksaan_diagnosis_id'];?>">
												<input type="hidden" name="pemeriksaan_diagnosis_name[]" value="<?php echo $row['pemeriksaan_diagnosis_name'];?>">
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Pemeriksaan Laboratorium</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Layanan Laboratorium</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original2">
								<div class="col-md-11 px-1">
									<select name="pendaftaran_layanan_lab_id" id="layanan_id" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Layanan Laboratorium">
										<option value="">Silahkan Pilih</option>
										<?php foreach($master_layanan_lab as $arr){?>
										<option value="<?php echo $arr['layanan_id'];?>" data-dokter-id="<?php echo (isset($jadwal_lab_arr['jadwal_dokter_id'])?$jadwal_lab_arr['jadwal_dokter_id']:0);?>" data-dokter-name="<?php echo (isset($jadwal_lab_arr['jadwal_dokter_name'])?$jadwal_lab_arr['jadwal_dokter_name']:'-');?>" data-perawat-id="<?php echo (isset($jadwal_lab_arr['jadwal_perawat_id'])?$jadwal_lab_arr['jadwal_perawat_id']:'0');?>" data-perawat-name="<?php echo (isset($jadwal_lab_arr['jadwal_perawat_name'])?$jadwal_lab_arr['jadwal_perawat_name']:'-');?>"><?php echo $arr['layanan_name'];?></option>
										<?php } ?>
									</select>
									<input type="hidden" name="div_pendaftaran_layanan_lab_layanan_name" value="Laboratorium">
									<input type="hidden" name="jadwal_lab_perawat_id" value="<?php echo isset($jadwal_lab_arr['jadwal_perawat_id'])?$jadwal_lab_arr['jadwal_perawat_id']:0;?>">
									<input type="hidden" name="jadwal_lab_perawat_name" value="<?php echo isset($jadwal_lab_arr['jadwal_perawat_name'])?$jadwal_lab_arr['jadwal_perawat_name']:'-';?>">
									<input type="hidden" name="jadwal_lab_dokter_id" value="<?php echo isset($jadwal_lab_arr['jadwal_dokter_id'])?$jadwal_lab_arr['jadwal_dokter_id']:0;?>">
									<input type="hidden" name="jadwal_lab_dokter_name" value="<?php echo isset($jadwal_lab_arr['jadwal_dokter_name'])?$jadwal_lab_arr['jadwal_dokter_name']:'-';?>">
								</div>
								<div class="col-md-1 px-1">
									<div>
										<button class="btn btn-info btn-clone2" onclick="add_lab();" type="button"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
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
												foreach($layanan_lab as $row){
													$file=trim($row['pendaftaran_layanan_hasil'])!=''&&file_exists(FCPATH.$row['pendaftaran_layanan_hasil'])?base_url($row['pendaftaran_layanan_hasil']):'';
										?>
										<tr>
											<td>
											<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();return false;"><i class="fa fa-minus"></i></button>
												[<?php echo $row['pendaftaran_layanan_layanan_name'];?>] <?php echo $row['pendaftaran_layanan_pemeriksaan_name'];?>
												<br/>
												<small>Dokter : <?php echo $row['pendaftaran_layanan_dokter_name'];?></small>
												<br/>
												<small>Perawat : <?php echo $row['pendaftaran_layanan_perawat_name'];?></small>
												<input type="hidden" name="pendaftaran_layanan_layanan_id[]" value="<?php echo $row['pendaftaran_layanan_layanan_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_pemeriksaan_id[]" value="<?php echo $row['pendaftaran_layanan_pemeriksaan_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_pemeriksaan_name[]" value="<?php echo $row['pendaftaran_layanan_pemeriksaan_name'];?>">
												<input type="hidden" name="pendaftaran_layanan_layanan_name[]" value="<?php echo $row['pendaftaran_layanan_layanan_name'];?>">
												<input type="hidden" name="pendaftaran_layanan_id[]" value="<?php echo $row['pendaftaran_layanan_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_dokter_id[]" value="<?php echo $row['pendaftaran_layanan_dokter_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_dokter_name[]" value="<?php echo $row['pendaftaran_layanan_dokter_name'];?>">
												<input type="hidden" name="pendaftaran_layanan_perawat_id[]" value="<?php echo $row['pendaftaran_layanan_perawat_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_perawat_name[]" value="<?php echo $row['pendaftaran_layanan_perawat_name'];?>">
											</td>
											<td>
												<?php if(trim($file)!=''){?>
												<a href="<?php echo $file;?>" target="__BLANK"><i class="fa fa-file fa-2x"></i> Hasil <?php echo $row['pendaftaran_layanan_pemeriksaan_name'];?></a>
												<?php } ?>
											</td>
											
										</tr>
									<?php } } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Tindakan</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tindakan</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original4">
								<div class="col-md-11 px-1">
									<select name="div_pendaftaran_layanan_id" id="div_pendaftaran_layanan_id" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Tindakan">
										<option value="">Silahkan Pilih</option>
										<?php foreach($master_layanan_umum as $arr){?>
										<option value="<?php echo $arr['layanan_id'];?>" data-dokter-id="<?php echo (isset($jadwal_lab_arr['jadwal_dokter_id'])?$jadwal_lab_arr['jadwal_dokter_id']:0);?>" data-dokter-name="<?php echo (isset($jadwal_lab_arr['jadwal_dokter_name'])?$jadwal_lab_arr['jadwal_dokter_name']:'-');?>" data-perawat-id="<?php echo (isset($jadwal_lab_arr['jadwal_perawat_id'])?$jadwal_lab_arr['jadwal_perawat_id']:'0');?>" data-perawat-name="<?php echo (isset($jadwal_lab_arr['jadwal_perawat_name'])?$jadwal_lab_arr['jadwal_perawat_name']:'-');?>"><?php echo $arr['layanan_name'];?></option>
										<?php } ?>
									</select>
									<input type="hidden" name="pendaftaran_layanan_pendaftaran_id" value="<?php echo isset($pemeriksaan_pendaftaran_id)?$pemeriksaan_pendaftaran_id:0;?>">
									<input type="hidden" name="div_pendaftaran_layanan_layanan_name" value="Umum">
									<input type="hidden" name="jadwal_perawat_id" value="<?php echo isset($jadwal_umum_arr['jadwal_perawat_id'])?$jadwal_umum_arr['jadwal_perawat_id']:0;?>">
									<input type="hidden" name="jadwal_perawat_name" value="<?php echo isset($jadwal_umum_arr['jadwal_perawat_name'])?$jadwal_umum_arr['jadwal_perawat_name']:'-';?>">
									<input type="hidden" name="jadwal_dokter_id" value="<?php echo isset($jadwal_umum_arr['jadwal_dokter_id'])?$jadwal_umum_arr['jadwal_dokter_id']:0;?>">
									<input type="hidden" name="jadwal_dokter_name" value="<?php echo isset($jadwal_umum_arr['jadwal_dokter_name'])?$jadwal_umum_arr['jadwal_dokter_name']:'-';?>">
								</div>
								<div class="col-md-1 px-1">
									<div>
										<button class="btn btn-info btn-clone2" onclick="add_tindakan();" type="button"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-product4 table-bordered table-sm">
								<thead>
									<tr>
										<th>Nama Tindakan</th>
									</tr>
								</thead>
								<tbody class="row_add_tindakan">
									
									<?php if(!empty($layanan_umum)){
												foreach($layanan_umum as $row){
										?>
										<tr>
											<td>
											<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();return false;"><i class="fa fa-minus"></i></button>
												[<?php echo $row['pendaftaran_layanan_layanan_name'];?>] <?php echo $row['pendaftaran_layanan_pemeriksaan_name'];?>
												<br/>
												<small>Dokter : <?php echo $row['pendaftaran_layanan_dokter_name'];?></small>
												<br/>
												<small>Perawat : <?php echo $row['pendaftaran_layanan_perawat_name'];?></small>
												<input type="hidden" name="pendaftaran_layanan_layanan_id[]" value="<?php echo $row['pendaftaran_layanan_layanan_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_pemeriksaan_id[]" value="<?php echo $row['pendaftaran_layanan_pemeriksaan_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_pemeriksaan_name[]" value="<?php echo $row['pendaftaran_layanan_pemeriksaan_name'];?>">
												<input type="hidden" name="pendaftaran_layanan_layanan_name[]" value="<?php echo $row['pendaftaran_layanan_layanan_name'];?>">
												<input type="hidden" name="pendaftaran_layanan_id[]" value="<?php echo $row['pendaftaran_layanan_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_dokter_id[]" value="<?php echo $row['pendaftaran_layanan_dokter_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_dokter_name[]" value="<?php echo $row['pendaftaran_layanan_dokter_name'];?>">
												<input type="hidden" name="pendaftaran_layanan_perawat_id[]" value="<?php echo $row['pendaftaran_layanan_perawat_id'];?>">
												<input type="hidden" name="pendaftaran_layanan_perawat_name[]" value="<?php echo $row['pendaftaran_layanan_perawat_name'];?>">
											</td>
											<td>
											</td>
											
										</tr>
									<?php } } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4 ">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Resep Obat</u></label>
				</div>
				<div class="form-group row mb-4">
					<div class="col-sm-12 col-md-12">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original3">
								<div class="col-md-1 px-1">
									<input type="text" name="pemeriksaan_obat_resep" class="form-control" placeholder="/R">
								</div>
								<div class="col-md-3 px-1">
									<input type="text" name="pemeriksaan_obat_name" class="form-control" placeholder="Nama Obat/Alkes">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" name="pemeriksaan_obat_kemasan_id" class="form-control" placeholder="Kemasan">
								</div>
								<div class="col-md-1 px-1">
									<input type="text" class="form-control" name="pemeriksaan_obat_qty" placeholder="Qty">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-control" name="pemeriksaan_obat_dosis" placeholder="Dosis">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-control" name="pemeriksaan_obat_aturan_pakai" placeholder="Aturan Pakai">
								</div>
								<div class="col-md-1 px-1">
									<div>
										<button class="btn btn-info btn-clone3" type="button" onclick="add_row_obat()"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-product3 table-bordered table-sm">
								<thead>
									<tr>
										<th></th>
										<th>/R</th>
										<th>Nama Obat</th>
										<th>Kemasan</th>
										<th>Jumlah</th>
										<th>Dosis</th>
										<th>Aturan Pakai</th>
									</tr>
								</thead>
								<tbody class="add_row_obat">
									<?php foreach($obat as $arr){?>		
									<tr>
										<td class="td">
											<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();return false;"><i class="fa fa-minus"></i></button>'
										</td>
										<td class="td">
											<?php echo $arr['pemeriksaan_obat_resep'];?>
											<input type="hidden" name="pemeriksaan_obat_resep[]" value="<?php echo $arr['pemeriksaan_obat_resep'];?>">
										</td>
										<td class="td"> <?php echo $arr['pemeriksaan_obat_name'];?>
											<input type="hidden" name="pemeriksaan_obat_name[]" value="<?php echo $arr['pemeriksaan_obat_name'];?>">
										</td>
										<td class="td"><?php echo $arr['pemeriksaan_obat_kemasan_name'];?> 
											<input type="hidden" name="pemeriksaan_obat_kemasan_name[]" value="<?php echo $arr['pemeriksaan_obat_kemasan_name'];?>">
											<input type="hidden" name="pemeriksaan_obat_kemasan_id[]" value="<?php echo $arr['pemeriksaan_obat_kemasan_name'];?>">
										</td>
										<td class="td">  <?php echo $arr['pemeriksaan_obat_qty'];?>
											<input type="hidden" name="pemeriksaan_obat_qty[]" value="<?php echo $arr['pemeriksaan_obat_qty'];?>">
										</td>
										<td class="td"><?php echo $arr['pemeriksaan_obat_dosis'];?>
											<input type="hidden" name="pemeriksaan_obat_dosis[]" value="<?php echo $arr['pemeriksaan_obat_dosis'];?>">
										</td>
										<td class="td"><?php echo $arr['pemeriksaan_obat_aturan_pakai'];?>
											<input type="hidden" name="pemeriksaan_obat_aturan_pakai[]" value="<?php echo $arr['pemeriksaan_obat_aturan_pakai'];?>">
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
					<div class="col-sm-12 col-md-9">
						<input type="hidden" class="form-control" name="pemeriksaan_id" value="<?php echo (isset($pemeriksaan_id)?$pemeriksaan_id:'');?>"> 
						<button class="btn btn-primary" name="submit" value="sudah diperiksa">Simpan Pemeriksaan</button>
						<button class="btn btn-warning" name="submit" value="laboratorium">Submit ke Laboratorium</button>
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
		find_diagnosis();
	});
	
	
function find_diagnosis()
{ 
	  var cacheItem = {};
	  $("#search_diagnosis").autocomplete({
		  minLength: 2,
		  source: function( request, response ) {
			  var term = request.term;
			  if ( term in cacheItem ) {
				  response( cacheItem[ term ] );
				  return;
			  } 
			  $.getJSON( "<?php echo site_url();?>admin/<?php echo $class?>/search_diagnosis", request, function( data, status, xhr ) {
				  $('#pendaftaran_pasien_id').val(''); 
				  cacheItem[ term ] = data;
				  response( data ); 
			  });
		  },
		  select: function (event, ui) {
				$('[name="diagnosis_id"]').val(ui.item.id);     
				$('[name="diagnosis_name"]').val(ui.item.label);     
				$('[name="search_diagnosis"]').val(ui.item.label);     
			return false;
		  },
		  focus: function (event, ui) {  
				$('[name="diagnosis_id"]').val(ui.item.id);     
				$('[name="diagnosis_name"]').val(ui.item.label);     
				$('[name="search_diagnosis"]').val(ui.item.label);     
				return false;
		  },
	  }).on("focus", function () {
		$(this).autocomplete("search", '');
	  });

}


	
	function add_row_diagnosa()
	{
		diagnosis_id=$('[name="diagnosis_id"]').val();
		diagnosis_name=$('[name="diagnosis_name"]').val();
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
		$('[name="diagnosis_id"]').val('');
		$('[name="diagnosis_name"]').val('');
		$('[name="search_diagnosis"]').val('');
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
		pemeriksaan_obat_kemasan_id='0';
		pemeriksaan_obat_kemasan_name=$('[name="pemeriksaan_obat_kemasan_id"]').val();
		pemeriksaan_obat_qty=$('[name="pemeriksaan_obat_qty"]').val();
		pemeriksaan_obat_dosis=$('[name="pemeriksaan_obat_dosis"]').val();
		pemeriksaan_obat_aturan_pakai=$('[name="pemeriksaan_obat_aturan_pakai"]').val(); 
		if(pemeriksaan_obat_resep==''||pemeriksaan_obat_name==''||pemeriksaan_obat_kemasan_id==''||pemeriksaan_obat_qty==''||pemeriksaan_obat_dosis==''||pemeriksaan_obat_aturan_pakai==''||pemeriksaan_obat_kemasan_name=='')
		{
			alert('Silahkan lengkapi data')	;
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