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
    <h1>Farmasi</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Pemeriksaan</a></div>
      	<div class="breadcrumb-item">Farmasi</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Farmasi</h4>
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
		
			<form action="#" id="formApotek" method="POST" enctype="multipart/form-data" enctype="multipart/form-data">
			
				<div class="form-group row mb-4">
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Nama Pasien</label>
								<div class="col-md-8">
									<input type="text" class="form-control pasien_name" id="pasien_name" name="pasien_name" value="<?php echo $this->input->post('pasien_name');?>" required> 
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Alamat</label>
								<div class="col-md-8">
									<input type="text" class="form-control pasien_alamat" id="pasien_alamat" name="pasien_alamat" value="<?php echo $this->input->post('pasien_alamat');?>" required> 
								</div>
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-1"></div>
						<div class="col-md-5">
							<div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">Usia</label>
								<div class="col-md-8">
									<input type="number" class="form-control pasien_name" id="pasien_age" name="pasien_age" value="<?php echo $this->input->post('pasien_age');?>" required> 
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group row mb-4">
								<label class="col-form-label text-md-right col-12 col-md-4 col-lg-4">No Telp</label>
								<div class="col-md-8">
									<input type="text" class="form-control pasien_phone" id="pasien_phone" name="pasien_phone" value="<?php echo $this->input->post('pasien_phone');?>" required> 
								</div>
							</div>
						</div>
						<div class="col-md-1"></div>
				</div>
				<div class="form-group row mb-4" style="display:none">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Farmasi</u></label>
				</div>
				<div class="form-group row mb-4" style="display:none">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-7">  
						<div class="table-responsive">
							<table class="table table-product3 table-bordered table-sm">
								<thead>
									<tr>
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
											<?php echo $arr['pemeriksaan_obat_resep'];?>
										</td>
										<td class="td"> <?php echo $arr['pemeriksaan_obat_name'];?>
										</td>
										<td class="td"><?php echo $arr['pemeriksaan_obat_kemasan_name'];?> 
										</td>
										<td class="td">  <?php echo $arr['pemeriksaan_obat_qty'];?>
										</td>
										<td class="td"><?php echo $arr['pemeriksaan_obat_dosis'];?>
										</td>
										<td class="td"><?php echo $arr['pemeriksaan_obat_aturan_pakai'];?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
								
					</div>
				</div>
				
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Transaksi Non Resep</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-2 mx-n1 form-original">
								<div class="col-md-4 px-1">
									<input type="text" class="form-control nr_search_obat_name" placeholder="Nama Obat/Alkes" id="nr_search_obat_name" name="nr_search_obat_name">
									<input type="hidden" class="form-control nr_obat_name" readonly name="nr_obat_name">
									<input type="hidden" class="form-control nr_obat_id" readonly name="nr_obat_id">
									<input type="hidden" class="form-control nr_obat_price" readonly name="nr_obat_price">
									<input type="hidden" class="form-control nr_obat_type" readonly name="nr_obat_type">
									<input type="hidden" class="form-control nr_is_obat" readonly name="nr_is_obat">
								</div>
								<div class="col-md-3 px-1">
									<select name="nr_obat_kemasan_id" id="nr_obat_kemasan_id" onchange="calculate_nr()" class="form-input form-select2 nr_obat_kemasan_id" style="width: 100%;" data-placeholder="Pilih Kemasan">
										<option value="">Silahkan Pilih</option>
										<?php if(!empty($kemasan_arr)){
												foreach($kemasan_arr as $row){
										?>
										<option value="<?php echo $row['kemasan_id'];?>"><?php echo $row['kemasan_name'];?></option>
										<?php } } ?>
									</select>
								</div>
								<div class="col-md-2 px-1">
									<input type="number" name="nr_obat_qty" onchange="calculate_nr()" class="form-control nr_obat_qty" placeholder="Qty">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" name="nr_obat_total" class="form-control currency_rupiah nr_obat_total" onblur="add_row_nr()" readonly="" value="">
								</div>
								<div class="col-md-1 px-1">
									<div>
										<button class="btn btn-info btn-clone" type="button" onclick="add_row_nr()"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-product table-bordered table-sm table-nr">
								<thead>
									<tr>
										<th>Nama Obat</th>
										<th>Kemasan</th>
										<th>Qty</th>
										<th>Harga</th>
										<th></th>
									</tr>
								</thead>
								<tbody class="add_row_nr">
									<?php 
									// echo '<pre>';print_r($_POST);exit;
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
									
									if(!empty($obat_id)){
									foreach($obat_id as $index=>$value){
										$row=array();
										if(isset($obat_type[$index])&&$obat_type[$index]=='non_resep')
										{
											$row=array
											(
												'pemeriksaan_obat_obat_id'=>isset($obat_id[$index])?$obat_id[$index]:0,
												'pemeriksaan_obat_id'=>0,
												'pemeriksaan_obat_kemasan_id'=>isset($obat_kemasan_id[$index])?$obat_kemasan_id[$index]:0,
												'pemeriksaan_obat_name'=>isset($obat_name[$index])?$obat_name[$index]:'-',
												'pemeriksaan_obat_price'=>isset($obat_price[$index])?common_lib::remove_currency_format($obat_price[$index]):'0',
												'pemeriksaan_obat_type'=>isset($obat_type[$index])?$obat_type[$index]:'-',
												'pemeriksaan_obat_resep'=>isset($obat_resep[$index])?$obat_resep[$index]:'-',
												'pemeriksaan_obat_dosis'=>isset($obat_dosis[$index])?$obat_dosis[$index]:'-',
												'pemeriksaan_obat_aturan_pakai'=>isset($obat_aturan_pakai[$index])?$obat_aturan_pakai[$index]:'-',
												'pemeriksaan_obat_kemasan_name'=>isset($obat_kemasan_name[$index])?$obat_kemasan_name[$index]:'-',
												'pemeriksaan_obat_qty'=>isset($obat_qty[$index])?$obat_qty[$index]:0,
												'pemeriksaan_obat_is_obat'=>isset($is_obat[$index])?$is_obat[$index]:0,
											);
										?>
										<tr class="tr_data trr_<?php echo $row['pemeriksaan_obat_is_obat'];?>_<?php echo $row['pemeriksaan_obat_id'].'_'.$row['pemeriksaan_obat_kemasan_id'];?>"> 
											<td class="td">
												<?php echo $row['pemeriksaan_obat_name'];?>  
												<input type="hidden" readonly class="form-control obat_name" id="obat_name" name="obat_name[]" value="<?php echo $row['pemeriksaan_obat_name'];?>  ">
												<input type="hidden" class="form-control obat_id" readonly name="obat_id[]" value="<?php echo $row['pemeriksaan_obat_obat_id'];?>">
												<input type="hidden" class="form-control obat_price" readonly name="obat_price[]" value="<?php echo $row['pemeriksaan_obat_price'];?>">
												<input type="hidden" class="form-control obat_type" readonly name="obat_type[]" value="<?php echo $row['pemeriksaan_obat_type'];?>">
												<input type="hidden" readonly class="form-control obat_resep" id="obat_resep" name="obat_resep[]" value="<?php echo $row['pemeriksaan_obat_resep'];?> ">
												<input type="hidden" readonly class="form-control obat_qty" id="obat_dosis" name="obat_dosis[]" value="<?php echo $row['pemeriksaan_obat_dosis'];?>">
												<input type="hidden" readonly class="form-control obat_aturan_pakai" id="obat_dosis" name="obat_aturan_pakai[]" value="<?php echo $row['pemeriksaan_obat_aturan_pakai'];?>">
												<input type="hidden" readonly class="form-control is_obat" id="is_obat" name="is_obat[]" value="<?php echo $row['pemeriksaan_obat_is_obat'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_kemasan_name'];?>
												<input type="hidden" readonly class="form-control obat_kemasan_id" id="obat_kemasan_id" name="obat_kemasan_id[]" value="<?php echo $row['pemeriksaan_obat_kemasan_id'];?>">
												<input type="hidden" readonly class="form-control obat_kemasan_name" id="obat_kemasan_name" name="obat_kemasan_name[]" value="<?php echo $row['pemeriksaan_obat_kemasan_name'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_qty'];?>
												<input type="hidden" readonly class="form-control obat_qty" id="obat_qty" name="obat_qty[]" value="<?php echo $row['pemeriksaan_obat_qty'];?>">
											</td>  
											<td class="td">
												<?php echo $row['pemeriksaan_obat_price']*$row['pemeriksaan_obat_qty'];?>
												<input type="hidden" readonly class="form-control obat_total" id="obat_total" name="obat_total[]" value="<?php echo $row['pemeriksaan_obat_price']*$row['pemeriksaan_obat_qty'];?>">
											</td>
											<td class="td">
												<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();calculate_subtotal();return false;"><i class="fa fa-trash"></i></button>
											</td>
									</tr>
									<?php } } }
									else if(!empty($trx_non_resep)){
									foreach($trx_non_resep as $row){?>
										<tr class="tr_data trr_<?php echo $row['pemeriksaan_obat_is_obat'];?>_<?php echo $row['pemeriksaan_obat_obat_id'].'_'.$row['pemeriksaan_obat_kemasan_id'];?>"> 
											<td class="td">
												<?php echo $row['pemeriksaan_obat_name'];?>  
												<input type="hidden" readonly class="form-control obat_name" id="obat_name" name="obat_name[]" value="<?php echo $row['pemeriksaan_obat_name'];?>  ">
												<input type="hidden" class="form-control obat_id" readonly name="obat_id[]" value="<?php echo $row['pemeriksaan_obat_obat_id'];?>">
												<input type="hidden" class="form-control obat_price" readonly name="obat_price[]" value="<?php echo $row['pemeriksaan_obat_price'];?>">
												<input type="hidden" class="form-control obat_type" readonly name="obat_type[]" value="<?php echo $row['pemeriksaan_obat_type'];?>">
												<input type="hidden" readonly class="form-control obat_resep" id="obat_resep" name="obat_resep[]" value="<?php echo $row['pemeriksaan_obat_resep'];?> ">
												<input type="hidden" readonly class="form-control obat_dosis" id="obat_dosis" name="obat_dosis[]" value="<?php echo $row['pemeriksaan_obat_dosis'];?>">
												<input type="hidden" readonly class="form-control obat_aturan_pakai" id="obat_aturan_pakai" name="obat_aturan_pakai[]" value="<?php echo $row['pemeriksaan_obat_aturan_pakai'];?>">
												<input type="hidden" readonly class="form-control is_obat" id="is_obat" name="is_obat[]" value="<?php echo $row['pemeriksaan_obat_is_obat'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_kemasan_name'];?>
												<input type="hidden" readonly class="form-control obat_kemasan_id" id="obat_kemasan_id" name="obat_kemasan_id[]" value="<?php echo $row['pemeriksaan_obat_kemasan_id'];?>">
												<input type="hidden" readonly class="form-control obat_kemasan_name" id="obat_kemasan_name" name="obat_kemasan_name[]" value="<?php echo $row['pemeriksaan_obat_kemasan_name'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_qty'];?>
												<input type="hidden" readonly class="form-control obat_qty" id="obat_qty" name="obat_qty[]" value="<?php echo $row['pemeriksaan_obat_qty'];?>">
											</td>  
											<td class="td">
												<?php echo $row['pemeriksaan_obat_price']*$row['pemeriksaan_obat_qty'];?>
												<input type="hidden" readonly class="form-control obat_total" id="obat_total" name="obat_total[]" value="<?php echo $row['pemeriksaan_obat_price']*$row['pemeriksaan_obat_qty'];?>">
											</td>
											<td class="td">
												<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();calculate_subtotal();return false;"><i class="fa fa-trash"></i></button>
											</td>
									</tr>
									<?php } }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Transaksi Resep</u></label>
				</div>
				<div class="form-group row mb-4">
					<div class="col-sm-12 col-md-12">
						<div class="form-clone-wrap">
							<div class="form-group row mb-2 mx-n1 form-original">
								<div class="col-md-1 px-1">
									<input type="text" class="form-control r_obat_resep" placeholder="/R" id="r_obat_resep" name="r_obat_resep"> 
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-control r_search_obat_name" placeholder="Nama Obat/Alkes" id="r_search_obat_name" name="r_search_obat_name">
									<input type="hidden" class="form-control r_obat_name" readonly name="r_obat_name">
									<input type="hidden" class="form-control r_obat_id" readonly name="r_obat_id">
									<input type="hidden" class="form-control r_obat_price" readonly name="r_obat_price">
									<input type="hidden" class="form-control r_obat_type" readonly name="r_obat_type">
									<input type="hidden" class="form-control r_is_obat" readonly name="r_is_obat">
								</div>
								<div class="col-md-2 px-1">
									<select name="r_obat_kemasan_id" id="r_obat_kemasan_id" onchange="calculate_r()" class="form-input form-select2 r_obat_kemasan_id" style="width: 100%;" data-placeholder="Pilih Kemasan">
										<option value="">Silahkan Pilih</option>
										<?php if(!empty($kemasan_arr)){
												foreach($kemasan_arr as $row){
										?>
										<option value="<?php echo $row['kemasan_id'];?>"><?php echo $row['kemasan_name'];?></option>
										<?php } } ?>
									</select>
								</div>
								<div class="col-md-1 px-1">
									<input type="number" name="r_obat_qty" onchange="calculate_r()" class="form-control r_obat_qty" placeholder="Qty">
								</div>
								<div class="col-md-2 px-1">
									<input type="number" name="r_obat_dosis" class="form-control r_obat_dosis" placeholder="Dosis">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" name="r_obat_aturan_pakai" class="form-control r_obat_aturan_pakai" placeholder="Aturan Pakai">
								</div>
								<div class="col-md-1 px-1">
									<input type="text" name="r_obat_total" class="form-control currency_rupiah r_obat_total" onblur="add_row_r()" readonly="" value="">
								</div>
								<div class="col-md-1 px-1">
										<button class="btn btn-info btn-clone" type="button" onclick="add_row_r()"><i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-product table-bordered table-sm table-r">
								<thead>
									<tr>
										<th>/R</th>
										<th>Nama Obat</th>
										<th>Kemasan</th>
										<th>Qty</th>
										<th>Dosis</th>
										<th>Aturan Pakai</th>
										<th>Harga</th>
										<th></th>
									</tr>
								</thead>
								<tbody class="add_row_r">
									
									<?php 
									// echo '<pre>';print_r($_POST);exit;
									$obat_id=isset($_POST['obat_id'])?$_POST['obat_id']:array();
									$obat_name=isset($_POST['obat_name'])?$_POST['obat_name']:array();
									$obat_price=isset($_POST['obat_price'])?$_POST['obat_price']:array();
									$obat_resep=isset($_POST['obat_resep'])?$_POST['obat_resep']:array();
									$obat_dosis=isset($_POST['obat_dosis'])?$_POST['obat_dosis']:array();
									$obat_aturan_pakai=isset($_POST['obat_aturan_pakai'])?$_POST['obat_aturan_pakai']:array();
									$obat_kemasan_id=isset($_POST['obat_kemasan_id'])?$_POST['obat_kemasan_id']:array();
									$obat_qty=isset($_POST['obat_qty'])?$_POST['obat_qty']:array();
									$obat_type=isset($_POST['obat_type'])?$_POST['obat_type']:array();
									$obat_type=isset($_POST['obat_type'])?$_POST['obat_type']:array();
									$obat_total=isset($_POST['obat_total'])?$_POST['obat_total']:array();
									$obat_kemasan_name=isset($_POST['obat_kemasan_name'])?$_POST['obat_kemasan_name']:array();
									$is_obat=isset($_POST['is_obat'])?$_POST['is_obat']:array();
									
									if(!empty($obat_id)){
									foreach($obat_id as $index=>$value){
										$row=array();
										if(isset($obat_type[$index])&&$obat_type[$index]=='resep')
										{
											$row=array
											(
												'pemeriksaan_obat_obat_id'=>isset($obat_id[$index])?$obat_id[$index]:0,
												'pemeriksaan_obat_id'=>0,
												'pemeriksaan_obat_kemasan_id'=>isset($obat_kemasan_id[$index])?$obat_kemasan_id[$index]:0,
												'pemeriksaan_obat_name'=>isset($obat_name[$index])?$obat_name[$index]:'-',
												'pemeriksaan_obat_price'=>isset($obat_price[$index])?common_lib::remove_currency_format($obat_price[$index]):'0',
												'pemeriksaan_obat_type'=>isset($obat_type[$index])?$obat_type[$index]:'-',
												'pemeriksaan_obat_resep'=>isset($obat_resep[$index])?$obat_resep[$index]:'-',
												'pemeriksaan_obat_dosis'=>isset($obat_dosis[$index])?$obat_dosis[$index]:'-',
												'pemeriksaan_obat_aturan_pakai'=>isset($obat_aturan_pakai[$index])?$obat_aturan_pakai[$index]:'-',
												'pemeriksaan_obat_kemasan_name'=>isset($obat_kemasan_name[$index])?$obat_kemasan_name[$index]:'-',
												'pemeriksaan_obat_qty'=>isset($obat_qty[$index])?$obat_qty[$index]:0,
												'pemeriksaan_obat_is_obat'=>isset($is_obat[$index])?$is_obat[$index]:0,
											);
										?>
										<tr class="tr_data trr_<?php echo $row['pemeriksaan_obat_is_obat'];?>_<?php echo $row['pemeriksaan_obat_id'].'_'.$row['pemeriksaan_obat_kemasan_id'];?>"> 
											<td class="td">
												<?php echo $row['pemeriksaan_obat_resep'];?> 
												<input type="hidden" readonly class="form-control obat_resep" id="obat_resep" name="obat_resep[]" value="<?php echo $row['pemeriksaan_obat_resep'];?> ">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_name'];?>  
												<input type="hidden" readonly class="form-control obat_name" id="obat_name" name="obat_name[]" value="<?php echo $row['pemeriksaan_obat_name'];?>  ">
												<input type="hidden" class="form-control obat_id" readonly name="obat_id[]" value="<?php echo $row['pemeriksaan_obat_obat_id'];?>">
												<input type="hidden" class="form-control obat_price" readonly name="obat_price[]" value="<?php echo $row['pemeriksaan_obat_price'];?>">
												<input type="hidden" class="form-control obat_type" readonly name="obat_type[]" value="<?php echo $row['pemeriksaan_obat_type'];?>">
												<input type="hidden" class="form-control is_obat" readonly name="is_obat[]" value="<?php echo $row['pemeriksaan_obat_is_obat'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_kemasan_name'];?>
												<input type="hidden" readonly class="form-control obat_kemasan_id" id="obat_kemasan_id" name="obat_kemasan_id[]" value="<?php echo $row['pemeriksaan_obat_kemasan_id'];?>">
												<input type="hidden" readonly class="form-control obat_kemasan_name" id="obat_kemasan_name" name="obat_kemasan_name[]" value="<?php echo $row['pemeriksaan_obat_kemasan_name'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_qty'];?>
												<input type="hidden" readonly class="form-control obat_qty" id="obat_qty" name="obat_qty[]" value="<?php echo $row['pemeriksaan_obat_qty'];?>">
											</td>  
											<td class="td">
												<?php echo $row['pemeriksaan_obat_dosis'];?>
												<input type="hidden" readonly class="form-control obat_dosis" id="obat_dosis" name="obat_dosis[]" value="<?php echo $row['pemeriksaan_obat_dosis'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_aturan_pakai'];?>
												<input type="hidden" readonly class="form-control obat_aturan_pakai" id="obat_aturan_pakai" name="obat_aturan_pakai[]" value="<?php echo $row['pemeriksaan_obat_aturan_pakai'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_price']*$row['pemeriksaan_obat_qty'];?>
												<input type="hidden" readonly class="form-control obat_total" id="obat_total" name="obat_total[]" value="<?php echo $row['pemeriksaan_obat_price']*$row['pemeriksaan_obat_qty'];?>">
											</td>
											<td class="td">
												<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();calculate_subtotal();return false;"><i class="fa fa-trash"></i></button>
											</td>
									</tr>
									<?php } } }
									else if(!empty($trx_resep)){
									foreach($trx_resep as $row){?>
										<tr class="tr_data trr_<?php echo $row['pemeriksaan_obat_is_obat'];?>_<?php echo $row['pemeriksaan_obat_obat_id'].'_'.$row['pemeriksaan_obat_kemasan_id'].'_'.$row['pemeriksaan_obat_resep'];?>">
											<td class="td">
												<?php echo $row['pemeriksaan_obat_resep'];?> 
												<input type="hidden" readonly class="form-control obat_resep" id="obat_resep" name="obat_resep[]" value="<?php echo $row['pemeriksaan_obat_resep'];?> ">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_name'];?>  
												<input type="hidden" readonly class="form-control obat_name" id="obat_name" name="obat_name[]" value="<?php echo $row['pemeriksaan_obat_name'];?>  ">
												<input type="hidden" class="form-control obat_id" readonly name="obat_id[]" value="<?php echo $row['pemeriksaan_obat_obat_id'];?>">
												<input type="hidden" class="form-control obat_price" readonly name="obat_price[]" value="<?php echo $row['pemeriksaan_obat_price'];?>">
												<input type="hidden" class="form-control obat_type" readonly name="obat_type[]" value="<?php echo $row['pemeriksaan_obat_type'];?>">
												<input type="hidden" class="form-control is_obat" readonly name="is_obat[]" value="<?php echo $row['pemeriksaan_obat_is_obat'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_kemasan_name'];?>
												<input type="hidden" readonly class="form-control obat_kemasan_id" id="obat_kemasan_id" name="obat_kemasan_id[]" value="<?php echo $row['pemeriksaan_obat_kemasan_id'];?>">
												<input type="hidden" readonly class="form-control obat_kemasan_name" id="obat_kemasan_name" name="obat_kemasan_name[]" value="<?php echo $row['pemeriksaan_obat_kemasan_name'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_qty'];?>
												<input type="hidden" readonly class="form-control obat_qty" id="obat_qty" name="obat_qty[]" value="<?php echo $row['pemeriksaan_obat_qty'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_dosis'];?>
												<input type="hidden" readonly class="form-control obat_qty" id="obat_dosis" name="obat_dosis[]" value="<?php echo $row['pemeriksaan_obat_dosis'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_aturan_pakai'];?>
												<input type="hidden" readonly class="form-control obat_aturan_pakai" id="obat_dosis" name="obat_aturan_pakai[]" value="<?php echo $row['pemeriksaan_obat_aturan_pakai'];?>">
											</td>
											<td class="td">
												<?php echo $row['pemeriksaan_obat_price']*$row['pemeriksaan_obat_qty'];?>
												<input type="hidden" readonly class="form-control obat_total" id="obat_total" name="obat_total[]" value="<?php echo $row['pemeriksaan_obat_price']*$row['pemeriksaan_obat_qty'];?>">
											</td>
											<td class="td">
												<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();calculate_subtotal();return false;"><i class="fa fa-trash"></i></button>
											</td>
									</tr>
									<?php } }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<hr/>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Harga</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="apotek_subtotal" required readonly value="<?php echo isset($pemeriksaan_apotek_subtotal)?$pemeriksaan_apotek_subtotal:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tuslah</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="apotek_tuslah" required onchange="calculate_grandtotal()" value="<?php echo isset($pemeriksaan_apotek_tuslah)?$pemeriksaan_apotek_tuslah:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Embalage</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="apotek_embalage" onchange="calculate_grandtotal()" value="<?php echo isset($pemeriksaan_apotek_embalage)?$pemeriksaan_apotek_embalage:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon Rp</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="apotek_disc_rp" required onchange="calculate_disc('rp');calculate_grandtotal()" value="<?php echo isset($pemeriksaan_apotek_disc_rupiah)?$pemeriksaan_apotek_disc_rupiah:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon %</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control" step="0.01" onchange="calculate_disc('persen');calculate_grandtotal()" required name="apotek_disc_persen" value="<?php echo isset($pemeriksaan_apotek_disc_persen)?$pemeriksaan_apotek_disc_persen:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Grand Total</label>
					<div class="col-sm-12 col-md-4">
						<input type="hidden" class="form-control currency_rupiah" name="apotek_disc" readonly value="<?php echo isset($pemeriksaan_apotek_disc)?$pemeriksaan_apotek_disc:0;?>">
						<input type="text" class="form-control currency_rupiah" name="apotek_grandtotal" required readonly value="<?php echo isset($pemeriksaan_apotek_total)?$pemeriksaan_apotek_total:0;?>">
					</div>
				</div>
				
				<div class="form-group row mb-5">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-8">
						<input type="hidden" class="form-control" name="pemeriksaan_id" value="<?php echo (isset($pemeriksaan_id)?$pemeriksaan_id:'');?>"> 
						<button class="btn btn-primary" name="submit" value="kasir">Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/autoNumeric.js"></script>

<script type="text/javascript">
	$(function(){
		$('.form-select2').select2();
		find_obat_nr();
		find_obat_r();
		currency_rupiah();
		calculate_subtotal();
	});
	
$('#formApotek').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});


function calculate_disc(tipe)
{
	
	apotek_subtotal=$('[name="apotek_subtotal"]').autoNumeric('get')*1;
	rp=$('[name="apotek_disc_rp"]').autoNumeric('get')*1;
	persen=$('[name="apotek_disc_persen"]').val()*1;
	disc=0;
	if(tipe=='rp')
	{
		disc=rp;
		$('[name="apotek_disc_persen"]').val('0');
	}
	else if(tipe=='persen')
	{
		disc=(apotek_subtotal*persen/100);
		$('[name="apotek_disc_rp"]').autoNumeric('set',0);
	}
	
	$('[name="apotek_disc"]').val(disc);
}
function calculate_grandtotal()
{
	subtotal=$('[name="apotek_subtotal"]').autoNumeric('get')*1;
	apotek_tuslah=$('[name="apotek_tuslah"]').autoNumeric('get')*1;
	apotek_embalage=$('[name="apotek_embalage"]').autoNumeric('get')*1;
	apotek_disc=$('[name="apotek_disc"]').val()*1;
	
	grandtotal=subtotal+apotek_tuslah+apotek_embalage-apotek_disc;
	
	apotek_disc=$('[name="apotek_grandtotal"]').autoNumeric('set',grandtotal);
	
}

function calculate_subtotal()
{
	total=0;
	$('.add_row_r > tr').each(function(){
			r_total=$(this).find('.obat_total').val();
			total+=(r_total*1);
	});

	$('.add_row_nr > tr').each(function(){
			r_total=$(this).find('.obat_total').val();
			total+=(r_total*1);
	});
	
	$('[name="apotek_subtotal"]').autoNumeric('set',total);
	calculate_grandtotal();
}

function add_row_r()
{
	r_is_obat=$('[name="r_is_obat"]').val();
	r_obat_resep=$('[name="r_obat_resep"]').val();
	r_obat_dosis=$('[name="r_obat_dosis"]').val();
	r_obat_aturan_pakai=$('[name="r_obat_aturan_pakai"]').val();
	r_obat_name=$('[name="r_obat_name"]').val();
	r_obat_id=$('[name="r_obat_id"]').val();
	r_obat_price=$('[name="r_obat_price"]').val();
	r_obat_kemasan_name=$('[name="r_obat_kemasan_id"] option:selected').text();
	r_obat_kemasan_id=$('[name="r_obat_kemasan_id"]').val();
	r_obat_qty=$('[name="r_obat_qty"]').val();
	r_obat_total=$('[name="r_obat_total"]').autoNumeric('get');
	// diagnosis_name=$('[name="diagnosis_id"]  option:selected').text(); 
	if(r_obat_resep==''||r_obat_dosis==''||r_obat_aturan_pakai==''||r_obat_name==''||r_obat_id==''||r_obat_price==''||r_obat_qty==''||r_obat_kemasan_id==''||r_obat_total=='')
	{
		alert('Silahkan lengkapi isi resep');
	}
	else
	{
		
		r_obat_price=r_obat_total/r_obat_qty;
		num=$('.tr_data').length;
		lain=0;
		if($('tr.trr_'+r_is_obat+'_'+r_obat_id+'_'+r_obat_kemasan_id+'_'+r_obat_resep).find('.produk_qty').length>0)
		{
			lain=$('tr.trr_'+r_is_obat+'_'+r_obat_id+'_'+r_obat_kemasan_id+'_'+r_obat_resep).find('.r_obat_qty').val();
			r_obat_price=$('tr.trr_'+r_is_obat+'_'+produk_id_div+'_'+r_obat_kemasan_id+'_'+r_obat_resep).find('.r_obat_price').val();
			// penjualan_detail_id=$('tr.trr_'+produk_id_div).find('.penjualan_detail_id').val();
		}
		
		r_obat_qty=(r_obat_qty*1)+(lain*1);
		
		
		$('tr.trr_'+r_is_obat+'_'+r_obat_id+'_'+r_obat_kemasan_id+'_'+r_obat_resep).remove();
		html='<tr class="tr_data trr_'+r_is_obat+'_'+r_obat_id+'_'+r_obat_kemasan_id+'_'+r_obat_resep+'">'
					+'<td class="td">'
						+r_obat_resep 
						+'<input type="hidden" readonly class="form-control obat_resep" id="obat_resep" name="obat_resep[]" value="'+r_obat_resep+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_name 
						+'<input type="hidden" readonly class="form-control obat_name" id="obat_name" name="obat_name[]" value="'+r_obat_name+'">'
						+'<input type="hidden" class="form-control obat_id" readonly name="obat_id[]" value="'+r_obat_id+'">'
						+'<input type="hidden" class="form-control obat_price" readonly name="obat_price[]" value="'+r_obat_price+'">'
						+'<input type="hidden" class="form-control is_obat" readonly name="is_obat[]" value="'+r_is_obat+'">'
						+'<input type="hidden" class="form-control obat_type" readonly name="obat_type[]" value="resep">'
					+'</td>'
					+'<td class="td">'
						+r_obat_kemasan_name 
						+'<input type="hidden" readonly class="form-control obat_kemasan_id" id="obat_kemasan_id" name="obat_kemasan_id[]" value="'+r_obat_kemasan_id+'">'
						+'<input type="hidden" readonly class="form-control obat_kemasan_name" id="obat_kemasan_name" name="obat_kemasan_name[]" value="'+r_obat_kemasan_name+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_qty 
						+'<input type="hidden" readonly class="form-control obat_qty" id="obat_qty" name="obat_qty[]" value="'+r_obat_qty+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_dosis 
						+'<input type="hidden" readonly class="form-control obat_qty" id="obat_dosis" name="obat_dosis[]" value="'+r_obat_dosis+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_aturan_pakai
						+'<input type="hidden" readonly class="form-control obat_aturan_pakai" id="obat_dosis" name="obat_aturan_pakai[]" value="'+r_obat_aturan_pakai+'">'
					+'</td>'
					+'<td class="td">'
						+r_obat_total 
						+'<input type="hidden" readonly class="form-control obat_total" id="obat_total" name="obat_total[]" value="'+r_obat_total+'">'
					+'</td>'
					+'<td class="td">'
						+'<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();calculate_subtotal();return false;"><i class="fa fa-trash"></i></button>'
					+'</td>'
			+'</tr>'
			;
				
		$('.add_row_r').append(html);
		
		r_obat_resep=$('[name="r_search_obat_name"]').val('');
		r_obat_resep=$('[name="r_obat_resep"]').val('');
		r_obat_dosis=$('[name="r_obat_dosis"]').val('');
		r_obat_aturan_pakai=$('[name="r_obat_aturan_pakai"]').val('');
		r_obat_name=$('[name="r_obat_name"]').val('');
		r_obat_id=$('[name="r_obat_id"]').val('');
		r_obat_price=$('[name="r_obat_price"]').val('');
		r_obat_kemasan_id=$('[name="r_obat_kemasan_id"]').val('');
		r_obat_qty=$('[name="r_obat_qty"]').val('');
		r_is_obat=$('[name="r_is_obat"]').val('');
		r_obat_total=$('[name="r_obat_total"]').autoNumeric('set','');
		calculate_subtotal();
	}
}

function calculate_r()
{
	// $('r_obat_kemasan_id')
	konversi=$('#r_obat_kemasan_id option:selected').attr('konversi');
	// konversi=$("#r_obat_kemasan_id").select2().find(":selected").data("konversi");
	r_obat_price=$('[name="r_obat_price"]').val();
	r_obat_qty=$('[name="r_obat_qty"]').val();
	total=r_obat_price*r_obat_qty*konversi;
	// alert(r_obat_price+'*'+r_obat_qty+'*'+konversi);
	$('[name="r_obat_total"]').autoNumeric('set',total);
	
	return false;
}


function calculate_nr()
{
	// $('nr_obat_kemasan_id')
	konversi=$('#nr_obat_kemasan_id option:selected').attr('konversi');
	// konversi=$("#nr_obat_kemasan_id").select2().find(":selected").data("konversi");
	nr_obat_price=$('[name="nr_obat_price"]').val();
	nr_obat_qty=$('[name="nr_obat_qty"]').val();
	total=nr_obat_price*nr_obat_qty*konversi;
	// alert(nr_obat_price+'*'+nr_obat_qty+'*'+konversi);
	$('[name="nr_obat_total"]').autoNumeric('set',total);
	
	return false;
}

function get_kemasan(id,type)
{ 
	$.ajax({
	   url:'<?php echo base_url();?>admin/<?php echo $class?>/get_kemasan_by_id',
	   type:'post',
	   dataType:'json',
	   data:'id='+id+'&type='+type,
	   success:function(response){
		   html='';
		   if(type=='1')
		   {
			html+='<option value="">Silahkan Pilih</option>';
		   }
		   if(response.length>0)
		   {
			   for(i=0;i<response.length;i++)
			   {
				   html+='<option value="'+response[i].kemasan_id+'" konversi="'+response[i].konversi+'">'+response[i].kemasan_name+'</option>';				   
			   }
		   }
		   
		   $('#nr_obat_kemasan_id').html(html);
		  $('#nr_obat_kemasan_id').focus();
		  $('#nr_obat_kemasan_id').select();
		  
		  
		   if(type=='0')
		   {
				calculate_nr();
		   }
	   },
	   error:function(){
			alert('terjadi kesalahan saat validasi'); 
			$('.modal-footer').show();	
			$('.button').show();
			$('.btn').prop('disabled',false);
			session_id='';			
	   }
   });

}

function find_obat_nr()
{ 
	  var cacheItem = {};
	  $("#nr_search_obat_name").autocomplete({
		  minLength: 2,
		  source: function( request, response ) {
			  var term = request.term;
			  if ( term in cacheItem ) {
				  response( cacheItem[ term ] );
				  return;
			  } 
			  $.getJSON( "<?php echo site_url();?>admin/<?php echo $class?>/search_obat_by_name", request, function( data, status, xhr ) {
				  $('#nr_obat_id').val(''); 
				  cacheItem[ term ] = data;
				  response( data ); 
			  });
		  },
		  select: function (event, ui) {
				$('[name="nr_obat_id"]').val(ui.item.id);     
				// $('[name="search_pasien"]').val(ui.item.label);      
				$('[name="nr_obat_name"]').val(ui.item.obat_name); 
				$('[name="nr_is_obat"]').val(ui.item.is_obat); 
				$('[name="nr_obat_price"]').val(ui.item.obat_price_non_resep); 
				$('[name="nr_obat_type"]').val(ui.item.obat_type); 
				nr_obat_qty=$('[name="nr_obat_qty"]').val(); 
				if(nr_obat_qty=='')
				{
					$('[name="nr_obat_qty"]').val('1'); 
				}
				calculate_nr();
				get_kemasan(ui.item.id,ui.item.is_obat);
			return false;
		  },
		  focus: function (event, ui) {  
				$('[name="nr_obat_id"]').val(ui.item.id);     
				// $('[name="search_pasien"]').val(ui.item.label);      
				$('[name="nr_obat_name"]').val(ui.item.obat_name); 
				$('[name="nr_obat_price"]').val(ui.item.obat_price_non_resep); 
				return false;
		  },
	  }).on("focus", function () {
		$(this).autocomplete("search", '');
	  });
}


function add_row_nr()
{
	nr_obat_name=$('[name="nr_obat_name"]').val();
	nr_is_obat=$('[name="nr_is_obat"]').val();
	nr_obat_id=$('[name="nr_obat_id"]').val();
	nr_obat_price=$('[name="nr_obat_price"]').val();
	nr_obat_kemasan_name=$('[name="nr_obat_kemasan_id"] option:selected').text();
	nr_obat_kemasan_id=$('[name="nr_obat_kemasan_id"]').val();
	nr_obat_qty=$('[name="nr_obat_qty"]').val();
	nr_obat_type=$('[name="nr_obat_type"]').val();
	nr_obat_total=$('[name="nr_obat_total"]').autoNumeric('get');
	// diagnosis_name=$('[name="diagnosis_id"]  option:selected').text(); 
	if(nr_obat_name==''||nr_obat_id==''||nr_obat_price==''||nr_obat_qty==''||nr_obat_kemasan_id==''||nr_obat_total=='')
	{
		alert('Silahkan lengkapi isi non resep');
	}
	else
	{
		
		nr_obat_price=nr_obat_total/nr_obat_qty;
		num=$('.tr_data').length;
		lain=0;
		if($('tr.trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id).find('.produk_qty').length>0)
		{
			lain=$('tr.trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id).find('.nr_obat_qty').val();
			nr_obat_price=$('tr.trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id).find('.nr_obat_price').val();
			// penjualan_detail_id=$('tr.trr_'+produk_id_div).find('.penjualan_detail_id').val();
		}
		
		nr_obat_qty=(nr_obat_qty*1)+(lain*1);
		
		
		$('tr.trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id).remove();
		html='<tr class="tr_data trr_'+nr_is_obat+'_'+nr_obat_id+'_'+nr_obat_kemasan_id+'">'
					+'<td class="td">'
						+nr_obat_name 
						+'<input type="hidden" readonly class="form-control obat_name" id="obat_name" name="obat_name[]" value="'+nr_obat_name+'">'
						+'<input type="hidden" class="form-control obat_id" readonly name="obat_id[]" value="'+nr_obat_id+'">'
						+'<input type="hidden" class="form-control obat_price" readonly name="obat_price[]" value="'+nr_obat_price+'">'
						+'<input type="hidden" class="form-control obat_resep" readonly name="obat_resep[]" value="">'
						+'<input type="hidden" class="form-control obat_dosis" readonly name="obat_dosis[]" value="">'
						+'<input type="hidden" class="form-control obat_type" readonly name="obat_type[]" value="non_resep">'
						+'<input type="hidden" class="form-control obat_aturan_pakai" readonly name="obat_aturan_pakai[]" value="">'
						+'<input type="hidden" class="form-control is_obat" readonly name="is_obat[]" value="'+nr_is_obat+'">' 
					+'</td>'
					+'<td class="td">'
						+nr_obat_kemasan_name 
						+'<input type="hidden" readonly class="form-control obat_kemasan_id" id="obat_kemasan_id" name="obat_kemasan_id[]" value="'+nr_obat_kemasan_id+'">'
						+'<input type="hidden" readonly class="form-control obat_kemasan_name" id="obat_kemasan_name" name="obat_kemasan_name[]" value="'+nr_obat_kemasan_name+'">'
					+'</td>'
					+'<td class="td">'
						+nr_obat_qty 
						+'<input type="hidden" readonly class="form-control obat_qty" id="obat_qty" name="obat_qty[]" value="'+nr_obat_qty+'">'
					+'</td>'
					+'<td class="td">'
						+nr_obat_total 
						+'<input type="hidden" readonly class="form-control obat_total" id="obat_total" name="obat_total[]" value="'+nr_obat_total+'">'
					+'</td>'
					+'<td class="td">'
						+'<button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();calculate_subtotal();return false;"><i class="fa fa-trash"></i></button>'
					+'</td>'
			+'</tr>'
			;
				
		$('.add_row_nr').append(html);
		r_obat_resep=$('[name="nr_search_obat_name"]').val('');
		nr_obat_name=$('[name="nr_obat_name"]').val('');
		nr_obat_id=$('[name="nr_obat_id"]').val('');
		nr_obat_price=$('[name="nr_obat_price"]').val('');
		nr_obat_kemasan_id=$('[name="nr_obat_kemasan_id"]').val('');
		nr_obat_qty=$('[name="nr_obat_qty"]').val('');
		nr_obat_qty=$('[name="nr_is_obat"]').val('');
		nr_obat_total=$('[name="nr_obat_total"]').autoNumeric('set','');
		calculate_subtotal();
	}
}
 
function get_kemasan_r(id,type)
{ 
	$.ajax({
	   url:'<?php echo base_url();?>admin/<?php echo $class?>/get_kemasan_by_id',
	   type:'post',
	   dataType:'json',
	   data:'id='+id+'&type='+type,
	   success:function(response){
		   html='';
		   if(type=='1')
		   {
			html+='<option value="">Silahkan Pilih</option>';
		   }
		   if(response.length>0)
		   {
			   for(i=0;i<response.length;i++)
			   {
				   html+='<option value="'+response[i].kemasan_id+'" konversi="'+response[i].konversi+'">'+response[i].kemasan_name+'</option>';				   
			   }
		   }
		   
		   $('#r_obat_kemasan_id').html(html);
		  $('#r_obat_kemasan_id').focus();
		  $('#r_obat_kemasan_id').select();
		  
		  
		   if(type=='0')
		   {
			calculate_r()
		   $('[name="r_obat_dosis"]').val(0);
		   $('[name="r_obat_aturan_pakai"]').val('-');
		   }
	   },
	   error:function(){
			alert('terjadi kesalahan saat validasi'); 
			$('.modal-footer').show();	
			$('.button').show();
			$('.btn').prop('disabled',false);
			session_id='';			
	   }
   });

}

function find_obat_r()
{ 
	  var cacheItem = {};
	  $("#r_search_obat_name").autocomplete({
		  minLength: 2,
		  source: function( request, response ) {
			  var term = request.term;
			  if ( term in cacheItem ) {
				  response( cacheItem[ term ] );
				  return;
			  } 
			  $.getJSON( "<?php echo site_url();?>admin/<?php echo $class?>/search_obat_by_name", request, function( data, status, xhr ) {
				  $('#r_obat_id').val(''); 
				  cacheItem[ term ] = data;
				  response( data ); 
			  });
		  },
		  select: function (event, ui) {
				$('[name="r_obat_id"]').val(ui.item.id);     
				// $('[name="search_pasien"]').val(ui.item.label);      
				$('[name="r_obat_name"]').val(ui.item.obat_name); 
				$('[name="r_is_obat"]').val(ui.item.is_obat); 
				$('[name="r_obat_price"]').val(ui.item.obat_price_non_resep); 
				$('[name="r_obat_type"]').val(ui.item.obat_type); 
				r_obat_qty=$('[name="r_obat_qty"]').val(); 
				if(r_obat_qty=='')
				{
					$('[name="r_obat_qty"]').val('1'); 
				}
				calculate_r();
				get_kemasan_r(ui.item.id,ui.item.is_obat);
			return false;
		  },
		  focus: function (event, ui) {  
				$('[name="r_obat_id"]').val(ui.item.id);     
				// $('[name="search_pasien"]').val(ui.item.label);      
				$('[name="r_obat_name"]').val(ui.item.obat_name); 
				$('[name="r_obat_price"]').val(ui.item.obat_price_non_resep); 
				return false;
		  },
	  }).on("focus", function () {
		$(this).autocomplete("search", '');
	  });
}


function currency_rupiah()
{
	var myOptions = {aSep: '.', aDec: ',',mDec: '0'};
	$('.currency_rupiah').autoNumeric('init', myOptions); 
}

</script>