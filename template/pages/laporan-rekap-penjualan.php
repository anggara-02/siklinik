<div class="section-header">
    <h1>Rekap Penjualan</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item active"><a href="#">Laporan</a></div>
      	<div class="breadcrumb-item">Rekap Penjualan</div>
    </div>
</div>
<div class="section-body">
	<div class="card">
		<div class="p-4 border-bottom border-light">
			<div class="row mx-n2">
				<div class="col-md-auto ml-auto mb-3 mb-md-0 px-2">
					<div class="row">
						<div class="col-3">
							<input type="date" class="form-control">
						</div>
						<div class="col-3">
							<input type="date" class="form-control">
						</div>
						<div class="col-3">
							<select name="" id="" class="form-control">
								<option value="">Semua Kasir</option>
								<option>Rina</option>	
								<option>Rini</option>
							</select>
						</div>
						<div class="col-2">
							<input type="text" class="form-control" placeholder="Search..">
						</div>
						<div class="col-1">
							<div class="input-group-append">
								<button class="btn btn-primary"><i class="fa fa-search"></i></button>
							</div>
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
							<td><strong>Penjualan</strong></td>
							<td class="text-right">30.000</td>
						</tr>
						<tr>
							<td><strong>Modal</strong></td>
							<td class="text-right">23.000</td>
						</tr>
						<tr>
							<td><strong>Omset Bersih</strong></td>
							<td class="text-right">7.000</td>
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
							<th width="150">Tanggal</th>
							<th width="200">No Invoice</th>
							<th width="50">Shift</th>
							<th width="50">Kasir</th>
							<th>Item Penjualan</th>
							<th class="text-right">Harga Jual</th>
							<th class="text-right">Modal</th>
							<th class="text-right">Netto</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td rowspan="2">1</td>
							<td rowspan="2">19-11-2021</td>
							<td rowspan="2">INV-202111001</td>
							<td rowspan="2">Pagi</td>
							<td rowspan="2">Rini</td>
							<td>Nasi Goreng</td>
							<td class="text-right">25.000</td>
							<td class="text-right">20.000</td>
							<td class="text-right">5.000</td>
						</tr>
						<tr>
							<td>Es Teh</td>
							<td class="text-right">5.000</td>
							<td class="text-right">3.000</td>
							<td class="text-right">2.000</td>
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
	$('.sidebar-menu > li > a:contains("Laporan")').parent().addClass('active').find('a:contains("Rekap Penjualan")').parent().addClass('active');
</script>