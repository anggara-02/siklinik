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
								<th class="align-middle text-center">Satuan Dosis</th>
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
				<div class="form-group dosis_name-field">
					<label for="" class="form-label">Satuan Dosis</label>
					<input type="text" name="dosis_name" id="dosis_name" class="form-control" value="">
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="dosis_id" id="dosis_id" class="form-control" value="0">
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
				dosis_name: {
					required: function(element) {
						return $('.dosis_name-field').addClass('is-invalid');
					},
					remote: {
						url: "<?= site_url('admin/'.$class.'/action_validation');?>",
						type: "post",
						data: {
							dosis_name: function() {
							return $("#dosis_name").val();
							},
							dosis_id: function() {
							return $("#dosis_id").val();
							}
						}
					}
				}
			},
            messages:{
                dosis_name: {
                    remote: "Satuan Dosis sudah di gunakan"
                }
            }
		});
	});
	
	$("#modal-form").on('hidden.bs.modal', function () {
		$('.form-group').removeClass('is-invalid');
		$('label[class="error"]').hide();
	});
	
	/* munculkan popup edit dan load data */
	function edit_form(dosis_id) {
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/action_data_form');?>',
			type:'GET',
			dataType:'json',
			data:'dosis_id='+dosis_id,
			success:function(response){
				if(response['status']==200) {
					$('#FormData').find('[name="dosis_name"]').val(response['data']['dosis_name']);
					$('#FormData').find('[name="dosis_id"]').val(response['data']['dosis_id']);
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
				reset_trx(); //get on custom.js
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
		var link_service='?dosis_name='+keyword;
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
			{data: "no", "width":"20px", visible: true}, 
			{data: "action", "width":"50px", visible: true},
			{data: "dosis_name", visible: true}
		],
		});
		
		setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
	}
</script>