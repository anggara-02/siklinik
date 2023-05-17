<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Laporan Penjualan</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Laporan</a></div>
      	<div class="breadcrumb-item">Laporan Penjualan</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-body">
			<form action="" method="POST" class="needs-validation" novalidate="">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal</label>
					<div class="col-sm-12 col-md-4">
						<div class="row">
							<div class="col-6">
								<input type="date" class="form-control">
							</div>
							<div class="col-6">
								<input type="date" class="form-control">
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
							<td><strong>Total</strong></td>
							<td class="text-right">26.000</td>
						</tr>
						<tr>
							<td><strong>Diskon</strong></td>
							<td class="text-right">2.000</td>
						</tr>
						<tr>
							<td><strong>Grand Total</strong></td>
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
							<th>Kode</th>
							<th>Nama Customer</th>
							<th>Nama Tindakan/ Produk</th>
							<th class="text-right">Qty</th>
							<th class="text-right">Harga Satuan</th>
							<th class="text-right">Sub Total</th>
							<th class="text-right">Total</th>
							<th class="text-right">Diskon</th>
							<th class="text-right">Grand Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>TRX-001</td>
							<td>Customer A</td>
							<td>Produk A</td>
							<td class="text-right">2</td>
							<td class="text-right">1.000</td>
							<td class="text-right">2.000</td>
							<td class="text-right">13.000</td>
							<td class="text-right">1.000</td>
							<td class="text-right">12.000</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Laporan")').parent().addClass('active').find('a:contains("Penjualan")').parent().addClass('active');
</script>