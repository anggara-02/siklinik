<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Barang Keluar</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item active"><a href="#">Inventori</a></div>
      	<div class="breadcrumb-item">Form</div>
    </div>
</div>
<div class="section-body">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
                	<h4>Form Barang Keluar</h4>
              	</div>
				<div class="card-body">
					<form action="#" method="POST" class="needs-validation" novalidate="">
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal/Shift</label>
							<div class="col-sm-12 col-md-3">
								<input type="text" class="form-control" value="18/11/2021" readonly="">
							</div>
							<div class="col-sm-12 col-md-3">
								<input type="text" class="form-control" value="Pagi" readonly="">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
							<div class="col-sm-12 col-md-7">
								<div class="form-clone-wrap">
									<div class="form-group row mb-3 mx-n1 form-original">
										<div class="col-md-3 px-1">
											<label for="">Pilih Item</label>
											<input type="text" class="form-input form-control">
										</div>
										<div class="col-md-2 px-1">
											<label for="">Qty</label>
											<input type="text" class="form-input form-control">
										</div>
										<div class="col-md-3 px-1">
											<label for="">Harga Satuan</label>
											<input type="text" class="form-input form-control" readonly="">
										</div>
										<div class="col-md-3 px-1">
											<label for="">Sub Total</label>
											<input type="text" class="form-input form-control" readonly>
										</div>
										<div class="col-md-1 px-1">
											<label for="">&nbsp;</label>
											<div>
												<button class="btn btn-info btn-clone" type="button"><i class="fa fa-plus"></i></button>
											</div>
										</div>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-product table-bordered table-sm">
										<thead>
											<tr>
												<th>Nama Item</th>
												<th>Qty</th>
												<th>Harga Satuan</th>
												<th>Sub Total</th>
												<th width="10"></th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Catatan</label>
							<div class="col-sm-12 col-md-7">
								<textarea name="" id="" cols="30" rows="3" class="form-control h-auto"></textarea>
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Grand Total</label>
							<div class="col-sm-12 col-md-7">
								<input type="text" class="form-control" readonly="">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
							<div class="col-sm-12 col-md-7">
								<button class="btn btn-primary" type="submit">Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style type="text/css">
	.form-original .btn-delete{
		display: none;
	}
	.form-clone .btn-clone{
		display: none;
	}
	.form-clone label{
		display: none;
	}
</style>

<script type="text/javascript">
	$(function(){
		$('.form-select2').select2();
		$(document).on('click','.btn-clone',function(){
			var form = $(this).parents('.form-original');
			//$('.form-select2').select2('destroy');
			//form.clone().removeClass('form-original').addClass('form-clone').appendTo($(this).parents('.form-clone-wrap'));
			//$('.form-select2').select2();
			value_1 = form.children().eq(0).find('input').val();
			value_2 = form.children().eq(1).find('input').val();
			value_3 = form.children().eq(2).find('input').val();
			value_4 = form.children().eq(2).find('input').val();

			$('table.table-product tbody').append(''+
			'<tr>'+
			'<td>'+value_1+'</td>'+
			'<td>'+value_2+'</td>'+
			'<td>'+value_3+'</td>'+
			'<td>'+value_4+'</td>'+
			'<td><button class="btn btn-danger btn-delete" type="button"><i class="fa fa-trash"></i></button></td>'+
			'</tr/>');
			
		});

		$(document).on('click','.btn-delete',function(){
			$(this).parents('tr').remove();
			
		});
	});
</script>
<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Inventori")').parent().addClass('active').find('a:contains("Barang Keluar")').parent().addClass('active');
</script>