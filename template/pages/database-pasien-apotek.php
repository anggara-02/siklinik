<div class="section-header">
    <h1>Pasien Apotek</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      	<div class="breadcrumb-item">Pasien Apotek</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="row mx-n2">
				<div class="col-md-auto mb-3 mb-md-0 px-2">
					<!-- <a href="?page=database-pasien-apotek-data" class="btn btn-primary">Tambah</a> -->
				</div>
				<div class="col-md-auto ml-auto mb-3 mb-md-0 px-2">
					<!-- <select name="" id="" class="form-control">
						<option value="">Semua Role</option>
						<option value="">Administrator</option>
						<option value="">Kasir</option>
					</select> -->
				</div>
				<div class="col-md-auto px-2">
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
							<th width="5">No</th>
							<th width="100">Aksi</th>
							<th>Nama Pasien Apotek</th>
							<th width="200">Jenis Kelamin</th>
							<th width="200">Tgl Lahir</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td class="text-nowrap">
								<a href="?page=database-pasien-apotek-data" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
							</td>
							<td>Ronaldo</td>
							<td>Laki-laki</td>
							<td>01-01-1989</td>
						</tr>
						<tr>
							<td>2</td>
							<td class="text-nowrap">
								<a href="?page=database-pasien-apotek-data" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
							</td>
							<td>Ronaldo</td>
							<td>Laki-laki</td>
							<td>01-01-1989</td>
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript">
	$('.sidebar-menu li a:contains("Pasien Apotek")').parent().addClass('active');
</script>
<script type="text/javascript">
	$(function(){
		$('.btn-kirim').on('click',function(){
			swal({
		      	title: 'Apakah anda yakin?',
		      	text: 'Anda akan mengirimkan data ini ke bagian pemeriksaan',
		      	icon: 'warning',
		      	buttons: true,
		      	dangerMode: true,
		    })
		    .then((willDelete) => {
		      	if (willDelete) {
			      	swal('Data berhasil dikirim', {
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