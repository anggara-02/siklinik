<div class="section-header">
	<div class="section-header-back">
      	<a href="javascript:history.go(-1)" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Manajemen Shift</h1>
    <div class="section-header-breadcrumb">
     	<div class="breadcrumb-item">Manajemen Shift</div>
    </div>
</div>
<div class="section-body">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
                	<h4>Manajemen Shift</h4>
              	</div>
				<div class="card-body">
					<form action="#" method="POST" class="needs-validation" novalidate="">
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Shift</label>
							<div class="col-sm-12 col-md-7">
								<input type="text" class="form-control" value="Pagi" readonly="">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam</label>
							<div class="col-sm-12 col-md-3">
								<input type="time" class="form-control">
							</div>
							<div class="col-sm-12 col-md-3">
								<input type="time" class="form-control">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Shift</label>
							<div class="col-sm-12 col-md-7">
								<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Status Shift">
									<option value=""></option>
									<option>Aktif</option>
									<option>Non Aktif</option>
								</select>
							</div>
						</div>
						<hr>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Shift</label>
							<div class="col-sm-12 col-md-7">
								<input type="text" class="form-control" value="Siang" readonly="">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam</label>
							<div class="col-sm-12 col-md-3">
								<input type="time" class="form-control">
							</div>
							<div class="col-sm-12 col-md-3">
								<input type="time" class="form-control">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Shift</label>
							<div class="col-sm-12 col-md-7">
								<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Status Shift">
									<option value=""></option>
									<option>Aktif</option>
									<option>Non Aktif</option>
								</select>
							</div>
						</div>
						<hr>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Shift</label>
							<div class="col-sm-12 col-md-7">
								<input type="text" class="form-control" value="Sore" readonly="">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam</label>
							<div class="col-sm-12 col-md-3">
								<input type="time" class="form-control">
							</div>
							<div class="col-sm-12 col-md-3">
								<input type="time" class="form-control">
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Shift</label>
							<div class="col-sm-12 col-md-7">
								<select name="" id="" class="form-input form-select2" style="width: 100%;" data-placeholder="Pilih Status Shift">
									<option value=""></option>
									<option>Aktif</option>
									<option>Non Aktif</option>
								</select>
							</div>
						</div>
						<div class="form-group row mb-4">
							<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
							<div class="col-sm-12 col-md-7">
								<button class="btn btn-primary" type="submit">Update</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style type="text/css">
	.form-original .btn-delete{
		display: none;
	}
	.form-clone .btn-clone{
		display: none;
	}
	.form-clone label{
		display: none;
	}
</style>

<script type="text/javascript">
	$(function(){
		$('.form-select2').select2();
		$(document).on('click','.btn-clone',function(){
			var form = $(this).parents('.form-original');
			//$('.form-select2').select2('destroy');
			//form.clone().removeClass('form-original').addClass('form-clone').appendTo($(this).parents('.form-clone-wrap'));
			//$('.form-select2').select2();
			value_1 = form.children().eq(0).find('input').val();
			value_2 = form.children().eq(1).find('input').val();
			value_3 = form.children().eq(2).find('input').val();
			value_4 = form.children().eq(2).find('input').val();

			$('table.table-product tbody').append(''+
			'<tr>'+
			'<td>'+value_1+'</td>'+
			'<td>'+value_2+'</td>'+
			'<td>'+value_3+'</td>'+
			'<td>'+value_4+'</td>'+
			'<td><button class="btn btn-danger btn-delete" type="button"><i class="fa fa-trash"></i></button></td>'+
			'</tr/>');
			
		});

		$(document).on('click','.btn-delete',function(){
			$(this).parents('tr').remove();
			
		});
	});
</script>
<script type="text/javascript">
	$('.sidebar-menu li a:contains("Manajemen Shift")').parent().addClass('active');
</script>