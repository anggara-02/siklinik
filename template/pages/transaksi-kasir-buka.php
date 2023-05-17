<div class="section-header">
    <h1>Kasir</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item">Kasir</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="row mx-n2">
				<div class="col-md-auto mb-3 mb-md-0 px-2">
					<a href="?page=#" class="btn btn-success" data-toggle="modal" data-target="#modal-form">Buka Kasir</a>
				</div>
				<div class="col-md-auto px-2 ml-auto">
					<div class="input-group">
						<input type="date" class="form-control" placeholder="">
						<div class="input-group-append">
							<!-- <button class="btn btn-primary"><i class="fa fa-calendar"></i></button> -->
						</div>
						&nbsp;&nbsp;
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
							<th width="50">Aksi</th>
							<th width="150">No Invoice</th>
							<th width="150">Tanggal</th>
							<th width="100">Shift</th>
							<th width="200">Kasir / Verifikator</th>
							<th class="text-center">Item Menu</th>
							<th class="text-right">Grand Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox"></td>
							<td class="text-nowrap">
								<a href="?page=transaksi-kasir-form" class="btn btn-info btn-icon disabled"><i class="fa fa-edit"></i></a>
								<a href="?page=#" class="btn btn-warning btn-icon disabled"><i class="fa fa-print"></i></a>
								<a href="#" class="btn btn-danger btn-icon btn-delete disabled"><i class="fas fa-trash"></i></a>
							</td>
							<td>INV0001</td>
							<td>18-11-2021</td>
							<td>Pagi</td>
							<td>Ririn / Alex</td>
							<td>
								<ul>
									<li>Nasi Goreng</li>
									<li>Es Teh</li>
								</ul>
							</td>
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

<div class="modal fade" id="modal-form" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Form Buka Kasir</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="" class="form-label">Nama Kasir</label>
					<input type="text" class="form-control" value="Ririn" readonly="">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Shift</label>
					<input type="text" class="form-control" value="Pagi" readonly="">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Modal</label>
					<input type="text" class="form-control" value="">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Catatan</label>
					<textarea name="" id="" cols="30" rows="3" class="form-control h-auto"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<a href="?page=transaksi-kasir"><button type="button" class="btn btn-primary">Buka Kasir</button></a>
			</div>
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
	$('.sidebar-menu li a:contains("Kasir")').parent().addClass('active');
</script>