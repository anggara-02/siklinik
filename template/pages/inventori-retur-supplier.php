<div class="section-header">
    <div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Retur Supplier</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
      	<div class="breadcrumb-item"><a href="#">Inventori</a></div>
      	<div class="breadcrumb-item">Retur Supplier</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="row mx-n2">
				<div class="col-md-auto mb-3 mb-md-0 px-2">
					<a href="?page=inventori-retur-supplier-form" class="btn btn-primary">Tambah</a>
				</div>
				<div class="col-md-auto px-2 ml-auto">
					<div class="row">
						<div class="col-md-3">
							<input type="date" class="form-control tooltips" title="Tanggal Awal">
						</div>
						<div class="col-md-3">
							<input type="date" class="form-control tooltips" title="Tanggal Akhir">
						</div>
						<div class="col-md-3">
							<select name="" id="" class="form-select2" data-placeholder="Pilih Supplier">
								<option value=""></option>
								<option>Dosniroha</option>
								<option>Kimia Farma</option>
							</select>
						</div>
						<div class="col-md-3 input-group">
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
							<th width="5"><input type="checkbox"></th>
							<th width="100">Aksi</th>
							<th>No Faktur</th>
							<th>Tanggal Faktur</th>
							<th>Tanggal Retur</th>
							<th>Supplier</th>
							<th>Total Harga</th>
							<th>Nama Item</th>
							<th width="50">Kemasan</th>
							<th width="50">Jumlah</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td rowspan="3"><input type="checkbox"></td>
							<td rowspan="3" class="text-nowrap">
								<a href="?page=inventori-retur-supplier-form" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
								<a href="?page=#" class="btn btn-warning btn-icon"><i class="fa fa-print"></i></a>
								<a href="#" class="btn btn-danger btn-icon btn-delete"><i class="fas fa-trash"></i></a>
							</td>
							<td rowspan="3">FK-202111001</td>
							<td rowspan="3">09-11-2021</td>
							<td rowspan="3">09-12-2021</td>
							<td rowspan="3">Dosniroha</td>
							<td rowspan="3">Rp 1.000.000,-</td>
							<td>Amoxicillin</td>
							<td>Box</td>
							<td>10</td>
						</tr>
						<tr>
							<td>Amoxicillin</td>
							<td>Box</td>
							<td>10</td>
						</tr>
						<tr>
							<td>Amoxicillin</td>
							<td>Box</td>
							<td>10</td>
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
	$('.sidebar-menu > li > a:contains("Inventori")').parent().addClass('active').find('a:contains("Retur Supplier")').parent().addClass('active');
</script>