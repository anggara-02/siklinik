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
		<?php if ($this->session->flashdata('status')) {$sukses = $this->session->flashdata('sukses');$gagal = $this->session->flashdata('gagal'); ?>
			<div class="col-sm-12 control-label action_message" id="action_message">
				<div class="callout mb-1 <?= ($this->session->flashdata('status') == '200') ? 'callout-success' : 'callout-danger'; ?>">
					<div style="text-align:left;" class="message"><?= $sukses ? $sukses : $gagal; ?></div>
				</div>
			</div>
		<?php } ?>
		<div class="card-header">
        	<h4>Form Entry</h4>
      	</div>
		<div class="card-body">
			<form class="form-horizontal" id="FormData" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="setting_id" id="setting_id" value="<?= $setting_id ?>">
				<div class="form-group row mb-4 nama_klinik-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Klinik</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="nama_klinik" id="nama_klinik" class="form-control" value="">
					</div>
				</div>
				<div class="form-group row mb-4 no_telpon-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telpon</label>
					<div class="col-sm-12 col-md-7">
						<input type="number" name="no_telpon" id="no_telpon" class="form-control" value="">
					</div>
				</div>
				<div class="form-group row mb-4 email-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="email" id="email" class="form-control" value="">
					</div>
				</div>
				<div class="form-group row mb-4 alamat-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
					<div class="col-sm-12 col-md-7">
						<textarea name="alamat" id="alamat" class="form-control" type="text" rows="5"></textarea>
					</div>
				</div>
                <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo Klinik</label>
                    <div class="col-sm-12 col-md-7 logo-field">
                        <input type="file" name="logo" id="logo" class="form-control">
                    </div>
                    <?php if ($logo!='0') { ?>
                    <div>
                        <a href="<?= site_url('admin/'.$class.'/download/'.$logo);?>" target="_blank">
                            <button type="button" class="btn btn-info">Download Logo Klinik</button>
                        </a>
                    </div>
                    <?php } ?>
                </div>
				<div class="form-group row mb-4 apoteker-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Apoteker</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="apoteker" id="apoteker" class="form-control" value="">
					</div>
				</div>
				<div class="form-group row mb-4 sipa-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor SIPA</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="sipa" id="sipa" class="form-control" value="">
					</div>
				</div>
				<div class="form-group row mb-4 sia-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor SIA</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" name="sia" id="sia" class="form-control" value="">
					</div>
				</div>
				<div class="form-group row mb-4 min_promo-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Minimal Belanja Promo</label>
					<div class="col-sm-12 col-md-7">
						<input type="number" name="min_promo" id="min_promo" class="form-control" value="">
					</div>
				</div>
				<div class="form-group row mb-4 konversi_poin-field">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Konversi Poin</label>
					<div class="col-sm-12 col-md-7">
						<input type="number" name="konversi_poin" id="konversi_poin" class="form-control" value="">
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
					<div class="col-sm-12 col-md-7">
						<button type="button" id="save" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</form>
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

	#alamat {
		height: auto;
	}
</style>
<script>
	$(document).ready(function() { 
		setTimeout(function() {
			$('.action_message').hide();
		}, 5000);
		var setting_id = $('input[name="setting_id"]').val();
		if (setting_id == 0) {
			$('#FormData').find('input,textarea,select').val('');
		} else {
			$.ajax({
				url:'<?= site_url('admin/'.$class.'/action_data_form');?>',
				type:'GET',
				dataType:'json',
				data:'setting_id='+setting_id,
				success:function(response){
					if(response['status']==200) {
						$('#FormData').find('[name="setting_id"]').val(response['data']['setting_id']);
						$('#FormData').find('[name="nama_klinik"]').val(response['data']['nama_klinik']);
						$('#FormData').find('[name="no_telpon"]').val(response['data']['no_telpon']);
						$('#FormData').find('[name="email"]').val(response['data']['email']);
						$('#FormData').find('[name="alamat"]').val(response['data']['alamat']);
						$('#FormData').find('[name="apoteker"]').val(response['data']['apoteker']);
						$('#FormData').find('[name="sipa"]').val(response['data']['sipa']);
						$('#FormData').find('[name="sia"]').val(response['data']['sia']);
						$('#FormData').find('[name="min_promo"]').val(response['data']['min_promo']);
						$('#FormData').find('[name="konversi_poin"]').val(response['data']['konversi_poin']);
					} else {
						custom_message(response['status'],response['message']); //get on custom.js				   
					}
					
				}, error:function(){
					alert('terjadi kesalahan saat validasi'); 
					$('.modal-footer').show();	
					$('.button').show();
					$('.btn').prop('disabled',false);			
				}
			});
		}
		
		$.validator.setDefaults({
			ignore: ":hidden:not('select')" // validate all hidden select elements
		});

		var validator = $('#FormData').validate({
			rules: {
				nama_klinik: {
					required: function(element) {
						return $('.nama_klinik-field').addClass('is-invalid');
					},
				},
				no_telpon: {
					required: function(element) {
						return $('.no_telpon-field').addClass('is-invalid');
					},
				},
				email: {
					required: function(element) {
						return $('.email-field').addClass('is-invalid');
					},
				},
				alamat: {
					required: function(element) {
						return $('.alamat-field').addClass('is-invalid');
					},
				},
				logo: {
                    required: function(element) {
                        var logo = '<?= $logo ?>';
                        if (logo==0) {
                            return $('.logo-field').addClass('is-invalid');
                        } else {
                            return false;
                        }
                    }
				},
				apoteker: {
					required: function(element) {
						return $('.apoteker-field').addClass('is-invalid');
					},
				},
				sipa: {
					required: function(element) {
						return $('.sipa-field').addClass('is-invalid');
					},
				},
				sia: {
					required: function(element) {
						return $('.sia-field').addClass('is-invalid');
					},
				},
				min_promo: {
					required: function(element) {
						return $('.min_promo-field').addClass('is-invalid');
					},
				},
				konversi_poin: {
					required: function(element) {
						return $('.konversi_poin-field').addClass('is-invalid');
					},
				},
			},
		});
	});

	/* aksi simpan/edit diklik */
	$('#save').click(function(e) {
		var data = {};
		var setting_id = $('input[name="setting_id"]').val();
		var form_data = new FormData($('#FormData')[0]);
		if ($('#FormData').valid() != false) {
			swal({
				title: 'Apakah anda yakin?',
				text: 'Pastikan data sudah sesuai',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
			}).then((confirm) => {
				if (confirm) {
					$.ajax({
						url: '<?= site_url('admin/' . $class . '/do_upload'); ?>',
						type: 'POST',
						dataType: 'JSON',
						data: form_data,
						processData:false,
						contentType:false,
						cache:false,
						async:false,
						success: function(response) {
							if (response=1) {
								window.location.href = '<?= base_url('admin/' . $class . '/after_save'); ?>';
							}
						},
					});
				}
			});
		}
	});
</script>