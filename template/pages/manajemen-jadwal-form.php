<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Manajemen Jadwal</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Manajemen Jadwal</a></div>
      	<div class="breadcrumb-item">Form</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Manajemen Jadwal</h4>
      	</div>
		<div class="card-body">
			<form action="#" method="POST" class="needs-validation" novalidate="">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal</label>
					<div class="col-sm-12 col-md-7">
						<input type="date" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Tanggal
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Shift</label>
					<div class="col-sm-12 col-md-7">
						<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Shift">
							<option value=""></option>
							<option value="1">Pagi</option>
							<option value="2">Siang</option>
							<option value="3">Sore</option>
						</select>
						<div class="invalid-feedback">
							Pilih Shift
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Dokter</label>
					<div class="col-sm-12 col-md-7">
						<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Dokter">
							<option value=""></option>
							<option value="1">Dr Andi</option>
							<option value="2">Dr Boyke</option>
						</select>
						<div class="invalid-feedback">
							Pilih Dokter
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Perawat</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original4">
								<div class="col-md-11 px-1">
									<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Perawat">
										<option value=""></option>
										<option>Rina</option>
										<option>Rini</option>
										<option>Rinso</option>
									</select>
								</div>
								<div class="col-md-1 px-1">
									<div>
										<button class="btn btn-info btn-clone4" type="button"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-product4 table-bordered table-sm">
								<thead>
									<tr>
										<th>Nama Perawat</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
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

		value_1 = form.children().eq(0).find('select').val();
		
		$('table.table-product tbody').append(''+
		'<tr>'+
		'<td>'+value_1+'</td>'+
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
		
		$('table.table-product3 tbody').append(''+
		'<tr>'+
		'<td>'+value_1+'</td>'+
		'<td>'+value_2+'</td>'+
		'<td>'+value_3+'</td>'+
		'<td>'+value_4+'</td>'+
		'<td>'+value_5+'</td>'+
		'<td>'+value_6+'</td>'+
		'<td><button class="btn btn-danger btn-delete3" type="button"><i class="fa fa-trash"></i></button></td>'+
		'</tr/>');
		
	});

	$(document).on('click','.btn-delete3',function(){
		$(this).parents('tr').remove();
		
	});

	$(document).on('click','.btn-clone4',function(){
		var form = $(this).parents('.form-original4');

		value_1 = form.children().eq(0).find('select').val();
		
		$('table.table-product4 tbody').append(''+
		'<tr>'+
		'<td>'+value_1+'</td>'+
		'<td><button class="btn btn-danger btn-delete4" type="button"><i class="fa fa-trash"></i></button></td>'+
		'</tr/>');
		
	});

	$(document).on('click','.btn-delete3',function(){
		$(this).parents('tr').remove();
		
	});

</script>
<script type="text/javascript">
	$('.sidebar-menu li a:contains("Manajemen Jadwal")').parent().addClass('active');
</script>