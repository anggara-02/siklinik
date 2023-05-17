<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Pasien Apotek</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Pasien Apotek</a></div>
      	<div class="breadcrumb-item">Form</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Pasien Apotek</h4>
      	</div>
      	<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td width="200">Nama Pasien Apotek</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="Ronaldo"></td>
						</tr>
						<tr>
							<td width="200">Usia</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="32 Tahun"></td>
						</tr>
						<tr>
							<td width="200">Alamat</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="Jalan Kusumanegara Yogyakarta"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-body">
			<div class="p-4 border-bottom border-light">
				<div class="row mx-n2">
					<div class="col-md-auto mb-3 mb-md-0 px-2">
						<a href="?page=database-pasien-apotek" class="btn btn-primary">Simpan</a>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th rowspan="2" width="5">No</th>
							<th rowspan="2" width="200">Tgl Kunjungan</th>
							<th colspan="5" class="text-center">Daftar Belanja</th>
						</tr>
						<tr>
							<th>Nama Barang</th>
							<th>Qty</th>
							<th>Kemasan</th>
							<th>Harga Satuan</th>
							<th>Total Harga</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td rowspan="2">1</td>
							<td rowspan="2">02-01-2021</td>
							<td>Amoxicillin</td>
							<td>1</td>
							<td>Strip</td>
							<td>10.000</td>
							<td>10.000</td>
						</tr>
						<tr>
							<td>Amoxicillin</td>
							<td>1</td>
							<td>Strip</td>
							<td>10.000</td>
							<td>10.000</td>
						</tr>
						<tr>
							<td rowspan="2">2</td>
							<td rowspan="2">01-01-2021</td>
							<td>Amoxicillin</td>
							<td>1</td>
							<td>Strip</td>
							<td>10.000</td>
							<td>10.000</td>
						</tr>
						<tr>
							<td>Amoxicillin</td>
							<td>1</td>
							<td>Strip</td>
							<td>10.000</td>
							<td>10.000</td>
						</tr>
					</tbody>
				</table>
			</div>
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
	$('.sidebar-menu li a:contains("Pasien Apotek")').parent().addClass('active');
</script>