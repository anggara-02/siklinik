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
                <div class="col-md-3 ml-md-auto">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td class="text-right"><strong>Total</strong></td>
                                <td id="_total" class="text-right"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-auto align-self-end">
                    <a href="#" class="btn btn-success" id="export">Export Excel</a>
                </div>
                <div class="col-md-auto px-4 ml-auto">
                    <div class="row">
                        <div class="search">
                            <input type="date" class="form-control tooltips" value="<?php echo ($this->input->get('start_date'))?$this->input->get('start_date'):''?>" id="tanggal_awal" title="Tanggal Awal">
                        </div>
                        <div class="search">
                            <input type="date" class="form-control tooltips" value="<?php echo $this->input->get('end_date')?$this->input->get('end_date'):''?>" id="tanggal_akhir" title="Tanggal Akhir">
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary" shortcut="ctrl+enter" onclick="load_table();return false;"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatables" class="table table-sm table-bordered text-nowrap">
                    <thead>
                        <tr class="bg-light">
                            <th class="align-middle text-center" width="5">No</th>
                            <th class="align-middle text-center" width="100">Item ID</th>
                            <th class="align-middle text-center" width="100">Item Barcode</th>
                            <th class="align-middle text-center" width="100">Nama Barang</th>
                            <th class="align-middle text-center" width="100">Diskon</th>
                            <th class="align-middle text-center" width="100">Jumlah Beli</th>
                            <th class="align-middle text-center" width="100">Kemasan Dasar</th>
                            <th class="align-middle text-center" width="100">HNA + PPN</th>
                            <th class="align-middle text-center" width="100">Total Modal</th>
                            <th class="align-middle text-center" width="100">Harga Jual</th>
                            <th class="align-middle text-center" width="100">Total Jual</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered text-nowrap">
                    <thead>
                        <tr class="bg-light">
                            <th class="align-middle text-center" width="5">No</th>
                            <th class="align-middle text-center" width="100">Item ID</th>
                            <th class="align-middle text-center" width="100">Item Barcode</th>
                            <th class="align-middle text-center" width="100">Nama Barang</th>
                            <th class="align-middle text-center" width="100">Diskon</th>
                            <th class="align-middle text-center" width="100">Jumlah Beli</th>
                            <th class="align-middle text-center" width="100">Kemasan Dasar</th>
                            <th class="align-middle text-center" width="100">Harga Modal</th>
                            <th class="align-middle text-center" width="100">Total Modal</th>
                            <th class="align-middle text-center" width="100">Harga Jual</th>
                            <th class="align-middle text-center" width="100">Total Jual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>123456789</td>
                            <td>Paracetamol</td>
                            <td>1000</td>
                            <td>2</td>
                            <td>PCS</td>
                            <td>10.000</td>
                            <td>20.000</td>
                            <td>15.000</td>
                            <td>30.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> -->
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

    $('#export').click(function(e) {
        location.href = "<?php echo site_url('admin/laporan/penjualan/' . $class . '/export') ?>";
    })

    function checkDateRange(start, end) {
        // Parse the entries
        var startDate = Date.parse(start);
        var endDate = Date.parse(end);

        // Check the date range, 86400000 is the number of milliseconds in one day
        var difference = (endDate - startDate) / (86400000 * 7);
        if (difference < 0) {
            alert("Tanggal Mmulai harus lebih kecil dari tanggal selesai.");
            return false;
        }
        return true;
    }

    function load_table(){
        if ($('#datatables thead>tr').length > 0) {
            $('#datatables').dataTable().fnDestroy();
        }
        
        var tanggal_awal = $("#tanggal_awal").val();
        var tanggal_akhir = $("#tanggal_akhir").val();
        if (checkDateRange(tanggal_awal, tanggal_akhir) != false) {
            var link_service = '?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
        } else {
            var link_service = '';
        } 

        dataReload(link_service);
        tes_ajax(link_service);
    }

    function tes_ajax(link_service){
        $.ajax({
            url: '<?= base_url('admin/laporan/penjualan/'.$class.'/get_datatable');?>' + link_service,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#_total').text(response.grand_total_harga_jual);
            }
        });
    }

    function dataReload(link_service){
        $('#datatables').DataTable({
            processing: true,
            serverSide: true,   
            searching: false,
            // dom: ' Bt<"table-footer clearfix"<"DT-label"i><"DT-pagination"p>>', 				
            aoColumnDefs: [{ "bSortable": false, "aTargets": [ "_all" ],"orderable": false }],
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            'ajax': {
                url: '<?= base_url('admin/laporan/penjualan/'.$class.'/get_datatable');?>' + link_service,
                type: 'post',
                dataType: 'json',
            },
            'columns':[
                {data: "no", visible: true}, 
                {data: "item_id", visible: true},
                {data: "item_barcode", visible: true},
                {data: "nama_barang", visible: true},
                {data: "diskon", visible: true},
                {data: "jumlah_beli", visible: true},
                {data: "kemasan_terkecil", visible: true},
                {data: "harga_modal", visible: true},
                {data: "total_modal", visible: true},
                {data: "harga_jual", visible: true},
                {data: "total_jual", visible: true},
            ],
        });
        
        setTimeout(function(){ $("#datatables th").removeClass("sorting_asc");}, 1000);
    }

    $('#export').click(function(e) {
        var tanggal_awal = $("#tanggal_awal").val();
        var tanggal_akhir = $("#tanggal_akhir").val();
        if (checkDateRange(tanggal_awal, tanggal_akhir) != false) {
            var link_service = '?tanggal_awal=' + tanggal_awal + '&tanggal_akhir=' + tanggal_akhir;
        } else {
            var link_service = '';
        }
        location.href = "<?php echo site_url('admin/laporan/penjualan/' . $class . '/export') ?>" + link_service;
    });
</script>