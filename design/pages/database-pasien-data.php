<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Pasien</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
     	<div class="breadcrumb-item"><a href="#">Pasien</a></div>
      	<div class="breadcrumb-item">Form</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="card-header">
        	<h4>Form Pasien</h4>
      	</div>
      	<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td width="200">No RM</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="000001"></td>
							<td width="200">Nama Pasien</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="Ronaldo"></td>
						</tr>
						<tr>
							<td width="200">Jenis Penjaminan</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="BPJS"></td>
							<td width="200">Usia</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="32 Tahun"></td>
						</tr>
						<tr>
							<td width="200">No Penjaminan</td>
							<td width="10" align="center">:</td>
							<td><input type="text" class="form-control" value="123456789"></td>
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
						<a href="?page=database-pasien" class="btn btn-primary">Simpan</a>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th width="5">No</th>
							<th width="100">Aksi</th>
							<th width="200">Tgl Pemeriksaan</th>
							<th>Poli</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td class="text-nowrap">
								<a href="?page=database-pasien-form" class="btn btn-info btn-icon" target="_blank"><i class="fa fa-eye"></i></a>
							</td>
							<td>02-01-2021</td>
							<td>Umum</td>
						</tr>
						<tr>
							<td>2</td>
							<td class="text-nowrap">
								<a href="?page=database-pasien-form" class="btn btn-info btn-icon" target="_blank"><i class="fa fa-eye"></i></a>
							</td>
							<td>01-01-2021</td>
							<td>Umum</td>
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
	$('.sidebar-menu li a:contains("Pasien")').parent().addClass('active');
</script>