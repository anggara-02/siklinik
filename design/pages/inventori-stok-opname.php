<div class="section-header">
    <div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Stok Opname</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
      	<div class="breadcrumb-item"><a href="#">Inventori</a></div>
      	<div class="breadcrumb-item">Stok Opname</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="row mx-n2">
				<div class="col-md-auto mb-3 mb-md-0 px-2">
					<a href="?page=inventori-stok-opname-form" class="btn btn-primary">Tambah</a>
				</div>
				<div class="col-md-auto px-2 ml-auto">
					<div class="row">
						<div class="col-md-4">
							<input type="date" class="form-control tooltips" title="Tanggal Awal">
						</div>
						<div class="col-md-4">
							<input type="date" class="form-control tooltips" title="Tanggal Akhir">
						</div>
						<div class="col-md-4 input-group">
							<input type="text" class="form-control" placeholder="Search..">
							<div class="input-group-append">
								<button class="btn btn-primary"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th rowspan="2" width="5"><input type="checkbox"></th>
							<th rowspan="2" width="100">Aksi</th>
							<th rowspan="2">Kode SO</th>
							<th rowspan="2">Tanggal SO</th>
							<th rowspan="2">Keterangan</th>
							<th rowspan="2">Nama Item</th>
							<th rowspan="2">Kemasan</th>
							<th rowspan="2">Harga Satuan</th>
							<th colspan="3" class="text-center">Jumlah</th>
						</tr>
						<tr>
							<th>Sebelum</th>
							<th>Sesudah</th>
							<th>Selisih</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td rowspan="2"><input type="checkbox"></td>
							<td rowspan="2" class="text-nowrap">
								<a href="?page=inventori-stok-opname-form" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
								<a href="#" class="btn btn-danger btn-icon btn-delete"><i class="fas fa-trash"></i></a>
							</td>
							<td rowspan="2">SO-202111001</td>
							<td rowspan="2">09-11-2021</td>
							<td rowspan="2">SO Bulanan</td>
							<td>Amoxicillin</td>
							<td>Box</td>
							<td>1.000</td>
							<td>10</td>
							<td>6</td>
							<td>4</td>
						</tr>
						<tr>
							<td>Amoxicillin</td>
							<td>Box</td>
							<td>1.000</td>
							<td>10</td>
							<td>6</td>
							<td>4</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card-footer">
			<nav class="d-inline-block">
				<ul class="pagination mb-0">
					<li class="page-item disabled">
						<a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
					</li>
					<li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
					<li class="page-item">
						<a class="page-link" href="#">2</a>
					</li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item">
						<a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.btn-delete').on('click',function(){
			swal({
		      	title: 'Apakah anda yakin?',
		      	text: 'Setelah data dihapus anda tidak akan dapat mengembalikan data itu kembali!',
		      	icon: 'warning',
		      	buttons: true,
		      	dangerMode: true,
		    })
		    .then((willDelete) => {
		      	if (willDelete) {
			      	swal('Data berhasil dihapus', {
			        	icon: 'success',
			      	});
		      	}
		    });
		});
	});
</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
	$(function(){
		$('.form-select2').select2();
	});
</script>
<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Inventori")').parent().addClass('active').find('a:contains("Stok Opname")').parent().addClass('active');
</script>