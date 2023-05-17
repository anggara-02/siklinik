<div class="section-header">
    <h1>Rekap Stok</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item active"><a href="#">Laporan</a></div>
      	<div class="breadcrumb-item">Rekap Stok</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="row mx-n2">
				<div class="col-md-auto px-2 ml-auto">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search...">
						<div class="input-group-append">
							<button class="btn btn-primary"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
		<div class="px-4 pt-4 pb-0">
			<div class="row">
				<div class="col-md-auto align-self-end">
					<a href="#" class="btn btn-success">Export Excel</a>
				</div>
				<div class="col-md-3 ml-md-auto">
					<table class="table table-sm">
						<tr>
							<td><strong>Total Aset</strong></td>
							<td class="text-right">100.000</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th width="5">No</th>
							<th width="">Nama Item</th>
							<th width="150">Sisa Stok</th>
							<th width="150">Harga Item</th>
							<th width="150">Total Aset</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Garam</td>
							<td>10</td>
							<td>5.000</td>
							<td>50.000</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Beras</td>
							<td>10</td>
							<td>5.000</td>
							<td>50.000</td>
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
	$('.sidebar-menu > li > a:contains("Laporan")').parent().addClass('active').find('a:contains("Rekap Stok")').parent().addClass('active');
</script>