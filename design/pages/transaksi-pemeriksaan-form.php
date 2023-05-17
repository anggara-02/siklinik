<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Pemeriksaan</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Pemeriksaan</a></div>
      	<div class="breadcrumb-item">Form</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Pemeriksaan</h4>
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
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alergi</label>
					<div class="col-sm-12 col-md-7">
						<textarea name="" id="" cols="30" rows="5" class="form-control h-auto"></textarea>
						<div class="invalid-feedback">
							Masukkan Alergi
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-2">
						<label>Berat Badan</label>
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Berat Badan
						</div>
					</div>
					<div class="col-sm-12 col-md-2">
						<label>Tinggi Badan</label>
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Tinggi Badan
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Tanda Vital</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-2">
						<label>Tekanan Darah</label>
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Tekanan Darah
						</div>
					</div>
					<div class="col-sm-12 col-md-2">
						<label>Respiratory Rate</label>
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Respiratory Rate
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-2">
						<label>Nadi</label>
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Nadi
						</div>
					</div>
					<div class="col-sm-12 col-md-2">
						<label>Suhu Tubuh</label>
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Suhu Tubuh
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Anamnesis</label>
					<div class="col-sm-12 col-md-7">
						<textarea name="" id="" cols="30" rows="5" class="form-control h-auto"></textarea>
						<div class="invalid-feedback">
							Masukkan Anamnesis
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pemeriksaan Fisik</label>
					<div class="col-sm-12 col-md-7">
						<textarea name="" id="" cols="30" rows="5" class="form-control h-auto"></textarea>
						<div class="invalid-feedback">
							Masukkan Pemeriksaan Fisik
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diagnosis</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original">
								<div class="col-md-11 px-1">
									<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Diagnosis">
										<option value=""></option>
										<option value="J.00 - Commond Cold">J.00 - Commond Cold</option>
										<option value="J.01 - Viral Cold">J.01 - Viral Cold</option>
									</select>
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
										<th>Diagnosis</th>
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
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Pemeriksaan Laboratorium</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Layanan Laboratorium</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original2">
								<div class="col-md-11 px-1">
									<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Layanan Laboratorium">
										<option value=""></option>
										<option value="Cek Darah Lengkap">Cek Darah Lengkap</option>
										<option value="Cek Kolesterol">Cek Kolesterol</option>
									</select>
								</div>
								<div class="col-md-1 px-1">
									<div>
										<button class="btn btn-info btn-clone2" type="button"><i class="fa fa-plus"></i></button>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-product2 table-bordered table-sm">
								<thead>
									<tr>
										<th>Layanan Laboratorium</th>
										<th>Hasil</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Tindakan</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tindakan</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original4">
								<div class="col-md-11 px-1">
									<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Tindakan">
										<option value=""></option>
										<option value="Konsultasi Dokter">Konsultasi Dokter</option>
										<option value="Pemeriksaan Umum">Pemeriksaan Umum</option>
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
										<th>Nama Tindakan</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><u>Resep Obat</u></label>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">&nbsp;</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original3">
								<div class="col-md-1 px-1">
									<input type="text" class="form-control" placeholder="/R">
								</div>
								<div class="col-md-3 px-1">
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
								<div class="col-md-2 px-1">
									<input type="text" class="form-control" placeholder="Dosis">
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-control" placeholder="Aturan Pakai">
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
										<th>Jumlah</th>
										<th>Dosis</th>
										<th>Aturan Pakai</th>
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
						<button class="btn btn-primary" type="submit">Simpan Pemeriksaan</button>
						<button class="btn btn-warning" type="submit-lab">Submit ke Laboratorium</button>
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
	$('.sidebar-menu li a:contains("Pemeriksaan")').parent().addClass('active');
</script>