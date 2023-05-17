<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Laboratorium</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Laboratorium</a></div>
      	<div class="breadcrumb-item">Form</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Laboratorium</h4>
      	</div>
      	<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td width="200">No RM</td>
							<td width="10" align="center">:</td>
							<td>000001</td>
							<td width="200">Nama Pasien</td>
							<td width="10" align="center">:</td>
							<td>Ronaldo</td>
						</tr>
						<tr>
							<td width="200">Jenis Penjaminan</td>
							<td width="10" align="center">:</td>
							<td>BPJS</td>
							<td width="200">Usia</td>
							<td width="10" align="center">:</td>
							<td>32 Tahun</td>
						</tr>
						<tr>
							<td width="200">No Penjaminan</td>
							<td width="10" align="center">:</td>
							<td>1234567890</td>
							<td width="200">Alamat</td>
							<td width="10" align="center">:</td>
							<td>Jalan Kusumanegara No 102 Yogyakarta</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-body">
			<form action="#" method="POST" class="needs-validation" novalidate="">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Pemeriksaan Laboratorium</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-7">
						<div class="table-responsive">
							<table class="table table-product2 table-bordered table-sm">
								<thead>
									<tr>
										<th>Layanan Laboratorium</th>
										<th>Hasil</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Cek Darah</td>
										<td><input type="file" class="form-control"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
					<div class="col-sm-12 col-md-7">
						<button class="btn btn-primary" type="submit">Submit ke Pemeriksaan</button>
						<button class="btn btn-warning" type="submit">Submit ke Kasir</button>
						<button class="btn btn-success" type="submit">Submit ke Pendaftaran</button>
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
		value_3 = form.children().eq(2).find('input').val();
		value_4 = form.children().eq(3).find('input').val();
		value_5 = form.children().eq(4).find('input').val();
		
		$('table.table-product3 tbody').append(''+
		'<tr>'+
		'<td>'+value_1+'</td>'+
		'<td>'+value_2+'</td>'+
		'<td>'+value_3+'</td>'+
		'<td>'+value_4+'</td>'+
		'<td>'+value_5+'</td>'+
		'<td><button class="btn btn-danger btn-delete3" type="button"><i class="fa fa-trash"></i></button></td>'+
		'</tr/>');
		
	});

	$(document).on('click','.btn-delete3',function(){
		$(this).parents('tr').remove();
		
	});

</script>
<script type="text/javascript">
	$('.sidebar-menu li a:contains("Laboratorium")').parent().addClass('active');
</script>