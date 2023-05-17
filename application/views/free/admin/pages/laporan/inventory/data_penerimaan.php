<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ -->

<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="section-body">
    <!-- <div class="card">
		<div class="card-body">
			<form action="" method="POST" class="needs-validation" novalidate="">
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal</label>
					<div class="col-sm-12 col-md-4">
						<div class="row">
							<div class="col-6">
								<input type="date" class="form-control">
							</div>
							<div class="col-6">
								<input type="date" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kasir</label>
					<div class="col-sm-12 col-md-7">
						<select name="" id="" class="form-select2" data-placeholder="Pilih Kasir">
							<option value=""></option>
							<option>Semua Kasir</option>
						</select>
					</div>
				</div>
				<div class="form-group row mb-4">
					<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
					<div class="col-sm-12 col-md-7">
						<button class="btn btn-primary" type="submit">Cari</button>
					</div>
				</div>
			</form>
		</div>
	</div> -->

    <div class="card">
        <div class="px-4 pt-4 pb-0">
            <div class="row">
                <div class="col-md-auto align-self-end">
                    <a href="#" class="btn btn-success">Export Excel</a>
                </div>
                <!-- <div class="col-md-3 ml-md-auto">
					<table class="table table-sm">
						<tr>
							<td><strong>Total</strong></td>
							<td class="text-right">1.000.000</td>
						</tr>
					</table>
				</div> -->
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered text-nowrap">
                    <thead>
                        <tr class="bg-light">
                            <th class="align-middle text-center" width="5">No</th>
                            <th class="align-middle text-center" width="100">No Faktur</th>
                            <th class="align-middle text-center" width="100">Tgl Faktur</th>
                            <th class="align-middle text-center" width="100">Tgl Penerimaan</th>
                            <th class="align-middle text-center" width="100">Tgl Jatuh Tempo</th>
                            <th class="align-middle text-center" width="100">Tgl Pembayaran/Pelunasan</th>
                            <th class="align-middle text-center" width="100">Supplier</th>
                            <th class="align-middle text-center" width="100">Petugas</th>
                            <th class="align-middle text-center" width="100">Total</th>
                            <th class="align-middle text-center" width="100">Diskon Faktur</th>
                            <th class="align-middle text-center" width="100">Materai</th>
                            <th class="align-middle text-center" width="100">Item ID</th>
                            <th class="align-middle text-center" width="100">Item Barcode</th>
                            <th class="align-middle text-center" width="100">Nama Barang</th>
                            <th class="align-middle text-center" width="100">Qty</th>
                            <th class="align-middle text-center" width="100">Kemasan</th>
                            <th class="align-middle text-center" width="100">ED</th>
                            <th class="align-middle text-center" width="100">Batch</th>
                            <th class="align-middle text-center" width="100">Harga Beli</th>
                            <th class="align-middle text-center" width="100">PPN</th>
                            <th class="align-middle text-center" width="100">HNA + PPN</th>
                            <th class="align-middle text-center" width="100">Diskon</th>
                            <th class="align-middle text-center" width="100">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="3">1</td>
                            <td rowspan="3">FK001</td>
                            <td rowspan="3">01-01-2021</td>
                            <td rowspan="3">02-01-2021</td>
                            <td rowspan="3">03-01-2021</td>
                            <td rowspan="3">04-01-2021</td>
                            <td rowspan="3">Kimia Farma</td>
                            <td rowspan="3">Rini</td>
                            <td rowspan="3">325.000</td>
                            <td rowspan="3">1.000</td>
                            <td rowspan="3">6.000</td>
                            <td>1111</td>
                            <td>123456789</td>
                            <td>Paracetamol</td>
                            <td>10</td>
                            <td>Strip</td>
                            <td>01-01-2030</td>
                            <td>BATCH001</td>
                            <td>10.000</td>
                            <td>1.000</td>
                            <td>11.000</td>
                            <td>0</td>
                            <td>110.000</td>
                        </tr>
                        <tr>
                            <td>2222</td>
                            <td>123456781</td>
                            <td>Paramex</td>
                            <td>10</td>
                            <td>Strip</td>
                            <td>01-01-2030</td>
                            <td>BATCH001</td>
                            <td>10.000</td>
                            <td>1.000</td>
                            <td>11.000</td>
                            <td>0</td>
                            <td>110.000</td>
                        </tr>
                        <tr>
                            <td>3333</td>
                            <td>123456782</td>
                            <td>Mixagrip</td>
                            <td>10</td>
                            <td>Strip</td>
                            <td>01-01-2030</td>
                            <td>BATCH001</td>
                            <td>10.000</td>
                            <td>1.000</td>
                            <td>11.000</td>
                            <td>0</td>
                            <td>110.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        load_table();
        setTimeout(function() {
            $('.action_message').hide();
            $('.action_message').find('.message').html('');
        }, 2000);
    });
</script>