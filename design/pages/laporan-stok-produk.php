<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Laporan Stok Produk</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Laporan</a></div>
      	<div class="breadcrumb-item">Laporan Stok Produk</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-body">
			<form action="" method="POST" class="needs-validation" novalidate="">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Produk</label>
					<div class="col-sm-12 col-md-7">
						<input type="text" class="form-control">
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
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-sm table-bordered">
					<thead>
						<tr class="bg-light">
							<th width="5">No</th>
							<th>Nama Produk</th>
							<th class="text-right">Stok Akhir</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Produk A</td>
							<td class="text-right">2</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Laporan")').parent().addClass('active').find('a:contains("Stok Produk")').parent().addClass('active');
</script>