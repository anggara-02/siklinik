<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Obat</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
      	<div class="breadcrumb-item"><a href="#">Data Master</a></div>
      	<div class="breadcrumb-item">Obat</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Entry</h4>
      	</div>
		<div class="card-body">
			<form action="#" method="POST" class="needs-validation" novalidate="">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode Barcode</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Kode Barcode
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Obat</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Nama Obat
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Kemasan Kecil</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Harga Kemasan Kecil
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Margin</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" required>
						<div class="invalid-feedback">
							Masukkan Margin
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Setelah Margin</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control" required readonly="">
						<!-- <div class="invalid-feedback">
							Masukkan Harga Sete
						</div> -->
					</div>
				</div>
				<hr>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kemasan Kecil</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original">
								<div class="col-md-3 px-1">
									<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Kemasan">
										<option value=""></option>
										<option>Box</option>
										<option>Strip</option>
										<option>Tablet</option>
									</select>
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-input form-control" placeholder="Qty" readonly="" value="1">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kemasan Sedang</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original">
								<div class="col-md-3 px-1">
									<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Kemasan">
										<option value=""></option>
										<option>Box</option>
										<option>Strip</option>
										<option>Tablet</option>
									</select>
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-input form-control" placeholder="Qty">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kemasan Besar</label>
					<div class="col-sm-12 col-md-7">
						<div class="form-clone-wrap">
							<div class="form-group row mb-3 mx-n1 form-original">
								<div class="col-md-3 px-1">
									<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Kemasan">
										<option value=""></option>
										<option>Box</option>
										<option>Strip</option>
										<option>Tablet</option>
									</select>
								</div>
								<div class="col-md-2 px-1">
									<input type="text" class="form-input form-control" placeholder="Qty">
								</div>
							</div>
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
</script>

<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Data Master")').parent().addClass('active').find('a:contains("Obat")').parent().addClass('active');
</script>