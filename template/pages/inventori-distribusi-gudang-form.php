<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Distribusi Antar Gudang</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
      	<div class="breadcrumb-item"><a href="#">Inventori</a></div>
      	<div class="breadcrumb-item">Distribusi Antar Gudang</div>
    </div>
</div>
<div class="section-body">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
                	<h4>Form Distribusi Antar Gudang</h4>
              	</div>
				<div class="card-body">
					<form action="#" method="POST" class="needs-validation" novalidate="">
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Distribusi</label>
							<div class="col-sm-12 col-md-7">
								<input type="text" class="form-control" required readonly="" value="09-11-2021">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tujuan</label>
							<div class="col-sm-12 col-md-7">
								<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Tujuan">
									<option value=""></option>
									<option>Etalase</option>
									<option>Gudang</option>
								</select>
								<div class="invalid-feedback">
									Pilih Tujuan
								</div>
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Obat & Alkes</label>
							<div class="col-sm-12 col-md-7">
								<div class="form-clone-wrap">
									<div class="form-group row mb-3 mx-n1 form-original">
										<div class="col-md-4 px-1">
											<input type="text" class="form-input form-control" placeholder="Barcode atau Nama Obat/Alkes">
										</div>
										<div class="col-md-2 px-1">
											<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Kemasan">
												<option value=""></option>
												<option>Box</option>
												<option>Strip</option>
												<option>Tablet</option>
											</select>
										</div>
										<div class="col-md-2 px-1">
											<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Expired Date">
												<option value=""></option>
												<option>09-11-2025</option>
												<option>09-12-2023</option>
												<option>09-11-2022</option>
											</select>
										</div>
										<div class="col-md-2 px-1">
											<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Batch">
												<option value=""></option>
												<option>BATCH1</option>
												<option>BATCH2</option>
												<option>BATCH3</option>
											</select>
										</div>
										<div class="col-md-1 px-1">
											<input type="text" class="form-input form-control" placeholder="Qty">
										</div>
										<div class="col-md-1 px-1">
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
												<th>Obat & Alkes</th>
												<th>Kemasan</th>
												<th>Expired Date</th>
												<th>Batch</th>
												<th>Qty</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- <div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-2 col-lg-3">Total Harga</label>
							<div class="col-sm-12 col-md-7">
								<input type="text" class="form-control" readonly="">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon</label>
							<div class="col-sm-12 col-md-7">
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Grand Total</label>
							<div class="col-sm-12 col-md-7">
								<input type="text" class="form-control" readonly="">
							</div>
						</div> -->
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
			value_2 = form.children().eq(1).find('select').val();
			value_3 = form.children().eq(2).find('select').val();
			value_4 = form.children().eq(3).find('select').val();
			value_5 = form.children().eq(4).find('input').val();
			value_6 = form.children().eq(5).find('input').val();
			
			$('table.table-product tbody').append(''+
			'<tr>'+
			'<td>'+value_1+'</td>'+
			'<td>'+value_2+'</td>'+
			'<td>'+value_3+'</td>'+
			'<td>'+value_4+'</td>'+
			'<td>'+value_5+'</td>'+
			'<td>'+value_6+'</td>'+
			'<td><button class="btn btn-danger btn-delete" type="button"><i class="fa fa-trash"></i></button></td>'+
			'</tr/>');
			
		});

		$(document).on('click','.btn-delete',function(){
			$(this).parents('tr').remove();
			
		});
	});
</script>

<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Inventori")').parent().addClass('active').find('a:contains("Distribusi Antar Gudang")').parent().addClass('active');
</script>