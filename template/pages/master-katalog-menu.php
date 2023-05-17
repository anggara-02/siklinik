<div class="section-header">
    <div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Katalog Menu</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Data Master</a></div>
      	<div class="breadcrumb-item">Katalog Menu</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="row mx-n2">
				<div class="col-md-auto mb-3 mb-md-0 px-2">
					<a href="?page=#" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Tambah</a>
				</div>
				<div class="col-md-auto px-2 ml-auto">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search..">
						<div class="input-group-append">
							<button class="btn btn-primary"><i class="fa fa-search"></i></button>
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
							<th width="150">Kategori</th>
							<th>Nama Menu</th>
							<th width="150">Harga</th>
							<th width="50">Gambar</th>
							<th width="50">Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox"></td>
							<td class="text-nowrap">
								<a href="?page=#" class="btn btn-info btn-icon" data-toggle="modal" data-target="#modal-form"><i class="fa fa-edit"></i></a>
								<a href="#" class="btn btn-warning btn-icon btn-unpublish"><i class="fas fa-times"></i></a>
								<a href="#" class="btn btn-danger btn-icon btn-delete"><i class="fas fa-trash"></i></a>
							</td>
							<td>Food</td>
							<td>Nasi Goreng</td>
							<td>25.000</td>
							<td>
								<div class="badge badge-info">View</div>
							</td>
							<td>
								<div class="badge badge-success">Aktif</div>
							</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td class="text-nowrap">
								<a href="?page=#" class="btn btn-info btn-icon" data-toggle="modal" data-target="#modal-form"><i class="fa fa-edit"></i></a>
								<a href="#" class="btn btn-success btn-icon btn-publish"><i class="fas fa-check"></i></a>
								<a href="#" class="btn btn-danger btn-icon btn-delete"><i class="fas fa-trash"></i></a>
							</td>
							<td>Beverages</td>
							<td>Es Teh</td>
							<td>5.000</td>
							<td>
								<div class="badge badge-info">View</div>
							</td>
							<td>
								<div class="badge badge-danger">Non Aktif</div>
							</td>
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

<div class="modal fade" id="modal-form" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Form Entry</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="" class="form-label">Kategori</label>
					<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Kategori">
						<option value=""></option>
						<option>Food</option>
						<option>Beverages</option>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="form-label">Nama Item</label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Harga</label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Margin (%)</label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Total</label>
					<input type="text" class="form-control" readonly="">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Gambar</label>
					<input type="file" class="form-control">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary">Simpan</button>
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
	$(function(){
		$('.btn-publish').on('click',function(){
			swal({
		      	title: 'Apakah anda yakin?',
		      	text: 'Anda akan mengaktifkan Item ini',
		      	icon: 'warning',
		      	buttons: true,
		      	dangerMode: true,
		    })
		    .then((willDelete) => {
		      	if (willDelete) {
			      	swal('Item Aktif', {
			        	icon: 'success',
			      	});
		      	}
		    });
		});

		$('.btn-unpublish').on('click',function(){
			swal({
		      	title: 'Apakah anda yakin?',
		      	text: 'Anda akan menonaktifkan Item ini',
		      	icon: 'warning',
		      	buttons: true,
		      	dangerMode: true,
		    })
		    .then((willDelete) => {
		      	if (willDelete) {
			      	swal('Item Non Aktif', {
			        	icon: 'success',
			      	});
		      	}
		    });
		});
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
<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Data Master")').parent().addClass('active').find('a:contains("Katalog Menu")').parent().addClass('active');
</script>