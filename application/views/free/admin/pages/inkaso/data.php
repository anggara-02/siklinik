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
		<div class="section-body">
			<div class="card">
				<div class="p-4 border-bottom border-light">
					<div class="row mx-n2">
						<div class="col-md-auto mb-3 mb-md-0 px-2">
						</div>
						<div class="col-md-auto px-2 ml-auto">
							<div class="row">
								<div class="col-md-3 search">
									<input type="date" class="form-control tooltips" id="tanggal_awal" title="Tanggal Awal">
								</div>
								<div class="col-md-3 search">
									<input type="date" class="form-control tooltips" id="tanggal_akhir" title="Tanggal Akhir">
								</div>
								<div class="col-md-3 search">
									<select class="form-control form-select2" id="supplier_id" data-placeholder="Semua Supplier">
										<option value=""></option>
										<?php if(isset($supplier_arr)&&!empty($supplier_arr)) {
											foreach($supplier_arr as $rowArr) {
												echo '<option value="'.$rowArr['supplier_id'].'">'.$rowArr['supplier_name'].'</option>';
											}
										} ?>
									</select>
								</div>
								<div class="col-md-3 input-group search">
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
                                <th class="align-middle text-center">No Faktur</th>
                                <th class="align-middle text-center">Tanggal Faktur</th>
                                <th class="align-middle text-center">Tanggal Jatuh Tempo</th>
                                <th class="align-middle text-center">Supplier</th>
                                <th class="align-middle text-center">Total Harga</th>
                                <th class="align-middle text-center">Total Bayar</th>
                            </tr>
                        </thead>
                    </table>
				</div> 
			</div> 
		</div>  
	</div> 
</div>
<style>
	.search{
		padding: 0 5px;
	}
</style>
<script>
	$(function(){$('.form-select2').select2();});
	$(document).ready(function() { 
		load_table();	
	});
	
	function checkDateRange(start, end) {
		// Parse the entries
		var startDate = Date.parse(start);
		var endDate = Date.parse(end);
		
		// Check the date range, 86400000 is the number of milliseconds in one day
		var difference = (endDate - startDate) / (86400000 * 7);
		if (difference < 0) {
			alert("Tanggal Mmulai harus lebih kecil dari tanggal selesai.");
			return false;
		}
		return true;
	}

	function load_table() {
		if($('#datatables thead>tr').length>0)
		{
			$('#datatables').dataTable().fnDestroy();
		}
		
		var tanggal_awal=$("#tanggal_awal").val();
		var tanggal_akhir=$("#tanggal_akhir").val();
		var supplier_id=$("#supplier_id").val();
		var no_faktur=$("#keyword").val();

		if (checkDateRange(tanggal_awal, tanggal_akhir) != false) {
			var link_service='?no_faktur='+no_faktur+'&tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir+'&supplier_id='+supplier_id;
			dataReload(link_service);
		} else{
			var link_service = '?no_faktur=' + no_faktur + '&supplier=' + supplier_id;
			dataReload(link_service);
		}
	}

	function dataReload(link_service) {
		$('#datatables').DataTable({
			processing: true,
			serverSide: true,   
			searching: false,
			aoColumnDefs: [{ "bSortable": false, "aTargets": [ "_all" ],"orderable": false }],
			lengthMenu: [
				[10, 25, 50, -1], 
				[10, 25, 50, "All"]
			],
			'ajax': {
				url: '<?= base_url('admin/'.$class.'/get_datatable');?>'+link_service,
				type: 'post',
				dataType: 'json',
			},
			'columns':[
				{data: "no","width":"20px", visible: true}, 
				{data: "action","width":"100px", visible: true},
				{data: "no_faktur", visible: true},
				{data: "tanggal_faktur", visible: true},
				{data: "tanggal_tempo", visible: true},
				{data: "supplier", visible: true},
				{data: "total_harga", visible: true},
				{data: "bayar", visible: true},
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