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
								<th class="align-middle text-center">Barcode</th>
								<th class="align-middle text-center">Nama Alkes</th>
								<th class="align-middle text-center">Lokasi</th>
								<th class="align-middle text-center">Rak</th>
								<th class="align-middle text-center">Harga</th>
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
				<div class="form-group alkes_barcode-field">
					<label for="" class="form-label">Barcode</label>
					<input type="text" name="alkes_barcode" id="alkes_barcode" class="form-control">
				</div>
				<div class="form-group alkes_name-field">
					<label for="" class="form-label">Nama Alkes</label>
					<input type="text" name="alkes_name" id="alkes_name" class="form-control">
				</div>
				<div class="form-group alkes_type-field">
					<label for="" class="form-label">Jenis Alkes</label>
					<select name="alkes_type" class="form-control form-select2" id="alkes_type" style="width: 100%;" data-placeholder="Pilih Jenis Alkes">
						<option value=""></option>
						<option value="generic">Generik</option>
						<option value="non_generic">Non Generik</option>
					</select>
					<label id="alkes_type-error" class="error" for="alkes_type" style="display: none;"></label>
				</div>
				<div class="form-group alkes_kemasan-field">
					<label for="" class="form-label">Kemasan</label>
					<input type="text" name="alkes_kemasan" id="alkes_kemasan" class="form-control">
				</div>
				<div class="form-group alkes_lokasi-field">
					<label for="" class="form-label">Lokasi</label>
					<input type="text" name="alkes_lokasi" id="alkes_lokasi" class="form-control">
				</div>
				<div class="form-group alkes_rak-field">
					<label for="" class="form-label">Rak</label>
					<input type="text" name="alkes_rak" id="alkes_rak" class="form-control">
				</div>
				<div class="form-group alkes_price-field">
					<label for="" class="form-label">Harga Modal</label>
					<input type="number" name="alkes_price" id="alkes_price" class="form-control" min="0">
				</div>
				<div class="form-group alkes_margin-field">
					<label for="" class="form-label">Margin (%)</label>
					<input type="number" name="alkes_margin" id="alkes_margin" class="form-control" min="0">
				</div>
				<div class="form-group alkes_price_sale-field">
					<label for="" class="form-label">Harga Setelah Margin</label>
					<input type="text" name="alkes_price_sale" id="alkes_price_sale" class="form-control" readonly="">
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="alkes_id" id="alkes_id" class="form-control" value="0">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
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
				alkes_barcode: {
					required: function(element) {
						return $('.alkes_barcode-field').addClass('is-invalid');
					},
					remote: {
						url: "<?= site_url('admin/'.$class.'/action_validation');?>",
						type: "post",
						data: {
							alkes_barcode: function() {
							return $("#alkes_barcode").val();
							},
							alkes_id: function() {
							return $("#alkes_id").val();
							}
						}
					}
				},
				alkes_name: {
					required: function(element) {
						return $('.alkes_name-field').addClass('is-invalid');
					},
				},
				alkes_kemasan: {
					required: function(element) {
						return $('.alkes_kemasan-field').addClass('is-invalid');
					},
				},
				alkes_price: {
					required: function(element) {
						return $('.alkes_price-field').addClass('is-invalid');
					},
				},
				alkes_margin: {
					required: function(element) {
						return $('.alkes_margin-field').addClass('is-invalid');
					},
				},
				alkes_price_sale: {
					required: function(element) {
						return $('.alkes_price_sale-field').addClass('is-invalid');
					},
				},
				alkes_type: {
					required: function(element) {
						return $('.alkes_type-field').addClass('is-invalid');
					},
				},
			},
            messages:{
                alkes_barcode: {
                    remote: "Barcode sudah di gunakan"
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
		
		var $harga = $('#alkes_price');
		var $margin = $('#alkes_margin');
		var $total = $('#alkes_price_sale');

		function calcVal() {
			
			var num1 = $harga.val();
			var num2 = $margin.val();
			var result = parseInt(num1, 10) + (parseInt(num2, 10)/100*parseInt(num1, 10));
			if (!isNaN(result)) {
				$total.val(result);
			}
		}

		calcVal();

		$harga.on("keydown keyup", function() {
			calcVal();
		});
		$margin.on("keydown keyup", function() {
			calcVal();
		});
	
		$('input[type="number"]').on('wheel', function() {
			return false;
		});
	});

	/* munculkan popup edit dan load data */
	function edit_form(alkes_id) {
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/action_data_form');?>',
			type:'GET',
			dataType:'json',
			data:'alkes_id='+alkes_id,
			success:function(response){
				if(response['status']==200) {
					$('#FormData').find('[name="alkes_id"]').val(response['data']['alkes_id']);
					$('#FormData').find('[name="alkes_name"]').val(response['data']['alkes_name']);
					$('#FormData').find('[name="alkes_price"]').val(response['data']['alkes_price']);
					$('#FormData').find('[name="alkes_margin"]').val(response['data']['alkes_margin']);
					$('#FormData').find('[name="alkes_barcode"]').val(response['data']['alkes_barcode']);
					$('#FormData').find('[name="alkes_kemasan"]').val(response['data']['alkes_kemasan']);
					$('#FormData').find('[name="alkes_price_sale"]').val(response['data']['alkes_price_sale']);
					$('#FormData').find('[name="alkes_lokasi"]').val(response['data']['alkes_lokasi']);
					$('#FormData').find('[name="alkes_rak"]').val(response['data']['alkes_rak']);
					$('#FormData').find('[name="alkes_type"]').val(response['data']['alkes_type']);
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

	function load_table() {
		if($('#datatables thead>tr').length>0) {
			$('#datatables').dataTable().fnDestroy();
		}
		
		var keyword=$("#keyword").val();  
		var link_service='?alkes_name='+keyword;
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
			{data: "alkes_barcode", visible: true},
			{data: "alkes_name", visible: true},
			{data: "alkes_lokasi", visible: true},
			{data: "alkes_rak", visible: true},
			{data: "alkes_price_sale", visible: true},
		],
		});
		
		setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
	}
</script>