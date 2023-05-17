<!-- ==========DON'T REMOVE============
	Create with Love
	Creator : Indra Pradipta | indra.pradiptaa@gmail.com 
	Modified : Badra | sipatan.jana@students.amikom.ac.id
	Support : Alfons Permana | 
	Megistra Team : megistra.com
	Contact Us : support@megistra.com
	==========DON'T REMOVE============ -->

<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script src="<?php echo base_url(); ?>/assets/js/rowGroup.js"></script>

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
                    <a href="#" class="btn btn-success" id="export">Export Excel</a>
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
                <table id="datatables" class="table table-sm table-bordered text-nowrap" style="width: 100%">
                    <thead>
                        <tr class="bg-light">
                            <th class="align-middle text-center" width="5">No</th>
                            <th class="align-middle text-center" width="100">No SP</th>
                            <th class="align-middle text-center" width="100">Tgl Pemesanan</th>
                            <th class="align-middle text-center" width="100">Supplier</th>
                            <th class="align-middle text-center" width="100">Petugas</th>
                            <th class="align-middle text-center" width="100">Total (Rp)</th>
                            <th class="align-middle text-center" width="100">Item ID</th>
                            <th class="align-middle text-center" width="100">Item Barcode</th>
                            <th class="align-middle text-center" width="100">Nama Barang</th>
                            <th class="align-middle text-center" width="100">Kemasan</th>
                            <th class="align-middle text-center" width="100">Jumlah</th>
                            <th class="align-middle text-center" width="100">Harga</th>
                            <th class="align-middle text-center" width="100">Total</th>
                        </tr>
                    </thead>
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

        $('#export').click(function(e) {
            location.href = "<?php echo site_url('admin/laporan/inventory/' . $class . '/export') ?>";
        })

        function load_table() {
            $('#datatables').DataTable({
                // processing: true,
                // serverSide: true,
                // searching: false,
                // "scrollX": true,
                aoColumnDefs: [{
                    "bSortable": false,
                    "aTargets": ["_all"],
                    "orderable": false
                }],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                ajax: {
                    url: '<?= base_url('admin/laporan/inventory/' . $class . '/get_datatable'); ?>',
                    type: 'POST',
                    dataType: 'JSON',
                },
                columns: [{
                        data: "no",
                    },
                    {
                        name: 'first',
                        data: "no_sp",
                    },
                    {
                        data: "tanggal_pemesanan",
                    },
                    {
                        data: "supplier",
                    },
                    {
                        data: "petugas",
                    },
                    {
                        data: "grand_total",
                    },
                    {
                        data: "item_id",
                    },
                    {
                        data: "item_barcode",
                    },
                    {
                        data: "nama_barang",
                    },
                    {
                        data: "kemasan",
                    },
                    {
                        data: "jumlah",
                    },
                    {
                        data: "harga",
                    },
                    {
                        data: "total",
                    },
                ],
                rowsGroup: [
                    'first:name',
                    1, 2, 3, 4, 5
                ],
            });
            setTimeout(function() {
                $("#datatables th").removeClass("sorting_asc");
            }, 1000);
        }
    });
</script>