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
								<th class="align-middle text-center">Supplier</th>
								<th class="align-middle text-center">Alamat Supplier</th>
								<th class="align-middle text-center">No Telp Supplier</th>
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
				<div class="form-group supplier_name-field">
					<label for="" class="form-label">Supplier</label>
					<input type="text" name="supplier_name" id="supplier_name" class="form-control" value="">
				</div>
				<div class="form-group supplier_address-field">
					<label for="" class="form-label">Alamat Supplier</label>
					<input type="text" name="supplier_address" class="form-control" value="">
				</div>
				<div class="form-group supplier_phone-field">
					<label for="" class="form-label">No Telp Supplier</label>
					<input type="text" name="supplier_phone" class="form-control" value="">
				</div>
				<div class="form-group supplier_sales_name-field">
					<label for="" class="form-label">Nama Sales</label>
					<input type="text" name="supplier_sales_name" class="form-control" value="">
				</div>
				<div class="form-group supplier_sales_phone-field">
					<label for="" class="form-label">No Telp Sales</label>
					<input type="text" name="supplier_sales_phone" class="form-control" value="">
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="0">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
		</div>
	</div>
</div>

<script>
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
				supplier_name: {
					required: function(element) {
						return $('.supplier_name-field').addClass('is-invalid');
					},
                    remote: {
						url: "<?= site_url('admin/'.$class.'/action_validation');?>",
						type: "post",
						data: {
							supplier_name: function() {
							return $("#supplier_name").val();
							},
							supplier_id: function() {
							return $("#supplier_id").val();
							}
						}
					} 
				},
				supplier_address: {
					required: function(element) {
						return $('.supplier_address-field').addClass('is-invalid');
					}
				},
				supplier_phone: {
					required: function(element) {
						return $('.supplier_phone-field').addClass('is-invalid');
					}
				},
				supplier_sales_name: {
					required: function(element) {
						return $('.supplier_sales_name-field').addClass('is-invalid');
					}
				},
				supplier_sales_phone: {
					required: function(element) {
						return $('.supplier_sales_phone-field').addClass('is-invalid');
					}
				}
			},
            messages:{
                supplier_name: {
                    remote: "Supplier sudah di gunakan"
                }
            }
		});
	});
			
	$("#modal-form").on('hidden.bs.modal', function () {
		$('.form-group').removeClass('is-invalid');
		$('label[class="error"]').hide();
	});

	/* munculkan popup edit dan load data */
	function edit_form(supplier_id) {
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/action_data_form');?>',
			type:'GET',
			dataType:'json',
			data:'supplier_id='+supplier_id,
			success:function(response){
				if(response['status']==200) {
					$('#FormData').find('[name="supplier_id"]').val(response['data']['supplier_id']);
					$('#FormData').find('[name="supplier_name"]').val(response['data']['supplier_name']);
					$('#FormData').find('[name="supplier_address"]').val(response['data']['supplier_address']);
					$('#FormData').find('[name="supplier_phone"]').val(response['data']['supplier_phone']);
					$('#FormData').find('[name="supplier_sales_name"]').val(response['data']['supplier_sales_name']);
					$('#FormData').find('[name="supplier_sales_phone"]').val(response['data']['supplier_sales_phone']);
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
		var link_service='?supplier_name='+keyword;
		dataReload(link_service);
	}

	function dataReload(link_service){
		$('#datatables').DataTable({
		processing: true,
		serverSide: true,   
		searching: false,
		// dom: ' Bt<"table-footer clearfix"<"DT-label"i><"DT-pagination"p>>', 				
		aoColumnDefs: [{ "bSortable": false, "aTargets": [ "_all" ],"orderable": false }],
		lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
		'ajax': {
			url: '<?= base_url('admin/'.$class.'/get_datatable');?>'+link_service,
			type: 'post',
			dataType: 'json',
		},
		'columns':[
			{data: "no","width":"20px", visible: true}, 
			{data: "action","width":"50px", visible: true},
			{data: "supplier_name", visible: true},
			{data: "supplier_address", visible: true},
			{data: "supplier_phone", visible: true},
		],
		});
		
		setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
	}
</script>