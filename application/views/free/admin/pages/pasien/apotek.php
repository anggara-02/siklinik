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
			
		  <?php 
				if(trim($status)!='' AND trim($message)!=''){
			  ?> 
					<div class="col-sm-12 control-label custom_message" id="custom_message"> 
						<div class="callout message mb-1 <?php echo ($status==200)?'callout-success':'callout-danger'; ?>">
						  <div style="text-align:left;"><i class="<?php echo ($status==200)?'icon-thumbs-up':'icon-remove'; ?>"></i><?php echo $message; ?></div>
						  </div>
					</div> 

			  <?php
				}
				?>
				<div class="p-4 border-bottom border-light">
					<div class="row mx-n2">
						<div class="col-md-auto mb-3 mb-md-0 px-2">
							<?php if(common_lib::hak_akses($access,'add','menu')=='1'){?>
								<a href="<?php echo site_url('admin/pasien/apotek/add');?>" class="btn btn-primary add" shortcut="f2">Tambah</a>
							<?php } ?>	
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
					<table id="datatables" class="table table-striped table-bordered" style="width: 100%"></table>
				</div> 
		  	</div> 
	  	</div>  
	</div> 
</div> 
 
<script>
	$(document).ready(function() { 
		load_table();	
    	setTimeout(function(){ 
			$('.custom_message').hide();
		}, 2000); 
	});
 
	function load_table() {
		if($('#datatables thead>tr').length>0) {
			$('#datatables').dataTable().fnDestroy();
		}
		  
		var keyword=$("#keyword").val();  
		var link_service='?keyword='+keyword 
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
			url: '<?= base_url('admin/'.$class.'/get_datatable_apotek');?>'+link_service,
			type: 'post',
			dataType: 'json',
		},
		'columns':[
			{ title: "No.", data: "no","width":"40px", visible: true}, 
			{ title: "Aksi", data: "action","width":"40px", visible: true},
			{ title: "Nama Pasien", data: "pasien_name", visible: true},
			{ title: "Membership", data: "membership", visible: true},
			{ title: "Usia", data: "pasien_birthdate", visible: true},
			{ title: "Telp", data: "pendaftaran_pasien_penanggung_jawab_telp", visible: true},
			{ title: "Alamat", data: "pasien_address", visible: true}
		],
		});
		
		setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
	}
</script>