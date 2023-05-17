<div class="section-header">
    <div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Inkaso</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item"><a href="#">Dashboard</a></div>
      	<div class="breadcrumb-item"><a href="#">Inventori</a></div>
      	<div class="breadcrumb-item">Inkaso</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td width="200">No Faktur</td>		
							<td>: FK-202111001</td>
							<td width="200">Tanggal Tempo</td>		
							<td>: 09-12-2021</td>
						</tr>
						<tr>
							<td width="200">Tanggal Faktur</td>		
							<td>: 09-11-2021</td>
							<td width="200">Jumlah Tagihan</td>		
							<td>: Rp 1.000.000,-</td>
						</tr>
						<tr>
							<td width="200">Supplier</td>		
							<td>: Dosniroha</td>
							<td width="200">Jumlah Bayar</td>		
							<td>: Rp 500.000,-</td>
						</tr>
						<tr>
							
						</tr>
					</tbody>
				</table>
				<div class="col-md-auto mb-3 mb-md-0 px-2">
					<a href="?page=#" class="btn btn-primary" data-toggle="modal" data-target="#modal-form">Tambah</a>
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
							<th width="200">Tanggal Bayar</th>
							<th width="200">Cara Bayar</th>
							<th>Jumlah Bayar</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox"></td>
							<td class="text-nowrap">
								<a href="?page=#" class="btn btn-info btn-icon" data-toggle="modal" data-target="#modal-form"><i class="fa fa-edit"></i></a>
								<a href="#" class="btn btn-danger btn-icon btn-delete"><i class="fas fa-trash"></i></a>
							</td>
							<td>20-11-2021</td>
							<td>Tunai</td>
							<td>300.000,-</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td class="text-nowrap">
								<a href="?page=#" class="btn btn-info btn-icon" data-toggle="modal" data-target="#modal-form"><i class="fa fa-edit"></i></a>
								<a href="#" class="btn btn-danger btn-icon btn-delete"><i class="fas fa-trash"></i></a>
							</td>
							<td>15-11-2021</td>
							<td>Transfer BCA</td>
							<td>200.000,-</td>
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
				<h5 class="modal-title">INKASO</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="" class="form-label">Tgl Bayar</label>
					<input type="date" class="form-control">
				</div>
				<div class="form-group">
					<label for="" class="form-label">Cara Bayar</label>
					<select name="" id="" class="form-select2" data-placeholder="Pilih Cara Bayar">
						<option value=""></option>
						<option>Tunai</option>
						<option>Transfer BCA</option>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="form-label">Jumlah Bayar</label>
					<input type="text" class="form-control">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary">Simpan</button>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
	$(function(){
		$('.form-select2').select2();
	});
</script>
<script type="text/javascript">
	$('.sidebar-menu > li > a:contains("Inventori")').parent().addClass('active').find('a:contains("Inkaso")').parent().addClass('active');
</script>