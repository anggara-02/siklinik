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
							<a href="<?= site_url('admin/'.$class.'/add');?>" class="btn btn-primary add" shortcut="f2">Tambah</a>
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
								<th class="align-middle text-center">Nama Obat</th>
								<th class="align-middle text-center">Kemasan</th>
								<th class="align-middle text-center">Harga Non Resep</th>
								<th class="align-middle text-center">Harga Resep</th>
							</tr>
						</thead>
					</table>
				</div> 
			</div> 
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

	function load_table() {
		if($('#datatables thead>tr').length>0)
		{
			$('#datatables').dataTable().fnDestroy();
		}
		
		var obat_name=$("#keyword").val();  
		var role_id=$("#filter_role_id").val();  
		var link_service='?obat_name='+obat_name;
		dataReload(link_service);
	}

	function dataReload(link_service) {
		$('#datatables').DataTable({
			processing: true,
			serverSide: true,   
			searching: false,
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
				{data: "obat_barcode", visible: true},
				{data: "obat_name", visible: true},
				{data: "kemasan", visible: true},
				{data: "harga", visible: true},
				{data: "harga_resep", visible: true},
			],
		});
		setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
	}
</script>
<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
==========DON'T REMOVE============ -->