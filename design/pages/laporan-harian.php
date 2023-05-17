<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Laporan Harian</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Laporan</a></div>
      	<div class="breadcrumb-item">Laporan Harian</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-body">
			<form action="" method="POST" class="needs-validation" novalidate="">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Periode</label>
					<div class="col-sm-12 col-md-4">
						<div class="row">
							<div class="col-6">
								<select name="" id="" class="form-select2" data-placeholder="Pilih Bulan">
									<option value=""></option>
									<option>Januari</option>
									<option>Februari</option>
									<option>Maret</option>
									<option>April</option>
									<option>Mei</option>
									<option>Juni</option>
									<option>Juli</option>
									<option>Agustus</option>
									<option>September</option>
									<option>Oktober</option>
									<option>November</option>
									<option>Desember</option>
								</select>
							</div>
							<div class="col-6">
								<select name="" id="" class="form-select2" data-placeholder="Pilih Tahun">
									<option value=""></option>
									<option>2021</option>
									<option>2020</option>
									<option>2019</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kasir</label>
					<div class="col-sm-12 col-md-7">
						<select name="" id="" class="form-select2" data-placeholder="Pilih Kasir">
							<option value=""></option>
							<option>Semua Kasir</option>
						</select>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
					<div class="col-sm-12 col-md-7">
						<button class="btn btn-primary" type="submit">Cari</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="card">
		<div class="px-4 pt-4 pb-0">
			<div class="row">
				<div class="col-md-auto align-self-end">
					<a href="#" class="btn btn-success">Export Excel</a>
				</div>
				<div class="col-md-3 ml-md-auto">
					<table class="table table-sm">
						<tr>
							<td><strong>Total Penjualan</strong></td>
							<td class="text-right">26.000</td>
						</tr>
						<tr>
							<td><strong>Total Pengeluaran</strong></td>
							<td class="text-right">2.000</td>
						</tr>
						<tr>
							<td><strong>Omset Bersih</strong></td>
							<td class="text-right">24.000</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-sm table-bordered">
					<thead>
						<tr class="bg-light">
							<th width="5">No</th>
							<th>Tanggal</th>
							<th class="text-right">Penjualan</th>
							<th class="text-right">Diskon</th>
							<th class="text-right">Total Penjualan</th>
							<th class="text-right">Pengeluaran</th>
							<th class="text-right">Omset Bersih</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>24-10-2021</td>
							<td class="text-right">1.000.000</td>
							<td class="text-right">-</td>
							<td class="text-right">1.000.000</td>
							<td class="text-right">100.000</td>
							<td class="text-right">900.000</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Laporan")').parent().addClass('active').find('a:contains("Harian")').parent().addClass('active');
</script>