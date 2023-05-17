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
		<div class="col-sm-12 control-label action_message" id="action_message" style="display: none;"> 
			<div class="callout mb-1 <?= ($status==200)?'callout-success':'callout-danger'; ?>">
				<div style="text-align:left;" class="message"><?= $message; ?></div>
			</div>
		</div> 
		<div class="section-body">
			<div class="card">
				<div class="p-4 border-bottom border-light">
					<div class="row mx-n2">
						<div class="col-md-auto mb-3 mb-md-0 px-2">
							<a href="#" onclick="add_form()" class="btn btn-primary add" shortcut="f2">Tambah</a>
						</div>
						<div class="col-md-auto px-2 ml-auto">
							<div class="input-group">
								<input type="text" data-date-format="dd-mm-yyyy" value="<?php echo ($this->input->get('start_date'))?$this->input->get('start_date'):date('d-m-Y')?>" id="date_start" class="form-control datepicker" placeholder="Tgl Awal" size="10">
								<input type="text" data-date-format="dd-mm-yyyy" value="<?php echo $this->input->get('end_date')?$this->input->get('end_date'):date('d-m-Y')?>" id="date_end" class="form-control datepicker" placeholder="Tgl Akhir" size="10">

								
								<select type="text" id="shift" name="search_jadwal_shift_id" class="form-control input-sm">
									<option value="">Semua Shift</option>
									<?php foreach($shift_arr as $arr) { ?>
										<option value="<?php echo $arr['shift_id'];?>"><?php echo $arr['shift_name'];?></option>
									<?php } ?>
								</select>
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
					<table id="datatables" class="table table-striped table-bordered" style="width: 100%"></table>
				</div> 
		  	</div> 
	  	</div>  
	</div> 
</div> 
<div class="modal fade" id="modal-form" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<form class="form-horizontal" id="FormData" method="POST" action="" enctype="multipart/form-data">
			<div class="modal-header">
				<h5 class="modal-title">Form Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">			
				<div class="control-label custom_message" style="display:none" id="custom_message"> 
					<div class="mb-1 <?= ($status==200)?'callout-success':'error_msg'; ?>">
					  <div style="text-align:left;" class="message">-</div>
					</div>
				</div> 
				<div class="form-group">
					<label for="" class="form-label">Tanggal</label>
					<input type="date" name="jadwal_date" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Poli</label>
					<select type="text" name="jadwal_poli" class="form-control">
						<option value="">Silahkan Pilih</option>
						<option value="umum">Umum</option>
						<option value="laboratorium">Laboratorium</option>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="form-label">Shift</label>
					<select type="text" id="jadwal_shift_id" name="jadwal_shift_id" class="form-control input-sm">
						<option value="">Silahkan Pilih</option>
						<?php foreach($shift_arr as $arr) { ?>
							<option value="<?php echo $arr['shift_id'];?>"><?php echo $arr['shift_name'];?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="form-label">Dokter</label>
					<select type="text" id="jadwal_dokter_id" name="jadwal_dokter_id" class="form-control input-sm">
						<option value="">Silahkan Pilih</option>
						<?php foreach($dokter_arr as $arr) { ?>
							<option value="<?php echo $arr['user_id'];?>">[<?php echo $arr['user_name'];?>] <?php echo $arr['user_karyawan'];?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="form-label">Perawat</label>
					<select type="text" id="jadwal_perawat_id" name="jadwal_perawat_id" class="form-control input-sm">
						<option value="">Silahkan Pilih</option>
						<?php foreach($perawat_arr as $arr) { ?>
							<option value="<?php echo $arr['user_id'];?>">[<?php echo $arr['user_name'];?>] <?php echo $arr['user_karyawan'];?></option>
						<?php } ?>
					</select>
				</div> 
			</div>
			<div class="modal-footer">
				<input type="hidden" name="jadwal_id" class="form-control" value="0">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" onclick="return trx_save();">Simpan</button>
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
	});

	/* munculkan popup edit dan load data */
	function edit_form(jadwal_id) {
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/action_data_form');?>',
			type:'GET',
			dataType:'json',
			data:'jadwal_id='+jadwal_id,
			success:function(response){
				if(response['status']==200) {
					$('#FormData').find('[name="jadwal_id"]').val(response['data']['jadwal_id']);
					$('#FormData').find('[name="jadwal_date"]').val(response['data']['jadwal_date']);
					$('#FormData').find('[name="jadwal_poli"]').val(response['data']['jadwal_poli']);
					$('#FormData').find('[name="jadwal_shift_id"]').val(response['data']['jadwal_shift_id']);
					$('#FormData').find('[name="jadwal_dokter_id"]').val(response['data']['jadwal_dokter_id']);
					$('#FormData').find('[name="jadwal_perawat_id"]').val(response['data']['jadwal_perawat_id']);
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
					custom_message(response['status'],response['message']);
				} else {
					swal({
						title: 'Apakah anda yakin?',
						text: 'Pastikan data sudah sesuai',
						icon: 'warning',
						buttons: true,
						dangerMode: true,
					}).then((confirm) => {
						if (confirm) {
							trx_stored();
						}
					});
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
		
		var date_start=$("#date_start").val();  
		var date_end=$("#date_end").val();  
		var jadwal_shift_id=$("#shift").val();  
		var keyword=$("#keyword").val();  
		var link_service='?keyword='+keyword
		+'&date_start='+date_start
		+'&date_end='+date_end
		+'&jadwal_shift_id='+jadwal_shift_id
		;
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
			{ title: "No.", data: "no","width":"80px", visible: true}, 
			{ title: "Aksi", data: "action","width":"200px", visible: true},
			{ title: "Tanggal", data: "jadwal_date", visible: true},
			{ title: "Shift", data: "jadwal_shift_name", visible: true},
			{ title: "Poli", data: "jadwal_poli", visible: true},
			{ title: "Dokter", data: "jadwal_dokter_name", visible: true},
			{ title: "Perawat", data: "jadwal_perawat_name", visible: true}
		],
		});
		
		setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
	}
</script>