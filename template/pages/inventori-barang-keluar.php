<div class="section-header">
    <h1>Barang Keluar</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item active"><a href="#">Inventori</a></div>
      	<div class="breadcrumb-item">Barang Keluar</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="row mx-n2">
				<div class="col-md-auto mb-3 mb-md-0 px-2">
					<a href="?page=inventori-barang-keluar-form" class="btn btn-primary">Tambah</a>
				</div>
				<div class="col-md-auto px-2 ml-auto">
					<div class="input-group">
						<input type="date" class="form-control" placeholder="">
						<div class="input-group-append">
							<!-- <button class="btn btn-primary"><i class="fa fa-calendar"></i></button> -->
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
							<th width="50">Aksi</th>
							<th width="150">Tanggal</th>
							<th width="100">Shift</th>
							<th>Catatan</th>
							<th class="text-right">Grand Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox"></td>
							<td class="text-nowrap">
								<a href="?page=inventori-barang-keluar-form" class="btn btn-info btn-icon"><i class="fa fa-edit"></i></a>
								<a href="#" class="btn btn-danger btn-icon btn-delete"><i class="fas fa-trash"></i></a>
							</td>
							<td>18-11-2021</td>
							<td>Pagi</td>
							<td>Barang keluar hari ini</td>
							<td class="text-right">1.500.000</td>
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
<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Inventori")').parent().addClass('active').find('a:contains("Barang Keluar")').parent().addClass('active');
</script>