<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ -->
	
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 
           
<div class="section-body">
	<div class="card">
		<?php if ($this->session->flashdata('status')) {$sukses = $this->session->flashdata('sukses'); $gagal = $this->session->flashdata('gagal');?>
			<div class="col-sm-12 control-label action_message" id="action_message"> 
				<div class="callout mb-1 <?= ($this->session->flashdata('status')=='200')?'callout-success':'callout-danger'; ?>">
					<div style="text-align:left;" class="message"><?= $sukses ? $sukses : $gagal; ?></div>
				</div>
			</div>
		<?php } ?>
		<div class="section-body">
			<div class="card">
				<div class="p-4 border-bottom border-light">
					<div class="row mx-n2">
						<div class="col-md-auto mb-3 mb-md-0 px-2">
							<a href="#" onclick="add_form()" class="btn btn-primary add" shortcut="f2">Tambah</a>
						</div>
						<div class="col-md-auto px-2 ml-auto">
							<div class="input-group">
								<input type="text" id="keyword" autocomplete="off" name="keyword" class="form-control input-sm" placeholder="Search" size="20">
								<div class="input-group-append">
									<button class="btn btn-primary" shortcut="ctrl+enter" onclick="load_table();return false;"><i class="fa fa-search"></i></button>
								</div> 
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div> 
		<div class="col-md-12">
			<div class="box box-success">
				<div class="box-body"> 
					<div class="clearfix"></div>
					<table id="datatables" class="table table-sm table-bordered text-nowrap" style="width: 100%">
						<thead>
							<tr class="bg-light">
								<th class="align-middle text-center">No.</th>
								<th class="align-middle text-center">Aksi</th>
								<th class="align-middle text-center">Poli</th>
								<th class="align-middle text-center">Layanan Medis</th>
								<th class="align-middle text-center">Tarif</th>
								<th class="align-middle text-center">BHP</th>
								<th class="align-middle text-center">Total Tarif</th>
							</tr>
						</thead>
					</table>
				</div> 
		  	</div> 
	  	</div>  
	</div> 
</div> 
<div class="modal fade" id="modal-form" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form class="form-horizontal" id="FormData" method="POST" action="<?= site_url('admin/'.$class.'/action_stored');?>" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title">Form Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group layanan_poli_id-field">
						<label for="" class="form-label">Poli</label>
						<select class="form-control form-select2" name="layanan_poli_id" id="layanan_poli_id" data-placeholder="Pilih Poli">
							<option value=""></option>
							<?php if(isset($role_arr)&&!empty($role_arr)) {
								foreach($role_arr as $rowArr) {
									echo '<option value="'.$rowArr['poli_id'].'">'.$rowArr['poli_name'].'</option>';
								}
							} ?>
						</select> 
						<label id="layanan_poli_id-error" class="error" for="layanan_poli_id" style="display: none;"></label>
					</div>
					<div class="form-group layanan_name-field">
						<label for="" class="form-label">Nama Layanan Medis</label>
						<input type="text" name="layanan_name" id="layanan_name" class="form-control" value="">
						<label id="layanan_name-error" class="error" for="layanan_name" style="display: none;"></label>
					</div>
					<div class="form-group layanan_tarif-field">
						<label for="" class="form-label">Tarif Layanan Medis</label>
						<input type="number" name="layanan_tarif" id="layanan_tarif" class="form-control" min="0" value="">
					</div>
					<div class="form-group layanan_bph-field">
						<label for="" class="form-label">Tarif BHP</label>
						<input type="number" name="layanan_bph" id="layanan_bph" class="form-control" min="0" value="">
					</div>
					<div class="form-group layanan_total-field">
						<label for="" class="form-label">Total Tarif</label>
						<input type="text" name="layanan_total" id="layanan_total" class="form-control" readonly="">
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="layanan_id" id="layanan_id" class="form-control" value="0">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary simpan">Simpan</button>
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
</style>
<script>
	$(document).on('change', '#layanan_poli_id', function () {
		var layanan_poli_id = $('#layanan_poli_id').val();
		if (layanan_poli_id) {
			$('#layanan_poli_id-error').hide();
		}
	});
	$(function(){$('.form-select2').select2();});
	$(document).ready(function() { 
		load_table();	
    	setTimeout(function(){ 
			$('.action_message').hide();
			$('.action_message').find('.message').html('');
		}, 2000);
		
		$.validator.setDefaults({
			ignore: ":hidden:not('select')" // validate all hidden select elements
		});

		var validator = $('#FormData').validate({
			rules: {
				layanan_poli_id: {
					required: function(element) {
						return $('.layanan_poli_id-field').addClass('is-invalid');
					}
				},
				layanan_name: {
					required: function(element) {
						return $('.layanan_name-field').addClass('is-invalid');
					},
                    remote: {
						url: "<?= site_url('admin/'.$class.'/action_validation');?>",
						type: "post",
						data: {
							layanan_name: function() {
							return $("#layanan_name").val();
							},
							layanan_id: function() {
							return $("#layanan_id").val();
							}
						}
					} 
				},
				layanan_tarif: {
					required: function(element) {
						return $('.layanan_tarif-field').addClass('is-invalid');
					}
				},
				layanan_bph: {
					required: function(element) {
						return $('.layanan_bph-field').addClass('is-invalid');
					}
				},
				layanan_total: {
					required: function(element) {
						return $('.layanan_total-field').addClass('is-invalid');
					}
				},
			},
            messages:{
                layanan_name: {
                    remote: "Layanan Medis sudah di gunakan"
                }
            }
		});
	});
	
	$("#modal-form").on('hidden.bs.modal', function () {
		$('.form-group').removeClass('is-invalid');
		$('label[class="error"]').hide();
	});

	$(function() {
        $("input[type='number']").on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
		
		var $tarif = $('#layanan_tarif');
		var $bph = $('#layanan_bph');
		var $total = $('#layanan_total');

		function calcVal() {
			var num1 = $tarif.val();
			var num2 = $bph.val();
			var result = parseInt(num1, 10) + parseInt(num2, 10);
			if (!isNaN(result)) {
				$total.val(result);
			}
		}

		calcVal();

		$tarif.on("keydown keyup", function() {
			calcVal();
		});
		$bph.on("keydown keyup", function() {
			calcVal();
		});
		
		$('input[type="number"]').on('wheel', function() {
			return false;
		});
    });

	/* munculkan popup edit dan load data */
	function edit_form(layanan_id) {
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/action_data_form');?>',
			type:'GET',
			dataType:'json',
			data:'layanan_id='+layanan_id,
			success:function(response){
				if(response['status']==200) {
					$('#FormData').find('[name="layanan_id"]').val(response['data']['layanan_id']);
					$('#FormData').find('[name="layanan_name"]').val(response['data']['layanan_name']);
					$('#FormData').find('[name="layanan_tarif"]').val(response['data']['layanan_tarif']);
					$('#FormData').find('[name="layanan_bph"]').val(response['data']['layanan_bph']);
					$('#FormData').find('[name="layanan_total"]').val(response['data']['layanan_total']);
					$('#FormData').find('[name="layanan_poli_id"]').val(response['data']['layanan_poli_id']);
					$('#modal-form').modal('show');
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

	/* fitur stored add maupun edit pembeda pada user_id atau primarykey */
	function trx_stored() {
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/action_stored');?>',
			type:'POST',
			dataType:'json',
			data:$('#FormData').serialize(),
			success: function(response){
				action_message(response['status'],response['message']); //get on custom.js
				reset_trx();
				$('#modal-form').modal('hide');
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

	/* aksi simpan/edit diklik */
	function trx_save() {
		/* validasi sebelum stored */
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/action_validation');?>',
			type:'POST',
			dataType:'json',
			data:$('#FormData').serialize(),
			success:function(response){
				if(response['status']==500) {
					return false;
					// custom_message(response['status'],response['message']);
				} else {
					trx_stored();
				}
			},
			error:function(){
				alert('terjadi kesalahan saat validasi'); 
				$('.modal-footer').show();	
				$('.button').show();
				$('.btn').prop('disabled',false);			
			}
		});
	}

	function load_table() {
		if($('#datatables thead>tr').length>0) {
			$('#datatables').dataTable().fnDestroy();
		}
		
		var keyword=$("#keyword").val();  
		var link_service='?layanan_name='+keyword;
		dataReload(link_service);
	}

	function dataReload(link_service){
		$('#datatables').DataTable({
		processing: true,
		serverSide: true,   
		searching: false,
		aoColumnDefs: [{ "bSortable": false, "aTargets": [ "_all" ],"orderable": false }],
		lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		'ajax': {
			url: '<?php echo base_url('admin/'.$class.'/get_datatable');?>'+link_service,
			type: 'post',
			dataType: 'json',
		},
		'columns':[
			{data: "no","width":"20px", visible: true}, 
			{data: "action","width":"50px", visible: true},
			{data: "poli_name", visible: true},
			{data: "layanan_name", visible: true},
			{data: "layanan_tarif", visible: true},
			{data: "layanan_bph", visible: true},
			{data: "layanan_total", visible: true}
		],
		});
		
		setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
	}
</script>