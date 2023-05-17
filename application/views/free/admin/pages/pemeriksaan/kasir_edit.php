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
    <h1>Kasir</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Pemeriksaan</a></div>
      	<div class="breadcrumb-item">Kasir</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Kasir</h4>
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
		
			<form action="#" id="formApotek" method="POST" enctype="multipart/form-data" enctype="multipart/form-data">
			
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Tindakan</u></label>
				</div>
				<div class="form-group row mb-4">
				
					<label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">&nbsp;</label>
					<div class="col-sm-12 col-md-8"> 
						<div class="table-responsive">
							<table class="table table-product table-bordered table-sm table-r">
								<thead>
									<tr>
										<th>Nama Tindakan</th>
										<th style="width:30%;text-align:right">Tarif</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									if(!empty($layanan_umum)){
									foreach($layanan_umum as $row){?>
										<tr>
											<td><?php echo $row['pendaftaran_layanan_pemeriksaan_name'];?></td>
											<td style="text-align:right"><?php echo common_lib::currency_format($row['pendaftaran_layanan_price']);?></td>
										</tr>
									<?php } } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<hr/>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Pemeriksaan Laboratorium</u></label>
				</div>
				<div class="form-group row mb-4">
				
					<label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">&nbsp;</label>
					<div class="col-sm-12 col-md-8"> 
						<div class="table-responsive">
							<table class="table table-product table-bordered table-sm table-r">
								<thead>
									<tr>
										<th>Nama Layanan Laboratorium</th>
										<th style="width:30%;text-align:right">Tarif</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									if(!empty($layanan_lab)){
									foreach($layanan_lab as $row){?>
										<tr>
											<td><?php echo $row['pendaftaran_layanan_pemeriksaan_name'];?></td>
											<td style="text-align:right"><?php echo common_lib::currency_format($row['pendaftaran_layanan_price']);?></td>
										</tr>
									<?php } } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<hr/>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Resep Obat</u></label>
				</div>
				<div class="form-group row mb-4">
				
					<label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">&nbsp;</label>
					<div class="col-sm-12 col-md-8"> 
						<div class="table-responsive">
							<table class="table table-product table-bordered table-sm table-r">
								<thead>
									<tr>
										<th>Nama Obat</th>
										<th>Kemasan</th>
										<th>Qty</th>
										<th>Dosis</th>
										<th>Aturan Pakai</th>
										<th>Tarif</th>
										<th></th>
									</tr>
								</thead>
								<tbody class="add_row_r">
									
									<?php 
									if(!empty($trx_obat)){
									foreach($trx_obat as $row){?>
										<tr class="tr_data trr_<?php echo $row['pemeriksaan_obat_obat_id'].'_'.$row['pemeriksaan_obat_kemasan_id'].'_'.$row['pemeriksaan_obat_resep'];?>">
											<td class="td">
												<?php echo $row['pemeriksaan_obat_name'];?>  
												<input type="hidden" readonly class="form-control obat_name" id="obat_name" name="obat_name[]" value="<?php echo $row['pemeriksaan_obat_name'];?>  ">
												<input type="hidden" class="form-control obat_id" readonly name="obat_id[]" value="<?php echo $row['pemeriksaan_obat_obat_id'];?>">
												<input type="hidden" class="form-control obat_price" readonly name="obat_price[]" value="<?php echo $row['pemeriksaan_obat_price'];?>">
												<input type="hidden" class="form-control obat_type" readonly name="obat_type[]" value="<?php echo $row['pemeriksaan_obat_type'];?>">
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
												<!--button class="btn btn-danger btn-clone4 btn-sm" type="button" onclick="$(this).parent().parent().remove();calculate_subtotal();return false;"><i class="fa fa-trash"></i></button-->
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
						<input type="text" class="form-control currency_rupiah" name="apotek_subtotal" required readonly value="<?php echo isset($kasir_subtotal)?$kasir_subtotal:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tuslah</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="apotek_tuslah" readonly  value="<?php echo isset($kasir_tuslah)?$kasir_tuslah:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Embalage</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="apotek_embalage" readonly value="<?php echo isset($kasir_embalage)?$kasir_embalage:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon Rp</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="apotek_disc_rp" readonly value="<?php echo isset($kasir_disc_rupiah)?$kasir_disc_rupiah:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon %</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control" step="0.01"  name="apotek_disc_persen" readonly value="<?php echo isset($kasir_disc_persen)?$kasir_disc_persen:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Grand Total Resep</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="apotek_grandtotal" required readonly value="<?php echo isset($kasir_grandtotal)?$kasir_grandtotal:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Grand Total Tindakan & Lab</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="kasir_layanan_price" required readonly value="<?php echo isset($kasir_layanan_price)?$kasir_layanan_price:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Tagihan</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="kasir_total" required readonly value="<?php echo isset($kasir_total)?$kasir_total:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Cara Bayar</label>
					<div class="col-sm-12 col-md-4">
						<select name="bank_name" class="form-input form-select2 bank_name" onchange="change_bank()" style="width: 100%;">
							<?php if(!empty($data_bank)){
									foreach($data_bank as $row){
							?>
							<option value="<?php echo $row['bank_name'];?>"><?php echo $row['bank_name'];?></option>
							<?php } } ?>
						</select>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Bayar</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="tipe_paid" required onchange="calculate_other('tipe')" value="<?php echo isset($tipe_paid)?$tipe_paid:0;?>">
					</div>
				</div>
				<div class="form-group row mb-4 tipe_paid_cash" style="display:none">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Cash</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="tipe_paid_cash" required onchange="calculate_other('cash')" value="<?php echo isset($tipe_paid_cash)?$tipe_paid_cash:0;?>">
					</div>
				</div>
				
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kembalian</label>
					<div class="col-sm-12 col-md-4">
						<input type="text" class="form-control currency_rupiah" name="tipe_kembalian" required value="<?php echo isset($tipe_kembalian)?$tipe_kembalian:0;?>">
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
		currency_rupiah();
		change_bank();
	});
	
$('#formApotek').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});


function calculate_other(tipe)
{
	apotek_grandtotal=$('[name="kasir_total"]').autoNumeric('get');
	tipe_paid_cash=$('[name="tipe_paid_cash"]').autoNumeric('get');
	tipe_paid=$('[name="tipe_paid"]').autoNumeric('get');
	
	_sisa=(tipe_paid_cash*1+tipe_paid*1)-apotek_grandtotal*1;
	
	
	if(tipe=='tipe')
	{
		sisa=apotek_grandtotal-tipe_paid;
		
		sisa=(sisa>0)?sisa:0;
		$('[name="tipe_paid_cash"]').autoNumeric('set',sisa);
	}
	else
	{
		sisa=apotek_grandtotal-tipe_paid_cash;
		sisa=(sisa>0)?sisa:0;
		$('[name="tipe_paid"]').autoNumeric('set',sisa);
	}
	
	sisa=(_sisa>0)?_sisa:0;
	$('[name="tipe_kembalian"]').autoNumeric('set',sisa);
	
}

function change_bank()
{
	bank_name=$('[name="bank_name"]').val();
	apotek_grandtotal=$('[name="kasir_total"]').autoNumeric('get');
	if(bank_name=='Cash/Tunai'||bank_name=='cash/tunai'||bank_name=='cash / tunai'||bank_name=='Cash / Tunai')
	{
		$('[name="tipe_paid_cash"]').autoNumeric('set',0);
		$('[name="tipe_paid"]').autoNumeric('set',apotek_grandtotal);
		$('.tipe_paid_cash').hide();
	}
	else
	{
		$('[name="tipe_paid_cash"]').autoNumeric('set',0);
		$('[name="tipe_paid"]').autoNumeric('set',apotek_grandtotal);
		$('.tipe_paid_cash').show();
	}
}

function currency_rupiah()
{
	var myOptions = {aSep: '.', aDec: ',',mDec: '0'};
	$('.currency_rupiah').autoNumeric('init', myOptions); 
}

</script>