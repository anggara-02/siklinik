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
		<?php if ($this->session->flashdata('status')) {$sukses = $this->session->flashdata('sukses');$gagal = $this->session->flashdata('gagal');?>
			<div class="col-sm-12 control-label action_message" id="action_message"> 
				<div class="callout mb-1 <?= ($this->session->flashdata('status')=='200')?'callout-success':'callout-danger'; ?>">
					<div style="text-align:left;" class="message"><?= $sukses ? $sukses : $gagal; ?></div>
				</div>
			</div>
		<?php } ?>
		<div class="p-4 border-bottom border-light">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td width="200">No Faktur</td>		
							<td>: <?= $penerimaan->no_faktur ?></td>
							<td width="200">Tanggal Tempo</td>		
							<td>: <?= $tanggal_tempo ?></td>
						</tr>
						<tr>
							<td width="200">Tanggal Faktur</td>		
							<td>: <?= $tanggal_faktur ?></td>
							<td width="200">Jumlah Tagihan</td>		
							<td>: <?= $total ?>,-</td>
						</tr>
						<tr>
							<td width="200">Supplier</td>		
							<td>: <?= $penerimaan->supplier ?></td>
							<td width="200">Jumlah Bayar</td>		
							<td>: <?= $sum_jumlah ? $sum_jumlah : 0 ?>,-</td>
						</tr>
					</tbody>
				</table>
				<!-- Warning message -->
				<?php if ($penerimaan->total != $penerimaan->sum_jumlah) { ?>
				<div class="col-md-auto mb-3 mb-md-0 px-2">
					<a href="#" onclick="add_form()" class="btn btn-primary add" shortcut="f2">Tambah</a>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="datatables" class="table table-striped table-bordered" style="width: 100%"></table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-form" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form class="form-horizontal" id="FormData" method="POST" action="<?= site_url('admin/'.$class.'/store_form/'.$penerimaan->penerimaan_id);?>" enctype="multipart/form-data">
				<div class="modal-header">
					<h5 class="modal-title">INKASO</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<input type="hidden" name="inkaso_id" id="inkaso_id" value="">
				</div>
				<div class="modal-body">
					<div class="form-group tanggal-field">
						<label for="" class="form-label">Tanggal Bayar</label>
						<input type="date" name="tanggal" id="tanggal"  class="form-control">
					</div>
					<div class="form-group cara_bayar-field">
						<label for="" class="form-label">Cara Bayar</label>
						<select name="cara_bayar" id="cara_bayar" class="form-select2" data-placeholder="Pilih Cara Bayar">
							<option value=""></option>
							<option>Tunai</option>
							<option>Transfer BCA</option>
						</select>
						<label id="cara_bayar-error" class="error" for="cara_bayar" style="display: none;"></label>
					</div>
					<div class="form-group jumlah-field">
						<label for="" class="form-label">Jumlah Bayar</label>
						<input type="number" name="jumlah" id="jumlah" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
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
				tanggal: {
					required: function(element) {
						return $('.tanggal-field').addClass('is-invalid');
					}
				},
				cara_bayar: {
					required: function(element) {
						return $('.cara_bayar-field').addClass('is-invalid');
					}
				},
				jumlah: {
					required: function(element) {
						return $('.jumlah-field').addClass('is-invalid');
					},
					remote: {
						url: "<?= site_url('admin/'.$class.'/action_validation');?>",
						type: "post",
						data: {
							jumlah: function() {
							return $("#jumlah").val();
							},
							inkaso_id: function() {
							return $("#inkaso_id").val();
							},
							id_penerimaan: '<?= $penerimaan->penerimaan_id ?>',
							total_harga: '<?= $penerimaan->total_harga ?>',
						}
					}
				},
			},
            messages:{
                jumlah: {
                    remote: "Total Bayar tidak boleh melebihi Jumlah Tagihan"
                }
            }
		});
	});
	
	$("#modal-form").on('hidden.bs.modal', function () {
		$('.form-group').removeClass('is-invalid');
		$('label[class="error"]').hide();
	});

	$(document).on('change', '#cara_bayar', function () {
		var cara_bayar = $('#cara_bayar').val();
		if (cara_bayar) {
			$('#cara_bayar-error').hide();
		}
	});

	/* munculkan popup edit dan load data */
	function edit_form(kemasan_id) {
		$.ajax({
			url:'<?= site_url('admin/'.$class.'/action_data_form');?>',
			type:'GET',
			dataType:'json',
			data:'kemasan_id='+kemasan_id,
			success:function(response){
				if(response['status']==200) {
					$('#FormData').find('[name="inkaso_id"]').val(response['data']['inkaso_id']);
					$('#FormData').find('[name="tanggal"]').val(response['data']['tanggal']);
					$('#FormData').find('[name="cara_bayar"]').val(response['data']['cara_bayar']);
					$('#FormData').find('[name="cara_bayar"]').select2().trigger('change');
					$('#FormData').find('[name="jumlah"]').val(response['data']['jumlah']);
					$('#modal-form').modal('show');
				}
			}, error:function(){
				alert('terjadi kesalahan saat validasi'); 
				$('.modal-footer').show();	
				$('.button').show();
				$('.btn').prop('disabled',false);			
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

	function load_table() {
		if($('#datatables thead>tr').length>0) {
			$('#datatables').dataTable().fnDestroy();
		}
		
		var id_penerimaan= '<?= $penerimaan->penerimaan_id ?>';  
		var link_service='?id_penerimaan='+id_penerimaan;
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
			url: '<?= base_url('admin/'.$class.'/get_datatable_detail');?>'+link_service,
			type: 'post',
			dataType: 'json',
		},
		'columns':[
			{ title: "No.", data: "no","width":"80px", visible: true}, 
			{ title: "Aksi", data: "action","width":"200px", visible: true},
			{ title: "Tanggal Bayar", data: "tanggal", visible: true},
			{ title: "Cara Bayar", data: "cara_bayar", visible: true},
			{ title: "Jumlah Bayar", data: "jumlah", visible: true},
		],
		});
		
		setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
	}
</script>