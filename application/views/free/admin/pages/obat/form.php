<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
==========DON'T REMOVE============ -->

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Entry</h4>
      	</div>
		<div class="card-body">
			<form class="form-horizontal" id="FormData" method="POST" action="<?= site_url('admin/'.$class.'/action_stored');?>" enctype="multipart/form-data">
				<input type="hidden" name="obat_id" id="obat_id" value="<?= $obat_id ?>">
				<div class="form-group row mb-4 obat_barcode-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode Barcode</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="obat_barcode" id="obat_barcode" class="form-control" value="">
					</div>
				</div>
				<div class="form-group row mb-4 obat_name-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Obat</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="obat_name" id="obat_name" class="form-control" value="<?= set_value('obat_name'); ?>">
					</div>
				</div>
				<div class="form-group row mb-4 obat_type-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Obat</label>
					<div class="col-sm-12 col-md-7">
						<select name="obat_type" class="form-control form-select2" id="obat_type" style="width: 100%;" data-placeholder="Pilih Jenis Obat">
							<option value=""></option>
							<option value="generic">Generik</option>
							<option value="non_generic">Non Generik</option>
						</select>
						<label id="obat_type-error" class="error" for="obat_type" style="display: none;"></label>
					</div>
				</div>
				<div class="form-group row mb-4 obat_lokasi-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lokasi</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="obat_lokasi" id="obat_lokasi" class="form-control" value="<?= set_value('obat_lokasi'); ?>">
					</div>
				</div>
				<div class="form-group row mb-4 obat_rak-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rak</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="obat_rak" id="obat_rak" class="form-control" value="<?= set_value('obat_rak'); ?>">
					</div>
				</div>
				<div class="form-group row mb-4 obat_dosis_value-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Dosis</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="obat_dosis_value" id="obat_dosis_value" class="form-control" value="<?= set_value('obat_dosis_value'); ?>">
					</div>
				</div>
				<div class="form-group row mb-4 obat_dosis_id-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan Dosis</label>
					<div class="col-sm-12 col-md-7">
						<select class="form-control form-select2" name="obat_dosis_id" id="obat_dosis_id" data-placeholder="Pilih Satuan Dosis">
							<option value=""></option>
							<?php if(isset($dosis_arr)&&!empty($dosis_arr)) {
								foreach($dosis_arr as $rowArr) {
									echo '<option value="'.$rowArr['dosis_id'].'">'.$rowArr['dosis_name'].'</option>';
								}
							} ?>
						</select>
						<label id="obat_dosis_id-error" class="error" for="obat_dosis_id" style="display: none;"></label>
					</div>
				</div>
				<div class="form-group row mb-4 obat_price-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Kemasan Kecil (HNA+PPN)</label>
					<div class="col-sm-12 col-md-7">
						<input type="number" name="obat_price" id="obat_price" class="form-control" value="<?= set_value('obat_price'); ?>">
					</div>
				</div>
				<div class="form-group row mb-4 obat_margin_non_resep-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Margin Non Resep (%)</label>
					<div class="col-sm-12 col-md-7">
						<input type="number" name="obat_margin_non_resep" id="obat_margin_non_resep" class="form-control" value="<?= set_value('obat_margin_non_resep'); ?>">
					</div>
				</div>
				<div class="form-group row mb-4 obat_margin_resep-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Margin Resep (%)</label>
					<div class="col-sm-12 col-md-7">
						<input type="number" name="obat_margin_resep" id="obat_margin_resep" class="form-control" value="<?= set_value('obat_margin_resep'); ?>">
					</div>
				</div>
				<div class="form-group row mb-4 obat_price_non_resep-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Setelah Margin (Non Resep)</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="obat_price_non_resep" id="obat_price_non_resep" class="form-control" readonly="">
					</div>
				</div>
				<div class="form-group row mb-4 obat_price_resep-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Setelah Margin (Resep)</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="obat_price_resep" id="obat_price_resep" class="form-control" readonly="">
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4 obat_kemasan_kecil_id-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kemasan Kecil</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original">
								<div class="col-md-3 px-1">
									<select class="form-control form-select2" name="obat_kemasan_kecil_id" id="obat_kemasan_kecil_id" data-placeholder="Pilih Kemasan">
										<option value=""></option>
										<?php if(isset($kemasan_arr)&&!empty($kemasan_arr)) {
											foreach($kemasan_arr as $rowArr) {
												echo '<option value="'.$rowArr['kemasan_id'].'" data-name="'.$rowArr['kemasan_name'].'">'.$rowArr['kemasan_name'].'</option>';
											}
										} ?>
									</select> 
									<label id="obat_kemasan_kecil_id-error" class="error" for="obat_kemasan_kecil_id" style="display: none;"></label>
								</div>
								<div class="col-md-2 px-1">
									<input type="text" name="obat_kemasan_kecil_konversi" id="obat_kemasan_kecil_konversi" class="form-control form-control" placeholder="Qty" readonly="" value="1">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4 obat_kemasan_sedang_id-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kemasan Sedang</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original">
								<div class="col-md-3 px-1">
									<select class="form-control form-select2" name="obat_kemasan_sedang_id" id="obat_kemasan_sedang_id" data-placeholder="Pilih Kemasan">
										<option value=""></option>
										<?php if(isset($kemasan_arr)&&!empty($kemasan_arr)) {
											foreach($kemasan_arr as $rowArr) {
												echo '<option value="'.$rowArr['kemasan_id'].'">'.$rowArr['kemasan_name'].'</option>';
											}
										} ?>
									</select> 
									<label id="obat_kemasan_sedang_id-error" class="error" for="obat_kemasan_sedang_id" style="display: none;"></label>
								</div>
								<div class="col-md-2 px-1">
									<input type="number" name="obat_kemasan_sedang_konversi" id="obat_kemasan_sedang_konversi" class="form-control form-control" placeholder="Qty">
								</div>
								<div class="col-md-2 px-1">
									<label for="obat_kemasan_sedang_id" class="col-form-label text-md-right" id="kemasan_sedang"></label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4 obat_kemasan_besar_id-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kemasan Besar</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original">
								<div class="col-md-3 px-1">
									<select class="form-control form-select2" name="obat_kemasan_besar_id" id="obat_kemasan_besar_id" data-placeholder="Pilih Kemasan">
										<option value=""></option>
										<?php if(isset($kemasan_arr)&&!empty($kemasan_arr)) {
											foreach($kemasan_arr as $rowArr) {
												echo '<option value="'.$rowArr['kemasan_id'].'">'.$rowArr['kemasan_name'].'</option>';
											}
										} ?>
									</select> 
									<label id="obat_kemasan_besar_id-error" class="error" for="obat_kemasan_besar_id" style="display: none;"></label>
								</div>
								<div class="col-md-2 px-1">
									<input type="number" name="obat_kemasan_besar_konversi" id="obat_kemasan_besar_konversi" class="form-control form-control" placeholder="Qty">
								</div>
								<div class="col-md-2 px-1">
									<label for="obat_kemasan_besar_id" class="col-form-label text-md-right" id="kemasan_besar"></label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
					<div class="col-sm-12 col-md-7">
						<button type="submit" name="save" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-form" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">			
				<div class="row custom_message">
					<div class="col-sm-12 control-label"> 
						<div>
							<div style="text-align:left;" class="mb-1 message"><?= $message; ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	/* Chrome, Safari, Edge, Opera */
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	/* Firefox */
	input[type=number] {
		-moz-appearance: textfield;
	}
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	$(function(){$('.form-select2').select2();});
	$(document).ready(function() { 
		var obat_id = $('input[name="obat_id"]').val();
		if (obat_id == 0) {
			$('#FormData').find('input,textarea,select').val('');
			$('input[name="obat_kemasan_kecil_konversi"]').val('1');
		} else {
			$.ajax({
				url:'<?= site_url('admin/'.$class.'/action_data_form');?>',
				type:'GET',
				dataType:'json',
				data:'obat_id='+obat_id,
				success:function(response){
					if(response['status']==200) {
						$('#FormData').find('[name="obat_id"]').val(response['data']['obat_id']);
						$('#FormData').find('[name="obat_barcode"]').val(response['data']['obat_barcode']);
						$('#FormData').find('[name="obat_name"]').val(response['data']['obat_name']);
						$('#FormData').find('[name="obat_lokasi"]').val(response['data']['obat_lokasi']);
						$('#FormData').find('[name="obat_rak"]').val(response['data']['obat_rak']);
						$('#FormData').find('[name="obat_dosis_value"]').val(response['data']['obat_dosis_value']);
						$('#FormData').find('[name="obat_price"]').val(response['data']['obat_price']);
						$('#FormData').find('[name="obat_margin_resep"]').val(response['data']['obat_margin_resep']);
						$('#FormData').find('[name="obat_margin_non_resep"]').val(response['data']['obat_margin_non_resep']);
						$('#FormData').find('[name="obat_price_resep"]').val(response['data']['obat_price_resep']);
						$('#FormData').find('[name="obat_price_non_resep"]').val(response['data']['obat_price_non_resep']);
						$('#FormData').find('[name="obat_kemasan_kecil_konversi"]').val(response['data']['obat_kemasan_kecil_konversi']);
						$('#FormData').find('[name="obat_kemasan_sedang_konversi"]').val(response['data']['obat_kemasan_sedang_konversi']);
						$('#FormData').find('[name="obat_kemasan_besar_konversi"]').val(response['data']['obat_kemasan_besar_konversi']);
						$("#obat_type").val(response['data']['obat_type']);
						$("#obat_type").select2().trigger('change');
						$("#obat_dosis_id").val(response['data']['obat_dosis_id']);
						$("#obat_dosis_id").select2().trigger('change');
						$("#obat_kemasan_kecil_id").val(response['data']['obat_kemasan_kecil_id']);
						$("#obat_kemasan_kecil_id").select2().trigger('change');
						$("#obat_kemasan_sedang_id").val(response['data']['obat_kemasan_sedang_id']);
						$("#obat_kemasan_sedang_id").select2().trigger('change');
						$("#obat_kemasan_besar_id").val(response['data']['obat_kemasan_besar_id']);
						$("#obat_kemasan_besar_id").select2().trigger('change');
					} else {
						custom_message(response['status'],response['message']); //get on custom.js				   
					}
					get_kemasan(response['data']['obat_kemasan_kecil_id']);
					
				}, error:function(){
					alert('terjadi kesalahan saat validasi'); 
					$('.modal-footer').show();	
					$('.button').show();
					$('.btn').prop('disabled',false);			
				}
			});
		}
		
        $("#obat_kemasan_kecil_id").on('change', function(e) {
			var id_kemasan = $(this).val();
			get_kemasan(id_kemasan);
        });
		
		$.validator.setDefaults({
			ignore: ":hidden:not('select')" // validate all hidden select elements
		});

		var validator = $('#FormData').validate({
			rules: {
				obat_barcode: {
					required: function(element) {
						return $('.obat_barcode-field').addClass('is-invalid');
					},
					remote: {
						url: "<?= site_url('admin/'.$class.'/action_validation');?>",
						type: "post",
						data: {
							obat_barcode: function() {
							return $("#obat_barcode").val();
							},
							obat_id: function() {
							return $("#obat_id").val();
							}
						}
					}
				},
				obat_name: {
					required: function(element) {
						return $('.obat_name-field').addClass('is-invalid');
					},
				},
				obat_type: {
					required: function(element) {
						return $('.obat_type-field').addClass('is-invalid');
					},
				},
				obat_dosis_value: {
					required: function(element) {
						return $('.obat_dosis_value-field').addClass('is-invalid');
					},
				},
				obat_dosis_id: {
					required: function(element) {
						return $('.obat_dosis_id-field').addClass('is-invalid');
					},
				},
				obat_price: {
					required: function(element) {
						return $('.obat_price-field').addClass('is-invalid');
					},
				},
				obat_margin_non_resep: {
					required: function(element) {
						return $('.obat_margin_non_resep-field').addClass('is-invalid');
					},
				},
				obat_margin_resep: {
					required: function(element) {
						return $('.obat_margin_resep-field').addClass('is-invalid');
					},
				},
				obat_price_non_resep: {
					required: function(element) {
						return $('.obat_price_non_resep-field').addClass('is-invalid');
					},
				},
				obat_price_resep: {
					required: function(element) {
						return $('.obat_price_resep-field').addClass('is-invalid');
					},
				},
				obat_kemasan_kecil_id: {
					required: function(element) {
						return $('.obat_kemasan_kecil_id-field').addClass('is-invalid');
					},
				},
				obat_kemasan_kecil_konversi: {
					required: function(element) {
						return $('.obat_kemasan_kecil_konversi-field').addClass('is-invalid');
					},
				},
				obat_kemasan_sedang_id: {
					required: function(element) {
						return $('.obat_kemasan_sedang_id-field').addClass('is-invalid');
					},
				},
				obat_kemasan_sedang_konversi: {
					required: function(element) {
						return $('.obat_kemasan_sedang_konversi-field').addClass('is-invalid');
					},
				},
				obat_kemasan_besar_id: {
					required: function(element) {
						return $('.obat_kemasan_besar_id-field').addClass('is-invalid');
					},
				},
				obat_kemasan_besar_konversi: {
					required: function(element) {
						return $('.obat_kemasan_besar_konversi-field').addClass('is-invalid');
					},
				},
			},
            messages:{
                obat_barcode: {
                    remote: "Barcode sudah di gunakan"
                }
            }
		});

		$(document).on('change', '#obat_type, #obat_dosis_id, #obat_kemasan_kecil_id, #obat_kemasan_sedang_id, #obat_kemasan_besar_id', function () {
			var obat_type = $('#obat_type').val();
			var obat_dosis_id = $('#obat_dosis_id').val();
			var obat_kemasan_kecil_id = $('#obat_kemasan_kecil_id').val();
			var obat_kemasan_sedang_id = $('#obat_kemasan_sedang_id').val();
			var obat_kemasan_besar_id = $('#obat_kemasan_besar_id').val();
			if (obat_type) {
				$('#obat_type-error').hide();
			}
			if (obat_dosis_id) {
				$('#obat_dosis_id-error').hide();
			}
			if (obat_kemasan_kecil_id) {
				$('#obat_kemasan_kecil_id-error').hide();
			}
			if (obat_kemasan_sedang_id) {
				$('#obat_kemasan_sedang_id-error').hide();
			}
			if (obat_kemasan_besar_id) {
				$('#obat_kemasan_besar_id-error').hide();
			}
		});
	});

	/* aksi simpan/edit diklik */
	function cek_validasi() {
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/action_validation');?>',
			type:'POST',
			dataType:'json',
			data:$('#FormData').serialize(),
			success:function(response){
				if(response['status']==500) {
    				$('#modal-form').modal('show');
					validation_message(response['status'],response['message']);
				} else {
					swal({
						title: 'Apakah anda yakin?',
						text: 'Pastikan data sudah sesuai',
						icon: 'warning',
						buttons: true,
						dangerMode: true,
					}).then((confirm) => {
						if (confirm) {
							$.ajax({
								url:'<?= site_url('admin/'.$class.'/store_form');?>',
								type:'POST',
								dataType:'json',
								data:$('#FormData').serialize(),
								success: function(response){
									console.log(response['url']);
									window.location.href = '<?= site_url('admin/'.$class.'/index'); ?>';
								},
							});	
						}
					});
				}
			}
		});
	}

	function get_kemasan(id_kemasan) {
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/get_kemasan');?>',
			type:'POST',
			dataType:'json',
			data:'id_kemasan='+ id_kemasan,
			success:function(response){
				console.log(response);
				$("#kemasan_sedang").text(response.kemasan_name);
				$("#kemasan_besar").text(response.kemasan_name);
			}
		});
	}
	
	$(function() {
        $("input[type='number']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
		
		var $harga = $('#obat_price');
		var $margin_non_resep = $('#obat_margin_non_resep');
		var $margin_resep = $('#obat_margin_resep');
		var $obat_price_non_resep = $('#obat_price_non_resep');
		var $obat_price_resep = $('#obat_price_resep');

		function calcVal() {
			var num1 = $harga.val();
			var num2 = $margin_non_resep.val();
			var num3 = $margin_resep.val();
			var obat_price_non_resep = parseInt(num1, 10) + (parseInt(num2, 10)/100*parseInt(num1, 10));
			var obat_price_resep = parseInt(num1, 10) + (parseInt(num3, 10)/100*parseInt(num1, 10));
			if (!isNaN(obat_price_non_resep) & !isNaN(obat_price_resep)) {
				$obat_price_non_resep.val(obat_price_non_resep);
				$obat_price_resep.val(obat_price_resep);
			}
		}

		calcVal();

		$harga.on("keydown keyup", function() {
			calcVal();
		});
		$margin_non_resep.on("keydown keyup", function() {
			calcVal();
		});
		$margin_resep.on("keydown keyup", function() {
			calcVal();
		});
		
	
		$('input[type="number"]').on('wheel', function() {
			return false;
		});
    });
</script>