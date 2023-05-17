<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Apotek</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Apotek</a></div>
      	<div class="breadcrumb-item">Form</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Apotek</h4>
      	</div>
      	<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td width="200">No RM</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="000001" readonly=""></td>
							<td width="200">Nama Pasien</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="Ronaldo" readonly=""></td>
						</tr>
						<tr>
							<td width="200">Jenis Penjaminan</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="BPJS" readonly=""></td>
							<td width="200">Usia</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="32 Tahun" readonly=""></td>
						</tr>
						<tr>
							<td width="200">No Penjaminan</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="123456789" readonly=""></td>
							<td width="200">Alamat</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="Jalan Kusumanegara Yogyakarta" readonly=""></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-body">
			<form action="#" method="POST" class="needs-validation" novalidate="">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Transaksi Non Resep</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original">
								<div class="col-md-4 px-1">
									<input type="text" class="form-control" placeholder="Nama Obat/Alkes">
								</div>
								<div class="col-md-3 px-1">
									<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Kemasan">
										<option value=""></option>
										<option>Box</option>
										<option>Strip</option>
										<option>Tablet</option>
									</select>
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-control" placeholder="Qty">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-control" readonly="">
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
										<th>Nama Obat</th>
										<th>Kemasan</th>
										<th>Qty</th>
										<th>Harga</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Transaksi Resep</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original3">
								<div class="col-md-1 px-1">
									<input type="text" class="form-control" placeholder="/R">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-control" placeholder="Nama Obat/Alkes">
								</div>
								<div class="col-md-2 px-1">
									<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Kemasan">
										<option value=""></option>
										<option>Box</option>
										<option>Strip</option>
										<option>Tablet</option>
									</select>
								</div>
								<div class="col-md-1 px-1">
									<input type="text" class="form-control" placeholder="Qty">
								</div>
								<div class="col-md-1 px-1">
									<input type="text" class="form-control" placeholder="Dosis">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-control" placeholder="Aturan Pakai">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-control" readonly="">
								</div>
								<div class="col-md-1 px-1">
									<div>
										<button class="btn btn-info btn-clone3" type="button"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-product3 table-bordered table-sm">
								<thead>
									<tr>
										<th>/R</th>
										<th>Nama Obat</th>
										<th>Kemasan</th>
										<th>Qty</th>
										<th>Dosis</th>
										<th>Aturan Pakai</th>
										<th>Harga</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Harga</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" readonly="">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tuslah</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Embalage</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon Rp</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon %</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control">
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
	$(function(){
		$('.form-select2').select2();
	});

	$(document).on('click','.btn-clone',function(){
		var form = $(this).parents('.form-original');

		value_1 = form.children().eq(0).find('input').val();
		value_2 = form.children().eq(1).find('select').val();
		value_3 = form.children().eq(2).find('input').val();
		value_4 = form.children().eq(3).find('input').val();
				
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

	$(document).on('click','.btn-clone2',function(){
		var form = $(this).parents('.form-original2');

		value_1 = form.children().eq(0).find('select').val();
		
		$('table.table-product2 tbody').append(''+
		'<tr>'+
		'<td>'+value_1+'</td>'+
		'<td></td>'+
		'<td><button class="btn btn-danger btn-delete2" type="button"><i class="fa fa-trash"></i></button></td>'+
		'</tr/>');
		
	});

	$(document).on('click','.btn-delete2',function(){
		$(this).parents('tr').remove();
		
	});

	$(document).on('click','.btn-clone3',function(){
		var form = $(this).parents('.form-original3');

		value_1 = form.children().eq(0).find('input').val();
		value_2 = form.children().eq(1).find('input').val();
		value_3 = form.children().eq(2).find('select').val();
		value_4 = form.children().eq(3).find('input').val();
		value_5 = form.children().eq(4).find('input').val();
		value_6 = form.children().eq(5).find('input').val();
		value_7 = form.children().eq(6).find('input').val();
		
		$('table.table-product3 tbody').append(''+
		'<tr>'+
		'<td>'+value_1+'</td>'+
		'<td>'+value_2+'</td>'+
		'<td>'+value_3+'</td>'+
		'<td>'+value_4+'</td>'+
		'<td>'+value_5+'</td>'+
		'<td>'+value_6+'</td>'+
		'<td>'+value_7+'</td>'+
		'<td><button class="btn btn-danger btn-delete3" type="button"><i class="fa fa-trash"></i></button></td>'+
		'</tr/>');
		
	});

	$(document).on('click','.btn-delete3',function(){
		$(this).parents('tr').remove();
		
	});

</script>
<script type="text/javascript">
	$('.sidebar-menu li a:contains("Apotek")').parent().addClass('active');
</script>